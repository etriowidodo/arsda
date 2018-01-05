<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Permohonan;

class PermohonanController extends Controller{
    public function actionIndex(){
		$_SESSION['no_register_perkara'] = '';
		$_SESSION['no_surat'] 			 = '';
		$_SESSION['no_register_skk'] 	 = '';
		$_SESSION['tanggal_skk'] 		 = '';
		//$_SESSION['no_skks']			 = '' ;
		$_SESSION['bantuan_hukum'] 	 	 = '';
        $searchModel = new Permohonan;
        $dataProvider = $searchModel->searchPer(Yii::$app->request->get());
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionCreate(){
        $model  = new Permohonan;	
		return $this->render('create', ['model'=>$model]);
    }

    public function actionGetisnta(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new Permohonan;
			$dataProvider = $searchModel->searchInta(Yii::$app->request->get());
			return $this->renderAjax('_getInsta', ['dataProvider' => $dataProvider]);
		}    
	}
	
    public function actionGetwil(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new Permohonan;
			$dataProvider = $searchModel->searchWil(Yii::$app->request->get());
			return $this->renderAjax('_getWil', ['dataProvider' => $dataProvider]);
		}    
	}
	
    public function actionGetpeng(){
		if (Yii::$app->request->isAjax) {
        	$searchModel = new Permohonan;
			$dataProvider = $searchModel->searchPeng(Yii::$app->request->get());
			return $this->renderAjax('_getPeng', ['dataProvider' => $dataProvider]);
		}    
	}
	
    public function actionUpdate($id, $ns){
        $id = rawurldecode($id); 
        $ns = rawurldecode($ns);
        $_SESSION['no_register_perkara'] = $id;
        $_SESSION['no_surat'] 			 = $ns;
		
		$sqlnya = "
			select a.*, b.deskripsi_jnsinstansi, c.deskripsi_instansi, d.deskripsi_inst_wilayah, d.alamat as alamat_instansi, d.no_tlp as telp_instansi, e.nama_pengadilan
			from datun.permohonan a 
			join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
			join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi
			join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
				and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut
			join datun.master_pengadilan e on a.kode_pengadilan_tk1 = e.kode_pengadilan_tk1 and a.kode_pengadilan_tk2 = e.kode_pengadilan_tk2
			where a.no_register_perkara = '".$id."' and a.no_surat = '".$ns."'";
		$model 	= Permohonan::findBySql($sqlnya)->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionCekpermohonan(){
		if (Yii::$app->request->isAjax) {
			$model = new Permohonan;
			$nilai = $model->cekPermohonan(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$nilai['hasil'], 'error'=>$nilai['error'], 'element'=>$nilai['element']];
		}    
	}

	public function actionSimpan(){
        $model 	= new Permohonan;
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
				return $this->redirect(['update', 'id' => $param['no_reg_perkara'], 'ns'=>$param['no_surat']]);
			}
		}
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Permohonan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
	
	/* START CRUD MODAL INSTANSI */
	public function actionGetformins(){
		$get = Yii::$app->request->get();
		$tq1 = htmlspecialchars($get['id'], ENT_QUOTES);
		$tq2 = htmlspecialchars($get['idins'], ENT_QUOTES);		
		if($tq1 && !$tq2){
			$model = array();
			$model['isNewRecord'] = 1; 
			$model['kode_jenis_instansi'] = $tq1;
		} else if($tq1 && $tq2){
			$sql = "select * from datun.instansi where kode_jenis_instansi = '".$tq1."' and kode_instansi = '".$tq2."' and kode_tk = '".$_SESSION["kode_tk"]."'";
			$model 	= Permohonan::findBySql($sql)->asArray()->one();
		}
        return $this->renderAjax('form_instansi', ['model' => $model]);
	}

	public function actionInstansi(){
		$model 	= new Permohonan;
		$result = $model->simpanDataFinstansi(Yii::$app->request->post());
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['hasil'=>$result['hasil'], 'error'=>$result['error']];
    }

    public function actionHapusinstansi(){
		if (Yii::$app->request->isAjax) {
			$model = new Permohonan;
			$hasil = $model->hapusIns(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
	/* END CRUD MODAL INSTANSI */

	
	/* START CRUD MODAL WILAYAH INSTANSI */
	public function actionGetformwilins(){
		$get = Yii::$app->request->get();
		$tq1 = htmlspecialchars($get['id'], ENT_QUOTES);
		$tq2 = htmlspecialchars($get['idins'], ENT_QUOTES);
		$tq3 = htmlspecialchars($get['tq3'], ENT_QUOTES);
		$tq4 = htmlspecialchars($get['tq4'], ENT_QUOTES);
		$tq5 = htmlspecialchars($get['tq5'], ENT_QUOTES);
		if($tq1 && $tq2 && !$tq3){
			$model = array();
			$model['isNewRecord'] = 1; 
			$model['kode_jenis_instansi'] = $tq1;
			$model['kode_instansi'] = $tq2;
		} else if($tq1 && $tq2 && $tq3){
			$sql = "select a.*, b.deskripsi as propinsi, c.deskripsi_kabupaten_kota as kabupaten 
					from datun.instansi_wilayah a 
					join datun.m_propinsi b on a.kode_provinsi = b.id_prop 
					join datun.m_kabupaten c on a.kode_provinsi = c.id_prop and a.kode_kabupaten = c.id_kabupaten_kota 
					where kode_jenis_instansi = '".$tq1."' and kode_instansi = '".$tq2."' and kode_provinsi = '".$tq3."' and kode_kabupaten = '".$tq4."' 
						and kode_tk = '".$_SESSION['kode_tk']."' and no_urut = '".$tq5."'";
			$model 	= Permohonan::findBySql($sql)->asArray()->one();
		}
        return $this->renderAjax('form_wilinstansi', ['model' => $model]);
	}

	public function actionWilinstansi(){
		$model 	= new Permohonan;
		$result = $model->simpanDataFwilinstansi(Yii::$app->request->post());
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['hasil'=>$result['hasil'], 'error'=>$result['error']];
    }		

    public function actionHapuswilinstansi(){
		if (Yii::$app->request->isAjax) {
			$model = new Permohonan;
			$hasil = $model->hapusWilIns(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

    public function actionGetkabupaten(){
		if (Yii::$app->request->isAjax) {
			$model = new Permohonan;
			$hasil = $model->getKabupaten(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return $hasil;
		}    
	}	
	/* END CRUD MODAL WILAYAH INSTANSI */
		
	/* START CRUD MODAL PENGADILAN */
	public function actionGetformpengadilan(){
		$get = Yii::$app->request->get();
		$tq1 = htmlspecialchars($get['id'], ENT_QUOTES);
		if(!$tq1){
			$model = array();
			$model['isNewRecord'] = 1; 
		} else{
			$sql = "select * from datun.master_pengadilan where kode_pengadilan = '".$tq1."'";
			$model 	= Permohonan::findBySql($sql)->asArray()->one();
		}
        return $this->renderAjax('form_pengadilan', ['model' => $model]);
	}

	public function actionPengadilan(){
		$model 	= new Permohonan;
		$result = $model->simpanDataPengadilan(Yii::$app->request->post());
		\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		return ['hasil'=>$result['hasil'], 'error'=>$result['error']];
    }		

    public function actionHapuspengadilan(){
		if (Yii::$app->request->isAjax) {
			$model = new Permohonan;
			$hasil = $model->hapusPengadilan(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }
	/* END CRUD MODAL PENGADILAN */

}
    
