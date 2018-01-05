<?php
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\GetJpu;

class GetJpuController extends Controller
{
    public function actionIndex(){
		$searchModel = new GetJpu;
		$dataProvider = $searchModel->searchJpu(Yii::$app->request->get());
		return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
    }	

    public function actionPenyidik(){
		$searchModel = new GetJpu;
		$dataProvider = $searchModel->searchJpp(Yii::$app->request->get());
		return $this->renderAjax('penyidik', ['dataProvider' => $dataProvider]);
    }	
}
