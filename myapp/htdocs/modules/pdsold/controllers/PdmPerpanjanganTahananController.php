<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPerpanjanganTahanan;
use app\modules\pdsold\models\PdmPerpanjanganTahananSearch;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\MsAsalSurat;
use app\modules\pdsold\models\VwTersangka;
use app\modules\pdsold\models\MsPenyidik;
use app\modules\pdsold\models\PdmTahananPenyidik;
use app\modules\pdsold\models\PdmSysMenu;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\MsTersangkaPt;
use app\modules\pdsold\models\MsTersangkaSearch;
use app\modules\pdsold\models\MsLoktahanan;
use app\models\MsWarganegara;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
/**
 * PdmPerpanjanganTahananController implements the CRUD actions for PdmPerpanjanganTahanan model.
 */
class PdmPerpanjanganTahananController extends Controller
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
     * Lists all PdmPerpanjanganTahanan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PdmPerpanjanganTahananSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		$sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::PerpanjanganThn]);
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'sysMenu' => $sysMenu
        ]);
    }

    /**
     * Displays a single PdmPerpanjanganTahanan model.
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
     * Creates a new PdmPerpanjanganTahanan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       
		$session = new Session();

        $id = $session->get('id_perkara');
		
        $model = new PdmPerpanjanganTahanan();
        $modelPdmSpdp = PdmSpdp::findOne(['id_perkara' => $id]);
        if($modelPdmSpdp){
            $modelAsalSurat = $modelPdmSpdp->idAsalsurat->nama;
            $modelTersangkas = $modelPdmSpdp->msTersangkas;
            $connection = \Yii::$app->db;
            $spdp = $connection->createCommand("SELECT id_penyidik,id_asalsurat FROM pidum.pdm_spdp WHERE id_perkara='".$id."'")->queryOne();
            $instansiPenyidik = $connection->createCommand("SELECT nama FROM pidum.ms_inst_pelak_penyidikan WHERE kode_ip = '$spdp[id_asalsurat]' AND kode_ipp = '$spdp[id_penyidik]'")->queryOne();
            $modelPenyidik = $instansiPenyidik['nama'];
        }
		
		

        if ($model->load(Yii::$app->request->post()) ) {
            $transaction = Yii::$app->db->beginTransaction();

            try{
                $jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_perpanjangan_tahanan WHERE id_perkara='".$id."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
                $model->id_perkara = $id;
                $model->id_perpanjangan = $id."|".$_POST['PdmPerpanjanganTahanan']['no_surat_penahanan'];
                $model->id_msloktahanan = $_POST['MsTersangkaBaru']['id_jenispenahanan'][0];
                if($_POST['MsTersangkaBaru']['id_tglawal_penahanan'][0] !=''){
                    $model->tgl_mulai = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglawal_penahanan'][0])));
                }
                if($_POST['MsTersangkaBaru']['id_tglakhir_penahanan'][0] !=''){
                    $model->tgl_selesai = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglakhir_penahanan'][0])));
                }
                
                if($_POST['MsTersangkaBaru']['id_tglawal_permintaan'][0] !=''){
                    $model->tgl_mulai_permintaan = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglawal_permintaan'][0])));
                }
                if($_POST['MsTersangkaBaru']['id_tglakhir_permintaan'][0] !=''){
                    $model->tgl_selesai_permintaan = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglakhir_permintaan'][0])));
                }
                $model->persetujuan = $_POST['MsTersangkaBaru']['persetujuan'][0];
                
                $model->lokasi_penahanan = $_POST['MsTersangkaBaru']['id_lokasipenahanan'][0];

                $files = UploadedFile::getInstance($model, 'file_upload');

                if ($files != false && !empty($files) ) {
                        $model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/perpanjangan_tahanan_'.$jml_pt['jml'].'.'. $files->extension;
                        $path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id) . '/perpanjangan_tahanan_'.$jml_pt['jml'].'.'. $files->extension;
                        $files->saveAs($path);
                }
//                echo '<pre>';print_r($model);exit();
                if($model->save()){
//                                        echo $id."|".$_POST['PdmPerpanjanganTahanan']['no_surat_penahanan'];exit();
					$no_penahanan = $_POST['PdmPerpanjanganTahanan']['no_surat_penahanan'];
					$i = 0;
					if(isset($_POST['MsTersangkaBaru']['nama'][$i]) && $_POST['MsTersangkaBaru']['nama'][$i] !=''){
                                            
						$tersangka = new MsTersangkaPt();
						$tersangka->id_tersangka = $id."|".$_POST['PdmPerpanjanganTahanan']['no_surat_penahanan']."|".($i+1); 
						$tersangka->tmpt_lahir = $_POST['MsTersangkaBaru']['tmpt_lahir'][$i];
						$tersangka->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru']['tgl_lahir'][$i]));
						$tersangka->umur = $_POST['MsTersangkaBaru']['umur'][$i];
						$tersangka->alamat = $_POST['MsTersangkaBaru']['alamat'][$i];
						$tersangka->no_identitas = $_POST['MsTersangkaBaru']['no_identitas'][$i];
						$tersangka->no_hp = $_POST['MsTersangkaBaru']['no_hp'][$i];
						$tersangka->warganegara = $_POST['MsTersangkaBaru']['warganegara'][$i];
						$tersangka->pekerjaan = $_POST['MsTersangkaBaru']['pekerjaan'][$i];
						$tersangka->suku = $_POST['MsTersangkaBaru']['suku'][$i];
						$tersangka->nama = $_POST['MsTersangkaBaru']['nama'][$i];
						$tersangka->id_jkl = $_POST['MsTersangkaBaru']['id_jkl'][$i];
						$tersangka->id_identitas = $_POST['MsTersangkaBaru']['id_identitas'][$i];
						$tersangka->id_agama = $_POST['MsTersangkaBaru']['id_agama'][$i];
						$tersangka->id_pendidikan = $_POST['MsTersangkaBaru']['id_pendidikan'][$i];
						$tersangka->id_perpanjangan = $model->id_perpanjangan;
						$tersangka->no_urut = 1;
                                                $tersangka->no_surat_penahanan = $no_penahanan;
						
						if(!$tersangka->save()){
							var_dump($tersangka->getErrors());exit;
						}
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
                    return $this->redirect('index');
                }else{
					var_dump($model->getErrors());exit;
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
            }catch (Exception $e){
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
				'modelAsalSurat' => $modelAsalSurat,
                'modelPenyidik' => $modelPenyidik,
                'modelTersangkas' => $modelTersangkas,
            ]);
        }

    }

    public function actionUpdate($id)
    {
//        echo $id;exit();
        $session = new Session();
        $id_perkara = $session->get('id_perkara');

        if(!empty($id_perkara)){
            $model = $this->findModel($id);
            $modelPdmSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        }

        if (empty($model)) {
            $model = new PdmPerpanjanganTahanan();
        }

        if($modelPdmSpdp){
            $modelAsalSurat = $modelPdmSpdp->idAsalsurat->nama;
            $modelPenyidik = $modelPdmSpdp->idPenyidik->nama;
			$modelListTersangka = Yii::$app->db->createCommand(" select a.id_tersangka,a.nama, a.tmpt_lahir, to_char(tgl_lahir,'dd-mm-yyyy') as tgl_lahir, a.tmpt_lahir from pidum.ms_tersangka_pt a inner join pidum.pdm_perpanjangan_tahanan b on a.id_perpanjangan = b.id_perpanjangan where b.id_perkara='".$id_perkara."' AND b.id_perpanjangan = '".$id."' ")->queryOne();
			
			
        }

        if ($model->load(Yii::$app->request->post()) ) {
            $transaction = Yii::$app->db->beginTransaction();
            try{
				$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_perpanjangan_tahanan WHERE id_perkara='".$id_perkara."' AND (file_upload is not null OR file_upload <> '') ")->queryOne();
					if(isset($_POST['MsTersangkaBaru']['id_jenispenahanan'][0]) && $_POST['MsTersangkaBaru']['id_jenispenahanan'][0] !=""){
						$model->id_msloktahanan = $_POST['MsTersangkaBaru']['id_jenispenahanan'][0];
						if($_POST['MsTersangkaBaru']['id_tglawal_penahanan'][0] !=''){
							$model->tgl_mulai = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglawal_penahanan'][0])));
						}
						if($_POST['MsTersangkaBaru']['id_tglakhir_penahanan'][0] !=''){
							$model->tgl_selesai = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglakhir_penahanan'][0])));
						}
						$model->lokasi_penahanan = $_POST['MsTersangkaBaru']['id_lokasipenahanan'][0];
					}
					
					$files = UploadedFile::getInstance($model, 'file_upload');
					$file_lama = $model->getOldAttributes()['file_upload'];
					
					if ($files != false && !empty($files) ) {
						if($file_lama !=''){
							$model->file_upload = $file_lama;
							$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . $file_lama;
							$files->saveAs($path);
						}else{
							
							$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
							$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p16_'.$jml_pt['jml'].'.'. $files->extension;
							$files->saveAs($path);
						}
						
					}else{
						$model->file_upload = $file_lama;
					}
//                    $model->id_perkara = $id;
                    
                    if($_POST['MsTersangkaBaru']['id_tglawal_permintaan'][0] !=''){
                        $model->tgl_mulai_permintaan = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglawal_permintaan'][0])));
                    }
                    if($_POST['MsTersangkaBaru']['id_tglakhir_permintaan'][0] !=''){
                        $model->tgl_selesai_permintaan = date('Y-m-d',strtotime(trim($_POST['MsTersangkaBaru']['id_tglakhir_permintaan'][0])));
                    }
                    $model->persetujuan = $_POST['MsTersangkaBaru']['persetujuan'][0];
                                        
                                        
                    $model->id_perpanjangan = $id_perkara."|".$_POST['PdmPerpanjanganTahanan']['no_surat_penahanan'];
		
//                    echo '<pre>';print_r($model);exit();
                    if(!$model->save()){
                        var_dump($model->getErrors());echo "--";exit;
                    }                
                    
                    $no_penahanan = $_POST['PdmPerpanjanganTahanan']['no_surat_penahanan'];
//                    echo '<pre>';print_r($_POST['MsTersangkaBaru']['id_tersangka'][0]);exit();
                    if(isset($_POST['MsTersangka']['nama_update'][0]) && $_POST['MsTersangka']['nama_update'][0] !=''){
                        MsTersangkaPt::deleteAll(['id_tersangka' => $_POST['MsTersangka']['nama_update'][0]]);
                    }
                    
                    $i = 0;
                    if(isset($_POST['MsTersangkaBaru']['nama'][$i]) && $_POST['MsTersangkaBaru']['nama'][$i] !=''){				
                        if($_POST['MsTersangkaBaru']['id_tersangka'][$i] == ''){
                            MsTersangkaPt::deleteAll(['id_tersangka' => $_POST['MsTersangkaBaru']['id_tersangka'][$i]]);
							/*$jml = Yii::$app->db->createCommand(" select count(*) from pidum.ms_tersangka_pt where id_perkara = '".$id_perkara."' ")->queryScalar();*/
                            $id_tersangka = $id."|1"; ; // karena hanya 1 tersangka saja untuk 1 surat
                        }else{
                            MsTersangkaPt::deleteAll(['id_tersangka' => $_POST['MsTersangkaBaru']['id_tersangka'][$i]]);
                            $id_tersangka = $_POST['MsTersangkaBaru']['id_tersangka'][$i];
                        }			
                        $tersangka = new MsTersangkaPt();
                        $tersangka->id_tersangka = $id_tersangka; // pemisah antara id_perkara dan nomor urut tersangka
                        $tersangka->tmpt_lahir = $_POST['MsTersangkaBaru']['tmpt_lahir'][$i];
                        $tersangka->tgl_lahir = date('Y-m-d',strtotime($_POST['MsTersangkaBaru']['tgl_lahir'][$i]));
                        $tersangka->umur = $_POST['MsTersangkaBaru']['umur'][$i];
                        $tersangka->alamat = $_POST['MsTersangkaBaru']['alamat'][$i];
                        $tersangka->no_identitas = $_POST['MsTersangkaBaru']['no_identitas'][$i];
                        $tersangka->no_hp = $_POST['MsTersangkaBaru']['no_hp'][$i];
                        $tersangka->warganegara = $_POST['MsTersangkaBaru']['warganegara'][$i];
                        $tersangka->pekerjaan = $_POST['MsTersangkaBaru']['pekerjaan'][$i];
                        $tersangka->suku = $_POST['MsTersangkaBaru']['suku'][$i];
                        $tersangka->nama = $_POST['MsTersangkaBaru']['nama'][$i];
                        $tersangka->id_jkl = $_POST['MsTersangkaBaru']['id_jkl'][$i];
                        $tersangka->id_identitas = $_POST['MsTersangkaBaru']['id_identitas'][$i];
                        $tersangka->id_agama = $_POST['MsTersangkaBaru']['id_agama'][$i];
                        $tersangka->id_pendidikan = $_POST['MsTersangkaBaru']['id_pendidikan'][$i];
                        $tersangka->id_perpanjangan = $id_perkara."|".$_POST['PdmPerpanjanganTahanan']['no_surat_penahanan'];
                        $tersangka->no_surat_penahanan = $no_penahanan;
                        $tersangka->no_urut = 1;
