<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\Was9_Inspeksi;
use app\modules\pengawasan\models\Was9_InspeksiTuSearch;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil dari transaksi ketika update*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil dari master ketika create*/
use app\modules\pengawasan\models\SaksiEksternalInspeksi;/*mengambil saksi external*/
use app\modules\pengawasan\models\SaksiInternalInspeksi;/*mengambil saksi internal*/
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\vWas9;
use app\modules\pengawasan\models\PemeriksaSpWas2;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\models\KpPegawai;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Odf;
use yii\db\Query;
use yii\db\Command;
use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;
use yii\grid\GridView;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was9InspeksiTuController extends Controller
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
      // $connection = \Yii::$app->db;
      // $query1 = "select * from was.was9_inspeksi where jbtn_penandatangan='Jaksa Agung Muda Pengawasan'";
      // $updateinternal = $connection->createCommand($query1)->queryAll();
      // foreach ($updateinternal as $key ) {
      //   echo $key['id_surat_was9'];
      // }
      //$updateinternal->execute();
      // echo"test";   
        $searchModel = new Was9_InspeksiTuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'=>$model,
        ]);
    }

     public function actionInsertnomor()
    {
      $connection = \Yii::$app->db;
      $query1 = "update was.was9_inspeksi set nomor_surat_was9='".$_POST['nomor']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."'  and id_surat_was9='".$_POST['surat_was9']."' and id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."' ";
      $updateinternal = $connection->createCommand($query1);
      // print_r($query1);
      // exit();
      $updateinternal->execute();
      return $this->redirect(['index']);
    } 

      public function actionInsertnomoreksternal()
    {
      $connection = \Yii::$app->db;
      $query1 = "update was.was9_inspeksi set nomor_surat_was9='".$_POST['nomor']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."'  and id_surat_was9='".$_POST['surat_was9']."' and id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."'  and id_saksi_eksternal is not null ";
      $updateinternal = $connection->createCommand($query1);
      // print_r($query1);
      // exit();
      $updateinternal->execute();
      return $this->redirect(['index']);
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
    /*CREATE SAKSI INTERNAL*/
      public function actionCreatesaksi()
    {
        $searchModel = new Was9_InspeksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new SaksiInternalInspeksi();

        if ($model->load(Yii::$app->request->post())){
          $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              $jml=$_POST['nip'];
              /*echo "ssss";
              exit();*/
        for ($i=0; $i < count($jml); $i++) { 
            $saksi_in = new SaksiInternalInspeksi();
            $saksi_in->no_register = $_SESSION['was_register'];
            $saksi_in->id_tingkat  = $_SESSION['kode_tk'];
            $saksi_in->id_kejati   = $_SESSION['kode_kejati'];
            $saksi_in->id_kejari   = $_SESSION['kode_kejari'];
            $saksi_in->id_cabjari  = $_SESSION['kode_cabjari'];
            $saksi_in->id_wilayah  = $_SESSION['was_id_wilayah'];
            $saksi_in->id_level1   = $_SESSION['was_id_level1'];
            $saksi_in->id_level2   = $_SESSION['was_id_level2'];
            $saksi_in->id_level3   = $_SESSION['was_id_level3'];
            $saksi_in->id_level4   = $_SESSION['was_id_level4'];
            $saksi_in->nip=$_POST['nip'][$i];
            $saksi_in->nrp=$_POST['nrp'][$i];
            $saksi_in->nama_saksi_internal=$_POST['nama'][$i]; 
            $saksi_in->pangkat_saksi_internal=$_POST['pangkat'][$i]; 
            $saksi_in->golongan_saksi_internal=$_POST['golongan'][$i];  
            $saksi_in->jabatan_saksi_internal=$_POST['jabatan'][$i];
            // $saksi_in->id_saksi_internal=$i; 
            // $saksi_in->from_table  ='WAS-9'; 
            $saksi_in->created_ip  = $_SERVER['REMOTE_ADDR'];
            $saksi_in->created_time= date('Y-m-d H:i:s');
            $saksi_in->created_by  = \Yii::$app->user->identity->id;
            $saksi_in->save();
            // print_r($saksi_in->save());
            // exit();
          }
            $transaction->commit();
            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        }   else {
           return $this->render('create_saksi', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'model'   => $model,
        ]);
        } 
    }

    /*CREATE SAKSI EKSTERNAL*/
    public function actionCreatesaksi2()
    {
        $searchModel = new Was9_InspeksiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new SaksiEksternalInspeksi();

        if ($model->load(Yii::$app->request->post())){
          $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
           
            $model->no_register = $_SESSION['was_register'];
            $model->id_tingkat  = $_SESSION['kode_tk'];
            $model->id_kejati   = $_SESSION['kode_kejati'];
            $model->id_kejari   = $_SESSION['kode_kejari'];
            $model->id_cabjari  = $_SESSION['kode_cabjari'];
          
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id; 
            $model->save();
           

            $transaction->commit();
            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
              
            }
        }   else {
           return $this->render('create_saksi2', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'modelSaksiEksternal'   => $model,
        ]);
      } 
    }

    /*Update Internal*/
    public function actionUpdateinternal()
    {
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where();
      $connection = \Yii::$app->db;
      $query1 = "update was.saksi_internal_inspeksi set nama_saksi_internal='".$_POST['Mnama']."',nip='".$_POST['Mnip']."',nrp='".$_POST['Mnrp']."', jabatan_saksi_internal='".$_POST['Mjabatan']."',golongan_saksi_internal='".$_POST['Mgolongan']."',pangkat_saksi_internal='".$_POST['Mpangkat']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' 
        and id_wilayah='".$_SESSION['was_id_wilayah']."'and id_level1='".$_SESSION['was_id_level1']."' 
        and id_level2='".$_SESSION['was_id_level2']."'  and id_level3='".$_SESSION['was_id_level3']."' 
        and id_level4='".$_SESSION['was_id_level4']."'  and id_saksi_internal='".$_POST['Mid']."' $where";
      $updateinternal = $connection->createCommand($query1);
      $updateinternal->execute();
      return $this->redirect(['index']);
    }

    /*Update Eksternal*/
    public function actionUpdateeksternal()
    {
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where();
      $connection = \Yii::$app->db;
      $query1 = "update was.saksi_eksternal_inspeksi set nama_saksi_eksternal='".$_POST['Mnama_eks']."',
        tempat_lahir_saksi_eksternal='".$_POST['Mtempat_eks']."',id_negara_saksi_eksternal='".$_POST['Mwarga_eks']."',
        tanggal_lahir_saksi_eksternal='".$_POST['Mtanggal_eks']."',pendidikan='".$_POST['Mpendidikan_eks']."',
        id_agama_saksi_eksternal='".$_POST['Magama_eks']."',alamat_saksi_eksternal='".$_POST['Malamat_eks']."',
        nama_kota_saksi_eksternal='".$_POST['Mkota_eks']."',pekerjaan_saksi_eksternal='".$_POST['Mkerja_eks']."'
        
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_saksi_eksternal='".$_POST['Mid_eks']."' $where";
      $updateinternal = $connection->createCommand($query1);
      $updateinternal->execute();
      return $this->redirect(['index']);
      
      //echo $nm,$nm1,$nm2,$nm3,$nm4,$nm5,$nm6,$nm7,$nm8,$nm9;
   }   


   public function actionCreate()
    {
    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    
        $model = new Was9_Inspeksi();
        $modelSaksiEksternal = new SaksiEksternalInspeksi();

        $modelTembusanMaster = TembusanWas::findBySql("select * from was.was_tembusan_master where for_tabel='was_9_inspeksi' or for_tabel='master'")->all();
        $connection = \Yii::$app->db;

        /*cek expire tanggal SPWAS1*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where();/*karena ada perubahan kode*/ 

        $filter_0          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                              and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";

        $spwas2=$fungsi->FunctGetIdSpwas2All($filter_0);/*karena ada perubahan kode*/ 
        // print_r($spwas2);
        // exit();

        $Fungsi         =new GlobalFuncComponent();
        $table          ='sp_was_2';
        $filed          ='tanggal_akhir_sp_was2';
        $filter_1          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                              and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was2 is not null $where";
        $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);

        /*mendapatkan id SPWAS1 Yang  Aktif*/
        $FungsiWas      =new FungsiComponent();
        $filter         =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                           and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                           and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $getId          =$FungsiWas->FunctGetIdSpwas2($filter);
       

        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              
            $saksi_internal=KpPegawai::findOne(['peg_nip_baru'=>$_POST['nip']]);
            $pegawai_pemeriksa=PemeriksaSpWas2::findOne(['nip_pemeriksa'=>$model->nip_pemeriksa,'no_register'=>$_SESSION['was_register'] 
                                                          ,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'] 
                                                          ,'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']
                                                          ,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1']
                                                          ,'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3']
                                                          ,'id_level4'=>$_SESSION['was_id_level4']
                                                          ]);
            
            
            $model->no_register=$_SESSION['was_register'];
            $model->jenis_saksi=$_POST['jenis_saksi'];
            $model->tanggal_pemeriksaan_was9=date('Y-m-d', strtotime($_POST['was9_inspeksi']['tanggal_pemeriksaan_was9']));
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati = $_SESSION['kode_kejati'];
            $model->id_kejari = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register = $_SESSION['was_register'];
            $model->id_wilayah = $_SESSION['was_id_wilayah'];
            $model->id_level1 = $_SESSION['was_id_level1'];
            $model->id_level2 = $_SESSION['was_id_level2'];
            $model->id_level3 = $_SESSION['was_id_level3'];
            $model->id_level4 = $_SESSION['was_id_level4'];

            $model->id_sp_was2         = $getId['id_sp_was2'];
            $model->jenis_saksi       = $_POST['jenis_saksi'];

          if($_GET['jns']=='Internal'){
            $model->id_saksi_internal = $_POST['id_saksi'];
          }else{
            $model->id_saksi_eksternal= $_POST['id_saksi'];
          }
            $model->nip_pemeriksa     = $pegawai_pemeriksa['nip_pemeriksa'];
            $model->id_pemeriksa      = $pegawai_pemeriksa['id_pemeriksa_sp_was2'];
            $model->nama_pemeriksa    = $pegawai_pemeriksa['nama_pemeriksa'];
            $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
            $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
            $model->golongan_pemeriksa= $pegawai_pemeriksa['golongan_pemeriksa'];
            $model->nrp_pemeriksa     = $pegawai_pemeriksa['nrp_pemeriksa'];

        if($model->save()) {


            $pejabat = $_POST['pejabat'];
                for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was9Inspeksi';
                        $saveTembusan->pk_in_table = strrev($model->id_surat_was9);
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

                 $arr = array(ConstSysMenuComponent::Was13inspek, ConstSysMenuComponent::Bawas3inspek, ConstSysMenuComponent::Was11inspek, ConstSysMenuComponent::Bawas4, ConstSysMenuComponent::Bawas2);
                    for ($i=0; $i < 5 ; $i++) { 
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
                 'message' => 'Data Ba-Was9 Berhasil Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                ]);
                $transaction->commit();
        }
            return $this->redirect(['index']);
         } catch (Exception $e) {
                $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
        }
        } else {
            return $this->render('create', [
                'model' => $model,
                'spwas2' => $spwas2,
                'modelTembusanMaster' => $modelTembusanMaster,
                'result_expire' => $result_expire ,
            ]);
        }
    }


    public function actionUpdate($jns,$id,$nm,$id_saksi,$no,$id_was9)
    {
      $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
      $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

       if($_GET['jns'] == 'Internal'){
        $model=$this->findModel_int($id_saksi,$id_was9);
       }else{
         $model=$this->findModel_eks($id_saksi,$id_was9);
       }
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_surat_was9,'from_table'=>'Was9Inspeksi','no_register'=>$model->no_register,'id_tingkat'=>$model->id_tingkat,'id_kejati'=>$model->id_kejati,'id_kejari'=>$model->id_kejari,'id_cabjari'=>$model->id_cabjari
                                              ,'id_wilayah'=>$model->id_wilayah,'id_level1'=>$model->id_level1,'id_level2'=>$model->id_level2,'id_level3'=>$model->id_level3,'id_level4'=>$model->id_level4]);
        
        $fungsi=new FungsiComponent();
        $filter_0          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                              and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                              and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";

        $spwas2=$fungsi->FunctGetIdSpwas2All($filter_0);
        
        $where=$fungsi->static_where();/*karena ada perubahan kode*/ 

        $Fungsi         =new GlobalFuncComponent();
        $table          ='sp_was_2';
        $filed          ='tanggal_akhir_sp_was2';
        $filter_1          ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was2 is not null $where";
        $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);
        
        $modelSaksiEksternal = new SaksiEksternalInspeksi();

            $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/         
            $OldFile=$model->was9_file;

            if($model->load(Yii::$app->request->post())){
                 $pegawai_pemeriksa=PemeriksaSpWas2::findOne(['nip_pemeriksa'=>$model->nip_pemeriksa,'no_register'=>$_SESSION['was_register'] 
                                                        ,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'] 
                                                        ,'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']
                                                        ,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1']
                                                        ,'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3']
                                                        ,'id_level4'=>$_SESSION['was_id_level4']
                                                        ]);

                  $file_name    = $_FILES['was9_file']['name'];
                  $file_size    = $_FILES['was9_file']['size'];
                  $file_tmp     = $_FILES['was9_file']['tmp_name'];
                  $file_type    = $_FILES['was9_file']['type'];
                  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                  $tmp = explode('.', $_FILES['was9_file']['name']);
                  $file_exists = end($tmp);
                  $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
                  

              $connection = \Yii::$app->db;
              $transaction = $connection->beginTransaction();
              try {


           if($_GET['jns']=='Internal'){
              $model->id_saksi_internal = $_POST['id_saksi'];
            }else{
              $model->id_saksi_eksternal= $_POST['id_saksi'];
            }
            $model->tanggal_pemeriksaan_was9=date('Y-m-d', strtotime($_POST['was9_inspeksi']['tanggal_pemeriksaan_was9']));
            $model->updated_ip = $_SERVER['REMOTE_ADDR'];
            $model->updated_time = date('Y-m-d H:i:s');
            $model->updated_by = \Yii::$app->user->identity->id;
            $model->nip_pemeriksa     = $pegawai_pemeriksa['nip_pemeriksa'];
            $model->id_pemeriksa      = $pegawai_pemeriksa['id_pemeriksa_sp_was2'];
            $model->nama_pemeriksa    = $pegawai_pemeriksa['nama_pemeriksa'];
            $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
            $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
            $model->golongan_pemeriksa= $pegawai_pemeriksa['golongan_pemeriksa'];
            $model->nrp_pemeriksa     = $pegawai_pemeriksa['nrp_pemeriksa'];
            $model->was9_file = ($file_name==''?$OldFile:$rename_file);
            if($model->save()) {
               
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_9inspeksi/'.$OldFile)) {
                    unlink(\Yii::$app->params['uploadPath'].'was_9inspeksi/'.$OldFile);
                } 

                        TembusanWas2::deleteAll(['from_table'=>'Was9Inspeksi','is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa'],'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was9]);
                          
                          $pejabat = $_POST['pejabat'];
                           for($z=0;$z<count($pejabat);$z++){
                          $saveTembusan = new TembusanWas2;
                          $saveTembusan->from_table = 'Was9';
                          $saveTembusan->pk_in_table = strrev($model->id_surat_was9);
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

                          $arr = array(ConstSysMenuComponent::Was13inspek, ConstSysMenuComponent::Bawas3inspek, ConstSysMenuComponent::Was11inspek, ConstSysMenuComponent::Bawas4, ConstSysMenuComponent::Bawas2);
                          for ($i=0; $i < 5 ; $i++) { 
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
                     'message' => 'Data Ba-Was9 Berhasil Disimpan',
                     'title' => 'Simpan Data',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                    ]);
                    $transaction->commit();
                    move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_9inspeksi/'.$rename_file);   
            }
                return $this->redirect(['index']);
                } catch (Exception $e) {
                  $transaction->rollback();
                  if(YII_DEBUG){throw $e; exit;} else{return false;}
                
              }
            } else {
                return $this->render('update', [
                    'model' => $model,
                    'spwas2' => $spwas2,
                    'modelTembusan' => $modelTembusan,
                    'result_expire' => $result_expire,
                ]);
            }
        }


