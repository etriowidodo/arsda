<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPengembalianBerkas;

class PdsPengembalianBerkasController extends Controller{
    public function actionIndex(){
        $_SESSION['no_spdp'] 	= "";
        $_SESSION['tgl_spdp'] 	= "";
        $_SESSION['no_berkas'] 	= "";
		$_SESSION['pidsus_no_p8_umum'] = "";
        $searchModel = new PdsPengembalianBerkas;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new PdsPengembalianBerkas;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetberkas(){
        if (Yii::$app->request->isAjax){
        	$searchModel = new PdsPengembalianBerkas;
			$dataProvider = $searchModel->getBerkas(Yii::$app->request->get());
			return $this->renderAjax('_getBerkas', ['dataProvider' => $dataProvider]);
        }
    }

    public function actionUpdate($id1, $id2, $id3){
        $_SESSION['no_spdp'] = rawurldecode($id1);
        $_SESSION['tgl_spdp'] = rawurldecode($id2);
        $_SESSION['no_berkas'] = rawurldecode($id3);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."' and a.no_berkas = '".$_SESSION['no_berkas']."'";
		$sqlnya = "
		select a.*, to_char(b.tgl_berkas, 'DD-MM-YYYY') as tgl_berkas 
		from pidsus.pds_pengembalian_berkas a 
		join pidsus.pds_terima_berkas b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas 
		where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."' and a.no_berkas = '".$_SESSION['no_berkas']."'"; 
		$model 	= PdsPengembalianBerkas::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekpengembalianberkas(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPengembalianBerkas;
			$nilai = $model->cekPengembalianBerkas(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}
	
     public function actionSimpan(){
		$model 	= new PdsPengembalianBerkas;
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
				return $this->redirect(['update', 'id1' => rawurlencode($param['no_spdp']), 'id2'=>rawurlencode($param['tgl_spdp']), 'id3'=>rawurlencode($param['no_berkas'])]);
			}
		}
    }
  
    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPengembalianBerkas;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
    
    public function actionCetak($id1, $id2, $id3){
        $no_spdp = rawurldecode($id1);
        $tgl_spdp = rawurldecode($id2);
        $no_berkas = rawurldecode($id3);
		$sqlnya = "
		select a.*, to_char(b.tgl_berkas, 'DD-MM-YYYY') as tgl_berkas, c.no_surat as no_p21a, c.tgl_dikeluarkan as tgl_p21a 
		from pidsus.pds_pengembalian_berkas a 
		join pidsus.pds_terima_berkas b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_berkas = b.no_berkas
                left join pidsus.pds_p21a c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
			and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp and a.no_berkas = c.no_berkas
		where a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and a.no_spdp = '".$no_spdp."' and a.tgl_spdp = '".$tgl_spdp."' and a.no_berkas = '".$no_berkas."'"; 
                $model 	= PdsPengembalianBerkas::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }
}
    
