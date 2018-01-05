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
                        <div class="col-md-4">
                            <?php
                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'startDate' => '-101y',
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) {
                                            var tgl = $('#mstersangka-tgl_lahir-disp').val();
                                            var str = tgl.split('-');
                                            var firstdate=new Date(str[2],str[1],str[0]);
                                            var today = new Date();
                                            var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
                                            var age = parseInt(dayDiff);
                                            $('#umur').val(age+' tahun');
                                        }",
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <div class="col-md-2"><input type="text" class="form-control" id="umur"> </div>
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
                                    $identitas,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
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
                            <?php
                                 $JnsKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
                                echo  $form->field($modelTersangka, 'id_jkl')->dropDownList($JnsKelamin,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']) ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_agama')->dropDownList( $agama,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
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
                            echo $form->field($modelTersangka, 'id_pendidikan')->dropDownList( $pendidikan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
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
                            <?php echo $form->field($modelTersangka, 'warganegara')->dropDownList( $warganegara,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            ) ?>
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
            <?= $form->field($modelTersangka, 'id_tersangka')->hiddenInput() ?>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
            <?php if($modelTersangka->isNewRecord): ?>
                <a class="btn btn-warning" id="simpan-tersangka">Simpan</a> 
            <?php else: ?>
                <a class="btn btn-warning" id="ubah-tersangka">Ubah</a> 
            <?php endif; ?>
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
                    '<input type="text" name="MsTersangkaBaru[nama][]" value="'+$('#mstersangka-nama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tersangka][]" value="" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tmpt_lahir][]" value="'+$('#mstersangka-tmpt_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tgl_lahir][]" value="'+$('#mstersangka-tgl_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[jkl][]" value="'+$('#mstersangka-jkl').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[alamat][]" value="'+$('#mstersangka-alamat').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_identitas][]" value="'+$('#mstersangka-id_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_identitas][]" value="'+$('#mstersangka-no_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_hp][]" value="'+$('#mstersangka-no_hp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_agama][]" value="'+$('#mstersangka-id_agama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[warganegara][]" value="'+$('#mstersangka-warganegara').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[pekerjaan][]" value="'+$('#mstersangka-pekerjaan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[suku][]" value="'+$('#mstersangka-suku').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_pendidikan][]" value="'+$('#mstersangka-id_pendidikan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                '</td>' +
                '<td><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
            '</tr>'

        );
        currentValue ++;
        $('#m_tersangka').modal('hide');
    });

    $('#ubah-tersangka').click(function(){
        //console.log($("form").serialize());
        $.ajax({
            type: "POST",
            url: '/pdsold/pdm-p16a/update-tersangka?id='+$('#mstersangka-id_tersangka').val(),
            data: $("#tersangka-form").serialize(),
            success:function(data){
                console.log(data);
                alert('Data berhasil disimpan');
                $('#m_tersangka').modal('hide');
            },

        });
    });

    var tgl = $('#mstersangka-tgl_lahir-disp').val();
    if(tgl != ''){
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var today = new Date();
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#umur').val(age+' tahun');
    }
JS;
$this->registerJs($script);

ActiveForm::end();
?>
