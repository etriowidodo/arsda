<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\Cabjari;
use app\modules\pengawasan\models\CabjariSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\SqlDataProvider;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class CabjarimasterController extends Controller
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
        // $query = " select a.*, b.nama_kejari, c.nama_kejati from was.cabjari a inner join was.kejari b or was.cabjari a inner join was.kejati c on b.id_kejari=a.id_kejari, c.id_kejati=a.id_kejati";
        $query="select a.*,b.nama_kejari,c.nama_kejati from was.cabjari a inner join was.kejari b on a.id_kejari=b.id_kejari and a.id_kejati=b.id_kejati inner join was.kejati c on b.id_kejati=c.id_kejati and a.id_kejati=c.id_kejati and id_cabjari not in ('-1') order by id_cabjari";
        $jml = Yii::$app->db->createCommand(" select count(*) from (".$query.")a ")->queryScalar();


        $dataProvider = new SqlDataProvider([
            'sql' => $query,
            'totalCount' => (int)$jml,
            'sort' => [
            'attributes' => [
                //'id_kejagung_bidang',
                'nama_cabjari',
                'nama_kejari',
                'nama_kejati',
                'akronim',
                'inst_lokinst',
                'inst_alamat',
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

        // $searchModel = new CabjariSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $model = new Cabjari();

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

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            // return $this->redirect(['view', 'id' => $model->id_inspektur]);
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
        if($_POST['selection_all']==1){
            Cabjari::deleteAll();
            return $this->redirect(['index']);
        } else {
            foreach ($_POST['selection'] as $key => $value) {
                $this->findModel($value)->delete();
            }
            return $this->redirect(['index']);
        }
        // $this->findModel($id)->delete();

        // return $this->redirect(['index']);
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
        if (($model = Cabjari::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
