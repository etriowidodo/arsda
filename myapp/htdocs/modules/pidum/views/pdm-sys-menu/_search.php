<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmSysMenuSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-sys-menu-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'kd_berkas') ?>

    <?= $form->field($model, 'no_urut') ?>

    <?= $form->field($model, 'durasi') ?>

    <?= $form->field($model, 'keterangan') ?>

    <?php // echo $form->field($model, 'url') ?>

    <?php // echo $form->field($model, 'id__group_perkara') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'akronim') ?>

    <?php // echo $form->field($model, 'no_surat') ?>

    <?php // echo $form->field($model, 'id_menu') ?>

    <?php // echo $form->field($model, 'is_show') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
