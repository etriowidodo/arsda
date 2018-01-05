<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBaKonsultasiSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-ba-konsultasi-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'id_ba_konsultasi') ?>

    <?= $form->field($model, 'tgl_pelaksanaan') ?>

    <?= $form->field($model, 'nip_jaksa') ?>

    <?= $form->field($model, 'nama_jaksa') ?>

    <?php // echo $form->field($model, 'jabatan_jaksa') ?>

    <?php // echo $form->field($model, 'nip_penyidik') ?>

    <?php // echo $form->field($model, 'nama_penyidik') ?>

    <?php // echo $form->field($model, 'jabatan_penyidik') ?>

    <?php // echo $form->field($model, 'konsultasi_formil') ?>

    <?php // echo $form->field($model, 'konsultasi_materil') ?>

    <?php // echo $form->field($model, 'kesimpulan') ?>

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
