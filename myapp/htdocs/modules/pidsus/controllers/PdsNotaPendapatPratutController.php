<?php

namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\PdsNotaPendapatPratut;

class PdsNotaPendapatPratutController extends Controller{
    public function actionIndex(){
        $searchModel = new PdsNotaPendapatPratut;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }
    
    public function actionGetjp(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsNotaPendapatPratut;
            $dataProvider = $searchModel->getJaksap16(Yii::$app->request->get());
            return $this->renderAjax('_tambah_jp', ['dataProvider' => $dataProvider]);
        }
    }

    public function actionCreate(){
	$model 	= new PdsNotaPendapatPratut;
	return $this->render('create', ['model'=>$model]);
    }

    public function actionUpdate($id){
        $idnya 	= rawurldecode($id);
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
        $sqlnya = "
                select a.*,b.tgl_minta_perpanjang
                from pidsus.pds_nota_pendapat_t4 a
                left join pidsus.pds_minta_perpanjang b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
				and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang=b.no_minta_perpanjang
                where ".$where." and a.no_minta_perpanjang = '".$idnya."'";
        $model 	= PdsNotaPendapatPratut::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }
    

	public function actionSimpan(){
        $model 	= new PdsNotaPendapatPratut;
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
			$model = new PdsNotaPendapatPratut;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
    
    public function actionCetak($id){
        $idnya 	= rawurldecode($id);
        $where 	= "a.id_kejati = '".$_SESSION['kode_kejati']."' and a.id_kejari = '".$_SESSION['kode_kejari']."' and a.id_cabjari = '".$_SESSION['kode_cabjari']."' 
                           and a.no_spdp = '".$_SESSION['no_spdp']."' and a.tgl_spdp = '".$_SESSION['tgl_spdp']."'";
        $sqlnya = "
                select a.*,d.nama as penyidik, b.nama as tersangka,c.undang_pasal,b.tgl_minta_perpanjang
                from pidsus.pds_nota_pendapat_t4 a 
                left join pidsus.pds_minta_perpanjang b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang=b.no_minta_perpanjang
                left join pidsus.pds_spdp c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
                        and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp
                join pidsus.ms_inst_penyidik d on c.id_asalsurat=d.kode_ip
                where ".$where." and a.no_minta_perpanjang = '".$idnya."'";
        $model 	= PdsNotaPendapatPratut::findBySql($sqlnya)->asArray()->one();
        return $this->render('cetak', ['model'=>$model]);
    }
    
    public function actionCekmintaperpanjangan(){
        if (Yii::$app->request->isAjax) {
                $model = new PdsNotaPendapatPratut;
                $nilai = $model->cekMintaPerpanjangan(Yii::$app->request->post());
                \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
                return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
        }    
    }
    
    public function actionGettglmintaperpanjang(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new PdsNotaPendapatPratut;
            $nilai = $searchModel->searchTglmintaperpanjang(Yii::$app->request->post());
            \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return $nilai;		
        }
    }

}
    
