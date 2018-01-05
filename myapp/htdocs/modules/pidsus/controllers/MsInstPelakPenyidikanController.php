<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\MsInstPelakPenyidikan;

class MsInstPelakPenyidikanController extends Controller{
    public function actionIndex(){
        $searchModel = new MsInstPelakPenyidikan;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new MsInstPelakPenyidikan;
        return $this->render('create', ['model'=>$model]);
    }
    
    public function actionCekttdjabatan(){
        if (Yii::$app->request->isAjax) {
            $model = new MsInstPelakPenyidikan;
            $hasil = $model->cekTtdJabatan(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }    
    }
	
    public function actionUpdate($kode_ip, $kode_ipp){
        $kode_ip  = rawurldecode($kode_ip);
        $kode_ipp = rawurldecode($kode_ipp);

        $where 	= "a.kode_ip = '".$kode_ip."' and a.kode_ipp = '".$kode_ipp."'";
        $sqlnya = "
                select a.* 
                from pidsus.ms_inst_pelak_penyidikan a 
                where ".$where;
        $model 	= MsInstPelakPenyidikan::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionSimpan(){
        $model 	= new MsInstPelakPenyidikan;
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
            $model = new MsInstPelakPenyidikan;
            $hasil = $model->hapusData(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }	
	
}
    
