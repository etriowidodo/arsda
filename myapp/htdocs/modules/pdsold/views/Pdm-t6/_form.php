<?php

use app\components\GlobalConstMenuComponent;
use app\models\MsSifatSurat;
use app\modules\pdsold\models\PdmT6;
use app\modules\pdsold\models\VwPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\web\UploadedFile;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this View */
/* @var $model PdmT6 */
/* @var $form ActiveForm2 */
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin([
                    'options' => ['enctype' => 'multipart/form-data'],
                    'id' => 'pdm-t6-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ],
        ]);
        ?>


<?= $this->render('//default/_formHeaderAltx', ['form' => $form, 'model' => $model]) ?>


        <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:14px 0px;">
            <div class="box-header with-border">
                <h3 class="box-title">
                    <i class="glyphicon glyphicon-user"></i> Terdakwa
                </h3>
            </div>
            <br>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Terdakwa</label>
                        <div class="col-md-8">	
<?php
$terdakwa = (new Query())
        ->select('a.no_reg_tahanan,a.nama')
        ->from('pidum.vw_terdakwat2 a')
        ->where(['a.no_register_perkara' => $no_register_perkara])
        ->all();
//echo '<pre>';var_dump($no_register_perkara);exit;
$list = ArrayHelper::map($terdakwa, 'no_reg_tahanan', 'nama');
echo $form->field($model, 'id_tersangka')->dropDownList($list, ['prompt' => '---Pilih---'], ['label' => '']);
?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:14px;">
            <div class="box-header with-border">
                <h3 class="box-title">Perihal Surat</h3>
            </div>
            <br>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Isi Surat</label>
                        <div class="col-md-8">	
<?= $form->field($model, 'alasan')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Karena</label>
                        <div class="col-md-8">	
<?= $form->field($model, 'karena')->textarea(['rows' => 6]) ?>
                        </div>
                    </div>
                </div>
            </div>
			 <div class="well well-sm col-md-12" style="margin-top:15px;">
 <div class="form-inline col-md-12" style="padding:0;">
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="form-group">
                   
                        <div class="col-md-4">	   Tgl Mulai
<?=
$form->field($model, 'tgl_mulai')->widget(DateControl::className(), [
    'type' => DateControl::FORMAT_DATE,
    'ajaxConversion' => false,
    'options' => [
        'pluginOptions' => [
            'autoclose' => true,
            'endDate' => '+1y',
        ]
    ]
]);
?>
                        </div>
						 <div class="col-md-4">	
						   Tgl Akhir
<?=
$form->field($model, 'tgl_selesai')->widget(DateControl::className(), [
    'type' => DateControl::FORMAT_DATE,
    'ajaxConversion' => false,
    'options' => [
        'pluginOptions' => [
            'autoclose' => true,
            'endDate' => '+1y',
        ]
    ]
]);
?>
                        </div>
						<div class="col-md-4" style="margin-top:8px;">	
			<?php echo Html::radio('radio', false, ['label' => '5 Hari', 'id' => '5hari']); ?>
			<br>
			<?php echo Html::radio('radio', false, ['label' => '30 Hari', 'id' => '30hari']); ?>
			</div>
			
                    </div>
                </div>
            </div>
            
        </div>
      </div>
            </div>

            <div class="box box-primary" style="border-color: #f39c12">
                <div class="box-header with-border" style="border-color: #c7c7c7;">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-md-4">Upload File</label>
                                <div class="col-md-6">
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
                                    
                                    
                                    <?= $form->field($model, 'file_upload')->hiddenInput();?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


         <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T6, 'id_table' => $model->no_surat_t6]) ?>

             <?php if (!$model->isNewRecord): ?>
            <?= $form->field($model, 'no_surat_t6')->hiddenInput(['maxlength' => true]) ?>
        <?php endif ?>    

        <?= $form->field($model, 'no_register_perkara')->hiddenInput(['maxlength' => true]) ?>


        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => 'btn btn-warning']) ?>
            <?php if (!$model->isNewRecord): ?>
                <a class="btn btn-warning" href="<?= Url::to(['pdm-t6/cetak?id=' . $model->no_surat_t6]) ?>">Cetak</a>
            <?php endif ?>
        </div>
    </div>    

    <?php ActiveForm::end(); ?>

</div>
</section>
<?php
$script = <<< JS
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" name="mytext[]"><br />'
                )
            });

            var handleFileSelect = function(evt) {
            var files = evt.target.files;
            var file = files[0];

            if (files && file) {
                var reader = new FileReader();
                // console.log(file);
                reader.onload = function(readerEvt) {
                    var binaryString = readerEvt.target.result;
                    var mime = 'data:'+file.type+';base64,';
                    console.log(mime);
                    document.getElementById('pdmt6-file_upload').value = mime+btoa(binaryString);
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

<script type="text/javascript">

    window.onload = function () {


        $("#5hari").change(function () {
            if ($("#pdmt6-tgl_mulai").val() != null && $("#pdmt6-tgl_mulai").val() != '') {
                if (this.checked) {
                    var tglawal = new Date($("#pdmt6-tgl_mulai").val());
                    var tglakhir = new Date(tglawal).setDate(tglawal.getDate() + 5);
                    var tglakhir2 = new Date(tglakhir);
                    //alert(tglawal);
                    function pad(s) {
                        return (s < 10) ? '0' + s : s;
                    }
                    var tgl = [pad(tglakhir2.getDate()), pad(tglakhir2.getMonth() + 1), tglakhir2.getFullYear()].join('-');
                    var tgl2 = [tglakhir2.getFullYear(), pad(tglakhir2.getMonth() + 1), pad(tglakhir2.getDate())].join('-');
                    //alert(tglakhir2);
                    //var tgl = parseDate("d-m-Y", tglakhir2);
                    $("#pdmt6-tgl_selesai-disp").val(tgl);
                    $("#pdmt6-tgl_selesai").val(tgl2);
                } else {
                    $("#pdmt6-tgl_selesai-disp").val("");
                    $("#pdmt6-tgl_selesai").val("S");
                }
            }
        });
		 $("#30hari").change(function () {
            if ($("#pdmt6-tgl_mulai").val() != null && $("#pdmt6-tgl_mulai").val() != '') {
                if (this.checked) {
                    var tglawal = new Date($("#pdmt6-tgl_mulai").val());
                    var tglakhir = new Date(tglawal).setDate(tglawal.getDate() + 30);
                    var tglakhir2 = new Date(tglakhir);
                    //alert(tglawal);
                    function pad(s) {
                        return (s < 10) ? '0' + s : s;
                    }
                    var tgl = [pad(tglakhir2.getDate()), pad(tglakhir2.getMonth() + 1), tglakhir2.getFullYear()].join('-');
                    var tgl2 = [tglakhir2.getFullYear(), pad(tglakhir2.getMonth() + 1), pad(tglakhir2.getDate())].join('-');
                    //alert(tglakhir2);
                    //var tgl = parseDate("d-m-Y", tglakhir2);
                    $("#pdmt6-tgl_selesai-disp").val(tgl);
                    $("#pdmt6-tgl_selesai").val(tgl2);
                } else {
                    $("#pdmt6-tgl_selesai-disp").val("");
                    $("#pdmt6-tgl_selesai").val("S");
                }
            }
        });
	}
		</script>