<?php
	use app\assets\SecurityAsset;
	use dmstr\web\AdminLteAsset;
	use dmstr\widgets\Alert;
	use kartik\widgets\SideNav;
	use yii\helpers\Html;
	use yii\helpers\Url;
	use yii\web\View;
	use yii\widgets\Breadcrumbs;
	use kartik\widgets\Growl;
	use mdm\admin\components\MenuHelper;

	if (Yii::$app->controller->action->id === 'login') {
		echo $this->render('wrapper-black', ['content' => $content]);
	} else {
		$this->title = $this->title . Yii::$app->params['appName'];
		SecurityAsset::register($this);
		AdminLteAsset::register($this);
		$mdlnya = Yii::$app->controller->module->id;
		$cntnya = Yii::$app->controller->id;
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
        </head>

        <body class="skin-security fixed<?php echo ($mdlnya == "autentikasi" && $cntnya == "ubah-password")?' sidebar-collapse':'';?>">
            <?php $this->beginBody() ?>
            <div class="wrapper">
                <header class="main-header">
                    <a href="<?= \Yii::$app->homeUrl ?>" class="logo">
                    	<img alt="admin" src="<?php echo Url::to('/image/logo-cms-simkari-header.png');?>" style="margin-left:-31px;">
					</a>

                    <nav class="navbar navbar-static-top" role="navigation">
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>

                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <!-- Messages: style can be found in dropdown.less-->
                                    <!-- User Account: style can be found in dropdown.less -->
                                    <li class="dropdown user user-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span><?= Yii::$app->user->identity->username ?> <i class="caret"></i></span>
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
                                                    <a href="<?= Url::to(['/autentikasi/ubah-password/index']) ?>"
                                                       class="btn btn-default btn-flat">Ubah Password</a>
                                                </div>
                                                <div class="pull-right">
                                                    <a href="<?= Url::to(['/site/logout']) ?>"
                                                       class="btn btn-default btn-flat" data-method="post">Sign out</a>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>

                                <?php endif; ?>
                            </ul>
                        </div>
                        <h5 style="margin:0px;padding:0px;text-align:left;">
                            <img alt="admin" src="<?php echo Url::to('/image/text_header_security.png');?>">
                        </h5>
                    </nav>
                </header>

                <aside class="main-sidebar">
                    <?php
                        /*$items = [
                            ['label' => 'Menu', 'url'=>'/wewenang/menu'],
                            ['label' => 'Role', 'url' => '/wewenang/role'],
                            ['label' => 'User', 'url'=>'/user/admin/index'],
                            ['label' => 'User Baru', 'url'=>'/autentikasi/user/index'],
                            ['label' => 'Assignment', 'url' => '/wewenang/assignment'],
                            ['label' => 'Route', 'url'=>'/wewenang/route'],
                            ['label' => 'Backup', 'url'=>'/backup-data'],
                            ['label' => 'Restore', 'url'=>'/restore-data'],
                            ['label' => 'Export Data Perkara', 'url'=>'/backup/export'],
                            ['label' => 'Import Data Pegawai', 'url'=>'/synchronize/pegawai'],
                            ['label' => 'Config', 'url'=>'/pidum/pdm-config/index'],
                        ];
                        echo SideNav::widget(['encodeLabels' => false, 'options' => ['class' => 'sidebar-menu'], 'items' => $items]);*/

						$callback = function($menu){
							return [
								'label' => $menu['name'],
								'url' => $menu['route'],
								'items' => $menu['children'],
								'active' => $menu['active'],
							];
						};
						$userId	= Yii::$app->user->id;
						$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id;
						if($mdlnya == "autentikasi" && $cntnya == "ubah-password"){
							$items = array();
						} else{
							if(Yii::$app->user->identity->peg_nip){
								$items = MenuHelper::getAssignedMenu($userId, $callback, 'SECURITY', '', $urlnya);
							} else{
								$items = MenuHelper::getAssignedMenu($userId, $callback, '', '', $urlnya);
							}
						}
						echo SideNav::widget([
							'encodeLabels' => false,
							'options' => ['class' => 'sidebar-menu'],
							'items' => $items,
						]);
                    ?>

                </aside>

                <div class="content-wrapper">
                    <section class="content-header" style="padding:10px 0px 9px;">
                        <h1 style="margin-left:15px;"><?= $this->title ?></h1>
                    </section>

                    <section class="content" style="padding:65px 15px 15px;">
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
                    <strong style="color:#5b5b5b;font-size: 12px;font-weight: bold;"> © Copyright 2015 Simkari CMS
                    <small style="color:#1c7aa9;font-size: 12px;font-weight: normal;"> &nbsp;: : &nbsp;Kejaksaan Republik Indonesia</small></strong>
                </footer>
            </div>

    <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>