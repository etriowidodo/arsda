<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\pengawasan\models\Kejati;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="kejari-master-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div>
        <?php
        if(!$model->isNewRecord){
            echo $form->field($model, 'id_kejari')->hiddenInput();
        }
        ?>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Kejari</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'nama_kejari')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Kejati</label>
                <div class="col-md-5">
                    <!--<?= $form->field($model, 'id_kejati')->textInput(['maxlength' => true]) ?>-->
                    <?php
                        echo $form->field($model, 'id_kejati')->dropDownList(
                                 ArrayHelper::map(Kejati::find()->all(), 'id_kejati', 'nama_kejati'), ['prompt' => '-- Pilih Kejati --'],['width'=>'40%']
                                //  print_r($x);
                       );   
                     ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Akronim</label>
                <div class="col-md-5">
                    <?= $form->field($model, 'akronim')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Lokasi Instansi</label>
                <div class="col-md-5">
                    <?= $form->field($model, 'inst_lokinst')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Alamat Lokasi Instansi</label>
                <div class="col-md-5">
                    <?= $form->field($model, 'inst_alamat')->textInput(['maxlength' => true]) ?>
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