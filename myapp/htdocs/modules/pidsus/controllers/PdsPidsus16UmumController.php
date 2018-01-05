<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPidsus16Umum;

class PdsPidsus16UmumController extends Controller{
    public function actionIndex(){
        $searchModel = new PdsPidsus16Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsPidsus16Umum;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetgldh(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsPidsus16Umum;
            $hasil = $model->getPenggeledahan(Yii::$app->request->post());
            return $this->renderAjax('_tambah_geledah', ['model'=>$hasil]);
        }
    }
    
    public function actionSetgldh(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsPidsus16Umum;
            $hasil = $model->setPenggeledahan(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
        } 
    }

    public function actionGetlistjaksagldh(){
		$searchModel = new PdsPidsus16Umum;
		$dataProvider = $searchModel->searchListJaksaGldh(Yii::$app->request->get());
		return $this->renderAjax('_list_jaksa_gldh', ['dataProvider' => $dataProvider]);
    }	

    public function actionGetsita(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsPidsus16Umum;
            $hasil = $model->getPenyitaan(Yii::$app->request->post());
            return $this->renderAjax('_tambah_sita', ['model'=>$hasil]);
        }    
    }

    public function actionSetsita(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsPidsus16Umum;
            $hasil = $model->setPenyitaan(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
        } 
    }

    public function actionGetlistjaksasita(){
		$searchModel = new PdsPidsus16Umum;
		$dataProvider = $searchModel->searchListJaksaSita(Yii::$app->request->get());
		return $this->renderAjax('_list_jaksa_sita', ['dataProvider' => $dataProvider]);
    }	

    public function actionUpdate($id1){
        $idnya 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum  
		from pidsus.pds_pidsus16_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
		where ".$where." and a.no_pidsus16_umum = '".$idnya."'";
		$model 	= PdsPidsus16Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new PdsPidsus16Umum;
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
				return $this->redirect(['update', 'id1' => $param['no_pidsus16_umum']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus16Umum;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1){
        $idnya 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum, b.laporan_pidana, b.tindak_pidana  
		from pidsus.pds_pidsus16_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
		where ".$where." and a.no_pidsus16_umum = '".$idnya."'";
		$model 	= PdsPidsus16Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    
