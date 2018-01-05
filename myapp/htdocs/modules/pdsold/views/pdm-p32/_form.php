<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmP20;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmP20 */
/* @var $form ActiveForm2 */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm ::begin(
                        [
                            'id' => 'p32-form',
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
                        <label class="control-label col-md-4">Nomor</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'no_surat_p32')
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No. Reg. Perkara</label>
                        <div class="col-md-8">
                            <?=
                            Html::textInput('no_register_perkara', $ba5->no_register_perkara, ['readOnly' => true, 'class' => 'form-control'])
                            ?>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <!-- <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No. Reg. Tahanan</label>
                        <div class="col-md-8">
                            <?php
                            //Html::textInput('NoRegTahanan', null, ['readOnly' => true, 'class' => 'form-control'])
                            ?>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div> -->
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No. Reg. Bukti</label>
                        <div class="col-md-8">
                            <?=
                            Html::textInput('no_reg_bukti', $ba5->no_reg_bukti, ['readOnly' => true, 'class' => 'form-control'])
                            ?>
                            <div class="help-block"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="col-md-6 hide">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Pengadilan</label>
                        <div class="col-md-8">
                            <?php
                            $pengadilan = (new Query())
                                    ->select('id, nama')
                                    ->from('pidum.pdm_ms_jns_pengadilan')
                                    ->all();
                            $listpengadilan = ArrayHelper::map($pengadilan, 'id', 'nama');
                            echo $form->field($model, 'id_ms_jnspengadilan')->dropDownList($listpengadilan, ['prompt' => '---Pilih Jenis Pengadilan---'], ['label' => '']);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Pelimpahan</label>
                        <div class="col-md-8"><?php
                            echo $form->field($model, 'tgl_pelimpahan')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'endDate' => '+1y'
                                    ]
                                ]
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
                        <label class="control-label col-md-4">Dikeluarkan di</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'dikeluarkan')->textInput(['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst, 'readOnly' => true]) ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">

                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Melimpahkan Ke Pengadilan</label>
                        <div class="col-md-4">
                            <?= $form->field($model, 'lokasi_pengadilan')->textinput(['value'=> $model->isNewRecord ? Yii::$app->globalfunc->GetConfSatker()->p_negeri : $model->lokasi_pengadilan ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Alamat</label>
                        <div class="col-md-4">
                            
                            <?= $form->field($model, 'alamat_pengadilan')->textarea(['value'=> $model->isNewRecord ? Yii::$app->globalfunc->GetConfSatker()->alamat_p_negeri : $model->lokasi_pengadilan ]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8"><?php
                            echo $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::classname(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    // 'endDate' => '+1y'
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-1">Jam</label>
                        <div class="col-md-3"><?php
                            echo $form->field($model, 'jam')
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P32, 'id_table' => $model->no_surat_p32]) ?>

        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php
            if (!$model->isNewRecord) { ?>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p32/cetak?id=' . $model->no_register_perkara]) ?>">
                Cetak</a>

               

            <?php }
            ?>

        </div>
        <?php ActiveForm::end(); ?>

    </div>

</section>
