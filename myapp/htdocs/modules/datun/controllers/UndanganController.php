<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Undangan;

class UndanganController extends Controller{

    public function actionIndex(){
		if($_SESSION['no_surat']){
			$searchModel = new Undangan;
			$dataProvider = $searchModel->search(Yii::$app->request->get());
			return $this->render('index', [
				'searchModel' => $searchModel,
				'dataProvider' => $dataProvider,
			]);
		} else{
			return $this->redirect(['permohonan/index']);
		}
    }

    public function actionCreate(){
		if($_SESSION['no_surat']){
			$model = new Undangan;
			return $this->render('create', ['model' => $model]);
		} else{
			return $this->redirect(['permohonan/index']);
		}
	}

    public function actionGetundangan(){
		if (Yii::$app->request->isAjax) {
			$model = new Undangan;
			$hasil = $model->getUndangan(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }

    public function actionUpdate($id, $tp){
		if($_SESSION['no_surat']){
			$id = rawurldecode($id);
			$tp = rawurldecode($tp);

			if($tp == 1){
				$sqlnya = "
					with tbl_lawan as(
						 select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as penggugat
						 from datun.lawan_pemohon group by no_register_perkara, no_surat
					)
					select a.tanggal_permohonan, a.tanggal_diterima, b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, 
					d.deskripsi_inst_wilayah as tergugat, e.penggugat, f.*, '1' as tahap_undangan, g.tanggal_ttd as tanggal_sp1, b.kode_jenis_instansi 
					from datun.permohonan a 
					join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
					join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
					join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
						and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
					join tbl_lawan e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat
					join datun.surat_undangan_telaah f on a.no_register_perkara = f.no_register_perkara and a.no_surat = f.no_surat 
					left join datun.sp1 g on a.no_register_perkara = g.no_register_perkara and a.no_surat = g.no_surat 
					where f.no_register_perkara = '".$_SESSION['no_register_perkara']."' and f.no_surat = '".$_SESSION['no_surat']."' and f.no_surat_undangan = '".$id."'";
			} else if($tp == 2){
				$sqlnya = "
					with tbl_lawan as(
						 select no_register_perkara, no_surat, string_agg(nama_instansi, '#') as penggugat
						 from datun.lawan_pemohon group by no_register_perkara, no_surat
					)
					select a.tanggal_permohonan, a.tanggal_diterima, b.deskripsi_jnsinstansi as jns_instansi, c.deskripsi_instansi as nama_instansi, 
					d.deskripsi_inst_wilayah as tergugat, e.penggugat, g.no_register_skks, g.tanggal_ttd as tgl_skks, h.*, '2' as tahap_undangan, b.kode_jenis_instansi 
					from datun.permohonan a 
					join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
					join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk
					join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
						and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
					join tbl_lawan e on a.no_register_perkara = e.no_register_perkara and a.no_surat = e.no_surat 
					join datun.skk f on a.no_register_perkara = f.no_register_perkara and a.no_surat = f.no_surat 
					join datun.surat_undangan_sidang h on f.no_register_perkara = f.no_register_perkara and f.no_surat = h.no_surat and f.no_register_skk = h.no_register_skk 
						and f.tanggal_skk = h.tanggal_skk 
					left join datun.skks g on f.no_register_perkara = g.no_register_perkara and f.no_surat = g.no_surat and f.no_register_skk = g.no_register_skk 
						and f.tanggal_skk = g.tanggal_skk and g.is_active = 1 
					where h.no_register_perkara = '".$_SESSION['no_register_perkara']."' and h.no_surat = '".$_SESSION['no_surat']."' 
						and h.no_register_skk = '".$_SESSION['no_register_skk']."' and h.tanggal_skk = '".$_SESSION['tanggal_skk']."' and h.no_surat_undangan = '".$id."'";
			}
			$model 	= Undangan::findBySql($sqlnya)->asArray()->one();
			return $this->render('create', ['model' => $model]);
		} else{
			return $this->redirect(['permohonan/index']);
		}
    }

    public function actionCekundangan(){
		if (Yii::$app->request->isAjax) {
			$model = new Undangan;
			$hasil = $model->cekUndangan(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
		if($_SESSION['no_surat']){
			$model 	= new Undangan;
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
					return $this->redirect(['update', 'id'=>rawurlencode($param['nomor_skks'])]);
				}
			}
		} else{
			return $this->redirect(['permohonan/index']);
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Undangan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

    public function actionTtd($id, $tp){
        $id = rawurldecode($id);
        $tp = rawurldecode($tp);
		if($tp == 1){
			$sqlnya = "
				select a.no_surat_undangan, a.tanggal_surat_undangan, b.nama, b.pekerjaan, b.hubungan_dengan_su, b.alamat, b.hari, b.jam, b.tanggal_tanda_terima, b.file_ttd, 
				'1' as jns_undangan from datun.surat_undangan_telaah a 
				left join datun.surat_tanda_terima_telaah b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
					and a.no_surat_undangan = b.no_surat_undangan 
				where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' and a.no_surat_undangan = '".$id."'";
		} else if($tp == 2){
			$sqlnya = "
				select a.no_surat_undangan, a.tanggal_surat_undangan, b.nama, b.pekerjaan, b.hubungan_dengan_su, b.alamat, b.hari, b.jam, b.tanggal_tanda_terima, b.file_ttd, 
				'2' as jns_undangan from datun.surat_undangan_sidang a 
				left join datun.surat_tanda_terima_sidang b on a.no_register_perkara = b.no_register_perkara and a.no_surat = b.no_surat 
					and a.no_surat_undangan = b.no_surat_undangan and a.no_register_skk = b.no_register_skk and a.tanggal_skk = b.tanggal_skk
				where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' 
					and a.no_register_skk = '".$_SESSION['no_register_skk']."' and a.tanggal_skk = '".$_SESSION['tanggal_skk']."' and a.no_surat_undangan = '".$id."'";
		}
		$model 	= Undangan::findBySql($sqlnya)->asArray()->one();
		return $this->render('_form_ttd', ['model' => $model]);
    }

    public function actionSimpanttd(){
        $model 	= new Undangan;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanDataTtd($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['ttd', 'id'=>rawurlencode($param['no_surat_undangan']), 'tp'=>rawurlencode($param['jns_undangan'])]);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
			return $this->redirect(['ttd', 'id'=>rawurlencode($param['no_surat_undangan']), 'tp'=>rawurlencode($param['jns_undangan'])]);
		}
    }

    public function actionCetak($id, $tp){
        $id = rawurldecode($id);
        $tp = rawurldecode($tp);

		if($tp == 1){
			$sqlnya = "
				select a.*, c.no_sp1, c.tanggal_ttd, '1' as tipenya, b.nama as sifat_undangan, d.kode_jenis_instansi 
				from datun.surat_undangan_telaah a 
				join public.ms_sifat_surat b on a.sifat::integer = b.id 
				join datun.permohonan d on a.no_register_perkara = d.no_register_perkara and a.no_surat = d.no_surat 
				left join datun.sp1 c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
				where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' and a.no_surat_undangan = '".$id."'";
		} else if($tp == 2){
			$sqlnya = "
				select a.*, '2' as tipenya, b.nama as sifat_undangan, c.kode_jenis_instansi 
				from datun.surat_undangan_sidang a 
				join public.ms_sifat_surat b on a.sifat::integer = b.id 
				join datun.permohonan c on a.no_register_perkara = c.no_register_perkara and a.no_surat = c.no_surat 
				where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' 
					and a.no_register_skk = '".$_SESSION['no_register_skk']."' and a.tanggal_skk = '".$_SESSION['tanggal_skk']."' and a.no_surat_undangan = '".$id."'";
		}
		$model 	= Undangan::findBySql($sqlnya)->asArray()->one();
		return $this->render('cetak', ['model'=>$model]);
	}

}
