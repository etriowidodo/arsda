<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmB12;
use app\modules\pdsold\models\VwPenandatangan;
use app\modules\pdsold\models\PdmMsBendaSitaan;
use app\modules\pdsold\models\PdmBarangsitaanB12;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB12 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b12-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'b12-form',
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
    </div>

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">

                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-md-2">Berupa</label>
                    <div class="col-sm-6">
                        <?php echo $form->field($model, 'barbuk')->textarea() ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Jenis</label>
                    <div class="col-sm-6">
                        <div class="form-group field-pdmbarangsitaanb14-id_msbendasitaan required">

                            <div class="col-sm-12">
                                <div id="nama">
                                    <?php foreach ($model2 as $data_barbuk): ?>
                                        <div class="checkbox"><label><input type="checkbox" value="<?= $data_barbuk['id'] ?>" <?= $data_barbuk['is_checked'] ?> name="id_msbendasitaan[]"> <?= $data_barbuk['nama'] ?></label></div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <div class="col-sm-12"></div>
                            <div class="col-sm-12"><div class="help-block"></div></div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Hasil Penelitian</label>
                    <div class="col-sm-6">
                        <?php echo $form->field($model, 'hasil_penelitian')->textarea() ?>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B12, 'id_table' => $model->id_b12]) ?>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b12/cetak?id=' . $model->id_b12]) ?>">Cetak</a>
        <?php endif ?>  
    </div>



    <?php ActiveForm::end(); ?>

</div>