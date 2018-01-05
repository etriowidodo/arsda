<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\P17;

class P17Controller extends Controller{

	public function actionIndex(){
		$searchModel = new P17;	
        $sql = "
		select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.tgl_terima, a.undang_pasal, b.no_p17, b.dikeluarkan, b.tgl_dikeluarkan, b.sifat, b.kepada, 
		b.lampiran, b.di_kepada, b.penandatangan_nama, b.penandatangan_nip, b.penandatangan_jabatan_pejabat, b.penandatangan_gol, b.penandatangan_pangkat, 
		b.penandatangan_status_ttd, b.penandatangan_jabatan_ttd, b.file_upload_p17, b.created_user, b.created_nip, b.created_nama, b.created_ip, b.created_date, 
		b.updated_user, b.updated_nip, b.updated_nama, b.updated_ip, b.updated_date, b.no_spdp as id_p17 
		from pidsus.pds_spdp a 
		left join pidsus.pds_p17 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp
		where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
		$model = Yii::$app->db->createCommand($sql)->queryOne();   
        return $this->render('index', ['model'=>$model]);
    }
	
    public function actionCekp17(){
		if (Yii::$app->request->isAjax) {
			$model = new P17;
			$nilai = $model->cekP17(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}
	
     public function actionSimpan(){
		$model 	= new P17;
		$simpan = $model->simpanData(Yii::$app->request->post());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
           	return $this->redirect(['index']);
        }
    }
  
     public function actionHapus(){
		$model 	= new P17;
		$simpan = $model->hapusData(Yii::$app->request->get());
        if($simpan){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil dihapus']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal dihapus']);
           	return $this->redirect(['index']);
        }
    }
  
	public function actionCetak($id){
        $idnya 	= rawurldecode($id);
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
        $sqlnya = "
                select a.*,b.undang_pasal,b.tgl_terima
                from pidsus.pds_p17 a 
                join pidsus.pds_spdp b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp
                where ".$where." and a.no_p17 = '".$idnya."'";
        $model 	= P17::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
	}

}