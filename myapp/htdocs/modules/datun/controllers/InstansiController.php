<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Instansi;

class InstansiController extends Controller{

	public function actionIndex(){
		$searchModel  = new Instansi;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel'=>$searchModel]);
    }

	public function actionCreate(){
		$model = new Instansi;
		return $this->render('create', ['model'=>$model]);	
	}

    public function actionUpdate($id, $id2){
        $id1 = rawurldecode($id);
        $id2 = rawurldecode($id2);
		$sqlnya = "select a.*, b.deskripsi_jnsinstansi from datun.instansi a join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
				   where a.kode_jenis_instansi = '".$id1."' and a.kode_instansi = '".$id2."' and a.kode_tk = '".$_SESSION['kode_tk']."'";
		$model 	= Instansi::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekinstansi(){
		if (Yii::$app->request->isAjax) {
			$model = new Instansi;
			$hasil = $model->cekInstansi(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new Instansi;
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
				return $this->redirect(['update', 'id' => rawurlencode($param['kode_jns']), 'id2'=>rawurlencode($param['kode_ins'])]);
			}
		}
	}	
	
    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Instansi;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
	
}