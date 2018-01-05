<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\TemplateTembusan;
use app\modules\pidsus\models\TemplateSurat;


class TemplateTembusanController extends Controller{

	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        $searchModel = new TemplateSurat;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->get());
        return $this->render('index', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
        ]);
    }

    public function actionView($id){
        $searchModel  = new TemplateTembusan;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->get());
        return $this->render('view', ['dataProvider' => $dataProvider]);
    }

    public function actionSimpan(){
        $model 	= new TemplateTembusan;
		$param	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
        if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
            return $this->redirect(['view', 'id'=>$param['hdnId']]);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['view', 'id'=>$param['hdnId']]);
        }
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new TemplateTembusan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }
}