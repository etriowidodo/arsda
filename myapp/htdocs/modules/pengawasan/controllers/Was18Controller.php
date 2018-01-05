<?php

namespace app\modules\pengawasan\controllers;

use Yii; 
use app\modules\pengawasan\models\Was18;
use app\modules\pengawasan\models\Was18Search;
use app\modules\pengawasan\models\BaWas9;
use yii\web\Controller;
use app\components\ConstSysMenuComponent;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\TembusanWas18;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use Odf;
use app\models\KpInstSatker; 
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use app\modules\pengawasan\models\lwas2terlapor; 
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\WasTrxPemrosesan;
use yii\db\Query;
/**
 * Was18Controller implements the CRUD actions for Was18 model.
 */
class Was18Controller extends Controller
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
     * Lists all Was18 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was18Search();  
        $dataProvider = $searchModel->searchWas18();

        return $this->render('index', [
          'dataProvider' => $dataProvider,
      
        ]);
    }

    /**
     * Displays a single Was18 model.
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
     * Creates a new Was18 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Was18();
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_10_inspeksi','condition2'=>'master'])->all();

        $BaWas9   = BaWas9::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah']]);
       
        $connection = \Yii::$app->db;
        if ($model->load(Yii::$app->request->post())) {
          $tembusan =  $_POST['id_jabatan']; 
          $model->id_tingkat  = $_SESSION['kode_tk'];
          $model->id_kejati   = $_SESSION['kode_kejati'];
          $model->id_kejari   = $_SESSION['kode_kejari'];
          $model->id_cabjari  = $_SESSION['kode_cabjari'];
          $model->no_register = $_SESSION['was_register']; 
          $model->id_wilayah  = $_SESSION['was_id_wilayah']; 

          $model->created_ip  = $_SERVER['REMOTE_ADDR'];
          $model->created_time =date('Y-m-d h:i:sa');
          $model->created_by  = \Yii::$app->user->identity->id; 
          $model->no_was_18 = $_POST['Was18']['no_was_18'];
          $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
          $model->upload_file = $files->name;
          $model->perihal = $_POST['Was18']['perihal']; 
 
          $transaction = $connection->beginTransaction();
           
          try {
            if($model->save()){
                if ($files != false) {
                  $path = \Yii::$app->params['uploadPath'].'was_18/'.$files->name;
                  $files->saveAs($path);
                }
             for($i=0;$i<count($tembusan);$i++){
                    $saveTembusan = new TembusanWas18();
                    $saveTembusan->id_was18 = $model->id_was18;
                    $saveTembusan->id_pejabat_tembusan = $tembusan[$i];
                    $saveTembusan->save();
                }
              $pejabat = $_POST['pejabat'];
              for($z=0;$z<count($pejabat);$z++){
                $saveTembusan = new TembusanWas2;
                $saveTembusan->from_table = 'Was18';
                $saveTembusan->pk_in_table = strrev($model->id_was18);
                $saveTembusan->tembusan = $_POST['pejabat'][$z];
                $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                $saveTembusan->created_time = date('Y-m-d H:i:s');
                $saveTembusan->created_by = \Yii::$app->user->identity->id;
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

              $arr = array(ConstSysMenuComponent::Bawas5);
              for ($i=0; $i < 1 ; $i++) { 
                WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
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
          } catch(Exception $e) {
              $transaction->rollback();
          }
        } else { 
                
            return $this->render('create', [
                'model' => $model, 
                'modelTembusanMaster' => $modelTembusanMaster,
            ]);
        }
    }

    /**
     * Updates an existing Was18 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id) {
      $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
          $res = "";
          for ($i = 0; $i < 10; $i++) {
              $res .= $chars[mt_rand(0, strlen($chars)-1)];
          }

      $model = $this->findModel($id);
      $modelTembusan    = TembusanWas2::findAll(['pk_in_table'=>$model->id_was18,'from_table'=>'Was18','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]); 
 
      $session = Yii::$app->session;
      $oldFile = $model->upload_file;
      $connection = \Yii::$app->db; 

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
          if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was18/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was18/'.$OldFile);
          }
           
          TembusanWas2::deleteAll(['from_table'=>'Was18','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'  =>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_was18]);
           $pejabat = $_POST['pejabat'];
          for($z=0;$z<count($pejabat);$z++){
              $saveTembusan = new TembusanWas2;
              $saveTembusan->from_table = 'Was18';
              $saveTembusan->pk_in_table = strrev($model->id_was18);
              $saveTembusan->tembusan = $_POST['pejabat'][$z];
              $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
              $saveTembusan->created_time = date('Y-m-d H:i:s');
              $saveTembusan->created_by = \Yii::$app->user->identity->id;
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

            $arr = array(ConstSysMenuComponent::Bawas5);
              for ($i=0; $i < 1 ; $i++) { 
                WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
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
           'message' => 'Berhasil Disimpan',
           'title' => 'Simpan Data',
           'positonY' => 'top',
           'positonX' => 'center',
           'showProgressbar' => true,
           ]);

          move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_18/'.$rename_file);
          $transaction->commit();
           
          return $this->redirect(['index']);  
          }
          else{
          Yii::$app->getSession()->setFlash('success', [
           'type' => 'success',
           'duration' => 3000,
           'icon' => 'fa fa-users',
           'message' => 'Gagal Disimpan',
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
          
          
             
          } else if (Yii::$app->request->isAjax) { 
                $queryTerlapor = new Query;
                $queryTerlapor->select(["CONCAT(a.peg_nip, ' - ', a.peg_nama) AS terlapor", "a.id_terlapor"])
                  ->from('was.v_terlapor a')
                  ->where("a.id_register= :id_register", [':id_register' => $session->get('was_register')]);
                $terlapor = $queryTerlapor->all(); 
              return $this->renderAjax('_form', [
                  'model'   => $model,
                  'terlapor'  => $terlapor,
              ]);
          }
      
      return $this->render('update', [
        'model' => $model, 
        'modelTembusan' => $modelTembusan,
      ]);
    }
 
    /**
     * Deletes an existing Was18 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
     $id=$_POST['id'];
     
    $jml=$_POST['jml'];
    // echo $jml;
    for ($i=0; $i < $jml; $i++) { 
    $pecah=explode(',', $id);
    Was18::deleteAll(['id_was18'=>$pecah[$i],'no_register'=>$_SESSION['was_register'],
            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
            'id_level4'=>$_SESSION['was_id_level4']]);
    }
    return $this->redirect(['index']);
    }

    /**
     * Finds the Was18 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was18 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was18::findOne(['id_was18'=>$id,'no_register'=>$_SESSION['was_register'],
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

    public function actionViewpdf($id){ 
        $file_upload=$this->findModel($id); 
        $filepath = '../modules/pengawasan/upload_file/was_18/'.$file_upload['upload_file'];
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
        $noreg      = $_SESSION['was_register'];
        $id_tingkat = $_SESSION['kode_tk'];
        $id_kejati  = $_SESSION['kode_kejati']; 
        $id_kejari  = $_SESSION['kode_kejari']; 
        $id_cabjari = $_SESSION['kode_cabjari']; 
        $model      = $this->findModel($id);

        $connection = \Yii::$app->db;
        $data_satker  = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $lwas2      = lwas2terlapor::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $query = "select  nip_pemeriksa,nama_pemeriksa,pangkat_pemeriksa,jabatan_pemeriksa
                  from was.sk_was_4e a inner join was.sk_was_4e_pemeriksa b on a.id_sk_was_4e=b.id_sk_was_4e
                  where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'
                  union
                  select  nip_pemeriksa,nama_pemeriksa,pangkat_pemeriksa,jabatan_pemeriksa
                  from was.sk_was_4d a inner join was.sk_was_4d_pemeriksa b on a.id_sk_was_4d=b.id_sk_was_4d
                  where a.no_register = '$noreg' and a.id_tingkat='$id_tingkat' and a.id_kejati='$id_kejati' and a.id_kejari='$id_kejari' and a.id_cabjari='$id_cabjari'  and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
        $pemeriksa = $connection->createCommand($query)->queryOne();
        
        $query2 = "select * from was.pelapor where no_register = '$noreg' and id_tingkat='$id_tingkat' and id_kejati='$id_kejati' and id_kejari='$id_kejari' and id_cabjari='$id_cabjari'";
        $pelapor = $connection->createCommand($query2)->queryOne();
        
        return $this->render('cetak',[
            'model'=>$model,
            'data_satker'=>$data_satker,  
            'pemeriksa'=>$pemeriksa,  
            'pelapor'=>$pelapor,
            'lwas2'=>$lwas2,
        ]);
    }

}