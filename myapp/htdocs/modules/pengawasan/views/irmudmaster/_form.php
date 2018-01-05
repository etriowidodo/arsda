<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\InspekturModel;
?>

<div class="irmud-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div>
        <?php
        if(!$model->isNewRecord){
            echo $form->field($model, 'id_irmud')->hiddenInput();
            //echo $form->field($model, 'id_irmud')->textInput(['maxlength' => true]);
        }
        ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Irmud</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'nama_irmud')->textInput(['maxlength' => true]) ?>
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

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Kode Surat</label>
                <div class="col-md-2" style="width:100px;">
                    <?= $form->field($model, 'kode_surat')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Inspektur</label>
                <div class="col-md-3">
                    <?php
                        echo $form->field($model, 'id_inspektur')->dropDownList(
                                 ArrayHelper::map(InspekturModel::find()->all(), 'id_inspektur', 'nama_inspektur'), ['prompt' => '-- Pilih Inspektur --'],['width'=>'40%']
                                
                       );   
                     ?>
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