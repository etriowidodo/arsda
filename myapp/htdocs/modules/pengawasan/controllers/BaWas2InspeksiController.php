<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\PemeriksaSpWas2;
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\BaWas2Inspeksi;
use app\modules\pengawasan\models\BaWas2InspeksiSearch;
use app\modules\pengawasan\models\SaksiEksternalInspeksi;
use app\modules\pengawasan\models\SaksiInternalInspeksi;
use app\modules\pengawasan\models\BaWas2InspeksiKesimpulan;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\models\KpInstSatkerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\modules\pengawasan\components\FungsiComponent;
use yii\grid\GridView;
use yii\widgets\Pjax;


/*catatanan untuk bawas2 karena menurut hasil rapat L-was1 itu kesimpulan dari hasil wawancara jadi tidak perlu ada table pemeriksa, saksi internal dan internal */
/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class BaWas2InspeksiController extends Controller
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
     * Lists all InspekturModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        // print_r($_SESSION);
        // exit();
        $model = BaWas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],
            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
            'id_level4'=>$_SESSION['was_id_level4']]);

        // $model = $this->findModel();

       // $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2-inspeksi/create"));
        if($model){
            $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2-inspeksi/update"));
        }else{
            $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2-inspeksi/create"));
        }
    }

    /**
     * Displays a single InspekturModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

    $model = BaWas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],
            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
            'id_level4'=>$_SESSION['was_id_level4']]);
       // $model = $this->findModel();
        // print_r($model);
        // exit();
        if($model){
            $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2-inspeksi/update"));
        }else{
          
        $model = new BaWas2Inspeksi();
        $modelSpWas2=SpWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'trx_akhir'=>1,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelPemeriksa=PemeriksaSpWas2::findAll(['id_sp_was2'=>$modelSpWas2['id_sp_was2'],
                'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelSaksiEk=SaksiEksternalInspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelSaksiIn=SaksiInternalInspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try{
                
                $model->no_register = $_SESSION['was_register'];
                $model->id_tingkat  = $_SESSION['kode_tk'];
                $model->id_kejati   = $_SESSION['kode_kejati'];
                $model->id_kejari   = $_SESSION['kode_kejari'];
                $model->id_cabjari  = $_SESSION['kode_cabjari'];
                $model->created_by=\Yii::$app->user->identity->id;
                $model->created_ip=$_SERVER['REMOTE_ADDR'];
                $model->created_time=date('Y-m-d H:i:s');
                $model->hari_ba_was_2=\Yii::$app->globalfunc->GetNamaHari($model->tgl_ba_was_2);
                $model->id_sp_was2=$modelSpWas2['id_sp_was2'];

            if($model->save()){
                $pertanyaan=$_POST['pertanyaan'];
                for ($i=0; $i <count($pertanyaan) ; $i++) { 
                    $bawas2Hasil=new BaWas2InspeksiKesimpulan();
                    $bawas2Hasil->no_register = $_SESSION['was_register'];
                    $bawas2Hasil->id_tingkat    = $_SESSION['kode_tk'];
                    $bawas2Hasil->id_kejati     = $_SESSION['kode_kejati'];
                    $bawas2Hasil->id_kejari     = $_SESSION['kode_kejari'];
                    $bawas2Hasil->id_cabjari    = $_SESSION['kode_cabjari'];
                    $bawas2Hasil->id_ba_was2=$model->id_ba_was2;
                    $bawas2Hasil->id_sp_was2=$modelSpWas2['id_sp_was2'];
                    $bawas2Hasil->kesimpulan_ba_was_2=$_POST['pertanyaan'][$i];
                    $bawas2Hasil->created_by=\Yii::$app->user->identity->id;
                    $bawas2Hasil->created_ip=$_SERVER['REMOTE_ADDR'];
                    $bawas2Hasil->created_time=date('Y-m-d H:i:s');
                    $bawas2Hasil->save();

                }

            }
            Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Ba-Was9 Berhasil Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
            $transaction->commit(); 
            return $this->redirect(['index']);

            } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
                }
        }   else {
            return $this->render('create', [
                'model' => $model,
                'modelPemeriksa' => $modelPemeriksa,
                'modelSaksiEk' => $modelSaksiEk,
                'modelSaksiIn' => $modelSaksiIn,
                'modelSpWas2' => $modelSpWas2,
            ]);
        }
     }
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {

       $model = $this->findModel();
      //  if($model){
      //       $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2-inspeksi/update"));
      /*random kode*/
      $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
      $res = "";
      for ($i = 0; $i < 10; $i++) {
          $res .= $chars[mt_rand(0, strlen($chars)-1)];
      }

        $model = $this->findModel();
        $fungsi=new FungsiComponent();
        // print_r($model);
        // exit();
        // $where=$fungsi->static_where_alias('a');
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
        $modelSpWas2=SpWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'trx_akhir'=>1,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);


        $modelPemeriksa=PemeriksaSpWas2::findAll(['id_sp_was2'=>$modelSpWas2['id_sp_was2'],'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $modelSaksiEk=SaksiEksternalInspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelSaksiIn=SaksiInternalInspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        
        $modelKesimpulan=BaWas2InspeksiKesimpulan::find()->where(['no_register'=>$_SESSION['was_register'],
            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
            'id_ba_was2'=>$model['id_ba_was2'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->all();

        $OldFile=$model->file_ba_was_2;
        //print_r($OldFile);
        // print_r($model->load(Yii::$app->request->post()));
        // exit();

        if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try { 
                  $errors       = array();
                  $file_name    = $_FILES['upload_file']['name'];
                  $file_size    =$_FILES['upload_file']['size'];
                  $file_tmp     =$_FILES['upload_file']['tmp_name'];
                  $file_type    =$_FILES['upload_file']['type'];
                  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                  $tmp = explode('.', $_FILES['upload_file']['name']);
                  $file_exists = end($tmp);
                  $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;

                $model->updated_by=\Yii::$app->user->identity->id;
                $model->updated_ip=$_SERVER['REMOTE_ADDR'];
                $model->updated_time=date('Y-m-d H:i:s');
                $model->file_ba_was_2 =  ($file_name==''?$OldFile:$rename_file);
                $model->hari_ba_was_2=\Yii::$app->globalfunc->GetNamaHari($model->tgl_ba_was_2);
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_2_inspeksi/'.$OldFile)) {
                  unlink(\Yii::$app->params['uploadPath'].'ba_was_2_inspeksi/'.$OldFile);
                } 

                $pertanyaan=$_POST['pertanyaan'];
                    BaWas2InspeksiKesimpulan::deleteAll(['no_register'=>$model->no_register]);
                for ($i=0; $i <count($pertanyaan) ; $i++) { 
                    $bawas2Hasil=new BaWas2InspeksiKesimpulan();
                    $bawas2Hasil->no_register = $_SESSION['was_register'];
                    $bawas2Hasil->id_tingkat    = $_SESSION['kode_tk'];
                    $bawas2Hasil->id_kejati     = $_SESSION['kode_kejati'];
                    $bawas2Hasil->id_kejari     = $_SESSION['kode_kejari'];
                    $bawas2Hasil->id_cabjari    = $_SESSION['kode_cabjari'];
                    $bawas2Hasil->id_ba_was2=$model->id_ba_was2;
                    $bawas2Hasil->id_sp_was2=$modelSpWas2['id_sp_was2'];
                    $bawas2Hasil->kesimpulan_ba_was_2=$_POST['pertanyaan'][$i];
                    $bawas2Hasil->created_by=\Yii::$app->user->identity->id;
                    $bawas2Hasil->created_ip=$_SERVER['REMOTE_ADDR'];
                    $bawas2Hasil->created_time=date('Y-m-d H:i:s');
                    $bawas2Hasil->save();

                }
                    WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2021' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //lwas-1

                    $modelTrxPemrosesan=new WasTrxPemrosesan();
                    $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                    $modelTrxPemrosesan->id_sys_menu="2021";/*masuk lwas2*/
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
                    // print_r($modelTrxPemrosesan->save());
                    // exit();
                    $modelTrxPemrosesan->save();

            }   
            Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Ba-Was9 Berhasil Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
             $transaction->commit();
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_2_inspeksi/'.$rename_file);

            return $this->redirect(['index']);
            } catch(Exception $e) {
                    $transaction->rollback();
                   if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        }else{
            return $this->render('update', [
                'model' => $model,
                'modelPemeriksa' => $modelPemeriksa,
                'modelSaksiEk' => $modelSaksiEk,
                'modelSaksiIn' => $modelSaksiIn,
                'modelSpWas2' => $modelSpWas2,
                'modelKesimpulan' => $modelKesimpulan,
            ]);
            // echo "string";
        }
        
       // }else{
       //     $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2-inspeksi/create"));
       // }
    }

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCetak(){
        $model=$this->findModel();
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/

        /*pemeriksa*/
        $modelPemeriksa=PemeriksaSpWas2::findAll(['id_sp_was2'=>$model['id_sp_was2'],'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $connection = \Yii::$app->db;
        $query_eksternal="select a.*, b.nama as agama_saksi_eksternal,c.nama as pendidikan from was.ba_was2_detail_eks a join public.ms_agama b on a.id_agama_saksi_eksternal=b.id_agama inner join public.ms_pendidikan c on a.pendidikan=id_pendidikan where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $modelSaksiEk=$connection->createCommand($query_eksternal)->queryAll();
        $modelSaksiIn=SaksiInternalInspeksi::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        
        $modelKesimpulan=BaWas2InspeksiKesimpulan::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_ba_was2'=>$model['id_ba_was2'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
       
 // print_r($model);
 // print_r($modelPemeriksa);
 //        exit();
        $tgl_bawas2=\Yii::$app->globalfunc->GetNamaHari($model['tgl_ba_was_2']);
        $hari_bawas2=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_ba_was_2']);
        $tgl_spwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_sp_was_2']);
        return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'hari_bawas2'=>$hari_bawas2,
                                'tgl_bawas2'=>$tgl_bawas2,
                                'tgl_spwas2'=>$tgl_spwas2,
                                'tanggal_bawas2'=>$tanggal_bawas2,
                                'model'=>$model,
                                'modelPemeriksa'=>$modelPemeriksa,
                                'modelSaksiEk'=>$modelSaksiEk,
                                'modelSaksiIn'=>$modelSaksiIn,
                                'modelKesimpulan'=>$modelKesimpulan,
                        ]);
    }

    public function actionViewpdf($id){
     
       $file_upload=$this->findModel();
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/ba_was_2_inspeksi/'.$file_upload['file_ba_was_2'];
        $extention=explode(".", $file_upload['file_ba_was_2']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_ba_was_2'] . '"');
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

    public function actionDelete()
    {
        //Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);
        if($_POST['selection_all']==1){
            DipaMaster::deleteAll();
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
        } else {
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
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
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    public function actionGetttd(){
  
   $searchModelBaWas2Inspeksi = new BaWas2InspeksiSearch();
   $dataProviderPenandatanganBaWas2Inspeksi = $searchModelBaWas2Inspeksi->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]);
   echo GridView::widget([
                    'dataProvider'=> $dataProviderPenandatanganBaWas2Inspeksi,
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

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = BaWas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],
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
