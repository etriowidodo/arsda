<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\HarianSidang;

class HariansidangController extends Controller{
    public function actionIndex(){
        $searchModel = new HarianSidang();
        $dataProvider = $searchModel->searchHarian(Yii::$app->request->get());
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }
	
	
	public function actionSimpan(){
		$model 	= new HarianSidang;
		$simpan = $model->simpanData(Yii::$app->request->post());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['create']);
        }
	}

	//faiz zainol 25/11/2016
    public function actionCreate(){
        $model  = new HarianSidang;
		$sqlnya = "
		with tbl_lawan_pemohon as( 
			select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
			from datun.lawan_pemohon group by no_register_perkara, no_surat 
		) 
		select a.tanggal_panggilan_pengadilan, a.no_register_perkara, a.no_surat, a.kode_jenis_instansi, a.kode_instansi, a.kode_kabupaten, f.nama_pengadilan, f.alamat,
		e.lawan_pemohon as penggugat, c.deskripsi_inst_wilayah as tergugat, a.tanggal_diterima
		from datun.permohonan a 
		join datun.instansi_wilayah c on a.kode_instansi = c.kode_instansi and a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_provinsi = c.kode_provinsi
			and a.kode_kabupaten = c.kode_kabupaten and a.kode_tk = c.kode_tk and a.no_urut_wil = c.no_urut
		join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
		join tbl_lawan_pemohon e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
		where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara='".$_SESSION['no_register_perkara']."'";
		$head = HarianSidang::findBySql($sqlnya)->asArray()->one();
		return $this->render('create',[
			'model'=>$model,
			'head'=>$head,
		]);
    }

    public function actionUpdate ($noperkara, $nosrt, $tgls11){				
		$sqlnya = "
		with tbl_lawan_pemohon as( 
			select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
			from datun.lawan_pemohon group by no_register_perkara, no_surat 
		) 
		select a.tanggal_panggilan_pengadilan, a.no_register_perkara, a.no_surat, a.kode_jenis_instansi, a.kode_instansi, a.kode_kabupaten, a.tanggal_diterima, f.nama_pengadilan, 
		f.alamat, b.no_register_skk, b.tanggal_skk, b.tanggal_s11, b.hari, b.waktu_sidang, b.panitera, b.agenda_sidang, b.kasus_posisi, b.isi_laporan, b.analisa_laporan, 
		b.kesimpulan, b.resume, b.tanggal_ttd, b.file_s11, b.no_sidang, b.no_register_skks, d.tanggal_ttd as tgl_skks, e.lawan_pemohon as penggugat, 
		c.deskripsi_inst_wilayah as tergugat
		from datun.permohonan a 
		join datun.s11 b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
		join datun.instansi_wilayah c on a.kode_instansi = c.kode_instansi and a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_provinsi = c.kode_provinsi
			and a.kode_kabupaten = c.kode_kabupaten and a.kode_tk = c.kode_tk and a.no_urut_wil = c.no_urut
		join tbl_lawan_pemohon e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
		join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
		join datun.skk g on b.no_register_skk = g.no_register_skk and b.tanggal_skk = g.tanggal_skk and b.no_register_perkara = g.no_register_perkara and b.no_surat = g.no_surat		
		left join datun.skks d on b.no_register_skk = d.no_register_skk and b.tanggal_skk = d.tanggal_skk and b.no_register_perkara = d.no_register_perkara 
			and b.no_surat = d.no_surat and b.no_register_skks = d.no_register_skks
		where a.no_surat = '".$nosrt."' and a.no_register_perkara = '".$noperkara."' and b.tanggal_s11 = '".$tgls11."'";
		$head = HarianSidang::findBySql($sqlnya)->asArray()->one();
		return $this->render('create', ['head'=>$head]);
    }
	
    public function actionCeks11(){
		if (Yii::$app->request->isAjax) {
			$model = new HarianSidang;
			$nilai = $model->cekS11(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	} 
	
	public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new HarianSidang;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
	}
	
	public function actionCetak($noperkara, $nosrt, $tgls11){
		$sqlnya = "
		select a.*, b.kode_jenis_instansi, c.nama_pengadilan, c.alamat
		from datun.s11 a
		join datun.permohonan b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat
		join datun.master_pengadilan c on b.kode_pengadilan_tk1 = c.kode_pengadilan_tk1 and b.kode_pengadilan_tk2 = c.kode_pengadilan_tk2
		where a.no_surat = '".$nosrt."' and a.no_register_perkara = '".$noperkara."' and a.tanggal_s11 = '".$tgls11."'";
		$model 	= HarianSidang::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['head' => $model]);
	} 

}
