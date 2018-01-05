<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPengembalianSpdp;

class PdsPengembalianSpdpController extends Controller{

    public function actionIndex(){
        $searchModel = new PdsPengembalianSpdp;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
	
    public function actionCreate(){
        $model  = new PdsPengembalianSpdp;
        return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($no_spdp, $tgl_spdp){
		$no_spdp  = rawurldecode($no_spdp);
		$tgl_spdp = rawurldecode($tgl_spdp);
		$sqlnya = "
		select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.tgl_terima, b.no_spdp_kembali, b.dikeluarkan, b.tgl_dikeluarkan, b.sifat, b.kepada, b.lampiran, 
		b.di_kepada, b.perihal, b.penandatangan_nama, b.penandatangan_nip, b.penandatangan_jabatan_pejabat, b.penandatangan_gol, b.penandatangan_pangkat, 
		b.penandatangan_status_ttd, b.penandatangan_jabatan_ttd, b.file_upload_spdp_kembali, b.alasan 
		from pidsus.pds_spdp a
		join pidsus.pds_spdp_kembali b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp
		where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_spdp = '".$no_spdp."' and a.tgl_spdp = '".$tgl_spdp."'";
		$model 	= PdsPengembalianSpdp::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionGetspdp(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsPengembalianSpdp;
            $dataProvider = $searchModel->getSpdp(Yii::$app->request->get());
            return $this->renderAjax('_getSpdp', ['dataProvider' => $dataProvider]);
        }
    }

    public function actionCekspdpkembali(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPengembalianSpdp;
			$nilai = $model->cekSpdpKembali(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}
	
     public function actionSimpan(){
		$model 	= new PdsPengembalianSpdp;
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
				return $this->redirect(['update', 'no_spdp' => rawurlencode($param['no_spdp']), 'tgl_spdp'=>rawurlencode($param['tgl_spdp'])]);
			}
		}
    }
  
    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPengembalianSpdp;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
	
	public function actionCetak($no_spdp, $tgl_spdp){
		$no_spdp  = rawurldecode($no_spdp);
		$tgl_spdp = rawurldecode($tgl_spdp);
		$sqlnya = "
		with tbl_tersangka as(
				select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(nama, '#' order by no_urut) as tersangka 
				from pidsus.pds_spdp_tersangka group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		), tbl_tersangka_berkas as(
			select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, string_agg(nama, '#' order by no_urut) as tersangka_berkas
			from(
				select distinct id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_urut, nama 
				from pidsus.pds_terima_berkas_tersangka 
			) a
			group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp
		)
		select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.tgl_terima, b.no_spdp_kembali, b.dikeluarkan, b.tgl_dikeluarkan, b.sifat, b.kepada, b.lampiran, 
		b.di_kepada, b.perihal, b.penandatangan_nama, b.penandatangan_nip, b.penandatangan_jabatan_pejabat, b.penandatangan_gol, b.penandatangan_pangkat, 
		b.penandatangan_status_ttd, b.penandatangan_jabatan_ttd, b.file_upload_spdp_kembali, c.nama as sifat_surat, e.tersangka, d.tersangka_berkas 
		from pidsus.pds_spdp a
		join pidsus.pds_spdp_kembali b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp 
		join ms_sifat_surat c on b.sifat::integer = c.id 
		join tbl_tersangka e on a.id_kejati = e.id_kejati and a.id_kejari = e.id_kejari and a.id_cabjari = e.id_cabjari and a.no_spdp = e.no_spdp and a.tgl_spdp = e.tgl_spdp 
		left join tbl_tersangka_berkas d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari and a.no_spdp = d.no_spdp 
			and a.tgl_spdp = d.tgl_spdp 
		where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_spdp = '".$no_spdp."' and a.tgl_spdp = '".$tgl_spdp."'";
		$model 	= PdsPengembalianSpdp::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}

}