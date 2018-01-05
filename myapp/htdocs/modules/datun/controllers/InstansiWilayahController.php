<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\InstansiWilayah;

class InstansiWilayahController extends Controller{

	public function actionIndex(){
		$searchModel  = new InstansiWilayah;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel'=>$searchModel]);
    }

    public function actionGetinstansi(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiWilayah;
			$hasil = $model->getInstansi(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $hasil;
		}    
	}

    public function actionGetkabupaten(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiWilayah;
			$hasil = $model->getKabupaten(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $hasil;
		}    
	}

	public function actionCreate(){
		$model = new InstansiWilayah;
		return $this->render('create', ['model'=>$model]);	
	}

    public function actionUpdate($id, $id2, $id3, $id4, $id5, $id6){
        $id1 = rawurldecode($id);
        $id2 = rawurldecode($id2);
        $id3 = rawurldecode($id3);
        $id4 = rawurldecode($id4);
        $id5 = rawurldecode($id5);
        $id6 = rawurldecode($id6);
		$sqlnya = "
			select a.*, b.deskripsi_jnsinstansi, c.deskripsi_instansi, d.deskripsi as nm_provinsi, e.deskripsi_kabupaten_kota as nm_kabupaten 
			from datun.instansi_wilayah a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
			join datun.m_propinsi d on a.kode_provinsi = d.id_prop 
			join datun.m_kabupaten e on a.kode_provinsi = e.id_prop and a.kode_kabupaten = e.id_kabupaten_kota 
			where a.kode_jenis_instansi = '".$id1."' and a.kode_instansi = '".$id2."' and a.kode_provinsi = '".$id3."' and a.kode_kabupaten = '".$id4."' 
				and a.kode_tk = '".$_SESSION['kode_tk']."' and a.no_urut = '".$id6."'";
		$model 	= InstansiWilayah::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionSimpan(){
        $model 	= new InstansiWilayah;
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
				return $this->redirect(['update', 'id' => rawurlencode($param['kode_jns']), 'id2' => rawurlencode($param['kode_ins']), 'id3' => rawurlencode($param['propinsi']), 
				'id4' => rawurlencode($param['kabupaten']), 'id5' => rawurlencode($param['kode_tk']), 'id6' => rawurlencode($param['no_urut'])]);
			}
		}
	}	
	
    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new InstansiWilayah;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
	
}