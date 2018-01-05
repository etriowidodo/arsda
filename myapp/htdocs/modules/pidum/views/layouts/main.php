
<?php

use app\assets\AppAsset;
use dmstr\web\AdminLteAsset;
//use dmstr\widgets\Alert;
use kartik\widgets\Growl;
use kartik\widgets\SideNav;
use mdm\admin\components\MenuHelper;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\Breadcrumbs;
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use app\modules\pidum\models\PdmP48;
use app\modules\pidum\models\VwTerdakwaT2;
use app\modules\pidum\models\PdmRp11;
use app\modules\pidum\models\PdmTahapDua;
use app\modules\pidum\models\PdmBerkasTahap1;
use app\modules\pidum\models\PdmSpdp;
//use app\modules\pidum\models\MsTersangkaBerkas;
/*use app\modules\pidum\models\Pdm;
use app\modules\pidum\models\PdmSpdp;
use app\modules\pidum\models\PdmSpdp;*/


if (Yii::$app->controller->action->id === 'login') {
    echo $this->render(
            'wrapper-black', ['content' => $content]
    );
} else {
    /* @var $this View */
    /* @var $content string */
    //echo '<pre>';print_r(Yii::$app->params);exit;
    $this->title = $this->title . Yii::$app->params['appName'];
    //var_dump($this->subtitle);exit;
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
            <!--[endif]-->

            <style type="text/css">
                .modal-loading-new {
                        display:    none;
                        position:   fixed;
                        z-index:    1000;
                        top:        0;
                        left:       0;
                        height:     100%;
                        width:      100%;
                        background:     
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

        <body class="skin-yellow fixed">
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
                        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                            <span class="sr-only">Toggle navigation</span>
                        </a>

                        <div class="navbar-custom-menu">
                            <ul class="nav navbar-nav">
                                <?php if (!Yii::$app->user->isGuest): ?>
                                    <!-- Messages: style can be found in dropdown.less-->
                                    <!-- User Account: style can be found in dropdown.less -->
                                    <?php //if(Yii::$app->user->identity->is_admin == 1): ?>
                                    <!-- <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">Security <i class="caret"></i></a>
                                        <ul class="dropdown-menu">
                                            <li><?php //=Html::a('Backup', Url::toRoute('/backup/index')) ?></li>
                                            <li><?php  //=Html::a('Synchronize', Url::toRoute('/synchronize/index')) ?></li>
                                        </ul>
                                    </li> -->
                                    <?php //endif; ?>
                                    <li class="dropdown user user-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                            <i class="glyphicon glyphicon-user"></i>
                                            <span><?= Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                                        </a>
                                        <ul class="dropdown-menu">
                                            <!-- User image -->
                                            <li class="user-header bg-light-blue">
                                                <img alt="admin" src="<?php echo Url::to('/image/avatar5.png');?>">
                                                <?php
													/*<span><?= Yii::$app->globalfunc->getSatker()->inst_nama; ?></span>
													echo Gravatar::widget([
														'email'   => \Yii::$app->user->identity->profile->gravatar_email,
														'options' => ['alt' => \Yii::$app->user->identity->username],
														'size'    => 128
													]); */
												?>
                                                <p>
                                                    <?= Yii::$app->user->identity->username ?>
                                                    <small><?= Yii::$app->user->identity->email ?></small>
                                                </p>
                                            </li>
                                            <!-- Menu Footer-->
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
                            <a href="/pidum/spdp/index"><img alt="admin" src="<?php echo Url::to('/image/text_header_pidum.png');?>"></a>
                            <span style="color:white;margin-left:16px;font-size:14px;"><strong><?= Yii::$app->globalfunc->getSatker()->inst_nama; ?></strong></span>
                        </h5>
                    </nav>
                </header>
                <!-- Left side column. contains the logo and sidebar -->
                <aside class="main-sidebar">

                    <?php
						$session = Yii::$app->session;
						$callback = function($menu) {
							//$data = eval($menu['data']);
							return [
								'label' => (empty($menu['route']) ?'<i class="fa fa-chevron-circle-right">' : '<i class="fa fa-angle-right">').'</i>' . $menu['name'],
								'url' => $menu['route'],
                                // 'data-toggle' => $menu['keterangan'],
								'items' => $menu['children'],
								'active' => $menu['active'],
								'options' =>['title' => $menu['keterangan']]
							];
						};
						/*if($session->has('id_perkara')){
							$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback,true,'PIDUM');
						}else{
							$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, null, $callback,true,'PIDUM3');
						}*/
                        //echo '<pre>';print_r($callback);exit;
						$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id;
                                                if ($session->has('id_perkara'))
                                                {
							$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PIDUM', $session['id_perkara'], $urlnya);
						}else
                        {
							$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PIDUM', $session['id_perkara'], $urlnya);
						}
                        //print_r($items);
						echo SideNav::widget([
							'encodeLabels' => false,
							'options' => ['class' => 'sidebar-menu'],
							'items' => $items,
						]);
                    ?>

                </aside>

                <!-- Right side column. Contains the navbar and content of the page -->
                <div class="content-wrapper">
                    <!-- Content Header (Page header) -->
                    <section class="content-header" style="padding-bottom:2px;">
                        <h1 style="margin-left:15px;">
                            <?= $this->title ?>
                            <small><?= $this->subtitle ?></small>
                            <?php   $id_perkara             = $session->get('id_perkara');
                                    $id_berkas              = $session->get('id_berkas');
                                    $no_register_perkara    = $session->get('no_register_perkara');
                                    $no_reg_tahanan         = $session->get('no_reg_tahanan');
                                    $no_pengantar           = $session->get('no_pengantar');
                                    $no_akta                = $session->get('no_akta');
                                    $no_eksekusi            = $session->get('no_eksekusi');
                                    //echo '<pre>';print_r($no_eksekusi);exit;

                                if(isset($no_eksekusi)){
                                    $header_1 = 'Nomor Register Perkara : ';
                                    $isi_1    = $no_register_perkara;
                                    $header_2 = '  Tanggal Diterima';
                                    $isi_2    = Yii::$app->globalfunc->ViewIndonesianFormat(PdmTahapDua::findOne(['no_register_perkara'=>$no_register_perkara])->tgl_terima) ;
                                    $header_3  = '  Terpidana : ';
                                    $isi_3    = Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $no_reg_tahanan) ;
                                }elseif(isset($no_akta)){
                                    $header_1 = 'Nomor Register Perkara : ';
                                    $isi_1    = $no_register_perkara;
                                    $header_2 = '  Tanggal Diterima';
                                    $isi_2    = Yii::$app->globalfunc->ViewIndonesianFormat(PdmTahapDua::findOne(['no_register_perkara'=>$no_register_perkara])->tgl_terima) ;
                                    $header_3  = '  Terpidana : ';
                                    $isi_3    = Yii::$app->globalfunc->GetNamaTahananT2($no_register_perkara, $no_reg_tahanan) ;
                                }elseif(isset($no_register_perkara)) {
                                    $header_1 = 'Nomor Register Perkara : ';
                                    $isi_1    = substr($no_register_perkara,strlen($no_register_perkara)-1,1)=='^' ? 'Belum Di Input' : $no_register_perkara ;
                                    $header_2 = '  Tanggal Diterima';
                                    $isi_2    = Yii::$app->globalfunc->ViewIndonesianFormat(PdmTahapDua::findOne(['no_register_perkara'=>$no_register_perkara])->tgl_terima) ;
                                    $header_3  = '  Terdakwa : ';
                                    $isi_3    =  Yii::$app->globalfunc->GetHlistTerdakwaT2($no_register_perkara) ;
                                }elseif(isset($no_pengantar)) {
                                    $header_1 = 'Nomor Berkas : ';
                                    $isi_1    = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->no_berkas;
                                    $header_2 = '  Tanggal Berkas';
                                    $isi_2    = Yii::$app->globalfunc->ViewIndonesianFormat(PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->tgl_berkas) ;
                                    $header_3  = '  Terdakwa : ';
                                    $isi_3    =  Yii::$app->globalfunc->GetHlistTerdakwaPengantar($no_pengantar) ;
                                }elseif(isset($id_berkas)) {
                                    $header_1 = 'Nomor Berkas : ';
                                    $isi_1    = PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->no_berkas;
                                    $header_2 = '  Tanggal Berkas';
                                    $isi_2    = Yii::$app->globalfunc->ViewIndonesianFormat(PdmBerkasTahap1::findOne(['id_berkas'=>$id_berkas])->tgl_berkas) ;
                                    $header_3  = '  Tersangka : ';
                                    $isi_3    =  Yii::$app->globalfunc->GetHlistTerdakwaBerkas($id_berkas) ;
                                }elseif(isset($id_perkara)) {
                                    $header_1 = 'Nomor SPDP : ';
                                    $isi_1    = PdmSpdp::findOne($id_perkara)->no_surat;
                                    $header_2 = '  Tanggal Dikeluarkan';
                                    $isi_2    = $session->get('tgl_perkara');
                                    $header_3  = '  Tanggal Diterima : ';
                                    $isi_3    =  $session->get('tgl_terima');
                                }else{
                                    $header_1 = '';
                                    $isi_1    = '';
                                    $header_2 = '';
                                    $isi_2    = '';
                                    $header_3 = '';
                                    $isi_3    = '';
                                }
                            ?>

							<?php //if(Yii::$app->session->get('nomor_perkara')!=''){ ?>
							<br/>
							<a style="color:black;" ><!-- href="/pidum/spdp/update2?id=<?php echo Yii::$app->session->get('id_perkara'); ?>" -->
							<font size="3pt" ><?= $header_1 ?> </font>
							<font size="3pt" color="#EB7310"><b>
								<?php echo  $isi_1; //Yii::$app->session->get('nomor_perkara'); ?></b>
							</font>
							<font size="3pt" > <?= $header_2 ?> </font>
							<font size="3pt" color="#EB7310"><b>
								<?php echo "&nbsp;&nbsp;&nbsp;".$isi_2;//Yii::$app->session->get('tgl_perkara'); ?></b>
							</font>
                            <font size="3pt" > <?= $header_3 ?> </font>
    							<font size="3pt" color="#EB7310"><b>
    								<?php echo $isi_3;//echo "&nbsp;&nbsp;&nbsp;".Yii::$app->session->get('tgl_terima').$session->get('no_register_perkara'); ?></b>
    						</font>
							</a>
							<?php //} ?>
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

                        <?php foreach (Yii::$app->session->getAllFlashes() as $message):; ?>
                            <?php
                            echo Growl::widget([
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

                        <?/*= Alert::widget() */?>
                        <?= $content ?>
            <?php  
                        //echo '<pre>';
            // print_r($items);

            ?>
                    </section>
                    <!-- /.content -->

                </div>
                <!-- /.content-wrapper -->
                <footer class="main-footer">

                    <strong style="color:#5b5b5b;font-size: 12px;font-weight: bold;"> © Copyright 2015 Simkari CMS<small style="color:#1c7aa9;font-size: 12px;font-weight: normal;"> &nbsp;: : &nbsp;Kejaksaan Republik Indonesia</small></strong>
                </footer>
            </div>
            <div class="modal-loading-new"></div>
            <!-- ./wrapper -->

            <?php

            // echo '<h1>'.$_SESSION['id_perkara'].'</h1>';
            if($_SESSION['id_perkara']!='')
            {
              // $NextProcces = array(ConstSysMenuComponent::Hukum );
              // echo ('<h1> fsdfasdfasdfa'.Yii::$app->globalfunc->getNextProcces($_SESSION['id_perkara'],$NextProcces).'</h1>');
            }
            $this->endBody() ?>



        </body>
        <?php




        $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $actual_link = explode('/', $actual_link);
        $back_link =  '/'.$actual_link[3].'/'.$actual_link[4];

        if($actual_link[4]!='spdp'&&($actual_link[5]=='index'||$actual_link[5]==''||substr($actual_link[5],0,6)=='ceklis'))
        {
            $back_link =  '/'.$actual_link[3].'/spdp/update2?id='.$_SESSION['id_perkara'];
        }
        else if($actual_link[4]!='spdp'&&($actual_link[5]=='pdm-berkas-tahap1'||substr($actual_link[5],0,8)=='pendapat'))
        {
            $back_link = '/pidum/pdm-berkas-tahap1/ceklis';
        }

		if($actual_link[4]=='pdm-penetapan-barbuk')
        {
            $back_link =  '/pidum/pdm-penetapan-barbuk/index';
        }

        ?>
        <a title="Kembali Ke SPDP" id="backSpdp" href="<?php echo $back_link ?>" class="btn btn-primary btn-m glyphicon glyphicon-backward "> Kembali </a>
        <?php //} ?>
    </html>
    <?php
    $js = <<< JS

    $(document).ready(function(){

        // var title =  '$this->title';
        // if( title != 'SPDP' && title != 'Tambah SPDP' )
        // {
        //    // $('body').addClass('fixed sidebar-collapse');
        //    //$('a.sidebar-toggle').remove();
        // }
        // // $('body').addClass('fixed sidebar-collapse');
        // // $('a.sidebar-toggle').remove();
        var a = $('.sub-menu');

        a.each(function(){
            var href = $(this).attr('href');
            if(href != '#'){
                $(this).css('font-weight', 'bold');
				$(this).css('title','oke');
            }

            var text = $(this).text();
            $(this).attr('title',text); 
        });

        var b = $('.kv-toggle');
        b.each(function(){
            var href = $(this).attr('href');
            if(href != '#'){
                $(this).css('font-weight', 'bold');
                $(this).css('title','oke');
            }
            var text = $(this).text();
            $(this).attr('title',text);
        });

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

    $('.sidebar-menu').slimScroll({
        height: '571px'
    });
var body = $("body");

$(document).on({

        ajaxStart: function() { body.addClass("loading");    },
        ajaxSuccess: function() { body.removeClass("loading"); },
        submit  : function(){ body.addClass("loading");}

});


document.body.style.zoom="90%"

JS;
    $this->registerJs($js);
    ?>
    <?php $this->endPage() ?>

<?php }
?>
