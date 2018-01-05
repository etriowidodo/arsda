<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was27Klari;
use app\modules\pengawasan\models\Was27KlariSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pengawasan\models\TembusanWas27Klari;
use app\modules\pengawasan\models\TembusanWas2;/*mengambil tembusan dari transaksi*/
use app\modules\pengawasan\models\TembusanWas;/*mengambil tembusan dari master*/
use app\modules\pengawasan\models\Was27KlariDetail;
use app\modules\pengawasan\models\Was27Terlapor;
use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;
use app\modules\pengawasan\models\LWas1;
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\LWas1Saran;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\modules\pengawasan\components\FungsiComponent; 

use app\models\KpPegawai;
use Nasution\Terbilang;
use yii\db\Query;
use yii\db\Command;
use Odf;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Was27KlariController implements the CRUD actions for Was27Klari model.
 */
class Was27KlariController extends Controller
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
     * Lists all Was27Klari models.
     * @return mixed
     */
    public function actionIndex()
    {
         $query=Was27Klari::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-klari/update?id=".$query->id_was_27_klari));
        }else{
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-klari/create"));
        }

    }

    /**
     * Displays a single Was27Klari model.
     * @param string $id
     * @return mixed
     */
   

    /**
     * Creates a new Was27Klari model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $query=Was27Klari::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-klari/update?id=".$query->id_was_27_klari));
        }else{
        
        $model = new Was27Klari();
        $modelTembusanMaster = TembusanWas::findBySql("select * from was.was_tembusan_master where for_tabel='was_27_klari' or for_tabel='master'")->all();	
        $modelTerlapor = LWas1Saran::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'saran_lwas1'=>1,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelPelapor = Pelapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);

        $FungsiWas      =new FungsiComponent();
        $filter         ="no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $getId          =$FungsiWas->FunctGetIdSpwas1($filter);
        
        $modelLapdu          =Lapdu::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);


        if ($model->load(Yii::$app->request->post()) ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati = $_SESSION['kode_kejati'];
            $model->id_kejari = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register=$_SESSION['was_register'];
            $model->id_sp_was = $getId['id_sp_was1'];
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time = date('Y-m-d h:i:sa');
            $model->created_by = \Yii::$app->user->identity->id;
            //$model->updated_by = \Yii::$app->user->identity->id;

            if($model->save()){

                $pejabat = $_POST['pejabat'];
                 for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-27';
                        $saveTembusan->pk_in_table = strrev($model->id_was_27_klari);
                        $saveTembusan->tembusan = $_POST['pejabat'][$z];
                        $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                        $saveTembusan->created_time = date('Y-m-d H:i:s');
                        $saveTembusan->created_by = \Yii::$app->user->identity->id;
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

                 $rencana = $_POST['rencana'];
                 for($x=0;$x<count($rencana);$x++){
                      $modelWas27Detail=new Was27KlariDetail();
                      $modelWas27Detail->no_register = $_SESSION['was_register'];
                      $modelWas27Detail->id_tingkat  = $_SESSION['kode_tk'];
                      $modelWas27Detail->id_kejati   = $_SESSION['kode_kejati'];
                      $modelWas27Detail->id_kejari   = $_SESSION['kode_kejari'];
                      $modelWas27Detail->id_cabjari  = $_SESSION['kode_cabjari'];
                      $modelWas27Detail->id_was_27=$model->id_was_27_klari;
                      $modelWas27Detail->saran = $_POST['rencana'][$x];
                      $modelWas27Detail->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelWas27Detail->created_by=\Yii::$app->user->identity->id;
                      $modelWas27Detail->created_time=date('Y-m-d H:i:s');
                      $modelWas27Detail->save();
                    }

                 $jml_terlapor = $_POST['nip_terlapor'];
                 for($i=0;$i<count($jml_terlapor);$i++){
                    $terlapor=LWas1Saran::findOne(['nip_terlapor'=>$_POST['nip_terlapor'][$i]]);
                      $modelWas27Terlapor=new Was27Terlapor();
                      $modelWas27Terlapor->no_register = $_SESSION['was_register'];
                      $modelWas27Terlapor->id_tingkat  = $_SESSION['kode_tk'];
                      $modelWas27Terlapor->id_kejati   = $_SESSION['kode_kejati'];
                      $modelWas27Terlapor->id_kejari   = $_SESSION['kode_kejari'];
                      $modelWas27Terlapor->id_cabjari  = $_SESSION['kode_cabjari'];
                      $modelWas27Terlapor->id_was_27=$model->id_was_27_klari;
                      $modelWas27Terlapor->nip=$terlapor['nip_terlapor'];
                      $modelWas27Terlapor->nrp_pegawai_terlapor=$terlapor['nrp_terlapor'];
                      $modelWas27Terlapor->nama_pegawai_terlapor=$terlapor['nama_terlapor'];
                      $modelWas27Terlapor->pangkat_pegawai_terlapor=$terlapor['pangkat_terlapor'];
                      $modelWas27Terlapor->golongan_pegawai_terlapor=$terlapor['golongan_terlapor'];
                      $modelWas27Terlapor->jabatan_pegawai_terlapor=$terlapor['jabatan_terlapor'];
                      $modelWas27Terlapor->satker_pegawai_terlapor=$terlapor['satker_terlapor'];
                      $modelWas27Terlapor->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelWas27Terlapor->created_by=\Yii::$app->user->identity->id;
                      $modelWas27Terlapor->created_time=date('Y-m-d H:i:s');
                      $modelWas27Terlapor->save();
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
                    } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }

             return $this->redirect(['index']);
              
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelTembusanMaster' => $modelTembusanMaster,
                'modelTerlapor' => $modelTerlapor,
                'modelPelapor' => $modelPelapor,
                'modelLapdu' => $modelLapdu,
				// 'spwas1' => $spwas1,
            ]);
        }

    }
         
    }

    /**
     * Updates an existing Was27Klari model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    { 
        /*random kode*/
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }  
        
      $model = $this->findModel($id);
      $fungsi=new FungsiComponent();
      $is_inspektur_irmud_riksa =$fungsi->gabung_where();
        
        $modelTembusan=TembusanWas2::findAll(['pk_in_table'=>$model->id_was_27_klari,'from_table'=>'Was-27','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $connection = \Yii::$app->db;
        $sqlterlapor = "select nip as nip_terlapor, nrp_pegawai_terlapor as nrp_terlapor, nama_pegawai_terlapor as nama_terlapor, pangkat_pegawai_terlapor as pangkat_terlapor,
            golongan_pegawai_terlapor as golongan_terlapor,
            jabatan_pegawai_terlapor as jabatan_terlapor
             from was.was_27_detail_terlapor where no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'";
        $modelTerlapor = $connection->createCommand($sqlterlapor)->queryAll();

        $modelPelapor = Pelapor::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		$modelWas27Detail=Was27KlariDetail::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_27'=>$model->id_was_27_klari]);
        
        $OldFile=$model->upload_file_data;
         if ($model->load(Yii::$app->request->post()) ) {

              $errors       = array();
              $file_name    = $_FILES['upload_file_data']['name'];
              $file_size    =$_FILES['upload_file_data']['size'];
              $file_tmp     =$_FILES['upload_file_data']['tmp_name'];
              $file_type    =$_FILES['upload_file_data']['type'];
              $ext = pathinfo($file_name, PATHINFO_EXTENSION);
              $tmp = explode('.', $_FILES['upload_file_data']['name']);
              $file_exists = end($tmp);
              $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
            
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try {
                $model->updated_ip = $_SERVER['REMOTE_ADDR'];
                $model->updated_time = date('Y-m-d h:i:sa');
                $model->updated_by = \Yii::$app->user->identity->id;
                $model->upload_file_data = ($file_name==''?$OldFile:$rename_file);
            if($model->save()){
                if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_27_klari/'.$OldFile)) {
                      unlink(\Yii::$app->params['uploadPath'].'was_27_klari/'.$OldFile);
                  } 

                $pejabat =  $_POST['pejabat'];/*Untuk table tembusan*/
                    TembusanWas2::deleteAll(['from_table'=>'Was-27','no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'pk_in_table'=>$model->id_was_27_klari]);
                 for($z=0;$z<count($pejabat);$z++){
                        $saveTembusan = new TembusanWas2;
                        $saveTembusan->from_table = 'Was-27';
                        $saveTembusan->pk_in_table = strrev($model->id_was_27_klari);
                        $saveTembusan->tembusan = $_POST['pejabat'][$z];
                        $saveTembusan->created_ip = $_SERVER['REMOTE_ADDR'];
                        $saveTembusan->created_time = date('Y-m-d H:i:s');
                        $saveTembusan->created_by = \Yii::$app->user->identity->id;
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
                $rencana = $_POST['rencana'];
                    Was27KlariDetail::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_27'=>$model->id_was_27_klari]);
                 for($x=0;$x<count($rencana);$x++){
                      $modelWas27Detail=new Was27KlariDetail();
                      $modelWas27Detail->no_register = $_SESSION['was_register'];
                      $modelWas27Detail->id_tingkat  = $_SESSION['kode_tk'];
                      $modelWas27Detail->id_kejati   = $_SESSION['kode_kejati'];
                      $modelWas27Detail->id_kejari   = $_SESSION['kode_kejari'];
                      $modelWas27Detail->id_cabjari  = $_SESSION['kode_cabjari'];
                      $modelWas27Detail->id_was_27=$model->id_was_27_klari;
                      $modelWas27Detail->saran = $_POST['rencana'][$x];
                      $modelWas27Detail->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelWas27Detail->created_by=\Yii::$app->user->identity->id;
                      $modelWas27Detail->created_time=date('Y-m-d H:i:s');
                      $modelWas27Detail->save();
                    }

                 $jml_terlapor = $_POST['nip_terlapor'];
                    Was27Terlapor::deleteAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'], 'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_27'=>$model->id_was_27_klari]);
                 for($i=0;$i<count($jml_terlapor);$i++){
                    $terlapor=LWas1Saran::findOne(['nip_terlapor'=>$_POST['nip_terlapor'][$i]]);
                      $modelWas27Terlapor=new Was27Terlapor();
                      $modelWas27Terlapor->no_register = $_SESSION['was_register'];
                      $modelWas27Terlapor->id_tingkat  = $_SESSION['kode_tk'];
                      $modelWas27Terlapor->id_kejati   = $_SESSION['kode_kejati'];
                      $modelWas27Terlapor->id_kejari   = $_SESSION['kode_kejari'];
                      $modelWas27Terlapor->id_cabjari  = $_SESSION['kode_cabjari'];
                      $modelWas27Terlapor->id_was_27=$model->id_was_27_klari;
                      $modelWas27Terlapor->nip=$terlapor['nip_terlapor'];
                      $modelWas27Terlapor->nrp_pegawai_terlapor=$terlapor['nrp_terlapor'];
                      $modelWas27Terlapor->nama_pegawai_terlapor=$terlapor['nama_terlapor'];
                      $modelWas27Terlapor->pangkat_pegawai_terlapor=$terlapor['pangkat_terlapor'];
                      $modelWas27Terlapor->golongan_pegawai_terlapor=$terlapor['golongan_terlapor'];
                      $modelWas27Terlapor->jabatan_pegawai_terlapor=$terlapor['jabatan_terlapor'];
                      $modelWas27Terlapor->satker_pegawai_terlapor=$terlapor['satker_terlapor'];
                      $modelWas27Terlapor->created_ip=$_SERVER['REMOTE_ADDR'];
                      $modelWas27Terlapor->created_by=\Yii::$app->user->identity->id;
                      $modelWas27Terlapor->created_time=date('Y-m-d H:i:s');
                      $modelWas27Terlapor->save();
                    }
                
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
                move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_27_klari/'.$rename_file);
                $transaction->commit();
            return $this->redirect(['update', 'id' => $model->id_was_27_klari]);
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
              return $this->redirect(['update', 'id' => $model->id_was_27_klari]);
            }
           } catch(Exception $e) {

                    $transaction->rollback();
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelTembusan' => $modelTembusan,
                'modelTerlapor' => $modelTerlapor,
                'modelPelapor' => $modelPelapor,
				'modelWas27Detail' => $modelWas27Detail,
            ]);
        }
    }

    /**
     * Deletes an existing Was27Klari model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
       public function actionHapus($id)
    {
        Was27Klari::deleteAll("id_was_27_klari = '".$_GET['id']."'");

       
         // echo $_GET['id'];
         $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-klari/create"));
    }

    
    protected function PrintWas27($id){
       $model=$this->findModel($id);
       // $modelSpWas1=SpWas1::findOne(['no_register' => $model->no_register]);
       $modelPenghentian=PegawaiTerlapor::findBySql("select  b.nip as id_terlapor,b.nama_pegawai_terlapor,b.pangkat_pegawai_terlapor,b.golongan_pegawai_terlapor,b.jabatan_pegawai_terlapor  
from was.l_was_1_saran a
inner join was.pegawai_terlapor b on a.id_terlapor=b.id_pegawai_terlapor where a.no_register='".$model->no_register."'")->All();
       $modelLwas1=LWas1::findOne(['no_register' => $model->no_register]);
       $modelSpWas1=SpWas1::findOne(['no_register' => $model->no_register]);
       $modelPelapor=Pelapor::findAll(['no_register' => $model->no_register]);
       $modelPegawai=KpPegawai::findOne(['peg_nip_baru' => $_SESSION['nik_user']]);
       // $SaksiEksternal=SaksiEksternal::findAll(['no_register'=>$model->no_register,'from_table'=>'WAS-9']);
       // $SaksiInternal=SaksiInternal::findAll(['no_register'=>$model->no_register,'from_table'=>'WAS-9']);
       // $DasarSpwas1=DasarSpWas1::findAll(['id_sp_was1' => $modelSpWas1->id_sp_was1]);
       // $modelSatker=KpInstSatker::findOne(['inst_satkerkd' => $model->inst_satkerkd]);

       return $this->render('cetak',[
                        'model'=>$model,
                        'modelPenghentian'=>$modelPenghentian,
                        'modelLwas1'=>$modelLwas1,
                        'modelPelapor'=>$modelPelapor,
                        'modelPegawai'=>$modelPegawai,
                        'modelSpWas1'=>$modelSpWas1,
                ]);
    

     
    }

    public function actionCetak($id){
       $model=$this->findModel($id);
       // $modelSpWas1=SpWas1::findOne(['no_register' => $model->no_register]);
       $modelPenghentian=Was27Terlapor::findAll(['no_register' => $model->no_register]);
       $modelSaran=Was27KlariDetail::findAll(['no_register' => $model->no_register]);

       $modelLwas1=LWas1::findOne(['no_register' => $model->no_register]);
       $modelSpWas1=SpWas1::findOne(['no_register' => $model->no_register]);
       $modelPelapor=Pelapor::findAll(['no_register' => $model->no_register]);
       $modelPegawai=KpPegawai::findOne(['peg_nip_baru' => $_SESSION['nik_user']]);
       // $SaksiEksternal=SaksiEksternal::findAll(['no_register'=>$model->no_register,'from_table'=>'WAS-9']);
       // $SaksiInternal=SaksiInternal::findAll(['no_register'=>$model->no_register,'from_table'=>'WAS-9']);
       // $DasarSpwas1=DasarSpWas1::findAll(['id_sp_was1' => $modelSpWas1->id_sp_was1]);
       // $modelSatker=KpInstSatker::findOne(['inst_satkerkd' => $model->inst_satkerkd]);

       return $this->render('cetak',[
                        'model'=>$model,
                        'modelPenghentian'=>$modelPenghentian,
                        'modelSaran'=>$modelSaran,
                        'modelLwas1'=>$modelLwas1,
                        'modelPelapor'=>$modelPelapor,
                        'modelPegawai'=>$modelPegawai,
                        'modelSpWas1'=>$modelSpWas1,
                ]);
    

     
    }


    public function actionViewpdf($id_was_27_klari){

       $file_upload=$this->findModel($id_was_27_klari);
          $filepath = '../modules/pengawasan/upload_file/was_27_klari/'.$file_upload['upload_file_data'];
          $nama_file=$file_upload['upload_file_data'];
    
       
        $extention=explode(".", $nama_file);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $nama_file . '"');
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


    public function actionGetttd(){
  
   $searchModelWas27 = new Was27KlariSearch();
   $dataProviderPenandatangan = $searchModelWas27->searchPenandatangan(Yii::$app->request->queryParams);
   Pjax::begin(['id' => 'Mpenandatangan-tambah-grid', 'timeout' => false,'formSelector' => '#searchFormPenandatangan','enablePushState' => false]);
   echo GridView::widget([
                      'dataProvider'=> $dataProviderPenandatangan,
                      // 'filterModel' => $searchModel,
                      // 'layout' => "{items}\n{pager}",
                      'columns' => [
                          ['header'=>'No',
                          'headerOptions'=>['style'=>'text-align:center;'],
                          'contentOptions'=>['style'=>'text-align:center;'],
                          'header'=>'No',
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
     * Finds the Was27Klari model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Was27Klari the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was27Klari::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_was_27_klari'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
