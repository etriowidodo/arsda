<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB16Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b16-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_b16') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'sifat') ?>

    <?= $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'di_kepada') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_tersangka') ?>

    <?php // echo $form->field($model, 'pelaksanaan_lelang') ?>

    <?php // echo $form->field($model, 'tgl_lelang') ?>

    <?php // echo $form->field($model, 'total') ?>

    <?php // echo $form->field($model, 'bank') ?>

    <?php // echo $form->field($model, 'ba_penitipan') ?>

    <?php // echo $form->field($model, 'tgl_ba') ?>

    <?php // echo $form->field($model, 'no_persetujuan') ?>

    <?php // echo $form->field($model, 'tgl_persetujuan') ?>

    <?php // echo $form->field($model, 'kantor_lelang') ?>

    <?php // echo $form->field($model, 'no_risalan') ?>

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
