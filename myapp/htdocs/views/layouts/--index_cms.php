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
        <title>
        <?= Html::encode($this->title) ?>
        </title>
<?php $this->head() ?>
    </head>
    <body>
<?php $this->beginBody() ?>
        <p></p>

        <div class="header_login">
            <img src="<?php echo Url::to('/image/logo_kejagung_dasbort.png'); ?>"><br>Kejaksaan Republik Indonesia
        </div>
        
        <h1 style="text-align: center;margin: 0px;padding: 10px 0px 0px 0px;border-top: 1px solid #603205;"><img src="<?php echo Url::to('/image/logo-cms-simkari-header.png'); ?>" style="margin-bottom:10px;"></h1>

        <div class="container" style="width:900px;background:#fff;padding-top:15px;border-radius:4px;box-shadow: 0 0 6px 0 rgba(0, 0, 0, 0.75);">
            <div class="row">
                <div class="col-md-3">
                    <div class="box box-danger" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;">
                        <h3 class="box-title" style="text-align:center;color:#dd4b39;font-size:40px;margin:0px 0px 10px 0px;">PIDSUS</h3>
                        <img src="<?php echo Url::to('/image/pidsus-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #dd4b39;box-shadow:0 0 5px 0 rgba(0, 0, 0, 0.64);">
                        <p style="text-align:center;">Pidana Khusus</p>
                        <a href="pidsus/default/index" class="btn btn-block btn-danger" style="cursor:pointer;">Enter</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box box-danger" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#ce7e19;">
                        <h3 class="box-title" style="text-align:center;color:#f39c12;font-size:40px;margin:0px 0px 10px 0px;">PIDUM</h3>
                        <img src="<?php echo Url::to('/image/pidum-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #f39c12;box-shadow:0 0 5px 0 rgba(0, 0, 0, 0.64);">
                        <p style="text-align:center;">Pidana Umum</p>
                        <a href="pidum/spdp/index" class="btn btn-block btn-warning" style="cursor:pointer;">Enter</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box box-default" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#73a8de;">
                        <h3 class="box-title" style="text-align:center;color:#73a8de;font-size:40px;margin:0px 0px 10px 0px;">WAS</h3>
                        <img src="<?php echo Url::to('/image/was-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #3c8dbc;box-shadow:0 0 5px 0 rgba(0, 0, 0, 0.64);">
                        <p style="text-align:center;">Pengawasan</p>
                        <a href="pengawasan/dugaan-pelanggaran" class="btn btn-block btn-primary" style="cursor:pointer;">Enter</a>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="box box-default" style="padding:10px;box-shadow:0 0 11px 0 rgba(0, 0, 0, 0.29) inset;border-top-color:#00a65a;">
                        <h3 class="box-title" style="text-align:center;color:#00a65a;font-size:40px;margin:0px 0px 10px 0px;">SECURITY</h3>
                        <img src="<?php echo Url::to('/image/scurity-icon.jpg'); ?>" class="profile-img-card" style="border:4px solid #00a65a;box-shadow:0 0 5px 0 rgba(0, 0, 0, 0.64);">
                        <p style="text-align:center;">Keamanan</p>
                        <a href="wewenang" class="btn btn-block btn-success" style="cursor:pointer;">Enter</a>
                    </div>
                </div>
            </div>
        </div>
        <div footer style="text-align:center;color:#f2be6f;margin-top:10px;">© Copyright 2015 Simkari CMS<br>Kejaksaan Republik Indonesia</div>

        <?php $this->endBody() ?>

        <?php $this->endPage() ?>

