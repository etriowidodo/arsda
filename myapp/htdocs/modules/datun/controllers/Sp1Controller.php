<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Sp1;

class Sp1Controller extends Controller{

    public function actionIndex(){
		$sqlnya = "
			select a.*, b.deskripsi_jnsinstansi, c.deskripsi_instansi, d.deskripsi_inst_wilayah, e.no_sp1, e.tanggal_ttd, e.penandatangan_status, e.penandatangan_nama, 
			e.penandatangan_nip, e.penandatangan_jabatan, e.penandatangan_gol, e.penandatangan_pangkat, e.penandatangan_ttdjabat, e.file_sp1, b.kode_jenis_instansi 
			from datun.permohonan a 
			inner join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
			inner join datun.instansi c on a.kode_instansi = c.kode_instansi and a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_tk = c.kode_tk 
			inner join datun.instansi_wilayah d on a.kode_instansi = d.kode_instansi and a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_provinsi = d.kode_provinsi
			and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
			left join datun.sp1 e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat
			where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";
		$model 	= Sp1::findBySql($sqlnya)->asArray()->one();
		return $this->render('index', ['model' => $model]);
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
		$model 	= new Sp1;
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
		$sqlnya = "
			select a.*, b.deskripsi_jnsinstansi, c.deskripsi_instansi, d.deskripsi_inst_wilayah, e.no_sp1, e.tanggal_ttd, e.penandatangan_status, e.penandatangan_nama, 
			e.penandatangan_nip, e.penandatangan_jabatan, e.penandatangan_gol, e.penandatangan_pangkat, e.penandatangan_ttdjabat, e.file_sp1, b.kode_jenis_instansi 
			from datun.permohonan a 
			inner join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi 
			inner join datun.instansi c on a.kode_instansi = c.kode_instansi and a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_tk = c.kode_tk 
			inner join datun.instansi_wilayah d on a.kode_instansi = d.kode_instansi and a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_provinsi = d.kode_provinsi
			and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
			left join datun.sp1 e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat
			where a.no_surat = '".$_SESSION['no_surat']."' and a.no_register_perkara = '".$_SESSION['no_register_perkara']."'";
		$model 	= Sp1::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}

}
