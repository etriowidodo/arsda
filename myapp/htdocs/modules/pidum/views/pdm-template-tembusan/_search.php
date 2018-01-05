<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmTemplateTembusanSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-template-tembusan-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_tmp_tembusan') ?>

    <?= $form->field($model, 'kd_berkas') ?>

    <?= $form->field($model, 'no_urut') ?>

    <?= $form->field($model, 'tembusan') ?>

    <?= $form->field($model, 'flag') ?>

    <?php // echo $form->field($model, 'keterangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
