<?php

namespace app\modules\pengawasan;
use Yii;
use mdm\admin\components\MenuHelper;

class Pengawasan extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\pengawasan\controllers';

    public function init()
    {
        parent::init();		
		\Yii::$app->viewPath = '@app/modules/pengawasan/views';
		\Yii::$app->params['uploadPath'] = \Yii::$app->basePath . '/modules/pengawasan/upload_file/';
		\Yii::$app->params['uploadUrl'] = \Yii::$app->urlManager->baseUrl . '/uploads/';
		\Yii::$app->params['reportPengawasan'] = \Yii::$app->basePath . '/modules/pengawasan/template/';
		$handler = new \yii\web\ErrorHandler(['errorAction' => 'site/errorwas']);
		Yii::$app->set('errorHandler', $handler);
		$handler->register(); 
    }

    public function beforeAction($action){
		parent::beforeAction($action);
		$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id; 		
		\Yii::$app->layout = '@app/views/layouts/pengawasan/main';
		$hasil = MenuHelper::getAksesMenu($urlnya);
		if($hasil){
			return true;
		} else{
			throw new \yii\base\UserException('Anda tidak memiliki akses ke halaman ini');
			Yii::$app->getResponse()->redirect(['site/errornya']);
			return true;
		}
	}
}
