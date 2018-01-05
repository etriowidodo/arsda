<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Mediasi;

class MediasiController extends Controller{

    public function actionIndex(){
		$sqlnya = "
		with tbl_lawan_pemohon as( 
			select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as lawan_pemohon 
			from datun.lawan_pemohon group by no_register_perkara, no_surat 
		)
		select a.*, c.deskripsi_inst_wilayah, d.nama_pengadilan, e.no_register_skk, e.tanggal_skk, e.no_register_skks, g.tanggal_ttd as tgl_skks, e.proses_mediasi, 
		e.file_mediasi, b.lawan_pemohon as penggugat 
		from datun.permohonan a
		join tbl_lawan_pemohon b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
		join datun.instansi_wilayah c on a.kode_instansi = c.kode_instansi and a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_provinsi = c.kode_provinsi
			and a.kode_kabupaten = c.kode_kabupaten and a.kode_tk = c.kode_tk and a.no_urut_wil = c.no_urut
		join datun.master_pengadilan d on a.kode_pengadilan_tk1 = d.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = d.kode_pengadilan_tk2
		left join datun.mediasi e on a.no_surat = e.no_surat and a.no_register_perkara = e.no_register_perkara  
		left join datun.skk f on e.no_register_skk = f.no_register_skk and e.tanggal_skk = f.tanggal_skk and e.no_register_perkara = f.no_register_perkara 
			and e.no_surat = f.no_surat 
		left join datun.skks g on e.no_register_skk = g.no_register_skk and e.tanggal_skk = g.tanggal_skk and e.no_register_perkara = g.no_register_perkara 
			and e.no_surat = g.no_surat and e.no_register_skks = g.no_register_skks 
		where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";
		$model = Mediasi::findBySql($sqlnya)->asArray()->one();		
		return $this->render('index', ['model' => $model]);    
    }
	
   public function actionSimpan(){
		$model 	= new Mediasi;
		$simpan = $model->simpanData(Yii::$app->request->post());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['create']);
        }
    }

}
