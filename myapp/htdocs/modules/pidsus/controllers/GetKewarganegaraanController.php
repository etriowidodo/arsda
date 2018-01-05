<?php
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\GetKewarganegaraan;

class GetKewarganegaraanController extends Controller
{
    public function actionIndex(){
		$searchModel = new GetKewarganegaraan;
		$dataProvider = $searchModel->searchNegara(Yii::$app->request->get());
		return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
    }	
}
