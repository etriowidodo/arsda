<?php
	use app\assets\PidsusAsset;
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

	if(Yii::$app->controller->action->id === 'login'){
		echo $this->render('wrapper-black', ['content' => $content]);
	} else{
		$this->title = $this->title . Yii::$app->params['appName'];
		PidsusAsset::register($this);
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
                $items  = MenuHelper::getAssignedMenu(Yii::$app->user->id, $callback, 'PIDSUS', '', $urlnya);
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
                    <div>
                        <table>
                            <tr><td><?= $this->title ?> <small style="font-size:14px;"><?= $this->subtitle ?></small></td></tr>
                            <tr><td><?php echo ($this->params['idtitle'])?'<small style="color:#333; font-size:16px;">'.$this->params['idtitle'].'</small>':''; ?></td></tr>
                        </table>
                    </div>
        		</h1>        
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
<script>
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
});
</script>
</body>
</html>
<?php $this->endPage() ?>
<?php } ?>