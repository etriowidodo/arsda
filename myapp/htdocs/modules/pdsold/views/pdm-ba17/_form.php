<?php


use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;
use yii\helpers\Url;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
    [
        'id' => 'ba17-form',
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
    <div class="pdm-p45-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary" style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No. Surat</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_surat_ba17')->textInput(['placeholder' => 'Nomor Surat']); ?>
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
                                            <?= $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
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
                                            ]);
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
                                        <label class="control-label col-md-4">Jaksa P-16a</label>
                                        <div class="col-md-6">
                                            <?php
                                                if ($model->isNewRecord) {?>
                                                    <div class="form-group field-pdmjaksasaksi-nama required">
                                                        <div class="col-sm-12">
                                                            <div class="input-group">
                                                                <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                                <div class="input-group-btn">
                                                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-12"></div>
                                                        <div class="col-sm-12">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                            <?php
                                                } else {
                                            ?>
                                                <div class="form-group field-pdmjaksasaksi-nama required">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input value ="<?= $modeljaksi['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
                                                        echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-12"></div>
                                                    <div class="col-sm-12">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                                <?php
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
                                        <label class="control-label col-md-4">Terdakwa/Terpidana</label>
                                        <div class="col-md-6">
                                            <?= $form->field($modeltsk, 'nama')->textInput(['placeholder' => 'Terdakwa/Terpidana' ]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Rutan</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'nama_rutan')->textInput(['placeholder' => 'Rutan' ]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Kepala Rutan</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'nama_kepala_rutan')->textInput(['placeholder' => 'Kepala Rutan' ]); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?= $this->render('//pdm-ba17/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->no_surat_ba17, 'GlobalConst' => GlobalConstMenuComponent::BA17]) ?>
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if(!$model->isNewRecord){ ?><a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba17/cetak?id='.rawurlencode($model->no_surat_ba17)])?>">Cetak</a><?php } ?>
                </div>
                <?php
                    echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', $model->no_register_perkara, ['id' => 'pdmjaksasaksi-no_register_perkara']);
                    echo Html::hiddenInput('PdmJaksaSaksi[no_surat_p16a]', null, ['id' => 'pdmjaksasaksi-no_surat_p16a']);
                    echo Html::hiddenInput('PdmJaksaSaksi[no_urut]', null, ['id' => 'pdmjaksasaksi-no_urut']);
                    echo Html::hiddenInput('PdmJaksaSaksi[nip]', $model->id_penandatangan, ['id' => 'pdmjaksasaksi-nip']);
                    echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', $model->jabatan, ['id' => 'pdmjaksasaksi-jabatan']);
                    echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', $model->pangkat, ['id' => 'pdmjaksasaksi-pangkat']);
                ?>
                
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>


<?php
Modal::begin([
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
Modal::end();
?>