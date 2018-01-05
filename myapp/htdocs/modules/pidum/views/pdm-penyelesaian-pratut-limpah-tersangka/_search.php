<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpahTersangkaSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-penyelesaian-pratut-limpah-tersangka-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_pratut_limpah_tersangka') ?>

    <?= $form->field($model, 'id_ms_tersangka_berkas') ?>

    <?= $form->field($model, 'status_penahanan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
