<?php 

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Bukti;

class BuktiController extends Controller{

    public function actionIndex(){
		$sqlnya = "
		with tbl_lawan_pemohon as( 
			select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
			from datun.lawan_pemohon group by no_register_perkara, no_surat 
		)
		select a.*, d.deskripsi_inst_wilayah, f.nama_pengadilan, f.alamat as alamat_pengadilan, i.no_register_skk, i.tanggal_skk, i.no_register_skks, 
		h.tanggal_ttd as tanggal_skks, i.tanggal_s19a, i.kepada_yth, i.tempat, i.file_s19a, e.lawan_pemohon as penggugat 
		from datun.permohonan a
		join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
		join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
		join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
			and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
		join tbl_lawan_pemohon e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
		join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
		left join datun.s19a i on i.no_register_perkara = a.no_register_perkara and i.no_surat = a.no_surat 
		left join datun.skk g on i.no_register_skk = g.no_register_skk and i.tanggal_skk = g.tanggal_skk and i.no_register_perkara = g.no_register_perkara 
			and i.no_surat = g.no_surat 
		left join datun.skks h on i.no_register_skk = h.no_register_skk and i.tanggal_skk = h.tanggal_skk and i.no_register_perkara = h.no_register_perkara 
			and i.no_surat = h.no_surat and i.no_register_skks = h.no_register_skks 
		where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";	
		$model = Bukti::findBySql($sqlnya)->asArray()->one();			
		return $this->render('index', ['model' => $model]);	
    }
	
   public function actionSimpan(){
		$model 	= new Bukti;
		$simpan = $model->simpanData(Yii::$app->request->post());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['create']);
        }
    }
	
	public function actionCetak(){
		$sqlnya = "
		with tbl_lawan_pemohon as( 
			select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
			from datun.lawan_pemohon group by no_register_perkara, no_surat 
		)
		select a.*, d.deskripsi_inst_wilayah, f.nama_pengadilan, f.alamat as alamat_pengadilan, i.no_register_skk, i.tanggal_skk, i.no_register_skks, 
		h.tanggal_ttd as tanggal_skks, i.tanggal_s19a, i.kepada_yth, i.tempat, i.file_s19a, e.lawan_pemohon as penggugat 
		from datun.permohonan a
		join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
		join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
		join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
			and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
		join tbl_lawan_pemohon e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
		join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
		left join datun.s19a i on i.no_register_perkara = a.no_register_perkara and i.no_surat = a.no_surat 
		left join datun.skk g on i.no_register_skk = g.no_register_skk and i.tanggal_skk = g.tanggal_skk and i.no_register_perkara = g.no_register_perkara 
			and i.no_surat = g.no_surat 
		left join datun.skks h on i.no_register_skk = h.no_register_skk and i.tanggal_skk = h.tanggal_skk and i.no_register_perkara = h.no_register_perkara 
			and i.no_surat = h.no_surat and i.no_register_skks = h.no_register_skks 
		where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";	
		$model = Bukti::findBySql($sqlnya)->asArray()->one();			

		$sqlBukti 	= "
		select b.* 
		from datun.s19a a 
		join datun.bukti_tertulis b on a.no_surat = b.no_surat and a.no_register_perkara = b.no_register_perkara 
		where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";
		$resBukti 	= Bukti::findBySql($sqlBukti)->asArray()->all();

		return $this->render('cetak', ['model'=>$model, 'modelBukti' => $resBukti]);
	}
}
