<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsCeklistTahap1;

class PdsCeklistTahap1Controller extends Controller{
    public function actionIndex(){
        $searchModel = new PdsCeklistTahap1;
        $dataProvider = $searchModel->searchPer();
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetpengantar(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsCeklistTahap1;
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
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.no_pengantar, c.no_pengantar as id_ceklist,
			b.tgl_pengantar, c.tgl_mulai, c.tgl_selesai, c.nip_ttd, c.nama_ttd, c.gol_ttd, c.pangkat_ttd, jabatan_ttd, c.file_upload_ceklist, c.pendapat_jaksa, 
			c.pendapat_jaksa_tdk_lngkp, c.pendapat_jaksa_tdk_lngkp_alsn 
			from pidsus.pds_terima_berkas a 
			join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			left join pidsus.pds_ceklist_tahap1 c on b.id_kejati = c.id_kejati and b.id_kejari = c.id_kejari and b.id_cabjari = c.id_cabjari 
				and b.no_spdp = c.no_spdp and b.tgl_spdp = c.tgl_spdp and b.no_berkas = c.no_berkas and b.no_pengantar = c.no_pengantar
			where ".$where." and a.no_berkas = '".$id1."' and b.no_pengantar = '".$id2."'";
		$model 	= PdsCeklistTahap1::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }
    
	public function actionSimpan(){
        $model 	= new PdsCeklistTahap1;
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
    
    public function actionCetak($id1){
        $id1 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
		select a.*,b.tgl_pengantar, c.tgl_berkas
                from pidsus.pds_ceklist_tahap1 a
                left join pidsus.pds_terima_berkas_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas and a.no_pengantar=b.no_pengantar
                left join pidsus.pds_terima_berkas c on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
		where ".$where." and a.no_pengantar = '".$id1."'";
	$model 	= PdsCeklistTahap1::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }

}
    
