<?php

// namespace app\controllers;
namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;
use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\TerlaporSearch;

use app\modules\pengawasan\models\Kejagungunit;
use app\modules\pengawasan\models\KejagungunitSearch;


use app\modules\pengawasan\models\Kejati;
use app\modules\pengawasan\models\KejatiSearch;

use app\modules\pengawasan\models\Kejari;
use app\modules\pengawasan\models\KejariSearch;

use app\modules\pengawasan\models\Cabjari;
use app\modules\pengawasan\models\CabjariSearch;

use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\models\DisposisiInspektur;

use app\modules\pengawasan\models\WasStatuslapdu;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;
use yii\web\UploadedFile;
use Odf;
use app\components\GlobalFuncComponent; 
use yii\db\Query;
use yii\db\Command;



/**
 * LapduController implements the CRUD actions for Lapdu model.
 */
class IrmudController extends Controller
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
     * Lists all Lapdu models.
     * @return mixed
     */
    public function actionIndex()
    {
         $session = new Session();

         if(($session->get('was_register')) !=""){
        //     // $session->remove('id_perkara');
        //     // $session->remove('nomor_perkara');
        //     // $session->remove('tgl_perkara');
            $session->remove('was_register');

            
        }
        $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
            if($var[1]=='1'){
            $cek_irmud="c.irmud_pegasum_kepbang=TRUE";
            }else if($var[1]=='2'){
            $cek_irmud="c.irmud_pidum_datun=TRUE";
            }else if($var[1]=='3'){
            $cek_irmud="c.irmud_intel_pidsus=TRUE";
            }
        $searchModel = new LapduSearch();
       
        $connection = \Yii::$app->db;
        $query1="select distinct a.no_register,a.id_tingkat,a.id_kejati,a.id_kejari,a.id_cabjari,a.perihal_lapdu,a.created_time,e.tanggal_disposisi 
                  from was.lapdu a left join was.terlapor_awal b on a.no_register=b.no_register 
                  left join was.pelapor c on a.no_register=c.no_register and  A .id_tingkat = b .id_tingkat and A .id_kejati = b .id_kejati and A .id_kejari = b .id_kejari and A .id_cabjari = b .id_cabjari 
                  left join was.sumber_laporan d on c.id_sumber_laporan=d.id_sumber_laporan 
                  LEFT JOIN was.was_disposisi_inspektur e on b.no_urut=e.urut_terlapor and A .no_register = e .no_register and A .id_tingkat = e .id_tingkat and A .id_kejati = e .id_kejati and A .id_kejari = e .id_kejari and A .id_cabjari = e .id_cabjari 
                  where b.id_inspektur= '".$var[0]."' and e.tanggal_disposisi is not null order by a.created_time DESC";
        $query = $connection->createCommand($query1)->queryAll();

        return $this->render('index', [
            'searchModel' => $searchModel,
            // 'dataProvider' => $dataProvider,
            'query' => $query,
            
        ]);
        // }
    }

    /**
     * Displays a single Lapdu model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
         //if($_POST['action']=='Cetak'){
            //return $this->redirect(['view', 'id' => $model->no_register]);
            // $this->cetak();
            // unset($_POST['action']);
           // }
        return $this->render('view', [
            'model' => $this->findModel($id)

        ]);
    }

    /**
     * Creates a new Lapdu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionViewpdf($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
      $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
       // $file_upload=$this->findModel($id);
          $file_upload=DisposisiIrmud::findOne(["no_register"=>$id,"id_inspektur"=>$var[0],"id_irmud"=>$var[1],"id_tingkat"=>$id_tingkat, "id_kejati"=>$id_kejati, "id_kejari"=>$id_kejari,"id_cabjari"=>$id_cabjari]);
          $filepath = '../modules/pengawasan/upload_file/lapdu/irmud/'.$file_upload['file_irmud'];

        $extention=explode(".", $file_upload['file_irmud']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
              if(file_exists($filepath)){
               return Yii::$app->response->sendFile($filepath);
              }
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_irmud'] . '"');
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


    public function actionViewpdf1($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
      $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
      
        $file_upload=DisposisiInspektur::findOne(["no_register"=>$id,"id_inspektur"=>$var[0],"id_tingkat"=>$id_tingkat, "id_kejati"=>$id_kejati, "id_kejari"=>$id_kejari,"id_cabjari"=>$id_cabjari]);
         
          $filepath = '../modules/pengawasan/upload_file/lapdu/inspektur/'.$file_upload['file_inspektur'];
        $extention=explode(".", $file_upload['file_inspektur']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            if(file_exists($filepath)){
            return Yii::$app->response->sendFile($filepath);
            }
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_inspektur'] . '"');
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


    public function actionCreate($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari) {

    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
    $model = $this->findModel($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
    $modelTerlapor = new Terlapor();
    $modelDisposisi=new DisposisiIrmud();


        $queryBerupa = new Query;
        $queryBerupa->select("case when (b.id_sumber_laporan='13' or b.id_sumber_laporan='11') then coalesce(b.sumber_lainnya,a.nama_sumber_laporan) 
                                else (a.nama_sumber_laporan) end as nama_sumber_laporan,b.sumber_lainnya as sumberlain,
                                b.no_urut,b.id_tingkat,b.id_kejati,b.id_kejari,id_cabjari,b.no_register,b.id_sumber_laporan,b.nama_pelapor,b.alamat_pelapor,b.telp_pelapor,
                                b.email_pelapor,b.pekerjaan_pelapor,b.sumber_lainnya,
                                b.tempat_lahir_pelapor,b.tanggal_lahir_pelapor,b.kewarganegaraan_pelapor,b.agama_pelapor,b.pendidikan_pelapor,b.nama_kota_pelapor")
                ->from("was.sumber_laporan a")
                ->join("inner join","was.pelapor b","a.id_sumber_laporan = b.id_sumber_laporan")
                   ->where(['no_register'=>$id ,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari]);
        $pelapor = $queryBerupa->all();
        
         if($var[1]=='1'){
        $cek_irmud="f.irmud_pegasum_kepbang= :id_irmud";
        }else if($var[1]=='2'){
        $cek_irmud="f.irmud_pidum_datun= :id_irmud";
        }else if($var[1]=='3'){
        $cek_irmud="f.irmud_intel_pidsus= :id_irmud";
        }  

        $connection = \Yii::$app->db;
        $queryTerlapor1=new Query();
        $queryTerlapor2=new Query();
        $query=new Query();

        $query="select*from was.was_disposisi_inspektur where no_register='".$id."' and id_inspektur='".$var[0]."' and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."'and id_kejari='".$id_kejari."'and id_cabjari='".$id_cabjari."'";
        $modelDisposisi_ins=$connection->createCommand($query)->queryOne();

        
        $queryTerlapor1="select*from was.v_wilayah_pelanggaran where no_register='".$id."' and id_tingkat='".$id_tingkat."' 
                        and id_kejati='".$id_kejati."' and id_kejari='".$id_kejari."' and id_cabjari='".$id_cabjari."' and id_inspektur='".$var[0]."'";
        
        $queryTerlapor2 = $connection->createCommand($queryTerlapor1);
        $terlapor = $queryTerlapor2->queryAll();
        $OldFile=$terlapor[0]['file_irmud'];

       if ($model->load(Yii::$app->request->post())) {
          for ($riksa_pegasum=0; $riksa_pegasum < count($_POST['cek_1']); $riksa_pegasum++) { 
                $result.=$_POST['cek_1'][$riksa_pegasum];
            }
            for ($pegasum=0; $pegasum < count($_POST['cek_1']); $pegasum++) { 
                $result1.="0";
            }

            for ($riksa_kepbang=0; $riksa_kepbang < count($_POST['cek_2']); $riksa_kepbang++) { 
                $hasil.=$_POST['cek_2'][$riksa_kepbang];
            }

            for ($kepbang=0; $kepbang < count($_POST['cek_2']); $kepbang++) { 
                $hasil1.="0";
            }

            $arr_result=array($result);
            $arr_hasil=array($hasil);
            if (in_array($result1, $arr_result, TRUE) AND in_array($hasil1, $arr_hasil, TRUE)){
            // if($irmud1<=0 ){
              Yii::$app->getSession()->setFlash('success', [
              'type' => 'success',
              'duration' => 3000,
              'icon' => 'fa fa-users',
              'message' =>'Cekbox pada kolom pemeriksa harap di pilih',
              'title' => 'Harap Lengkapi Pengisian',
              'positonY' => 'top',
              'positonX' => 'center',
              'showProgressbar' => true,
          ]);
              return $this->render('update',[
              'model' => $model,
              'pelapor' => $pelapor,
              'terlapor' => $terlapor,
              'modelTerlapor' => $modelTerlapor,
              'modelDisposisi' => $modelDisposisi,
              'modelDisposisi_ins' => $modelDisposisi_ins,
              
          ]);
            }else{
            
                $errors       = array();
                $file_name    = $_FILES['file_irmud']['name'];
                $file_size    =$_FILES['file_irmud']['size'];
                $file_tmp     =$_FILES['file_irmud']['tmp_name'];
                $file_type    =$_FILES['file_irmud']['type'];
                $file_exists  =explode('.',$_FILES['file_irmud']['name']);
                $rename_file  =$var[0].$var[1].'_'.$id.'.'.$file_exists;
                $riksa        =$_POST['no_urut'];
            
            $no=1;
              for($j=0;$j<count($riksa);$j++){
                 for($i=0;$i<2;$i++){
                    $saveDisposisi = new DisposisiIrmud();
                  
                    $saveDisposisi->no_urut=$no;
                    $saveDisposisi->urut_terlapor =$_POST['no_urut'][$j];
                    $saveDisposisi->no_register =$id;
                    $saveDisposisi->id_tingkat =$_GET['id_tingkat'];
                    $saveDisposisi->id_kejati =$_GET['id_kejati'];
                    $saveDisposisi->id_kejari =$_GET['id_kejari'];
                    $saveDisposisi->id_cabjari =$_GET['id_cabjari'];
                    $saveDisposisi->id_pemeriksa =$_POST['cek_1'][$i];
                    $saveDisposisi->id_irmud =$var[1];
                    $saveDisposisi->file_irmud =($file_name==''?$OldFile:$rename_file);
                    $saveDisposisi->id_inspektur =$var[0];
                    if(!empty($_POST['tanggal_dis_inspektur'])){
                    $saveDisposisi->tanggal_disposisi =date('Y-m-d', strtotime($_POST['tanggal_dis_inspektur']));
                    }
                    $saveDisposisi->isi_disposisi =$_POST['isi_disposisi'];
                    $saveDisposisi->status ='LAPDU';
                    // $saveDisposisi->id_wilayah = 1;
                    // $saveDisposisi->id_level1  = 1;
                    // $saveDisposisi->id_level2  = 1;
                    // $saveDisposisi->id_level3  = 1;
                    // $saveDisposisi->id_level4  = 1;
                    $saveDisposisi->created_ip = $_SERVER['REMOTE_ADDR'];
                    $saveDisposisi->created_time = date('Y-m-d h:i:sa');
                    $saveDisposisi->created_by = \Yii::$app->user->identity->id;
                    $saveDisposisi->save();    
                    $no++;                            
                    }
                  }
                  move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'lapdu/irmud/'.$rename_file);

          return $this->redirect(['index']);
              }
        

       }else{
        return $this->render('create',[
              'model' => $model,
              'pelapor' => $pelapor,
              'terlapor' => $terlapor,
              'modelTerlapor' => $modelTerlapor,
              'modelDisposisi' => $modelDisposisi,
              'modelDisposisi_ins' => $modelDisposisi_ins,
              
          ]);
       }
    
    }


    public function actionUpdate($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari) {

    $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
	/*random kode*/
    $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $res = "";
    for ($i = 0; $i < 10; $i++) {
        $res .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    $query=DisposisiIrmud::findOne(['no_register'=>$id,'id_inspektur'=>$var[0],'id_irmud'=>$var[1]]);
   
    if($query<=0){
   /*Jika Data belum ada Maka Masuk ke Fundi Create*/
        $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/irmud/create?id=".$id."&id_tingkat=".$id_tingkat."&id_bidang=".$id_bidang."&id_kejati=".$id_kejati."&id_kejari=".$id_kejari."&id_cabjari=".$id_cabjari.""));
    }else{
   /*Jika Data belum ada Maka Masuk ke Fundi Create*/
     $model = $this->findModel($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
     $modelTerlapor = new Terlapor();
     
        $queryBerupa = new Query;
        $queryBerupa->select("case when (b.id_sumber_laporan='13' or b.id_sumber_laporan='11') then coalesce(b.sumber_lainnya,a.nama_sumber_laporan) 
                                else (a.nama_sumber_laporan) end as nama_sumber_laporan,b.sumber_lainnya as sumberlain,
                                b.no_urut,b.id_tingkat,b.id_kejati,b.id_kejari,id_cabjari,b.no_register,b.id_sumber_laporan,b.nama_pelapor,b.alamat_pelapor,b.telp_pelapor,
                                b.email_pelapor,b.pekerjaan_pelapor,b.sumber_lainnya,
                                b.tempat_lahir_pelapor,b.tanggal_lahir_pelapor,b.kewarganegaraan_pelapor,b.agama_pelapor,b.pendidikan_pelapor,b.nama_kota_pelapor")
                ->from("was.sumber_laporan a")
                ->join("inner join","was.pelapor b","a.id_sumber_laporan = b.id_sumber_laporan")
        ->where(['no_register'=>$id ,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari]);

        $pelapor = $queryBerupa->all();
        $connection = \Yii::$app->db;

        $queryTerlapor1=new Query();
        $queryTerlapor2=new Query();
        $query=new Query();
        $query_ins=new Query();

        $query_ins="select*from was.was_disposisi_inspektur where no_register='".$id."' and id_inspektur='".$var[0]."' and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."' and id_kejari='".$id_kejari."'and id_cabjari='".$id_cabjari."'";
        $modelDisposisi_ins=$connection->createCommand($query_ins)->queryOne();

        $query="select*from was.was_disposisi_irmud where no_register='".$id."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."'  and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."' and id_kejari='".$id_kejari."'and id_cabjari='".$id_cabjari."'";
        $modelDisposisi=$connection->createCommand($query)->queryOne();
        

        // $queryTerlapor1="select a.* from was.v_terlapor_pemeriksa a  where a.no_register='".$id."' and a.id_tingkat='".$id_tingkat."' and a.id_kejati='".$id_kejati."' and a.id_kejari='".$id_kejari."' and  a.id_cabjari='".$id_cabjari."' and
        //                   a.id_inspektur='".$var[0]."'";
        // $queryTerlapor2 = $connection->createCommand($queryTerlapor1);
        $queryTerlapor1="SELECT a.no_urut, a.no_register, a.nama_terlapor_awal, a.jabatan_terlapor_awal, 
              a.satker_terlapor_awal, a.pelanggaran_terlapor_awal, 
              a.tgl_pelanggaran_terlapor_awal, a.bln_pelanggaran_terlapor_awal, 
              a.thn_pelanggaran_terlapor_awal, a.id_inspektur, a.level1, a.level2, 
              a.level3, a.id_tingkat, a.id_kejati, a.id_kejari, a.id_cabjari, 
              a.id_wilayah, a.id_tingkat_kejadian, a.id_kejati_kejadian, 
              a.id_kejari_kejadian, a.id_cabjari_kejadian, a.id_wilayah_kejadian, 
              a.id_level1_kejadian, a.id_level2_kejadian, 
                  CASE
                      WHEN (( SELECT b.id_irmud
                         FROM was.was_disposisi_irmud b
                        WHERE b.no_register::text = a.no_register::text AND b.urut_terlapor = a.no_urut AND b.id_pemeriksa = 1 and b.id_irmud='".$var[1]."')) = 1 THEN 1
                      ELSE 0
                  END AS pemeriksa1, 
                  CASE
                      WHEN (( SELECT b.id_irmud
                         FROM was.was_disposisi_irmud b
                        WHERE b.no_register::text = a.no_register::text AND b.urut_terlapor = a.no_urut AND b.id_pemeriksa = 2 and b.id_irmud='".$var[1]."')) = 1 THEN 2
                      ELSE 0
                  END AS pemeriksa2
             FROM was.v_wilayah_pelanggaran a where a.no_register='".$id."' and a.id_tingkat='".$id_tingkat."' and a.id_kejati='".$id_kejati."' and a.id_kejari='".$id_kejari."' and  a.id_cabjari='".$id_cabjari."' and
                           a.id_inspektur='".$var[0]."'
            ORDER BY a.no_urut";
        $queryTerlapor2 = $connection->createCommand($queryTerlapor1);  
        $terlapor = $queryTerlapor2->queryAll();

        $OldFile=$terlapor[0]['file_irmud'];

       if ($model->load(Yii::$app->request->post())) {


            for ($riksa_pegasum=0; $riksa_pegasum < count($_POST['cek_1']); $riksa_pegasum++) { 
                $result.=$_POST['cek_1'][$riksa_pegasum];
            }
            for ($pegasum=0; $pegasum < count($_POST['cek_1']); $pegasum++) { 
                $result1.="0";
            }

            for ($riksa_kepbang=0; $riksa_kepbang < count($_POST['cek_2']); $riksa_kepbang++) { 
                $hasil.=$_POST['cek_2'][$riksa_kepbang];
            }

            for ($kepbang=0; $kepbang < count($_POST['cek_2']); $kepbang++) { 
                $hasil1.="0";
            }

            $arr_result=array($result);
            $arr_hasil=array($hasil);
            if (in_array($result1, $arr_result, TRUE) AND in_array($hasil1, $arr_hasil, TRUE)){
            // if($irmud1<=0 ){
              Yii::$app->getSession()->setFlash('success', [
              'type' => 'success',
              'duration' => 3000,
              'icon' => 'fa fa-users',
              'message' =>'Cekbox pada kolom pemeriksa harap di pilih',
              'title' => 'Harap Lengkapi Pengisian',
              'positonY' => 'top',
              'positonX' => 'center',
              'showProgressbar' => true,
          ]);
              return $this->render('update',[
              'model' => $model,
              'pelapor' => $pelapor,
              'terlapor' => $terlapor,
              'modelTerlapor' => $modelTerlapor,
              'modelDisposisi' => $modelDisposisi,
              'modelDisposisi_ins' => $modelDisposisi_ins,
              
          ]);
            }else{

             
				  $errors       = array();
				  $file_name    = $_FILES['was10_file']['name'];
				  $file_size    =$_FILES['was10_file']['size'];
				  $file_tmp     =$_FILES['was10_file']['tmp_name'];
				  $file_type    =$_FILES['was10_file']['type'];
				  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
				  $tmp = explode('.', $_FILES['was10_file']['name']);
				  $file_exists = end($tmp);
				  $rename_file  =$_SESSION['is_inspektur_irmud_riksa'].'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;

                

                  $riksa=$_POST['no_urut'];
                  $no=1;
                  $jml=0;
                  for($j=0;$j<count($riksa);$j++){
                      for($i=0;$i<2;$i++){
                        // echo $_POST['cek_1'][$jml];
                      $saveDisposisi = DisposisiIrmud::find()->where("no_register='".$id."' and id_tingkat='".$id_tingkat."' and id_kejati='".$id_kejati."' and id_kejari='".$id_kejari."' and id_cabjari='".$id_cabjari."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."' and  no_urut='".$no."'")->one();
                      $saveDisposisi->id_pemeriksa  =$_POST['cek_1'][$jml];
                      $saveDisposisi->file_irmud    =($file_name==''?$OldFile:$rename_file);
                      if(!empty($_POST['tanggal_dis_inspektur'])){
                        $saveDisposisi->tanggal_disposisi =date('Y-m-d', strtotime($_POST['tanggal_dis_inspektur']));
                      }
                      $saveDisposisi->isi_disposisi =$_POST['isi_disposisi'];
                      $saveDisposisi->update(); 
                      $no++;
                      $jml++;
                  }
                }
                // exit();
                    
                   move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'lapdu/irmud/'.$rename_file);


                   // if($saveDisposisi->tanggal_disposisi!=null){
                   //  WasTrxPemrosesan::deleteAll("no_register='".$id."' AND id_sys_menu='2003' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'"); //was-1
                   
                   //  $modelTrxPemrosesan=new WasTrxPemrosesan();
                   //  $modelTrxPemrosesan->no_register    =$saveDisposisi->no_register;
                   //  $modelTrxPemrosesan->id_sys_menu    ="2003";
                   //  $modelTrxPemrosesan->id_user_login  =$_SESSION['username'];
                   //  $modelTrxPemrosesan->durasi         =date('Y-m-d H:i:s');
                   //  $modelTrxPemrosesan->created_by     =\Yii::$app->user->identity->id;
                   //  $modelTrxPemrosesan->created_ip     =$_SERVER['REMOTE_ADDR'];
                   //  $modelTrxPemrosesan->created_time   =date('Y-m-d H:i:s');
                   //  $modelTrxPemrosesan->updated_ip     =$_SERVER['REMOTE_ADDR'];
                   //  $modelTrxPemrosesan->updated_by     =\Yii::$app->user->identity->id;
                   //  $modelTrxPemrosesan->updated_time   =date('Y-m-d H:i:s');
                   //  $modelTrxPemrosesan->user_id        =$_SESSION['is_inspektur_irmud_riksa'];
                   //  $modelTrxPemrosesan->save();
                   //  }
                           
          return $this->redirect(['index']);
        }
       }else{
        return $this->render('update',[
              'model' => $model,
              'pelapor' => $pelapor,
              'terlapor' => $terlapor,
              'modelTerlapor' => $modelTerlapor,
              'modelDisposisi' => $modelDisposisi,
              'modelDisposisi_ins' => $modelDisposisi_ins,
              
          ]);
       }
    }
    }

    /**
     * Finds the Lapdu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Lapdu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
        // if (($model = Lapdu::findOne($id)) !== null) {
        //     return $model;
        // } else {
        //     throw new NotFoundHttpException('The requested page does not exist.');
        // }

      if (($model = Lapdu::findOne(['no_register'=>$id,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPelapor($id)
    {
        if (($modelPelapor = Pelapor::findOne(['no_register'=>$id])) !== null) {
            return $modelPelapor;
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
	
	public function actionCekNoRegisterLapdu()
    {
        $noregister = str_replace(" ","",$_POST['no_register']); 
        $query = Lapdu::find()
        ->where(['REPLACE(no_register,\' \',\'\')' => $noregister])
        ->all();
        echo count($query);
    }
	
}
