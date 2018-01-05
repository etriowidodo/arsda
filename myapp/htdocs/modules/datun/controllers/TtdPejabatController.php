<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\TtdPejabat;

class TtdPejabatController extends Controller{
	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

	public function actionIndex(){
		$searchModel  = new TtdPejabat;
		$dataProvider = $searchModel->search(Yii::$app->request->get());
		return $this->render('index', ['dataProvider' => $dataProvider, 'searchModel'=>$searchModel]);
    }

	public function actionCreate(){
		$model = new TtdPejabat;
		return $this->render('create', ['model'=>$model]);	
	}

    public function actionUpdate($id, $id2, $id3){
        $id1 = rawurldecode($id);
        $id2 = rawurldecode($id2);
        $id3 = rawurldecode($id3);
		$sqlnya = "select a.*, b.nama, b.jabatan, c.deskripsi as jabatan_ttd, 
			case when b.pns_jnsjbtfungsi = 0 then b.gol_kd||' '||b.gol_pangkatjaksa else b.gol_kd||' '||b.gol_pangkat2 end as pangkat 
			from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru
			join datun.m_penandatangan c on a.kode_tk = c.kode_tk and a.kode = c.kode 
			where a.kode = '".$id1."' and a.nip = '".$id2."' and a.kode_tk = '".$id3."'";
		$model 	= TtdPejabat::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekttdpejabat(){
		if (Yii::$app->request->isAjax) {
			$model = new TtdPejabat;
			$hasil = $model->cekTtdPejabat(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new TtdPejabat;
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
				return $this->redirect(['update', 'id' => rawurlencode($param['kode_ttd']), 'id2'=>rawurlencode($param['peg_nip']), 'id3'=>$_SESSION['kode_tk']]);
			}
		}
	}	
	
    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new TtdPejabat;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
	
}