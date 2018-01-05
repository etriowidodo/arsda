<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP49Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p49-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p49') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'dikeluarkan') ?>

    <?= $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'menimbang') ?>

    <?php // echo $form->field($model, 'mengingat') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

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
