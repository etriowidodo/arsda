<?php
namespace app\modules\pidsus\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\GetUndang;


class GetUndangController extends Controller{
    public function actionGetformundang(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new GetUndang;
            $dataProvider = $searchModel->searchUndang(Yii::$app->request->get());
            return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
        } 
    }
}
