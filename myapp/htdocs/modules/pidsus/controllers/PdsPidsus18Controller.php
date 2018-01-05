<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsPidsus18;

class PdsPidsus18Controller extends Controller{
    public function actionIndex(){
		$_SESSION['no_spdp'] 	= "";
		$_SESSION['tgl_spdp'] 	= "";
		$_SESSION['no_berkas'] 	= "";
		$_SESSION['pidsus_no_p8_umum'] = "";
		$_SESSION['pidsus_no_pidsus18'] = "";
		$_SESSION['pidsus_no_p8_khusus'] = "";
        $searchModel = new PdsPidsus18;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetp8(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsPidsus18;
            $dataProvider = $searchModel->searchP8(Yii::$app->request->get());
            return $this->renderAjax('_getp8', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionGetformundang(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsPidsus18;
            $dataProvider = $searchModel->searchUndang(Yii::$app->request->get());
            return $this->renderAjax('_getUndang', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionGetformpasal(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsPidsus18;
            $dataProvider = $searchModel->searchPasal(Yii::$app->request->get());
            return $this->renderAjax('_getPasal', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionPoptersangka(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsPidsus18;
            $model = $searchModel->explodeTersangka(Yii::$app->request->post());
            return $this->renderAjax('_popTersangka',['model' => $model]);
        }
    }
    
    public function actionGettsk(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsPidsus18;
            $hasil = $model->getTersangka(Yii::$app->request->post());
            return $this->renderAjax('_popTersangka', ['model'=>$hasil]);
        }
    }
        
    public function actionSettsk(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsPidsus18;
            $hasil = $model->setTersangka(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$hasil];
        } 
    }

    public function actionCreate(){
        $model  = new PdsPidsus18;	
	return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($id1, $id2){
        $no_pidsus18 	= rawurldecode($id1);
        $no_p8_umum 	= rawurldecode($id2);
		$_SESSION['pidsus_no_p8_umum'] = $no_p8_umum;
		$_SESSION['pidsus_no_pidsus18'] = $no_pidsus18;
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_p8_umum = '".$no_p8_umum."' and a.no_pidsus18 = '".$no_pidsus18."'";
        $sqlnya = "
                select a.*
                from pidsus.pds_pidsus18 a 
                where ".$where;
        $model 	= PdsPidsus18::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekpidsus18(){
        if (Yii::$app->request->isAjax) {
                $model = new PdsPidsus18;
                $nilai = $model->cekPidsus18(Yii::$app->request->post());
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

	public function actionSimpan(){
        $model 	= new PdsPidsus18;
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
				return $this->redirect(['update', 'nop16' => $param['no_p16']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsPidsus18;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id1, $id2){
        $no_pidsus18 	= rawurldecode($id1);
        $no_p8_umum 	= rawurldecode($id2);
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_p8_umum = '".$no_p8_umum."' and a.no_pidsus18 = '".$no_pidsus18."'";
        $sqlnya = "
                select a.*, b.tgl_p8_umum, b.laporan_pidana, b.tindak_pidana
                from pidsus.pds_pidsus18 a
                left join pidsus.pds_p8_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                and a.no_p8_umum = b.no_p8_umum
                where ".$where;
        $model 	= PdsPidsus18::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }


}
    
