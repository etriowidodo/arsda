<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa6Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba6-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_t6') ?>

    <?= $form->field($model, 'id_ba6') ?>

    <?= $form->field($model, 'tgl_surat') ?>

    <?= $form->field($model, 'penetepan') ?>

    <?= $form->field($model, 'memerintahkan') ?>

    <?php // echo $form->field($model, 'isi_penetapan') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
