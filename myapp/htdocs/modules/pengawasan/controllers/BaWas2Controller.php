<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\BaWas2;
use app\modules\pengawasan\models\BaWas2Search;
use app\modules\pengawasan\models\BaWas2DetailHasil;
use app\modules\pengawasan\models\BaWas2DetailPemeriksa;
use app\modules\pengawasan\models\BaWas2DetailEks;
use app\modules\pengawasan\models\BaWas2DetailInt;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\pengawasan\models\Was9;
use app\modules\pengawasan\models\SpWas1;
use app\modules\pengawasan\models\PemeriksaSpWas1;
use app\modules\pengawasan\models\pemeriksaBawas2;
use app\modules\pengawasan\models\SaksiInternal;
use app\modules\pengawasan\models\SaksiEksternal;
use app\models\KpInstSatker;
use app\models\KpInstSatkerSearch;
use app\modules\pengawasan\models\DisposisiIrmud;
use app\modules\pengawasan\components\FungsiComponent;

use app\components\ConstSysMenuComponent;
use app\modules\pengawasan\models\WasTrxPemrosesan;

use app\modules\pengawasan\models\VSpWas2;
use app\modules\pengawasan\models\VTerlapor;
use app\modules\pengawasan\models\VPelapor;
use app\modules\pengawasan\models\VSaksiInternal;
use app\modules\pengawasan\models\VSaksiEksternal;
use app\modules\pengawasan\models\VPemeriksa;
use Odf;
use yii\db\Query;
use yii\grid\GridView;
use yii\widgets\Pjax;

/**
 * BaWas3Controller implements the CRUD actions for BaWas3 model.
 */
