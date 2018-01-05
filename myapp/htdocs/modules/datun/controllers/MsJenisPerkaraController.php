<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\MsJenisPerkara;
use app\modules\pidum\models\MsJenisPerkaraSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MsJenisPerkaraController implements the CRUD actions for MsJenisPerkara model.
 */
class MsJenisPerkaraController extends Controller
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
     * Lists all MsJenisPerkara models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsJenisPerkaraSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsJenisPerkara model.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return mixed
     */
    public function actionView($kode_pidana, $jenis_perkara)
    {
        return $this->render('view', [
            'model' => $this->findModel($kode_pidana, $jenis_perkara),
        ]);
    }

    /**
     * Creates a new MsJenisPerkara model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsJenisPerkara();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsJenisPerkara model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return mixed
     */
    public function actionUpdate($kode_pidana, $jenis_perkara)
    {
        $model = $this->findModel($kode_pidana, $jenis_perkara);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MsJenisPerkara model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return mixed
     */
    public function actionDelete($kode_pidana, $jenis_perkara)
    {
        $this->findModel($kode_pidana, $jenis_perkara)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MsJenisPerkara model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $kode_pidana
     * @param integer $jenis_perkara
     * @return MsJenisPerkara the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($kode_pidana, $jenis_perkara)
    {
        if (($model = MsJenisPerkara::findOne(['kode_pidana' => $kode_pidana, 'jenis_perkara' => $jenis_perkara])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
