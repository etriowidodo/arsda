<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa18Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba18-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_ba18') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'asal_satker') ?>

    <?= $form->field($model, 'no_sp') ?>

    <?= $form->field($model, 'tgl_sp') ?>

    <?php // echo $form->field($model, 'id_tersangka') ?>

    <?php // echo $form->field($model, 'barbuk') ?>

    <?php // echo $form->field($model, 'tindakan') ?>

    <?php // echo $form->field($model, 'no_reg_bukti') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
