<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use dmstr\web\AdminLteAsset;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
AdminLteAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>Simkari CMS</title>
    <?php $this->head() ?>
    <style type="text/css">
		.profile-img-card{
			box-shadow:0 0 5px 0 rgba(0, 0, 0, 0.64);
		}
    </style>
</head>
<body>
	<?php $this->beginBody() ?>
    <span style="color:#fff;"><?php echo $data; ?></span>
    <div class="header_login"><img src="<?php echo Url::to('/image/logo_kejagung_dasbort.png'); ?>"><br>Kejaksaan Republik Indonesia</div>
        
	<h1 style="text-align: center;margin: 0px;padding: 10px 0px 0px 0px;border-top: 1px solid #603205;">
    	<img src="<?php echo Url::to('/image/logo-cms-simkari-header.png'); ?>" style="margin-bottom:10px;">
	</h1>

	<?php echo $content; ?>
    <div footer style="text-align:center;color:#f2be6f;margin-top:10px;">© Copyright 2015 Simkari CMS<br>Kejaksaan Republik Indonesia</div>
	<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
