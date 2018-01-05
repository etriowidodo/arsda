<?php

namespace app\modules\datun\controllers;

use Yii;
use app\modules\datun\models\Pengadilan;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class PengadilanController extends Controller{
	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

    public function actionIndex(){
        $searchModel = new Pengadilan;
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(){
        $model = new Pengadilan;
		return $this->render('create', ['model' => $model]);
    }

    public function actionGetkabupaten(){
		if (Yii::$app->request->isAjax) {
			$model = new Pengadilan;
			$hasil = $model->getKabupaten(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $hasil;
		}    
	}

    public function actionCekwilayah(){
		if (Yii::$app->request->isAjax) {
			$model = new Pengadilan;
			$hasil = $model->cekWilayah(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionUpdate($id){
		$model 	= Pengadilan::findBySql("select * from datun.master_pengadilan where kode_pengadilan = '".rawurldecode($id)."'")->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionSimpan(){
        $model 	= new Pengadilan;
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
				return $this->redirect(['update', 'id' => rawurlencode($param['idr'])]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Pengadilan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
}
