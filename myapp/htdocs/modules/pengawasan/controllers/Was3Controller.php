<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was3;
use app\modules\pengawasan\models\Was3Search;
use app\modules\pengawasan\models\TembusanWas2;
use app\modules\pengawasan\models\Was1Pemeriksa;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Nasution\Terbilang;
use app\models\KpInstSatkerSearch;
use Odf;
use app\components\GlobalFuncComponent; 
use yii\db\Query;
use yii\db\Command;
/**
 * Was3Controller implements the CRUD actions for Was3 model.
 */
class Was3Controller extends Controller
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
     * Lists all Was3 models.
     * @return mixed
     */
    public function actionIndex()
    {
	
			 $query=Was3::findOne(['no_register'=>$_SESSION['was_register'],['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]]);

       
        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was3/update?id=".$query->id_was3."&id_register=".$_SESSION['was_register']."&id_tingkat=".$_SESSION['kode_tk']."&id_kejati=".$_SESSION['kode_kejati']."&id_kejari=".$_SESSION['kode_kejari']."&id_cabjari=".$_SESSION['kode_cabjari']));
        }else{
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was3/create"));
        }
		
     /*    $searchModel = new Was3Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }

    /**
     * Displays a single Was3 model.
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
     * Creates a new Was3 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $session = Yii::$app->session;
        $QueryWas1 = new Query;
        $connection = \Yii::$app->db;
        //Saran sementara di hilangkan $query = "select * from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and tgl_disposisi_jamwas is not null and id_saran='3'";
        $query = "select * from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and  was1_tgl_disposisi is not null ";
        $QueryWas1 = $connection->createCommand($query)->queryAll();

		$connection = \Yii::$app->db;
        $query1 = "select perihal_lapdu from was.lapdu where no_register='".$_SESSION['was_register']."' and id_tingkat='".['kode_tk']."' and id_kejati='".['kode_kejati']."' and id_kejari='".['kode_kejari']."' and id_cabjari='".['kode_cabjari']."'";
        $modelLapdu = $connection->createCommand($query1)->queryAll();
			
        if(count($QueryWas1)>0){
             // echo "harus sudah ada disposisi jamwas dan saran adalah di  kepada bidang teknis terkait";
        // if (isset($_SESSION['was_register']) && !empty($_SESSION['was_register'])) {
        //   $findWas = Was3::find()->where("no_register = :id",[":id"=>$_SESSION['was_register']])->asArray()->one();
           $findWas = Was3::find()->where(["no_register" => $_SESSION['was_register'],"id_tingkat" => $_SESSION['kode_tk'],"id_kejati" => $_SESSION['kode_kejati'],"id_kejari" => $_SESSION['kode_kejari'],"id_cabjari" => $_SESSION['kode_cabjari'] ])->asArray()->one();
             if(isset($findWas) && count($findWas > 0)){
                              
                  
                  // echo "sudah memenuhi disposisi jamwas dan masuk ke halaman update karena data sudah ada";
                  return $this->redirect(['update', 'id' => $findWas['id_was3'] , 'id_register' => $_SESSION['was_register'] , 'id_tingkat' => $_SESSION['kode_tk'] , 'id_kejati' => $_SESSION['kode_kejati'] , 'id_kejari' => $_SESSION['kode_kejari'] , 'id_cabjari' => $_SESSION['kode_cabjari']]); 
             }else{
                // echo "sudah memenuhi disposisi jamwas dan masuk ke halaman create karena data was 2 tidak ada";
             // }
        $model = new Was3();
		$model->created_by = \Yii::$app->user->identity->id;
		$model->created_ip = $_SERVER['REMOTE_ADDR'];
        
        $modelTembusan = new TembusanWas2();
        $modelPenandatangan=Was1Pemeriksa::find()
                   ->where(['nip'=>$_SESSION['nik_user']])
                   ->all();
	   
	   
        if ($model->load(Yii::$app->request->post()) ) {
           
            $files = \yii\web\UploadedFile::getInstance($model,'was3_file');
           // store the source file name

            $OldFile      =$model->was3_file;
            $var          =str_split($_SESSION['is_inspektur_irmud_riksa']);
            
            $errors       =array();
            $file_name    =$_FILES['was3_file']['name'];
            $file_size    =$_FILES['was3_file']['size'];
            $file_tmp     =$_FILES['was3_file']['tmp_name'];
            $file_type    =$_FILES['was3_file']['type'];
            $tmp          =explode('.',$_FILES['was3_file']['name']);
            $file_exists  =end($tmp);
            $rename_file  =$var[0].'_'.$_SESSION['was_register'].'.'.$file_exists;

            $model->no_register      = $_SESSION['was_register'];      
			$model->id_pelapor       ='';
			$model->id_terlapor_awal ='';
           // $model->inst_satkerkd    = $_SESSION['inst_satkerkd'];
            $model->no_register      = $_SESSION['was_register'];
            $model->id_tingkat       = $_SESSION['kode_tk'];
            $model->id_kejati        = $_SESSION['kode_kejati'];
            $model->id_kejari        = $_SESSION['kode_kejari'];
            $model->id_cabjari       = $_SESSION['kode_cabjari'];
            $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
            $model->created_time     = date('Y-m-d H:i:s');
            $model->created_ip       = $_SERVER['REMOTE_ADDR'];
            $model->created_by       = \Yii::$app->user->identity->id;
            /*$model->id_wilayah  = 1;
            $model->id_level1   = 1;
            $model->id_level2   = 1;
            $model->id_level3   = 1;
            $model->id_level4   = 1;*/
            $model->was3_file   =($file_name==''?$OldFile:$rename_file);  
            $connection  = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
          try {

            if($model->save()){
               
            $pejabat =  $_POST['pejabat'];
            for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas2;
                      // $saveTembusan->id_tembusan_was_2 = $pejabat[$i];
                    $saveTembusan->from_table = 'Was-3';
                    $saveTembusan->pk_in_table = strval($model->id_was3);
                    $saveTembusan->tembusan = $_POST['pejabat'][$i];
                    $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                    $saveTembusan->created_time = date('Y-m-d H:i:s');
                    $saveTembusan->created_by = \Yii::$app->user->identity->id;
                    $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];    
                    $saveTembusan->no_register = $_SESSION['was_register'];
                    $saveTembusan->id_tingkat  = $_SESSION['kode_tk'];
                    $saveTembusan->id_kejati   = $_SESSION['kode_kejati'];
                    $saveTembusan->id_kejari   = $_SESSION['kode_kejari'];
                    $saveTembusan->id_cabjari  = $_SESSION['kode_cabjari'];
                      
                 //   $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];
                    $saveTembusan->save();
                   /* $saveTembusan = new TembusanWas3;
                    $saveTembusan->from_table = 'Was-3';
                    $saveTembusan->pk_in_table = $model->id_was3;
                    $saveTembusan->tembusan = $pejabat[$i];
                    $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                    $saveTembusan->created_time = date('Y-m-d H:i:s');
                    $saveTembusan->created_by = \Yii::$app->user->identity->id;
                    //$saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];
                    $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];    
                    $saveTembusan->no_register = $_SESSION['was_register'];
                    $saveTembusan->id_tingkat  = $_SESSION['kode_tk'];
                    $saveTembusan->id_kejati   = $_SESSION['kode_kejati'];
                    $saveTembusan->id_kejari   = $_SESSION['kode_kejari'];
                    $saveTembusan->id_cabjari  = $_SESSION['kode_cabjari'];
                    $saveTembusan->save();*/
                }
                $transaction->commit();
                 if ($files != false) {
                    move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_3/'.$rename_file);
                    return $this->redirect(['index']);
                }
                 if($_POST['print']=='1'){
                    $this->cetak($model->id_was3);
                 }
                   Yii::$app->getSession()->setFlash('success', [
                      'type' => 'success',
                     'duration' => 3000,
                     'icon' => 'fa fa-users',
                     'message' => 'Data Berhasil di Simpan',
                     'title' => 'Simpan Data',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                         //   return $this->redirect(['update', 'id' => $model->id_was3]);
                            return $this->redirect(['update', 'id' => $model->id_was3 , 'id_register' => $model->no_register , 'id_tingkat' => $model->id_tingkat , 'id_kejati' => $model->id_kejati , 'id_kejari' => $model->id_kejari , 'id_cabjari' => $model->id_cabjari]);
                }else{
                        Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 3000,
                     'icon' => 'fa fa-users',
                     'message' => 'Data Gagal di Simpan',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                               return $this->render('create', [
                                'model' => $model,
                                 'modelTembusan' => $modelTembusan,
                                   'modelPenandatangan' => $modelPenandatangan, 
								   'modelLapdu' => $modelLapdu, 
                                
                            ]);
        }

        } catch (Exception $e) {
                $transaction->rollback();
              }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
                                   'modelPenandatangan' => $modelPenandatangan,
								   'modelLapdu' => $modelLapdu, 
            ]);
        }
          }
        // }else{
        //     $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was1/index"));
        // }
        }else{
             Yii::$app->getSession()->setFlash('success', [
                      'type' => 'danger',
                     'duration' => 3000,
                     'icon' => 'fa fa-users',
                     'message' => 'Belum Ada data Yang Dapat Di proses Di Was-3',
                     'title' => 'Simpan Data',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
             $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was1/index"));
        }
    }

    /**
     * Updates an existing Was3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
        $model = $this->findModel($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
		//$model->updated_by = \Yii::$app->user->identity->id;
		$modelTembusan = TembusanWas2::find()
        ->where(["pk_in_table" => $id, "no_register" => $id_register,"id_tingkat" => $id_tingkat,"id_kejati" => $id_kejati,"id_kejari" => $id_kejari,"id_cabjari" => $id_cabjari ])
        //->where("pk_in_table = :id",[":id"=>$model['id_was2']])
        ->andWhere("from_table='Was-3'")
        ->asArray()->all();
        $OldFile      =$model->was3_file;
        $var          =str_split($_SESSION['is_inspektur_irmud_riksa']);

        $errors       =array();
        $file_name    =$_FILES['was3_file']['name'];
        $file_size    =$_FILES['was3_file']['size'];
        $file_tmp     =$_FILES['was3_file']['tmp_name'];
        $file_type    =$_FILES['was3_file']['type'];
        $tmp          =explode('.',$_FILES['was3_file']['name']);
        $file_exists  =end($tmp);
        $rename_file  =$var[0].'_'.$id_register.'.'.$file_exists;
		
       /* $oldFileName = $model->was3_file;
        $oldFile = (isset($model->was3_file) ? Yii::$app->params['uploadPath'] .'was_3/'. $model->was3_file : null);*/
         if ($model->load(Yii::$app->request->post()) ) {
             $delete_tembusan = $_POST['delete_tembusan'];
             $delete_tembusan = explode("#",$delete_tembusan);
            
            $model->no_register = $_SESSION['was_register'];
            $model->id_tingkat  = $_SESSION['kode_tk'];
            $model->id_kejati   = $_SESSION['kode_kejati'];
            $model->id_kejari   = $_SESSION['kode_kejari'];
            $model->id_cabjari  = $_SESSION['kode_cabjari'];
            $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa']; 
            $model->was3_file   = ($file_name==''?$OldFile:$rename_file);
            $model->created_time= date('Y-m-d H:i:s');
            $model->created_ip  = $_SERVER['REMOTE_ADDR'];
            $model->created_by  = \Yii::$app->user->identity->id; 
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try {
            if($model->save()){
                // if(count($delete_tembusan) > 1){
                //    for($j=1;$j<count($delete_tembusan);$j++){
                //        $deleteTembusan = TembusanWas3::find()->where('id_pejabat_tembusan = :id and id_was_3 = :id_was',[":id"=>$delete_tembusan[$j],":id_was"=>$model->id_was_3])->one();
                //         $deleteTembusan->delete();
                //    }
                // }
                // print_r($pejabat);
                // exit();
                $pejabat =  $_POST['pejabat'];
                TembusanWas2::deleteAll("pk_in_table = '".$id."'");
                for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas2;
                    // $saveTembusan->id_tembusan_was_2 = $pejabat[$i];
                    $saveTembusan->from_table = 'Was-3';
                    $saveTembusan->pk_in_table= strval($model->id_was3);
                    $saveTembusan->tembusan   = $pejabat[$i];
                    $saveTembusan->updated_ip = $_SERVER['REMOTE_ADDR'];
                    $saveTembusan->updated_time = date('Y-m-d H:i:s');
                    $saveTembusan->updated_by = \Yii::$app->user->identity->id;
                  //  $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];
                    $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];    
                    $saveTembusan->no_register = $_SESSION['was_register'];
                    $saveTembusan->id_tingkat  = $_SESSION['kode_tk'];
                    $saveTembusan->id_kejati   = $_SESSION['kode_kejati'];
                    $saveTembusan->id_kejari   = $_SESSION['kode_kejari'];
                    $saveTembusan->id_cabjari  = $_SESSION['kode_cabjari'];

                    $saveTembusan->save();
                }
             $transaction->commit();
           //  if ($files != false) { // delete old and overwrite
                    // unlink($oldFile);
                    move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_3/'.$rename_file);
                    return $this->redirect(['index']);
           //     }
                 if($_POST['print']=='1'){
                    $this->cetak($model->id_was3);
                 }   
             Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Berhasil di Simpan',
                 'title' => 'Update Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                  'showProgressbar' => true,
             ]);    
                        return $this->redirect(['update', 'id' => $model->id_was3 , 'id_register' => $model->no_register , 'id_tingkat' => $model->id_tingkat , 'id_kejati' => $model->id_kejati , 'id_kejari' => $model->id_kejari , 'id_cabjari' => $model->id_cabjari]);
                         }else{
                             $transaction->rollback();
                             Yii::$app->getSession()->setFlash('success', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Gagal di Update',
                 'title' => 'Error',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
             ]);
              return $this->redirect(['update', 'id' => $model->id_was3 , 'id_register' => $model->no_register , 'id_tingkat' => $model->id_tingkat , 'id_kejati' => $model->id_kejati , 'id_kejari' => $model->id_kejari , 'id_cabjari' => $model->id_cabjari]);
            }
           } catch(Exception $e) {

                    $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
               'modelTembusan' => $modelTembusan,
            ]);
        }
    }

    /**
     * Deletes an existing Was3 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
       $id = $_POST['id'];
         $transaction = Yii::$app->db->beginTransaction();
        try {
        $updateData = $this->findModel($id);
        $updateData->flag = 3;
        $updateData->save();
         $transaction->commit();
      
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
        return $this->redirect('create');
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

            return $this->redirect('create');
        }
    }

    /**
     * Finds the Was3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel_old($id)
    {
        if (($model = Was3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

      protected function findModel($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
       /* $model = Was2::findOne($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
             return $model;*/
        if (($model = Was3::findOne(['no_register' => $id_register,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

      public function actionViewpdf($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
       $file_upload=$this->findModel($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);


     //    print_r($file_upload['was2_file']);
     //    exit();
          $filepath = '../modules/pengawasan/upload_file/was_3/'.$file_upload['was3_file'];
        $extention=explode(".", $file_upload['was3_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['was3_file'] . '"');
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

     public function actionViewpdf1($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
       $file_upload=$this->findModel($id);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_3/'.$file_upload['was3_file'];
        $extention=explode(".", $file_upload['was3_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['was3_file'] . '"');
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

 public function actionCetak($no_register,$id_was3,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){

        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query1 = "select a.*
                    ,a.kepada_lapdu    
                    ,a.tanggal_surat_lapdu as tanggal_lapdu
                    ,a.ringkasan_lapdu
                    ,b.nama_penandatangan
                    ,b.jabatan_penandatangan
                    ,b.golongan_penandatangan
                    ,b.pangkat_penandatangan
                    ,b.jbtn_penandatangan
                    ,b.was3_perihal
                    ,b.was3_lampiran
                    ,b.was3_tanggal
                    ,d.jabatan as was3_kepada
                    ,b.no_surat
                    ,d.jabatan
                    ,b.id_was3
                    ,b.is_inspektur_irmud_riksa
                    ,COALESCE(b.nip_penandatangan,b.nip_penandatangan) as peg_nip 
                    from was.lapdu a
                    inner join was.was3 b on a.no_register=b.no_register
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    inner join was.v_pejabat_pimpinan d on b.was3_kepada::varchar=d.id_jabatan_pejabat::varchar
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and b.id_was3='".$id_was3."' and b.is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
        $model = $connection->createCommand($query1)->queryOne();

        $query2 = "select a.* from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$model['id_was3']."' and a.from_table='Was-3' and a.is_inspektur_irmud_riksa='".$model['is_inspektur_irmud_riksa']."'";
        $model2 = $connection->createCommand($query2)->queryAll();

        $query3 = "select string_agg(a.nama_terlapor_awal,',') as nama_terlapor_awal from was.terlapor_awal a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'";
        $model3 = $connection->createCommand($query3)->queryOne();

        $query4 = "select string_agg(a.nama_pelapor,',') as nama from was.pelapor a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'";
        $model4 = $connection->createCommand($query4)->queryOne();

      /*  print_r($query3);
        exit();*/

        $tgl     = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['was3_tanggal'])));
        $tglLapdu= GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_lapdu'])));
        
        return $this->render('cetak',['model'=>$model ,'tgl'=>$tgl,'tglLapdu'=>$tglLapdu,'data_satker'=>$data_satker,'model2'=>$model2,'model3'=>$model3,'model4'=>$model4]);
    }

public function actionCetak_old($no_register,$id_was3){
        
$odf = new Odf(Yii::$app->params['reportPengawasan']."was_3.odt");
$sql1 = new Query;
$sql1->select('c.inst_nama as satker_was_1,c.inst_lokinst
,j.jabatan as kpd_was3
,b.no_surat
,b.was3_tanggal
,b.was3_lampiran
,a.tanggal_surat_lapdu
,b.nama_penandatangan
,b.jabatan_penandatangan
,b.golongan_penandatangan
,b.pangkat_penandatangan
,b.jbtn_penandatangan
,a.perihal_lapdu
,b.was3_perihal
,a.ringkasan_lapdu
,a.kepada_lapdu
,a.tembusan_lapdu
,d.id_jabatan
,COALESCE(b."nip_penandatangan",b."nip_penandatangan") as peg_nip');
        $sql1->from("was.lapdu a");
        $sql1->join("inner join", "was.was3 b", "(a.no_register=b.no_register)");
		$sql1->join("inner join", "was.jabatan_pejabat j", "(b.was3_kepada=j.id_jabatan_pejabat::varchar)");
		$sql1->join("inner join", "kepegawaian.kp_inst_satker c", "(a.inst_satkerkd=c.inst_satkerkd)");
		$sql1->join("inner join", "was.penandatangan_surat d", "(b.nip_penandatangan=d.nip)");
        $sql1->where("a.no_register ='".$no_register."' ");
        $command = $sql1->createCommand();
        $data = $command->queryOne(); 
        
        $sql2 = new Query;
        $sql2->select('*');
        $sql2->from("was.terlapor_awal");
        $sql2->where("no_register ='".$no_register."' ");
        $command2 = $sql2->createCommand();
        $data2 = $command2->queryAll(); 
        
       
        $sql3 = new Query;
        $sql3->select('*');
        $sql3->from("was.pelapor");
        $sql3->where("no_register ='".$no_register."' ");
        $command3 = $sql3->createCommand();
        $data3 = $command3->queryAll(); 
        
		//tembusan
        $sql4 = new Query;
        $sql4->select('a.tembusan');
        $sql4->from("was.tembusan_was a");
        $sql4->join("inner join", "was.was3 b", "(a.pk_in_table=b.id_was3)");
        $sql4->where("b.id_was3 = :idWas",[":idWas"=>$id_was3]);
        $command4 = $sql4->createCommand();
        $data4 = $command4->queryAll(); 
		$listTembusan1 = $command4->queryAll();
        foreach ($listTembusan1 as $key) {
            $dft_tembusan1 .= $key[tembusan] . ',';
			}
		$odf->setVars('kejaksaan', $data['satker_was_1']);
        $odf->setVars('tempat', 'Jakarta');
        $odf->setVars('kepada',  $data['kpd_was3']);
         //$odf->setVars('dari',  $data['dari']);
        $odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['was3_tanggal']));
		$odf->setVars('tanggalLapdu',  $data['tanggal_surat_lapdu']);
        $odf->setVars('nomor',$data['no_surat']);
        //$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
        $odf->setVars('namaTerlapor', $data2[0]['nama_terlapor_awal']);
        $odf->setVars('pelapor',  (!empty($data3[0]['nama_pelapor'])?$data3[0]['nama_pelapor'] : ""));
        $odf->setVars('perihal',  $data['was3_perihal']);
        $odf->setVars('kepada_lapdu1',  $data['kepada_lapdu']);
		$odf->setVars('tembusan_lapdu1',  $data['tembusan_lapdu']);
		$odf->setVars('ringkasan',  $data['ringkasan_lapdu']);
		
		$sts =(substr($data['id_jabatan'],0,1));;
		/* print_r($sts);
		exit(); */
		if($sts=='0'){ //jabatansbenernya
			/* $odf->setVars('jabatanPenandatangan', '');
			$odf->setVars('jabatan', $data['jbtn_penandatangan']);
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
			$odf->setVars('nipTandatangan', ''); */
			$odf->setVars('jabatanPenandatangan', $data['jabatan_penandatangan']);
			$odf->setVars('jabatan', '');
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
			$odf->setVars('nipTandatangan',  $data['pangkat_penandatangan'].' / NIP. '.$data['peg_nip']);
		}elseif($sts=='1'){ //AN.
			$odf->setVars('jabatanPenandatangan', $data['jabatan_penandatangan']);
			$odf->setVars('jabatan', $data['jbtn_penandatangan']);
			$odf->setVars('nipTandatangan',  $data['pangkat_penandatangan'].' / NIP. '.$data['peg_nip']);
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
		}elseif($sts=='2'||$sts=='3'){ //Plt. & Plh.
			$odf->setVars('jabatanPenandatangan', $data['jabatan_penandatangan']);
			$odf->setVars('jabatan', '');
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
			$odf->setVars('nipTandatangan',  $data['pangkat_penandatangan'].' / NIP. '.$data['peg_nip']);
			}
		
		//$odf->setVars('jabatanPenandatangan', $data['jabatan_penandatangan']);
        /* if(($data['status_penandatangan'])==0){
		$odf->setVars('jabatanPenandatangan', $data['jabatan_penandatangan']);
		}elseif(($data['status_penandatangan'])==1){
		$odf->setVars('jabatanPenandatangan',  "AN. ".$data['jabatan_penandatangan']);
		}elseif(($data['status_penandatangan'])==2){
		$odf->setVars('jabatanPenandatangan',  "PLT. ".$data['jabatan_penandatangan']);
		}elseif(($data['status_penandatangan'])==3){
		$odf->setVars('jabatanPenandatangan',  "PLH. ".$data['jabatan_penandatangan']);
		} */
		//$odf->setVars('nipTandatangan',  $data['peg_nip']);
        $terbilang = new Terbilang();
		if (strlen($data['was2_lampiran']) > 4) {  
		$odf->setVars('lampiran',  $data['was3_lampiran']);
		}else{
		$odf->setVars('lampiran',  $data['was3_lampiran'] .'('.(!empty($data['was3_lampiran'])?$terbilang->convert(trim($data['was3_lampiran'])):'').')');
		}
        //$odf->setVars('tembusan1', $dft_tembusan1);
        $dft_tembusan = $odf->setSegment('tembusan');
        $i = 1;
        foreach($data4 as $dataTembusan){
          $dft_tembusan->tembusanJabatan($i.". ".$dataTembusan['tembusan']);
           $dft_tembusan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_tembusan);
      
     
		$no_register1 = str_replace("/","",$no_register);
        $odf->exportAsAttachedFile("was3_".$no_register1.".odt");
        Yii::$app->end();
    }
}
