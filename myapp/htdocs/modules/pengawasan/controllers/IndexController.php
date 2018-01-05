<?php

namespace app\modules\pengawasan\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Was1Controller implements the CRUD actions for Was1 model.
 */
class IndexController extends Controller
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
     * Lists all Was1 models.
     * @return mixed
     */
    public function actionIndex()
    {
        $session = Yii::$app->session;
        
            $session->remove('was_register');
        return $this->render('index');
    }

  

}
