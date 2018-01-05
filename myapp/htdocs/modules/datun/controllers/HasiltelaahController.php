<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use app\modules\datun\models\searchs\Hasiltelaah as Search;

class HasiltelaahController extends Controller{

	public function actionIndex(){
		$searchModel = new Search;
		$no_register_perkara = $_SESSION['no_register_perkara'];	
		$no_surat = $_SESSION['no_surat'];
	
        $sql = "
			select f.no_register_perkara, f.no_surat,g.no_surat as no_surat_parm, f.petunjuk, f.tanggal_ttd as tanggal_s5, e.tanggal_ttd as tanggal_sp1, e.no_sp1, 
			b.deskripsi_jnsinstansi as jenis_instansi, a.kode_jenis_instansi, 
			c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, a.tanggal_diterima, a.tanggal_permohonan, a.tanggal_panggilan_pengadilan, 
			g.keputusan, g.sifat, g.lampiran_keputusan, g.perihal, g.tanggal_telaah, g.untuk, g.tempat, g.alasan1, g.alasan2, g.penandatangan_status, g.penandatangan_nama, 
			g.penandatangan_nip, g.penandatangan_jabatan, g.penandatangan_gol, g.penandatangan_pangkat, g.penandatangan_ttdjabat, g.file_disposisi, g.file_telaah, 
			g.file_terimatolak, g.no_surat_telaah, d.alamat as alamat_ins, h.deskripsi as nm_propinsi, g.is_approved  
			from datun.permohonan a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi and a.kode_kabupaten = d.kode_kabupaten
				and a.kode_provinsi = d.kode_provinsi and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join datun.sp1 e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
			left join datun.s5 f on e.no_register_perkara = f.no_register_perkara and e.no_surat = f.no_surat 
			join datun.m_propinsi h on a.kode_provinsi = h.id_prop 
			left join datun.keputusan_telaah g on f.no_register_perkara = g.no_register_perkara and f.no_surat = g.no_surat 
			where f.no_register_perkara = '".$_SESSION['no_register_perkara']."' and f.no_surat = '".$_SESSION['no_surat']."'";
		$seq = Yii::$app->db->createCommand($sql)->queryOne();   				
		$dataProvider = $searchModel->searchCustom($seq['no_surat_parm']);
        return $this->render('index', ['dataProvider'=>$dataProvider, 'seq'=>$seq]);
    }
	
    public function actionCektelaah(){
		if (Yii::$app->request->isAjax) {
			$model = new Search;
			$nilai = $model->cekTelaah(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}
	
     public function actionSimpanhasiltelaah(){
		$model 	= new Search;
		$simpan = $model->simpanDatahasiltelaah(Yii::$app->request->post());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
           	return $this->redirect(['index']);
        }
    }
  
	public function actionCetak(){
        $sqlnya = "
			select f.no_register_perkara, f.no_surat, f.petunjuk, f.tanggal_ttd as tanggal_s5, e.tanggal_ttd as tanggal_sp1, e.no_sp1, b.deskripsi_jnsinstansi as jenis_instansi, 
			c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, a.tanggal_diterima, a.tanggal_permohonan, a.tanggal_panggilan_pengadilan, 
			g.keputusan, g.sifat, g.lampiran_keputusan, g.perihal, g.tanggal_telaah, g.untuk, g.tempat, g.alasan1, g.alasan2, g.penandatangan_status, g.penandatangan_nama, 
			g.penandatangan_nip, g.penandatangan_jabatan, g.penandatangan_gol, g.penandatangan_pangkat, g.penandatangan_ttdjabat, g.file_disposisi, g.file_telaah, 
			g.file_terimatolak, g.no_surat_telaah, d.alamat as alamat_ins, h.deskripsi as nm_propinsi, i.nama as sifat_surat, a.kode_jenis_instansi 
			from datun.permohonan a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi and a.kode_kabupaten = d.kode_kabupaten
				and a.kode_provinsi = d.kode_provinsi and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join datun.sp1 e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
			left join datun.s5 f on e.no_register_perkara = f.no_register_perkara and e.no_surat = f.no_surat 
			join datun.m_propinsi h on a.kode_provinsi = h.id_prop 
			left join datun.keputusan_telaah g on f.no_register_perkara = g.no_register_perkara and f.no_surat = g.no_surat 
			left join public.ms_sifat_surat i on g.sifat::integer = i.id 
			where f.no_register_perkara = '".$_SESSION['no_register_perkara']."' and f.no_surat = '".$_SESSION['no_surat']."'";
		$model 	= Search::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}

}