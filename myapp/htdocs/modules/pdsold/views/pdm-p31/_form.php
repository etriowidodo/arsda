<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 'p31-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false,
                            ]
                        ]
                )
        ?>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">

            <div class="col-md-8">
                <label class="control-label col-md-3">Nomor</label>
                <div class="col-md-6">
                    <?= $form->field($model, 'no_surat_p31')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

        </div>
        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>Terdakwa</strong>
                </h3>
            </div>
            <div class="box-header with-border">
                <?php
                // if ($modelTersangka != null) {
                $layout = <<< HTML
                                
                                <div class="clearfix"></div>
                                {items}
                                <div class="col-sm-5">&nbsp;</div><div class="col-sm-2">{pager}</div><div class="col-sm-5">&nbsp;</div>
HTML;
                echo kartik\grid\GridView::widget([
                    'id' => 'tersangka',
                    'dataProvider' => $dataProviderTersangka,
                    'layout' => $layout,
                    'columns' => [
                        ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width: 3%']],
                        'nama'
                    ],
                    'export' => false,
                    'pjax' => true,
                    'responsive' => true,
                    'hover' => true,
                ]);


                // }
                ?>
            </div>
        </div>
        <?php
        // echo Form::widget([ /* nomor perkara */
        //     'model' => $model,
        //     'form' => $form,
        //     'columns' => 1,
        //     'attributes' => [
        //         'nomor_perkara' => [
        //             'label' => 'Nomor Perkara',
        //             'labelSpan' => 2,
        //             'columns' => 8,
        //             'attributes' => [
        //                 'id_perkara' => [
        //                     'type' => Form::INPUT_TEXT,
        //                     'columnOptions' => ['colspan' => 4],
        //                 ],
        //             ]
        //         ],
        //     ]
        // ]);
        ?>
        <?php
        /*            echo Form::widget([
          'model' => $model,
          'form' => $form,
          'columns' => 1,
          'attributes' => [
          'terdakwa' => [
          'label' => 'Terdakwa',
          'labelSpan' => 3,
          'columns' => 8,
          'attributes' => [
          'id_tersangka' => [
          'type' => Form::INPUT_DROPDOWN_LIST,
          'options' => ['prompt' => 'Pilih Terdakwa'],
          'items' => ArrayHelper::map($terdakwa, 'id_tersangka', 'nama'),
          'columnOptions' => ['colspan' => 5],
          ],
          ]
          ],
          ]
          ]);
         */
        ?>
        <!-- <div class="form-group">
            <label class="control-label col-sm-2">Nama</label>

            <div class="col-sm-3">
        <?php
        /*echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp, $this);*/
        ?>
            </div>
        </div>
        <div id="data-terdakwa">
        <?php
//                    if ($model->id_tersangka != null)
//                        echo Yii::$app->globalfunc->getIdentitasTerdakwa($model->id_tersangka);
//                    
        ?>
        </div> -->


        <div class="form-group">
            <label class="control-label col-sm-2">Melimpahkan Ke Pengadilan</label>
            <div class="col-sm-5">
                <?php $conf = Yii::$app->globalfunc->GetConfSatker() ; 
                echo $form->field($model, 'lokasi_pengadilan')->textInput(['value'=> $model->isNewRecord ? $conf->p_negeri : $model->lokasi_pengadilan]);
                ?>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-sm-2">Tetap Ditahan</label>
            <div class="col-sm-3">
                <?php
                $nama = (new \yii\db\Query())
                        ->select(['id_loktahanan', "nama as nama_lokasi"])
                        ->from('pidum.ms_loktahanan')
                        ->all();
                $listnama = ArrayHelper::map($nama, 'id_loktahanan', 'nama_lokasi');
                echo $form->field($model, 'id_ms_loktahanan')->dropDownList($listnama, ['prompt' => '---Pilih lokasi---'], ['label' => '']);
                ?>
            </div>
        </div>



        <div class="box box-primary" style="border-color: #f39c12;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title" style="margin-top: 5px;">
                    <strong>Penahanan</strong>
                </h3>
            </div>
            <div class="box-header with-border" style="border-bottom:none;">

                <?php
                echo Form::widget([ /* Pencabutan Penahanan */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'dikeluarkan' => [
                            'label' => 'Dikeluarkan di',
                            'labelSpan' => 2,
                            'columns' => 8,
                            'attributes' => [
                                'dikeluarkan' => [
                                    'type' => Form::INPUT_TEXT,
                                    'options' => [
                                        'placeholder' => 'Dikeluarkan di',
                                        'value' => strtolower(Yii::$app->globalfunc->getSatker($modelSpdp->wilayah_kerja)->inst_lokinst)
                                    ],
                                    'columnOptions' => ['colspan' => 4],
                                ],
                                'tgl_dikeluarkan' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\datecontrol\DateControl',
                                    'options' => [
                                        'options' => [
                                            'options' => ['placeholder' => 'Tanggal Dikeularkan']
                                        ]
                                    ],
                                    'columnOptions' => ['colspan' => 4],
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
                <?php
                // echo Form::widget([ /* dakwaan */
                //     'model' => $model,
                //     'form' => $form,
                //     'columns' => 1,
                //     'attributes' => [
                //         'dakwaan' => [
                //             'label' => 'Dakwaan',
                //             'labelSpan' => 2,
                //             'columns' => 8,
                //             'attributes' => [
                //                 'catatan' => [
                //                     'type' => Form::INPUT_TEXTAREA,
                //                     'columnOptions' => ['colspan' => 8],
                //                 ],
                //             ]
                //         ],
                //     ]
                // ]);
                ?> 


<?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P31, 'id_table' => $model->no_surat_p31]) ?>

                <div class="box-footer" style="text-align: center;">
                    <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
                    <?php if (!$model->isNewRecord) { ?>
                        <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p31/cetak?id=' . $model->no_register_perkara]) ?>">Cetak</a>
                    <?php } ?>
                </div>
<?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>
<?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>
<?= $form->field($model, 'nama_ttd')->hiddenInput() ?>

<?php ActiveForm::end(); ?>
            </div>
            </section>

