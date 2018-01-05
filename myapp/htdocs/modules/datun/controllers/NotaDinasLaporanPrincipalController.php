<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\NotaDinasLaporanPrincipal;

class NotaDinasLaporanPrincipalController extends Controller{

    public function actionIndex(){
        if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara'] && $_SESSION['no_register_skk'] && $_SESSION['tanggal_skk'] && $_SESSION['no_skks']) {
		$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.nomor_prinsipal, i.tanggal_prinsipal, j.nomor_nodis, j.tanggal_nodis, j.kepada_yth, j.sifat, j.lampiran, j.perihal,
				j.kasus_posisi, j.putusan_aquo, j.kesimpulan, j.file_nodis, j.dari, j.penandatangan_nama, j.penandatangan_nip, j.penandatangan_jabatan,
				j.penandatangan_status, j.penandatangan_gol, j.penandatangan_pangkat, j.penandatangan_ttdjabat,
				a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
				a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk,
				b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
				e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
				a.tanggal_diterima
				from datun.permohonan a 
				inner join datun.skk b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
				inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
				and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
				inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
				left join datun.skks d on b.no_register_skk=d.no_register_skk and b.tanggal_skk=d.tanggal_skk and b.no_register_perkara=d.no_register_perkara
				and b.no_surat=d.no_surat and is_active='1'
				inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
				left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
				left join datun.prinsipal_utama i on i.no_register_perkara=a.no_register_perkara and i.no_register_skks=d.no_register_skks
				and i.no_putusan=h.no_putusan and i.tanggal_putusan=h.tanggal_putusan
				left join datun.prinsipal_nodis j on i.nomor_prinsipal=j.nomor_prinsipal and i.no_register_skks=j.no_register_skks
				and i.no_putusan=j.no_putusan and i.tanggal_putusan=j.tanggal_putusan
				where a.no_surat='".$_SESSION['no_surat']."' 
				and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
				and b.no_register_skk='".$_SESSION['no_register_skk']."' 
				and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
				and d.no_register_skks='".$_SESSION['no_skks']."'
				";
			$head 	= NotaDinasLaporanPrincipal::findBySql($sqlnya)->asArray()->one();
			return $this->render('index', ['head' => $head]);
		} else {
					return $this->redirect(['skk/index']);
		}
    }
	
    public function actionCek(){
		if (Yii::$app->request->isAjax) {
			$model = new NotaDinasLaporanPrincipal;
			$nilai = $model->cekNodisLapPrinsipal(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

   public function actionSimpan(){
		$model 	= new NotaDinasLaporanPrincipal;
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
		if($_SESSION['no_surat'] && $_SESSION['no_register_perkara'] && $_SESSION['no_register_skk'] && $_SESSION['tanggal_skk'] && $_SESSION['no_skks']) {
			$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.nomor_prinsipal, i.tanggal_prinsipal, j.nomor_nodis, j.tanggal_nodis, j.kepada_yth, j.sifat, j.lampiran, j.perihal,
				j.kasus_posisi, j.putusan_aquo, j.kesimpulan, j.file_nodis, j.dari, j.penandatangan_nama, j.penandatangan_nip, j.penandatangan_jabatan,
				j.penandatangan_status, j.penandatangan_gol, j.penandatangan_pangkat, j.penandatangan_ttdjabat,
				a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
				a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk,
				b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
				e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
				a.tanggal_diterima, k.deskripsi_instansi, l.jabatan_pegawai as jab_skk, m.status_tergugat, m.no_status_tergugat,
				a.status_pemohon, a.no_status_pemohon
				from datun.permohonan a 
				inner join datun.skk b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
				inner join datun.skk_anak l on b.no_surat=l.no_surat and b.no_register_perkara=l.no_register_perkara
				and b.no_register_skk=l.no_register_skk and b.tanggal_skk=l.tanggal_skk
				inner join datun.turut_tergugat m on a.no_surat=m.no_surat and a.no_register_perkara=m.no_register_perkara
				inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
				and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
				join datun.instansi k on a.kode_jenis_instansi = k.kode_jenis_instansi and a.kode_instansi = k.kode_instansi
				inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
				left join datun.skks d on b.no_register_skk=d.no_register_skk and b.tanggal_skk=d.tanggal_skk and b.no_register_perkara=d.no_register_perkara
				and b.no_surat=d.no_surat and is_active='1'
				inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
				left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
				left join datun.prinsipal_utama i on i.no_register_perkara=a.no_register_perkara and i.no_register_skks=d.no_register_skks
				and i.no_putusan=h.no_putusan and i.tanggal_putusan=h.tanggal_putusan
				left join datun.prinsipal_nodis j on i.nomor_prinsipal=j.nomor_prinsipal and i.no_register_skks=j.no_register_skks
				and i.no_putusan=j.no_putusan and i.tanggal_putusan=j.tanggal_putusan
				where a.no_surat='".$_SESSION['no_surat']."' 
				and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
				and b.no_register_skk='".$_SESSION['no_register_skk']."' 
				and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
				and d.no_register_skks='".$_SESSION['no_skks']."'
				";
			$model 	= NotaDinasLaporanPrincipal::findBySql($sqlnya)->asArray()->one();
			return $this->render('cetak', ['model'=>$model]);
		} else {
				Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK dan SKKS kembali']);
				return $this->redirect(['skk/index']);
		}
	}

}
