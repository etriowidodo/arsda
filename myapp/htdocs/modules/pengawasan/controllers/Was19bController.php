<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was19b;
use app\modules\pengawasan\models\Was19bIsi;
use app\modules\pengawasan\models\Was19bSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\BaWas5;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\TembusanWas2;
use app\modules\pengawasan\components\FungsiComponent;
use app\models\KpInstSatkerSearch;
use yii\helpers\Json;
use Nasution\Terbilang;
use yii\db\Query;
use Odf;
/**
 * Was19bController implements the CRUD actions for Was19b model.
 */
class Was19bController extends Controller
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
     * Lists all Was19b models.
     * @return mixed
     */
    public function actionIndex() {
     $searchModel = new Was19bSearch();
     $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]); 
  //echo "ini Halaman Index";
  }

    /**
     * Displays a single Was19b model.
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

          $filepath = '../modules/pengawasan/upload_file/was_19b/'.$file_upload['upload_file'];
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
     * Creates a new Was19b model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
    $model = new Was19b();
    $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_19b','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
    $modelwas19b=Was19bIsi::findAll(['id_was_19b'=>$model->id_was_19b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
    $modelWas15 = BaWas5::findOne(["id_ba_was_5"=>$_POST['was19b-idBaWas5']]);

    $connection = \Yii::$app->db;

    if ($model->load(Yii::$app->request->post())) {
        $model->id_sp_was2  = $modelWas15->id_sp_was2;
        $model->id_ba_was2  = $modelWas15->id_ba_was2;
        $model->id_l_was2   = $modelWas15->id_l_was2;
        $model->id_was15    = $modelWas15->id_was15;
        $model->id_terlapor = $modelWas15->id_terlapor;
        $model->no_register = $_SESSION['was_register'];
        $model->id_tingkat  = $_SESSION['kode_tk'];
        $model->id_kejati   = $_SESSION['kode_kejati'];
        $model->id_kejari   = $_SESSION['kode_kejari'];
        $model->id_cabjari  = $_SESSION['kode_cabjari'];
        $model->created_by=\Yii::$app->user->identity->id;
        $model->created_ip=$_SERVER['REMOTE_ADDR'];
        $model->created_time=date('Y-m-d H:i:s');

      $transaction = $connection->beginTransaction();
      try {

        if ($model->save()) {
           $jml=count($_POST['uraian']);
           // print_r($jml);
           // exit();
            for ($i=0; $i < $jml; $i++) { 
                $model19uraian=new Was19bIsi();
                $model19uraian->no_register = $_SESSION['was_register'];
                $model19uraian->id_tingkat  = $_SESSION['kode_tk'];
                $model19uraian->id_kejati   = $_SESSION['kode_kejati'];
                $model19uraian->id_kejari   = $_SESSION['kode_kejari'];
                $model19uraian->id_cabjari  = $_SESSION['kode_cabjari'];
                $model19uraian->id_sp_was2  = $model->id_sp_was2;
                $model19uraian->id_ba_was2  = $model->id_ba_was2;
                $model19uraian->id_l_was2   = $model->id_l_was2;
                $model19uraian->id_was15    = $model->id_was15;
                $model19uraian->id_was_19b  = $model->id_was_19b;
                $model19uraian->isi       = $_POST['uraian'][$i];
                $model19uraian->created_by=\Yii::$app->user->identity->id;
                $model19uraian->created_ip=$_SERVER['REMOTE_ADDR'];
                $model19uraian->created_time=date('Y-m-d H:i:s');
                // print_r($_POST['uraian'][$i].'<br>');
                $model19uraian->save();
            }
            
                 // exit();

          $pejabat = $_POST['pejabat'];
         // TembusanWas2::deleteAll(['from_table'=>'Was-19b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_19b),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
              for($z=0;$z<count($pejabat);$z++){
                  $saveTembusan = new TembusanWas2;
                  $saveTembusan->from_table = 'Was-19b';
                  $saveTembusan->pk_in_table = strrev($model->id_was_19b);
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
        $transaction->roolback();
      }
      return $this->redirect(['index']);
    } else {
      return $this->render('create', [
                  'model' => $model,
                  'modelTembusanMaster' => $modelTembusanMaster,
                  'modelwas19b' => $modelwas19b,

                  
      ]);
    }
  }

    /**
     * Updates an existing Was19b model.
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
        // print_r($_SESSION);
        // exit();
        $model = $this->findModel($id);
        $fungsi=new FungsiComponent();
        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_19b,'from_table'=>'Was-19b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
        $modelwas19b=Was19bIsi::findAll(['id_was_19b'=>$model->id_was_19b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

         $is_inspektur_irmud_riksa=$fungsi->gabung_where();
         $OldFile=$model->upload_file;

        if ($model->load(Yii::$app->request->post())){

              $errors       = array();
              $file_name    = $_FILES['upload_file']['name'];
              $file_size    =$_FILES['upload_file']['size'];
              $file_tmp     =$_FILES['upload_file']['tmp_name'];
              $file_type    =$_FILES['upload_file']['type'];
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
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_19b/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_19b/'.$OldFile);
                  }

                $jml=count($_POST['uraian']);
                Was19bIsi::deleteAll(['id_was_19b'=>$model->id_was_19b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                    for ($i=0; $i < $jml; $i++) { 
                        $model19uraian=new Was19bIsi();
                        $model19uraian->no_register = $_SESSION['was_register'];
                        $model19uraian->id_tingkat  = $_SESSION['kode_tk'];
                        $model19uraian->id_kejati   = $_SESSION['kode_kejati'];
                        $model19uraian->id_kejari   = $_SESSION['kode_kejari'];
                        $model19uraian->id_cabjari  = $_SESSION['kode_cabjari'];
                        $model19uraian->id_sp_was2  = $model->id_sp_was2;
                        $model19uraian->id_ba_was2  = $model->id_ba_was2;
                        $model19uraian->id_l_was2   = $model->id_l_was2;
                        $model19uraian->id_was15    = $model->id_was15;
                        $model19uraian->id_was_19b  = $model->id_was_19b;
                        $model19uraian->isi       = $_POST['uraian'][$i];
                        $model19uraian->created_by=\Yii::$app->user->identity->id;
                        $model19uraian->created_ip=$_SERVER['REMOTE_ADDR'];
                        $model19uraian->created_time=date('Y-m-d H:i:s');
                        $model19uraian->save();
                    }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-19b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_19b),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-19b';
                            $saveTembusan->pk_in_table = strrev($model->id_was_19b);
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
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_19b/'.$rename_file);
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
                'modelwas19b'   => $modelwas19b,
            ]);
        }
    }




    /**
     * Deletes an existing Was19b model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete() {
     $id_was_19b = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_was_19b);
           // echo $pecah[$i];
          //  $this->findModel($pecah[$i])->delete();
            Was19b::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_19b'=>$pecah[$i]]);
        
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
               //$this->findModel($id)->delete();
        $selection = $_POST['selection'];
        $transaction = Yii::$app->db->beginTransaction();
        try {
           

           for($i=0;$i<count($selection);$i++){
               $update = Was19b::updateAll(['flag' => '3'], 'id_was_19b = :id', [':id'=>$selection[$i]]);
           }
             //     Tun::updateAll(['flag' => '3'], 'id_tun=:id', [':id' => $id_tun[$i]]);
              //  }
           

            $transaction->commit();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'success', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Berhasil Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect('index');
        } catch(Exception $e) {
            $transaction->rollBack();

            Yii::$app->getSession()->setFlash('success', [
                'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                'icon' => 'glyphicon glyphicon-ok-sign', //String
                'message' => 'Data Gagal Dihapus', // String
                'title' => 'Delete', //String
                'positonY' => 'top', //String // defaults to top, allows top or bottom
                'positonX' => 'center', //String // defaults to right, allows right, center, left
                'showProgressbar' => true,
            ]);

            return $this->redirect('index');
        }
    }

    public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        $modelwas19b=Was19bIsi::findAll(['id_was_19b'=>$model->id_was_19b,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4']]);

        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_19b,'from_table'=>'Was-19b',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

         // $modelwas15=Was15::findOne(['id_was15'=>$model->id_was15,'no_register'=>$_SESSION['was_register'],
         //                    'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
         //                    'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
         //                    'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
         //                    'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
         //                    'id_level4'=>$_SESSION['was_id_level4']]);

        // $connection = \Yii::$app->db;
        // $fungsi=new FungsiComponent();
        // $where=$fungsi->static_where_alias('a');
        // $query="select * FROM was.sp_was_2 a   where  
        //             a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        //             and a.id_kejati='".$_SESSION['kode_kejati']."' 
        //             and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
        //             and a.trx_akhir=1 $where";
        // $modelSpwas2 = $connection->createCommand($query)->queryOne();
        $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_19b']);
      //  $tanggalWas15=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas15['tgl_was15']);
        // print_r($tanggalWas15);
         // print_r($tanggalWas15);
         // print_r($modelwas15);
        // exit();

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tanggal'=>$tanggal,
                                'tanggalWas15'=>$tanggalWas15,
                                'modelTembusan'=>$modelTembusan,
                               // 'modelSpwas2'=>$modelSpwas2,
                                'modelwas19b'=>$modelwas19b,
                         //       'modelwas15'=>$modelwas15,
                                ]);
      
    }

     public function actionCetak_old(){
        
         $id_register = $_GET['id_register'];
         $id_was_19b = $_GET['id_was_19b'];
         $odf = new Odf(Yii::$app->params['reportPengawasan']."was_19b.odt");
          

      
        
        $sql1 = "select a.no_was_19b,b.inst_nama AS kejaksaan,b.inst_lokinst AS di,a.id_register,a.tgl_was_19b,c.nm_lookup_item AS sifat,
a.jml_lampiran,a.satuan_lampiran,
d.jabatan AS kepada, g.jabatan AS dari,
 e.peg_nama AS nama_terlapor, e.peg_nip AS nip_terlapor, 
    e.peg_nrp AS nrp_terlapor, e.jabatan AS jabatan_terlapor, 
    h.uraian,
a.ttd_peg_nik, f.peg_nip AS ttd_nip, f.peg_nama AS ttd_nama, f.jabatan AS ttd_jabatan  
from was.was_19b a
JOIN kepegawaian.kp_inst_satker b ON a.inst_satkerkd::text = b.inst_satkerkd::text
   JOIN was.lookup_item c ON a.sifat_surat = c.kd_lookup_item::integer AND c.kd_lookup_group = '01'::bpchar AND c.kd_lookup_item = '3'::bpchar
   JOIN was.v_pejabat_pimpinan d ON a.kpd_was_19b= d.id_jabatan_pejabat
   JOIN was.v_terlapor e ON a.id_terlapor::text = e.id_terlapor::text
   JOIN was.v_pejabat_pimpinan g ON a.ttd_was_19b = g.id_jabatan_pejabat
   JOIN was.v_riwayat_jabatan f ON a.ttd_id_jabatan::text = f.id::text
   JOIN was.v_dugaan_pelanggaran h on a.id_register = h.id_register
   where  a.id_was_19b='".$id_was_19b."' and a.id_register = '".$id_register."'";
        $data = Was19b::findBySql($sql1)->asArray()->one();
       // $data = $command->queryOne(); 
        
       
       
       
        
        $sqlTembusan = new Query;
        $sqlTembusan->select('b.jabatan');
        $sqlTembusan->from("was.tembusan_was_19b a");
        $sqlTembusan->join("inner join", "was.v_pejabat_tembusan b", "(a.id_pejabat_tembusan=b.id_pejabat_tembusan)");
        $sqlTembusan->where("a.id_was_19b = :idWas",[":idWas"=>$id_was_19b]);
        $commandTembusan = $sqlTembusan->createCommand();
        $dataTembusan = $commandTembusan->queryAll(); 
       
        $odf->setVars('kejaksaan', $data['kejaksaan']);
        $odf->setVars('kepada',  $data['kepada']);
        $odf->setVars('dari',  $data['dari']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_19b']));
        $odf->setVars('nomor',  $data['no_was_19b']);
        $odf->setVars('sifat',  $data['sifat']);
        $odf->setVars('nipTerlapor', $data['nip_terlapor']);
        $odf->setVars('namaTerlapor',  $data['nama_terlapor']);
        $odf->setVars('jabatanTerlapor',  $data['jabatan_terlapor']);
      //  $odf->setVars('uraianPermasalahan',  $data['uraian']);
       // $odf->setVars('keputusanJA',  $data['kputusan_ja']);
        
       
         $terbilang = new Terbilang();
        //  $ini = $was_19a->jml_lampiran." (".$terbilang->convert($was_19a->jml_lampiran).")";
        //  $odf->setVars('jml_lampiran', $ini);
        $odf->setVars('berkas',  $data['jml_lampiran'] .'('.(!empty($data['jml_lampiran'])?$terbilang->convert(trim($data['jml_lampiran'])):'').')');
        
      
        $dft_tembusan = $odf->setSegment('tembusan');
        $i = 1;
        foreach($dataTembusan as $dataTembusan2){
          $dft_tembusan->tembusanJabatan($i.". ".$dataTembusan2['jabatan']);
          $dft_tembusan->merge();
          $i++;
        }
        $odf->mergeSegment($dft_tembusan);
      /*  $odf->setVars('kesimpulan',  $data['kesimpulan']);
        $odf->setVars('hasilkesimpulan',  $data['hasil_kesimpulan']);
        $odf->setVars('saran',  $data['saran']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_1']));
        $odf->setVars('tempat',  $data['inst_lokinst']);

        //terlapor
        $dft_terlapor = $odf->setSegment('terlapor');
        foreach($data2 as $dataTerlapor){
            $dft_terlapor->terlaporNama($dataTerlapor['peg_nama']);
            $dft_terlapor->terlaporNip($dataTerlapor['peg_nip']);
            $dft_terlapor->terlaporJabatan($dataTerlapor['jabatan']);
            $dft_terlapor->merge();
        }
        $odf->mergeSegment($dft_terlapor);
        //pelapor
         $dft_pelapor = $odf->setSegment('pelapor');
        foreach($data3 as $dataPelapor){
            $dft_pelapor->pelaporNama($dataPelapor['nama']);
            $dft_pelapor->pelaporAlamat($dataPelapor['alamat']);
           $dft_pelapor->merge();
        }
        $odf->mergeSegment($dft_pelapor);*/
     

       $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister"=>$id_register])->asArray()->one();
        $odf->exportAsAttachedFile("WAS19B- ".$dugaan['terlapor'].".odt");
        Yii::$app->end();
    }

    
    /**
     * Finds the Was19b model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was19b the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
   protected function findModel($id)
    {
        if (($model = Was19b::findOne(['id_was_19b'=>$id,'no_register'=>$_SESSION['was_register'],
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
