<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB1;
use app\modules\pidum\models\VwPenandatangan;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB1 */
/* @var $form ActiveForm2 */
?>


<div class="pdm-b1-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'b1-form',
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

    <div class="col-sm-6">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    BARANG BUKTI DUGAAN
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-4">Berupa</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'barbuk')->textarea() ?>

                        <?php
                        $this->registerCss("div[contenteditable] {
                                outline: 1px solid #d2d6de;
                                min-height: 100px;
                            }");
                        $this->registerJs("
                                CKEDITOR.inline( 'PdmB1[barbuk]');
                                CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                CKEDITOR.config.autoParagraph = false;

                            ");
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Pelanggaran Pasal</label>
                    <div class="col-sm-8">
                        <?php echo Yii::$app->globalfunc->getDaftarPasal($model->id_perkara); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Berlokasi</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'simpan_di') ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Diduga</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'telah_diduga')->textarea(); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Dikuasai</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'dikuasai'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Barang Diduga</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'barang_diduga')->textarea(); ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box box-warning" style="height:240px;">
            <div class="box-header">
                <h3 class="box-title">
                    PELENGKAP
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-sm-4">Surat Penetapan Ijin Penggeledahan / Penyitaan</label>
                    <div class="col-sm-8">
                        <?= $form->field($model, 'penyitaan')->textarea() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B1, 'id_table' => $model->id_b1]) ?>
    <div class="col-sm-12">
        <div class="form-group" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord) {
                ?>
                <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-b1/cetak?id=' . $model->id_b1]) ?>">Cetak</a> 
                <?php
            }
            ?>

        </div>
    </div>
</div>

<?php ActiveForm::end(); ?>

