<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsTutMatrixPerkara;
use app\modules\pidsus\models\PdsTutSurat;
use app\modules\pidsus\models\PdsTutTersangka;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P7tutController implements the CRUD actions for PdsTutMatrixPerkara model.
 */
class P7tutController extends Controller
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
     * Lists all PdsTutMatrixPerkara models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if(isset($_SESSION['idPdsTut'])){
    		$idPdsTut=$_SESSION['idPdsTut'];
    	}
    	else if (isset($_SESSION['idPdsLid'])){
    		$modelPdsTut=PdsTut::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
    		$idPdsTut=$modelPdsTut->id_pds_tut;
    	}
    	else{
    		return $this->redirect(['../pidsus/tut/index?type=pratut']);
    	}
    	$modelSurat=$this-> findModelSurat($_SESSION['idPdsTut']);
    	$_SESSION['idPdsTutSurat']=$modelSurat->id_pds_tut_surat;
    	
        $dataProvider = new ActiveDataProvider([
            'query' => PdsTutMatrixPerkara::find()->where(['id_pds_tut_surat'=>$_SESSION['idPdsTutSurat'],'flag'=>'1'])->orderby('no_urut'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdsTutMatrixPerkara model.
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
     * Creates a new PdsTutMatrixPerkara model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsTutMatrixPerkara();

        if ($model->load(Yii::$app->request->post())) {
        	$model->id_pds_tut_surat=$_SESSION['idPdsTutSurat'];
        	$modelTersangka=PdsTutTersangka::find()->where(['id_pds_tut_tersangka'=>$model->id_tut_tersangka])->one();
        	$model->nama_tersangka=$modelTersangka->nama_tersangka;
        	$model->create_by=Yii::$app->user->identity->username;
        	$model->create_date=date('Y-m-d H:i:s');$model->flag='1';
        	$model->save();

        	return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdsTutMatrixPerkara model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
        	$modelTersangka=PdsTutTersangka::find()->where(['id_pds_tut_tersangka'=>$model->id_tut_tersangka])->one();
        	$model->nama_tersangka=$modelTersangka->nama_tersangka;
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
     * Deletes an existing PdsTutMatrixPerkara model.
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
     * Finds the PdsTutMatrixPerkara model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsTutMatrixPerkara the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsTutMatrixPerkara::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    protected function findModelSurat($id)
    {
    	if (($model = PdsTutSurat::find()->where('id_jenis_surat=\'p7tut\' and id_pds_tut=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model = new PdsTutSurat();
    		$model->id_pds_tut=$id;
    		$model->id_jenis_surat='p7tut';
    		$model->save();
    		$this->findModelSurat($id);
    		return $model;
    	}
    }
    
    public function actionDeletebatch(){
    	$id_pds_mp=$_POST['hapusPds'];
    	//echo $_POST['typeSurat'];
    	//print_r($id_pds_mp);die();
    	for($i=0;$i<count($id_pds_mp);$i++){
    		$model=PdsLidMatrixPerkara::findOne($id_pds_mp[$i]);
    		$model->flag='3';
    		$model->save();
    
    	}
    	return $this->redirect('/pidsus/p7tut');
    
    }
}
