<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPidsus16;

class PdsPidsus16Controller extends Controller{
    public function actionIndex(){
        $searchModel = new PdsPidsus16;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetgeledah(){
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_tambah_geledah');
        }
    }
    
    public function actionGetsita(){
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_tambah_sita');
        }
    }
    

    public function actionCreate(){
        $model  = new PdsPidsus16;	
	return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($nop16){
        $idnya 	= rawurldecode($nop16);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
			select a.*
			from pidsus.pds_p16 a 
			join pidsus.pds_spdp b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp
			where ".$where." and a.no_p16 = '".$idnya."'";
		$model 	= PdsPidsus16::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekp16(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus16;
			$nilai = $model->cekPdsPidsus16(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsPidsus16;
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
				return $this->redirect(['update', 'nop16' => $param['no_p16']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus16;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }

    public function actionUploadmodal(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsPidsus16;
            $model = $searchModel->explodeUpload(Yii::$app->request->post());
            return $this->renderAjax('_uploadModal',['model' => $model]);
        }
    }
    
    public function actionSimpanupload(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus16;
			$hasil = $model->simpanUpload(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }

}
    
