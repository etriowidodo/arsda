<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\LaporanPrincipal;

class LaporanPrincipalController extends Controller{

    public function actionIndex(){
    if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara']) {
		$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.nomor_prinsipal,i.tanggal_prinsipal,i.kepada_yth,i.di,i.sifat,i.lampiran,i.perihal,i.pihak,
				i.kasus_posisi,i.penanganan_perkara,i.resume,i.file_prinsipal,
				a.tanggal_panggilan_pengadilan,i.no_register_perkara as is_cek, a.no_register_perkara, a.no_surat,a.kode_jenis_instansi,
				a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,i.no_register_skk,
				i.tanggal_skk,i.no_register_skks,d.tanggal_ttd as tanggal_skks,
				e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
				a.tanggal_diterima, i.penandatangan_nama, i.penandatangan_nip, i.penandatangan_jabatan,
				i.penandatangan_status, i.penandatangan_gol, i.penandatangan_pangkat, i.penandatangan_ttdjabat,
				i.is_inkrah
				from datun.permohonan a 				
				inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
				and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
				inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
				inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
				left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_surat=a.no_surat
				left join datun.prinsipal_utama i on i.no_register_perkara=a.no_register_perkara and i.no_surat=a.no_surat
				left join datun.skk b on i.no_surat=b.no_surat and i.no_register_perkara=b.no_register_perkara 
				and i.no_register_skk=b.no_register_skk and i.tanggal_skk=b.tanggal_skk
				left join datun.skks d on i.no_surat=d.no_surat and i.no_register_perkara=d.no_register_perkara 
				and i.no_register_skk=d.no_register_skk and i.tanggal_skk=d.tanggal_skk and i.no_register_skks=d.no_register_skks
				where a.no_surat='".$_SESSION['no_surat']."' and a.no_register_perkara='".$_SESSION['no_register_perkara']."'";
			$head 	= LaporanPrincipal::findBySql($sqlnya)->asArray()->one();
			return $this->render('index', ['head' => $head]);
		} else {
			Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK kembali']);
			return $this->redirect(['skk/index']);
		}
    }
	
    public function actionCek(){
		if (Yii::$app->request->isAjax) {
			$model = new LaporanPrincipal;
			$nilai = $model->cekLapPrinsipal(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

   public function actionSimpan(){
		$model 	= new LaporanPrincipal;
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
			$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.nomor_prinsipal,i.tanggal_prinsipal,i.kepada_yth,i.di,i.sifat,i.lampiran,i.perihal,i.pihak,
				i.kasus_posisi,i.penanganan_perkara,i.resume,i.file_prinsipal,
				a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
				a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk,
				b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
				e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat, k.nama_pegawai, k.jabatan_pegawai,
				a.tanggal_diterima, a.status_pemohon, a.no_status_pemohon, j.status_tergugat, j.no_status_tergugat,
				l.jabatan_pegawai as penerima_kuasa, i.penandatangan_nama, i.penandatangan_nip, i.penandatangan_jabatan,
				i.penandatangan_status, i.penandatangan_gol, i.penandatangan_pangkat, i.penandatangan_ttdjabat
				from datun.permohonan a 
				inner join datun.skk b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
				inner join datun.skk_anak k on b.no_surat=k.no_surat and b.no_register_perkara=k.no_register_perkara
				and b.no_register_skk=k.no_register_skk and b.tanggal_skk=k.tanggal_skk
				inner join datun.turut_tergugat j on a.no_surat=j.no_surat and a.no_register_perkara=j.no_register_perkara
				inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
				and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
				inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
				left join datun.skks d on b.no_register_skk=d.no_register_skk and b.tanggal_skk=d.tanggal_skk and b.no_register_perkara=d.no_register_perkara
				and b.no_surat=d.no_surat and is_active='1'
				left join datun.skks_anak l on d.no_register_perkara = l.no_register_perkara and d.no_surat = l.no_surat 
				and d.no_register_skks=l.no_register_skks and d.tanggal_skk=l.tanggal_skk and d.no_register_skk=l.no_register_skk
				inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
				left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
				left join datun.prinsipal_utama i on i.no_register_perkara=a.no_register_perkara and i.no_register_skks=d.no_register_skks
				and i.no_putusan=h.no_putusan and i.tanggal_putusan=h.tanggal_putusan
				where a.no_surat='".$_SESSION['no_surat']."' 
				and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
				and b.no_register_skk='".$_SESSION['no_register_skk']."' 
				and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
				and d.no_register_skks='".$_SESSION['no_skks']."'
				";
			$model 	= LaporanPrincipal::findBySql($sqlnya)->asArray()->one();
			return $this->render('cetak', ['model'=>$model]);
		} else {
				Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK dan SKKS kembali']);
				return $this->redirect(['skk/index']);
		}
	}

}