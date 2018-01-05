<?php
use dosamigos\ckeditor\CKEditorInline;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP49;
use app\modules\pidum\models\VwPenandatangan;
use app\modules\pidum\models\PdmMsBendaSitaan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use kartik\builder\Form;



/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP49 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
    [
        'id' => 'p-49-form',
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
    <div class="pdm-p49-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No. Surat P-49</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_surat_p49')->textInput(['placeholder' => 'Nomor Surat P-49']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tanggal Surat</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => [
                                                        'placeholder' => 'Tanggal Surat',
                                                    ],
                                                    'pluginOptions' => [
                                                        'autoclose' => true
                                                    ]
                                                ]
                                            ]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Ditetapkan di</label>
                                        <div class="col-md-6">
                                            <?
                                                if($model->isNewRecord){
                                                   echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                                                }else{
                                                   echo $form->field($model, 'dikeluarkan');
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Terpidana</label>
                                        <div class="col-md-6">
                                            <?= $form->field($modeltsk, 'nama')->textInput(['placeholder' => '']); ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Surat Kematian dari</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'surat_kematian')->textInput(['placeholder' => 'Surat Kematian dari']); ?>
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
                                            <a class="btn btn-primary tambah_alasan">+ Mengingat</a>
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
                                                <?php for($i=0; $i < count($mengingat);$i++){ ?>
                                                <tr>
                                                    <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td>
                                                    <td width="98%"><textarea name="txt_nama_alasan[]" id=""  type='textarea' class='form-control'><?=$mengingat[$i]?></textarea></td>
                                                </tr>
                                                <?php } ?>
                                            <?php }else{ ?>
                                            <tr>
                                                <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td>
                                                <td width="98%"><textarea name="txt_nama_alasan[]" id=""  type='textarea' class='form-control'>Pasal 83 KUHP</textarea></td>
                                            </tr>
                                            <tr>
                                                <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td>
                                                <td width="98%"><textarea name="txt_nama_alasan[]" id=""  type='textarea' class='form-control'>Pasal 84 KUHP</textarea></td>
                                            </tr>
                                            <tr>
                                                <td style="height: 70px"><input type='checkbox' name='new_check1_1[]' class='hapusalasanCheck1'></td>
                                                <td width="98%"><textarea name="txt_nama_alasan[]" id=""  type='textarea' class='form-control'>Pasal 46 KUHAP</textarea></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->no_surat_p49, 'GlobalConst' => GlobalConstMenuComponent::P49]) ?>
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if(!$model->isNewRecord){ ?><a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p49/cetak?id='.rawurlencode($model->no_surat_p49)])?>">Cetak</a><?php } ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


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