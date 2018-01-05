<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was16b;
use app\modules\pengawasan\models\Was16Bisi;
use app\modules\pengawasan\models\Was16bSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas16b;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\Was15Rencana;/*mengambil tembusan dari master*/
use app\models\KpInstSatkerSearch;
use app\models\KpInstSatker;
use app\models\KpPegawai;
use app\components\GlobalFuncComponent;
use app\modules\pengawasan\components\FungsiComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use yii\base\Model;
use app\modules\pengawasan\models\VWas16b;
use app\modules\pengawasan\models\VTembusanWas16b;
use app\modules\pengawasan\models\TembusanWas2;
use app\modules\pengawasan\models\Was15;
use app\components\ConstSysMenuComponent;
use Odf;
use Nasution\Terbilang;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Was16bController implements the CRUD actions for Was16b model.
 */
class Was16bController extends Controller {

  public function behaviors() {
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
   * Lists all Was16b models.
   * @return mixed
   */
  public function actionIndex() {
     $searchModel = new Was16bSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]); 
	//echo "ini Halaman Index";
  }

  /**
   * Displays a single Was16b model.
   * @param string $id
   * @return mixed
   */
  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);
  }

  public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/was_16b/'.$file_upload['upload_file'];
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
   * Creates a new Was16b model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
    $model = new Was16b();
    $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_16b','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
    $modelwas16b=Was16Bisi::findAll(['id_was_16b'=>$model->id_was_16b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
    $modelWas15 = Was15Rencana::findOne(["id_was15_rencana"=>$_POST['was16b-was15']]);

    $connection = \Yii::$app->db;

    if ($model->load(Yii::$app->request->post())) {
        // print_r( $_POST['Was16b']['nama_pegawai_terlapor']);
        // print_r( $_POST['Was16b-nama_pegawai_terlapor']);
        // print_r($model->nama_pegawai_terlapor);
        // print_r($model);
        // exit();
        $model->id_sp_was2  = $modelWas15->id_sp_was2;
        $model->id_ba_was2  = $modelWas15->id_ba_was2;
        $model->id_l_was2   = $modelWas15->id_l_was2;
        $model->id_was15    = $modelWas15->id_was15;
        //$model->id_terlapor = $modelWas15->id_terlapor_l_was2;
        $model->no_register = $_SESSION['was_register'];
        $model->id_tingkat  = $_SESSION['kode_tk'];
        $model->id_kejati   = $_SESSION['kode_kejati'];
        $model->id_kejari   = $_SESSION['kode_kejari'];
        $model->id_cabjari  = $_SESSION['kode_cabjari'];
        $model->created_by=\Yii::$app->user->identity->id;
        $model->created_ip=$_SERVER['REMOTE_ADDR'];
        $model->created_time=date('Y-m-d H:i:s');
      // $tembusan = $_POST['id_jabatan'];

      // $model->id_terlapor = $_POST['Was16b']['id_terlapor']; //menyimpan nilai dari dropdown Terlapor
      // $model->kpd_was_16b = $_POST['Was16b']['kpd_was_16b'];
      // $model->ttd_was_16b = $_POST['Was16b']['ttd_was_16b'];
      // $model->no_was_16b = "ND-" . $_POST['no_was_16b'];
      // $model->inst_satkerkd = $_POST['inst_satkerkd'];
      // $model->perihal = $_POST['Was16b']['perihal'];
      // $model->created_ip = Yii::$app->getRequest()->getUserIP();
      // //echo ($model->no_was_16b); exit();

      // $files = \yii\web\UploadedFile::getInstance($model, 'upload_file');
      // $model->upload_file = $files->name;

      $transaction = $connection->beginTransaction();
      try {

        if ($model->save()) {
           $jml=count($_POST['uraian']);
            for ($i=0; $i < $jml; $i++) { 
                $model16uaraian=new Was16Bisi();
                $model16uaraian->no_register = $_SESSION['was_register'];
                $model16uaraian->id_tingkat  = $_SESSION['kode_tk'];
                $model16uaraian->id_kejati   = $_SESSION['kode_kejati'];
                $model16uaraian->id_kejari   = $_SESSION['kode_kejari'];
                $model16uaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                $model16uaraian->id_sp_was2  = $model->id_sp_was2;
                $model16uaraian->id_ba_was2  = $model->id_ba_was2;
                $model16uaraian->id_l_was2   = $model->id_l_was2;
                $model16uaraian->id_was15    = $model->id_was15;
                $model16uaraian->id_was_16b  = $model->id_was_16b;
                //$model16uaraian->isi       = $_POST['uraian'][$i];
                $pattern = "/<p[^>]*>/"; 
                $model16uaraian->isi       = preg_replace($pattern, '<p style="margin-top:0px;" >', $_POST['uraian'][$i]);
                $model16uaraian->created_by=\Yii::$app->user->identity->id;
                $model16uaraian->created_ip=$_SERVER['REMOTE_ADDR'];
                $model16uaraian->created_time=date('Y-m-d H:i:s');
                // print_r($model16uaraian->save());
                // exit();
                $model16uaraian->save();
            }

          $pejabat = $_POST['pejabat'];
         // TembusanWas2::deleteAll(['from_table'=>'Was-16b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_16b),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
              for($z=0;$z<count($pejabat);$z++){
                  $saveTembusan = new TembusanWas2;
                  $saveTembusan->from_table = 'Was-16b';
                  $saveTembusan->pk_in_table = strrev($model->id_was_16b);
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

              $arr = array(ConstSysMenuComponent::Bawas7);
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
                  'modelTembusanMaster' => $modelTembusanMaster,
                  'modelwas16b' => $modelwas16b,

                  
      ]);
    }
  }

  public function actionUpdate($id)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $model = $this->findModel($id);
        $fungsi=new FungsiComponent();
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_16b,'from_table'=>'Was-16b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelwas16b=Was16Bisi::findAll(['id_was_16b'=>$model->id_was_16b,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
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
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_16b/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_16b/'.$OldFile);
                  }

                $jml=count($_POST['uraian']);
                Was16Bisi::deleteAll(['id_was_16b'=>$model->id_was_16b,'id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari']]);
                // exit();
                    for ($i=0; $i < $jml; $i++) { 
                          $model16uaraian=new Was16Bisi();
                          $model16uaraian->no_register = $_SESSION['was_register'];
                          $model16uaraian->id_tingkat  = $_SESSION['kode_tk'];
                          $model16uaraian->id_kejati   = $_SESSION['kode_kejati'];
                          $model16uaraian->id_kejari   = $_SESSION['kode_kejari'];
                          $model16uaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                          $model16uaraian->id_sp_was2  = $model->id_sp_was2;
                          $model16uaraian->id_ba_was2  = $model->id_ba_was2;
                          $model16uaraian->id_l_was2   = $model->id_l_was2;
                          $model16uaraian->id_was15    = $model->id_was15;
                          $model16uaraian->id_was_16b  = $model->id_was_16b;
                          $pattern = "/<p[^>]*>/"; 
                          $model16uaraian->isi       = preg_replace($pattern, '<p style="margin-top:0px;" >', $_POST['uraian'][$i]);
                          $model16uaraian->created_by=\Yii::$app->user->identity->id;
                          $model16uaraian->created_ip=$_SERVER['REMOTE_ADDR'];
                          $model16uaraian->created_time=date('Y-m-d H:i:s');
                          // print_r($model16uaraian->save());
                          // exit();
                          $model16uaraian->save();
                    }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-16b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_16b),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-16b';
                            $saveTembusan->pk_in_table = strrev($model->id_was_16b);
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
                      //1 jabatan (TU) // 0 jabatan (JAKSA)  
                  // if($kp['pns_jnsjbtfungsi'] == '1'){
                  //   $arr = array(ConstSysMenuComponent::Bawas7, ConstSysMenuComponent::Bawas9);
                  // }else if($kp['pns_jnsjbtfungsi'] == '0'){
                  //   $arr = array(ConstSysMenuComponent::Bawas7, ConstSysMenuComponent::Bawas8);
                  // }      
                    $arr = array(ConstSysMenuComponent::Bawas7);
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
                      $modelTrxPemrosesan->save();
                      // }
                    }

            }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_16b/'.$rename_file);
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
                'modelwas16b'   => $modelwas16b,
            ]);
        }
    }

    public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        
        $modelwas16b=Was16Bisi::findAll(['id_was_16b'=>$model->id_was_16b,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4']]);

        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_16b,'from_table'=>'Was-16b',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

         $modelwas15=Was15::findOne(['id_was15'=>$model->id_was15,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4']]);

        // $connection = \Yii::$app->db;
        // $fungsi=new FungsiComponent();
        // $where=$fungsi->static_where_alias('a');
        // $query="select * FROM was.sp_was_2 a   where  
        //             a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        //             and a.id_kejati='".$_SESSION['kode_kejati']."' 
        //             and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
        //             and a.trx_akhir=1 $where";
        // $modelSpwas2 = $connection->createCommand($query)->queryOne();
        $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_16b']);
        $tanggalWas15=\Yii::$app->globalfunc->ViewIndonesianFormat($modelwas15['tgl_was15']);
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
                                'modelwas16b'=>$modelwas16b,
                                'modelwas15'=>$modelwas15,
                                ]);
      
    }



  public function actionUpdate2($id) {
    $model = Was16b::findOne(array("id_was_16b" => $id, "flag" => '1'));
    $model2 = Was16b::findOne(array("id_was_16b" => $id, "flag" => '1'));
    $model->id_was_16b = $id;
    $model->no_was_16b = "ND-".$_POST["no_was_16b"];
//      $model->id_register = $_POST[];
    $model->inst_satkerkd = $_POST["inst_satkerkd"];
    $model->kpd_was_16b = $_POST["Was16b"]["kpd_was_16b"];
//      $model->id_terlapor = $_POST["Was16b"]["id_terlapor"];
    $model->tgl_was_16b = $_POST["Was16b"]["tgl_was_16b"];
    $model->sifat_surat = $_POST["Was16b"]["sifat_surat"];
    $model->jml_lampiran = $_POST["Was16b"]["jml_lampiran"];
//      $model->satuan_lampiran = $_POST[];
    $model->perihal = $_POST["Was16b"]["perihal"];
    $model->ttd_was_16b = $_POST["Was16b"]["ttd_was_16b"];
    $model->ttd_peg_nik = $_POST["Was16b"]["ttd_peg_nik"];
    $model->ttd_id_jabatan = $_POST["Was16b"]["ttd_id_jabatan"];

    $model->updated_ip = Yii::$app->getRequest()->getUserIP();
      
    $file = \yii\web\UploadedFile::getInstance($model, 'upload_file');
    if (empty($file)) {
      $model->upload_file = $model2->upload_file;
    } else {
      $model->upload_file = $file->name;
    }
    $tembusan = $_POST['id_jabatan'];
    
    $connection = \Yii::$app->db;
    $transaction = $connection->beginTransaction();
    try {
      if ($model->save()) {
        if ($files != false) {
          $path = \Yii::$app->params['uploadPath'] . 'was_16b/' . $files->name;
          $files->saveAs($path);
        }

        //hapus tembusan lalu disimpan lagi 
        TembusanWas16b::deleteAll('id_was_16b=:del', [':del' => $model->id_was_16b]);
        for ($i = 0; $i < count($tembusan); $i++) {
          $saveTembusan = new TembusanWas16b();
          $saveTembusan->id_was_16b = $model->id_was_16b;
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

   public function actionDelete() {
     $id_was_16b = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_was_16b);
           // echo $pecah[$i];
          //  $this->findModel($pecah[$i])->delete();
            Was16b::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_16b'=>$pecah[$i]]);
        
             // $arr = array(ConstSysMenuComponent::Was17, ConstSysMenuComponent::Was18);
             //        for ($i=0; $i < 2 ; $i++) { 
             //          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
             //        }

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

  public function actionGetttd(){
       
   $searchModelWas16b = new was16bSearch();
   $dataProviderPenandatangan = $searchModelWas16b->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]); 
   echo GridView::widget([
                        'dataProvider'=> $dataProviderPenandatangan,
                        // 'filterModel' => $searchModel,
                        // 'layout' => "{items}\n{pager}",
                        'columns' => [
                            ['header'=>'No',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'contentOptions'=>['style'=>'text-align:center;'],
                            'class' => 'yii\grid\SerialColumn'],
                            
                            
                            // ['label'=>'No Surat',
                            //     'headerOptions'=>['style'=>'text-align:center;'],
                            //     'attribute'=>'id_surat',
                            // ],

                            ['label'=>'Nip',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nip',
                            ],


                            ['label'=>'Nama Penandatangan',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nama',
                            ],

                            ['label'=>'Jabatan Alias',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'nama_jabatan',
                            ],

                            ['label'=>'Jabatan Sebenarnya',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'attribute'=>'jabtan_asli',
                            ],

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

  public function actionHapus() {
    $id_was_16b = $_GET['id'];
    if (Was16b::updateAll(["flag" => '3'], "id_was_16b ='" . $id_was_16b . "'")) {
      TembusanWas16b::updateAll(["flag" => '3'], "id_was_16b ='" . $id_was_16b . "'");
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
    } else {
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'danger',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Gagal Dihapus',
          'title' => 'Error',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    }
    return $this->redirect(['create']);
  }
  /**
   * Deletes an existing Was16b model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
//    public function actionDelete($id)
//    {
//        $this->findModel($id)->delete();
//
//        return $this->redirect(['index']);
//    }

  /**
   * Finds the Was16b model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return Was16b the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel2($id) {
    if (($model = Was16b::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

   protected function findModel($id)
    {
        if (($model = Was16b::findOne(['id_was_16b'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
