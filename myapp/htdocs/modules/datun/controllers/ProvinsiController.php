<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Provinsi;

class ProvinsiController extends Controller{
	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

	public function actionIndex(){
		$searchModel  = new Provinsi;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('index', ['dataProvider'=>$dataProvider, 'searchModel'=>$searchModel]);
    }

    public function actionCreate(){
        $model = new Provinsi;
		return $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id){
		$model 	= Provinsi::findBySql("select * from datun.m_propinsi where id_prop = '".rawurldecode($id)."'")->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekpropinsi(){
		if (Yii::$app->request->isAjax) {
			$model = new Provinsi;
			$hasil = $model->cekPropinsi(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new Provinsi;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($param['isNewRecord']){
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['create']);
			}
		} else{
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['update', 'id' => rawurlencode($param['kode'])]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Provinsi;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

}