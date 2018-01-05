<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Skk;

class SkkController extends Controller{

    public function actionIndex(){
		$_SESSION['no_register_perkara'] = '';
		$_SESSION['no_surat'] 			 = '';
		$_SESSION['no_register_skk'] 	 = '';
		$_SESSION['tanggal_skk'] 		 = '';
		//$_SESSION['no_skks']			 = '' ;
		$_SESSION['bantuan_hukum'] 	 	= ''; 
        $searchModel = new Skk;
        $dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(){
        $model = new Skk;
		return $this->render('create', ['model' => $model]);
    }

    public function actionGetpermohonan(){
		$searchModel = new Skk;
		$dataProvider = $searchModel->getPermohonan(Yii::$app->request->get());
		return $this->renderAjax('_getPermohonan', ['dataProvider' => $dataProvider]);
    }

    public function actionGetpenerimakuasa(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new Skk;
			$post = Yii::$app->request->post();
			if($post['tk'] == '0' && $post['tp'] == '06'){
				$sqlnya = "
					select peg_nip_baru as q1, nama as q2, jabatan as q3 
					from kepegawaian.kp_pegawai where jabat_jenisjabatan = 1 and ref_jabatan_kd = 3 and unitkerja_kd = '1.5' 
						and inst_satkerkd = '".$_SESSION['inst_satkerkd']."' and is_verified = 1";
				$hasil = Skk::findBySql($sqlnya)->asArray()->one();
				$post['q1'] = $hasil['q1'];
				$post['q2'] = $hasil['q2'];
				$post['q3'] = $hasil['q3'];
				$post['q4'] = Yii::$app->inspektur->getLokasiSatker()->alamat;
			}
			return $this->renderAjax('_getPenerimaKuasa', ['post' => $post]);
		}    
    }

    public function actionGetpenerimapusat(){
		if (Yii::$app->request->isAjax) {
			$model = new Skk;
			$hasil = $model->getPenerimaPusat(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }

    public function actionGetpegawai(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new Skk;
			$dataProvider = $searchModel->getPegawai(Yii::$app->request->get());
			return $this->renderAjax('_getPegawai', ['dataProvider' => $dataProvider]);
		}    
    }

    public function actionGetjpnsp1(){
		if (Yii::$app->request->isAjax) {
        	$sqlnya = "select * from datun.sp1_timjpn where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."'";
			$model 	= Skk::findBySql($sqlnya)->asArray()->all();
			return $this->renderAjax('_getjpnsp1', ['model' => $model]);
		}    
    }

    public function actionUpdate($id, $np, $nk, $tk, $th){ 
        $id = rawurldecode($id);
        $np = rawurldecode($np);
        $nk = rawurldecode($nk);
        $tk = rawurldecode($tk);
		$th = rawurldecode($th);
        $_SESSION['no_register_perkara'] = $id;
        $_SESSION['no_surat'] 			 = $np;
        $_SESSION['no_register_skk'] 	 = $nk;
        $_SESSION['tanggal_skk'] 		 = $tk;
		if ($th==1) {
			$_SESSION['bantuan_hukum'] 	 = '';
		} else {
			$_SESSION['bantuan_hukum'] 	 = '1';
		}
		
		$sqlnya = " 
			select a.tanggal_panggilan_pengadilan, a.pimpinan_pemohon, a.kode_jenis_instansi, b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi, 
			d.deskripsi_inst_wilayah as wil_instansi, d.alamat as alamat_instansi, e.inst_nama as diterima_satker, e.inst_lokinst, e.inst_alamat as alamat_penerima_kuasa, 
			f.nama_pengadilan, a.tanggal_permohonan, g.* 
			from datun.permohonan a
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join kepegawaian.kp_inst_satker e on a.kode_tk = e.kode_tk and a.kode_kejati = e.kode_kejati and a.kode_kejari = e.kode_kejari and a.kode_cabjari = e.kode_cabjari
			join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
			join datun.skk g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat 
			where g.no_register_perkara = '".$id."' and g.no_surat = '".$np."' and g.no_register_skk = '".$nk."' and g.tanggal_skk = '".$tk."'";
		$model 	= Skk::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekskk(){
		if (Yii::$app->request->isAjax) {
			$model = new Skk;
			$nilai = $model->cekSkk(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

    public function actionSimpan(){
        $model 	= new Skk;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($param['isNewRecord']){
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['create']);
			}
		} else{
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['index']);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['update', 'id'=>rawurlencode($param['nomor_skk']), 'ns'=>rawurlencode($param['tanggal_skk'])]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Skk;
			$hasil = $model->hapusData(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

	public function actionCetak(){
        $id = $_SESSION['no_register_perkara'];
        $np = $_SESSION['no_surat'];
        $nk = $_SESSION['no_register_skk'];
        $tk = $_SESSION['tanggal_skk'];

		$sqlnya = "
			select a.tanggal_panggilan_pengadilan, a.pimpinan_pemohon, a.kode_jenis_instansi, initcap(a.status_pemohon||' '||a.no_status_pemohon) as status_pemohon, 
			b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi, 
			d.deskripsi_inst_wilayah as wil_instansi, d.alamat as alamat_instansi, e.inst_nama as diterima_satker, e.inst_lokinst, e.inst_alamat as alamat_penerima_kuasa, 
			f.nama_pengadilan, g.* 
			from datun.permohonan a
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join kepegawaian.kp_inst_satker e on a.kode_tk = e.kode_tk and a.kode_kejati = e.kode_kejati and a.kode_kejari = e.kode_kejari and a.kode_cabjari = e.kode_cabjari
			join datun.master_pengadilan f on a.kode_pengadilan_tk1 = f.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = f.kode_pengadilan_tk2
			join datun.skk g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat 
			where g.no_register_perkara = '".$id."' and g.no_surat = '".$np."' and g.no_register_skk = '".$nk."' and g.tanggal_skk = '".$tk."'";
		$model 	= Skk::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}

}
