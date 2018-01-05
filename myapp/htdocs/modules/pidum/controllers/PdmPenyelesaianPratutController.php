<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmPenyelesaianPratut;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpah;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpahJaksa;
use app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangka;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmPenyelesaianPratutSearch;
use app\modules\pidum\models\PdmTembusanPratutLimpah;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmPengantarTahap1;
use app\modules\pidum\models\MsTersangkaBerkas;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\web\UploadedFile;
use app\components\GlobalConstMenuComponent;
/**
 * PdmPenyelesaianPratutController implements the CRUD actions for PdmPenyelesaianPratut model.
 */
class PdmPenyelesaianPratutController extends Controller
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
     * Lists all PdmPenyelesaianPratut models.
     * @return mixed
     */
    public function actionIndex()
    {
        $id_perkara = Yii::$app->session->get('id_perkara');
        // Jika Penyelesaian SPDP
        if(PdmBerkasTahap1::findOne(['id_perkara'=>$id_perkara])->id_berkas ==''){
            $this->redirect(['update', 'id' => $id_perkara]);
        }
        $searchModel = new PdmPenyelesaianPratutSearch();
        $dataProvider = $searchModel->search($id_perkara);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);	
    }

    /**
     * Displays a single PdmPenyelesaianPratut model.
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
     * Creates a new PdmPenyelesaianPratut model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmPenyelesaianPratut();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pratut]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmPenyelesaianPratut model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = PdmPenyelesaianPratut::findOne(['id_perkara'=>$id]);
		if($model==null){
			$model = new PdmPenyelesaianPratut();
			$file_lama = '';
		}else{
			$file_lama = $model->getOldAttributes()['file_upload'];
		}

        if ($model->load(Yii::$app->request->post())) {
			$transaction = Yii::$app->db->beginTransaction();
            try{
				if(PdmPenyelesaianPratut::findOne(['id_perkara'=>$id]) == null ){
					$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_penyelesaian_pratut', 'id_pratut', '" . \Yii::$app->globalfunc->getSatker()->inst_satkerkd . "', '" . date('Y') . "')")->queryOne();
					$model->id_perkara = $id;
					$model->id_pratut = $seq['generate_pk'];
				}
				$files = UploadedFile::getInstance($model, 'file_upload');
				
				if ($files != false && !empty($files) ) {
					
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/penyelesaianSPDP.'. $files->extension;
				}
				
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
				
				if ($files != false && !empty($files) ) {
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/penyelesaianSPDP.'.$files->extension;
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
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
	
	public function actionUpdateberkas($id_pratut,$id_berkas){
		
		$no_pengantar = PdmPengantarTahap1::find()->where(['id_berkas'=>$id_berkas])->orderBy('tgl_pengantar desc')->limit(1)->one()->no_pengantar;
		$TersangkaSS = MsTersangkaBerkas::findAll(['no_pengantar'=>$no_pengantar]);
		//echo '<pre>';print_r($TersangkaSS);exit;

		$id_perkara = Yii::$app->session->get('id_perkara');
		
		$model = PdmPenyelesaianPratut::findOne(['id_pratut'=>$id_pratut]);
		$modelLimpah = new PdmPenyelesaianPratutLimpah();
		
		$modelSpdp = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
		$nomorspdp = $modelSpdp->no_surat;
		//echo '<pre>';print_r($nomor);exit;


		$idLimpah = PdmPenyelesaianPratutLimpah::findOne(['id_pratut'=>$id_pratut])->id_pratut_limpah;
		if($idLimpah==''){
			$idLimpah = "0";
		}

		

		if($model==null){
			$model = new PdmPenyelesaianPratut();
			$file_lama = '';
			$model->created_time=date('Y-m-d H:i:s');
			$model->created_by=\Yii::$app->user->identity->peg_nip;
			$model->created_ip = \Yii::$app->getRequest()->getUserIP();
		}else{
			$file_lama = $model->getOldAttributes()['file_upload'];
			$model->updated_by=\Yii::$app->user->identity->peg_nip;
			$model->updated_time=date('Y-m-d H:i:s');
            $model->updated_ip = \Yii::$app->getRequest()->getUserIP();
		}

		if ($model->load(Yii::$app->request->post()) || $modelLimpah->load(Yii::$app->request->post())) {
		

			$transaction = Yii::$app->db->beginTransaction();
            try{
				
				
				
			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_penyelesaian_pratut WHERE id_berkas='".$id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
			
			if($_POST['PdmPenyelesaianPratutLimpah']['no_surat']!=''){ // Jika Dilimpahkan
				$model->nomor = $_POST['PdmPenyelesaianPratutLimpah']['no_surat'];
				$model->tgl_surat = $_POST['PdmPenyelesaianPratutLimpah']['tgl_dikeluarkan'];
				//$model->status = '1';
				$model->status = $_POST['PdmPenyelesaianPratut']['status'];
				//$nomor = $_POST['PdmPenyelesaianPratutLimpah']['no_surat'];
			}else{
				$model->nomor = $_POST['PdmPenyelesaianPratut']['nomor'];
				$model->status = $_POST['PdmPenyelesaianPratut']['status'];
				$model->tgl_surat = $_POST['PdmPenyelesaianPratut']['tgl_surat'];
				//$nomor = $_POST['PdmPenyelesaianPratut']['nomor'];
			}

			if($_POST['PdmPenyelesaianPratut']['status']=='1'){
				$model->nomor = '';
				$model->tgl_surat = null;
			}

			if($id_pratut =='0'){	
				$model->id_pratut = str_pad(\Yii::$app->globalfunc->getSatker()->inst_satkerkd, 6, "0", STR_PAD_LEFT).$nomorspdp.$id_berkas;
				$model->id_berkas = $id_berkas;
				$model->id_perkara = $id_perkara;
			}
			
			/*$files = UploadedFile::getInstance($model, 'file_upload');
			
			$files = UploadedFile::getInstance($model, 'file_upload');
			
				if ($files != false && !empty($files) ) {
					if($file_lama !=''){
						$model->file_upload = $file_lama;
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/penyelesaianPratut_'.$file_lama.'.'.$files->extension;
						$files->saveAs($path);
					}else{
						$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/penyelesaianPratut_'.$jml_pt['jml'].'.'. $files->extension;
						$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/penyelesaianPratut_'.$jml_pt['jml'].'.'.$files->extension;
						$files->saveAs($path);
					}
				}else{
					$model->file_upload = $file_lama;
				}*/
			
			
			
			if(!$model->save()){
				var_dump($model->getErrors())."-Penyelesaian Pratut-";exit;
			}
			
		
			
			//JIKA DILANJUTKAN BAIK DILIMPAHKAN/DITERUSKAN
			/*if($_POST['PdmPenyelesaianPratutLimpah']['no_surat']!=''){
				//$model->nomor = $_POST['PdmPenyelesaianPratutLimpah']['no_surat'];
				//$model->tgl_surat = $_POST['PdmPenyelesaianPratutLimpah']['tgl_dikeluarkan'];
				
				$data_limpah = $_POST['PdmPenyelesaianPratutLimpah'];
			
				$nama_penandatangan = $_POST['hdn_nama_penandatangan'];
				$pangkat_penandatangan = $_POST['hdn_pangkat_penandatangan'];
				$jabatan_penandatangan = $_POST['hdn_jabatan_penandatangan'];
				
				$data_limpah_jaksa_nip = $_POST['nip_baru'];
				$data_limpah_jaksa_nama = $_POST['nama_jpu'];
				$data_limpah_jaksa_pangkat = $_POST['gol_jpu'];
				$data_limpah_jaksa_jabatan = $_POST['jabatan_jpu'];
				
				$data_limpah_tersangka = $_POST['chk_status_penahanan'];
				
				$data_limpah_tersangka_id = $_POST['hdn_id_tersangka'];
				
				$modelLimpah = PdmPenyelesaianPratutLimpah::findOne(['id_pratut'=>$id_pratut]);
				if($modelLimpah==null){
					$modelLimpah = new PdmPenyelesaianPratutLimpah();
					$modelLimpah->id_pratut_limpah = $model->id_pratut."|".$_POST['PdmPenyelesaianPratutLimpah']['no_surat'];
					$modelLimpah->id_pratut = $model->id_pratut;
					$modelLimpah->created_time=date('Y-m-d H:i:s');
					$modelLimpah->created_by=\Yii::$app->user->identity->peg_nip;
					$modelLimpah->created_ip = \Yii::$app->getRequest()->getUserIP();
				}
				else
				{
					$modelLimpah->updated_by=\Yii::$app->user->identity->peg_nip;
					$modelLimpah->updated_time=date('Y-m-d H:i:s');
            		$modelLimpah->updated_ip = \Yii::$app->getRequest()->getUserIP();
				}
				
				$modelLimpah->no_surat = $data_limpah['no_surat'];
				$modelLimpah->sifat = $data_limpah['sifat'];
				$modelLimpah->lampiran = $data_limpah['lampiran'];
				$modelLimpah->tgl_dikeluarkan = $data_limpah['tgl_dikeluarkan'];
				$modelLimpah->dikeluarkan = $data_limpah['dikeluarkan'];
				$modelLimpah->kepada = $data_limpah['kepada'];
				$modelLimpah->di_kepada = $data_limpah['di_kepada'];
				$modelLimpah->perihal = $data_limpah['perihal'];
				$modelLimpah->id_penandatangan = $data_limpah['id_penandatangan'];
				if($nama_penandatangan !=''){
					$modelLimpah->nama = $nama_penandatangan;
					$modelLimpah->pangkat = $pangkat_penandatangan;
					$modelLimpah->jabatan = $jabatan_penandatangan;
				}
				$modelLimpah->kd_satker_pelimpahan = $data_limpah['kd_satker_pelimpahan'];
				$modelLimpah->id_perkara = $id_perkara;
				
				if($_POST['hdn_nama_penandatangan'] != ''){
				$modelLimpah->nama = $_POST['hdn_nama_penandatangan'];
				$modelLimpah->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$modelLimpah->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}
				
				if(!$modelLimpah->save()){
					var_dump($modelLimpah->getErrors())."-Penyelesaian Pratut Surat-";exit;
				}
				
				$modelSpdp = PdmSpdp::findOne(['id_perkara'=>$id_perkara]);
				$modelSpdp->id_satker_tujuan = $data_limpah['kd_satker_pelimpahan'];
				if(!$modelSpdp->save()){
					var_dump($modelSpdp->getErrors())."-Update Satker Tujuan Spdp error-";exit;
				}
				
				$id_pratut_limpah = $model->id_pratut."|".$_POST['PdmPenyelesaianPratutLimpah']['no_surat'];
				
				PdmPenyelesaianPratutLimpahJaksa::deleteAll(['id_pratut_limpah' => $id_pratut_limpah]);
				for($i=0;$i<count($data_limpah_jaksa_nip);$i++){
					$modelLimpahJaksa = new PdmPenyelesaianPratutLimpahJaksa();
					$modelLimpahJaksa->id_pratut_limpah_jaksa = $data_limpah_jaksa_nip[$i]."|".$id_pratut_limpah;
					$modelLimpahJaksa->id_pratut_limpah = $id_pratut_limpah;
					
					
					$modelLimpahJaksa->peg_nip = $data_limpah_jaksa_nip[$i];
					$modelLimpahJaksa->nama = $data_limpah_jaksa_nama[$i];
					$modelLimpahJaksa->pangkat = $data_limpah_jaksa_pangkat[$i];
					$modelLimpahJaksa->jabatan = $data_limpah_jaksa_jabatan[$i];
					if(!$modelLimpahJaksa->save()){
						var_dump($modelLimpahJaksa->getErrors())."-Penyelesaian Pratut Jaksa- ";exit;
					}
					
				}
				
				PdmPenyelesaianPratutLimpahTersangka::deleteAll(['id_pratut_limpah' => $id_pratut_limpah]);
				for($i=0;$i<count($data_limpah_tersangka_id);$i++){
					
					$modelLimpahTersangka = new PdmPenyelesaianPratutLimpahTersangka();
					$modelLimpahTersangka->id_pratut_limpah_tersangka = $data_limpah_tersangka_id[$i]."|".$id_pratut_limpah;
					$modelLimpahTersangka->id_pratut_limpah = $id_pratut_limpah;
					$modelLimpahTersangka->id_ms_tersangka_berkas = $data_limpah_tersangka_id[$i];
					$modelLimpahTersangka->status_penahanan = $data_limpah_tersangka[$i];
					if(!$modelLimpahTersangka->save()){
						var_dump($modelLimpahTersangka->getErrors())."-Penyelesaian Pratut Tersangka-";exit;
					}
				}
				
				PdmTembusanPratutLimpah::deleteAll(['id_pratut_limpah' => $id_pratut_limpah]);
				if (isset($_POST['new_tembusan'])) {
					for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
						$modelNewTembusan = new PdmTembusanPratutLimpah();
						$modelNewTembusan->id_pratut_limpah = $id_pratut_limpah;
						$modelNewTembusan->id_tembusan = $id_pratut_limpah."|".($i+1);
						$modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
						$modelNewTembusan->no_urut = ($i+1);
						if(!$modelNewTembusan->save()){
							var_dump($modelNewTembusan->getErrors());exit;
						}
						
					}
				}
				
				
				
			
			}*/
			
			//END JIKA DILANJUTKAN BAIK DILIMPAHKAN/DITERUSKAN
			
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
		}else{
			if($idLimpah!='0'){
				$modelLimpah = PdmPenyelesaianPratutLimpah::findOne(['id_pratut'=>$id_pratut]);
			}else{
				$modelLimpah = new PdmPenyelesaianPratutLimpah();
			}
			
			
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
		
		$modelTersangka = Yii::$app->db->createCommand(" select a.nama, to_char(tgl_lahir,'dd-mm-yyyy') as tgl_lahir, case when id_jkl = '1' then 'Laki-Laki' else 'Perempuan' end as kelamin,coalesce(b.status_penahanan,'0') as status_penahanan, a.id_tersangka
		FROM 
		pidum.pdm_berkas_tahap1 d INNER JOIN (
			select x.* from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
		) c ON d.id_berkas = c.id_berkas
		INNER JOIN pidum.ms_tersangka_berkas a ON a.id_berkas = c.id_berkas
		LEFT JOIN pidum.pdm_penyelesaian_pratut_limpah_tersangka b ON a.id_tersangka = b.id_ms_tersangka_berkas
		WHERE d.id_berkas='".$id_berkas."' ")->queryAll();
		
		$modelJaksa = Yii::$app->db->createCommand(" SELECT a.* FROM pidum.pdm_penyelesaian_pratut_limpah_jaksa a WHERE id_pratut_limpah = '".$idLimpah."' ")->queryAll();
		
		
		
			$searchModel = new PdmPenyelesaianPratutSearch();
			$dataProvider = $searchModel->search($id_perkara);
			
			$searchSatker = new KpInstSatkerSearch();
			$dataSatker = $searchSatker->search(Yii::$app->request->queryParams);
			
			
			return $this->render('index', [
				'searchModel' => $searchModel,
				'model'=>$model,
				'modelLimpah'=>$modelLimpah,
				'updateBerkas'=>'1',
				'id_pratut'=>$id_pratut,
				'id_limpah'=>$idLimpah,
				'id_berkas'=>$id_berkas,
				'dataProvider' => $dataProvider,
				'modelTersangka' => $modelTersangka,
				'modelBerkas' => $modelBerkas,
				'modelJaksa' => $modelJaksa,
				'searchSatker' => $searchSatker,
				'dataSatker' => $dataSatker,
				'TersangkaSS' => $TersangkaSS,
			]);
		}
		
	}

    /**
     * Deletes an existing PdmPenyelesaianPratut model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
	
	public function actionDeleteberkas()
    {
        $id=$_POST['hapusIndex'];
		if($id=='all'){
			$id_perkara = Yii::$app->session->get('id_perkara');
			Yii::$app->db->createCommand(" DELETE FROM pidum.pdm_penyelesaian_pratut WHERE id_berkas IN (SELECT id_berkas FROM pidum.pdm_berkas_tahap1 where id_perkara='".$id_perkara."') ")->execute();
			
		}else{
			for($i=0;$i<count($id);$i++){
				$this->findModel($id[$i])->delete();
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
     * Finds the PdmPenyelesaianPratut model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPenyelesaianPratut the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPenyelesaianPratut::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	
	public function actionShowPelimpahan($id_pratut_limpah,$id_berkas){
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
		
		$modelTersangka = Yii::$app->db->createCommand(" select a.nama, to_char(tgl_lahir,'dd-mm-yyyy') as tgl_lahir, case when id_jkl = '1' then 'Laki-Laki' else 'Perempuan' end as kelamin,coalesce(b.status_penahanan,'0') as status_penahanan
		FROM 
		pidum.pdm_berkas_tahap1 d INNER JOIN (
			select x.id_pengantar from 
			pidum.pdm_pengantar_tahap1 x inner join (
				select max(id_pengantar) as id_pengantar from pidum.pdm_pengantar_tahap1 group by id_berkas 
			)y on x.id_pengantar = y.id_pengantar
		) c ON d.id_berkas = c.id_pengantar
		INNER JOIN pidum.ms_tersangka_berkas a ON a.id_pengantar = c.id_pengantar
		LEFT JOIN pidum.pdm_penyelesaian_pratut_limpah_tersangka b ON a.id_tersangka = b.id_ms_tersangka_berkas
		WHERE d.id_berkas='".$id_berkas."' ")->queryAll();
		
		$model = new PdmPenyelesaianPratutLimpah();
		return $this->renderAjax('_popupPelimpahan', [
				'modelLimpah'=>$model,
				'modelBerkas'=>$modelBerkas,
				'modelTersangka'=>$modelTersangka,
			]);
	}
	
	public function actionSatker(){
		$searchSatker = new KpInstSatkerSearch();
		$dataSatker = $searchSatker->search(Yii::$app->request->queryParams);
			
		return $this->renderAjax('_satker', [
				'searchSatker' => $searchSatker,
				'dataSatker' => $dataSatker,
			]);
	}
}
