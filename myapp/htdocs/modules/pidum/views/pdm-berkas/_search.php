<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBerkasSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-berkas-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'tgl_terima') ?>

    <?= $form->field($model, 'id_statusberkas') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
