<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\InspekturModel;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kejagung-bidang-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2 hide">Id Kejagung Bidang</label>
                <div class="col-md-2">
                    <?php
                    if(!$model->isNewRecord){
                        echo $form->field($model, 'id_kejagung_bidang')->hiddenInput();
                    }
                    ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Kejagung Bidang</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'nama_kejagung_bidang')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Inspektur</label>
                <div class="col-md-3">
                    <!--<?= $form->field($model, 'id_inspektur')->textInput(['maxlength' => true]) ?>-->
                    <?php
                        echo $form->field($model, 'id_inspektur')->dropDownList(
                                 ArrayHelper::map(InspekturModel::find()->all(), 'id_inspektur', 'nama_inspektur'), ['prompt' => '-- Pilih Inspektur --'],['width'=>'40%']
                                //  print_r($x);
                       );   
                     ?>
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