//                        echo '<pre>';print_r($tersangka);exit();
                        if(!$tersangka->save()){
                            var_dump($tersangka->getErrors());exit;
                        }
                    }

                $transaction->commit();
                
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'success',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Berhasil di Ubah',
                    'title' => 'Ubah Data',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
            }catch (Exception $e){
                $transaction->rollback();
                Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Gagal di Ubah',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
                return $this->redirect(['index']);
            }
            
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelAsalSurat' => $modelAsalSurat,
                'modelPenyidik' => $modelPenyidik,
                'modelListTersangka' => $modelListTersangka

            ]);
        }
    }

    /**
     * Deletes an existing PdmPerpanjanganTahanan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
     public function actionDelete()
    {
         $id = $_POST['hapusIndex'];
         $session = new Session();
         $id_perkara = $session->get('id_perkara');
		 
		
		
		
        if($id == "all")
        { 
			$cek = Yii::$app->db->createCommand(" SELECT count(*) jml FROM pidum.pdm_perpanjangan_tahanan a LEFT join pidum.pdm_t4 b on a.id_perpanjangan = b.id_perpanjangan LEFT JOIN pidum.pdm_t5 c on a.id_perpanjangan = c.id_perpanjangan WHERE (b.id_t4 is not null OR c.id_t5 is not null ) AND a.id_perkara='".$id_perkara."' ")->queryOne();
			if($cek['jml'] > 0){
				Yii::$app->getSession()->setFlash('success', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'fa fa-users',
                    'message' => 'Data Perpanjangan Tahanan Sudah Digunakan Di T-4/T-5',
                    'title' => 'Error',
                    'positonY' => 'top',
                    'positonX' => 'center',
                    'showProgressbar' => true,
                ]);
				return $this->redirect(['index']);
			}
			
			PdmPerpanjanganTahanan::deleteAll(['id_perkara' => $id_perkara]);
            MsTersangkaPt::deleteAll(['id_perkara' => $id_perkara]); 
            
            return $this->redirect(['index']);
        }
        else
        {  
               for ($i = 0; $i < count($id); $i++) 
               {   
					$cek = Yii::$app->db->createCommand(" SELECT count(*) jml FROM pidum.pdm_perpanjangan_tahanan a LEFT join pidum.pdm_t4 b on a.id_perpanjangan = b.id_perpanjangan LEFT JOIN pidum.pdm_t5 c on a.id_perpanjangan = c.id_perpanjangan WHERE (b.id_t4 is not null OR c.id_t5 is not null ) AND a.id_perpanjangan='".$id[$i]."'  ")->queryOne();
					if($cek['jml'] > 0){
						Yii::$app->getSession()->setFlash('success', [
							'type' => 'danger',
							'duration' => 3000,
							'icon' => 'fa fa-users',
							'message' => 'Data Perpanjangan Tahanan Sudah Digunakan Di T-4/T-5',
							'title' => 'Error',
							'positonY' => 'top',
							'positonX' => 'center',
							'showProgressbar' => true,
						]);
						return $this->redirect(['index']);
					}
			
					PdmPerpanjanganTahanan::deleteAll(['id_perpanjangan' => $id[$i]]);
                    MsTersangkaPt::deleteAll(['id_perpanjangan' => $id[$i]]); 
                    
                }
        }
		
        return $this->redirect(['index']);
    }
    /**
     * Finds the PdmPerpanjanganTahanan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmPerpanjanganTahanan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $id])) !== null) {
            return $model;
        }
    }



	
	 public function actionShowTersangka()
    {
        if($_GET['id_tersangka'] != null){
            $modelTersangka = MsTersangkaPt::findOne(['id_tersangka' => $_GET['id_tersangka']]);
            $modelPerpanjanganTahanan = PdmPerpanjanganTahanan::findOne(['id_perpanjangan' => $modelTersangka->id_perpanjangan]);
			$id_tersangka = $_GET['id_tersangka'];
        }else{
            $modelTersangka = new MsTersangkaPt();
            $modelPerpanjanganTahanan = new PdmPerpanjanganTahanan();
			$id_tersangka = '';
        }
        
        $identitas = ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama');
        $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
        $pendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
        $maxPendidikan = ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'umur');
		$JenisKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
        $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
        $warganegara_grid = new MsWarganegara();
		$lok_tahanan =  ArrayHelper::map(MsLoktahanan::find()->where(['and', "id_loktahanan <> '4'"])->all(), 'id_loktahanan', 'nama');
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $modelPdmSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
        
        return $this->renderAjax('_popTersangka', [
            'modelTersangka'    => $modelTersangka,
            'agama'             => $agama,
            'identitas'         => $identitas,
			'JenisKelamin'		=> $JenisKelamin,
            'pendidikan'        => $pendidikan,
            'warganegara'       => $warganegara,
            'warganegara_grid'  => $warganegara_grid,
            'maxPendidikan'    => $maxPendidikan,
            'modelPerpanjanganTahanan'  => $modelPerpanjanganTahanan,
            'lok_tahanan'  => $lok_tahanan,
            'id_tersangka'  => $id_tersangka,
            'modelPdmSpdp'     => $modelPdmSpdp 

        ]);
    }

    public function actionTersangka() {
        $searchModel = new MsTersangkaSearch();
  //$dataProvider = $searchModel->search2(Yii::$app->request->queryParams);
         $dataProvider2 = $searchModel->searchPdmTahanan('');
//var_dump ($dataProvider2);exit;
//echo $dataProvider['id_tersangka'];exit;
//$dataProvider->pagination->pageSize = 5;
        $dataProvider2->pagination->pageSize = 5;
        return $this->renderAjax('_tersangka', [
                    'searchModel'   => $searchModel,
                    'dataProvider'  => $dataProvider,
                    'dataProvider2' => $dataProvider2,
        ]);
    }
	
	 public function actionWn() {
        $searchModel = new MsWarganegara();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 10;
        return $this->renderAjax('_wn',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
	
}
