<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\SpWas2Search;
use app\modules\pengawasan\models\PemeriksaSpWas2;

use app\modules\pengawasan\models\DasarSpWas2;
use app\modules\pengawasan\models\DasarSpWas2Search;

use app\modules\pengawasan\models\Pemeriksa;
use app\modules\pengawasan\models\PemeriksaSearch;

use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/


use app\modules\pengawasan\models\PegawaiTerlaporSpWas2;
use app\modules\pengawasan\models\PegawaiTerlaporSpWas2Search;
use app\modules\pengawasan\models\DasarSpWas1;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use app\modules\pengawasan\models\VTerlapor;
use app\modules\pengawasan\models\VPemeriksa;
use app\modules\pengawasan\models\VTembusanSpWas2;
use app\modules\pengawasan\models\DipaMaster;
//use app\modules\pengawasan\models\VSpWas2;
// use app\components\GlobalFuncComponent; 
//use app\modules\pengawasan\models\TembusanSpWas1;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use yii\web\UploadedFile;
use yii\db\Query;
use yii\db\Command;
use Odf;
use yii\web\Session;
/**
 * SpWas2Controller implements the CRUD actions for SpWas2 model.
 */
class SpWas2Controller extends Controller {

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
   * Lists all SpWas2 models.
   * @return mixed
   */
  public function actionIndex() {
    $searchModel = new SpWas2Search();
    $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]);
  }

  /**
   * Displays a single SpWas2 model.
   * @param string $id
   * @return mixed
   */

    public function actionViewpdf($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
     
       $file_upload=$this->findModel($id_register,$id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/sp_was_2/'.$file_upload['file_sp_was2'];
        $extention=explode(".", $file_upload['file_sp_was2']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_sp_was2'] . '"');
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

  public function actionView($id) {
    return $this->render('view', [
                'model' => $this->findModel($id),
    ]);
  }

  /**
   * Creates a new SpWas2 model.
   * If creation is successful, the browser will be redirected to the 'view' page.
   * @return mixed
   */
  public function actionCreate() {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        } 

        $no_reg=$_SESSION['was_register'];
       // $model = SpWas2::findOne(["no_register"=>$_SESSION['was_register'],"id_tingkat"=>$_SESSION['kode_tk'],"id_kejati"=>$_SESSION['kode_kejati'],"id_kejari"=>$_SESSION['kode_kejari'],"id_kejati"=>$_SESSION['kode_kejati'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']]);
        $model = new SpWas2();
        $OldFile      =$model->file_sp_was2;
        $expire         =new GlobalFuncComponent();
        $table          ='sp_was_2';
        $filed          ='tanggal_akhir_sp_was2';
        $where          ="  trx_akhir=1 and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was2 is not null";
        $result_expire  =$expire->CekExpire($table,$filed,$where);

        $connection = \Yii::$app->db;
        $sql = "select*, nama_pegawai_terlapor as nama_terlapor_awal,
                jabatan_pegawai_terlapor as jabatan_terlapor_awal,
                satker_pegawai_terlapor as satker_terlapor_awal, 
                golongan_pegawai_terlapor as golongan_terlapor_awal,
                pangkat_pegawai_terlapor as pangkat_terlapor_awal
                from was.pegawai_terlapor_was10_inspeksi where no_register='".$_SESSION['was_register']."' 
                and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $resultWas10=$connection->createCommand($sql)->queryAll();
      //  print_r($sql.'<br>');
      //  exit();

        $query_was9 = "select id_pegawai_terlapor AS no_urut, nama_pegawai_terlapor AS nama_terlapor_awal,
                      jabatan_pegawai_terlapor AS jabatan_terlapor_awal, satker_pegawai_terlapor AS satker_terlapor_awal,
                      nip, nrp_pegawai_terlapor,pangkat_pegawai_terlapor as pangkat_terlapor_awal,
                      golongan_pegawai_terlapor as golongan_terlapor_awal
                      from was.pegawai_terlapor_sp_was2 where id_sp_was2=(select max(id_sp_was2)from was.sp_was_2 
                        where trx_akhir=1 and no_register='".$_SESSION['was_register']."')
                      and no_register='".$_SESSION['was_register']."'   
                      and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                      and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $resultWa9=$connection->createCommand($query_was9)->queryAll();
      //  print_r($query_was9);
      //   exit();

        $query1 = "select * from was.sp_was_1 where  no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                   and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                   and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['id_wil']."'
                   and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."'
                   and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."' ";
        $resultWa1=$connection->createCommand($query1)->queryAll();  
       
        //print_r(expression)
        if(count($resultWa1) <= 0 ){
          $fungsi = new FungsiComponent();
          $query=$fungsi->Get_terlapor2();
          $resultTerlaporawal=$connection->createCommand($query)->queryAll();
        }else{
           $query_lwas1 = "select nip_terlapor as nip,nama_terlapor as nama_terlapor_awal,
                           golongan_terlapor as golongan_terlapor_awal,jabatan_terlapor as jabatan_terlapor_awal,
                           pangkat_terlapor as pangkat_terlapor_awal,satker_terlapor as satker_terlapor_awal
                            from was.l_was_1_saran where  
                           no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                           and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                           and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['id_wil']."'
                           and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."'
                           and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."' ";
           $resultTerlaporawal=$connection->createCommand($query_lwas1)->queryAll();
           
        }         
           if(count($resultWas10)>=1){
              $modelTerlapor=$resultWas10;
            //echo "1";
           }else if(count($resultWas10)<=1 AND count($resultWa9)>=1){
              $modelTerlapor=$resultWa9;
            // echo "2";
            // echo $query_was9;
           }else{
              $modelTerlapor=$resultTerlaporawal;
            // echo "3";
            // echo $query_lwas1;
           }
        // print_r($resultTerlaporawal);
       //  exit();           
      //  $OldFile=$model->file_sp_was2;

        // $query_terlaporawal = "select*, '' as nip from was.terlapor_awal where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        // $resultTerlaporawal = $connection->createCommand($query_terlaporawal)->queryAll();
       // print_r($query_terlaporawal);
       // exit();


        // print_r($modelTerlapor);
        //               exit();

        $modelPegawaiTerlapor = new PegawaiTerlaporSpWas2();
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'sp_was_2','condition2'=>'master'])->all();

        $sql="select*from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $modelWas1 = $connection->createCommand($sql)->queryOne();
        // print_r($modelWas1);
        // exit();
         $sql1="select*from was.l_was_1 where no_register='".$_SESSION['was_register']."' 
         and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
         and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $modelWas27 = $connection->createCommand($sql1)->queryOne();

       //  print_r($modelWas27);
       // exit();
       

        if ($model->load(Yii::$app->request->post())) {

          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
            //upload
            $errors       = array();
            $file_name    = $_FILES['file_sp_was2']['name'];
            $file_size    =$_FILES['file_sp_was2']['size'];
            $file_tmp     =$_FILES['file_sp_was2']['tmp_name'];
            $file_type    =$_FILES['file_sp_was2']['type'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $tmp = explode('.', $_FILES['file_sp_was2']['name']);
            $file_exists = end($tmp);
            $rename_file  =$_SESSION['was_register'].$res.'.'.$ext;
            $OldFile=$model->file_sp_was2;

            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati  = $_SESSION['kode_kejati'];
            $model->id_kejari  = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register= $_SESSION['was_register'];
            $model->id_wilayah = $_SESSION['id_wil'];
            $model->id_level1 = $_SESSION['id_level_1'];
            $model->id_level2 = $_SESSION['id_level_2'];
            $model->id_level3 = $_SESSION['id_level_3'];
            $model->id_level4 = $_SESSION['id_level_4'];

            $model->tanggal_mulai_sp_was2=date("Y-m-d", strtotime($_POST['SpWas2']['tanggal_mulai_sp_was2']));
            $model->tanggal_akhir_sp_was2=date("Y-m-d", strtotime($_POST['SpWas2']['tanggal_akhir_sp_was2']));
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;

           
            $model->id_was_27   = $modelWas27['id_was_27_klari'];
            $model->id_was = $modelWas1['id_was1'];

            $isi_dasar_surat = $_POST['isi_dasar_sp_was_2'];/*untuk table dasar surat*/
            $nip = $_POST['nip_pemeriksa'];/*Untuk table pemeriksa*/
            $pejabat =  $_POST['pejabat'];/*Untuk table tembusan*/
            $terlapor =  $_POST['noTerlapor'];/*untuk table pegawai terlapor*/
            $model->file_sp_was2 = ($file_name==''?$OldFile:$rename_file);

            // print_r($terlapor);
            // exit();
           
            if ($model->save()) {
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'sp_was_2/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'sp_was_2/'.$OldFile);
               }
                //dasarSurat
              for ($i = 0; $i < count($isi_dasar_surat); $i++) {
                $saveDasarSurat = new DasarSpWas2();
                $saveDasarSurat->id_sp_was2 = $model->id_sp_was2;
                $saveDasarSurat->isi_dasar_sp_was2 =   $_POST['isi_dasar_sp_was_2'][$i];
                $saveDasarSurat->id_tingkat = $_SESSION['kode_tk'];
                $saveDasarSurat->id_kejati = $_SESSION['kode_kejati'];
                $saveDasarSurat->id_kejari = $_SESSION['kode_kejari'];
                $saveDasarSurat->id_cabjari = $_SESSION['kode_cabjari'];
                $saveDasarSurat->no_register = $_SESSION['was_register'];
                $saveDasarSurat->created_ip = $_SERVER['REMOTE_ADDR'];
                $saveDasarSurat->created_time = date('Y-m-d H:i:s');
                $saveDasarSurat->created_by = \Yii::$app->user->identity->id;
                $saveDasarSurat->id_wilayah = $_SESSION['id_wil'];
                $saveDasarSurat->id_level1 = $_SESSION['id_level_1'];
                $saveDasarSurat->id_level2 = $_SESSION['id_level_2'];
                $saveDasarSurat->id_level3 = $_SESSION['id_level_3'];
                $saveDasarSurat->id_level4 = $_SESSION['id_level_4'];
                $saveDasarSurat->save();
              }
               //PemeriksaSurat 
              for ($j = 0; $j < count($nip); $j++) {
                $savePemeriksa = new PemeriksaSpWas2 ();
                $savePemeriksa->id_sp_was2 = $model->id_sp_was2;
                $savePemeriksa->nip_pemeriksa = $_POST['nip_pemeriksa'][$j];
                $savePemeriksa->nrp_pemeriksa =  $_POST['nrp_pemeriksa'][$j];
                $savePemeriksa->nama_pemeriksa = $_POST['nama_pemeriksa'][$j];
                $savePemeriksa->pangkat_pemeriksa = $_POST['pangkat_pemeriksa'][$j];
                $savePemeriksa->jabatan_pemeriksa = $_POST['jabatan_pemeriksa'][$j];
                $savePemeriksa->golongan_pemeriksa = $_POST['golongan_pemeriksa'][$j];
                $savePemeriksa->no_register = $_SESSION['was_register'];
                $savePemeriksa->id_tingkat = $_SESSION['kode_tk'];
                $savePemeriksa->id_kejati = $_SESSION['kode_kejati'];
                $savePemeriksa->id_kejari = $_SESSION['kode_kejari'];
                $savePemeriksa->id_cabjari = $_SESSION['kode_cabjari'];
                $savePemeriksa->created_ip = $_SERVER['REMOTE_ADDR'];
                $savePemeriksa->created_time = date('Y-m-d H:i:s');
                $savePemeriksa->created_by = \Yii::$app->user->identity->id;
                $savePemeriksa->id_wilayah = $_SESSION['id_wil'];
                $savePemeriksa->id_level1 = $_SESSION['id_level_1'];
                $savePemeriksa->id_level2 = $_SESSION['id_level_2'];
                $savePemeriksa->id_level3 = $_SESSION['id_level_3'];
                $savePemeriksa->id_level4 = $_SESSION['id_level_4'];
                $savePemeriksa->save();
              }
              //TembusanWas
              $pejabat = $_POST['pejabat'];
              TembusanWas2::deleteAll(['from_table'=>'Sp-Was-2','id_wilayah'=>$_SESSION['id_wil'],
                                       'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                       'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4'],
                                       'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                       'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                       'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_sp_was2)]);
            //TembusanWas2::deleteAll(['from_table'=>'Was9','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was9,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                      
              $pejabat = $_POST['pejabat'];
               for($z=0;$z<count($pejabat);$z++){
              $saveTembusan = new TembusanWas2;
              $saveTembusan->from_table = 'Sp-Was-2';
              $saveTembusan->pk_in_table = strrev($model->id_sp_was2);
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
              $saveTembusan->is_inspektur_irmud_riksa = strval($_SESSION['is_inspektur_irmud_riksa']);
              $saveTembusan->id_wilayah = $_SESSION['id_wil'];
              $saveTembusan->id_level1 = $_SESSION['id_level_1'];
              $saveTembusan->id_level2 = $_SESSION['id_level_2'];
              $saveTembusan->id_level3 = $_SESSION['id_level_3'];
              $saveTembusan->id_level4 = $_SESSION['id_level_4'];
              // print_r($saveTembusan);
              // exit();
              $saveTembusan->save();
          
          }

              //PegawaiTerlapor    
              PegawaiTerlaporSpWas2::deleteAll(['id_sp_was2'=> $id_sp_was2, 'no_register'=>$id,'id_tingkat'=>$_SESSION,'id_kejati'=>$_SESSION,'id_kejari'=>$_SESSION,'id_cabjari'=>$_SESSION]);
              for($x=0;$x<count($terlapor);$x++){
                    $saveTerlapor = new PegawaiTerlaporSpWas2;
                   // $saveTerlapor->for_tabel = 'Sp-Was-2';
                    $saveTerlapor->id_sp_was2 = $model->id_sp_was2;
                    $saveTerlapor->nip = $_POST['nipTerlapor'][$x];
                    $saveTerlapor->nrp_pegawai_terlapor = $_POST['nrpTerlapor'][$x];
                    $saveTerlapor->nama_pegawai_terlapor = $_POST['namaTerlapor'][$x];
                    $saveTerlapor->pangkat_pegawai_terlapor = $_POST['pangkatTerlapor'][$x];
                    $saveTerlapor->golongan_pegawai_terlapor = $_POST['golonganTerlapor'][$x];
                    $saveTerlapor->jabatan_pegawai_terlapor = $_POST['jabatanTerlapor'][$x];
                    $saveTerlapor->satker_pegawai_terlapor = $_POST['satkerTerlapor'][$x];
                    $saveTerlapor->id_tingkat = $_SESSION['kode_tk'];
                    $saveTerlapor->id_kejati = $_SESSION['kode_kejati'];
                    $saveTerlapor->id_kejari = $_SESSION['kode_kejari'];
                    $saveTerlapor->id_cabjari = $_SESSION['kode_cabjari'];
                    $saveTerlapor->no_register = $_SESSION['was_register'];
                    $saveTerlapor->created_ip = $_SERVER['REMOTE_ADDR'];
                    $saveTerlapor->created_time = date('Y-m-d H:i:s');
                    $saveTerlapor->created_by = \Yii::$app->user->identity->id;
                    $saveTerlapor->id_wilayah = $_SESSION['id_wil'];
                    $saveTerlapor->id_level1 = $_SESSION['id_level_1'];
                    $saveTerlapor->id_level2 = $_SESSION['id_level_2'];
                    $saveTerlapor->id_level3 = $_SESSION['id_level_3'];
                    $saveTerlapor->id_level4 = $_SESSION['id_level_4'];
                    // print_r($saveTerlapor->save());
                    // exit();
                    $saveTerlapor->save();
                }  
              
              move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'sp_was_2/'.$rename_file); 

            }
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Sp-Was-2 Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
             ]);
            $transaction->commit();
            return $this->redirect(['index']);
          } catch (Exception $e) {
            $transaction->rollback();
          }
        } else {
          return $this->render('create', [
                      'model' => $model,
                      'modelTerlapor' => $modelTerlapor,
                      'modelPegawaiTerlapor' => $modelPegawaiTerlapor,
                      'modelTembusanMaster' => $modelTembusanMaster,
                      'modelWas1' => $modelWas1,
                      'result_expire' => $result_expire,
                            
          ]);
        }

  }

  /**
   * Updates an existing SpWas2 model.
   * If update is successful, the browser will be redirected to the 'view' page.
   * @param string $id
   * @return mixed
   */
  public function actionUpdate($id,$id_sp_was2) {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        } 
		// print_r($_SESSION);
        // exit();
        $model = $this->findModel($id,$id_sp_was2);
        $expire         =new GlobalFuncComponent();
        $table          ='sp_was_2';
        $filed          ='tanggal_akhir_sp_was2';
        $where          ="  trx_akhir=1 and no_register='".$_SESSION['was_register']."' 
                          and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                          and id_kejari='".$_SESSION['kode_kejari']."' 
                          and id_cabjari='".$_SESSION['kode_cabjari']."' 
                          and tanggal_akhir_sp_was2 is not null";
        $result_expire  =$expire->CekExpire($table,$filed,$where);

        $modelTerlapor = new Query;
        $connection = \Yii::$app->db;
        // $query = "select * from was.pegawai_terlapor where id_sp_was1='".$model->id_sp_was1."' and for_tabel='Sp-Was-1' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $query = "select id_pegawai_terlapor AS no_urut,
                  nama_pegawai_terlapor AS nama_terlapor_awal,
                  jabatan_pegawai_terlapor AS jabatan_terlapor_awal,
                  satker_pegawai_terlapor AS satker_terlapor_awal,
                  nip, nrp_pegawai_terlapor,pangkat_pegawai_terlapor as pangkat_terlapor_awal,
                  golongan_pegawai_terlapor as golongan_terlapor_awal from was.pegawai_terlapor_sp_was2 
                  where id_sp_was2='".$model->id_sp_was2."' and no_register='".$_SESSION['was_register']."' 
                  and id_tingkat='".$_SESSION['kode_tk']."' and
                  id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and
                  id_cabjari='".$_SESSION['kode_cabjari']."'";


        $modelPegawaiTerlapor = new PegawaiTerlaporSpWas2();
        $modelTerlapor = $connection->createCommand($query)->queryAll();
        $modelPemeriksa = PemeriksaSpWas2::find()->where(['id_sp_was2'=> $model->id_sp_was2,'no_register' => $model->no_register,'id_tingkat' => $model->id_tingkat,
                                                 'id_kejati' => $model->id_kejati,'id_kejari' => $model->id_kejari,'id_cabjari' => $model->id_cabjari])->all();
        $modelTembusan = TembusanWas2::findBySql("select*from was.tembusan_was where from_table='Sp-Was-2' and pk_in_table='". $model->id_sp_was2 ."' 
                                                  and no_register='". $model->no_register ."' 
                                                  and id_tingkat='". $model->id_tingkat ."' and id_kejati='". $model->id_kejati ."' 
                                                  and id_kejari='". $model->id_kejari ."' and id_cabjari='". $model->id_cabjari ."' 
                                                  order by is_order desc")->all();
        $modelDasarSurat = DasarSpWas2::findAll(['id_sp_was2'=> $model->id_sp_was2,'no_register' => $model->no_register,
                                                 'id_tingkat' => $model->id_tingkat,
                                                 'id_kejati' => $model->id_kejati,'id_kejari' => $model->id_kejari,
                                                'id_cabjari' => $model->id_cabjari]);
        

        $fungsi = new FungsiComponent();
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
        $OldFile=$model->file_sp_was2;

       //  $no_reg=$_SESSION['was_register'];
       // // $model = SpWas2::findOne(["no_register"=>$_SESSION['was_register'],"id_tingkat"=>$_SESSION['kode_tk'],"id_kejati"=>$_SESSION['kode_kejati'],"id_kejari"=>$_SESSION['kode_kejari'],"id_kejati"=>$_SESSION['kode_kejati'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']]);
       //  $model = new SpWas2();
       //  $OldFile      =$model->file_sp_was2;
       //  $expire         =new GlobalFuncComponent();
       //  $table          ='sp_was_2';
       //  $filed          ='tanggal_akhir_sp_was2';
       //  $where          ="trx_akhir=1 and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was2 is not null";
       //  $result_expire  =$expire->CekExpire($table,$filed,$where);

        
    // print_r($model);
    //     exit();
    if ($model->load(Yii::$app->request->post())) {
      // $model->updated_ip = Yii::$app->getRequest()->getUserIP();
      //PRIN-..../H/Hjw/".$bulan.'/'.$tahun;
     if($_POST['SpWas2']['nomor_sp_was2']!=''){
      $model->nomor_sp_was2 = $_POST['no_print'].$_POST['SpWas2']['nomor_sp_was2'].$_POST['no_hwj'];
     }
      // $model->thn_dipa = $_POST['thn_dipa'];
     $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        try {
          $errors       = array();
          $file_name    = $_FILES['file_sp_was2']['name'];
          $file_size    =$_FILES['file_sp_was2']['size'];
          $file_tmp     =$_FILES['file_sp_was2']['tmp_name'];
          $file_type    =$_FILES['file_sp_was2']['type'];
          $ext = pathinfo($file_name, PATHINFO_EXTENSION);
          $tmp = explode('.', $_FILES['file_sp_was2']['name']);
          $file_exists = end($tmp);
          $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
          //$OldFile=$model->file_sp_was2;

          $model->tanggal_mulai_sp_was2=date("Y-m-d", strtotime($_POST['SpWas2']['tanggal_mulai_sp_was2']));
          $model->tanggal_akhir_sp_was2=date("Y-m-d", strtotime($_POST['SpWas2']['tanggal_akhir_sp_was2']));
          $model->updated_ip = $_SERVER['REMOTE_ADDR'];
          $model->updated_time = date('Y-m-d H:i:s');
          $model->updated_by = \Yii::$app->user->identity->id;
          
          $isi_dasar_surat = $_POST['isi_dasar_sp_was_2'];/*untuk table dasar surat*/
          $nip = $_POST['nip_pemeriksa'];/*Untuk table pemeriksa*/
          $pejabat =  $_POST['pejabat'];/*Untuk table tembusan*/
          $terlapor =  $_POST['satkerTerlapor'];/*untuk table pegawai terlapor*/
          $model->file_sp_was2 = ($file_name==''?$OldFile:$rename_file);
        
          
      if ($model->save()) {
		  
        if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'sp_was_2/'.$OldFile)) {
                  unlink(\Yii::$app->params['uploadPath'].'sp_was_2/'.$OldFile);
              }  
              //dasarSurat
               DasarSpwas2::deleteAll(['id_sp_was2'=> $id_sp_was2, 'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                       'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                       'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['id_wil'],
                                       'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                       'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for ($i = 0; $i < count($isi_dasar_surat); $i++) {
                $saveDasarSurat = new DasarSpWas2();
                $saveDasarSurat->id_sp_was2 = $model->id_sp_was2;
                $saveDasarSurat->isi_dasar_sp_was2 =   $_POST['isi_dasar_sp_was_2'][$i];
                $saveDasarSurat->id_tingkat = $_SESSION['kode_tk'];
                $saveDasarSurat->id_kejati = $_SESSION['kode_kejati'];
                $saveDasarSurat->id_kejari = $_SESSION['kode_kejari'];
                $saveDasarSurat->id_cabjari = $_SESSION['kode_cabjari'];
                $saveDasarSurat->no_register = $_SESSION['was_register'];
                $saveDasarSurat->created_ip = $_SERVER['REMOTE_ADDR'];
                $saveDasarSurat->created_time = date('Y-m-d H:i:s');
                $saveDasarSurat->created_by = \Yii::$app->user->identity->id;
                $saveDasarSurat->id_wilayah = $_SESSION['id_wil'];
                $saveDasarSurat->id_level1 = $_SESSION['id_level_1'];
                $saveDasarSurat->id_level2 = $_SESSION['id_level_2'];
                $saveDasarSurat->id_level3 = $_SESSION['id_level_3'];
                $saveDasarSurat->id_level4 = $_SESSION['id_level_4'];
                $saveDasarSurat->save();
              }
              //PemeriksaSurat
             PemeriksaSpWas2::deleteAll(['id_sp_was2'=> $id_sp_was2, 'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                         'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                         'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['id_wil'],
                                         'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                         'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for ($j = 0; $j < count($nip); $j++) {
                $savePemeriksa = new PemeriksaSpWas2 ();
                $savePemeriksa->id_sp_was2 = $model->id_sp_was2;
                $savePemeriksa->nip_pemeriksa = $_POST['nip_pemeriksa'][$j];
                $savePemeriksa->nrp_pemeriksa =  $_POST['nrp_pemeriksa'][$j];
                $savePemeriksa->nama_pemeriksa = $_POST['nama_pemeriksa'][$j];
                $savePemeriksa->pangkat_pemeriksa = $_POST['pangkat_pemeriksa'][$j];
                $savePemeriksa->jabatan_pemeriksa = $_POST['jabatan_pemeriksa'][$j];
                $savePemeriksa->golongan_pemeriksa = $_POST['golongan_pemeriksa'][$j];
                $savePemeriksa->no_register = $_SESSION['was_register'];
                $savePemeriksa->id_tingkat = $_SESSION['kode_tk'];
                $savePemeriksa->id_kejati = $_SESSION['kode_kejati'];
                $savePemeriksa->id_kejari = $_SESSION['kode_kejari'];
                $savePemeriksa->id_cabjari = $_SESSION['kode_cabjari'];
                $savePemeriksa->created_ip = $_SERVER['REMOTE_ADDR'];
                $savePemeriksa->created_time = date('Y-m-d H:i:s');
                $savePemeriksa->created_by = \Yii::$app->user->identity->id;
                $savePemeriksa->id_wilayah = $_SESSION['id_wil'];
                $savePemeriksa->id_level1 = $_SESSION['id_level_1'];
                $savePemeriksa->id_level2 = $_SESSION['id_level_2'];
                $savePemeriksa->id_level3 = $_SESSION['id_level_3'];
                $savePemeriksa->id_level4 = $_SESSION['id_level_4'];
                $savePemeriksa->save();
              }
                 $pejabat = $_POST['pejabat'];
                  TembusanWas2::deleteAll(['from_table'=>'Sp-Was-2','id_wilayah'=>$_SESSION['id_wil'],
                                           'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                           'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4'],
                                           'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                           'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                           'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_sp_was2)]);
                //TembusanWas2::deleteAll(['from_table'=>'Was9','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was9,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                          
                  $pejabat = $_POST['pejabat'];
                   for($z=0;$z<count($pejabat);$z++){
                  $saveTembusan = new TembusanWas2;
                  $saveTembusan->from_table = 'Sp-Was-2';
                  $saveTembusan->pk_in_table = strrev($model->id_sp_was2);
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
                  $saveTembusan->is_inspektur_irmud_riksa = strval($_SESSION['is_inspektur_irmud_riksa']);
                  $saveTembusan->id_wilayah = $_SESSION['id_wil'];
                  $saveTembusan->id_level1 = $_SESSION['id_level_1'];
                  $saveTembusan->id_level2 = $_SESSION['id_level_2'];
                  $saveTembusan->id_level3 = $_SESSION['id_level_3'];
                  $saveTembusan->id_level4 = $_SESSION['id_level_4'];
                  // print_r($saveTembusan);
                  // exit();
                  $saveTembusan->save();
              
              }
                //PegawaiTerlapor
              PegawaiTerlaporSpWas2::deleteAll(['id_sp_was2'=> $id_sp_was2, 'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                                'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                                'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['id_wil'],
                                                'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                                'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for($x=0;$x<count($terlapor);$x++){
                    $saveTerlapor = new PegawaiTerlaporSpWas2;
                   // $saveTerlapor->for_tabel = 'Sp-Was-2';
                    $saveTerlapor->id_sp_was2 = $model->id_sp_was2;
                    $saveTerlapor->nip = $_POST['nipTerlapor'][$x];
                    $saveTerlapor->nrp_pegawai_terlapor = $_POST['nrpTerlapor'][$x];
                    $saveTerlapor->nama_pegawai_terlapor = $_POST['namaTerlapor'][$x];
                    $saveTerlapor->pangkat_pegawai_terlapor = $_POST['pangkatTerlapor'][$x];
                    $saveTerlapor->golongan_pegawai_terlapor = $_POST['golonganTerlapor'][$x];
                    $saveTerlapor->jabatan_pegawai_terlapor = $_POST['jabatanTerlapor'][$x];
                    $saveTerlapor->satker_pegawai_terlapor = $_POST['satkerTerlapor'][$x];
                    // $saveTerlapor->inst_satkerkd = $_SESSION['inst_satkerkd'];
                    $saveTerlapor->id_tingkat = $_SESSION['kode_tk'];
                    $saveTerlapor->id_kejati = $_SESSION['kode_kejati'];
                    $saveTerlapor->id_kejari = $_SESSION['kode_kejari'];
                    $saveTerlapor->id_cabjari = $_SESSION['kode_cabjari'];
                    $saveTerlapor->no_register = $_SESSION['was_register'];
                    $saveTerlapor->created_ip = $_SERVER['REMOTE_ADDR'];
                    $saveTerlapor->created_time = date('Y-m-d H:i:s');
                    $saveTerlapor->created_by = \Yii::$app->user->identity->id;
                    $saveTerlapor->id_wilayah = $_SESSION['id_wil'];
                    $saveTerlapor->id_level1 = $_SESSION['id_level_1'];
                    $saveTerlapor->id_level2 = $_SESSION['id_level_2'];
                    $saveTerlapor->id_level3 = $_SESSION['id_level_3'];
                    $saveTerlapor->id_level4 = $_SESSION['id_level_4'];
                    $saveTerlapor->save();
                }

                 WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' 
                                             AND id_sys_menu='3543' AND id_wilayah='".$_SESSION['was_id_wilayah']."' 
                                             and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' 
                                             and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-2
                 WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' 
                                             AND id_sys_menu='3545' AND id_wilayah='".$_SESSION['was_id_wilayah']."' 
                                             and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' 
                                             and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-2
              
                 $arr = array(ConstSysMenuComponent::Was9inspek, ConstSysMenuComponent::Was10inspek);
                
                 for ($i=0; $i < 2 ; $i++) { 
                          $modelTrxPemrosesan1=new WasTrxPemrosesan();
                          $modelTrxPemrosesan1->no_register    =$_SESSION['was_register'];
                          $modelTrxPemrosesan1->id_sys_menu    =$arr[$i];
                          $modelTrxPemrosesan1->id_user_login  =$_SESSION['username'];
                          $modelTrxPemrosesan1->durasi         =date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->created_by     =\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->created_ip     =$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->created_time   =date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->updated_ip     =$_SERVER['REMOTE_ADDR'];
                          $modelTrxPemrosesan1->updated_by     =\Yii::$app->user->identity->id;
                          $modelTrxPemrosesan1->updated_time   =date('Y-m-d H:i:s');
                          $modelTrxPemrosesan1->id_wilayah = $_SESSION['id_wil'];
                          $modelTrxPemrosesan1->id_level1 = $_SESSION['id_level_1'];
                          $modelTrxPemrosesan1->id_level2 = $_SESSION['id_level_2'];
                          $modelTrxPemrosesan1->id_level3 = $_SESSION['id_level_3'];
                          $modelTrxPemrosesan1->id_level4 = $_SESSION['id_level_4']; 
                          $modelTrxPemrosesan1->user_id       =strval($_SESSION['is_inspektur_irmud_riksa']);
                         // print_r($modelTrxPemrosesan1->save());
                         // exit(); 
                          $modelTrxPemrosesan1->save();
                //  }  
                }
                
                  
		          move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'sp_was_2/'.$rename_file);
      }
       Yii::$app->getSession()->setFlash('success', [
         'type' => 'success',
         'duration' => 3000,
         'icon' => 'fa fa-users',
         'message' => 'Data Sp-Was-2 Berhasil Disimpan',
         'title' => 'Simpan Data',
         'positonY' => 'top',
         'positonX' => 'center',
         'showProgressbar' => true,
         ]);
       $transaction->commit();
      return $this->redirect(['index']);
      //return $this->redirect(['update', 'id' => $model->id_sp_was2]);
    } catch (Exception $e) {
      $transaction->rollback();
    }
    } else {
      // print_r($model);
      // exit();
      return $this->render('update', [
                  'model' => $model,
                  'modelPemeriksa' => $modelPemeriksa,
                  'modelTembusan' => $modelTembusan,
                  'modelDasarSurat' => $modelDasarSurat,
                  'modelTerlapor' => $modelTerlapor,
                  'modelPegawaiTerlapor' => $modelPegawaiTerlapor,
                  'result_expire' => $result_expire,
      ]);
      // print_r($model);
      // print_r($modelPemeriksa);
      // print_r($modelTembusan);
      // print_r($modelTerlapor);
    }
  }

  /**
   * Deletes an existing SpWas2 model.
   * If deletion is successful, the browser will be redirected to the 'index' page.
   * @param string $id
   * @return mixed
   */
  public function actionDelete($id) {
    $this->findModel($id)->delete();

    return $this->redirect(['index']);
  }

  public function actionHapus1() {
        $id=$_POST['id'];
        $jml=$_POST['jml'];
        $check=explode(",",$id);
        // $modelPelapor = new Pelapor();
        // $modelTerlapor = new Terlapor();
        for ($i=0; $i <$jml ; $i++) { 
        
            // SpWas2::deleteAll("id_sp_was2 = '".$check[$i]."'");
           $this->findModel($check[$i])->delete();
            // echo $check[$i];
            // Terlapor::deleteAll("no_register = '".$check[$i]."'");
            // Lapdu::deleteAll("no_register = '".$check[$i]."'");
    }
         return $this->redirect(['index']);
  }

    public function actionHapus() {
    $id_sp_was2 = $_POST['id_sp_was2'];
    $no_register = $_POST['id'];
    $jml=$_POST['jml'];
   // print_r($jml);
    //print_r($no_register);
    //print_r($jml);
   // exit();
    //$check=explode(",",$id_sp_was_2);
        // echo $check[0].$jml; 
    for ($i=0; $i <$jml ; $i++) { 
      // print_r($id_sp_was2[$i]);
      // exit();
      SpWas2::deleteAll(["id_sp_was2" => $id_sp_was2[$i],"no_register" => $_SESSION['was_register'],"id_tingkat"=>$_SESSION['kode_tk'],"id_kejati"=>$_SESSION['kode_kejati'],"id_kejari"=>$_SESSION['kode_kejari'],"id_cabjari"=>$_SESSION['kode_cabjari']]);
    
    }
     return $this->redirect(['index']);

  }

  /**
   * Finds the SpWas2 model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param string $id
   * @return SpWas2 the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id,$id_sp_was2)
    {
        if (($model = SpWas2::findOne(['id_sp_was2'=>$id_sp_was2,'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

  protected function findModel1($id,$id_sp_was2) {
    if (($model = SpWas2::findOne($id)) !== null) {
      return $model;
    } else {
      throw new NotFoundHttpException('The requested page does not exist.');
    }
  }

   public function actionCetakdocx($no_register,$id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
      $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
	  
      $connection = \Yii::$app->db;
      $sql = "select*from was.sp_was_2 where id_sp_was2='".$id."' and no_register='".$no_register."' 
              and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."' and id_kejari='".$id_kejari."' 
              and id_cabjari='".$id_cabjari."'";
      $spwas2=$connection->createCommand($sql)->queryOne();
	  
      $dasar = DasarSpWas2::find()->where("id_sp_was2='".$id."' and no_register='".$no_register."' 
                                           and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."'
                                           and id_kejari='".$id_kejari."' and id_cabjari='".$id_cabjari."'")->all();
	
      $pemeriksa = PemeriksaSpWas2::find()->where("id_sp_was2='".$id."' and no_register='".$no_register."' 
                                           and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."'
                                           and id_kejari='".$id_kejari."' and id_cabjari='".$id_cabjari."'")->all();
     
      $sqlTerlapor="select*from was.pegawai_terlapor_sp_was2 where id_sp_was2='".$id."' and no_register='".$no_register."' 
                                           and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."'
                                           and id_kejari='".$id_kejari."' and id_cabjari='".$id_cabjari."'";
      $terlapor=$connection->createCommand($sqlTerlapor)->queryAll();
     


      $tgl_berlaku_1=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas2['tanggal_mulai_sp_was2'])));
      $tgl_berlaku_2=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas2['tanggal_akhir_sp_was2'])));
      $tgl_sp_was_2=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas2['tanggal_sp_was2'])));
      // print_r($tgl_sp_was_2);
      // exit();
      $query6 = "select a.* from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$id."' and from_table='Sp-Was-2'  order by is_order DESC";
      $tembusan = $connection->createCommand($query6)->queryAll();

      $dipa = DipaMaster::find()->where("is_aktif = '1'")->one();
      // print_r($tembusan);
      // exit();
    return $this->render('cetak',[
                  'data_satker'=>$data_satker,
                   'spwas2'=>$spwas2,
                   'dasar'=>$dasar,
                   'pemeriksa'=>$pemeriksa,
                   'terlapor'=>$terlapor,
                   'tembusan'=>$tembusan,
                   'tgl_berlaku_1'=>$tgl_berlaku_1,
                   'tgl_berlaku_2'=>$tgl_berlaku_2,
                   'tgl_sp_was_2'=>$tgl_sp_was_2,
                   'dipa'=>$dipa
                  ]);
    }

  public function actionCetak($id_sp_was2) {
    // $odf = new Odf(Yii::$app->params['report-path'] . "modules/pengawasan/template/sp_was_2.odt");
    $odf = new Odf(Yii::$app->params['reportPengawasan']."sp_was_2.odt");
       $spwas2 = VSpWas2::findOne(['id_sp_was2' => $id_sp_was2]);
//     $pelapor = VPelapor::find()->where("id_register='" . $id_register . "'")->all();
       $terlapor = PegawaiTerlapor::find()->where("id_sp_was='".$id_sp_was2."' and for_tabel='Sp-Was-2'")->all();
       $pemeriksa = Pemeriksa::find()->where("id_sp_was2 = '".$id_sp_was2."'")->all();
       $tembusan = TembusanWas2::find()->where("pk_in_table='".$id_sp_was2."' and from_table='Sp-Was-2'")->all();
       $dasar = DasarSpwas2::find()->where("id_sp_was2='".$id_sp_was2."'")->all();
		
		
		//$sts =explode(' ',$spwas2['jabatan_penandatangan']);
		$sts =(substr($spwas2['id_jabatan'],0,1));
/* 		print_r($sts);
		exit(); */
		if($sts=='0'){ //jabatansebernya
			$odf->setVars('jabatanPenandatangan', '');
			$odf->setVars('jabatan', $spwas2['jbtn_penandatangan']);
			$odf->setVars('namaTandatangan',  $spwas2['nama_penandatangan']);
			$odf->setVars('nipTandatangan', '');
		}elseif($sts=='1'){ //AN
			$odf->setVars('jabatanPenandatangan', $spwas2['jabatan_penandatangan']);
			$odf->setVars('jabatan', $spwas2['jbtn_penandatangan']);
			$odf->setVars('nipTandatangan',  $spwas2['pangkat_penandatangan'].' / NIP. '.$spwas2['peg_nip']);
			$odf->setVars('namaTandatangan',  $spwas2['nama_penandatangan']);
		}elseif($sts=='2'||$sts['0']=='3'){ //Plt&Plh
			$odf->setVars('jabatanPenandatangan', $spwas2['jabatan_penandatangan']);
			$odf->setVars('jabatan', '');
			$odf->setVars('namaTandatangan',  $spwas2['nama_penandatangan']);
			$odf->setVars('nipTandatangan',  $spwas2['pangkat_penandatangan'].' / NIP. '.$spwas2['peg_nip']);
			}
			
		
       $odf->setVars('pejabat_sp_was_2', $spwas2->jbtn_penandatangan);
       $odf->setVars('kejaksaan', $spwas2->inst_nama);
//     $odf->setVars('pejabat_sp_was_2', ucwords(strtolower($spwas2->pejabat_sp_was_2)));
       $odf->setVars('no_sp_was_2', $spwas2->no_sp_was_2);
//     $odf->setVars('perja', $spwas2->perja);
       $odf->setVars('tgl_berlaku_1', GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas2->tanggal_mulai_sp_was2))));
       $odf->setVars('tgl_berlaku_2', GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas2->tanggal_akhir_sp_was2))));
