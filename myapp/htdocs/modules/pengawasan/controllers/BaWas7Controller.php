<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas7;
use app\modules\pengawasan\models\BaWas7Search;
use app\modules\pengawasan\models\Was16b;
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\lapdu;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

use app\components\GlobalFuncComponent;
use app\modules\pengawasan\components\FungsiComponent;

use app\modules\pengawasan\models\SaksiInternal;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\VSpWas2;
use app\components\ConstSysMenuComponent;
use app\models\KpPegawai;

use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\VTerlapor;
use app\modules\pengawasan\models\VRiwayatJabatan;

use Odf;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * BaWas7Controller implements the CRUD actions for BaWas7 model.
 */
class BaWas7Controller extends Controller
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

     public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        $modelwas2=SpWas2::findOne(['id_sp_was2'=>$model->id_sp_was2,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4']]);

         $modelLapdu=lapdu::findOne(['no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query="select a.*,b.* from was.ba_was_7 a inner join was.ms_sk b
    	 		on a.sk=b.kode_sk where  
                a.id_ba_was_7='".$model->id_ba_was_7."'";
        $modelSk = $connection->createCommand($query)->queryOne();
        // print_r($modelSk);
        // exit();
         

        $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_7']);
        $tanggalSpwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas2['tanggal_sp_was2']);
      //  $tanggalWas15=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas15['tgl_was15']);
        $hari=\Yii::$app->globalfunc->GetNamaHari($model['tgl_ba_was_7']);
       // print_r($modelwas2);
         // print_r($modelLapdu);
         // // print_r($modelwas15);
         // exit();

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tgl'=>$tanggal,
                                'hari'=>$hari,
                                'modelwas2'=>$modelwas2,
                                'tanggalSpwas2'=>$tanggalSpwas2,
                                'modelLapdu'=>$modelLapdu,
                                'modelSk'=>$modelSk,
                                ]);
      
    }



	
    /**
     * Lists all BaWas7 models.
     * @return mixed
     */
  //   public function actionIndex() {
	 //     $searchModel = new Was16bSearch();
	 //    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

	 //    return $this->render('index', [
	 //                'searchModel' => $searchModel,
	 //                'dataProvider' => $dataProvider,
	 //    ]); 
		// //echo "ini Halaman Index";
	 //  }

    public function actionIndex()
    {
        $model = new BaWas7();
		    $session = Yii::$app->session;
        $searchModel = new BaWas7Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
		// $searchSatker = new KpInstSatkerSearch();
  //       $dataProviderSatker = $searchSatker->searchSatker(Yii::$app->request->queryParams);		
		// $dataBaWas7 = $searchModel->searchBawas7($session->get('was_register'));
		// $dataInternal = $searchModel->searchInternal($session->get('was_register'));

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BaWas7 model.
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
     * Creates a new BaWas7 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaWas7();
	  //  $modelwas16b=Was16Bisi::findAll(['id_was_16b'=>$model->id_was_16b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
	    $modelWas16 = Was16b::findOne(["id_was_16b"=>$_POST['bawas7-idwas16']]);
	    // print_r($modelWas16);
	    // exit();
    $connection = \Yii::$app->db;

    if ($model->load(Yii::$app->request->post())) {
        // print_r( $_POST['Was16b']['nama_pegawai_terlapor']);
        // print_r( $_POST['Was16b-nama_pegawai_terlapor']);
        // print_r($model->nama_pegawai_terlapor);
        // print_r($model);
        // exit();
        $model->id_sp_was2  = $modelWas16->id_sp_was2;
        $model->id_ba_was2  = $modelWas16->id_ba_was2;
        $model->id_l_was2   = $modelWas16->id_l_was2;
        $model->id_was15    = $modelWas16->id_was15;
        $model->id_was_16b  = $modelWas16->id_was_16b;
        $model->no_register = $_SESSION['was_register'];
        $model->id_tingkat  = $_SESSION['kode_tk'];
        $model->id_kejati   = $_SESSION['kode_kejati'];
        $model->id_kejari   = $_SESSION['kode_kejari'];
        $model->id_cabjari  = $_SESSION['kode_cabjari'];
        $model->created_by=\Yii::$app->user->identity->id;
        $model->created_ip=$_SERVER['REMOTE_ADDR'];
        $model->created_time=date('Y-m-d H:i:s');

        $kp=KpPegawai::findOne(['peg_nip_baru'=>$model->nip_terlapor]);

      $transaction = $connection->beginTransaction();
      try {

        if ($model->save()) {

          if($kp['pns_jnsjbtfungsi'] == '1'){
                $arr = array(ConstSysMenuComponent::Bawas9);
              }else if($kp['pns_jnsjbtfungsi'] == '0'){
                $arr = array(ConstSysMenuComponent::Bawas8);
              }  
            // $arr = array(ConstSysMenuComponent::Bawas8);
                    for ($i=0; $i < 1 ; $i++) { 
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
         

        }
        $transaction->commit();
//          $error = \yii\widgets\ActiveForm::validate($model);
//          print_r($error);
//          exit();
        $model->validate();
        $model->save();
        Yii::$app->getSession()->setFlash('success', [
            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
            'duration' => 5000, //Integer //3000 default. time for growl to fade out.
            'icon' => 'glyphicon glyphicon-ok-sign', //String
            'message' => 'Data Berhasil Disimpan', // String
            'title' => 'Save', //String
            'positonY' => 'top', //String // defaults to top, allows top or bottom
            'positonX' => 'center', //String // defaults to right, allows right, center, left
            'showProgressbar' => true,
        ]);
      } catch (Exception $e) {
        $transaction->roolback();
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
                  'model' => $model,
      ]);
    }
  }
	

    /**
     * Updates an existing BaWas7 model.
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
        // print_r($model);
        // exit();
        $fungsi=new FungsiComponent();
      //  $modelwas16b=Was16b::findAll(['id_was_16b'=>$model->id_was_16b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelWas16 = Was16b::findOne(["id_was_16b"=>$_POST['bawas7-idwas16']]);

         $is_inspektur_irmud_riksa=$fungsi->gabung_where();
         $OldFile=$model->upload_file;

        if ($model->load(Yii::$app->request->post())){

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
                $model->upload_file=($file_name==''?$OldFile:$rename_file);
                $model->id_sp_was2  = $modelWas16->id_sp_was2;
		        $model->id_ba_was2  = $modelWas16->id_ba_was2;
		        $model->id_l_was2   = $modelWas16->id_l_was2;
		        $model->id_was15    = $modelWas16->id_was15;
		        $model->id_was_16b  = $modelWas16->id_was_16b;
		        $model->no_register = $_SESSION['was_register'];
		        $model->id_tingkat  = $_SESSION['kode_tk'];
		        $model->id_kejati   = $_SESSION['kode_kejati'];
		        $model->id_kejari   = $_SESSION['kode_kejari'];
		        $model->id_cabjari  = $_SESSION['kode_cabjari'];
		        $model->created_by=\Yii::$app->user->identity->id;
		        $model->created_ip=$_SERVER['REMOTE_ADDR'];
		        $model->created_time=date('Y-m-d H:i:s');
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_7/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'ba_was_7/'.$OldFile);
                  }

                  $arr = array(ConstSysMenuComponent::Bawas8);
                    for ($i=0; $i < 1 ; $i++) { 
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

            }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_7/'.$rename_file);
            $transaction->commit();

            $model->validate();
	        $model->save();
	        Yii::$app->getSession()->setFlash('success', [
	            'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
	            'duration' => 5000, //Integer //3000 default. time for growl to fade out.
	            'icon' => 'glyphicon glyphicon-ok-sign', //String
	            'message' => 'Data Berhasil Disimpan', // String
	            'title' => 'Save', //String
	            'positonY' => 'top', //String // defaults to top, allows top or bottom
	            'positonX' => 'center', //String // defaults to right, allows right, center, left
	            'showProgressbar' => true,
	        ]);

            } catch (Exception $e) {
                $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
                //'modelTembusan' => $modelTembusan,
                'modelwas16b'   => $modelwas16b,
            ]);
        }
    }

    /**
     * Deletes an existing BaWas7 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
     $ba_was_7 = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $ba_was_7);
            BaWas7::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_ba_was_7'=>$pecah[$i]]);
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

    public function actionDeleteOld()
    {
        $id_ba_was_7 = $_POST['data'];
		$arrIdBaWas7 = explode(',',$id_ba_was_7);	
		$session = Yii::$app->session;		
		
		$connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {	
        for($i=0;$i<count($arrIdBaWas7);$i++){
            
			if(BaWas7::updateAll(["flag" => '3'], "id_ba_was_7 ='".$arrIdBaWas7[$i]."'")){
			SaksiInternal::updateAll(["flag" => '3'], "id_register ='".$session->get('was_register')."' and ba_was_7=1");
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
			}
			else{
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
		$transaction->commit(); 
		} catch(Exception $e) {
            $transaction->rollback();
		}
        return $this->redirect(['index']);
    }

    public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/ba_was_7/'.$file_upload['upload_file'];
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

    public function actionGetttd1(){
       
   $searchModelSaksi = new BaWas7Search();
   $dataProviderBawas7 = $searchModelSaksi->searchBawas7Saksi1(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Msaksi-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormSaksi','enablePushState' => false]); 
   echo GridView::widget([
                        'dataProvider'=> $dataProviderBawas7,
                        // 'filterModel' => $searchModel,
                        // 'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['header'=>'No',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'contentOptions'=>['style'=>'text-align:center;'],
                            'class' => 'yii\grid\SerialColumn'],
                            
                            
                            ['label'=>'Nip / Nrp',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nip_nrp',
                            ],
                            ['label'=>'Nama Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nama',
                            ],
                            ['label'=>'Golongan Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'gol_kd',
                            ],
                            ['label'=>'Pangkat Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'gol_pangkat2',
                            ],
                            ['label'=>'Jabatan Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'jabatan',
                            ],
                            ['class' => 'yii\grid\CheckboxColumn',
                             'headerOptions'=>['style'=>'text-align:center'],
                             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                       'checkboxOptions' => function ($data) {
                                        $result=json_encode($data);
                                        return ['value' => $data['peg_nip_baru'],'class'=>'selection_saksi1','json'=>$result];
                                        },
                                ],


                         ],   

                    ]);
          Pjax::end();
          echo '<div class="modal-loading-new"></div>';
    }

    public function actionGetttd2(){
       
   $searchModelSaksi = new BaWas7Search();
   $dataProviderBawas7 = $searchModelSaksi->searchBawas7Saksi2(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Msaksi-tambah-grid2', 'timeout' => false,'formSelector' => '#searchFormSaksi','enablePushState' => false]); 
   echo GridView::widget([
                      'dataProvider'=> $dataProviderBawas7,
                      // 'filterModel' => $searchModel,
                      // 'layout' => "{items}\n{pager}",
                      'columns' => [
                          ['header'=>'No',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['style'=>'text-align:center;'],
                          'class' => 'yii\grid\SerialColumn'],
                          
                          
                          ['label'=>'Nip / Nrp',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'nip_nrp',
                          ],
                          ['label'=>'Nama Saksi',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'nama',
                          ],
                          ['label'=>'Golongan Saksi',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'gol_kd',
                          ],
                          ['label'=>'Pangkat Saksi',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'gol_pangkat2',
                          ],
                          ['label'=>'Jabatan Saksi',
                              'headerOptions'=>['style'=>'text-align:center;'],
                              'attribute'=>'jabatan',
                          ],
                          ['class' => 'yii\grid\CheckboxColumn',
                           'headerOptions'=>['style'=>'text-align:center'],
                           'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                     'checkboxOptions' => function ($data) {
                                      $result=json_encode($data);
                                      return ['value' => $data['peg_nip_baru'],'class'=>'selection_saksi2','json'=>$result];
                                      },
                              ],


                       ],   

                  ]);
          echo '<div class="modal-loading-new"></div>';
    }

    public function actionGetttd3(){
       
   $searchModelSaksi = new BaWas7Search();
   $dataProviderBawas7 = $searchModelSaksi->searchBawas7Petugas(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpetugas-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormTerlapor','enablePushState' => false]); 
   echo GridView::widget([
                        'dataProvider'=> $dataProviderBawas7,
                        // 'filterModel' => $searchModel,
                        // 'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['header'=>'No',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'contentOptions'=>['style'=>'text-align:center;'],
                            'class' => 'yii\grid\SerialColumn'],
                            
                            
                            ['label'=>'Nip / Nrp',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nip_nrp',
                            ],
                            ['label'=>'Nama Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nama',
                            ],
                            ['label'=>'Golongan Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'gol_kd',
                            ],
                            ['label'=>'Pangkat Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'gol_pangkat2',
                            ],
                            ['label'=>'Jabatan Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'jabatan',
                            ],
                            ['class' => 'yii\grid\CheckboxColumn',
                             'headerOptions'=>['style'=>'text-align:center'],
                             'contentOptions'=>['style'=>'text-align:center; width:5%'],
                                       'checkboxOptions' => function ($data) {
                                        $result=json_encode($data);
                                        return ['value' => $data['peg_nip_baru'],'class'=>'selection_petugas','json'=>$result];
                                        },
                                ],


                         ],   

                    ]);
          Pjax::end();
          echo '<div class="modal-loading-new"></div>';
    }

    /**
     * Finds the BaWas7 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas7 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	if (($model = BaWas7::findOne(['id_ba_was_7'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {	
      //  if (($model = BaWas7::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
