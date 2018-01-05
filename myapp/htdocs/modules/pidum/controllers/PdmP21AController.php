<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\PdmP21;
use app\modules\pidum\models\PdmP21ASearch;
use app\modules\pidum\models\PdmP21a;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSysMenu;
use app\modules\pidum\models\PdmTembusanP21a;
use app\modules\pidum\models\PdmPengantarTahap1;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmTrxPemrosesan;
use app\modules\pidum\models\PdmPenandatangan;
use yii\web\UploadedFile;
use yii\base\Object;
use yii\db\Query;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Session;


/**
 * PdmP21AController implements the CRUD actions for PdmP21A model.
 */
class PdmP21AController extends Controller
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
     * Lists all PdmP21A models.
     * @return mixed
     */
    public function actionIndex()
    {
        $berkas = Yii::$app->session->get('perilaku_berkas');
        if($berkas == ''){
            $sysMenu        = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P21A]);
            $id_perkara     = Yii::$app->session->get('id_perkara');
            $searchModel    = new PdmP21ASearch();
            $dataProvider   = $searchModel->search2(Yii::$app->request->queryParams);
            $models         = $dataProvider->getModels();		
            return $this->render('index', [
                'dataProvider' => $dataProvider,
                'sysMenu' => $sysMenu,
                            'model'=>$model,
                            'searchModel' => $searchModel
            ]);
        }else{
            $session    = new Session();
            $id_berkas  = $session->get('id_berkas');
            $query      = (new \yii\db\Query())
                    ->select (['pidum.pdm_pengantar_tahap1.no_pengantar','pidum.pdm_p21a.id_p21a','pidum.pdm_p21a.tgl_dikeluarkan','pidum.pdm_p21.no_surat','pidum.pdm_berkas_tahap1.no_berkas','pidum.pdm_berkas_tahap1.tgl_berkas','pidum.pdm_p21.tgl_dikeluarkan','pidum.pdm_pengantar_tahap1.id_berkas','pidum.pdm_pengantar_tahap1.id_pengantar',"string_agg(pidum.ms_tersangka_berkas.nama,', ') as nama"])
                    ->from('pidum.pdm_berkas_tahap1')
                    ->join('INNER JOIN', 'pidum.pdm_pengantar_tahap1', 'pidum.pdm_pengantar_tahap1.id_berkas = pidum.pdm_berkas_tahap1.id_berkas')
                    ->join('INNER JOIN', 'pidum.ms_tersangka_berkas', 'pidum.ms_tersangka_berkas.id_berkas=pidum.pdm_pengantar_tahap1.id_berkas')
                    ->join('INNER JOIN', 'pidum.pdm_p24', 'pidum.pdm_p24.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->join('INNER JOIN', 'pidum.pdm_p21', 'pidum.pdm_p21.id_pengantar=pidum.pdm_pengantar_tahap1.id_pengantar')
                    ->join('LEFT JOIN', 'pidum.pdm_p21a', 'pidum.pdm_p21a.id_pengantar=pidum.pdm_p21.id_pengantar')
                    ->where("pidum.pdm_berkas_tahap1.id_berkas = '".$berkas."' AND pidum.pdm_p24.id_hasil='1' GROUP BY pidum.pdm_pengantar_tahap1.id_pengantar,pidum.pdm_berkas_tahap1.no_berkas,pidum.pdm_berkas_tahap1.tgl_berkas,pidum.pdm_p21.id_p21,pidum.pdm_p21a.id_p21a")
                    ->all();
            //echo '<pre>';print_r($query);exit;
            $id_pengantar   = $query[0]['id_pengantar'];
            $idp21a   = $query[0]['id_p21a'];
            if($idp21a=='')
            {
                $idp21a =0;
            }
           // echo $idp21a;exit;
            // echo $idp21a;exit;
            
            return $this->redirect(['update','id_pengantar'=>$id_pengantar, 'idp21a'=>$idp21a]);
        }
    }

    /**
     * Displays a single PdmP21A model.
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
     * Creates a new PdmP21A model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_pengantar)
    {
		  $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P21A]);
		  $id_perkara = Yii::$app->session->get('id_perkara');
		  $idp21a=$_GET['idp21a'];
			if ($idp21a !='' && $idp21a !='undefined')
			{
			 return $this->redirect('update?id_pengantar='.$id_pengantar.'&idp21a='.$idp21a.'');
			}
		  $model = new PdmP21a();
		  $modelP21 = PdmP21::findOne(['id_pengantar' => $id_pengantar]);
		  $modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $id_pengantar]);
		  $searchModel = new PdmP21ASearch();
		  $dataProvider = $searchModel->searchTersangka_new($modelPengantar->id_berkas);
		 
      
	   if ($model->load(Yii::$app->request->post())) {
	   $transaction = Yii::$app->db->beginTransaction();
            try{
				$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p21a WHERE id_berkas='".$modelPengantar->id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
				
				$model->id_p21a  =$modelPengantar->id_berkas."|".$_POST['PdmP21a']['no_surat'];
				$model->id_pengantar =$id_pengantar;
				$model->id_berkas =$modelPengantar->id_berkas;
				
				  $files = UploadedFile::getInstance($model, 'file_upload');
				if ($files != false && !empty($files) ) {
				$model->file_upload =preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara).'/p21a_'.$jml_pt['jml'].'.'. $files->extension;
				$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21a_'.$jml_pt['jml'].'.'. $files->extension;
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
				
            if (isset($_POST['new_tembusan'])) {
                PdmTembusanP21a::deleteAll(['id_p21a' => $model->id_p21a]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP21a();
                    $modelNewTembusan->id_p21a = $model->id_p21a;
                    $modelNewTembusan->id_tembusan = $model->id_p21a."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
                    if(!$modelNewTembusan->save()){
						var_dump($modelNewTembusan->getErrors());exit;
					}
                }
            }
			 
			$transaction->commit();

                if($model->save()){
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
			 return $this->redirect(['../pidum/pdm-p21-a/index']);
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
				'modelPengantar'=>$modelPengantar,
				'dataProvider' => $dataProvider,
				'modelP21'=>$modelP21,
				'sysMenu' => $sysMenu,
            ]);
        }				
    }

    /**
     * Updates an existing PdmP21A model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_pengantar,$idp21a){
        // echo 'lel';exit;
          $sysMenu = PdmSysMenu::findOne(['kd_berkas' => GlobalConstMenuComponent::P21A]);
		  $id_perkara = Yii::$app->session->get('id_perkara');
		  $model = PdmP21a::findOne(['id_p21a' => $idp21a]);
          if($model == NULL){
                $model= new PdmP21a();
          }
		  $modelP21 = PdmP21::findOne(['id_pengantar' => $id_pengantar]);
		  $modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $id_pengantar]);
		  $searchModel = new PdmP21ASearch();
		  $dataProvider = $searchModel->searchTersangka_new($modelPengantar->id_berkas);
		 
          $session = new session();
        $id_berkas = $session->get('perilaku_berkas');    

	   if ($model->load(Yii::$app->request->post())) {
        //echo '<pre>';print_r($_POST);exit;
	       $transaction = Yii::$app->db->beginTransaction();
            try{
			$jml_pt = Yii::$app->db->createCommand(" SELECT (count(*)+1) as jml FROM pidum.pdm_p21a WHERE id_berkas='".$modelPengantar->id_berkas."' AND (file_upload is NOT null OR file_upload <> '') ")->queryOne();
			
			$files = UploadedFile::getInstance($model, 'file_upload');
			$file_lama = $model->getOldAttributes()['file_upload'];
			
			if ($files != false && !empty($files) ) {
				if($file_lama !=''){
					$model->file_upload = $file_lama;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . $file_lama;
					$files->saveAs($path);
				}else{
					
					$model->file_upload = preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21a_'.$jml_pt['jml'].'.'. $files->extension;
					$path = Yii::$app->basePath . '/web/template/pidum_surat/' . preg_replace('/[^A-Za-z0-9\-]/', '',$id_perkara) . '/p21a_'.$jml_pt['jml'].'.'. $files->extension;
					$files->saveAs($path);
				}
				
			}else{
				$model->file_upload = $file_lama;
			}

                $model->id_p21a = $id_berkas.'|'.$_POST['PdmP21a']['no_surat'];
                $model->id_berkas = $id_berkas;
			if($_POST['hdn_nama_penandatangan'] != ''){
				$model->nama = $_POST['hdn_nama_penandatangan'];
				$model->pangkat = $_POST['hdn_pangkat_penandatangan'];
				$model->jabatan = $_POST['hdn_jabatan_penandatangan'];
			}
			
			
				
				if(!$model->save()){
					var_dump($model->getErrors());exit;
				}
				//Insert tabel tembusan 
            if (isset($_POST['new_tembusan'])) {
				$id_p21a= $modelPengantar->id_berkas."|".$_POST['PdmP21a']['no_surat'];
                PdmTembusanP21a::deleteAll(['id_p21a' => $id_p21a]);
                for ($i = 0; $i < count($_POST['new_tembusan']); $i++) {
                    $modelNewTembusan = new PdmTembusanP21a();
                    $modelNewTembusan->id_p21a = $id_p21a;
                    $modelNewTembusan->id_tembusan = $id_p21a."|".($i+1);
                    $modelNewTembusan->tembusan = $_POST['new_tembusan'][$i];
                    $modelNewTembusan->no_urut = ($i+1);
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
			return $this->redirect(['update', 'id_pengantar'=>$id_pengantar, 'idp21a'=>$model->id_p21a]);
			 
                    
                
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
				'modelPengantar'=>$modelPengantar,
				'dataProvider' => $dataProvider,
				'modelP21'=>$modelP21,
				'sysMenu' => $sysMenu,
            ]);
        }				
    }
	
	public function actionCetak($id_pengantar,$idp21a) {
		$id_perkara=Yii::$app->session->get('id_perkara');
                $connection = \Yii::$app->db;
                //....
                $odf = new \Odf(Yii::$app->params['report-path'] . "web/template/pidum/p21a.odt");
                $model = PdmP21A::findOne(['id_p21a' => $idp21a]);
                $spdp = PdmSpdp::findOne(['id_perkara' =>$id_perkara]);

                $p21 = PdmP21::findOne(['id_berkas' => $model->id_berkas]);
                $odf->setVars('Kejaksaan', Yii::$app->globalfunc->getNamaSatker($spdp->wilayah_kerja)->inst_nama);
                $odf->setVars('kepala',$model->jabatan);

                $odf->setVars('nomor', $model->no_surat);
                $sifat = MsSifatSurat::findOne(['id'=>$model->sifat]);
                $odf->setVars('sifat', $sifat->nama);
                $odf->setVars('lampiran', $model->lampiran);
                $odf->setVars('dikeluarkan', ucfirst(strtolower($model->dikeluarkan)));
                $odf->setVars('tanggal_dikeluarkan', Yii::$app->globalfunc->ViewIndonesianFormat($model->tgl_dikeluarkan));
                $odf->setVars('tanggalP21', Yii::$app->globalfunc->ViewIndonesianFormat($p21->tgl_dikeluarkan));
                $odf->setVars('nomorP21', $p21->no_surat);
                $odf->setVars('kepada', $model->kepada);
                $odf->setVars('di_tempat', $model->di_kepada);

                #tembusan
                $dft_tembusan = '';
                $query = new Query;
                $query->select('*')
                        ->from('pidum.pdm_tembusan_p21a')
                        ->where("id_p21a='" . $model->id_p21a . "'")
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

                #list Tersangka
                /*$dft_tersangka = '';
                $query = new Query;
                $query->select('*')
                        ->from('pidum.ms_tersangka_berkas')
                        ->where("id_berkas='" .$model->id_berkas. "'");
                $data = $query->createCommand();
                $listTersangka = $data->queryAll();
                foreach ($listTersangka as $key) {
                    $dft_tersangka .= $key[nama] . ',';
                }
                $lampiran = explode(',', $dft_tersangka);
                if (count($listTersangka) > 1) {
                    $lampiran = $lampiran[0] . '. dkk';
                } else {
                    $lampiran = $lampiran[0];
                }*/
                $ex_id = explode('|', $id_pengantar);
                $lampiran =  Yii::$app->globalfunc->GetHlistTerdakwaPengantar($ex_id[1]);
                //echo '<pre>';print_r($lampiran);exit;
                $odf->setVars('tersangka_lampiran', $lampiran);


                $dft_tersangka = substr_replace($dft_tersangka, "", -1);
       
				 #penanda tangan
				$odf->setVars('nama_penandatangan', $model->nama);
				$odf->setVars('pangkat', $model->pangkat);
				$odf->setVars('nip_penandatangan', $model->id_penandatangan);


                $odf->exportAsAttachedFile('p21A.odt');
            }
    /**
     * Deletes an existing PdmP21A model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
	  public function actionHapus()
    {	
		$id = $_POST['hapusIndex'];
		$model1 = PdmP21a::findOne(['id_pengantar' => $id]);
		PdmTembusan::deleteAll(['id_table' => $model1->id_p21a, 'kode_table' => GlobalConstMenuComponent::P21A]);
				
				$filename = Yii::$app->basePath . '/web/template/pidum_surat/' .preg_replace('/[^A-Za-z0-9\-]/', '',$model1->id_perkara). '/p21a_'.$model1->id_p21a.'.pdf';
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
                PdmP21a::findOne(['id_berkas'=>$_id[0]])->delete();
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

    /**
     * Finds the PdmP21A model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmP21A the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmP21a::findOne(['id_pengantar' => $id])) !== null) {
            return $model;
        } /* else {
            throw new NotFoundHttpException('The requested page does not exist.');
        } */
    }
    
    protected function findModelTersangka($id)
    {
    	if (($modelTersangka = MsTersangka::findAll(['id_perkara' => $id])) !== null) {
    		return $modelTersangka;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist1.');
    	}
    }
}
