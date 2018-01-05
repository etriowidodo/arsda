<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB15;
use app\modules\pidum\models\PdmPenandatangan;
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
/* @var $model app\modules\pidum\models\PdmB15 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-b15-form">

    <?php
    $form = ActiveForm::begin(
                    [
                        'id' => 'b15-form',
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


    <div class="box-body">
        <div class="form-group">
            <div class="col-sm-12">
                <div class="box box-warning">
                    <div class="box-header">
                        <h3 class="box-title">
                            DETAIL BARANG 
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label col-sm-2">Berupa :</label>
                            <div class="col-sm-8">
                                <?php echo $form->field($model, 'keterangan')->textarea() ?>


                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </div>



    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::B15, 'id_table' => $model->id_b15]) ?>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b15/cetak?id=' . $model->id_b15]) ?>">Cetak</a>
        <?php endif ?>  
    </div>



    <?php ActiveForm::end(); ?>

</div>
