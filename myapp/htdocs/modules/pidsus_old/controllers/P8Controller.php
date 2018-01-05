<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidTembusan;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratJaksa;
use app\modules\pidsus\models\PdsLidJaksa;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\Pidsus2Search;
use app\modules\pidsus\models\KpPegawaiSearch2;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P2Controller implements the CRUD actions for PdsLid model.
 */
class P8Controller extends Controller
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
     
    public function actionIndex()
    {
        $searchModel = new Pidsus2Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
	*/

    /**
     * Creates a new PdsLid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsDik();
		
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_lid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionIndex()
    {	
    	if(isset($_SESSION['idPdsLid'])){
    		$idPdsLid=$_SESSION['idPdsLid'];
    	}
    	else{
    		return $this->redirect(['../pidsus/default/index']);
    	}
        //$modelLid = $this->findModelLid($idPdsLid);
        $model = $this->findModel($idPdsLid,'p8');
		$modelTembusan= PdsLidTembusan::findBySql('select * from pidsus.select_surat_tembusan(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->orderby('no_urut')->all(); 
		$modelSuratIsi= PdsLidSuratIsi::findBySql('select * from pidsus.select_surat_isi(\''.$model->id_pds_lid_surat.'\',\''.Yii::$app->user->id.'\')')->all();
		$modelJaksa=PdsLidSuratJaksa::find()->where('id_pds_lid_surat=\''.$model->id_pds_lid_surat.'\' order by no_urut')->all();

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
	        		$modelNewTembusan= new PdsDiktembusan();
	        		$modelNewTembusan->id_pds_dik_surat=$model->id_pds_dik_surat;
	        		$modelNewTembusan->no_urut=$noUrutTembusan;$noUrutTembusan++;
	        		$modelNewTembusan->tembusan=$_POST['new_tembusan'][$i];
					$modelNewTembusan->create_by=(string)Yii::$app->user->identity->username;
					$modelNewTembusan->save();
        		}
        	}
        	if(PdsLidSuratIsi::loadMultiple($modelSuratIsi, Yii::$app->request->post()) ){
        		foreach($modelSuratIsi as $row){
        			$row->update_by=Yii::$app->user->identity->username;
        			$row->update_date=date('Y-m-d H:i:s');
        			$row->save();        	
        		}
        	}
        	if(isset($_POST['hapus_tembusan'])){
        		for($i=0; $i<count($_POST['hapus_tembusan']);$i++){
        			PdsLidtembusan::deleteAll(['id_pds_lid_tembusan' => $_POST['hapus_tembusan'][$i]]);
        		}
        	}
        	
        	if(isset($_POST['nip_jpu'])){
        		$nip_jpu=$_POST['nip_jpu'];
        	}
        	else $nip_jpu=null;
        		
        	if(isset($_POST['hapus_jpu'])){
        		$hapus_jpu=$_POST['hapus_jpu'];
        	}
        	else $hapus_jpu=null;
        	
        	if ($hapus_jpu!=null){
        		for($i = 0; $i < count($hapus_jpu); $i++){
        			//PdsLidJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_lid'=>$id]);
					PdsLidJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_lid'=>$model->id_pds_lid]);
        			PdsLidSuratJaksa::deleteAll(['id_jaksa' => $hapus_jpu[$i], 'id_pds_lid_surat'=>$model->id_pds_lid_surat]);
        		}
        	}
        	
        	if ($nip_jpu!=null){
        		for($i = 0; $i < count($nip_jpu); $i++){
        			$modelJaksaSurat= new PdsLidSuratJaksa();
        			$modelJaksaMain = new PdsLidJaksa();
        			$modelJaksaSurat->create_by=(string)Yii::$app->user->identity->username;
        			$modelJaksaMain->create_by=(string)Yii::$app->user->identity->username;
        			$modelJaksaSurat->id_pds_lid_surat=$model->id_pds_lid_surat;
        			$modelJaksaMain->id_pds_lid=$model->id_pds_lid;
					//$modelJaksaMain->id_pds_lid=$id;
        			$modelJaksaSurat->id_jaksa=$nip_jpu[$i];
        			$modelJaksaMain->id_jaksa=$nip_jpu[$i];
        			$modelJaksaSurat->save();
        			$modelJaksaMain->save();
        		}
        	}
        	
        	$model->update_by=(string)Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
        	if ($_POST['btnSubmit']=='simpan'){
        		return $this->redirect(['../pidsus/default/viewlaporan','id'=>$idPdsLid]);
        	}
        	else {
        		$_SESSION['cetak']=1; return $this->refresh();   //return $this->redirect(['../pidsus/default/viewreport', 'id'=>$model->id_pds_lid_surat]);
        	}
        } else {
            return $this->render('update', [
                'model' => $model,
            	'modelJaksa' => $modelJaksa,	
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
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdsLid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id,$jenisSurat,$isNew=false)
    {
        if (($model = PdsLidSurat::find()->where('id_jenis_surat=\''.$jenisSurat.'\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
            
        	return $model;
        } else {
            $model= new PdsLidSurat();
			$model->id_pds_lid=$id;
			$model->id_jenis_surat=$jenisSurat;
			$model->create_by=(string)Yii::$app->user->identity->username;
			$model->create_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
			$model->save();
			return $this->findModel($id,$jenisSurat);
        }
    }
    protected function findModelDik($id)
    {
    	if (($modelDik = PdsDik::findOne($id)) !== null) {
    		return $modelDik;
    	} else {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    }
    protected function findModelTembusan($id)
    {
    	return $model = PdsDiktembusan::find()->where('id_pds_dik_surat=\''.$id.'\'')->orderBy('no_urut')->all();
    }
    
    public function actionJpu()
    {  // $model->id_satker=$_SESSION['idSatkerUser'];
    $searchModel = new KpPegawaiSearch2();
    $dataProvider = $searchModel->searchBySatker(Yii::$app->request->queryParams,$_SESSION['idSatkerUser']);
    $dataProvider->pagination->pageSize=10;
    return $this->renderAjax('_jpu', [
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    ]);
    }
}
