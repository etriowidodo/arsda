<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP14Umum;

class PdsP14UmumController extends Controller{
    public function actionIndex(){
        unset($_SESSION['pidsus_no_p14_umum']);
        $searchModel = new PdsP14Umum;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionCreate(){
        $model  = new PdsP14Umum;	
		return $this->render('create', ['model'=>$model]);
    }

    public function actionGetpidsus7umum(){
        if (Yii::$app->request->isAjax){
                $searchModel = new PdsP14Umum;
                $dataProvider = $searchModel->searchPidsus7Umum(Yii::$app->request->get());
                return $this->renderAjax('_getpidsus7umum', ['dataProvider' => $dataProvider]);
        }
    }
    
    public function actionCekpdsp14umum(){
        if (Yii::$app->request->isAjax) {
                $model = new PdsP14Umum;
                $nilai = $model->cekPdsP14Umum(Yii::$app->request->post());
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

    public function actionUpdate($id1){
        $idnya 	= rawurldecode($id1);
        $no_p14_umum = rawurldecode($id1);
	$_SESSION['pidsus_no_p14_umum'] = $no_p14_umum;
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_p8_umum = '".$_SESSION['pidsus_no_p8_umum']."'";
		$sqlnya = "
		select a.*, b.tgl_pidsus7
		from pidsus.pds_p14_umum a 
		left join pidsus.pds_pidsus7_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
			and a.no_p8_umum = b.no_p8_umum and a.no_pidsus7_umum = b.no_pidsus7_umum
		where ".$where." and a.no_p14_umum = '".$idnya."'";
		$model 	= PdsP14Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

	public function actionSimpan(){
        $model 	= new PdsP14Umum;
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
				return $this->redirect(['update', 'id1' => $param['no_ba2_umum']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsP14Umum;
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
        select a.*, b.tgl_pidsus7, c.laporan_pidana
        from pidsus.pds_p14_umum a 
        left join pidsus.pds_pidsus7_umum b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                and a.no_p8_umum = b.no_p8_umum and a.no_pidsus7_umum = b.no_pidsus7_umum
        left join pidsus.pds_p8_umum c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
                and a.no_p8_umum = c.no_p8_umum
        where ".$where." and a.no_p14_umum = '".$idnya."'";
        $model 	= PdsP14Umum::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }
}
