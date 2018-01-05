<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidSuratforPidsus3;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsLidSuratSearch;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class Pidsus3aController extends Controller
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
     * Lists all PdsLid models.
     * @return mixed
     */
    protected function checkActive(){
    	if(empty($_SESSION['idPdsLid'])){
	    	if (!empty($_SESSION['idPdsDik'])){
	    		$modelPdsDik=PdsDik::find()->where(['id_pds_dik'=>$_SESSION['idPdsDik']])->one();
	    		$_SESSION['idPdsLid']=$modelPdsDik->id_pds_lid_parent;
	    	}
	    	if (!empty($_SESSION['idPdsTut'])){
	    		$modelPdsDik=PdsTut::find()->where(['id_pds_tut'=>$_SESSION['idPdsTut']])->one();
	    		$_SESSION['idPdsLid']=$modelPdsTut->id_pds_lid_parent;
	    	}
	    	else{
	    		return $this->redirect(['../pidsus/default/index']);
	    	}
    	}
    }
    public function actionIndexalit()
    {
    	$this->checkActive();
    	$_SESSION['startDatePidsus3']=new \DateTime($this->getStartDate('pidsus2'));
    	$_SESSION['startDatePidsus3']=$_SESSION['startDatePidsus3']->format('d m Y');
    	$readOnly=$this->isPidsus9Exist();
    	$model = PdsLidSuratforPidsus3::findOne($this->getIdPidsus3A('pidsus3alit'));
    	$modelLid = $this->findModelLid($model->id_pds_lid);
    	//$modelStatus=Status::findOne($modelLid->id_status);
    	$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
    	$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
    	if ($model->load(Yii::$app->request->post()) ) {

    		if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidTembusan::validateMultiple($modelTembusan)){
    			$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
    				$row->update_by=Yii::$app->user->identity->username;
    				$row->update_date=date('Y-m-d H:i:s');
    				$row->save();
    			}
    		}
    		if(isset($_POST['new_tembusan'])){
    			for($i = 0; $i < count($_POST['new_tembusan']); $i++){
    				$modelNewTembusan= new PdsLidtembusan();
    				$modelNewTembusan->id_pds_lid_surat=$model->id_pds_lid_surat;
    				$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
    				$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
    				$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
    				$modelNewTembusan->save();
    			}
    		}
    		if(isset($_POST['hapus_tembusan'])){
    			for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
    				PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
    			}
    		}
    		$model->update_by=(string)Yii::$app->user->identity->username;
    		$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
    		$model->save();
    		//echo $model->id_status;
    		$modelLid = $this->findModelLid($model->id_pds_lid);
    		$modelLid->id_status=$model->id_status;
    		$modelLid->update_by=(string)Yii::$app->user->identity->username;
    		$modelLid->update_date=date('Y-m-d H:i:s');
    		$modelLid->save();
    		if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
    			foreach($modelSuratIsi as $row){
    				$row->update_by=Yii::$app->user->identity->username;
    				$row->update_date=date('Y-m-d H:i:s');
    				$row->save();
    
    				//print_r($row->getErrors());
    			}
    		}
	    	if ($_POST['btnSubmit']=='simpan'){
	        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$model->id_pds_lid]);
	        	}
	        	else {
	        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
	        	}
    	} else {
    		return $this->render('update', [
    				'model' => $model,
    				'modelLid' => $modelLid,
    				'modelSuratIsi' => $modelSuratIsi,
    				'modelTembusan'	 =>$modelTembusan,
    				'titleForm' => "",
    				'readOnly' => $readOnly,
    		]);
    	}
    }
    
    public function actionIndexalid()
    {
    	$this->checkActive();
    	$_SESSION['startDatePidsus3']=new \DateTime($this->getStartDate('pidsus2'));
    	$_SESSION['startDatePidsus3']=$_SESSION['startDatePidsus3']->format('d m Y');
    	 
    	$model = PdsLidSuratforPidsus3::findOne($this->getIdPidsus3A('pidsus3alid'));
    	$readOnly=$this->isPidsus9Exist();
    	$modelLid = $this->findModelLid($model->id_pds_lid);
    	//$modelStatus=Status::findOne($modelLid->id_status);
    	$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
    	$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
    	if ($model->load(Yii::$app->request->post()) ) {

    		if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidTembusan::validateMultiple($modelTembusan)){
    			$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
    				$row->update_by=Yii::$app->user->identity->username;
    				$row->update_date=date('Y-m-d H:i:s');
    				$row->save();
    			}
    		}
    		if(isset($_POST['new_tembusan'])){
    			for($i = 0; $i < count($_POST['new_tembusan']); $i++){
    				$modelNewTembusan= new PdsLidtembusan();
    				$modelNewTembusan->id_pds_lid_surat=$model->id_pds_lid_surat;
    				$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
    				$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
    				$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
    				$modelNewTembusan->save();
    			}
    		}
    		if(isset($_POST['hapus_tembusan'])){
    			for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
    				PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
    			}
    		}
    		$model->update_by=(string)Yii::$app->user->identity->username;
    		$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
    		$model->save();
    		//echo $model->id_status;
    		$modelLid = $this->findModelLid($model->id_pds_lid);
    		$modelLid->id_status=$model->id_status;
    		$modelLid->update_by=(string)Yii::$app->user->identity->username;
    		$modelLid->update_date=date('Y-m-d H:i:s');
    		$modelLid->save();
    		if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
    			foreach($modelSuratIsi as $row){
    				$row->update_by=Yii::$app->user->identity->username;
    				$row->update_date=date('Y-m-d H:i:s');
    				$row->save();
    
    				//print_r($row->getErrors());
    			}
    		}
	    	if ($_POST['btnSubmit']=='simpan'){
		        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$model->id_pds_lid]);
		        	}
		        	else {
		        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
		        	}
    	} else {
    		return $this->render('update', [
    				'model' => $model,
    				'modelLid' => $modelLid,
    				'modelSuratIsi' => $modelSuratIsi,
    				'modelTembusan'	 =>$modelTembusan,
    				'titleForm' => "",
    				'readOnly' => $readOnly,
    		]);
    	}
    }
    
    
    public function getIdPidsus3A($idJenisSurat){
    	$sql = "SELECT COUNT(*) FROM pidsus.pds_lid_surat where flag<>'3' and id_jenis_surat='".$idJenisSurat."' and id_pds_lid='".$_SESSION['idPdsLid']."'";
    	$modelLid =PdsLid::findOne($_SESSION['idPdsLid']);
    	 
    	$numClients = Yii::$app->db->createCommand($sql)->queryScalar();
    	if($numClients== 0){
    		$model= new PdsLidSurat();
    		$model->id_pds_lid=$_SESSION['idPdsLid'];
    		$model->id_jenis_surat=$idJenisSurat;
    		$model->id_status=$modelLid->id_status;
    		$model->kepada=$modelLid->pelapor;
    		$model->kepada_lokasi=$modelLid->asal_surat_lap;
	    	/*if($idJenisSurat=='pidsus3alit'){
	    		$model->perihal_lap='Pemberitahuan tindak lanjut atas Laporan/Pengaduan setelah dilakukan penelitian';
	    	}
	    	elseif($idJenisSurat=='pidsus3alid'){
	    		$model->perihal_lap='Pemberitahuan tindak lanjut atas Laporan/Pengaduan setelah dilakukan penyelidikan';
	    	}*/
    		$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
    		$model->save();   	
    	}
    	$id=Yii::$app->db->createCommand("SELECT id_pds_lid_surat FROM pidsus.pds_lid_surat where id_jenis_surat='".$idJenisSurat."' and id_pds_lid='".$_SESSION['idPdsLid']."'")->queryColumn();
    	return $id[0];
    }
    
    public function getStartDate($jenisSurat){
    	$modelPidsus2=PdsLidSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$_SESSION['idPdsLid'].'\'')->one();
    	return $modelPidsus2->tgl_surat;
    }
    

    public function getIdPidsus3B($idJenisSurat){
    	$model= new PdsLidSurat();
    	$model->id_pds_lid=$_SESSION['idPdsLid'];
    	$model->id_jenis_surat=$idJenisSurat;
    /*	if($idJenisSurat=='pidsus3alit'){
    		$model->perihal_lap='Pemberitahuan tindak lanjut atas Laporan/Pengaduan setelah dilakukan penelitian';
    	}
    	elseif($idJenisSurat=='pidsus3alid'){
    		$model->perihal_lap='Pemberitahuan tindak lanjut atas Laporan/Pengaduan setelah dilakukan penyelidikan';
    	}
    	elseif($idJenisSurat=='pidsus3blit'){

    		$model->perihal_lap='Laporan/Pengaduan setelah dilakukan penelitian';
    	}
    	elseif($idJenisSurat=='pidsus3blid'){
    		$model->perihal_lap='Laporan/Pengaduan setelah dilakukan penyelidikan';    		
    	}*/
    	$model->create_by=(string)Yii::$app->user->identity->username;
    	$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
    	$model->save();
    	$id=Yii::$app->db->createCommand("SELECT id_pds_lid_surat FROM pidsus.pds_lid_surat where flag<>'3' and id_jenis_surat='".$idJenisSurat."' and id_pds_lid='".$_SESSION['idPdsLid']."' and create_by ='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->queryColumn();
    	return $id[0];
    }
    public function actionIndexblid()
    {
    	$this->checkActive();
    	/*$id=$_SESSION['idPdsLid'];
    	$modelLid =PdsLid::findOne($id);
    	$modelStatus=Status::findOne($modelLid->id_status);
        $searchModel = new PdsLidSuratSearch();

        $idJenisSurat2='pidsus3blid';

        $dataProvider3b = $searchModel->search(Yii::$app->request->queryParams,$idJenisSurat2,$id);
         
        return $this->render('indexb', [
        		'id' =>$id,
    			'idJenisSurat2'=>$idJenisSurat2,
        		'modelLid'=>$modelLid,
        		'modelStatus' => $modelStatus,
        		'searchModel' => $searchModel,
        		'dataProvider3b' => $dataProvider3b,
        ]);
		*/
    	$_SESSION['startDatePidsus3']=new \DateTime($this->getStartDate('pidsus3alid'));
    	$_SESSION['startDatePidsus3']=$_SESSION['startDatePidsus3']->format('d m Y');
    	
		$model = PdsLidSuratforPidsus3::findOne($this->getIdPidsus3A('pidsus3blid'));
		$modelLid = $this->findModelLid($model->id_pds_lid);
		//$modelStatus=Status::findOne($modelLid->id_status);
		$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
		if ($model->load(Yii::$app->request->post()) ) {

			if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidTembusan::validateMultiple($modelTembusan)){
				$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();
				}
			}
			if(isset($_POST['new_tembusan'])){
				for($i = 0; $i < count($_POST['new_tembusan']); $i++){
					$modelNewTembusan= new PdsLidtembusan();
					$modelNewTembusan->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
					$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
					$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
					$modelNewTembusan->save();
				}
			}
			if(isset($_POST['hapus_tembusan'])){
				for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
					PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
				}
			}
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->save();
			//echo $model->id_status;
			$modelLid = $this->findModelLid($model->id_pds_lid);
			$modelLid->id_status=$model->id_status;
			$modelLid->update_by=(string)Yii::$app->user->identity->username;
			$modelLid->update_date=date('Y-m-d H:i:s');
			$modelLid->save();
			if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
				foreach($modelSuratIsi as $row){
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();

					//print_r($row->getErrors());
				}
			}
			if ($_POST['btnSubmit']=='simpan'){
				return $this->redirect(['../pidsus/default/viewlaporan','id'=>$model->id_pds_lid]);
			}
			else {
				$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
			}
		} else {
			return $this->render('update', [
				'model' => $model,
				'modelLid' => $modelLid,
				'modelSuratIsi' => $modelSuratIsi,
				'modelTembusan'	 =>$modelTembusan,
				'titleForm' => "",
				'readOnly' => false,
			]);
		}
    }
    public function actionIndexblit()
    {
    	$this->checkActive();
    	/*$id=$_SESSION['idPdsLid'];
    	$modelLid =PdsLid::findOne($id);
    	$modelStatus=Status::findOne($modelLid->id_status);
    	$searchModel = new PdsLidSuratSearch();
    
    	$idJenisSurat2='pidsus3blit';
    
    	$dataProvider3b = $searchModel->search(Yii::$app->request->queryParams,$idJenisSurat2,$id);
    	
    	return $this->render('indexb', [
				'id' =>$id,
    			'idJenisSurat2'=>$idJenisSurat2,
				'modelLid'=>$modelLid,	
				'modelStatus' => $modelStatus,
				'searchModel' => $searchModel,
				'dataProvider3b' => $dataProvider3b,
			]);
    	*/
    	$_SESSION['startDatePidsus3']=new \DateTime($this->getStartDate('pidsus3alit'));
    	$_SESSION['startDatePidsus3']=$_SESSION['startDatePidsus3']->format('d m Y');
    	
		$model = PdsLidSuratforPidsus3::findOne($this->getIdPidsus3A('pidsus3blit'));
		$modelLid = $this->findModelLid($model->id_pds_lid);
		//$modelStatus=Status::findOne($modelLid->id_status);
		$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
		if ($model->load(Yii::$app->request->post()) ) {

			if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidTembusan::validateMultiple($modelTembusan)){
				$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();
				}
			}
			if(isset($_POST['new_tembusan'])){
				for($i = 0; $i < count($_POST['new_tembusan']); $i++){
					$modelNewTembusan= new PdsLidtembusan();
					$modelNewTembusan->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
					$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
					$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
					$modelNewTembusan->save();
				}
			}
			if(isset($_POST['hapus_tembusan'])){
				for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
					PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
				}
			}
			$model->update_by=(string)Yii::$app->user->identity->username;
			$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->save();
			//echo $model->id_status;
			$modelLid = $this->findModelLid($model->id_pds_lid);
			$modelLid->id_status=$model->id_status;
			$modelLid->update_by=(string)Yii::$app->user->identity->username;
			$modelLid->update_date=date('Y-m-d H:i:s');
			$modelLid->save();
			if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
				foreach($modelSuratIsi as $row){
					$row->update_by=Yii::$app->user->identity->username;
					$row->update_date=date('Y-m-d H:i:s');
					$row->save();

					//print_r($row->getErrors());
				}
			}
			if ($_POST['btnSubmit']=='simpan'){
				return $this->redirect(['../pidsus/default/viewlaporan','id'=>$model->id_pds_lid]);
			}
			else {
				$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
			}
		} else {
			return $this->render('update', [
				'model' => $model,
				'modelLid' => $modelLid,
				'modelSuratIsi' => $modelSuratIsi,
				'modelTembusan'	 =>$modelTembusan,
				'titleForm' => "",
				'readOnly' => false,
			]);
		}
		
    }
    
    /**
     * Creates a new PdsLid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($idJenisSurat)
    {	
		return $this->redirect(['update','id'=>$this->getIdPidsus3B($idJenisSurat)]);
    	
    }

    /**
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {	
    	$model = PdsLidSuratforPidsus3::findOne($id);
    	$modelLid = $this->findModelLid($model->id_pds_lid);
    	//$modelStatus=Status::findOne($modelLid->id_status);
    	$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
    	$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
    	if ($model->load(Yii::$app->request->post()) ) {

    		if(PdsLidTembusan::loadMultiple($modelTembusan, Yii::$app->request->post()) && PdsLidTembusan::validateMultiple($modelTembusan)){
    			$noUrutTembusan=1;foreach($modelTembusan as $row){$row->no_urut=$noUrutTembusan;$noUrutTembusan++;
    				$row->update_by=Yii::$app->user->identity->username;
    				$row->update_date=date('Y-m-d H:i:s');
    				$row->save();
    			}
    		}
    		if(isset($_POST['new_tembusan'])){
    			for($i = 0; $i < count($_POST['new_tembusan']); $i++){
    				$modelNewTembusan= new PdsLidtembusan();
    				$modelNewTembusan->id_pds_lid_surat=$model->id_pds_lid_surat;
    				$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
    				$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
    				$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
    				$modelNewTembusan->save();
    			}
    		}
    		if(isset($_POST['hapus_tembusan'])){
    			for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
    				PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
    			}
    		}
    		$model->update_by=(string)Yii::$app->user->identity->username;
    		$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
    		$model->save();
    		//echo $model->id_status;
    		$modelLid = $this->findModelLid($model->id_pds_lid);
    		$modelLid->id_status=$model->id_status;
    		$modelLid->update_by=(string)Yii::$app->user->identity->username;
    		$modelLid->update_date=date('Y-m-d H:i:s');
    		$modelLid->save();
    		if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
    			foreach($modelSuratIsi as $row){
    				$row->update_by=Yii::$app->user->identity->username;
    				$row->update_date=date('Y-m-d H:i:s');
    				$row->save();
    
    				//print_r($row->getErrors());
    			}
    		}
    		$listPage='';
    		if($model->id_jenis_surat=='pidsus3blid')
    		$listPage='indexblid';
    		else $listPage='indexblit';
    		
    		if ($_POST['btnSubmit']=='simpan'){
    			return $this->redirect([$listPage]);
    		}
    		else {
    			$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
    		}
    	} else {
    		return $this->render('update', [
    				'model' => $model,
    				'modelLid' => $modelLid,
    				'modelSuratIsi' => $modelSuratIsi,
    				'modelTembusan'	 =>$modelTembusan,
    				'readOnly' => false,
    		]);
    	}
    }

    /**
     * Deletes an existing PdsLid model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {	
    	$model=PdsLidSuratforPidsus3::findOne($id);
    	$type=substr($model->id_jenis_surat,-3);
        PdsLidSuratforPidsus3::findOne($id)->delete();

        return $this->redirect(['indexb'.$type]);
    }

    /**
     * Finds the PdsLid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$modelLid,$type)
    {
        if (($model = PdsLidSuratforPidsus3::find()->where('id_jenis_surat=\''.$type.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
            return $model;
        } else {
    		throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelLid($id)
    {
    	if (($modelLid = PdsLid::findOne($id)) !== null) {
    		return $modelLid;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsLidTembusan::find()->where('id_pds_lid_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
    
    protected function isPidsus9Exist()
    {
    	if(($model=PdsLidSurat::find()->where(['id_jenis_surat'=>'pidsus9','flag'=>'1','id_pds_lid'=>$_SESSION['idPdsLid']])->one())!==null) return true;
    	else return false;
    }
}
