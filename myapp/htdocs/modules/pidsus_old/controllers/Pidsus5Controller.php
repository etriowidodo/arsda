<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidSuratforPidsus5;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsLidSuratSearch;
use app\modules\pidsus\models\PdsLidPermintaanData;
use app\modules\pidsus\models\PdsLidUsulanPermintaanData;
use app\modules\pidsus\models\Status;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class Pidsus5Controller extends Controller
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
    public function actionIndex()
    {
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
    	$id=$_SESSION['idPdsLid'];
    	if (!isset($_SESSION['idPdsLid'])){
    		return $this->redirect(['../pidsus/default/index']);
    	}
    	$modelLid =PdsLid::findOne($id);
    	//$modelStatus=Status::findOne($modelLid->id_status);
        $searchModel = new PdsLidSuratSearch();

        $dataProvider5a = $searchModel->search(Yii::$app->request->queryParams,'pidsus5a',$id);
        $dataProvider5b = $searchModel->search(Yii::$app->request->queryParams,'pidsus5b',$id);
        $dataProvider5c = $searchModel->search(Yii::$app->request->queryParams,'pidsus5c',$id);
       		
		if ($modelLid->load(Yii::$app->request->post())) {
			$modelLid->save();
			$modelLidSurat=PdsLidSuratforPidsus5::find()->where('id_pds_lid=\''.$id.'\' and (id_jenis_surat in (\'pidsus5a\',\'pidsus5b\',\'pidsus5c\'))')->all();
			foreach($modelLidSurat as $modelLidSuratRow){
				$modelLidSuratRow->id_status=$modelLid->id_status;
				$modelLidSuratRow->save();
			}
			return $this->redirect(['../pidsus/default/index']);
		}
			return $this->render('index', [
				'id' =>$id,
				'modelLid'=>$modelLid,	
				//'modelStatus' => $modelStatus,
				'searchModel' => $searchModel,
				'dataProvider5a' => $dataProvider5a,
				'dataProvider5b' => $dataProvider5b,
				'dataProvider5c' => $dataProvider5c,
			]);
		
    }

    public function actionCreate($idJenisSurat,$id)
    {
    
    	$modelLid = $this->findModelLid($id);
    	$model = new PdsLidSurat();
    	$modelTembusan = new PdsLidTembusan();
    	$modelSuratIsi = new PdsLidSuratIsi();
    	$model->id_jenis_surat=$idJenisSurat;
    	if($idJenisSurat=='pidsus5a'){
    		$model->perihal_lap='Permintaan Keterangan';
    	}
    	else if($idJenisSurat=='pidsus5b'){
    		$model->perihal_lap='Bantuan Pemanggilan';
    	}
    	else if($idJenisSurat=='pidsus5c'){
    		$model->perihal_lap='Bantuan Permintaan Data/Tindakan lain .... (*)';
    	}
    	$model->id_pds_lid=$modelLid->id_pds_lid;
        $model->create_by=(string)Yii::$app->user->identity->username;
		$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
		$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
		$model->save();    
		$model= PdsLidSuratforPidsus5::findBySql("select * from pidsus.pds_lid_surat where id_pds_lid='".$modelLid->id_pds_lid."' and id_jenis_surat='".$idJenisSurat."' and create_by='".(string)Yii::$app->user->identity->username."' order by create_date desc limit 1")->one();
			
    	return $this->redirect(['update?id='.$model->id_pds_lid_surat]);
    	
    }

    public function getStartDate($jenisSurat){
    	$modelPidsus4=PdsLidSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$_SESSION['idPdsLid'].'\'')->one();
    	return $modelPidsus4->tgl_surat;
    }
    public function actionUpdate($id)
    {	
    	
    	$model = PdsLidSuratforPidsus5::findOne($id);
        $modelLid = $this->findModelLid($model->id_pds_lid);
        $_SESSION['startDatePidsus5']=new \DateTime($this->getStartDate('pidsus4'));
        $_SESSION['startDatePidsus5']=$_SESSION['startDatePidsus5']->format('d m Y');
         
    	//$modelStatus=Status::findOne($modelLid->id_status);
    	$modelPermintaanData=PdsLidPermintaanData::find()->where(['id_pds_lid_surat'=>$model->id_pds_lid_surat])->all();
        $modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(trim(\''.$model->id_pds_lid_surat.'\'),\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all();
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		$modelPermintaanData4=PdsLidUsulanPermintaanData::findBySql('select * from pidsus.pds_lid_usulan_permintaan_data where id_pds_lid_surat in (select id_pds_lid_surat from pidsus.pds_lid_surat where id_jenis_surat=\'pidsus4\' and id_pds_lid=\''.$model->id_pds_lid.'\' )')->all();
		if(isset($_SESSION['cetak'])){
			$_SESSION['cetak']=null;
			$link = "<script>window.open(\"../../pidsus/default/viewreport?id=$model->id_pds_lid_surat\")</script>";
			echo $link;
		}
        if ($model->load(Yii::$app->request->post()) ) { 
        	
			if(isset($_POST['hapus_pd'])){
				//print_r($_POST['hapus_pd']);
				for($i = 0; $i < count($_POST['hapus_pd']); $i++){
					PdsLidPermintaanData::deleteAll(['id_pds_lid_permintaan_data' => $_POST['hapus_pd'][$i], 'id_pds_lid_surat'=>$id]);
				}
			}

			if(isset($_POST['id_pd_insert'])){
				for($i = 0; $i < count($_POST['id_pd_insert']); $i++){
					$modelUpd= PdsLidUsulanPermintaanData::findOne($_POST['id_pd_insert'][$i]);
					$modelPd= new PdsLidPermintaanData();
					$modelPd->id_pds_lid_surat=$model->id_pds_lid_surat;
					$modelPd->nama_tindakan_lain=$_POST['nama_pd_insert'][$i];
					$modelPd->jenis_permintaan_data=0;
					$modelPd->create_by=(string)Yii::$app->user->identity->username;
					$modelPd->update_by=Yii::$app->user->identity->username;
					$modelPd->update_date=date('Y-m-d H:i:s');
					$modelPd->save();
					//print_r($modelPd->getErrors());
					
				}
				//die();
			}

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
        	
        	if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();
        	
        			//print_r($row->getErrors());
        		}
        	}
	        if ($_POST['btnSubmit']=='simpan'){
	        		return $this->redirect(['index']);        	
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
            	'modelPermintaanData' => $modelPermintaanData,	
            	'modelPermintaanData4' => $modelPermintaanData4,	
            	'titleForm' => "",	
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
    	pdsLidPermintaanData::deleteAll(['id_pds_lid_surat' => $id]);
    	$modelLidSurat=$this->findModel($id);
    	$idPdsLid=$modelLidSurat->id_pds_lid;
        $modelLidSurat->delete();
        return $this->redirect(['index?id='.$idPdsLid]);
    }

    /**
     * Finds the PdsLid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsLidSuratforPidsus5::find()->where('id_pds_lid_surat=\''.$id.'\'')->one()) !== null) {
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
}
