<?php

namespace app\modules\pidum\controllers;

use app\modules\pidum\models\MsAsalsurat;
use app\modules\pidum\models\MsAsalsuratSearch;
use app\modules\pidum\models\PdmSpdp;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\web\Session;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\components\GlobalFuncComponent;

/**
 * AsalSuratController implements the CRUD actions for MsAsalsurat model.
 */
class AsalSuratController extends Controller
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
     * Lists all MsAsalsurat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsAsalsuratSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsAsalsurat model.
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
     * Creates a new MsAsalsurat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = new Session();
        $id_asalsurat = $session->get('id_asalsurat');
		$model = new MsAsalsurat();
		
        if ($model->load(Yii::$app->request->post())) {
            
            $seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.ms_asalsurat', 'id_asalsurat', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
			
			$model->kd_satker=Yii::$app->globalfunc->getSatker()->inst_satkerkd;
			 //print_r($model->kd_satker); exit();
		
			 
		if($model->id_asalsurat != null){
			$model->flag='1';	
			$model->save();
		}else{
			$model->id_asalsurat = $seq['generate_pk'];
			$model->save();
			}
            
                        
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
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsAsalsurat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
     * Deletes an existing MsAsalsurat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
        try{
            $id_asalsurat = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_asalsurat = $session->get('id_asalsurat');
				
				MsAsalsurat::updateAll(['flag' => '3'], "id_asalsurat = '" . $id_asalsurat . "'");
            }else{
                for($i=0;$i<count($id_asalsurat);$i++){
                MsAsalsurat::updateAll(['flag' => '3'], "id_asalsurat = '" . $id_asalsurat[$i] . "'");
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
     * Finds the MsAsalsurat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return MsAsalsurat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsAsalsurat::findOne($id)) !== null) {
            return $model;
        }
    }
	
	 protected function findModelSpdp($id)
    {
        if (($modelSpdp = PdmSpdp::findOne($id)) !== null) {
            return $modelSpdp;
        } 
    }
}
