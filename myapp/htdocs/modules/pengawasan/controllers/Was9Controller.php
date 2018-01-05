<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\models\Was9;
use app\modules\pengawasan\models\Was9Search;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil dari transaksi ketika update*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil dari master ketika create*/
use app\modules\pengawasan\models\SaksiEksternal;/*mengambil saksi external*/
use app\modules\pengawasan\models\SaksiInternal;/*mengambil saksi internal*/
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\vWas9;
use app\modules\pengawasan\models\PemeriksaSpWas1;
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
use yii\widgets\Pjax;


/**
 * Was9Controller implements the CRUD actions for Was9 model.
 */
class Was9Controller extends Controller
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
     * Lists all Was9 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Was9Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }


    public function actionCreatesaksi()
    { 
        $searchModel = new Was9Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new SaksiInternal();

        if ($model->load(Yii::$app->request->post())){
          $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              $jml=$_POST['nip'];
        for ($i=0; $i < count($jml); $i++) { 
            $saksi_in = new SaksiInternal();
            $saksi_in->no_register = $_SESSION['was_register'];
            $saksi_in->id_tingkat  = $_SESSION['kode_tk'];
            $saksi_in->id_kejati   = $_SESSION['kode_kejati'];
            $saksi_in->id_kejari   = $_SESSION['kode_kejari'];
            $saksi_in->id_cabjari  = $_SESSION['kode_cabjari'];
            $saksi_in->nip=$_POST['nip'][$i];
            $saksi_in->nrp=$_POST['nrp'][$i];
            $saksi_in->nama_saksi_internal=$_POST['nama'][$i]; 
            $saksi_in->pangkat_saksi_internal=$_POST['pangkat'][$i]; 
            $saksi_in->golongan_saksi_internal=$_POST['golongan'][$i];  
            $saksi_in->jabatan_saksi_internal=$_POST['jabatan'][$i];
            $saksi_in->created_ip  = $_SERVER['REMOTE_ADDR'];
            $saksi_in->created_time= date('Y-m-d H:i:s');
            $saksi_in->created_by  = \Yii::$app->user->identity->id;
            $saksi_in->save();
          }
            
            $transaction->commit();
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
            ]);
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

    public function actionCreatesaksi2()
    {
        $searchModel = new Was9Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $model = new SaksiEksternal();

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
            Yii::$app->getSession()->setFlash('success', [
             'type' => 'success',
             'duration' => 3000,
             'icon' => 'fa fa-users',
             'message' => 'Data Berhasil Disimpan',
             'title' => 'Simpan Data',
             'positonY' => 'top',
             'positonX' => 'center',
             'showProgressbar' => true,
            ]);
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

    /**
     * Displays a single Was9 model.
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
     * Creates a new Was9 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    
        $model = new Was9();
        $modelSaksiEksternal = new SaksiEksternal();

    	  $modelTembusanMaster = TembusanWas::findBySql("select * from was.was_tembusan_master where for_tabel='was_9' or for_tabel='master'")->all();
    		$connection = \Yii::$app->db;

        /*cek expire tanggal SPWAS1*/
        $fungsi         =new FungsiComponent();
        $where          =$fungsi->static_where();/*karena ada perubahan kode*/ 

        $filter_0       =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
        $spWas1         =$fungsi->FunctGetIdSpwas1All($filter_0);

        $Fungsi         =new GlobalFuncComponent();
        $table          ='sp_was_1';
        $filed          ='tanggal_akhir_sp_was1';
        $filter_1          =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was1 is not null $where";
        $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);

        /*mendapatkan id SPWAS1 Yang  Aktif*/
        // $FungsiWas      =new FungsiComponent();
        $filter_2         =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $getId          =$fungsi->FunctGetIdSpwas1($filter_2);
       

        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
              
            $saksi_internal=KpPegawai::findOne(['peg_nip_baru'=>$_POST['nip']]);
            $pegawai_pemeriksa=PemeriksaSpWas1::findOne(['nip'=>$model->nip_pemeriksa]);
            
            
            $model->no_register=$_SESSION['was_register'];
            $model->jenis_saksi=$_POST['jenis_saksi'];
            $model->tanggal_pemeriksaan_was9=date('Y-m-d', strtotime($_POST['Was9']['tanggal_pemeriksaan_was9']));
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_by = \Yii::$app->user->identity->id;
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati = $_SESSION['kode_kejati'];
            $model->id_kejari = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register = $_SESSION['was_register'];

            $model->id_sp_was         = $getId['id_sp_was1'];
            $model->jenis_saksi       = $_POST['jenis_saksi'];
            $model->id_saksi          = $_POST['id_saksi'];
            $model->nip_pemeriksa     = $pegawai_pemeriksa['nip'];
            $model->id_pemeriksa      = $pegawai_pemeriksa['id_pemeriksa_sp_was1'];
            $model->nama_pemeriksa    = $pegawai_pemeriksa['nama_pemeriksa'];
            $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
            $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
            $model->golongan_pemeriksa= $pegawai_pemeriksa['golongan_pemeriksa'];
            $model->nrp_pemeriksa     = $pegawai_pemeriksa['nrp'];

        if($model->save()) {


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

                 $arr = array(ConstSysMenuComponent::Was13, ConstSysMenuComponent::Bawas3, ConstSysMenuComponent::Was11, ConstSysMenuComponent::Bawas4, ConstSysMenuComponent::Bawas2);
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
                'spWas1' => $spWas1,
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
    $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_surat_was9,'from_table'=>'Was9','no_register'=>$model->no_register,'id_tingkat'=>$model->id_tingkat,'id_kejati'=>$model->id_kejati,'id_kejari'=>$model->id_kejari,'id_cabjari'=>$model->id_cabjari,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
    
    
    $fungsi=new FungsiComponent();
    $where=$fungsi->static_where();/*karena ada perubahan kode*/ 

    $filter_0       =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where";
    $spWas1         =$fungsi->FunctGetIdSpwas1All($filter_0);

    $Fungsi         =new GlobalFuncComponent();
    $table          ='sp_was_1';
    $filed          ='tanggal_akhir_sp_was1';
    $filter_1          ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and tanggal_akhir_sp_was1 is not null $where";
    $result_expire  =$Fungsi->CekExpire($table,$filed,$filter_1);
    
    $modelSaksiEksternal = new SaksiEksternal();
        
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/         
        $OldFile=$model->was9_file;

        if($model->load(Yii::$app->request->post())){
              $pegawai_pemeriksa=PemeriksaSpWas1::findOne(['nip'=>$model->nip_pemeriksa]);

              $file_name    = $_FILES['was9_file']['name'];
              $file_size    = $_FILES['was9_file']['size'];
              $file_tmp     = $_FILES['was9_file']['tmp_name'];
              $file_type    = $_FILES['was9_file']['type'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $tmp = explode('.', $_FILES['was9_file']['name']);
              $file_exists = end($tmp);
              $rename_file = $is_inspektur_irmud_riksa.'_'.$_GET['id_saksi'].'_'.$_SESSION[inst_satkerkd].'_'.$res.'.'.$ext;
              

          $connection = \Yii::$app->db;
          $transaction = $connection->beginTransaction();
          try {


        $model->jenis_saksi=$_POST['jenis_saksi'];
        $model->tanggal_pemeriksaan_was9=date('Y-m-d', strtotime($_POST['Was9']['tanggal_pemeriksaan_was9']));
        $model->updated_ip = $_SERVER['REMOTE_ADDR'];
        $model->updated_time = date('Y-m-d H:i:s');
        $model->updated_by = \Yii::$app->user->identity->id;
        $model->nip_pemeriksa     = $pegawai_pemeriksa['nip'];
        $model->id_pemeriksa      = $pegawai_pemeriksa['id_pemeriksa_sp_was1'];
        $model->nama_pemeriksa    = $pegawai_pemeriksa['nama_pemeriksa'];
        $model->pangkat_pemeriksa = $pegawai_pemeriksa['pangkat_pemeriksa'];
        $model->jabatan_pemeriksa = $pegawai_pemeriksa['jabatan_pemeriksa'];
        $model->golongan_pemeriksa= $pegawai_pemeriksa['golongan_pemeriksa'];
        $model->nrp_pemeriksa     = $pegawai_pemeriksa['nrp'];
        $model->was9_file = ($file_name==''?$OldFile:$rename_file);
        if($model->save()) {
           
            if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_9/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'was_9/'.$OldFile);
            } 

                    TembusanWas2::deleteAll(['from_table'=>'Was9','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_surat_was9,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                      
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

                    $arr = array(ConstSysMenuComponent::Was13, ConstSysMenuComponent::Bawas3, ConstSysMenuComponent::Was11, ConstSysMenuComponent::Bawas4, ConstSysMenuComponent::Bawas2);
                    for ($i=0; $i < 5 ; $i++) { 
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
                move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_9/'.$rename_file);   
        }
            return $this->redirect(['index']);
            } catch (Exception $e) {
              $transaction->rollback();
              if(YII_DEBUG){throw $e; exit;} else{return false;}
            
          }
        } else {
            return $this->render('update', [
                'model' => $model,
                'spWas1' => $spWas1,
                'modelTembusan' => $modelTembusan,
                'result_expire' => $result_expire,
            ]);
        }
    }


public function actionGettable(){
      $kriteria=$_GET['cari'];
      $model = new Was9();
        $query = new Query;
        $query="select*from was.vw_pegawai_terlapor";
        $keyWord  = htmlspecialchars($_GET['cari'], ENT_QUOTES);
         if($_GET['cari']!=''){
          $query .=" where  upper(peg_nama) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(peg_nip_baru) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(jabatan) like'%".strtoupper($keyWord)."%'";
          $query .=" or  upper(pangkat) like'%".strtoupper($keyWord)."%'";
         }

        // add conditions that should always apply here

        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a  ")->queryScalar();  
        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'pagination' => [
            'pageSize' => 10,
      ]
        ]);


          return $this->renderAjax('@app/modules/pengawasan/views/global/_searchPegawaiKpPegawaiWas9',[
                    'dataProvider'=>$dataProvider,
                    'param'=>'was9',
                    'model'=>$model,
                    ]);
    }

    /**
     * Updates an existing Was9 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
//
public function actionUpdateinternal()
    {

      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where();
      $connection = \Yii::$app->db;
      $query1 = "update was.saksi_internal set nama_saksi_internal='".$_POST['Mnama']."',nip='".$_POST['Mnip']."',nrp='".$_POST['Mnrp']."', jabatan_saksi_internal='".$_POST['Mjabatan']."',golongan_saksi_internal='".$_POST['Mgolongan']."',pangkat_saksi_internal='".$_POST['Mpangkat']."'
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_saksi_internal='".$_POST['Mid']."' $where";
      $updateinternal = $connection->createCommand($query1);
      $updateinternal->execute();
      Yii::$app->getSession()->setFlash('success', [
       'type' => 'success',
       'duration' => 3000,
       'icon' => 'fa fa-users',
       'message' => 'Data Berhasil Disimpan',
       'title' => 'Simpan Data',
       'positonY' => 'top',
       'positonX' => 'center',
       'showProgressbar' => true,
      ]);
      return $this->redirect(['index']);
    }

    public function actionUpdateeksternal()
    {
      $fungsi=new FungsiComponent();
      $where=$fungsi->static_where();
      $connection = \Yii::$app->db;
      $query1 = "update was.saksi_eksternal set nama_saksi_eksternal='".$_POST['Mnama_eks']."',
        tempat_lahir_saksi_eksternal='".$_POST['Mtempat_eks']."',id_negara_saksi_eksternal='".$_POST['Mwarga_eks']."',
        tanggal_lahir_saksi_eksternal='".$_POST['Mtanggal_eks']."',pendidikan='".$_POST['Mpendidikan_eks']."',
        id_agama_saksi_eksternal='".$_POST['Magama_eks']."',alamat_saksi_eksternal='".$_POST['Malamat_eks']."',
        nama_kota_saksi_eksternal='".$_POST['Mkota_eks']."',pekerjaan_saksi_eksternal='".$_POST['Mkerja_eks']."'
        
        where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' 
        and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' 
        and id_cabjari='".$_SESSION['kode_cabjari']."' and id_saksi_eksternal='".$_POST['Mid_eks']."' $where";
      $updateinternal = $connection->createCommand($query1);
      $updateinternal->execute();
      Yii::$app->getSession()->setFlash('success', [
       'type' => 'success',
       'duration' => 3000,
       'icon' => 'fa fa-users',
       'message' => 'Data Berhasil Disimpan',
       'title' => 'Simpan Data',
       'positonY' => 'top',
       'positonX' => 'center',
       'showProgressbar' => true,
      ]);
      return $this->redirect(['index']);
      
      //echo $nm,$nm1,$nm2,$nm3,$nm4,$nm5,$nm6,$nm7,$nm8,$nm9;
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
                    and a.pk_in_table='".$model['id_surat_was9']."' and from_table='Was9' $where order by is_order";
        $model2 = $connection->createCommand($query2)->queryAll();
//
        $query3 = "select a.*,b.* from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
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
                    and a.id_sp_was1='".$model['id_sp_was']."' $where ";
        $model3 = $connection->createCommand($query3)->queryOne();

        $query4 = "select a.* from was.lapdu a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                   ";
        $model4 = $connection->createCommand($query4)->queryOne();

        $query5 = "select string_agg(a.nama_pegawai_terlapor,'#') as nama_pegawai_terlapor from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
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
                    and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $model5 = $connection->createCommand($query5)->queryOne();

        

         $tgl_periksa = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_pemeriksaan_was9'])));
         $tgl_was9    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_was9'])));
         $tglSpWas    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model3['tanggal_sp_was1'])));
        
        return $this->render('cetak',['model'=>$model, 'model2'=>$model2, 'model3'=>$model3, 'model4'=>$model4, 'model5'=>$model5 , 'data_satker'=>$data_satker, 'tgl_periksa'=>$tgl_periksa , 'tglSpWas'=>$tglSpWas, 'tgl_was9'=>$tgl_was9]);
    }

     public function actionCetak2($id,$no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);

        $connection = \Yii::$app->db;
        $query1 = "select a.*,b.* from was.was9 a
                    inner join was.saksi_eksternal b
                    on a.id_saksi=b.id_saksi_eksternal
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
                    and a.pk_in_table='".$model['id_surat_was9']."' and from_table='Was9' $where";
        $model2 = $connection->createCommand($query2)->queryAll();
        
        $query3 = "select a.*,b.* from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
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
                    and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $model3 = $connection->createCommand($query3)->queryOne();

        
        $query4 = "select a.* from was.lapdu a
                    where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                    and a.id_kejati='".$id_kejati."' 
                    and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                   ";
        $model4 = $connection->createCommand($query4)->queryOne();

         $query5 = "select string_agg(a.nama_pegawai_terlapor,'#') as nama_pegawai_terlapor from was.pegawai_terlapor a
                    inner join was.sp_was_1 b
                    on a.id_sp_was1=b.id_sp_was1
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
                    and a.id_sp_was1='".$model['id_sp_was']."' $where";
        $model5 = $connection->createCommand($query5)->queryOne();

       

         $tgl_periksa = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_pemeriksaan_was9'])));
         $tgl_was9    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['tanggal_was9'])));
         $tglSpWas    = GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model3['tanggal_sp_was1'])));
        
        return $this->render('cetak',['model'=>$model, 'model2'=>$model2, 'model3'=>$model3, 'model4'=>$model4, 'model5'=>$model5 , 'data_satker'=>$data_satker, 'tgl_periksa'=>$tgl_periksa , 'tglSpWas'=>$tglSpWas, 'tgl_was9'=>$tgl_was9]);
    }





    public function actionCetakdocx($id) {
     
      $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
      $model = vWas9::findOne(['id_was9' => $id,'id_surat'=>'was9']);
      $tanggal=\Yii::$app->globalfunc->ViewIndonesianFormat($model->tanggal_was9); //date('d F Y', strtotime($model->tanggal_was9)));

      $query="select a.*, ";
    if($model->jenis_saksi=='0'){
      $query .=" b.nama_saksi_internal nama_saksi, b.lokasi_saksi_internal as lokasi_saksi";
      $query_tambahan=" left join was.saksi_internal b on a.id_was9=b.id_was where b.from_table='WAS-9' and a.no_register='".$_SESSION['was_register']."'";
    }else{
       $query .=" b.nama_saksi_eksternal as nama_saksi,  b.lokasi_saksi_eksternal as lokasi_saksi";
      $query_tambahan=" left join was.saksi_eksternal b on a.id_was9=b.id_was where b.from_table='WAS-9' and a.no_register='".$_SESSION['was_register']."' and id_kejati='".$_SESSION['kd_keja']."'";
    }
      $tanggalPanggilan=\Yii::$app->globalfunc->ViewIndonesianFormat($model->tanggal_pemeriksaan_was9); //date('d F Y', strtotime($model->tanggal_pemeriksaan_was9)));

          $query .=" from was.was9 a";
          $query .=$query_tambahan;
          $connection = \Yii::$app->db;
          $modelSaksi = $connection->createCommand($query)->queryOne();
/*kenapa ini spwas1 di bawah ini d query all ini karena dulu daskrimti bilang spawas1 di buat hanya satu kali! kemudian terakhir2(masa garansi) bilang bahwa spwas1 bisa beberapa kali */
    $sp_was_1 = SpWas1::find()->where("no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'")->all();
    $query_sql="select string_agg(nama_pegawai_terlapor,', ') as nama_pegawai_terlapor from was.pegawai_terlapor where id_sp_was='".$sp_was_1[0]['id_sp_was1']."'";
    $terlapor = $connection->createCommand($query_sql)->queryOne();

    $sql="select*from was.lapdu where no_register='".$_SESSION['was_register']."'";
    $lapdu = $connection->createCommand($sql)->queryOne();

   
    $modelPemeriksa = PemeriksaSpWas1::find()->where("id_sp_was1='".$sp_was_1[0]['id_sp_was1']."' and nip='".$model->nip."'")->one();

    $tglSpWas= \Yii::$app->globalfunc->ViewIndonesianFormat($sp_was_1[0]['tanggal_sp_was1']);

    $tembusan_was9 = TembusanWas2::find()->where(['pk_in_table'=>$model->id_surat_was9,'from_table'=>'Was9','no_register'=>$model->no_register,'id_tingkat'=>$model->id_tingkat,'id_kejati'=>$model->id_kejati,'id_kejari'=>$model->id_kejari,'id_cabjari'=>$model->id_cabjari,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->all();

       return $this->render('cetak',[
                                    'data_satker'=>$data_satker,
                                    'model'=>$model,
                                    'tanggal'=>$tanggal,
                                    'modelSaksi'=>$modelSaksi,
                                    'tanggalPanggilan'=>$tanggalPanggilan,
                                    'modelPemeriksa'=>$modelPemeriksa,
                                    'terlapor'=>$terlapor,
                                    'lapdu'=>$lapdu,
                                    'sp_was_1'=>$sp_was_1,
                                    'tglSpWas'=>$tglSpWas,
                                    'tembusan_was9'=>$tembusan_was9,
                           ]);

    }

    /**
     * Deletes an existing Was9 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
public function actionGetsaksiint(){
   $jenis_saksi= $_POST['jenis_saksi'];
   $id_saksi   = $_POST['id_saksi'];
   $nip        = $_POST['nip'];
   $nm         = $_POST['nm'];
  /* echo $id;
   echo $id_saksi;*/
  $searchModel = new Was9Search();
 // $id_saksi = 7;
  $dataProviderWas9Int = $searchModel->searchSaksiInt($jenis_saksi,$id_saksi);
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
                            return "<input type='checkbox' name='MselectionSIn_one[]'  value='".$data['no_register']."' json='".$result."' surat='".$data['nomor_surat_was9']."#".$data['id_saksi']."#".$data['id_surat_was9']."' class='MselectionSIn_one' />";
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
  $searchModel = new Was9Search();
 
  $dataProviderWas9Eks = $searchModel->searchSaksiEks($jenis_saksi,$id_saksi);
  echo " <input type='hidden' name='Mnm_eks' class='Mnm_eks' value='".$nm."'>
        <input type='hidden' name='Mid_eks' class='Mid_eks' value='".$id_saksi."'>";
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
                                return "<input type='checkbox' name='MselectionSIe_one[]'  value='".$data['no_register']."' json='".$result."' surat='".$data['nomor_surat_was9']."#".$data['id_saksi']."#".$data['id_surat_was9']."' class='MselectionSIe_one' />";
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
          'id_saksi'=>$pecahLagi[1],'jenis_saksi'=>'Internal','id_wilayah'=>$_SESSION['was_id_wilayah'],
          'id_level1'=>$_SESSION['was_id_level1'],
          'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
          'id_level4'=>$_SESSION['was_id_level4']]);

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
        was9::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_cabjari'=>$_SESSION['kode_cabjari'],'nomor_surat_was9'=>$pecahLagi[0],
          'id_saksi'=>$pecahLagi[1],'jenis_saksi'=>'Eksternal',
          'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
          'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
          'id_level4'=>$_SESSION['was_id_level4']]);

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
       }else{
      //  echo "jangan hapus ";
      }
   }
   return $this->redirect(['index']);

  }

  public function actionDelete(){
   $id= $_POST['id'];
   $pecah=explode(',', $id);
  
   for ($i=0; $i < count($pecah); $i++) { 
       $pecahLagi= explode('#', $pecah[$i]);
     
        SaksiInternal::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_cabjari'=>$_SESSION['kode_cabjari'],'nip'=>$pecahLagi[2],'id_saksi_internal'=>$pecahLagi[1],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
      
   }

    Yii::$app->getSession()->setFlash('success', [
     'type' => 'success',
     'duration' => 3000,
     'icon' => 'fa fa-users',
     'message' => 'Data Ba-Was9 Berhasil Dihapus',
     'title' => 'Hapus Data',
     'positonY' => 'top',
     'positonX' => 'center',
     'showProgressbar' => true,
    ]);
   return $this->redirect(['index']);

  }


  public function actionDelete2(){
   $id= $_POST['id'];
   SaksiEksternal::deleteAll([
          'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],
          'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],
          'id_cabjari'=>$_SESSION['kode_cabjari'],'id_saksi_eksternal'=>$id,
          'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],
          'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],
          'id_level4'=>$_SESSION['was_id_level4']]);
   return $this->redirect(['index']);
  
  }
     public function actionViewpdf($id,$no,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
       $file_upload=$this->findModel($id,$no,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
        $filepath = '../modules/pengawasan/upload_file/was_9/'.$file_upload['was9_file'];
        $extention=explode(".", $file_upload['was9_file']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['was9_file'] . '"');
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



    public function actionHapus() {
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
    $model = was9::findAll(array("no_register" => $_SESSION['was_register'],'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa']));
     if(count($model)<=0){
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        $connection = \Yii::$app->db;
        $query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
        $disposisi_irmud = $connection->createCommand($query1)->queryAll(); 

        for ($i=0;$i<count($disposisi_irmud);$i++){
        
        $saveDisposisi = DisposisiIrmud::find()->where("no_register='".$_SESSION['was_register']."' and id_terlapor_awal='".$disposisi_irmud[$i]['id_terlapor_awal']."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."'")->one();
        if($var[2]==1){
            $connection = \Yii::$app->db;
            $query1 = "update was.was_disposisi_irmud set status_pemeriksa1='SP.WAS-1' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
            $disposisi_irmud = $connection->createCommand($query1);
            $disposisi_irmud->execute();
        }
        if($var[2]==2){
            $connection = \Yii::$app->db;
            $query1 = "update was.was_disposisi_irmud set status_pemeriksa2='SP.WAS-1' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
            $disposisi_irmud = $connection->createCommand($query1);
            $disposisi_irmud->execute();
        // }    
        }   
      }
    

    // hapus trx_permrosesan WAS11,BAWAS2  dan BAWAS4
       $arr = array(ConstSysMenuComponent::Was11, ConstSysMenuComponent::Bawas4, ConstSysMenuComponent::Bawas2);
    for ($z=0; $z < 3 ; $z++) { 
            WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$z]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
    }
    // hapus trx_permrosesan BAWAS3  dan WAS13, tp harus cek was10 dulu jika was10 ada maka jangan di hapus
    $cek_was10 = "select count(*) as jumlah from was.was10 where no_register='".$_SESSION['was_register']."' AND is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
    $result_wa10 = $connection->createCommand($cek_was10)->queryOne(); 
    
    if($result_wa10['jumlah']<=0){
      $arr = array(ConstSysMenuComponent::Was13, ConstSysMenuComponent::Bawas3);
    for ($x=0; $x < 2 ; $x++) { 
            WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$x]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
    }
    }
    

}
         return $this->redirect(['index']);
  }

  public function actionGetttd(){
       
   $searchModelWas9 = new Was9Search();
   $dataProviderPenandatangan = $searchModelWas9->searchPenandatangan(Yii::$app->request->queryParams);
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
     * Finds the Was9 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was9 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModelint($id)
    {
        if (($model = SaksiInternal::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'] , 'is_inspektur_irmud_riksa'=>$_SESSION['is_inspektur_irmud_riksa'],'id_saksi_internal'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModel_int($id_saksi,$id_was9)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        if (($model = Was9::findBySql("
            select a.*,b.nama_saksi_internal as nama_saksi,
            b.nip as nip_saksi,b.pangkat_saksi_internal as pangkat_saksi, b.golongan_saksi_internal as golongan_saksi,
            b.jabatan_saksi_internal as jabatan_saksi,'' as tempat_lahir,null as tanggal_lahir,null as id_negara,null as agama,
            null as pendidikan,'' as alamat,null as kota,null as pekerjaan
            from was.was9 a left join was.saksi_internal b on a.id_saksi=b.id_saksi_internal
             where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."' 
               and jenis_saksi='Internal' and a.id_saksi='".$id_saksi."' and a.id_surat_was9=".$id_was9." $where")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     protected function findModel_eks($id_saksi,$id_was9)
    {
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        if (($model = Was9::findBySql("
            select a.*,b.nama_saksi_eksternal as nama_saksi,
             '' as nip_saksi, '' as pangkat_saksi, '' as golongan_saksi,'' as jabatan_saksi, b.tempat_lahir_saksi_eksternal as tempat_lahir,
             tanggal_lahir_saksi_eksternal as tanggal_lahir,b.id_negara_saksi_eksternal as id_negara,b.id_agama_saksi_eksternal as agama, b.pendidikan as pendidikan,
             b.alamat_saksi_eksternal as alamat,b.nama_kota_saksi_eksternal as kota,b.pekerjaan_saksi_eksternal as pekerjaan
              from was.was9 a left join was.saksi_eksternal b on a.id_saksi=b.id_saksi_eksternal
               where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['kode_cabjari']."' and jenis_saksi='Eksternal' and a.id_saksi='".$id_saksi."' 
               and a.id_surat_was9=".$id_was9." $where")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

     protected function findModel($id,$no,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
       /* $model = Was2::findOne($id,$id_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
             return $model;*/
        if (($model = Was9::findOne(['id_saksi'=>$id,'nomor_surat_was9'=>$no,'no_register' => $id_register,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelz($id,$no)
    {
        if (($model = Was9::findBySql("select a.*,b.nama_saksi_eksternal as nama_saksi,b.lokasi_saksi_eksternal as di,
             '' as nip_saksi, '' as pangkat_saksi, '' as golongan_saksi,'' as jabatan_saksi, b.tempat_lahir_saksi_eksternal as tempat_lahir,
             tanggal_lahir_saksi_eksternal as tanggal_lahir,b.id_negara_saksi_eksternal as id_negara,b.id_agama_saksi_eksternal as agama, b.pendidikan as pendidikan,
             b.alamat_saksi_eksternal as alamat,b.nama_kota_saksi_eksternal as kota,b.pekerjaan_saksi_eksternal as pekerjaan
              from was.was9 a left join was.saksi_eksternal b on a.id_saksi=b.id_saksi_eksternal
               where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['id_cabjari']."' and jenis_saksi='Eksternal' and a.id_saksi='".$id."' and a.nomor_surat_was9='".$no."'
            union
            select a.*,b.nama_saksi_internal as nama_saksi,b.lokasi_saksi_internal as di,
            b.nip as nip_saksi,b.pangkat_saksi_internal as pangkat_saksi, b.golongan_saksi_internal as golongan_saksi,
            b.jabatan_saksi_internal as jabatan_saksi,'' as tempat_lahir,null as tanggal_lahir,null as id_negara,null as agama,
            null as pendidikan,'' as alamat,null as kota,null as pekerjaan
            from was.was9 a left join was.saksi_internal b on a.id_saksi=b.id_saksi_internal
             where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."'
               and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."'
               and a.id_cabjari='".$_SESSION['id_cabjari']."' and jenis_saksi='Internal' and a.id_saksi='".$id."'  and a.nomor_surat_was9='".$no."'")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
