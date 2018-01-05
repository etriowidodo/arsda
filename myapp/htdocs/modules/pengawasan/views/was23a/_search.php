<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was23aSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="was23a-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_tingkat') ?>

    <?= $form->field($model, 'id_kejati') ?>

    <?= $form->field($model, 'id_kejari') ?>

    <?= $form->field($model, 'id_cabjari') ?>

    <?= $form->field($model, 'no_register') ?>

    <?php // echo $form->field($model, 'id_sp_was2') ?>

    <?php // echo $form->field($model, 'id_ba_was2') ?>

    <?php // echo $form->field($model, 'id_l_was2') ?>

    <?php // echo $form->field($model, 'id_was15') ?>

    <?php // echo $form->field($model, 'id_was_23a') ?>

    <?php // echo $form->field($model, 'no_was_23a') ?>

    <?php // echo $form->field($model, 'id_wilayah') ?>

    <?php // echo $form->field($model, 'id_level1') ?>

    <?php // echo $form->field($model, 'id_level2') ?>

    <?php // echo $form->field($model, 'id_level3') ?>

    <?php // echo $form->field($model, 'id_level4') ?>

    <?php // echo $form->field($model, 'kpd_was_23a') ?>

    <?php // echo $form->field($model, 'di') ?>

    <?php // echo $form->field($model, 'nip_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'nrp_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'nama_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'pangkat_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'golongan_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'jabatan_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'satker_pegawai_terlapor') ?>

    <?php // echo $form->field($model, 'tgl_was_23a') ?>

    <?php // echo $form->field($model, 'tgl_nota_dinas') ?>

    <?php // echo $form->field($model, 'tempat') ?>

    <?php // echo $form->field($model, 'sifat_surat') ?>

    <?php // echo $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'perihal') ?>

    <?php // echo $form->field($model, 'nip_penandatangan') ?>

    <?php // echo $form->field($model, 'nama_penandatangan') ?>

    <?php // echo $form->field($model, 'pangkat_penandatangan') ?>

    <?php // echo $form->field($model, 'golongan_penandatangan') ?>

    <?php // echo $form->field($model, 'jabatan_penandatangan') ?>

    <?php // echo $form->field($model, 'jbtn_penandatangan') ?>

    <?php // echo $form->field($model, 'upload_file') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'created_ip') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_ip') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'sk') ?>

    <?php // echo $form->field($model, 'tanggal_ba') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
