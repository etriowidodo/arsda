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
class SecurityAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/ionicons.min.css',
        'css/security.css',
        'css/fonts.css',
        'css/style.select2.css',
        'css/style.icheck.css',
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
        'js/jquery.slimscroll.js',
        'js/global_was.js',
		'js/bootbox.min.js',
        'js/plugins/jquery.plugin.select2.min.js',      
        'js/plugins/jquery.plugin.select2.id.js',      
        'js/plugins/jquery.plugin.iCheck.js',      
        'js/plugins/validator.min.js',
        'js/global.security.js',
        'js/sync.js'
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
		'kartik\sidenav\SideNavAsset',
    ];
    public $jsOptions = [
    	'position' => \yii\web\View::POS_HEAD
	];
}
