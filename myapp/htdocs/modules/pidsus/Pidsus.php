<?php
namespace app\modules\pidsus;
use Yii;
use mdm\admin\components\MenuHelper;

class Pidsus extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\pidsus\controllers';

    public function init(){
        parent::init();
        \Yii::$app->viewPath                = '@app/modules/pidsus/views';
		\Yii::$app->layout                  = '@app/modules\pidsus\views\layouts\main2';
        \Yii::$app->params['pathTemplate']  = \Yii::$app->basePath.'/modules/pidsus/template/';
        \Yii::$app->params['p16']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p16/';
        \Yii::$app->params['p17']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p17/';
        \Yii::$app->params['ceklist']       = \Yii::$app->basePath.'/modules/pidsus/upload_file/ceklist/';
        \Yii::$app->params['p21']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p21/';
        \Yii::$app->params['p21a']          = \Yii::$app->basePath.'/modules/pidsus/upload_file/p21a/';
        \Yii::$app->params['pengembalian_berkas']  = \Yii::$app->basePath.'/modules/pidsus/upload_file/pengembalian_berkas/';
        \Yii::$app->params['p18']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p18/';
        \Yii::$app->params['p19']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p19/';
        \Yii::$app->params['p20']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p20/';
        \Yii::$app->params['p22']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p22/';
        \Yii::$app->params['p23']           = \Yii::$app->basePath.'/modules/pidsus/upload_file/p23/';
        \Yii::$app->params['spdp']          = \Yii::$app->basePath.'/modules/pidsus/upload_file/spdp/';
        \Yii::$app->params['spdp_kembali']  = \Yii::$app->basePath.'/modules/pidsus/upload_file/spdp_kembali/';
        \Yii::$app->params['minta_perpanjang']  = \Yii::$app->basePath.'/modules/pidsus/upload_file/minta_perpanjang/';
        \Yii::$app->params['pdsT4']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/t-4/';
        \Yii::$app->params['pdsT5']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/t-5/';
        \Yii::$app->params['penyelesaian_pratut']  = \Yii::$app->basePath.'/modules/pidsus/upload_file/penyelesaian_pratut/';
        \Yii::$app->params['rendak']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/rendak/';
        \Yii::$app->params['p8umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p8umum/';
        \Yii::$app->params['pidsus_12umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_12umum/';
        \Yii::$app->params['pidsus_13umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_13umum/';
        \Yii::$app->params['pidsus_14umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_14umum/';
        \Yii::$app->params['pidsus_15umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_15umum/';
        \Yii::$app->params['p9_umum']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/p9_umum/';
        \Yii::$app->params['p10_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p10_umum/';
        \Yii::$app->params['p11_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p11_umum/';
        \Yii::$app->params['ba1_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba1_umum/';
        \Yii::$app->params['ba2_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba2_umum/';
        \Yii::$app->params['ba3_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba3_umum/';
        \Yii::$app->params['pidsus_16umum'] = \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_16umum/';
        \Yii::$app->params['b4_umum']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/b4_umum/';
        \Yii::$app->params['b1_umum']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/b1_umum/';
        \Yii::$app->params['pidsus_20cumum'] = \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_20cumum/';
        \Yii::$app->params['ba16_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba16_umum/';
        \Yii::$app->params['b2_umum']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/b2_umum/';
        \Yii::$app->params['pidsus_17umum'] = \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_17umum/';
        \Yii::$app->params['b7_umum']  		= \Yii::$app->basePath.'/modules/pidsus/upload_file/b7_umum/';
        \Yii::$app->params['pidsus_6umum']  = \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_6umum/';
        \Yii::$app->params['pidsus_7umum']  = \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_7umum/';
        \Yii::$app->params['p15_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p15_umum/';
        \Yii::$app->params['p14_umum']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p14_umum/';
        \Yii::$app->params['pidsus_18']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_18/';
        \Yii::$app->params['p8khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p8khusus/';
        \Yii::$app->params['pidsus_12khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_12khusus/';
        \Yii::$app->params['pidsus_13khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_13khusus/';
        \Yii::$app->params['pidsus_14khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_14khusus/';
        \Yii::$app->params['pidsus_15khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/pidsus_15khusus/';
        \Yii::$app->params['p9_khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p9_khusus/';
        \Yii::$app->params['p10_khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p10_khusus/';
        \Yii::$app->params['p11_khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/p11_khusus/';
        \Yii::$app->params['ba1_khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba1_khusus/';
        \Yii::$app->params['ba2_khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba2_khusus/';
        \Yii::$app->params['ba3_khusus']  	= \Yii::$app->basePath.'/modules/pidsus/upload_file/ba3_khusus/';
	}

    public function beforeAction($action){
		parent::beforeAction($action);
		$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id; 		
		$arrPas = array("/pidsus/download-file/index", "/pidsus/getjpn/index", "/pidsus/get-ttd/index");
		/*$hasil = MenuHelper::getAksesMenu($urlnya);
		if($hasil || in_array($urlnya, $arrPas)){
			return true;
		} else{
			throw new \yii\base\UserException('Anda tidak memiliki akses ke halaman ini');
			Yii::$app->getResponse()->redirect(['site/errornya']);
			return true;
		}*/
		return true;
	}
}
