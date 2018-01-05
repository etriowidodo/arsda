<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPidsus14Umum;

class PdsPidsus14UmumController extends Controller{
    public function actionIndex(){
        $searchModel = new PdsPidsus14Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsPidsus14Umum;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetusul(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsPidsus14Umum;
            $model = $searchModel->explodeSaksi(Yii::$app->request->post());
            return $this->renderAjax('_tambah_usul',['model' => $model]);
        }
    }

    public function actionUpdate($id1){
        $idnya 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum 
		from pidsus.pds_pidsus14_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum
		where ".$where." and a.no_urut_pidsus14_umum = '".$idnya."'";
		$model 	= PdsPidsus14Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new PdsPidsus14Umum;
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
				return $this->redirect(['update', 'id1' => $param['no_urut_pidsus14_umum']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus14Umum;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1){
        $idnya 	= rawurldecode($id1);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_p8_umum, b.laporan_pidana, b.tindak_pidana
		from pidsus.pds_pidsus14_umum a 
		join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari and a.no_p8_umum = b.no_p8_umum
                where ".$where." and a.no_urut_pidsus14_umum = '".$idnya."'";
		$model 	= PdsPidsus14Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }
}
