<?php

use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;

//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MkjBapeg */
/* @var $form yii\widgets\ActiveForm */
?>

    <div class="mkj-bapeg-form">
    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'tun-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'action' => $model->isNewRecord ? Url::toRoute('mkj-bapeg/create') : Url::toRoute('mkj-bapeg/update?id=' . $model->id_mkj_bapeg),
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 1,
                'showLabels' => false,
            ],
            'options' => [
                'enctype' => 'multipart/form-data',
            ]
        ]
    )
    ?>

        <div class="modal-body">
            <section class="content" style="padding: 0px;">
                <div class="content-wrapper-1">
                    <div class="box box-primary">
                        <div class="box-header with-border" style="border-color: #c7c7c7;">
                            <?php
                            // echo Form::widget([ /* terlapor */
                            //     'model' => $model,
                            //     'form' => $form,
                            //     'columns' => 1,
                            //     'attributes' => [
                            //         'terlapor' => [
                            //             'label' => 'Terlapor',
                            //             'labelSpan' => 2,
                            //             'columns' => 8,
                            //             'attributes' => [
                            //                 'id_terlapor' => [
                            //                     'type' => Form::INPUT_DROPDOWN_LIST,
                            //                     'options' => ['prompt' => 'Pilih Terlapor'],
                            //                     'items' => ArrayHelper::map($terlapor, 'id_terlapor', 'terlapor'),
                            //                     'columnOptions' => ['colspan' => 6],
                            //                 ],
                            //             ]
                            //         ],
                            //     ]
                            // ]);
                            ?>

                        </div>
                    </div>
                    <hr style="border-color: #c7c7c7;margin: 10px 0;">

                    <div class="box-footer">
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? '<i class="fa fa-pencil-square-o"></i> Simpan' : '<i class="fa fa-retweet"></i> Simpan', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
                            <?= Html::button('Kembali', ['class' => 'btn btn-primary', 'onclick' => 'batal()']); ?>
                            <?php //echo Html::button('Hapus', ['class' => 'btn btn-primary', 'onclick' => 'hapus()']); */?>
                        </div>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </section>
        </div>
    </div>

