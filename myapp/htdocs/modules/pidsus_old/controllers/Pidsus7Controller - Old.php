<?php

namespace app\modules\pidsus\controllers;

use Yii;
use app\modules\pidsus\models\PdsLidSurat;
use app\modules\pidsus\models\PdsLidSuratJaksa;
use app\modules\pidsus\models\KpPegawai;
use app\modules\pidsus\models\pidsus9search;
use app\modules\pidsus\models\PdsLidSuratSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Pidsus9Controller implements the CRUD actions for PdsLidSurat model.
 */
class Pidsus7Controller extends Controller
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
     * Lists all PdsLidSurat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new Pidsus9Search();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdsLidSurat model.
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
     * Creates a new PdsLidSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
public function actionCreate()
    {
        $id=$_SESSION['idPdsLid'];
        $model = new PdsLidSurat();
		$modelJaksa= new PdsLidSuratJaksa();
		$modelKpPegawai= new KpPegawai();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id_pds_lid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            	'readOnly'=>false,	
            	'modelJaksa'=>$modelJaksa,
            	'modelKpPegawai'=>$modelKpPegawai,
            	'id'=>$id			
            ]);
        }
    }

    /**
     * Updates an existing PdsLidSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id_pds_lid_surat]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdsLidSurat model.
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
     * Finds the PdsLidSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdsLidSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdsLidSurat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
