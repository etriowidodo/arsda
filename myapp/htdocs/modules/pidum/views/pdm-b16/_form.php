<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB16;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\PdmMsJnsbrng;
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
use kartik\grid\GridView;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB16 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'b16-form',
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



<?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>

        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-bottom:none;">
                <fieldset>
                    <div class="kv-nested-attribute-block form-sub-attributes form-group">
                        <div class="col-sm-12">
                            <?php
                            echo Form::widget([ /* tersangka */
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'tersangka' => [
                                        'label' => 'Tersangka',
                                        'labelSpan' => 2,
                                        'columns' => 8,
                                        'attributes' => [
                                            'id_tersangka' => [
                                                'type' => Form::INPUT_DROPDOWN_LIST,
                                                'options' => ['prompt' => 'Pilih Tersangka'],
                                                'items' => ArrayHelper::map($list_tersangka, 'id_tersangka', 'nama'),
                                                'columnOptions' => ['colspan' => 4],
                                            ],
                                        ]
                                    ],
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>


        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>HASIL PELELANGAN</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">
                <div class="form-group">
                    <label class="control-label col-md-2">Pelakasanaan Di</label>
                    <div class="col-sm-4">
<?php echo $form->field($model, 'pelaksanaan_lelang'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Tanggal</label>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'tgl_lelang')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Terima',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Jumlah Akhir Pelelangan</label>
                    <div class="col-sm-2">
<?php echo $form->field($model, 'total'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Bank Penitipan</label>
                    <div class="col-sm-4">
<?php echo $form->field($model, 'bank'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Berita Acara Penitipan</label>
                    <div class="col-sm-4">
<?php echo $form->field($model, 'ba_penitipan'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Tanggal</label>
                    <div class="col-sm-2">
                        <?=
                        $form->field($model, 'tgl_ba')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Terima',
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

        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>Detail Lampiran</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">
                <!--           <div class="form-group">
                                                <label class="control-label col-md-2">Surat Perintah Kepada</label>
                                                <div class="col-sm-4">
<?php //echo $form->field($model, 'surat_perintah_kepada');  ?>
                                                </div>
                                        </div>
                            
                                        <div class="form-group">
                                                <label class="control-label col-md-2">Penetapan Pengadilan Negeri/Ekonomi</label>
                                                <div class="col-sm-2">
<?php // echo $form->field($model, 'lokasi_penetapan');  ?>
                                                </div>
                                        </div>
                -->
                <div class="form-group">
                    <label class="control-label col-md-2">No. Persetujuan Terdakwa</label>
                    <div class="col-sm-2">
<?php echo $form->field($model, 'no_persetujuan'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Tanggal</label>
                    <div class="col-sm-4">

                        <?=
                        $form->field($model, 'tgl_persetujuan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'Tanggal Terima',
                                ],
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Kantor Lelang Negara</label>
                    <div class="col-sm-4">
<?php echo $form->field($model, 'kantor_lelang'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">No. Risalah Lelang</label>
                    <div class="col-sm-4">
<?php echo $form->field($model, 'no_risalan'); ?>
                    </div>
                </div>
            </div>
        </div>

<?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B16, 'id_table' => $model->id_b16]) ?>

        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>  
                <a class="btn btn-warning" href="<?= Url::to(['pdm-b16/cetak?id=' . $model->id_b16]) ?>">Cetak</a>
<?php endif ?>  
        </div>



<?php ActiveForm::end(); ?>



</section>
