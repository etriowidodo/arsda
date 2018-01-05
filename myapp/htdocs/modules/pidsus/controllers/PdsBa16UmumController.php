<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsBa16Umum;

class PdsBa16UmumController extends Controller{
    public function actionIndex(){
        unset($_SESSION['pidsus_tgl_ba16_umum']);
        $searchModel = new PdsBa16Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsBa16Umum;	
	return $this->render('create', ['model'=>$model]);
    }
    
    public function actionGetb4(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsBa16Umum;
            $dataProvider = $searchModel->searchB4(Yii::$app->request->get());
            return $this->renderAjax('_getb4', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionGetjaksab4(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsBa16Umum;
            $hasil = $model->searchB4Jaksa(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        } 
    }
    
    public function actionListjaksab4(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsBa16Umum;
            $hasil = $model->listB4Jaksa(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $hasil;
        } 
    }
    
    public function actionGetgeledahb4(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsBa16Umum;
            $hasil = $model->searchB4Geledah(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        } 
    }
    
    public function actionGetsitab4(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsBa16Umum;
            $hasil = $model->searchB4Sita(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        } 
    }

    public function actionUpdate($id1,$id2){
        $no_ba16_umum = rawurldecode($id1);
        $tgl_ba16_umum = rawurldecode($id2);
        $_SESSION['pidsus_tgl_ba16_umum'] = $tgl_ba16_umum;

        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
        $sqlnya = "
        select a.*, b.tgl_p8_umum  
        from pidsus.pds_ba16_umum a 
        join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
        where ".$where." and a.no_ba16_umum = '".$no_ba16_umum."' and tgl_ba16_umum = '".$tgl_ba16_umum."'";
        $model 	= PdsBa16Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekpidsus20cumum(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsBa16Umum;
            $nilai = $model->cekPidsus20cUmum(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

    public function actionSimpan(){
        $model 	= new PdsBa16Umum;
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
                $model = new PdsBa16Umum;
                $hasil = $model->hapusData(Yii::$app->request->post());
                $hasil = ($hasil)?true:false;
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['hasil'=>$hasil];
        }
    }
    
    public function actionCetak($id1,$id2){
        $no_ba16_umum = rawurldecode($id1);
        $tgl_ba16_umum = rawurldecode($id2);

        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
        $sqlnya = "
        select a.*, b.tgl_p8_umum, b.no_p8_umum, d.kepada as  kepada_b1
        from pidsus.pds_ba16_umum a 
        join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
        join pidsus.pds_b4_umum c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari and a.no_p8_umum = c.no_p8_umum and a.no_b4_umum = c.no_b4_umum 
        join pidsus.pds_b1_umum d on c.id_kejati = d.id_kejati and c.id_kejari = d.id_kejari and c.id_cabjari = d.id_cabjari and c.no_p8_umum = d.no_p8_umum 
        where ".$where." and a.no_ba16_umum = '".$no_ba16_umum."' and tgl_ba16_umum = '".$tgl_ba16_umum."'";
        $model 	= PdsBa16Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    