//     $odf->setVars('anggaran', $spwas2->anggaran);
//     $odf->setVars('thn_dipa', $spwas2->thn_dipa);
       $odf->setVars('tgl_sp_was_2', GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime(date('d-m-Y', strtotime($spwas2->tanggal_sp_was2))))));
       //$odf->setVars('ttd_peg_nama', $spwas2->nama_penandatangan);
       //$odf->setVars('ttd_peg_nip', '');
       //$odf->setVars('ttd_jabatan', $spwas2->jabatan_penandatangan);
       //$odf->setVars('ttd_pangkat', '');
       $odf->setVars('dikeluarkan_di', ucwords(strtolower($spwas2->inst_lokinst)));
       $odf->setVars('lokasi', strtoupper($spwas2->inst_lokinst));

        #tembusan
        $dft_tembusan = $odf->setSegment('tembusan');
        $i = 1;
        foreach ($tembusan as $element) {
          $dft_tembusan->urutan_tembusan($i);
          $dft_tembusan->jabatan_tembusan($element['tembusan']);
          $dft_tembusan->merge();
          $i++;
        }
        $odf->mergeSegment($dft_tembusan);

        #dasar surat
        $dft_daftar= $odf->setSegment('surat');
            foreach ($dasar as $key) {
          $dft_daftar->isi_surat($key['isi_dasar_sp_was2']);
          $dft_daftar->merge();
            }
        $odf->mergeSegment($dft_daftar);


        #Pemeriksa
        $dft_pemeriksa= $odf->setSegment('pemeriksa');
          $i=1;
            foreach ($pemeriksa as $key) {
          $dft_pemeriksa->urutan_pemeriksa($i);
          $dft_pemeriksa->nama_pemeriksa($key['nama_pemeriksa']);
          $dft_pemeriksa->nip_pemeriksa($key['nip']);
          $dft_pemeriksa->pangkat_pemeriksa($key['pangkat_pemeriksa']);
          $dft_pemeriksa->jabatan_pemeriksa($key['jabatan_pemeriksa']);
          $dft_pemeriksa->merge();
          $i++;
            }
        $odf->mergeSegment($dft_pemeriksa);

