<?php
namespace app\modules\security;
use Yii;
use mdm\admin\components\MenuHelper;

class Security extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\security\controllers';

    public function init(){
        parent::init();
        \Yii::$app->layout = '@app/views/layouts/main.php';
        \Yii::$app->viewPath = '@app/modules/security/views';
        \Yii::$app->params['uploadPath'] = \Yii::$app->basePath . '/modules/security/upload_file/';
    }

    public function beforeAction($action){
		parent::beforeAction($action);
		$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id;
		if(Yii::$app->controller->module->id == "autentikasi" && Yii::$app->controller->id == "ubah-password"){
			return true;
		} else if(Yii::$app->user->identity->peg_nip == ""){
			return true;
		} else{
			$hasil = MenuHelper::getAksesMenu($urlnya);
			if($hasil){
				return true;
			} else{
				throw new \yii\base\UserException('Anda tidak memiliki akses ke halaman ini lagi');
				Yii::$app->getResponse()->redirect(['site/errornya']);
				return true;
			}
		}
	}
}
