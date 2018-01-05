<?php

use app\assets\AppAsset;
use app\modules\pdsold\models\MsAsalsurat;
use app\modules\pdsold\models\MsPenyidik;
use app\modules\pdsold\models\PdmSaksi;
use app\modules\pdsold\models\MsTersangka;
use app\modules\pdsold\models\PdmSaksiAhli;
use app\modules\pdsold\models\PdmBarbuk;
use app\modules\pdsold\models\PdmKetTersangka;
use app\modules\pdsold\models\PdmBa4;
use app\models\MsSifatSurat;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use app\modules\pdsold\models\PdmPkTingRef;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <!--    <div class="box-header"></div>-->
    <?php
    $form = ActiveForm::begin([
                'id' => 'p13-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false,
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);
    ?>

    <?= $this->render('//default/_formHeaderV', ['form' => $form, 'model' => $model, 'kode'=>'_p13']) ?>
    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="form-group">
            <label class="control-label col-md-2">No Surat Perintah</label>
            <div class="col-md-4">
                 <?= $form->field($model, 'no_sp') ?>
            </div>
        </div>
            
      
                <div class="form-group">
                <label class="control-label col-md-2">Tanggal Di keluarkan </label>
                <div class="col-md-4">
                     <?= $form->field($model, 'tgl_sp')->widget(DateControl::className(),[
                    'type'=>DateControl::FORMAT_DATE,
                    'ajaxConversion'=>false,
                    'options' => [
                        'pluginOptions' => [
                            'autoclose' => true
                        ]
                    ]
                ]); ?>
                </div>
                </div>
            
        
                <div class="form-group">
                    <label class="control-label col-md-2">Tersangka</label>

                    <div class="col-md-4">
                      <?php
//                          echo Yii::$app->globalfunc->returnDropDownList($form,$model,PdmBa4::find()->all(),'no_urut_tersangka','nama','id_tersangka',false);
                            $tsk =(new \yii\db\Query())
                            ->select('nama,no_urut_tersangka')
                            ->from('pidum.vw_terdakwat2')
                            ->where(['no_register_perkara' =>$_SESSION['no_register_perkara']])
                            ->all();
                            $list = ArrayHelper::map($tsk,'no_urut_tersangka','nama');
                            echo $form->field($model, 'id_tersangka')->dropDownList($list,
                            ['prompt' => '---Pilih---'],
                            ['label'=>'']);
                            
                     ?>
                    </div>

                </div>
            
       
                      <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'ket_saksi' => [
                            'label' => 'Ket Saksi',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'ket_saksi' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?>
            <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'ket_ahli' => [
                            'label' => 'Ket Ahli',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'ket_ahli' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 
                <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'ket_surat' => [
                            'label' => 'surat surat',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'ket_surat' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 
                <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'petunjuk' => [
                            'label' => 'Barang Bukti/Petunjuk',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'petunjuk' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?>
                <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'ket_tersangka' => [
                            'label' => 'Ket tersangka',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'ket_tersangka' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 
                <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'hukum' => [
                            'label' => 'Fakta Hukum',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'hukum' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 

                 <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'yuridis' => [
                            'label' => 'Pembahasan yuridis',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'yuridis' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 
                <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'kesimpulan' => [
                            'label' => 'Pembahasan kesimpulan',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'kesimpulan' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 
                <?php
                //form no spdp
                echo Form::widget([
                    'model' => $model,
                    'form' => $form,
                    'columns' => 1,
                    'attributes' => [
                        'saran' => [
                            'label' => 'Saran',
                            'labelSpan' => 2,
                            'columns' =>7,
                            'attributes' => [
                                'saran' => [
                                    'type' => Form::INPUT_TEXTAREA,
                                    'options' => [
                                      
                                    ],
                                    'columnOptions' => ['colspan' => 8]
                                ]
                            ],

                        ],
                    ],
                ]);
                ?> 
               

           
                <div class="form-group">
                    <label class="control-label col-md-2">Penanda Tangan</label>

                    <div class="col-md-4">
                      <?php
                $penandatangan=(new \yii\db\Query())
                    ->select('peg_nik,peg_nip_baru,nama')
                    ->from('pidum.vw_penandatangan')
                    ->where(['is_active' =>'1'])
                    ->all();
                $list = ArrayHelper::map($penandatangan,'peg_nip_baru','nama');
                echo $form->field($model, 'id_penandatangan')->dropDownList($list,
                    ['prompt' => '---Pilih---'],
                    ['label'=>'']);
                ?>
                    </div>

                </div>
            
        

    </div>

 <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if(!$model->isNewRecord){ ?>
        <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['p13/cetak?no_surat_p13='.rawurlencode($model->no_surat_p13)] ) ?>">Cetak</a>
		<?php } ?>
    </div>
        <div id="hiddenId"></div>
    <?php ActiveForm::end(); ?>
    </div>
</section>


