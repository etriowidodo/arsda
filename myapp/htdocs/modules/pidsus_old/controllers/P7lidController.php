<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLidMatrixPerkara;
use app\modules\pidsus\models\PdsLidSurat;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P7lidController implements the CRUD actions for PdsLidMatrixPerkara model.
 */
class P7lidController extends Controller
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
     * Lists all PdsLidMatrixPerkara models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if(empty($_SESSION['idPdsLid'])){
    		return $this->redirect(['../pidsus/default/index']);
    	}
    	$modelSurat=$this-> findModelSurat($_SESSION['idPdsLid']);
    	$_SESSION['idPdsLidSurat']=$modelSurat->id_pds_lid_surat;
        $dataProvider = new ActiveDataProvider([
            'query' => PdsLidMatrixPerkara::find()->where(['id_pds_lid_surat'=>$_SESSION['idPdsLidSurat'],'flag'=>'1'])->orderby('no_urut'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdsLidMatrixPerkara model.
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
     * Creates a new PdsLidMatrixPerkara model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsLidMatrixPerkara();

        if ($model->load(Yii::$app->request->post())) {
        	$model->id_pds_lid_surat=$_SESSION['idPdsLidSurat'];
        	$model->create_by=Yii::$app->user->identity->username;
        	$model->create_date=date('Y-m-d H:i:s');$model->flag='1';
        	$model->save();
			//print_r($model->getErrors());die();
        	return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsLidMatrixPerkara model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
        	$model->update_by=Yii::$app->user->identity->username;
        	$model->update_date=date('Y-m-d H:i:s');$model->flag='1';
        	$model->save();
        	return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdsLidMatrixPerkara model.
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
     * Finds the PdsLidMatrixPerkara model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLidMatrixPerkara the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsLidMatrixPerkara::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelSurat($id)
    {
    	if (($model = PdsLidSurat::find()->where('id_jenis_surat=\'p7lid\' and id_pds_lid=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model = new PdsLidSurat();
    		$model->id_pds_lid=$id;
    		$model->id_jenis_surat='p7lid';
    		$model->save();
    		$this->findModelSurat($id);
    		return $model;
    	}
    }
    
    public function actionDeletebatch(){
    	$id_pds_mp=$_POST['hapusPds'];
    	//print_r($id_pds_mp);die();
    	
    	for($i=0;$i<count($id_pds_mp);$i++){
    		$model=PdsLidMatrixPerkara::findOne($id_pds_mp[$i]);
    		$model->flag='3';
    		$model->save();
    		//print_r($model->getErrors());die();
    	}
    	return $this->redirect('/pidsus/p7lid');
    
    }
}
