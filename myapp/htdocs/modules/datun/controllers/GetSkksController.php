<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\GetSkks;

class GetskksController extends Controller
{
	public function actionIndex(){
		if (Yii::$app->request->isAjax) {
			$model = new GetSkks;
			$hasil = $model->getSkks(Yii::$app->request->post());
			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
			return ['hasil'=>$hasil];
		}    
	}
}
