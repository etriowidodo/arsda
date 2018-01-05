<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\WasDisposisiInspektur;
use app\modules\pengawasan\models\WasDisposisiInspekturSearch;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFuncComponent; 
use yii\db\Query;
use yii\db\Command;
use yii\web\Session;


/**
 * InspekturController implements the CRUD actions for WasDisposisiInspektur model.
 */
class InspekturController extends Controller
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
     * Lists all WasDisposisiInspektur models.
     * @return mixed
     */
    public function actionIndex()
    {
       $session = new Session();

         if(($session->get('was_register')) !=""){
        //     // $session->remove('id_perkara');
        //     // $session->remove('nomor_perkara');
        //     // $session->remove('tgl_perkara');
            $session->remove('was_register');

            
        }

        $searchModel = new LapduSearch();
        // $dataProvider = $searchModel->searchinspektur(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize = 15;

    $connection = \Yii::$app->db;
    $query1 = "select distinct A .no_register, A .id_wilayah, A .id_tingkat, A .id_kejati, A .id_kejari, A .id_cabjari,a.perihal_lapdu,a.created_time from was.lapdu a left join was.terlapor_awal b on a.no_register=b.no_register left join was.pelapor c on a.no_register=c.no_register left join was.sumber_laporan d on c.id_sumber_laporan=d.id_sumber_laporan where b.id_inspektur= '".$_SESSION['inspektur']."' and a.tgl_disposisi is not null order by a.created_time DESC";
        $query = $connection->createCommand($query1)->queryAll();


        return $this->render('index', [
            'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'query' => $query,
            
        ]);
    }

    /**
     * Displays a single WasDisposisiInspektur model.
     * @param integer $no_urut
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $urut_terlapor
     * @return mixed
     */
    public function actionView($no_urut, $id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $urut_terlapor)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_urut, $id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $urut_terlapor),
        ]);
    }

    /**
     * Creates a new WasDisposisiInspektur model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {

        $queryBerupa = new Query;
        $model = new WasDisposisiInspektur();
        $modelLapdu=Lapdu::find()->where(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']])->one();

        $queryBerupa->select("case when (b.id_sumber_laporan='13' or b.id_sumber_laporan='11') then coalesce(b.sumber_lainnya,a.nama_sumber_laporan) else (a.nama_sumber_laporan) end as nama_sumber_laporan,
                            sumber_lainnya as sumberlain, b.id_tingkat,b.id_kejati,b.id_kejari,id_cabjari,b.no_urut,b.no_register,b.id_sumber_laporan,b.nama_pelapor,b.alamat_pelapor,b.telp_pelapor,b.email_pelapor,
                            b.pekerjaan_pelapor,b.sumber_lainnya,
                            b.tempat_lahir_pelapor,b.tanggal_lahir_pelapor,b.kewarganegaraan_pelapor,b.agama_pelapor,b.pendidikan_pelapor,b.nama_kota_pelapor")
                ->from("was.sumber_laporan a")
                ->join("inner join","was.pelapor b","a.id_sumber_laporan = b.id_sumber_laporan")
                   ->where(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
        $pelapor = $queryBerupa->all();

        $connection = \Yii::$app->db;
        $queryTerlapor1="select*from was.v_wilayah_pelanggaran where no_register='".$id."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_inspektur='".$_SESSION['inspektur']."'";                
        $queryTerlapor2 = $connection->createCommand($queryTerlapor1);
        $terlapor = $queryTerlapor2->queryAll();
        $OldFile=$terlapor[0]['file_inspektur'];
        

        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {

            $var          =str_split($_SESSION['is_inspektur_irmud_riksa']);
            $x            =$_SESSION['inspektur'];

            $errors       = array();
            $file_name    = $_FILES['file_inspektur']['name'];
            $file_size    =$_FILES['file_inspektur']['size'];
            $file_tmp     =$_FILES['file_inspektur']['tmp_name'];
            $file_type    =$_FILES['file_inspektur']['type'];
            $tmp          = explode('.', $_FILES['file_inspektur']['name']);
            $file_exists  = end($tmp);

            $no_reg       = str_replace('/', '_', $id);
            $rename_file  =$var[0].'_'.$no_reg.'.'.$file_exists;

                  $noTerlaporPegasum =$_POST['no_urut'];

            
             $no=1; 
             $jml=0;
            
           for($j=0;$j<count($noTerlaporPegasum);$j++){

            for($i=0;$i<3;$i++){
                $saveDisposisi = new WasDisposisiInspektur();
                $saveDisposisi->no_urut =$no;
                $saveDisposisi->urut_terlapor =$_POST['no_urut'][$j];
                $saveDisposisi->no_register =$id;
                $saveDisposisi->no_register =$_POST['no_register'];
                $saveDisposisi->id_tingkat =$_SESSION['kode_tk'];
                $saveDisposisi->id_kejati =$_SESSION['kode_kejati'];
                $saveDisposisi->id_kejari =$_SESSION['kode_kejari'];
                $saveDisposisi->id_cabjari =$_SESSION['kode_cabjari'];
                $saveDisposisi->id_irmud =$_POST['cek_1'][$jml];
                $saveDisposisi->file_inspektur =($file_name==''?$OldFile:$rename_file);
                $saveDisposisi->id_inspektur =$_SESSION['inspektur'];
                // if(!empty($_POST['tanggal_dis_inspektur'])){
                // $saveDisposisi->tanggal_disposisi =date('Y-m-d', strtotime($_POST['tanggal_dis_inspektur']));
                // }
                $saveDisposisi->isi_disposisi =$_POST['WasDisposisiInspektur']['isi_disposisi'];
                $saveDisposisi->tanggal_disposisi =$_POST['WasDisposisiInspektur']['tanggal_disposisi'];
                $saveDisposisi->status ='LAPDU';
                // $saveDisposisi->id_wilayah = 1;
                // $saveDisposisi->id_level1  = 1;
                // $saveDisposisi->id_level2  = 1;
                // $saveDisposisi->id_level3  = 1;
                // $saveDisposisi->id_level4  = 1;
                $saveDisposisi->created_ip = $_SERVER['REMOTE_ADDR'];
                $saveDisposisi->created_time = date('Y-m-d h:i:sa');
                $saveDisposisi->created_by = \Yii::$app->user->identity->id;
                // echo $_POST['cek_1'][$jml];
                // exit();
                $saveDisposisi->save();
                $no++;
                $jml++;
              }
                
          }

          move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'lapdu/inspektur/'.$rename_file);
            $transaction->commit();
            return $this->redirect(['index']);
        } catch (Exception $e) {
            $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}        
        }
        } else {
            return $this->render('create', [
                'model' => $model,
                'pelapor' => $pelapor,
                'terlapor' => $terlapor,
                'modelLapdu' => $modelLapdu,
            ]);
        }
    }

    /**
     * Updates an existing WasDisposisiInspektur model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $no_urut
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $urut_terlapor
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $connection = \Yii::$app->db;

        $cek = WasDisposisiInspektur::find()
                ->where(['id_inspektur'=>$_SESSION['inspektur'],'id_tingkat' => $_SESSION['kode_tk'],
                       'id_kejati' => $_SESSION['kode_kejati'], 'id_kejari' => $_SESSION['kode_kejari'], 
                       'id_cabjari' => $_SESSION['kode_cabjari'], 'no_register' => $id])
                ->exists();
       if($cek==''){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/inspektur/create?id=".$id."&id_tingkat=".$_SESSION['kode_tk']."&id_kejati=".$_SESSION['kode_kejati']."&id_kejari=".$_SESSION['kode_kejari']."&id_cabjari=".$_SESSION['kode_cabjari']));
       }else{
          //print_r('isi');
       // exit();
        // $queryTerlapor1="select*from was.was_disposisi_irmud where no_register='".$id."' and id_tingkat='".$_SESSION['kode_tk']."' 
        //                 and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_inspektur='".$_SESSION['inspektur']."'";  

        $queryBerupa = new Query;
        $model = $this->findModel($id);
        $modelLapdu=Lapdu::find()->where(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']])->one();

        $queryBerupa->select("case when (b.id_sumber_laporan='13' or b.id_sumber_laporan='11') then coalesce(b.sumber_lainnya,a.nama_sumber_laporan) else (a.nama_sumber_laporan) end as nama_sumber_laporan,
                            sumber_lainnya as sumberlain, b.id_tingkat,b.id_kejati,b.id_kejari,id_cabjari,b.no_urut,b.no_register,b.id_sumber_laporan,b.nama_pelapor,b.alamat_pelapor,b.telp_pelapor,b.email_pelapor,
                            b.pekerjaan_pelapor,b.sumber_lainnya,
                            b.tempat_lahir_pelapor,b.tanggal_lahir_pelapor,b.kewarganegaraan_pelapor,b.agama_pelapor,b.pendidikan_pelapor,b.nama_kota_pelapor")
                ->from("was.sumber_laporan a")
                ->join("inner join","was.pelapor b","a.id_sumber_laporan = b.id_sumber_laporan")
                   ->where(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
        $pelapor = $queryBerupa->all();

    
        $queryTerlapor1="select*from was.v_inspektur_irmud where no_register='".$id."' and id_tingkat='".$_SESSION['kode_tk']."' 
                        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_inspektur='".$_SESSION['inspektur']."'";  

        $queryTerlapor2 = $connection->createCommand($queryTerlapor1);
        $terlapor = $queryTerlapor2->queryAll();
        $OldFile=$terlapor[0]['file_inspektur'];
        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            $var          =str_split($_SESSION['is_inspektur_irmud_riksa']);
            $x            =$_SESSION['inspektur'];
            $errors       = array();
            $file_name    = $_FILES['file_inspektur']['name'];
            $file_size    =$_FILES['file_inspektur']['size'];
            $file_tmp     =$_FILES['file_inspektur']['tmp_name'];
            $file_type    =$_FILES['file_inspektur']['type'];
            $tmp = explode('.', $_FILES['file_inspektur']['name']);
            $file_exists = end($tmp);
            $rename_file  =$var[0].'_'.$id.'.'.$file_exists;

            $noTerlaporPegasum =$_POST['no_urut'];

           $no=1;
           $jml=0;
           for($j=0;$j<count($noTerlaporPegasum);$j++){
                for($i=0;$i<3;$i++){
                $saveDisposisi = WasDisposisiInspektur::find()->where("no_register='".$id."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_inspektur='".$_SESSION['inspektur']."' and  no_urut='".$no."'")->one();
                $saveDisposisi->isi_disposisi =$_POST['WasDisposisiInspektur']['isi_disposisi'];
                $saveDisposisi->tanggal_disposisi =$_POST['WasDisposisiInspektur']['tanggal_disposisi'];
                $saveDisposisi->file_inspektur =($file_name==''?$OldFile:$rename_file);
                $saveDisposisi->id_irmud =$_POST['cek_1'][$jml];
            $saveDisposisi->update(); 
            $no++;
            $jml++;
              }
              
          }
          move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'lapdu/inspektur/'.$rename_file);
          $transaction->commit();
            return $this->redirect(['index']);
        } catch (Exception $e) {
            $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}        
        }

        } else {
            return $this->render('update', [
                'model' => $model,
                'pelapor' => $pelapor,
                'terlapor' => $terlapor,
                'modelLapdu' => $modelLapdu,
            ]);
        }
      }  
    }


     public function actionViewpdf($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
       // $file_upload=$this->findModel($id);
       $file_upload=WasDisposisiInspektur::findOne(["no_register"=>$id,"id_inspektur"=>$_SESSION['inspektur'],"id_tingkat"=>$id_tingkat,"id_kejati"=>$id_kejati,"id_kejari"=>$id_kejari,"id_cabjari"=>$id_cabjari]);
        // print_r($file_upload['file_inspektur']);
        // exit();

          $filepath = '../modules/pengawasan/upload_file/lapdu/inspektur/'.$file_upload['file_inspektur'];
        $extention=explode(".", $file_upload['file_inspektur']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_inspektur'] . '"');
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

     public function actionViewpdf1($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
     
      $file_upload=Lapdu::findOne(["no_register"=>$id,"id_tingkat"=>$id_tingkat,"id_kejati"=>$id_kejati,"id_kejari"=>$id_kejari,"id_cabjari"=>$id_cabjari]);
        
          $filepath = '../modules/pengawasan/upload_file/lapdu/'.$file_upload['file_lapdu'];
        $extention=explode(".", $file_upload['file_lapdu']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_lapdu'] . '"');
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
     * Deletes an existing WasDisposisiInspektur model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $no_urut
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $urut_terlapor
     * @return mixed
     */
    public function actionDelete($no_urut, $id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $urut_terlapor)
    {
        $this->findModel($no_urut, $id_tingkat, $id_kejati, $id_kejari, $id_cabjari, $no_register, $urut_terlapor)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the WasDisposisiInspektur model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $no_urut
     * @param string $id_tingkat
     * @param string $id_kejati
     * @param string $id_kejari
     * @param string $id_cabjari
     * @param string $no_register
     * @param integer $urut_terlapor
     * @return WasDisposisiInspektur the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WasDisposisiInspektur::findOne(['id_inspektur'=>$_SESSION['inspektur'],'id_tingkat' => $_SESSION['kode_tk'], 'id_kejati' => $_SESSION['kode_kejati'], 'id_kejari' => $_SESSION['kode_kejari'], 'id_cabjari' => $_SESSION['kode_cabjari'], 'no_register' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
