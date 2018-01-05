<?php

namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Penandatangan;
use app\modules\datun\models\Penandatanganjabatan;

class PenandatanganController extends Controller{

	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all AuthItem models.
     * @return mixed
     */
    public function actionIndex(){
        $searchModel = new Penandatangan;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->get());
        return $this->render('index', [
			'dataProvider' => $dataProvider,
        ]);
	}

    public function actionCreate(){
		$model = new Penandatangan;
		return $this->render('create', ['model' => $model]);
    }

    public function actionCekrole(){
		if (Yii::$app->request->isAjax) {
			$model = new Penandatangan;
			$hasil = $model->cekRole(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new Penandatangan;
		$sukses = $model->simpanData(Yii::$app->request->post());
        if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
			return $this->redirect(['index']);
        } else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
            return $this->redirect(['create']);
        }
    }

    public function actionUpdate($id){
		$kueri = "select * from datun.m_penandatangan where kode = '".$id."'";
		$model = Penandatangan::findBySql($kueri)->asArray()->one();
		return $this->render('create', ['model'=>$model]);
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new Penandatangan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
    }

	/** Tingkat 2 **/

    public function actionViewpejabat($id){
		$dataTtd = Penandatangan::find()->where(['kode'=>$id, 'kode_tk'=>Yii::$app->user->identity->kode_tk])->one();
		$searchModel = new Penandatanganjabatan;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->queryParams);
        return $this->render('_viewPejabat', [
            'dataProvider' => $dataProvider,
			'arrTtd' => $dataTtd,
        ]);
    }
    public function actionCreatepejabat($id){
		$dataTtd = Penandatangan::find()->where(['kode'=>$id, 'kode_tk'=>Yii::$app->user->identity->kode_tk])->one();
        $model = new Penandatanganjabatan;
		return $this->render('_createPejabat', ['model' => $model, 'arrTtd' => $dataTtd]);
    }

    public function actionCekpejabat(){
		if (Yii::$app->request->isAjax) {
			$model = new Penandatanganjabatan;
			$hasil = $model->cekJabatan(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpanpejabat(){
        $model 	= new Penandatanganjabatan;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($param['isNewRecord']){
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['viewpejabat', 'id'=>$param['kode']]);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['createpejabat', 'id'=>$param['kode']]);
			}
		} else{
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['viewpejabat', 'id'=>$param['kode']]);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['updatepejabat', 'id'=>$param['kode'], 'kb'=>$param['kode_kab']]);
			}
		}
    }

    public function actionUpdatepejabat($id, $kb){
		$sqlnya = "select a.*, b.nama, b.jabatan, case when b.pns_jnsjbtfungsi = 0 then b.gol_kd||' '||b.gol_pangkatjaksa else b.gol_kd||' '||b.gol_pangkat2 end as pangkat 
				from datun.m_penandatangan_pejabat a join kepegawaian.kp_pegawai b on a.nip = b.peg_nip_baru 
				where a.kode = '".$id."' and a.nip = '".$kb."' and a.kode_tk = '".Yii::$app->user->identity->kode_tk."'";
		$model 	= Penandatanganjabatan::findBySql($sqlnya)->asArray()->one();
        return $this->render('_createPejabat', ['model' => $model]);
    }
	
    public function actionHapuspejabat(){
		if (Yii::$app->request->isAjax) {
			$model = new Penandatanganjabatan;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

}