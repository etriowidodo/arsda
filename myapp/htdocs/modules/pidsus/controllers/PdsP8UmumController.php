<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP8Umum;

class PdsP8UmumController extends Controller{
    public function actionIndex(){
        $_SESSION['no_spdp'] 	= "";
        $_SESSION['tgl_spdp'] 	= "";
        $_SESSION['no_berkas'] 	= "";
	$_SESSION['pidsus_no_p8_umum'] = "";
        $_SESSION['pidsus_no_pidsus18'] = "";
	$searchModel = new PdsP8Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetjp(){
        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('_tambah_jp');
        }
    }
    
    public function actionGetp6(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsP8Umum;
            $dataProvider = $searchModel->searchP6(Yii::$app->request->get());
            return $this->renderAjax('_getp6', ['dataProvider' => $dataProvider]);
        } 
    }

    public function actionCreate(){
        $model  = new PdsP8Umum;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($no_p8_umum){
        $no_p8_umum = rawurldecode($no_p8_umum);
		$_SESSION['pidsus_no_p8_umum'] = $no_p8_umum;

		$sqlnya = "
		select b.*, a.nip_jaksa, a.nama_jaksa, a.pangkat_jaksa, a.jabatan_jaksa 
		from pidsus.pds_p6 a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_urut_p6 = b.no_urut_p6 and a.tgl_p6 = b.tgl_p6  
		where b.id_kejati = '".$_SESSION['kode_kejati']."' and b.id_kejari = '".$_SESSION['kode_kejari']."' and b.id_cabjari = '".$_SESSION['kode_cabjari']."' 
			and b.no_p8_umum = '".$no_p8_umum."'";
		
		$model 	= PdsP8Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekp8umum(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Umum;
            $nilai = $model->cekPdsP8Umum(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

    public function actionSimpan(){
        $model 	= new PdsP8Umum;
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
				$_SESSION['pidsus_no_p8_umum'] = $param['no_p8_umum'];
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['update', 'no_p8_umum' => rawurlencode($_SESSION['pidsus_no_p8_umum'])]);
			}
        }
    }

    public function actionHapusdata(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Umum;
            $hasil = $model->hapusData(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }

    public function actionUploadmodal(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsP8Umum;
            $model = $searchModel->explodeUpload(Yii::$app->request->post());
            return $this->renderAjax('_uploadModal',['model' => $model]);
        }
    }
    
    public function actionSimpanupload(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP8Umum;
            $hasil = $model->simpanUpload(Yii::$app->request->post());
            $hasil = ($hasil)?true:false;
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        }
    }
    
    public function actionCetak($no_p8_umum){
        $no_p8_umum = rawurldecode($no_p8_umum);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$no_p8_umum."'";
		$sqlnya = "select a.*,b.dilakukan_oleh,b.kasus_posisi,b.tindak_pidana from pidsus.pds_p8_umum a "
                        . " left join pidsus.pds_p6 b on a.id_kejati=b.id_kejati and a.id_kejari=b.id_kejari and a.id_cabjari=b.id_cabjari "
                        . " and a.no_urut_p6=b.no_urut_p6 and a.tgl_p6=b.tgl_p6 "
                        . " where ".$where;
		$model 	= PdsP8Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    
