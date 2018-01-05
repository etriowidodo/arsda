<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas9;
use app\modules\pengawasan\models\BaWas9Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query; 
use app\modules\pengawasan\models\Was16b;

use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\LookupItem;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\VTerlapor;
use app\modules\pengawasan\components\FungsiComponent; 
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\components\ConstSysMenuComponent;

use Odf;


/**
 * BaWas9Controller implements the CRUD actions for BaWas9 model.
 */
class BaWas9Controller extends Controller
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
     * Lists all BaWas9 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $model = new BaWas9();
		$session = Yii::$app->session;
        $searchModel = new BaWas9Search();
        
		$searchSatker = new KpInstSatkerSearch();
        $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);		
		$dataProvider = $searchModel->searchBawas9($session->get('was_register'));
		/* print_r($session->get('was_register'));
		exit(); */
        return $this->render('index', [
			'model' => $model,
			/* 'id_register' => $session->get('was_register'),
            'searchModel' => $searchModel,
			'searchSatker' => $searchSatker,
			'dataProviderSatker' => $dataProviderSatker, */
			'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BaWas9 model.
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
     * Creates a new BaWas9 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
       	$model = new BaWas9();
       	$idwas16b		= Was16b::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah']]);

        if ($model->load(Yii::$app->request->post())) {
           
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	$model->id_tingkat 	= $idwas16b['id_tingkat'];
				$model->id_kejati 	= $idwas16b['id_kejati'];
				$model->id_kejari 	= $idwas16b['id_kejari'];
				$model->id_cabjari 	= $idwas16b['id_cabjari'];
				$model->no_register = $idwas16b['no_register'];
				$model->id_sp_was2 	= $idwas16b['id_sp_was2'];
				$model->id_ba_was2 	= $idwas16b['id_ba_was2'];
				$model->id_l_was2 	= $idwas16b['id_l_was2'];
				$model->id_was15	= $idwas16b['id_was15']; 
				/*$model->id_wilayah 	= $idwas16b['id_wilayah'];
				$model->id_level1 	= $idwas16b['id_level1'];
				$model->id_level2	= $idwas16b['id_level2'];
				$model->id_level3 	= $idwas16b['id_level3'];
				$model->id_level4 	= $idwas16b['id_level4'];*/
				//$model->id_ba_was_9	= 1;  
				$model->created_ip 	= $_SERVER['REMOTE_ADDR'];
				$model->created_time=date('Y-m-d h:i:sa');
				$model->created_by 	= \Yii::$app->user->identity->id;
				
			if($model->save()){

				$arr = array(ConstSysMenuComponent::Skwas4e, ConstSysMenuComponent::Skwas4d);
                  	for ($i=0; $i < 2 ; $i++) { 
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
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
                      //print_r($modelTrxPemrosesan);
                      //exit();
                      $modelTrxPemrosesan->save();
                      // }
                    }
				 
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was9 Berhasil Disimpan',
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
				 'type' => 'danger',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was9 Gagal Disimpan',
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
     * Updates an existing BaWas9 model.
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
		$session = Yii::$app->session;
		$oldFile = $model->upload_file;
		
		$connection = \Yii::$app->db;
       	$model = $this->findModel($id);
       	$fungsi=new FungsiComponent();
       	$is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/
       	$OldFile=$model->upload_file;

        if ($model->load(Yii::$app->request->post())) {
            $errors       = array();
            $file_name    = $_FILES['upload_file']['name'];
           	$file_size    =$_FILES['upload_file']['size'];
            $file_tmp     =$_FILES['upload_file']['tmp_name'];
            $file_type    =$_FILES['upload_file']['type'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $tmp = explode('.', $_FILES['upload_file']['name']);
            $file_exists  = end($tmp);
           	$rename_file  = $is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].'_'.$res.'.'.$ext;
			//ip address & user_id//
			$model->upload_file=($file_name==''?$OldFile:$rename_file);
			$model->updated_ip = $_SERVER['REMOTE_ADDR'];
			$model->updated_by = \Yii::$app->user->identity->id;
			
			 
			
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
			if($model->save()){
				
				if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_9/'.$OldFile)) {
                  	unlink(\Yii::$app->params['uploadPath'].'ba_was_9/'.$OldFile);
              	}

              	$arr = array(ConstSysMenuComponent::Skwas4e, ConstSysMenuComponent::Skwas4d);
                  	for ($i=0; $i < 2 ; $i++) { 
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
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
                      //print_r($modelTrxPemrosesan);
                      //exit();
                      $modelTrxPemrosesan->save();
                      // }
                    }
				 
		
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was9 Berhasil Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);

				move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_9/'.$rename_file);
				$transaction->commit();
				  
				return $this->redirect(['index']);	
				}
				else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Ba-Was6 Gagal Disimpan',
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
				
				
           
   //      } else if (Yii::$app->request->isAjax) {
            
			// $queryTerlapor = new Query;
			// 				$queryTerlapor->select(["CONCAT(a.peg_nip, ' - ', a.peg_nama) AS terlapor", "a.id_terlapor"])
   //                                  ->from('was.v_terlapor a')
   //                                  ->where("a.id_register= :id_register", [':id_register' => $session->get('was_register')]);
   //                          $terlapor = $queryTerlapor->all();
							
   //          return $this->renderAjax('_form', [
   //              'model' 	=> $model,
   //              'terlapor' 	=> $terlapor,
   //          ]);
   //      }
		
  	// 	return $this->render('update', [
  	// 		'model' => $model, 
  	// 	]);
   //  }

    public function actionViewpdf($id){ 
        $file_upload=$this->findModel($id); 
        $filepath = '../modules/pengawasan/upload_file/ba_was_9/'.$file_upload['upload_file'];
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

    /**
     * Deletes an existing BaWas9 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete(){
		$id=$_POST['id'];
		 
		$jml=$_POST['jml'];
		// echo $jml;
		for ($i=0; $i < $jml; $i++) { 
		$pecah=explode(',', $id);
		BaWas9::deleteAll(['id_ba_was_9'=>$pecah[$i],'no_register'=>$_SESSION['was_register'],
					  'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
					  'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
					  'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
					  'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
					  'id_level4'=>$_SESSION['was_id_level4']]);
		}
		return $this->redirect(['index']);
    }

    public function actionCetak($id){
		$noreg			= $_SESSION['was_register'];
		$model			= $this->findModel($id);
		$data_satker 	= KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
	   	 
		$conection = \yii::$app->db;
		$sql = "select*from was.ba_was_7 a inner join was.was_15_rencana b
											on a.nip_terlapor=b.nip_terlapor and
											a.no_register=b.no_register and
											a.id_tingkat=b.id_tingkat and
											a.id_kejati=b.id_kejati and
											a.id_kejari=b.id_kejari and
											a.id_cabjari=b.id_cabjari and
											a.id_wilayah=b.id_wilayah and
											a.id_level1=b.id_level1 and
											a.id_level2=b.id_level2 and
											a.id_level3=b.id_level3 and
											a.id_level4=b.id_level4 and
											b.saran_dari='Jamwas'
											where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' 
											and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'  
											and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' 
											and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."' 
											";
		$ba_was_7 = $conection->createCommand($sql)->queryOne();
		
											 
											 
	   	 
		return $this->render('cetak',[
				'model'=>$model,
				'data_satker'=>$data_satker,   
				'ba_was_7'=>$ba_was_7,   
		]);
     
    }
    
    /**
     * Finds the BaWas9 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas9 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BaWas9::findOne(['id_ba_was_9'=>$id,'no_register'=>$_SESSION['was_register'],
					  'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
					  'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
					  'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
					  'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
					  'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
