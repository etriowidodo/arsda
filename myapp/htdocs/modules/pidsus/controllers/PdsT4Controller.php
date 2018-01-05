<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsT4;

class PdsT4Controller extends Controller{
    public function actionIndex(){
        unset($_SESSION['t4']);
        $searchModel = new PdsT4;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new PdsT4;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetTersangka(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsT4;
			$nilai = $model->getTersangka(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $nilai;
		}    
	}

    public function actionUpdate($id1, $id2){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
        $_SESSION['t4']=$id2;
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select a.nama, case when a.jenis_penahanan = 1 then 'Rutan' when a.jenis_penahanan = 2 then 'Rumah' when a.jenis_penahanan = 3 then 'Kota' end as jenis_thn, 
		a.lokasi_penahanan as lokasi_thn, to_char(a.tgl_mulai_penahanan, 'DD-MM-YYYY') as tgl_mulai_thn, to_char(a.tgl_selesai_penahanan, 'DD-MM-YYYY') as tgl_selesai_thn, b.*,
                to_char(d.tgl_nota, 'DD-MM-YYYY') as tgl_nota
		from pidsus.pds_minta_perpanjang a 
		join pidsus.pds_t4 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang 
                left join pidsus.pds_nota_pendapat_t4 d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
                        and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp and a.no_minta_perpanjang = d.no_minta_perpanjang
		where ".$where." and b.no_minta_perpanjang = '".$id1."' and b.no_t4 = '".$id2."'";
		$model 	= PdsT4::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekT4(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsT4;
			$nilai = $model->cekT4(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsT4;
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
				return $this->redirect(['update', 'id1' => $param['no_minta_perpanjang'], 'id2' => $param['no_t4']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsT4;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1, $id2){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select a.nama, case when a.jenis_penahanan = 1 then 'Rutan' when a.jenis_penahanan = 2 then 'Rumah' when a.jenis_penahanan = 3 then 'Kota' end as jenis_thn, 
		a.lokasi_penahanan as lokasi_thn, to_char(a.tgl_mulai_penahanan, 'DD-MM-YYYY') as tgl_mulai_thn, to_char(a.tgl_selesai_penahanan, 'DD-MM-YYYY') as tgl_selesai_thn, b.*,
                a.tgl_minta_perpanjang, d.nama as penyidik, c.ket_kasus, c.undang_pasal, a.tmpt_lahir, a.tgl_lahir, e.nama as jenis_kelamin,
                f.nama as warganegara, g.nama as agama, h.nama as pendidikan, a.alamat, a.pekerjaan
		from pidsus.pds_minta_perpanjang a 
		join pidsus.pds_t4 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang 
                join pidsus.pds_spdp c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
                        and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp
                join pidsus.ms_inst_penyidik d on c.id_asalsurat=d.kode_ip
                join public.ms_jkl e on a.id_jkl=e.id_jkl
                join public.ms_warganegara f on a.warganegara = f.id
                join public.ms_agama g on a.id_agama=g.id_agama
                join public.ms_pendidikan h on a.id_pendidikan=h.id_pendidikan
		where ".$where." and b.no_minta_perpanjang = '".$id1."' and b.no_t4 = '".$id2."'";
	$model 	= PdsT4::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }

}
    
