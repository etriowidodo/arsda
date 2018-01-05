<?php

use app\assets\AppAsset;
use dmstr\web\AdminLteAsset;
use kartik\widgets\ActiveForm;
use yii\debug\Module;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;

AppAsset::register($this);
AdminLteAsset::register($this);

/* @var $this View */
/* @var $form ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = '';
$this->params['breadcrumbs'][] = $this->title;
?>
<p></p>
<div class="header_login">
    <img src="<?php echo Url::to('/image/logo_kejagung_dasbort.png'); ?>"><br>Kejaksaan Republik Indonesia
</div>
<h1 style="text-align: center;margin: 0px;padding: 10px 0px 0px 0px;border-top: 1px solid #603205;"><img src="<?php echo Url::to('/image/logo-cms-simkari-header.png'); ?>" style="margin-bottom:10px;"></h1>
<div class="form-box" id="login-box">

    <?php $this->off(View::EVENT_END_BODY, [Module::getInstance(), 'renderToolbar']); ?>
    <div class="header"><?= Html::encode($this->title) ?></div>




    <?php
    $form = ActiveForm::begin([
                'id' => 'login-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);
    ?>



    <div class="login-box" style="margin-top: 0px;">

        <div class="login-box-body">
            <h1 style="text-align: center;font-size: 24px;margin: 0px 0px 20px 0px;">Sign in</h1>





            <?=
            $form->field($model, 'username', [
                'addon' => ['prepend' => ['content' => '<span aria-hidden="true" class="glyphicon glyphicon-user"></span>']]
            ])->input('text', ['placeholder' => 'Username'])
            ?>

            <?=
            $form->field($model, 'password', [
                'addon' => ['prepend' => ['content' => '<span aria-hidden="true" class="glyphicon glyphicon-lock"></span>']]
            ])->input('password', ['placeholder' => 'Password'])
            ?>






            <?= $form->field($model, 'rememberMe')->checkbox() ?>
            <div class="footer" style="border-top:none;background: none;height: auto;padding-top: 0px;">
                <?= Html::submitButton('Login', ['class' => 'btn btn-block btn-primary', 'name' => 'login-button']) ?>
            </div>
            <!-- <form method="post" action="../../index2.html">
              <div class="form-group has-feedback">
                <input type="text" placeholder="Email" class="form-control">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
              </div>
              <div class="form-group has-feedback">
                <input type="password" placeholder="Password" class="form-control">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
              </div>
              <div class="row">
                <div class="col-xs-8">    
                  <div class="checkbox icheck">
                    <label>
                      <div class="icheckbox_square-blue" style="position: relative;" aria-checked="false" aria-disabled="false"><input type="checkbox" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: -20%; left: -20%; display: block; width: 140%; height: 140%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;"></ins></div> Remember Me
                    </label>
                  </div>                        
                </div><!-- /.col -->
            <!--<div class="col-xs-4">
              <button class="btn btn-primary btn-block btn-flat" type="submit">Sign In</button>
            </div><!-- /.col -->
            <!--</div>
          </form> -->

        </div><!-- /.login-box-body -->
    </div>
    <!-- <div class="body bg-gray">
        <p>Please fill out the following fields to login:</p>
    <?= $form->field($model, 'username') ?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'rememberMe')->checkbox() ?>
    </div>
    <div class="footer">

    <?= Html::submitButton('Login', ['class' => 'btn bg-olive btn-block', 'name' => 'login-button']) ?>

        <p><a href="#">I forgot my password</a></p>

    </div> -->
    <?php ActiveForm::end(); ?>
    <div footer style="text-align:center;color:#f2be6f;margin-top:10px;">© Copyright 2015 Simkari CMS<br>Kejaksaan Republik Indonesia</div>
</div>
