<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\modules\pidum\models\VwPenandatangan;
use app\components\GlobalConstMenuComponent;
use kartik\widgets\DatePicker;
use kartik\datecontrol\DateControl;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP35 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'p35-form',
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
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-sm-12">
            <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_p35']) ?>

            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">
                        <i class="glyphicon glyphicon-user"></i> Terdakwa
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group">
                        <label class="control-label col-sm-2">Nama</label>
                        <div class="col-sm-4">
                            <?php
                            echo $form->field($model, 'no_reg_tahanan')->hiddenInput(['class'=>'no_reg_tahanan']);

                            echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register_perkara,'');
                            ?>
                        </div>
                    </div>
                    <div id="data-terdakwa">
                        <?php
                        if ($model->id_tersangka != null)
                            echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
                        ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-sm-12">
            <div class="box-body">
                <div class="form-group" >
                    <label class="control-label col-sm-2">Dilimpahkan Ke :</label>
                        <div class="col-sm-3">
                        <?php 
                            if(!$model->isNewRecord){
                                echo $form->field($model, 'dilimpahkan')->textInput();
                            }else{
                                echo $form->field($model, 'dilimpahkan')->textInput(['value'=>Yii::$app->globalfunc->GetConfSatker(Yii::$app->session->get('inst_satkerkd'))->p_negeri]);
                            }
                        ?>
                        </div>
                    <label class="control-label col-sm-2">Tanggal Dilimpahkan</label>
                        <div class="col-sm-2">
                        <?=
                            $form->field($model, 'tgl_limpah')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                    ]
                                ]
                            ]);
                        ?>
                        </div>
                </div>
            </div>

        </div>

        <div class="col-sm-12">
            <div class="box box-warning">
                <div class="box-header">
                    <h3 class="box-title">
                       Dakwaan
                    </h3>
                </div>
                <div class="box-body">
                    <div class="form-group"> 
                        <div class="col-sm-10">
                            <?php if($model->isNewRecord): ?>
                                <?= $form->field($model, 'dakwaan')->textarea(['rows' => 5, 'value' => $modelP29->dakwaan]) ?>
                            <?php else: ?>
                                <?= $form->field($model, 'dakwaan')->textarea(['rows' => 5]) ?>
                            <?php endif; ?>

                            <?php
                            $this->registerCss("div[contenteditable] {
                                    outline: 1px solid #d2d6de;
                                    min-height: 100px;
                                }");
                            $this->registerJs("
                                    CKEDITOR.inline( 'PdmP35[dakwaan]');
                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                    CKEDITOR.config.autoParagraph = false;

                                ");
                            ?>

                        </div>
                    </div>

                </div>
            </div>
        </div>
</div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P35, 'id_table' => $model->no_surat_p35]) ?>

        <div class="col-sm-12">
            <div class="box-body">
                <div class="form-group" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if (!$model->isNewRecord): ?>
                        <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p35/cetak?id=' . $model->no_surat_p35]) ?>">Cetak</a>
                    <?php endif; ?>
                </div>
            </div>

        </div>
<?= $form->field($model, 'nama_ttd')->hiddenInput() ?>
<?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>
<?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>
<?php ActiveForm::end(); 

?>
    </div>

</section>
