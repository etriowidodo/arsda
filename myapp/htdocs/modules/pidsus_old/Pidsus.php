<?php

namespace app\modules\pidsus;

class Pidsus extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\pidsus\controllers';

    public function init()
    {
        parent::init();

        // custom initialization code goes here
		
        \Yii::$app->layout = '@app/modules\pidsus\views\layouts\main';
    }
}
