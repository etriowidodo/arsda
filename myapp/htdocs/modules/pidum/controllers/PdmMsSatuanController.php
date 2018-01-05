<?php

namespace app\modules\pidum\controllers;

use app\modules\pidum\models\PdmMsSatuan;
use app\modules\pidum\models\PdmMsSatuanSearch;
use Yii;
use yii\web\Session;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * PdmMsSatuanController implements the CRUD actions for PdmMsSatuan model.
 */
class PdmMsSatuanController extends Controller
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
     * Lists all PdmMsSatuan models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PdmMsSatuanSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmMsSatuan model.
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
     * Creates a new PdmMsSatuan model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = new Session();
        $id = $session->get('id');
		//print_r($id); exit();
		$model = new PdmMsSatuan();
		
		$query = new Query;
        $query->select('count(*) as jlh')
                ->from('pidum.pdm_ms_satuan');
        $data = $query->createCommand();
        $listTersangka = $data->queryAll(); 
		$id = $listTersangka[0]['jlh']+1;
		
		if ($model->load(Yii::$app->request->post())) {
         	
			$model->id = $id;
			$model->nama = $_POST['PdmMsSatuan']['nama'];
			if($model->save()){     
				 Yii::$app->getSession()->setFlash('success', [
					'type' => 'success',
					'duration' => 3000,
					'icon' => 'fa fa-users',
					'message' => 'Data Berhasil di Simpan',
					'title' => 'Simpan Data',
					'positonY' => 'top',
					'positonX' => 'center',
					'showProgressbar' => true,
				]);         
			}
            return $this->redirect(['index']);   
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PdmMsSatuan model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
			
			Yii::$app->getSession()->setFlash('success', [
					'type' => 'success',
					'duration' => 3000,
					'icon' => 'fa fa-users',
					'message' => 'Data Berhasil di Simpan',
					'title' => 'Simpan Data',
					'positonY' => 'top',
					'positonX' => 'center',
					'showProgressbar' => true,
				]);         
			  return $this->redirect(['index']); 
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PdmMsSatuan model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete()
    {
       try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id = $session->get('id');
				
				PdmMsSatuan::updateAll(['flag' => '3'], "id = '" . $id . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                PdmMsSatuan::updateAll(['flag' => '3'], "id = '" . $id[$i] . "'");
                }
            }
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
        }catch (Exception $e){
            Yii::$app->getSession()->setFlash('success', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-users',
                        'message' => 'Data Gagal di Hapus',
                        'title' => 'Hapus Data',
                        'positonY' => 'top',
                        'positonX' => 'center',
                        'showProgressbar' => true,
                    ]);
            return $this->redirect(['index']);
        }
    }

    /**
     * Finds the PdmMsSatuan model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PdmMsSatuan the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmMsSatuan::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
