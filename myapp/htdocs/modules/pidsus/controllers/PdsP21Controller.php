<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP21;

class PdsP21Controller extends Controller{
    public function actionIndex(){
        if(!$_SESSION["no_berkas"]){
			$searchModel = new PdsP21;
			$dataProvider = $searchModel->searchPer(Yii::$app->request->get());
			return $this->render('index', ['dataProvider' => $dataProvider]);
		} else{
			Yii::$app->response->redirect(['pidsus/pds-p21/create', 'id1'=>$_SESSION["no_berkas"], 'id2'=>""]);
		}
    }

    public function actionCreate($id1, $id2){
		$id1 	= rawurldecode($id1);
		$id2 	= rawurldecode($id2);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		if(!$_SESSION["no_berkas"]){
			$sqlnya = "
				select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar, b.tgl_terima as tgl_terima, 
				f.no_pengantar as id_p21, f.no_surat, f.sifat, f.lampiran, f.tgl_dikeluarkan, f.dikeluarkan, f.kepada, f.di_kepada, f.penandatangan_nama, f.penandatangan_nip, 
				f.penandatangan_jabatan_pejabat, f.penandatangan_gol, f.penandatangan_pangkat, f.penandatangan_status_ttd, f.penandatangan_jabatan_ttd, f.file_upload_p21    
				from pidsus.pds_terima_berkas a 
				join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
					and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
				join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
					and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
				join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
					and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
				join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
					and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 1 
				left join pidsus.pds_p21 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
					and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
				where ".$where." and a.no_berkas = '".$id1."' and b.no_pengantar = '".$id2."'";
		} else{
			$sqlnya = "
				select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar, b.tgl_terima as tgl_terima, e.tgl_ba, 
				f.no_pengantar as id_p21, f.no_surat, f.sifat, f.lampiran, f.tgl_dikeluarkan, f.dikeluarkan, f.kepada, f.di_kepada, f.penandatangan_nama, f.penandatangan_nip, 
				f.penandatangan_jabatan_pejabat, f.penandatangan_gol, f.penandatangan_pangkat, f.penandatangan_status_ttd, f.penandatangan_jabatan_ttd, f.file_upload_p21    
				from pidsus.pds_terima_berkas a 
				join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
					and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
				join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
					and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
				join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
					and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
				join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
					and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 1 
				left join pidsus.pds_p21 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
					and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
				where ".$where." and a.no_berkas = '".$id1."'";
		}
		$model 	= PdsP21::findBySql($sqlnya)->asArray()->one();
		return $this->render('create', ['model' => $model]);
    }

    public function actionCekp21(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsP21;
			$nilai = $model->cekP21(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsP21;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
			return $this->redirect(['create', 'id1' => rawurlencode($param['no_berkas']), 'id2' => rawurlencode($param['no_pengantar'])]);
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsP21;
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
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar, b.tgl_terima as tgl_terima, f.no_pengantar as id_p21, 
			f.no_surat, f.sifat, f.lampiran, f.tgl_dikeluarkan, f.dikeluarkan, f.kepada, f.di_kepada, f.penandatangan_nama, f.penandatangan_nip, f.penandatangan_jabatan_pejabat, 
			f.penandatangan_gol, f.penandatangan_pangkat, f.penandatangan_status_ttd, f.penandatangan_jabatan_ttd, f.file_upload_p21    
			from pidsus.pds_terima_berkas a 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
				and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
			join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 1 
			left join pidsus.pds_p21 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
				and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
			where ".$where." and a.no_berkas = '".$id1."' and b.no_pengantar = '".$id2."'";
		$model 	= PdsP21::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }
}
    
