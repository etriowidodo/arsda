<?php 

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsP6;

class PdsP6Controller extends Controller{
    public function actionIndex(){
		unset($_SESSION['pidsus_no_urut_p6'], $_SESSION['pidsus_tgl_p6']);
        $searchModel = new PdsP6;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
		$model  = new PdsP6;	
		return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($no_urut_p6, $tgl_p6){
        $no_urut_p6 = rawurldecode($no_urut_p6);
        $tgl_p6     = rawurldecode($tgl_p6);
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
		$id_cabjari = $_SESSION['kode_cabjari'];
        
		$_SESSION['pidsus_no_urut_p6'] 	= $no_urut_p6;
        $_SESSION['pidsus_tgl_p6'] 		= $tgl_p6;

		$whereDef 	= "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' 
						and no_urut_p6 = '".$no_urut_p6."' and tgl_p6 = '".$tgl_p6."'";
		$sqlnya = "select * from pidsus.pds_p6 where ".$whereDef;
		$model 	= PdsP6::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekp6(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsP6;
            $nilai = $model->cekp6(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }

    public function actionSimpan(){
		$model 	= new PdsP6;
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
				return $this->redirect(['update', 'no_urut_p6' => rawurlencode($_SESSION['pidsus_no_urut_p6']), 'tgl_p6'=>rawurlencode($_SESSION['pidsus_tgl_p6'])]);
			}
		}
    }

    public function actionHapusdata(){
        if (Yii::$app->request->isAjax) {
			$model = new PdsP6;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
        }
    }
    
    public function actionCetak($no_urut_p6,$tgl_p6){
        $no_urut_p6 = rawurldecode($no_urut_p6);
        $tgl_p6     = rawurldecode($tgl_p6);
        $id_kejati  = $_SESSION['kode_kejati'];
        $id_kejari  = $_SESSION['kode_kejari'];
	$id_cabjari = $_SESSION['kode_cabjari'];
		$whereDef = "id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' and no_urut_p6 = '".$no_urut_p6."' and tgl_p6 = '".$tgl_p6."'";
		$sqlnya = "
			select * from pidsus.pds_p6
			where ".$whereDef;
		$model 	= PdsP6::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model' => $model]);
    }

}
    
