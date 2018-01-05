<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBaKonsultasi */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php $form = ActiveForm::begin([
                'id' => 'spdp-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false,
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ],
                'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
    ]); ?>


    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Tanggal BA Konsultasi</label>
                    <div class="col-md-6">
                            <?php
                             echo $form->field($model, 'tgl_pelaksanaan')->widget(DateControl::classname(), [
                             'type'=>DateControl::FORMAT_DATE,
                             'ajaxConversion'=>false,
                             'options' => [
                             'pluginOptions' => [
                             'autoclose' => true
                                                    ]
                                                ]
                                            ]);

                                        ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nama Penyidik</label>
                    <div class="col-md-6">
                         <?= $form->field($model, 'nama_penyidik')->textInput() ?>
                    </div>

                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor Surat P-16</label>
                    <div class="col-md-6">
                         <?= $form->field($model, 'no_surat')->textInput(['value'=>$jaksa_p16[no_surat], 'readonly'=> 'readonly']) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">NIP / NRP Penyidik</label>
                    <div class="col-md-6">
                            <?= $form->field($model, 'nip_penyidik')->textInput() ?>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group"> 
                 <label class="control-label col-md-4">Nama JPU</label>
                 <div class="col-md-6">
                         <?php echo $form->field($model, 'nip_jaksa')->dropDownList(
                                         ArrayHelper::map($jaksa, 'nip', 'nama'), // Flat array ('id'=>'label')
                                             ['prompt' => 'Pilih Jaksa', 'class' => 'cmb_jaksa']);    // options ?>
                 </div> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Jabatan</label>
                    <div class="col-md-6">
                            <?= $form->field($model, 'jabatan_penyidik')->textInput() ?>
                    </div>
                </div>
            </div>
        </div> 


    </div>

    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="col-md-9">
                <div class="form-group">
                    <label class="control-label col-md-3">Konsultasi Formil</label>
                    <div class="col-md-9">
                            <?= $form->field($model, 'konsultasi_formil')->textarea() ?>
                            <?php   $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                    $this->registerJs("
                                                    CKEDITOR.inline( 'PdmBaKonsultasi[konsultasi_formil]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                    </div> 
                </div>
            </div>       
        </div>

        <div class="col-md-12">
            <div class="col-md-9">
                <div class="form-group">
                    <label class="control-label col-md-3">Konsultasi Materil</label>
                    <div class="col-md-9">
                            <?= $form->field($model, 'konsultasi_materil')->textarea() ?>
                            <?php           $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmBaKonsultasi[konsultasi_materil]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                    </div> 
                </div>
            </div>       
        </div>

        <div class="col-md-12">
            <div class="col-md-9">
                <div class="form-group">
                    <label class="control-label col-md-3">Kesimpulan</label>
                    <div class="col-md-9">
                            <?= $form->field($model, 'kesimpulan')->textarea() ?>
                            <?php           $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmBaKonsultasi[kesimpulan]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                    </div> 
                </div>
            </div>       
        </div>
        <div class="row">
            <div class="col-md-12" style="margin-top: 15px">
                <div class="col-md-9">
                    <div class="form-group">
                        <label class="control-label col-md-3">Upload File</label>
                        <div class="col-md-4">  
                        <?php
                            $preview = "";
                            if($model->file_upload!=""){
                                $preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                             ];
                            }
                            echo FileInput::widget([
                                'name' => 'attachment_3',
                                'id'   =>  'filePicker',
                                'pluginOptions' => [
                                    'showPreview' => true,
                                    'showCaption' => true,
                                    'showRemove' => true,
                                    'showUpload' => false,
                                    'initialPreview' =>  $preview
                                ],
                            ]);
                        ?>


                        <?= $form->field($model, 'file_upload')->hiddenInput()?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php if(!$model->isNewRecord){ ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba-konsultasi/cetak?id_ba_konsultasi='.$model->id_ba_konsultasi] ) ?>">Cetak</a>
        <?php } else {?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba-konsultasi/cetakdraf'] ) ?>">Cetak Draf</a>
        <?php }?>
    </div>

    <?php ActiveForm::end(); ?>

        
<?php
$script = <<< JS
        var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = "data:"+file.type+";base64,";
                    console.log(mime);
                    document.getElementById("pdmbakonsultasi-file_upload").value = mime+btoa(binaryString);
                    // window.open(mime+btoa(binaryString));
                };
                reader.readAsBinaryString(file);
            }
        };

        if (window.File && window.FileReader && window.FileList && window.Blob) {
            document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
        } else {
            alert('The File APIs are not fully supported in this browser.');
        }
JS;
$this->registerJs($script);
?>
