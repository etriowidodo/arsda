<?php

use app\components\ConstDataComponent;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmB22;
use app\modules\pidum\models\PdmMsStatusData;
use kartik\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmB22 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-b22-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'b22-form',
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

    <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>

    <div class="box box-warning">
        <div class="box-header">
            <h3 class="box-title">
                PELAKSANAAN
            </h3>
        </div>
        <div class="box-body">
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Tindakan</label>
                    <div class="col-md-10">
                        <?php
                        $listData = PdmMsStatusData::findAll(['is_group' => ConstDataComponent::TindakanB22]);
                        $new = array();
                        foreach ($listData as $key) {
                            $new = $new + [$key->id => $key->nama];
                        }
                        echo $form->field($model, 'id_tindakan')
                                //->radioList($new);
                                ->radioList($new, ['inline' => false]);
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="form-group">
                    <label class="control-label col-md-2">Jenis Barang</label>
                    <div class="col-md-10">
                        <?php
                        $listData2 = PdmMsStatusData::findAll(['is_group' => ConstDataComponent::JenisB22]);
                        $new2 = array();
                        foreach ($listData2 as $key) {
                            $new2 = $new2 + [$key->id => $key->nama];
                        }
                        echo $form->field($model, 'id_jnsbarang')
                                //->radioList($new);
                                ->radioList($new2, ['inline' => false]);
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'id_table' => $model->id_b22, 'GlobalConst' => GlobalConstMenuComponent::B22]) ?>

   

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b22/cetak?id=' . $model->id_b22]) ?>">Cetak</a>
        <?php endif ?>	
    </div>

    <?php ActiveForm::end(); ?>

</div>
