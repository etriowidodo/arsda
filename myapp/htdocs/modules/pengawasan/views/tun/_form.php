<?php

use kartik\builder\Form;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
//use yii\widgets\ActiveForm;
use kartik\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Tun */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tun-form">
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'tun-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'action' => $model->isNewRecord ? Url::toRoute('tun/create') : Url::toRoute('tun/update?id=' . $model->id_tun),
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 1,
                'showLabels' => false,
            ],
            'options' => [
                'enctype' => 'multipart/form-data',
            ]
        ]
    )
    ?>

    <div class="modal-content" style="width: 900px;margin: 30px auto;">
        <div class="modal-header">
            Form Tata Usaha Negara
            <button class="close" aria-hidden="true" data-dismiss="modal" type="button">×</button>
        </div>

        <div class="modal-body">
            <section class="content" style="padding: 0px;">
                <div class="content-wrapper-1">
                    <div class="box box-primary">
                        <div class="box-header with-border" style="border-color: #c7c7c7;">
                            <?php
                            echo Form::widget([ /* terlapor */
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'terlapor' => [
                                        'label' => 'Terlapor',
                                        'labelSpan' => 2,
                                        'columns' => 8,
                                        'attributes' => [
                                            'id_terlapor' => [
                                                'type' => Form::INPUT_DROPDOWN_LIST,
                                                'options' => ['prompt' => 'Pilih Terlapor'],
                                                'items' => ArrayHelper::map($terlapor, 'id_terlapor', 'terlapor'),
                                                'columnOptions' => ['colspan' => 6],
                                            ],
                                        ]
                                    ],
                                ]
                            ]);
                            ?>
                            <fieldset style="margin-bottom: 15px;">
                                <div class="kv-nested-attribute-block form-sub-attributes form-group">
                                    <label class="col-sm-2 control-label">
                                        Kejaksaan
                                    </label>

                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group field-kejaksaan">
                                                    <div class="input-group">
                                                        <?= Html::input('hidden', 'Tun[inst_satkerkd]', $instansi['inst_satkerkd'], ['class' => 'form-control', 'id' => 'inst_satkerkd', 'readonly' => true]); ?>
                                                        <input id="inst_nama" class="form-control" type="text"
                                                               readonly="true"
                                                               name="inst_nama" value="<?= $instansi['inst_nama']; ?>">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-primary"
                                                            data-target="#m_kejaksaan"
                                                            data-toggle="modal">...
                                                    </button>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                            <?php
                            echo Form::widget([ /* nomor & tanggal */
                                'model' => $model,
                                'form' => $form,
                                'columns' => 2,
                                'attributes' => [
                                    'no_tun' => [
                                        'label' => 'Nomor',
                                        'labelSpan' => 4,
                                        'columns' => 8,
                                        'attributes' => [
                                            'no_tun' => [
                                                'type' => Form::INPUT_TEXT,
                                                'columnOptions' => ['colspan' => 12],
                                            ],

                                        ]
                                    ],
                                    'tgl_tun' => [
                                        'label' => 'Tanggal',
                                        'labelSpan' => 4,
                                        'columns' => 8,
                                        'attributes' => [
                                            'tgl_tun' => [
                                                'type' => Form::INPUT_WIDGET,
                                                'widgetClass' => '\kartik\datecontrol\DateControl',
                                                //'hint' => 'format tanggal DD/MM/YYYY',
                                                'options' => [
                                                    'pluginOptions' => [
                                                        'format' => 'dd-mm-yyyy',
                                                        'autoclose' => true,
                                                        'todayHighlight' => true,
                                                        //'endDate' => '+1y',
                                                    ]],
                                                'columnOptions' => ['colspan' => 12],
                                            ],
                                        ]
                                    ],
                                ]
                            ]);
                            ?>
                            <?php
                            echo Form::widget([ /* hasil putusan */
                                'model' => $model,
                                'form' => $form,
                                'columns' => 1,
                                'attributes' => [
                                    'hasil_putusan' => [
                                        'label' => 'Hasil Putusan',
                                        'labelSpan' => 2,
                                        'columns' => 8,
                                        'attributes' => [
                                            'hasil_putusan' => [
                                                'type' => Form::INPUT_RADIO_LIST,
                                                'items' => [1 => 'Ditolak', 3 => 'Bebas'],
                                                'options' => ['inline' => true],
                                                'columnOptions' => ['colspan' => 12],
                                            ],
                                        ]
                                    ],
                                ]
                            ]);
                            ?>
                            <fieldset>
                                <div class="kv-nested-attribute-block form-sub-attributes form-group">
                                    <label class="col-sm-2 control-label">
                                        Upload File
                                    </label>

                                    <div class="col-sm-6">
                                        <div class="row">
                                            <?php echo $form->field($model, 'upload_file')->widget(FileInput::className(), [
                                                'options' => [
                                                    //'accept' => 'image/*'
                                                    'multiple' => false,
                                                ],
                                                'pluginOptions' => [
                                                    //'uploadUrl' => Url::to('@web/modules/pidum/upload_file/b4/'),
                                                    'showPreview' => true,
                                                    'showUpload' => false,
                                                    'browseLabel' => 'Pilih',
                                                ],
                                            ]); ?>
                                        </div>
                                        <div class="row">
                                            <?php if (!$model->isNewRecord && !empty($model['upload_file'])) { ?>
                                                <label
                                                    class="control-label col-md-12"><?= Html::label($model['upload_file']); ?></label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <hr style="border-color: #c7c7c7;margin: 10px 0;">

                    <div class="box-footer">
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil-square-o"></i> Simpan' : '<i class="fa fa-retweet"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                            <?= Html::button('Kembali',['class'=>'btn btn-primary','onclick'=>'batal()']); ?>
                            <?php /*echo Html::button('Hapus',['class'=>'btn btn-primary']); */?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </div>
</div>

<?php $btn = <<< JS
        function batal() {
            $("#m_tun").modal('hide');
        }
JS;
$this->registerJs($btn);
?>