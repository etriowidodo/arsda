<?php

// namespace app\controllers;
namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;
use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\TerlaporSearch;
use app\models\MsWarganegara;
use yii\helpers\ArrayHelper;

use app\modules\pengawasan\models\Kejagungunit;
use app\modules\pengawasan\models\KejagungunitSearch;


use app\modules\pengawasan\models\Kejati;
use app\modules\pengawasan\models\KejatiSearch;

use app\modules\pengawasan\models\Kejari;
use app\modules\pengawasan\models\KejariSearch;
use app\modules\pengawasan\models\DisposisiInspektur;
use app\modules\pengawasan\models\Cabjari;
use app\modules\pengawasan\models\CabjariSearch;
use app\models\KpInstSatkerSearch;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;
use yii\web\UploadedFile;
use Odf;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use yii\db\Query;
use yii\db\Command;



/**
 * LapduController implements the CRUD actions for Lapdu model.
 */
class LapduController extends Controller
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

        $searchModel = new LapduSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        // $dataProvider->pagination->pageSize = 15;
        $connection = \Yii::$app->db;
        $query1 = "select distinct a.id_tingkat,a.id_kejati,a.id_kejari,a.id_cabjari,a.no_register,a.perihal_lapdu,a.tgl_disposisi,a.created_time
                    from was.lapdu a order by a.created_time DESC";
        $query = $connection->createCommand($query1)->queryAll();
        // print_r($query);
        // exit();


        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'query' => $query,
            
        ]);
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
    public function actionCreate()
    {
        $tgl=['Tanggal','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        $bln=['Bulan','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
        $thn=['Tahun','2016','2015','2014','2013','2012','2011','2010','2009','2008','2007','2006','2005','2004','2003','2002','2001'];
		//$thn=['2016','2015','2014'];

        $model = new Lapdu();
        $modelPelapor = new Pelapor();
        $modelTerlapor = new Terlapor();
		$searchModelBidang = new KejagungunitSearch();
        $searchModelKejati = new KejatiSearch();
        $searchModelKejari = new KejariSearch();
        $searchModelCabjari = new CabjariSearch();


		
		//warganegara danar	
		     $warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
		
		
		     $dataProvider = $searchModelBidang->search(Yii::$app->request->queryParams);
         $dataProvider->pagination->pageSize = 5;

         $dataProviderKejati = $searchModelKejati->search(Yii::$app->request->queryParams);
         $dataProviderKejati->pagination->pageSize = 5;

         $dataProviderKejari = $searchModelKejari->search(Yii::$app->request->queryParams);
         $dataProviderKejari->pagination->pageSize = 5;

         $dataProviderCabjari = $searchModelCabjari->search(Yii::$app->request->queryParams);
         $dataProviderCabjari->pagination->pageSize = 5;
//echo $dataProvider['pangkat'];exit;
         // 

        if ($model->load(Yii::$app->request->post())) {
				
				$model->kepada_lapdu= ucwords($_POST['Lapdu']['kepada_lapdu']);
				$model->tembusan_lapdu= ucwords($_POST['Lapdu']['tembusan_lapdu']);
            // if (empty($_POST['Lapdu']['tanggal_surat_lapdu'])) {
                $model->tanggal_surat_lapdu = $_POST['surat_tanggal'];
              // } else {
              //   $model->tanggal_surat_lapdu = date('Y-m-d', strtotime($_POST['tmp']));
              // }
			  
				$model->created_ip = $_SERVER['REMOTE_ADDR'];
				$model->created_time = date('Y-m-d h:i:sa');
				//$model->updated_ip = $_SERVER['REMOTE_ADDR'];
				$model->created_by = \Yii::$app->user->identity->id;
				//$model->updated_by = \Yii::$app->user->identity->id;
				
            if (empty($_POST['Lapdu']['tanggal_surat_diterima'])) {
                $model->tanggal_surat_diterima = date('Y-m-d h:i:sa');
              } else {
                $model->tanggal_surat_diterima = date('Y-m-d', strtotime($_POST['Lapdu']['tanggal_surat_diterima']));
              }
            $files = \yii\web\UploadedFile::getInstance($model,'file_lapdu');
            if ($files != false) {
                $model->file_lapdu = $files->name;
            }
            /*tambahan kang putut 29-03-2017*/
             $model->id_tingkat = $_SESSION['kode_tk'];
             $model->id_kejati  = $_SESSION['kode_kejati'];
             $model->id_kejari  = $_SESSION['kode_kejari'];
             $model->id_cabjari = $_SESSION['kode_cabjari'];
             

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();

             /*print_r($model);
            exit();*/
          try {

            if($model->save()){
            // }

            /*insert pelapor*/
            $nikPelapor = $_POST['txt_sumber'];
            $nomor = 1;
            for($i=0;$i<count($nikPelapor);$i++){
            $savePelapor = new Pelapor();
            $savePelapor->no_urut = $nomor;
            $savePelapor->no_register = $model->no_register;
            $savePelapor->nama_pelapor = ucwords($_POST['nama'][$i]);
            $savePelapor->alamat_pelapor = ucwords($_POST['alamat'][$i]);
            $savePelapor->email_pelapor = $_POST['email'][$i];
			      $lsm = ucwords($_POST['sumberlainya'][$i]);
            $savePelapor->sumber_lainnya = $lsm;
            // $savePelapor->tgl_lahir = date('Y-m-d',strtotime($_POST['tgl_lahir'][$i]));
            $savePelapor->telp_pelapor = $_POST['no_telepon'][$i];
            $savePelapor->pekerjaan_pelapor = ucwords($_POST['pekerjaan'][$i]);
            $savePelapor->id_sumber_laporan = $_POST['txt_sumber'][$i];
            // penambahan req pa putut
            $savePelapor->tempat_lahir_pelapor = ucwords($_POST['tempat_lahir'][$i]);
            if(!empty($_POST['tgl_lahir'][$i])){
            $savePelapor->tanggal_lahir_pelapor =date('Y-m-d',strtotime($_POST['tgl_lahir'][$i]));
            }
            $savePelapor->kewarganegaraan_pelapor = $_POST['warga'][$i];
            $savePelapor->agama_pelapor = $_POST['agama'][$i];
            $savePelapor->pendidikan_pelapor = $_POST['pendidikan'][$i];
            $savePelapor->nama_kota_pelapor = ucwords($_POST['kota'][$i]);
             /*tambahan kang putut 29-03-2017*/
             $savePelapor->id_tingkat = $_SESSION['kode_tk'];
             $savePelapor->id_kejati  = $_SESSION['kode_kejati'];
             $savePelapor->id_kejari  = $_SESSION['kode_kejari'];
             $savePelapor->id_cabjari = $_SESSION['kode_cabjari'];
             $savePelapor->created_ip = $_SERVER['REMOTE_ADDR'];
             $savePelapor->created_time = date('Y-m-d h:i:sa');
             $savePelapor->created_by = \Yii::$app->user->identity->id;
			
            $savePelapor->save();
            $nomor++;
            }

            /*insert terlapor*/
            $no_terlapor = 1;
            $nikTerlapor = $_POST['satkerTerlapor'];
            for($j=0;$j<count($nikTerlapor);$j++){
            $saveTerlapor = new Terlapor();
            $saveTerlapor->no_urut = $no_terlapor;
            $saveTerlapor->no_register = $model->no_register;
            $saveTerlapor->nama_terlapor_awal = ucwords($_POST['namaTerlapor'][$j]);
            $saveTerlapor->jabatan_terlapor_awal = ucwords($_POST['jabatanTerlapor'][$j]);
            $saveTerlapor->satker_terlapor_awal = ucwords($_POST['satkerTerlapor'][$j]);

            $saveTerlapor->pelanggaran_terlapor_awal = $_POST['pelanggaranTerlapor'][$j];
            // $saveTerlapor->tgl_lahir = date('Y-m-d',strtotime($_POST['tgl_lahir'][$j]));
            $saveTerlapor->tgl_pelanggaran_terlapor_awal = $_POST['tgl'][$j];
            $saveTerlapor->bln_pelanggaran_terlapor_awal = $_POST['bln'][$j];
            $saveTerlapor->thn_pelanggaran_terlapor_awal = $_POST['thn'][$j];
            // $saveTerlapor->id_wilayah_kejadian = $_POST['wilayahTerlapor'][$j];
            $saveTerlapor->level_was = 'inspektur';

           if($_POST['wilayahTerlapor'][$j]=='0'){
            /*simpan ke bagian kejaksaan agung*/
            $saveTerlapor->id_wilayah_kejadian = 1;
            $saveTerlapor->id_level1_kejadian =  $_POST['bidang'][$j];
            $saveTerlapor->id_level2_kejadian = $_POST['unit'][$j];

            $saveTerlapor->id_tingkat_kejadian='0';
            $saveTerlapor->id_kejati_kejadian =  '0';
            $saveTerlapor->id_kejari_kejadian = '00';
            $saveTerlapor->id_cabjari_kejadian = '00';
            }else  if($_POST['wilayahTerlapor'][$j]=='1'){
            /*simpan ke bagian kejaksaan kejati*/
            $saveTerlapor->id_kejati_kejadian =  $_POST['bidang'][$j];
            $saveTerlapor->id_kejari_kejadian = '00';
            $saveTerlapor->id_cabjari_kejadian = '00';

            $saveTerlapor->id_tingkat_kejadian='1';
            $saveTerlapor->id_wilayah_kejadian = 0;
            $saveTerlapor->id_level1_kejadian = 0;
            $saveTerlapor->id_level2_kejadian = 0;
            }else if($_POST['wilayahTerlapor'][$j]=='2'){
            /*simpan ke bagian kejaksaan kejari*/
            $saveTerlapor->id_kejati_kejadian =  $_POST['bidang'][$j];
            $saveTerlapor->id_kejari_kejadian = $_POST['unit'][$j];
            $saveTerlapor->id_cabjari_kejadian = '00';

            $saveTerlapor->id_tingkat_kejadian='2';
            $saveTerlapor->id_wilayah_kejadian = 0;
            $saveTerlapor->id_level1_kejadian = 0;
            $saveTerlapor->id_level2_kejadian = 0;
            }else if($_POST['wilayahTerlapor'][$j]=='3'){
            /*simpan ke bagian kejaksaan cabjari*/
            $saveTerlapor->id_kejati_kejadian =  $_POST['bidang'][$j];
            $saveTerlapor->id_kejari_kejadian =  $_POST['unit'][$j];
            $saveTerlapor->id_cabjari_kejadian = $_POST['cabjari'][$j];

            $saveTerlapor->id_tingkat_kejadian='3';
            $saveTerlapor->id_wilayah_kejadian = 0;
            $saveTerlapor->id_level1_kejadian = 0;
            $saveTerlapor->id_level2_kejadian = 0;
            }

			/*tambahan kang putut 29-03-2017*/
             $saveTerlapor->id_tingkat = $_SESSION['kode_tk'];
             $saveTerlapor->id_kejati  = $_SESSION['kode_kejati'];
             $saveTerlapor->id_kejari  = $_SESSION['kode_kejari'];
             $saveTerlapor->id_cabjari = $_SESSION['kode_cabjari'];

             $saveTerlapor->created_ip = $_SERVER['REMOTE_ADDR'];
             $saveTerlapor->created_time = date('Y-m-d h:i:sa');
             $saveTerlapor->created_by = \Yii::$app->user->identity->id;

            $saveTerlapor->id_inspektur = $_POST['inspektur'][$j];
            $saveTerlapor->save();
            $no_terlapor++;
            }
            
            if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'lapdu/'.$files->name;
                    $files->saveAs($path);
                }
            $transaction->commit();
           //    if($_POST['print']=='1'){
           // //   unset($_POST['action']);
           // // $this->redirect('lapdu/view?id=r001');
           //  $this->cetak($model->no_register);

           // }
            return $this->redirect('index');
            }else{
             Yii::$app->getSession()->setFlash('success', [
              'type' => 'success',
              'duration' => 3000,
              'icon' => 'fa fa-users',
              'message' => 'Data Lapdu Gagal Di simpan',
              'title' => 'Simpan Data',
              'positonY' => 'top',
              'positonX' => 'center',
              'showProgressbar' => true,
          ]);
            }
                } catch (Exception $e) {
                $transaction->rollback();
              }

        } else {
            return $this->render('create', [
                'model' => $model,
                'modelPelapor' => $modelPelapor,
                'modelTerlapor' =>  $modelTerlapor,
				'dataProvider' => $dataProvider,
                'dataProviderKejati' => $dataProviderKejati,
                'dataProviderKejari' => $dataProviderKejari,
                'dataProviderCabjari' => $dataProviderCabjari,
                'tgl' => $tgl,
                'bln' => $bln,
                'thn' => $thn,
				'warganegara'       => $warganegara,
            ]);
        }
    }

    /**
     * Updates an existing Lapdu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {   
        
        $tgl=['Tanggal','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16','17','18','19','20','21','22','23','24','25','26','27','28','29','30','31'];
        $bln=['Bulan','Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','Nopember','Desember'];
        $thn=['Tahun','2016','2015','2014'];
        $modelTerlapor = new Terlapor();
        // Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/upload_file/lapdu/';
        $searchModelBidang = new KejagungunitSearch();
        $searchModelKejati = new KejatiSearch();
        $searchModelKejari = new KejariSearch();
        $searchModelCabjari = new CabjariSearch();
        $key = $id;
        $session = Yii::$app->session; 
        $session->remove('was_register');
        $session->set('was_register', $key);

        $model = $this->findModel($no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
       /* print_r($model);
        exit();*/
        $oldFile=$model->file_lapdu;
		    $oldFile1=$model->file_disposisi;
        $queryBerupa = new Query;
    
        $connection = \Yii::$app->db;
        $queryPelapor="select a.*,c.nama as nameWn,
                        case WHEN b.id_sumber_laporan='13' THEN
                        a.sumber_lainnya 
                        WHEN b.id_sumber_laporan='11' THEN
                        'LSM ' || a.sumber_lainnya 
                        ELSE
                        b.nama_sumber_laporan
                        end
                        as nama_sumber_laporan
                        from
                        was.pelapor a inner join was.sumber_laporan b on a.id_sumber_laporan = b.id_sumber_laporan
                        left join public.ms_warganegara c on a.kewarganegaraan_pelapor=c.id::text   
                        where a.no_register='".$no_register."' and a.id_tingkat='".$id_tingkat."' 
                        and a.id_kejati='".$id_kejati."' and a.id_kejari='".$id_kejari."' and a.id_cabjari='".$id_cabjari."'
                        ";          
        $pelapor = $connection->createCommand($queryPelapor)->queryAll();

        $queryTerlapor="select*from was.v_wilayah_pelanggaran where no_register='".$no_register."' and id_tingkat='".$id_tingkat."' 
                        and id_kejati='".$id_kejati."' and id_kejari='".$id_kejari."' and id_cabjari='".$id_cabjari."'";
        $terlapor = $connection->createCommand($queryTerlapor)->queryAll(); 
        // print_r($terlapor);
        // exit();  
		if($_GET['no_register'] != null){
            $modelPelapor = Pelapor::findOne(['no_register' => $_GET['no_register'],'id_tingkat' => $_GET['id_tingkat'],'id_kejati' => $_GET['id_kejati'],'id_kejari' => $_GET['id_kejari'],'id_cabjari' => $_GET['id_cabjari']]);
        }else{
            $modelPelapor = new Pelapor();
        }
		// //warganegara danar	
		$warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
       
         $dataProvider = $searchModelBidang->search(Yii::$app->request->queryParams);
         $dataProvider->pagination->pageSize = 5;

         $dataProviderKejati = $searchModelKejati->search(Yii::$app->request->queryParams);
         $dataProviderKejati->pagination->pageSize = 5;

         $dataProviderKejari = $searchModelKejari->search(Yii::$app->request->queryParams);
         $dataProviderKejari->pagination->pageSize = 5;

         $dataProviderCabjari = $searchModelCabjari->search(Yii::$app->request->queryParams);
         $dataProviderCabjari->pagination->pageSize = 5;
      
        if ($model->load(Yii::$app->request->post())) {
				$model->kepada_lapdu= ucwords($_POST['Lapdu']['kepada_lapdu']);
				$model->tembusan_lapdu= ucwords($_POST['Lapdu']['tembusan_lapdu']);
                if (empty($_POST['Lapdu']['tanggal_surat_diterima'])) {
                    $model->tanggal_surat_diterima = date('Y-m-d');
                  } else {
                    $model->tanggal_surat_diterima = date('Y-m-d', strtotime($_POST['Lapdu']['tanggal_surat_diterima']));
                  }

                // if (empty($_POST['Lapdu']['tanggal_surat_lapdu'])) {
                //     $model->tanggal_surat_lapdu = date('Y-m-d');
                //   } else {
                //     $model->tanggal_surat_lapdu = date('Y-m-d', strtotime($_POST['Lapdu']['tanggal_surat_lapdu']));
                //   }
                  $model->tanggal_surat_lapdu = $_POST['surat_tanggal'];

                $files = \yii\web\UploadedFile::getInstance($model, 'file_lapdu');
                if ($files != false) {
                    $model->file_lapdu = $files->name;
                }else{
                    $model->file_lapdu = $oldFile;
                }
				
				$files1 = \yii\web\UploadedFile::getInstance($model, 'file_disposisi');
                if ($files1 != false) {
                    $model->file_disposisi = $files1->name;
                }else{
                    $model->file_disposisi = $oldFile1;
                }
				
                
             $model->id_tingkat = $_SESSION['kode_tk'];
             $model->id_kejati  = $_SESSION['kode_kejati'];
             $model->id_kejari  = $_SESSION['kode_kejari'];
             $model->id_cabjari = $_SESSION['kode_cabjari'];
             $model->created_ip = $_SERVER['REMOTE_ADDR'];
             $model->created_time = date('Y-m-d h:i:sa');
             $model->created_by = \Yii::$app->user->identity->id;
			       $model->updated_ip = $_SERVER['REMOTE_ADDR'];
			       $model->updated_time = date('Y-m-d h:i:sa');
			       $model->updated_by = \Yii::$app->user->identity->id;
             $connection = \Yii::$app->db;
             $transaction = $connection->beginTransaction();
			
          try {
            if($model->save()){
            
/* print_r(date('Y-m-d'));
exit(); */
/*=========================================================Simpan Ke table Detail===========================================================================*/
            $nikPelapor = $_POST['txt_sumber'];
            // Pelapor::deleteAll("no_register = '".$id."',id_wilayah = '".$id_wilayah."',id_bidang = '".$id_bidang."',id_unit = '".$id_unit."'");
            $no_pelapor = 1;
            Pelapor::deleteAll(['no_register' => $no_register,'id_tingkat' => $id_tingkat,'id_kejati' => $id_kejati,'id_kejari' => $id_kejari,'id_cabjari' => $id_cabjari]);
            for($i=0;$i<count($nikPelapor);$i++){
            $modelPelapor = new Pelapor();
            $modelPelapor->no_urut = $no_pelapor;
            $modelPelapor->no_register = $model->no_register;
            $modelPelapor->nama_pelapor = ucwords($_POST['nama'][$i]);
            $modelPelapor->alamat_pelapor = ucwords($_POST['alamat'][$i]);
            $modelPelapor->email_pelapor = $_POST['email'][$i];

            $modelPelapor->sumber_lainnya = ucwords($_POST['sumberlainya'][$i]);
            // $modelPelapor->tgl_lahir = date('Y-m-d',strtotime($_POST['tgl_lahir'][$i]));
            $modelPelapor->telp_pelapor = $_POST['no_telepon'][$i];
            $modelPelapor->pekerjaan_pelapor = ucwords($_POST['pekerjaan'][$i]);
            $modelPelapor->id_sumber_laporan = $_POST['txt_sumber'][$i];
            // penambahan req pa putut
            $modelPelapor->tempat_lahir_pelapor = ucwords($_POST['tempat_lahir'][$i]);
			
			
			
            if(!empty($_POST['tgl_lahir'][$i])){
            $modelPelapor->tanggal_lahir_pelapor = date('Y-m-d',strtotime($_POST['tgl_lahir'][$i]));
             }
            $modelPelapor->kewarganegaraan_pelapor = $_POST['warga'][$i];
            $modelPelapor->agama_pelapor = $_POST['agama'][$i];
            $modelPelapor->pendidikan_pelapor = $_POST['pendidikan'][$i];
            $modelPelapor->nama_kota_pelapor = ucwords($_POST['kota'][$i]);
            $modelPelapor->id_tingkat = $_SESSION['kode_tk'];
            $modelPelapor->id_kejati  = $_SESSION['kode_kejati'];
            $modelPelapor->id_kejari  = $_SESSION['kode_kejari'];
            $modelPelapor->id_cabjari = $_SESSION['kode_cabjari'];
            $modelPelapor->created_ip = $_SERVER['REMOTE_ADDR'];
            $modelPelapor->created_time = date('Y-m-d h:i:sa');
            $modelPelapor->created_by = \Yii::$app->user->identity->id;

            
            $modelPelapor->save();
            $no_pelapor++;
            }

            $no_terlapor = 1;
            $nipTerlapor = $_POST['satkerTerlapor'];
            Terlapor::deleteAll(['no_register' => $no_register,'id_tingkat' => $id_tingkat,'id_kejati' => $id_kejati,'id_kejari' => $id_kejari,'id_cabjari' => $id_cabjari]);
            for($j=0;$j<count($nipTerlapor);$j++){
            $modelTerlapor = new Terlapor();
            $modelTerlapor->no_urut = $no_terlapor;
            $modelTerlapor->no_register = $model->no_register;
            $modelTerlapor->nama_terlapor_awal = ucwords($_POST['namaTerlapor'][$j]);
            $modelTerlapor->jabatan_terlapor_awal = ucwords($_POST['jabatanTerlapor'][$j]);
            $modelTerlapor->satker_terlapor_awal = ucwords($_POST['satkerTerlapor'][$j]);

            $modelTerlapor->pelanggaran_terlapor_awal = $_POST['pelanggaranTerlapor'][$j];
            // $modelTerlapor->tgl_lahir = date('Y-m-d',strtotime($_POST['tgl_lahir'][$j]));
            $modelTerlapor->tgl_pelanggaran_terlapor_awal = $_POST['tgl'][$j];
            $modelTerlapor->bln_pelanggaran_terlapor_awal = $_POST['bln'][$j];
            $modelTerlapor->thn_pelanggaran_terlapor_awal = $_POST['thn'][$j];
            // $modelTerlapor->id_wilayah_kejadian = $_POST['wilayahTerlapor'][$j];
            $modelTerlapor->level_was = 'inspektur';
            
            if($_POST['wilayahTerlapor'][$j]=='0'){
            /*simpan ke bagian kejaksaan agung*/
            $modelTerlapor->id_wilayah_kejadian=1;
            $modelTerlapor->id_level1_kejadian =  $_POST['bidang'][$j];
            $modelTerlapor->id_level2_kejadian =  $_POST['unit'][$j];

            $modelTerlapor->id_tingkat_kejadian='0';
            $modelTerlapor->id_kejati_kejadian =  '00';
            $modelTerlapor->id_kejari_kejadian = '00';
            $modelTerlapor->id_cabjari_kejadian = '00';
            }else  if($_POST['wilayahTerlapor'][$j]=='1'){
            /*simpan ke bagian kejaksaan kejati*/
            $modelTerlapor->id_tingkat_kejadian='1';
            $modelTerlapor->id_kejati_kejadian =  $_POST['bidang'][$j];
            $modelTerlapor->id_kejari_kejadian = '00';
            $modelTerlapor->id_cabjari_kejadian = '00';

            $modelTerlapor->id_wilayah_kejadian= 0;
            $modelTerlapor->id_level1_kejadian = 0;
            $modelTerlapor->id_level2_kejadian = 0;
            }else if($_POST['wilayahTerlapor'][$j]=='2'){
            /*simpan ke bagian kejaksaan kejari*/
            $modelTerlapor->id_tingkat_kejadian='2';
            $modelTerlapor->id_kejati_kejadian =  $_POST['bidang'][$j];
            $modelTerlapor->id_kejari_kejadian =  $_POST['unit'][$j];
            $modelTerlapor->id_cabjari_kejadian = '00';

            $modelTerlapor->id_wilayah_kejadian= 0;
            $modelTerlapor->id_level1_kejadian = 0;
            $modelTerlapor->id_level2_kejadian = 0;
            }else if($_POST['wilayahTerlapor'][$j]=='3'){
            /*simpan ke bagian kejaksaan cabjari*/
            $modelTerlapor->id_tingkat_kejadian='3';
            $modelTerlapor->id_kejati_kejadian =  $_POST['bidang'][$j];
            $modelTerlapor->id_kejari_kejadian =  $_POST['unit'][$j];
            $modelTerlapor->id_cabjari_kejadian = $_POST['cabjari'][$j];

            $modelTerlapor->id_wilayah_kejadian= 0;
            $modelTerlapor->id_level1_kejadian = 0;
            $modelTerlapor->id_level2_kejadian = 0;
            }
            
		    $modelTerlapor->id_wilayah = $_SESSION['id_wilayah'];
          
            $modelTerlapor->id_tingkat = $_SESSION['kode_tk'];
            $modelTerlapor->id_kejati  = $_SESSION['kode_kejati'];
            $modelTerlapor->id_kejari  = $_SESSION['kode_kejari'];
            $modelTerlapor->id_cabjari = $_SESSION['kode_cabjari'];
            $modelTerlapor->created_ip = $_SERVER['REMOTE_ADDR'];
            $modelTerlapor->created_time = date('Y-m-d h:i:sa');
            $modelTerlapor->created_by = \Yii::$app->user->identity->id;




            $modelTerlapor->id_inspektur = $_POST['inspektur'][$j];
            
        
            $modelTerlapor->save();
            $no_terlapor++;
 
            }


/*=================================================================end Simpan Ke table Detail===========================================================*/            
/*======================================================================Move File Upload================================================================*/
           if ($files != false) {
                    $path = \Yii::$app->params['uploadPath'].'lapdu/'.$files->name;
                    $files->saveAs($path);
                }
			
			if ($files1 != false) {
                    $path1 = \Yii::$app->params['uploadPath'].'lapdu/disposisi_jamwas/'.$files1->name;
                    $files1->saveAs($path1);
                }			
/*===================================================================End Move File Upload================================================================*/
            $transaction->commit();
            
            // Yii::$app->getSession()->setFlash('success', [
            //      'type' => 'success',
            //      'duration' => 3000,
            //      'icon' => 'fa fa-users',
            //      'message' => 'Data Berhasil di Simpan',
            //      'title' => 'Simpan Data',
            //      'positonY' => 'top',
            //      'positonX' => 'center',
            //      'showProgressbar' => true,
            //  ]);

           if($_POST['print']=='1'){
           //   unset($_POST['action']);
           // $this->redirect('lapdu/view?id=r001');
            $this->cetak($model->no_register);

           }
            return $this->redirect('index');
/*===================================================================simpan sukses=============================================================*/            
            }else{
             Yii::$app->getSession()->setFlash('success', [
              'type' => 'success',
              'duration' => 3000,
              'icon' => 'fa fa-users',
              'message' => 'Data Lapdu Gagal Di simpan',
              'title' => 'Simpan Data',
              'positonY' => 'top',
              'positonX' => 'center',
              'showProgressbar' => true,
          ]);
            }
/*================================================================Rollback transaksi====================================================================*/            
                } catch (Exception $e) {
                $transaction->rollback();
              }
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelPelapor' => $modelPelapor,
                'modelTerlapor' => $modelTerlapor,
                'pelapor' => $pelapor,
                'terlapor' => $terlapor,
                'dataProvider' => $dataProvider,
                'dataProviderKejati' => $dataProviderKejati,
                'dataProviderKejari' => $dataProviderKejari,
                'dataProviderCabjari' => $dataProviderCabjari,
                'tgl' => $tgl,
                'bln' => $bln,
                'thn' => $thn,
				'warganegara'       => $warganegara,
            ]);
        }
    }

    /**
     * Deletes an existing Lapdu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id=$_POST['id'];
        $jml=$_POST['jml'];
        $check=explode(",",$id);
      /*  echo $id.$jml; */
        // $modelPelapor = new Pelapor();
        // $modelTerlapor = new Terlapor();
        for ($i=0; $i <$jml ; $i++) { 
        
            Pelapor::deleteAll("no_register = '".$check[$i]."'");
            Terlapor::deleteAll("no_register = '".$check[$i]."'");
            Lapdu::deleteAll("no_register = '".$check[$i]."'");
    }
         return $this->redirect(['index']);


    }
	public function actionWn() {
        $searchModel= new MsWarganegara();
        $dataProvider= $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->pagination->pageSize = 7;
        return $this->renderAjax('_wn',[
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
        ]);
    }
    
    public function actionViewpdf($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
       $file_upload=$this->findModel($id,$_SESSION['kode_tk'],$_SESSION['kode_kejati'],$_SESSION['kode_kejari'],$_SESSION['kode_cabjari']);
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/lapdu/'.$file_upload['file_lapdu'];
        $extention=explode(".", $file_upload['file_lapdu']);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
            return Yii::$app->response->sendFile($filepath);
           }else{
          if(file_exists($filepath))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload['file_lapdu'] . '"');
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
	
	 public function actionViewpdf1($id){
      // echo  \Yii::$app->params['uploadPath'].'lapdu/230017577_116481.pdf';
        // echo 'cms_simkari/modules/pengawasan/upload_file/lapdu/230017577_116481.pdf';
      // $filename = $_GET['filename'] . '.pdf';
      
       $file_upload1=$this->findModel($id,$_SESSION['kode_tk'],$_SESSION['kode_kejati'],$_SESSION['kode_kejari'],$_SESSION['kode_cabjari']);
       // $no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari
        // print_r($file_upload['file_lapdu']);
          $filepath1 = '../modules/pengawasan/upload_file/lapdu/disposisi_jamwas/'.$file_upload1['file_disposisi'];
        $extention1=explode(".", $file_upload1['file_disposisi']);
           if($extention1[1]=='jpg' || $extention1[1]=='jpeg' || $extention1[1]=='png'){
            return Yii::$app->response->sendFile($filepath1);
           }else{
          if(file_exists($filepath1))
          {
              // Set up PDF headers
              header('Content-type: application/pdf');
              header('Content-Disposition: inline; filename="' . $file_upload1['file_disposisi'] . '"');
              header('Content-Transfer-Encoding: binary');
              header('Content-Length: ' . filesize($filepath1));
              header('Accept-Ranges: bytes');

              // Render the file
              readfile($filepath1);
          }
          else
          {
             // PDF doesn't exist so throw an error or something
          }
      }
      
    }
	
	

    public function actionKejagung(){
      $id=$_POST['id'];
	  $query = new Query;
        $connection = \Yii::$app->db;
                        $query1 = "select * from was.kejagung_bidang a 
                                        inner join was.wilayah_inspektur b on a.id_kejagung_bidang=b.id_kejati 
                                        inner join was.kejagung_unit c on a.id_kejagung_bidang=c.id_kejagung_bidang 
                                where b.id_wilayah='0' and a.id_kejagung_bidang='".$id."' order by b.id_kejati";
        $result = $connection->createCommand($query1)->queryAll();
      
     echo "<table class='table table-bordered' id='tbl_bidang'>
            <thead>
              <tr>
                <th width='3%'>No</th>
                <th>Unit Kerja</th>
                <th width='4%' style='text-align:center'>Pilih</th>
              </tr>
            </thead>
            <tbody>";
            $no=1;
            foreach ($result as $key) {
          echo"<tr>
                <td style='text-align:center'>".$no."</td>
                <td>".$key['nama_kejagung_unit']."</td>
                <td style='text-align:center'><input class='td_kejagung' type='checkbox' name='ck_pilih' rel='". $key['id_kejagung_bidang']."' nmbidang='". $key['akronim']. "' idunit='".$key['id_kejagung_unit']."' nmunit='". $key['nama_kejagung_unit']."' idinspektur='". $key['id_inspektur'] ."'></td>
              </tr>";
              $no++;
            }
    //$('.td').click(function(){<a href='#' class='td' rel='". $key['id_kejagung_unit']."' nunit='". $key['nama_kejagung_unit']."'><i class='glyphicon glyphicon-ok'></i></a>

        echo"</tbody
     </table>
     <script>
     $('#tbl_bidang').dataTable({'aLengthMenu': [[10, 15, 20, -1], [10, 15, 20, 'All']],
        'iDisplayLength': 10}); 
    $(document).on('click', '.ck_bidang:checked', function () { 
      var x=$('.ck_bidang:checked').length;
      if(x > 1){
        $(this).prop('checked',false);
      }
    });
    $(document).on('click','#add_bidang',function(){
    var xunitid=$('.ck_bidang:checked').attr('rel');
    var xunitname=$('.ck_bidang:checked').attr('nunit');
	var xinspektur=$('.ck_bidang:checked').attr('idinspektur');
    var xbidangid=$('#terlapor-id_bidang_kejati option:selected').val();
    var xbidangname=$('#terlapor-id_bidang_kejati option:selected').text();
    
	/* if(xbidangid==''|| xunitid==''){
         alert('Harap Pilih Bidang Dan Unit Kerja');
    }else{
 */
    $('#idbidang').val(xbidangid);
    $('#bidang').val(xbidangname);
    $('#idunit').val(xunitid);
	$('#idinspektur').val(xinspektur);
    $('#unit_kerja').val(xunitname);
    //$('.ck_bidang').prop('checked',false);
    $('#MyModalPopUp').modal('hide');
	
    //}
    });
     </script>";
    }




    public function actionKejari(){
    $id=$_POST['id'];
	$query = new Query;
        $query->select("a.id_kejari,a.nama_kejari,b.id_inspektur,b.id_kejati,b.nama_kejati")
                ->from("was.kejari a")
                ->join("inner join","was.kejati b","a.id_kejati = b.id_kejati")
                   ->where(['b.id_kejati'=>$id]);
       /*
          $query->select("a.id_kejari,a.nama_kejari,b.id_kejati,b.nama_kejati,d.nama_inspektur,d.id_inspektur")
                ->from("was.kejari a")
                ->join("inner join","was.kejati b","a.id_kejati = b.id_kejati")
                ->join("inner join","was.wilayah_inspektur c","b.id_kejati = c.id_kejati")
                ->join("inner join","was.inspektur d","c.id_inspektur = d.id_inspektur")
                   ->where(['b.id_kejati'=>$id]);    
                    */     
        $ModelKejari = $query->all();
   /*  $ModelKejari = Kejari::find()
                   ->where(['id_kejati'=>$id])
                   ->all(); */
      
     echo "<table width='100%' class='table table-bordered' id='tbl_kejari'>
            <thead>
              <tr>
                <th width='4%'>No</th>
                <th>Kejaksaan Tinggi</th>
                <th>Kejaksaan Negeri</th>
                <th width='4%'>Pilih</th>
              </tr>
            </thead>
            <tbody>";
            $no=1;
            foreach ($ModelKejari as $key) {
          echo"<tr>
                <td>".$no."</td>
                <td>".$key['nama_kejati']."</td>
                <td>".$key['nama_kejari']."</td>
                <td class='ck_bok'><input class='ck_kejari' type='checkbox' name='ck_pilih' rel='". $key['id_kejari']."' nmkejari='". $key['nama_kejari']."' idkejati='".$key['id_kejati']."' nmkejati='".$key['nama_kejati']."' idinspektur='". $key['id_inspektur']."'></td>
              </tr>";
              $no++;
            }

      //$('.td_kejari').click(function(){
        echo"</tbody
     </table>
     <script>
     $('#tbl_kejari').dataTable({'aLengthMenu': [[10, 15, 20, -1], [10, 15, 20, 'All']],
        'iDisplayLength': 10}); 
      $(document).on('click', '.ck_kejari', function () { 
        var x=$('.ck_kejari:checked').length;
      if(x > 1){
        $(this).prop('checked',false);
      }
    });
     $(document).on('click', '#add_kejari', function () { 
      var id_kejari=$('.ck_kejari:checked').attr('rel');
	    var id_inspektur=$('.ck_kejari:checked').attr('idinspektur');
      var nama_kejari=$('.ck_kejari:checked').attr('nmkejari');
      var id_kejati=$('.ck_kejari:checked').attr('idkejati');
      var nama_kejati=$('.ck_kejari:checked').attr('nmkejati');
      // alert(id_inspektur);
      if(id_kejati=='' || id_kejari==null){
        alert('Harap Pilih Kejati dan Kejari');
      }else{
      $('#idbidang').val(id_kejati);/*Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati*/
      $('#nmkejati').val(nama_kejati);
      $('#nmkejari').val(nama_kejari);
      $('#idunit').val(id_kejari);
	    $('#idinspektur').val(id_inspektur);
      $('#MyModalPopUp3').modal('hide');
      }
      
  }); 
     </script>";
    }
    public function actionCabjari(){
       $id=$_POST['id'];
	   $query = new Query;
        $query->select("a.id_kejari,a.nama_kejari,b.id_inspektur,a.akronim")
                ->from("was.kejari a")
                ->join("inner join","was.kejati b","a.id_kejati = b.id_kejati")
                   ->where(['b.id_kejati'=>$id]);
        $ModelKejari = $query->all();
       /* $ModelKejari = Kejari::find()
                   ->where(['id_kejati'=>$id])
                   ->all(); */
      echo "<select name='kejari' id='idkejari'>";
      echo "<option value=''>Pilih Kejari</option>";
        foreach ($ModelKejari as $key) {
            echo "<option value='".$key['id_kejari']."'>".$key['nama_kejari']."</option>";
        }
            
      echo"</select>";
    }
    public function actionCabjaridetail(){
      $id=$_POST['id'];
      $idkejati=$_POST['idkejati'];
	  $query = new Query;
        
        /*$query->select("a.id_cabjari,a.nama_cabjari,
                        (select distinct c.id_inspektur from was.kejati c where c.id_kejati=a.id_kejati)as id_inspektur,
                        (select distinct c.id_kejati from was.kejati c where c.id_kejati=a.id_kejati)as id_kejati,
                        (select distinct c.nama_kejati from was.kejati c where c.id_kejati=a.id_kejati)as nama_kejati,
                        (select distinct b.id_kejari from was.kejari b where b.id_kejari=a.id_kejari and b.id_kejati=a.id_kejati)as id_kejari,
                        (select distinct b.nama_kejari from was.kejari b where b.id_kejari=a.id_kejari and b.id_kejati=a.id_kejati)as nama_kejari")
                ->from("was.cabjari a")
          */
                // ->join("inner join","was.kejari b","a.id_kejari = b.id_kejari")
				// ->join("inner join","was.kejati c","b.id_kejati = c.id_kejati")
              //     ->where(['a.id_kejari'=>$id,'a.id_kejati'=>$idkejati ]);
                   // ->andWhere(['a.id_kejati'=>'01']);
     //   $Modelcabjari = $query->all();
   /*  $Modelcabjari = Cabjari::find()
                   ->where(['id_kejari'=>$id])
                   ->all(); */
      
      // print_r($Modelcabjari);
     echo "<table class='table table-bordered' id='tbl_cabjari'>
            <thead>
              <tr>
                <th width='3%'>No</th>
                <th>Kejaksaan Tinggi</th>
                <th>Kejaksaan Negeri</th>
                <th>Cabang Kejaksaan Negeri</th>
                <th width='4%'>Pilih</th>
              </tr>
            </thead>
            <tbody>";
            $no=1;
            foreach ($Modelcabjari as $key) {
          echo"<tr>
                <td>".$no."</td>
                <td>".$key['nama_kejati']."</td>
                <td>".$key['nama_kejari']."</td>
                <td>".$key['nama_cabjari']."</td>
                <td class='ck_bok'><input class='td_cabjari' type='checkbox' name='ck_pilih' rel='". $key['id_cabjari']."' nmcabjari='". $key['nama_cabjari']."' idkejari='". $key['id_kejari'] ."'  nmkejari='". $key['nama_kejari'] ."'  idkejati='". $key['id_kejati'] ."'  nmkejati='". $key['nama_kejati'] ."' idinspektur='". $key['id_inspektur']."'></td>
              </tr>";
              $no++;
            }

      // $('.td_cabjari').click(function(){
  //       echo"</tbody
  //    </table>
  //    <script>
  //    $('#tbl_cabjari').dataTable({'aLengthMenu': [[10, 15, 20, -1], [10, 15, 20, 'All']],
  //       'iDisplayLength': 10});  
  //     $(document).on('click', '.td_cabjari', function () { 
  //       var x=$('.td_cabjari:checked').length;
  //       if(x > 1){
  //         $(this).prop('checked',false);
  //       }
  //     });

  //      $(document).on('click', '#add_cabjari', function () { 
  //     var id_cabjari=$('.td_cabjari:checked').attr('rel');
	 //    var id_inspektur=$('.td_cabjari:checked').attr('idinspektur');
  //     var nama_cabjari=$('.td_cabjari:checked').attr('nmcabjari');
  //     var id_kejati=$('.td_cabjari:checked').attr('idkejati');
  //     var nama_kejati=$('.td_cabjari:checked').attr('nmkejati');
  //     var id_kejari=$('.td_cabjari:checked').attr('idkejari');
  //     var nama_kejari=$('.td_cabjari:checked').attr('nmkejari');
     
  //  if(id_kejati==''){
  //       alert('Harap Pilih Kejati');
  //     }else if (id_kejari==''){
  //       alert('Harap Pilih Kejari');

  //     }else{

  //     $('#idbidang').val(id_kejati);/*Warning pada saat memilih kejagung id_bidang ini adalah id bidang kejagung tpi pada saat milih kejati id bidang ini adalah id_kejati*/
  //     $('#nmkejati').val(nama_kejati);
  //     $('#nmkejari').val(nama_kejari);
  //     $('#idunit').val(id_kejari);
  //     $('#idcabjari').val(id_cabjari);
	 //  $('#idinspektur').val(id_inspektur);
  //     $('#cabjari').val(nama_cabjari);
  //     $('#MyModalPopUp4').modal('hide');
  //     }
      
  // });

  //    </script>";
    }
    public function actionLokasipelanggaran(){
    // echo $_POST['id'];
        $id_pelanggaran=$_POST['id'];
        // $view=$this->loadView();

         //return $this->renderPartial('_bidang');

       if($id_pelanggaran=='0'){
        echo "<div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-2'>Bidang</label>
                        <div class='col-md-7 kejaksaan'>
                            <input id='bidang' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_1' data-toggle='modal' data-target='#modalBidang' data-backdrop='static' data-keyboard='false'>Pilih</button>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idbidang' class='form-control' type='hidden' maxlength='32'>
							<input id='idinspektur' class='form-control' type='hidden' maxlength='32'>
                        </div>
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-2'>Unit Kerja</label>
                        <div class='col-md-7 kejaksaan'>
                            <input id='unit_kerja' class='form-control unit_kerja' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idunit' class='form-control' type='hidden' maxlength='32' readonly='readonly'>
                        </div>
                    </div>
                    <div class='col-md-1 kejaksaan'>
                            <input id='idcabjari' class='form-control' type='hidden' maxlength='32'>
                        </div>
            </div>";
            
        }else if($id_pelanggaran=='1'){
        echo "<div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Tinggi</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejati' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_2' data-toggle='modal' data-target='#modalKejati' data-backdrop='static' data-keyboard='false'>Pilih</button>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idbidang' class='form-control' type='hidden' maxlength='32'>
                            <input id='idunit' class='form-control' type='hidden' maxlength='32'>
						                <input id='idinspektur' class='form-control' type='hidden' maxlength='32'>
                        </div>
                    </div>
                    <div class='col-md-1 kejaksaan'>
                            <input id='idcabjari' class='form-control' type='hidden' maxlength='32'>
                        </div>
            </div>";
        }else if($id_pelanggaran=='2'){
        echo "<div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Tinggi</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejati' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idbidang' class='form-control' type='hidden' maxlength='32'>
              							<input id='idinspektur' class='form-control' type='hidden' maxlength='32'>
              							<button class='btn btn-primary' type='button' id='pilih_bidang_3' data-toggle='modal' data-target='#modalKejari' data-backdrop='static' data-keyboard='false'>Pilih</button>
                        </div>
                        <!--<div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_3' data-toggle='modal' data-target='#modalKejari' data-backdrop='static' data-keyboard='false'>Pilih</button>
                        </div>-->
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Negeri</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejari' class='form-control unit_kerja' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idunit' class='form-control' type='hidden' maxlength='32'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idcabjari' class='form-control' type='hidden' maxlength='32'>
                        </div>
                    </div>
            </div>";
        }else if($id_pelanggaran=='3'){
        echo "<div class='col-md-12'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Tinggi</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejati' class='form-control bidang' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idbidang' class='form-control' type='hidden' maxlength='32'>
							<input id='idinspektur' class='form-control' type='hidden' maxlength='32'>
							<button class='btn btn-primary' type='button' id='pilih_bidang_3' data-toggle='modal' data-target='#modalCabjari' data-backdrop='static' data-keyboard='false'>Pilih</button>
                        </div>
                        <!--<div class='col-md-2'>
                           <button class='btn btn-primary' type='button' id='pilih_bidang_3' data-toggle='modal' data-target='#MyModalPopUp4'>Pilih</button>
                        </div>-->
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Kejaksaan Negeri</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='nmkejari' class='form-control unit_kerja' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idunit' class='form-control' type='hidden' maxlength='32'>
                        </div>
                    </div>
            </div>
            <div class='col-md-12' style='margin-top: 15px;'>
                    <div class='form-group'>
                        <label class='control-label col-md-3'>Cabjari</label>
                        <div class='col-md-6 kejaksaan'>
                            <input id='cabjari' class='form-control cabjari' type='text' maxlength='32' readonly='readonly'>
                        </div>
                        <div class='col-md-1 kejaksaan'>
                            <input id='idcabjari' class='form-control' type='hidden' maxlength='32'>
                        </div>
                    </div>
            </div>";
        }
    } 
    

    /**
     * Finds the Lapdu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Lapdu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
        if (($model = Lapdu::findOne(['no_register'=>$no_register,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari])) !== null) {
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


     public function actionCetakdoc($id){
      $query=new FungsiComponent();

      $resultQuery      =$query->FunctQuery('lapdu',$id);
      $media_pelaporan  =$query->FunctQueryNoSession('media_pelaporan','id_media_pelaporan',$resultQuery['id_media_pelaporan']);

      $modelTerlapor = Terlapor::findAll(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);

      $connection = \Yii::$app->db;    
      
      $terlaporForCek = new Query;
          $query = "select distinct 
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='1') as insp1,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='2') as insp2,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='3') as insp3,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='4') as insp4,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='5') as insp5
                  from was.terlapor_awal where no_register='".$id."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'  order by 1,2,3,4,5";
              // print_r($query);
              // exit();    
          $terlaporForCek = $connection->createCommand($query)->queryOne();
      

      $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);
      $tgl= \Yii::$app->globalfunc->ViewIndonesianFormat(date('Y-m-d', strtotime($resultQuery['tanggal_surat_lapdu'])));
      
        
       
        return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'resultQuery'=>$resultQuery,
                                'lapdu_tgl_surat'=>$tgl,
                                'media_pelaporan'=>$media_pelaporan,
                                'modelTerlapor'=>$modelTerlapor,
                                'terlaporForCek'=>$terlaporForCek,
                            ]);

    }


    protected function Cetak($id){
       $query=new FungsiComponent();

      $resultQuery      =$query->FunctQuery('lapdu',$id);
      $media_pelaporan  =$query->FunctQueryNoSession('media_pelaporan','id_media_pelaporan',$resultQuery['id_media_pelaporan']);

      $modelTerlapor = Terlapor::findAll(['no_register'=>$id,'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);

      $connection = \Yii::$app->db;    
      
      $terlaporForCek = new Query;
          $query = "select distinct 
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='1') as insp1,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='2') as insp2,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='3') as insp3,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='4') as insp4,
                  (select distinct id_inspektur from was.terlapor_awal where no_register='".$id."'  AND id_inspektur='5') as insp5
                  from was.terlapor_awal where no_register='".$id."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."'  order by 1,2,3,4,5";
              // print_r($query);
              // exit();    
          $terlaporForCek = $connection->createCommand($query)->queryOne();
      

      $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);
      $tgl= GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($resultQuery['was1_tgl_surat'])));
        
       
        return $this->render('cetak',[
                                'data_satker'=>$data_satker,
                                'resultQuery'=>$resultQuery,
                                'lapdu_tgl_surat'=>$tgl,
                                'media_pelaporan'=>$media_pelaporan,
                                'modelTerlapor'=>$modelTerlapor,
                                'terlaporForCek'=>$terlaporForCek,
                            ]);

        
    }
	
}
