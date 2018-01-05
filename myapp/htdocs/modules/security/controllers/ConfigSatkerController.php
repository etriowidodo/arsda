<?php

namespace app\modules\security\controllers;

use Yii;
use app\modules\security\models\ConfigSatker;
use app\modules\security\models\ConfigSatkerSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PdmConfigController implements the CRUD actions for PdmConfig model.
 */
class ConfigSatkerController extends Controller
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

    public function actionIndex()
    {
		$searchModel = new ConfigSatkerSearch;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(){
        $model = new ConfigSatkerSearch;
		return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id){
		$sql = "select a.*, b.inst_nama from pidum.pdm_config a join kepegawaian.kp_inst_satker b on a.kd_satker = b.inst_satkerkd where kd_satker = '".$id."'";
		$model 	= ConfigSatkerSearch::findBySql($sql)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionSimpan(){
        $model 	= new ConfigSatkerSearch;
		$param 	= Yii::$app->request->post();
        // print_r($param);exit;
		if($param['act']){

			$sukses = $model->simpanData($param);
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['create']);
			}
		} else{
			$sukses = $model->simpanData($param);

            
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['update', 'id' => $param['idr']]);
			}
		}
    }
}

