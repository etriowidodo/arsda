<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT13Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-t13-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t13') ?>

    <?= $form->field($model, 'id_t8') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'sp_penahanan') ?>

    <?php // echo $form->field($model, 'penetapan') ?>

    <?php // echo $form->field($model, 'no_penahanan') ?>

    <?php // echo $form->field($model, 'tgl_penahanan') ?>

    <?php // echo $form->field($model, 'keperluan') ?>

    <?php // echo $form->field($model, 'menghadap') ?>

    <?php // echo $form->field($model, 'tempat') ?>

    <?php // echo $form->field($model, 'tgl_penetapan') ?>

    <?php // echo $form->field($model, 'jam') ?>

    <?php // echo $form->field($model, 'id_penandatangan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
