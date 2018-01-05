<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP39;
use app\modules\pidum\models\VwTerdakwaT2;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use yii\helpers\ArrayHelper;
use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
[
    'id' => 'agenda-persidangan-form',
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

<div class="content-wrapper-1">
    <div class="pdm-agenda-persidangan-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="content-wrapper-1">
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                <h3 class="box-title">
                                                    <a class='btn btn-danger delete hapus hapusSurat1'></a>
                                                    &nbsp;
                                                    <a class="btn btn-primary tambah_memperhatikan1">+ Majelis Hakim</a>
                                                </h3>
                                            </div>
                                            <table id="table_grid_surat1" class="table table-bordered table-striped">
                                                <thead>
                                                    <th></th>
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 77%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat1">
                                                    <?php if(!$model->isNewRecord){ ?>
                                                        <?php// foreach($majelis1 as $value): ?>
                                                        <?php for($i=0; $i < count($majelis1);$i++){ ?>
                                                        <tr>
                                                            <td style="height: 70px"><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td>
                                                            <td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'><?=$majelis1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat1_1[]" id=""  type='textarea' class='form-control'><?=$majelis2[$i]?></textarea></td>
                                                        </tr>
                                                        <?php }?>
                                                    <?php }else{ 
                                                            if ($majelis1 == ''){ ?>
                                                                <tr>
                                                                    <td style="height: 70px"><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'>Ketua</textarea></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1_1[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 70px"><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1[]" id="" type='textarea' class='form-control'>Anggota 1</textarea></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1_1[]" id="" type='textarea' class='form-control'></textarea></td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="height: 70px"><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1[]" id="" type='textarea' class='form-control'>Anggota 2</textarea></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1_1[]" id="" type='textarea' class='form-control'></textarea></td>
                                                                </tr>
                                                    <?php   } else { ?>
                                                                <?php for($i=0; $i < count($majelis1);$i++){ ?>
                                                                <tr>
                                                                    <td style="height: 70px"><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1[]" id=""  type='textarea' class='form-control'><?=$majelis1[$i]?></textarea></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat1_1[]" id=""  type='textarea' class='form-control'><?=$majelis2[$i]?></textarea></td>
                                                                </tr>
                                                                <?php }?>
                                                    <?php   }
                                                        ?>
                                                    
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                <h3 class="box-title">
                                                    <a class='btn btn-danger delete hapus hapusSurat2'></a>
                                                    &nbsp;
                                                    <a class="btn btn-primary tambah_memperhatikan2">+ Penasehat Hukum</a>
                                                </h3>
                                            </div>
                                            <table id="table_grid_surat2" class="table table-bordered table-striped">
                                                <thead>
                                                    <th></th>
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 77%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat2">
                                                    <?php if(!$model->isNewRecord){ ?>
                                                        <?php //foreach($penasehat_hkm as $value): ?>
                                                        <?php for($i=0; $i < count($penasehat1);$i++){ ?>
                                                        <tr>
                                                            <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                            <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'><?=$penasehat1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat2_2[]" id=""  type='textarea' class='form-control'><?=$penasehat2[$i]?></textarea></td>
                                                        </tr>
                                                        <?php } ?>
                                                    <?php }else{ 
                                                        if ($penasehat1 == ''){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                        <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'>Ke-1</textarea></td>
                                                        <td width="20%"><textarea name="txt_nama_surat2_2[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                        <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'>Ke-2</textarea></td>
                                                        <td width="20%"><textarea name="txt_nama_surat2_2[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                        <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'>Ke-3</textarea></td>
                                                        <td width="20%"><textarea name="txt_nama_surat2_2[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                    <?php   } else { ?>
                                                                <?php for($i=0; $i < count($penasehat1);$i++){ ?>
                                                                <tr>
                                                                    <td style="height: 70px"><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat2[]" id=""  type='textarea' class='form-control'><?=$penasehat1[$i]?></textarea></td>
                                                                    <td width="20%"><textarea name="txt_nama_surat2_2[]" id=""  type='textarea' class='form-control'><?=$penasehat2[$i]?></textarea></td>
                                                                </tr>
                                                    <?php }?>
                                                    <?php   }
                                                        ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" style="height: 45px">
                                <div class="col-md-12">
                                    <div class="col-md-6">
                                        <div class="box-header with-border">
                                            <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                                <h3 class="box-title">
                                                    <a class='btn btn-danger delete hapus hapusSurat3'></a>
                                                    &nbsp;
                                                    <a class="btn btn-primary tambah_memperhatikan3">+ Panitera</a>
                                                </h3>
                                            </div>
                                            <table id="table_grid_surat3" class="table table-bordered table-striped">
                                                <thead>
                                                    <th></th>
                                                    <th style="width: 20%"></th>
                                                    <th style="width: 77%"></th>
                                                </thead>
                                                <tbody id="tbody_grid_surat3">
                                                    <?php if(!$model->isNewRecord){ ?>
                                                        <?php //foreach($penasehat_hkm as $value): ?>
                                                        <?php for($i=0; $i < count($panitera1);$i++){ ?>
                                                        <tr>
                                                            <td style="height: 70px"><input type='checkbox' name='new_check3[]' class='hapusSuratCheck2'></td>
                                                            <td width="20%"><textarea name="txt_nama_surat3[]" id=""  type='textarea' class='form-control'><?=$panitera1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat3_3[]" id=""  type='textarea' class='form-control'><?=$panitera2[$i]?></textarea></td>
                                                        </tr>
                                                        <?php } ?>
                                                    <?php }else{ 
                                                        if ($panitera1 == ''){ ?>
                                                    <tr>
                                                        <td style="height: 70px"><input type='checkbox' name='new_check3[]' class='hapusSuratCheck3'></td>
                                                        <td width="20%"><textarea name="txt_nama_surat3[]" id=""  type='textarea' class='form-control'>Panitera</textarea></td>
                                                        <td width="20%"><textarea name="txt_nama_surat3_3[]" id=""  type='textarea' class='form-control'></textarea></td>
                                                    </tr>
                                                    <?php   } else { ?>
                                                                <?php for($i=0; $i < count($panitera1);$i++){ ?>
                                                        <tr>
                                                            <td style="height: 70px"><input type='checkbox' name='new_check3[]' class='hapusSuratCheck2'></td>
                                                            <td width="20%"><textarea name="txt_nama_surat3[]" id=""  type='textarea' class='form-control'><?=$panitera1[$i]?></textarea></td>
                                                            <td width="20%"><textarea name="txt_nama_surat3_3[]" id=""  type='textarea' class='form-control'><?=$panitera2[$i]?></textarea></td>
                                                        </tr>
                                                    <?php }?>
                                                    <?php   }
                                                        ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br/>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label class="control-label col-sm-7">Sidang Tahap ke</label>
                                        <div class="col-sm-5">
                                            <?php ;
                                            if(!$model->isNewRecord){ ?>
                                            <?= $form->field($model, 'no_agenda')->textInput(['readonly'=>true]);?>
                                            <?php }else{ ?>
                                            <?= $form->field($model, 'no_agenda')->textInput(['readonly'=>true, 'value'=>$agenda_1[hasil]]);?>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Tgl.</label>
                                        <div class="col-sm-9">
                                            <?php
                                            echo $form->field($model, 'tgl_acara_sidang')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => [
                                                        'placeholder' => 'Tgl. Acara Sidang',
                                                    ],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'startDate' => '-1m',
                                                        'endDate' => '+1y'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-sm-4">Acara Sidang</label>
                                        <div class="col-sm-6">
                                            <?php echo $form->field($model, 'acara_sidang')->dropDownList(
                                                ArrayHelper::map($modelsdg,'id', 'keterangan'), 
                                                ['prompt' => 'Pilih Acara Sidang']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <h4 class="box-title">
                            Catatan Persidangan
                        </h4>
                        <br/>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Jalan Persidangan</label>
                                        <div class="col-sm-9">
                                            <?php //echo $form->field($model, 'uraian_sidang')->textarea(['placeholder' => 'Jalan Persidangan','class'=>'ckeditor']); ?>
                                            <?php echo $form->field($model, 'uraian_sidang')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmAgendaPersidangan[uraian_sidang]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Pengunjung Sidang</label>
                                        <div class="col-sm-9">
                                            <?php// echo $form->field($model, 'pengunjung')->textarea(['placeholder' => 'Pengunjung Sidang','class'=>'ckeditor']); ?>
                                            <?php echo $form->field($model, 'pengunjung')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmAgendaPersidangan[pengunjung]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Kesimpulan</label>
                                        <div class="col-sm-9">
                                            <?php// echo $form->field($model, 'kesimpulan')->textarea(['placeholder' => 'Kesimpulan','class'=>'ckeditor']); ?>
                                            <?php echo $form->field($model, 'kesimpulan')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmAgendaPersidangan[kesimpulan]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-sm-2">Pendapat/Saran</label>
                                        <div class="col-sm-9">
                                            <?php// echo $form->field($model, 'pendapat')->textarea(['placeholder' => 'Pendapat/Saran','class'=>'ckeditor']); ?>
                                            <?php echo $form->field($model, 'pendapat')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmAgendaPersidangan[pendapat]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>	
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>



<?php
$script1 = <<< JS
        var id=1;
	$('.tambah_memperhatikan1').on('click', function() {
		$("#table_grid_surat1 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check1[]' class='hapusSuratCheck1'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat1[]' /></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat1_1[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat1').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check1[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan2').on('click', function() {
		$("#table_grid_surat2 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check2[]' class='hapusSuratCheck2'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat2[]' /></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat2_2[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat2').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check2[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
        var id=1;
	$('.tambah_memperhatikan3').on('click', function() {
		$("#table_grid_surat3 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check3[]' class='hapusSuratCheck3'></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat3[]' /></td><td><textarea type='textarea' class='form-control' name='txt_nama_surat3_3[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusSurat3').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check3[]\"]'),function(x)
			{
				var input = $(this);
				if(input.prop('checked')==true)
				{   var id = input.parent().parent();
					id.remove();
				}
			}
		 )
	});
        
        
JS;
$this->registerJs($script1);
?>