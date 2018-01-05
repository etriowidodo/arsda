<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\VSpWas1;
use app\modules\pengawasan\models\SpWas1Search;
use app\modules\pengawasan\models\PemeriksaSpWas1;
use app\modules\pengawasan\models\Was1;

use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use app\modules\pengawasan\models\PegawaiTerlapor;
use app\modules\pengawasan\models\PegawaiTerlaporSearch;
use app\modules\pengawasan\models\DasarSpWas1;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\TerlaporSearch;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\models\DipaMaster;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\db\Command;
use Odf;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * SpWas1Controller implements the CRUD actions for SpWas1 model.
 */
class SpWas1Controller extends Controller
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
     * Lists all SpWas1 models.
     * @return mixed
     */
    public function actionIndex()
    {
      //print_r($_SESSION);
	  //exit();
        $searchModel = new SpWas1Search();
	    $session = Yii::$app->session;
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 15;
      
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SpWas1 model.
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
     * Creates a new SpWas1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
      /*Jiksa sarang yang di pilih 5(klarifikasi kejaksaan agung)*/
        // print_r($_SESSION);
        // exit();
        $model = new SpWas1();
    		$var=str_split($_SESSION['is_inspektur_irmud_riksa']);		

        if($var[2]=='1'){
        $riksa="pemeriksa_1";
        }else if($var[2]=='2'){
        $riksa="pemeriksa_2";
        }else if($var[2]=='3'){
        $riksa="pemeriksa_1";
        }else if($var[2]=='4'){
        $riksa="pemeriksa_2";
        }else if($var[2]=='5'){
        $riksa="pemeriksa_1";
        }else if($var[2]=='6'){
        $riksa="pemeriksa_2";
        }

        $expire         =new GlobalFuncComponent();
        $table          ='sp_was_1';
        $filed          ='tanggal_akhir_sp_was1';
        $where          ="  trx_akhir=1 and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was1 is not null";
        $result_expire  =$expire->CekExpire($table,$filed,$where);
        $fungsi=new FungsiComponent();

        
        $connection = \Yii::$app->db;
        $sql = "select*, nama_pegawai_terlapor as nama_terlapor_awal,
                jabatan_pegawai_terlapor as jabatan_terlapor_awal,
                satker_pegawai_terlapor as satker_terlapor_awal, 
                golongan_pegawai_terlapor as golongan_terlapor_awal,
                pangkat_pegawai_terlapor as pangkat_terlapor_awal
                from was.pegawai_terlapor_was10 where no_register='".$_SESSION['was_register']."' 
                and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
                and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'and  id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."' ";
        $resultWas10=$connection->createCommand($sql)->queryAll();
        
        $query_was9 = "select id_pegawai_terlapor AS no_urut,
                       nama_pegawai_terlapor AS nama_terlapor_awal,
                       jabatan_pegawai_terlapor AS jabatan_terlapor_awal,
                       satker_pegawai_terlapor AS satker_terlapor_awal,
                       nip, nrp_pegawai_terlapor,pangkat_pegawai_terlapor as pangkat_terlapor_awal,
                       golongan_pegawai_terlapor as golongan_terlapor_awal from was.pegawai_terlapor 
                       where id_sp_was1=(select max(id_sp_was1)from was.sp_was_1) and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                       and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_wilayah='".$_SESSION['id_wil']."' and id_level1='".$_SESSION['id_level_1']."' and id_level2='".$_SESSION['id_level_2']."' and id_level3='".$_SESSION['id_level_3']."' and id_level4='".$_SESSION['id_level_4']."'

                       ";
        $resultWa9=$connection->createCommand($query_was9)->queryAll();

       
        $query_terlaporawal=$fungsi->get_terlapor2();
        $resultTerlaporawal = $connection->createCommand($query_terlaporawal)->queryAll();
		

        if(count($resultWas10)>=1){
            $modelTerlapor=$resultWas10;
			
        }else if(count($resultWas10)<=1 AND count($resultWa9)>=1){
            $modelTerlapor=$resultWa9;
			
        }else{
            $modelTerlapor=$resultTerlaporawal;
			
        }
	
		
		$modelPegawaiTerlapor = new PegawaiTerlapor();
        // $modelTembusanMaster = TembusanWas::findAll(["for_tabel"=>'sp_was_1','master']);
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'sp_was_1','condition2'=>'master'])->all();

        $sql="select*from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' 
              and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' 
              and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $modelWas1 = $connection->createCommand($sql)->queryOne();
		
         if ($model->load(Yii::$app->request->post())) {
          $transaction = $connection->beginTransaction();
          try {
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati = $_SESSION['kode_kejati'];
            $model->id_kejari = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register = $_SESSION['was_register'];
            $model->tanggal_mulai_sp_was1=date("Y-m-d", strtotime($_POST['SpWas1']['tanggal_mulai_sp_was1']));
  		    $model->tanggal_akhir_sp_was1=date("Y-m-d", strtotime($_POST['SpWas1']['tanggal_akhir_sp_was1']));
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->id_wilayah = $_SESSION['id_wil'];
            $model->id_level1 = $_SESSION['id_level_1'];
            $model->id_level2 = $_SESSION['id_level_2'];
            $model->id_level3 = $_SESSION['id_level_3'];
            $model->id_level4 = $_SESSION['id_level_4'];
            // $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
           

            $isi_dasar_surat = $_POST['isi_dasar_sp_was_1'];/*untuk table dasar surat*/
            $nip = $_POST['nip'];/*Untuk table pemeriksa*/
            $pejabat =  $_POST['pejabat'];/*Untuk table tembusan*/
            $terlapor =  $_POST['satkerTerlapor'];/*untuk table pegawai terlapor*/
         
            if ($model->save()) {
			
			
              
              for ($i = 0; $i < count($isi_dasar_surat); $i++) {
                $saveDasarSurat = new DasarSpWas1();
                $saveDasarSurat->id_sp_was1 = $model->id_sp_was1;
                $saveDasarSurat->isi_dasar_sp_was1 =   $_POST['isi_dasar_sp_was_1'][$i];
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

              for ($j = 0; $j < count($nip); $j++) {
                $savePemeriksa = new PemeriksaSpWas1 ();
                $savePemeriksa->id_sp_was1 = $model->id_sp_was1;
                $savePemeriksa->nip = $_POST['nip'][$j];
                $savePemeriksa->nrp =  $_POST['nrp'][$j];
                $savePemeriksa->nama_pemeriksa = $_POST['nama_pemeriksa'][$j];
                $savePemeriksa->pangkat_pemeriksa = $_POST['pangkat'][$j];
                $savePemeriksa->jabatan_pemeriksa = $_POST['jabatan'][$j];
                $savePemeriksa->golongan_pemeriksa = $_POST['golongan'][$j];
                $savePemeriksa->id_tingkat = $_SESSION['kode_tk'];
                $savePemeriksa->id_kejati = $_SESSION['kode_kejati'];
                $savePemeriksa->id_kejari = $_SESSION['kode_kejari'];
                $savePemeriksa->id_cabjari = $_SESSION['kode_cabjari'];
                $savePemeriksa->no_register = $_SESSION['was_register'];
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

              for($z=0;$z<count($pejabat);$z++){
                    $saveTembusan = new TembusanWas2;
                    $saveTembusan->from_table = 'Sp-Was-1';
                    $saveTembusan->pk_in_table = strrev($model->id_sp_was1);
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
                    $saveTembusan->save();
                }

              for($x=0;$x<count($terlapor);$x++){
                    $saveTerlapor = new PegawaiTerlapor;
                    // $saveTerlapor->for_tabel = 'Sp-Was-1';
                    $saveTerlapor->id_sp_was1 = $model->id_sp_was1;
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
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Ba-Was9 Gagal Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                $transaction->commit(); 
                return $this->redirect(['index']);

            }else{
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Ba-Was9 Gagal Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                return $this->redirect(['index']);
            }

          } catch (Exception $e) {
            $transaction->rollback();
             if(YII_DEBUG){throw $e; exit;} else{return false;}
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
     * Updates an existing SpWas1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$id_sp_was1)
    {
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }
      
        $model = $this->findModel($id,$id_sp_was1);

        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where1();/*karena ada perubahan kode*/
        $expire         =new GlobalFuncComponent();
        $table          ='sp_was_1';
        $filed          ='tanggal_akhir_sp_was1';
        $filter_1       ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
                          and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                          and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $result_expire  =$expire->CekExpire($table,$filed,$filter_1);
		$var=str_split($_SESSION['is_inspektur_irmud_riksa']);	

       	

		$modelTerlapor = new Query;
        $connection = \Yii::$app->db;
        $query = "select id_pegawai_terlapor AS no_urut,
                    nama_pegawai_terlapor AS nama_terlapor_awal,
                    jabatan_pegawai_terlapor AS jabatan_terlapor_awal,
                    satker_pegawai_terlapor AS satker_terlapor_awal,
                    nip, nrp_pegawai_terlapor,pangkat_pegawai_terlapor as pangkat_terlapor_awal,
                    golongan_pegawai_terlapor as golongan_terlapor_awal from was.pegawai_terlapor 
                    where no_register='".$_SESSION['was_register']."' and id_sp_was1='".$model->id_sp_was1."' and id_tingkat='".$_SESSION['kode_tk']."' 
                    and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
                    and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
	    $modelTerlapor = $connection->createCommand($query)->queryAll();

        $modelPegawaiTerlapor = new PegawaiTerlapor();
		$modelDasarSurat = DasarSpWas1::findAll(['id_sp_was1'=> $model->id_sp_was1,'no_register'=>$id,
                                                 'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                                 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                                 'id_wilayah'=>$_SESSION['id_wil'],
                                                 'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                                 'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);


		$modelPemeriksa = PemeriksaSpWas1::find()->where(['id_sp_was1' => $model->id_sp_was1, 
                                                          'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                                          'id_kejati'=>$_SESSION['kode_kejati'],
                                                          'id_kejari'=>$_SESSION['kode_kejari'],
                                                          'id_cabjari'=>$_SESSION['kode_cabjari'],
                                                          'id_wilayah'=>$_SESSION['id_wil'],
                                                          'id_level1'=>$_SESSION['id_level_1'],
                                                          'id_level2'=>$_SESSION['id_level_2'],
                                                          'id_level3'=>$_SESSION['id_level_3'],
                                                          'id_level4'=>$_SESSION['id_level_4']])->all();

		$sql="select*from was.was1 where no_register='".$_SESSION['was_register']."' and id_level_was1='3' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
		$modelWas1 = $connection->createCommand($sql)->queryOne();
 
		$modelTembusan = TembusanWas2::findBySql("select*from was.tembusan_was where from_table='Sp-Was-1' and no_register='".$_SESSION['was_register']."'
                                                  and pk_in_table='". $model->id_sp_was1 ."' and id_tingkat='".$_SESSION['kode_tk']."' 
                                                  and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."'
                                                  and id_cabjari='".$_SESSION['kode_cabjari']."' $where order by is_order desc")->all();
		
            $fungsi=new FungsiComponent();
            $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/ 
            $Old_file=$model->file_sp_was1;

         if ($model->load(Yii::$app->request->post())) {
          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {
                $file_name    = $_FILES['file_sp_was1']['name'];
                $file_size    = $_FILES['file_sp_was1']['size'];
                $file_tmp     = $_FILES['file_sp_was1']['tmp_name'];
                $file_type    = $_FILES['file_sp_was1']['type'];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $tmp = explode('.', $_FILES['file_sp_was1']['name']);
                $file_exists = end($tmp);
                $rename_file = $is_inspektur_irmud_riksa.'_'.$_SESSION[inst_satkerkd].'_'.$res.'.'.$ext;

          $model->tanggal_mulai_sp_was1=date("Y-m-d", strtotime($_POST['SpWas1']['tanggal_mulai_sp_was1']));
          $model->tanggal_akhir_sp_was1=date("Y-m-d", strtotime($_POST['SpWas1']['tanggal_akhir_sp_was1']));
          $model->updated_ip = $_SERVER['REMOTE_ADDR'];
          $model->updated_time = date('Y-m-d H:i:s');
          $model->updated_by = \Yii::$app->user->identity->id;
          $model->file_sp_was1 = ($file_name==''?$OldFile:$rename_file);
          $model->id_wilayah = $_SESSION['id_wil'];
          $model->id_level1 = $_SESSION['id_level_1'];
          $model->id_level2 = $_SESSION['id_level_2'];
          $model->id_level3 = $_SESSION['id_level_3'];
          $model->id_level4 = $_SESSION['id_level_4'];
          if($_POST['SpWas1']['nomor_sp_was1']!=''){
            $model->nomor_sp_was1 = $_POST['no_print'].$_POST['SpWas1']['nomor_sp_was1'].$_POST['no_hwj'];
           }
		
          $isi_dasar_surat = $_POST['isi_dasar_sp_was_1'];/*untuk table dasar surat*/
          $nip = $_POST['nip'];/*Untuk table pemeriksa*/
          $pejabat =  $_POST['pejabat'];/*Untuk table tembusan*/
          $terlapor =  $_POST['satkerTerlapor'];/*untuk table pegawai terlapor*/
          //           echo count($nip);
          // exit();
          
            if ($model->save()) {

                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'sp_was_1/'.$OldFile)) {
                    unlink(\Yii::$app->params['uploadPath'].'sp_was_1/'.$OldFile);
                } 
			
			DasarSpWas1::deleteAll(['id_sp_was1'=> $id_sp_was1, 'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                    'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                    'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['id_wil'],
                                    'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                    'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for ($i = 0; $i < count($isi_dasar_surat); $i++) {
                $saveDasarSurat = new DasarSpWas1();
                $saveDasarSurat->id_sp_was1 = $model->id_sp_was1;
                $saveDasarSurat->isi_dasar_sp_was1 =   $_POST['isi_dasar_sp_was_1'][$i];
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
			PemeriksaSpWas1::deleteAll(['id_sp_was1'=> $id_sp_was1, 'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                        'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                        'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['id_wil'],
                                        'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                        'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for ($j = 0; $j < count($nip); $j++) {
                $savePemeriksa = new PemeriksaSpWas1 ();
                $savePemeriksa->id_sp_was1 = $model->id_sp_was1;
                $savePemeriksa->nip = $_POST['nip'][$j];
                $savePemeriksa->nrp =  $_POST['nrp'][$j];
                $savePemeriksa->nama_pemeriksa = $_POST['nama_pemeriksa'][$j];
                $savePemeriksa->pangkat_pemeriksa = $_POST['pangkat'][$j];
                $savePemeriksa->jabatan_pemeriksa = $_POST['jabatan'][$j];
                $savePemeriksa->golongan_pemeriksa = $_POST['golongan'][$j];
                $savePemeriksa->id_tingkat = $_SESSION['kode_tk'];
                $savePemeriksa->id_kejati = $_SESSION['kode_kejati'];
                $savePemeriksa->id_kejari = $_SESSION['kode_kejari'];
                $savePemeriksa->id_cabjari = $_SESSION['kode_cabjari'];
                $savePemeriksa->no_register = $_SESSION['was_register'];
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
			TembusanWas2::deleteAll(['pk_in_table'=> $id_sp_was1, 'from_table'=>'Sp-Was-1','no_register'=>$id,
                                     'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                     'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                     'id_wilayah'=>$_SESSION['id_wil'],
                                     'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                     'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for($z=0;$z<count($pejabat);$z++){
                    $saveTembusan = new TembusanWas2;
                    $saveTembusan->from_table = 'Sp-Was-1';
                    $saveTembusan->pk_in_table = strrev($model->id_sp_was1);
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
                    $saveTembusan->save();
                }
			PegawaiTerlapor::deleteAll(['id_sp_was1'=> $id_sp_was1, 'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                        'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                        'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['id_wil'],
                                        'id_level1'=>$_SESSION['id_level_1'],'id_level2'=>$_SESSION['id_level_2'],
                                        'id_level3'=>$_SESSION['id_level_3'],'id_level4'=>$_SESSION['id_level_4']]);
              for($x=0;$x<count($terlapor);$x++){
                    $saveTerlapor = new PegawaiTerlapor;
                    // $saveTerlapor->for_tabel = 'Sp-Was-1';
                    $saveTerlapor->id_sp_was1 = $model->id_sp_was1;
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
                 $arr = array(ConstSysMenuComponent::Was9, ConstSysMenuComponent::Was10);
                
                if($model->tanggal_sp_was1!=null AND $model->nomor_sp_was1!=null){
                for ($i=0; $i < 2 ; $i++) { 
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
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
                        $modelTrxPemrosesan->id_wilayah = $_SESSION['id_wil'];
                        $modelTrxPemrosesan->id_level1 = $_SESSION['id_level_1'];
                        $modelTrxPemrosesan->id_level2 = $_SESSION['id_level_2'];
                        $modelTrxPemrosesan->id_level3 = $_SESSION['id_level_3'];
                        $modelTrxPemrosesan->id_level4 = $_SESSION['id_level_4'];
                        $modelTrxPemrosesan->save();
                }
                
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
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'sp_was_1/'.$rename_file);   
			
            return $this->redirect(['index']);
          } catch (Exception $e) {
            $transaction->rollback();
             if(YII_DEBUG){throw $e; exit;} else{return false;}
          }
        } else { 
            return $this->render('update', [
				  'model' => $model,
                  'modelPemeriksa' => $modelPemeriksa,
                  'modelTembusan' => $modelTembusan,
                  'modelDasarSurat' => $modelDasarSurat,
                  'modelTerlapor' => $modelTerlapor,
                  'modelPegawaiTerlapor' => $modelPegawaiTerlapor,
                  'modelTembusanMaster' => $modelTembusanMaster,
                  'modelWas1' => $modelWas1,
        		  'result_expire' => $result_expire,
            ]);
        }
    }

    /**
     * Deletes an existing SpWas1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionViewpdf($no_register,$id){
      
        $file_upload=$this->findModel($no_register,$id);
        $filepath = '../modules/pengawasan/upload_file/sp_was_1/'.$file_upload['file_sp_was1'];
        $extention=explode(".", $file_upload['file_sp_was1']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_sp_was1'] . '"');
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

    public function actionGettable()
    {
        $kriteria=$_GET['cari'];
        $query = new Query;
        $query->select('*')
                ->from('was.v_riwayat_jabatan1')
				->where("inst_satkerkd='".$_SESSION['inst_satkerkd']."'")
            ->andFilterWhere(['like', 'peg_nip_baru',$kriteria])
            // ->andFilterWhere(['like', 'upper(nama)',strtoupper($params['PegawaiSearch']['cari'])]);
            ->orFilterWhere(['like', 'upper(peg_nama)',strtoupper($kriteria)])
            ->orFilterWhere(['like', 'upper(gol_pangkat)',strtoupper($kriteria)])
            ->orFilterWhere(['like', 'upper(jbtn_panjang)',strtoupper($kriteria)]);
            

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
            'pageSize' => 10,
            ],
        ]);

          return $this->renderAjax('@app/modules/pengawasan/views/global/_searchPemeriksa',[
                    'dataProvider'=>$dataProvider,
                    ]);
    }

	public function actionHapus() {
    $id_sp_was_1 = $_POST['id'];
    $jml=$_POST['jml'];
    $check=explode(",",$id_sp_was_1);
        // echo $check[0].$jml; 
        for ($i=0; $i <$jml ; $i++) { 
    SpWas1::deleteAll(["no_register" => $check[$i],"id_tingkat"=>$_SESSION['kode_tk'],"id_kejati"=>$_SESSION['kode_kejati'],"id_kejari"=>$_SESSION['kode_kejari'],"id_cabjari"=>$_SESSION['kode_cabjari']]);
    }
     return $this->redirect(['index']);

  }
    /**
     * Finds the SpWas1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SpWas1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
	
  public function actionCetakdoc($id_sp_was1){
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        // $spwas1 = VSpWas1::findOne(['id_sp_was1' => $id_sp_was1]);/**/
        $connection = \Yii::$app->db;
        $sql = "select*from was.sp_was_1 where id_sp_was1='".$id_sp_was1."' and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        $spwas1=$connection->createCommand($sql)->queryOne();
        $dasar = DasarSpWas1::find()->where("id_sp_was1='".$id_sp_was1."'")->all();

        $pemeriksa = PemeriksaSpWas1::findAll(["id_sp_was1" => $id_sp_was1,"no_register"=>$_SESSION['was_register'],"id_tingkat"=>$spwas1['id_tingkat'],"id_kejati"=>$spwas1['id_kejati'],"id_kejari"=>$spwas1['id_kejari'],"id_cabjari"=>$spwas1['id_cabjari']]);
		
        $sqlTerlapor="select*from was.pegawai_terlapor where id_sp_was1='".$id_sp_was1."' and no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'";
        // $terlapor = PegawaiTerlapor::find()->where("id_sp_was='".$id_sp_was1."' and for_tabel='Sp-Was-1'")->all();
        $terlapor=$connection->createCommand($sqlTerlapor)->queryAll();


        $tgl_berlaku_1=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas1['tanggal_mulai_sp_was1'])));
        $tgl_berlaku_2=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas1['tanggal_akhir_sp_was1'])));
        $tgl_sp_was_1=GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($spwas1['tanggal_sp_was1'])));

       
        $tembusan_spwas1 = TembusanWas2::find()->where("pk_in_table='".$id_sp_was1."' and from_table='Sp-Was-1' and no_register='".$_SESSION['was_register']."' and id_kejati='".$spwas1['id_kejati']."' and id_kejari='".$spwas1['id_kejari']."' and id_cabjari='".$spwas1['id_cabjari']."'")->all();
		

        $dipa = DipaMaster::find()->where("is_aktif = '1'")->one();
      
    return $this->render('cetak',[
                                 'data_satker'=>$data_satker,
                                 'spwas1'=>$spwas1,
                                 'dasar'=>$dasar,
                                 'pemeriksa'=>$pemeriksa,
                                 'terlapor'=>$terlapor,
                                 'tgl_berlaku_1'=>$tgl_berlaku_1,
                                 'tgl_berlaku_2'=>$tgl_berlaku_2,
                                 'tgl_sp_was_1'=>$tgl_sp_was_1,
                                 'tembusan_spwas1'=>$tembusan_spwas1,
                                 'dipa'=>$dipa,
                                ]);

    }

 public function actionGetttd(){
 // echo "test";
 //    exit();
  $searchModelSpwas1 = new SpWas1Search();
  $dataProviderPenandatangan = $searchModelSpwas1->searchPenandatangan(Yii::$app->request->queryParams);
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
                                  return ['value' => $data['id_surat'],'class'=>'selection_one_tandatangan','json'=>$result];
                                  },
                          ],
                          
                       ],   

                  ]);
           Pjax::end(); 
          echo '<div class="modal-loading-new"></div>';
    }



    public function actionGetpemeriksa(){
 // echo "test";
 //    exit();
  $searchModel = new SpWas1Search();
  $dataProvider = $searchModel->searchPemeriksa(Yii::$app->request->queryParams);
  Pjax::begin(['id' => 'Mpemeriksa-grid', 'timeout' => false,'formSelector' => '#searchFormPemeriksa','enablePushState' => false]);
  echo GridView::widget([
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'Nama Pemeriksa',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama',    
                ],

                
                ['label'=>'NIP',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'peg_nip_baru',
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan',
                ],   

                ['class' => 'yii\grid\CheckboxColumn',
                   'checkboxOptions' => function ($data) {
                    $result=json_encode($data);
                    return ['value' => $data['peg_nip_baru'],'class'=>'Mselection_one','json'=>$result];
                    },
                ],
                
             ],   

        ]);
       Pjax::end(); 
      echo '<div class="modal-loading-new"></div>';
    } 

  public function actionGetterlapor(){
 // echo "test";
 //    exit();
  $searchModel = new SpWas1Search();
  $dataProvider = $searchModel->searchPegawai(Yii::$app->request->queryParams);
  $dataProvider->pagination->pageSize = 5;
  Pjax::begin(['id' => 'Mterlapor-ubah-grid', 'timeout' => false,'formSelector' => '#searchFormMterlapor','enablePushState' => false]);
  echo GridView::widget([
            'dataProvider'=> $dataProvider,
            // 'filterModel' => $searchModel,
            // 'layout' => "{items}\n{pager}",
            'columns' => [
                ['header'=>'No',
                'headerOptions'=>['style'=>'text-align:center;'],
                'contentOptions'=>['style'=>'text-align:center;'],
                'class' => 'yii\grid\SerialColumn'],
                
                ['label'=>'Nama Pegawai',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'nama',    
                ],

                
                ['label'=>'NIP',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'peg_nip_baru',
                ],

                ['label'=>'Jabatan',
                    'headerOptions'=>['style'=>'text-align:center;'],
                    'attribute'=>'jabatan',
                ],   

            ['header'=>'Action',
            'class' => 'yii\grid\ActionColumn',
            'headerOptions' => ['style' => 'width:5%;text-align:center;'],
            'contentOptions' => ['style' => 'width:5%;text-align:center;'],
                    'template' => '{pilih}',
                    'buttons' => [
                        'pilih' => function ($url, $model,$key) use ($param){
                            $result=json_encode($model);
                            return Html::button('<i class="fa fa-plus"> Pilih </i>', ['class' => 'btn btn-primary btn-xs MTpilih_terlapor','json'=>$result,'data-placement'=>'left', 'title'=>'Pilih Terlapor']);
                        },
                    ]
                ],
                
             ],   

        ]);
       Pjax::end(); 
      echo '<div class="modal-loading-new"></div>';
    } 
  
    protected function findModel($id,$id_sp_was1)
    {
        if (($model = SpWas1::findOne(['id_sp_was1'=>$id_sp_was1,'no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],
                                       'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
                                       'id_cabjari'=>$_SESSION['kode_cabjari'],
                                       'id_wilayah'=>$_SESSION['id_wil'],'id_level1'=>$_SESSION['id_level_1'],
                                       'id_level2'=>$_SESSION['id_level_2'],'id_level3'=>$_SESSION['id_level_3'],
                                       'id_level4'=>$_SESSION['id_level_4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	 protected function findModelTerlapor($id)
    {
        if (($modelTerlapor = Terlapor::findOne(['no_register'=>$id])) !== null) {
            return $modelTerlapor;
        } else {
            
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
	protected function findModelPegawaiTerlapor($id)
    {
        if (($modelPegawaiTerlapor = PegawaiTerlapor::findOne(['no_register'=>$id])) !== null) {
            return $modelPegawaiTerlapor;
        } else {
            
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
