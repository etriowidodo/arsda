<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\S25;

class S25Controller extends Controller{

    public function actionIndex(){ 
	if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara']) {
			$sqlnya="SELECT j.tanggal_s25,j.di_s25,j.alasan_banding,j.isi_petitum_primer,j.isi_petitum_subsider,j.file_s25,j.kepada_yth_s25,
					j.melalui, j.no_permohonan_banding,j.tgl_permohonan_banding,j.file_permohonan_banding,					h.no_putusan,h.tanggal_putusan,h.amar_putusan,a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi, j.is_inkrah, j.file_akta_penyerahan_banding, j.no_register_perkara as is_cek,
					a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk,
					b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
					e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
					a.tanggal_diterima
					from datun.permohonan a 
					inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
					and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
					inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
					inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
					left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_surat=a.no_surat
					left join datun.s25 j on j.no_register_perkara=a.no_register_perkara and j.no_surat=a.no_surat
					left join datun.skk b on j.no_surat=b.no_surat and j.no_register_perkara=b.no_register_perkara and j.no_register_skk=b.no_register_skk and j.tanggal_skk=b.tanggal_skk
					left join datun.skks d on j.no_register_skk=d.no_register_skk and j.tanggal_skk=d.tanggal_skk and j.no_register_perkara=d.no_register_perkara and j.no_surat=d.no_surat and j.no_register_skks=d.no_register_skks
					where a.no_surat='".$_SESSION['no_surat']."' 
					and a.no_register_perkara='".$_SESSION['no_register_perkara']."'";
			$head 	= S25::findBySql($sqlnya)->asArray()->one();
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
		$model 	= new S25;
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
			$sqlnya="SELECT j.tanggal_s25,j.di_s25,j.alasan_banding,j.isi_petitum_primer,j.isi_petitum_subsider,j.file_s25,j.kepada_yth_s25,
					j.melalui, j.no_permohonan_banding,j.tgl_permohonan_banding,j.file_permohonan_banding,					h.no_putusan,h.tanggal_putusan,h.amar_putusan,a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi, j.is_inkrah, j.file_akta_penyerahan_banding, j.no_register_perkara as is_cek,
					a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk, a.pimpinan_pemohon,
					a.status_pemohon, a.no_status_pemohon,
					b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
					e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
					a.tanggal_diterima
					from datun.permohonan a 
					inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
					and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
					inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
					inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
					left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_surat=a.no_surat
					left join datun.s25 j on j.no_register_perkara=a.no_register_perkara and j.no_surat=a.no_surat
					left join datun.skk b on j.no_surat=b.no_surat and j.no_register_perkara=b.no_register_perkara and j.no_register_skk=b.no_register_skk and j.tanggal_skk=b.tanggal_skk
					left join datun.skks d on j.no_register_skk=d.no_register_skk and j.tanggal_skk=d.tanggal_skk and j.no_register_perkara=d.no_register_perkara and j.no_surat=d.no_surat and j.no_register_skks=d.no_register_skks
					where a.no_surat='".$_SESSION['no_surat']."' 
					and a.no_register_perkara='".$_SESSION['no_register_perkara']."'";
			$model 	= S25::findBySql($sqlnya)->asArray()->one();
			return $this->render('cetak', ['model'=>$model]);
		} else {
				Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK kembali']);
				return $this->redirect(['skk/index']);
		}
	}

}
