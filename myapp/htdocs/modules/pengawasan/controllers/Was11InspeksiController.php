<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was11Inspeksi;
use app\modules\pengawasan\models\Was11InspeksiSearch;
use app\modules\pengawasan\models\Was9Inspeksi;
use app\modules\pengawasan\models\Was11InspeksiSaksiInt;
use app\modules\pengawasan\models\Was11InspeksiSaksiEks;
use app\modules\pengawasan\models\TembusanWas11Inspeksi;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\KpInstSatker;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\SaksiInternalInspeksi;/*mengambil saksi internal*/
use app\modules\pengawasan\models\SaksiEksternalInspeksi;/*mengambil saksi external*/
use app\modules\pengawasan\models\Lapdu;/*mengambil Lapdu untuk report*/
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\components\FungsiComponent; 
use app\models\KpInstSatkerSearch;
use app\models\KpPegawai;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use Odf;
use yii\grid\GridView;
use yii\widgets\Pjax;

use app\components\GlobalFuncComponent; 

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was11InspeksiController extends Controller
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

        // echo "string";
        // exit();
        $searchModel = new Was11InspeksiSearch();
        $dataProviderInt = $searchModel->searchInt(Yii::$app->request->queryParams);
        $dataProviderEks = $searchModel->searchEks(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProviderInt' => $dataProviderInt,
            'dataProviderEks' => $dataProviderEks,
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

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
  public function actionCreate($jns)
    {
    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    
        $model = new Was11Inspeksi();
        // print_r($model);
        // exit();
      //  $modelTembusan = new TembusanWas11();
        // $modelTembusanMaster = TembusanWas::findAll(["for_tabel"=>'was_11']);
       // $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_11','condition2'=>'master'])->all();
        $modelTembusanMaster = TembusanWas::findBySql("select * from was.was_tembusan_master where for_tabel='was_11_inspeksi' or for_tabel='master'")->all();
        $connection = \Yii::$app->db;
        /*cek expire tanggal SPWAS1*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();/*karena ada perubahan kode*/ 
        $filter_0          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                              and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
        $modelSpwas2=$fungsi->FunctGetIdSpwas2All($filter_0);/*karena ada perubahan kode*/ 
        $modelwas9   =$fungsi->FunctGetIdWas9All($filter_0);/*karena ada perubahan kode*/ 
         
        

        // $FungsiWas      =new FungsiComponent();
        // $filter         ="is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."' and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        // $getId          =$FungsiWas->FunctGetIdSpwas1($filter);
   

        if ($model->load(Yii::$app->request->post())) {

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                // $model->id_was_11='1';
                // $model->inst_satkerkd = $_SESSION['inst_satkerkd'];
                $model->no_register = $_SESSION['was_register'];
                $model->id_tingkat  = $_SESSION['kode_tk'];
                $model->id_kejati   = $_SESSION['kode_kejati'];
                $model->id_kejari   = $_SESSION['kode_kejari'];
                $model->id_cabjari  = $_SESSION['kode_cabjari'];
              //  $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                $model->id_sp_was2   = $modelSpwas2['id_sp_was2'];
                $model->id_surat_was9= $modelwas9['id_surat_was9'];
                // $model->upload_file = $rename_file;
                $model->created_ip = $_SERVER['REMOTE_ADDR'];
                $model->created_time = date('Y-m-d H:i:s');
                $model->created_by = \Yii::$app->user->identity->id;
                $model->jns_saksi =$_POST['jenis_saksi'];

            if($model->save()){
            //     print_r($model->id_surat_was11);
              //   exit();
                // if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_12/'.$OldFile)) {
    //               unlink(\Yii::$app->params['uploadPath'].'was_12/'.$OldFile);
    //           }
            // print_r($model);
            //         exit();
            $tmp_jns = $_POST['jenis_saksi'];

            if($tmp_jns=='Internal'){
            $saksi_int = $_POST['Mnip_saksi'];
                for($i=0;$i<count($saksi_int);$i++){
                    $query="select a.id_surat_was9,a.id_sp_was2,b.nip,b.nrp,b.nama_saksi_internal,b.pangkat_saksi_internal,
                            b.golongan_saksi_internal,b.jabatan_saksi_internal 
                            from was.was9_inspeksi a inner join was.saksi_internal_inspeksi b 
                                on a.id_saksi_internal=b.id_saksi_internal
                                and a.id_tingkat=b.id_tingkat
                                and a.id_kejati=b.id_kejati
                                AND a.id_kejari = b.id_kejari
                                AND a.id_cabjari = b.id_cabjari
                                AND a.no_register = b.no_register
                                and a.id_wilayah = b.id_wilayah 
                                and a.id_level1 = b.id_level1 
                                and a.id_level2 = b.id_level2 
                                and a.id_level3 = b.id_level3 
                                and a.id_level4 = b.id_level4  
                                where b.nip='".$_POST['Mnip_saksi'][$i]."' and a.jenis_saksi='Internal' and
                                 a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and 
                                 a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and 
                                 a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_level1='".$_SESSION['was_id_level1']."' and 
                                 a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and 
                                 a.id_level4='".$_SESSION['was_id_level4']."'";
                    // print_r($query);
                    // exit();  
                    $saksiIN = $connection->createCommand($query)->queryOne();

                    $where1=$fungsi->static_where();
                    $filter_1    =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                    and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 
                                    and id_saksi_internal='".$_POST['Mid_saksi'][$i]."' $where1";
                    $modelwas9int=$fungsi->FunctGetIdWas9All($filter_1);/*karena ada perubahan kode*/
                    // print_r($modelwas9int);
                    // exit();

                    $Was11Detail = new Was11InspeksiSaksiInt;
                    $Was11Detail->no_register   =$_SESSION['was_register'];
                    $Was11Detail->id_tingkat    =$_SESSION['kode_tk'];
                    $Was11Detail->id_kejati     =$_SESSION['kode_kejati'];
                    $Was11Detail->id_kejari     =$_SESSION['kode_kejari'];
                    $Was11Detail->id_cabjari    =$_SESSION['kode_cabjari'];
                    $Was11Detail->nip_pemeriksa       = $modelwas9int['nip_pemeriksa'];
                    $Was11Detail->nrp_pemeriksa       = $modelwas9int['nrp_pemeriksa'];
                    //$Was11Detail->id_pemeriksa      = $modelwas9int['id_pemeriksa_sp_was2'];
                    $Was11Detail->nama_pemeriksa      = $modelwas9int['nama_pemeriksa'];
                    $Was11Detail->golongan_pemeriksa  = $modelwas9int['golongan_pemeriksa'];
                    $Was11Detail->pangkat_pemeriksa   = $modelwas9int['pangkat_pemeriksa'];
                    $Was11Detail->jabatan_pemeriksa   = $modelwas9int['jabatan_pemeriksa'];
                    $Was11Detail->tanggal_pemeriksaan = $modelwas9int['tanggal_pemeriksaan_was9'];
                    $Was11Detail->hari_pemeriksaan    = $modelwas9int['hari_pemeriksaan_was9'];
                    $Was11Detail->jam_pemeriksaan     = $modelwas9int['jam_pemeriksaan_was9'];
                    //$Was11Detail->satker_pemeriksa    = $modelwas9int['jabatan_pemeriksa'];
                    $Was11Detail->tempat_pemeriksaan  = $modelwas9int['tempat_pemeriksaan_was9'];
                    // $Was11Detail->id_wilayah = $_SESSION['was_id_wilayah'];
                    // $Was11Detail->id_level1 = $_SESSION['was_id_level1'];
                    // $Was11Detail->id_level2 = $_SESSION['was_id_level2'];
                    // $Was11Detail->id_level3 = $_SESSION['was_id_level3'];
                    // $Was11Detail->id_level4 = $_SESSION['was_id_level4'];
                    // $Was11Detail->id_was_11_detail_int=1;
                    $Was11Detail->id_was_11=$model->id_surat_was11;
                    $Was11Detail->id_sp_was2 = $model->id_sp_was2;
                    $Was11Detail->id_was_9 = $model->id_surat_was9;
                    $Was11Detail->nip_saksi_internal=$saksiIN['nip'];
                    $Was11Detail->nrp_saksi_internal=$saksiIN['nrp'];
                    $Was11Detail->nama_saksi_internal=$saksiIN['nama_saksi_internal'];
                    $Was11Detail->pangkat_saksi_internal=$saksiIN['pangkat_saksi_internal'];
                    $Was11Detail->golongan_saksi_internal=$saksiIN['golongan_saksi_internal'];
                    $Was11Detail->jabatan_saksi_internal=$saksiIN['jabatan_saksi_internal'];
                   // $Was11Detail->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                    $Was11Detail->created_ip = $_SERVER['REMOTE_ADDR'];
                    $Was11Detail->created_time = date('Y-m-d H:i:s');
                    $Was11Detail->created_by = \Yii::$app->user->identity->id;
                    
                    
                    $Was11Detail->save();
                }           
            }else{
                $saksi_eks = $_POST['Mid_saksi_eksternal'];
                echo "string";
                echo $_POST['Mid_saksi_ekternal'];
                // exit();
                for($i=0;$i<count($saksi_eks);$i++){
                    $query="select a.id_surat_was9,a.id_sp_was2,b.id_saksi_eksternal,b.nama_saksi_eksternal,
                            b.nama_kota_saksi_eksternal,b.alamat_saksi_eksternal
                            from was.was9_inspeksi a inner join was.saksi_eksternal_inspeksi b 
                                on a.id_saksi_eksternal=b.id_saksi_eksternal
                                AND a.id_tingkat=b.id_tingkat
                                AND a.id_kejati=b.id_kejati
                                AND a.id_kejari = b.id_kejari
                                AND a.id_cabjari = b.id_cabjari
                                AND a.no_register = b.no_register
                                AND a.id_wilayah = b.id_wilayah 
                                AND a.id_level1 = b.id_level1 
                                AND a.id_level2 = b.id_level2 
                                AND a.id_level3 = b.id_level3 
                                AND a.id_level4 = b.id_level4  
                                where b.id_saksi_eksternal='".$_POST['Mid_saksi_eksternal'][$i]."'
                                and a.jenis_saksi='Eksternal' and
                                 a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                                 and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                                 and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_level1='".$_SESSION['was_id_level1']."' 
                                 and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' 
                                 and a.id_level4='".$_SESSION['was_id_level4']."'";
                    $saksiEk = $connection->createCommand($query)->queryOne(); 

                    $Was11Detail_ek = new Was11InspeksiSaksiEks;
                    $where2=$fungsi->static_where();  
                    $filter_2    =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                    and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 
                                    and id_saksi_eksternal='".$_POST['Mid_saksi_eksternal'][$i]."' $where2";
                    $modelwas9eks=$fungsi->FunctGetIdWas9All($filter_2);/*karena ada perubahan kode*/
                    // print_r($modelwas9eks);
                    // exit();

                    $Was11Detail_ek->no_register=$_SESSION['was_register'];
                    $Was11Detail_ek->id_tingkat=$_SESSION['kode_tk'];
                    $Was11Detail_ek->id_kejati=$_SESSION['kode_kejati'];
                    $Was11Detail_ek->id_kejari=$_SESSION['kode_kejari'];
                    $Was11Detail_ek->id_cabjari=$_SESSION['kode_cabjari'];
                    $Was11Detail_ek->id_was_11=$model->id_surat_was11;
                    $Was11Detail_ek->id_sp_was2 = $model->id_sp_was2;
                    $Was11Detail_ek->id_was_9 = $model->id_surat_was9;
                    $Was11Detail_ek->nama_saksi_eksternal=$saksiEk['nama_saksi_eksternal'];
                    $Was11Detail_ek->alamat_saksi_eksternal=$saksiEk['alamat_saksi_eksternal'];
                    $Was11Detail_ek->nip_pemeriksa     = $modelwas9eks['nip_pemeriksa'];
                    $Was11Detail_ek->nrp_pemeriksa     = $modelwas9eks['nrp_pemeriksa'];
                    //$Was11Detail_ek->id_pemeriksa      = $modelwas9eks['id_pemeriksa_sp_was2'];
                    $Was11Detail_ek->nama_pemeriksa    = $modelwas9eks['nama_pemeriksa'];
                    $Was11Detail_ek->golongan_pemeriksa= $modelwas9eks['golongan_pemeriksa'];
                    $Was11Detail_ek->pangkat_pemeriksa = $modelwas9eks['pangkat_pemeriksa'];
                    $Was11Detail_ek->jabatan_pemeriksa = $modelwas9eks['jabatan_pemeriksa'];
                    $Was11Detail_ek->tanggal_pemeriksaan = $modelwas9eks['tanggal_pemeriksaan_was9'];
                    $Was11Detail_ek->hari_pemeriksaan    = $modelwas9eks['hari_pemeriksaan_was9'];
                    $Was11Detail_ek->jam_pemeriksaan     = $modelwas9eks['jam_pemeriksaan_was9'];
                  //  $Was11Detail_ek->satker_pemeriksa  = $modelwas9eks['jabatan_pemeriksa'];
                    $Was11Detail_ek->tempat_pemeriksaan  = $modelwas9eks['tempat_pemeriksaan_was9'];
                    //$Was11Detail_ek->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                    $Was11Detail_ek->created_ip = $_SERVER['REMOTE_ADDR'];
                    $Was11Detail_ek->created_time = date('Y-m-d H:i:s');
                    $Was11Detail_ek->created_by = \Yii::$app->user->identity->id;
                    $Was11Detail_ek->save();
                }
            }

             $pejabat = $_POST['pejabat'];
            TembusanWas2::deleteAll(['from_table'=>'Was-11Inspeksi','id_wilayah'=>$_SESSION['was_id_wilayah']
                                      ,'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2']
                                      ,'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']
                                      ,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk']
                                      ,'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari']
                                      ,'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_surat_was11)]);
            //TembusanWas2::deleteAll(['from_table'=>'Was9','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was9,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                      
                      $pejabat = $_POST['pejabat'];
                       for($z=0;$z<count($pejabat);$z++){
                      $saveTembusan = new TembusanWas2;
                      $saveTembusan->from_table = 'Was-11Inspeksi';
                      $saveTembusan->pk_in_table = strrev($model->id_surat_was11);
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


                    if($model->jbtn_penandatangan == 'Jaksa Agung Muda PENGAWASAN'){    
                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3544';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='1';
                            $modelTrxPemrosesan1->id_level3 ='2';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
                       }

            // $pejabat = $_POST['pejabat'];
            //    for($z=0;$z<count($pejabat);$z++){
            //                 $saveTembusan = new TembusanWas2;
            //                 $saveTembusan->from_table = 'Was-11';
            //                 $saveTembusan->pk_in_table = strrev($model->id_surat_was11);
            //                 $saveTembusan->tembusan = $_POST['pejabat'][$z];
            //                 $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
            //                 $saveTembusan->created_time = date('Y-m-d H:i:s');
            //                 $saveTembusan->created_by = \Yii::$app->user->identity->id;
            //                 // $saveTembusan->inst_satkerkd = $_SESSION['inst_satkerkd'];s
            //                 $saveTembusan->no_register = $_SESSION['was_register'];
            //                 $saveTembusan->id_tingkat = $_SESSION['kode_tk'];
            //                 $saveTembusan->id_kejati = $_SESSION['kode_kejati'];
            //                 $saveTembusan->id_kejari = $_SESSION['kode_kejari'];
            //                 $saveTembusan->id_cabjari = $_SESSION['kode_cabjari'];
            //                 $saveTembusan->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
            //                 $saveTembusan->save();
            //             }


            // move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_11/'.$rename_file);
			
			if($model->jbtn_penandatangan == 'Jaksa Agung Muda PENGAWASAN'){    
			  // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			  //    AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			  //    and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='1';
				$modelTrxPemrosesan1->id_level3 ='2';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}else if($model->jbtn_penandatangan == 'Sekretaris JAM PENGAWASAN'){
				 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
				 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
				 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='1';
				$modelTrxPemrosesan1->id_level3 ='0';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}else if($model->jbtn_penandatangan == 'Inspektur I '){
				 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
				 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
				 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='8';
				$modelTrxPemrosesan1->id_level3 ='0';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}else if($model->jbtn_penandatangan == 'Inspektur II'){
				 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
				 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
				 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='9';
				$modelTrxPemrosesan1->id_level3 ='0';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}else if($model->jbtn_penandatangan == 'Inspektur III'){
				 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
				 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
				 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='10';
				$modelTrxPemrosesan1->id_level3 ='0';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}else if($model->jbtn_penandatangan == 'Inspektur IV'){
				 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
				 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
				 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='11';
				$modelTrxPemrosesan1->id_level3 ='0';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}else if($model->jbtn_penandatangan == 'Inspektur V'){
				 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
				 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
				 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
				$modelTrxPemrosesan1=new WasTrxPemrosesan();
				$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
				$modelTrxPemrosesan1->id_sys_menu='3544';
				$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
				$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
				$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
				$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
				$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
				$modelTrxPemrosesan1->id_wilayah='1';
				$modelTrxPemrosesan1->id_level1 ='6';
				$modelTrxPemrosesan1->id_level2 ='12';
				$modelTrxPemrosesan1->id_level3 ='0';
				$modelTrxPemrosesan1->id_level4 ='0';
				$modelTrxPemrosesan1->save();
			}
			
            $transaction->commit();

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
             return $this->redirect(['index']);
            }
            
            else{
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
             return $this->redirect(['index']);
            }
            
            } catch(Exception $e) {
                    $transaction->rollback();
            }
            
            
        } else {
            return $this->render('create', [
                'model' => $model,
                // 'searchSatker' => $searchSatker,
                // 'dataProviderSatker' => $dataProviderSatker,
                'modelTembusanMaster' => $modelTembusanMaster,
                'modelSaksiIn' => $modelSaksiIn,
                'modelSaksiEk' => $modelSaksiEk,
                // 'modelSaksiIn_trans' => $modelSaksiIn_trans,
                // 'modelSaksiEk_trans' => $modelSaksiEk_trans,
                 'modelSpwas2' => $modelSpwas2,
            ]);
        }
        
        
    }


    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($jns,$id)
    {
      $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
      $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

       $connection = \Yii::$app->db;
       $model = $this->findModel($id);

       if($jns=='Internal'){
              $sql="select*from was.was11_inspeksi_saksi_int a where 
               a.id_was_11='".$model->id_surat_was11."' 
               and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."'
               and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."'
               and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."'
               and a.id_level4='".$_SESSION['was_id_level4']."'";
              $modelSaksiIn_trans = $connection->createCommand($sql)->queryAll(); 
        }else if($jns=='Eksternal'){
              $sql="select*from was.was11_inspeksi_saksi_ext a where 
               a.id_was_11='".$model->id_surat_was11."' 
               and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."'
               and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."'
               and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."'
               and a.id_level4='".$_SESSION['was_id_level4']."'";
              $modelSaksiIn_trans = $connection->createCommand($sql)->queryAll(); 
        }
          //      print_r($sql);
          // exit();
        
       // if($_GET['jns'] == 'Internal'){
       //   $modelSaksiIn_trans=$this->findModel_int($id);
       // }else{
       //   $modelSaksiIn_trans=$this->findModel_eks($id);
       // }
        // print_r($modelSaksiIn_trans);
        // exit();

        $modelTembusanMaster = TembusanWas::findBySql("select * from was.was_tembusan_master where for_tabel='was_11_inspeksi' or for_tabel='master'")->all();
        $connection = \Yii::$app->db;
        /*cek expire tanggal SPWAS1*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();/*karena ada perubahan kode*/ 
        $filter_0          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                              and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
        $modelSpwas2 =$fungsi->FunctGetIdSpwas2All($filter_0);/*Pembatasan Tanggal Sp was2*/ 
        $modelwas9   =$fungsi->FunctGetIdWas9All($filter_0);/*karena ada perubahan kode*/ 
        

        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$id,'from_table'=>'Was-11Inspeksi',
                                              'no_register'=>$model->no_register,'id_tingkat'=>$model->id_tingkat,
                                              'id_kejati'=>$model->id_kejati,'id_kejari'=>$model->id_kejari,
                                              'id_cabjari'=>$model->id_cabjari,'id_wilayah'=>$model->id_wilayah,
                                              'id_level1'=>$model->id_level1,'id_level2'=>$model->id_level2,
                                              'id_level3'=>$model->id_level3,'id_level4'=>$model->id_level4]);

        $Fungsi         =new GlobalFuncComponent();
        $table          ='sp_was_2';
        $filed          ='tanggal_akhir_sp_was2';
        $filter_1          ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was2 is not null $where";
        $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);
        
     //   $modelSaksiEksternal = new SaksiEksternalInspeksi();

            $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/         
            $OldFile=$model->upload_file;

            if($model->load(Yii::$app->request->post())){
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
              if($model->save()){
                  if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_10/'.$OldFile)) {
                          unlink(\Yii::$app->params['uploadPath'].'was_11/'.$OldFile);
                      } 

          
          // $tmp_jns = $jns;
            if($jns=='Internal'){
                Was11InspeksiSaksiInt::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                                             'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                             'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                             'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                             'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                             'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_11'=>$id]);

                $saksi_int = $_POST['Mnip_saksi'];
                for($i=0;$i<count($saksi_int);$i++){
                    $query="select a.id_surat_was9,a.id_sp_was2,b.nip,b.nrp,b.nama_saksi_internal,b.pangkat_saksi_internal,
                            b.golongan_saksi_internal,b.jabatan_saksi_internal 
                            from was.was9_inspeksi a inner join was.saksi_internal_inspeksi b 
                                on a.id_saksi_internal=b.id_saksi_internal
                                and a.id_tingkat=b.id_tingkat
                                and a.id_kejati=b.id_kejati
                                AND a.id_kejari = b.id_kejari
                                AND a.id_cabjari = b.id_cabjari
                                AND a.no_register = b.no_register
                                and a.id_wilayah = b.id_wilayah 
                                and a.id_level1 = b.id_level1 
                                and a.id_level2 = b.id_level2 
                                and a.id_level3 = b.id_level3 
                                and a.id_level4 = b.id_level4  
                                where b.nip='".$_POST['Mnip_saksi'][$i]."'
                                and a.jenis_saksi='Internal' and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
                    $saksiIN = $connection->createCommand($query)->queryOne();

                   // $where1=$fungsi->static_where();
                    $filter_1    =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                    and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 
                                    and id_saksi_internal='".$_POST['Mid_saksi'][$i]."' 
                                    and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' 
                                    and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' 
                                    and id_level4='".$_SESSION['was_id_level4']."'";
                    $modelwas9int=$fungsi->FunctGetIdWas9All($filter_1);/*karena ada perubahan kode*/
                    // print_r($modelwas9int);
                    // exit();

                    $Was11Detail = new Was11InspeksiSaksiInt;
                    $Was11Detail->no_register=$_SESSION['was_register'];
                    $Was11Detail->id_tingkat=$_SESSION['kode_tk'];
                    $Was11Detail->id_kejati=$_SESSION['kode_kejati'];
                    $Was11Detail->id_kejari=$_SESSION['kode_kejari'];
                    $Was11Detail->id_cabjari=$_SESSION['kode_cabjari'];
                    $Was11Detail->nip_pemeriksa     = $modelwas9int['nip_pemeriksa'];
                    $Was11Detail->nrp_pemeriksa     = $modelwas9int['nrp_pemeriksa'];
                    //$Was11Detail->id_pemeriksa      = $modelwas9int['id_pemeriksa_sp_was2'];
                    $Was11Detail->nama_pemeriksa    = $modelwas9int['nama_pemeriksa'];
                    $Was11Detail->golongan_pemeriksa= $modelwas9int['golongan_pemeriksa'];
                    $Was11Detail->pangkat_pemeriksa = $modelwas9int['pangkat_pemeriksa'];
                    $Was11Detail->jabatan_pemeriksa = $modelwas9int['jabatan_pemeriksa'];
                    $Was11Detail->tanggal_pemeriksaan = $modelwas9int['tanggal_pemeriksaan_was9'];
                    $Was11Detail->hari_pemeriksaan    = $modelwas9int['hari_pemeriksaan_was9'];
                    $Was11Detail->jam_pemeriksaan     = $modelwas9int['jam_pemeriksaan_was9'];
                  //  $Was11Detail->satker_pemeriksa  = $modelwas9int['jabatan_pemeriksa'];
                    $Was11Detail->tempat_pemeriksaan  = $modelwas9int['tempat_pemeriksaan_was9'];
                    $Was11Detail->id_was_11=$model->id_surat_was11;
                    $Was11Detail->id_sp_was2 = $model->id_sp_was2;
                    $Was11Detail->id_was_9 = $model->id_surat_was9;
                    $Was11Detail->nip_saksi_internal=$saksiIN['nip'];
                    $Was11Detail->nrp_saksi_internal=$saksiIN['nrp'];
                    $Was11Detail->nama_saksi_internal=$saksiIN['nama_saksi_internal'];
                    $Was11Detail->pangkat_saksi_internal=$saksiIN['pangkat_saksi_internal'];
                    $Was11Detail->golongan_saksi_internal=$saksiIN['golongan_saksi_internal'];
                    $Was11Detail->jabatan_saksi_internal=$saksiIN['jabatan_saksi_internal'];
                   // $Was11Detail->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                    $Was11Detail->created_ip = $_SERVER['REMOTE_ADDR'];
                    $Was11Detail->created_time = date('Y-m-d H:i:s');
                    $Was11Detail->created_by = \Yii::$app->user->identity->id;
                    $Was11Detail->save();            
            }
        }else{
                
                Was11InspeksiSaksiEks::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                                             'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                             'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                             'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                             'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                             'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_11'=>$id]);
                
                $saksi_eks = $_POST['Mid_saksi_eksternal'];
                // echo "string";
                echo $_POST['Mid_saksi_ekternal'];
                // exit();
                for($i=0;$i<count($saksi_eks);$i++){
                    $query="select a.id_surat_was9,a.id_sp_was2,b.id_saksi_eksternal,b.nama_saksi_eksternal,
                            b.nama_kota_saksi_eksternal,b.alamat_saksi_eksternal
                            from was.was9_inspeksi a inner join was.saksi_eksternal_inspeksi b 
                                on a.id_saksi_eksternal=b.id_saksi_eksternal
                                AND a.id_tingkat=b.id_tingkat
                                AND a.id_kejati=b.id_kejati
                                AND a.id_kejari = b.id_kejari
                                AND a.id_cabjari = b.id_cabjari
                                AND a.no_register = b.no_register
                                AND a.id_wilayah = b.id_wilayah 
                                AND a.id_level1 = b.id_level1 
                                AND a.id_level2 = b.id_level2 
                                AND a.id_level3 = b.id_level3 
                                AND a.id_level4 = b.id_level4  
                                where b.id_saksi_eksternal='".$_POST['Mid_saksi_eksternal'][$i]."'
                                and a.jenis_saksi='Eksternal' and a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."' and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."' and a.id_level4='".$_SESSION['was_id_level4']."'";
                    $saksiEk = $connection->createCommand($query)->queryOne(); 
                    // print_r($query);
                    // exit();
                    // print_r($saksiEk);
                    // exit();

                    $Was11Detail_ek = new Was11InspeksiSaksiEks;
                    $where2=$fungsi->static_where();  
                    $filter_2    =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                                    and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 
                                    and id_saksi_eksternal='".$_POST['Mid_saksi_eksternal'][$i]."' $where2";
                    $modelwas9eks=$fungsi->FunctGetIdWas9All($filter_2);/*karena ada perubahan kode*/
                    

                    $Was11Detail_ek->no_register=$_SESSION['was_register'];
                    $Was11Detail_ek->id_tingkat=$_SESSION['kode_tk'];
                    $Was11Detail_ek->id_kejati=$_SESSION['kode_kejati'];
                    $Was11Detail_ek->id_kejari=$_SESSION['kode_kejari'];
                    $Was11Detail_ek->id_cabjari=$_SESSION['kode_cabjari'];
                    $Was11Detail_ek->id_was_11=$model->id_surat_was11;
                    $Was11Detail_ek->id_sp_was2 = $model->id_sp_was2;
                    $Was11Detail_ek->id_was_9 = $model->id_surat_was9;
                    $Was11Detail_ek->nama_saksi_eksternal      =$saksiEk['nama_saksi_eksternal'];
                    $Was11Detail_ek->nama_kota_saksi_eksternal =$saksiEk['nama_kota_saksi_eksternal'];
                    $Was11Detail_ek->alamat_saksi_eksternal=$saksiEk['alamat_saksi_eksternal'];
                    $Was11Detail_ek->nip_pemeriksa     = $modelwas9eks['nip_pemeriksa'];
                    $Was11Detail_ek->nrp_pemeriksa     = $modelwas9eks['nrp_pemeriksa'];
                    //$Was11Detail_ek->id_pemeriksa      = $modelwas9eks['id_pemeriksa_sp_was2'];
                    $Was11Detail_ek->nama_pemeriksa    = $modelwas9eks['nama_pemeriksa'];
                    $Was11Detail_ek->golongan_pemeriksa= $modelwas9eks['golongan_pemeriksa'];
                    $Was11Detail_ek->pangkat_pemeriksa = $modelwas9eks['pangkat_pemeriksa'];
                    $Was11Detail_ek->jabatan_pemeriksa = $modelwas9eks['jabatan_pemeriksa'];
                    $Was11Detail_ek->tanggal_pemeriksaan = $modelwas9eks['tanggal_pemeriksaan_was9'];
                    $Was11Detail_ek->hari_pemeriksaan    = $modelwas9eks['hari_pemeriksaan_was9'];
                    $Was11Detail_ek->jam_pemeriksaan     = $modelwas9eks['jam_pemeriksaan_was9'];
                  //  $Was11Detail_ek->satker_pemeriksa  = $modelwas9eks['jabatan_pemeriksa'];
                    $Was11Detail_ek->tempat_pemeriksaan  = $modelwas9eks['tempat_pemeriksaan_was9'];
                    //$Was11Detail_ek->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
                    $Was11Detail_ek->created_ip = $_SERVER['REMOTE_ADDR'];
                    $Was11Detail_ek->created_time = date('Y-m-d H:i:s');
                    $Was11Detail_ek->created_by = \Yii::$app->user->identity->id;
                    // print_r($Was11Detail_ek);
                    // exit();
                    $Was11Detail_ek->save();
                }
            } 
    
         $pejabat = $_POST['pejabat'];
            TembusanWas2::deleteAll(['from_table'=>'Was-11Inspeksi','id_wilayah'=>$_SESSION['was_id_wilayah']
                                      ,'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2']
                                      ,'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']
                                      ,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk']
                                      ,'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari']
                                      ,'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$id]);
            //TembusanWas2::deleteAll(['from_table'=>'Was9','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was9,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                      
                      $pejabat = $_POST['pejabat'];
                       for($z=0;$z<count($pejabat);$z++){
                      $saveTembusan = new TembusanWas2;
                      $saveTembusan->from_table = 'Was-11Inspeksi';
                      $saveTembusan->pk_in_table = $id;
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

                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
                          
                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");

                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='8' and id_level3 ='0' and id_level4 ='0'");

                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='9' and id_level3 ='0' and id_level4 ='0'");

                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='10' and id_level3 ='0' and id_level4 ='0'");

                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='11' and id_level3 ='0' and id_level4 ='0'");

                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                                 AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                                 and id_level2 ='12' and id_level3 ='0' and id_level4 ='0'");

            if($model->jbtn_penandatangan == 'Jaksa Agung Muda PENGAWASAN'){    
                          WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                             AND id_sys_menu='3544' and id_wilayah='1' and id_level1 ='6' 
                             and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
                            $modelTrxPemrosesan1=new WasTrxPemrosesan();
                            $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                            $modelTrxPemrosesan1->id_sys_menu='3544';
                            $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                            $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                            $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                            $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                            $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                            $modelTrxPemrosesan1->id_wilayah='1';
                            $modelTrxPemrosesan1->id_level1 ='6';
                            $modelTrxPemrosesan1->id_level2 ='1';
                            $modelTrxPemrosesan1->id_level3 ='2';
                            $modelTrxPemrosesan1->id_level4 ='0';
                            $modelTrxPemrosesan1->save();
            }else if($model->jbtn_penandatangan == 'Sekretaris JAM PENGAWASAN'){
                 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                $modelTrxPemrosesan1=new WasTrxPemrosesan();
                $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan1->id_sys_menu='3544';
                $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan1->id_wilayah='1';
                $modelTrxPemrosesan1->id_level1 ='6';
                $modelTrxPemrosesan1->id_level2 ='1';
                $modelTrxPemrosesan1->id_level3 ='0';
                $modelTrxPemrosesan1->id_level4 ='0';
                $modelTrxPemrosesan1->save();
            }else if($model->jbtn_penandatangan == 'Inspektur I '){
                 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                $modelTrxPemrosesan1=new WasTrxPemrosesan();
                $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan1->id_sys_menu='3544';
                $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan1->id_wilayah='1';
                $modelTrxPemrosesan1->id_level1 ='6';
                $modelTrxPemrosesan1->id_level2 ='8';
                $modelTrxPemrosesan1->id_level3 ='0';
                $modelTrxPemrosesan1->id_level4 ='0';
                $modelTrxPemrosesan1->save();
            }else if($model->jbtn_penandatangan == 'Inspektur II'){
                 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                $modelTrxPemrosesan1=new WasTrxPemrosesan();
                $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan1->id_sys_menu='3544';
                $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan1->id_wilayah='1';
                $modelTrxPemrosesan1->id_level1 ='6';
                $modelTrxPemrosesan1->id_level2 ='9';
                $modelTrxPemrosesan1->id_level3 ='0';
                $modelTrxPemrosesan1->id_level4 ='0';
                $modelTrxPemrosesan1->save();
            }else if($model->jbtn_penandatangan == 'Inspektur III'){
                 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                $modelTrxPemrosesan1=new WasTrxPemrosesan();
                $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan1->id_sys_menu='3544';
                $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan1->id_wilayah='1';
                $modelTrxPemrosesan1->id_level1 ='6';
                $modelTrxPemrosesan1->id_level2 ='10';
                $modelTrxPemrosesan1->id_level3 ='0';
                $modelTrxPemrosesan1->id_level4 ='0';
                $modelTrxPemrosesan1->save();
            }else if($model->jbtn_penandatangan == 'Inspektur IV'){
                 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                $modelTrxPemrosesan1=new WasTrxPemrosesan();
                $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan1->id_sys_menu='3544';
                $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan1->id_wilayah='1';
                $modelTrxPemrosesan1->id_level1 ='6';
                $modelTrxPemrosesan1->id_level2 ='11';
                $modelTrxPemrosesan1->id_level3 ='0';
                $modelTrxPemrosesan1->id_level4 ='0';
                $modelTrxPemrosesan1->save();
            }else if($model->jbtn_penandatangan == 'Inspektur V'){
                 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
                 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
                 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
                $modelTrxPemrosesan1=new WasTrxPemrosesan();
                $modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
                $modelTrxPemrosesan1->id_sys_menu='3544';
                $modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
                $modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
                $modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
                $modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan1->id_wilayah='1';
                $modelTrxPemrosesan1->id_level1 ='6';
                $modelTrxPemrosesan1->id_level2 ='12';
                $modelTrxPemrosesan1->id_level3 ='0';
                $modelTrxPemrosesan1->id_level4 ='0';
                $modelTrxPemrosesan1->save();
            }      

           
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_11_inspeksi/'.$rename_file);
      $transaction->commit();
      
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
             return $this->redirect(['index']);
      }
      
      else{
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
               // return $this->redirect(['index']);
      }
      
      } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
      }
    
        } else {
            return $this->render('update', [
                'model' => $model,
        // 'tembusan'=>$tembusan,
        'searchSatker' => $searchSatker,
        'dataProviderSatker' => $dataProviderSatker,
        'modelTembusan' => $modelTembusan,
        'modelSaksiIn' => $modelSaksiIn,
        'modelSaksiEk' => $modelSaksiEk,
        'modelSaksiIn_trans' => $modelSaksiIn_trans,
        'modelSaksiEk_trans' => $modelSaksiEk_trans,
        'modelSpwas2' => $modelSpwas2,
        'result_expire' => $result_expire,
            ]);
        }
		
		if($model->jbtn_penandatangan == 'Jaksa Agung Muda PENGAWASAN'){    
		  // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
		  //    AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
		  //    and id_level2 ='1' and id_level3 ='2' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='1';
			$modelTrxPemrosesan1->id_level3 ='2';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}else if($model->jbtn_penandatangan == 'Sekretaris JAM PENGAWASAN'){
			 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='1';
			$modelTrxPemrosesan1->id_level3 ='0';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}else if($model->jbtn_penandatangan == 'Inspektur I '){
			 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='8';
			$modelTrxPemrosesan1->id_level3 ='0';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}else if($model->jbtn_penandatangan == 'Inspektur II'){
			 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='9';
			$modelTrxPemrosesan1->id_level3 ='0';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}else if($model->jbtn_penandatangan == 'Inspektur III'){
			 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='10';
			$modelTrxPemrosesan1->id_level3 ='0';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}else if($model->jbtn_penandatangan == 'Inspektur IV'){
			 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='11';
			$modelTrxPemrosesan1->id_level3 ='0';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}else if($model->jbtn_penandatangan == 'Inspektur V'){
			 // WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."'
			 // AND id_sys_menu='3545' and id_wilayah='1' and id_level1 ='6' 
			 // and id_level2 ='1' and id_level3 ='0' and id_level4 ='0'");
			$modelTrxPemrosesan1=new WasTrxPemrosesan();
			$modelTrxPemrosesan1->no_register=$_SESSION['was_register'];
			$modelTrxPemrosesan1->id_sys_menu='3544';
			$modelTrxPemrosesan1->id_user_login=$_SESSION['username'];
			$modelTrxPemrosesan1->durasi=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->created_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->created_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->created_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->updated_ip=$_SERVER['REMOTE_ADDR'];
			$modelTrxPemrosesan1->updated_by=\Yii::$app->user->identity->id;
			$modelTrxPemrosesan1->updated_time=date('Y-m-d H:i:s');
			$modelTrxPemrosesan1->user_id=$_SESSION['is_inspektur_irmud_riksa'];
			$modelTrxPemrosesan1->id_wilayah='1';
			$modelTrxPemrosesan1->id_level1 ='6';
			$modelTrxPemrosesan1->id_level2 ='12';
			$modelTrxPemrosesan1->id_level3 ='0';
			$modelTrxPemrosesan1->id_level4 ='0';
			$modelTrxPemrosesan1->save();
		}
    
    }

     protected function findModel_int($id)
    {
        $fungsi=new FungsiComponent();
        //$where=$fungsi->static_where_alias('a');
        if (($model = Was11Inspeksi::findBySql("
             select a.*,b.*
             from was.was11_inspeksi a left join was.was11_inspeksi_saksi_int b on a.id_surat_was11=b.id_was_11
             where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
               and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."'
               and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."'
               and a.id_level4='".$_SESSION['was_id_level4']."'
               and a.id_surat_was11=".$id." ")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     protected function findModel_eks($id_saksi,$id_was11)
    {
        $fungsi=new FungsiComponent();
      //  $where=$fungsi->static_where_alias('a');
        if (($model = Was9_Inspeksi::findBySql("
            select a.*,b.nama_saksi_eksternal as nama_saksi,
             '' as nip_saksi, '' as pangkat_saksi, '' as golongan_saksi,'' as jabatan_saksi, b.tempat_lahir_saksi_eksternal as tempat_lahir,
             tanggal_lahir_saksi_eksternal as tanggal_lahir,b.id_negara_saksi_eksternal as id_negara,b.id_agama_saksi_eksternal as agama, b.pendidikan as pendidikan,
             b.alamat_saksi_eksternal as alamat,b.nama_kota_saksi_eksternal as kota,b.pekerjaan_saksi_eksternal as pekerjaan
              from was.was9_inspeksi a left join was.saksi_eksternal_inspeksi b on a.id_saksi_eksternal=b.id_saksi_eksternal
               where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."'  and a.id_saksi_eksternal='".$id_saksi."' 
               and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."'
               and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."'
               and a.id_level4='".$_SESSION['was_id_level4']."'
               and a.id_surat_was9=".$id_was9." ")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }    

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        //Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);
        if($_POST['selection_all']==1){
            DipaMaster::deleteAll();
            return $this->redirect(['index']);
        } else {
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            return $this->redirect(['index']);
        }
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    public function actionDeleteint(){
       $id= $_POST['id'];
       $pecah=explode(',', $id);
       // print_r($pecah);
       // exit();
        //echo count($id);
       for ($i=0; $i < count($pecah); $i++) { 
          // echo $pecah[$i];
         //   $pecahLagi= explode('#', $pecah[$i]);
            
          //  echo $id[$i];

            if($id<>''){
         //   echo "hapus ";
            Was11Inspeksi::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                                             'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                             'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                             'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                             'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                             'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was11'=>$pecah[$i]]);

            Was11InspeksiSaksiInt::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                                             'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                             'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                             'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                             'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                             'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_11'=>$pecah[$i]]);
           }else{
          //  echo "jangan hapus ";
          }
       }
       return $this->redirect(['index']);

      }

    public function actionDeleteeks(){
       $id= $_POST['id'];
       $pecah=explode(',', $id);
       // print_r($pecah);
       // exit();
      //  echo count($pecah);
       for ($i=0; $i < count($pecah); $i++) { 
          // echo $pecah[$i];
         //   $pecahLagi= explode('#', $pecah[$i]);
            
           // echo $pecah[$i];

            if($id<>''){
         //   echo "hapus ";
            Was11Inspeksi::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                                             'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                             'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                             'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                             'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                             'id_cabjari'=>$_SESSION['kode_cabjari'],'id_surat_was11'=>$pecah[$i]]);

            Was11InspeksiSaksiEks::deleteAll(['id_wilayah'=>$_SESSION['was_id_wilayah'],
                                             'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                             'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
                                             'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
                                             'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],
                                             'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_11'=>$pecah[$i]]);
           }else{
          //  echo "jangan hapus ";
          }
       }
       return $this->redirect(['index']);

      }

     public function actionViewpdf($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
        $file_upload=$this->findModel($id);
       //$file_upload=Was11Inspeksi::findOne(["id_was_11"=>$id]);
        // print_r($file_upload['file_lapdu']);
        $filepath = '../modules/pengawasan/upload_file/was_11_inspeksi/'.$file_upload['upload_file'];
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

      public function actionCetak($id,$jns){
		  
        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);/*lokasi dan nama kejaksaan*/
        $connection = \Yii::$app->db;
        $query="select * FROM was.was11_inspeksi a   where  
                    a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.id_surat_was11='".$id."' and a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                    AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                    AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'";
        $model = $connection->createCommand($query)->queryOne();
        $tgl_was_11=\Yii::$app->globalfunc->tglToWord($model['tgl_was_11']);
        // $query_sql="select b.jabatan_penandatangan, a.no_register,c. nama_pegawai_terlapor as nama_terlapor_awal,
        //          b.jbtn_penandatangan, a.pelanggaran_terlapor_awal,b.nomor_sp_was1,b.tanggal_sp_was1 
        //          from was.terlapor_awal a 
        //          inner join was.sp_was_1 b on a.no_register=b.no_register 
        //          inner join was.pegawai_terlapor c on b.no_register=c.no_register 
        //           where a.no_register='".$_SESSION['was_register']."' and a.is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
     //     $modelterlapor = $connection->createCommand($query_sql)->queryAll();
        //  print_r($model);
        // exit();
         $query3 = "select a.*,b.* from was.pegawai_terlapor_sp_was2 a
                    inner join was.sp_was_2 b
                    on a.id_sp_was2=b.id_sp_was2
					and a.no_register=b.no_register
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    where  a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.id_sp_was2='".$model['id_sp_was2']."' and a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                    AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                    AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'";
        $modelterlapor1 = $connection->createCommand($query3)->queryOne();
        // print_r($modelterlapor1);
        // exit();
         $tgl_sp_was= \Yii::$app->globalfunc->tglToWord($modelterlapor1['tanggal_sp_was2']);
         // $saksiIN = SaksiInternal::find()->where("no_register='".$_SESSION['was_register']."' and from_table='WAS-11' and id_was='".$id."'")->all();
         // $sql="select a.*,b.peg_nrp from was.saksi_internal a inner join kepegawaian.kp_pegawai b 
         //        on a.nip=b.peg_nip_baru where a.no_register='".$_SESSION['was_register']."'

         //        and a.from_table='WAS-11' and a.id_was='".$id."'";
         $sql="select * from was.was11_inspeksi_saksi_int where id_was_11='".$id."' and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' 
                    and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
                    and id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                    AND id_level1::text ='".$_SESSION['was_id_level1']."'  AND id_level2::text ='".$_SESSION['was_id_level2']."' 
                    AND id_level3::text ='".$_SESSION['was_id_level3']."' AND id_level4::text ='".$_SESSION['was_id_level4']."'";
         $saksiIN=$connection->createCommand($sql)->queryAll();

         $sql2="select * from was.was11_inspeksi_saksi_ext where id_was_11='".$id."' and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' 
                    and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'
                    and id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                    AND id_level1::text ='".$_SESSION['was_id_level1']."'  AND id_level2::text ='".$_SESSION['was_id_level2']."' 
                    AND id_level3::text ='".$_SESSION['was_id_level3']."' AND id_level4::text ='".$_SESSION['was_id_level4']."'";
         $saksiEK=$connection->createCommand($sql2)->queryAll();
         // print_r($saksiEK);
         // exit();
         //$saksiEK = SaksiEksternal::find()->where("id_was='".$id."' and from_table='WAS-11'")->all();

        // $modelLapdu=Lapdu::find()->where("no_register='".$_SESSION['was_register']."'")->one();
         $query4 = "select a.* from was.lapdu a
                    where  a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
                   ";
        $modelLapdu = $connection->createCommand($query4)->queryOne();
        // print_r($modelLapdu);
        // exit();
        $query5 = "select string_agg(a.nama_pegawai_terlapor,',') as nama_pegawai_terlapor from was.pegawai_terlapor_sp_was2 a
                    inner join was.sp_was_2 b
                    on a.id_sp_was2=b.id_sp_was2
					and a.no_register=b.no_register
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    where  a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.id_sp_was2='".$model['id_sp_was2']."' 
                    and a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                    AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                    AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'";
        $modelterlapor = $connection->createCommand($query5)->queryOne();
        // print_r($modelterlapor);
        // exit();
        $query6 = "select a.* from was.tembusan_was a
                    where  a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' 
                    and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.pk_in_table='".$model['id_surat_was11']."' and a.id_wilayah::text = '".$_SESSION['was_id_wilayah']."' 
                    AND a.id_level1::text ='".$_SESSION['was_id_level1']."'  AND a.id_level2::text ='".$_SESSION['was_id_level2']."' 
                    AND a.id_level3::text ='".$_SESSION['was_id_level3']."' AND a.id_level4::text ='".$_SESSION['was_id_level4']."'
                    and from_table='Was-11Inspeksi' order by is_order desc";
        $tembusan_was11 = $connection->createCommand($query6)->queryAll();
        
		//  print_r($tembusan_was11['tembusan']);
        // exit();

       //  $tembusan_was11 = TembusanWas2::find()->where("pk_in_table='".$id."' and from_table='Was-11'")->all();

         return $this->render('cetak',[
            'data_satker'=>$data_satker,
            'model'=>$model,
            'tgl_was_11'=>$tgl_was_11,
            'modelterlapor'=>$modelterlapor1,
            'tgl_sp_was'=>$tgl_sp_was,
            'saksiIN'=>$saksiIN,
            'saksiEK'=>$saksiEK,
            'modelLapdu'=>$modelLapdu,
            'tembusan_was11'=>$tembusan_was11,
            ]);
    }

   public function actionGetttd(){
       
   $searchModelWas11 = new Was11InspeksiSearch;
   $dataProviderPenandatangan = $searchModelWas11->searchPenandatangan(Yii::$app->request->queryParams);
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
      protected function findModel($id)
    {
        if (($model = Was11Inspeksi::findOne(['id_surat_was11'=>$id,'no_register'=>$_SESSION['was_register'],
                                              'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                              'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                              'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
                                              'id_level2'=>$_SESSION['was_id_level2'], 'id_level3'=>$_SESSION['was_id_level3'],
                                              'id_level4'=>$_SESSION['was_id_level4']
                                              ])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
