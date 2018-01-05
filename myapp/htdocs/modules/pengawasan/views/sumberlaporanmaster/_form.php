<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="sumber-laporan-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div>
        <?php
        if(!$model->isNewRecord){
            echo $form->field($model, 'id_sumber_laporan')->hiddenInput();
            //echo $form->field($model, 'id_irmud')->textInput(['maxlength' => true]);
        }
        ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Sumber Laporan</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'nama_sumber_laporan')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Akronim</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'akronim')->textInput(['maxlength' => true]) ?>
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