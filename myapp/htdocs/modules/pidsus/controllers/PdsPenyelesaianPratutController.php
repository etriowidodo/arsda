<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPenyelesaianPratut;

class PdsPenyelesaianPratutController extends Controller{
    public function actionIndex(){
        $searchModel = new PdsPenyelesaianPratut;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
		$sqlnya = "
			with tbl_pengantar as (
				select * from pidsus.pds_terima_berkas_pengantar 
				where(id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, tgl_pengantar) in(
					select id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas, max(tgl_pengantar) as tgl_pengantar
					from pidsus.pds_terima_berkas_pengantar a
					where id_kejati = '".$_SESSION['kode_kejati']."' and id_kejari = '".$_SESSION['kode_kejari']."' and id_cabjari = '".$_SESSION['kode_cabjari']."' 
						and no_spdp = '".$_SESSION['no_spdp']."' and tgl_spdp = '".$_SESSION['tgl_spdp']."' and no_berkas = '".$_SESSION['no_berkas']."'
					group by id_kejati, id_kejari, id_cabjari, no_spdp, tgl_spdp, no_berkas limit 1
				)
			)
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.tgl_berkas, b.tgl_terima as tgl_terima, 
			c.no_berkas as id_penyelesaian_pratut, c.nomor, c.tgl_surat, c.status, c.sikap_jpu, c.file_upload_penyelesaian_pratut    
			from pidsus.pds_terima_berkas a 
			join tbl_pengantar b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
			left join pidsus.pds_penyelesaian_pratut c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
				and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp and a.no_berkas = c.no_berkas 
			where a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."' and a.no_berkas = '".$_SESSION['no_berkas']."'";
		$model 	= PdsPenyelesaianPratut::findBySql($sqlnya)->asArray()->one();
		return $this->render('create', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new PdsPenyelesaianPratut;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
			return $this->redirect(['create']);
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPenyelesaianPratut;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
}
    
