<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP50;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmP50 */
/* @var $form ActiveForm2 */
?>

<!--<div class="box-header"></div>-->


    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'p50-form',
                        'type' => ActiveForm::TYPE_HORIZONTAL,
                        'enableAjaxValidation' => false,
                        'fieldConfig' => [
                            'autoPlaceholder' => false
                        ],
                        'formConfig' => [
                            'deviceSize' => ActiveForm::SIZE_SMALL,
                            'labelSpan' => 2,
                            'showLabels' => false
                        ]
    ]);
    ?>
<div class="content-wrapper-1">
    <div class="pdm-p50-form">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('//pdm-p50/_formHeader', ['form' => $form, 'model' => $model]) ?>
                <div class="box box-primary" style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px; margin-top: 10px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Terdakwa</label>
                                        <div class="col-md-6">
                                            <?echo $form->field($terdakwa, 'nama');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="box-header with-border">
                                    <div class="col-md-6" style="padding: 0px; margin-bottom: 10px">
                                        <h3 class="box-title">
                                            <a class='btn btn-danger delete hapus hapusalasan'></a>
                                            &nbsp;
                                            <a class="btn btn-primary tambah_alasan">+ Alasan Kasasi</a>
                                        </h3>
                                    </div>
                                    <table id="table_grid_alasan" class="table table-bordered table-striped">
                                        <thead>
                                            <th></th>
                                            <th style="width: 96%"></th>
                                        </thead>
                                        <tbody id="tbody_grid_alasan">
                                            <?php if(!$model->isNewRecord){ ?>
                                                <?php //foreach($penasehat_hkm as $value): ?>
                                                <?php for($i=0; $i < count($alasan);$i++){ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td>
                                                    <td width="98%"><textarea name="txt_nama_alasan[]" id=""  type='textarea' class='form-control'><?=$alasan[$i]?></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            <?php }else{ ?>
                                            <tr>
                                                <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td>
                                                <td width="98%"><textarea name="txt_nama_alasan[]" id=""  type='textarea' class='form-control'></textarea></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->no_surat_p50, 'GlobalConst' => GlobalConstMenuComponent::P50]) ?>
            </div>
            <div class="form-group" style="text-align: center;">
                <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                <?php if (!$model->isNewRecord) { ?>
                    <a class="btn btn-warning" href="<?= Url::to(['pdm-p50/cetak?id=' . $model->no_surat_p50]) ?>">Cetak</a>
                <?php } ?>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>
</div>


<?php
$script1 = <<< JS
        var id=1;
	$('.tambah_alasan').on('click', function() {
		$("#table_grid_alasan > tbody").append("<tr id='"+id+"'><td><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td><td><textarea type='textarea' class='form-control' name='txt_nama_alasan[]' /></td></tr>");
		
		$(".date-picker").kvDatepicker({
			format:'dd-m-yyyy',
			autoclose: true
		});
		id++;
	});
        
        $('.hapusalasan').click(function()
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
$this->registerJs($script1);
?>
