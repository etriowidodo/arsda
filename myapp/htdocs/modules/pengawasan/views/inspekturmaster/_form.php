<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="inspektur-model-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div>
        <?php
        if(!$model->isNewRecord){
            echo $form->field($model, 'id_inspektur')->hiddenInput();
        }
        ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Inspektur</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'nama_inspektur')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Kode Surat</label>
                <div class="col-md-1">
                    <?= $form->field($model, 'kode_surat')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>
    
</div>
    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
$(document).ready(function(){
    $(".control-label").hide();
});
</script>