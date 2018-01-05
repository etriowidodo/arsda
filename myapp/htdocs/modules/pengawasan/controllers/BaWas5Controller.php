<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas5;
use app\modules\pengawasan\models\BaWas5Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

use app\modules\pengawasan\models\SaksiInternal;
use app\modules\pengawasan\models\VSpWas2;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\VTerlapor;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\components\FungsiComponent;
use app\components\ConstSysMenuComponent;

use Odf;


/**
 * BaWas5Controller implements the CRUD actions for BaWas5 model.
 */
class BaWas5Controller extends Controller
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

	
	public function actionIndex()
    {
        $model = new BaWas5();
        $modelSearch = new BaWas5Search();
        
        $dataProvider = $modelSearch->search(Yii::$app->request->queryParams);		
		// $dataBaWas5 = $searchModel->searchBawas5($session->get('was_register'));
		
		

        return $this->render('index',[
        					'dataProvider'=>$dataProvider
        					]);
    }

 

    /**
     * Displays a single BaWas5 model.
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
     * Creates a new BaWas5 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaWas5();
        $searchModel = new BaWas5Search();
				
        if ($model->load(Yii::$app->request->post())) {
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	$model->created_ip = $_SERVER['REMOTE_ADDR'];
	            $model->created_time = date('Y-m-d H:i:s');
	            $model->created_by = \Yii::$app->user->identity->id;
	            $model->id_tingkat = $_SESSION['kode_tk'];
	            $model->id_kejati = $_SESSION['kode_kejati'];
	            $model->id_kejari = $_SESSION['kode_kejari'];
	            $model->id_cabjari = $_SESSION['kode_cabjari'];
	            $model->no_register = $_SESSION['was_register'];
	            // $model->tanggal_sk = $_POST['tanggal_sk'];
			if($model->save()){

				      $arr = array(ConstSysMenuComponent::Was19b);
                  for ($i=0; $i < 1 ; $i++) { 
                    WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                    $modelTrxPemrosesan=new WasTrxPemrosesan();
                    $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                    $modelTrxPemrosesan->id_sys_menu=$arr[$i];
                    $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                    $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                    $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                    $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                    $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                    $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                    $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                    $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                    $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                    $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                    $modelTrxPemrosesan->save();
                    // }
                  }
				
		
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was5 Berhasil Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				$transaction->commit(); 
				return $this->redirect(['index']);	
			}else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was5 Gagal Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				return $this->redirect(['index']);	
			}
				
				} catch(Exception $e) {
                    $transaction->rollback();
				}

		}else{
            return $this->render('create', [
                'model' => $model,
				
            ]);
        
		}
    }

    /**
     * Updates an existing BaWas5 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $model = $this->findModel($id);
        $fungsi=new FungsiComponent();
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
		

		$OldFile = $model->upload_file;
		
        if ($model->load(Yii::$app->request->post())) {

        	  $errors       = array();
              $file_name    = $_FILES['upload_file']['name'];
              $file_size    = $_FILES['upload_file']['size'];
              $file_tmp     = $_FILES['upload_file']['tmp_name'];
              $file_type    = $_FILES['upload_file']['type'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $tmp = explode('.', $_FILES['upload_file']['name']);
              $file_exists  = end($tmp);
              $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;

			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	$model->updated_ip = $_SERVER['REMOTE_ADDR'];
      				$model->updated_time = date('Y-m-d H:i:s');
      				$model->updated_by = \Yii::$app->user->identity->id;
      				$model->upload_file = ($file_name==''?$OldFile:$rename_file);
      				// $model->tanggal_sk = $_POST['tanggal_sk'];
			if($model->save()){
				
				if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_5/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'ba_was_5/'.$OldFile);
                  }
                $arr = array(ConstSysMenuComponent::Was19b);
                  for ($i=0; $i < 1 ; $i++) { 
                    WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
                    $modelTrxPemrosesan=new WasTrxPemrosesan();
                    $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                    $modelTrxPemrosesan->id_sys_menu=$arr[$i];
                    $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                    $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                    $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                    $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                    $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                    $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                    $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                    $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                    $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                    $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                    $modelTrxPemrosesan->save();
                    // }
                  }
				
				move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_5/'.$rename_file);
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was5 Berhasil Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				$transaction->commit(); 
				return $this->redirect(['index']);	
			}else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was5 Gagal Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				return $this->redirect(['index']);	
				}
				
				} catch(Exception $e) {
                    $transaction->rollback();
				}
				
				
           
        } else{
    
							
            return $this->render('update', [
                'model' => $model,
               
            ]);
        }
    }

    /**
     * Deletes an existing BaWas5 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
     public function actionDelete() {
     $ba_was_5 = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $ba_was_5);
            BaWas5::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_ba_was_5'=>$pecah[$i]]);
         }

      Yii::$app->getSession()->setFlash('success', [
          'type' => 'success',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Berhasil Dihapus',
          'title' => 'Hapus Data',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    
      return $this->redirect(['index']);
  }

    public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/ba_was_5/'.$file_upload['upload_file'];
        $extention=explode(".", $file_upload['upload_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['upload_file'] . '"');
              header('Content-Transfer-Encoding: binary');
              header('Content-Length: ' . filesize($filepath));
              header('Accept-Ranges: bytes');

              // Render the file
              readfile($filepath);
          }
          else
          {
             // PDF doesn't exist so throw an error or something
          }
      }
      
    }

         public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
      //   $modelwas2=SpWas2::findOne(['id_sp_was2'=>$model->id_sp_was2,'no_register'=>$_SESSION['was_register'],
      //                       'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
      //                       'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
      //                       'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
      //                       'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
      //                       'id_level4'=>$_SESSION['was_id_level4']]);

      //    $modelLapdu=lapdu::findOne(['no_register'=>$_SESSION['was_register'],
      //                       'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
      //                       'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query="select *from was.ms_sk a inner join was.ms_category_sk b on a.kode_category=b.kode_category where a.kode_sk='".$model['sk']."'";
        $modelSk = $connection->createCommand($query)->queryOne();
      //   // print_r($modelSk);
      //   // exit();
         

      //   $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_7']);
      //   $tanggalSpwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas2['tanggal_sp_was2']);
      // //  $tanggalWas15=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas15['tgl_was15']);
      //   $hari=\Yii::$app->globalfunc->GetNamaHari($model['tgl_ba_was_7']);
       // print_r($modelwas2);
         // print_r($modelLapdu);
         // // print_r($modelwas15);
         // exit();

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                // 'tgl'=>$tanggal,
                                // 'hari'=>$hari,
                                // 'modelwas2'=>$modelwas2,
                                // 'tanggalSpwas2'=>$tanggalSpwas2,
                                // 'modelLapdu'=>$modelLapdu,
                                'modelSk'=>$modelSk,
                                ]);
      
    }

    /**
     * Finds the BaWas5 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas5 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BaWas5::findOne(['id_ba_was_5'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
