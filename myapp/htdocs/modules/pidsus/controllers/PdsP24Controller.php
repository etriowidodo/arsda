<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP24;

class PdsP24Controller extends Controller{
    public function actionIndex(){
        $searchModel = new PdsP24;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetpengantar(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP24;
            $hasil = $model->getPengantar(Yii::$app->request->post());
			return $this->renderAjax('_popPengantar', ['model' => $hasil]);
        }    
    }

    public function actionCreate($id1, $id2){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, a.no_p16, b.no_pengantar, b.tgl_pengantar, 
			d.tgl_dikeluarkan as tgl_p16, e.no_pengantar as id_p24, e.tgl_ba, e.ket_saksi, e.ket_ahli, e.alat_bukti, e.benda_sitaan, e.ket_tersangka, e.fakta_hukum, e.yuridis, 
			e.kesimpulan, e.id_pendapat, e.saran_disetujui, e.saran, e.petunjuk_disetujui, e.petunjuk, e.id_hasil, e.nip_ttd, e.nama_ttd, e.gol_ttd, e.pangkat_ttd, 
			e.jabatan_ttd, e.file_upload_p24    
			from pidsus.pds_terima_berkas a 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			join pidsus.pds_p16 d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
				and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp and a.no_p16 = d.no_p16 
			left join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar
			where ".$where." and a.no_berkas = '".$id1."' and b.no_pengantar = '".$id2."'";
		$model 	= PdsP24::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }
    
	public function actionSimpan(){
        $model 	= new PdsP24;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
			return $this->redirect(['create', 'id1' => rawurlencode($param['no_berkas']), 'id2' => rawurlencode($param['no_pengantar'])]);
		}
    }
    
    public function actionCetak($id1, $id2, $id3){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
        
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, a.no_p16, b.no_pengantar, b.tgl_pengantar, 
			d.tgl_dikeluarkan as tgl_p16, e.no_pengantar as id_p24, e.tgl_ba, e.ket_saksi, e.ket_ahli, e.alat_bukti, e.benda_sitaan, e.ket_tersangka, e.fakta_hukum, e.yuridis, 
			e.kesimpulan, e.id_pendapat, e.saran_disetujui, e.saran, e.petunjuk_disetujui, e.petunjuk, e.id_hasil, e.nip_ttd, e.nama_ttd, e.gol_ttd, e.pangkat_ttd, 
			e.jabatan_ttd, e.file_upload_p24    
			from pidsus.pds_terima_berkas a 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			join pidsus.pds_p16 d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
				and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp and a.no_p16 = d.no_p16 
			left join pidsus.pds_p24 e on b.id_kejati = e.id_kejati and b.id_kejari = e.id_kejari and b.id_cabjari = e.id_cabjari 
				and b.no_spdp = e.no_spdp and b.tgl_spdp = e.tgl_spdp and b.no_berkas = e.no_berkas and b.no_pengantar = e.no_pengantar
			where ".$where." and a.no_berkas = '".$id1."' and b.no_pengantar = '".$id2."'";
        $model 	= PdsP24::findBySql($sqlnya)->asArray()->one();
        $model['isDraft']=rawurldecode($id3);
        return $this->render('cetak', ['model'=>$model]);
    }

}
    
