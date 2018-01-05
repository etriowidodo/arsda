<?php
	use app\assets\DatunAsset;
	use dmstr\web\AdminLteAsset;
	use kartik\widgets\Growl;
	use kartik\widgets\SideNav;
	use mdm\admin\components\MenuHelper;
	use yii\bootstrap\Nav;
	use yii\bootstrap\NavBar;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;
	use yii\widgets\Breadcrumbs;

	if (Yii::$app->controller->action->id === 'login') {
		echo $this->render('wrapper-black', ['content' => $content]);
	} else {
		/* @var $this View */
		/* @var $content string */
		$this->title = $this->title . Yii::$app->params['appName'];
		DatunAsset::register($this);
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
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
    <!--[endif]-->
    <style type="text/css">
        .modal-loading-new {
            opacity: 0.6!important;
            display:    none;
            position:   fixed;
            z-index:    1000;
            top:        0;
            left:       0;
            height:     100%;
            width:      100%;
            background: #333 url(<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/image/loading.gif'; ?>) 50% 50% no-repeat;
        }
        /* When the body has the loading class, we turn the scrollbar off with overflow:hidden */
        body.loading {
            overflow: hidden;   
        }
        body.loading .modal-loading-new {
            display: block;
        }
    </style>
</head>

<body class="skin-datun-light fixed" data-tgl="<?php echo date("Y").",".date("m").",".date("d");?>">
    <noscript>
        <h3 style="color: white"><center>Javascript anda tidak aktif mohon aktifkan / enabled javascript browser anda.</center></h3> 
        <style>div { display:none; }</style>
    </noscript>
    <?php $this->beginBody() ?>
    <div class="wrapper">
        <header class="main-header" style="border-bottom:1px solid #ffd198;">
            <a href="<?= \Yii::$app->homeUrl ?>" class="logo"><img alt="admin" src="<?php echo Url::to('/image/logo-cms-simkari-header.png');?>" style="margin-left:-31px;"></a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <?php if (!Yii::$app->user->isGuest): ?>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="glyphicon glyphicon-user"></i><span><?= Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="user-header bg-light-blue">
                                        <img alt="admin" src="<?php echo Url::to('/image/avatar5.png');?>">
                                        <p>
                                            <?= Yii::$app->user->identity->username ?>
                                            <small><?= Yii::$app->user->identity->email ?></small>
                                        </p>
                                    </li>
                                    <li class="user-footer">
                                        <div class="pull-left">
											<a href="<?= Url::to(['/autentikasi/ubah-password/index']) ?>" class="btn btn-default btn-flat">Ubah Password</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?= Url::to(['/site/logout']) ?>" class="btn btn-default btn-flat" data-method="post">Sign out</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <h5 style="margin:0px;padding:0px;text-align:left;">
                    <a href="/datun/permohonan/index"><img alt="admin" src="<?php echo Url::to('/image/text_header_datun.png');?>"></a> 
                    <span style="color:white;margin-left:16px;font-size:14px;"><strong><?= Yii::$app->inspektur->getNamaSatker(); ?></strong></span>
                </h5>
            </nav>
        </header>

        <aside class="main-sidebar">
			<?php
				//print_r($_SERVER['REQUEST_URI']);
                $callback = function($menu){
                    //$data = eval($menu['data']);
                    return [
                        'label' => (empty($menu['route'])?'<i class="fa fa-chevron-circle-right">':'<i class="fa fa-angle-right">').'</i>' . $menu['name'],
                        'url' => (empty($menu['route'])?'#':$menu['route']),
                        'items' => $menu['children'],
						'active' => $menu['active'],
                    ];
                };
				$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id; 		
                $items  = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'DATUN', '', $urlnya);
				echo SideNav::widget([
                    'encodeLabels' => false,
                    'options' => ['class' => 'sidebar-menu'],
                    'items' => $items,
                ]);
            ?>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1 style="margin-left:15px;">
                    <?= $this->title ?>
                    <small><?= $this->subtitle ?></small>
                </h1>
                <ol class="breadcrumb">
                    <?=Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],])?>
                </ol>
            </section>

            <!-- Main content  -->
            
            <section class="content">
				<?php 
                    foreach (Yii::$app->session->getAllFlashes() as $message){
                        echo Growl::widget([
                            'type' 	=> (!empty($message['type'])) ? $message['type'] : 'danger',
                            'title' => (!empty($message['title'])) ? Html::encode($message['title']) : 'Informasi',
                            'icon' 	=> (!empty($message['icon'])) ? $message['icon'] : 'fa fa-info',
                            'body' 	=> (!empty($message['message'])) ? Html::encode($message['message']) : 'Message Not Set!',
                            'delay' => 1,
                            'showSeparator' => true,
                            'pluginOptions' => [
                                'delay' => (!empty($message['duration'])) ? $message['duration'] : 3000,
                                'placement' => [
                                    'from' => (!empty($message['positonY'])) ? $message['positonY'] : 'top',
                                    'align' => (!empty($message['positonX'])) ? $message['positonX'] : 'center',
                                ],
                                'showProgressbar' => (!empty($message['showProgressbar'])) ? $message['showProgressbar'] : false,
                            ]
                        ]);
                    }
                ?>
                <?= $content ?>
            </section>
        </div>
        <footer class="main-footer">
            <strong style="color:#5b5b5b;font-size: 12px;font-weight: bold;"> 
                &copy; Copyright 2016 Simkari CMS<small style="color:#1c7aa9;font-size: 12px;font-weight: normal;"> &nbsp;: : &nbsp;Kejaksaan Republik Indonesia</small>
            </strong>
        </footer>
    </div>
    <div class="modal-loading-new"></div>        
    <?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
<?php } ?>
