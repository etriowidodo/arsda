<?php

use app\assets\AppAsset;
use dmstr\web\AdminLteAsset;
use dmstr\widgets\Alert;
use kartik\widgets\SideNav;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;

if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'wrapper-black', ['content' => $content]
    );
} else {
    /* @var $this View */
    /* @var $content string */
    $this->title = $this->title . Yii::$app->params['appName'];
    AppAsset::register($this);
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
            <!-- Ionicons -->
            <!--<link href="//code.ionicframework.com/ionicons/1.5.2/css/ionicons.min.css" rel="stylesheet" type="text/css"/>-->
            <!-- Theme style -->
            <?php $this->head() ?>

            <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
            <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
            <!--[if lt IE 9]>
            <!--<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>-->
            <![endif]-->
        </head>

        <body class="skin-green">
            <?php $this->beginBody() ?>

            <div class="wrapper">

                <header class="main-header">
                    <!-- Logo -->
                    <a href="<?= Yii::$app->homeUrl ?>" class="logo">Simkari CMS</a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>
                        <?php
                            

                            NavBar::begin([
                                'brandLabel' => 'My Company',
                                'brandUrl' => Yii::$app->homeUrl,
                                'options' => [
                                    'class' => 'navbar-inverse navbar-fixed-top',
                                ],
                            ]);
                            $menuItems = [
                                ['label' => 'Home', 'url' => ['/site/index']],
                            ];
                            if (Yii::$app->user->isGuest) {
                                $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
                            } else {
                                $callback = function($menu) {
                                    $data = eval($menu['data']);

                                    return [
                                        'label' => $menu['name'],
                                        'url' => $menu['route'],
                                        //'options' => $data
                                        //'items' => $menu['children']
                                    ];
                                };
                                $menuItems = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);
                                $menuItems[] = [
                                    'label' => 'Logout (' . Yii::$app->user->identity->username . ')',
                                    'url' => ['/site/logout'],
                                    'linkOptions' => ['data-method' => 'post']
                                ];
                            }
                            echo Nav::widget([
                                'options' => ['class' => 'navbar-nav navbar-right'],
                                'items' => $menuItems,
                            ]);
                            NavBar::end();
                        ?>
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
                                            <!-- User image -->
                                            <li class="user-header bg-light-blue">
                                                <img alt="admin" src="http://simkaricms.local/image/avatar5.png">
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
                                                    <?= Yii::$app->user->identity->username ?>
                                                    <small><?= Yii::$app->user->identity->email ?></small>
                                                </p>
                                            </li>
                                            <!-- Menu Footer-->
                                            <li class="user-footer">
                                                <div class="pull-left">
                                                    <a href="<?= Url::to(['/user/settings/profile']) ?>"
                                                       class="btn btn-default btn-flat">Profile</a>
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
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">
                    <?php if (!Yii::$app->user->isGuest): ?>
                        <div class="user-panel">
                            <div class="pull-left image">
                                <img alt="admin" src="http://simkaricms.local/image/avatar5.png">
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
                                <p><?= Yii::$app->user->identity->username ?></p>

                                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php
                    $callback = function($menu) {
                        $data = eval($menu['data']);

                        return [
                            'label' => '<i class="fa fa-circle-o"></i> ' . $menu['name'],
                            'url' => $menu['route'],
                            //'options' => $data
                            'items' => $menu['children']
                        ];
                    };

                    $items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback);



                    echo SideNav::widget(
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
                        <h1>
                            <small><?= $this->title ?></small>
                        </h1>
                        <ol class="breadcrumb">
                            <?=
                            Breadcrumbs::widget([
                                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                            ])
                            ?>
                        </ol>
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
                    Powered by <strong><a href="http://phundament.com">Phundament 4</a></strong>
                </footer>
            </div>
            <!-- ./wrapper -->

            <?php $this->endBody() ?>
        </body>
    </html>
    <?php $this->endPage() ?>
<?php } ?>