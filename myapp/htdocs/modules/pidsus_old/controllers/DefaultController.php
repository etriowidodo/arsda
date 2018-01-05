<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ArrayDataProvider;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidForPidsus1;
use app\modules\pidsus\models\PdsDik;
use app\modules\pidsus\models\PdsDikforP6;
use app\modules\pidsus\models\Status;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidPermintaanData;
use app\modules\pidsus\models\PdsLidRenLid;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\KpInstSatker;
use app\modules\pidsus\models\PdsLidJaksa;
use app\modules\pidsus\models\PdsLidSaksi;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsLidSuratDetail;
use app\modules\pidsus\models\PdsLidSuratSaksi;
use app\modules\pidsus\models\PdsLidSuratJaksa;
use app\modules\pidsus\models\PdsLidSuratSearch;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsPasal;
//use app\modules\pidsus\models\PdsTersangka;
use app\modules\pidsus\models\SimkariJenisSurat;

class DefaultController extends Controller
{
	public function actionCreate()
	{


		if(isset($_SESSION['cetak'])){
			//$_SESSION['cetak']=null;
			return $this->redirect('draftlaporan?type=pidsus1');
			//$link = "<script>window.open("../../pidsus/default/draftlaporan?type=pidsus1")</script>";
			//echo $link;
		}

		$model = new PdsLidForPidsus1();
		$model->lokasi_lap=$_SESSION['lokasiUser'];
		//$model->penerima_lap=(string)Yii::$app->user->identity->peg_nik;
		//$model->penandatangan_lap=(string)Yii::$app->user->identity->peg_nik;

		if ($model->load(Yii::$app->request->post())) {
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			//$model->attributes = Yii::$app->request->post('PdsLid');
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->id_satker=$_SESSION['idSatkerUser'];
			
			$model->save();
			//$model->id_pds_lid='PDSLID-'.$model->id_satker.'-'.Yii::$app->db->getLastInsertID('pidsus.id_pds_lid') ;
			//print_r($model);	
			//print_r($model->getErrors());
			//die();
			$transaction->commit();	
			//echo $model->id_pds_lid .'&'.Yii::$app->db->lastInsertID;;

			if ($_POST['btnSubmit']=='simpan'){
				//return $this->redirect('viewlaporan?id='.$id);
				return $this->redirect('index');
			}
			else {
				$_SESSION['idPdsLid']=$model->id_pds_lid;
				$_SESSION['cetak']=1;$_SESSION['btnCetak']=$_POST['btnCetak']; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
			}
		} else {
			return $this->render('create', [
					'model' => $model,
					'typeSurat' =>'pidsus1',
					'titleForm'=>'Input Laporan/Pengaduan',
			]);
		}
	}
	

