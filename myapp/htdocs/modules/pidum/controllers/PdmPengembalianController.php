<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmPengembalian;
use app\modules\pidum\models\PdmPengembalianBerkas;
use app\modules\pidum\models\PdmPengembalianSearch;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmTembusanPengembalian;
use app\modules\pidum\models\PdmTembusanPengembalianBerkas;
use app\modules\pidum\models\PdmP21ASearch;
use app\modules\pidum\models\PdmP21a;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\UploadedFile;
use app\components\GlobalConstMenuComponent;
use yii\db\Query;
/**
 * PdmPengembalianController implements the CRUD actions for PdmPengembalian model.
 */
class PdmPengembalianController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all PdmPengembalian models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$berkas  = Yii::$app->session->get('perilaku_berkas');
        if($berkas == ''){*/
            $session    = new Session();
            $id_perkara = Yii::$app->session->get('id_perkara');
            // Jika Pengembalian SPDP
            if(PdmBerkasTahap1::findOne(['id_perkara'=>$id_perkara])->id_berkas ==''){
                $this->redirect(['update', 'id' => $id_perkara]);
            }
            $searchModel    = new PdmPengembalianSearch();
            $dataProvider   = $searchModel->search($id_perkara);
            return $this->render('index', [
                'searchModel'   => $searchModel,
                'dataProvider'  => $dataProvider,
            ]);
       /* }else{
            $query ="select d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY') as berkas,coalesce(b.id_pengembalian,'0') as id_pengembalian ,string_agg(f.nama,', ') as nama
                    ,coalesce(b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY'),'-')  as pengembalian, d.id_berkas
                    from 
                    pidum.pdm_berkas_tahap1 d 
                    INNER JOIN (
                    select x.* from 
                    pidum.pdm_pengantar_tahap1 x inner join (
                    select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
                    )y on x.id_pengantar = y.id_pengantar
                    ) e on d.id_berkas = e.id_berkas
                    INNER JOIN pidum.ms_tersangka_berkas f on e.id_berkas = f.id_berkas
                    left join pidum.pdm_pengembalian_berkas b on d.id_berkas = b.id_berkas
                    where d.id_berkas='".$berkas."' 
                    GROUP BY d.no_berkas||'<br/>'||to_char(d.tgl_berkas,'DD-MM-YYYY'),coalesce(b.id_pengembalian,'0')
                    ,b.no_surat||'<br/>'||to_char(b.tgl_dikeluarkan,'DD-MM-YYYY') ,d.id_berkas";
            $command            = Yii::$app->db->createCommand($query);
            $rows               = $command->queryAll();
            $id_pengembalian    = $rows[0]['id_pengembalian'];
            $id_pengantar       = $rows[0]['id_pengantar'];
            return $this->redirect(['update','id'=>$id_pengembalian,'id_pengantar'=>$id_pengantar]);
        }*/
        
        
                
                
    }

    /**
     * Displays a single PdmPengembalian model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdmPengembalian model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmPengembalian();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pengembalian]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmPengembalian model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate() // pengembalian SPDP
    {
		$id = Yii::$app->session->get('id_perkara');

        $model = PdmPengembalian::findOne(['id_perkara'=>$id]);
        $modelSpdp = PdmSpdp::findOne(['id_perkara'=>$id]);
		
		if($model ==null){
			$model = new PdmPengembalian();
			$model->created_time=date('Y-m-d H:i:s');
			$model->created_by=\Yii::$app->user->identity->peg_nip;
			$model->created_ip = \Yii::$app->getRequest()->getUserIP();
		}else{
			$model->updated_by=\Yii::$app->user->identity->peg_nip;
			$model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
		}

        if ($model->load(Yii::$app->request->post()) ) {
            // echo '<pre>';
            // print_r($_POST);exit;
			$transaction = Yii::$app->db->beginTransaction();
            try{
			if(PdmPengembalian::findOne(['id_perkara'=>$id]) == null ){
				$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_pengembalian', 'id_pengembalian', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
				$model->id_pengembalian = $seq['generate_pk'];
				$model->id_perkara = $id;
			}
			
			$files = UploadedFile::getInstance($model, 'file_upload');
			
			if ($files != false && !empty($files) ) {
				
				$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/pengembalianSPDP.'. $files->extension;
			}
			
			if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}
			
			if(!$model->save()){
				echo "pengembalian".var_dump($model->getErrors());exit;
			}
			
			PdmTembusanPengembalian::deleteAll(['id_pengembalian' => $model->id_pengembalian]);
            if (isset($_POST['new_tembusan'])) {
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanPengembalian();
                    $modelNewTembusan->id_pengembalian = $model->id_pengembalian;
                    $modelNewTembusan->id_tembusan = $model->id_pengembalian."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						echo "Tembusan.".var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }
			
			if ($files != false && !empty($files) ) {
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/pengembalianSPDP.'.$files->extension;
					$files->saveAs($path);
			}
			
			$transaction->commit();
			Yii::$app->getSession()->setFlash('success', [
				'type' => 'success',
				'duration' => 3000,
				'icon' => 'fa fa-users',
				'message' => 'Data Berhasil di Simpan',
				'title' => 'Simpan Data',
				'positonY' => 'top',
				'positonX' => 'center',
				'showProgressbar' => true,
			]);
			
				return $this->redirect(['update']);
			}catch (Exception $e) {
                $transaction->rollback();
				 Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                return $this->redirect(['update']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'title' => 'Pengembalian SPDP',
				'konstanta' => 'PengembalianSPDP',
				'modelPengembalian' => $modelSpdp,
            ]);
        }
    }
	
	 public function actionUpdateberkas($id,$id_berkas) // pengembalian berkas
    {
        $model = PdmPengembalianBerkas::findOne(['id_pengembalian'=>$id]);
        
		$modelBerkas = Yii::$app->db->createCommand(" select a.no_berkas, to_char(a.tgl_berkas,'dd-mm-yyyy') as tgl_berkas,to_char(b.tgl_terima,'dd-mm-yyyy') as tgl_terima
		from 
		pidum.pdm_berkas_tahap1 a 
		INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
        ) b on a.id_berkas = b.id_berkas
		WHERE a.id_berkas='".$id_berkas."' ")->queryOne();
		$modelP21a = PdmP21a::findOne(['id_berkas'=>$id_berkas]);
		
		if ($model == null) {
            $model = new PdmPengembalianBerkas();
			$file_lama = '';
        }else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}

        if ($model->load(Yii::$app->request->post()) ) {
			$transaction = Yii::$app->db->beginTransaction();
            try{
				$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_pengembalian_berkas WHERE id_berkas='".$id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
				
				$id_perkara = Yii::$app->session->get('id_perkara');
				
				if($id=='0'){
					$model->created_time=date('Y-m-d H:i:s');
					$model->created_by=\Yii::$app->user->identity->peg_nip;
					$model->created_ip = \Yii::$app->getRequest()->getUserIP();
					
					$model->id_pengembalian = $id_berkas."|".$_POST['PdmPengembalianBerkas']['no_surat'];
					$model->id_berkas = $id_berkas;
				}else{
					$model->updated_by=\Yii::$app->user->identity->peg_nip;
					$model->updated_time=date('Y-m-d H:i:s');
                    $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
					
				}
				$files = UploadedFile::getInstance($model, 'file_upload');
			
				if ($files != false && !empty($files) ) {
					if($file_lama !=''){
						$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/pengembalianBerkas_'.$file_lama.'.'. $files->extension;
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/pengembalianBerkas_'.$file_lama.'.'.$files->extension;
						$files->saveAs($path);
					}else{
						$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/pengembalianBerkas_'.$jml_pt['jml'].'.'. $files->extension;
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/pengembalianBerkas_'.$jml_pt['jml'].'.'.$files->extension;
						$files->saveAs($path);
					}
				}else{
					$model->file_upload = $file_lama;
				}
				
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
				
				
				
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
				$id_pengembalian = $id_berkas."|".$_POST['PdmPengembalianBerkas']['no_surat'];
				PdmTembusanPengembalianBerkas::deleteAll(['id_pengembalian' => $id_pengembalian]);
				if (isset($_POST['new_tembusan'])) {
					for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
						$modelNewTembusan = new PdmTembusanPengembalianBerkas();
						$modelNewTembusan->id_pengembalian = $id_pengembalian;
						$modelNewTembusan->id_tembusan = $id_pengembalian."|".($i+1);
						$modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
						$modelNewTembusan->no_urut = ($i+1);
						if(!$modelNewTembusan->save()){
							var_dump($modelNewTembusan->getErrors());exit;
						}
						
					}
				}
				
				if ($files != false && !empty($files) ) {
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/pengembalianBerkas_'.$id_berkas.'.'.$files->extension;
						$files->saveAs($path);
				}
				
				$transaction->commit();

				Yii::$app->getSession()->setFlash('success', [
					'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
							  'duration' => 3000,
								'icon' => 'fa fa-users',
								'message' => 'Data Berhasil di Simpan',
								'title' => 'Simpan Data',
								'positonY' => 'top',
								'positonX' => 'center',
								'showProgressbar' => true,
				]);

				return $this->redirect(['index']);
			}catch (Exception $e) {
                $transaction->rollback();
				Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Simpan',
                        'title' => 'Error',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('create');
            }
			
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                'title' => 'Pengembalian Berkas',
                'konstanta' => 'PengembalianBerk',
				'modelPengembalian' => $modelBerkas,
				'modelP21a'   => $modelP21a
            ]);
        }
    }

    /**
     * Deletes an existing PdmPengembalian model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
   
	 public function actionDelete()
    {
		
		$id=$_POST['hapusIndex'];
		if($id=='all'){
			$id_perkara = Yii::$app->session->get('id_perkara');
			PdmPengembalian::deleteAll(['id_perkara'=>$id_perkara]);
		}else{
			for($i=0;$i<count($id);$i++){
				$this->findModel($id)->delete();
			}
		}
		Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil Dihapus',
                        'title' => 'Pesan',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
        return $this->redirect(['index']);
    }
	
	public function actionDeleteberkas()
    {
		
		$id=$_POST['hapusIndex'];
		if($id=='all'){
			$id_perkara = Yii::$app->session->get('id_perkara');
			Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_pengembalian_berkas WHERE id_berkas IN (SELECT id_berkas FROM pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."') ")->execute();
			
		}else{
			for($i=0;$i<count($id);$i++){
				$this->findModelBerkas($id[$i])->delete();
			}
		}
		Yii::$app->getSession()->setFlash('success', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil Dihapus',
                        'title' => 'Pesan',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmPengembalian model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPengembalian the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPengembalian::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	 protected function findModelBerkas($id)
    {
        if (($model = PdmPengembalianBerkas::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionCetakberkas($id) {
		$id_perkara = Yii::$app->session->get('id_perkara');
		$connection = \Yii::$app->db;
		$odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pidum/pengembalianBerkas.odt");
		$model = PdmPengembalianBerkas::findOne(['id_pengembalian' => $id]);
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => trim($id_perkara)]);
		$modelBerkas = PdmBerkasTahap1::findOne($model->id_berkas);
		
		$listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut desc  ")->queryAll();
			
			 if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
				$nama_tersangka = ucfirst(strtolower($key[nama])) ;
			}
        } else if(count($listTersangka) == 2){
			 $i=1;
			 foreach ($listTersangka as $key) {
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dan " ;
				}else{
					$nama_tersangka .= ucfirst(strtolower($key[nama])) ;
				}
				$i++;
			 }
		}else {
            foreach ($listTersangka as $key) {
				$i=1;
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dkk. " ;
				}
			}
        }
		
		 $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
		
		$odf->setVars('nama_penandatangan', $model->nama);
		$odf->setVars('jabatan_penandatangan', $model->jabatan);
        $odf->setVars('pangkat', $model->pangkat);
        $odf->setVars('nip_penandatangan', $model->id_penandatangan);
        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('sifat', $sifat->nama);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('dikeluarkan', $model->dikeluarkan);
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
		
		$odf->setVars('nama_tersangka', $nama_tersangka);
		$odf->setVars('nomor_berkas', $modelBerkas->no_berkas);
		$odf->setVars('tanggal_berkas', Yii::$app->globalfunc->ViewIndonesianFormat($modelBerkas->tgl_berkas));
		
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_pengembalian_berkas')
                ->where(" id_pengembalian ='" .$id."'")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		$i=1;
		
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);
		
		
		$odf->exportAsAttachedFile('pengembalianBerkas.odt');
	}
	public function actionCetakspdp($id) {
		$connection = \Yii::$app->db;
		$odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pidum/pengembalianSPDP.odt");
		$model = PdmPengembalian::findOne(['id_pengembalian' => trim($id)]);
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => trim($model->id_perkara)]);
		
		$listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka a WHERE a.id_perkara='".$model->id_perkara."' ORDER BY a.no_urut desc  ")->queryAll();
			
			 if (count($listTersangka) == 1) {
            foreach ($listTersangka as $key) {
				$nama_tersangka = ucfirst(strtolower($key[nama])) ;
			}
        } else if(count($listTersangka) == 2){
			 $i=1;
			 foreach ($listTersangka as $key) {
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dan " ;
				}else{
					$nama_tersangka .= ucfirst(strtolower($key[nama])) ;
				}
				$i++;
			 }
		}else {
            foreach ($listTersangka as $key) {
				$i=1;
				if($i==1){
					$nama_tersangka = ucfirst(strtolower($key[nama]))." dkk. " ;
				}
			}
        }
		
		
		
		$odf->setVars('nama_penandatangan', $model->nama);
		$odf->setVars('jabatan_penandatangan', $model->jabatan);
        $odf->setVars('pangkat', $model->pangkat);
        $odf->setVars('nip_penandatangan', $model->id_penandatangan);
        $odf->setVars('nomor', $model->no_surat);
        $odf->setVars('sifat', $model->sifat);
        $odf->setVars('lampiran', $model->lampiran);
        $odf->setVars('dikeluarkan', $model->dikeluarkan);
        $odf->setVars('kepada', $model->kepada);
        $odf->setVars('di_tempat', $model->di_kepada);
        $odf->setVars('kejaksaan', Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama);
        $odf->setVars('tgl_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
		
		$odf->setVars('nama_tersangka', $nama_tersangka);
		$odf->setVars('nomor_spdp', $modelSpdp->no_surat);
		$odf->setVars('tanggal_spdp', Yii::$app->globalfunc->ViewIndonesianFormat($modelSpdp->tgl_surat));
		$odf->setVars('tanggal_terima', Yii::$app->globalfunc->ViewIndonesianFormat($modelSpdp->tgl_terima));
		
		$query = new Query;
        $query->select('*')
                ->from('pidum.pdm_tembusan_pengembalian')
                ->where(" trim(id_pengembalian) ='" .trim($id)."' ")
                ->orderby('no_urut');
        $dt_tembusan = $query->createCommand();
        $listTembusan = $dt_tembusan->queryAll();
        $dft_tembusan = $odf->setSegment('tembusan');
		$i=1;
		
        foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);
		
		$odf->exportAsAttachedFile('pengembalianSPDP.odt');
	}
}
