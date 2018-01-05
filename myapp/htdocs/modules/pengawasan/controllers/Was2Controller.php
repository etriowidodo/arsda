<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was2;
use app\modules\pengawasan\models\Was2Search;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas2;
use app\modules\pengawasan\models\TembusanWas;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;
use app\modules\pengawasan\models\Was1Pemeriksa;
use Nasution\Terbilang;
use app\models\KpInstSatkerSearch;
use Odf;
use app\components\GlobalFuncComponent; 
use yii\db\Query;
use yii\db\Command;
/**
 * Was2Controller implements the CRUD actions for Was2 model.
 */
class Was2Controller extends Controller
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
     * Lists all Was2 models.
     * @return mixed
     */
    public function actionIndex()
    {
		 $query=Was2::findOne(['no_register'=>$_SESSION['was_register'],['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]]);

        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was2/update?id=".$query->id_was2."&id_register=".$_SESSION['was_register']."&id_tingkat=".$_SESSION['kode_tk']."&id_kejati=".$_SESSION['kode_kejati']."&id_kejari=".$_SESSION['kode_kejari']."&id_cabjari=".$_SESSION['kode_cabjari']));
        }else{                                                     
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was2/create"));
        }
		
/*         $searchModel = new Was2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->rend.er.("index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]); */
    }

    /**
     * Displays a single Was2 model.
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
     * Creates a new Was2 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        
        $session = Yii::$app->session;
        $QueryWas1 = new Query;
        $connection = \Yii::$app->db;
        $query = "select * from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and was1_tgl_disposisi is not null and id_saran='2'";
        $QueryWas1 = $connection->createCommand($query)->queryAll();
		
		$connection = \Yii::$app->db;
        $query1 = "select perihal_lapdu from was.lapdu where no_register='".$_SESSION['was_register']."' and id_tingkat='".['kode_tk']."' and id_kejati='".['kode_kejati']."' and id_kejari='".['kode_kejari']."' and id_cabjari='".['kode_cabjari']."'";
        $modelLapdu = $connection->createCommand($query1)->queryAll();
		
        if(count($QueryWas1)>0){
             // echo "harus sudah ada disposisi jamwas dan saran adalah di  kepada bidang teknis terkait";
        // if (isset($_SESSION['was_register']) && !empty($_SESSION['was_register'])) {
           $findWas = Was2::find()->where(["no_register" => $_SESSION['was_register'],"id_tingkat" => $_SESSION['kode_tk'],"id_kejati" => $_SESSION['kode_kejati'],"id_kejari" => $_SESSION['kode_kejari'],"id_cabjari" => $_SESSION['kode_cabjari'] ])->asArray()->one();
             if(isset($findWas) && count($findWas > 0)){
                              
                  
                  // echo "sudah memenuhi disposisi jamwas dan masuk ke halaman update karena data sudah ada";
                  return $this->redirect(['update', 'id' => $findWas['id_was2'] , 'id_register' => $_SESSION['was_register'] , 'id_tingkat' => $_SESSION['kode_tk'] , 'id_kejati' => $_SESSION['kode_kejati'] , 'id_kejari' => $_SESSION['kode_kejari'] , 'id_cabjari' => $_SESSION['kode_cabjari']]); 
             }else{
                // echo "sudah memenuhi disposisi jamwas dan masuk ke halaman create karena data was 2 tidak ada";
             // }
        $model = new Was2();
        $modelTembusanMaster = TembusanWas::findAll(["for_tabel"=>'was_2']);
        $modelPenandatangan=Was1Pemeriksa::find()
                   ->where(['nip'=>$_SESSION['nik_user']])
                   ->all();

         
        if ($model->load(Yii::$app->request->post()) ) {
            $OldFile      =$model->was2_file;
            $var          =str_split($_SESSION['is_inspektur_irmud_riksa']);
            
            $errors       =array();
            $file_name    =$_FILES['was2_file']['name'];
            $file_size    =$_FILES['was2_file']['size'];
            $file_tmp     =$_FILES['was2_file']['tmp_name'];
            $file_type    =$_FILES['was2_file']['type'];
            $tmp          =explode('.',$_FILES['was2_file']['name']);
            $file_exists  =end($tmp);
            $rename_file  =$var[0].'_'.$_SESSION['was_register'].'.'.$file_exists;
           // store the source file name
            $model->no_register = $_SESSION['was_register'];
            $model->id_tingkat  = $_SESSION['kode_tk'];
            $model->id_kejati   = $_SESSION['kode_kejati'];
            $model->id_kejari   = $_SESSION['kode_kejari'];
            $model->id_cabjari  = $_SESSION['kode_cabjari'];
            $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa']; 
            $model->created_time= date('Y-m-d H:i:s');
            $model->created_ip  = $_SERVER['REMOTE_ADDR'];
            $model->created_by  = \Yii::$app->user->identity->id;
            $model->was2_file   =($file_name==''?$OldFile:$rename_file);   


            //$model->inst_satkerkd = $_SESSION['inst_satkerkd'];
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
          try {

            if($model->save()){
               
            $pejabat =  $_POST['pejabat'];
          //  echo $model->id_was2;
            //exit();
            for($i=0;$i<count($pejabat);$i++){
                    $saveTembusan = new TembusanWas2;
                    // $saveTembusan->id_tembusan_was_2 = $pejabat[$i];
                    $saveTembusan->from_table = 'Was-2';
                    $saveTembusan->pk_in_table = strval($model->id_was2);
                    $saveTembusan->tembusan = $pejabat[$i];
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
                    // print_r($saveTembusan);
                    // exit();
                }

             
                $transaction->commit();
                 if ($files != false) {
                    move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_2/'.$rename_file);
                    return $this->redirect(['index']);
                }
                 if($_POST['print']=='1'){
                    $this->cetak($model->id_was2);
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
                    move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_2/'.$rename_file);
                    return $this->redirect(['index']);
                    /*print_r($saveTembusan);
                    exit();*/
                        //    return $this->redirect(['update', 'id' => $findWas['id_was2'] , ]);     
                            return $this->redirect(['update', 'id' => $model->id_was2 , 'id_register' => $model->no_register , 'id_tingkat' => $model->id_tingkat , 'id_kejati' => $model->id_kejati , 'id_kejari' => $model->id_kejari , 'id_cabjari' => $model->id_cabjari]);
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
                                   'modelTembusanMaster' => $modelTembusanMaster,
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
				'modelTembusanMaster' => $modelTembusanMaster,
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
                     'message' => 'Belum Ada data Yang Dapat Di proses Di Was-2',
                     'title' => 'Akses Ditolak',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
             $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was1/index"));
        }
    }

    /**
     * Updates an existing Was2 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
        $model = $this->findModel($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
        
        $modelTembusan = TembusanWas2::find()
        ->where(["pk_in_table" => $id, "no_register" => $id_register,"id_tingkat" => $id_tingkat,"id_kejati" => $id_kejati,"id_kejari" => $id_kejari,"id_cabjari" => $id_cabjari ])
		//->where("pk_in_table = :id",[":id"=>$model['id_was2']])
		->andWhere("from_table='Was-2'")
		->asArray()->all();
        $OldFile      =$model->was2_file;
        $var          =str_split($_SESSION['is_inspektur_irmud_riksa']);

        $errors       =array();
        $file_name    =$_FILES['was2_file']['name'];
        $file_size    =$_FILES['was2_file']['size'];
        $file_tmp     =$_FILES['was2_file']['tmp_name'];
        $file_type    =$_FILES['was2_file']['type'];
        $tmp          =explode('.',$_FILES['was2_file']['name']);
        $file_exists  =end($tmp);
        $rename_file  =$var[0].'_'.$id_register.'.'.$file_exists;
       /* print_r($modelTembusan);
        exit(); */  
        /*$oldFileName = $model->was2_file;
        $oldFile = (isset($model->was2_file) ? Yii::$app->params['uploadPath'] .'was_2/'. $model->was2_file : null);*/
         if ($model->load(Yii::$app->request->post()) ) {
            
             $delete_tembusan = $_POST['delete_tembusan'];
             $delete_tembusan = explode("#",$delete_tembusan);
            
            /* $files = \yii\web\UploadedFile::getInstance($model,'was2_file');
             if ($files != false) {
                $model->was2_file = $files->name;
            }else{
                $model->was2_file = $oldFileName;
            }*/
            $model->no_register = $_SESSION['was_register'];
            $model->id_tingkat  = $_SESSION['kode_tk'];
            $model->id_kejati   = $_SESSION['kode_kejati'];
            $model->id_kejari   = $_SESSION['kode_kejari'];
            $model->id_cabjari  = $_SESSION['kode_cabjari'];
            $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa']; 
            $model->was2_file   =($file_name==''?$OldFile:$rename_file);
            $model->created_time= date('Y-m-d H:i:s');
            $model->created_ip  = $_SERVER['REMOTE_ADDR'];
            $model->created_by  = \Yii::$app->user->identity->id;
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try {
            if($model->save()){
                // if(count($delete_tembusan) > 1){
                //    for($j=1;$j<count($delete_tembusan);$j++){
                //        $deleteTembusan = TembusanWas2::find()->where('id_pejabat_tembusan = :id and id_was_2 = :id_was',[":id"=>$delete_tembusan[$j],":id_was"=>$model->id_was_2])->one();
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
                    $saveTembusan->from_table = 'Was-2';
                    $saveTembusan->pk_in_table= strval($model->id_was2);
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
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_2/'.$rename_file);
             return $this->redirect(['index']);
             
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
                      //  return $this->redirect(['update', 'id' => $model->id_was2]);
              return $this->redirect(['update', 'id' => $model->id_was2 , 'id_register' => $model->no_register , 'id_tingkat' => $model->id_tingkat , 'id_kejati' => $model->id_kejati , 'id_kejari' => $model->id_kejari , 'id_cabjari' => $model->id_cabjari]);
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
             // return $this->redirect(['update', 'id' => $model->id_was2]);
              return $this->redirect(['update', 'id' => $model->id_was2 , 'id_register' => $model->no_register , 'id_tingkat' => $model->id_tingkat , 'id_kejati' => $model->id_kejati , 'id_kejari' => $model->id_kejari , 'id_cabjari' => $model->id_cabjari]);
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
     * Deletes an existing Was2 model.
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
     * Finds the Was2 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was2 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
       /* $model = Was2::findOne($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
             return $model;*/
        if (($model = Was2::findOne(['no_register' => $id_register,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari])) !== null) {
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
          $filepath = '../modules/pengawasan/upload_file/was_2/'.$file_upload['was2_file'];
        $extention=explode(".", $file_upload['was2_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['was2_file'] . '"');
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
    
    public function actionCetak($no_register,$id_was2,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){

       
        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query1 = "select a.no_register
                    ,b.is_inspektur_irmud_riksa
                    ,b.id_was2
                    ,a.ringkasan_lapdu
                    ,a.kepada_lapdu    
                    ,b.was2_no_surat
                    ,b.was2_tanggal
                    ,b.was2_lampiran
                    ,a.tanggal_surat_lapdu
                    ,b.nama_penandatangan
                    ,b.status_penandatangan
                    ,b.jabatan_penandatangan
                    ,b.pangkat_penandatangan
                    ,b.jbtn_penandatangan
                    ,a.perihal_lapdu
                    ,a.ringkasan_lapdu
                    ,c.jabatan as dari
                    ,d.jabatan as kepada
                    ,COALESCE(b.nip_penandatangan,b.nip_penandatangan) as peg_nip 
                    from was.lapdu a
                    inner join was.was2 b on a.no_register=b.no_register
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    inner join was.v_pejabat_pimpinan c on b.id_dari_was2::varchar=c.id_jabatan_pejabat::varchar
                    inner join was.v_pejabat_pimpinan d on b.id_kepada_was2::varchar=d.id_jabatan_pejabat::varchar
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and b.id_was2='".$id_was2."' and b.is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
        $model = $connection->createCommand($query1)->queryOne();

        $query2 = "select string_agg(a.tembusan,',') as tembusan from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$model['id_was2']."' and a.from_table='Was-2' and a.is_inspektur_irmud_riksa='".$model['is_inspektur_irmud_riksa']."'";
/*print_r($query2);
        exit();*/
        $model2 = $connection->createCommand($query2)->queryOne();

        $query3 = "select string_agg(a.nama_pelapor,',') as nama from was.pelapor a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'";
        $model3 = $connection->createCommand($query3)->queryOne();
        

        $tgl= GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['was2_tanggal'])));
        
        return $this->render('cetak',['model'=>$model ,'tgl'=>$tgl,'data_satker'=>$data_satker,'model2'=>$model2,'model3'=>$model3]);


    }
    
     public function actionCetak_odf($no_register,$id_was2,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
        
         $odf = new Odf(Yii::$app->params['reportPengawasan']."was_2.odt");
        $sql1 = new Query;
        $sql1->select('c.inst_nama as satker_was_1,c.inst_lokinst
,j.jabatan as kpd_was2
,p.jabatan as dari
,b.was2_no_surat
,b.was2_tanggal
,b.was2_lampiran
,a.tanggal_surat_lapdu
,b.nama_penandatangan
,b.status_penandatangan
,b.jabatan_penandatangan
,b.pangkat_penandatangan
,b.jbtn_penandatangan
,a.perihal_lapdu
,a.ringkasan_lapdu
,c.inst_nama as satker_dugaan_pelanggaran
,d.id_jabatan
,COALESCE(b."nip_penandatangan",b."nip_penandatangan") as peg_nip');
        $sql1->from("was.lapdu a");
        $sql1->join("inner join", "was.was2 b", "(a.no_register=b.no_register)");
		$sql1->join("inner join", "was.jabatan_pejabat p", "(b.id_dari_was2=p.id_jabatan_pejabat::varchar)");
		$sql1->join("inner join", "was.jabatan_pejabat j", "(b.id_kepada_was2=j.id_jabatan_pejabat::varchar)");
		$sql1->join("inner join", "kepegawaian.kp_inst_satker c", "(a.inst_satkerkd=c.inst_satkerkd)");
		$sql1->join("inner join", "was.penandatangan_surat d", "(b.nip_penandatangan=d.nip)");
        $sql1->where("a.no_register ='".$no_register."' AND b.id_was2='".$id_was2."'");
        $command = $sql1->createCommand();
        $data = $command->queryOne(); 
        
        $sql2 = new Query;
        $sql2->select('*');
        $sql2->from("was.terlapor_awal");
        $sql2->where("no_register ='".$no_register."' and id_tingkat ='".$id_tingkat."' and id_kejati ='".$id_kejati."' and id_kejari ='".$id_kejari."' id_cabjari ='".$id_cabjari."' ");
        $command2 = $sql2->createCommand();
        $data2 = $command2->queryAll(); 
        
       
        $sql3 = new Query;
        $sql3->select('*');
        $sql3->from("was.pelapor");
        $sql3->where("no_register ='".$no_register."' and id_tingkat ='".$id_tingkat."' and id_kejati ='".$id_kejati."' and id_kejari ='".$id_kejari."' id_cabjari ='".$id_cabjari."' ");
        $command3 = $sql3->createCommand();
        $data3 = $command3->queryAll(); 
        
		//tembusan
        $sql4 = new Query;
        $sql4->select('a.tembusan');
        $sql4->from("was.tembusan_was a");
        $sql4->join("inner join", "was.was2 b", "(a.pk_in_table=b.id_was2)");
        $sql4->where("b.id_was2 = :idWas",[":idWas"=>$id_was2]);
		$sql4->andWhere("a.from_table = 'Was-2'");
        $command4 = $sql4->createCommand();
        $data4 = $command4->queryAll(); 
		$listTembusan1 = $command4->queryAll();
        foreach ($listTembusan1 as $key) {
            $dft_tembusan1 .= $key[tembusan] . ',';
			}
       
        $odf->setVars('kejaksaan', strtoupper($data['satker_was_1']));
        $odf->setVars('kepada',  ucwords(strtolower($data['kpd_was2'])));
         $odf->setVars('dari',  ucwords(strtolower($data['dari'])));
        $odf->setVars('tanggalWas2',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['was2_tanggal']));
        $odf->setVars('nomor',  $data['was2_no_surat']);
        
        $odf->setVars('namaTerlapor', $data2[0]['nama_terlapor_awal']);
        $odf->setVars('pelaporNama',  (!empty($data3[0]['nama_pelapor'])?$data3[0]['nama_pelapor'] : ""));
        $odf->setVars('perihal',  $data['perihal_lapdu']);
        $odf->setVars('ringkasan',  $data['ringkasan_lapdu']);

		
		$sts =(substr($data['id_jabatan'],0,1));;
		/* print_r($sts);
		exit(); */
		
		if($sts=='0'){
			/* $odf->setVars('jabatanalias', '');
			$odf->setVars('jabatan', $data['jbtn_penandatangan']);
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
			$odf->setVars('nipTandatangan', ''); */
			$odf->setVars('jabatanalias', $data['jabatan_penandatangan']);
			$odf->setVars('jabatan', '');
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
			$odf->setVars('nipTandatangan',  $data['pangkat_penandatangan'].' / NIP. '.$data['peg_nip']);
		}elseif($sts=='1'){
			$odf->setVars('jabatanalias', $data['jabatan_penandatangan']);
			$odf->setVars('jabatan', $data['jbtn_penandatangan']);
			$odf->setVars('nipTandatangan',  $data['pangkat_penandatangan'].' / NIP. '.$data['peg_nip']);
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
		}elseif($sts=='2'||$sts=='3'){
			$odf->setVars('jabatanalias', $data['jabatan_penandatangan']);
			$odf->setVars('jabatan', '');
			$odf->setVars('namaTandatangan',  $data['nama_penandatangan']);
			$odf->setVars('nipTandatangan',  $data['pangkat_penandatangan'].' / NIP. '.$data['peg_nip']);
			}
		
        /* if(($data['status_penandatangan'])==0){
		$odf->setVars('jabatanPenandatangan', $data['jabatan_penandatangan']);
		}elseif(($data['status_penandatangan'])==1){
		$odf->setVars('jabatanPenandatangan',  "AN. ".$data['jabatan_penandatangan']);
		}elseif(($data['status_penandatangan'])==2){
		$odf->setVars('jabatanPenandatangan',  "PLT. ".$data['jabatan_penandatangan']);
		}elseif(($data['status_penandatangan'])==3){
		$odf->setVars('jabatanPenandatangan',  "PLH. ".$data['jabatan_penandatangan']);
		} */
		
		
        $terbilang = new Terbilang();
		if (strlen($data['was2_lampiran']) > 4) {  
		$odf->setVars('berkas',  $data['was2_lampiran']);
		}else{
		$odf->setVars('berkas',  $data['was2_lampiran'] .'('.(!empty($data['was2_lampiran'])?$terbilang->convert(trim($data['was2_lampiran'])):'').')');
		}
        $odf->setVars('tembusan1', $dft_tembusan1);
        $dft_tembusan = $odf->setSegment('tembusan');
        $i = 1;
        foreach($data4 as $dataTembusan){
          $dft_tembusan->tembusanJabatan($i.". ".$dataTembusan['tembusan']);
           $dft_tembusan->merge();
            $i++;
        }
        $odf->mergeSegment($dft_tembusan);
        //$odf->setVars('kesimpulan',  $data['kesimpulan']);
        //$odf->setVars('hasilkesimpulan',  $data['hasil_kesimpulan']);
        //$odf->setVars('saran',  $data['saran']);
        //$odf->setVars('tanggal',  \Yii::$app->globalfunc->ViewIndonesianFormat($data['tgl_was_1']));
        //$odf->setVars('tempat',  $data['inst_lokinst']);

        //terlapor
        /* $dft_terlapor = $odf->setSegment('terlapor');
        foreach($data2 as $dataTerlapor){
            $dft_terlapor->terlaporNama($dataTerlapor['peg_nama']);
            $dft_terlapor->terlaporNip($dataTerlapor['peg_nip']);
            $dft_terlapor->terlaporJabatan($dataTerlapor['jabatan']);
            $dft_terlapor->merge();
        }
        $odf->mergeSegment($dft_terlapor); */
        //pelapor
        /*   $dft_pelapor = $odf->setSegment('pelapor');
        foreach($data3 as $dataPelapor){
            $dft_pelapor->pelaporNama($dataPelapor['nama']);
            $dft_pelapor->pelaporAlamat($dataPelapor['alamat']);
           $dft_pelapor->merge();
        }
        $odf->mergeSegment($dft_pelapor);  */
     
		$no_register1 = str_replace("/","",$no_register);
        $odf->exportAsAttachedFile("was2_".$no_register1.".odt");
        Yii::$app->end();
    }
}
