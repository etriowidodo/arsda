<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\builder\Form;
use app\modules\pidum\models\VwTerdakwaT2;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;

use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmNotaPendapat */
/* @var $form yii\widgets\ActiveForm */
?>

<br/>
<?php
$form = ActiveForm::begin(
        [
            'id' => 'nota_pendapat-form',
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

<div class="content-wrapper-1">
    <div class="pdm-nota-pendapat-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                    <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                   <div class="form-group">
                                        <label class="control-label col-md-4">Nama Terdakwa</label>
                                                <div class="col-md-6">
                                                    <?php
                                                    echo $form->field($model, 'nama_tersangka_ba4', [
                                                        'addon' => [
                                                            'append' => [
                                                                'content' => Html::a('Pilih', 'javascript:void(0)', ['id'=>'show_tersangka','class' => 'btn btn-warning']),
                                                                'asButton' => true
                                                            ]
                                                        ]
                                                    ]);
                                                    ?>
                                                </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Jenis Nota Pendapat</label>
                                        <div class="col-md-6">
                                            <?php echo $form->field($model, 'jenis_nota_pendapat')->dropDownList(
                                                    ArrayHelper::map($modeljns,'jenis', 'jenis'), 
                                                    ['prompt' => 'Pilih Jenis Nota Pendapat']);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Kepada Yth.</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'kepada')->textInput(['placeholder' => 'Kepada']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Jaksa</label>
                                        <div class="col-md-6">
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
                                                <div class="form-group field-pdmjaksasaksi-nama required">
                                                    <div class="col-sm-12">
                                                        <div class="input-group">
                                                            <input value ="<?= $model->dari_nama_jaksa_p16a?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                            <div class="input-group-btn">
                                                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                            </div>
                                                        </div>
                                                        <?php
                                                        
//                                                        echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'nip')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'pangkat')->hiddenInput();
//                                                        echo $form->field($modeljaksi, 'jabatan')->hiddenInput();
                                                        ?>
                                                    </div>
                                                    <div class="col-sm-12"></div>
                                                    <div class="col-sm-12">
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tgl. Nota</label>
                                        <div class="col-md-4">
                                            <?=$form->field($model, 'tgl_nota')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tgl. Nota'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true,
                                                        'startDate' => '-1m',
                                                        'endDate' => '+4m'
                                                    ]
                                                ]
                                            ]);
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 70px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Perihal</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'perihal_nota')->textarea(['placeholder' => 'Perihal']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Dasar</label>
                                        <div class="col-md-10">
                                            <?php echo $form->field($model, 'dasar_nota')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmNotaPendapat[dasar_nota]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Pendapat</label>
                                        <div class="col-md-10">
                                            <?php echo $form->field($model, 'pendapat_nota')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmNotaPendapat[pendapat_nota]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Saran Kasipidum</label>
                                        <div class="col-md-8">
                                            <?php echo $form->field($model, 'saran_nota')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmNotaPendapat[saran_nota]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Petunjuk Kajari</label>
                                        <div class="col-md-8">
                                            <?php echo $form->field($model, 'petunjuk_nota')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmNotaPendapat[petunjuk_nota]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Persetujuan Saran</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'flag_saran')->radio(['label' => 'Setuju', 'value' => 1, 'uncheck' => null]) ?>
                                            <?= $form->field($model, 'flag_saran')->radio(['label' => 'Tidak Setuju', 'value' => 0, 'uncheck' => null]) ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Persetujuan Petunjuk</label>
                                        <div class="col-md-8">
                                            <?= $form->field($model, 'flag_pentunjuk')->radio(['label' => 'Setuju', 'value' => 1, 'uncheck' => null]) ?>
                                            <?= $form->field($model, 'flag_pentunjuk')->radio(['label' => 'Tidak Setuju', 'value' => 0, 'uncheck' => null]) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>
            <? echo Html::a('Cetak', ['cetak', 'id' => rawurlencode($model->id_nota_pendapat)], ['class' => 'btn btn-warning']);?>
            <?php endif ?>	
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

                
//                echo Html::hiddenInput('PdmJaksaSaksi[nip]', null, ['id' => 'pdmjaksasaksi-nip','value'=>$model->dari_nip_jaksa_p16a]);
//                echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', null, ['id' => 'pdmjaksasaksi-jabatan','value'=>$model->dari_jabatan_jaksa_p16a]);
//                echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', null, ['id' => 'pdmjaksasaksi-pangkat','value'=>$model->dari_pangkat_jaksa_p16a]);
    //        }
            ?>
            <input type="hidden" id="pdmjaksasaksi-nip" name="PdmJaksaSaksi[nip]" value="<?= $model->dari_nip_jaksa_p16a?>">
            <input type="hidden" id="pdmjaksasaksi-jabatan" name="PdmJaksaSaksi[jabatan]" value="<?= $model->dari_jabatan_jaksa_p16a?>">
            <input type="hidden" id="pdmjaksasaksi-pangkat" name="PdmJaksaSaksi[pangkat]" value="<?= $model->dari_pangkat_jaksa_p16a?>">
             <?= $form->field($model, 'tgl_ba4')->hiddenInput() ?>
         <?= $form->field($model, 'no_urut_tersangka')->hiddenInput() ?>
        </div>

        <!--<div class="form-group">-->
            <?// Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <!--</div>-->

        <?php ActiveForm::end(); ?>

    </div>
</div>


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


 $this->registerJs("
//  CKEDITOR.inline( 'PdmNotaPendapat[dasar_nota]');
//  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
//  CKEDITOR.config.autoParagraph = false;
//
//  CKEDITOR.inline( 'PdmNotaPendapat[pendapat_nota]');
//  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
//  CKEDITOR.config.autoParagraph = false;
//
//  CKEDITOR.inline( 'PdmNotaPendapat[saran_nota]');
//  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
//  CKEDITOR.config.autoParagraph = false;
//
//  CKEDITOR.inline( 'PdmNotaPendapat[petunjuk_nota]');
//  CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
//  CKEDITOR.config.autoParagraph = false;

     $('#show_tersangka').click(function(){
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidum/pdm-nota-pendapat/refer-tersangka');
            $('#m_tersangka').modal('show');
                    
            });

  ");

?>

<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Data Tersangka</h7>'
]);
?> 

<?php
Modal::end();
?> 
<?php 