	public function actionCreatedik()
	{
		if ($_SESSION['idPdsDik']!==null){
		 return $this->redirect('viewlaporandik?id='.$_SESSION['idPdsDik']);
			echo "tes";
		/*	if(isset($_SESSION['cetak'])){
				//$_SESSION['cetak']=null;
				return $this->redirect('viewlaporandik?id='.$_SESSION['idPdsDik']);
				//$link = "<script>window.open("../../pidsus/default/draftlaporan?type=pidsus1")</script>";
				//echo $link;
			}*/
	     }
	//	echo "tes";

		//$model = new PdsDik();
		$model = new PdsDikforP6();

		//$model->lokasi_lap=$_SESSION['lokasiUser'];
		//$model->penerima_spdp=(string)Yii::$app->user->identity->peg_nik;
		if ($model->load(Yii::$app->request->post())) {
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			//$model->attributes = Yii::$app->request->post('PdsLid');
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->id_satker=$_SESSION['idSatkerUser'];
			$model->is_internal=0;
			//echo 	$model->penerima_spdp;
		//	echo 	$model->id_satker;
			$model->save();
			//echo $model->id_pds_dik;
		//	print_r($model->getErrors());//
			//$model->id_pds_lid='PDSLID-'.$model->id_satker.'-'.Yii::$app->db->getLastInsertID('pidsus.id_pds_lid') ;
			//print_r($model);
			//print_r($model->getErrors());
			$transaction->commit();
			//echo $model->id_pds_lid .'&'.Yii::$app->db->lastInsertID;;
			//return $this->redirect('index?type=dik');

			if ($_POST['btnSubmit']=='simpan'){
				//return $this->redirect('viewlaporan?id='.$id);
				return $this->redirect('index?type=dik');
			}
			else {
				$_SESSION['idPdsDik']=$model->id_pds_dik;
				$_SESSION['cetak']=1;$_SESSION['btnCetak']=$_POST['btnCetak']; return $this->refresh();
				//	return $this->redirect('viewreportdik?id='.$model->id_pds_dik.'&jenisSurat='.$_POST['btnCetak']);
			}
		} else {
			return $this->render('createDik', [
					'model' => $model,
					'titleForm'=>'Input Laporan/Pengaduan',
			]);
		}
	}
    public function actionIndex($type='lid')
    {
    	$modelKpPegawai=KpPegawai::find()->where(['peg_nik'=>(string)Yii::$app->user->identity->peg_nik])->one();
    	$_SESSION['idSatkerUser']=$modelKpPegawai->peg_instakhir;
    	$modelKpInstSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$modelKpPegawai->peg_instakhir.'\' limit 1')->one();
    	$_SESSION['lokasiUser']=$modelKpInstSatker->inst_lokinst;
		//$_SESSION['globalStartDate']= date(strtotime('-1 years'), 'd m Y');
		$_SESSION['globalStartDate']= date('d m Y', strtotime('-1 year'));
    	// $_SESSION['todayDate']=date('d m Y');
    	 $_SESSION['todayDate']=date('d m Y', strtotime('+7 days'));
    	 $_SESSION['startBirth']=date('d m Y', strtotime('-100 year'));
    	 $_SESSION['endBirth']=date('d m Y', strtotime('-17 year'));
		//$_SESSION['globalEndDate']= date('d m Y', strtotime('+1 years'));
    	//$whereQuery="";
    	if($type=='lid'){
    		$_SESSION['idPdsLid']=null;
    		$_SESSION['idPdsDik']=null;
			$_SESSION['idPdsTut']=null;
				$rawData=Yii::$app->db->createCommand("select * from pidsus.lid_daftar_pekerjaan('".Yii::$app->user->identity->username."','".$_SESSION['idSatkerUser']."','".$_POST['merger_field']."' ) ")->queryAll();  //idsatker

	    	$dataProvider=new ArrayDataProvider([
	    			'allModels' =>$rawData, 'key' => 'id_pds_lid',

	    			'pagination'=>[
	    					'pageSize'=>10,         //records display
	    			],
	    	]);
	    	//print_r($rawData);
    	}
    	else {

    		$_SESSION['idPdsLid']=null;
    		$_SESSION['idPdsDik']=null;
			$_SESSION['idPdsTut']=null;

    			$rawData=Yii::$app->db->createCommand("select * from pidsus.dik_daftar_pekerjaan('".Yii::$app->user->identity->username."','".$_SESSION['idSatkerUser']."','".$_POST['merger_field']."' ) ")->queryAll();  //idsatker
    		$_SESSION['globalStartDate']= date('d m Y', strtotime('-1 year'));
    	 //$_SESSION['todayDate']=date('d m Y');
    	 $_SESSION['todayDate']=date('d m Y', strtotime('+7 days'));
    		
    			$dataProvider=new ArrayDataProvider([
    					'allModels' =>$rawData, 'key' => 'id_pds_dik',
    				/*	'sort'=>[
    							'attributes'=>[
    							'id_pds_dik', 'no_spdp', 'tgl_spdp', 'status', 'id_status'
	    					],
    					],*/
    					'pagination'=>[
    							'pageSize'=>10,         //records display
    					],
    			]);
    			//print_r($rawData);
    		
    	}
    	 return $this->render('index', [
    			'dataProvider'=>$dataProvider,
    	 		'type'=>$type,
    	]);
    }

    public function actionListsuratdik($id)
    {
    	$searchModel= new PdsDikSuratSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,'all',$id);
    	$_SESSION['idPdsDik']=$id;
    	return $this->render('listsurat', [
    			'id_pds_dik' =>$id,
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    public function actionListsurat($id)
    {
    	$searchModel= new PdsLidSuratSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams,'all',$id);
    	$_SESSION['idPdsLid']=$id;
    	return $this->render('listsurat', [
    			'idPdsLid' =>$id,
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    	]);
    }
    
    public function actionUpdate($id)
    {
    	$modelPdsLid = PdsLidForPidsus1::findOne($id);
    	//$modelStatus= Status::findOne($modelPdsLid->id_status);
    	
    	//header("Location: ../../".$modelStatus->url.'?id='.$id);
		die();
    }
	public function actionUpdateDik($id)
	{
		$modelPdsDik = PdsDikforP6::findOne($id);
		//$modelStatus= Status::findOne($modelPdsDik->id_status);

		//header("Location: ../../".$modelStatus->url.'?id='.$id);
		die();
	}
    public function actionViewreport($id)
    {
    	$modelPdsLidSurat = PdsLidSurat::findOne($id);
    	$modelJenisSurat= SimkariJenisSurat::findOne(trim($modelPdsLidSurat->id_jenis_surat));
    	 
    	return $this->redirect(str_replace("%7BID_REPORT%7D",$id,$modelJenisSurat->url_report));
    	die();
    }
    

   public function actionViewreportdik($id,$jenisSurat=null)
    {
		if ($jenisSurat==null){
			$modelPdsDikSurat = PdsDikSurat::findOne($id);
			$modelJenisSurat= SimkariJenisSurat::findOne(trim($modelPdsDikSurat->id_jenis_surat));
		}
		else {
			$modelJenisSurat= SimkariJenisSurat::findOne(trim($jenisSurat));
		}
		//echo $modelJenisSurat;
		//return $this->redirect(Yii::$app->request->referrer);
	//	return $this->refresh();
		//$_SESSION['cetak']=1;
	   	return $this->redirect(str_replace("%7BID_REPORT%7D",$id,$modelJenisSurat->url_report),array('target'=>'blank'));
		//header("Location: " . $_SERVER["HTTP_REFERER"]);
    	die();
    }



    public function actionViewreportlid($id,$jenisSurat)
    {
    	$modelJenisSurat= SimkariJenisSurat::findOne(trim($jenisSurat));
    
    	return $this->redirect(str_replace("%7BID_REPORT%7D",$id,$modelJenisSurat->url_report),array('target'=>'blank'));
		//return $this->goBack();
    	die();
    }
    
    public function actionP1(){
    	return $this->redirect('draftlaporan');
    }
    public function actionPidsus1(){
    	return $this->redirect('draftlaporan');
    }
	public function actionP1Dik(){
		return $this->redirect('draftlaporandik');
	}
    public function actionDraftlaporan($type)
    {

	    if (isset($_SESSION['idPdsLid'])){
	    	$id=$_SESSION['idPdsLid'];
	    }
	    else{
	    		return $this->redirect('create');
	    }
	    if (empty($_SESSION['idPdsDik'])){
	    	$modelDik=PdsDik::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
	    	$_SESSION['idPdsDik']=$modelDik->id_pds_dik;
	    	
	    }
	    //echo $_SESSION['idPdsDik'];die();
	    $model = $this->findModel($id);        
	    if(isset($_SESSION['cetak'])){
	    	$_SESSION['cetak']=null;
	    	$link = "<script>window.open(\"../../pidsus/default/viewreportlid?id=".$model->id_pds_lid."&jenisSurat=".$_SESSION['btnCetak']."\")</script>";
	    	echo $link;
	    }    
	        if ($model->load(Yii::$app->request->post())) {
	        	$connection = Yii::$app->db;
	        	$transaction = $connection->beginTransaction();
	        	$model->attributes = Yii::$app->request->post('PdsLid');
	        	$model->update_by=Yii::$app->user->identity->username;
	        	$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
	        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
	        	$model->save();
	        	//print_r($model->getErrors());
	            $transaction->commit();
	            if ($_POST['btnSubmit']=='simpan'){
	            	//return $this->redirect('viewlaporan?id='.$id);
					return $this->redirect('index');
	            }
	        	else {
	        		$_SESSION['cetak']=1;$_SESSION['btnCetak']=$_POST['btnCetak']; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
	        	}
	        } else {
	            return $this->render('draftlaporan', [
	                'model' => $model,
	                'typeSurat'=>$type,
	            	'titleForm'=>'Draft Laporan/Pengaduan',
	            ]);
	        }
    }

	public function actionDraftlaporandik($id)
	{
	/*	if (isset($_SESSION['idPdsDik'])){
			$id=$_SESSION['idPdsDik'];
		}
		else{
			return $this->redirect('index');
		}*/
		$model = $this->findModelDik($id);
		$_SESSION['idPdsDik']=$id;

		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=".$model->id_pds_dik."&jenisSurat=".$_SESSION['btnCetak']."\")</script>";
			echo $link;
		}

		if (($modelLid=PdsLid::find()->where(['id_pds_lid'=>$id])->one())!==null) {
			$_SESSION['idPdsLid']=$modelLid->id_pds_lid;
		//	$modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$modelDik->id_satker.'\' limit 1')->one();
		//	$_SESSION['noSpdpDik']=$modelDik->no_spdp.'</br>'.$modelSatker->inst_lokinst;
		}
		else {
			$_SESSION['idPdsLid']=null;
		}
		if ($model->load(Yii::$app->request->post())) {
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			$model->attributes = Yii::$app->request->post('PdsDik');
			$model->update_by=Yii::$app->user->identity->username;
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->save();
			//print_r($model->getErrors());
			$transaction->commit();
			if ($_POST['btnSubmit']=='simpan'){
				//return $this->redirect('viewlaporan?id='.$id);
				return $this->redirect('index?type=dik');
			}
			else {
				$_SESSION['cetak']=1;$_SESSION['btnCetak']=$_POST['btnCetak']; return $this->refresh();
			//	return $this->redirect('viewreportdik?id='.$model->id_pds_dik.'&jenisSurat='.$_POST['btnCetak']);
			}
		} else {
			return $this->render('draftlaporandik', [
				'model' => $model,

				'titleForm'=>'Draft Laporan Penyidikan',
			]);
		}
	}


	 public function actionViewlaporan($id)
    {

    	$_SESSION['idPdsLid']=$id;
    		if (($modelDik=PdsDik::find()->where(['id_pds_lid_parent'=>$id])->one())!==null){
    			$_SESSION['idPdsDik']=$modelDik->id_pds_dik;
    			$modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$modelDik->id_satker.'\' limit 1')->one();    			 
    			$_SESSION['noSpdpDik']=$modelDik->no_spdp.'</br>'.$modelDik->id_jenis_surat.'</br>'.$modelSatker->inst_lokinst;
    		}
    		else {
    			$_SESSION['idPdsDik']=null;
    		}
	    $model = $this->findModel($id);
		$model2 = $this->findModel($id);
	    $modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$model->id_satker.'\' limit 1')->one();
	    //$_SESSION['noLapLid']=$model->no_surat_lap.'</br>'.$model2->id_jenis_surat.'</br>'.$modelSatker->inst_lokinst;
	    //$_SESSION['noLapLid']='Nomor Surat Laporan : '.$model->no_surat_lap.'</br> Surat Terakhir : '.$model2->id_jenis_surat.'</br> Satuan Kerja : '.$modelSatker->inst_lokinst.'</br> Asal Surat : '.$model->pelapor;
	        
	    return $this->render('viewlaporan', [
	                'model' => $model,
	                'typeSurat'=>'1',
	            	'titleForm'=>'view Laporan/Pengaduan',
	            ]);
	        
    }
	

    public function actionViewlaporandik($id)
    {
    	
    	$_SESSION['idPdsDik']=$id;
		$model = $this->findModelDik($id);
		$model2 = $this->findModelLid($model->id_pds_lid_parent);
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreportdik?id=".$model->id_pds_dik."&jenisSurat=".$_SESSION['btnCetak']."\")</script>";
			echo $link;
		}


    	$modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$model->id_satker.'\' limit 1')->one();    			     			
    	//$_SESSION['noSpdpDik']=$model->no_spdp.'</br>'.$model->id_jenis_surat.'</br>'.$modelSatker->inst_lokinst;
    	//$_SESSION['noSpdpDik']=$model->no_spdp.'</br>'.$model->id_jenis_surat.'</br>'.$modelSatker->inst_lokinst;
    	$_SESSION['idPdsLid']=$model->id_pds_lid_parent;
    	if (($modelLid = PdsLid::findOne($model->id_pds_lid_parent)) !== null) {
    		 $modelSatker=KpInstSatker::findBySql('select * from kepegawaian.kp_inst_satker where inst_satkerkd=\''.$modelLid->id_satker.'\' limit 1')->one();
	    	//$_SESSION['noLapLid']=$modelLid->no_surat_lap.'</br>'.$modelSatker->inst_lokinst;
    		 //$_SESSION['noLapLid']='Nomor Surat Laporan : '.$modelLid->no_surat_lap.'</br> Surat Terakhir : '.$modelLid->id_jenis_surat.'</br> Satuan Kerja : '.$modelSatker->inst_lokinst.'</br> Asal Surat : '.$modelLid->pelapor;
	    	
			//$_SESSION['noLapLid']=$model->no_surat_lap.'</br>'.$model2->id_jenis_surat.'</br>'.$modelSatker->inst_lokinst;
    	}

		if ($model->load(Yii::$app->request->post())) {
			$connection = Yii::$app->db;
			$transaction = $connection->beginTransaction();
			//$model->attributes = Yii::$app->request->post('PdsLid');

			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';

			//echo 	$model->penerima_spdp;
			//	echo 	$model->id_satker;
			$model->save();
			//echo $model->id_pds_dik;
			//print_r($model->getErrors());//
			//$model->id_pds_lid='PDSLID-'.$model->id_satker.'-'.Yii::$app->db->getLastInsertID('pidsus.id_pds_lid') ;
			//print_r($model);
			//print_r($model->getErrors());
			$transaction->commit();
			//echo $model->id_pds_lid .'&'.Yii::$app->db->lastInsertID;;
		//	return $this->redirect('index?type=dik');
			if ($_POST['btnSubmit']=='simpan'){
				//return $this->redirect('viewlaporan?id='.$id);
				return $this->redirect('index?type=dik');
			}
			else {
				$_SESSION['cetak']=1;$_SESSION['btnCetak']=$_POST['btnCetak']; return $this->refresh();
				//	return $this->redirect('viewreportdik?id='.$model->id_pds_dik.'&jenisSurat='.$_POST['btnCetak']);
			}

		}
    	return $this->render('viewlaporandik', [
    			'model' => $model,
    			//'typeSurat'=>'1',
    			'titleForm'=>'view Laporan/Pengaduan',
    	]);


    }
    public function actionApprovallaporan($id)
    {
    	$model = $this->findModel($id);
    
    	if ($model->load(Yii::$app->request->post())) {
    		$connection = Yii::$app->db;
    		$transaction = $connection->beginTransaction();
    		$model->attributes = Yii::$app->request->post('PdsLid');
    		$model->update_by=Yii::$app->user->identity->username;
    		$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
    		$model->save();
    		//print_r($model->getErrors());
    		$transaction->commit();
    		return $this->redirect('index');
    	} else {
    		return $this->render('approvallaporan', [
    				'model' => $model,
    				'typeSurat'=>'1',
    				'titleForm'=>'Approval Laporan/Pengaduan',
    		]);
    	}
    }
    

    public function actionApprovalpemanggilanlid($id)
    {
	   	 	$modelLid =PdsLidForPidsus1::findOne($id);
	    	//$modelStatus=Status::findOne($modelLid->id_status);
	        $searchModel = new PdsLidSuratSearch();
	        $idJenisSurat='pidsus4';        
	        $modelLid = $this->findModelLid($id);
	        //$modelStatus=Status::findOne($modelLid->id_status);
	        $model = $this->findModelSurat($id,$modelLid,$idJenisSurat);
	        $model = $this->findModelSurat($id,$modelLid,$idJenisSurat);
	        $modelJaksa=Yii::$app->db->createCommand("select peg_nik,peg_nama from pidsus.pds_lid_jaksa plj left join simkari.kp_pegawai kp on kp.peg_nik=plj.id_jaksa")->queryAll();;
	        $modelPermintaanData=PdsLidPermintaanData::find()->where(['id_pds_lid_surat'=>$model->id_pds_lid_surat])->all();
		
			$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();        
			$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
			$modelKpPegawai= KpPegawai::findBySql('select * from simkari.kp_pegawai')->all();
			if ($model->load(Yii::$app->request->post())) {
				$modelLid->update_by=Yii::$app->user->identity->username;
				$modelLid->update_date=date('Y-m-d H:i:s');
				$modelLid->id_status=$model->id_status;
				$modelLid->save();
	
				return $this->redirect(['../pidsus/default/index']);
			}
	
			else {
				return $this->render('../pidsus4/index', [
	                'model' => $model,
	                'modelLid' => $modelLid,
	            	'modelSuratIsi' => $modelSuratIsi,
	            	'modelTembusan' => $modelTembusan,
					'modelKpPegawai' =>$modelKpPegawai,
					'modelPermintaanData'=>$modelPermintaanData,
					'modelJaksa' =>$modelJaksa,
	            	'titleForm' => "",
	            	'readOnly' => true,
	            ]);
			}
    }
    
    public function actionApprovalsetelahpenelitian($id){
    	$modelLid = $this->findModelLid($id);
    	$model = $this->findModelSurat($id,$modelLid,'pidsus2');
    	$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
    	$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
    	
    	if ($model->load(Yii::$app->request->post()) ) {
    		$model->update_by=(string)Yii::$app->user->identity->username;
    		$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
    		$model->save();
    		echo $model->id_status;
    		$modelLid->id_status=$model->id_status;
    		$modelLid->update_by=(string)Yii::$app->user->identity->username;
    		$modelLid->update_date=date('Y-m-d H:i:s');
    		$modelLid->save();
    		return $this->redirect('index');
    	} else {
    		return $this->render('approvalsetelahpenilitian', [
    				'model' => $model,
    				'modelLid' => $modelLid,
    				'modelSuratIsi' => $modelSuratIsi,
    				'modelTembusan'	 =>$modelTembusan,
    				'readOnly' => true,
    		]);
    	}
    }
    
    public function actionDelete($id)
    {
    	PdsLid::findOne($id)->delete();
    	
    	$modelLidJaksa=PdsLidJaksa::find()->where('id_pds_lid= \''.$id.'\' ')->all();
    	foreach ($modelLidJaksa as $index => $modelLidJaksaRow) {
    		$modelLidJaksaRow->delete();
    	}
    	

    	$modelLidSaksi=PdsLidSaksi::find()->where('id_pds_lid= \''.$id.'\' ')->all();
    	foreach ($modelLidSaksi as $index => $modelLidSaksiRow) {
    		$modelLidSaksiRow->delete();
    	}

    	$modelLidPermintaanData=PdsLidPermintaanData::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelLidPermintaanData as $index => $modelLidPermintaanDataRow) {
    		$modelLidPermintaanDataRow->delete();
    	}

    	$modelPasal=PdsPasal::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelPasal as $index => $modelPasalRow) {
    		$modelPasalRow->delete();
    	}

    	/*$modelTersangka=PdsTersangka::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelTersangka as $index => $modelTersangkaRow) {
    		$modelTersangkaRow->delete();
    	}
    	 */
    	$modelLidSuratJaksa=PdsLidSuratJaksa::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelLidSuratJaksa as $index => $modelLidSuratJaksaRow) {
    		$modelLidSuratJaksaRow->delete();
    	}
    	
    	$modelLidSuratSaksi=PdsLidSuratSaksi::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelLidSuratSaksi as $index => $modelLidSuratSaksiRow) {
    		$modelLidSuratSaksiRow->delete();
    	}
    	
    	$modelLidRenLid=PdsLidRenLid::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelLidRenLid as $index => $modelLidRenLidRow) {
    		$modelLidRenLidRow->delete();
    	}
    	
    	$modelTembusan=PdsLidTembusan::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelTembusan as $index => $modelTembusanRow) {
    		$modelTembusanRow->delete();
    	}
    	
    	$modelSuratIsi=PdsLidSuratIsi::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelSuratIsi as $index => $modelSuratIsiRow) {
    		$modelSuratIsiRow->delete();
    	}

    	$modelSuratDetail=PdsLidSuratDetail::find()->where('id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_pds_lid=\''.$id.'\' )')->all();
    	foreach ($modelSuratDetail as $index => $modelSuratDetailRow) {
    		$modelSuratDetail->delete();
    	}
    	 
    	$modelSurat=PdsLidSurat::find()->where('id_pds_lid=\''.$id.'\'')->all();
    	foreach ($modelSurat as $index => $modelSuratRow) {
    		$modelSuratRow->delete();
    	}
    	return $this->redirect(['index']);
    }
    

    protected function findModel($id)
    {
    	if (($model = PdsLidForPidsus1::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelDik($id)
    {
    	if (($model = PdsDikforP6::findOne($id)) !== null) {
    		return $model;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    
    protected function findModelSurat($id,$modelLid,$typeSurat)
    {	
    	if (($model = PdsLidSurat::find()->where('id_jenis_surat=\''.$typeSurat.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model= new PdsLidSurat();
    		$model->id_pds_lid=$id;
    		$model->id_jenis_surat=$typeSurat;
    		$model->id_status=$modelLid->id_status;
    		$model->create_by=(string)Yii::$app->user->identity->username;
    		$model->save();
    		$this->findModel($id,$modelLid);
    	}
    }
    protected function findModelLid($id)
    {
    	if (($modelLid = PdsLidForPidsus1::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		return new PdsLid;
    	}
    }
    
    public function actionLinkForm() {
    	if (Yii::$app->request->isAjax) {
    		Yii::$app->response->format = Response::FORMAT_JSON;
    
    
    		$res = array(
    				'body'    => print_r($_POST, true),
    				'success' => true,
    		);
    
    		return $res;
    	}
    }
    
    public function actionAjax(){
    	return $this->render('ajax', [
    	]);
    }
    
    public function actionValidasihapussurat($id, $type){
		/*if ($type == null)
		{
			$type = 'lid';
		}
*/
    	$data= Yii::$app->db->createCommand('select pidsus.validasi_hapus_surat(\''.$id.'\',\''.$type.'\')')->queryScalar();
		//$data= Yii::$app->db->createCommand("select pidsus.validasi_hapus_surat(".$id.",".$type.")")->queryScalar();
    	echo json_encode($data);  			
    }
    
    public function actionValidasihapusparent($id,$type){
    	if ($type=='lid')
    		$modelSurat=PdsLidSurat::find()->where(['id_pds_lid'=>$id,'flag'=>1])->all();
    	else if($type=='dik')
    		$modelSurat=PdsDikSurat::find()->where(['id_pds_dik'=>$id,'flag'=>1])->all();
    	else if ($type=='tut')
    		$modelSurat=PdsTutSurat::find()->where(['id_pds_tut'=>$id,'flag'=>1])->all();
    	if(count($modelSurat)==0){
    		return true;
    	}
    	else {
    		return false;
    	}
    }
    public function actionHapussurat($id,$type){

    	//echo $type.$id;die();
    	if ($type=='lid')
    		$modelSurat=PdsLidSurat::find()->where(['id_pds_lid_surat'=>$id])->one();
    	else if($type=='dik')
    		$modelSurat=PdsDikSurat::find()->where(['id_pds_dik_surat'=>$id])->one();
    	else if ($type=='tut')
    		$modelSurat=PdsTutSurat::find()->where(['id_pds_tut_surat'=>$id])->one();
    	else 
    		$modelSurat=PdsLidSurat::find()->where(['id_pds_lid_surat'=>$id])->one();
    	
    	$modelSurat->flag='3';
    	$modelSurat->no_surat='';
    	$modelSurat->tgl_surat=null;
    	$modelSurat->lokasi_surat='';
    	$modelSurat->sifat_surat=0;
    	$modelSurat->lampiran_surat='';
    	$modelSurat->perihal_lap ='';
    	$modelSurat->kepada='';
    	$modelSurat->kepada_lokasi='';
    	$modelSurat->id_ttd='';
    	$modelSurat->create_by='';
    	$modelSurat->update_by='';
    	$modelSurat->jam_surat=null;
    	$modelSurat->create_ip='';
    	$modelSurat->update_ip='';
    	$modelSurat->dari='';
    	$modelSurat->save();
    	//print_r($model->getErrors());
    	if ($type=='lid')
    		return $this->redirect('/pidsus/pidsus1');
    	else if($type=='dik')
    		return $this->redirect('/pidsus/default/viewlaporandik?id='.$modelSurat->id_pds_dik);
    	else if ($type=='tut')
    		return $this->redirect('/pidsus/tut/viewlaporan?id='.$modelSurat->id_pds_tut);
    	//echo json_encode($modelSurat->getErrors());
    }
    public function actionDeletebatch()
    {
    	$id_pds = $_POST['hapusPds'];
    	//print_r($_POST);die();
    	$listSuccess='';
    	$listFailed='';
    	for($i=0;$i<count($id_pds);$i++){
    		if($_SESSION['typeDaftar']=='lid')
    			$pds = PdsLidForPidsus1::findOne($id_pds[$i]);
    		else if ($_SESSION['typeDaftar']=='dik')
    			$pds = PdsDikforP6::findOne($id_pds[$i]);
    		else if ($_SESSION['typeDaftar']=='tut')
    			$pds = PdsDik::findOne($id_pds[$i]);
    		
    		if ($this->actionValidasihapusparent($id_pds[$i],$_SESSION['typeDaftar'])){    		
	    		$pds->flag = '3';
	    		$pds->save();
	    		//print_r($pds->getErrors());die();
				if($_SESSION['typeDaftar']=='lid')
					$listSuccess=$listSuccess.$pds->no_surat_lap.'</br>';
				else
					$listSuccess=$listSuccess.$pds->no_spdp.'</br>';
    		}
    		else {

    			//$listFailed=$listFailed.$pds->no_surat_lap.'</br>';
				if($_SESSION['typeDaftar']=='lid')
					$listFailed=$listFailed.$pds->no_surat_lap.'</br>';
				else
					$listFailed=$listFailed.$pds->no_spdp.'</br>';
    		}
    	}
    	if($listSuccess!==''){
    		$listSuccess='<b>Laporan yang berhasil dihapus:</b> </br>'.$listSuccess;
    	}
    	if($listFailed!==''){
    		$listFailed='<b>Laporan yang gagal dihapus karena masih memiliki anak:</b> </br>'.$listFailed;
    	}
    	$_SESSION['messageDelete']=$listSuccess.'</br>'.$listFailed;
    	return $this->redirect('index?type='.$_SESSION['typeDaftar']);
    }
    
    public function actionDeletebatchsurat(){
    	$id_pds_surat=$_POST['hapusPds'];
    	//die();
    	//echo $_POST["jenisSurat"];die();
    	//print_r($id_pds_surat);die();
    	for($i=0;$i<count($id_pds_surat);$i++){
    		$this->Hapussurat($id_pds_surat[$i],$_POST['typeSurat']);
    		
    	}
    	if($_POST["jenisSurat"]=='pidsus5a'||$_POST["jenisSurat"]=='pidsus5b'||$_POST["jenisSurat"]=='pidsus5c'){
    		$_POST["jenisSurat"]=='pidsus5';
    	}
    	return $this->redirect('/pidsus/'.$_POST["jenisSurat"]);
    	
    }
    
    public function Hapussurat($id,$type){
    	if ($type=='lid')
    		$modelSurat=PdsLidSurat::find()->where(['id_pds_lid_surat'=>$id])->one();
    	else if($type=='dik')
    		$modelSurat=PdsDikSurat::find()->where(['id_pds_dik_surat'=>$id])->one();
    	else if ($type=='tut')
    		$modelSurat=PdsTutSurat::find()->where(['id_pds_tut_surat'=>$id])->one();
    	else
    		$modelSurat=PdsLidSurat::find()->where(['id_pds_lid_surat'=>$id])->one();
    	//echo $type;print_r($id);die();
    	$modelSurat->flag='3';
    	$modelSurat->no_surat='';
    	$modelSurat->tgl_surat=null;
    	$modelSurat->lokasi_surat='';
    	$modelSurat->sifat_surat=0;
    	$modelSurat->lampiran_surat='';
    	$modelSurat->perihal_lap ='';
    	$modelSurat->kepada='';
    	$modelSurat->kepada_lokasi='';
    	$modelSurat->id_ttd='';
    	$modelSurat->create_by='';
    	$modelSurat->update_by='';
    	$modelSurat->jam_surat=null;
    	$modelSurat->create_ip='';
    	$modelSurat->update_ip='';
    	$modelSurat->dari='';
    	$modelSurat->save();
    	//print_r($modelSurat->getErrors());
    	
    	//echo json_encode($modelSurat->getErrors());
    }
}
