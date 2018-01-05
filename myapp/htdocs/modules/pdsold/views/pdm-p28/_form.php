<?php

use app\modules\pdsold\models\PdmP28;
use kartik\datecontrol\DateControl;
use kartik\date\DatePickerAsset;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

DatePickerAsset::register($this);

/* @var $this View */
/* @var $model PdmP28 */
/* @var $form ActiveForm2 */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'p28-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'autoPlaceholder' => false
                        ],
                        'formConfig' => [
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                            'labelSpan' => 1,
                            'showLabels' => false
                        ]
    ]);
    ?>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">Nomor Perkara</label>
                <div class="col-md-3"><?= $form->field($model, 'no_surat')->textInput(['value' => $modelRp9->no_urut]) ?></div>
            </div>

            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">No RT 2</label>
                <div class="col-md-3"><?= $form->field($model, 'no_rt2') ?></div>
            </div>

            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">No RT 3</label>
                <div class="col-md-3"><?= $form->field($model, 'no_rt3')->textInput(['value' => $modelRt3]) ?></div>
            </div>

            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">No RB 1</label>
                <div class="col-md-3"><?= $form->field($model, 'no_rb1') ?></div>
            </div>

            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">No RB 2</label>
                <div class="col-md-3"><?= $form->field($model, 'no_rb2')->textInput(['value' => $modelRb2->no_urut]) ?></div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">Sidang Pengadilan</h3>
            </div>
            <div class="form-group">
                <label for="dasar" class="control-label col-md-2">Sidang Pengadilan</label>
            </div>

            <div class="input_fields_wrap">
                <a class="btn btn-info" id="tambah_sidang" style="margin-left:185px; margin-top:-25px;"> + </a>
                <?php if(!$model->isNewRecord): ?>
                    <?php foreach ($modelSidang as $key => $value): ?>
                        <div class="hapus<?php echo $key+1 ?>" style="margin-bottom:10px">
                            <div class="form-group">
                                <div class="col-sm-3">
                                    <?php
                                        echo $form->field($value, 'tgl_sidang')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'value' => $value->tgl_sidang,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'options' => [
                                                    'placeholder' => 'Tanggal Sidang',
                                                ],
                                                'pluginOptions' => [
                                                    'autoclose' => true
                                                ]
                                            ]
                                        ]);
                                    ?>
                                </div>
                                <div class="col-sm-3"><a class='btn btn-danger delete' onclick="hapusTanggal(<?php echo $key+1 ?>,'<?php echo $value['id_sidang'] ?>')"></a></div>
                            </div>
                         </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="form-group">
                        <div class="col-sm-3">
                            <?= $form->field($modelSidang, 'tgl_sidang[]')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => [
                                        'placeholder' => 'Tanggal Sidang',
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]); ?>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="sidang_pengadilan_append"></div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">Hakim Ketua</h3>
            </div>
            <div class="col-md-12"><br></div>
            <div class="form-group">
                <label for="hakim_ketua" class="control-label col-md-2">Hakim Ketua</label>
                <div class="col-md-3"><?= $form->field($model, 'hakim1') ?></div>
            </div>

            <div class="form-group">
                <label for="anggota" class="control-label col-md-2">Anggota</label>
                <div class="col-md-3"><?= $form->field($model, 'hakim2') ?></div>
            </div>

            <div class="form-group">
                <label for="anggota" class="control-label col-md-2">Anggota</label>
                <div class="col-md-3"><?= $form->field($model, 'hakim3') ?></div>
            </div><br>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">Panitera</h3>
            </div>
            <div class="col-md-12"><br></div>
            <div class="form-group">
                <label for="panitera" class="control-label col-md-2">Panitera</label>
                <div class="col-md-3">
                    <?= $form->field($model, 'panitera')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="form-group">
                <label for="penasehat" class="control-label col-md-2">Penasihat</label>
                <div class="col-md-3">
                    <?= $form->field($model, 'penasehat')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <!-- <input type="checkbox" name="check1" value="Penyerahan berkas tahap II lengkap"> Penyerahan berkas tahap II lengkap <br/> -->
        </div>
        <div class="hapus_sidang"></div>
                
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => 'btn btn-warning']) ?>
            <?php  if(!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-p28/cetak?id=' . $model->id_p28]) ?>">Cetak</a>
            <?php endif ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</section>
            <?php
            $script = <<< JS
                    var cloneCount = 1;
                    jQuery('.tgl_sidang').kvDatepicker({          //re attach
                        autoclose: true,
                        endDate: '+0',
                        onSelect: function(dateText) {
                            console.log(dateText)
                          }
                    });
                    var i = 1;
                    $('#tambah_sidang').click(function(){
                        jQuery('.tgl_sidang').kvDatepicker('remove');

                        $('.sidang_pengadilan_append').append(
                            '<div class="hapus_sidang_append'+i+'" style="margin-bottom:10px">'+
                                '<div class="form-group">'+
                                        '<div class="col-md-3">'+
                                            '<input type="text" class="tgl_sidang form-control" name="PdmSidang[tgl_sidang_baru][]" placeholder="Tanggal Sidang">'+
                                        '</div>'+
                                        '<div class="col-sm-3">'+
                                            '<a class="btn btn-danger delete" onclick=hapusTanggalAppend("'+i+'")></a>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'
                            
                            
                        );

                        jQuery('.tgl_sidang').kvDatepicker({  //re attach
                            // displayFormat: 'dd-mm-yyyy',
                            format: 'dd-mm-yyyy',
                            // saveFormat: 'yyyy-mm-dd',
                            autoclose: true,
                            endDate: '+0',
                            onSelect: function(dateText) {
                                console.log(dateText)
                              }
                        });
                        i++;
                    });
	
JS;
            $this->registerJs($script);
            ?>

<script>
    function hapusTanggalAppend(key)
    {
        $('.hapus_sidang_append'+key).remove();
    }
    
    function hapusTanggal(key, id_sidang)
    {
        $('.hapus'+key).remove();
        $('.hapus_sidang').append(
            '<input type="hidden" name="hapus_sidang_tanggal[]" value="'+id_sidang+'">'
        );
    }
</script>