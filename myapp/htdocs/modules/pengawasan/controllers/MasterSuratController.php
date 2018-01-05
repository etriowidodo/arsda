<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\MasterSurat;
use app\modules\pengawasan\models\MasterSuratSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterSuratController implements the CRUD actions for MasterSurat model.
 */
class MasterSuratController extends Controller
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
     * Lists all MasterSurat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterSuratSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterSurat model.
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
     * Creates a new MasterSurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterSurat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MasterSurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MasterSurat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);

        $id = $_POST['id'];
        $jumlah = $_POST['jml'];
 
        for ($i=0; $i <$jumlah ; $i++) { 
            $pecah=explode(',', $id);
          
            MasterSurat::deleteAll(['id_surat'=>$pecah[$i]]); 
  
        }

        Yii::$app->getSession()->setFlash('success', [
            'type' => 'success',
            'duration' => 3000,
            'icon' => 'fa fa-users',
            'message' => 'Data Berhasil Dihapus',
            'title' => 'Hapus Data',
            'positonY' => 'top',
            'positonX' => 'center',
            'showProgressbar' => true,
        ]);

        return $this->redirect(['index']);
    }

    /**
     * Finds the MasterSurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MasterSurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterSurat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
