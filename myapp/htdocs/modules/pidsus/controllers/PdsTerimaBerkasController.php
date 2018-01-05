<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsTerimaBerkas;

class PdsTerimaBerkasController extends Controller{
    public function actionIndex(){
        $_SESSION['no_spdp'] 	= "";
        $_SESSION['tgl_spdp'] 	= "";
        $_SESSION['no_berkas'] 	= "";
		$_SESSION['pidsus_no_p8_umum'] = "";
        $searchModel = new PdsTerimaBerkas;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionGetformundang(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsTerimaBerkas;
            $dataProvider = $searchModel->searchUndang(Yii::$app->request->get());
            return $this->renderAjax('_getUndang', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionGetformpasal(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsTerimaBerkas;
            $dataProvider = $searchModel->searchPasal(Yii::$app->request->get());
            return $this->renderAjax('_getPasal', ['dataProvider' => $dataProvider]);
        } 
    }

    public function actionSetpengantar(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsTerimaBerkas;
            $hasil = $model->setPengantar(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
        } 
    }

    public function actionGetpengantar(){
        if (Yii::$app->request->isAjax) {
            $model = new PdsTerimaBerkas;
            $hasil = $model->getPengantar(Yii::$app->request->post());
            return $this->renderAjax('_popPengantar', ['modelPnt'=>$hasil[0], 'modelUun'=>$hasil[1], 'modelTsk'=>$hasil[2]]);
        }    
    }
    

    public function actionCreate(){
        $model 	= new PdsTerimaBerkas;
        $model['isNewRecord'] = 1;
		return $this->render('create', ['model'=>$model]);
    }
    
    public function actionPoptersangka(){
        if (Yii::$app->request->isAjax){
            $searchModel = new PdsTerimaBerkas;
            $model = $searchModel->explodeTersangka(Yii::$app->request->post());
            return $this->renderAjax('_popTersangka',['model' => $model]);
        }
    }
    
    public function actionGetwarnegara(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsTerimaBerkas;
            $dataProvider = $searchModel->searchWarga(Yii::$app->request->get());
            return $this->renderAjax('_getWarganegara', ['dataProvider' => $dataProvider]);
        } 
    }
    
    public function actionGetdatatersangka(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsTerimaBerkas;
            $dataProvider = $searchModel->searchTersangka(Yii::$app->request->get());
            return $this->renderAjax('_getDatatersangka', ['dataProvider' => $dataProvider]);
        } 
    }
	
    public function actionUpdate($id1,$id2,$id3){
        $id1 	= rawurldecode($id1);
        $id2 	= rawurldecode($id2);
        $idnya 	= rawurldecode($id3);
        $_SESSION['no_spdp']= $id1;
        $_SESSION['tgl_spdp']= $id2;
        $_SESSION['no_berkas']= $idnya;
		$where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
				   and a.no_spdp = '".$id1."' and a.tgl_spdp = '".$id2."' and d.no_berkas='".$idnya."'";
		$sqlnya = "
		select a.tgl_spdp, a.tgl_terima, a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.tgl_kejadian_perkara, a.tempat_kejadian, b.nama as nama_inst_penyidik, 
		c.nama as nama_inst_pelaksana, d.no_berkas, d.tgl_berkas, d.no_p16, to_char(e.tgl_dikeluarkan, 'DD-MM-YYYY') as tgl_p16 , f.statusnya 
		from pidsus.pds_spdp a 
		join pidsus.ms_inst_penyidik b on a.id_asalsurat = b.kode_ip 
		join pidsus.ms_inst_pelak_penyidikan c on a.id_asalsurat = c.kode_ip and a.id_penyidik = c.kode_ipp 
		join pidsus.pds_terima_berkas d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
			and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp 
		join pidsus.pds_p16 e on d.id_kejati = e.id_kejati and d.id_kejari = e.id_kejari and d.id_cabjari = e.id_cabjari 
			and d.no_spdp = e.no_spdp and d.tgl_spdp = e.tgl_spdp and d.no_p16 = e.no_p16 
                left join pidsus.vw_pds_status_berkas_dikeks f on d.id_kejati = f.id_kejati and d.id_kejari = f.id_kejari and d.id_cabjari = f.id_cabjari and d.no_spdp = f.no_spdp 
			and d.tgl_spdp = f.tgl_spdp and d.no_berkas = f.no_berkas
		where ".$where;
		$model 	= PdsTerimaBerkas::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekberkas(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsTerimaBerkas;
			$nilai = $model->cekBerkas(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new PdsTerimaBerkas;
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
				return $this->redirect(['update', 'id1' => $param['no_berkas']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new PdsTerimaBerkas;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
    
    public function actionGetspdp(){
        if (Yii::$app->request->isAjax){
        	$searchModel = new PdsTerimaBerkas;
                $dataProvider = $searchModel->getSpdp(Yii::$app->request->get());
                return $this->renderAjax('_getSpdp', ['dataProvider' => $dataProvider]);
        }
    }
    
    public function actionGetnop16(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsTerimaBerkas;
            $nilai = $searchModel->searchGetnop16(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $nilai;		
        }    
    }
}
    
