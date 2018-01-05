<?php

namespace app\modules\datun\controllers;

use Yii;
use app\modules\datun\models\MsWilayahSearch;
use app\modules\datun\models\MsWilayahkabSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WilayahController implements the CRUD actions for MsWilayah model.
 */
class WilayahController extends Controller
{
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
     * Lists all MsWilayah models.
     * @return mixed
     */
    public function actionIndex(){
        $searchModel = new MsWilayahSearch();
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate(){
        $model = new MsWilayahSearch;
		return $this->render('create', ['model' => $model]);
    }

    public function actionCekwilayah(){
		if (Yii::$app->request->isAjax) {
			$model = new MsWilayahSearch;
			$hasil = $model->cekWilayah(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new MsWilayahSearch;
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
				return $this->redirect(['update', 'id' => $param['idr']]);
			}
		}
    }

    public function actionUpdate($id){
		$model 	= MsWilayahSearch::findBySql("select * from datun.m_propinsi where id_prop = '".$id."'")->asArray()->one();
        return $this->render('create', ['model' => $model]);
    }

    public function actionHapusdata(){
		if (Yii::$app->request->isAjax) {
			$model = new MsWilayahSearch;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	

    public function actionViewkab($id){
        $dataProp = MsWilayahSearch::find()->where(['id_prop' => $id])->one();
		$searchModel = new MsWilayahkabSearch;
        $dataProvider = $searchModel->searchCustom(Yii::$app->request->queryParams);
        return $this->render('_viewKab', [
            'dataProvider' => $dataProvider,
			'arrProp' => $dataProp,
        ]);
    }
    public function actionCreatekab($id){
        $dataProp = MsWilayahSearch::find()->where(['id_prop' => $id])->one();
        $model = new MsWilayahkabSearch;
		return $this->render('createKab', ['model' => $model, 'arrProp' => $dataProp]);
    }

    public function actionCekkabupaten(){
		if (Yii::$app->request->isAjax) {
			$model = new MsWilayahkabSearch;
			$hasil = $model->cekKabupaten(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpankab(){
        $model 	= new MsWilayahkabSearch;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($param['isNewRecord']){
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil disimpan']);
				return $this->redirect(['viewkab', 'id'=>$param['kode']]);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal disimpan']);
				return $this->redirect(['createkab', 'id'=>$param['kode']]);
			}
		} else{
			if($sukses){
				Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Data berhasil diubah']);
				return $this->redirect(['viewkab', 'id'=>$param['kode']]);
			} else{
				Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, data gagal diubah']);
				return $this->redirect(['updatekab', 'id'=>$param['kode'], 'kb'=>$param['kode_kab']]);
			}
		}
    }

    public function actionUpdatekab($id, $kb){
		$sqlnya = "select a.*, b.id_prop||' | '||b.deskripsi as proptxt from datun.m_kabupaten a join datun.m_propinsi b on a.id_prop = b.id_prop 
				where a.id_prop = '".$id."' and a.id_kabupaten_kota = '".$kb."'";
		$model 	= MsWilayahkabSearch::findBySql($sqlnya)->asArray()->one();
        return $this->render('createkab', ['model' => $model]);
    }
	
    public function actionHapuskab(){
		if (Yii::$app->request->isAjax) {
			$model = new MsWilayahkabSearch;
			$hasil = $model->hapusData(Yii::$app->request->post());
			$hasil = ($hasil)?true:false;
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}
    }	
}
