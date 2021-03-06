<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-t5-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t5') ?>

    <?= $form->field($model, 'id_p16') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'sifat') ?>

    <?= $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'perihal') ?>

    <?php // echo $form->field($model, 'tgl_surat') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'di') ?>

    <?php // echo $form->field($model, 'alasan') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
