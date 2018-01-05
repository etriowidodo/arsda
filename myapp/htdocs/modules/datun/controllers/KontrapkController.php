<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\KontraPK;

class KontrapkController extends Controller{

    public function actionIndex(){
     if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara']) {
		$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.tanggal_kontra_pk,i.kepada_yth,
				i.melalui, i.di_kontrapk, i.file_kontrapk,i.amar_putusan, a.tanggal_panggilan_pengadilan, i.no_register_perkara as is_cek, a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
				a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,i.no_register_skk,
				i.tanggal_skk,i.no_register_skks,d.tanggal_ttd as tanggal_skks, i.file_memori_pk, i.file_relas,
				e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
				a.tanggal_diterima, i.is_inkrah
				from datun.permohonan a 
				inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
				and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
				inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
				inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
				left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_surat=a.no_surat
				left join datun.kontra_memori_pk i on i.no_register_perkara=a.no_register_perkara and i.no_surat=a.no_surat
				left join datun.skk b on i.no_surat=b.no_surat and i.no_register_perkara=b.no_register_perkara and i.no_register_skk=b.no_register_skk and i.tanggal_skk=b.tanggal_skk
				left join datun.skks d on i.no_surat=d.no_surat and i.no_register_perkara=d.no_register_perkara 
				and i.no_register_skk=d.no_register_skk and i.tanggal_skk=d.tanggal_skk and i.no_register_skks=d.no_register_skks
				where a.no_surat='".$_SESSION['no_surat']."' and a.no_register_perkara='".$_SESSION['no_register_perkara']."'";
			$head 	= KontraPK::findBySql($sqlnya)->asArray()->one();
			return $this->render('index', ['head' => $head]);
		} else {
			Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK kembali']);
			return $this->redirect(['skk/index']);
		}
    }
	
    public function actionCek(){
		if (Yii::$app->request->isAjax) {
			$model = new KontraPK;
			$nilai = $model->cekKontraPK(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

   public function actionSimpan(){
		$model 	= new kontraPK;
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
		if($_SESSION['no_surat'] && $_SESSION['no_register_perkara']) {
			$sqlnya = "
				SELECT h.no_putusan, h.amar_putusan as putusan_awal, h.tanggal_putusan,i.tanggal_kontra_pk,i.nomor_memori_pk,i.tanggal_memori_pk,i.kepada_yth,
					i.melalui, i.di_kontrapk, i.amar_putusan, a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
					a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk,
					b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
					e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
					a.tanggal_diterima, j.nama_pegawai as nama_pemberi,l.deskripsi_jnsinstansi as jns_instansi,
					a.status_pemohon, a.no_status_pemohon, j.jabatan_pegawai, coalesce(j.jabatan_pegawai, k.jabatan_pegawai) as pemberi_kuasa,
					k.jabatan_pegawai as penerima_kuasa, c.alamat as alamat_instansi, a.pimpinan_pemohon
					from datun.permohonan a 
					inner join datun.skk b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
					left join datun.skk_anak j on b.no_register_perkara = j.no_register_perkara and b.no_surat = j.no_surat 
					and b.no_register_skk = j.no_register_skk and b.tanggal_skk = j.tanggal_skk 
					inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
					and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
					inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
					left join datun.skks d on b.no_register_skk=d.no_register_skk and b.tanggal_skk=d.tanggal_skk and b.no_register_perkara=d.no_register_perkara
					and b.no_surat=d.no_surat and is_active='1'
					left join datun.skks_anak k on d.no_register_perkara = k.no_register_perkara and d.no_surat = k.no_surat 
					and d.no_register_skks=k.no_register_skks and d.tanggal_skk=k.tanggal_skk and d.no_register_skk=k.no_register_skk
					inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
					left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
					left join datun.kontra_memori_pk i on i.no_register_perkara=a.no_register_perkara and i.no_register_skks=d.no_register_skks
					and i.no_putusan=h.no_putusan
					join datun.jenis_instansi l on a.kode_jenis_instansi = l.kode_jenis_instansi
					where a.no_surat='".$_SESSION['no_surat']."' 
					and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
					and b.no_register_skk='".$_SESSION['no_register_skk']."' 
					and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
					and d.no_register_skks='".$_SESSION['no_skks']."'";
			$model 	= KontraPK::findBySql($sqlnya)->asArray()->one();
			return $this->render('cetak', ['model'=>$model]);
		} else {
				Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK kembali']);
				return $this->redirect(['skk/index']);
		}
	}

}
