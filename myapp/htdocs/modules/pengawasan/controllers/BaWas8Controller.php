<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas8;
use app\modules\pengawasan\models\BaWas7;
use app\modules\pengawasan\models\Was16b;
use app\modules\pengawasan\models\BaWas8Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\components\FungsiComponent; 
use yii\db\Query;
use app\components\ConstSysMenuComponent;


use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
//use app\modules\pengawasan\models\LookupItem;
//use app\modules\pengawasan\models\VTerlapor;
//use app\modules\pengawasan\models\VRiwayatJabatan;

use Odf;
use yii\grid\GridView;
use yii\widgets\Pjax;



/**
 * BaWas8Controller implements the CRUD actions for BaWas8 model.
 */
class BaWas8Controller extends Controller
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
     * Lists all BaWas8 models.
     * @return mixed
     */
    public function actionIndex()
    {  
        $searchModel = new BaWas8Search();
         		
		$dataProvider = $searchModel->searchBawas8();
 
        return $this->render('index', [
			'dataProvider' => $dataProvider,
			
        ]);
    }

    /**
     * Displays a single BaWas8 model.
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
     * Creates a new BaWas8 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaWas8();
		$idbawas16b		= Was16b::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah']]);

        if ($model->load(Yii::$app->request->post())) {
           
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
				$model->id_tingkat 	= $_SESSION['kode_tk'];
				$model->id_kejati 	= $_SESSION['kode_kejati'];
				$model->id_kejari 	= $_SESSION['kode_kejari'];
				$model->id_cabjari 	= $_SESSION['kode_cabjari'];
				$model->no_register	= $_SESSION['was_register'];
				$model->id_sp_was2 	= $idbawas16b['id_sp_was2'];
				$model->id_ba_was2	= $idbawas16b['id_ba_was2'];
				$model->id_was15	= $idbawas16b['id_was15'];
				$model->id_l_was2	= $idbawas16b['id_l_was2'];
				$model->created_ip 	= $_SERVER['REMOTE_ADDR'];
				$model->created_time =date('Y-m-d h:i:sa');
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
				 'message' => 'Data Ba-Was6 Berhasil Disimpan',
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

		}else{
			return $this->render('create', [
                'model' => $model,
               
            ]);
        
		}
    }

    /**
     * Updates an existing BaWas8 model.
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
				if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_8/'.$OldFile)) {
                  	unlink(\Yii::$app->params['uploadPath'].'ba_was_8/'.$OldFile);
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
				 'message' => 'Data Ba-Was6 Berhasil Disimpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);

				move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_8/'.$rename_file);
				$transaction->commit();
				 
				return $this->redirect(['index']);	
				}else{
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
       //       else if (Yii::$app->request->isAjax) {
            
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
		
		

    public function actionViewpdf($id){ 
        $file_upload=$this->findModel($id); 
        $filepath = '../modules/pengawasan/upload_file/ba_was_8/'.$file_upload['upload_file'];
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
     * Deletes an existing BaWas8 model.
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
		BaWas8::deleteAll(['id_ba_was_8'=>$pecah[$i],'no_register'=>$_SESSION['was_register'],
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


public function actionGetttd(){
       
   $searchModelbawas8penerima = new BaWas8Search();
   $dataProviderPenerima = $searchModelbawas8penerima->searchPenerima(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenerima-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenerima','enablePushState' => false]); 
   echo GridView::widget([
                        'dataProvider'=> $dataProviderPenerima,
                        // 'filterModel' => $searchModel,
                        // 'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['header'=>'No',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'contentOptions'=>['style'=>'text-align:center;'],
                            'header'=>'No',
                            'class' => 'yii\grid\SerialColumn'],
                            
                            
                            // ['label'=>'No Surat',
                            //     'headerOptions'=>['style'=>'text-align:center;'],
                            //     'attribute'=>'id_surat',
                            // ],

                            ['label'=>'Nip',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'peg_nip_baru',
                            ],


                            ['label'=>'Nama Penandatangan',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nama',
                            ],

                            ['label'=>'Jabatan',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'jabatan',
                            ],

                            /* ['label'=>'Jabatan Sebenarnya',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'jabtan_asli',
                            ], */

                         ['class' => 'yii\grid\CheckboxColumn',
                         'headerOptions'=>['style'=>'text-align:center'],
                         'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                   'checkboxOptions' => function ($data) {
                                    $result=json_encode($data);
                                    return ['value' => $data['id_surat'],'class'=>'selection_one','json'=>$result];
                                    },
                            ],
                            
                         ],   

                    ]); 
          Pjax::end();
          echo '<div class="modal-loading-new"></div>';
    }

    /**
     * Finds the BaWas8 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas8 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BaWas8::findOne(['no_register'=>$_SESSION['was_register'],'id_ba_was_8'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
