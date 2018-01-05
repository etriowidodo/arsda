<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use app\modules\pengawasan\models\SuratPeraturan;
use app\modules\pengawasan\models\SuratPeraturanSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Command;
use yii\db\Query;

/**
 * SuratPeraturanController implements the CRUD actions for SuratPeraturan model.
 */
class SuratPeraturanController extends Controller
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
     * Lists all SuratPeraturan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SuratPeraturanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SuratPeraturan model.
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
     * Creates a new SuratPeraturan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SuratPeraturan();

        if ($model->load(Yii::$app->request->post())){

            $jml = count($_POST['id_peraturan']);
            for ($i=0; $i < $jml; $i++) { 
                $modelSave = new SuratPeraturan();
                $modelSave->id_peraturan=$_POST['id_peraturan'][$i];
                $modelSave->is_order=$_POST['is_order'][$i];
                $modelSave->id_surat=$_POST['SuratPeraturan']['id_surat'];
                $modelSave->save(); 
            }
            
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SuratPeraturan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $connection = \yii::$app->db;
        $sql = "select*from was.surat_peraturan a inner join was.ms_peraturan b on a.id_peraturan = b.id_peraturan where a.id_surat='".$id."'";
        $modelSurat = $connection->createCommand($sql)->queryAll();
        // $modelSurat = SuratPeraturan::findAll(['id_surat'=>$id]);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('index');
        } else {
            return $this->render('update', [
                'model' => $model,
                'modelSurat' => $modelSurat,
            ]);
        }
    }

    /**
     * Deletes an existing SuratPeraturan model.
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
          
            SuratPeraturan::deleteAll(['id'=>$pecah[$i]]); 
  
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
     * Finds the SuratPeraturan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SuratPeraturan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SuratPeraturan::findOne(['id_surat'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
