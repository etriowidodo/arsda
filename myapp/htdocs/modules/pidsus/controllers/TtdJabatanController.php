<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\TtdJabatan;

class TtdJabatanController extends Controller{
    public function actionIndex(){
        $searchModel = new TtdJabatan;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new TtdJabatan;
        return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($kode){
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $kode  = rawurldecode($kode);
        $where 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and kode = '".$kode."'";
        $sqlnya = "
                select * 
                from pidsus.ms_penandatangan
                where ".$where;
        $model 	= TtdJabatan::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }
    
    public function actionCekttdjabatan(){
        if (Yii::$app->request->isAjax) {
            $model = new TtdJabatan;
            $hasil = $model->cekTtdJabatan(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }    
    }

    public function actionSimpan(){
        $model 	= new TtdJabatan;
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
                return $this->redirect(['update', 'id' => $param['no_reg_perkara'], 'ns'=>$param['no_surat']]);
            }
        }
    }

    public function actionHapusdata(){
        if (Yii::$app->request->isAjax) {
            $model = new TtdJabatan;
            $hasil = $model->hapusData(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }	
	
}
    
