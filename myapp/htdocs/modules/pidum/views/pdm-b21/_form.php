<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB21;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

CKEditorAsset::register($this);

/* @var $this View */
/* @var $model PdmB21 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-b21-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'b21-form',
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
                        <label class="control-label col-md-4">Wilayah kerja</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'wilayah')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?= $form->field($modelJaksa, 'nip')->hiddenInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor-PRINT</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_surat')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?= $form->field($modelJaksa, 'jabatan')->hiddenInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Penerima Perintah/Jaksa</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($modelJaksa, 'nama', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?= $form->field($modelJaksa, 'pangkat')->hiddenInput() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                DASAR ACUAN
            </h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Surat Jaksa Agung No</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'surat_jaksa_agung')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tanggal_jaksa_agung')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => [
                                        'placeholder' => 'Tanggal Surat Jaksa Agung',
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
    </div>

    <div class="box box-warning">
        <div class="box-body">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Pertimbangan</label>
                        <div class="col-md-10">
                            <?= $form->field($model, 'pertimbangan')->textarea() ?>

                            <?php
                            $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                            $this->registerJs("
                                CKEDITOR.inline( 'PdmB21[pertimbangan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Untuk</label>
                        <div class="col-md-10">
                            <?= $form->field($model, 'untuk')->textarea() ?>

                            <?php
                            $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                            $this->registerJs("
                                CKEDITOR.inline( 'PdmB21[untuk]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dikeluarkan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'dikeluarkan')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-8">
                            <?=
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
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->id_b21, 'GlobalConst' => GlobalConstMenuComponent::B21]) ?>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b21/cetak?id=' . $model->id_b21]) ?>">Cetak</a>
        <?php endif ?>	
    </div>

    <?php ActiveForm::end(); ?>

</div>

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
