<?php 
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPidsus13Khusus;

class PdsPidsus13KhususController extends Controller{
        
    public function actionIndex(){
        
        $sqlnya = "
                Select a.*, b.no_p8_khusus, b.tgl_p8_khusus
                from pidsus.pds_pidsus13_khusus a
                left join pidsus.pds_p8_khusus b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari
                and a.no_pidsus18 = b.no_pidsus18 and a.no_p8_khusus = b.no_p8_khusus
                where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                        and a.no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and a.no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
        $model = Yii::$app->db->createCommand($sqlnya)->queryOne();   				
        return $this->render('create', ['model'=>$model]);
    }
	
    public function actionCekpidsus13khusus(){
        if (Yii::$app->request->isAjax) {
                $model = new PdsPidsus13Khusus;
                $nilai = $model->Cekpidsus13khusus(Yii::$app->request->post());
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

     public function actionSimpan(){
		$model 	= new PdsPidsus13Khusus;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
        if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
           	return $this->redirect(['index']);
        }
    }

    public function actionHapusdata($id1, $id2, $id3){
		$model = new PdsPidsus13Khusus;
		$hasil = $model->hapusData($id1, $id2, $id3);
		$hasil = ($hasil)?true:false;
        if($hasil){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil dihapus']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal dihapus']);
           	return $this->redirect(['index']);
        }
    }
    
    public function actionCetak(){
        $sqlnya = "
			select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_p8_umum, a.tgl_p8_umum, b.no_p8_umum as id_p13_umum, 
			b.no_pidsus13_umum, b.tgl_pidsus13_umum, b.sifat, b.lampiran, 
			b.penandatangan_nama, b.penandatangan_nip, b.penandatangan_jabatan_pejabat, b.penandatangan_gol, b.penandatangan_pangkat, 
			b.penandatangan_status_ttd, b.penandatangan_jabatan_ttd, b.file_upload, a.laporan_pidana, a.tindak_pidana
			from pidsus.pds_p8_umum a 
			left join pidsus.pds_pidsus13_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_p8_umum = b.no_p8_umum 
			where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
				and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
		$model = Yii::$app->db->createCommand($sqlnya)->queryOne();   				
        return $this->render('cetak', ['model'=>$model]);
    }

}
    
