<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapatT4Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-nota-pendapat-t4-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_perpanjangan') ?>

    <?= $form->field($model, 'id_nota_pendapat') ?>

    <?= $form->field($model, 'tgl_nota') ?>

    <?= $form->field($model, 'persetujuan') ?>

    <?= $form->field($model, 'id_kejati') ?>

    <?php // echo $form->field($model, 'id_kejari') ?>

    <?php // echo $form->field($model, 'id_cabjari') ?>

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