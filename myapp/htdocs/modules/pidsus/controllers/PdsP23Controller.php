<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP23;

class PdsP23Controller extends Controller{
    public function actionIndex(){
        if(!$_SESSION["no_berkas"]){
			$searchModel = new PdsP23;
			$dataProvider = $searchModel->searchPer(Yii::$app->request->get());
			return $this->render('index', ['dataProvider' => $dataProvider]);
		} else{
			Yii::$app->response->redirect(['pidsus/pds-p23/create', 'id1'=>$_SESSION["no_berkas"]]);
		}
    }

    public function actionCreate($id1){
		$id1 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar, b.tgl_terima as tgl_terima, 
			i.no_surat as no_p22, i.tgl_dikeluarkan as tgl_p22, j.no_pengantar as id_p23, j.no_surat, j.sifat, j.lampiran, j.tgl_dikeluarkan, j.dikeluarkan, j.kepada, j.di_kepada, 
			j.penandatangan_nama, j.penandatangan_nip, j.penandatangan_jabatan_pejabat, j.penandatangan_gol, j.penandatangan_pangkat, j.penandatangan_status_ttd, 
			j.penandatangan_jabatan_ttd, j.file_upload_p23, h.nama as instansi_penyidik
			from pidsus.pds_terima_berkas a
			join pidsus.pds_spdp g on a.id_kejati = g.id_kejati and a.id_kejari = g.id_kejari and a.id_cabjari = g.id_cabjari 
				and a.no_spdp = g.no_spdp and a.tgl_spdp = g.tgl_spdp 
			join pidsus.ms_inst_penyidik h on g.id_asalsurat = h.kode_ip 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
				and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
			join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 2 
			join pidsus.pds_p18 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
				and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
			join pidsus.pds_p22 i on f.id_kejati = i.id_kejati and f.id_kejari = i.id_kejari and f.id_cabjari = i.id_cabjari 
				and f.no_spdp = i.no_spdp and f.tgl_spdp = i.tgl_spdp and f.no_berkas = i.no_berkas and f.no_pengantar = i.no_pengantar 
			left join pidsus.pds_p23 j on i.id_kejati = j.id_kejati and i.id_kejari = j.id_kejari and i.id_cabjari = j.id_cabjari 
				and i.no_spdp = j.no_spdp and i.tgl_spdp = j.tgl_spdp and i.no_berkas = j.no_berkas and i.no_pengantar = j.no_pengantar 
			where ".$where." and a.no_berkas = '".$id1."'";
		$model 	= PdsP23::findBySql($sqlnya)->asArray()->one();
		return $this->render('create', ['model' => $model]);
    }

    public function actionCekp23(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsP23;
			$nilai = $model->cekP23(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsP23;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
			return $this->redirect(['create', 'id1' => rawurlencode($param['no_berkas'])]);
		}
    }

    public function actionHapus(){
		$model = new PdsP23;
		$hasil = $model->hapusData();
		if($hasil){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil dihapus']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal dihapus']);
			return $this->redirect(['create', 'id1' => $_SESSION["no_berkas"]]);
		}
    }	
    
    public function actionCetak($id1){
        $id1 	= rawurldecode($id1);
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
        $sqlnya = "
                select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar, b.tgl_terima as tgl_terima, 
                i.no_surat as no_p22, i.tgl_dikeluarkan as tgl_p22, j.no_pengantar as id_p23, j.no_surat, j.sifat, j.lampiran, j.tgl_dikeluarkan, j.dikeluarkan, j.kepada, j.di_kepada, 
                j.penandatangan_nama, j.penandatangan_nip, j.penandatangan_jabatan_pejabat, j.penandatangan_gol, j.penandatangan_pangkat, j.penandatangan_status_ttd, 
                j.penandatangan_jabatan_ttd, j.file_upload_p23, h.nama as instansi_penyidik
                from pidsus.pds_terima_berkas a
                join pidsus.pds_spdp g on a.id_kejati = g.id_kejati and a.id_kejari = g.id_kejari and a.id_cabjari = g.id_cabjari 
                        and a.no_spdp = g.no_spdp and a.tgl_spdp = g.tgl_spdp 
                join pidsus.ms_inst_penyidik h on g.id_asalsurat = h.kode_ip 
                join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
                join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
                        and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
                join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
                        and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
                join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
                        and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 2 
                join pidsus.pds_p18 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
                        and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
                join pidsus.pds_p22 i on f.id_kejati = i.id_kejati and f.id_kejari = i.id_kejari and f.id_cabjari = i.id_cabjari 
                        and f.no_spdp = i.no_spdp and f.tgl_spdp = i.tgl_spdp and f.no_berkas = i.no_berkas and f.no_pengantar = i.no_pengantar 
                left join pidsus.pds_p23 j on i.id_kejati = j.id_kejati and i.id_kejari = j.id_kejari and i.id_cabjari = j.id_cabjari 
                        and i.no_spdp = j.no_spdp and i.tgl_spdp = j.tgl_spdp and i.no_berkas = j.no_berkas and i.no_pengantar = j.no_pengantar 
                where ".$where." and a.no_berkas = '".$id1."'";
        $model 	= PdsP23::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }
}
    
