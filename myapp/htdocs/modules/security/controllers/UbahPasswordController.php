<?php

namespace app\modules\security\controllers;

use app\modules\security\models\UbahPassword;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use Yii;

class UbahPasswordController extends Controller{

	public function beforeAction($action){
		Yii::$app->log->targets[0]->enabled = false;
        return parent::beforeAction($action);
    }

    public function behaviors(){
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $model = new UbahPassword;
        return $this->render('index', ['model' => $model]);
    }

    public function actionCekpassword(){
		if (Yii::$app->request->isAjax) {
			$model = new UbahPassword;
			$hasil = $model->cekPassword(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}

    public function actionSimpan(){
        $model 	= new UbahPassword;
		$param 	= Yii::$app->request->post();
		$sukses = $model->simpanData($param);
		if($sukses){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Password berhasil diubah']);
			return $this->redirect(['index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, password gagal diubah']);
			return $this->redirect(['index']);
		}
    }

    public function actionResetpass($id){
        $model 	= new UbahPassword;
		$sukses = $model->resetPass($id);
		if($sukses['hasil']){
			Yii::$app->session->setFlash('success', ['type'=>'success', 'message'=>'Password untuk user '.$sukses['user'].' berhasil direset']);
			return $this->redirect(['user/index']);
		} else{
			Yii::$app->session->setFlash('success', ['type'=>'danger', 'message'=>'Maaf, password untuk user '.$sukses['user'].' gagal direset']);
			return $this->redirect(['user/index']);
		}
    }

}