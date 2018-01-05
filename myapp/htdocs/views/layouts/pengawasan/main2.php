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

        <body class="skin-green fixed sidebar-collapse">
            <?php $this->beginBody() ?>

            <div class="wrapper">

                <header class="main-header">
                    <!-- Logo -->

                    <a href="<?= \Yii::$app->homeUrl ?>" class="logo"><img alt="admin" src="<?php echo Url::to('/image/logo-cms-simkari-header.png'); ?>" style="margin-left:-31px;"></a>
                    <!-- Header Navbar: style can be found in header.less -->
                    <nav class="navbar navbar-static-top" role="navigation">
                        <!-- Sidebar toggle button-->
                        <!--<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>-->
                        <!--<div id="panah_kanan" >
                            <a href="#"   class="sidebar-toggle" data-toggle="offcanvas" role="button">
                                <span class="sr-only">Toggle navigation</span>
                            </a>
                        </div>-->
                        <div id="panah_kiri" style="display :none">
                            <a href="#"  class="sidebar-toggle2" data-toggle="offcanvas" role="button">
                                <span class="sr-only">Toggle navigation</span>
                            </a>
                        </div>
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
                                                <img alt="admin" src="<?php echo Url::to('/image/avatar5.png'); ?>">
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
                        </div><h5 style="margin:0px;padding:0px;text-align:left;"><a href="<?php echo Yii::$app->homeUrl . 'pengawasan/index'; ?>"><img alt="admin" src="<?php echo Url::to('/image/text_header.png'); ?>"></a></h5>
                    </nav>
                </header>


                <!-- Right side column. Contains the navbar and content of the page -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header">
                        <h1 style="margin-left:15px;"><?= $this->title ?>
                            <small><?= $this->subtitle ?></small>
                            <?php
                            $session = Yii::$app->session;
                            $ringkasan = isset($this->params['ringkasan_perkara']) ? $this->params['ringkasan_perkara'] : "";
                            if ($ringkasan != "" && $session->has('was_register')) {

                                $dugaan = \app\modules\pengawasan\models\DugaanPelanggaran::findBySql("select a.id_register,a.no_register,f.peg_nip_baru||' - '||f.peg_nama||case when f.jml_terlapor > 1 then ' dkk' else '' end as terlapor from was.dugaan_pelanggaran a
inner join kepegawaian.kp_inst_satker b on (a.inst_satkerkd=b.inst_satkerkd)
inner join (
select c.id_terlapor,c.id_register,c.id_h_jabatan,e.peg_nama,e.peg_nip,e.peg_nip_baru,y.jml_terlapor from was.terlapor c
    inner join kepegawaian.kp_h_jabatan d on (c.id_h_jabatan=d.id)
    inner join kepegawaian.kp_pegawai e on (c.peg_nik=e.peg_nik)
        inner join (select z.id_register,min(z.id_terlapor)as id_terlapor,
            count(*) as jml_terlapor from was.terlapor z group by 1)y on (c.id_terlapor=y.id_terlapor)order by 1 asc)f
        on (a.id_register=f.id_register) where a.id_register = :idRegister", [":idRegister" => $session['was_register']])->asArray()->one();
                                ?><br>
                                <small>No. Surat &nbsp;<strong class="head"><?= $dugaan['no_register'] ?></strong></small>
                                <small>Terlapor &nbsp;<strong class="head"><?= $dugaan['terlapor'] ?></strong></small>
                                <?php
                            }
                            ?>
                        </h1>
                        <!--<ol class="breadcrumb">
                        <?php /* ?><?=
                          Breadcrumbs::widget([
                          'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
                          ])
                          ?> <?php */ ?>
                        </ol>-->
                    </section>

                    <!-- Main content -->

                    <section class="content">
                        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                            <?=
                            Growl::widget([
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
                                    'showProgressbar' => (!empty($message['showProgressbar'])) ? $message['showProgressbar'] : false,
                                ]
                            ]);
                            ?>
                        <?php endforeach; ?>

                        <?php Alert::widget() ?>

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
    <?php
    /*  $js = <<< JS
      $('.sidebar-menu').slimScroll({
              height: '510px',
      bottom: '10px'
          });
      JS;
      $this->registerJs($js); */
    ?>
    <?php $this->endPage() ?>
<?php } ?>