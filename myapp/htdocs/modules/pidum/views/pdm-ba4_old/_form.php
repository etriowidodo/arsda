<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\db\Query;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">
    <?php
    $form = ActiveForm ::begin(
                    [
                        'id' => 'b-a-4-form',
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
                    <label class="control-label col-md-2">Tanggal Pembuatan</label>
                    <div class="col-md-3">
                        <?php
                        echo $form->field($model, 'tgl_ba')->widget(DateControl::classname(), [
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
                <div class="form-group">
                    <label class="control-label col-md-2">Tempat</label>
                    <div class="col-md-3"><?= $form->field($model, 'lokasi') ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Pemeriksaan</label>
                    <div class="col-md-5">
                        <?php
                        $new = [1 => 'Saksi', 2 => 'Ahli'];
                        echo $form->field($model, 'stat_pemeriksa')
                                //->radioList($new);
                                ->radioList($new, ['inline' => true]);
                        //$form->field($model, 'stat_pemeriksa')
                        ?>

                    </div>
                </div>
            </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h5 class="box-title">Jaksa Pemeriksa</h5>
            </div><br>
            <div class="form-group">
                <label for="id_berkas" class="control-label col-md-2">Jaksa Pemeriksa</label>
                <div class="col-md-4">
                    <?php
                        if(!$model->isNewRecord){
                            echo Html::dropDownList('jaksa_pemeriksa', $modelJaksiChoosen->nip,
                                ArrayHelper::map($modeljaksi, 'nip', 'nama'),
                                ['prompt' => 'Pilih Jaksa Pemeriksa', 'id' => 'dropdown', 'class' => 'form-control dropdown-jaksa']
                            );
                        }else{
                            echo Html::dropDownList('jaksa_pemeriksa', null,
                                ArrayHelper::map($modeljaksi, 'nip', 'nama'),
                                ['prompt' => 'Pilih Jaksa Pemeriksa', 'id' => 'dropdown', 'class' => 'form-control dropdown-jaksa']
                            );
                        }
                    ?>
                </div>
            </div>


            <!--            <div class="form-group" style="margin-left:-325px">
                            <label for="id_berkas" class="control-label col-md-4">Nomor</label>
                            <div class="col-md-2"><?php // $form->field($model, 'id_berkas')                                   ?></div>
                        </div>-->
            <!--            <div class="form-group" style="margin-left:-300px">
                            <label for="tgl_ba" class="control-label col-md-4" style="margin-left:-18px">Tanggal S.Perintah </label>
                            <div class="col-md-2" style="margin-left:1px">
            <?php /*
              echo $form->field($model, 'tgl_ba')->widget(DateControl::classname(), [
              'type' => DateControl::FORMAT_DATE,
              'ajaxConversion' => false,
              'options' => [
              'pluginOptions' => [
              'autoclose' => true
              ]
              ]
              ]); */
            ?>
                            </div>
                        </div> -->
        </div>
        <div class="box box-primary hide" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <br>
                <div class="form-group">
                    <label class="control-label col-md-2">SP. Kepala Kejaksaan</label>
                    <div class="col-md-3">
                        <input type="text" class="form-control" readonly="true" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                        <div class="help-block"></div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">No. SP</label>
                    <div class="col-md-3"><?= $form->field($model, 'no_sp') ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Tgl. SP</label>
                    <div class="col-md-3"><?php
                        echo $form->field($model, 'tgl_sp')->widget(DateControl::classname(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?></div>
                </div>
            </div>
        </div>
        
		<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="glyphicon glyphicon-user"></i> Tersangka
                </h3>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2">Nama</label>
                <div class="col-sm-4">
                    <?php
                        echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp, $this);
                    ?>
                </div>
            </div>
            <div id="data-terdakwa">
                <?php
                    if($model->id_tersangka != null)
                        echo Yii::$app->globalfunc->getIdentitasTerdakwa($model->id_tersangka);
                ?>

            </div>
        </div>
		
       <div class="box box-primary hide" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <br>
                <div class="form-group">
                    <label class="control-label col-md-2">No. Perkara</label>
                    <div class="col-md-3"><?= $form->field($model, 'no_perkara') ?></div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Tgl. Berkas Perkara</label>
                    <div class="col-md-3"><?php
                        echo $form->field($model, 'tgl_perkara')->widget(DateControl::classname(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?></div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="box-header with-border">
                <h5 class="box-title"><a class="btn btn-primary" id='btn_tambah_pertanyaan'><i class="glyphicon glyphicon-plus"></i>Pertanyaan dan Jawaban</a></h5>
            </div><br>
            <div class="form-group">
                <div class="col-md-11"  style="margin-left:10px">
                    <table class="table table-bordered" id="gridPertanyaan">
                        <thead>
                            <tr>
                                <th>Pertanyaan</th>
                                <th>Jawaban</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if (!$modeltanya->isNewRecord) {
                                foreach ($modeltanya as $key => $value) {
                                    ?>
                                    <tr>
                                        <td><textarea id='pertanyaan' rows="3" class='form-control' name='pertanyaan[]'><?= $value->pertanyaan ?></textarea></td>
                                        <td><textarea id='jawaban' rows="3" class='form-control' name='jawaban[]'><?= $value->jawaban ?></textarea></td>
                                        <td><a class="btn btn-danger delete" id="btn_hapus"></a></td>
                                    </tr>
                                    <?php
                                }
                            }else{
                            ?>
                                <tr>
                                    <td>
                                        <textarea id="pertanyaan" rows="3" class="form-control" name="pertanyaan[]">Apakah Saudara mengerti maksud diadakannya pemeriksaan terhadap Saudara sekarang ini?</textarea>
                                    </td>
                                    <td>
                                        <textarea id="jawaban" rows="3" class="form-control" name="jawaban[]"></textarea>
                                    </td>
                                    <td><a class="btn btn-danger delete" id="btn_hapus"></a></td>
                                </tr>
                                <tr>
                                    <td>
                                        <textarea id="pertanyaan" rows="3" class="form-control" name="pertanyaan[]">Apakah Saudara dalam keadaan sehat dan bersedia diperiksa sekarang ini?</textarea>
                                    </td>
                                    <td>
                                        <textarea id="jawaban" rows="3" class="form-control" name="jawaban[]"></textarea>
                                    </td>
                                    <td><a class="btn btn-danger delete" id="btn_hapus"></a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    		<?php if(!$model->isNewRecord){ ?>
    			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba4/cetak?id='.$model->id_ba4] ) ?>">Cetak</a>
    		<?php } ?>
        </div>	
</section>
 </div>


   
    <?php ActiveForm::end(); ?>




    <?php
    Modal::begin([
        'id' => 'm_jpu',
        'header' => 'Data Jaksa Pemeriksa',
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
        'id' => 'm_terdakwa',
        'header' => 'Data Terdakwa',
        'options' => [
            'data-url' => '',
        ],
    ]);
    ?> 

    <?=
    $this->render('_m_terdakwa', [
        'model' => $model,
        'searchTerdakwa' => $searchTerdakwa,
        'dataTerdakwa' => $dataTerdakwa,
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


            $(document).on('click', 'a#btn_tambah_pertanyaan', function () {
                var i = $('table#gridTerdakwa tr:last').index() + 1;
                $('#gridPertanyaan').append(
                        '<tr>' +
                        '<td><textarea id="pertanyaan" class="form-control" name="pertanyaan[]"></textarea></td>' +
                        '<td><textarea id="jawaban" class="form-control" name="jawaban[]"></textarea>' +
                        '<td><a class="btn btn-danger" id="btn_hapus">Hapus</a></td>' +
                        '</tr>'
                        );
                i++;
            });

            $('#pilih-jpu').click(function () {

                $('.check_jpu:checkbox:checked').each(function (index) {
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
                            '<td id="tdJPU"><a class="btn btn-danger" id="btn_hapus">Hapus</a></td>' +
                            '</tr>'
                            );

                });
                $('#m_jpu').modal('hide');
            });

            $('#pilih_terdakwa').click(function () {

                $('.check_terdakwa:checkbox:checked').each(function (index) {
                    //var keys = $('#gridKejaksaan').yiiGridView('getSelectedRows');
                    // alert(keys);
                    var value = $(this).val();
                    var data = value.split('#');
                    var i = $('table#gridTerdakwa tr:last').index() + 1;
                    $('#gridTerdakwa').append(
                            "<tr id='trTerdakwa" + i + "'>" +
                            "<td id='tdTerdakwa" + i + "' style='display:none;'><input type='text' name='txtid[]' id='txtid" + i + "' value='" + data[0] + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
                            "<td id='tdTerdakwa" + i + "'><input type='text' name='txtnama[]' id='txtnama" + i + "' value='" + data[1] + "' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>" +
                            "<td id='tdTerdakwa" + i + "'><input type='text' name='txtalamat[]' id='txtalamat" + i + "' value='" + data[2] + "' style='width:400px;' readonly='true' class='form-control' readonly='true'></td>" +
                            "<td id='tdTerdakwa" + i + "'><input type='text' name='txtagama[]' id='txtagama" + i + "' value='" + data[3] + "' style='width:130px;' readonly='true' class='form-control' readonly='true'></td>" +
                            "<td id='tdTerdakwa" + i + "'><input type='text' name='txtpendidikan[]' id='txtpendidikan" + i + "' value='" + data[4] + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
                            "<td id='tdTerdakwa" + i + "'><a class='btn btn-danger' id='btn_hapus'>Hapus</a></td>" +
                            "</tr>"
                            );
                    i++;
                    $('#m_terdakwa').modal('hide');
                });
            });
        }
    </script>