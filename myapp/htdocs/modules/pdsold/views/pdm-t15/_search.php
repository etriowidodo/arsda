<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT15Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-t15-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t15') ?>

    <?= $form->field($model, 'id_t8') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'sifat') ?>

    <?= $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'modus') ?>

    <?php // echo $form->field($model, 'kerugian') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
