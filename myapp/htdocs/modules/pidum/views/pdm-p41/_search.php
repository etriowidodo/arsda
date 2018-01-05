<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP41Search */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p41-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id_p41') ?>

    <?= $form->field($model, 'id_perkara') ?>

    <?= $form->field($model, 'no_surat') ?>

    <?= $form->field($model, 'sifat') ?>

    <?= $form->field($model, 'lampiran') ?>

    <?php // echo $form->field($model, 'kepada') ?>

    <?php // echo $form->field($model, 'di_kepada') ?>

    <?php // echo $form->field($model, 'dikeluarkan') ?>

    <?php // echo $form->field($model, 'tgl_dikeluarkan') ?>

    <?php // echo $form->field($model, 'id_tersangka') ?>

    <?php // echo $form->field($model, 'tgl_baca') ?>

    <?php // echo $form->field($model, 'pasal_bukti') ?>

    <?php // echo $form->field($model, 'kerugian') ?>

    <?php // echo $form->field($model, 'meninggal') ?>

    <?php // echo $form->field($model, 'luka') ?>

    <?php // echo $form->field($model, 'lain_lain') ?>

    <?php // echo $form->field($model, 'memberatkan') ?>

    <?php // echo $form->field($model, 'meringankan') ?>

    <?php // echo $form->field($model, 'tolak_ukur') ?>

    <?php // echo $form->field($model, 'usul_kajari') ?>

    <?php // echo $form->field($model, 'usul_kajati') ?>

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
