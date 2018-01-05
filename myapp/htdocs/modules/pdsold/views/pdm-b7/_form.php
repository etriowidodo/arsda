<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use dosamigos\ckeditor\CKEditorInline;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB7 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b7-form">

    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'b7-form',
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
    <div class="col-sm-12">
        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>

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
                        echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp);
                        ?>
                    </div>
                </div>
                <div id="data-terdakwa">
                    <?php
                    if ($model->id_tersangka != null)
                        echo Yii::$app->globalfunc->getIdentitasTerdakwa($model->id_tersangka);
                    ?>

                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Rincian Barang Sitaan
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">Berupa</label>
                    <div class="col-sm-8">
                        <?php echo $form->field($model, 'barbuk')->textarea(['value'=>$barbuk,'readonly'=>true]) ?>

                        <?php

                            $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                            $this->registerJs("
                                CKEDITOR.inline( 'PdmB7[barbuk]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    Permintaan Tindakan
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-2">Agar Melakukan</label>
                    <div class="col-sm-8">
                        <?php echo $form->field($model, 'tindakan')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmB7[tindakan]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>

            </div>
        </div>

         <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->id_b7, 'GlobalConst' => GlobalConstMenuComponent::B7]) ?>
    </div>

   



    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-b7/cetak?id_b7='.$model->id_b7])?>">Cetak</a>
    </div>

    <?php ActiveForm::end(); ?>

</div>
