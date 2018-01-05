<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmP51;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\Session;
use yii\web\View;

/* @var $this View */
/* @var $model PdmP51 */
/* @var $form ActiveForm */
?>

<div class="pdm-p51-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'p51-form',
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
        <div class="box-header">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tersangka/Terdakwa</label>
                        <div class="col-md-8">
                            <?php
                            $session = new Session();
                            $idPERKARA = $session->get('id_perkara');
                            $tersangka = (new Query())
                                    ->select(['id_tersangka', 'nama'])
                                    ->from('pidum.ms_tersangka')
                                    ->where("id_perkara='" . $idPERKARA . "'")
                                    ->all();
                            $listnama = ArrayHelper::map($tersangka, 'id_tersangka', 'nama');
                            echo $form->field($model, 'id_tersangka')->dropDownList($listnama, ['prompt' => '---Pilih Tersangka---'], ['label' => '']);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kawin / Belum</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'stat_kawin')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nama Orang Tua</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'ortu')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Jatuh Pidana</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_jth_pidana')->widget(DateControl::className(), [
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
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Hukum Tetap</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_hkm_tetap')->widget(DateControl::className(), [
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
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pidana dikenakan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'denda')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pidana pokok</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'pokok')->textInput() ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pidana Tambahan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'tambahan')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Masa Percobaan</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'percobaan')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Mulai Percobaan</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_awal_coba')->widget(DateControl::className(), [
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
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Akhir Percobaan</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_akhir_coba')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    //'endDate' => '+1y'
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Syarat Khusus</label>
                        <div class="col-md-8">
                            <?= $form->field($model, 'syarat')->textInput(['maxlength' => true]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="box box-warning">
        <div class="box-header">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Dikeluarkan</label>
                        <div class="col-md-4">
                            <?= $form->field($model, 'dikeluarkan')->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-md-4">
                            <?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    //'endDate' => '+1y'
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

    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->id_p51, 'GlobalConst' => GlobalConstMenuComponent::P51]) ?>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-p51/cetak?id=' . $model->id_p51]) ?>">Cetak</a>
        <?php endif ?>	
    </div>

    <?php ActiveForm::end(); ?>

</div>