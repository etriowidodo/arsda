<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Penandatangan;
use app\modules\pengawasan\models\PenandatanganSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * PenandatanganmasterController implements the CRUD actions for Penandatangan model.
 */
class PenandatanganmasterController extends Controller
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
     * Lists all Penandatangan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $query = " select a.*, b.nama_wilayah from was.penandatangan a inner join was.wilayah b on b.id_wilayah=a.id_tingkat_wilayah   
                ";
      $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


    $dataProvider = new SqlDataProvider([
      'sql' => $query,
      'totalCount' => (int)$jml,
      'sort' => [
          'attributes' => [
            'nip',
            'nama_penandatangan',
            'pangkat_penandatangan',
            'golongan_penandatangan',
            'nama_wilayah',
            'jabatan_penandatangan',
              //'id_kejagung_bidang',
              // 'nama_kejagung_bidang',
              // 'nama_inspektur',
              // 'akronim'
         ],
         'defaultOrder' => ['nama_penandatangan' => SORT_ASC],
     ],
     // 'sort'=> ['defaultOrder' => ['nama_penandatangan' => SORT_ASC]],
      'pagination' => [
          'pageSize' => 10,
      ]
]);
        // $searchModel = new PenandatanganSearch();
        $models = $dataProvider->getModels();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
        ]);


        
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);
    }

    /**
     * Displays a single Penandatangan model.
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
     * Creates a new Penandatangan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Penandatangan();
        $connection = \Yii::$app->db;
        $transaction = $connection->beginTransaction();
        
        if ($model->load(Yii::$app->request->post()) && $model -> validate()){
            try {    

                $model->save();
            $transaction->commit();
            return $this->redirect(['index']);
        
        } catch (Exception $e) {
            $transaction->rollback();
            echo "TES";
        }
        
        
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }

    }

    /**
     * Updates an existing Penandatangan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing Penandatangan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        Yii::$app->controller->enableCsrfValidation = false;
        // print_r($_POST);
        // exit();
        if(count($_POST['selection'])>0){
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            
        }

        return $this->redirect(['index']);

        // if($_POST['selection_all']==1){
        //     Penandatangan::deleteAll();
        //     return $this->redirect(['index']);
        // } else {
        //     foreach ($_POST['selection'] as $key => $value) {
        //         $this->findModel($value)->delete();
        //     }
        //     return $this->redirect(['index']);
        // }
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
    }

    /**
     * Finds the Penandatangan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Penandatangan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Penandatangan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
