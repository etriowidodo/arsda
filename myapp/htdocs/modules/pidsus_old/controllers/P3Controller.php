<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLidRenlidforP3;
use app\modules\pidsus\models\PdsLidRenlid;
//use app\modules\pidsus\models\PdsLidSuratforP3;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidRenlidSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P3Controller implements the CRUD actions for PdsLidRenlid model.
 */
class P3Controller extends Controller
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
     * Lists all PdsLidRenlid models.
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
        $searchModel = new PdsLidRenlidSearch();
		$modelLid=PdsLid::findOne($id);

		$modelSurat=$this-> findModelSurat($id);
		$_SESSION['idPdsLidSurat']=$modelSurat->id_pds_lid_surat;
        $dataProvider = $searchModel->search($modelSurat->id_pds_lid_surat,Yii::$app->request->queryParams);
        if ($modelLid->load(Yii::$app->request->post())) {

        	$modelLid->save();
        	return $this->redirect(['../pidsus/default/index']);
        }
        return $this->render('index', [
        	'modelLid'=> $modelLid,	
        	'modelSurat'=>$modelSurat,	
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdsLidRenlid model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PdsLidRenlid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsLidRenlidforP3();
        $modelSurat = PdsLidSurat::findOne($_SESSION['idPdsLidSurat']);

        if ($model->load(Yii::$app->request->post())) {
        	$model->id_pds_lid_surat=$_SESSION['idPdsLidSurat'];
        	$model->create_by=(string)Yii::$app->user->identity->username;
            $model->create_ip =(string)$_SERVER['REMOTE_ADDR'];
            $model->flag='1';
        	$model->save();
          //  $modelSurat = PdsLidSurat::findOne($model->id_pds_lid_surat);

            $modelSurat->create_by=(string)Yii::$app->user->identity->username;
            $modelSurat->update_by=Yii::$app->user->identity->username;
            $modelSurat->update_date=date('Y-m-d H:i:s');$modelSurat->flag='1';
            $modelSurat->update_ip=(string)$_SERVER['REMOTE_ADDR'];
            $modelSurat->save();
        	//print_r($model->getErrors());
            return $this->redirect(['../pidsus/p3']);
        } else {
            return $this->render('create', [
            	'idLid' =>$_SESSION['idPdsLid'],
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsLidRenlid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
		$modelSurat = PdsLidSurat::findOne($model->id_pds_lid_surat);
		
        if ($model->load(Yii::$app->request->post()) ) {
        	$model->update_by=Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
           	$model->update_ip=(string)$_SERVER['REMOTE_ADDR'];
        	$model->save();
            $modelSurat->update_by=Yii::$app->user->identity->username;
            $modelSurat->update_date=date('Y-m-d H:i:s');$modelSurat->flag='1';
            $modelSurat->update_ip=(string)$_SERVER['REMOTE_ADDR'];

            $modelSurat->save();
        	return $this->redirect(['../pidsus/p3']);
        } else {
            return $this->render('update', [
            	'modelSurat'=>$modelSurat,
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdsLidRenlid model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
    	$model=$this->findModel($id);
    	$modelSurat=PdsLidSurat::findOne($model->id_pds_lid_surat);
        $model->delete();

        return $this->redirect(['index?id='.$modelSurat->id_pds_lid]);
    }

    /**
     * Finds the PdsLidRenlid model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLidRenlid the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsLidRenlidforP3::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    public function actionDeletebatchsurat(){
    	$id_pds_renlid=$_POST['hapusPds'];
    	//die();
    	//echo $_POST['typeSurat'];
    	//print_r($id_pds_surat);die();
    	for($i=0;$i<count($id_pds_renlid);$i++){
    		$model=PdsLidRenlidforP3::findOne($id_pds_renlid[$i]);
    		$model->flag='3';
    		$model->save();
    
    	}
    	return $this->redirect('/pidsus/p3');
    	 
    }
    
    protected function findModelSurat($id)
    {
    	if (($model = PdsLidSurat::find()->where('id_jenis_surat=\'p3\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model = new PdsLidSurat();
    		$model->id_pds_lid=$id;
    		$model->id_jenis_surat='p3';
    		$model->save();
    		$this->findModelSurat($id);
            return $model;
    	}
    }
}
