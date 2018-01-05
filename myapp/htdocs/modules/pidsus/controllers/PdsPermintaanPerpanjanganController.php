<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPermintaanPerpanjangan;

class PdsPermintaanPerpanjanganController extends Controller{
    public function actionIndex(){
        unset($_SESSION['no_minta_perpanjang']);
        $searchModel = new PdsPermintaanPerpanjangan;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new PdsPermintaanPerpanjangan;
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, b.nama as nama_instansi_penyidik, c.nama as nama_instansi_pelaksana 
		from pidsus.pds_spdp a 
		join pidsus.ms_inst_penyidik b on a.id_asalsurat = b.kode_ip 
		join pidsus.ms_inst_pelak_penyidikan c on a.id_asalsurat = c.kode_ip and a.id_penyidik = c.kode_ipp 
		where ".$where;
		$model 	= PdsPermintaanPerpanjangan::findBySql($sqlnya)->asArray()->one();
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionPoptersangka(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsPermintaanPerpanjangan;
            $model = $searchModel->explodeTersangka(Yii::$app->request->post());
            return $this->renderAjax('_popTersangka',['model' => $model]);
        }
    }
	
	public function actionGetTersangkaSpdp(){
		$searchModel = new PdsPermintaanPerpanjangan;
		$dataProvider = $searchModel->searchTersangkaSpdp();
		return $this->renderAjax('_get_tersangka_spdp', ['dataProvider' => $dataProvider]);
	}

    public function actionUpdate($id){
        $idnya 	= rawurldecode($id);
        $_SESSION['no_minta_perpanjang']=rawurldecode($id);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select b.nama as nama_instansi_penyidik, c.nama as nama_instansi_pelaksana, d.*, e.nama as kebangsaan 
		from pidsus.pds_spdp a 
		join pidsus.ms_inst_penyidik b on a.id_asalsurat = b.kode_ip 
		join pidsus.ms_inst_pelak_penyidikan c on a.id_asalsurat = c.kode_ip and a.id_penyidik = c.kode_ipp 
		join pidsus.pds_minta_perpanjang d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
			and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp 
		join public.ms_warganegara e on d.warganegara = e.id 
		where ".$where." and d.no_minta_perpanjang = '".$idnya."'";
		$model 	= PdsPermintaanPerpanjangan::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekmintapanjang(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPermintaanPerpanjangan;
			$nilai = $model->cekMintaPerpanjang(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsPermintaanPerpanjangan;
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
				return $this->redirect(['index']);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPermintaanPerpanjangan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }

}
    
