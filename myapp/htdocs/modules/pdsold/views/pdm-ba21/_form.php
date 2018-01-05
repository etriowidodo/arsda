<?php

use app\components\ConstDataComponent;
use app\modules\pdsold\models\PdmBa21;
use app\modules\pdsold\models\PdmMsStatusData;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmBa21 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-ba21-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'ba21-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false,
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 2,
                    'showLabels' => false
                ]
    ]);
    ?>

    <div class="box box-warning">
        <div class="box-header">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'wilayah')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Penyerahan Barang</label>
                        <div class="col-md-8">
                            <?php
                            $listData = PdmMsStatusData::findAll(['is_group' => ConstDataComponent::PenyerahanBrg]);
                            $new = array();
                            foreach ($listData as $key) {
                                $new = $new + [$key->id => $key->nama];
                            }
                            echo $form->field($model, 'id_msstatdata')
                                    ->dropDownList($new, ['prompt' => '---Pilih Status Barang---']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
//                                    'options' => [
//                                        'placeholder' => 'Tanggal Putusan Penjara',
//                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    //'endDate' => '+1y'
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Lokasi</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pihak Pertama</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'nama1', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $form->field($model, 'nip1')->hiddenInput() ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $form->field($model, 'pangkat1')->hiddenInput() ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $form->field($model, 'jabatan1')->hiddenInput() ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pihak Kedua</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'nama2', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu2']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $form->field($model, 'nip2')->hiddenInput() ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $form->field($model, 'pangkat2')->hiddenInput() ?>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="form-group">
                        <?= $form->field($model, 'jabatan2')->hiddenInput() ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Keperluan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'keperluan')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dimusnahkan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'dimusnahkan')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box box-warning">
        <div class="box-header">
            <h5 class="box-title"><a class="btn btn-primary addJPU2" data-toggle="modal" data-target="#m_jpu3">Jaksa Peneliti</a></h5>
        </div><br>
        <div class="form-group">
            <div class="col-md-12">
                <table class="table table-bordered" id="gridJPU">
                    <thead>
                        <tr>
                            <th>No. Urut</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>PANGKAT</th>
                            <th>JABATAN</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($modeljaksi != null) {
                            foreach ($modeljaksi as $key => $value) {
                                ?>
                                <tr id='trJPU-<?= $value->nip ?>'>
                                    <td style="width: 5%;"><input type="text" class="form-control" name="no_urut[]"  value="<?= !empty($value->no_urut) ? $value->no_urut : ($key + 1); ?>" > </td>
                                    <td style="width:15%;"><input type="text" class="form-control" name="txtnip[]" readonly="true" value="<?= !empty($value->peg_nip_baru) ? $value->peg_nip_baru : $value->nip ?>"> </td>
                                    <td style="width:20%;"><input type="text" class="form-control" name="txtnama[]" readonly="true" value="<?= $value->nama ?>"> </td>
                                    <td style="width:15%;"><input type="text" class="form-control" name="txtpangkat[]" readonly="true" value="<?= $value->pangkat ?>"> </td>
                                    <td style="width:40%;"><input type="text" class="form-control" name="txtjabatan[]" readonly="true" value="<?= $value->jabatan ?>"> </td>
                                    <td style="width: 5%;" id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>
                                </tr>
                                <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-ba21/cetak?id=' . $model->id_ba21]) ?>">Cetak</a>
        <?php endif ?>	
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pihak Pertama',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'm_jpu2',
    'header' => 'Data Jaksa Pihak Kedua',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu2', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'm_jpu3',
    'header' => 'Data Jaksa Peneliti',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu3', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>


<script type="text/javascript">

    window.onload = function () {
        $(document).on('click', 'a#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });



        $('#pilih-jpu').click(function () {

            $('input:checkbox:checked').each(function (index) {
                var value = $(this).val();
                var data = value.split('#');
                var trCount = $("#gridJPU tr").length;

                var nipBaruValue = [];
                $("input[name='txtnip[]']").each(function () {
                    nipBaruValue.push($(this).val());
                });
                if (jQuery.inArray(data[4], nipBaruValue) > -1) {
                    console.log(nipBaruValue);
                    console.log(data[4]);
                    $('input:checkbox').prop('checked', false);
                    alert(data[1] + ' Sudah terpilih');
                    return false;
                } else {
                    $('#gridJPU').append(
                            '<tr id="trJPU-' + data[0] + '">' +
                            '<td style="width: 5%;"><input type="text" name="no_urut[]" class="form-control" value="' + (trCount) + '"></td>' +
                            '<td style="width:15%;"><input type="text" class="form-control" name="txtnip[]" readonly="true" value="' + data[4] + '"> </td>' +
                            '<td style="width:20%;"><input type="text" class="form-control" name="txtnama[]" readonly="true" value="' + data[1] + '"> </td>' +
                            '<td style="width:15%;"><input type="text" class="form-control" name="txtpangkat[]" readonly="true" value="' + data[2] + '"> </td>' +
                            '<td style="width:40%;"><input type="text" class="form-control" name="txtjabatan[]" readonly="true" value="' + data[3] + '"> </td>' +
                            '<td style="width: 5%;" id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
                            '</tr>'
                            );
                    $('#m_jpu3').modal('hide');
                }

            });
        });

    };


</script>