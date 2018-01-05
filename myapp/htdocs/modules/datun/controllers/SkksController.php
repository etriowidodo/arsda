<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Skks;

class SkksController extends Controller{

    public function actionIndex(){
		$searchModel = new Skks;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		if($dataProvider){
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		} else{
			return $this->redirect(['/datun/skk/index']);
		}
    }

    public function actionCreate(){
        $model = new Skks;
        $hasil = $model->getCreateSkk();
		return $this->render('create', ['model' => $hasil]);
    }

    public function actionGetpenerimapusat(){
		if (Yii::$app->request->isAjax) {
			$model = new Skks;
			$hasil = $model->getPenerimaPusat(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }

    public function actionGetpegawai(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new Skks;
			$dataProvider = $searchModel->getPegawai(Yii::$app->request->get());
			return $this->renderAjax('_getPegawai', ['dataProvider' => $dataProvider]);
		}    
    }

    public function actionUpdate($id){
       	$id = rawurldecode($id);
		$np = $_SESSION['no_register_perkara'];
		$ns = $_SESSION['no_surat'];
		$nk = $_SESSION['no_register_skk'];
		$dk = $_SESSION['tanggal_skk'];

		$sqlnya = "
			select g.no_register_skks, g.no_register_skk, g.tanggal_skk, g.no_register_perkara, g.no_surat, g.kode_tk, g.kode_kejati, g.kode_kejari, g.kode_cabjari, 
			g.tanggal_ttd, g.file_skks, g.penerima_kuasa, g.is_active, a.permasalahan_pemohon,
			coalesce(j.no_register_skks, h.no_register_skk) as no_register_tmp, coalesce(j.tanggal_ttd, h.tanggal_skk) as tanggal_tmp, 
			coalesce(k.nama_pegawai, i.nama_pegawai) as nama_pemberi, coalesce(k.jabatan_pegawai, i.jabatan_pegawai) as jabatan_pemberi, 
			coalesce(k.alamat_instansi, i.alamat_instansi) as alamat_pemberi, 
			a.pimpinan_pemohon, a.kode_jenis_instansi, b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, 
			d.alamat as alamat_instansi, a.tanggal_panggilan_pengadilan, f.nama_pengadilan 
			from datun.permohonan a
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join kepegawaian.kp_inst_satker e on a.kode_tk = e.kode_tk and a.kode_kejati = e.kode_kejati and a.kode_kejari = e.kode_kejari and a.kode_cabjari = e.kode_cabjari
			join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
			join datun.skks g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat 
			left join datun.skk h on g.no_register_perkara = h.no_register_perkara and g.no_surat = h.no_surat and g.pemberi_kuasa = h.no_register_skk 
				and g.tanggal_skk = h.tanggal_skk 
			left join datun.skk_anak i on h.no_register_perkara = i.no_register_perkara and h.no_surat = i.no_surat 
				and h.no_register_skk = i.no_register_skk and h.tanggal_skk = i.tanggal_skk 
			left join datun.skks j on g.no_register_perkara = j.no_register_perkara and g.no_surat = j.no_surat 
				and g.no_register_skk = j.no_register_skk and g.tanggal_skk = j.tanggal_skk and g.pemberi_kuasa = j.no_register_skks 
			left join datun.skks_anak k on j.no_register_perkara = k.no_register_perkara and j.no_surat = k.no_surat 
				and j.no_register_skk = k.no_register_skk and j.tanggal_skk = k.tanggal_skk and j.no_register_skks = k.no_register_skks
			where g.no_register_perkara = '".$np."' and g.no_surat = '".$ns."' and g.no_register_skk = '".$nk."' and g.tanggal_skk = '".$dk."' and g.no_register_skks = '".$id."'";
		$model 	= Skks::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekskks(){
		if (Yii::$app->request->isAjax) {
			$model = new Skks;
			$hasil = $model->cekSkks(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new Skks;
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
				return $this->redirect(['update', 'id'=>rawurlencode($param['nomor_skks'])]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Skks;
			$hasil = $model->hapusData(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

	public function actionCetak($id){
        $id = rawurldecode($id);
		$np = $_SESSION['no_register_perkara'];
		$ns = $_SESSION['no_surat'];
		$nk = $_SESSION['no_register_skk'];
		$dk = $_SESSION['tanggal_skk'];

		$sqlnya = "
			select g.no_register_skks, g.no_register_skk, g.tanggal_skk, g.no_register_perkara, g.no_surat, g.kode_tk, g.kode_kejati, g.kode_kejari, g.kode_cabjari, 
			g.tanggal_ttd, g.file_skks, g.penerima_kuasa, 
			coalesce(j.no_register_skks, h.no_register_skk) as no_register_tmp, coalesce(j.tanggal_ttd, h.tanggal_skk) as tanggal_tmp, 
			coalesce(k.nama_pegawai, i.nama_pegawai) as nama_pemberi, coalesce(k.jabatan_pegawai, i.jabatan_pegawai) as jabatan_pemberi, 
			coalesce(k.alamat_instansi, i.alamat_instansi) as alamat_pemberi, initcap(a.status_pemohon||' '||a.no_status_pemohon) as status_pemohon, 
			a.pimpinan_pemohon, a.kode_jenis_instansi, b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, 
			d.alamat as alamat_instansi, a.tanggal_panggilan_pengadilan, f.nama_pengadilan 
			from datun.permohonan a
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join kepegawaian.kp_inst_satker e on a.kode_tk = e.kode_tk and a.kode_kejati = e.kode_kejati and a.kode_kejari = e.kode_kejari and a.kode_cabjari = e.kode_cabjari
			join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
			join datun.skks g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat 
			left join datun.skk h on g.no_register_perkara = h.no_register_perkara and g.no_surat = h.no_surat and g.pemberi_kuasa = h.no_register_skk 
				and g.tanggal_skk = h.tanggal_skk 
			left join datun.skk_anak i on h.no_register_perkara = i.no_register_perkara and h.no_surat = i.no_surat 
				and h.no_register_skk = i.no_register_skk and h.tanggal_skk = i.tanggal_skk 
			left join datun.skks j on g.no_register_perkara = j.no_register_perkara and g.no_surat = j.no_surat 
				and g.no_register_skk = j.no_register_skk and g.tanggal_skk = j.tanggal_skk and g.pemberi_kuasa = j.no_register_skks 
			left join datun.skks_anak k on j.no_register_perkara = k.no_register_perkara and j.no_surat = k.no_surat 
				and j.no_register_skk = k.no_register_skk and j.tanggal_skk = k.tanggal_skk and j.no_register_skks = k.no_register_skks
			where g.no_register_perkara = '".$np."' and g.no_surat = '".$ns."' and g.no_register_skk = '".$nk."' and g.tanggal_skk = '".$dk."' and g.no_register_skks = '".$id."'";
		$model 	= Skks::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}
	
	public function actionCetak_permasalahan($id){
        $id = rawurldecode($id);
		$np = $_SESSION['no_register_perkara'];
		$ns = $_SESSION['no_surat'];
		$nk = $_SESSION['no_register_skk'];
		$dk = $_SESSION['tanggal_skk'];

		$sqlnya = "
			select g.no_register_skks, g.no_register_skk, g.tanggal_skk, g.no_register_perkara, g.no_surat, g.kode_tk, g.kode_kejati, g.kode_kejari, g.kode_cabjari, 
			g.tanggal_ttd, g.file_skks, g.penerima_kuasa, 
			coalesce(j.no_register_skks, h.no_register_skk) as no_register_tmp, coalesce(j.tanggal_ttd, h.tanggal_skk) as tanggal_tmp, 
			coalesce(k.nama_pegawai, i.nama_pegawai) as nama_pemberi, coalesce(k.jabatan_pegawai, i.jabatan_pegawai) as jabatan_pemberi, 
			coalesce(k.alamat_instansi, i.alamat_instansi) as alamat_pemberi, initcap(a.status_pemohon||' '||a.no_status_pemohon) as status_pemohon, 
			a.pimpinan_pemohon, a.kode_jenis_instansi, b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, 
			d.alamat as alamat_instansi, a.tanggal_panggilan_pengadilan, f.nama_pengadilan, a.permasalahan_pemohon
			from datun.permohonan a
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join kepegawaian.kp_inst_satker e on a.kode_tk = e.kode_tk and a.kode_kejati = e.kode_kejati and a.kode_kejari = e.kode_kejari and a.kode_cabjari = e.kode_cabjari
			join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
			join datun.skks g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat 
			left join datun.skk h on g.no_register_perkara = h.no_register_perkara and g.no_surat = h.no_surat and g.pemberi_kuasa = h.no_register_skk 
				and g.tanggal_skk = h.tanggal_skk 
			left join datun.skk_anak i on h.no_register_perkara = i.no_register_perkara and h.no_surat = i.no_surat 
				and h.no_register_skk = i.no_register_skk and h.tanggal_skk = i.tanggal_skk 
			left join datun.skks j on g.no_register_perkara = j.no_register_perkara and g.no_surat = j.no_surat 
				and g.no_register_skk = j.no_register_skk and g.tanggal_skk = j.tanggal_skk and g.pemberi_kuasa = j.no_register_skks 
			left join datun.skks_anak k on j.no_register_perkara = k.no_register_perkara and j.no_surat = k.no_surat 
				and j.no_register_skk = k.no_register_skk and j.tanggal_skk = k.tanggal_skk and j.no_register_skks = k.no_register_skks
			where g.no_register_perkara = '".$np."' and g.no_surat = '".$ns."' and g.no_register_skk = '".$nk."' and g.tanggal_skk = '".$dk."' and g.no_register_skks = '".$id."'";
		$model 	= Skks::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak_permasalahan', ['model'=>$model]);
	}

}
