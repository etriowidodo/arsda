<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\SkWas2a;
use app\modules\pengawasan\models\SkWas2aPelapor;
use app\modules\pengawasan\models\SkWas2aPemeriksa;
use app\modules\pengawasan\models\SkWas2aUraian;
use app\modules\pengawasan\models\SkWas2aSearch;
use app\modules\pengawasan\models\PemeriksaSpWas2;
use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\was10Inspeksi;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\Lapdu;/*mengambil tembusan dari master*/
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\KpInstSatkerSearch;
use app\models\KpInstSatker;

use app\modules\pengawasan\models\TembusanSkWas2a;
use app\modules\pengawasan\models\LookupItem;
use app\modules\pengawasan\models\VPejabatPimpinan;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\TembusanWas2;
use Odf;
use yii\db\Command;
use app\components\ConstSysMenuComponent;

use yii\db\Exception;
use yii\db\Query;
use yii\web\Response;
use yii\web\Session;
use yii\web\UploadedFile;

use app\modules\pengawasan\models\DugaanPelanggaran;
use app\modules\pengawasan\models\LWas2Saran;
use app\modules\pengawasan\models\SpRTingkatphd;
use app\modules\pengawasan\models\VDugaanPelanggaran;
use app\modules\pengawasan\models\VPelapor;
use app\modules\pengawasan\models\VPemeriksa;
use app\modules\pengawasan\models\VRiwayatJabatan;
use app\modules\pengawasan\models\VTerlapor;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * SkWas2aController implements the CRUD actions for SkWas2a model.
 */
