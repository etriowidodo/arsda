<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */
/* @var $form yii\widgets\ActiveForm */
?>



<section class="content" style="padding: 0px;">
    <div class ="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'T13-form',
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



        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input class="form-control" readonly="true" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                        </div>
                    </div>
                </div>
            </div>

          
            <div class="col-md-12">
                <div class="col-md-6">
                     <br>
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat</label>
                        <div class="col-md-8"> 
                            <?= $form->field($model, 'no_surat') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">kepada</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'kepada') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Terdakwa</label>
                        <div class="col-md-8">
                            <?php
                            $penandatangan = (new \yii\db\Query())
                                    ->select('id_tersangka,nama')
                                    ->from('pidum.vw_terdakwa')
                                    ->where("id_perkara='" . $id . "'")
                                    ->all();
                            $list = ArrayHelper::map($penandatangan, 'id_tersangka', 'nama');
                            echo $form->field($model, 'id_tersangka')->dropDownList($list, ['prompt' => '---Pilih---'], ['label' => '']);
                            ?>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">SP Penahanan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'sp_penahanan') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Penahanan/Penetapan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'penetapan') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Penahanan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'no_penahanan') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Penahanan</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'tgl_penahanan')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    //'options' => ['place' => '26/Agustus/2015'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Keperluan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'keperluan') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Menghadap</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'menghadap') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tempat</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'tempat') ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Penetapan</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($model, 'tgl_penetapan')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    //'options' => ['place' => '26/Agustus/2015'],
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <?php
                    echo Form::widget([ /* waktu kunjungan */
                        'model' => $model,
                        'form' => $form,
                        'columns' => 2,
                        'attributes' => [
                            'jam_kunjungan' => [
                                'label' => 'Jam',
                                'labelSpan' => 4,
                                'columns' => 12,
                                'attributes' => [
                                    'jam' => [
                                        'type' => Form::INPUT_WIDGET,
                                        'widgetClass' => '\kartik\widgets\TimePicker',
                                        'options' => [
                                            'pluginOptions' => [
                                                //'template'=>false,
                                                'defaultTime' => false,
                                                'showSeconds' => false,
                                                'showMeridian' => false,
                                                'minuteStep' => 1,
                                            ],
                                            'options' => [
                                                'placeholder' => 'Jam Mulai'
                                            ]
                                        ],
                                        'columnOptions' => ['colspan' => 8],
                                    ],
                                ]
                            ],
                        ]
                    ]);
                    ?>
                </div>
            </div>

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Dikeluarkan & Tanggal</label>
                        <div class="col-md-4">
                            <?php echo $form->field($model, 'dikeluarkan')->input('text', ['value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
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
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T13, 'id_table' => $model->id_t13]) ?>

        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-t13/cetak?id=' . $model->id_t13]) ?>">Cetak</a>
            <?php endif ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>