/*Ambil Data Saksi Internal*/
public function actionGetsaksiint(){
   $jenis_saksi= $_POST['jenis_saksi'];
   $id_saksi   = $_POST['id_saksi'];
   $nip        = $_POST['nip'];
   $nm         = $_POST['nm'];
  /* echo $id;
   echo $id_saksi;*/
  $searchModel = new Was9_InspeksiSearch();
 // $id_saksi = 7;
  $dataProviderWas9Int = $searchModel->searchSaksiInt_ins($jenis_saksi,$id_saksi);
  echo "<input type='hidden' name='Mnip_int' class='Mnip_int' value='".$nip."'>
        <input type='hidden' name='Mnm_int' class='Mnm_int' value='".$nm."'>
        <input type='hidden' name='Mid' class='Mid' value='".$id_saksi."'>";
  echo GridView::widget([
                    'dataProvider'=> $dataProviderWas9Int,
                    'columns' => [
                         ['header'=>'No',
                        'contentOptions'=>['style'=>'text-align:center;'],
                        'class' => 'yii\grid\SerialColumn'],
                        
                        ['header'=>'No Register',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'value' => function ($data) {
                             return $data['no_register']; 
                          }, 
                         ], 

                         ['header'=>'No surat',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'value' => function ($data) {
                             return $data['nomor_surat_was9']; 
                          }, 
                         ],

                         ['header'=>'Tanggal',
                        'headerOptions'=>['style'=>'text-align:center;'],
                        'value' => function ($data) {
                             return $data['tanggal_was9']; 
                          }, 
                         ], 
                        
                        ['label'=>'Nip',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'value' => function ($data) {
                             return $data['nip']; 
                          },    
                        ],

                        ['label'=>'Nama Saksi internal',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'value' => function ($data) {
                             return $data['nama_saksi_internal']; 
                          },    
                        ],

                        [
                          'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
                          'contentOptions'=>['class'=>'text-center aksinya'],
                          'format'=>'raw',
                          'header'=>'<input type="checkbox" name="MselectionSIn_one2" id="MselectionSIn_one" />', 
                          'value'=>function($data, $index){
                              $result=json_encode($data);
                           // $idnya = rawurlencode($data['no_register_perkara']).'#'.rawurlencode($data['no_surat']);
                            return "<input type='checkbox' name='MselectionSIn_one[]'  value='".$data['no_register']."' json='".$result."' surat='".$data['nomor_surat_was9']."#".$data['id_saksi_internal']."#".$data['id_surat_was9']."' class='MselectionSIn_one' />";
                          }, 
                        ],

                         ],   

                ]); 
  }



  public function actionGetsaksieks(){
   $jenis_saksi= $_POST['jenis_saksi'];
   $id_saksi   = $_POST['id_saksi'];
   $nm         = $_POST['nm'];
  /* echo $id;
   echo $id_saksi;*/
  $searchModel = new Was9_InspeksiSearch();
 
  $dataProviderWas9Eks = $searchModel->searchSaksiEks_ins($jenis_saksi,$id_saksi);
  echo " <input type='text' name='Mnm_eks' class='Mnm_eks' value='".$nm."'>
        <input type='text' name='Mid_eks' class='Mid_eks' value='".$id_saksi."'>";
  echo GridView::widget([
                        'dataProvider'=> $dataProviderWas9Eks,
                        'columns' => [
                             
                             ['header'=>'No',
                              'contentOptions'=>['style'=>'text-align:center;'],
                              'class' => 'yii\grid\SerialColumn'
                              ],
                              
                             ['header'=>'Nomor Surat',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'value' => function ($data) {
                                 return $data['nomor_surat_was9']; 
                              }, 
                             ],

                             ['header'=>'Tanggal Surat',
                            'headerOptions'=>['style'=>'text-align:center;'],
                            'value' => function ($data) {
                                 return $data['tanggal_was9']; 
                              }, 
                             ], 

                            ['label'=>'Nama Saksi',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'value' => function ($data) {
                                 return $data['nama_saksi_eksternal']; 
                              },    
                            ],

                            ['label'=>'Alamat',
                                'headerOptions'=>['style'=>'text-align:center;'],
                                'value' => function ($data) {
                                 return $data['alamat_saksi_eksternal']; 
                              },    
                            ],

                             [
                              'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
                              'contentOptions'=>['class'=>'text-center aksinya'],
                              'format'=>'raw',
                              'header'=>'<input type="checkbox" name="MselectionSIe_one2" id="MselectionSIe_one2" />', 
                              'value'=>function($data, $index){
                                  $result=json_encode($data);
                               // $idnya = rawurlencode($data['no_register_perkara']).'#'.rawurlencode($data['no_surat']);
                                return "<input type='checkbox' name='MselectionSIe_one[]'  value='".$data['no_register']."' json='".$result."' surat='".$data['nomor_surat_was9']."#".$data['id_saksi_eksternal']."#".$data['id_surat_was9']."' class='MselectionSIe_one' />";
                              }, 

                           // ['class' => 'yii\grid\CheckboxColumn',
                           //  'headerOptions'=>['style'=>'text-align:center'],
                           //  'contentOptions'=>['style'=>'text-align:center; width:5%'],
                           //             'checkboxOptions' => function ($data) {
                           //              $result=json_encode($data);
                           //              return [ 'value'=>$data['no_register'],'json'=>$result,'surat'=>$data['nomor_surat_was9'].'#'.$data['id_saksi'],'class'=>'MselectionSIe_one'];
                           //              },
                                 ],
                             ],   

                    ]); 
  }


   

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete_old()
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

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = DipaMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

      protected function findModel_int($id_saksi,$id_was9)
    {
        $fungsi=new FungsiComponent();
        //$where=$fungsi->static_where_alias('a');
        if (($model = Was9_Inspeksi::findBySql("
            select a.*,b.nama_saksi_internal as nama_saksi,
            b.nip as nip_saksi,b.pangkat_saksi_internal as pangkat_saksi, b.golongan_saksi_internal as golongan_saksi,
            b.jabatan_saksi_internal as jabatan_saksi,'' as tempat_lahir,null as tanggal_lahir,null as id_negara,null as agama,
            null as pendidikan,'' as alamat,null as kota,null as pekerjaan
            from was.was9_inspeksi a left join was.saksi_internal_inspeksi b on a.id_saksi_internal=b.id_saksi_internal
             where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
               and a.id_wilayah='".$_SESSION['was_id_wilayah']."' and a.id_level1='".$_SESSION['was_id_level1']."'
               and a.id_level2='".$_SESSION['was_id_level2']."' and a.id_level3='".$_SESSION['was_id_level3']."'
               and a.id_level4='".$_SESSION['was_id_level4']."'
               and a.id_saksi_internal='".$id_saksi."' 
               and a.id_surat_was9=".$id_was9." ")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     protected function findModel_eks($id_saksi,$id_was9)
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

      public function actionDelete(){
       $id= $_POST['id'];
       $pecah=explode(',', $id);
      
       for ($i=0; $i < count($pecah); $i++) { 
           $pecahLagi= explode('#', $pecah[$i]);
         
            SaksiInternalInspeksi::deleteAll([
              'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
              'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
              'id_cabjari'=>$_SESSION['kode_cabjari'],'nip'=>$pecahLagi[2],'id_saksi_internal'=>$pecahLagi[1]]);
          
       }
       Yii::$app->getSession()->setFlash('success', [
         'type' => 'success',
         'duration' => 3000,
         'icon' => 'fa fa-users',
         'message' => 'Data Ba-Was9 Berhasil Dihapus',
         'title' => 'Simpan Data',
         'positonY' => 'top',
         'positonX' => 'center',
         'showProgressbar' => true,
        ]);
       return $this->redirect(['index']);

      }


      public function actionDelete2(){
       $id= $_POST['id'];
       SaksiEksternalInspeksi::deleteAll([
              'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
              'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
              'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
              'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
              'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
              'id_saksi_eksternal'=>$id]);
       return $this->redirect(['index']);
      
      }

    public function actionDeletewas9(){
   $id= $_POST['id'];
   $pecah=explode(',', $id);
  // echo $id;
    //echo count($id);
   for ($i=0; $i < count($pecah); $i++) { 
      // echo $pecah[$i];
        $pecahLagi= explode('#', $pecah[$i]);
        if($pecahLagi[0]<>''){
     //   echo "hapus ";
        was9::deleteAll([
          'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_cabjari'=>$_SESSION['kode_cabjari'],'nomor_surat_was9'=>$pecahLagi[0],
          'id_wilayah'=>$_SESSION['was_id_wilayah'],
          'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
          'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
          'id_saksi'=>$pecahLagi[1],'jenis_saksi'=>'Internal']);
       }else{
      //  echo "jangan hapus ";
      }
   }
   return $this->redirect(['index']);

  }

  public function actionDeletewas9b(){
   $id= $_POST['id'];
   $pecah=explode(',', $id);
  // echo $id;
    //echo count($id);
   for ($i=0; $i < count($pecah); $i++) { 
      // echo $pecah[$i];
        $pecahLagi= explode('#', $pecah[$i]);
        if($pecahLagi[0]<>''){
     //   echo "hapus ";
        Was9_Inspeksi::deleteAll([
          'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],
          'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
          'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],
          'nomor_surat_was9'=>$pecahLagi[0],
          'id_saksi'=>$pecahLagi[1],'jenis_saksi'=>'Eksternal']);
       }else{
      //  echo "jangan hapus ";
      }
   }
   return $this->redirect(['index']);

  }

  public function actionCetak($id,$no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query1 = "select a.*,b.* from was.was9 a
                    inner join was.saksi_internal b
                    on a.id_saksi=b.id_saksi_internal
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    and a.id_wilayah=b.id_wilayah 
                    and a.id_level1=b.id_level1   
                    and a.id_level2=b.id_level2 
                    and a.id_level3=b.id_level3                                         
                    and a.id_level4=b.id_level4 
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_surat_was9='".$id."' $where";
        $model = $connection->createCommand($query1)->queryOne();

        $query2 = "select a.* from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$model['id_surat_was9']."' and from_table='Was9Inspeksi'  $where ";
        $model2 = $connection->createCommand($query2)->queryAll();
//
        $query3 = "select a.*,b.* from was.pegawai_terlapor_sp_was2 a 
                    inner join was.sp_was_2 b on a.id_sp_was2=b.id_sp_was2
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    and a.id_wilayah=b.id_wilayah 
                    and a.id_level1=b.id_level1   
                    and a.id_level2=b.id_level2 
                    and a.id_level3=b.id_level3                                         
                    and a.id_level4=b.id_level4
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_sp_was2='".$model['id_sp_was']."' $where ";
        $model3 = $connection->createCommand($query3)->queryOne();

        $query4 = "select a.* from was.lapdu a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                   ";
        $model4 = $connection->createCommand($query4)->queryOne();

        $query5 = "select string_agg(a.nama_pegawai_terlapor,'#') as nama_pegawai_terlapor from was.pegawai_terlapor_sp_was2 a
                    inner join was.sp_was_2 b
                    on a.id_sp_was2=b.id_sp_was2
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    and a.id_wilayah=b.id_wilayah 
                    and a.id_level1=b.id_level1   
                    and a.id_level2=b.id_level2 
                    and a.id_level3=b.id_level3                                         
                    and a.id_level4=b.id_level4
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_sp_was2='".$model['id_sp_was']."' $where";
        $model5 = $connection->createCommand($query5)->queryOne();

     

        
         $jam         = substr($model['jam_pemeriksaan_was9'], 0,5); 
         $tgl_periksa = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_pemeriksaan_was9'])));
         $tgl_was9    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_was9'])));
         $tglSpWas    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model3['tanggal_sp_was1'])));
         
        return $this->render('cetak',['jam'=>$jam, 'model'=>$model, 'model2'=>$model2, 'model3'=>$model3, 'model4'=>$model4, 'model5'=>$model5 , 'data_satker'=>$data_satker, 'tgl_periksa'=>$tgl_periksa , 'tglSpWas'=>$tglSpWas, 'tgl_was9'=>$tgl_was9]);
    }

     public function actionCetak2($id,$no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query1 = "select a.*,b.* from was.was9_inspeksi a
                    inner join was.saksi_eksternal_inspeksi b
                    on a.id_saksi_eksternal=b.id_saksi_eksternal
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    and a.id_wilayah=b.id_wilayah 
                    and a.id_level1=b.id_level1   
                    and a.id_level2=b.id_level2 
                    and a.id_level3=b.id_level3                                         
                    and a.id_level4=b.id_level4
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_surat_was9='".$id."' $where";
        $model = $connection->createCommand($query1)->queryOne();
        
        $query2 = "select a.* from was.tembusan_was a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.pk_in_table='".$model['id_surat_was9']."' and from_table='Was9Inspeksi' $where";
        $model2 = $connection->createCommand($query2)->queryAll();
        //    print_r($query2);
        // exit();
        
        $query3 = "select a.*,b.* from was.pegawai_terlapor_sp_was2 a 
                    inner join was.sp_was_2 b on a.id_sp_was2=b.id_sp_was2
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    and a.id_wilayah=b.id_wilayah 
                    and a.id_level1=b.id_level1   
                    and a.id_level2=b.id_level2 
                    and a.id_level3=b.id_level3                                         
                    and a.id_level4=b.id_level4
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_sp_was2='".$model['id_sp_was2']."' $where ";
        $model3 = $connection->createCommand($query3)->queryOne();

        // print_r($query3);
        // exit();
        
        $query4 = "select a.* from was.lapdu a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                   ";
        $model4 = $connection->createCommand($query4)->queryOne();

         $query5 = "select string_agg(a.nama_pegawai_terlapor,'#') as nama_pegawai_terlapor 
                    from was.pegawai_terlapor_sp_was2 a
                    inner join was.sp_was_2 b
                    on a.id_sp_was2=b.id_sp_was2
                    and a.id_tingkat=b.id_tingkat
                    and a.id_kejati=b.id_kejati
                    and a.id_kejari=b.id_kejari
                    and a.id_cabjari=b.id_cabjari
                    and a.id_wilayah=b.id_wilayah 
                    and a.id_level1=b.id_level1   
                    and a.id_level2=b.id_level2 
                    and a.id_level3=b.id_level3                                         
                    and a.id_level4=b.id_level4
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                    and a.id_sp_was2='".$model['id_sp_was2']."' $where";
        $model5 = $connection->createCommand($query5)->queryOne();
       
         $jam         = substr($model['jam_pemeriksaan_was9'], 0,5);  
         $tgl_periksa = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_pemeriksaan_was9'])));
         $tgl_was9    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_was9'])));
         $tglSpWas    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model3['tanggal_sp_was1'])));
        
        return $this->render('cetak',['jam'=>$jam ,'model'=>$model, 'model2'=>$model2, 'model3'=>$model3, 'model4'=>$model4, 'model5'=>$model5 , 'data_satker'=>$data_satker, 'tgl_periksa'=>$tgl_periksa , 'tglSpWas'=>$tglSpWas, 'tgl_was9'=>$tgl_was9]);
    }

}
