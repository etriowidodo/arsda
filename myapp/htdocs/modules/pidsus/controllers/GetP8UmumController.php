<?php
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\GetP8Umum;

class GetP8UmumController extends Controller
{
    public function actionIndex(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new GetP8Umum;
            $dataProvider = $searchModel->searchP8(Yii::$app->request->get());
            return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
        } 
    }	
}