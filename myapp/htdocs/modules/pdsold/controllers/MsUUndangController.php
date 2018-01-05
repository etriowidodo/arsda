<?php

namespace app\modules\pdsold\controllers;

use Yii;
use app\modules\pdsold\models\MsUUndang;
use app\modules\pdsold\models\MsUUndangSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
/**
 * MsUUndangController implements the CRUD actions for MsUUndang model.
 */
class MsUUndangController extends Controller
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
     * Lists all MsUUndang models.
     * @return mixed
     */
    public function actionIndex()
    {
		$session = new Session();
        $session->remove('id_perkara');
		$session->remove('nomor_perkara');
		$session->remove('tgl_perkara');
		$session->remove('tgl_terima');
		
        $searchModel = new MsUUndangSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsUUndang model.
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
     * Creates a new MsUUndang model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsUUndang();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsUUndang model.
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
     * Deletes an existing MsUUndang model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        $id = $_POST['hapusIndex'];

        if($id[0] == 'all'){ 
            try{          
                    MsUUndang::deleteAll();  
                }catch (\yii\db\Exception $e) {
                          $count =1;
                } 
             if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  ' Data Undang undag Tidak Dapat Dihapus Karena Sudah Digunakan Di Referensi Lainya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }      
        }
        else
        {
             $count = 0;
           foreach($id AS $key_delete => $delete){
             try{
                    MsUUndang::deleteAll(['id' => $delete]);
                }catch (\yii\db\Exception $e) {
                  $count++;
                }
            }
            if($count>0){
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'danger',
                     'duration' => 5000,
                     'icon' => 'fa fa-users',
                     'message' =>  $count.' Data Undang undag Tidak Dapat Dihapus Karena Sudah Digunakan Di Referensi Lainya',
                     'title' => 'Error',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                 ]);
                 return $this->redirect(['index']);
            }
            else
            {
                Yii::$app->getSession()->setFlash('success', [
                     'type' => 'success',
                     'duration' => 3000,
                     'icon' => 'fa fa-users',
                     'message' => 'Data Berhasil di Hapus',
                     'title' => 'Hapus Data',
                     'positonY' => 'top',
                     'positonX' => 'center',
                     'showProgressbar' => true,
                     ]);

                return $this->redirect(['index']);
            }
        }
        // $this->findModel($id)->delete();
		
		
    }

    /**
     * Finds the MsUUndang model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsUUndang the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
		$data = explode("#",$id);
		$uu = $data[0];
		//$pasal = $data[1];
        if (($model = MsUUndang::findOne(['id'=>$uu])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}