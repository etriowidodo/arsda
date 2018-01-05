<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\VwTersangka;
use app\modules\pidum\models\VwTerdakwaT2;
use kartik\builder\Form;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\TimePicker;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT9 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
            [
                'id' => 't10-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels' => false,
                ]
            ]
        )
        ?>

        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>Diberikan Kepada</strong>
                </h3>
            </div>
            <br/>
            <div class="row" style="height: 45px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nomor Surat T-10</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'no_surat_t10') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row" style="height: 45px"> 
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'nama') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Pekerjaan</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'pekerjaan') ?>
                            </div>
                        </div>
                    </div>
		</div>
            </div>
            <div class="row" style="height: 45px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Alamat</label>
                            <div class="col-md-8">
                                <?=$form->field($model, 'alamat')->textarea()?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Hubungan</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'hubungan') ?>
                            </div>
                        </div>
                    </div>
		</div>
            </div>
            <br/>
        </div>
        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>Untuk Mengunjungi Tahanan</strong>
                </h3>
            </div>
            <br/>
            <div class="row" style="height: 45px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tahanan</label>
                            <div class="col-md-8">
                                <?php echo $form->field($model, 'id_tersangka')->dropDownList(
                                      ArrayHelper::map(VwTerdakwaT2::find()->where('no_register_perkara=:no_register_perkara',[':no_register_perkara'=>$no_register_perkara])->all(), 'no_urut_tersangka', 'nama'), ['prompt' => 'Pilih Tahanan']);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Keperluan</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'keperluan') ?>
                            </div>
                        </div>
                    </div>
		</div>
            </div>
            <div class="row" style="height: 45px">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Izin Berlaku</label>
                            <div class="col-md-4">
                                <?php
                                    echo $form->field($model, 'jam_mulai')->widget(TimePicker::classname(), [
                                        'pluginOptions'=>[
                                            //'template'=>false,
                                            'defaultTime'=>false,
                                            'showSeconds'=>false,
                                            'showMeridian'=>false,
                                            'minuteStep'=>1,
                                        ],
                                      ]);

                                ?>
                            </div>
                            <div class="col-sm-4">
                                <?php
                                    echo $form->field($model, 'jam_selesai')->widget(TimePicker::classname(), [
                                        'pluginOptions'=>[
                                            //'template'=>false,
                                            'defaultTime'=>false,
                                            'showSeconds'=>false,
                                            'showMeridian'=>false,
                                            'minuteStep'=>1,
                                        ],
                                      ]);
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tanggal Berlaku</label>
                            <div class="col-sm-8" >
                                <?php
                                echo $form->field($model, 'tgl_kunjungan')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options' => [
                                            'placeholder' => 'Tanggal Berlaku',
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'startDate' => '-1m',
                                            'endDate' => '+4m'
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
                            <label class="control-label col-sm-4">Dikeluarkan</label>
                            <div class="col-sm-8">
                                <?php
                                    if($model->isNewRecord){
                                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
                                    }else{
                                       echo $form->field($model, 'dikeluarkan');
                                    } 
                                ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-sm-4">Tanggal Dikeluarkan</label>
                            <div class="col-sm-8">
                                <?php
                                echo $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
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
	<?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T10, 'id_table' => $model->no_surat_t10]) ?>   
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?= Html::a('Batal', ['/pidum/pdm-t10/index'], ['class' => 'btn btn-warning']); ?>
            <?php if(!$model->isNewRecord)
                echo Html::a('Cetak', ['/pidum/pdm-t10/cetak','id'=>  rawurlencode($model->no_surat_t10)], ['class' => 'btn btn-warning']);
            ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>
