<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\VwTerdakwaT2;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP27 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>

<?php
$form = ActiveForm::begin(
        [
            'id' => 'p27-form',
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

<div class="content-wrapper-1">
    <div class="pdm-p27-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No Surat P-27</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_surat_p27')->textInput(['placeholder' => 'No Surat P-27']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl Surat</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_ba')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl Surat'],
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
                    </div>
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tersangka</label>
                                        <div class="col-md-6">
                                            <?php
//                                            echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register, $this);
                                                echo $form->field($model, 'id_tersangka')->dropDownList(
                                                ArrayHelper::map(VwTerdakwaT2::find()->where(['no_register_perkara'=>$no_register])->all(), 'no_urut_tersangka', 'nama'), ['prompt' => 'Pilih Tersangka']);
                                            ?>
                                        </div>
                                    </div>
<!--                                    <div id="data-terdakwa">
                                        <?php
//                                        if ($model->id_tersangka != null)
//                                            echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
                                        ?>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No. Putusan</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_putusan')->textInput(['placeholder' => 'No Putusan']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. Putusan</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_putusan')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl. Putusan'],
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
                        <div class="row" style="height: 70px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Ket. Tersangka</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'keterangan_tersangka')->textarea(['placeholder' => 'Ket. Tersangka']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 70px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Ket. Saksi</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'keterangan_saksi')->textarea(['placeholder' => 'Ket. Saksi']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Dari Benda</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'dari_benda')->textInput(['placeholder' => 'Dari Benda']); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Dari Petunjuk</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'dari_petunjuk')->textInput(['placeholder' => 'Dari Petunjuk']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 70px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Alasan</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'alasan')->textarea(['placeholder' => 'Alasan']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Dikeluarkan di</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'dikeluarkan')->textInput(['placeholder' => 'Dikeluarkan','value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst]); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. Dikeluarkan</label>
                                        <div class="col-md-8">
                                            <?=$form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl. Dikeluarkan'],
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
                    </div>
                </div>
                <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P27, 'id_table' => $model->no_surat_p27]) ?>
                <div class="box-footer" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if (!$model->isNewRecord): 
                    echo Html::a('Cetak', ['cetak', 'id' => rawurlencode($model->no_surat_p27)], ['class' => 'btn btn-warning']);?>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php
$script = <<< JS
        $('.tambah-tembusan').click(function(){
            $('.tembusan').append(
           '<br /><input type="text" class="form-control" style="margin-left:60px"name="mytext[]">'
            )
        });

JS;
$this->registerJs($script);
?>