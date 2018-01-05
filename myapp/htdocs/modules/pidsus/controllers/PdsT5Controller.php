<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsT5;

class PdsT5Controller extends Controller{
    public function actionIndex(){
        unset($_SESSION['t5']);
        $searchModel = new PdsT5;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new PdsT5;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetTersangka(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsT5;
			$nilai = $model->getTersangka(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $nilai;
		}    
	}

    public function actionUpdate($id1, $id2){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
        $_SESSION['t5']=$id2;
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select a.nama, case when a.jenis_penahanan = 1 then 'Rutan' when a.jenis_penahanan = 2 then 'Rumah' when a.jenis_penahanan = 3 then 'Kota' end as jenis_thn, 
		a.lokasi_penahanan as lokasi_thn, to_char(a.tgl_mulai_penahanan, 'DD-MM-YYYY') as tgl_mulai_thn, to_char(a.tgl_selesai_penahanan, 'DD-MM-YYYY') as tgl_selesai_thn, b.*,
                to_char(a.tgl_minta_perpanjang, 'DD-MM-YYYY') as tgl_minta_perpanjang
		from pidsus.pds_minta_perpanjang a 
		join pidsus.pds_t5 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang 
		where ".$where." and b.no_minta_perpanjang = '".$id1."' and b.no_t5 = '".$id2."'";
		$model 	= PdsT5::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekT5(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsT5;
			$nilai = $model->cekT5(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsT5;
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
				return $this->redirect(['update', 'id1' => $param['no_minta_perpanjang'], 'id2' => $param['no_t5']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsT5;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1, $id2){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select a.nama, case when a.jenis_penahanan = 1 then 'Rutan' when a.jenis_penahanan = 2 then 'Rumah' when a.jenis_penahanan = 3 then 'Kota' end as jenis_thn, 
		a.lokasi_penahanan as lokasi_thn, to_char(a.tgl_mulai_penahanan, 'DD-MM-YYYY') as tgl_mulai_thn, to_char(a.tgl_selesai_penahanan, 'DD-MM-YYYY') as tgl_selesai_thn, b.*,
                a.tgl_minta_perpanjang, a.tmpt_lahir, a.tgl_lahir,
                a.alamat, a.pekerjaan
		from pidsus.pds_minta_perpanjang a 
		join pidsus.pds_t5 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang 
		where ".$where." and b.no_minta_perpanjang = '".$id1."' and b.no_t5 = '".$id2."'";
	$model 	= PdsT5::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }
}
    
