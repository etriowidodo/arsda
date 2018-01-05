<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\web\View;
use app\modules\pdsold\models\VwPenandatangan;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP43 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class ="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'p43-form',
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
        <div class="col-sm-12">
            <?= $this->render('//default/_formHeaderV_p43', ['form' => $form, 'model' => $model, 'kode'=>'_p43']) ?>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-body">
                <div class="row" style="height: 45px; margin-top: 15px">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Petunjuk</label>
                                <div class="col-md-6">
                                    <?php echo $form->field($model, 'petunjuk')->dropDownList(
                                        ArrayHelper::map($petunjuk,'id', 'nama'), 
                                        ['prompt' => '--- Pilih ---', 'class' => 'cmb_agenda']);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="height: 45px; margin-top: 15px">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Nomor Surat /NoTel</label>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'notel') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Tgl. Surat /NoTel</label>
                                <div class="col-md-6">
                                    <?= $form->field($model, 'tgl_notel')->widget(DateControl::className(), [
                                            'type' => DateControl::FORMAT_DATE,
                                            'ajaxConversion' => false,
                                            'options' => [
                                                'options' => ['placeholder' => 'Tanggal Surat'],
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
                <div class="row hide" style="height: 45px">
                    <div class="col-md-12">
                        <div class="box-header with-border">
                            <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                <h3 class="box-title">
                                    <a class='btn btn-danger delete hapus hapusamar1'></a>
                                    &nbsp;
                                    <a class="btn btn-primary tambah_amar1">+ Tuntutan Pidana</a>
                                </h3>
                            </div>
                            <table id="table_grid_amar1" class="table table-bordered table-striped">
                                <thead>
                                    <th></th>
                                    <th style="width: 96%"></th>
                                </thead>
                                <tbody id="tbody_grid_amar1">
                                    <?php if(!$model->isNewRecord){ ?>
                                        <?php //foreach($penasehat_hkm as $value): ?>
                                        <?php for($i=0; $i < count($ket_amar);$i++){ ?>
                                        <tr>
                                            <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusAmarCheck1'></td>
                                            <td width="98%"><textarea name="txt_nama_amar1[]" id=""  type='textarea' class='form-control'><?=$ket_amar[$i]?></textarea></td>
                                        </tr>
                                        <?php } ?>
                                    <?php }else{ ?>
                                    <tr>
                                        <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusAmarCheck1'></td>
                                        <td width="98%"><textarea name="txt_nama_amar1[]" id=""  type='textarea' class='form-control'></textarea></td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        

        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P43, 'id_table' => $model->no_surat_p43]) ?>

        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord) { ?>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p43/cetak?id=' . $model->no_surat_p43]) ?>">Cetak</a>
            <?php } ?>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

    <?php
    $script = <<< JS
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px"name="mytext[]"><br />'
                )
            });
            
            var id=1;
	$('.tambah_amar1').on('click', function() {
		$("#table_grid_amar1 > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check1_1[]' class='hapusAmarCheck1'></td><td><textarea type='textarea' class='form-control' name='txt_nama_amar1[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusamar1').click(function()
	{
		 $.each($('input[type=\"checkbox\"][name=\"new_check1_1[]\"]'),function(x)
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
    $this->registerJs($script);
    ?>