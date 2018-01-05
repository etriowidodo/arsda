<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsDikMatrixPerkara;
use app\modules\pidsus\models\PdsDikSuratforP7;
use app\modules\pidsus\models\PdsDikSurat;
use app\modules\pidsus\models\PdsDikTersangka;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * P7dikController implements the CRUD actions for PdsDikMatrixPerkara model.
 */
class P7dikController extends Controller
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
     * Lists all PdsDikMatrixPerkara models.
     * @return mixed
     */
    public function actionIndex()
    {
    	if(isset($_SESSION['idPdsDik'])){
    		$idPdsDik=$_SESSION['idPdsDik'];
    	}
    	else if (isset($_SESSION['idPdsLid'])){
    		$modelPdsDik=PdsDik::find()->where(['id_pds_lid_parent'=>$_SESSION['idPdsLid']])->one();
    		$_SESSION['idPdsDik']=$modelPdsDik->id_pds_dik;
    	}
    	else{
    		return $this->redirect(['../pidsus/default/index?type=dik']);
    	}
    	$modelSurat=$this-> findModelSurat($_SESSION['idPdsDik']);
    	$_SESSION['idPdsDikSurat']=$modelSurat->id_pds_dik_surat;
    	
        $dataProvider = new ActiveDataProvider([
            'query' => PdsDikMatrixPerkara::find()->where(['id_pds_dik_surat'=>$_SESSION['idPdsDikSurat'],'flag'=>'1'])->orderby('no_urut'),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdsDikMatrixPerkara model.
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
     * Creates a new PdsDikMatrixPerkara model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsDikMatrixPerkara();

        if ($model->load(Yii::$app->request->post())) {
        	$model->id_pds_dik_surat=$_SESSION['idPdsDikSurat'];
        	$modelTersangka=PdsDikTersangka::find()->where(['id_pds_dik_tersangka'=>$model->id_dik_tersangka])->one();
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
     * Updates an existing PdsDikMatrixPerkara model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) ) {
        	$modelTersangka=PdsDikTersangka::find()->where(['id_pds_dik_tersangka'=>$model->id_dik_tersangka])->one();
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
     * Deletes an existing PdsDikMatrixPerkara model.
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
     * Finds the PdsDikMatrixPerkara model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsDikMatrixPerkara the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsDikMatrixPerkara::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    

    protected function findModelSurat($id)
    {
    	if (($model = PdsDikSuratforP7::find()->where('id_jenis_surat=\'p7dik\' and id_pds_dik=\''.$id.'\'')->one()) !== null) {
    		return $model;
    	} else {
    		$model = new PdsDikSurat();
    		$model->id_pds_dik=$id;
    		$model->id_jenis_surat='p7dik';
    		$model->save();
    		$this->findModelSurat($id);
    		return $model;
    	}
    }
    
    public function actionDeletebatch(){
    	$id_pds_mp=$_POST['hapusPds'];
    	//die();
    	//echo $_POST['typeSurat'];
    	//print_r($id_pds_surat);die();
    	for($i=0;$i<count($id_pds_mp);$i++){
    		$model=PdsDikMatrixPerkara::findOne($id_pds_mp[$i]);
    		$model->flag='3';
    		$model->save();
    
    	}
    	return $this->redirect('/pidsus/p7dik');
    
    }
}
