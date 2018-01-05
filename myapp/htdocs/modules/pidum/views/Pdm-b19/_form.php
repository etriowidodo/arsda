<?php

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB19;
use app\modules\pidum\models\PdmMsSatuan;
use app\modules\pidum\models\PdmMsStatusData;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

CKEditorAsset::register($this);

/* @var $this View */
/* @var $model PdmB19 */
/* @var $form ActiveForm2 */
?>

<div class="box-header"></div>


    <?php
    $form = ActiveForm::begin([
                'id' => 'b19-form',
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
    
<div class="content-wrapper-1">
    <div class="pdm-b19-form">
        <div class="row">
            <div class="col-md-12">
                <?= $this->render('//Pdm-b19/_formHeader', ['form' => $form, 'model' => $model]) ?>
                <div class="box box-primary" style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="box-title">
                                    Barang Bukti
                                </h4>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <table id="table_barbuk" class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th width="2%" style="text-align: center;"></th>
                                                    <th width="4%" style="text-align: center;">No</th>
                                                    <th width="15%" style="text-align: center;vertical-align: middle;">Nama</th>
                                                    <th width="8%" style="text-align: center;vertical-align: middle;">Jumlah [decimal]</th>
                                                    <th width="8%" style="text-align: center;vertical-align: middle;">Satuan</th>
                                                    <th width="10%" style="text-align: center;vertical-align: middle;">Disita dari</th>
                                                    <th width="10%" style="text-align: center;vertical-align: middle;">Tempat Simpan</th>
                                                    <th width="10%" style="text-align: center;vertical-align: middle;">Kondisi</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tbody_barbuk">
                                                <?php if(!$model->isNewRecord){ ?>
                                                
                                                <?php
                                                    $i = 0;
                                                    foreach ($modelbarbuk as $barbuk){
                                                ?>
                                                    <tr>
                                                        <td style="text-align: center">
                                                            <input type="checkbox" name="pdmBarbukFlag<?= $i?>" <?php echo ($barbuk['flag'])?'Checked':''; ?>></input>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <input type="text" class="form-control" name="pdmBarbukNo[]" readonly="true" value="<?= $barbuk['no_urut'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="<?= $barbuk['nama'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="<?= $barbuk['jumlah'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="<?= $barbuk['id_satuan'] ?>">
                                                            <input type="text" class="form-control" name="txtBarbukSatuan[]" readonly="true" value="<?= \app\modules\pidum\models\PdmMsSatuan::findOne($barbuk['id_satuan'])->nama ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="<?= $barbuk['sita_dari'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="<?= $barbuk['tindakan'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="<?= $barbuk['id_stat_kondisi'] ?>">
                                                            <input type="text" class="form-control" name="txtBarbukKondisi[]" readonly="true" value="<?= \app\modules\pidum\models\PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => \app\components\ConstDataComponent::KondisiBarang])->nama ?>">
                                                        </td>
                                                    </tr>
                                                <?php
                                                 $i++;   }//end foreach
                                                ?>
                                                
                                                <?php } else { ?>
                                                
                                                <?php
                                                    $i = 0;
                                                    foreach ($modelbarbuk as $barbuk){
                                                ?>
                                                    <tr>
                                                        <td style="text-align: center">
                                                            <input type="checkbox" name="pdmBarbukFlag<?= $i?>" ></input>
                                                        </td>
                                                        <td style="text-align: center">
                                                            <input type="text" class="form-control" name="pdmBarbukNo[]" readonly="true" value="<?= $barbuk['no_urut_bb'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="<?= $barbuk['nama'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="<?= $barbuk['jumlah'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="<?= $barbuk['id_satuan'] ?>">
                                                            <input type="text" class="form-control" name="txtBarbukSatuan[]" readonly="true" value="<?= \app\modules\pidum\models\PdmMsSatuan::findOne($barbuk['id_satuan'])->nama ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="<?= $barbuk['sita_dari'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="<?= $barbuk['tindakan'] ?>">
                                                        </td>
                                                        <td>
                                                            <input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="<?= $barbuk['id_stat_kondisi'] ?>">
                                                            <input type="text" class="form-control" name="txtBarbukKondisi[]" readonly="true" value="<?= \app\modules\pidum\models\PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => \app\components\ConstDataComponent::KondisiBarang])->nama ?>">
                                                        </td>
                                                    </tr>
                                                <?php
                                                 $i++;   }//end foreach
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
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Status Barang Bukti</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'ms_status_data')->dropDownList(
                                            ArrayHelper::map($status, 'id', 'nama'), 
                                            ['prompt' => 'Pilih Status']) 
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-primary" style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <h4 class="box-title">
                                    Barang Sitaan
                                </h4>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Dikembalikan kepada</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'dikembalikan') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Perkiraan harga minimum</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'harga') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->no_surat_b19, 'GlobalConst' => GlobalConstMenuComponent::B19]) ?>
                <hr style="border-color: #c7c7c7;margin: 10px 0;">
                <div class="box-footer" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if (!$model->isNewRecord) : ?>
                        <a class="btn btn-warning" href="<?= Url::to(['pdm-b19/cetak?id=' . $model->no_surat_b19]) ?>">Cetak</a>
                    <?php endif ?>	
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>


