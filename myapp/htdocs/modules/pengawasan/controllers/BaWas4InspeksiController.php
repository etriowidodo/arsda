<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas4Inspeksi;
use app\modules\pengawasan\models\BaWas4InspeksiSearch;
use app\modules\pengawasan\models\BaWas4Keterangan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\SaksiEksternalInspeksi;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\components\FungsiComponent;

use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use app\modules\pengawasan\models\DisposisiIrmud;

use Odf;
use yii\db\Query;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class BaWas4InspeksiController extends Controller
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
        $model = new BaWas4Inspeksi();
        //$session = Yii::$app->session;
        $searchModel = new BaWas4InspeksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,

        ]);
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

     public function actionViewpdf($id){

       $result_file_name=$this->findModel($id);
       // print_r($result_file_name['bawas3_file']);
       // exit();
          $filepath = '../modules/pengawasan/upload_file/ba_was_4_inspeksi/'.$result_file_name['file_ba_was_4'];

        $extention=explode(".", $result_file_name['file_ba_was_4']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png' and file_exists($filepath)){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $result_file_name['file_ba_was_4'] . '"');
              header('Content-Transfer-Encoding: binary');
              header('Content-Length: ' . filesize($filepath));
              header('Accept-Ranges: bytes');

              // Render the file
              readfile($filepath);
          }
          else
          {
            echo "File Tidak Ditemukan";
             // PDF doesn't exist so throw an error or something
          }
      }
      
    }

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaWas4Inspeksi();
        $modelPernyataan= new BaWas4Keterangan();

        if ($model->load(Yii::$app->request->post()) ) {
            
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                $model->id_tingkat = $_SESSION['kode_tk'];
                $model->id_kejati  = $_SESSION['kode_kejati'];
                $model->id_kejari  = $_SESSION['kode_kejari'];
                $model->id_cabjari = $_SESSION['kode_cabjari'];
                $model->no_register= $_SESSION['was_register'];
                //$model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                // $model->id_ba_was4 = 1;
                // $model->id_saksi_eksternal = 1;
                $model->created_ip = $_SERVER['REMOTE_ADDR'];
                $model->created_by = \Yii::$app->user->identity->id;
                $model->created_time = date('Y-m-d H:i:s');
                
                // print_r($_POST['BaWas4Inspeksi']['id_saksi_eksternal']);
                // exit();
                
            if($model->save()){
                
                $pernyataan = $_POST['pertanyaan'];

                 for($k=0;$k<count($pernyataan);$k++){
                    $modelBaWas4Pertanyaan = new BaWas4Keterangan();
                    $modelBaWas4Pertanyaan->id_tingkat = $_SESSION['kode_tk'];
                    $modelBaWas4Pertanyaan->id_kejati  = $_SESSION['kode_kejati'];
                    $modelBaWas4Pertanyaan->id_kejari  = $_SESSION['kode_kejari'];
                    $modelBaWas4Pertanyaan->id_cabjari = $_SESSION['kode_cabjari'];
                    $modelBaWas4Pertanyaan->id_saksi_eksternal = $model->id_saksi_eksternal;
                    $modelBaWas4Pertanyaan->id_ba_was4 = $model->id_ba_was4;
                    $modelBaWas4Pertanyaan->no_register = $_SESSION['was_register'];
                    $modelBaWas4Pertanyaan->pernyataan_ba_was_4 =$_POST['pertanyaan'][$k];
                    $modelBaWas4Pertanyaan->created_ip = $_SERVER['REMOTE_ADDR'];
                    $modelBaWas4Pertanyaan->updated_ip = $_SERVER['REMOTE_ADDR'];
                    $modelBaWas4Pertanyaan->created_by = \Yii::$app->user->identity->id;
                    $modelBaWas4Pertanyaan->updated_by = \Yii::$app->user->identity->id;
                    // print_r($modelBaWas4Pertanyaan);
                    // exit();
                    $modelBaWas4Pertanyaan->save();
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
                
                $transaction->commit(); 
                return $this->redirect(['index']);  
                }
                else{
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Gagal di Simpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                return $this->render('create', [
                'model' => $model,
                //'modelSpWas1' => $modelSpWas1,
                'modelSaksiEksternal' => $modelSaksiEksternal,
                'modelPernyataan' => $modelPernyataan,
            ]);
                }
                } catch(Exception $e) {
                    $transaction->rollback();
                }
                
        }
            else {
            return $this->render('create', [
                 'model' => $model,
                
            ]);
        }
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
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
        $where=$fungsi->static_where_alias('a');
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
        $no_reg=$_SESSION['was_register'];
        $modelSpWas2 = SpWas2::findOne(["no_register"=>$_SESSION['was_register'],"id_tingkat"=>$_SESSION['kode_tk'],
                                        "id_kejati"=>$_SESSION['kode_kejati'],"id_kejari"=>$_SESSION['kode_kejari'],
                                        "id_kejati"=>$_SESSION['kode_kejati'],
                                        'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                        'id_level1'=>$_SESSION['was_id_level1'],
                                        'id_level2'=>$_SESSION['was_id_level2'],
                                        'id_level3'=>$_SESSION['was_id_level3'],
                                        'id_level4'=>$_SESSION['was_id_level4']]);

        //$modelPernyataan= new BaWas4Detail();
        //$modelPernyataan = BaWas4Detail::findOne(["id_ba_was_4"=>$model->id_ba_was_4]);
        //$modelPernyataan = BaWas4Detail::find()->where("id_ba_was_4 =:id", [":id" => $model->id_ba_was_4])->all();
        
        $connection = \Yii::$app->db;
        $xx ="select a.* from was.ba_was_4_inspeksi_pernyataan a where a.id_ba_was4='".$model->id_ba_was4."' 
                    and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
        $modelPernyataan = $connection->createCommand($xx)->queryAll();
        //print_r($modelPernyataan);exit();
        $querySaksiEksternal ="select a.*,b.nama as negara_eks,c.nama as agama_eks,d.nama as pendidikan_eks 
                                from was.saksi_eksternal_inspeksi a
                                inner join public.ms_warganegara b on a.id_negara_saksi_eksternal=b.id
                                inner join public.ms_agama  c on a.id_agama_saksi_eksternal=c.id_agama
                                inner join public.ms_pendidikan  d on a.pendidikan=d.id_pendidikan where 
                     a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."' and id_level1='".$_SESSION['was_id_level1']."'
                    and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."'
                    and id_level4='".$_SESSION['was_id_level4']."' and id_wilayah='".$_SESSION['was_id_wilayah']."'
                    and a.id_saksi_eksternal='".$model->id_saksi_eksternal."' $where";
        $modelSaksiEksternal = $connection->createCommand($querySaksiEksternal)->queryOne();
        // print_r($modelSaksiEksternal);exit();
        $query1 = "select a.* from was.sp_was_2 a where 
                  a.no_register='".$_SESSION['was_register']."'  
                  and a.id_tingkat='".$_SESSION['kode_tk']."' 
                  and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                  and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
        $spwas2 = $connection->createCommand($query1)->queryAll();
       // print_r($spwas2);exit();
     if ($model->load(Yii::$app->request->post()) ) {
        
                     
        $model->updated_by = \Yii::$app->user->identity->id;
        $model->updated_ip = $_SERVER['REMOTE_ADDR'];
        $model->updated_time = date('Y-m-d H:i:s');  
        $OldFile=$model->file_ba_was_4;
                     
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
       try {
           
            $file_name    = $_FILES['file_ba_was_4']['name'];
            $file_size    = $_FILES['file_ba_was_4']['size'];
            $file_tmp     = $_FILES['file_ba_was_4']['tmp_name'];
            $file_type    = $_FILES['file_ba_was_4']['type'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $tmp = explode('.', $_FILES['file_ba_was_4']['name']);
            $file_exists = end($tmp);
            $rename_file = $is_inspektur_irmud_riksa.'_'.$model->id_saksi_eksternal.'_'.$res.'.'.$ext;
            $model->file_ba_was_4 = ($file_name==''?$OldFile:$rename_file); 

           
        if($model->save()){

        if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_4_inspeksi/'.$OldFile)) {
            unlink(\Yii::$app->params['uploadPath'].'ba_was_4_inspeksi/'.$OldFile);
        }  

        $pernyataan = $_POST['pertanyaan'];
        BaWas4Keterangan::deleteAll("id_ba_was4 = '".$model->id_ba_was4."' and no_register='".$_SESSION['was_register']."' 
                    and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                    and id_cabjari='".$_SESSION['kode_cabjari']."' and id_level1='".$_SESSION['was_id_level1']."'
                    and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."'
                    and id_level4='".$_SESSION['was_id_level4']."' and id_wilayah='".$_SESSION['was_id_wilayah']."'");

        for($g=0;$g<count($pernyataan);$g++){
            $modelBaWas4Pernyataan = new BaWas4Keterangan();
           // $modelBaWas4Pertanyaan->pernyataan_ba_was_4 =$_POST['pertanyaan'][$k];
            $modelBaWas4Pernyataan->id_tingkat = $_SESSION['kode_tk'];
            $modelBaWas4Pernyataan->id_kejati  = $_SESSION['kode_kejati'];
            $modelBaWas4Pernyataan->id_kejari  = $_SESSION['kode_kejari'];
            $modelBaWas4Pernyataan->id_cabjari = $_SESSION['kode_cabjari'];
            $modelBaWas4Pernyataan->no_register = $_SESSION['was_register'];
            $modelBaWas4Pernyataan->pernyataan_ba_was_4 =$_POST['pertanyaan'][$g];
            $modelBaWas4Pernyataan->id_saksi_eksternal = $model->id_saksi_eksternal;
            $modelBaWas4Pernyataan->id_ba_was4 = $model->id_ba_was4;
            $modelBaWas4Pernyataan->created_ip = $_SERVER['REMOTE_ADDR'];
            $modelBaWas4Pernyataan->updated_ip = $_SERVER['REMOTE_ADDR'];
            $modelBaWas4Pernyataan->created_by = \Yii::$app->user->identity->id;
            $modelBaWas4Pernyataan->updated_by = \Yii::$app->user->identity->id;
           // print_r($modelBaWas4Pernyataan); exit();
            $modelBaWas4Pernyataan->save();
        } 
                    
                $arr = array(ConstSysMenuComponent::Bawas4);
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
                      $modelTrxPemrosesan->user_id = strval($_SESSION['is_inspektur_irmud_riksa']);
                      $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                      $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                      $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                      $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                      $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                    // print_r($modelTrxPemrosesan); exit();
                      $modelTrxPemrosesan->save();
                      // }
                    }

                    if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'ba_was_4_inspeksi/'.date('Y-m-d').$files->name;
                    $files->saveAs($path);
                    }
                
             $transaction->commit();
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_4_inspeksi/'.$rename_file);        
   
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
                        return $this->redirect(['index']);
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
              return $this->redirect(['index']);
            }
           } catch(Exception $e) {

                    $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                    'model' => $model,
                    'modelSpWas2' => $modelSpWas2,
                    'modelSaksiEksternal' => $modelSaksiEksternal,
                    'modelPernyataan' => $modelPernyataan,
                ]);
        }   
    }

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete() {
     $id_bawas4 = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas3;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_bawas4);
           // echo $pecah[$i];
            $this->findModel($pecah[$i])->delete();
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

    public function actionCetak($id)
    {
       // $model = $this->findModel($id);
       // $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $connection = \Yii::$app->db;
        $sql="select b.nama as negara_eks,c.nama as agama_eks,d.nama as pendidikan_eks,a.* 
                          from was.ba_was_4_inspeksi a
                          inner join public.ms_warganegara b on a.id_negara_saksi_eksternal=b.id
                          inner join public.ms_agama  c on a.id_agama_saksi_eksternal=c.id_agama
                          inner join public.ms_pendidikan  d on a.pendidikan_saksi_eksternal=d.id_pendidikan
                          where a.no_register='".$_SESSION['was_register']."'  
                          and a.id_tingkat='".$_SESSION['kode_tk']."' 
                          and a.id_kejati='".$_SESSION['kode_kejati']."' 
                          and a.id_kejari='".$_SESSION['kode_kejari']."' 
                          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_ba_was4='".$id."' $where";
        $model = $connection->createCommand($sql)->queryOne();
        $query_pertanyaan="select a.* from was.ba_was_4_inspeksi_pernyataan a 
                           where a.no_register='".$_SESSION['was_register']."' 
                           and a.id_tingkat='".$_SESSION['kode_tk']."' 
                           and a.id_kejati='".$_SESSION['kode_kejati']."' 
                           and a.id_kejari='".$_SESSION['kode_kejari']."' 
                           and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
                           and a.id_ba_was4='".$id."' $where";
        $modelPertanyaan = $connection->createCommand($query_pertanyaan)->queryAll();
        // print_r($modelPertanyaan);
        // exit();

        $tgl_bawas4=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_ba_was_4']);
        $tgl_lahir =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_lahir_saksi_eksternal']);
        // print_r($model['tanggal_lahir_saksi_eksternal']);
        // exit();
          return $this->render('cetak',[
                    'model'=>$model,
                    'modelPertanyaan'=>$modelPertanyaan,
                    'tgl_bawas4'=>$tgl_bawas4,
                    'tgl_lahir'=>$tgl_lahir,
                    ]);
    }

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    // protected function findModel($id)
    // {
    //     if (($model = DipaMaster::findOne($id)) !== null) {
    //         return $model;
    //     } else {
    //         throw new NotFoundHttpException('The requested page does not exist.');
    //     }
    // }

     protected function findModel($id)
    {
        if (($model = BaWas4Inspeksi::findOne(['id_ba_was4'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
