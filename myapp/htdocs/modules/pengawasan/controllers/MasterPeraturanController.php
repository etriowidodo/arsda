<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\MasterPeraturan;
use app\modules\pengawasan\models\MasterPeraturanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MasterPeraturanController implements the CRUD actions for MasterPeraturan model.
 */
class MasterPeraturanController extends Controller
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
     * Lists all MasterPeraturan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MasterPeraturanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MasterPeraturan model.
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
     * Creates a new MasterPeraturan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MasterPeraturan();

        if ($model->load(Yii::$app->request->post())) {
           
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                
                $model->created_ip  = $_SERVER['REMOTE_ADDR'];
                $model->created_time=date('Y-m-d h:i:sa');
                $model->created_by  = \Yii::$app->user->identity->id;
                
            if($model->save()){
                 
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Berhasil Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                $transaction->commit(); 
                return $this->redirect(['index']);  
                }
                else{
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Gagal Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                return $this->redirect(['index']);  
                }
                
                } catch(Exception $e) {
                    $transaction->rollback();
                }

        }else{
            return $this->render('create', [
                'model' => $model,
               
            ]);
        
        }

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //     return $this->redirect(['view', 'id' => $model->id_peraturan]);
        // } else {
        //     return $this->render('create', [
        //         'model' => $model,
        //     ]);
        // }
    }

    /**
     * Updates an existing MasterPeraturan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
           
            $connection = \Yii::$app->db;
            $transaction = $connection->beginTransaction();
            try {
                
                $model->updated_ip  = $_SERVER['REMOTE_ADDR'];
                $model->updated_time=date('Y-m-d h:i:sa');
                $model->updated_by  = \Yii::$app->user->identity->id;
                
            if($model->save()){
                 
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'success',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Berhasil Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                $transaction->commit(); 
                return $this->redirect(['index']);  
                }
                else{
                Yii::$app->getSession()->setFlash('success', [
                 'type' => 'danger',
                 'duration' => 3000,
                 'icon' => 'fa fa-users',
                 'message' => 'Data Gagal Disimpan',
                 'title' => 'Simpan Data',
                 'positonY' => 'top',
                 'positonX' => 'center',
                 'showProgressbar' => true,
                 ]);
                return $this->redirect(['index']);  
                }
                
                } catch(Exception $e) {
                    $transaction->rollback();
                }

        }else{
            return $this->render('update', [
                'model' => $model,
               
            ]);
        
        }
         
    }

    /**
     * Deletes an existing MasterPeraturan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        print_r('sadsdsads');
        exit();
        $id=$_POST['id'];
         
        $jml=$_POST['jml'];
        // echo $jml;
        for ($i=0; $i < $jml; $i++) { 
        $pecah=explode(',', $id);
        MasterPeraturan::deleteAll(['id_peraturan'=>$pecah[$i]]);
        }
        return $this->redirect(['index']); 
    }

    /**
     * Finds the MasterPeraturan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MasterPeraturan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MasterPeraturan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
