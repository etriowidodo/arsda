<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\DugaanPelanggaran;
use app\modules\pengawasan\models\DugaanPelanggaranSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;
use app\modules\pengawasan\models\Wilayah;

use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\Terlaporearch;

use app\modules\pengawasan\models\TembusanDugaanPelanggaran;
use app\modules\pengawasan\models\VDugaanPelanggaranIndexSearch;

use app\models\KpPegawai;
use app\models\KpPegawaiSearch;


use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;





/**
 * DugaanPelanggaranController implements the CRUD actions for DugaanPelanggaran model.
 */
class DugaanPelanggaranController extends Controller
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

    
    //create session was
    
    public function actionRegisterWas(){
        $key = $_POST['id_register'];
     
        $view_pemberitahuan = $this->renderAjax('view2', [
            'model' => $this->findModel($key),
        ]);
      //   header('Content-Type: application/json; charset=utf-8');
    echo  \yii\helpers\Json::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
     \Yii::$app->end();
        //return CJSON::encode(['key'=>$key,'view_pemberitahuan'=>$view_pemberitahuan]);
      //  return json_encode($key);
    }
    
    
    public function actionRegisterWasSession(){
        $key = $_POST['id_register'];
        $session = Yii::$app->session; 
        $session->remove('was_register');
        $session->set('was_register', $key); 
        $lastStatus = DugaanPelanggaran::find()->select('status')->where('id_register = :id',[":id"=>$key])->one();
    
       // $link = \mdm\admin\models\Menu::find()->select('route')->where('id = :id',[":id"=>$lastStatus->status])->one();
        
    
        return json_encode(array("key"=>$lastStatus->status,"link"=> \yii\helpers\Url::to(['dugaan-pelanggaran/update','id'=>$key])));
        \Yii::$app->end();
    }
    
    /**
     * Lists all DugaanPelanggaran models.
     * @return mixed
     */
	 
	public function actionGetwilayah(){
	$idWilayah = $_POST['id'];
	$ketWilayah = Wilayah::find()->select('keterangan')->where("id_wilayah='".$idWilayah."'")->one();
	echo $ketWilayah->keterangan;
	
	} 
    public function actionIndex()
    {
        
      
        $searchModel = new VDugaanPelanggaranIndexSearch();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
         // clear any default values
		if(isset($_GET['DugaanPelanggaranSearch'])){
                    // $searchModel->unsetAttributes(); 
                 //   $params = Yii::$app->request->post();
                  //  unset($params['_csrf']);
                  //  print_r($params);exit();
                     $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
                  //  $dataProvider = $searchModel->searchIndex($params);
                }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            
        ]);
    }

    /**
     * Displays a single DugaanPelanggaran model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new DugaanPelanggaran model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DugaanPelanggaran();
		
		$searchPegawai = new KpPegawaiSearch();
        $dataProviderPegawai = $searchPegawai->searchPegawai(Yii::$app->request->queryParams);
		
		$searchSatker = new KpInstSatkerSearch();
        $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);
		

        if ($model->load(Yii::$app->request->post())) {
			$model->tgl_dugaan = date('Y-m-d',strtotime($_POST['DugaanPelanggaran']['tgl_dugaan']));
			$model->created_ip = $_SERVER['REMOTE_ADDR'];
			$model->updated_ip = $_SERVER['REMOTE_ADDR'];
			$model->created_by = \Yii::$app->user->identity->id;
			$model->updated_by = \Yii::$app->user->identity->id;
			$model->flag = '1';
			
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
			
			if($model->save()){
			$nikPelapor = $_POST['nik'];
			for($i=0;$i<count($nikPelapor);$i++){
			$modelPelapor = new Pelapor();
			$modelPelapor->id_register = $model->id_register;
			$modelPelapor->nik = $_POST['nik'][$i];
			$modelPelapor->nama = $_POST['nama'][$i];
			$modelPelapor->tempat_lahir = $_POST['tempat_lahir'][$i];
			$modelPelapor->tgl_lahir = date('Y-m-d',strtotime($_POST['tgl_lahir'][$i]));
			$modelPelapor->alamat = $_POST['alamat'][$i];
			$modelPelapor->pendidikan = $_POST['pendidikan'][$i];
			$modelPelapor->agama = $_POST['agama'][$i];
			$modelPelapor->pekerjaan = $_POST['pekerjaan'][$i];
			$modelPelapor->keterangan = $_POST['keterangan'][$i];
			$model->flag = '1';
			$modelPelapor->save();
			}
			
			
			$nipTerlapor = $_POST['nipTerlapor'];
			for($j=0;$j<count($nipTerlapor);$j++){
			$modelTerlapor = new Terlapor();
			$modelTerlapor->id_register = $model->id_register;
			$modelTerlapor->id_h_jabatan = $_POST['idPegawai'][$j];
			$modelTerlapor->peg_nik = $_POST['peg_nik'][$j];
			$model->flag = '1';
			$modelTerlapor->save();
			}
			
			
			$idPejabatTembusan = $_POST['id_jabatan'];
			
			for($k=0;$k<count($idPejabatTembusan);$k++){
			$modelTembusan = new TembusanDugaanPelanggaran();
			$modelTembusan->id_register = $model->id_register;
			$modelTembusan->id_pejabat_tembusan = $_POST['id_jabatan'][$k];
			$modelTembusan->save();
			}
			
			
			Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Dugaan Pelanggaran Berhasil Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				$transaction->commit(); 
				return $this->redirect(['index']);	
				}
				else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Dugaan Pelanggaran Gagal Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				}
				
				} catch(Exception $e) {
                    $transaction->rollback();
				}
				
        } else {
            return $this->render('create', [
                'model' => $model,
				'searchPegawai' => $searchPegawai,
				'dataProviderPegawai' => $dataProviderPegawai,
				'searchSatker' => $searchSatker,
				'dataProviderSatker' => $dataProviderSatker,
            ]);
        }
    }

    /**
     * Updates an existing DugaanPelanggaran model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		
		$searchPegawai = new KpPegawaiSearch();
        $dataProviderPegawai = $searchPegawai->searchPegawai(Yii::$app->request->queryParams);
		
		$searchSatker = new KpInstSatkerSearch();
        $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);
		
		
		
		$pelapor = Pelapor::find()
				   ->where(['id_register'=>$id])
				   ->all();
		
		$terlapor = Terlapor::find()
				   ->where(['id_register'=>$id])
				   ->all();
		
		$tembusan = TembusanDugaanPelanggaran::find()
					->where(['id_register'=>$id])
					->all();
		
				   
        if ($model->load(Yii::$app->request->post())) {
            $model->tgl_dugaan = date('Y-m-d',strtotime($_POST['DugaanPelanggaran']['tgl_dugaan']));
			$model->updated_ip = $_SERVER['REMOTE_ADDR'];
			$model->updated_by = \Yii::$app->user->identity->id;
			$model->flag = '1';

			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
			
			if($model->save()){
			$nikPelapor = $_POST['nik'];
			Pelapor::deleteAll("id_register = '".$id."'");
			for($i=0;$i<count($nikPelapor);$i++){
			$modelPelapor = new Pelapor();
			$modelPelapor->id_register = $model->id_register;
			$modelPelapor->nik = $_POST['nik'][$i];
			$modelPelapor->nama = $_POST['nama'][$i];
			$modelPelapor->tempat_lahir = $_POST['tempat_lahir'][$i];
			$modelPelapor->tgl_lahir = date('Y-m-d',strtotime($_POST['tgl_lahir'][$i]));
			$modelPelapor->alamat = $_POST['alamat'][$i];
			$modelPelapor->pendidikan = $_POST['pendidikan'][$i];
			$modelPelapor->agama = $_POST['agama'][$i];
			$modelPelapor->pekerjaan = $_POST['pekerjaan'][$i];
			$modelPelapor->keterangan = $_POST['keterangan'][$i];
			$model->flag = '1';
			$modelPelapor->save();
			}
			
			
			$nipTerlapor = $_POST['nipTerlapor'];
			Terlapor::deleteAll("id_register = '".$id."'");
			for($j=0;$j<count($nipTerlapor);$j++){
			$modelTerlapor = new Terlapor();
			$modelTerlapor->id_register = $model->id_register;
			$modelTerlapor->id_h_jabatan = $_POST['idPegawai'][$j];
			$modelTerlapor->peg_nik = $_POST['peg_nik'][$j];
			$model->flag = '1';
			$modelTerlapor->save();
			}
			
			
			$idPejabatTembusan = $_POST['id_jabatan'];
			TembusanDugaanPelanggaran::deleteAll("id_register = '".$id."'");
			for($k=0;$k<count($idPejabatTembusan);$k++){
			$modelTembusan = new TembusanDugaanPelanggaran();
			$modelTembusan->id_register = $model->id_register;
			$modelTembusan->id_pejabat_tembusan = $_POST['id_jabatan'][$k];
			$modelTembusan->save();
			}
			
			Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Dugaan Pelanggaran Berhasil Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				$transaction->commit(); 
				return $this->redirect(['index']);	
				}
				else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Dugaan Pelanggaran Gagal Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				}
				
				} catch(Exception $e) {
                    $transaction->rollback();
				}
				
        } else {
            return $this->render('update', [
                'model' => $model,
				'searchPegawai' => $searchPegawai,
				'dataProviderPegawai' => $dataProviderPegawai,
				'searchSatker' => $searchSatker,
				'dataProviderSatker' => $dataProviderSatker,
				'pelapor'=>$pelapor,
				'terlapor'=>$terlapor,
				'tembusan'=>$tembusan,
            ]);
        }
    }

    /**
     * Deletes an existing DugaanPelanggaran model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

      public function actionDelete()
      {
        $id_register = $_POST['data'];
        $arrIdRegister = explode(',', $id_register);
        //echo count($arrIdWas16c); exit();
        for ($i = 0; $i < count($arrIdRegister); $i++) {
          if (DugaanPelanggaran::updateAll(["flag" => "3"], "id_register ='" . $arrIdRegister[$i] . "'")) {
            //TembusanWas16c::updateAll(["flag" => 1], "id_register ='" . $arrIdRegister[$i] . "'");
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
          } else {
            Yii::$app->getSession()->setFlash('success', [
              'type' => 'danger',
              'duration' => 3000,
              'icon' => 'fa fa-users',
              'message' => 'Data Gagal di Hapus',
              'title' => 'Error',
              'positonY' => 'top',
              'positonX' => 'center',
              'showProgressbar' => true,
            ]);
          }
        }
      }
    
    /**
     * Finds the DugaanPelanggaran model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DugaanPelanggaran the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DugaanPelanggaran::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
