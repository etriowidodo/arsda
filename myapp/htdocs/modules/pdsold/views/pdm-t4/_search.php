<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT4Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-t4-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t4') ?>

    <?= $form->field($model, 'id_p16') ?>

    <?= $form->field($model, 'id_loktahanan') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_buat') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_mulai') ?>

    <?php // echo $form->field($model, 'tgl_selesai') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
