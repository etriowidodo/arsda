<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB9Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b9-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_b9') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'tgl') ?>

    <?= $form->field($model, 'putusan_negeri') ?>

    <?= $form->field($model, 'tgl_pn') ?>

    <?php // echo $form->field($model, 'barbuk') ?>

    <?php // echo $form->field($model, 'putusan_tinggi') ?>

    <?php // echo $form->field($model, 'tgl_pt') ?>

    <?php // echo $form->field($model, 'no_ma') ?>

    <?php // echo $form->field($model, 'tgl_ma') ?>

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
