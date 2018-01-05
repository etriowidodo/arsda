<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Was1;
use app\modules\pengawasan\models\Was1Search;

use app\modules\pengawasan\models\Lapdu;
use app\modules\pengawasan\models\LapduSearch;

use app\modules\pengawasan\models\Terlapor;
use app\modules\pengawasan\models\TerlaporSearch;

use app\modules\pengawasan\models\Pelapor;
use app\modules\pengawasan\models\PelaporSearch;

use app\modules\pengawasan\models\Was1Pemeriksa;
use app\modules\pengawasan\models\Was1PemeriksaSearch;

use app\modules\pengawasan\models\StatusLapdu;
use app\modules\pengawasan\models\DisposisiIrmud;

use app\components\ConstSysMenuComponent;

use app\components\InspekturComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;
use app\models\KpInstSatkerSearch;


use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFuncComponent; 
use app\modules\pengawasan\components\FungsiComponent; 
use yii\web\UploadedFile;
use yii\db\Query;
use yii\db\Command;
use Odf;
use yii\web\Session;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * Was1Controller implements the CRUD actions for Was1 model.
 */
class Was1Controller extends Controller
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
     * Lists all Was1 models.
     * @return mixed
     */

	 public function actionIndex()
    {
         $session = Yii::$app->session;
		 
	/* 	 $key = $id;
		 // $session->remove('was_register');
        $session->set('was_register', $key); */
        // if (isset($session['was_register']) && !empty($session['was_register'])) {
        $searchModel = new Was1Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index1', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    // }else{
    //       $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/dugaan-pelanggaran/index"));
    // }
    }

    /**
     * Displays a single Was1 model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionWas1()
    {
        $model = new Was1();
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$_SESSION['was_register']])
                   ->all();

        // $modelTerlapor= Terlapor::find()
        //            ->where(['no_register'=>$_SESSION['was_register']])
        //            ->all();


        $Terlpaor = new Query;
        $Terlpaor2 = new Query;
        $Terlpaor->select("a.nama_terlapor_awal,b.nama_kejagung_bidang as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejagung_bidang b","a.id_bidang_kejati = b.id_kejagung_bidang")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere(['a.id_wilayah'=>'0']);

        $Terlpaor2->select("a.nama_terlapor_awal,b.nama_kejati as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejati b","a.id_bidang_kejati = b.id_kejati")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere('a.id_wilayah != :del', ['del'=>'0']);
         $modelTerlapor=$Terlpaor->union($Terlpaor2)->all();
        return $this->render('update', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelTerlapor' => $modelTerlapor,
                // 'view'=>'_form_pemeriksa',
                
            ]);
    }

    public function actionIrmud()
    {
        $view="_form_irmud";
        $modelWas1= Was1::findBysql("SELECT max(id_level_was1) as id_level_was1 FROM was.was1 where no_register='".$_SESSION['was_register']."'")
                   // ->where(['no_register'=>$_SESSION['was_register']])
                   ->all();
        /*Jika pada modelWas1 id_level_was1 nya adalah 1 maka ambil data dengan id_level_was1=1*/
        /*Jika pada modelWas1 id_level_was1 nya tidak sama dengan 1 atau null(!=1 atau null) maka ambil data dari lapdu*/
        /**/

        $model = new Was1();
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$_SESSION['was_register']])
                   ->all();
        // $modelTerlapor= Terlapor::find()
        //            ->where(['no_register'=>$_SESSION['was_register']])
        //            ->all();


        $Terlpaor = new Query;
        $Terlpaor2 = new Query;
        $Terlpaor->select("a.nama_terlapor_awal,b.nama_kejagung_bidang as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejagung_bidang b","a.id_bidang_kejati = b.id_kejagung_bidang")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere(['a.id_wilayah'=>'0']);

        $Terlpaor2->select("a.nama_terlapor_awal,b.nama_kejati as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejati b","a.id_bidang_kejati = b.id_kejati")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere('a.id_wilayah != :del', ['del'=>'0']);
         $modelTerlapor=$Terlpaor->union($Terlpaor2)->all();
        return $this->render('create', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelTerlapor' => $modelTerlapor,
                'view' => $view,
                
            ]);
        // return $this->renderPartial('_form_irmud');
    }

    public function actionInspektur()
    {
        $view="_form_inspektur";
        /*Jika pada modelWas1 id_level_was1 nya adalah 1 maka ambil data dengan id_level_was1=1*/
        /*Tapi jika pada modelWas1 id_level_was1 nya adalah 2 maka ambil data dengan id_level_was1=2*/
        /*Jika pada modelWas1 id_level_was1 nya tidak sama dengan 1 atau 2 atau null(!=1 atau 2 atau null) maka ambil data dari lapdu*/
        $model = new Was1();
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$_SESSION['was_register']])
                   ->all();

        // $modelTerlapor= Terlapor::find()
        //            ->where(['no_register'=>$_SESSION['was_register']])
        //            ->all();


        $Terlpaor = new Query;
        $Terlpaor2 = new Query;
        $Terlpaor->select("a.nama_terlapor_awal,b.nama_kejagung_bidang as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejagung_bidang b","a.id_bidang_kejati = b.id_kejagung_bidang")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere(['a.id_wilayah'=>'0']);

        $Terlpaor2->select("a.nama_terlapor_awal,b.nama_kejati as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejati b","a.id_bidang_kejati = b.id_kejati")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere('a.id_wilayah != :del', ['del'=>'0']);
         $modelTerlapor=$Terlpaor->union($Terlpaor2)->all();
       return $this->render('create', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelTerlapor' => $modelTerlapor,
                'view' => $view,
                
            ]);
        // return $this->renderPartial('_form_inspektur');
    }
    public function actionPemeriksa()
    {
         $view="_form_pemeriksa";
        $model = new Was1();
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$_SESSION['was_register']])
                   ->all();

        // $modelTerlapor= Terlapor::find()
        //            ->where(['no_register'=>$_SESSION['was_register']])
        //            ->all();


        $Terlpaor = new Query;
        $Terlpaor2 = new Query;
        $Terlpaor->select("a.nama_terlapor_awal,b.nama_kejagung_bidang as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejagung_bidang b","a.id_bidang_kejati = b.id_kejagung_bidang")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere(['a.id_wilayah'=>'0']);

        $Terlpaor2->select("a.nama_terlapor_awal,b.nama_kejati as wilayah_pelanggaran")
                ->from("was.terlapor_awal a")
                ->join("inner join","was.kejati b","a.id_bidang_kejati = b.id_kejati")
                // ->join("left join", "was.terlapor_awal b" , "a.no_register=b.no_register")
                   ->where(['a.no_register'=>$_SESSION['was_register']])
                   ->andWhere('a.id_wilayah != :del', ['del'=>'0']);
         $modelTerlapor=$Terlpaor->union($Terlpaor2)->all();
        // return $this->renderPartial('_form_pemeriksa',[
        //                     'model' => $model,
        //                     'modelLapdu' => $modelLapdu,
        //                     'modelTerlapor' => $modelTerlapor,
        //                 ]);
         return $this->render('create', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelTerlapor' => $modelTerlapor,
                'view' => $view,
                
            ]);
    }

    /**
     * Creates a new Was1 model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id)
    {
	$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        
            if($id=='0'){
            $view='_form';
            }else if($id=='1'){
            $view='_form_pemeriksa';
            }else if($id=='2'){
            $view='_form_irmud';
            }else if($id=='3'){
            $view='_form_inspektur';
            }
        
        $tempat=$_POST['Was1']['tempat'];
        if($_POST['Was1']['tgl_cetak']=='' OR empty($_POST['Was1']['tgl_cetak'])){
            $tglcetak=date('Y-m-d');
        }else{
            $tglcetak=$_POST['Was1']['tgl_cetak'];
        }

        $modelWas1= Was1::findBysql("SELECT max(id_level_was1) as id_level_was1,id_tingkat,id_kejati,id_kejari,id_cabjari FROM was.was1 where no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."' GROUP BY id_level_was1,id_tingkat,id_kejati,id_kejari,id_cabjari")->one();
         
        if($modelWas1['id_level_was1']=='1'){
            $modelLoad = $this->findModelByNoreg($_SESSION['was_register'],$modelWas1['id_level_was1'],$modelWas1['id_tingkat'],$modelWas1['id_kejati'],$modelWas1['id_kejari'],$modelWas1['id_cabjari']);
            $loadWas1=$modelLoad;
        }else if($modelWas1['id_level_was1']=='2' or $modelWas1['id_level_was1']=='3'){
             $modelLoad = $this->findModelByNoreg($_SESSION['was_register'],$modelWas1['id_level_was1'],$modelWas1['id_tingkat'],$modelWas1['id_kejati'],$modelWas1['id_kejari'],$modelWas1['id_cabjari']);
            // print_r($modelLoad['was1_perihal']);
            // exit();
            $loadWas1=$modelLoad;
        }
        $modelPenandatangan=Was1Pemeriksa::find()
                   ->where(['nip'=>$_SESSION['nik_user']])
                   ->all();

        $model = new Was1();
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$_SESSION['was_register']])
                   ->all();

        

        $tempat=$_POST['Was1']['tempat'];
        if($_POST['Was1']['tgl_cetak']=='' OR empty($_POST['Was1']['tgl_cetak'])){
            $tglcetak=date('Y-m-d');
        }else{
            $tglcetak=$_POST['Was1']['tgl_cetak'];
        }
          $connection = \Yii::$app->db;
           $sql_terlpaor= "select*from was.v_wilayah_pelanggaran";
          $result_terlapor = $connection->createCommand($sql_terlpaor)->queryAll();
          
                 

        /*Menggabungkan terlapor dan pelapor dalam satu baris untuk bagian perihal*/
          $query = "SELECT string_agg(A.nama_terlapor_awal,',')as nama_terlapor_awal FROM was.terlapor_awal a
              left join was.was_disposisi_irmud b on a.no_register=b.no_register and a.id_tingkat=b.id_tingkat and a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.no_urut=b.urut_terlapor
              WHERE b.no_register='".$_SESSION['was_register']."' AND b.id_tingkat = '".$_SESSION['kode_tk']."' AND b.id_kejati = '".$_SESSION['kode_kejati']."' AND b.id_kejari = '".$_SESSION['kode_kejari']."' AND b.id_cabjari = '".$_SESSION['kode_cabjari']."' and id_pemeriksa='".$var[2]."'";
          $model_terlapor = $connection->createCommand($query)->queryAll();
          
          $query2 = "SELECT string_agg(nama_pelapor, ',') as nama_pelapor FROM was.pelapor as S WHERE no_register ='".$_SESSION['was_register']."' AND id_tingkat = '".$_SESSION['kode_tk']."' AND id_kejati = '".$_SESSION['kode_kejati']."' AND id_kejari = '".$_SESSION['kode_kejari']."' AND id_cabjari = '".$_SESSION['kode_cabjari']."' ";
          $modelPelapor = $connection->createCommand($query2)->queryAll();
        
		$connection = \Yii::$app->db;
		$query1 = "SELECT*
                FROM
                    was.was_disposisi_irmud
                WHERE
                    no_register = '".$_SESSION['was_register']."'
                    AND id_tingkat = '".$_SESSION['kode_tk']."'
                    AND id_kejati = '".$_SESSION['kode_kejati']."'
                    AND id_kejari = '".$_SESSION['kode_kejari']."'
                    AND id_cabjari = '".$_SESSION['kode_cabjari']."'
                    AND id_wilayah = '".$var[0]."'
                    AND id_irmud = '".$var[1]."'
                    AND id_pemeriksa = '".$var[2]."'";
		$disposisi_irmud = $connection->createCommand($query1)->queryAll();	
		
        if ($model->load(Yii::$app->request->post())){
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try{

            if($model->id_level_was1=='1'){
                $model->was1_tgl_surat=$_POST['Was1']['tgl_cetak'];
                $model->no_surat='-';
             }
            $model->created_time = date('Y-m-d H:i:s');
            $model->created_ip   = $_SERVER['REMOTE_ADDR'];
            $model->created_by   = \Yii::$app->user->identity->id;
            $model->no_register = $_SESSION['was_register'];
            $model->id_tingkat  = $_SESSION['kode_tk'];
            $model->id_kejati   = $_SESSION['kode_kejati'];
            $model->id_kejari   = $_SESSION['kode_kejari'];
            $model->id_cabjari  = $_SESSION['kode_cabjari'];
            $model->is_inspektur_irmud_riksa = $_SESSION['is_inspektur_irmud_riksa'];
            if($model->save()){
                
	
			$connection = \Yii::$app->db;
			$query1 = "update was.was_disposisi_irmud set status='WAS-1' 
                    where 
                        no_register = '".$_SESSION['was_register']."'
                        AND id_tingkat = '".$_SESSION['kode_tk']."'
                        AND id_kejati = '".$_SESSION['kode_kejati']."'
                        AND id_kejari = '".$_SESSION['kode_kejari']."'
                        AND id_cabjari = '".$_SESSION['kode_cabjari']."'
                        AND id_pemeriksa = '".$var[2]."'";
			$update_disposisi = $connection->createCommand($query1);
			$update_disposisi->execute();
				
                $transaction->commit();
        if($_POST['print']=='1'){
           //   unset($_POST['action']);
           // $this->redirect('lapdu/view?id=r001');
            $this->cetak($model['no_register'],$id,$tempat,$tglcetak);
            // exit();
           }
           // else 
           if($_POST['print_1']=='3'){
             $this->cetak2($model['no_register'],$id);

           }

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
            
            return $this->redirect('index');
        }else{
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
               return $this->render('create', [
                'id' => $id,
            ]);
        }

     } catch (Exception $e) {
                $transaction->rollback();
                 if(YII_DEBUG){throw $e; exit;} else{return false;}
              }
      
        }else {
            return $this->render('create', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'model_terlapor' => $model_terlapor,
                'view' => $view,
                'modelWas1' => $modelWas1,
                'loadWas1' => $loadWas1,
                'modelPelapor' => $modelPelapor,
                'modelPenandatangan' => $modelPenandatangan,
				        'disposisi_irmud' => $disposisi_irmud,
                
            ]);
        }
        
    }


    /**
     * Updates an existing Was1 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$option,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {   
	      $var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        if($option=='0'){
        $view='_form';
        }else if($option=='1'){
        $view='_form_pemeriksa';
        }else if($option=='2'){
        $view='_form_irmud';
        }else if($option=='3'){
        $view='_form_inspektur';
        }

        /*random kode*/
        $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $res = "";
        for ($i = 0; $i < 10; $i++) {
            $res .= $chars[mt_rand(0, strlen($chars)-1)];
        }

         $queryp = new Query;
         $connection = \Yii::$app->db;
        /*Query terlapor*/
         $modelTerlapor="select string_agg(nama_terlapor_awal,', ') as nama from was.terlapor_awal  where
                        no_register = '".$_SESSION['was_register']."'
                        AND id_tingkat = '".$_SESSION['kode_tk']."'
                        AND id_kejati = '".$_SESSION['kode_kejati']."'
                        AND id_kejari = '".$_SESSION['kode_kejari']."'
                        AND id_cabjari = '".$_SESSION['kode_cabjari']."'";
        $dataTerlapor = $connection->createCommand($modelTerlapor)->queryOne(); 

        /*Query pelapor*/
         $modelPelapor="select string_agg(nama_pelapor,', ') as nama from was.pelapor where
                        no_register = '".$_SESSION['was_register']."'
                        AND id_tingkat = '".$_SESSION['kode_tk']."'
                        AND id_kejati = '".$_SESSION['kode_kejati']."'
                        AND id_kejari = '".$_SESSION['kode_kejari']."'
                        AND id_cabjari = '".$_SESSION['kode_cabjari']."'";
        $dataPelapor = $connection->createCommand($modelPelapor)->queryOne();

        // $tempat='Jakarta';
        // $tglcetak='2016-09-20';
        // ini adalah permintan kang putut;
        $modelWas1= Was1::findBysql("SELECT max(id_level_was1) as id_level_was1,id_tingkat,id_kejati,id_kejari,id_cabjari FROM was.was1 where no_register='".$_SESSION['was_register']."' and is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."' GROUP BY id_level_was1,id_tingkat,id_kejati,id_kejari,id_cabjari")
                   ->One();
                   
        $modelLoad = $this->findModelByNoreg($id,$modelWas1['id_level_was1'],$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
        $loadWas1=$modelLoad;
       
		
        $tempat=$_POST['Was1']['tempat'];
		
		$connection = \Yii::$app->db;
		$query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
		$disposisi_irmud = $connection->createCommand($query1)->queryAll();	
		
        if($_POST['Was1']['tgl_cetak']=='' OR empty($_POST['Was1']['tgl_cetak'])){
            $tglcetak=date('Y-m-d');
        }else{
            $tglcetak=$_POST['Was1']['tgl_cetak'];
        }
        $model= $this->findModelByNoreg($id,$option,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
        $modelLapdu= Lapdu::find()
                   ->where(['no_register'=>$id])
                   ->all();

              $fungsi=new FungsiComponent();
              $is_inspektur_irmud_riksa=$fungsi->gabung_where();/*karena ada perubahan kode*/    
              $OldFile = $model->was1_file_disposisi;
       // print_r($model['data']);
       // exit();
        if ($model->load(Yii::$app->request->post())){

            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
		            try {
                  
                $errors       = array();
                $file_name    = $_FILES['file_was1']['name'];
                $file_size    =$_FILES['file_was1']['size'];
                $file_tmp     =$_FILES['file_was1']['tmp_name'];
                $file_type    =$_FILES['file_was1']['type'];
                $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                $tmp = explode('.', $_FILES['file_was1']['name']);
                $file_exists = end($tmp);
                $rename_file  =$is_inspektur_irmud_riksa.'_'.$model->id_level_was1.'_'.$_SESSION['inst_satkerkd'].'_'.$res.'.'.$ext;
                $riksa        =$_POST['no_urut'];

             if($model->id_level_was1=='1'){
                $model->was1_tgl_surat=$_POST['Was1']['tgl_cetak'];
                $model->no_surat='-';
             }
			//$model->was1_tgl_disposisi=$model->was1_tgl_surat;
            $model->updated_time = date('Y-m-d H:i:s');
            $model->updated_ip = $_SERVER['REMOTE_ADDR'];
            $model->updated_by = \Yii::$app->user->identity->id;
            $model->was1_file_disposisi = ($file_name==''?$OldFile:$rename_file);
            if($model->save(false)) {
            if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'was_1/'.$OldFile)) {
                unlink(\Yii::$app->params['uploadPath'].'was_1/'.$OldFile);
            } 

            
                if($model->id_level_was1=='3' AND $model->was1_tgl_disposisi!=''){
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2003' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-1

                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2004' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-2

                   
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2005' AND id_wilayah='".$_SESSION['was_id_wilayah']."' and id_level1='".$_SESSION['was_id_level1']."' and id_level2='".$_SESSION['was_id_level2']."' and id_level3='".$_SESSION['was_id_level3']."' and id_level4='".$_SESSION['was_id_level4']."'"); //was-3
                    
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2015' AND id_wilayah='1' and id_level1='6' and id_level2='1' and id_level3='2' and id_level4='0'"); //sp-was2
                  
                        WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='2007' AND id_wilayah='1' and id_level1='6' and id_level2='1' and id_level3='2' and id_level4='0'"); //sp-was1
                /*ini bagian yang tertinggal untuk trx_pemrosesan*/
                /*Kondisi Jika Pilihan 6 mengaktifkan menu Sp-Was-2*/
                if($model->id_saran=='6'){
                    $modelTrxPemrosesan1=new WasTrxPemrosesan();
                    $modelTrxPemrosesan1->no_register    =$_SESSION['was_register'];
                    $modelTrxPemrosesan1->id_sys_menu    ="2015";
                    $modelTrxPemrosesan1->id_user_login  =$_SESSION['username'];
                    $modelTrxPemrosesan1->durasi         =date('Y-m-d H:i:s');
                    $modelTrxPemrosesan1->created_by     =\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan1->created_ip     =$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan1->created_time   =date('Y-m-d H:i:s');
                    $modelTrxPemrosesan1->updated_ip     =$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan1->updated_by     =\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan1->updated_time   =date('Y-m-d H:i:s');
                    /*SESSION TU*/
                    $modelTrxPemrosesan1->id_wilayah     =1;
                    $modelTrxPemrosesan1->id_level1      =6;
                    $modelTrxPemrosesan1->id_level2      =1;
                    $modelTrxPemrosesan1->id_level3      =2;
                    $modelTrxPemrosesan1->id_level4      =0;
                    
                    $modelTrxPemrosesan1->user_id        =$_SESSION['is_inspektur_irmud_riksa'];
                    $modelTrxPemrosesan1->save();
                }else if($model->id_saran=='5'){ /*Kondisi Jika Pilihan 5 mengaktifkan menu Sp-Was-1*/
                    $modelTrxPemrosesan1=new WasTrxPemrosesan();
                    $modelTrxPemrosesan1->no_register    =$_SESSION['was_register'];
                    $modelTrxPemrosesan1->id_sys_menu    ="2007";
                    $modelTrxPemrosesan1->id_user_login  =$_SESSION['username'];
                    $modelTrxPemrosesan1->durasi         =date('Y-m-d H:i:s');
                    $modelTrxPemrosesan1->created_by     =\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan1->created_ip     =$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan1->created_time   =date('Y-m-d H:i:s');
                    $modelTrxPemrosesan1->updated_ip     =$_SERVER['REMOTE_ADDR'];
                    $modelTrxPemrosesan1->updated_by     =\Yii::$app->user->identity->id;
                    $modelTrxPemrosesan1->updated_time   =date('Y-m-d H:i:s');
                    /*SESSION TU*/
                    $modelTrxPemrosesan1->id_wilayah     =1;
                    $modelTrxPemrosesan1->id_level1      =6;
                    $modelTrxPemrosesan1->id_level2      =1;
                    $modelTrxPemrosesan1->id_level3      =2;
                    $modelTrxPemrosesan1->id_level4      =0;
                    
                    $modelTrxPemrosesan1->user_id        =$_SESSION['is_inspektur_irmud_riksa'];
                    $modelTrxPemrosesan1->save();
                }else if($model->id_saran=='2'){ /*Kondisi Jika Pilihan 2 mengaktifkan menu was2*/
                    $modelTrxPemrosesan=new WasTrxPemrosesan();
                    $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                    $modelTrxPemrosesan->id_sys_menu="2004";/*masuk was2*/
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
                }else if($model->id_saran=='3'){ /*Kondisi Jika Pilihan 3 mengaktifkan menu was3*/
                    $modelTrxPemrosesan=new WasTrxPemrosesan();
                    $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                    $modelTrxPemrosesan->id_sys_menu="2005";/*masuk was2*/
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
                }



                $modelTrxPemrosesan2=new WasTrxPemrosesan();
                $modelTrxPemrosesan2->no_register    =$_SESSION['was_register'];
                $modelTrxPemrosesan2->id_sys_menu    ="2003";
                $modelTrxPemrosesan2->id_user_login  =$_SESSION['username'];
                $modelTrxPemrosesan2->durasi         =date('Y-m-d H:i:s');
                $modelTrxPemrosesan2->created_by     =\Yii::$app->user->identity->id;
                $modelTrxPemrosesan2->created_ip     =$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan2->created_time   =date('Y-m-d H:i:s');
                $modelTrxPemrosesan2->updated_ip     =$_SERVER['REMOTE_ADDR'];
                $modelTrxPemrosesan2->updated_by     =\Yii::$app->user->identity->id;
                $modelTrxPemrosesan2->updated_time   =date('Y-m-d H:i:s');
                $modelTrxPemrosesan2->id_wilayah=$_SESSION['was_id_wilayah'];
                $modelTrxPemrosesan2->id_level1=$_SESSION['was_id_level1'];
                $modelTrxPemrosesan2->id_level2=$_SESSION['was_id_level2'];
                $modelTrxPemrosesan2->id_level3=$_SESSION['was_id_level3'];
                $modelTrxPemrosesan2->id_level4=$_SESSION['was_id_level4'];
                $modelTrxPemrosesan2->user_id        =$_SESSION['is_inspektur_irmud_riksa'];
                $modelTrxPemrosesan2->save();

                $arr = array(ConstSysMenuComponent::Was2, ConstSysMenuComponent::Was3);

                // $modelTrxPemrosesan=new WasTrxPemrosesan();
                // $modelTrxPemrosesan->no_register=$_SESSION['was_register'];
                // if($model->id_saran=='2'){
                // $modelTrxPemrosesan->id_sys_menu=$arr[0];/*masuk was2*/
                // }else if($model->id_saran=='3'){
                // $modelTrxPemrosesan->id_sys_menu=$arr[1];/*masuk was3*/
                // }
                
                // $modelTrxPemrosesan->id_user_login=$_SESSION['username'];
                // $modelTrxPemrosesan->durasi=date('Y-m-d H:i:s');
                // $modelTrxPemrosesan->created_by=\Yii::$app->user->identity->id;
                // $modelTrxPemrosesan->created_ip=$_SERVER['REMOTE_ADDR'];
                // $modelTrxPemrosesan->created_time=date('Y-m-d H:i:s');
                // $modelTrxPemrosesan->updated_ip=$_SERVER['REMOTE_ADDR'];
                // $modelTrxPemrosesan->updated_by=\Yii::$app->user->identity->id;
                // $modelTrxPemrosesan->updated_time=date('Y-m-d H:i:s');
                // $modelTrxPemrosesan->user_id=$_SESSION['is_inspektur_irmud_riksa'];
                // $modelTrxPemrosesan->id_wilayah=$_SESSION['was_id_wilayah'];
                // $modelTrxPemrosesan->id_level1=$_SESSION['was_id_level1'];
                // $modelTrxPemrosesan->id_level2=$_SESSION['was_id_level2'];
                // $modelTrxPemrosesan->id_level3=$_SESSION['was_id_level3'];
                // $modelTrxPemrosesan->id_level4=$_SESSION['was_id_level4'];
                // $modelTrxPemrosesan->save();
                }
                
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'was_1/'.$rename_file);
             $transaction->commit();
            if($_POST['print']=='1'){
            $this->cetak($id,$option,$tempat,$tglcetak);
             }
             if($_POST['print_1']=='3'){
               $this->cetak2($id,$option);

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
            return $this->redirect('index');
            }else{
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
              return $this->redirect(['update', 'id' => $model->no_register,'option'=>$model->id_level_was1]);
            }
                } catch (Exception $e) {
                  $transaction->rollback();
                  if(YII_DEBUG){throw $e; exit;} else{return false;}
                }
                  
                
             
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelLapdu' => $modelLapdu,
                'modelTerlapor' => $modelTerlapor,
                'view' => $view,
                'disposisi_irmud' => $disposisi_irmud,
                'modelWas1' => $modelWas1,
                'loadWas1' => $loadWas1,
                'dataTerlapor' => $dataTerlapor,
                'dataPelapor' => $dataPelapor,
            ]);
        }
    }

     /**
     * Deletes an existing Was1 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id=$_POST['id'];
        $jml=$_POST['jml'];
        $check=explode(",",$id);
        // $modelPelapor = new Pelapor();
        // $modelTerlapor = new Terlapor();
        //echo $check;
        //exit();

        for ($i=0; $i <$jml ; $i++) { 
        //  echo $check[$i];
            // Pelapor::deleteAll("no_register = '".$check[$i]."'");
            // Terlapor::deleteAll("no_register = '".$check[$i]."'");
            Was1::deleteAll("id_level_was1 = '".$check[$i]."'");
        }
         // return $this->redirect(['index1?id='.$_SESSION['was_register']]);
        $this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/was1/index"));
    }

    public function actionCetakIndex($id,$option,$tempat,$tglcetak){

       if($option=='1'){
            $this->cetak($id,$option,$tempat,$tglcetak);
           }else{
            $this->cetak2($id,$option);
           }
          

    }
    
    
    protected function Cetak($id,$option,$tempat,$tglcetak){

        // $model= $this->findModelByNoreg($id,$option);

        // print_r($id);print_r($option);print_r($tempat);print_r($tglcetak);
        // exit();
        $model = Was1::findBysql("SELECT a.*,left(a.nip_penandatangan,8)||' '||substring(a.nip_penandatangan,9,6)||' '||substring(a.nip_penandatangan,15,1)||' '||substring(a.nip_penandatangan,16,3) as nip_1,b.isi_saran_was1,c.id_jabatan as jabatan FROM was.was1 a inner join was.saran_was1 b ON a.id_saran = b.id_saran_was1 inner join was.penandatangan_surat c on a.nip_penandatangan=c.nip WHERE a.no_register='".$id."' AND a.id_level_was1='".$option."'")->one();
        $tgl= GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($tglcetak)));
        // print_r($model);
        // exit();
        // $model=
		    //$tgl= GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['was1_tgl_surat'])));
		
        return $this->render('cetak',['model'=>$model,'tempat'=>$tempat,'tglcetak'=>$tgl]);

    }

    protected function Cetak2($id,$option){

        // $model= $this->findModelByNoreg($id,$option);
        // $modelLoadSaran=Was1::findOne($id)
        $model = Was1::findBysql("SELECT a.*, b.isi_saran_was1 FROM was.was1 a inner join was.saran_was1 b ON a.id_saran = b.id_saran_was1 WHERE a.no_register='".$id."' AND a.id_level_was1='".$option."'")->one();
        // print_r($model);
        $data_satker = KpInstSatkerSearch::findOne(['kode_tk'=>$_SESSION['kode_tk'],'kode_kejati'=>$_SESSION['kode_kejati'],'kode_kejari'=>$_SESSION['kode_kejari'],'kode_cabjari'=>$_SESSION['kode_cabjari']]);
        $tgl= GlobalFuncComponent::tglToWord(date('Y-m-d', strtotime($model['was1_tgl_surat'])));
        // exit();
        return $this->render('cetak2',['model'=>$model,'tgl'=>$tgl,'data_satker'=>$data_satker]);

    }

    public function actionViewpdf($id,$option,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari){
       $file_upload=$this->findModelByNoreg($id,$option,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari);
       $filepath = '../modules/pengawasan/upload_file/was_1/'.$file_upload['was1_file_disposisi'];
       $nama_file=$file_upload['was1_file_disposisi'];

        $extention=explode(".", $nama_file);
           if($extention[1]=='jpg' || $extention[1]=='jpeg' || $extention[1]=='png'){
                if(file_exists($filepath)){
            return Yii::$app->response->sendFile($filepath);
                }
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

    public function actionGetinspektur(){
 // echo "test";
 //    exit();
  $searchModelWas1 = new Was1Search();
  $dataProviderPenandatangan = $searchModelWas1->searchPenandatanganInspektur(Yii::$app->request->queryParams);
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

 public function actionGetirmud(){
 // echo "test";
 //    exit();
  $searchModelWas1 = new Was1Search();
  $dataProviderPenandatangan = $searchModelWas1->searchPenandatanganIrmud(Yii::$app->request->queryParams);
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

  public function actionGetriksa(){
 // echo "test";
 //    exit();
  $searchModelWas1 = new Was1Search();
  $dataProviderPenandatangan = $searchModelWas1->searchPenandatanganRiksa(Yii::$app->request->queryParams);
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

    /**
     * Finds the Was1 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Was1 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Was1::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelByNoreg($id,$option,$id_tingkat,$id_kejati,$id_kejari,$id_cabjari)
    {
        if (($model = Was1::findOne(['no_register'=>$id,'id_level_was1'=>$option,'id_tingkat'=>$id_tingkat,'id_kejati'=>$id_kejati,'id_kejari'=>$id_kejari,'id_cabjari'=>$id_cabjari,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Belum ada inputan Pada Halaman Ini');
            // return ;
        }
    }


}
