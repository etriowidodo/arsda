<?php

use app\assets\WasAsset;
use cebe\gravatar\Gravatar;
use dmstr\web\AdminLteAsset;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use mdm\admin\components\MenuHelper;
use yii\helpers\Url;
use kartik\widgets\Growl;


if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'wrapper-black', ['content' => $content]
    );
} else {
    /* @var $this \yii\web\View */
    /* @var $content string */
    $this->title = $this->title . Yii::$app->params['appName'];
    WasAsset::register($this);
    AdminLteAsset::register($this);
    ?>
    <?php $this->beginPage() ?>
  
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <?php $this->head() ?>
            <style type="text/css">
                .modal-loading-new {
                        display:    none;
                        position:   fixed;
                        z-index:    1000;
                        top:        0;
                        left:       0;
                        height:     100%;
                        width:      100%;
                        background: rgba( 255, 255, 255, .8 ) 
                                    url(<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/image/loading.gif'; ?>) 
                                    50% 50% 
                                    no-repeat;
                    }

                    /* When the body has the loading class, we turn
                       the scrollbar off with overflow:hidden */
                    body.loading {
                        overflow: hidden;   
                    }

                    body.loading .modal-loading-new {
                        display: block;
                    }
            </style>
        </head>
       <body class="skin-green fixed">
            <noscript>
              <h3 style="color: white"><center>Javascript anda tidak aktif mohon aktifkan / enabled javascript browser anda.</center></h3> 
              <style>div { display:none; }</style>
            </noscript>
            <?php $this->beginBody() ?>

            <div class="wrapper">

                <header class="main-header" style="border-bottom:1px solid #ffd198;">
                    <!-- Logo -->
                    <a href="<?= \Yii::$app->homeUrl ?>" class="logo"><img alt="admin" src="<?php echo Url::to('/image/logo-cms-simkari-header.png');?>" style="margin-left:-31px;"></a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <!--div id="panah_kanan" -->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <!--/div>
                         <div id="panah_kiri" style="display :none">
                        <a href="#"  class="sidebar-toggle2" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                         </div-->
                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <?php if (!\Yii::$app->user->isGuest): ?>
                                    <!-- Messages: style can be found in dropdown.less-->
                                    <!-- User Account: style can be found in dropdown.less -->
                                    <li class="dropdown user user-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span><?= \Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- User image -->
                                            <li class="user-header bg-light-blue">
                                                <img alt="admin" src="<?php echo Url::to('/image/avatar5.png');?>">
                                                <p>
                                                    <?= \Yii::$app->user->identity->username ?>
                                                    <small><?= \Yii::$app->user->identity->email ?></small>
                                                </p>
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
                                                <div class="pull-left">
                                                    <a href="<?= Url::to(['/autentikasi/ubah-password/index']) ?>"
                                                       class="btn btn-default btn-flat">Ubah Password</a>
                                                </div>
                                                <div class="pull-right">
                                                    <a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>"
                                                       class="btn btn-block btn-default" data-method="post">Sign out</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                <?php endif; ?>
                            </ul>
                        </div>
						<h5 style="margin:0px;padding:0px;text-align:left;"><a href="<?php echo Yii::$app->homeUrl.'pengawasan/index' ;?>"><img alt="admin" src="<?php echo Url::to('/image/text_header.png');?>"></a></h5>
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <?php
                        $callback = function($menu){
                        return [
								'label' => (($menu['route']=='#')?'<i class="fa fa-angle-right"></i>'.$menu['name']:'<i class="fa fa-chevron-circle-right"></i><b>'.$menu['name'].'</b>'),
								'url'   => $menu['route'],
								'items' => $menu['children'],
								'active' => $menu['active'],
							];
                    	};					
						$session = Yii::$app->session;
						$urlnya  = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id; 		
						if ($session->has('was_register')){
							$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PENGAWASAN', $session['ws_register'], $urlnya);
						}else{
							$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PENGAWASAN', $session['ws_register'], $urlnya);  
						}
						echo \kartik\widgets\SideNav::widget(
							[
								'encodeLabels' 	=> false,
								'options' 		=> ['class' => 'sidebar-menu'],
								'items' 		=> $items,
							]
						);
                    ?>
                </aside>

                <!-- Right side column. Contains the navbar and content of the page -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1 style="margin-left:15px;"><?= $this->title ?>
                            	<small><?= $this->subtitle ?></small>
                                <?php 
                                $ringkasan = isset($this->params['ringkasan_perkara']) ? $this->params['ringkasan_perkara'] : "";
                            // if ($ringkasan != "" && $session->has('was_register')) {
                            if ($ringkasan != "") {
         
						$dugaan = \app\modules\pengawasan\models\Lapdu::findBySql("select a.no_register,(select nama_terlapor_awal from was.terlapor_awal where no_register='".$ringkasan."' limit 1)as nama_terlapor_awal,(select count(nama_terlapor_awal)as jml from was.terlapor_awal where no_register='".$ringkasan."')as jml_terlapor,
						(select nama_pelapor from was.pelapor 
						where no_register='".$ringkasan."' limit 1)as nama_pelapor,
						(select count(nama_pelapor)as jml 
						from was.pelapor where no_register='".$ringkasan."')as jml_pelapor,
						(select nama_pegawai_terlapor from was.pegawai_terlapor_was10 where no_register='".$ringkasan."' order by id_pegawai_terlapor limit 1)as nama_pegawai_terlapor,
						(select count(nama_pegawai_terlapor)as jml from was.pegawai_terlapor_was10 where no_register='".$ringkasan."')as jml_pegawai_terlapor from was.lapdu a where no_register='".$ringkasan."'
								")->asArray()->one();

                              ?><br>
                                <strong><small>No. Register : <font size="4" color="blue" font-weight: bold><?php echo $dugaan['no_register']; ?></font></small></strong>
                                   <strong><small>Terlapor Awal :  <font size="4" color="blue" font-weight: bold><?= $dugaan['nama_terlapor_awal']; echo ($dugaan['jml_terlapor']>'1'?', Dkk ':'-') ?></font></small></strong>

								   <strong><small>Pegawai Terlapor :  <font size="4" color="blue" font-weight: bold><?= $dugaan['nama_pegawai_terlapor']; echo ($dugaan['jml_pegawai_terlapor']>=1?', Dkk ':'-') ?></font></small></strong>

                                   <strong><small>Pelapor : <font size="4" color="blue" font-weight: bold><?= $dugaan['nama_pelapor']; echo ($dugaan['jml_pelapor']>'1'?', Dkk ':'-') ?></font></small></strong>
                               <?php
                               } 
?>
                        </h1>
                        <!--<ol class="breadcrumb">
                           <?php /*?><?=
                            Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ])
                            ?> <?php */?>
                        </ol>-->
                    </section>

                    <!-- Main content -->

       <section class="content">
		<?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
            <?= Growl::widget([
                'type' => (!empty($message['type'])) ? $message['type'] : 'danger',
                'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Title Not Set!',
                'icon' => (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                'body' => (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                'showSeparator' => true,
                'delay' => 1, //This delay is how long before the message shows
                'pluginOptions' => [
                    'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000, //This delay is how long the message shows for
                    'placement' => [
                        'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                        'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'right',
                        
                    ],
                    'showProgressbar' => (!empty($message['showProgressbar'])) ? $message['showProgressbar']:false,
                    
                ]
            ]);
            ?>
                         <?php endforeach; ?>
       
					<?php  Alert::widget() ?>
						   
					<?= $content ?>
       </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <strong style="color:#5b5b5b;font-size: 12px;font-weight: bold;"> © Copyright 2015 Simkari CMS<small style="color:#1c7aa9;font-size: 12px;font-weight: normal;"> &nbsp;: : &nbsp;Kejaksaan Agung Republik Indonesia</small></strong>
                </footer>
            </div>
            <!-- ./wrapper -->

    <?php $this->endBody() ?>
        </body>
    </html>
	<!-- <a title="Kembali" id="backSpdp" href="javascript:history.go(-1)" class="btn btn-primary btn-m glyphicon glyphicon-backward "> Kembali </a> -->
     <?php
    $js = <<< JS
    $('.sidebar-menu').slimScroll({
        height: '510px',
        bottom: '10px'    
    });
function fixedBackButton()
{
    var test = ($( window ).height()-($( window ).height()*6)/100)+'px';
    $('#backSpdp').css('position','fixed');
    $('#backSpdp').css('top',test);
    $('#backSpdp').css('right','0px'); 
    $('#backSpdp').css('z-index','99999999999999');
}
fixedBackButton(); 
$( window ).resize(function() {
   fixedBackButton();
});
JS;
    $this->registerJs($js);
    ?>
    <?php $this->endPage() ?>
<?php } ?>