<?php

namespace app\modules\pdsold;
use Yii;
use mdm\admin\components\MenuHelper;

class Pdsold extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\pdsold\controllers';

    public function init(){
        parent::init();
        // custom initialization code goes here
        \Yii::$app->viewPath = '@app/modules/pdsold/views';
        \Yii::$app->params['uploadPath'] = \Yii::$app->basePath . '/modules/pdsold/upload_file/';
    }

    public function beforeAction($action){
		parent::beforeAction($action);
		$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id; 
		// echo $urlnya;exit;		
		$hasil = MenuHelper::getAksesMenu($urlnya);
		// echo $hasil;exit;
		if($hasil){
			return true;
		} else{
			//throw new \yii\base\UserException('Anda tidak memiliki akses ke halaman ini');
			//Yii::$app->getResponse()->redirect(['site/errornya']);
			return true;
		}
	}
}
