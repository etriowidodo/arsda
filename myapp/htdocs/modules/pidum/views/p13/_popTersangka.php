<?php

/**
 * Created by PhpStorm.
 * User: rio
 * Date: 25/06/15
 * Time: 16:03
 */
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;

$form = ActiveForm::begin([
            'id' => 'tersangka-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ]
        ]);
?>
<div class="modal-content" style="width: 780px;margin: 30px auto;">
    <div class="modal-header">
        Pilih Tersangka
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'nama'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Tempat & Tgl Lahir</label>
                        <div class="col-md-4">
                            <?php echo $form->field($modelTersangka, 'tmpt_lahir'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Identitas & No</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_identitas')->dropDownList(
                                    ArrayHelper::map(\app\models\MsIdentitas::find()->all(), 'id_identitas', 'nama')
                            )
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php echo $form->field($modelTersangka, 'no_identitas') ?>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                            <?= $form->field($modelTersangka, 'id_jkl')->dropDownList(['1' => 'Pria', '2' => 'Wanita']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_agama')->dropDownList(
                                    ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama')
                            )
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No HP</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'no_hp') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_pendidikan')->dropDownList(
                                    ArrayHelper::map(\app\models\MsPendidikan::find()->all(), 'id_pendidikan', 'nama')
                            )
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'warganegara') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pekerjaan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Suku</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'suku') ?>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
            <a class="btn btn-primary" id="simpan-tersangka">Simpan</a>
        </div>
    </div>
</div>
<?php
$script = <<< JS
    var currentValue = 1;
    $('#simpan-tersangka').click(function(){
        $('#tbody_tersangka').append(
            '<tr id="tr_id'+currentValue+'">'+
                '<td>' +
                    '<input type="text" name="MsTersangka[nama][]" value="'+$('#mstersangka-nama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[tmpt_lahir][]" value="'+$('#mstersangka-tmpt_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[tgl_lahir][]" value="'+$('#mstersangka-tgl_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[jkl][]" value="'+$('#mstersangka-jkl').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[alamat][]" value="'+$('#mstersangka-alamat').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[id_identitas][]" value="'+$('#mstersangka-id_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[no_identitas][]" value="'+$('#mstersangka-no_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[no_hp][]" value="'+$('#mstersangka-no_hp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[id_agama][]" value="'+$('#mstersangka-id_agama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[warganegara][]" value="'+$('#mstersangka-warganegara').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[pekerjaan][]" value="'+$('#mstersangka-pekerjaan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[suku][]" value="'+$('#mstersangka-suku').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangka[id_pendidikan][]" value="'+$('#mstersangka-id_pendidikan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                '</td>' +
                '<td><a class="btn btn-danger btn-sm glyphicon glyphicon-remove hapus" onclick="hapusTersangka('+currentValue+')"></a></td>' +
            '</tr>'

        );
        currentValue ++;
        $('#m_tersangka').modal('hide');
    });
JS;
$this->registerJs($script);

ActiveForm::end();
?>
