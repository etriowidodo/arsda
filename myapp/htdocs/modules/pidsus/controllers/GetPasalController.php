<?php
namespace app\modules\pidsus\controllers;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\modules\pidsus\models\GetPasal;


class GetPasalController extends Controller{
    public function actionGetformpasal(){
        if (Yii::$app->request->isAjax) {
            $searchModel = new GetPasal;
            $dataProvider = $searchModel->searchPasal(Yii::$app->request->get());
            return $this->renderAjax('index', ['dataProvider' => $dataProvider]);
        } 
    }
}
