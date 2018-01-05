<?php

use app\assets\PidsusAsset;
use cebe\gravatar\Gravatar;
use dmstr\web\AdminLteAsset;
use yii\bootstrap\Nav;
use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use dmstr\widgets\Alert;
use app\modules\pidsus\models\MenuHelper;
use yii\helpers\Url;


if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'wrapper-black', ['content' => $content]
    );
} else {
    /* @var $this \yii\web\View */
    /* @var $content string */
    $this->title = $this->title . Yii::$app->params['appName'];
    PidsusAsset::register($this);
    AdminLteAsset::register($this);
    if (!class_exists('viewFormFunction')) {
    require('..\modules\pidsus\controllers\viewFormFunction.php');
    }
    $viewFormFunction2=new viewFormFunction();
    $viewFormFunction2->setInfoHeaderLaporan();
    ?>
   
    <?php $this->beginPage() ?>
  
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <?= Html::csrfMetaTags() ?>
            <title><?= Html::encode($this->title) ?></title>
            <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
            <!-- Ionicons -->
            <!--<link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>-->
            <!-- Theme style -->
            <?php $this->head() ?>
			<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
            <!--[endif]-->
        </head>

              <body class="skin-red fixed">
            <?php $this->beginBody() ?>

            <div class="wrapper">

                <header class="main-header">
                    <!-- Logo -->
                    
                    <a href="<?= \Yii::$app->homeUrl ?>" class="logo"><img alt="admin" src="<?php echo Url::to('/image/logo-cms-simkari-header.png');?>" style="margin-left:-31px;"></a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>

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
                                                <?php /* echo Gravatar::widget(
                                                  [
                                                  'email'   => \Yii::$app->user->identity->profile->gravatar_email,
                                                  'options' => [
                                                  'alt' => \Yii::$app->user->identity->username
                                                  ],
                                                  'size'    => 128
                                                  ]
                                                  ); */ ?>
                                                <p>
                                                    <?= \Yii::$app->user->identity->username ?>
                                                    <small><?= \Yii::$app->user->identity->email ?></small>
                                                </p>
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
                                                <div class="pull-left">
                                                    <a href="<?= \yii\helpers\Url::to(['/user/settings/profile']) ?>"
                                                       class="btn btn-block btn-default">Profile</a>
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
                        </div><h5 style="margin:0px;padding:0px;text-align:left;"><img alt="admin" src="<?php echo Url::to('/image/text_header_pidsus.png');?>"></h5>
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar" style="overflow-x:hidden;overflow-y:scroll;height:600px">
                    <?php if (Yii::$app->user->isGuest): ?>
                        <div class="user-panel" style="background:#800000;border-bottom:1px solid #ff6969;box-shadow:0 1px 0 0 #8a5109;">
                            <div class="pull-left image">
                                <img alt="admin" src="<?php echo Url::to('/image/avatar5.png');?>">
                                <?php /* echo Gravatar::widget(
                                  [
                                  'email'   => \Yii::$app->user->identity->profile->gravatar_email,
                                  'options' => [
                                  'alt' => \Yii::$app->user->identity->username
                                  ],
                                  'size'    => 64
                                  ]
                                  ); */ ?>
                            </div>
                            <div class="pull-left info">
                                <p><?= \Yii::$app->user->identity->username ?></p>

                                <a href="#"><i class="fa fa-circle text-success" style="color:#bdfc44;"></i> Online</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                    $callback = function($menu) {
                      //  $data = eval($menu['data']);

                        return [
                            'label' => (empty($menu['route']) ?'<i class="fa fa-chevron-circle-right">' : '<i class="fa fa-angle-right">').'</i> ' . $menu['name'],
                            'url' => $menu['route'],
                            //'options' => $data
                            'items' => $menu['children']
                        ];
                    };

                    $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback,true,'PIDSUS');

         echo \kartik\widgets\SideNav::widget(
                            [
                                'encodeLabels' => false,
                                'options' => ['class' => 'sidebar-menu'],
                                'items' => $items,
                            ]
                    );

                    ?>

                </aside>

                <!-- Right side column. Contains the navbar and content of the page -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1 style="margin-left:15px;"><div><table class="col-md-9"><tr><td><?= $this->title ?><small><?= $this->params['idtitle']?></small></td></tr></table></div>
                        </h1>
                        
                    </section>

                    <!-- Main content -->

                    <section class="content">
    <?= Alert::widget() ?>
    <?= $content ?>
                    </section>
                    <!-- /.content -->
                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">
                    <strong style="color:#1c7aa9;"> Kejaksaan Republik Indonesia</strong>
                </footer>
            </div>
            <!-- ./wrapper -->

    <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>