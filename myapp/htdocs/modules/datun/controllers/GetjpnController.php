<?php
namespace app\modules\datun\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\datun\models\Getjpn;

class GetjpnController extends Controller
{
    public function actionIndex(){
		$searchModel = new Getjpn;
		$dataProvider = $searchModel->searchJpn(Yii::$app->request->get());
		return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
    }	
}
