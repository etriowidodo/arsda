<?php

namespace app\modules\datun\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\HtmlPurifier;
use app\modules\datun\models\Sp5;

class Sp5Controller extends Controller{

    public function actionIndex(){
        $sqlnya = "
			select f.tanggal_ttd, f.posisi_kasus_dt, f.posisi_kasus_ft, f.permasalahan, f.analisa, f.kesimpulan, f.saran, f.file_s5, e.no_sp1, e.no_register_perkara, e.no_surat, 
			b.deskripsi_jnsinstansi as jenis_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, f.petunjuk, a.tanggal_diterima, 
			a.tanggal_permohonan, a.tanggal_panggilan_pengadilan, e.tanggal_ttd as tanggal_sp1, a.kode_jenis_instansi
			from datun.permohonan a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi and a.kode_kabupaten = d.kode_kabupaten
				and a.kode_provinsi = d.kode_provinsi and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join datun.sp1 e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
			left join datun.s5 f on e.no_register_perkara = f.no_register_perkara and e.no_surat = f.no_surat 
			where e.no_register_perkara = '".$_SESSION['no_register_perkara']."' and e.no_surat = '".$_SESSION['no_surat']."'";
		$model 	= Sp5::findBySql($sqlnya)->asArray()->one();
		return $this->render('index', ['model' => $model]);
    }

    public function actionCeksp5(){
		if (Yii::$app->request->isAjax) {
			$model = new Sp5;
			$nilai = $model->cekSp5(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

    public function actionSimpan(){
        $model  = new Sp5;
        $param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
        if($sukses && !$param['cek_aja']){
            Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
            return $this->redirect(['index']);
        } else if($sukses && $param['cek_aja']){
            Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
            return $this->redirect(['/datun/hasiltelaah/index#cb_keputusan']);
        } else{
            Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['index']);
        }
    }

	public function actionCetak(){
        $sqlnya = "
			select f.tanggal_ttd, f.posisi_kasus_dt, f.posisi_kasus_ft, f.permasalahan, f.analisa, f.kesimpulan, f.saran, f.file_s5, e.no_sp1, e.no_register_perkara, e.no_surat, 
			b.deskripsi_jnsinstansi as jenis_instansi, c.deskripsi_instansi as nama_instansi, d.deskripsi_inst_wilayah as wil_instansi, f.petunjuk, a.tanggal_diterima, 
			a.tanggal_permohonan, a.tanggal_panggilan_pengadilan, a.permasalahan_pemohon, e.tanggal_ttd as tanggal_sp1, a.kode_jenis_instansi 
			from datun.permohonan a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi and a.kode_kabupaten = d.kode_kabupaten
				and a.kode_provinsi = d.kode_provinsi and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join datun.sp1 e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
			left join datun.s5 f on e.no_register_perkara = f.no_register_perkara and e.no_surat = f.no_surat 
			where e.no_register_perkara = '".$_SESSION['no_register_perkara']."' and e.no_surat = '".$_SESSION['no_surat']."'";
		$model 	= Sp5::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}

}