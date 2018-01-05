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
class DatunAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/ionicons.min.css',
        'css/fonts.css',
		'css/security.css',
		'css/style.select2.css',
        'css/style.icheck.css',
        'css/datun-element.css',
        'css/jquery-ui.css', //tambahan tanggal datun 09112016
        'css/bootstrap-timepicker.css',
    ];
    public $js = [
        'js/html5shiv.js',
        'js/respond.min.js',
        'js/jquery.slimscroll.js',
        'js/bootbox.min.js',
        'js/combodate.js',
        'js/moment.min.js',
        'js/jquery.inputmask.js',
		'ckeditor/ckeditor.js',
		'ckeditor/adapters/jquery.js',
		'js/plugins/jquery.plugin.select2.min.js',      
        'js/plugins/jquery.plugin.select2.id.js',      
        'js/plugins/jquery.plugin.iCheck.js',    
		'js/plugins/validator.min.js',
        'js/plugins/bootstrap-notify.min.js',    
        'js/jquery-ui.js',  //tambahan tanggal datun 09112016
        'js/plugins/bootstrap-timepicker.js',
        'js/plugins/jquery.plugin.sidebar.js',
        'js/datun.js',
    ];
    public $depends = [
        'dmstr\web\AdminLteAsset',
		'kartik\sidenav\SideNavAsset',
    ];
	public $jsOptions = [
    	'position' => \yii\web\View::POS_HEAD
	];
}
