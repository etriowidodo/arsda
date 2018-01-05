<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\S26;

class S26Controller extends Controller{

    public function actionIndex(){
		if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara']) {
			$sqlnya="SELECT k.tanggal_s26,k.di_s26,k.alasan_kasasi,k.isi_petitum_primer,k.isi_petitum_subsider,k.file_s26,k.kepada_yth_s26,
						k.no_permohonan_kasasi, k.tgl_permohonan_kasasi,k.file_permohonan_kasasi, k.melalui,k.file_relas, 						h.no_putusan,h.tanggal_putusan,h.amar_putusan,a.tanggal_panggilan_pengadilan, k.no_register_perkara as is_cek, a.no_register_perkara, a.no_surat, a.kode_jenis_instansi,
						a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat, k.no_register_skk,
						k.tanggal_skk,k.no_register_skks,d.tanggal_ttd as tanggal_skks,
						e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
						a.tanggal_diterima, k.is_inkrah
						from datun.permohonan a 
						inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
						and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
						inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
						inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
						left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_surat=a.no_surat
						left join datun.s26 k on k.no_register_perkara=a.no_register_perkara and k.no_surat=a.no_surat
						left join datun.skk b on k.no_surat=b.no_surat and k.no_register_perkara=b.no_register_perkara and k.no_register_skk=b.no_register_skk and k.tanggal_skk=b.tanggal_skk
						left join datun.skks d on k.no_register_skk=d.no_register_skk and k.tanggal_skk=d.tanggal_skk and k.no_register_perkara=d.no_register_perkara and k.no_surat=d.no_surat and k.no_register_skks=d.no_register_skks
						where a.no_surat='".$_SESSION['no_surat']."' 
						and a.no_register_perkara='".$_SESSION['no_register_perkara']."'";
			$head 	= S26::findBySql($sqlnya)->asArray()->one();
			return $this->render('index', ['head' => $head]);
		} else {
			Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK kembali']);
			return $this->redirect(['skk/index']);
		}
    }
	
    public function actionCeksp1(){
		if (Yii::$app->request->isAjax) {
			$model = new Sp1;
			$nilai = $model->cekSp1(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

   public function actionSimpan(){
		$model 	= new S26;
		$simpan = $model->simpanData(Yii::$app->request->post());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['index']);
        }
    }

	public function actionCetak(){ 
	if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara']) {
		$sqlnya="SELECT k.tanggal_s26,k.di_s26,k.alasan_kasasi,k.isi_petitum_primer,k.isi_petitum_subsider,k.file_s26,k.kepada_yth_s26,
					k.no_permohonan_kasasi, k.tgl_permohonan_kasasi,k.file_permohonan_kasasi, k.melalui,k.file_relas,
					h.no_putusan,h.tanggal_putusan,h.amar_putusan,a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
					a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk, a.status_pemohon, a.no_status_pemohon,
					b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
					e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat, i.jabatan_pegawai,
					a.tanggal_diterima , i.nama_pegawai,l.deskripsi_jnsinstansi as jns_instansi, m.deskripsi_instansi,
					a.pimpinan_pemohon, c.deskripsi_inst_wilayah, n.jabatan_pegawai as jab_skks
					from datun.permohonan a 
					inner join datun.skk b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
					left join datun.skk_anak i on b.no_register_perkara = i.no_register_perkara and b.no_surat = i.no_surat 
					and b.no_register_skk = i.no_register_skk and b.tanggal_skk = i.tanggal_skk 
					join datun.instansi m on a.kode_jenis_instansi = m.kode_jenis_instansi and a.kode_instansi = m.kode_instansi
					inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
					and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
					inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
					left join datun.skks d on b.no_register_skk=d.no_register_skk and b.tanggal_skk=d.tanggal_skk and b.no_register_perkara=d.no_register_perkara
					and b.no_surat=d.no_surat and is_active='1'
					left join datun.skks_anak n on d.no_register_perkara = n.no_register_perkara and d.no_surat = n.no_surat 
					and d.no_register_skk = n.no_register_skk and d.tanggal_skk = n.tanggal_skk and d.no_register_skks = n.no_register_skks
					inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
					left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
					left join datun.s26 k on k.no_register_perkara=a.no_register_perkara and k.no_register_skks=d.no_register_skks
					and k.no_putusan=h.no_putusan
					join datun.jenis_instansi l on a.kode_jenis_instansi = l.kode_jenis_instansi
					where a.no_surat='".$_SESSION['no_surat']."' 
					and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
					and b.no_register_skk='".$_SESSION['no_register_skk']."' 
					and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
			";	
			$model 	= S26::findBySql($sqlnya)->asArray()->one();
			return $this->render('cetak', ['model'=>$model]);
		} else {
				Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK dan SKKS kembali']);
				return $this->redirect(['skk/index']);
		}
	}

}