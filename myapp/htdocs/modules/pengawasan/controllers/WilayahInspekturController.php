<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\WilayahInspektur;
use app\modules\pengawasan\models\WilayahInspekturSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * InspekturModelController implements the CRUD actions for InspekturModel model.
 */
class WilayahInspekturController extends Controller
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
        $searchModel = new WilayahInspekturSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

       /* print_r($dataProvider);
        exit();*/

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
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

        $model = new WilayahInspektur();

       /*  return $this->render('create', [
                'model' => $model,
            ]);
          print_r($model->load(Yii::$app->request->post()));
        exit();*/

       // print_r($model->load(Yii::$app->request->post()));
        if ($model->load(Yii::$app->request->post())){
           /* print_r($model);
            exit();
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();*/
            $model->id_wilayah  =$_POST['id_wilayah'];
            $model->id_kejati   =$_POST['id_kejati'];
            $model->id_inspektur=$_POST['id_inspektur'];
            $model->save(); 
        
            return $this->redirect(['index']);
        } else {

            return $this->render('create', [
                'model' => $model,
            ]);
        }
          /* try{

           }*/
        //print_r($model->load(Yii::$app->request->post()));
      //  if ($model->load(Yii::$app->request->post())){
       /*   echo $_POST['id_wilayah'];  
          exit(); */ 
        /*$model->id_wilayah  =$_POST['id_wilayah'];
        $model->id_kejati   =$_POST['id_kejati'];
        $model->id_inspektur=$_POST['id_inspektur'];
        $model->save(); 
        
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
    }

    /**
     * Updates an existing InspekturModel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id_inspektur,$id_wilayah,$id_kejati)
    {
        $model = $this->findModel($id_inspektur,$id_wilayah,$id_kejati);

        if ($model->load(Yii::$app->request->post()) && $model->save()){
            // return $this->redirect(['view', 'id' => $model->id_inspektur]);
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

       public function actionKejagung()
    {

        if($_POST['id'] != 0){
            $connection = \Yii::$app->db; 
            $wil = "select * from was.kejati order by id_kejati";
            $wilayah = $connection->createCommand($wil)->queryAll();
                          echo "<option  selected>-- Pilih --</option>";
            foreach ($wilayah as $key) {
                          echo "<option value='".$key['id_kejati']."'>".$key['nama_kejati']."</option>";
            }
            
        }else{
            $connection = \Yii::$app->db; 
            $wil = "select * from was.kejagung_bidang";  
            $wilayah = $connection->createCommand($wil)->queryAll(); 
                          echo "<option  selected>-- Pilih --</option>";
            foreach ($wilayah as $key) {
                          echo "<option value='".$key['id_kejagung_bidang']."'>".$key['nama_kejagung_bidang']."</option>";
            }
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
      //  print_r($_POST['selection_all']);
        $id_e  = explode(',', $_POST['id']);
        $id  = $_POST['id'];
        $jml = $_POST['jml'];
        for ($i=0; $i <$jml  ; $i++) { 
           // echo $id_e[$i];
            $id_f  = explode('#', $id_e[$i]);
            WilayahInspektur::deleteAll(["id_inspektur"=>$id_f[0],"id_wilayah"=>$id_f[1],"id_kejati"=>$id_f[2]]);
        }
        return $this->redirect(['index']);
       // echo $_POST['id'];
      /*  if($_POST['selection_all']==1){
            WilayahInspektur::deleteAll();
            return $this->redirect(['index']);
        } else {
            foreach ($_POST['selection'] as $key => $value) {
              // alert($value);
                $this->findModel($value)->delete();
            }
            return $this->redirect(['index']);
        }*/
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
    protected function findModel($id_inspektur,$id_wilayah,$id_kejati)
    {
        if (($model = WilayahInspektur::findBySql("select a.*,b.nama_wilayah,c.nama_kejati,d.nama_inspektur from was.wilayah_inspektur a
                                                   inner join was.wilayah b on a.id_wilayah=b.id_wilayah
                                                   inner join was.kejati c on a.id_kejati=c.id_kejati
                                                   inner join was.inspektur d on a.id_inspektur=d.id_inspektur 
                                                   where a.id_inspektur=".$id_inspektur." and  a.id_wilayah='".$id_wilayah."' and 
                                                   a.id_kejati='".$id_kejati."'")->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
