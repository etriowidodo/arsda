<?php
/**
 * Created by PhpStorm.
 * User: rio
 * Date: 10/11/15
 * Time: 14:05
 */

use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'detil-b10-form',
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

<div class="modal-content" style="width: 980px;margin: 30px auto;">
    <div class="modal-header">
        <b>DAFTAR BARANG BUKTI</b>
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-sm-5">Jenis Barang Bukti</label>
                <div class="col-sm-4">
                    <?= $barbuk->nama ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Penerimaan Kejaksaan Tanggal</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'options' => [
                                'placeholder' => 'Tanggal Terima',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Pelimpahan ke PN Tanggal</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'tgl_limpah')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'options' => [
                                'placeholder' => 'Tanggal Limpah',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ]); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Diktum Tuntutan Pidana</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'diktum'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">No. Pututsan Pengadilan & Tanggal</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'no_putus'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Amar Putusan PN/PT/MA</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'amar_putus'); ?>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-5">Pelaksanaan Putusan Tanggal</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'tgl_plt_putus')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'options' => [
                                'placeholder' => 'Tanggal Pelaksanaan Putusan',
                            ],
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ]); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="form-group">
                <label class="control-label col-sm-2">Keterangan</label>
                <div class="col-sm-4">
                    <?= $form->field($model, 'keterangan')->textarea(['cols' => '6']); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer" style="text-align: center;">
        <?= $form->field($model, 'id_barbuk')->hiddenInput(['value' => $barbuk->id]) ?>
        <?= $form->field($model, 'id_perkara')->hiddenInput(['value' => \Yii::$app->session->get('id_perkara')]) ?>
        <a class="btn btn-warning" id="simpan-detil">Simpan</a>
    </div>
</div>

<?php
$js = <<< JS
$('#simpan-detil').click(function(){
        console.log($("form").serialize());
        $.ajax({
            type: "POST",
            url: '/pdsold/default/detil-b10?id='+$('#pdmdetailb10-id_barbuk').val(),
            data: $("form").serialize(),
            success:function(data){
                alert('Data berhasil disimpan');
                $('#m_detil').modal('hide');
            },

        });
    });

JS;
$this->registerJs($js);
?>

<?php ActiveForm::end(); ?>