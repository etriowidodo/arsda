<?php

namespace app\modules\pidum\controllers;

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsTersangkaPt;
use app\modules\pidum\models\PdmP16;
use app\modules\pidum\models\PdmPerpanjanganTahanan;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmT5;
use app\modules\pidum\models\PdmT5Tersangka;
use app\modules\pidum\models\PdmT5Search;
use app\modules\pidum\models\PdmTembusanT5;
use app\modules\pidum\models\PdmStatusSurat;
use Odf;
use Yii;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use app\modules\pidum\models\PdmPenandatangan;
use yii\web\UploadedFile;
/**
 * PdmT5Controller implements the CRUD actions for PdmT5 model.
 */
class PdmT5Controller extends Controller
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
     * Lists all PdmT5 models.
     * @return mixed
     */
    public function actionIndex()
    {
	$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T5]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        
        $searchModel = new PdmT5Search();
        $dataProvider = $searchModel->search($id_perkara);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmT5 model.
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
     * Creates a new PdmT5 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
		
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T5]);
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
		
        $modelPerpanjangan = PdmPerpanjanganTahanan::find()->where(['id_perkara'=>$id_perkara])->orderBy(['tgl_surat'=>'SORT_ASC'])->one();
        $model = new PdmT5();
      
        $modelSpdp = $this->findModelSpdp($id_perkara);

        if ($model->load(Yii::$app->request->post())) {
			
	
	
            $transaction = Yii::$app->db->beginTransaction();
            try {
				$jml_pt = Yii::$app->db->createCommand(" SELECT (count(a.*)+1) as jml FROM pidum.pdm_t5 a INNER JOIN pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan WHERE b.id_perkara='".$id_perkara."' AND (a.file_upload is NOT null OR a.file_upload <> '') ")->queryOne();
				
				$model->id_t5 = $_POST['PdmT5']['id_perpanjangan']."|".$_POST['PdmT5']['no_surat'];
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
				
				$files = UploadedFile::getInstance($model, 'file_upload');
			
				if ($files != false && !empty($files) ) {
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/T5_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/T5_'.$jml_pt['jml'].'.'. $files->extension;
					$files->saveAs($path);
				}
                                
                $model->id_perpanjangan     = $_POST['PdmT5']['id_perpanjangan'];
                $pdm_perpanjangan           = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
                $model->no_surat_penahanan  = $pdm_perpanjangan->no_surat_penahanan;
//                echo '<pre>';print_r($model);exit();
                if (!$model->save()) {
                    echo "T-5";var_dump($model->getErrors());exit;
                } else {
					
                    $no_penahanan       = $pdm_perpanjangan->no_surat_penahanan;
                    PdmTembusanT5::deleteAll(['id_t5'=>$model->id_t5]);
                    if (isset($_POST['new_tembusan'])) {
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan = new PdmTembusanT5();
                            $modelNewTembusan->id_t5 = $model->id_t5;
                            $modelNewTembusan->id_tembusan = $model->id_t5."|".($i+1);
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_surat_penahanan = $no_penahanan;
                            $modelNewTembusan->no_urut = ($i+1);
                            if(!$modelNewTembusan->save()){
								echo "Tembusan-";var_dump($modelNewTembusan->getErrors());exit;
							}
                        }
                    }
					
                    $transaction->commit();
                    Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Berhasil di Simpan',
                        'title' => 'Ubah Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                    return $this->redirect('index');
                   
                }
            } catch (Exception $e) {
				echo "Error5";var_dump($e);exit;
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                        'model'             => $model,
                        'modelSpdp'         => $modelSpdp,
                        'id_perkara'        => $id_perkara,
                        'modelPerpanjangan' => $modelPerpanjangan,
                        'sysMenu'           => $sysMenu
            ]);
        }
    }

    /**
     * Updates an existing PdmT5 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_t5)
    {
        
        $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::T5]);
        $id_perkara = Yii::$app->session->get('id_perkara');

        $model = PdmT5::findOne(['id_t5' => $id_t5]);
		
		if($model == null){
            $model = new PdmBerkas();
        }
		
		$modelPerpanjangan = PdmPerpanjanganTahanan::find()->where(['id_perkara'=>$id_perkara])->orderBy(['tgl_surat'=>'SORT_ASC'])->one();
        $modelSpdp = $this->findModelSpdp($id_perkara);
					
        if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try {
				$jml_pt = Yii::$app->db->createCommand(" SELECT (count(a.*)+1) as jml FROM pidum.pdm_t5 a INNER JOIN pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan WHERE b.id_perkara='".$id."' AND (a.file_upload is NOT null OR a.file_upload <> '') ")->queryOne();
				
                
                $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_t5', 'id_t5', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();

                
                if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
				
				$files = UploadedFile::getInstance($model, 'file_upload');
				$file_lama = $model->getOldAttributes()['file_upload'];
					
				if ($files != false && !empty($files) ) {
					if($file_lama !=''){
						$model->file_upload = $file_lama;
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . $file_lama;
						$files->saveAs($path);
					}else{
						
						$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/T5_'.$jml_pt['jml'].'.'. $files->extension;
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/T5_'.$jml_pt['jml'].'.'. $files->extension;
						$files->saveAs($path);
					}
					
				}else{
					$model->file_upload = $file_lama;
				}
                $pdm_perpanjangan           = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $model->id_perpanjangan]);
                $model->no_surat_penahanan  = $pdm_perpanjangan->no_surat_penahanan;	
                if(!$model->update()){
					var_dump($model->getErrors());exit;
				}
			
                    $no_penahanan       = $model->no_surat_penahanan;
                    $id_t5 = $model->id_perpanjangan."|".$_POST['PdmT5']['no_surat'];
                    PdmTembusanT5::deleteAll(['id_t5'=>$id_t5]);
                    if (isset($_POST['new_tembusan'])) {
                        for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                            $modelNewTembusan = new PdmTembusanT5();
                            $modelNewTembusan->id_t5 = $id_t5;
                            $modelNewTembusan->id_tembusan = $id_t5."|".($i+1);
                            $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                            $modelNewTembusan->no_surat_penahanan = $no_penahanan;
                            $modelNewTembusan->no_urut = ($i+1);
                            if(!$modelNewTembusan->save()){
								echo "Tembusan-";var_dump($modelNewTembusan->getErrors());exit;
							}
                        }
                    }
					
				// DANAR WIDO 13-07-2016 T5_10
				$idhapus = $_POST['MsTersangkaPt']['nama_update'];
				if(!empty($idhapus)){
               
                for($a=0; $a < count($idhapus); $a++){
                    $tersangka = Yii::$app->db->createCommand("UPDATE pidum.ms_tersangka_pt SET id_t5 =null WHERE id_tersangka = '".$idhapus[$a]."'");
                    $tersangka->execute();
					}
				}
				if(!empty($_POST['id_tersangka'])){
               
                for($b=0; $b < count($_POST['id_tersangka']); $b++){
                    $tersangka = Yii::$app->db->createCommand("UPDATE pidum.ms_tersangka_pt SET id_t5 ='".$model->id_t5."' WHERE id_tersangka = '".$_POST['id_tersangka'][$b]."'");
                    $tersangka->execute();
					}
				}
				// END DANAR WIDO 13-07-2016 T5_10
				
               
				
                $transaction->commit();
			
           if ($model->save()) {
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
                    return $this->redirect(['index']);
                    // return $this->redirect(['update','id'=>$model->id_perkara]);
                } else {
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
                }
            } catch (Exception $e) {
                $transaction->rollback();
                return $this->redirect('index');
            }
        } else {
            return $this->render('update', [
                        'model' => $model,
                        'modelSpdp' => $modelSpdp,
						'modelPerpanjangan' => $modelPerpanjangan,
                        'sysMenu' => $sysMenu,
                        'id' => $id_t5
            ]);
        }
    
    }

    /**
     * Deletes an existing PdmT5 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        try{
            $id = $_POST['hapusIndex'];
			$session = new Session();
            $id_perkara = $session->get('id_perkara');
			
			PdmStatusSurat::deleteAll(['id_perkara' => $id_perkara,'id_sys_menu'=>GlobalConstMenuComponent::T5]);
			
            if($id == "all"){
                /*$model_tersangka = MsTersangkaPt::findOne(['id_perkara' => $id_perkara]);
				$model_tersangka->id_t5 = '';
				$model_tersangka->update();*/
				
				//PdmT5::deleteAll(['id_perkara'=>$id_perkara]);
            }else{
                for($i=0;$i<count($id);$i++){
				   /*$model_tersangka = MsTersangkaPt::findOne(['id_perkara' => $id_perkara,'id_t5'=>$id[$i]]);
				   $model_tersangka->id_t5 = '';
				   $model_tersangka->update();*/
				   
				   PdmT5::deleteAll(['id_t5' => $id[$i]]);
				   
                }
            }
            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success',
                'duration' => 3000,
                'icon' => 'fa fa-users',
                'message' => 'Data Berhasil di Hapus',
                'title' => 'Hapus Data',
                'positonY' => 'top',
                'positonX' => 'center',
                'showProgressbar' => true,
            ]);
            return $this->redirect(['index']);
        }catch (Exception $e){
            Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Hapus',
                        'title' => 'Hapus Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
            return $this->redirect(['index']);
        }
    }
	
	public function actionCetak($id_t5)
	{
            $session = new Session();
        $id_perkara = $session->get('id_perkara');
            
			$connection = \Yii::$app->db;
            $odf = new Odf(Yii::$app->params['report-path'] . "web/template/pidum/t5.odt");
            $model = PdmT5::findOne(['id_t5' => $id_t5]);
            $p16 = PdmP16::findOne(['id_perkara' => $id_perkara]);
            $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
            $riwayat = PdmPerpanjanganTahanan::findOne(['id_perkara'=>$id_perkara]);
            $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
            
	$pangkat = PdmPenandatangan::find()
->select ("a.jabatan as jabatan")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t5 b','a.peg_nik = b.id_penandatangan')
->where ("id_t5='".$id_t5."'")
->one();

$ttd = PdmPenandatangan::find()
->select ("a.nama as nama,a.pangkat as pangkat,a.peg_nik as peg_nik")
->from ("pidum.pdm_penandatangan a")
->join ('inner join','pidum.pdm_t5 b','a.peg_nik = b.id_penandatangan')
->where ("id_t5='".$id_t5."'")
->one();
//print_r($pangkat);exit;
            $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
            
            $odf->setVars('nomor', $model->no_surat);
            $odf->setVars('sifat', $sifat->nama);
            $odf->setVars('lampiran', $model->lampiran);
            $odf->setVars('kepada', $model->kepada);
            $odf->setVars('tempat', ucfirst(strtolower($model->di_kepada))); //CMS_PIDUM_ #13072016
            $odf->setVars('nomor_riwayat', $riwayat->no_surat);
            $odf->setVars('tanggal_riwayat', Yii::$app->globalfunc->ViewIndonesianFormat($riwayat->tgl_surat));
            $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
            $odf->setVars('tanggal_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
            $odf->setVars('tanggal_resume', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_resume));
            
			
			#list Tersangka
            $dft_tersangka = '';
            $listTersangka = Yii::$app->db->createCommand(" SELECT * FROM pidum.ms_tersangka_pt WHERE id_perpanjangan='".$model->id_perpanjangan."' ")->queryOne();
            
                $dft_tersangka .= $listTersangka['nama'] . ',';
            
            $dft_tersangka= preg_replace("/,$/", "", $dft_tersangka);
            $odf->setVars('tersangka', ucfirst(strtolower($dft_tersangka)));
            
            $odf->setVars('alasan',$model->alasan);

            $listTersangkas = Yii::$app->db->createCommand(" SELECT * FROM pidum.ms_tersangka_pt WHERE id_perpanjangan='".$model->id_perpanjangan."' ")->queryOne();
            $dft_tersangka = $odf->setSegment('tersangkas');
            $i=1;
            //foreach ($listTersangkas as $element) {
                $dft_tersangka->urut($i);
                $dft_tersangka->nama_tersangka(ucfirst(strtolower($listTersangkas['nama'])));
                $dft_tersangka->merge();
                $i++;
           // }
            $odf->mergeSegment($dft_tersangka);

//			$odf->setVars('kepala', $model->jabatan);
            $odf->setVars('nama_penandatangan', $model->nama);
            $odf->setVars('pangkat', $model->pangkat);
            $odf->setVars('nip_penandatangan', $model->id_penandatangan);


            #tembusan
            $query = new Query;
            $query->select('*')
                    ->from('pidum.pdm_tembusan_t5')
                    ->where("id_t5='" . $model->id_t5 . "'")
                    ->orderBy('no_urut');
            $dt_tembusan = $query->createCommand();
            $listTembusan = $dt_tembusan->queryAll();
            $dft_tembusan = $odf->setSegment('tembusan');
			
		//bowo dibuat index untuk cetakan tembusan
        $i=1;
		foreach ($listTembusan as $element) {
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->nama_tembusan($element['tembusan']);
            $dft_tembusan->merge();
			$i++;
        }
        $odf->mergeSegment($dft_tembusan);
            
            $odf->exportAsAttachedFile('T5.odt');
        
        }

    /**
     * Finds the PdmT5 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmT5 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	  public function actionShowTersangka()
    {
        if($_GET['id_tersangka'] != null){
            $modelTersangka = MsTersangkaPt::findOne(['id_tersangka' => $_GET['id_tersangka']]);
        }else{
            $modelTersangka = new MsTersangkaPt();
        }
        
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        
        return $this->renderAjax('_popTersangka', [
            'modelTersangka' => $modelTersangka,
            'agama' => $agama,
            'identitas' => $identitas,
            'pendidikan' => $pendidikan,
            'warganegara' => $warganegara
        ]);
    }
    protected function findModel($id)
    {
        if (($model = PdmT5::findOne(['id_perkara' => $id])) !== null) {
            return $model;
        } /*else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }*/
    }

    protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelTersangka($id)
    {
        if (($model = MsTersangkaPt::findAll(['id_perkara' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    


	
	 protected function findModelPenyidikTahanan($id_perkara,$id_t5)
    { 
		$id_t5=$_GET['id_t5'];
		$query = new Query;
           
		$query->select (["tsk.nama as nama"])
				->from('pidum.ms_tersangka_pt tsk')
				->join('inner JOIN', 'pidum.pdm_t5_tersangka ters_t5', 'ters_t5.id_tersangka=tsk.id_tersangka')
				->join('INNER JOIN', 'pidum.pdm_t5 t5', 'ters_t5.id_t5=t5.id_t5')
				->where("trim(tsk.id_perkara) = '".trim($id_perkara)."' AND ters_t5.id_t5 = '".$id_t5."' order by t5.id_t5 asc");
		$model = $query->all();
		
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
