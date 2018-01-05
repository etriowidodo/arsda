<?php

use app\assets\PdsoldAsset;
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
use app\components\GlobalConstMenuComponent;
use app\components\ConstSysMenuComponent;
use app\modules\pdsold\models\PdmP48;
use app\modules\pdsold\models\VwTerdakwaT2;
use app\modules\pdsold\models\PdmRp11;
use app\modules\pdsold\models\PdmTahapDua;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmSpdp;


if (Yii::$app->controller->action->id === 'login'){
    echo $this->render('wrapper-black', ['content' => $content]);
} else {
    $this->title = $this->title . Yii::$app->params['appName'];
	PdsoldAsset::register($this);
	AdminLteAsset::register($this);
?>

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
		opacity: 0.4!important;
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

<body class="skin-red fixed" data-tgl="<?php echo date("Y").",".date("m").",".date("d");?>">
	<?php $this->beginBody() ?>
	<div class="wrapper">

		<header class="main-header">
			<a href="<?= \Yii::$app->homeUrl ?>" class="logo">
            	<img alt="admin" src="<?php echo Url::to('/image/logo-cms-simkari-header.png');?>" style="margin-left:-31px;">
			</a>
            <nav class="navbar navbar-static-top" role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"><span class="sr-only">Toggle navigation</span></a>
				<?php if(!\Yii::$app->user->isGuest){ ?>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i><span><?= \Yii::$app->user->identity->username ?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header bg-light-blue">
                                    <img alt="admin" src="<?php echo Url::to('/image/avatar5.png');?>">
                                    <p><?= \Yii::$app->user->identity->username ?><small><?= \Yii::$app->user->identity->email ?></small></p>
                                </li>
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?= \yii\helpers\Url::to(['/user/settings/profile'])?>" class="btn btn-block btn-default">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?= \yii\helpers\Url::to(['/site/logout']) ?>" class="btn btn-block btn-default" data-method="post">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                	</ul>
                </div>
				<?php } ?>
                <h5 style="margin:0px;padding:0px;text-align:left;"><img alt="admin" src="<?php echo Url::to('/image/text_header_pidsus2.png');?>"></h5>
			</nav>
		</header>
		
        <aside class="main-sidebar">
		<?php
			$session = Yii::$app->session;
            $callback = function($menu) {
                return [
					'label' => (empty($menu['route']) ?'<i class="fa fa-chevron-circle-right">' : '<i class="fa fa-angle-right">').'</i>' . $menu['name'],
					'url' => (empty($menu['route'])?'#':$menu['route']),
					'items' => $menu['children'],
					'active' => $menu['active'],
					'options' =>['title' => $menu['keterangan']]
                ];
            };
			$urlnya = "/".Yii::$app->controller->module->id."/".Yii::$app->controller->id."/".Yii::$app->controller->action->id;
			if ($session->has('id_perkara')){
				$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PIDSUS', $session['id_perkara'], $urlnya);
			} else{ 
				$items = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PIDSUS', $session['id_perkara'], $urlnya);
			}
			echo SideNav::widget([
				'encodeLabels' => false,
				'options' => ['class' => 'sidebar-menu'],
				'items' => $items,
			]);
		?>
        </aside>

        <div class="content-wrapper">
            <section class="content-header" style="padding-bottom:2px;">
                <h1 style="margin-left:15px;">
                    <?= $this->title ?>
                    <small><?= $this->subtitle ?></small>
					<?php   
						$id_perkara             = $session->get('id_perkara');
						$id_berkas              = $session->get('id_berkas');
						$no_register_perkara    = $session->get('no_register_perkara');
						$no_reg_tahanan         = $session->get('no_reg_tahanan');
						$no_pengantar           = $session->get('no_pengantar');
						$no_akta                = $session->get('no_akta');
						$no_eksekusi            = $session->get('no_eksekusi');

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
					<br />
                    <a style="color:black;" >
                        <font size="3pt"><?= $header_1 ?> </font>
                        <font size="3pt" color="#EB7310"><b><?php echo $isi_1;?></b></font>
                        <font size="3pt" > <?= $header_2 ?></font>
                        <font size="3pt" color="#EB7310"><b><?php echo "&nbsp;&nbsp;&nbsp;".$isi_2;?></b></font>
                        <font size="3pt" > <?= $header_3 ?> </font>
                        <font size="3pt" color="#EB7310"><b><?php echo $isi_3;?></b></font>
                    </a>
				</h1>
				<ol class="breadcrumb"><?= Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],])?></ol>
			</section>

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
        	<strong style="color:#5b5b5b;font-size: 12px;font-weight: bold;">&copy; Copyright 2016 Simkari CMS
            	<small style="color:#1c7aa9;font-size: 12px;font-weight: normal;"> &nbsp;: : &nbsp;Kejaksaan Republik Indonesia</small>
        	</strong>
        </footer>

	</div>
    <div class="modal-loading-new"></div>
	<?php $this->endBody() ?>
</body>
</html>
<?php 
$js = <<< JS
    $(document).ready(function(){
		$(".sub-menu").each(function(){
			var href = $(this).attr('href');
			if(href == '#'){
				$(this).css('color', '#999');
			}
		});
	
		$(".kv-toggle").each(function(){
			var href = $(this).attr('href');
			$(this).css('color', '#fff');
			if(href == '#'){
				$(this).css('color', '#999');
			}
		});

        /*var a = $('.sub-menu');
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
        });*/

    });
	function fixedBackButton(){
		var test = ($( window ).height()-($( window ).height()*6)/100)+'px';
		$('#backSpdp').css('position','fixed');
		$('#backSpdp').css('top',test);
		$('#backSpdp').css('right','0px');
		$('#backSpdp').css('z-index','99999999999999');
	}
	fixedBackButton();
	$( window ).resize(function(){
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

JS;
$this->registerJs($js);
?>
<?php $this->endPage() ?>
<?php } ?>
