<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPidsus6Umum;

class PdsPidsus6UmumController extends Controller{
    public function actionIndex(){
        unset($_SESSION['pidsus_no_pidsus6_umum']);
		$searchModel = new PdsPidsus6Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsPidsus6Umum;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionCekpdspidsus6umum(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus6Umum;
			$nilai = $model->cekPdsPidsus6Umum(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

    public function actionUpdate($id1){
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
		$no_p8_umum	= $_SESSION['pidsus_no_p8_umum'];
        $no_pidsus6_umum = rawurldecode($id1);
		$_SESSION['pidsus_no_pidsus6_umum'] = $no_pidsus6_umum;

		$whereDef 	= "a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
		$sqlnya = "
			select a.*, b.tgl_p8_umum 
			from pidsus.pds_pidsus6_umum a 
			join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
			where ".$whereDef." and a.no_pidsus6_umum = '".$no_pidsus6_umum."'";
		$model 	= PdsPidsus6Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }


	public function actionSimpan(){
        $model 	= new PdsPidsus6Umum;
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
				return $this->redirect(['update', 'id1' => rawurlencode($_SESSION['pidsus_no_pidsus6_umum'])]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus6Umum;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1){
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
        $id_cabjari = $_SESSION['kode_cabjari'];
        $no_p8_umum = $_SESSION['pidsus_no_p8_umum'];
        $no_pidsus6_umum = rawurldecode($id1);
        $whereDef 	= "a.id_kejati = '".$id_kejati."' and a.id_kejari = '".$id_kejari."' and a.id_cabjari = '".$id_cabjari."' and a.no_p8_umum = '".$no_p8_umum."'";
        $sqlnya = "
                select a.*, b.tgl_p8_umum 
                from pidsus.pds_pidsus6_umum a 
                join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
                where ".$whereDef." and a.no_pidsus6_umum = '".$no_pidsus6_umum."'";
        $model 	= PdsPidsus6Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    
