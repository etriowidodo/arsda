<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsB4Umum;

class PdsB4UmumController extends Controller{
    public function actionIndex(){
        $searchModel = new PdsB4Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsB4Umum;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetgldh(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $hasil = $model->getPenggeledahan(Yii::$app->request->post());
            return $this->renderAjax('_tambah_geledah', ['model'=>$hasil]);
        }
    }
    
    public function actionListgldh(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $hasil = $model->listPenggeledahan(Yii::$app->request->get());
            return $this->renderAjax('_list_geledah', ['dataProvider'=>$hasil]);
        }
    }
    
    public function actionSetgldh(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $hasil = $model->setPenggeledahan(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
        } 
    }

    public function actionGetsita(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $hasil = $model->getPenyitaan(Yii::$app->request->post());
            return $this->renderAjax('_tambah_sita', ['model'=>$hasil]);
        }    
    }
    
    public function actionListsita(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $hasil = $model->listPenyitaan(Yii::$app->request->get());
            return $this->renderAjax('_list_sita', ['dataProvider'=>$hasil]);
        }    
    }

    public function actionSetsita(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $hasil = $model->setPenyitaan(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
        } 
    }

    public function actionUpdate($id1){
        $no_b4_umum = rawurldecode($id1);
		$_SESSION['pidsus_no_b4_umum'] 	= $no_b4_umum;

		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum  
		from pidsus.pds_b4_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
		where ".$where." and a.no_b4_umum = '".$no_b4_umum."'"; //echo $sqlnya; exit;
		$model 	= PdsB4Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekb4umum(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsB4Umum;
            $nilai = $model->cekB4Umum(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

	public function actionSimpan(){
        $model 	= new PdsB4Umum;
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
				return $this->redirect(['update', 'id1' => $param['no_b4_umum']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsB4Umum;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1){
        $no_b4_umum = rawurldecode($id1);

        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
        $sqlnya = "
        select a.*, b.tgl_p8_umum, b.laporan_pidana, b.no_p8_umum  
        from pidsus.pds_b4_umum a 
        join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
        where ".$where." and a.no_b4_umum = '".$no_b4_umum."'"; //echo $sqlnya; exit;
        $model 	= PdsB4Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    