<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was23a;
use app\modules\pengawasan\models\Was23aSearch;
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

/*use Yii;
use app\modules\pengawasan\models\Was23a;
use app\modules\pengawasan\models\Was23aSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\components\FungsiComponent; 

*/


/**
 * Was23aController implements the CRUD actions for Was23a model.
 */
class Was23aController extends Controller
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
     * Lists all Was23a models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was23aSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was23a model.
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $id_sp_was2
     * @param integer $id_ba_was2
     * @param integer $id_l_was2
     * @param integer $id_was15
     * @param integer $id_was_23a
     * @return mixed
     */
    public function actionView($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_23a)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_23a),
        ]);
    }

    /**
     * Creates a new Was23a model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Was23a();
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_23a','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
    

        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              
                $model->id_tingkat = $_SESSION['kode_tk'];
                $model->id_kejati = $_SESSION['kode_kejati'];
                $model->id_kejari = $_SESSION['kode_kejari'];
                $model->id_cabjari = $_SESSION['kode_cabjari'];
                $model->no_register = $_SESSION['was_register'];
                $model->created_ip = $_SERVER['REMOTE_ADDR'];
                $model->created_time = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
            if($model->save()) {

                  $pejabat = $_POST['pejabat'];
             // TembusanWas2::deleteAll(['from_table'=>'Was-23b','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_23b),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                  for($z=0;$z<count($pejabat);$z++){
                      $saveTembusan = new TembusanWas2;
                      $saveTembusan->from_table = 'Was-23b';
                      $saveTembusan->pk_in_table = strrev($model->id_was_23b);
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

            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelTembusanMaster' => $modelTembusanMaster,
            ]);
        }
    }

    /**
     * Updates an existing Was23a model.
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
     * @param integer $id_was_23a
     * @return mixed
     */
    public function actionUpdate($id_was_23a)
    {

        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        $model = $this->findModel($id_was_23a);
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_23a,'from_table'=>'Was-23a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $fungsi=new FungsiComponent();
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
                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d H:i:s');
                $model->updated_by = \Yii::$app->user->identity->id;
                $model->upload_file=($file_name==''?$OldFile:$rename_file);
            if($model->save()) {

                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_23a/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'was_23a/'.$OldFile);
              }

                $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Was-23a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_23a),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Was-23a';
                            $saveTembusan->pk_in_table = strrev($model->id_was_23a);
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
                move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_23a/'.$rename_file);
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

            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan'   => $modelTembusan,
            ]);
        }
    }


        public function actionViewpdf($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
        $file_upload=$this->findModel($id);
       //$file_upload=Was11::findOne(["id_was_23a"=>$id]);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_23a/'.$file_upload['upload_file'];
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
     * Deletes an existing Was23a model.
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
     * @param integer $id_was_23a
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['id_was_23a'];
        $jml = $_POST['jml'];
        $pecah = explode(',',$id);
        for ($i=0; $i < $jml; $i++) { 
        $this->findModel($pecah[$i])->delete();
        }

        return $this->redirect(['index']);
    }

      public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel($id);
       
        // $modelSk=BaWas6::findOne(['nip_terlapor'=>$model->nip_pegawai_terlapor,
        //                     'no_register'=>$_SESSION['was_register'],
        //                     'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
        //                     'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
        //                     'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
        //                     'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
        //                     'id_level4'=>$_SESSION['was_id_level4']]);

         $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_23a,'from_table'=>'Was-23a',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();

        // $connection = \Yii::$app->db;
        // $fungsi=new FungsiComponent();
        // $query="select * FROM was.ms_sk where kode_sk='".$modelSk['sk']."'";
        // $modelIsiSk = $connection->createCommand($query)->queryOne();

        $tanggal    =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_23a']);
        $tglNodis   =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_nota_dinas']);
        //$tgl_keberatan_ba  =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_keberatan_ba']);
     //   $tglSk             =\Yii::$app->globalfunc->ViewIndonesianFormat($modelSk['tgl_sk']);
        

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tanggal'=>$tanggal,
                                'tglNodis'=>$tglNodis,
                                'modelTembusan'=>$modelTembusan,
                                ]);
      
    }

    /**
     * Finds the Was23a model based on its primary key value.
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
     * @param integer $id_was_23a
     * @return Was23a the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_was_23a)
    {
        if (($model = Was23a::findOne(['id_tingkat' => $_SESSION['kode_tk'], 'id_kejati' => $_SESSION['kode_kejati'], 'id_kejari' => $_SESSION['kode_kejari'], 'id_cabjari' => $_SESSION['kode_cabjari'], 'no_register' => $_SESSION['was_register'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'id_was_23a' => $id_was_23a])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
