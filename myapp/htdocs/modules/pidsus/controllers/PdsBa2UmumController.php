<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsBa2Umum;

class PdsBa2UmumController extends Controller{
    public function actionIndex(){
        $searchModel = new PdsBa2Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsBa2Umum;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetsaksi(){
        if (Yii::$app->request->isAjax){
			$searchModel = new PdsBa2Umum;
			$dataProvider = $searchModel->searchSaksi(Yii::$app->request->get());
			return $this->renderAjax('_tambah_saksi', ['dataProvider' => $dataProvider]);
        }
    }

    public function actionGetba1umum(){
        if (Yii::$app->request->isAjax){
			$searchModel = new PdsBa2Umum;
			$dataProvider = $searchModel->searchBa1Umum(Yii::$app->request->get());
			return $this->renderAjax('_getba1umum', ['dataProvider' => $dataProvider]);
        }
    }

    public function actionUpdate($id1){
        $idnya 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum, c.nama as kebangsaan, d.nama as pendidikan, e.nama as agama 
		from pidsus.pds_ba2_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
		left join public.ms_warganegara c on a.warganegara = c.id 
		left join public.ms_pendidikan d on a.id_pendidikan = d.id_pendidikan  
		left join public.ms_agama e on a.id_agama = e.id_agama 
		where ".$where." and a.no_ba2_umum = '".$idnya."'";
		$model 	= PdsBa2Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new PdsBa2Umum;
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
				return $this->redirect(['update', 'id1' => $param['no_ba2_umum']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsBa2Umum;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1, $id2){
        $idnya 	= rawurldecode($id1);
        $draft 	= rawurldecode($id2);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum, c.nama as kebangsaan, b.no_p8_umum, d.nama as agama, e.nama as pendidikan, b.laporan_pidana 
		from pidsus.pds_ba2_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum 
		left join public.ms_warganegara c on a.warganegara = c.id 
                left join public.ms_agama d on a.id_agama = d.id_agama
                left join public.ms_pendidikan e on a.id_pendidikan = e.id_pendidikan
                where ".$where." and a.no_ba2_umum = ".$idnya;
		$model 	= PdsBa2Umum::findBySql($sqlnya)->asArray()->one();
        $model['isDraft']=$draft;
        return $this->render('cetak', ['model' => $model]);
    }
}
