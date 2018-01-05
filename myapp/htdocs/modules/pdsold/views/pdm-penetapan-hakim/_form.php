<?php

use app\modules\pdsold\models\PdmMsStatusData;
use app\modules\pdsold\models\PdmP37;
use app\modules\pdsold\models\PdmP38;
use app\modules\pdsold\models\VwPenandatangan;
use app\modules\pdsold\models\VwTerdakwaT2;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\TimePicker;
use dosamigos\ckeditor\CKEditorAsset;
CKEditorAsset::register($this);
use kartik\widgets\FileInput;

/* @varkartik $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP38 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="box-header"></div>


    <?php
    $form = ActiveForm::begin(
        [
            'id' => 'pdm-penetapan-hakim-form',
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
<div class="content-wrapper-1">
    <div class="pdm-penetapan-hakim-form">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary"  style="border-color: #f39c12;">
                    <div class="box-body">
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">No. Penetapan Ketua PN/Hakim</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'no_penetapan_hakim')->textInput(['placeholder' => 'No. Penetapan']); ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-md-4">Penetapan hakim/ketua PN/PT/MA</label>
                                        <div class="col-md-6"><?= $form->field($model, 'penetapan')->dropDownList(['PN' => 'PN', 'PT' => 'PT', 'MA' => 'MA']) ?></div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tanggal</label>
                                        <div class="col-md-6">
                                            <?=$form->field($model, 'tgl_penetapan_hakim')->widget(DateControl::className(), [
                                                'type' => DateControl::FORMAT_DATE,
                                                'ajaxConversion' => false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tanggal'],
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
                        <br/>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Tentang</label>
                                        <div class="col-md-6">
                                            <?php $array = [
                                                                ['id' => '1', 'nama' => 'Hari Sidang'],
                                                                ['id' => '2', 'nama' => 'Penahanan'],
                                                                ['id' => '3', 'nama' => 'Barang Bukti'],
                                                            ]; ?>
                                            <?= $form->field($model, 'tentang')->dropDownList(
                                                               ArrayHelper::map($array, 'id', 'nama'), 
                                                               ['prompt' => 'Tentang...']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="control-label col-md-2">Memerintahkan</label>
                                        <div class="col-md-10">
                                            <?= $form->field($model, 'memerintahkan')->textarea(['placeholder' => 'Memerintahkan','class'=>'ckeditor']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hide" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Dengan Cara</label>
                                        <div class="col-md-6">
                                            <?= $form->field($model, 'dengan_cara')->textInput(['placeholder' => 'Dengan Cara']); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="height: 45px">
                            <div class="col-md-12">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="control-label col-md-4">Upload File</label>
                                        <div class="col-md-6">
                                            <?php
                                            $preview = "";
                                            if($model->upload_file!=""){
                                                $preview = ["<a href='".$model->upload_file."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
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
                                            <?= $form->field($model, 'upload_file')->hiddenInput()?>
                                        </div>
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
            <!--<a class="btn btn-warning" href="<? //echo Url::to(["pdm-penetapan-hakim/cetak?id=".$model->no_penetapan_hakim]) ?>">Cetak</a>-->
        <?php endif ?>	
    </div>
</div>    
<?php ActiveForm::end(); ?>

<?php

$script1 = <<< JS

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
                    document.getElementById("pdmpenetapanhakim-upload_file").value = mime+btoa(binaryString);
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
$this->registerJs($script1);

?>