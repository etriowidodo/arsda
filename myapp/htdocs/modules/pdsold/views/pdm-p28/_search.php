<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP28Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p28-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p28') ?>

    <?= $form->field($model, 'id_berkas') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'pelimpahan') ?>

    <?= $form->field($model, 'tgl_apsapb') ?>

    <?php // echo $form->field($model, 'id_jaksa1') ?>

    <?php // echo $form->field($model, 'id_jaksa2') ?>

    <?php // echo $form->field($model, 'id_jaksa3') ?>

    <?php // echo $form->field($model, 'hakim1') ?>

    <?php // echo $form->field($model, 'hakim2') ?>

    <?php // echo $form->field($model, 'hakim3') ?>

    <?php // echo $form->field($model, 'panitera') ?>

    <?php // echo $form->field($model, 'penasehat') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
