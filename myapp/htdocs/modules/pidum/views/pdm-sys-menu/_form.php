<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmSysMenu */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class ="content-wrapper-1">

        <div class="pdm-sys-menu-form">

            <?php
            $form = ActiveForm::begin(
                            [
                                'id' => 'sys-menu-form',
                                'type' => ActiveForm::TYPE_HORIZONTAL,
                                'enableAjaxValidation' => false,
                                'fieldConfig' => [
                                    'autoPlaceholder' => false
                                ],
                                'formConfig' => [
                                    'deviceSize' => ActiveForm::SIZE_SMALL,
                                    'labelSpan' => 1,
                                    'showLabels' => false
                                ],
                                'options' => [
                                    'enctype' => 'multipart/form-data',
                                ]
            ]);
            ?>

            <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
                <div class="form-group">
                    <label class="control-label col-md-2">Kode</label>
                    <div class="col-md-4" style="width:10%">
                        <?= $form->field($model, 'kd_berkas') ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Keterangan</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'keterangan')->textArea(); ?>
                    </div>
                </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Is Group</label>
                    <div class="col-md-4">
                        <?=
                        $form->field($model, 'id__group_perkara')->dropDownList(['' => 'Pilih Group ', '1' => 'Pratut',
                            '2' => 'Penuntutan', '3' => 'Upaya Hukum', '4' => 'Eksekusi'])
                        ?>
                    </div>
                </div>

                <!--<div class="form-group">
                    <label class="control-label col-md-2">No surat</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'no_surat') ?> 	
                    </div>
                </div>-->


               <!-- <div class="form-group ">
                    <label class="control-label col-md-2">Show</label>
                    <div class="col-md-4">
                        <?= $form->field($model, 'is_show')->checkbox(); ?> 	
                    </div>
                </div> -->

                <div class="form-group">
                    <label class="control-label col-md-2">Template</label>
					<div class="col-md-1" style="width:40px">
						<?php
                       if ($model->is_path == null || $model->is_path == '') {
                            
                       } else {
							echo Html::a(Html::img('/image/odt.jpg',['width'=>'30']), '/template/pidum/'.$model->file_name,['target'=>'_blank'])."&nbsp;";
                            
                        }
                        ?>
					</div>
                    <div class="col-md-4">
                        <?php
                       
                            echo $form->field($model, 'file_name')->widget(FileInput::classname(), [
                                'pluginOptions' => [
                                    'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
								'showClose' => false,
                                'showCaption'=> false,
                                    'browseClass' => 'btn btn-warning',
                                    'browseLabel' => 'Unggah Berkas',
                                    'removeClass' => 'btn btn-warning',
                                ]
                            ]);
                      
                        ?>
                    </div>
                </div>

            </div>

            <hr style="border-color: #c7c7c7;margin: 10px 0;">
            <div class="box-footer" style="text-align: center;">
                <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</section>
