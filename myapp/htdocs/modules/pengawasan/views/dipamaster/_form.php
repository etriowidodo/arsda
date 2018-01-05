<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dipa-master-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div>
        <?php
        if(!$model->isNewRecord){
            echo $form->field($model, 'id_dipa')->hiddenInput();
        }
        ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Dipa</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'dipa')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Tahun</label>
                <div class="col-md-2" style="width: 108px;">
                    <?//= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>
                    <?php
                        $now=date('Y');
                        $beginYear=date('Y')-3;
                        for($i=$beginYear;$i<=$now;$i++){
                            $year[$i]=$i;
                        };
                    ?>
                    <?= $form->field($model, 'tahun')->dropDownList($year)?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Status</label>
                <div class="col-md-10">
                    <!--<input type="checkbox" id="dipamaster-is_aktif" name="DipaMaster[is_aktif]"> Aktif
                    -->
                    <?= $form->field($model, 'is_aktif')->checkbox()->label('Hi'); ?>

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