class BaWas2Controller extends Controller
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
     * Lists all BaWas3 models.
     * @return mixed
     */
    public function actionIndex()
    {
 		
   //      return $this->render('index', [
			// 'searchModel' => $searchModel,
   //          'dataProvider' => $dataProvider,

   //      ]);
    	$model = $this->findModel();
		if($model){
			$this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2/update"));
		}else{
			$this->redirect(\Yii::$app->urlManager->createUrl("pengawasan/ba-was2/create"));
		}
    }
	
	
    public function actionCreate()
    {	
    	$model = $this->findModel();
		if($model){/*jika ada maka masuk ke update*/
			return $this->redirect(['update']);	
		}else{
        $model = new BaWas2();
        $fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $where2=$fungsi->static_where();
        $modelSpWas1=SpWas1::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'trx_akhir'=>1,'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        $modelPemeriksa=PemeriksaSpWas1::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
        $modelSaksiInternal=SaksiInternal::findAll(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
		
		$connection = \Yii::$app->db;
        $sql="select a.*,c.nama as warga,b.nama as agama 
        	from was.saksi_eksternal a
				left join public.ms_agama b on a.id_agama_saksi_eksternal=b.id_agama
				left join public.ms_warganegara c on a.id_warganegara=c.id 
				where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $modelSaksiEksternal=$connection->createCommand($sql)->queryAll();

        $filter_2         =" no_register='".$_SESSION['was_register']."' and id_tingkat='".$_SESSION['kode_tk']."' and id_kejati='".$_SESSION['kode_kejati']."' and id_kejari='".$_SESSION['kode_kejari']."' and id_cabjari='".$_SESSION['kode_cabjari']."' and trx_akhir=1 $where2";
      	$getId          =$fungsi->FunctGetIdSpwas1All($filter_2);


        if ($model->load(Yii::$app->request->post()) ) {
			$connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
            	$model->no_register = $_SESSION['was_register'];
                $model->id_tingkat	= $_SESSION['kode_tk'];
                $model->id_kejati 	= $_SESSION['kode_kejati'];
                $model->id_kejari 	= $_SESSION['kode_kejari'];
                $model->id_cabjari 	= $_SESSION['kode_cabjari'];
                $model->created_by=\Yii::$app->user->identity->id;
	            $model->created_ip=$_SERVER['REMOTE_ADDR'];
	            $model->created_time=date('Y-m-d H:i:s');
	            $model->hari=\Yii::$app->globalfunc->GetNamaHari($model->tgl);
	            $model->id_sp_was=$getId['id_sp_was1'];
	            $model->nomor_sp_was=$getId['nomor_sp_was1'];
	            $model->tanggal_spwas=$getId['tanggal_sp_was1'];
			if($model->save()){

				$pertanyaan=$_POST['pertanyaan'];
				for ($i=0; $i <count($pertanyaan) ; $i++) { 
					$bawas2Hasil=new BaWas2DetailHasil();
					$bawas2Hasil->no_register = $_SESSION['was_register'];
	                $bawas2Hasil->id_tingkat	= $_SESSION['kode_tk'];
	                $bawas2Hasil->id_kejati 	= $_SESSION['kode_kejati'];
	                $bawas2Hasil->id_kejari 	= $_SESSION['kode_kejari'];
	                $bawas2Hasil->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2Hasil->id_ba_was2=$model->id_ba_was2;
	                $bawas2Hasil->hasil_wawancara=$_POST['pertanyaan'][$i];
	                $bawas2Hasil->created_by=\Yii::$app->user->identity->id;
		            $bawas2Hasil->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2Hasil->created_time=date('Y-m-d H:i:s');
		            $bawas2Hasil->save();

				}

				$nip_pemeriksa=$_POST['nip_pemeriksa'];
				for ($j=0; $j <count($nip_pemeriksa) ; $j++) { 
					$bawas2Pemeriksa=new BaWas2DetailPemeriksa();
					$bawas2Pemeriksa->no_register 	= $_SESSION['was_register'];
	                $bawas2Pemeriksa->id_tingkat	= $_SESSION['kode_tk'];
	                $bawas2Pemeriksa->id_kejati 	= $_SESSION['kode_kejati'];
	                $bawas2Pemeriksa->id_kejari 	= $_SESSION['kode_kejari'];
	                $bawas2Pemeriksa->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2Pemeriksa->id_ba_was2 	=$model->id_ba_was2;
	                $bawas2Pemeriksa->nip = $_POST['nip_pemeriksa'][$j];
	                $bawas2Pemeriksa->nrp =  $_POST['nrp_pemeriksa'][$j];
	                $bawas2Pemeriksa->nama_pemeriksa = $_POST['nama_pemeriksa'][$j];
	                $bawas2Pemeriksa->pangkat_pemeriksa = $_POST['pangkat_pemeriksa'][$j];
	                $bawas2Pemeriksa->jabatan_pemeriksa = $_POST['jabatan_pemeriksa'][$j];
	                $bawas2Pemeriksa->golongan_pemeriksa = $_POST['golongan_pemeriksa'][$j];
	                $bawas2Pemeriksa->created_by=\Yii::$app->user->identity->id;
		            $bawas2Pemeriksa->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2Pemeriksa->created_time=date('Y-m-d H:i:s');
		            $bawas2Pemeriksa->save();

				}

				$urutSaksiInt=$_POST['id_saksi_eksternal'];
				for ($k=0; $k <count($urutSaksiInt) ; $k++) { 
					$bawas2SaksiEks=new BaWas2DetailEks();
					$bawas2SaksiEks->no_register 	= $_SESSION['was_register'];
	                $bawas2SaksiEks->id_tingkat		= $_SESSION['kode_tk'];
	                $bawas2SaksiEks->id_kejati 		= $_SESSION['kode_kejati'];
	                $bawas2SaksiEks->id_kejari 		= $_SESSION['kode_kejari'];
	                $bawas2SaksiEks->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2SaksiEks->id_ba_was2 	=$model->id_ba_was2;
	                $bawas2SaksiEks->nama_saksi_eksternal = $_POST['nama_saksi_eksternal'][$k];
	                $bawas2SaksiEks->tempat_lahir_saksi_eksternal = $_POST['tempat_lahir_saksi_eksternal'][$k];
	                $bawas2SaksiEks->tanggal_lahir_saksi_eksternal = $_POST['tanggal_lahir_saksi_eksternal'][$k];
	                $bawas2SaksiEks->id_negara_saksi_eksternal = $_POST['id_negara_saksi_eksternal'][$k];
	                $bawas2SaksiEks->pendidikan = $_POST['pendidikan_saksi_eksternal'][$k];
	                $bawas2SaksiEks->id_agama_saksi_eksternal = $_POST['id_agama_saksi_eksternal'][$k];
	                $bawas2SaksiEks->alamat_saksi_eksternal = $_POST['alamat_saksi_eksternal'][$k];
	                $bawas2SaksiEks->nama_kota_saksi_eksternal = $_POST['nama_kota_saksi_eksternal'][$k];
	                $bawas2SaksiEks->id_warganegara = $_POST['id_warga_saksi_eksternal'][$k];
	                $bawas2SaksiEks->pekerjaan_saksi_eksternal = $_POST['pekerjaan_saksi_eksternal'][$k];
	                $bawas2SaksiEks->created_by=\Yii::$app->user->identity->id;
		            $bawas2SaksiEks->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2SaksiEks->created_time=date('Y-m-d H:i:s');
		            $bawas2SaksiEks->save();

				}

				$nip_saksiIn=$_POST['nip_saksi_internal'];
				for ($l=0; $l <count($nip_saksiIn) ; $l++) { 
					$bawas2SaksiInt=new BaWas2DetailInt();
					$bawas2SaksiInt->no_register 	= $_SESSION['was_register'];
	                $bawas2SaksiInt->id_tingkat	= $_SESSION['kode_tk'];
	                $bawas2SaksiInt->id_kejati 	= $_SESSION['kode_kejati'];
	                $bawas2SaksiInt->id_kejari 	= $_SESSION['kode_kejari'];
	                $bawas2SaksiInt->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2SaksiInt->id_ba_was2 	=$model->id_ba_was2;
	                $bawas2SaksiInt->nip = $_POST['nip_saksi_internal'][$l];
	                $bawas2SaksiInt->nrp =  $_POST['nrp_pemeriksa'][$l];
	                $bawas2SaksiInt->nama_saksi_internal = $_POST['nama_saksi_internal'][$l];
	                $bawas2SaksiInt->pangkat_saksi_internal = $_POST['pangkat_saksi_internal'][$l];
	                $bawas2SaksiInt->jabatan_saksi_internal = $_POST['jabatan_saksi_internal'][$l];
	                $bawas2SaksiInt->golongan_saksi_internal = $_POST['golongan_saksi_internal'][$l];
	                $bawas2SaksiInt->created_by=\Yii::$app->user->identity->id;
		            $bawas2SaksiInt->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2SaksiInt->created_time=date('Y-m-d H:i:s');
		            $bawas2SaksiInt->save();

				}
			
			
				$arr = array(ConstSysMenuComponent::LWas);
                    for ($i=0; $i < 1 ; $i++) { 
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
				 'message' => 'Data Berhasil di Simpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				$transaction->commit(); 
				return $this->redirect(['index']);	
				}
				else{
				Yii::$app->getSession()->setFlash('success', [
				 'type' => 'success',
				 'duration' => 3000,
				 'icon' => 'fa fa-users',
				 'message' => 'Data Gagal di Simpan',
				 'title' => 'Simpan Data',
				 'positonY' => 'top',
				 'positonX' => 'center',
				 'showProgressbar' => true,
				 ]);
				return $this->render('create', [
                'model' => $model,
				'modelSpWas1' => $modelSpWas1,
				'modelPemeriksa' => $modelPemeriksa,
				'modelSaksiInternal' =>  $modelSaksiInternal,
				'modelSaksiEksternal' => $modelSaksiEksternal,
            ]);
				}
				} catch(Exception $e) {
                    $transaction->rollback();
                    if(YII_DEBUG){throw $e; exit;} else{return false;}
				}
				
        }
			else {
            return $this->render('create', [
                'model' => $model,
				'modelSpWas1' => $modelSpWas1,
				'modelPemeriksa' => $modelPemeriksa,
				'modelSaksiInternal' =>  $modelSaksiInternal,
				'modelSaksiEksternal' => $modelSaksiEksternal,
				
            ]);
        }
    }
    }

    /**
     * Updates an existing BaWas3 model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate()
    {
	  /*random kode*/
	  $chars = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	  $res = "";
	  for ($i = 0; $i < 10; $i++) {
	      $res .= $chars[mt_rand(0, strlen($chars)-1)];
	  }

		$model = $this->findModel();
		if($model){/*jika ada maka masuk ke update*/
		$fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $is_inspektur_irmud_riksa=$fungsi->gabung_where();
				
        $modelPemeriksa=BaWas2DetailPemeriksa::findAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
        $modelSaksiInternal=BaWas2DetailInt::findAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
		
		$connection = \Yii::$app->db;
        $sql="select a.*,c.nama as warga,b.nama as agama 
        	from was.ba_was2_detail_eks a
				left join public.ms_agama b on a.id_agama_saksi_eksternal=b.id_agama
				left join public.ms_warganegara c on a.id_warganegara=c.id 
				where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $modelSaksiEksternal=$connection->createCommand($sql)->queryAll();

        $modelWawancara=BaWas2DetailHasil::findAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari']]);
        $OldFile=$model->upload_file;

         if ($model->load(Yii::$app->request->post()) ) {

         		  $errors       = array();
                  $file_name    = $_FILES['upload_file']['name'];
                  $file_size    =$_FILES['upload_file']['size'];
                  $file_tmp     =$_FILES['upload_file']['tmp_name'];
                  $file_type    =$_FILES['upload_file']['type'];
                  $ext = pathinfo($file_name, PATHINFO_EXTENSION);
                  $tmp = explode('.', $_FILES['upload_file']['name']);
                  $file_exists = end($tmp);
                  $rename_file  =$is_inspektur_irmud_riksa.'_'.$_SESSION['inst_satkerkd'].$res.'.'.$ext;
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
           try {
           		$model->updated_by = \Yii::$app->user->identity->id;
				$model->updated_ip = $_SERVER['REMOTE_ADDR'];
				$model->updated_time = date('Y-m-d H:i:s');
				$model->upload_file =  ($file_name==''?$OldFile:$rename_file);
				// $model->id_sp_was=$getId['id_sp_was1'];
				$model->hari=\Yii::$app->globalfunc->GetNamaHari($model->tgl);
	            // $model->nomor_sp_was=$getId['nomor_sp_was1'];
	            // $model->tanggal_spwas=$getId['tanggal_sp_was1'];
            if($model->save()){
            	if($OldFile!='' && file_exists($file_tmp) && file_exists(\Yii::$app->params['uploadPath'].'ba_was_2/'.$OldFile)) {
                  unlink(\Yii::$app->params['uploadPath'].'ba_was_2/'.$OldFile);
              	} 

            	$pertanyaan=$_POST['pertanyaan'];
            	BaWas2DetailHasil::deleteAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
				for ($i=0; $i <count($pertanyaan) ; $i++) { 
					$bawas2Hasil=new BaWas2DetailHasil();
					$bawas2Hasil->no_register = $_SESSION['was_register'];
	                $bawas2Hasil->id_tingkat	= $_SESSION['kode_tk'];
	                $bawas2Hasil->id_kejati 	= $_SESSION['kode_kejati'];
	                $bawas2Hasil->id_kejari 	= $_SESSION['kode_kejari'];
	                $bawas2Hasil->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2Hasil->id_ba_was2=$model->id_ba_was2;
	                $bawas2Hasil->hasil_wawancara=$_POST['pertanyaan'][$i];
	                $bawas2Hasil->created_by=\Yii::$app->user->identity->id;
		            $bawas2Hasil->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2Hasil->created_time=date('Y-m-d H:i:s');
		            $bawas2Hasil->save();

				}

				$nip_pemeriksa=$_POST['nip_pemeriksa'];
				BaWas2DetailPemeriksa::deleteAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
				for ($j=0; $j <count($nip_pemeriksa) ; $j++) { 
					$bawas2Pemeriksa=new BaWas2DetailPemeriksa();
					$bawas2Pemeriksa->no_register 	= $_SESSION['was_register'];
	                $bawas2Pemeriksa->id_tingkat	= $_SESSION['kode_tk'];
	                $bawas2Pemeriksa->id_kejati 	= $_SESSION['kode_kejati'];
	                $bawas2Pemeriksa->id_kejari 	= $_SESSION['kode_kejari'];
	                $bawas2Pemeriksa->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2Pemeriksa->id_ba_was2 	=$model->id_ba_was2;
	                $bawas2Pemeriksa->nip = $_POST['nip_pemeriksa'][$j];
	                $bawas2Pemeriksa->nrp =  $_POST['nrp_pemeriksa'][$j];
	                $bawas2Pemeriksa->nama_pemeriksa = $_POST['nama_pemeriksa'][$j];
	                $bawas2Pemeriksa->pangkat_pemeriksa = $_POST['pangkat_pemeriksa'][$j];
	                $bawas2Pemeriksa->jabatan_pemeriksa = $_POST['jabatan_pemeriksa'][$j];
	                $bawas2Pemeriksa->golongan_pemeriksa = $_POST['golongan_pemeriksa'][$j];
	                $bawas2Pemeriksa->created_by=\Yii::$app->user->identity->id;
		            $bawas2Pemeriksa->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2Pemeriksa->created_time=date('Y-m-d H:i:s');
		            $bawas2Pemeriksa->save();

				}

				$urutSaksiInt=$_POST['id_saksi_eksternal'];
				BaWas2DetailEks::deleteAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
				for ($k=0; $k <count($urutSaksiInt) ; $k++) { 
					$bawas2SaksiEks=new BaWas2DetailEks();
					$bawas2SaksiEks->no_register 	= $_SESSION['was_register'];
	                $bawas2SaksiEks->id_tingkat		= $_SESSION['kode_tk'];
	                $bawas2SaksiEks->id_kejati 		= $_SESSION['kode_kejati'];
	                $bawas2SaksiEks->id_kejari 		= $_SESSION['kode_kejari'];
	                $bawas2SaksiEks->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2SaksiEks->id_ba_was2 	=$model->id_ba_was2;
	                $bawas2SaksiEks->nama_saksi_eksternal = $_POST['nama_saksi_eksternal'][$k];
	                $bawas2SaksiEks->tempat_lahir_saksi_eksternal = $_POST['tempat_lahir_saksi_eksternal'][$k];
	                $bawas2SaksiEks->tanggal_lahir_saksi_eksternal = $_POST['tanggal_lahir_saksi_eksternal'][$k];
	                $bawas2SaksiEks->id_negara_saksi_eksternal = $_POST['id_negara_saksi_eksternal'][$k];
	                $bawas2SaksiEks->pendidikan = $_POST['pendidikan_saksi_eksternal'][$k];
	                $bawas2SaksiEks->id_agama_saksi_eksternal = $_POST['id_agama_saksi_eksternal'][$k];
	                $bawas2SaksiEks->alamat_saksi_eksternal = $_POST['alamat_saksi_eksternal'][$k];
	                $bawas2SaksiEks->nama_kota_saksi_eksternal = $_POST['nama_kota_saksi_eksternal'][$k];
	                $bawas2SaksiEks->id_warganegara = $_POST['id_warga_saksi_eksternal'][$k];
	                $bawas2SaksiEks->pekerjaan_saksi_eksternal = $_POST['pekerjaan_saksi_eksternal'][$k];
	                $bawas2SaksiEks->created_by=\Yii::$app->user->identity->id;
		            $bawas2SaksiEks->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2SaksiEks->created_time=date('Y-m-d H:i:s');
		            $bawas2SaksiEks->save();

				}

				$nip_saksiIn=$_POST['nip_saksi_internal'];
				BaWas2DetailInt::deleteAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
				for ($l=0; $l <count($nip_saksiIn) ; $l++) { 
					$bawas2SaksiInt=new BaWas2DetailInt();
					$bawas2SaksiInt->no_register 	= $_SESSION['was_register'];
	                $bawas2SaksiInt->id_tingkat	= $_SESSION['kode_tk'];
	                $bawas2SaksiInt->id_kejati 	= $_SESSION['kode_kejati'];
	                $bawas2SaksiInt->id_kejari 	= $_SESSION['kode_kejari'];
	                $bawas2SaksiInt->id_cabjari 	= $_SESSION['kode_cabjari'];
	                $bawas2SaksiInt->id_ba_was2 	=$model->id_ba_was2;
	                $bawas2SaksiInt->nip = $_POST['nip_saksi_internal'][$l];
	                $bawas2SaksiInt->nrp =  $_POST['nrp_pemeriksa'][$l];
	                $bawas2SaksiInt->nama_saksi_internal = $_POST['nama_saksi_internal'][$l];
	                $bawas2SaksiInt->pangkat_saksi_internal = $_POST['pangkat_saksi_internal'][$l];
	                $bawas2SaksiInt->jabatan_saksi_internal = $_POST['jabatan_saksi_internal'][$l];
	                $bawas2SaksiInt->golongan_saksi_internal = $_POST['golongan_saksi_internal'][$l];
	                $bawas2SaksiInt->created_by=\Yii::$app->user->identity->id;
		            $bawas2SaksiInt->created_ip=$_SERVER['REMOTE_ADDR'];
		            $bawas2SaksiInt->created_time=date('Y-m-d H:i:s');
		            $bawas2SaksiInt->save();

				}
			
             
			  	$arr = array(ConstSysMenuComponent::LWas);
                    for ($i=0; $i < 1 ; $i++) { 
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

             $transaction->commit();
             move_uploaded_file($file_tmp,\Yii::$app->params['uploadPath'].'ba_was_2/'.$rename_file);
               
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
                        return $this->redirect(['index']);
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
              return $this->redirect(['index']);
            }
           } catch(Exception $e) {
                    $transaction->rollback();
                   if(YII_DEBUG){throw $e; exit;} else{return false;}
            }
        } else {
            return $this->render('update', [
					'model' => $model,
					'modelSpWas1' => $modelSpWas1,
					'modelPemeriksa' => $modelPemeriksa ,
					'modelSaksiInternal' => $modelSaksiInternal,
					'modelSaksiEksternal' => $modelSaksiEksternal,
					'modelWawancara' => $modelWawancara,
					'spwas1' => $spwas1,
				]);
        }
    }else{
			return $this->redirect(['create']);
	}	
    }

    public function actionCetak(){

    	$model = $this->findModel($id);
    	$fungsi=new FungsiComponent();
        $where=$fungsi->static_where_alias('a');
        $data_satker = KpInstSatkerSearch::findOne(['inst_satkerkd'=>$_SESSION['inst_satkerkd']]);/*lokasi dan nama kejaksaan*/

        /*pemeriksa*/
        $model_pemeriksa=BaWas2DetailPemeriksa::findAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        /*saksi internal*/
        $model_internal=BaWas2DetailInt::findAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);

        /*saksi eskternal*/
        $connection = \Yii::$app->db;
        $query_eksternal="select a.*, b.nama as agama_saksi_eksternal,c.nama as pendidikan from was.ba_was2_detail_eks a join public.ms_agama b on a.id_agama_saksi_eksternal=b.id_agama inner join public.ms_pendidikan c on a.pendidikan=id_pendidikan where a.no_register='".$_SESSION['was_register']."' and a.id_tingkat='".$_SESSION['kode_tk']."' and a.id_kejati='".$_SESSION['kode_kejati']."' and a.id_kejari='".$_SESSION['kode_kejari']."' and a.id_cabjari='".$_SESSION['kode_cabjari']."' $where";
        $model_eksternal=$connection->createCommand($query_eksternal)->queryAll();

        $model_pertanyaan=BaWas2DetailHasil::findAll(['id_ba_was2'=>$model->id_ba_was2,'no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']]);
       


        $tgl_spwas1=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tanggal_spwas']);
        $tgl_bawas2=\Yii::$app->globalfunc->ViewIndonesianFormat($model['tgl']);
        $hari_bawas2=\Yii::$app->globalfunc->GetNamaHari($model['tgl']);
    	return $this->render('cetak',[
    					'model'=>$model,
    					'data_satker'=>$data_satker,
    					'hari_bawas2'=>$hari_bawas2,
    					'tgl_bawas2'=>$tgl_bawas2,
    					'model_pemeriksa'=>$model_pemeriksa,
    					'tgl_spwas1'=>$tgl_spwas1,
    					'model_internal'=>$model_internal,
    					'model_eksternal'=>$model_eksternal,
    					'model_pertanyaan'=>$model_pertanyaan,
    					]);
    }
	
	public function actionViewpdf($id){
     
       $file_upload=$this->findModel();
        // print_r($file_upload['file_lapdu']);
          $filepath = '../modules/pengawasan/upload_file/ba_was_2/'.$file_upload['upload_file'];
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

    /**
     * Deletes an existing BaWas2 model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id_ba_was2 = $_POST['id'];
		$jumlah = $_POST['jml'];
		
		
		$check=explode(",",$id_ba_was2);
     
        for ($i=0; $i <$jumlah ; $i++) { 
            // SpWas2::deleteAll("id_sp_was2 = '".$check[$i]."'");
           $this->findModel($check[$i])->delete();
            
    }
    	$var=str_split($_SESSION['is_inspektur_irmud_riksa']);
        $connection = \Yii::$app->db;
        $query1 = "select * from was.was_disposisi_irmud where no_register='".$_SESSION['was_register']."'";
        $disposisi_irmud = $connection->createCommand($query1)->queryAll(); 

        for ($i=0;$i<count($disposisi_irmud);$i++){
        
        $saveDisposisi = DisposisiIrmud::find()->where("no_register='".$_SESSION['was_register']."' and id_terlapor_awal='".$disposisi_irmud[$i]['id_terlapor_awal']."' and id_inspektur='".$var[0]."' and id_irmud='".$var[1]."'")->one();
        if($var[2]==1){
            $connection = \Yii::$app->db;
            $query1 = "update was.was_disposisi_irmud set status_pemeriksa1='WAS-13' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
            $disposisi_irmud = $connection->createCommand($query1);
            $disposisi_irmud->execute();
        }
        if($var[2]==2){
            $connection = \Yii::$app->db;
            $query1 = "update was.was_disposisi_irmud set status_pemeriksa2='WAS-13' where id_terlapor_awal='".$saveDisposisi['id_terlapor_awal']."'";
            $disposisi_irmud = $connection->createCommand($query1);
            $disposisi_irmud->execute();
        // }    
        }   
	}
	    // hapus trx_permrosesan LWAS , tp harus cek BAWAS3 dulu jika BAWAS3 ada maka jangan di hapus
	    $cek_bawas2 = "select count(*) as jumlah from was.ba_was_3 where no_register='".$_SESSION['was_register']."' AND is_inspektur_irmud_riksa='".$_SESSION['is_inspektur_irmud_riksa']."'";
	    $result_baws2 = $connection->createCommand($cek_bawas2)->queryOne(); 
	    
	    if($result_baws2['jumlah']<=0){
	        $arr = array(ConstSysMenuComponent::LWas);
		    for ($i=0; $i < 1 ; $i++) { 
		            WasTrxPemrosesan::deleteAll("no_register='".$_SESSION['was_register']."' AND id_sys_menu='".$arr[$i]."' AND user_id='".$_SESSION['is_inspektur_irmud_riksa']."'");
		    
		    }
	    }
         return $this->redirect(['index']);
		 
    if (Was12::deleteAll("id_ba_was_2 ='" . $id_ba_was2  . "'")) {
      
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
    } else {
      Yii::$app->getSession()->setFlash('success', [
          'type' => 'danger',
          'duration' => 3000,
          'icon' => 'fa fa-users',
          'message' => 'Data Gagal Dihapus'.$id_ba_was2 .'" ',
          'title' => 'Error',
          'positonY' => 'top',
          'positonX' => 'center',
          'showProgressbar' => true,
      ]);
    }
    return $this->redirect(['index']);
    }

    public function actionGetttd(){
  
   $searchModelBaWas2 = new BaWas2Search();
   $dataProviderPenandatangan = $searchModelBaWas2->searchPenandatangan(Yii::$app->request->queryParams);
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
     * Finds the BaWas3 model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return BaWas3 the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
     protected function findModel()
    {
        if (($model = BaWas2::findOne(['no_register'=>$_SESSION['was_register'],'id_tingkat'=>$_SESSION['kode_tk'],'id_kejati'=>$_SESSION['kode_kejati'],'id_kejari'=>$_SESSION['kode_kejari'],'id_cabjari'=>$_SESSION['kode_cabjari'],'id_wilayah'=>$_SESSION['was_id_wilayah'],'id_level1'=>$_SESSION['was_id_level1'],'id_level2'=>$_SESSION['was_id_level2'],'id_level3'=>$_SESSION['was_id_level3'],'id_level4'=>$_SESSION['was_id_level4']
])) !== null) {
            return $model;
        } else {
            // throw new NotFoundHttpException('The requested page does not exist.');
            return '0';
        }
    }
}

