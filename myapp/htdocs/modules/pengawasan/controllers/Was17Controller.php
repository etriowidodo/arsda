<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was17;
use app\modules\pengawasan\models\Was17Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\KpInstSatkerSearch;
use app\models\KpInstSatker;
use app\models\KpPegawai;
use app\modules\pengawasan\models\LookupItem;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\modules\pengawasan\models\TembusanWas17;
use app\modules\pengawasan\models\VWas17;
use app\modules\pengawasan\models\VTembusanWas17;
use app\modules\pengawasan\models\LWas2Terlapor;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\Was15Rencana;/*mengambil tembusan dari master*/
use app\modules\pengawasan\components\FungsiComponent;
use Odf;
use app\components\GlobalFuncComponent; 
use Nasution\Terbilang;

/**
 * Was17Controller implements the CRUD actions for Was17 model.
 */
class Was17Controller extends Controller
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
     * Lists all Was17 models.
     * @return mixed
     */
   public function actionIndex() {
    $searchModel = new Was17Search();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]); 
  //echo "ini Halaman Index";
  }

    /**
     * Displays a single Was17 model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

     public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/was_17/'.$file_upload['upload_file'];
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
     * Creates a new Was17 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
    $model = new Was17();
    $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_17','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
    $modelWas15 = Was15Rencana::findOne(["id_was15_rencana"=>$_POST['was17-was15']]);

    $connection = \Yii::$app->db;

    if ($model->load(Yii::$app->request->post())) {
        // print_r( $_POST['Was17']['nama_pegawai_terlapor']);
        // print_r( $_POST['Was17-nama_pegawai_terlapor']);
        // print_r($model->nama_pegawai_terlapor);
        // print_r($model);
        // exit();
        $model->id_sp_was2  = $modelWas15->id_sp_was2;
        $model->id_ba_was2  = $modelWas15->id_ba_was2;
        $model->id_l_was2   = $modelWas15->id_l_was2;
        $model->id_was15    = $modelWas15->id_was15;
        $model->id_terlapor = $modelWas15->id_terlapor_l_was2;
        $model->no_register = $_SESSION['was_register'];
        $model->id_tingkat  = $_SESSION['kode_tk'];
        $model->id_kejati   = $_SESSION['kode_kejati'];
        $model->id_kejari   = $_SESSION['kode_kejari'];
        $model->id_cabjari  = $_SESSION['kode_cabjari'];
     //   $model->sk          = $_POST['was17']['sk'];
        $model->created_by=\Yii::$app->user->identity->id;
        $model->created_ip=$_SERVER['REMOTE_ADDR'];
        $model->created_time=date('Y-m-d H:i:s');

      $transaction = $connection->beginTransaction();
      try {

        if ($model->save()) {
    // print_r($model->created_ip);
    // exit();

          $pejabat = $_POST['pejabat'];
         // TembusanWas2::deleteAll(['from_table'=>'Was-17','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_17),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
              for($z=0;$z<count($pejabat);$z++){
                  $saveTembusan = new TembusanWas2;
                  $saveTembusan->from_table = 'Was-17';
                  $saveTembusan->pk_in_table = strrev($model->id_was_17);
                  $saveTembusan->tembusan = $_POST['pejabat'][$z];
                  $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                  $saveTembusan->created_time = date('Y-m-d H:i:s');
                  $saveTembusan->created_by = \Yii::$app->user->identity->id;
                  // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
                  $saveTembusan->no_register = $_SESSION['was_register'];
                  $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
                  $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
                  $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
                  $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
                  $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                  $saveTembusan->id_wilayah=$_SESSION['was_id_wilayah'];
                  $saveTembusan->id_level1=$_SESSION['was_id_level1'];
                  $saveTembusan->id_level2=$_SESSION['was_id_level2'];
                  $saveTembusan->id_level3=$_SESSION['was_id_level3'];
                  $saveTembusan->id_level4=$_SESSION['was_id_level4'];
                  $saveTembusan->save();
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
         Yii::$app->getSession()->setFlash('danger', [
            'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
            'duration' => 5000, //Integer //3000 default. time for growl to fade out.
            'icon' => 'glyphicon glyphicon-ok-sign', //String
            'message' => 'Data Gagal Disimpan', // String
            'title' => 'Save', //String
            'positonY' => 'top', //String // defaults to top, allows top or bottom
            'positonX' => 'center', //String // defaults to right, allows right, center, left
            'showProgressbar' => true,
        ]);
        $transaction->roolback();
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
                  'model' => $model,
                  'modelTembusanMaster' => $modelTembusanMaster,
                  'modelwas17' => $modelwas17,

                  
      ]);
    }
  }

    /**
     * Updates an existing Was17 model.
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
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_17,'from_table'=>'Was-17','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $kp=KpPegawai::findOne(['peg_nip_baru'=>$model->nip_pegawai_terlapor]);

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
                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by = \Yii::$app->user->identity->id;
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_17/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_17/'.$OldFile);
                  }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-17','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_17),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-17';
                            $saveTembusan->pk_in_table = strrev($model->id_was_17);
                            $saveTembusan->tembusan = $_POST['pejabat'][$z];
                            $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                            $saveTembusan->created_time = date('Y-m-d H:i:s');
                            $saveTembusan->created_by = \Yii::$app->user->identity->id;
                            // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
                            $saveTembusan->no_register = $_SESSION['was_register'];
                            $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
                            $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
                            $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
                            $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
                            $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                            $saveTembusan->id_wilayah=$_SESSION['was_id_wilayah'];
                            $saveTembusan->id_level1=$_SESSION['was_id_level1'];
                            $saveTembusan->id_level2=$_SESSION['was_id_level2'];
                            $saveTembusan->id_level3=$_SESSION['was_id_level3'];
                            $saveTembusan->id_level4=$_SESSION['was_id_level4'];
                            $saveTembusan->save();
                        }

            }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_17/'.$rename_file);
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
                'modelTembusan' => $modelTembusan,
                'modelwas17'   => $modelwas17,
            ]);
        }
    }

    public function actionUpdate2($id){
      $model = Was17::findOne(array("id_was_17"=>$id, "flag"=>'1'));
      $model2 = Was17::findOne(array("id_was_17"=>$id, "flag"=>'1'));
      $model->id_was_17 = $id;
      $model->no_was_17 = "R-".$_POST["no_was_17"];
      $model->inst_satkerkd = $_POST["inst_satkerkd"];
      $model->tgl_was_17 = $_POST["Was17"]["tgl_was_17"];
      $model->sifat_surat = $_POST["Was17"]["sifat_surat"];
      $model->jml_lampiran = $_POST["Was17"]["jml_lampiran"];
      $model->kpd_was_17 = $_POST["Was17"]["kpd_was_17"];
      $model->ttd_was_17 = $_POST["Was17"]["ttd_was_17"];
      $model->ttd_peg_nik = $_POST["Was17"]["ttd_peg_nik"];
      $model->ttd_id_jabatan = $_POST["Was17"]["ttd_id_jabatan"];
      $model->perihal = $_POST["Was17"]["perihal"];
      $model->updated_ip = Yii::$app->getRequest()->getUserIP();
      
      $file = \yii\web\UploadedFile::getInstance($model,'upload_file');
      //$model->upload_file = $files->name;
      if (empty($file)) {
        $model->upload_file = $model2->upload_file;
        //echo "a".$model->upload_file; exit();
      } else {
        $model->upload_file = $file->name;
        //echo "b".$model->upload_file; exit();
      }

      $tembusan =  $_POST['id_jabatan'];
      
      $connection = \Yii::$app->db;
      $transaction = $connection->beginTransaction();
      try {
        if ($model->save()) {
          if ($files != false) {
            $path = \Yii::$app->params['uploadPath'].'was_17/'.$files->name;
            $files->saveAs($path);
          }
          
          //hapus tembusan lalu disimpan lagi 
          TembusanWas17::deleteAll('id_was_17=:del', [':del'=>$model->id_was_17]); 
          for($i=0;$i<count($tembusan);$i++){
            $saveTembusan = new TembusanWas17(); 
            $saveTembusan->id_was_17 = $model->id_was_17; 
            $saveTembusan->id_pejabat_tembusan = $tembusan[$i]; 
            $saveTembusan->save(); 
          }
          
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
        }
        $transaction->commit();
        
        return $this->redirect(['create']);
      } catch (Exception $e) {
        $transaction->rollback();
      }
    }
    
    /**
     * Deletes an existing Was17 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */

     public function actionDelete() {
     $id_was_17 = $_POST['id'];
     $jumlah = $_POST['jml'];
     
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_was_17);
           // echo $pecah[$i];
          //  $this->findModel($pecah[$i])->delete();
            Was17::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_17'=>$pecah[$i]]);
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

    public function actionDelete_old()
    {
      $id_was_17 = $_POST['data'];
      $arrIdWas17 = explode(',', $id_was_17);


      for ($i = 0; $i < count($arrIdWas17); $i++) {

        if (Was17::updateAll(["flag" => 3], "id_was_17 ='" . $arrIdWas17[$i] . "'")) {
          TembusanWas17::updateAll(["flag" => 3], "id_was_17 ='" . $arrIdWas17[$i] . "'");
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
          return $this->redirect(['create']);
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
     * Finds the Was17 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was17 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel($id)
    {
        if (($model = Was17::findOne(['id_was_17'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        
        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_17,'from_table'=>'Was-17',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();

        $modelLwas2=LWas2Terlapor::findOne(['nip_terlapor'=>$model->nip_pegawai_terlapor,
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $connection = \Yii::$app->db;
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $query="select * FROM  was.ms_sk where kode_sk='".$model['sk']."'";
        $modelSk = $connection->createCommand($query)->queryOne();
        $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_17']);

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tanggal'=>$tanggal,
                                'modelTembusan'=>$modelTembusan,
                                'modelSk'=>$modelSk,
                                'modelLwas2'=>$modelLwas2,
                                ]);
      
    }
 
    public function actionCetak_odf($id)
    {
        $odf = new Odf(Yii::$app->params['reportPengawasan']."was_17.odt");

        $was_17 = VWas17::find()->where("id_was_17='".$id."'")->one();
        //var_dump($was_17); exit();
        
        $tembusan = VTembusanWas17::find()->where("id_was_17='".$id."'")->all();
          
        $odf->setVars('no_was_17', $was_17->no_was_17);
        $odf->setVars('kpd_was_17', $was_17->kpd);
        $odf->setVars('ttd_dari', $was_17->dari);
        //$odf->setVars('perihal', $was_17->perihal);
        $odf->setVars('tgl_was_17', GlobalFuncComponent::tglToWord($was_17->tgl_was_17));
        $odf->setVars('kejaksaan', $was_17->kejaksaan);
        $odf->setVars('sifat', $was_17->sifat);
        
        //jumlah lampiran
        if($was_17->jml_lampiran != ''){
          $terbilang = new Terbilang();
          $ini = $was_17->jml_lampiran." (".$terbilang->convert($was_17->jml_lampiran).")";
          $odf->setVars('jml_lampiran', $ini);
        }else{$odf->setVars('jml_lampiran', "-"); }
        
        $odf->setVars('nama_terlapor', $was_17->nama);
        $odf->setVars('nrp_terlapor', $was_17->nrp_terlapor);
        $odf->setVars('nip_terlapor', $was_17->nip);
        $odf->setVars('jabatan_terlapor', $was_17->jabatan);
        $odf->setVars('bentuk_hukuman', $was_17->bentuk_hukuman);
        $odf->setVars('pelanggaran_disiplin',  $was_17->dugaan_pelanggaran);
        $odf->setVars('ttd_jabatan', $was_17->ttd_jabatan);
        $odf->setVars('ttd_peg_nama', $was_17->ttd_peg_nama);
        $odf->setVars('ttd_peg_nip', $was_17->ttd_peg_nip);
        $odf->setVars('perihal', $was_17->perihal);
        
        /*$odf->setVars('surat', "SP-WAS-2");
        $odf->setVars('nomor_surat',  $was_17->no_surat_dinas);
        $odf->setVars('tanggal',  GlobalFuncComponent::tglToWord($was_17->tanggal_surat_dinas));
        $isi_hukuman_disiplin = $was_17->keterangan.' '.$was_17->aturan_hukum.' / '.$was_17->aturan_hukum. ' ';
        $odf->setVars('isi_hukuman_disiplin', $isi_hukuman_disiplin);
        
         $odf->setVars('tempat', $was_17->tempat);*/
        #tembusan
        $dft_tembusan = $odf->setSegment('tembusan');
	$i=1;
        foreach($tembusan as $element){
            $dft_tembusan->urutan_tembusan($i);
            $dft_tembusan->jabatan_tembusan($element['jabatan']);
            $dft_tembusan->merge();
            $i++;
        }
       
        $odf->mergeSegment($dft_tembusan);
        
        $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister"=>$was_17->id_register])->asArray()->one();
        $odf->exportAsAttachedFile("WAS17 - ".$dugaan['terlapor'].".odt");
    }
}
