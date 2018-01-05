<?php
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\GetTtd;

class GetTtdController extends Controller
{
    public function actionIndex(){
		$searchModel = new GetTtd;
		$dataProvider = $searchModel->searchTtd(Yii::$app->request->get());
		return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
    }	
}
