<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\db\Query;
use yii\db\Command;
use kartik\datecontrol\DateControl;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MasterPeraturan */
/* @var $form yii\widgets\ActiveForm */
 
?>

<div class="master-peraturan-form"> 
    <?php $form = ActiveForm::begin(); ?>
    
    <div class="box box-primary">
        <div class="box-body" style="margin-top:10px;">
            <div class="col-md-12">
                <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-3">ID Peraturan</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'id_peraturan')->textInput()->label(false) ?>
                            <!--<input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding-right: 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Perja</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'tgl_perja',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'displayFormat' => 'dd-MM-yyyy',
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true,  
                            ]
                        ]
                    ])->label(false);?>
                            <!--<input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-3">Kode Surat</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'kode_surat')->textInput()->label(false) ?>
                            <!--<input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding-right: 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-3">Pasal</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'pasal')->textInput()->label(false) ?>
                            <!--<input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6" style="padding-left: 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Inactive</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'tgl_inactive',['addon' => ['prepend' => ['content'=>'<i class="glyphicon glyphicon-calendar"></i>']]])->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'displayFormat' => 'dd-MM-yyyy',
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true,  
                            ]
                        ]
                    ])->label(false);?>
                            <!--<input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">-->
                        </div>
                    </div>
                </div>
                <div class="col-md-6" style="padding-right: 0px;">
                    <div class="form-group">
                        <label class="control-label col-md-3">&nbsp;</label>
                        <div class="col-md-9">
                            &nbsp;
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-primary">
        <div class="panel-heading"><b>Isi Peraturan</b></div>
        <div class="box-body" style="margin-top:10px;">
            <div class="col-md-12">
                <div class="col-md-12" style="padding-left: 0px;">
                    <div class="form-group"> 
                        <div class="col-md-12">
                            <?= $form->field($model, 'isi_peraturan')->textarea(['class'=>'ckeditor','rows' => 3])->label(false) ?>
                            <!--<input id="dipamaster-tahun" class="form-control" name="DipaMaster[tahun]" maxlength="4" type="text">-->
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>

    <?//= $form->field($model, 'isi_peraturan')->textarea(['rows' => 6]) ?>
    <?//= $form->field($model, 'tgl_perja')->textInput() ?>
    <?//= $form->field($model, 'kode_surat')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'pasal')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'tgl_inactive')->textInput() ?>
    <?//= $form->field($model, 'created_by')->textInput() ?>
    <?//= $form->field($model, 'created_ip')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'created_time')->textInput() ?>
    <?//= $form->field($model, 'updated_ip')->textInput(['maxlength' => true]) ?>
    <?//= $form->field($model, 'updated_by')->textInput() ?>
    <?//= $form->field($model, 'updated_time')->textInput() ?>

    <div class="form-group" align="center">
        <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-floppy-o"> Simpan</i>' : '<i class="fa fa-floppy-o"> Simpan</i>', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <button type="button" class="btn btn-success" onClick="back();"><i class="fa fa-arrow-left"> Batal</i></button>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
    function back(){
        var url = window.location.protocol + "//" + window.location.host + "/pengawasan/master-peraturan";
        $(location).attr('href',url);
    }
</script>
