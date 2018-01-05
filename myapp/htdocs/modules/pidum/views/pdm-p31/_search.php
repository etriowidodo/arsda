<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p30-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p30') ?>

    <?= $form->field($model, 'no_perkara') ?>

    <?= $form->field($model, 'id_tersangka') ?>

    <?= $form->field($model, 'tgl_awal_rutan') ?>

    <?= $form->field($model, 'tgl_akhir_rutan') ?>

    <?php // echo $form->field($model, 'tgl_awal_rumah') ?>

    <?php // echo $form->field($model, 'tgl_akhir_rumah') ?>

    <?php // echo $form->field($model, 'tgl_awal_kota') ?>

    <?php // echo $form->field($model, 'tgl_akhir_kota') ?>

    <?php // echo $form->field($model, 'perpanjangan') ?>

    <?php // echo $form->field($model, 'tgl_perpanjangan') ?>

    <?php // echo $form->field($model, 'pengalihan') ?>

    <?php // echo $form->field($model, 'tgl_pengalihan') ?>

    <?php // echo $form->field($model, 'pencabutan') ?>

    <?php // echo $form->field($model, 'tgl_pencabutan') ?>

    <?php // echo $form->field($model, 'catatan') ?>

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
