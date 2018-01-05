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
class WasAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/ionicons.min.css',
	    'css/login.css',
        'css/was-element.css',
        'css/fonts.css',
        'css/notify-metro.css',
        'css/jquery-ui.css',
        'css/jquery.dataTables.css',
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
        'js/jquery.slimscroll.js',
        'js/global_was.js',
        'js/bootbox.min.js',
	    'js/notify.js',
        'js/notify-metro.js',
        'js/jquery-ui.js',
        'js/jquery.dataTables.js',
        'ckeditor/ckeditor.js',
        'js/sync.js'
      
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
    public $jsOptions = [
    'position' => \yii\web\View::POS_HEAD
];
}
