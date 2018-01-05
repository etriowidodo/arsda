<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/ionicons.min.css',
		'css/login.css',
		'css/pidum-element.css',
        'css/fonts.css',
        'css/select2.css'
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
        'js/jquery.slimscroll.js',
        'js/pidum.js',
        'js/bootbox.min.js',
        //'js/relCopy.js',
        'js/select2.min.js',
        'js/combodate.js',
        'js/moment.min.js',
        'js/jquery.inputmask.js',
        'js/highcharts.js',
        'js/highcharts-3d.js',
        'js/exporting.js',
        'js/offline-exporting.js',
        'js/webcam.min.js',
        'js/download.js',
//        'js/sync.js'

        
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
        
    ];
}
