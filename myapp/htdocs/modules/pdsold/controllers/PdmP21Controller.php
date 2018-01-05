<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\PdmP21;
use app\modules\pdsold\models\PdmP21Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\base\Object;
use yii\db\Query;

use app\components\ConstSysMenuComponent;
use app\modules\pdsold\models\VwTersangka;
use app\modules\pdsold\models\PdmSpdp;
use app\modules\pdsold\models\PdmTrxPemrosesan;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\PdmP24;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmTembusanP21;
use app\modules\pdsold\models\MsTersangka;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSysMenu;
use yii\data\SqlDataProvider;
use yii\web\UploadedFile;
use yii\web\Session;

/**
 * PdmP21Controller implements the CRUD actions for PdmP21 model.
 */
class PdmP21Controller extends Controller
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
     * Lists all PdmP21 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $berkas = Yii::$app->session->get('perilaku_berkas');
        if($berkas == ''){
            $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P21]);
            $id_perkara     = Yii::$app->session->get('id_perkara');
            $searchModel    = new PdmP21Search();
            $dataProvider   = $searchModel->search2(Yii::$app->request->queryParams);
            $models         = $dataProvider->getModels();		
            return $this->render('index', [
                'dataProvider'  => $dataProvider,
                'sysMenu'       => $sysMenu,
                'model'         => $model,
                'searchModel'   => $searchModel
            ]);
        }else{
            $session    = new Session();
            $id_berkas  = $session->get('id_berkas');
            $query      = (new \yii\db\Query())
                    ->select (['pidum.pdm_pengantar_tahap1.no_pengantar',"coalesce(pidum.pdm_p21.id_p21,'0') as id_p21",'pidum.pdm_pengantar_tahap1.tgl_pengantar','pidum.pdm_berkas_tahap1.no_berkas','pidum.pdm_berkas_tahap1.tgl_berkas','pidum.pdm_pengantar_tahap1.tgl_terima','pidum.pdm_pengantar_tahap1.id_berkas','pidum.pdm_pengantar_tahap1.id_pengantar',"string_agg(pidum.ms_tersangka_berkas.nama,', ') as nama"])
                    ->from('pidum.pdm_berkas_tahap1')
                    ->join('INNER JOIN', 'pidum.pdm_pengantar_tahap1', 'pidum.pdm_pengantar_tahap1.id_berkas = pidum.pdm_berkas_tahap1.id_berkas')
                    ->join('INNER JOIN', 'pidum.ms_tersangka_berkas', 'pidum.ms_tersangka_berkas.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
                    ->join('INNER JOIN', 'pidum.pdm_p24', 'pidum.pdm_p24.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->join('LEFT JOIN', 'pidum.pdm_p21', 'pidum.pdm_p21.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->where("pidum.pdm_berkas_tahap1.id_berkas = '".$berkas."'  GROUP BY pidum.pdm_pengantar_tahap1.id_pengantar,pidum.pdm_berkas_tahap1.no_berkas,pidum.pdm_berkas_tahap1.tgl_berkas,pidum.pdm_p21.id_p21")
                    ->all();
            //            AND pidum.pdm_p24.id_hasil='1'
            
//            echo $berkas;exit();
            $id_pengantar = $query[0]['id_pengantar'];
            if ($id_pengantar == ""){
                
                Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Maaf.. Berkas Perkara Belum Dinyatakan Lengkap',
                        'title' => 'Peringatan!',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
                return $this->redirect(['../pdsold/pdm-p24/index']);
            }
//            echo $id_hasil;exit();
            $id_p21 = $query[0]['id_p21'];
            return $this->redirect(['update','id_pengantar'=>$id_pengantar,'idp21'=>$id_p21]);
        }
    }

    /**
     * Displays a single PdmP21 model.
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
     * Creates a new PdmP21 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_pengantar){
		  $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P21]);
		  $id_perkara = Yii::$app->session->get('id_perkara');
		  //$id_berkas = 
//		  $idp21=$_GET['idp21'];
			if ($idp21 !='' && $idp21 !='undefined'&&$idp21 !='0')
			{
			 return $this->redirect('update?id_pengantar='.$id_pengantar.'&idp21='.$idp21.'');
			}
		  $model = new PdmP21();
		  $modelP24 = PdmP24::findOne(['id_pengantar' => $id_pengantar]);
		  $modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $id_pengantar]);
		  $modelBerkas = PdmBerkasTahap1::findOne(['id_berkas' =>  $modelPengantar->id_berkas]);
		  $searchModel = new PdmP21Search();
		  $dataProvider = $searchModel->searchTersangka_new($modelPengantar->id_berkas);
		 
        
        //echo '<pre>';print_r($id_pengantar);exit;

	   if ($model->load(Yii::$app->request->post())) {
            //echo '<pre>';print_r($_SESSION);exit;
	       $transaction = Yii::$app->db->beginTransaction();
            try{
				$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p21 WHERE id_berkas='".$modelPengantar->id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
				
				$NextProcces = array(ConstSysMenuComponent::P21A);
                Yii::$app->globalfunc->getNextProcces($id_perkara,$NextProcces); 
				
				
				$model->id_p21  =$modelPengantar->id_berkas."|".$_POST['PdmP21']['no_surat'];
				$model->id_pengantar =$id_pengantar;
				$model->id_berkas = $modelPengantar->id_berkas;
				
				$files = UploadedFile::getInstance($model, 'file_upload');
			
				if ($files != false && !empty($files) ) {
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21_'.$jml_pt['jml'].'.'. $files->extension;
					$files->saveAs($path);
				}
                
				
				if($_POST['hdn_nama_penandatangan'] != ''){
					$model->nama = $_POST['hdn_nama_penandatangan'];
					$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
					$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
				}
			
				 if ($model->save()) {
					
				}else{
					var_dump($model->getErrors());exit;
					
				} 
				
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
				//Insert tabel tembusan 
            if (isset($_POST['new_tembusan'])) {
                PdmTembusanP21::deleteAll(['id_p21' => $model->id_p21]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP21();
                    $modelNewTembusan->id_p21 = $model->id_p21;
                    $modelNewTembusan->id_tembusan = $model->id_p21."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $i+1;
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }
			 
			

                if($model->save()){
					//Yii::$app->globalfunc->getSetStatusProcces($model->id_perkara,GlobalConstMenuComponent::SPDP); 
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
                    $transaction->commit();
                    return $this->redirect(['update','id_pengantar'=>$id_pengantar, 'idp21'=>$model->id_p21]);
			 //return $this->redirect(['update', 'id_pengantar'=>$id_pengantar, 'idp21'=>$perilaku_berkas.'|'.$_POST['PdmP21']['no_surat']]);
			 }else{
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
			}catch (Exception $e) {
                $transaction->rollback();
            }
        } else {
            return $this->render('create', [
                'model' => $model,
				'modelBerkas'=>$modelBerkas,
				'modelPengantar'=>$modelPengantar,
				'dataProvider' => $dataProvider,
				'modelP24'=>$modelP24,
				'sysMenu' => $sysMenu,
//				'id_hasil' => $id_hasil,
            ]);
        }
    }

    /**
     * Updates an existing PdmP21 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_pengantar,$idp21)
    {
		  $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P21]);
		  $id_perkara = Yii::$app->session->get('id_perkara');
		  $model = PdmP21::findOne(['id_p21' => $idp21]);
          if($model==NULL){
            $model = new PdmP21();
          }
		  $modelP24 = PdmP24::findOne(['id_p24' => $id_pengantar]);
		  $modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $id_pengantar]);
		  $modelBerkas = PdmBerkasTahap1::findOne(['id_berkas' =>  $modelPengantar->id_berkas]);
		  $searchModel = new PdmP21Search();
		  $dataProvider = $searchModel->searchTersangka_new($modelPengantar->id_berkas);
		  $session = new session();
          $id_berkas = $session->get('perilaku_berkas');
         // echo '<pre>';print_r($model);exit;
         
	   if ($model->load(Yii::$app->request->post())) {
            $transaction = Yii::$app->db->beginTransaction();
            try{				
				
			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p21 WHERE id_berkas='".$modelPengantar->id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
			
			$files = UploadedFile::getInstance($model, 'file_upload');
					$file_lama = $model->getOldAttributes()['file_upload'];
					
					if ($files != false && !empty($files) ) {
						if($file_lama !=''){
							$model->file_upload = $file_lama;
							$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . $file_lama;
							$files->saveAs($path);
						}else{
							
							$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21_'.$jml_pt['jml'].'.'. $files->extension;
							$path = Yii::$app->basePath . '/web/template/pdsold_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21_'.$jml_pt['jml'].'.'. $files->extension;
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
			     $model->id_p21 = $id_berkas.'|'.$_POST['PdmP21']['no_surat'];
                 $model->id_berkas = $id_berkas;
                 $model->id_pengantar = $id_pengantar;
				if(!$model->save()){
                        var_dump($model->getErrors());exit;
                       }
				//Insert tabel tembusan 
            if (isset($_POST['new_tembusan'])) {
				$id_p21  =$modelPengantar->id_berkas."|".$_POST['PdmP21']['no_surat'];
                 PdmTembusanP21::deleteAll(['id_p21' => $id_p21]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP21();
                    $modelNewTembusan->id_p21 = $id_p21;
                    $modelNewTembusan->id_tembusan = $id_p21."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = $i+1;
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
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
			 return $this->redirect(['update','id_pengantar'=>$id_pengantar, 'idp21'=>$model->id_p21]);
			 
                    
                
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
                    return $this->redirect(['index']);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
				'modelBerkas'=>$modelBerkas,
				'modelPengantar'=>$modelPengantar,
				'dataProvider' => $dataProvider,
				'modelP24'=>$modelP24,
				'sysMenu' => $sysMenu,
            ]);
        }
    }

    /**
     * Deletes an existing PdmP21 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
	 
    public function actionHapus()
    {	
		$id = $_POST['hapusIndex'];
		$model1 = PdmP21::findOne(['id_pengantar' => $id]);
		PdmTembusan::deleteAll(['id_table' => $model1->id_p21, 'kode_table' => GlobalConstMenuComponent::P21]);
				
				$filename = Yii::$app->basePath . '/web/template/pdsold_surat/' .preg_replace('/[^A-Za-z0-9\-]/', '',$model1->id_perkara). '/p21_'.$model1->id_p21.'.pdf';
				if (file_exists($filename)) {
					chmod($filename,0777);
					unlink($filename);
				}
		$this->findModel($id)->delete();
        return $this->redirect(['index']);		
    }
	
	 public function actionDelete()
    {	

    	// print_r($_POST);exit;
		$id =  $_POST['selection'];
		$pot=  (string) $_POST['hapusIndex'];
		$id_perkara = $_SESSION['id_perkara'];
		
			   foreach($id AS $_id)
			   {
			   	$_id = explode('|',$_id);
			   	PdmP21::findOne(['id_berkas'=>$_id[0]])->delete();
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
    }
	
        public function actionCetak($id_pengantar,$idp21){
            $id_perkara = Yii::$app->session->get('id_perkara');
            $connection = \Yii::$app->db;
            $odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pdsold/p21.odt");

            $model = PdmP21::findOne(['id_p21' => $idp21]);
            $model_berkas = PdmBerkasTahap1::findOne(['id_berkas' => $model->id_berkas]);
            $model_pengantar = PdmPengantarTahap1::findOne(['id_berkas'=> $model->id_berkas]);
            $spdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
			
			/*$listTersangka = Yii::$app->db->createCommand(" select a.nama FROM pidum.ms_tersangka_berkas a WHERE a.id_berkas='".$model->id_berkas."' ORDER BY a.no_urut desc  ")->queryAll();
			
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
        }*/


            $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
            $odf->setVars('kepala', $model->jabatan);
			$berkas = Yii::$app->db->createCommand("select no_berkas,tgl_berkas,b.tgl_terima from pidum.pdm_berkas_tahap1 a inner join pidum.pdm_pengantar_tahap1 b on a.id_berkas = b.id_berkas WHERE b.id_pengantar='".$id_pengantar."' ")->queryOne();
            $odf->setVars('nomor_p21', $model->no_surat);
			$odf->setVars('tanggalSurat', Yii::$app->globalfunc->ViewIndonesianFormat($model_berkas->tgl_berkas));
			$odf->setVars('nomor', $model_berkas->no_berkas);
            $sifat = \app\models\MsSifatSurat::findOne(['id'=>$model->sifat]);
            $odf->setVars('sifat', $sifat->nama);
            $odf->setVars('lampiran', $model->lampiran);
            $odf->setVars('kepada', strtoupper($model->kepada));
            $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
            $odf->setVars('di_tempat', strtoupper($model->di_kepada));
            $odf->setVars('tgl_surat', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
            
            $odf->setVars('tanggalTerima', Yii::$app->globalfunc->ViewIndonesianFormat($model_pengantar->tgl_terima));
            #list Tersangka
            $ex_id = explode('|', $id_pengantar);
            $nama_tersangka = Yii::$app->globalfunc->GetHlistTerdakwaPengantar($ex_id[1]);
            //echo '<pre>';print_r($nama_tersangka);exit;
            $odf->setVars('tersangka_lampiran', $nama_tersangka);
            $odf->setVars('tersangka', $nama_tersangka);


            #penanda tangan
            $odf->setVars('nama_penandatangan', $model->nama);
            $odf->setVars('pangkat', $model->pangkat);
            $odf->setVars('nip_penandatangan', $model->id_penandatangan);



            #tembusan
            $query = new Query;
            $query->select('*')
                    ->from('pidum.pdm_tembusan_p21')
                    ->where("id_p21='" . $model->id_p21 . "' ")
                    ->orderby('no_urut');
            $dt_tembusan = $query->createCommand();
            $listTembusan = $dt_tembusan->queryAll();
            $dft_tembusan = $odf->setSegment('tembusan');
            foreach ($listTembusan as $element) {
                $dft_tembusan->urutan_tembusan($element['no_urut']);
                $dft_tembusan->nama_tembusan($element['tembusan']);
                $dft_tembusan->merge();
            }
            $odf->mergeSegment($dft_tembusan);


            $odf->exportAsAttachedFile('p21.odt');
        }
	

    /**
     * Finds the PdmP21 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP21 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP21::findOne(['id_pengantar' => $id])) !== null) {
            return $model;
        } /* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
    
    protected function findModelTersangka($id)
    {
    	if (($modelTersangka = VwTersangka::findAll(['id_' => $id])) !== null) {
    		return $modelTersangka;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist1.');
    	}
    }
    
    protected function findModelSpdp($id)
    {
    	if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
    		return $modelSpdp;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist2.');
    	}
    }
	
	protected function findModelBerkas($id)
    {
        if (($modelBerkas = PdmBerkas::findOne(['id_perkara'=> $id])) !== null) {
            return $modelBerkas;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
