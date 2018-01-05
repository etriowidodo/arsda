<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\DipaMaster;
use app\modules\pengawasan\models\DipaMasterSearch;
use app\modules\pengawasan\models\LWas2Inspeksi;
use app\modules\pengawasan\models\LWas2InspeksiTtd;
use app\modules\pengawasan\models\LWas2Terlapor;
use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\SaksiInternalInspeksi;
use app\modules\pengawasan\models\SaksiEksternalInspeksi;
use app\modules\pengawasan\components\FungsiComponent; 
use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
//use app\modules\pengawasan\models\LWas2InspeksiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class LWas2InspeksiController extends Controller
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
       $query=LWas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],
                                      'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                                      'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                                      'id_wilayah'=>$_SESSION['was_id_wilayah'],
                                      'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                                      'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
       
        if(count($query)>0){
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/l-was2-inspeksi/update?id=".$query->id_l_was2));
        }else{
          $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/l-was2-inspeksi/create"));
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

    public function actionViewpdf($id){

       $result_file_name=$this->findModel($id);
       // print_r($result_file_name['bawas3_file']);
       // exit();
          $filepath = '../modules/pengawasan/upload_file/l_was_2_inspeksi/'.$result_file_name['file_l_was_2'];

        $extention=explode(".", $result_file_name['file_l_was_2']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png' and file_exists($filepath)){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $result_file_name['file_l_was_2'] . '"');
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
        // $query=Was27Klari::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        // if(count($query)>0){
        //   $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was27-klari/update?id=".$query->id_was_27_klari));
        // }else{
        $fungsi   =new FungsiComponent();
        $where    =$fungsi->static_where_alias('a');
        
        $model = new LWas2Inspeksi();
        $modelPelapor  = Pelapor::findAll(['no_register'=>$_SESSION['was_register'],
                                            'id_tingkat'=>$_SESSION['kode_tk'],
                                            'id_kejati'=>$_SESSION['kode_kejati'],
                                            'id_kejari'=>$_SESSION['kode_kejari'],
                                            'id_cabjari'=>$_SESSION['kode_cabjari']]);
         $modelLapdu  = Lapdu::findAll(['no_register'=>$_SESSION['was_register'],
                                            'id_tingkat'=>$_SESSION['kode_tk'],
                                            'id_kejati'=>$_SESSION['kode_kejati'],
                                            'id_kejari'=>$_SESSION['kode_kejari'],
                                            'id_cabjari'=>$_SESSION['kode_cabjari']]);
        // print_r($modelLapdu);
        // exit();

        $connection = \Yii::$app->db;
         $query = "select a.* from was.ba_was_2_inspeksi a
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."'  $where";
        $modelBawas2 = $connection->createCommand($query)->queryOne();

        // print_r($modelBawas2);
        // exit();
        $query1 = "select a.*,b.* from was.was9_inspeksi a
                    inner join was.saksi_internal_inspeksi b
                    on a.id_tingkat = b.id_tingkat and
                    a.id_kejati = b.id_kejati and
                    a.id_kejari = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_saksi_internal = b.id_saksi_internal and
                    a.id_wilayah = b.id_wilayah and
                    a.id_level1 = b.id_level1 and
                    a.id_level2 = b.id_level2 and
                    a.id_level3 = b.id_level3 and
                    a.id_level4 = b.id_level4 and 
                    a.no_register=b.no_register
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.trx_akhir='1'  $where";
        $modelInternal = $connection->createCommand($query1)->queryAll();

        $query2 = "select a.*,b.* from was.was9_inspeksi a
                    inner join was.saksi_eksternal_inspeksi b
                    on a.id_tingkat = b.id_tingkat and
                    a.id_kejati = b.id_kejati and
                    a.id_kejari = b.id_kejari and
                    a.id_cabjari = b.id_cabjari and
                    a.id_saksi_eksternal = b.id_saksi_eksternal and
                    a.id_wilayah = b.id_wilayah and
                    a.id_level1 = b.id_level1 and
                    a.id_level2 = b.id_level2 and
                    a.id_level3 = b.id_level3 and
                    a.id_level4 = b.id_level4 and 
                    a.no_register=b.no_register
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.trx_akhir='1'  $where ";
        $modelEksternal = $connection->createCommand($query2)->queryAll();

        // $query3=" select * from was.was10_inspeksi a 
        //         inner join was.sp_was_2 b on a.id_sp_was2=b.id_sp_was2 
        //         and a.no_register=b.no_register 
        //         where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
        //         and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
        //         and a.id_cabjari='".$_SESSION['kode_cabjari']."'
        //         and b.trx_akhir='1'  $where";
        $query3="select a.*, b.peg_nrp as nrp_pegawai_terlapor  from was.was10_inspeksi a inner join kepegawaian.kp_pegawai b on a.nip_pegawai_terlapor=b.peg_nip_baru where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                 and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                 and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                 and a.trx_akhir='1'  $where";
        $modelTerlapor = $connection->createCommand($query3)->queryAll(); 
        

        $query4="select a.*,b.*,b.pasal,a.category_sk||'-'||b.isi_sk as sk from was.ms_category_sk a 
                 inner join was.ms_sk b on a.kode_category=b.kode_category 
                 ";
        $modelHukdis = $connection->createCommand($query4)->queryAll();       

        if ($model->load(Yii::$app->request->post()) ) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            $model->id_tingkat = $_SESSION['kode_tk'];
            $model->id_kejati  = $_SESSION['kode_kejati'];
            $model->id_kejari  = $_SESSION['kode_kejari'];
            $model->id_cabjari = $_SESSION['kode_cabjari'];
            $model->no_register= $_SESSION['was_register'];
            $model->id_ba_was2 = $modelBawas2['id_ba_was2'];
            $model->id_sp_was2 = $modelBawas2['id_sp_was2'];
            //$model->id_sp_was  = $getId['id_sp_was1'];
            $model->created_ip = $_SERVER['REMOTE_ADDR'];
            $model->created_time= date('Y-m-d h:i:sa');
            $model->created_by = \Yii::$app->user->identity->id;
            //$model->updated_by = \Yii::$app->user->identity->id;

            if($model->save()){
            /*print_r($model);
            exit();*/

                $saran = $_POST['saran'];
                 for($z=0;$z<count($saran);$z++){
                        $saveTerlapor = new LWas2Terlapor;
                        $saveTerlapor->id_ba_was2 = $model->id_ba_was2;
                        $saveTerlapor->id_sp_was2 = $model->id_sp_was2;
                        $saveTerlapor->id_l_was2  = $model->id_l_was2;
                        $saveTerlapor->no_register= $_SESSION['was_register'];
                        $saveTerlapor->id_tingkat = $_SESSION['kode_tk'];
                        $saveTerlapor->id_kejati  = $_SESSION['kode_kejati'];
                        $saveTerlapor->id_kejari  = $_SESSION['kode_kejari'];
                        $saveTerlapor->id_cabjari = $_SESSION['kode_cabjari'];
                        $saveTerlapor->saran_l_was_2    = $_POST['saran'][$z];
                        $saveTerlapor->pendapat_l_was_2 = $_POST['saranP'][$z];
                        $saveTerlapor->bentuk_pelanggaran= $_POST['bentuk_pelanggaran'][$z];
                        $saveTerlapor->saran_pasal    = $_POST['hukdis'][$z];
                        $saveTerlapor->pendapat_pasal = $_POST['hukdisP'][$z];
                        $saveTerlapor->nip_terlapor = $_POST['nip'][$z];
                        $saveTerlapor->nrp_terlapor = $_POST['nrp'][$z];
                        $saveTerlapor->nama_terlapor= $_POST['nama'][$z];
                        $saveTerlapor->pangkat_terlapor = $_POST['pangkat'][$z];
                        $saveTerlapor->golongan_terlapor= $_POST['golongan'][$z];
                        $saveTerlapor->jabatan_terlapor = $_POST['jabatan'][$z];
                        $saveTerlapor->satker_terlapor  = $_POST['satker'][$z];
                        $saveTerlapor->created_ip   = $_POST['REMOTE_ADDR'];
                        $saveTerlapor->created_time = date('Y-m-d H:i:s');
                        $saveTerlapor->created_by   = \Yii::$app->user->identity->id;
                        // print_r($saveTerlapor->save());
                        // exit();    
                        $saveTerlapor->save();
                    }

                     $ttd = $_POST['nama_ttd'];
                 for($z=0;$z<count($ttd);$z++){
                        $saveTtd = new LWas2InspeksiTtd;
                        $saveTtd->id_ba_was2 = $model->id_ba_was2;
                        $saveTtd->id_sp_was2 = $model->id_sp_was2;
                        $saveTtd->id_l_was2  = $model->id_l_was2;
                        $saveTtd->no_register= $_SESSION['was_register'];
                        $saveTtd->id_tingkat = $_SESSION['kode_tk'];
                        $saveTtd->id_kejati  = $_SESSION['kode_kejati'];
                        $saveTtd->id_kejari  = $_SESSION['kode_kejari'];
                        $saveTtd->id_cabjari = $_SESSION['kode_cabjari'];
                        $saveTtd->nip_penandatangan  = $_POST['nip_ttd'][$z];
                        $saveTtd->nama_penandatangan = $_POST['nama_ttd'][$z];
                        $saveTtd->pangkat_penandatangan  = $_POST['pangkat_ttd'][$z];
                        $saveTtd->golongan_penandatangan = $_POST['golongan_ttd'][$z];
                        $saveTtd->jabatan_penandatangan  = $_POST['jabatan_ttd'][$z];
                        $saveTtd->id_sp_was2   = $_POST['id_sp_was2_ttd'][$z];
                        $saveTtd->created_ip   = $_POST['REMOTE_ADDR'];
                        $saveTtd->created_time = date('Y-m-d H:i:s');
                        $saveTtd->created_by   = \Yii::$app->user->identity->id;
                        // print_r($saveTtd->save());
                        // exit();    
                        $saveTtd->save();
                    }

                    $arr = array(ConstSysMenuComponent::Was27Inspek, ConstSysMenuComponent::Was14bInspek , ConstSysMenuComponent::Was14dInspek);      
            //$arr = array(ConstSysMenuComponent::Was27Inspek);
                    for ($i=0; $i < 3 ; $i++) { 
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
            }
                    } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
            }

             return $this->redirect(['index']);
              
         } else {
            return $this->render('create', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelHukdis' => $modelHukdis,
               // 'modelTembusanMaster' => $modelTembusanMaster,
                'modelPelapor' => $modelPelapor,
                'modelTerlapor' => $modelTerlapor,
                'modelInternal' => $modelInternal,
                'modelEksternal' => $modelEksternal,
                //'modelLapdu' => $modelLapdu,
                // 'spwas1' => $spwas1,
            ]);
         }
         
    }
    public function actionGetsaran(){
        $connection = \Yii::$app->db;
     //   echo $_POST['id'];
        $query4="select a.* from was.ms_sk a where kode_sk='".$_POST['id']."'";
        $modelHukdis2 = $connection->createCommand($query4)->queryAll();  
        echo"Pasal<br>"; 
        echo"<select class=\"form-control pasal1\">";
         foreach ($modelHukdis2 as $rowHukdis) {
            echo "<option>".$rowHukdis['pasal']."</option>";
            }
        echo"</select>";    
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
        //$id = $_POST['update_id_ba_was_3'];
        $model = $this->findModel($id);
        
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
        $no_reg=$_SESSION['was_register'];
        $OldFile=$model->file_l_was_2;    
        // print_r($model['id_ba_was2']);
        // exit();

        $connection = \Yii::$app->db;
        $query3=" select*from was.l_was_2_terlapor a 
                where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                and a.id_ba_was2='".$model['id_ba_was2']."'  $where";
        $modelTerlaporUpd = $connection->createCommand($query3)->queryAll();  
        // print_r($modelTerlaporUpd);
        // exit();
        
        $query4="select a.*,b.*,b.pasal,a.category_sk||'-'||b.isi_sk as sk from was.ms_category_sk a 
                 inner join was.ms_sk b on a.kode_category=b.kode_category 
                 ";
        $modelHukdisUpd = $connection->createCommand($query4)->queryAll(); 

        $queryTtd="select a.* from was.l_was_2_inspeksi_ttd a 
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.id_ba_was2='".$model['id_ba_was2']."' and a.id_l_was2='".$model['id_l_was2']."'  $where  
                 ";
        $modelPenandatangan = $connection->createCommand($queryTtd)->queryAll(); 

         if ($model->load(Yii::$app->request->post())) {
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            

            $file_name    = $_FILES['file_l_was_2']['name'];
            $file_size    = $_FILES['file_l_was_2']['size'];
            $file_tmp     = $_FILES['file_l_was_2']['tmp_name'];
            $file_type    = $_FILES['file_l_was_2']['type'];
            $ext = pathinfo($file_name, PATHINFO_EXTENSION);
            $tmp = explode('.', $_FILES['file_l_was_2']['name']);
            $file_exists = end($tmp);
            $rename_file = $is_inspektur_irmud_riksa.'_'.$model->id_ba_was2.'_'.$res.'.'.$ext;

            // $model->updated_by = $_SERVER['REMOTE_ADDR'];
            // $model->updated_time = date('Y-m-d H:i:s');
            // $model->updated_ip = \Yii::$app->user->identity->id;
            // $model->id_tingkat = $_SESSION['kode_tk'];
            // $model->id_kejati  = $_SESSION['kode_kejati'];
            // $model->id_kejari  = $_SESSION['kode_kejari'];
            // $model->id_cabjari = $_SESSION['kode_cabjari'];
            // $model->no_register= $_SESSION['was_register']; 
             $model->file_l_was_2 = ($file_name==''?$OldFile:$rename_file);           

            
            //    print_r($model->save());
            // exit();
            if($model->save()){

            // print_r($model->save());
            // exit();
                
            if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'l_was_2_inspeksi/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'l_was_2_inspeksi/'.$OldFile);
            }   
                // print_r($_POST['bentuk_pelanggaran']);
                // exit();
                $saran = $_POST['saran'];
                // print_r($model->id_l_was2);
                // exit();
                LWas2Terlapor::deleteAll(["id_l_was2" =>$model->id_l_was2]);
                 for($z=0;$z<count($saran);$z++){
                        $saveTerlapor = new LWas2Terlapor;
                        $saveTerlapor->id_ba_was2 = $model->id_ba_was2;
                        $saveTerlapor->id_sp_was2 = $model->id_sp_was2;
                        $saveTerlapor->id_l_was2  = $model->id_l_was2;
                        $saveTerlapor->no_register= $_SESSION['was_register'];
                        $saveTerlapor->id_tingkat = $_SESSION['kode_tk'];
                        $saveTerlapor->id_kejati  = $_SESSION['kode_kejati'];
                        $saveTerlapor->id_kejari  = $_SESSION['kode_kejari'];
                        $saveTerlapor->id_cabjari = $_SESSION['kode_cabjari'];
                        $saveTerlapor->bentuk_pelanggaran= $_POST['bentuk_pelanggaran'][$z];
                        $saveTerlapor->saran_l_was_2    = $_POST['saran'][$z];
                        $saveTerlapor->pendapat_l_was_2 = $_POST['saranP'][$z];
                        $saveTerlapor->saran_pasal    = $_POST['hukdis'][$z];
                        $saveTerlapor->pendapat_pasal = $_POST['hukdisP'][$z];
                        $saveTerlapor->nip_terlapor = $_POST['nip'][$z];
                        $saveTerlapor->nrp_terlapor = $_POST['nrp'][$z];
                        $saveTerlapor->nama_terlapor= $_POST['nama'][$z];
                        $saveTerlapor->pangkat_terlapor = $_POST['pangkat'][$z];
                        $saveTerlapor->golongan_terlapor= $_POST['golongan'][$z];
                        $saveTerlapor->jabatan_terlapor = $_POST['jabatan'][$z];
                        $saveTerlapor->satker_terlapor  = $_POST['satker'][$z];
                        $saveTerlapor->created_ip   = $_POST['REMOTE_ADDR'];
                        $saveTerlapor->created_time = date('Y-m-d H:i:s');
                        $saveTerlapor->created_by   = \Yii::$app->user->identity->id;
                        // print_r($saveTerlapor->save());
                        // exit();    
                        $saveTerlapor->save();
                    }

                LWas2InspeksiTtd::deleteAll(["id_ba_was2" =>$model->id_ba_was2]);
                $ttd = $_POST['nama_ttd'];
                // print_r($_POST['nama_ttd'][0]);
                // print_r(count($_POST['nama_ttd']));
                // exit();
                 for($z=0;$z<count($ttd);$z++){
                        $saveTtd = new LWas2InspeksiTtd;
                        $saveTtd->id_ba_was2 = $model->id_ba_was2;
                        $saveTtd->id_sp_was2 = $model->id_sp_was2;
                        $saveTtd->id_l_was2  = $model->id_l_was2;
                        $saveTtd->no_register= $_SESSION['was_register'];
                        $saveTtd->id_tingkat = $_SESSION['kode_tk'];
                        $saveTtd->id_kejati  = $_SESSION['kode_kejati'];
                        $saveTtd->id_kejari  = $_SESSION['kode_kejari'];
                        $saveTtd->id_cabjari = $_SESSION['kode_cabjari'];
                        $saveTtd->nip_penandatangan  = $_POST['nip_ttd'][$z];
                        $saveTtd->nama_penandatangan = $_POST['nama_ttd'][$z];
                        $saveTtd->pangkat_penandatangan  = $_POST['pangkat_ttd'][$z];
                        $saveTtd->golongan_penandatangan = $_POST['golongan_ttd'][$z];
                        $saveTtd->jabatan_penandatangan  = $_POST['jabatan_ttd'][$z];
                        $saveTtd->id_sp_was2   = $_POST['id_sp_was2_ttd'][$z];
                        $saveTtd->created_ip   = $_POST['REMOTE_ADDR'];
                        $saveTtd->created_time = date('Y-m-d H:i:s');
                        $saveTtd->created_by   = \Yii::$app->user->identity->id;
                        // print_r($saveTtd->save());
                        // exit();    
                        $saveTtd->save();
                    }

            $arr = array(ConstSysMenuComponent::Was27Inspek, ConstSysMenuComponent::Was14bInspek , ConstSysMenuComponent::Was14dInspek);      
            //$arr = array(ConstSysMenuComponent::Was27Inspek);
                    for ($i=0; $i < 3 ; $i++) { 
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
                 move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'l_was_2_inspeksi/'.$rename_file);        

            
                
                return $this->redirect(['index']);  
                } catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
                }
                
        }else{
           return $this->render('update', [
                        'model' => $model,
                        'modelTerlaporUpd' => $modelTerlaporUpd,
                        'modelHukdisUpd'=>$modelHukdisUpd,
                        'modelPenandatangan'=>$modelPenandatangan,
                    ]);
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

    public function actionCetak($id)
    {
        $model = $this->findModel($id);
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $connection = \Yii::$app->db;
        $queryP="select a.*,b.* from was.l_was_2_terlapor a
                left join was.ms_sk b on a.pendapat_pasal=b.kode_sk
                where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                and a.id_l_was2='".$model['id_l_was2']."'  $where";
        $modelDetilP = $connection->createCommand($queryP)->queryAll(); 

        $queryS="select a.*,b.* from was.l_was_2_terlapor a
                left join was.ms_sk b on a.saran_pasal=b.kode_sk
                where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                and a.id_l_was2='".$model['id_l_was2']."'  $where";
        $modelDetilS = $connection->createCommand($queryS)->queryAll();  
        // print_r($modelDetil);
        // exit();
        $query_spwas2="select a.* from was.sp_was_2 a where a.no_register='".$_SESSION['was_register']."' and 
          a.id_tingkat='".$_SESSION['kode_tk']."' 
          and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
          and a.id_cabjari='".$_SESSION['kode_cabjari']."' and a.id_sp_was2='".$model['id_sp_was2']."' $where";
        $modelSpWas2 = $connection->createCommand($query_spwas2)->queryOne();
        // print_r($modelSpWas2);
        // exit();
       $query_pemeriksa="select a.* from was.pemeriksa_sp_was2 a 
                         where a.no_register='".$_SESSION['was_register']."'  
                            and a.id_tingkat='".$_SESSION['kode_tk']."' 
                            and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                            and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $modelPemriksa = $connection->createCommand($query_pemeriksa)->queryAll();

        $query3=" select a.*,b.* from was.was10_inspeksi a
                left join was.pegawai_terlapor_was10_inspeksi b 
                on a.id_pegawai_terlapor=b.id_pegawai_terlapor
                and a.no_register=b.no_register
                and a.id_tingkat=b.id_tingkat
                and a.id_kejati=b.id_kejati
                and a.id_kejari=b.id_kejari
                and a.id_cabjari=b.id_cabjari
                and a.id_wilayah=b.id_wilayah
                and a.id_level1=b.id_level1
                and a.id_level2=b.id_level2
                and a.id_level3=b.id_level3
                and a.id_level4=b.id_level4 
                where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                and a.trx_akhir='1'  $where";
        $modelTerlapor = $connection->createCommand($query3)->queryAll(); 

        $queryTtd="select a.* from was.l_was_2_inspeksi_ttd a 
                    where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' 
                    and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' 
                    and a.id_cabjari='".$_SESSION['kode_cabjari']."'
                    and a.id_ba_was2='".$model['id_ba_was2']."' and a.id_l_was2='".$model['id_l_was2']."'  $where  
                 ";
        $modelPenandatangan = $connection->createCommand($queryTtd)->queryAll(); 



        $tglLwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_l_was_2']);
        $tgl_spwas2=\Yii::$app->globalfunc->ViewIndonesianFormat($modelSpWas2['tanggal_sp_was2']);


          return $this->render('cetak',[
                    'model'=>$model,
                    'modelDetilP'=>$modelDetilP,
                    'modelDetils'=>$modelDetilS,
                    'data_satker'=>$data_satker,
                    'tglLwas2'=>$tglLwas2,
                    'tgl_spwas2'=>$tgl_spwas2,
                    'modelPemriksa'=>$modelPemriksa,
                    'modelTerlapor'=>$modelTerlapor,
                    'modelSpWas2'=>$modelSpWas2,
                    'modelPenandatangan'=>$modelPenandatangan,
                    ]);
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
         if (($model = LWas2Inspeksi::findOne(['no_register'=>$_SESSION['was_register'],
                'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],
                'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],
                'id_l_was2'=>$id,'id_wilayah'=>$_SESSION['was_id_wilayah'],
                'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],
                'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
        
      //  if (($model = BaWas3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
