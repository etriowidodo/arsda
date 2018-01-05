<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\S24;

class S24Controller extends Controller{

    public function actionIndex(){
	 if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara'] ) {
		$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.kepada_yth_s24,i.file_s24,i.file_s24_putusan,i.nomor,i.perihal,i.tanggal_s24,i.alasan_penundaan_s24,i.di_s24,a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
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
					join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
					left join datun.s24 i on i.no_register_perkara=a.no_register_perkara and i.no_register_skks=d.no_register_skks
					and i.no_putusan=h.no_putusan
					where a.no_surat='".$_SESSION['no_surat']."' 
					and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
					and b.no_register_skk='".$_SESSION['no_register_skk']."' 
					and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
			";
		$head 	= S24::findBySql($sqlnya)->asArray()->one();
		return $this->render('index', ['head' => $head]);
		} else {
			return $this->redirect(['skk/index']);
		}
		
    }
	
    public function actionCeks24(){
		if (Yii::$app->request->isAjax) {
			$model = new S24;
			$nilai = $model->cekS24(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

   public function actionSimpan(){
		$model 	= new S24;
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
	 if ($_SESSION['no_surat'] && $_SESSION['no_register_perkara'] && $_SESSION['no_register_skk'] && $_SESSION['tanggal_skk'] && $_SESSION['no_skks']) {
			$sqlnya="SELECT h.no_putusan,h.tanggal_putusan,i.kepada_yth_s24,i.file_s24,i.nomor,i.perihal,i.tanggal_s24,i.alasan_penundaan_s24,i.di_s24,a.tanggal_panggilan_pengadilan,a.no_register_perkara,a.no_surat,a.kode_jenis_instansi,
						a.kode_instansi,a.kode_kabupaten,f.nama_pengadilan,f.alamat,b.no_register_skk,h.amar_putusan,
						b.tanggal_skk,d.no_register_skks,d.tanggal_ttd as tanggal_skks,
						e.nama_instansi as penggugat,c.deskripsi_inst_wilayah as tergugat,
						a.tanggal_diterima, j.nip_pegawai,j.nama_pegawai
						from datun.permohonan a 
						inner join datun.skk b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara
						inner join datun.skk_anak j on j.no_register_skk=b.no_register_skk and j.no_surat=b.no_surat and j.no_register_perkara=b.no_register_perkara
						inner join datun.instansi_wilayah c on a.kode_instansi=c.kode_instansi and a.kode_jenis_instansi=c.kode_jenis_instansi and a.kode_provinsi=c.kode_provinsi
						and a.kode_kabupaten=c.kode_kabupaten and a.kode_tk=c.kode_tk and a.no_urut_wil=c.no_urut
						inner join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
						left join datun.skks d on b.no_register_skk=d.no_register_skk and b.tanggal_skk=d.tanggal_skk and b.no_register_perkara=d.no_register_perkara
						and b.no_surat=d.no_surat and is_active='1'
						inner JOIN datun.lawan_pemohon e on a.no_register_perkara=e.no_register_perkara and a.no_surat=e.no_surat 
						left join datun.putusan h on h.no_register_perkara=a.no_register_perkara and h.no_register_skks=d.no_register_skks
						left join datun.s24 i on i.no_register_perkara=a.no_register_perkara and i.no_register_skks=d.no_register_skks
						and i.no_putusan=h.no_putusan
						where a.no_surat='".$_SESSION['no_surat']."' 
						and a.no_register_perkara='".$_SESSION['no_register_perkara']."' 
						and b.no_register_skk='".$_SESSION['no_register_skk']."' 
						and b.tanggal_skk='".$_SESSION['tanggal_skk']."'
				";
			$model 	= S24::findBySql($sqlnya)->asArray()->one();
			return $this->render('cetak', ['model'=>$model]);
		} else {
				Yii::$app->session->setFlash('success', ['type'=>'warning', 'message'=>'Maaf, Session habis, pilih SKK dan SKKS kembali']);
				return $this->redirect(['skk/index']);
		}
	}

}
