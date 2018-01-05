<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapatSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-nota-pendapat-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'no_register_perkara') ?>

    <?= $form->field($model, 'jenis_nota_pendapat') ?>

    <?= $form->field($model, 'id_nota_pendapat') ?>

    <?= $form->field($model, 'kepada') ?>

    <?= $form->field($model, 'dari_nip_jaksa_p16a') ?>

    <?php // echo $form->field($model, 'dari_nama_jaksa_p16a') ?>

    <?php // echo $form->field($model, 'dari_jabatan_jaksa_p16a') ?>

    <?php // echo $form->field($model, 'dari_pangkat_jaksa_p16a') ?>

    <?php // echo $form->field($model, 'tgl_nota') ?>

    <?php // echo $form->field($model, 'perihal_nota') ?>

    <?php // echo $form->field($model, 'dasar_nota') ?>

    <?php // echo $form->field($model, 'pendapat_nota') ?>

    <?php // echo $form->field($model, 'flag_saran') ?>

    <?php // echo $form->field($model, 'saran_nota') ?>

    <?php // echo $form->field($model, 'flag_pentunjuk') ?>

    <?php // echo $form->field($model, 'petunjuk_nota') ?>

    <?php // echo $form->field($model, 'id_kejati') ?>

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