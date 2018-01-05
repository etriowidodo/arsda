<?php

namespace app\controllers;

use Yii;
use app\models\PdmBa4Tersangka;
use app\models\PdmBa4TersangkaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PdmBa4TersangkaController implements the CRUD actions for PdmBa4Tersangka model.
 */
class PdmBa4TersangkaController extends Controller
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
     * Lists all PdmBa4Tersangka models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PdmBa4TersangkaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmBa4Tersangka model.
     * @param string $no_register_perkara
     * @param string $tgl_ba4
     * @param integer $no_urut_tersangka
     * @return mixed
     */
    public function actionView($no_register_perkara, $tgl_ba4, $no_urut_tersangka)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_register_perkara, $tgl_ba4, $no_urut_tersangka),
        ]);
    }

    /**
     * Creates a new PdmBa4Tersangka model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PdmBa4Tersangka();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'no_register_perkara' => $model->no_register_perkara, 'tgl_ba4' => $model->tgl_ba4, 'no_urut_tersangka' => $model->no_urut_tersangka]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmBa4Tersangka model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $no_register_perkara
     * @param string $tgl_ba4
     * @param integer $no_urut_tersangka
     * @return mixed
     */
    public function actionUpdate($no_register_perkara, $tgl_ba4, $no_urut_tersangka)
    {
        $model = $this->findModel($no_register_perkara, $tgl_ba4, $no_urut_tersangka);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'no_register_perkara' => $model->no_register_perkara, 'tgl_ba4' => $model->tgl_ba4, 'no_urut_tersangka' => $model->no_urut_tersangka]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdmBa4Tersangka model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $no_register_perkara
     * @param string $tgl_ba4
     * @param integer $no_urut_tersangka
     * @return mixed
     */
    public function actionDelete($no_register_perkara, $tgl_ba4, $no_urut_tersangka)
    {
        $this->findModel($no_register_perkara, $tgl_ba4, $no_urut_tersangka)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the PdmBa4Tersangka model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $no_register_perkara
     * @param string $tgl_ba4
     * @param integer $no_urut_tersangka
     * @return PdmBa4Tersangka the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_register_perkara, $tgl_ba4, $no_urut_tersangka)
    {
        if (($model = PdmBa4Tersangka::findOne(['no_register_perkara' => $no_register_perkara, 'tgl_ba4' => $tgl_ba4, 'no_urut_tersangka' => $no_urut_tersangka])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
