<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use app\modules\pengawasan\models\Wilayah;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tembusan-master-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="content-wrapper-1">
    <div class="box box-primary" style="padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Id Tembusan</label>
                <div class="col-md-2">
                    <?= $form->field($model, 'id_tembusan')->textInput(['maxlength'=>true]);?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Nama Tembusan</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'nama_tembusan')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">For Tabel</label>
                <div class="col-md-3">
                    <!--<?= $form->field($model, 'for_tabel')->textInput(['maxlength' => true]) ?>-->
                    <select class="form-control" id="tembusanmaster-for_tabel" name="TembusanMaster[for_tabel]">
                       
                        <option value="">-- Pilih --</option>
                        <option value="sp_was_1"<?php if($model['for_tabel']=='sp_was_1'){echo 'selected'; }else{echo '';} ?>>SP Was 1</option>
                        <option value="sp_was_2"<?php if($model['for_tabel']=='sp_was_2'){echo 'selected'; }else{echo '';} ?>>SP Was 2</option>
                        <option value="was_2"<?php if($model['for_tabel']=='was_2'){echo 'selected'; }else{echo '';} ?>>Was 2</option>
                        <option value="was_9"<?php if($model['for_tabel']=='was_9'){echo 'selected'; }else{echo '';} ?>>Was 9</option>
                        <option value="was_10"<?php if($model['for_tabel']=='was_10'){echo 'selected'; }else{echo '';} ?>>Was 10</option>
                        <option value="was_11"<?php if($model['for_tabel']=='was_11'){echo 'selected'; }else{echo '';} ?>>Was 11</option>
                        <option value="was_12"<?php if($model['for_tabel']=='was_12'){echo 'selected'; }else{echo '';} ?>>Was 12</option>
                        <option value="was_27_klari"<?php if($model['for_tabel']=='was_27_klari'){echo 'selected'; }else{echo '';} ?>>Was 27 Klarifikasi</option>
                    </select>
                    <div class="help-block" style="margin-bottom:15px;"></div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="col-md-2">Wilayah</label>
                <div class="col-md-3">
                    <?php //= $form->field($model, 'kode_wilayah')->textInput(['maxlength' => true]) ?>
                    <?=
                        $form->field($model, 'kode_wilayah')->dropDownList(
                                ArrayHelper::map(Wilayah::find()->orderBy('id_wilayah')->all(), 'id_wilayah', 'nama_wilayah'), ['prompt' => '-- Pilih --'],['width'=>'40%']
                        )
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
    $(".control-label").remove();
});
</script>