<?php

use app\components\ConstDataComponent;
use app\modules\pidum\models\PdmD1;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\VwPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmD1 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-d1-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'd1-form',
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
                    ]
    );
    ?>
    <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>

    <div class="box box-warning">
        <div class="box-header">
            <h5 class="col-md-12">
                <span style="float:left;font-weight: bold;">PIHAK YANG DIPANGGIL</span>
            </h5>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <div class="col-md-12">
                    <table class="table table-bordered" id="gridPihak">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                                    <tr id='trPihak'>
                                        <td style="width:25%;"><input type="text" class="form-control" disabled="true" name="no_nama[]"  value="<?= $modelTerpanggil->nama ?>" ></td>
                                        <td style="width:45%;"><input type="text" class="form-control" disabled="true" name="txtalamat[]" value="<?= $modelTerpanggil->alamat ?>"></td>
                                        <td style="width:25%;"><input type="text" class="form-control" disabled="true" name="txtpekerjaan[]" value="<?= $modelTerpanggil->pekerjaan ?>"></td>
                                    </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                UNDANGAN KEJAKSAAN
            </h3>
            <hr style="border-color: #c7c7c7;margin: 10px 0;">
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Tanggal</label>
                    <div class="col-md-3">
                        <?=
                        $form->field($model, 'tgl_panggil')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                //'options' => [
                                //    'placeholder' => 'Tanggal Dikeluarkan',
                                //],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                //'endDate' => '+1y'
                                ]
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-md-5">
                                     <?php
                                        echo Form::widget([ /* waktu kunjungan */
                                            'model' => $model,
                                            'form' => $form,
                                            'columns' => 3,
                                            'attributes' => [
                                                'jam_panggil' => [
                                                    'label' => 'Jam',
                                                    'labelSpan' => 2,
                                                    'columns' => 12,
                                                    'attributes' => [
                                                        'jam_panggil' => [
                                                            'type' => Form::INPUT_WIDGET,
                                                            'widgetClass' => '\kartik\widgets\TimePicker',
                                                            'options' => [
                                                                'pluginOptions'=>[
                                                                    //'template'=>false,
                                                                    'defaultTime'=>false,
                                                                    'showSeconds'=>false,
                                                                    'showMeridian'=>false,
                                                                    'minuteStep'=>1,
                                                                ],
                                                                'options' => [
                                                                    'placeholder'=>'Jam Panggil'
                                                                ]
                                                            ],
                                                            'columnOptions' => ['colspan' => 6],
                                                        ],
                                                    ]
                                                ],
                                            ]
                                        ]);
                                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-md-2">Menghadap</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'menghadap')->textInput(['maxlength' => true]) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                KETENTUAN (KELENGKAPAN)
            </h3>
            <hr style="border-color: #c7c7c7;margin: 10px 0;">
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Harus Melunasi</label>
                    <div class="col-md-4">
                        <?php
                        $listData = PdmMsStatusData::findAll(['is_group' => ConstDataComponent::LunasiD1, 'flag'=>1]);
                        $new = array();
                        foreach ($listData as $key) {
                            $new = $new + [$key->id => $key->nama];
                        }
                        echo $form->field($model, 'id_msstatusdata')
                                //->radioList($new);
                                ->radioList($new, ['inline' => false]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Penanda Tangan</label>
                    <div class="col-md-4">
                        <?=
                           $form->field($model, 'nama_ttd', [
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
        </div>
    </div>


    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                PENYAMPAI PANGGILAN (RELAS)
            </h3>
            <hr style="border-color: #c7c7c7;margin: 10px 0;">
        </div>
        <div class="box-body">
            <div class="col-md-12 hide">
                <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-md-4">
                        <?php 
                        /*$form->field($model, 'nama_ttd', [
                            'addon' => [
                                'append' => [
                                    'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                    'asButton' => true
                                ]
                            ]
                        ]);*/
                        ?>
                    </div>
                </div>
            </div>

        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Tanggal Relas</label>
                <div class="col-md-3">
                    <?=
                    $form->field($model, 'tgl_relas')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            //'options' => [
                            //    'placeholder' => 'Tanggal Dikeluarkan',
                            //],
                            'pluginOptions' => [
                                'autoclose' => true,
                            //'endDate' => '+1y'
                            ]
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-md-5">
                                 <?php
                                    echo Form::widget([ /* waktu kunjungan */
                                        'model' => $model,
                                        'form' => $form,
                                        'columns' => 3,
                                        'attributes' => [
                                            'jam_relas' => [
                                                'label' => 'Jam Relas',
                                                'labelSpan' => 2,
                                                'columns' => 12,
                                                'attributes' => [
                                                    'jam_relas' => [
                                                        'type' => Form::INPUT_WIDGET,
                                                        'widgetClass' => '\kartik\widgets\TimePicker',
                                                        'options' => [
                                                            'pluginOptions'=>[
                                                                //'template'=>false,
                                                                'defaultTime'=>false,
                                                                'showSeconds'=>false,
                                                                'showMeridian'=>false,
                                                                'minuteStep'=>1,
                                                            ],
                                                            'options' => [
                                                                'placeholder'=>'Jam Panggil'
                                                            ]
                                                        ],
                                                        'columnOptions' => ['colspan' => 6],
                                                    ],
                                                ]
                                            ],
                                        ]
                                    ]);
                                    ?>
                </div>
            </div>
        </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'nama_relas')->textInput() ?>
                    </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Pangkat</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'pangkat_relas')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $form->field($model, 'id_penandatangan')->hiddenInput() ?>

    <?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>

    <?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-d1/cetak?no_surat=' . $model->no_surat]) ?>">Cetak</a>
        <?php endif ?>	
    </div>
    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Penandatangan',
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