//     #terlapor
        $dft_terlapor = $odf->setSegment('terlapor');
        $i = 1;
        foreach ($terlapor as $element) {
          $dft_terlapor->urutan_terlapor($i);
          $dft_terlapor->nama_terlapor($element['nama_pegawai_terlapor']);
          $dft_terlapor->pangkat_terlapor($element['pangkat_pegawai_terlapor']);
          $dft_terlapor->nip_terlapor($element['nip']);
          $dft_terlapor->nrp_terlapor($element['nrp_pegawai_terlapor']);
          $dft_terlapor->jabatan_terlapor($element['jabatan_pegawai_terlapor']);
          $dft_terlapor->merge();
          $i++;
        }
        $odf->mergeSegment($dft_terlapor);

//     #pelapor
//     $dft_pelapor = $odf->setSegment('pelapor');
//     $jlhPelapor = count($pelapor);
//     $i = 1;
//     foreach ($pelapor as $element) {
//       if ($jlhPelapor == $i) {
//         $dft_pelapor->nama_pelapor($element['nama']);
//       } else {
//         $dft_pelapor->nama_pelapor($element['nama'] . "--");
//       }
//       $dft_pelapor->merge();
//       $i++;
//     }
//     $odf->mergeSegment($dft_pelapor);

//     $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
// inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
// inner join (
// select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
//     inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
//     inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
//         inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
//             count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
//         on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister" => $id_register])->asArray()->one();

    $odf->exportAsAttachedFile("SPWAS2-.odt");
  }

}
