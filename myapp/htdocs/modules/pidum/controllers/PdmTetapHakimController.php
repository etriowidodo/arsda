<?php

namespace app\modules\pidum\controllers;

use Yii;
use app\modules\pidum\models\PdmTetapHakim;
use app\modules\pidum\models\pdmTetapHakimSearch;
use app\modules\pidum\models\PdmSpdp;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;

/**
 * PdmTetapHakimController implements the CRUD actions for PdmTetapHakim model.
 */
class PdmTetapHakimController extends Controller
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
     * Lists all PdmTetapHakim models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $searchModel = new pdmTetapHakimSearch();
        $dataProvider = $searchModel->search($id_perkara,Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PdmTetapHakim model.
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
     * Creates a new PdmTetapHakim model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $session = new Session();
        $id_perkara = $session->get('id_perkara');
        $model = new PdmTetapHakim();
	
		
        $modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);

        if ($model->load(Yii::$app->request->post())) {			
			$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tetap_hakim', 'id_thakim', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
              
			      
			if($model->id_perkara != null){
			$model->flag='1';	
			$model->save();
			
			}else{	
			
			$model->id_thakim = $seq['generate_pk'];
            $model->id_perkara = $id_perkara;
			$model->save();
			}
				
				
				//SIMPAN
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
				
        // if ($model->save()){
            // return $this->redirect(['index', 'id_thakim' => $model->id_thakim]);
        // }else {
            // $error = \kartik\widgets\ActiveForm::validate($model);
            // print_r($error);
            // echo $model->getError();
          //  }
		  
		  
        } else {
            return $this->render('create', [
                'model' => $model,
                'modelSpdp' => $modelSpdp,
            ]);
        }
    }

    /**
     * Updates an existing PdmTetapHakim model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id_thakim)
    {
		$session = new Session();
        $id_perkara = $session->get('id_perkara');
	
		$modelSpdp = PdmSpdp::findOne(['id_perkara' => $id_perkara]);
		
		$model = PdmTetapHakim::findOne(['id_thakim'=>$id_thakim]);
		
    if ($model->load(Yii::$app->request->post())) {
		$transaction = Yii::$app->db->beginTransaction();
			
		$seq = Yii::$app->db->createCommand("select public.generate_pk('pidum.pdm_tetap_hakim', 'id_thakim', '".\Yii::$app->globalfunc->getSatker()->inst_satkerkd."', '".date('Y')."')")->queryOne();
						
			      
			if($model->id_perkara != null){
			$model->flag='2';	
			$model->save();
			
			}else{	
			
			$model->id_thakim = $seq['generate_pk'];
            $model->id_perkara = $id_perkara;
			$model->save();
			}
			$transaction->commit();
				
			 //SIMPAN 
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
           // return $this->redirect(['view', 'id' => $model->id_thakim]);
        } else {
            return $this->render('update', [
                'model' => $model,
				'modelSpdp' =>$modelSpdp,
            ]);
        }
    }

    /**
     * Deletes an existing PdmTetapHakim model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete()
    {
		try{
            $id = $_POST['hapusIndex'];

            if($id == "all"){
                $session = new Session();
                $id_perkara = $session->get('id_perkara');

                PdmTetapHakim::updateAll(['flag' => '3'], "id_perkara = '" . $id_perkara . "'");
            }else{
                for($i=0;$i<count($id);$i++){
                   PdmTetapHakim::updateAll(['flag' => '3'], "id_thakim = '" . $id[$i] . "'");
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
     * Finds the PdmTetapHakim model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return PdmTetapHakim the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PdmTetapHakim::findOne($id)) !== null) {
            return $model;
        } 
    }
}