class SkWas2aController extends Controller
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
     * Lists all SkWas2a models.
     * @return mixed
     */
     public function actionIndex()
    {
        $model = new SkWas2a();
        $session = Yii::$app->session;
        $searchModel = new SkWas2aSearch();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

        return $this->render('index');
    }

    // public function actionIndex()
    // {
    //     $searchModel = new SkWas2aSearch();
    //     $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    //     return $this->render('index', [
    //         'searchModel' => $searchModel,
    //         'dataProvider' => $dataProvider,
    //     ]);
    // }

    /**
     * Displays a single SkWas2a model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

     public function actionViewpdf($id,$id2){
        $file_upload=$this->findModel($id,$id2);

          $filepath = '../modules/pengawasan/upload_file/sk_was_2a/'.$file_upload['upload_file'];
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
     * Creates a new SkWas2a model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
        $model = new SkWas2a();
        $modelPemeriksa = new SkWas2aPemeriksa();
        $modelPelapor = new SkWas2aPelapor();
        $modelSpWas2 = SpWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1]);
        $dataPemeriksa = was10Inspeksi::findOne(["id_sp_was2"=>$modelSpWas2->id_sp_was2,
          'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],
          'nip_pegawai_terlapor'=>$_GET['id'],'trx_akhir'=>'1']);
          // print_r($dataPemeriksa);
        // exit();
        $dataLapdu = Lapdu::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'sk_was_2a','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
        // print_r($dataLapdu);
        // exit();
        $queryp = new Query;
        $connection = \Yii::$app->db;
        $sqlPelapor="select*from was.pelapor a inner join was.sumber_laporan b 
                     on a.id_sumber_laporan=b.id_sumber_laporan
                     where a.no_register='".$_SESSION['was_register']."' 
                     and a.id_tingkat='".$_SESSION['kode_tk']."' 
                     and a.id_kejati='".$_SESSION['kode_kejati']."' 
                     and a.id_kejari='".$_SESSION['kode_kejari']."' 
                     and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
        $dataPelapor = $connection->createCommand($sqlPelapor)->queryOne();

        $sqlPeraturan  ="select a.id_surat,nama_peraturan from was.surat_peraturan a inner join was.master_surat b  on a.id_surat=b.id_surat
                        inner join  was.ms_peraturan c on a.id_peraturan=c.id_peraturan 
                        where a.id_surat='Sk-Was-2A'
                        order by a.is_order asc";
        $dataPeraturan = $connection->createCommand($sqlPeraturan)->queryAll();
        // print_r($dataPeraturan);
        // exit();
        $modelTerlapor="select a.*,b.*,c.*,a.bentuk_pelanggaran as keterangan_pelanggaran,d.* 
                        from was.l_was_2_terlapor a 
                        inner join was.was_15_rencana b
                        on a.id_tingkat=b.id_tingkat and
                        a.id_kejati=b.id_kejati and
                        a.id_kejari=b.id_kejari and
                        a.id_cabjari=b.id_cabjari and 
                        a.no_register=b.no_register and 
                        a.nip_terlapor=b.nip_terlapor
                        left join kepegawaian.kp_pegawai c
                        on b.nip_terlapor=c.peg_nip_baru  
                        left join was.lapdu d
                        on a.id_tingkat=d.id_tingkat and
                        a.id_kejati=d.id_kejati and
                        a.id_kejari=d.id_kejari and
                        a.id_cabjari=d.id_cabjari and 
                        a.no_register=d.no_register  
                        where b.saran_dari='Jamwas' and b.sk='SK-WAS2-A' 
                        and b.nip_terlapor='".$_GET['id']."' 
                       ";
        $dataTerlapor = $connection->createCommand($modelTerlapor)->queryOne();
        // print_r($modelTerlapor);
        // print_r($dataTerlapor);
        // exit();

        
        

        $connection = \Yii::$app->db;
        
        if ($model->load(Yii::$app->request->post())){
          $transaction = $connection->beginTransaction();
          try {
          // print_r($dataTerlapor);
          // exit();

            $model->id_sp_was2  = $_POST['id_sp_was2'];
            $model->id_ba_was2  = $_POST['id_ba_was2'];
            $model->id_l_was2   = $_POST['id_l_was2'];
            $model->id_was15    = $_POST['id_was15'];
            $model->no_register = $_SESSION['was_register'];
            $model->id_tingkat  = $_SESSION['kode_tk'];
            $model->id_kejati   = $_SESSION['kode_kejati'];
            $model->id_kejari   = $_SESSION['kode_kejari'];
            $model->id_cabjari  = $_SESSION['kode_cabjari'];
            $model->created_by=\Yii::$app->user->identity->id;
            $model->created_ip=$_SERVER['REMOTE_ADDR'];
            $model->created_time=date('Y-m-d H:i:s');
            $model->pelanggaran = $dataTerlapor['keterangan_pelanggaran'];
            // $tembusan =  $_POST['id_jabatan']; 
            // $model->id_terlapor = $_POST['SkWas2a']['id_terlapor']; 
            // $model->ttd_sk_was_2a = $_POST['SkWas2a']['ttd_sk_was_2a'];
            // $model->no_sk_was_2a = "KEP-".$_POST['no_sk_was_2a'];
            
            // $files = \yii\web\UploadedFile::getInstance($model,'upload_file');
            // $model->upload_file = $files->name;

          //  $transaction = $connection->beginTransaction();
          //  try {
                if($model->save()){
             // print_r($model->id_wilayah);
             // exit();
                   $jml=count($_POST['uraian']);
                    for ($i=0; $i < $jml; $i++) { 
                        $modelsk12aUaraian=new SkWas2aUraian();
                        $modelsk12aUaraian->no_register = $_SESSION['was_register'];
                        $modelsk12aUaraian->id_tingkat  = $_SESSION['kode_tk'];
                        $modelsk12aUaraian->id_kejati   = $_SESSION['kode_kejati'];
                        $modelsk12aUaraian->id_kejari   = $_SESSION['kode_kejari'];
                        $modelsk12aUaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                        $modelsk12aUaraian->id_sp_was2  = $model->id_sp_was2;
                        $modelsk12aUaraian->id_ba_was2  = $model->id_ba_was2;
                        $modelsk12aUaraian->id_l_was2   = $model->id_l_was2;
                        $modelsk12aUaraian->id_was15    = $model->id_was15;
                        $modelsk12aUaraian->id_sk_was_2a= $model->id_sk_was_2a;
                        $modelsk12aUaraian->isi_uraian  = $_POST['uraian'][$i];
                        $modelsk12aUaraian->created_by  =\Yii::$app->user->identity->id;
                        $modelsk12aUaraian->created_ip  =$_SERVER['REMOTE_ADDR'];
                        $modelsk12aUaraian->created_time=date('Y-m-d H:i:s');
                      //  print_r( $modelsk12aUaraian);
                       // print_r($model->id_sk_was_2a);
                        // print_r($jml);
                        //  exit();
                        $modelsk12aUaraian->save();
                    }
//SkWas2aPelapor[nama_pelapor]
                    $jmlPelapor=count($_POST['nama_pelapor']);

                    for ($i=0; $i < $jmlPelapor; $i++) { 
                        $modelsk12aPelapor=new SkWas2aPelapor();
                        $modelsk12aPelapor->no_register = $_SESSION['was_register'];
                        $modelsk12aPelapor->id_tingkat  = $_SESSION['kode_tk'];
                        $modelsk12aPelapor->id_kejati   = $_SESSION['kode_kejati'];
                        $modelsk12aPelapor->id_kejari   = $_SESSION['kode_kejari'];
                        $modelsk12aPelapor->id_cabjari  = $_SESSION['kode_cabjari'];
                        $modelsk12aPelapor->id_sp_was2  = $model->id_sp_was2;
                        $modelsk12aPelapor->id_ba_was2  = $model->id_ba_was2;
                        $modelsk12aPelapor->id_l_was2   = $model->id_l_was2;
                        $modelsk12aPelapor->id_was15    = $model->id_was15;
                        $modelsk12aPelapor->id_sk_was_2a= $model->id_sk_was_2a;
                        $modelsk12aPelapor->nama_pelapor= $_POST['nama_pelapor'][$i];
                        $modelsk12aPelapor->alamat_pelapor    = $_POST['alamat_pelapor'][$i];
                        $modelsk12aPelapor->email_pelapor     = $_POST['email_pelapor'][$i];
                        $modelsk12aPelapor->telp_pelapor      = $_POST['telp_pelapor'][$i];
                        $modelsk12aPelapor->pekerjaan_pelapor = $_POST['pekerjaan_pelapor'][$i];
                        $modelsk12aPelapor->sumber_lainnya    = $_POST['sumber_lainnya'][$i];
                        $modelsk12aPelapor->id_sumber_laporan = $_POST['id_sumber_laporan'][$i];
                        $modelsk12aPelapor->tempat_lahir_pelapor   = $_POST['tempat_lahir_pelapor'][$i];
                        $modelsk12aPelapor->tanggal_lahir_pelapor  = $_POST['tanggal_lahir_pelapor'][$i];
                        $modelsk12aPelapor->kewarganegaraan_pelapor= $_POST['kewarganegaraan_pelapor'][$i];
                        $modelsk12aPelapor->agama_pelapor          = $_POST['agama_pelapor'][$i];
                        $modelsk12aPelapor->pendidikan_pelapor     = $_POST['pendidikan_pelapor'][$i];
                        $modelsk12aPelapor->nama_kota_pelapor      = $_POST['nama_kota_pelapor'][$i];
                        $modelsk12aPelapor->created_by  =\Yii::$app->user->identity->id;
                        $modelsk12aPelapor->created_ip  =$_SERVER['REMOTE_ADDR'];
                        $modelsk12aPelapor->created_time=date('Y-m-d H:i:s');
                      //  print_r( $modelsk12aPelapor);
                       // print_r($model->id_sk_was_2a);
                       // print_r($modelsk12aPelapor);
                       // exit();
                        $modelsk12aPelapor->save();
                    }
//[nama_pemeriksa]
                    $jmlPemeriksa=count($_POST['nama_pemeriksa']);
                    // print_r($jmlPemeriksa);
                    //   exit();
                    for ($i=0; $i < $jmlPemeriksa; $i++) { 
                        $modelsk12aPemeriksa=new SkWas2aPemeriksa();
                        $modelsk12aPemeriksa->no_register = $_SESSION['was_register'];
                        $modelsk12aPemeriksa->id_tingkat  = $_SESSION['kode_tk'];
                        $modelsk12aPemeriksa->id_kejati   = $_SESSION['kode_kejati'];
                        $modelsk12aPemeriksa->id_kejari   = $_SESSION['kode_kejari'];
                        $modelsk12aPemeriksa->id_cabjari  = $_SESSION['kode_cabjari'];
                        $modelsk12aPemeriksa->id_sp_was2  = $model->id_sp_was2;
                        $modelsk12aPemeriksa->id_ba_was2  = $model->id_ba_was2;
                        $modelsk12aPemeriksa->id_l_was2   = $model->id_l_was2;
                        $modelsk12aPemeriksa->id_was15    = $model->id_was15;
                        $modelsk12aPemeriksa->id_sk_was_2a= $model->id_sk_was_2a;
                        $modelsk12aPemeriksa->nip_pemeriksa = $_POST['nip_pemeriksa'][$i];
                        $modelsk12aPemeriksa->nrp_pemeriksa     = $_POST['nrp_pemeriksa'][$i];
                        $modelsk12aPemeriksa->nama_pemeriksa    = $_POST['nama_pemeriksa'][$i];
                        $modelsk12aPemeriksa->pangkat_pemeriksa = $_POST['pangkat_pemeriksa'][$i];
                        $modelsk12aPemeriksa->jabatan_pemeriksa = $_POST['jabatan_pemeriksa'][$i];
                        $modelsk12aPemeriksa->golongan_pemeriksa= $_POST['golongan_pemeriksa'][$i];
                        $modelsk12aPemeriksa->created_by  =\Yii::$app->user->identity->id;
                        $modelsk12aPemeriksa->created_ip  =$_SERVER['REMOTE_ADDR'];
                        $modelsk12aPemeriksa->created_time=date('Y-m-d H:i:s');
                        // print_r($modelsk12aPemeriksa);
                        // exit();
                        $modelsk12aPemeriksa->save();
                    }

                     $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Sk-Was-2a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_sk_was_2a),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Sk-Was-2a';
                            $saveTembusan->pk_in_table = strrev($model->id_sk_was_2a);
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

                    // if ($files != false) {
                    // $path = \Yii::$app->params['uploadPath'].'sk_was_2a/'.$files->name;
                    // $files->saveAs($path);
                    // }
                 // for($i=0;$i<count($tembusan);$i++){
                 //        $saveTembusan = new TembusanSkWas2a();
                 //        $saveTembusan->id_sk_was_2a = $model->id_sk_was_2a;
                 //        $saveTembusan->id_pejabat_tembusan = $tembusan[$i];
                 //        $saveTembusan->save();
                 //    }
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
               } catch (Exception $e) {
                $transaction->roolback();
            }
                
            // } catch(Exception $e) {
            //     $transaction->rollback();
            // }
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelPemeriksa' => $modelPemeriksa,
                'modelPelapor' => $modelPelapor,
                'dataPemeriksa' => $dataPemeriksa,
                'dataPelapor' => $dataPelapor,
                'dataTerlapor' => $dataTerlapor,
                'modelTembusanMaster' => $modelTembusanMaster,
                'dataLapdu' => $dataLapdu,
                'dataPeraturan' => $dataPeraturan,
                
            ]);
        }
    }

    public function actionUpdate($id,$id2)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        $model = $this->findModel($id,$id2);
        $fungsi=new FungsiComponent();
        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_sk_was_2a,'from_table'=>'Sk-Was-2a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
        $modelSpWas2 = SpWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>1]);
      //  $dataPemeriksa = PemeriksaSpWas2::findAll(["id_sp_was2"=>$modelSpWas2->id_sp_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
        $dataPemeriksa = was10Inspeksi::findOne(["id_sp_was2"=>$modelSpWas2->id_sp_was2,
          'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],
          'nip_pegawai_terlapor'=>$_GET['id'],'trx_akhir'=>'1']);
        $modelPemeriksa = SkWas2aPemeriksa::findAll(["id_sk_was_2a"=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelUraian = SkWas2aUraian::findAll(["id_sk_was_2a"=>$id,
                                              'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                              'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                              'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                              'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                                              'id_level2'=>$_SESSION['was_id_level2'],
                                              'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        
        $queryp = new Query;
        $connection = \Yii::$app->db;
        $sqlPeraturan  ="select a.id_surat,nama_peraturan from was.surat_peraturan a inner join was.master_surat b  on a.id_surat=b.id_surat
                        inner join  was.ms_peraturan c on a.id_peraturan=c.id_peraturan 
                        where a.id_surat='Sk-Was-2A'
                        order by a.is_order asc";
        $dataPeraturan = $connection->createCommand($sqlPeraturan)->queryAll();
        
       // $modelPelapor = SkWas2aPelapor::findAll(["id_sk_was_2a"=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        // print_r($dataPemeriksa);
        // exit();
        $dataLapdu = Lapdu::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_kejati'=>$_SESSION['kode_kejati'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
      //  $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_16b','condition2'=>'master'])->orderBy('id_tembusan desc')->all();
        // print_r($dataLapdu);
        // exit();
        $queryp = new Query;
        $connection = \Yii::$app->db;
        $sqlPelapor="select*from was.pelapor a inner join was.sumber_laporan b 
                     on a.id_sumber_laporan=b.id_sumber_laporan
                     where a.no_register='".$_SESSION['was_register']."' 
                     and a.id_tingkat='".$_SESSION['kode_tk']."' 
                     and a.id_kejati='".$_SESSION['kode_kejati']."' 
                     and a.id_kejari='".$_SESSION['kode_kejari']."' 
                     and a.id_cabjari='".$_SESSION['kode_cabjari']."'";
        $dataPelapor = $connection->createCommand($sqlPelapor)->queryOne();

        $modelTerlapor="select a.*,b.*,c.*,a.bentuk_pelanggaran as keterangan_pelanggaran,d.* 
                        from was.l_was_2_terlapor a 
                        inner join was.was_15_rencana b
                        on a.id_tingkat=b.id_tingkat and
                        a.id_kejati=b.id_kejati and
                        a.id_kejari=b.id_kejari and
                        a.id_cabjari=b.id_cabjari and 
                        a.no_register=b.no_register and
                        a.nip_terlapor=b.nip_terlapor
                        left join kepegawaian.kp_pegawai c
                        on b.nip_terlapor=c.peg_nip_baru   
                        left join was.lapdu d
                        on a.id_tingkat=d.id_tingkat and
                        a.id_kejati=d.id_kejati and
                        a.id_kejari=d.id_kejari and
                        a.id_cabjari=d.id_cabjari and 
                        a.no_register=d.no_register 
                        where b.saran_dari='Jamwas' and b.sk='SK-WAS2-A' and b.nip_terlapor='".$_GET['id2']."'";
        $dataTerlapor = $connection->createCommand($modelTerlapor)->queryOne();
        // print_r($dataTerlapor);
        // exit();
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
                $model->updated_by  = \Yii::$app->user->identity->id;
                $model->pelanggaran = $dataTerlapor['keterangan_pelanggaran'];
                // print_r($model->pelanggaran);
                // exit();
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'sk_was_2a/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'sk_was_2a/'.$OldFile);
                  }

                $jml=count($_POST['uraian']);
                SkWas2aUraian::deleteAll(['id_sk_was_2a'=>$model->id_sk_was_2a,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                    for ($i=0; $i < $jml; $i++) { 
                          $modelsk12aUaraian=new SkWas2aUraian();
                          $modelsk12aUaraian->no_register = $_SESSION['was_register'];
                          $modelsk12aUaraian->id_tingkat  = $_SESSION['kode_tk'];
                          $modelsk12aUaraian->id_kejati   = $_SESSION['kode_kejati'];
                          $modelsk12aUaraian->id_kejari   = $_SESSION['kode_kejari'];
                          $modelsk12aUaraian->id_cabjari  = $_SESSION['kode_cabjari'];
                          $modelsk12aUaraian->id_sp_was2  = $model->id_sp_was2;
                          $modelsk12aUaraian->id_ba_was2  = $model->id_ba_was2;
                          $modelsk12aUaraian->id_l_was2   = $model->id_l_was2;
                          $modelsk12aUaraian->id_was15    = $model->id_was15;
                          $modelsk12aUaraian->id_sk_was_2a= $model->id_sk_was_2a;
                          $modelsk12aUaraian->isi_uraian  = $_POST['uraian'][$i];
                          $modelsk12aUaraian->created_by  =\Yii::$app->user->identity->id;
                          $modelsk12aUaraian->created_ip  =$_SERVER['REMOTE_ADDR'];
                          $modelsk12aUaraian->created_time=date('Y-m-d H:i:s');
                          // print_r($model16uaraian->save());
                          // exit();
                          $modelsk12aUaraian->save();
                    }
                    
                    $pejabat = $_POST['pejabat'];
                    TembusanWas2::deleteAll(['from_table'=>'Sk-Was-2a','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_sk_was_2a),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                        for($z=0;$z<count($pejabat);$z++){
                            $saveTembusan = new TembusanWas2;
                            $saveTembusan->from_table = 'Sk-Was-2a';
                            $saveTembusan->pk_in_table = strrev($model->id_sk_was_2a);
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
                      //1 jabatan (TU) // 0 jabatan (JAKSA)  
                  // if($kp['pns_jnsjbtfungsi'] == '1'){
                  //   $arr = array(ConstSysMenuComponent::Bawas7, ConstSysMenuComponent::Bawas9);
                  // }else if($kp['pns_jnsjbtfungsi'] == '0'){
                     $arr = array(ConstSysMenuComponent::Was18);
                  // }      
                    for ($i=0; $i < 1 ; $i++) { 
                      WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
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
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'sk_was_2a/'.$rename_file);
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
                'modelTembusan' => $modelTembusan,
                'modelPemeriksa'   => $modelPemeriksa,
                'dataPelapor'   => $dataPelapor,
                'modelSpWas2'   => $modelSpWas2,
                'dataPemeriksa'   => $dataPemeriksa,
                'dataLapdu'   => $dataLapdu,
                'modelUraian'   => $modelUraian,
               // 'dataPelapor'   => $dataPelapor,
                'dataTerlapor'   => $dataTerlapor,
                'dataPeraturan'   => $dataPeraturan,
            ]);
        }
    }

     public function actionCetak($id){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $model=$this->findModel2($id);
        // print_r($model);
        // exit();
        $modelwasUraian1=SkWas2aUraian::findAll(['id_sk_was_2a'=>$model->id_sk_was_2a,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4'],'kode_header'=>1]);
        
        $modelwasUraian2=SkWas2aUraian::findAll(['id_sk_was_2a'=>$model->id_sk_was_2a,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4'],'kode_header'=>2]);
        
        $modelwasUraian3=SkWas2aUraian::findAll(['id_sk_was_2a'=>$model->id_sk_was_2a,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4'],'kode_header'=>3]);

        $modelwasUraian4=SkWas2aUraian::findAll(['id_sk_was_2a'=>$model->id_sk_was_2a,'no_register'=>$_SESSION['was_register'],
                            'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                            'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                            'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                            'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
                            'id_level4'=>$_SESSION['was_id_level4'],'kode_header'=>4]);

        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_sk_was_2a,'from_table'=>'Sk-Was-2a',
                            'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                            'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                            'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                            'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                            'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $tgl_sk      =\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_sk_was_2a']);
     //   $tgl_diterima=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl_diterima_sk_was_2a']);
        // print_r($tanggalWas15);
         // print_r($tanggalWas15);
        //  print_r($tgl_diterima);
        // exit();

         return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'model'=>$model,
                                'tgl_sk'=>$tgl_sk,
                              //  'tgl_diterima'=>$tgl_diterima,
                                'modelwasUraian1'=>$modelwasUraian1,
                                'modelwasUraian2'=>$modelwasUraian2,
                                'modelwasUraian3'=>$modelwasUraian3,
                                'modelwasUraian4'=>$modelwasUraian4,
                                'modelTembusan'=>$modelTembusan,
                                ]);
      
    }

     public function actionDelete() {
     $id_sk_was_2a = $_POST['id'];
     $jumlah = $_POST['jml'];
     
   //  echo $id_bawas2;
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id_sk_was_2a);
           // echo $pecah[$i];
          //  $this->findModel($pecah[$i])->delete();
            SkWas2a::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                               'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                               'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                               'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                               'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                               'id_cabjari'=>$_SESSION['kode_cabjari'],'id_sk_was_2a'=>$pecah[$i]]);
            
            TembusanWas2::deleteAll(['from_table'=>'Sk-Was-2a','no_register'=>$_SESSION['was_register'],
                                     'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                     'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                     'pk_in_table'=>$pecah[$i],'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                     'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                     'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                   
             // $arr = array(ConstSysMenuComponent::Was17, ConstSysMenuComponent::Was18);
             //        for ($i=0; $i < 2 ; $i++) { 
             //          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-17
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

    public function actionDelete_old() {
        $pk = $_POST['data'];
        $arr = explode(',', $pk);
        for ($i = 0; $i < count($arr); $i++) {
          if (SkWas2a::updateAll(["flag" => 3], "id_sk_was_2a ='" . $arr[$i] . "'")) {
            TembusanSkWas2a::deleteAll('id_sk_was_2a=:del', [':del'=>$arr[$i]]);
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
            return $this->redirect(['create']);
          } else {
            Yii::$app->getSession()->setFlash('success', [
              'type' => 'danger',
              'duration' => 3000,
              'icon' => 'fa fa-users',
              'message' => 'Data Gagal di Hapus',
              'title' => 'Error',
              'positonY' => 'top',
              'positonX' => 'center',
              'showProgressbar' => true,
            ]);
            return $this->redirect(['create']);
          }
        }
  }

    /**
     * Finds the SkWas2a model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SkWas2a the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionCetak_old($id) {
    $model = $this->findModel($id);

    #instansi satker dan nama
    $query = new Query();
    $instansi = $query->select('a.inst_satkerkd, b.inst_nama')
        ->from('was.dugaan_pelanggaran a')
        ->innerJoin('kepegawaian.kp_inst_satker b', 'a.inst_satkerkd = b.inst_satkerkd')
        ->where('length(a.inst_satkerkd)=:inst_satkerkd AND a.id_register=:id_register AND b.is_active=:is_active',
            [':inst_satkerkd' => 2, ':id_register' => $model->id_register, ':is_active' => 1])->one();

    #lokasi
    $qryLokasi = new Query();
    $lokasi = $qryLokasi->select('a.inst_lokinst')
        ->from('kepegawaian.kp_inst_satker a')
        ->innerJoin('was.sk_was_2a b', 'a.inst_satkerkd=b.inst_satkerkd')
        ->where('length(a.inst_satkerkd)=:inst_satkerkd AND b.id_sk_was_2a=:id_sk_was_2a',
            [':inst_satkerkd' => 2, ':id_sk_was_2a' => $model->id_sk_was_2a])->one();

    $keputusan = VPejabatPimpinan::find()->where('id_jabatan_pejabat=:id_jabatan_pejabat', [':id_jabatan_pejabat' => $model->ttd_sk_was_2a])->one();
    $dugaan_pelanggaran = VDugaanPelanggaran::find()->where('id_register=:id_register', [':id_register' => $model->id_register])->one();
    $terlapor = VTerlapor::find()->where('id_terlapor=:id_terlapor', [':id_terlapor' => $model->id_terlapor])->one();
    $tingkatphd = SpRTingkatphd::findOne(['tingkat_kd' => $model->tingkat_kd]);
    $tandatangan = VRiwayatJabatan::find()->where('id=:id AND peg_nik=:peg_nik', [':id' => $model->ttd_id_jabatan, ':peg_nik' => $model->ttd_peg_nik])->one();
    $pemeriksa = VPemeriksa::find()->where('id_register=:id_register AND sp_was_1=:sp_was_1 AND sp_was_2=:sp_was_2', [':id_register' => $model->id_register, ':sp_was_1' => 1, ':sp_was_2' => 1])->one();

    $dft_pelapor = '';
        foreach (VPelapor::findAll(['id_register' => $model->id_register]) as $key) {
            $dft_pelapor .= $key[nama] . ', ';
        }

    $odf = new Odf(Yii::$app->params['reportPengawasan'] . "sk_was_2a.odt");

    $odf->setVars('nm_kejaksaan', $instansi['inst_nama']);
    $odf->setVars('keputusan', $keputusan->jabatan);
    $odf->setVars('nmr_sk_was_2a', $model->no_sk_was_2a);
    $odf->setVars('nm_pelapor', rtrim($dft_pelapor, ', '));
    $odf->setVars('tgl_laporan', GlobalFuncComponent::tglToWord($dugaan_pelanggaran->tgl_register));
    $odf->setVars('nm_terlapor', $terlapor->peg_nama);
    $odf->setVars('nip_terlapor', $terlapor->peg_nip);
    $odf->setVars('nrp_terlapor', $terlapor->peg_nrp);
    $odf->setVars('pangkat_terlapor', '-');
    $odf->setVars('jabatan_terlapor', $terlapor->jabatan);
    $odf->setVars('perbuatan_terlapor', $dugaan_pelanggaran->uraian);
    $odf->setVars('nm_pemeriksa', $pemeriksa->peg_nama);
    $odf->setVars('nip_pemeriksa', $pemeriksa->peg_nip);
    $odf->setVars('nrp_pemeriksa', $pemeriksa->peg_nrp);
    $odf->setVars('pangkat_pemeriksa', '-');
    $odf->setVars('jabatan_pemeriksa', $pemeriksa->jabatan);
    $odf->setVars('tingkat_kd', $tingkatphd->keterangan);
    $odf->setVars('nmr_peraturan_jaksa_agung', 'PER-022/A/JA/03/2011');
    $odf->setVars('tgl_dugaan_pelanggaran', GlobalFuncComponent::tglToWord($dugaan_pelanggaran->tgl_register));
    $odf->setVars('unit_kerja_terlapor', '-');
    $odf->setVars('ditetapkan', $lokasi['inst_lokinst']);
    $odf->setVars('tgl_ditetapkan', GlobalFuncComponent::tglToWord($model->tgl_sk_was_2a));
    $odf->setVars('nm_penetap', $tandatangan->peg_nama);
    $odf->setVars('jabatan_penetap', $tandatangan->jabatan);
    $odf->setVars('pangkat_penetap', '-');
    $odf->setVars('nip_penetap', $tandatangan->peg_nip_baru);

    if ($model->ttd_sk_was_2a == 1) {
        $odf->setVars('keputusan_keempat', 'Keputusan ini mulai berlaku pada tanggal ditetapkan');
    } else {
        $odf->setVars('keputusan_keempat', 'Apabila tidak ada keberatan, maka Keputusan ini mulai berlaku pada hari kelima belas terhitung mulai tanggal terlapor menerima keputusan ini.');
    }

    #tembusan
    $query = new Query();
    $query->select('a.jabatan')
        ->from('was.v_pejabat_tembusan a')
        ->innerJoin('was.tembusan_sk_was_2a b', 'a.id_pejabat_tembusan = b.id_pejabat_tembusan')
        ->innerJoin('was.sk_was_2a c', 'b.id_sk_was_2a = c.id_sk_was_2a')
        ->where("c.id_sk_was_2a=:id_sk_was_2a", [':id_sk_was_2a' => $model->id_sk_was_2a]);
    $dt_tembusan = $query->createCommand();
    $listTembusan = $dt_tembusan->queryAll();
    $i = 1;
    $dft_tembusan = $odf->setSegment('tembusan');
    foreach ($listTembusan as $element) {
        //$dft_tembusan->urutan_tembusan($element['no_urut']);
        $dft_tembusan->urutan_tembusan($i);
        $dft_tembusan->nama_tembusan($element['jabatan']);
        $dft_tembusan->merge();
        $i++;
    }
    $odf->mergeSegment($dft_tembusan);

    $dugaan = DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister" => $model->id_register])->asArray()->one();

        $odf->exportAsAttachedFile("SK.WAS-2A ".$dugaan['terlapor'].'.odt');   
   }


   public function actionGetttd(){
       
   $searchModelskwas2a = new SkWas2aSearch();
   $dataProviderPenandatangan = $searchModelskwas2a->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]); 
   echo GridView::widget([
                        'dataProvider'=> $dataProviderPenandatangan,
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
                                    return ['value' => $data['id_surat'],'class'=>'MPenandatangan_selection_one','json'=>$result];
                                    },
                            ],
                            
                         ],   

                    ]);
          Pjax::end();
          echo '<div class="modal-loading-new"></div>';
    }

     protected function findModel($id,$id2)
    {
        if (($model = SkWas2a::findOne(['id_sk_was_2a'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    } 

    protected function findModel2($id)
    {
        if (($model = SkWas2a::findOne(['id_sk_was_2a'=>$id,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
