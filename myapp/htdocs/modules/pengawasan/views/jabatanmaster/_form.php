<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\JabatanMaster;

?>

<div class="jabatan-master-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <!--<div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Jabatan</label>
                <div class="col-md-2">
                    <?php
                        $var=str_split($model['id_jabatan']);
                        
                       ?>
                    <select class="form-control" id="id_jabatan" name="JabatanMaster[id_jabatan]">
                        
                        <option value="">-- Pilih --</option>
                        <option value="0" <?php if($var[0]=='0'){echo 'selected'; }else{echo '';} ?>>Diri Sendiri</option>
                        <option value="1"<?php if($var[0]=='1'){echo 'selected'; }else{echo '';} ?>>Atas Nama</option>
                        <option value="2"<?php if($var[0]=='2'){echo 'selected'; }else{echo '';} ?>>PLT</option>
                        <option value="3"<?php if($var[0]=='3'){echo 'selected'; }else{echo '';} ?>>PLH</option>
                    </select>
                    <div class="help-block" style="margin-bottom:15px;"></div>
                </div>
            </div>
        
        </div>-->

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama</label>
                <div class="col-md-10">
                    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
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
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary', 'id'=> $model->isNewRecord ? 'btn-tambah-jabatan' : 'btn-ubah-jabatan']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
$(document).ready(function(){
    $(".control-label").hide();


    $("#btn-tambah-jabatan").click(function () {
        var sumber = $("#id_jabatan").val();
        if (sumber==''){
              bootbox.alert("Id Jabatan tidak boleh kosong");
              $("#id_jabatan").focus();
              return false;

            }
    });
});
</script>