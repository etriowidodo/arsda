<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was20a;
use app\modules\pengawasan\models\Was20aSearch;
use app\modules\pengawasan\models\Was20aDetail;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\Was15Rencana;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\BaWas6;/*mengambil tembusan dari master*/
use app\models\KpInstSatkerSearch;
use app\models\KpInstSatker;
use app\models\KpPegawai;
use app\components\GlobalFuncComponent;
use app\modules\pengawasan\components\FungsiComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use yii\base\Model;
use app\modules\pengawasan\models\TembusanWas2;
use app\modules\pengawasan\models\Was15;
use app\components\ConstSysMenuComponent;
use Odf;
use Nasution\Terbilang;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Was20aController implements the CRUD actions for Was20a model.
 */
class Was20aController extends Controller
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
     * Lists all Was20a models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was20aSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was20a model.
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $id_sp_was2
     * @param integer $id_ba_was2
     * @param integer $id_l_was2
     * @param integer $id_was15
     * @param integer $id_was_20a
     * @return mixed
     */
    public function actionView($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a),
        ]);
    }

     public function actionViewpdf($id){
        $file_upload=$this->findModel($id);

          $filepath = '../modules/pengawasan/upload_file/was_20a/'.$file_upload['upload_file'];
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
     * Creates a new Was20a model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */ 
public function actionCreate() {
    $model = new Was20a();
    $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_20a','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
    $modelPertanyaan=Was20aDetail::findAll(['id_was_20a'=>$model->id_was_20a,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
    $modelBaWas6 = BaWas6::findOne(["id_ba_was_6"=>$_POST['was20a-was6']]);

    $connection = \Yii::$app->db;

    if ($model->load(Yii::$app->request->post())) {
        $model->id_sp_was2  = $modelBaWas6->id_sp_was2;
        $model->id_ba_was2  = $modelBaWas6->id_ba_was2;
        $model->id_l_was2   = $modelBaWas6->id_l_was2;
        $model->id_was15    = $modelBaWas6->id_was15;
        $model->id_terlapor = $modelBaWas6->id_terlapor;
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

           $jml=count($_POST['pertanyaan']);
            for ($i=0; $i < $jml; $i++) { 
                $model20uaraian=new Was20aDetail();
                $model20uaraian->no_register = $_SESSION['was_register'];
                $model20uaraian->id_tingkat  = $_SESSION['kode_tk'];
                $model20uaraian->id_kejati   = $_SESSION['kode_kejati'];
                $model20uaraian->id_kejari   = $_SESSION['kode_kejari'];
                $model20uaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                $model20uaraian->id_sp_was2  = $model->id_sp_was2;
                $model20uaraian->id_ba_was2  = $model->id_ba_was2;
                $model20uaraian->id_l_was2   = $model->id_l_was2;
                $model20uaraian->id_was15    = $model->id_was15;
                $model20uaraian->id_was_20a  = $model->id_was_20a;
                $model20uaraian->keberatan   = $_POST['pertanyaan'][$i];
                $model20uaraian->tanggapan   = $_POST['jawaban'][$i];
                $model20uaraian->created_by=\Yii::$app->user->identity->id;
                $model20uaraian->created_ip=$_SERVER['REMOTE_ADDR'];
                $model20uaraian->created_time=date('Y-m-d H:i:s');
                // print_r($model20uaraian->save());
                // exit();
                $model20uaraian->save();
            }

          $pejabat = $_POST['pejabat'];
         // TembusanWas2::deleteAll(['from_table'=>'Was-20a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_20a),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
              for($z=0;$z<count($pejabat);$z++){
                  $saveTembusan = new TembusanWas2;
                  $saveTembusan->from_table = 'Was-20a';
                  $saveTembusan->pk_in_table = strrev($model->id_was_20a);
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
                  'modelPertanyaan' => $modelPertanyaan,
      ]);
    }
  }

    public function actionCreate_old()
    {
        $model = new Was20a();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_tingkat' => $model->id_tingkat, 
                'id_kejati' => $model->id_kejati, 'id_kejari' => $model->id_kejari, 
                'id_cabjari' => $model->id_cabjari, 'no_register' => $model->no_register, 
                'id_sp_was2' => $model->id_sp_was2, 'id_ba_was2' => $model->id_ba_was2, 
                'id_l_was2' => $model->id_l_was2, 'id_was15' => $model->id_was15, 
                'id_was_20a' => $model->id_was_20a]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Was20a model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $id_sp_was2
     * @param integer $id_ba_was2
     * @param integer $id_l_was2
     * @param integer $id_was15
     * @param integer $id_was_20a
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
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_20a,'from_table'=>'Was-20a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelPertanyaan=Was20aDetail::findAll(['id_was_20a'=>$model->id_was_20a,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
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
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_20a/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_20a/'.$OldFile);
                  }

                // print_r($_POST['pertanyaan']);
                // exit();  
                  
                $jml=count($_POST['pertanyaan']);
                Was20aDetail::deleteAll(['id_was_20a'=>$model->id_was_20a,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                for ($i=0; $i < $jml; $i++) { 
                    $model20uaraian=new Was20aDetail();
                    $model20uaraian->no_register = $_SESSION['was_register'];
                    $model20uaraian->id_tingkat  = $_SESSION['kode_tk'];
                    $model20uaraian->id_kejati   = $_SESSION['kode_kejati'];
                    $model20uaraian->id_kejari   = $_SESSION['kode_kejari'];
                    $model20uaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                    $model20uaraian->id_sp_was2  = $model->id_sp_was2;
                    $model20uaraian->id_ba_was2  = $model->id_ba_was2;
                    $model20uaraian->id_l_was2   = $model->id_l_was2;
                    $model20uaraian->id_was15    = $model->id_was15;
                    $model20uaraian->id_was_20a  = $model->id_was_20a;
                    $model20uaraian->keberatan   = $_POST['pertanyaan'][$i];
                    $model20uaraian->tanggapan   = $_POST['jawaban'][$i];
                    $model20uaraian->created_by=\Yii::$app->user->identity->id;
                    $model20uaraian->created_ip=$_SERVER['REMOTE_ADDR'];
                    $model20uaraian->created_time=date('Y-m-d H:i:s');
                    // print_r($model20uaraian->keberatan);
                    // exit();
                    $model20uaraian->save();
                }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-20a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_20a),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-20a';
                            $saveTembusan->pk_in_table = strrev($model->id_was_20a);
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

                    // $arr = array(ConstSysMenuComponent::Bawas7);
                    // for ($i=0; $i < 1 ; $i++) { 
                    //   WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-20a
                    //   $modelTrxPemrosesan=new WasTrxPemrosesan();
                    //   $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                    //   $modelTrxPemrosesan->id_sys_menu=$arr[$i];
                    //   $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                    //   $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                    //   $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                    //   $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                    //   $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                    //   $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                    //   $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                    //   $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                    //   $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                    //   $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                    //   $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                    //   $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                    //   $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                    //   $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                    //   $modelTrxPemrosesan->save();
                    //   // }
                    // }

            }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_20a/'.$rename_file);
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
                'modelTembusan'   => $modelTembusan,
                'modelPertanyaan' => $modelPertanyaan,
            ]);
        }
    }

    public function actionUpdate_old($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a)
    {
        $model = $this->findModel($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id_tingkat' => $model->id_tingkat, 'id_kejati' => $model->id_kejati, 'id_kejari' => $model->id_kejari, 'id_cabjari' => $model->id_cabjari, 'no_register' => $model->no_register, 'id_sp_was2' => $model->id_sp_was2, 'id_ba_was2' => $model->id_ba_was2, 'id_l_was2' => $model->id_l_was2, 'id_was15' => $model->id_was15, 'id_was_20a' => $model->id_was_20a]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Was20a model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $id_sp_was2
     * @param integer $id_ba_was2
     * @param integer $id_l_was2
     * @param integer $id_was15
     * @param integer $id_was_20a
     * @return mixed
     */

      public function actionDelete() {
     $id_was_20 = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_was_20);
           // echo $pecah[$i];
          //  $this->findModel($pecah[$i])->delete();
            Was20a::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_20a'=>$pecah[$i]]);
          
           TembusanWas2::deleteAll(['from_table'=>'Was-20a',
                                    'no_register'=>$_SESSION['was_register'],
                                    'id_tingkat'=>$_SESSION['kode_tk'],
                                    'id_kejati'=>$_SESSION['kode_kejati'], 
                                    'id_kejari'=>$_SESSION['kode_kejari'],
                                    'id_cabjari'=>$_SESSION['kode_cabjari'],
                                    'pk_in_table'=>strrev($pecah[$i]),
                                    'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                    'id_level1'=>$_SESSION['was_id_level1'],
                                    'id_level2'=>$_SESSION['was_id_level2'],
                                    'id_level3'=>$_SESSION['was_id_level3'],
                                    'id_level4'=>$_SESSION['was_id_level4']]);
                   
             // $arr = array(ConstSysMenuComponent::Was20a, ConstSysMenuComponent::Was18);
             //        for ($i=0; $i < 2 ; $i++) { 
             //          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-20a
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
   
   // echo "asdasdas";
   // exit();    
   $searchModelWas20a = new Was20aSearch();
   $dataProviderPenandatanganWas20a = $searchModelWas20a->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]); 
   echo GridView::widget([
                        'dataProvider'=> $dataProviderPenandatanganWas20a,
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

    public function actionDelete_old($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a)
    {
        $this->findModel($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a)->delete();

        return $this->redirect(['index']);
    }


     public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
        $modelwas20a=Was20aDetail::findAll(['id_was_20a'=>$model->id_was_20a,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4']]); 

        $modelSk=BaWas6::findOne(['nip_terlapor'=>$model->nip_pegawai_terlapor,
                            'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4']]);

         $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_20a,'from_table'=>'Was-20a',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();

        $connection = \Yii::$app->db;
        $fungsi=new FungsiComponent();
        $query="select * FROM was.ms_sk where kode_sk='".$modelSk['sk']."'";
        $modelIsiSk = $connection->createCommand($query)->queryOne();

        $tanggal           =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_20a']);
        $tgl_disampaikan_ba=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_disampaikan_ba']);
        $tgl_keberatan_ba  =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_keberatan_ba']);
        $tglSk             =\Yii::$app->globalfunc->ViewIndonesianFormat($modelSk['tgl_sk']);
 

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tanggal'=>$tanggal,
                                'tgl_disampaikan_ba'=>$tgl_disampaikan_ba,
                                'tgl_keberatan_ba'=>$tgl_keberatan_ba,
                                'modelTembusan'=>$modelTembusan,
                                'modelwas20a'=>$modelwas20a,
                                'modelSk'=>$modelSk,
                                'modelIsiSk'=>$modelIsiSk,
                                'tglSk'=>$tglSk,
                                ]);
      
    }

    /**
     * Finds the Was20a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $id_sp_was2
     * @param integer $id_ba_was2
     * @param integer $id_l_was2
     * @param integer $id_was15
     * @param integer $id_was_20a
     * @return Was20a the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was20a::findOne(['id_was_20a'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel_old($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_20a)
    {
        if (($model = Was20a::findOne(['id_tingkat' => $id_tingkat, 'id_kejati' => $id_kejati, 'id_kejari' => $id_kejari, 'id_cabjari' => $id_cabjari, 'no_register' => $no_register, 'id_sp_was2' => $id_sp_was2, 'id_ba_was2' => $id_ba_was2, 'id_l_was2' => $id_l_was2, 'id_was15' => $id_was15, 'id_was_20a' => $id_was_20a])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
