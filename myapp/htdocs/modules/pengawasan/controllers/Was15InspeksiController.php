<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\was15;
use app\modules\pengawasan\models\LWas2Inspeksi;
use app\modules\pengawasan\models\LWas2Terlapor;
use app\modules\pengawasan\models\Was15Rencana;
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\SpWas2;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\components\FungsiComponent; 
use app\components\ConstSysMenuComponent; 
/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class Was15InspeksiController extends Controller
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
         $model = $this->findModel();
         if($model){
           $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was15-inspeksi/update"));
	       // echo "ada";
         }else{
           // echo "kosomng";
           $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was15-inspeksi/create"));
         }
         // print_r($model);

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
         // $model = $this->findModel();
         // if(count($model)>0){
           // $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was15-inspeksi/update"));
         // }else{
          
        $model = new was15();
        $modelLwas2=LWas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelTerlapor=LWas2Terlapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'saran_l_was_2'=>'1']);
     
        $modelTembusanMaster = TembusanWas::find()->where("for_tabel=:condition1 OR for_tabel=:condition2", [":condition1" => 'was_15','condition2'=>'master'])->orderBy('id_tembusan desc')->all();

        if ($model->load(Yii::$app->request->post())){
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
            $model->id_sp_was2=$modelLwas2['id_sp_was2'];
            $model->id_ba_was2=$modelLwas2['id_ba_was2'];
            $model->id_l_was2=$modelLwas2['id_l_was2'];

        if($model->save()) {
          
            foreach ($_POST['nip_terlapor'] as $idx1 => $value1) {
                foreach ($_POST['saran_rencana'][$idx1] as $key => $value) {
                        $modelRencana=new Was15Rencana();
                        $modelRencana->no_register = $_SESSION['was_register'];
                        $modelRencana->id_tingkat  = $_SESSION['kode_tk'];
                        $modelRencana->id_kejati   = $_SESSION['kode_kejati'];
                        $modelRencana->id_kejari   = $_SESSION['kode_kejari'];
                        $modelRencana->id_cabjari  = $_SESSION['kode_cabjari'];
                        $modelRencana->created_by=\Yii::$app->user->identity->id;
                        $modelRencana->created_ip=$_SERVER['REMOTE_ADDR'];
                        $modelRencana->created_time=date('Y-m-d H:i:s');
                        $modelRencana->id_sp_was2=$model['id_sp_was2'];
                        $modelRencana->id_ba_was2=$model['id_ba_was2'];
                        $modelRencana->id_l_was2=$model['id_l_was2'];
                        $modelRencana->id_was15=$model['id_was15'];
                        $modelRencana->kategori_hukuman=$_POST['saran_rencana'][$idx1][$key];
                        $modelRencana->jenis_hukuman=$_POST['saran_hukuman'][$idx1][$key];
                        $modelRencana->saran_dari=$_POST['saran_dari'][$idx1][$key];
                        $modelRencana->pasal=$_POST['pasal'][$idx1][$key];
                        $modelRencana->sk=$_POST['sk'][$idx1][$key];
                        $modelRencana->nip_terlapor=$_POST['nip_terlapor'][$idx1];
                        $modelRencana->nrp_terlapor=$_POST['nrp_terlapor'][$idx1];
                        $modelRencana->nama_terlapor=$_POST['nama_terlapor'][$idx1];
                        $modelRencana->pangkat_terlapor=$_POST['pangkat_terlapor'][$idx1];
                        $modelRencana->golongan_terlapor=$_POST['golongan_terlapor'][$idx1];
                        $modelRencana->jabatan_terlapor=$_POST['jabatan_terlapor'][$idx1];
                        $modelRencana->satker_terlapor=$_POST['satker_terlapor'][$idx1];
                        $modelRencana->save();
                        
                }
            }

            $pejabat = $_POST['pejabat'];
                // TembusanWas2::deleteAll(['from_table'=>'Was-15','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was15),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                    for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-15';
                        $saveTembusan->pk_in_table = strrev($model->id_was15);
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
            $transaction->commit(); 
            return $this->redirect(['index']);
        } catch(Exception $e) {
                $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        }   else {
            return $this->render('create', [
                'model' => $model,
                'modelTerlapor' => $modelTerlapor,
                'modelTembusanMaster' => $modelTembusanMaster,
            ]);
        }
    // }
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate()
    {
        // $model = $this->findModel();
        //  if(count($model)>0){
         
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

        $model = $this->findModel();
        $modelTerlapor=Was15Rencana::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'saran_dari'=>'Jamwas']);
        $modelDetail=Was15Rencana::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was15,'from_table'=>'Was-15','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();

        $fungsi         =new FungsiComponent();


        
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
            try{
                $model->updated_by=\Yii::$app->user->identity->id;
                $model->updated_ip=$_SERVER['REMOTE_ADDR'];
                $model->updated_time=date('Y-m-d H:i:s');
                $model->upload_file=($file_name==''?$OldFile:$rename_file);
                 if($model->save()){
                    if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_15/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_15/'.$OldFile);
                    } 

                    Was15Rencana::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'id_was15'=>$model->id_was15]);
                        foreach ($_POST['nip_terlapor'] as $idx1 => $value1) {
                            foreach ($_POST['saran_rencana'][$idx1] as $key => $value) {
                                    $modelRencana=new Was15Rencana();
                                    $modelRencana->no_register = $_SESSION['was_register'];
                                    $modelRencana->id_tingkat  = $_SESSION['kode_tk'];
                                    $modelRencana->id_kejati   = $_SESSION['kode_kejati'];
                                    $modelRencana->id_kejari   = $_SESSION['kode_kejari'];
                                    $modelRencana->id_cabjari  = $_SESSION['kode_cabjari'];
                                    $modelRencana->created_by=\Yii::$app->user->identity->id;
                                    $modelRencana->created_ip=$_SERVER['REMOTE_ADDR'];
                                    $modelRencana->created_time=date('Y-m-d H:i:s');
                                    $modelRencana->id_sp_was2=$model['id_sp_was2'];
                                    $modelRencana->id_ba_was2=$model['id_ba_was2'];
                                    $modelRencana->id_l_was2=$model['id_l_was2'];
                                    $modelRencana->id_was15=$model['id_was15'];
                                    $modelRencana->kategori_hukuman=$_POST['saran_rencana'][$idx1][$key];
                                    $modelRencana->jenis_hukuman=$_POST['saran_hukuman'][$idx1][$key];
                                    $modelRencana->saran_dari=$_POST['saran_dari'][$idx1][$key];
                                    $modelRencana->pasal=$_POST['pasal'][$idx1][$key];
                                    $modelRencana->sk=$_POST['sk'][$idx1][$key];
                                    $modelRencana->nip_terlapor=$_POST['nip_terlapor'][$idx1];
                                    $modelRencana->nrp_terlapor=$_POST['nrp_terlapor'][$idx1];
                                    $modelRencana->nama_terlapor=$_POST['nama_terlapor'][$idx1];
                                    $modelRencana->pangkat_terlapor=$_POST['pangkat_terlapor'][$idx1];
                                    $modelRencana->golongan_terlapor=$_POST['golongan_terlapor'][$idx1];
                                    $modelRencana->jabatan_terlapor=$_POST['jabatan_terlapor'][$idx1];
                                    $modelRencana->satker_terlapor=$_POST['satker_terlapor'][$idx1];
                                    $modelRencana->save();
                                    
                            }
                        }

                        for ($r=0; $r < count($_POST['nip_terlapor_ja']); $r++) { 
                            // echo $_POST['nip_terlapor_ja'][$r].'<br>';
                            $modelRencanaJa=new Was15Rencana();
                            $modelRencanaJa->no_register = $_SESSION['was_register'];
                            $modelRencanaJa->id_tingkat  = $_SESSION['kode_tk'];
                            $modelRencanaJa->id_kejati   = $_SESSION['kode_kejati'];
                            $modelRencanaJa->id_kejari   = $_SESSION['kode_kejari'];
                            $modelRencanaJa->id_cabjari  = $_SESSION['kode_cabjari'];
                            $modelRencanaJa->created_by=\Yii::$app->user->identity->id;
                            $modelRencanaJa->created_ip=$_SERVER['REMOTE_ADDR'];
                            $modelRencanaJa->created_time=date('Y-m-d H:i:s');
                            $modelRencanaJa->id_sp_was2=$model['id_sp_was2'];
                            $modelRencanaJa->id_ba_was2=$model['id_ba_was2'];
                            $modelRencanaJa->id_l_was2=$model['id_l_was2'];
                            $modelRencanaJa->id_was15=$model['id_was15'];
                            $modelRencanaJa->kategori_hukuman=$_POST['saran_ja'][$r];
                            $modelRencanaJa->jenis_hukuman=$_POST['hukuman_ja'][$r];
                            $modelRencanaJa->saran_dari='Jaksa Agung';
                            $modelRencanaJa->pasal=$_POST['pasal_ja'][$r];
                            $modelRencanaJa->sk=$_POST['sk_ja'][$r];
                            $modelRencanaJa->nip_terlapor=$_POST['nip_terlapor_ja'][$r];
                            $modelRencanaJa->nrp_terlapor=$_POST['nrp_terlapor_ja'][$r];
                            $modelRencanaJa->nama_terlapor=$_POST['nama_terlapor_ja'][$r];
                            $modelRencanaJa->pangkat_terlapor=$_POST['pangkat_terlapor_ja'][$r];
                            $modelRencanaJa->golongan_terlapor=$_POST['golongan_terlapor_ja'][$r];
                            $modelRencanaJa->jabatan_terlapor=$_POST['jabatan_terlapor_ja'][$r];
                            $modelRencanaJa->satker_terlapor=$_POST['satker_terlapor_ja'][$r];
                            $modelRencanaJa->save();
                            // print_r($modelRencanaJa);
                        }

                        // exit();

                $pejabat = $_POST['pejabat'];
                TembusanWas2::deleteAll(['from_table'=>'Was-15','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>strrev($model->id_was15),'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
                    for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-15';
                        $saveTembusan->pk_in_table = strrev($model->id_was15);
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

                  //  print_r($_POST['sk'][2][2]);
                  //  exit();
                    if($_POST['sk'][2][2] == 'SK-WAS2-A'){
                       $arr = array(ConstSysMenuComponent::Skwas2a);
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
                        $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                        $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                        $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                        $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                        $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                        $modelTrxPemrosesan->save();
                        // }
                      }

                    }else if($_POST['sk'][2][2] == 'SK-WAS2-B'){
                       $arr = array(ConstSysMenuComponent::Skwas2b);
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
                        $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                        $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                        $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                        $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                        $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                        $modelTrxPemrosesan->save();
                        // }
                      }

                    }else if($_POST['sk'][2][2] == 'SK-WAS2-C'){
                       $arr = array(ConstSysMenuComponent::Skwas2c);
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
                        $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                        $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                        $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                        $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                        $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                        $modelTrxPemrosesan->save();
                        // }
                      }

                    }else if($_POST['sk'][2][2] == 'SK-WAS3-A'){
                       $arr = array(ConstSysMenuComponent::Skwas3a);
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
                        $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                        $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                        $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                        $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                        $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                        $modelTrxPemrosesan->save();
                        // }
                      }

                    }else if($_POST['sk'][2][2] == 'SK-WAS3-B'){
                       $arr = array(ConstSysMenuComponent::Skwas3b);
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
                        $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                        $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                        $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                        $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                        $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                        $modelTrxPemrosesan->save();
                        // }
                      }

                    }else if($_POST['sk'][2][2] == 'SK-WAS3-C'){
                      $arr = array(ConstSysMenuComponent::Skwas3c);
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
                        $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                        $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                        $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                        $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                        $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                        $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                        $modelTrxPemrosesan->save();
                        // }
                      }
                    }else{
                      $arr = array(ConstSysMenuComponent::Was16b);
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

                      

                    }
            move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_15/'.$rename_file);
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
            return $this->redirect(['update']);
            } catch(Exception $e) {
                 Yii::$app->getSession()->setFlash('danger', [
                    'type' => 'danger', //String, can only be set to danger, success, warning, info, and growl
                    'duration' => 5000, //Integer //3000 default. time for growl to fade out.
                    'icon' => 'glyphicon glyphicon-ok-sign', //String
                    'message' => 'Data Gagal Disimpan', // String
                    'title' => 'Save', //String
                    'positonY' => 'top', //String // defaults to top, allows top or bottom
                    'positonX' => 'center', //String // defaults to right, allows right, center, left
                    'showProgressbar' => true,
                ]); 
                $transaction->rollback();
                if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTerlapor' => $modelTerlapor,
                'modelDetail' => $modelDetail,
                'modelTembusan' => $modelTembusan,
            ]);
        }
    // }else{
    //    $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was15-inspeksi/create"));
    //  }
    }
    public function actionGetobject(){
        $connection = \Yii::$app->db;
        $sql="select*from was.ms_sk where kode_category='".$_POST['id']."'";
        $result = $connection->createCommand($sql)->queryAll();
        
            echo "<option>-Pilih-</option>";
        foreach ($result as $key) {
            echo "<option value='".$key['isi_sk']."'>".$key['isi_sk']."</option>";
        }
    }

    public function actionGetdata(){
        $connection = \Yii::$app->db;
        $sql="select*from was.ms_sk where isi_sk='".$_POST['id']."'";
        $result = $connection->createCommand($sql)->queryOne();
       
            echo $result['pasal'].'#'.$result['kode_sk'];
    }

    public function actionGetpasal(){
        $connection = \Yii::$app->db;
        $sql="select*from was.ms_sk where isi_sk='".$_POST['id']."'";
        $result = $connection->createCommand($sql)->queryOne();
       
            echo $result['pasal'].'#'.$result['kode_sk'];


    }
    // public function viewpdf(){

    // }

    public function actionViewpdf(){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
        $file_upload=$this->findModel();
       //$file_upload=Was11::findOne(["id_was_15"=>$id]);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/was_15/'.$file_upload['upload_file'];
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

    public function actionCetakdocx(){
         $model = $this->findModel();
         $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
         
         $modelSpwas2=SpWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'trx_akhir'=>'1','id_sp_was2'=>$model->id_sp_was2]);

         $modelwas15rencanaP=Was15Rencana::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'id_was15'=>$model->id_was15, 'saran_dari'=>'Pemeriksa']);

         $modelwas15rencanaI=Was15Rencana::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'id_was15'=>$model->id_was15, 'saran_dari'=>'Inspektur']);

          $modelwas15rencanaJ=Was15Rencana::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4'],'id_was15'=>$model->id_was15, 'saran_dari'=>'Inspektur']);

         $modelTerlapor=LWas2Terlapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

         $modelTembusan=TembusanWas2::find()->where(['pk_in_table'=>$model->id_was15,'from_table'=>'Was-15','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])->orderBy('is_order desc')->all();
        return $this->render('cetak',[
                            'data_satker'=>$data_satker,
                            'model'=>$model,
                            'modelSpwas2'=>$modelSpwas2,
                            'modelTerlapor'=>$modelTerlapor,
                            'modelTembusan'=>$modelTembusan,
                            'modelwas15rencanaP'=>$modelwas15rencanaP,
                            'modelwas15rencanaI'=>$modelwas15rencanaI,
                            'modelwas15rencanaJ'=>$modelwas15rencanaJ,
                        ]);
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

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel()
    {
        if (($model = was15::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            //throw new NotFoundHttpException('The requested page does not exist.');
            return null;
        }
    }
}
