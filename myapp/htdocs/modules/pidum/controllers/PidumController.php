<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 26/06/15
 * Time: 13:52
 */

namespace app\modules\pidum\controllers;


use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;

class PidumController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['create', 'update'],
                'rules' => [
                    [
                        'actions' => ['create'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('Create Pidum');
                        }
                    ],
                    [
                        'actions' => ['update'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('Update Pidum');
                        }
                    ],
                    [
                        'actions' => ['delete'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('Delete Pidum');
                        }
                    ],
                    [
                        'actions' => ['view'],
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return Yii::$app->user->can('View Pidum');
                        }
                    ],
                ],
            ],
        ];
    }
}