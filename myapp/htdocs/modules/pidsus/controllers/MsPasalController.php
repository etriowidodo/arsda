<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\MsPasal;

class MsPasalController extends Controller{
    public function actionIndex(){
        $searchModel = new MsPasal;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new MsPasal;
        return $this->render('create', ['model'=>$model]);
    }
    
    public function actionGetformundang(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new MsPasal;
            $dataProvider = $searchModel->searchUndang(Yii::$app->request->get());
            return $this->renderAjax('_getUndang', ['dataProvider' => $dataProvider]);
        } 
    }
	
    public function actionUpdate($id,$id2){
        $id  = rawurldecode($id);
        $id2  = rawurldecode($id2);
        $sqlnya = "
                select a.*,b.uu
                from pidsus.ms_pasal a 
                join pidsus.ms_u_undang b on a.id=b.id
                where a.id = '".$id."' and a.id_pasal='".$id2."'";
        $model 	= MsPasal::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }
    
    public function actionCekttdjabatan(){
        if (Yii::$app->request->isAjax) {
            $model = new MsPasal;
            $hasil = $model->cekTtdJabatan(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }    
    }

    public function actionSimpan(){
        $model 	= new MsPasal;
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
            $model = new MsPasal;
            $hasil = $model->hapusData(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }	
	
}
    
