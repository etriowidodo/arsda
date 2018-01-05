<?php

use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmMsAlasanP26;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP26 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>
<?php
$form = ActiveForm::begin(
                [
                    'id' => 'p26-form',
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
<div class="box box-primary" style="border-color: #f39c12;padding: 15px;">
    
    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 1,
        'attributes' => [
            'no_surat_p26' => [
                'label' => 'Nomor Surat',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'no_surat_p26' => [
                        'type' => Form::INPUT_TEXT,
                        'options' => [
                            'placeholder' => 'Nomor Surat P26',
                        ],
                    ],
                ],
            ],
        ],
    ]);
    ?>
    
   
    
    <div class="form-group">
        <label for="nama" class="control-label col-md-2">Jaksa Pelaksana</label>
        <div class="col-md-3" style="width: 365px">
            <?php
                if ($model->isNewRecord) {?>
                    <div class="form-group field-pdmjaksasaksi-nama required">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                <div class="input-group-btn">
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12">
                            <div class="help-block"></div>
                        </div>
                    </div>
            <?php
                } else {
            ?>
            <!--<input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">-->
              
                    <div class="form-group field-pdmjaksasaksi-nama required">
                        <div class="col-sm-12">
                            <div class="input-group">
                                <input value ="<?= $modeljaksi['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                <div class="input-group-btn">
                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                </div>
                            </div>
                            <?php
                            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
                            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                            ?>
                        </div>
                        <div class="col-sm-12"></div>
                        <div class="col-sm-12">
                            <div class="help-block"></div>
                        </div>
                    </div>
                    <?php
                }
                ?>
        </div>
    </div>
    <div class="panel box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">
                <i class="glyphicon glyphicon-user"></i> Terdakwa
            </h3>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Nama</label>
            <div class="col-sm-4">
                <?php
//                echo Yii::$app->globalfunc->getTerdakwa($form, $model, $modelSpdp, $this);
                echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register, $this);
                ?>
            </div>
        </div>
        <div id="data-terdakwa">
            <?php
            if ($model->id_tersangka != null)
                echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($model->no_register_perkara,$model->id_tersangka);
//                echo 'celek';
            ?>

        </div>
    </div>
    
    <div class="form-group">
            <label class="control-label col-sm-2">Alasan</label>
            <div class="col-sm-3"  style="width: 365px">
                <select name="alasan" id="alasan" class="form-control" placeholder="" style="width:100%" >
                        <option>--Pilih--</option>
                        <?php 
                            $als = PdmMsAlasanP26::findBySql("select * from pidum.pdm_ms_alasan_p26 order by id")->asArray()->all();;
                            foreach($als as $id){
                                $selected = ($id['id'] == $model['alasan'])?'selected':'';
                                echo '<option value="'.$id['id'].'" '.$selected.'>'.$id['nama'].'</option>';
                            }
                        ?>
                    </select>
            </div>
        </div>
    <br/>
    <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'tgl_ba' => [
                'label' => 'Tanggal BA JPU',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'tgl_ba' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\datecontrol\DateControl',
                        'options' => [
                            'options' => [
                                'options' => ['placeholder' => 'Tanggal BA JPU']
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'tgl_persetujuan' => [
                'label' => 'Tanggal Persetujuan JA',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'tgl_persetujuan' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\datecontrol\DateControl',
                        'options' => [
                            'options' => [
                                'options' => ['placeholder' => 'Tanggal Persetujuan JA']
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);

    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'no_persetujuan' => [
                'label' => 'Nomor Persetujuan',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'no_persetujuan' => [
                        'type' => Form::INPUT_TEXT,
                        'options' => [
                            'options' => [
                                'options' => ['placeholder' => 'Nomor Persetujuan']
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'Kasus_posisi' => [
                'label' => 'Kasus Posisi',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'kasus_posisi' => [
                        'type' => Form::INPUT_TEXTAREA,
                        'options' => [
                            'placeholder' => 'Kasus Posisi'
                        ],
                    ],
                ],
            ],
        ],
    ]);
   /* echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'pasal_disangka' => [
                'label' => 'Pasal',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'pasal_disangka' => [
                        'type' => Form::INPUT_TEXTAREA,
                        'options' => [
                            'placeholder' => 'Pasal Disangka'
                        ],
                    ],
                ],
            ],
        ],
    ]);*/
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'barbuk' => [
                'label' => 'Barang Bukti',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'barbuk' => [
                        'type' => Form::INPUT_TEXTAREA,
                        'options' => [
                            'placeholder' => 'Barang Bukti'
                        ],
                    ],
                ],
            ],
        ],
    ]);
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'dikeluarkan' => [
                'label' => 'Dikeluarkan Di',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'dikeluarkan' => [
                        'type' => Form::INPUT_TEXT,
                        'options' => [
                            'placeholder' => 'Dikeluarkan Di',
                            'value' => \Yii::$app->globalfunc->getSatker()->inst_lokinst
                        ],
                    ],
                ],
            ],
        ],
    ]);
    ?>
    
     <?php
    echo Form::widget([
        'model' => $model,
        'form' => $form,
        'columns' => 2,
        'attributes' => [
            'tgl_surat' => [
                'label' => 'Tanggal Dikeluarkan',
                'labelSpan' => 2,
                'columns' => 3,
                'attributes' => [
                    'tgl_surat' => [
                        'type' => Form::INPUT_WIDGET,
                        'widgetClass' => '\kartik\datecontrol\DateControl',
                        'options' => [
                            'options' => [
                                'options' => ['placeholder' => 'Tanggal Surat']
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ]);
    ?>
    
    

    
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P26, 'id_table' => $model->no_surat_p26]) ?>
    
    <!--<hr style="border-color: #c7c7c7;margin: 10px 0;">-->
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord): 
            echo Html::a('Cetak', ['cetak', 'id' => rawurlencode($model->no_surat_p26)], ['class' => 'btn btn-warning']);?>
            <!--<a class="btn btn-warning" href="<?// Url::to(['pdm-p26/cetak?id=' . $model->no_surat_p26]) ?>">Cetak</a>-->
        <?php endif ?>	
        <?php  //} else {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                    ?>
        <?php
//        if (!$model->isNewRecord) {
//            echo $form->field($modeljaksi, 'nip')->hiddenInput();
//            echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
//            echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_register_perkara')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
//        } else {
            echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', null, ['id' => 'pdmjaksasaksi-no_register_perkara']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_surat_p16a]', null, ['id' => 'pdmjaksasaksi-no_surat_p16a']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_urut]', null, ['id' => 'pdmjaksasaksi-no_urut']);
            echo Html::hiddenInput('PdmJaksaSaksi[nip]', null, ['id' => 'pdmjaksasaksi-nip']);
            echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', null, ['id' => 'pdmjaksasaksi-jabatan']);
            echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', null, ['id' => 'pdmjaksasaksi-pangkat']);
//        }
        ?>
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

<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>