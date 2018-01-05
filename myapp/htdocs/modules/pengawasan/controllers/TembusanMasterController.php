<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\TembusanMaster;
use app\modules\pengawasan\models\TembusanMasterSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class TembusanmasterController extends Controller
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
     * Lists all InspekturModel models.
     * @return mixed
     */
    public function actionIndex()
    {
        //$searchModel = new TembusanMasterSearch();
        //$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $query = " select a.*, b.nama_wilayah from was.was_tembusan_master a inner join was.wilayah b on b.id_wilayah=a.kode_wilayah   
                ";
//print_r($query);exit;
      $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


    $dataProvider = new SqlDataProvider([
      'sql' => $query,
      'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
              'id_tembusan',
              'nama_tembusan',
              'for_tabel',
              'nama_wilayah'
         ],
     ],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
        $models = $dataProvider->getModels();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);




        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single InspekturModel model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new InspekturModel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new TembusanMaster();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
        
            return $this->redirect(['index']);
        }   else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing InspekturModel model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
        //Yii::$app->controller->enableCsrfValidation = false;
        //print_r($_POST);
        if(count($_POST['selection'])>0){
           
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            // return $this->redirect(['index']);
        }
        // $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the InspekturModel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InspekturModel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = TembusanMaster::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
