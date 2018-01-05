<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\BaKonsultasi;

class BaKonsultasiController extends Controller{
    public function actionIndex(){
        $searchModel = new BaKonsultasi;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
        $sqlnya = "select COALESCE(max(id_ba_konsultasi)+1,1) as id_ba_konsultasi
                    from pidsus.pds_ba_konsultasi a where ".$where;
	$model 	= BaKonsultasi::findBySql($sqlnya)->asArray()->one();
        $model['isNewRecord']=1;
	return $this->render('create', ['model'=>$model]);
    }
	
    public function actionUpdate($id){
        $idnya 	= rawurldecode($id);
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
		$sqlnya = "
			select a.*
			from pidsus.pds_ba_konsultasi a 
			where ".$where." and a.id_ba_konsultasi = '".$idnya."'";
		$model 	= BaKonsultasi::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }
    

	public function actionSimpan(){
        $model 	= new BaKonsultasi;
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
			$model = new BaKonsultasi;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($nop16){
        $idnya 	= rawurldecode($nop16);
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
        $sqlnya = "
                select a.*,b.undang_pasal,c.nama as asal_penyidik
                from pidsus.pds_p16 a 
                join pidsus.pds_spdp b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp
                join pidsus.ms_inst_penyidik c on b.id_asalsurat=c.kode_ip
                where ".$where." and a.no_p16 = '".$idnya."'";
        $model 	= BaKonsultasi::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }
    
    public function actionCekba(){
        if (Yii::$app->request->isAjax) {
                $model = new BaKonsultasi;
                $nilai = $model->cekBa(Yii::$app->request->post());
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }   

}
    
