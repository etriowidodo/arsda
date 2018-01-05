<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLid;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratIsi;
use app\modules\pidsus\models\PdsLidSuratDetail;
use app\modules\pidsus\models\PdsLidSearch;
use app\modules\pidsus\models\StatusSurat;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PidsusController implements the CRUD actions for PdsLid model.
 */
class UnusedController extends Controller
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
        $searchModel = new PdsLidSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
		
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdsLid model.
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
     * Creates a new PdsLid model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdsLid();
        
        if ($model->load(Yii::$app->request->post())) {
        	$connection = Yii::$app->db;
        	$transaction = $connection->beginTransaction();
        	$model->attributes = Yii::$app->request->post('PdsLid');
        	$model->create_by=(string)Yii::$app->user->identity->username;
        	$model->id_satker='3371';
        	$model->id_status=1;
        	$model->save();
        	print_r($model->getErrors());
            $transaction->commit();
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            	'typeSurat' =>'p1',
            	'titleForm'=>'Input Laporan/Pengaduan',
            ]);
        }
    }

    /**
     * Updates an existing PdsLid model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
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
            return $this->render('update', [
                'model' => $model,
                'typeSurat'=>'1',
            	'titleForm'=>'Update Laporan/Pengaduan',
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
    protected function findModel($id)
    {
        if (($model = PdsLid::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
