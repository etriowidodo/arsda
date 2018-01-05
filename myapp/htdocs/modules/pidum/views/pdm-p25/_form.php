<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use yii\bootstrap\Modal;
use kartik\builder\Form;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP25 */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'p25-form',
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
            <div class="col-md-12">
                <div class="form-group">
                    <label for="nomor" class="control-label col-md-2">Nomor Surat :</label>
                    <div class="col-md-3">
                        <?= $form->field($model, 'no_surat') ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header">
                <span class="pull-right"><a class="btn btn-primary" data-toggle="modal" data-target="#m_jpu"><i class="glyphicon glyphicon-user"></i> Tambah JPU</a></span>
                <h3 class="box-title">
                    Jaksa
                </h3>
            </div>
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
                    // if (!$model->isNewRecord) {
                    //     foreach ($modelJaksaSaksi as $key => $value) {
                    //         ?>
                    //         <tr id='trJPU-<?= $value->nip ?>'>
                    //             <td><input type="text" class="form-control" name="no_urut[]" style="width: 50px;" value="<?= !empty($value->no_urut) ? $value->no_urut : ($key + 1); ?>" > </td>
                    //             <td><input type="text" class="form-control" name="txtnip[]" style="width:100px;" readonly="true" value="<?= !empty($value->peg_nip_baru) ? $value->peg_nip_baru : $value->nip ?>"> </td>
                    //             <td><input type="text" class="form-control" name="txtnama[]" style="width:200px;" readonly="true" value="<?= $value->nama ?>"> </td>
                    //             <td><input type="text" class="form-control" name="txtpangkat[]" style="width:130px;" readonly="true" value="<?= $value->pangkat ?>"> </td>
                    //             <td><input type="text" class="form-control" name="txtjabatan[]" style="width:420px;" readonly="true" value="<?= $value->jabatan ?>"> </td>
                    //             <td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>
                    //         </tr>
                    //         <?php
                    //     }
                    // }
                    ?>
                </tbody>
            </table>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header">
                <div class="form-group">

                    <div class="col-md-7">

                        <?php
                        // echo Form::widget([
                        //     'model' => $model,
                        //     'form' => $form,
                        //     // 'columns' => 2,
                        //     'attributes' => [
                        //         'id_tersangka' => [
                        //             'label' => 'Tersangka',
                        //             'labelSpan' => 4,
                        //             'attributes' => [
                        //                 'id_tersangka' => [
                        //
                        //                     'type' => Form::INPUT_DROPDOWN_LIST,
                        //                     'items' => ArrayHelper::map(\app\modules\pidum\models\VwTerdakwa::find()->where("id_perkara = :idPerkara", [":idPerkara" => $modelSpdp->id_perkara])->all(), 'id_tersangka', 'nama'),
                        //                     'options' => [
                        //                         'options' => [
                        //                         ],
                        //                         'prompt' => 'Pilih Tersangka'
                        //                     ],
                        //                 //    'columnOptions' => ['colspan' => 3],
                        //                 ]
                        //             ],
                        //         ],
                        //     ]
                        // ]);
                        ?>

                    </div>
                </div>
                <div class="form-group">

                    <div class="col-md-7">

<?php
echo Form::widget([
    'model' => $model,
    'form' => $form,
    'columns' => 2,
    'attributes' => [
        'dikeluarkan' => [
            'label' => 'Di keluarkan di',
            'labelSpan' => 4,
            'columns' => 2,
            'attributes' => [
                'dikeluarkan' => [

                    'type' => Form::INPUT_TEXT,
                    'options' => [
                        'value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst,
                        'options' => [
                        ],
                    ],
                ],
                'tgl_surat' => [
                    'type' => Form::INPUT_WIDGET,
                    'widgetClass' => '\kartik\datecontrol\DateControl',
                    'options' => [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                        'pluginOptions' => [
                        'autoclose' => true,
                        'placeholder' => 'Tanggal Dikeluarkan'
                            ]
                        ],
                    ],
                ]
            ],
        ],
    ]
]);
?>
    </div>
    </div>

    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P25, 'id_table' => $model->id_p25]) ?>
    </div>
    </div>

        <div class="box-footer" style="text-align: center;">
<?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                <?php if (!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-p25/cetak?id_p25=' . $model->id_p25]) ?>">Cetak</a>
<?php endif ?>
        </div>

        <!--
            <div class="box-footer">
                <button class="btn btn-primary" type="submit">Submit</button>
                <button class="btn btn-primary" type="submit">Batal</button>
                <button class="btn btn-primary" type="submit">Cetak</button>
            </div>
        -->
<?php ActiveForm::end(); ?>

    </div>
</div>
</section>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
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

<?php $this->registerJs("
    $(document).ready(function(){
   $(document).on('click', 'button.removebutton', function () {

     $(this).closest('tr').remove();
     return false;
 });


}); ", \yii\web\View::POS_END); ?>
<?php
$script = <<< JS
    $(document).on('click', 'a#btn_hapus', function () {
        $(this).parent().parent().remove();
        return false;
    });

    $('.tambah-dasar').click(function(){
        $('#table_p25_dasar').append('<tr><td width="5%"><button type="button"  class="removebutton btn btn-danger delete"></button></td><td><textarea rows="2" class="form-control col-md-10" name="dasar[]" ></textarea></td></tr>'

        );
    });

    $('.tambah-pertimbangan').click(function(){
        $('#table_p25_pertimbangan').append('<tr><td width="5%"><button type="button"  class="removebutton btn btn-danger delete"></button></td><td><textarea rows="2" class="form-control col-md-10" name="pertimbangan[]"></textarea></td></tr>'

        );
    });

    $('#pilih-jpu').click(function () {

        $('input:checkbox:checked').each(function (index) {
            var value = $(this).val();
            var data = value.split('#');
            var trCount = $("#gridJPU tr").length;

            var nipBaruValue = [];
            $("input[name='txtnip[]']").each(function(){
                nipBaruValue.push($(this).val());
            });
            if(jQuery.inArray(data[4], nipBaruValue) > -1) {
                console.log(nipBaruValue);
                console.log(data[4]);
                $('input:checkbox').prop('checked', false);
                alert(data[1] + ' Sudah terpilih');return false;
            }else{
                $('#gridJPU').append(
                    '<tr id="trJPU-'+data[0]+'">' +
                    '<td><input type="text" name="no_urut[]" style="width:50px;" class="form-control" value="'+(trCount)+'"></td>' +
                    '<td><input type="text" class="form-control" name="txtnip[]" readonly="true" value="' + data[4] + '"> </td>' +
                    '<td><input type="text" class="form-control" name="txtnama[]" readonly="true" value="' + data[1] + '"> </td>' +
                    '<td><input type="text" class="form-control" name="txtpangkat[]" readonly="true" value="' + data[2] + '"> </td>' +
                    '<td><input type="text" class="form-control" name="txtjabatan[]" readonly="true" value="' + data[3] + '"> </td>' +
                    '<td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
                    '</tr>'
                );
                $('#m_jpu').modal('hide');
            }

        });
    });
JS;
$this->registerJs($script);
?>
