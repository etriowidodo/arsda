<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP19;

class PdsP19Controller extends Controller{
    public function actionIndex(){
        unset($_SESSION['no_surat']);
        $searchModel = new PdsP19;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new PdsP19;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionCekp19(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsP19;
			$nilai = $model->cekP19(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

    public function actionUpdate($id1, $id2){
		$id_kejati	= $_SESSION['kode_kejati'];
		$id_kejari	= $_SESSION['kode_kejari'];
		$id_cabjari	= $_SESSION['kode_cabjari'];
		$no_spdp	= $_SESSION['no_spdp'];
		$tgl_spdp	= $_SESSION['tgl_spdp'];
		$id1 = rawurldecode($id1);
                $id2 = rawurldecode($id2);
                $_SESSION['no_surat']=$id2;
		$sqlnya = "
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.tgl_terima as tgl_terima, f.no_surat as no_p18, 
			f.tgl_dikeluarkan as tgl_p18, h.nama as instansi_penyidik, i.no_surat, i.sifat, i.lampiran, i.tgl_dikeluarkan, i.dikeluarkan, i.kepada, i.di_kepada, 
			i.penandatangan_nama, i.penandatangan_nip, i.penandatangan_jabatan_pejabat, i.penandatangan_gol, i.penandatangan_pangkat, i.penandatangan_status_ttd, 
			i.penandatangan_jabatan_ttd, i.file_upload_p19, i.petunjuk, i.no_pengantar 
			from pidsus.pds_terima_berkas a
			join pidsus.pds_spdp g on a.id_kejati = g.id_kejati and a.id_kejari = g.id_kejari and a.id_cabjari = g.id_cabjari 
				and a.no_spdp = g.no_spdp and a.tgl_spdp = g.tgl_spdp 
			join pidsus.ms_inst_penyidik h on g.id_asalsurat = h.kode_ip 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
				and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
			join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 2 
			join pidsus.pds_p18 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
				and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
			join pidsus.pds_p19 i on f.id_kejati = i.id_kejati and f.id_kejari = i.id_kejari and f.id_cabjari = i.id_cabjari 
				and f.no_spdp = i.no_spdp and f.tgl_spdp = i.tgl_spdp and f.no_berkas = i.no_berkas and f.no_pengantar = i.no_pengantar 
			where i.id_kejati = '".$id_kejati."' and i.id_kejari = '".$id_kejari."' and i.id_cabjari = '".$id_cabjari."' and i.no_spdp = '".$no_spdp."' 
				and i.tgl_spdp = '".$tgl_spdp."' and i.no_berkas = '".$id1."' and i.no_surat = '".$id2."'";
		$model 	= PdsP19::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new PdsP19;
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
				return $this->redirect(['update', 'id1' => $param['no_surat']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsP19;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
    
    public function actionCetak($id1, $id2){
        $id_kejati	= $_SESSION['kode_kejati'];
        $id_kejari	= $_SESSION['kode_kejari'];
        $id_cabjari	= $_SESSION['kode_cabjari'];
        $no_spdp	= $_SESSION['no_spdp'];
        $tgl_spdp	= $_SESSION['tgl_spdp'];
        $id1 = rawurldecode($id1);
        $id2 = rawurldecode($id2);
        $sqlnya = "
                select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.tgl_terima as tgl_terima, f.no_surat as no_p18, 
                f.tgl_dikeluarkan as tgl_p18, h.nama as instansi_penyidik, i.no_surat, i.sifat, i.lampiran, i.tgl_dikeluarkan, i.dikeluarkan, i.kepada, i.di_kepada, 
                i.penandatangan_nama, i.penandatangan_nip, i.penandatangan_jabatan_pejabat, i.penandatangan_gol, i.penandatangan_pangkat, i.penandatangan_status_ttd, 
                i.penandatangan_jabatan_ttd, i.file_upload_p19, i.petunjuk, i.no_pengantar, g.undang_pasal 
                from pidsus.pds_terima_berkas a
                join pidsus.pds_spdp g on a.id_kejati = g.id_kejati and a.id_kejari = g.id_kejari and a.id_cabjari = g.id_cabjari 
                        and a.no_spdp = g.no_spdp and a.tgl_spdp = g.tgl_spdp 
                join pidsus.ms_inst_penyidik h on g.id_asalsurat = h.kode_ip 
                join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
                join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
                        and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
                join pidsus.pds_ceklist_tahap1 d on b.id_kejati = d.id_kejati and b.id_kejari = d.id_kejari and b.id_cabjari = d.id_cabjari 
                        and b.no_spdp = d.no_spdp and b.tgl_spdp = d.tgl_spdp and b.no_berkas = d.no_berkas and b.no_pengantar = d.no_pengantar 
                join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
                        and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar and e.id_hasil = 2 
                join pidsus.pds_p18 f on e.id_kejati = f.id_kejati and e.id_kejari = f.id_kejari and e.id_cabjari = f.id_cabjari 
                        and e.no_spdp = f.no_spdp and e.tgl_spdp = f.tgl_spdp and e.no_berkas = f.no_berkas and e.no_pengantar = f.no_pengantar 
                join pidsus.pds_p19 i on f.id_kejati = i.id_kejati and f.id_kejari = i.id_kejari and f.id_cabjari = i.id_cabjari 
                        and f.no_spdp = i.no_spdp and f.tgl_spdp = i.tgl_spdp and f.no_berkas = i.no_berkas and f.no_pengantar = i.no_pengantar 
                where i.id_kejati = '".$id_kejati."' and i.id_kejari = '".$id_kejari."' and i.id_cabjari = '".$id_cabjari."' and i.no_spdp = '".$no_spdp."' 
                        and i.tgl_spdp = '".$tgl_spdp."' and i.no_berkas = '".$id1."' and i.no_surat = '".$id2."'";
	$model 	= PdsP19::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }
}
    
