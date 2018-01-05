<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was16c;
use app\modules\pengawasan\models\Was16cSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\components\FungsiComponent; 
use app\models\KpInstSatkerSearch;

/**
 * Was16cController implements the CRUD actions for Was16c model.
 */
class Was16cController extends Controller
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
     * Lists all Was16c models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was16cSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Was16c model.
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $id_sp_was2
     * @param integer $id_ba_was2
     * @param integer $id_l_was2
     * @param integer $id_was15
     * @param integer $id_was_16c
     * @return mixed
     */
    public function actionView($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_16c)
    {
        return $this->render('view', [
            'model' => $this->findModel($id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $id_sp_was2, $id_ba_was2, $id_l_was2, $id_was15, $id_was_16c),
        ]);
    }

    /**
     * Creates a new Was16c model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Was16c();
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_16c','condition2'=>'master'])->all();

        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              
                $model->id_tingkat = $_SESSION['kode_tk'];
                $model->id_kejati = $_SESSION['kode_kejati'];
                $model->id_kejari = $_SESSION['kode_kejari'];
                $model->id_cabjari = $_SESSION['kode_cabjari'];
                $model->no_register = $_SESSION['was_register'];
                $model->id_sp_was2  = $modelWas15->id_sp_was2;
                $model->id_ba_was2  = $modelWas15->id_ba_was2;
                $model->id_l_was2   = $modelWas15->id_l_was2;
                $model->id_was15    = $modelWas15->id_was15;
                $model->created_ip = $_SERVER['REMOTE_ADDR'];
                $model->created_time = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
            if($model->save()) {

              $pejabat = $_POST['pejabat'];
              TembusanWas2::deleteAll(['from_table'=>'Was-16c','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_16c),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                   for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-16c';
                        $saveTembusan->pk_in_table = strrev($model->id_was_16c);
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
     * Updates an existing Was16c model.
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
     * @param integer $id_was_16c
     * @return mixed
     */
    public function actionUpdate($id_was_16c)
    {

    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }

        $model = $this->findModel($id_was_16c);
        $fungsi=new FungsiComponent();
        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was_16c,'from_table'=>'Was-16c','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();

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
            if($model->save()) {

              if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_16c/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'was_16c/'.$OldFile);
              } 


              $pejabat = $_POST['pejabat'];
              TembusanWas2::deleteAll(['from_table'=>'Was-16c','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was_16c),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                   for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-16c';
                        $saveTembusan->pk_in_table = strrev($model->id_was_16c);
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
              move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_16c/'.$rename_file);
            $transaction->commit();
            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
            ]);
        }
    }

    public function actionViewpdf($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
        $file_upload=$this->findModel($id);
       //$file_upload=Was11::findOne(["id_was_16c"=>$id]);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_16c/'.$file_upload['upload_file'];
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

    public function actionCetakdocx($id_was_16c){
      $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
    $connection = \Yii::$app->db;
    $fungsi=new FungsiComponent();

    $model=$this->findModel($id_was_16c);
    // $where=$fungsi->static_where_alias('a');
    // $query="select * FROM was.was11 a where  
    //       a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
    //                 and a.id_kejati='".$id_kejati."' 
    //                 and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
    //                 and a.id_surat_was11='".$id."' $where";
    // $model = $connection->createCommand($query)->queryOne();
    // $tgl_was_11=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_was_11']);

    
    //    $query3 = "select a.*,b.* from was.pegawai_terlapor a
    //                 inner join was.sp_was_1 b
    //                 on a.id_sp_was1=b.id_sp_was1
    //                 and a.id_tingkat=b.id_tingkat
    //                 and a.id_kejati=b.id_kejati
    //                 and a.id_kejari=b.id_kejari
    //                 and a.id_cabjari=b.id_cabjari
    //                 AND b.id_wilayah=a.id_wilayah
    //               AND b.id_level1=a.id_level1
    //               AND b.id_level2=a.id_level2
    //               AND b.id_level3=a.id_level3
    //               AND b.id_level4=a.id_level4 
    //               AND b.no_register=a.no_register
    //                 where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
    //                 and a.id_kejati='".$id_kejati."' 
    //                 and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
    //                 $where";
    //     $modelterlapor1 = $connection->createCommand($query3)->queryOne();

    //    $tgl_sp_was= \Yii::$app->globalfunc->ViewIndonesianFormat($modelterlapor1['tanggal_sp_was1']);
       
    //    $sql="select a.* from was.was_11_detail_int a where a.id_was_11='".$id."' and a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' and a.id_kejati='".$id_kejati."' 
    //                 and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
    //                 $where";
    //    $saksiIN=$connection->createCommand($sql)->queryAll();

    //    $sql2="select a.* from was.was_11_detail_eks a where a.id_was_11='".$id."' and a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' and a.id_kejati='".$id_kejati."' 
    //                 and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
    //                 $where";
    //    $saksiEK=$connection->createCommand($sql2)->queryAll();
       
    //    $query4 = "select a.* from was.lapdu a
    //                 where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
    //                 and a.id_kejati='".$id_kejati."' 
    //                 and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
    //                ";
    //     $modelLapdu = $connection->createCommand($query4)->queryOne();

    //     $query5 = "select string_agg(a.nama_pegawai_terlapor,', ') as nama_pegawai_terlapor from was.pegawai_terlapor a
    //                 inner join was.sp_was_1 b
    //                 on a.id_sp_was1=b.id_sp_was1
    //                 and a.id_tingkat=b.id_tingkat
    //                 and a.id_kejati=b.id_kejati
    //                 and a.id_kejari=b.id_kejari
    //                 and a.id_cabjari=b.id_cabjari
    //                 AND b.id_wilayah=a.id_wilayah
    //               AND b.id_level1=a.id_level1
    //               AND b.id_level2=a.id_level2
    //               AND b.id_level3=a.id_level3
    //               AND b.id_level4=a.id_level4 
    //               AND b.no_register=a.no_register
    //                 where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
    //                 and a.id_kejati='".$id_kejati."' 
    //                 and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
    //                 and a.id_sp_was1='".$model['id_sp_was']."' $where";
    //     $modelterlapor = $connection->createCommand($query5)->queryOne();


        $query="select * FROM  was.ms_sk where kode_sk='".$model->sk."'";
        $modelSk = $connection->createCommand($query)->queryOne();
     
        $query6 = "select a.* from was.tembusan_was a
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.pk_in_table='".$model['id_was_16c']."' and from_table='Was-16c' $where order by is_order desc";
        $tembusan_was16c = $connection->createCommand($query6)->queryAll();
    
       
       return $this->render('cetak',[
        'data_satker'=>$data_satker,
        'model'=>$model,
        'modelSk'=>$modelSk,
        // 'modelterlapor'=>$modelterlapor,
        // 'tgl_sp_was'=>$tgl_sp_was,
        // 'modelterlapor1'=>$modelterlapor1,
        // 'saksiIN'=>$saksiIN,
        // 'saksiEK'=>$saksiEK,
        // 'modelLapdu'=>$modelLapdu,
        'tembusan_was16c'=>$tembusan_was16c,
        ]);
    }

    /**
     * Deletes an existing Was16c model.
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
     * @param integer $id_was_16c
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['id_was_16c'];
        $jml = $_POST['jml'];
        $pecah = explode(',',$id);
        for ($i=0; $i < $jml; $i++) { 
        $this->findModel($pecah[$i])->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Was16c model based on its primary key value.
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
     * @param integer $id_was_16c
     * @return Was16c the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id_was_16c)
    {
        if (($model = Was16c::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'], 'id_was_16c' => $id_was_16c])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
