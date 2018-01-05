<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\DasarSpWasMaster;
use app\modules\pengawasan\models\DasarSpWasMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DasarSpWasMasterController implements the CRUD actions for DasarSpWasMaster model.
 */
class DasarspmasterController extends Controller
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
     * Lists all DasarSpWasMaster models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new DasarSpWasMasterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single DasarSpWasMaster model.
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
     * Creates a new DasarSpWasMaster model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new DasarSpWasMaster();

        if ($model->load(Yii::$app->request->post())) {
            /*for ($i=0; $i < 5; $i++) {
               $modelSimpan = new DasarSpWasMaster();
               $modelSimpan->isi_dasar_spwas=$_POST['dasar'][$i];
               $modelSimpan->created_by = \Yii::$app->user->identity->id;
               $modelSimpan->updated_by = \Yii::$app->user->identity->id;
               $modelSimpan->created_ip = $_SERVER['REMOTE_ADDR'];
               $modelSimpan->urut = $i;
               $modelSimpan->save();

           }*/
           $model->created_by = \Yii::$app->user->identity->id;
           $model->updated_by = \Yii::$app->user->identity->id;
           $model->created_ip = $_SERVER['REMOTE_ADDR'];
           $model->save();

            // return $this->redirect(['view', 'id' => $model->id_dasar_spwas]);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing DasarSpWasMaster model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())){
            $model->updated_ip = $_SERVER['REMOTE_ADDR'];
            // return $this->redirect(['view', 'id' => $model->id_dasar_spwas]);
            $model->save();
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing DasarSpWasMaster model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);


        if(count($_POST['selection'])>0){
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            // return $this->redirect(['index']);
        }

            return $this->redirect(['index']);

        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    /**
     * Finds the DasarSpWasMaster model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return DasarSpWasMaster the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        //if (($model = DasarSpWasMaster::findOne(['tahun'=>$id])) !== null) {
        if (($model = DasarSpWasMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
