<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP8Khusus;

class PdsP8KhususController extends Controller{
    public function actionIndex(){
		$_SESSION['no_spdp'] 	= "";
		$_SESSION['tgl_spdp'] 	= "";
		$_SESSION['no_berkas'] 	= "";
		$_SESSION['pidsus_no_p8_umum'] = "";
		$_SESSION['pidsus_no_pidsus18'] = "";
		$_SESSION['pidsus_no_p8_khusus'] = "";
		$searchModel = new PdsP8Khusus;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetpidsus18(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsP8Khusus;
            $dataProvider = $searchModel->searchpidsus18(Yii::$app->request->get());
            return $this->renderAjax('_getpidsus18', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionGettsk(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Khusus;
            $hasil = $model->getTersangka(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        } 
    }
    
    public function actionGetjaksa(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Khusus;
            $hasil = $model->getJaksa(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        } 
    }
    
    public function actionGetjp(){
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_tambah_jp');
        }
    }
    
    public function actionCreate(){
        $model  = new PdsP8Khusus;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($id1, $id2, $id3){
        $no_p8_umum = rawurldecode($id1);
        $no_pidsus18 = rawurldecode($id2);
        $no_p8_khusus = rawurldecode($id3);
        $_SESSION['pidsus_no_p8_umum'] = $no_p8_umum;
        $_SESSION['pidsus_no_pidsus18'] = $no_pidsus18;
        $_SESSION['pidsus_no_p8_khusus'] = $no_p8_khusus;
        
		$sqlnya = "
        select a.*, b.no_pidsus18, b.tgl_pidsus18, b.no_p8_umum, c.tgl_p8_umum 
		from pidsus.pds_p8_khusus a 
        left join pidsus.pds_pidsus18 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                and a.no_pidsus18 = b.no_pidsus18 
        left join pidsus.pds_p8_umum c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
                and b.no_p8_umum = c.no_p8_umum
        where a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                and a.no_pidsus18 = '".$no_pidsus18."' and a.no_p8_khusus = '".$no_p8_khusus."'";

        $model 	= PdsP8Khusus::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekp8khusus(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Khusus;
            $nilai = $model->cekPdsP8Khusus(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

    public function actionSimpan(){
        $model 	= new PdsP8Khusus;
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
                    return $this->redirect(['update', 'id1' => $param['id1']]);
            }
        }
    }

    public function actionHapusdata(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Khusus;
            $hasil = $model->hapusData(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }

    public function actionUploadmodal(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsP8Khusus;
            $model = $searchModel->explodeUpload(Yii::$app->request->post());
            return $this->renderAjax('_uploadModal',['model' => $model]);
        }
    }
    
    public function actionSimpanupload(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Khusus;
            $hasil = $model->simpanUpload(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }
    
    public function actionCetak($id1){
        $no_p8_khusus = rawurldecode($id1);
        $sqlnya = "
        select a.*, b.no_pidsus18, b.tgl_pidsus18, c.no_p8_umum, c.tgl_p8_umum 
		from pidsus.pds_p8_khusus a 
        left join pidsus.pds_pidsus18 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                and a.no_pidsus18 = b.no_pidsus18 
        left join pidsus.pds_p8_umum c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
                and b.no_p8_umum = c.no_p8_umum
        where a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                and a.no_pidsus18 = '".$_SESSION['pidsus_no_pidsus18']."' and a.no_p8_khusus = '".$no_p8_khusus."'";

        $model 	= PdsP8Khusus::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    
