<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\Spdp;

class SpdpController extends Controller{
    public function actionIndex(){
        $_SESSION['no_spdp'] 	= "";
        $_SESSION['tgl_spdp'] 	= "";
        $_SESSION['no_berkas'] 	= "";
	$_SESSION['pidsus_no_p8_umum'] = "";
        $_SESSION['pidsus_no_pidsus18'] = "";
        $searchModel = new Spdp;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new Spdp;
        return $this->render('create', ['model'=>$model]);
    }
	
    public function actionGetinstansiplkpydk(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new Spdp;
            $nilai = $searchModel->searchInstansiplkpydk(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $nilai;		
        }    
    }
    
    public function actionPoptersangka(){
        if (Yii::$app->request->isAjax){
            $searchModel = new Spdp;
            $model = $searchModel->explodeTersangka(Yii::$app->request->post());
            return $this->renderAjax('_popTersangka',['model' => $model]);
        }
    }
    
    public function actionGetwarnegara(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new Spdp;
            $dataProvider = $searchModel->searchWarga(Yii::$app->request->get());
            return $this->renderAjax('_getWarganegara', ['dataProvider' => $dataProvider]);
        } 
    }
	
    public function actionUpdate($no_spdp, $tgl_spdp){
		$no_spdp  			= rawurldecode($no_spdp);
		$tgl_spdp 			= rawurldecode($tgl_spdp);
        $_SESSION['no_spdp']  = $no_spdp;
        $_SESSION['tgl_spdp'] = $tgl_spdp;
		
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$no_spdp."' and a.tgl_spdp = '".$tgl_spdp."'";
		$sqlnya = "
			select a.*,i.statusnya 
			from pidsus.pds_spdp a 
                        left join pidsus.vw_pds_status_spdp_dikeks i on a.id_kejati = i.id_kejati and a.id_kejari = i.id_kejari and a.id_cabjari = i.id_cabjari and a.no_spdp = i.no_spdp 
			and a.tgl_spdp = i.tgl_spdp
			where ".$where;
		$model 	= Spdp::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekspdp(){
		if (Yii::$app->request->isAjax) {
			$model = new Spdp;
			$nilai = $model->cekSpdp(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
		$model 	= new Spdp;
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
				return $this->redirect(['update', 'id' => rawurlencode($param['no_spdp']), 'ns'=>rawurlencode($param['tgl_spdp'])]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Spdp;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
	
}
    
