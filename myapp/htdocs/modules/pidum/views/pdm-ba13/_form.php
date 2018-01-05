<?php

use app\modules\pidum\models\MsTersangka;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\PdmPasal;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA13 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'ba13-form',
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
                        ]
        );
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;">
            <div class="row">
                <div class="col-md-6 hide">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" readonly="true" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Pembuatan</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'tgl_pembuatan')->widget(DateControl::classname(), [
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
                        <label class="control-label col-sm-4">Jaksa Pelaksana</label>
                        <div class="col-sm-8">
                            <select class="form-control" name="jaksa_pelaksana">
                                <option value=""></option>                            
                            <?php
                                foreach ($modeljaksi as $value) {
                            ?>
                                <option <?php echo $value['nip'] == $modeljaksiChoosen->nip ? 'selected' : ''; ?> value="<?php echo $value['nip'] . "#" . $value['nama'] . "#" . $value['jabatan'] . "#" . $value['pangkat']; ?>">
                                    <?php echo $value['nama'];?>
                                </option>
                            <?php
                                }
                            ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary hide" style="border-color: #f39c12;">

            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <span class="pull-right hide">
                    <a class="btn btn-primary" data-toggle="modal" data-target="#m_jpu"><i class="glyphicon glyphicon-plus"></i> Tambah Jaksa Pelaksana</a>
                </span>
                <h3 class="box-title" style="margin-top: 5px;"><strong>JAKSA PELAKSANA</strong></h3>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;">
            <div style="border-color: #c7c7c7;" class="box-header with-border">
                <h3 class="box-title">
                    <!--<i class="glyphicon glyphicon-user"></i>--> <strong>TERDAKWA</strong>
                </h3>
            </div>

            <div class="col-md-12" style="margin-top: 15px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Nama</label>
                        <div class="col-sm-8">
                            <?php
                            echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp, $this);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="data-terdakwa">
                    <?php
                    if ($model->id_tersangka != null)
                        echo Yii::$app->globalfunc->getIdentitasTerdakwa($model->id_tersangka);
                    ?>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">No. Reg Perkara</label>
                        <div class="col-sm-8">
                            <?= $form->field($model, 'no_reg_perkara')->textInput(['value' => $modelRp9->no_urut, 'readonly' => true]) ?>
                        </div>
                    </div>
                </div>
            </div> 
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">No. Reg Tahanan</label>
                        <div class="col-sm-8">
                            <?= $form->field($model, 'no_reg_tahanan')->textInput(['id' => 'no_reg_tahanan', 'value' => $modelRt3->no_urut, 'readonly' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Ditahan Sejak</label>
                        <div class="col-sm-8">
                            <?=
                            $form->field($model, 'tgl_penahanan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'readonly' => true,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => ['placeholder' => 'Tanggal penahanan'],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>

<!--
        <div class="box box-primary" style="border-color: #f39c12;padding-bottom: 15px">
            <div style="border-color: #c7c7c7;" class="box-header with-border">
                <h3 class="box-title">
                   <strong>ACUAN</strong>
                </h3>
            </div>

            <div class="col-md-12" style="margin-top: 15px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="register_tahanan" class="control-label col-md-4">No. SP Kepala Kejaksaan</label>
                        <div class="col-md-8"><?= $form->field($modelSpdp, 'no_surat') ?></div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="register_perkara" class="control-label col-md-4">Tanggal Surat</label>
                        <div class="col-md-8"><?= $form->field($modelSpdp, 'tgl_surat') ?></div>
                    </div>
                </div>

            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="Status_tersangka" class="control-label col-md-4">Kepala Kejaksaan Asal</label>
                        <div class="col-md-8">
                            <span class="left">
                                <select class="form-control" id="jenis-pasal">
                                    <option value="tersangka">Tersangka</option>
                                    <option value="terdakwa">Terdakwa</option>
                                </select>

                            </span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
		-->


        <div class="box box-primary" style="border-color: #f39c12;padding-bottom: 15px">



            <div style="border-color: #c7c7c7;" class="box-header with-border">
                <h3 class="box-title">
                    <!--<i class="glyphicon glyphicon-user"></i>--> <strong>TINDAKAN</strong>
                </h3>
            </div>


            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="tindakan" class="control-label col-md-2">Diberikan</label>
                        <div class="col-md-10">
                                    
                        <?= $form->field($model, 'tindakan')->radioList(['pengeluaran terdakwa' => 'pengeluaran terdakwa', 'pengeluaran tersangka' => 'pengeluaran tersangka'],['inline'=>true]) ?>
                        
                        </div>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label for="register_perkara" class="control-label col-md-3">Atas Pasal</label>
                    <div class="col-md-2"></div>
                </div>-->
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_ms_loktahanan" class="control-label col-md-3">Dari Tahanan</label>
                        <div class="col-md-9">
                                    
                            <?= $form->field($model, 'id_ms_loktahanan')->radioList($modelLokTahanan, ['inline'=>true]) ?>
                    
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Terhitung Sejak</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'tgl_mulai')->widget(DateControl::classname(), [
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
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="kepala_rutan" class="control-label col-md-4">Kepala Rutan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'kepala_rutan')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>

        </div>
		<hr style="border-color: #c7c7c7;margin: 10px 0;">
		<div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord ): ?>
			<a class="btn btn-warning" href="<?= Url::to(['pdm-ba13/cetak?id='.$model->id_ba13]) ?>">Cetak</a>
		<?php endif ?>	
        
    </div>
<!--		
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            <button class="btn btn-primary" type="submit">Batal</button>
            <button class="btn btn-primary" type="submit">Cetak</button>
        </div>
		-->

    </div>



</section>



<?php ActiveForm::end(); ?>

</div>

<?php
/*Modal::begin([
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
Modal::end();*/
?>



<script type="text/javascript">


    window.onload = function () {



        $(document).on('click', 'a#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });


        $(document).on('click', 'a#btn_tambah_pertanyaan', function () {
            var i = $('table#gridTerdakwa tr:last').index() + 1;
            $('#gridPertanyaan').append(
                    '<tr>' +
                    '<td><a class="btn btn-danger delete hapus" id="btn_hapus">(-)</a></td>' +
                    '<td><input type="text" id="pertanyaan" class="form-control" name="pertanyaan[]" > </td>' +
                    '<td><input type="text" id="jaawaban" class="form-control" name="jawaban[]" > </td>' +
                    '</tr>'
                    );
            i++;
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
                        '<td id="tdJPU"><a class="btn btn-danger delete hapus" id="btn_hapus"></a></td>' +
                        '</tr>'
                        );

            });
            $('#m_jpu').modal('hide');
        });
        
        $('.cmb_terdakwa').change(function(){

        $.ajax({
            type: "POST",
            url: '/pidum/pdm-ba12/terdakwa',
            data: 'id_tersangka='+$('.cmb_terdakwa').val(),
            success:function(data){
                console.log(data);
                $('#data-terdakwa').html(
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Tempat Lahir</label>'+
                        '<div class="col-sm-4">'+data.tmpt_lahir+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Tanggal Lahir</label>'+
                        '<div class="col-sm-4">'+data.tgl_lahir+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Jenis Kelamin</label>'+
                        '<div class="col-sm-4">'+data.jns_kelamin+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Tempat Tinggal</label>'+
                        '<div class="col-sm-4">'+data.alamat+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Agama</label>'+
                        '<div class="col-sm-4">'+data.agama+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Pekerjaan</label>'+
                        '<div class="col-sm-4">'+data.pekerjaan+'</div>'+
                    '</div>'+
                    '<div class="form-group">'+
                        '<label class="control-label col-sm-2">Pendidikan</label>'+
                        '<div class="col-sm-4">'+data.pendidikan+'</div>'+
                    '</div>'
                );
                $('#no_reg_tahanan').val(data.no_reg_tahanan);

                var tglawal = new Date(data.ditahan_sejak);
                console.log(tglawal);
                function pad(s) {
                    return (s < 10) ? '0' + s : s;
                }
                var tgl = [pad(tglawal.getDate()), pad(tglawal.getMonth() + 1), tglawal.getFullYear()].join('-');
                var tgl2 = [tglawal.getFullYear(), pad(tglawal.getMonth() + 1), pad(tglawal.getDate())].join('-');
                console.log(tgl);
                console.log(tgl2);
                $("#pdmba12-tgl_penahanan-disp").val(tgl);
                $("#pdmba12-tgl_penahanan").val(tgl2);
            }
        });
    });

    };






</script>