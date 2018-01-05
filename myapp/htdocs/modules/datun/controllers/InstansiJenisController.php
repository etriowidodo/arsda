<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\InstansiJenis;

class InstansiJenisController extends Controller{

	public function actionIndex(){
		$searchModel  = new InstansiJenis;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('index', ['dataProvider'=>$dataProvider, 'searchModel'=>$searchModel]);
    }

    public function actionUpdate($id){
        $id 	= rawurldecode($id);
		$sqlnya = "select * from datun.jenis_instansi where kode_jenis_instansi = '".$id."'";
		$model 	= InstansiJenis::findBySql($sqlnya)->asArray()->one();
        return $this->render('_form', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new InstansiJenis;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
			return $this->redirect(['update', 'id' => $param['kode']]);
		}
    }

}