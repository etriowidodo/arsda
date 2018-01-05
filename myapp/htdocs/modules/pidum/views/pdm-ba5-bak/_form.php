<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm ::begin(
                        [
                            'id' => 'b-a-5-form',
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
                <div class="col-md-6 hide">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly="true" value="<?php echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Pembuatan</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_pembuatan')->widget(DateControl::className(), [
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
        </div>


        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="box-header with-border hide">
                    <h5 class="box-title"><a class="btn btn-primary addJPU2" data-toggle="modal" data-target="#m_jpu"> TAMBAH JAKSA SAKSI</a></h5>
                </div><br>
                <div class="form-group">
                    <table class="table table-bordered" id="gridJPU">
                        <thead>
                            <tr>
                                <th>NIP</th>
                                <th>Nama</th>
                                <th>Pangkat</th>
                                <th>Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            //if (!$modeljaksi->isNewRecord) {
                                foreach ($modeljaksi as $key => $value) {
                                    ?>
                                    <tr id='trJPU'>
                                        <td><input type="text" class="form-control" name="txtnip[]" style="width:152px;" readonly="true" value="<?= $value->peg_nip_baru ?>"> </td>
                                        <td><input type="text" class="form-control" name="txtnama[]" style="width:200px;" readonly="true" value="<?= $value->nama ?>"> </td>
                                        <td><input type="text" class="form-control" name="txtpangkat[]" style="width:150px;" readonly="true" value="<?= $value->pangkat ?>"> </td>
                                        <td><input type="text" class="form-control" name="txtjabatan[]" style="width:430px;" readonly="true" value="<?= $value->jabatan ?>"> </td>
                                    </tr>
                                    <?php
                                }
                            //}
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h5 class="box-title">ALAT BUKTI</h5>
                </div><br>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Identitas Saksi</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'ket_saksi')->textarea(['rows' => 2]) ?>
                        </div>
                        <label class="control-label col-md-2">Keterangan Ahli</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'ket_ahli')->textarea(['rows' => 2]) ?>
                        </div>
                        <label class="control-label col-md-2">Surat</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'ket_surat')->textarea(['rows' => 2]) ?>
                        </div>
                        <label class="control-label col-md-2">Petunjuk</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'petunjuk')->textarea(['rows' => 2]) ?>
                        </div>
                        <label class="control-label col-md-2">Identitas Tersangka</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'ket_tersangka')->textarea(['rows' => 2]) ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h5 class="box-title">KESIMPULAN</h5>
                </div><br>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Tentang Hukum</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'hukum')->textarea(['rows' => 2]) ?>
                        </div>
                        <label class="control-label col-md-2">Butir-butir</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'butir') ?>
                        </div>
                        <label class="control-label col-md-2">Kesimpulan/Pernyataan</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'kesimpulan')->textarea(['rows' => 2]) ?>
                        </div>
                        <label class="control-label col-md-2">Primair (Pasal)</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'primair') ?>
                        </div>
                        <label class="control-label col-md-2">Subsidair (Pasal)</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'subsidair') ?>
                        </div>
                        <label class="control-label col-md-2">Subsidair Lebih (Pasal)</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'lebih_subsidair') ?>
                        </div>
                        <label class="control-label col-md-2">Keterangan Lain</label>
                        <div class="col-md-9">
                            <?= $form->field($model, 'keterangan_tambahan')->textarea(['rows'=>2]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dikeluarkan</label>
                        <div class="col-md-7">
                            <?= $form->field($model, 'dikeluarkan')->textInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst, 'readOnly' => false]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Tanggal Dikeluarkan</label>
                        <div class="col-md-7">
                            <?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
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
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jaksa Pembuat</label>
                        <div class="col-md-7">
                            <?php
                            echo $form->field($modeljapen, 'nama', [
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Mengetahui</label>
                        <div class="col-md-7">
                            <?php
                            $penandatangan = (new \yii\db\Query())
                                    ->select('peg_nik,nama')
                                    ->from('pidum.vw_penandatangan')
                                    //->where(['is_active' => '1'])
                                    ->all();
                            $list = ArrayHelper::map($penandatangan, 'peg_nik', 'nama');
                            echo $form->field($model, 'id_penandatangan')->dropDownList($list, ['prompt' => '---Pilih---'], ['label' => '']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="box-header with-border">
                    
                </div><br>
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-3">Status</label>
                        <div class="col-md-3">
                        <?php
                            $listCheckBerkas = ['1' => 'APB', '2' => 'APS', '3' => 'Penghentian'];
                            echo $form->field($model, 'id_msstatusdata')->dropDownList($listCheckBerkas);
                         ?>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>

        

    </div>
        <?= $form->field($modeljapen, 'nip')->hiddenInput() ?>
        <?= $form->field($modeljapen, 'jabatan')->hiddenInput() ?>
        <?= $form->field($modeljapen, 'pangkat')->hiddenInput() ?>
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php
            if (!$model->isNewRecord) {
                echo Html::a('Cetak', ['cetak', 'id' => $model->id_ba5], ['class' => 'btn btn-warning']);
            }
            ?>

        </div>
        <?php ActiveForm::end(); ?>


    </div>
</section>

<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Saksi',
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
    'header' => 'Data Jaksa Pembuat',
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




<script type="text/javascript">

    window.onload = function () {



        $(document).on('click', 'a#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });

        $('#pilih-jpu').click(function () {

            $('input:checkbox:checked').each(function (index) {
                //var keys = $('#gridKejaksaan').yiiGridView('getSelectedRows');
                // alert(keys);
                var value = $(this).val();
                var data = value.split('#');

                $('#gridJPU').append(
                        '<tr id="trjpu">' +
                        '<td><input type="text" class="form-control" name="txtnip[]" readonly="true" style="width:100px;" value="' + data[0] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtnama[]" readonly="true" style="width:250px;" value="' + data[1] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtpangkat[]" readonly="true" style="width:50px;" value="' + data[2] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtjabatan[]" readonly="true" style="width:480px;" value="' + data[3] + '"> </td>' +
                        '<td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
                        '</tr>'
                        );

            });
            $('#m_jpu').modal('hide');
        });
    };

    function pilihJPU(nip, nama, jabatan, pangkat) {

        $("#pdmjaksapenerima-nip").val(nip);
        $("#pdmjaksapenerima-nama").val(nama);
        $("#pdmjaksapenerima-jabatan").val(jabatan);
        $("#pdmjaksapenerima-pangkat").val(pangkat);
        $('#m_jpu2').modal('hide');
    }
</script>

