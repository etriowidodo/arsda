<?php

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmB20;
use app\modules\pdsold\models\PdmMsSatuan;
use app\modules\pdsold\models\PdmMsStatusData;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

CKEditorAsset::register($this);
/* @var $this View */
/* @var $model PdmB20 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-b20-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'b20-form',
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

    <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                ALASAN PELELANGAN
            </h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Status Barang</label>
                    <div class="col-md-10">
                        <?php
                        $listData = PdmMsStatusData::find()->where(['is_group' => ConstDataComponent::PerihalB20])->orderBy('id')->All();
                        $new = array();
                        foreach ($listData as $key) {
                            $new = $new + [$key->id => $key->keterangan];
                        }
                        echo $form->field($model, 'id_statusbrng')
                                //->radioList($new);
                                ->radioList($new, ['inline' => false]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-12">Terdiri dari</label>
                    <div class="col-md-12">
                        <table id="table_barbuk" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="15%" style="text-align: center;vertical-align: middle;">Nama</th>
                                    <th width="15%" style="text-align: center;vertical-align: middle;">Jumlah [decimal]</th>
                                    <th width="15%" style="text-align: center;vertical-align: middle;">Satuan</th>
                                    <th width="15%" style="text-align: center;vertical-align: middle;">Disita dari</th>
                                    <th width="15%" style="text-align: center;vertical-align: middle;">Tempat Simpan</th>
                                    <th width="15%" style="text-align: center;vertical-align: middle;">Kondisi</th>
                                </tr>
                            </thead>
                            <tbody id="tbody_barbuk">

                                <?php
                                if (!$modelbarbuk->isNewRecord) {
                                    foreach ($modelbarbuk as $barbuk):
                                        echo '<td><input type="hidden" class="form-control idbarbuk" name="idBarbuk" readonly="true" value="' . $barbuk['id'] . '">';
                                        echo '<input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="' . $barbuk['nama'] . '"></td>';
                                        echo '<td><input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="' . $barbuk['jumlah'] . '"></td>';
                                        echo '<td><input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="' . $barbuk['id_satuan'] . '">';
                                        echo '<input type="text" class="form-control" name="txtBarbukSatuan" readonly="true" value="' . PdmMsSatuan::findOne($barbuk['id_satuan'])->nama . '"></td>';
                                        echo '<td><input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="' . $barbuk['sita_dari'] . '"></td>';
                                        echo '<td><input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="' . $barbuk['tindakan'] . '"></td>';
                                        echo '<td><input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="' . $barbuk['id_stat_kondisi'] . '">';
                                        echo '<input type="text" class="form-control" name="txtBarbukKondisi" readonly="true" value="' . PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => ConstDataComponent::KondisiBarang])->nama . '"></td>';
                                        echo '</tr>';
                                    endforeach;
                                }
                                ?>


                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Tidak jadi dilelang karena</label>
                    <div class="col-md-10">
                        <?= $form->field($model, 'alasan')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmB20[alasan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                MANFAAT BARANG
            </h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Status Pemanfaatan</label>
                    <div class="col-md-10">
                        <?php
                        $listData = PdmMsStatusData::find()->where(['is_group' => ConstDataComponent::PemanfaatanB20])->orderBy('id')->All();
                        $new = array();
                        foreach ($listData as $key) {
                            $new = $new + [$key->id => $key->nama];
                        }
                        echo $form->field($model, 'id_manfaatbrng')
                                //->radioList($new);
                                ->radioList($new, ['inline' => false]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Dimanfaatkan</label>
                    <div class="col-md-10">
                        <?= $form->field($model, 'dimanfaatkan')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmB20[dimanfaatkan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->id_b20, 'GlobalConst' => GlobalConstMenuComponent::B20]) ?>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b20/cetak?id=' . $model->id_b20]) ?>">Cetak</a>
        <?php endif ?>	
    </div>

    <?php ActiveForm::end(); ?>

</div>
