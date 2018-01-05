<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB2;
use app\modules\pidum\models\PdmPenandatangan;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB2 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b2-form">

    <?php 
        $form = ActiveForm::begin(
           [
                'id' => 'b2-form',
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
                    Tindakan Mendesak
                </h3>
            </div>
            <div class="box-body">
                <?php echo $form->field($model, 'uraian')->textarea(['value' => '<p dir="ltr"><span style="background-color:transparent; color:#000000; font-family:arial; font-size:14
.666666666666666px">a . Penggeledahan, tempat, rumah. pakaian, penggeledahan badan atau...</span></p>

<p dir="ltr"><span style="background-color:transparent; color:#000000; font-family:arial; font-size:14
.666666666666666px">b. Penyitaan Atas.......................................................</span></p>
<span style="background-color:transparent; color:#000000; font-family:arial; font-size:14.666666666666666px">c. Dan barang-barang yang dianggap perlu.</span>']) ?>

                <?php

                $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                $this->registerJs("
                                CKEDITOR.inline( 'PdmB2[uraian]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                ?>
            </div>
        </div>
    </div>
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B2, 'id_table' => $model->id_b2]) ?>

    <div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if(!$model->isNewRecord){ ?>
           <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-b2/cetak?id_b2='.$model->id_b2])?>">Cetak</a>
        <?php } ?>
        
    </div>

    <?php ActiveForm::end(); ?>

</div>
