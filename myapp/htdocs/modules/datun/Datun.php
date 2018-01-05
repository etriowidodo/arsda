<?php
namespace app\modules\datun;
use Yii;
use mdm\admin\components\MenuHelper;

class Datun extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\datun\controllers';

    public function init(){
        parent::init();
        \Yii::$app->viewPath 				= '@app/modules/datun/views';
        \Yii::$app->params['pathTemplate'] 	= \Yii::$app->basePath.'/modules/datun/template/';
        \Yii::$app->params['permohonan'] 	= \Yii::$app->basePath.'/modules/datun/upload_file/permohonan/';
		\Yii::$app->params['foto_mhs'] 		= \Yii::$app->basePath.'/modules/datun/upload_file/mahasiswa/';
        \Yii::$app->params['sp1'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/sp1/';
        \Yii::$app->params['s5'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s5/';
        \Yii::$app->params['hasiltelaah'] 	= \Yii::$app->basePath.'/modules/datun/upload_file/hasiltelaah/';
		\Yii::$app->params['skk'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/skk/';
		\Yii::$app->params['skks'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/skks/';
		\Yii::$app->params['s3_siap'] 		= \Yii::$app->basePath.'/modules/datun/upload_file/s3/persiapan/';
		\Yii::$app->params['s3_sidang'] 	= \Yii::$app->basePath.'/modules/datun/upload_file/s3/persidangan/';
		\Yii::$app->params['s4_siap'] 		= \Yii::$app->basePath.'/modules/datun/upload_file/s4/persiapan/';
		\Yii::$app->params['s4_sidang'] 	= \Yii::$app->basePath.'/modules/datun/upload_file/s4/persidangan/';
		\Yii::$app->params['mediasi'] 		= \Yii::$app->basePath.'/modules/datun/upload_file/mediasi/';
		\Yii::$app->params['s11'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s11/';
		\Yii::$app->params['s13'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s13/';
		\Yii::$app->params['s14'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s14/';
		\Yii::$app->params['s17'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s17/';
		\Yii::$app->params['s18'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s18/';
		\Yii::$app->params['s19a'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s19a/';
		\Yii::$app->params['s22'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s22/';
		\Yii::$app->params['putusan'] 		= \Yii::$app->basePath.'/modules/datun/upload_file/putusan/';
		\Yii::$app->params['s24'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s24/';
		\Yii::$app->params['s24_putusan']	= \Yii::$app->basePath.'/modules/datun/upload_file/s24Putusan/';
		\Yii::$app->params['s25'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s25/';
		\Yii::$app->params['s26'] 			= \Yii::$app->basePath.'/modules/datun/upload_file/s26/';
		\Yii::$app->params['putusanBanding']= \Yii::$app->basePath.'/modules/datun/upload_file/putusanBanding/';
		\Yii::$app->params['putusanKasasi']	= \Yii::$app->basePath.'/modules/datun/upload_file/putusanKasasi/';
		\Yii::$app->params['s28']			= \Yii::$app->basePath.'/modules/datun/upload_file/s28/';
		\Yii::$app->params['permohonan_banding']= \Yii::$app->basePath.'/modules/datun/upload_file/permohonanBanding/';
		\Yii::$app->params['permohonan_kasasi']= \Yii::$app->basePath.'/modules/datun/upload_file/permohonanKasasi/';
		\Yii::$app->params['permohonan_pk']	= \Yii::$app->basePath.'/modules/datun/upload_file/permohonanPK/';
		\Yii::$app->params['putusan_pk']	= \Yii::$app->basePath.'/modules/datun/upload_file/putusanPK/';
		\Yii::$app->params['kontra_banding']= \Yii::$app->basePath.'/modules/datun/upload_file/kontraBanding/';
		\Yii::$app->params['pts_kontra_banding']= \Yii::$app->basePath.'/modules/datun/upload_file/ptsKontraBanding/';
		\Yii::$app->params['pts_kontra_kasasi']= \Yii::$app->basePath.'/modules/datun/upload_file/ptsKontraKasasi/';
		\Yii::$app->params['kontra_kasasi']	= \Yii::$app->basePath.'/modules/datun/upload_file/kontraKasasi/';
		\Yii::$app->params['relas_s25']		= \Yii::$app->basePath.'/modules/datun/upload_file/relasS25/';
		\Yii::$app->params['relas_s26']		= \Yii::$app->basePath.'/modules/datun/upload_file/relasS26/';
		\Yii::$app->params['relas_s28']		= \Yii::$app->basePath.'/modules/datun/upload_file/relasS28/';
		\Yii::$app->params['relas_kontra_banding']	= \Yii::$app->basePath.'/modules/datun/upload_file/relasKontraBanding/';
		\Yii::$app->params['memori_banding']= \Yii::$app->basePath.'/modules/datun/upload_file/memoriBanding/';
		\Yii::$app->params['relas_kontra_kasasi']	= \Yii::$app->basePath.'/modules/datun/upload_file/relasKontraKasasi/';
		\Yii::$app->params['memori_kasasi']	= \Yii::$app->basePath.'/modules/datun/upload_file/memoriKasasi/';
		\Yii::$app->params['relas_kontra_pk']= \Yii::$app->basePath.'/modules/datun/upload_file/relasKontraPK/';
		\Yii::$app->params['memori_pk']		= \Yii::$app->basePath.'/modules/datun/upload_file/memoriPK/';
		\Yii::$app->params['kontra_pk']		= \Yii::$app->basePath.'/modules/datun/upload_file/kontraPK/';
		\Yii::$app->params['pts_kontra_pk']	= \Yii::$app->basePath.'/modules/datun/upload_file/ptsKontraPK/';
		\Yii::$app->params['laporan_prinsipal']	= \Yii::$app->basePath.'/modules/datun/upload_file/laporanPrinsipal/';
		\Yii::$app->params['nodis']			= \Yii::$app->basePath.'/modules/datun/upload_file/nodis/';
	}

    public function beforeAction($action){
		parent::beforeAction($action);
		$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id; 		
		$arrPas = array("/datun/download-file/index", "/datun/getjpn/index", "/datun/get-ttd/index", "/datun/getskks/index");
		$hasil = MenuHelper::getAksesMenu($urlnya);
		if($hasil || in_array($urlnya, $arrPas)){
			return true;
		} else{
			throw new \yii\base\UserException('Anda tidak memiliki akses ke halaman ini');
			Yii::$app->getResponse()->redirect(['site/errornya']);
			return true;
		}
	}
}
