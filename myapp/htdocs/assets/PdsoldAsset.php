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
class PdsoldAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/ionicons.min.css',
        'css/fonts.css',
		'css/login.css',
		'css/style.select2.css',
        'css/style.icheck.css',
		'css/pdsold-element.css',
        'css/jquery-ui.css',
        'css/bootstrap-timepicker.css',
        'css/select2.css'
    ];
    public $js = [
        'js/plugins/jquery.plugin.sidebar.js',
        'js/html5shiv.js',
        'js/respond.min.js',
        'js/jquery.slimscroll.js',
        'js/pidum.js',
        'js/bootbox.min.js',
        'js/select2.min.js',
        'js/combodate.js',
        'js/moment.min.js',
        'js/jquery.inputmask.js',
        'js/highcharts.js',
        'js/highcharts-3d.js',
        'js/exporting.js',
        'js/offline-exporting.js',
        'js/webcam.min.js',
		'js/plugins/jquery.plugin.select2.min.js',      
        'js/plugins/jquery.plugin.select2.id.js',      
        'js/plugins/jquery.plugin.iCheck.js',    
		'js/plugins/validator.min.js',
        'js/plugins/bootstrap-notify.min.js',    
        'js/jquery-ui.js', 
        'js/plugins/bootstrap-timepicker.js',
        'js/plugins/jquery.plugin.sidebar.js',
        'js/pdsold.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
        'position' => \yii\web\View::POS_END
        
    ];
}
