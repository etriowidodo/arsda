<?php

use app\components\ConstDataComponent;
use app\modules\pidum\models\PdmMsSatuan;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\PdmPenandatangan;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

CKEditorAsset::register($this);

/* @var $this View */
/* @var $model app\modules\pidum\models\pdmb17 */
/* @var $form ActiveForm2 */
?>


<?php
$form = ActiveForm::begin([
            'id' => 'b17-form',
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

<div class="box box-warning">
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Wilayah Kerja</label>
                    <div class="col-md-8">
                        <input class="form-control" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                        <div class="help-block"></div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor</label>
                    <div class="col-md-8">
                        <?= $form->field($model, 'no_surat') ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">
            BERKAS PERKARA
        </h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">No Reg Bukti</label>
                    <div class="col-md-8">
                        <?= $form->field($model, 'no_reg_bukti')->textInput(['readOnly' => false]) ?>
                    </div>
                </div>
            </div>
        </div>
<!--        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tersangka/Terdakwa</label>
                    <div class="col-md-8">
                        <?php
//                        $session = new Session();
//                        $idPERKARA = $session->get('id_perkara');
//                        $tersangka = (new Query())
//                                ->select(['id_tersangka', 'nama'])
//                                ->from('pidum.ms_tersangka')
//                                ->where("id_perkara='" . $idPERKARA . "'")
//                                ->all();
//                        $listnama = ArrayHelper::map($tersangka, 'id_tersangka', 'nama');
//                        echo $form->field($model, 'id_tersangka')->dropDownList($listnama, ['prompt' => '---Pilih Tersangka---'], ['label' => '']);
                        ?>
                    </div>
                </div>
            </div>
        </div>-->
    </div>
</div>


<div class="box box-warning">
    <div class="box-header">
        <h3 class="box-title">BARANG SITAAN</h3>
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
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
    </div>
</div>			

<div class="box box-warning">
    <div class="box-header">
    </div>
    <div class="box-body">
        <div class="col-md-12">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Dikeluarkan di</label>
                    <div class="col-md-4">
                        <?php
                        if ($model->isNewRecord) {
                            echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                        } else {
                            echo $form->field($model, 'dikeluarkan');
                        }
                        ?>
                    </div>
                    <div class="col-sm-3"><?=
                        $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Dikeluarkan',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Penanda Tangan</label>
                    <div class="col-md-8">
                        <?php echo Yii::$app->globalfunc->returnDropDownList($form, $model, \app\modules\pidum\models\VwPenandatangan::find()->all(), 'peg_nik', 'nama', 'id_penandatangan') ?>

                    </div>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>
</div>


<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;">

    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    <?php if (!$model->isNewRecord) : ?>
        <a class="btn btn-warning" href="<?= Url::to(['pdm-b17/cetak?id=' . $model->id_b17]) ?>">Cetak</a>
    <?php endif ?>	
</div>


<?php ActiveForm::end(); ?>
