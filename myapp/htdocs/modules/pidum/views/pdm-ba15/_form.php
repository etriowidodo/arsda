<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\datecontrol\DateControl;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa6 */
/* @var $form yii\widgets\ActiveForm */
?>
<?php
$form = ActiveForm::begin(
                [
                    'id' => 'ba6-form',
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
    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">


            <div class="form-group hide">
                <label class="control-label col-md-2">Wilayah Kerja</label>
                <div class="col-md-3">
                    <input type="text" class="form-control" readonly="true" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                    <div class="help-block"></div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Tanggal BA</label>
                <div class="col-md-3">
                    <?=
                    $form->field($model, 'tgl_ba15')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true,
                                'placeholder' => 'Tanggal BA'
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>  
    </div>

    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="box-header with-border">
                <div class="form-group">
                <label class="control-label col-sm-2">Jaksa Penuntut Umum</label>
                    <div class="col-sm-4">
                                        <?=
                                            $form->field($model, 'nama_jaksa', [
                                                                      'addon' => [
                                                                         'append' => [
                                                                            'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
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
    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="box-header with-border">
                <h4 class="box-title"><strong>ACUAN</strong></h4></div><br>
            <?= $form->field($model, 'no_sp')->hiddenInput(['value' => $p16a['no_surat']]) ?>
            <input type="hidden" class="form-control" readonly="true" value="<?php echo Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
            <?php
                echo $form->field($model, 'tgl_sp')->hiddenInput(['value' => $p16a['tgl_dikeluarkan']]);
            ?>
            <div class="form-group">
                <label class="control-label col-md-2">Terdakwa</label>
                <div class="col-md-3">
                    <?php
                        echo Yii::$app->globalfunc->getTerdakwaT2($form, $model, $no_register_perkara,'');
                    ?>
                </div>
            </div>
            <div id="data-terdakwa">
                <?php
                if ($model->id_tersangka != null)
                    echo Yii::$app->globalfunc->getIdentitasTerdakwaT2($no_register_perkara,$model->id_tersangka);
                ?>

            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Pilih Surat Penetapan Hakim</label>
                <?php $listPenetapan = ArrayHelper::map($penetapan, 'no_penetapan_hakim', 'no_penetapan_hakim'); ?>
                <div class="col-md-3"><?= $form->field($model, 'no_penetapan')->dropDownList($listPenetapan,['prompt' => '---Pilih---']) ?></div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2">Tgl. Surat</label>
                <div class="col-md-3"><?php
                    echo $form->field($model, 'tgl_penetapan')->widget(DateControl::classname(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ]);
                    ?></div>
            </div>
            
        </div>  
    </div>

    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="box-header with-border">
                <div class="form-group">
                    <div class="col-sm-2">
                        <h4 class="box-title"><strong>MENETAPKAN</strong></h4>
                    </div>
                    <label class="control-label col-md-1">Memerintahkan </label>
                    <div class="col-md-3">
                        <?php
                        $cara = (new \yii\db\Query())
                                ->select('*')
                                ->from('pidum.pdm_ms_isi_penetapan')
                                ->all();
                        $lists = ArrayHelper::map($cara, 'id', 'nama');
                        echo $form->field($model, 'id_isipenetapan')->dropDownList($lists, ['prompt' => '---Pilih---'], ['label' => '']);
                        ?>
                    </div>
                </div>
                
            </div>

            <div class="form-group">
                <label class="control-label col-md-2">Dengan Cara</label>
                <div class="col-md-6"><?= $form->field($model, 'memerintahkan') ?></div>
            </div>
            
            <!--            <div class="form-group">
                            <label class="control-label col-md-2">Upload File</label>
                            <div class="col-md-3 kejaksaan">
            <?php
//                    echo $form->field($model, 'uploaded_file')->widget(FileInput::classname(), [
//
//                        'options' => [
//                            'multiple' => false,
//                        ],
//                        'pluginOptions' => [
//                            'showPreview' => true,
//                            'showUpload' => false,
//                        ]
//                    ]);
//
//                    if ($model->uploaded_file != null || $model->uploaded_file != '') {
//                        //$basepath = str_replace('/', '\\', Yii::$app->basePath . '/modules/pidum/upload_file/ba11/' . $model->uploaded_file);
//                        //$path = str_replace($basepath, '', );
//                        echo $model->uploaded_file;
//                    }
            ?>
            
                            </div>
                        </div>-->
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
                        if($model->file_upload!=""){
                            /*$preview = ["<a href='".$model->upload_file."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                         ];*/
                            echo '<object width="160px" id="print" height="160px" data="'.$model->file_upload.'"></object>';
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


    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php //echo Html::a('Batal', ['/pidum/spdp/index'], ['class' => 'btn btn-primary']); ?>
        <?php if (!$model->isNewRecord): ?>
            <!-- <a class="btn btn-warning" href="<?= Url::to(['pdm-ba15/cetak?id='.$model->tgl_ba15]) ?>" >Cetak</a> -->
            <a class="btn btn-warning" id="ctx">Cetak</a>
        <?php endif ?>

    </div>

</div>
<?= $form->field($model, 'nip_jaksa')->hiddenInput() ?>
<?= $form->field($model, 'jabatan_jaksa')->hiddenInput() ?>
<?= $form->field($model, 'pangkat_jaksa')->hiddenInput() ?>
<?= $form->field($model, 'no_reg_tahanan')->hiddenInput(['class'=>'no_reg_tahanan']) ?>
<?php ActiveForm::end(); ?>

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



<script type="text/javascript">
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
             document.getElementById('pdmba15-file_upload').value = mime+btoa(binaryString);
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

    window.onload = function () {
        $('#ctx').on('click', function(){
            var file = '<?php echo $model->file_upload ?>';
            if(file==''){
                alert('Belum Upload File!');
                return false;
            }
            download(file, 'BA-15.pdf', 'text/pdf');
        });


        $("#pdmba15-tgl_penetapan-disp").prop('disabled',true);
        $("#pdmba15-no_penetapan").on("change", function(){
            var nom = $(this).val();
            $.ajax({
                type: "POST",
                url: '/pidum/pdm-ba15/detail-penetapan',
                data: 'no_penetapan='+nom,
                success:function(data){
                    //console.log(data.tanggal);
                    var lel = data.tanggal.split('-');
                    //console.log(lel);
                    $("#pdmba15-tgl_penetapan-disp").val(lel[2]+'-'+lel[1]+'-'+lel[0]);
                    $("#pdmba15-tgl_penetapan").val(data.tanggal);
                }
            });

        });

        /*$(document).on('click', 'a#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });*/

        $( document ).on('click', '.hapusJaksa', function(e) {
        
        console.log(e.target.value);
        var input = $( this );
        if(input.prop( "checked" ) == true){
            //$(".hapus").prop("disabled",false);
        
            $(".hapus").click(function(){
                $('tr[data-id="'+e.target.value+'"]').remove();
                /*$('#hiddenId').append(
                    '<input type="hidden" name="MsTersangka[nama_update][]" value='+e.target.value+'>'
                )*/
            });  


        }

       
    });


        $(document).on('click', 'a#btn_tambah_pertanyaan', function () {
            var i = $('table#gridTerdakwa tr:last').index() + 1;
            $('#gridPertanyaan').append(
                    '<tr>' +
                    '<td><a class="btn btn-danger delete" id="btn_hapus">(-)</a></td>' +
                    '<td><input type="text" id="pertanyaan" class="form-control" name="pertanyaan[]" > </td>' +
                    '<td><input type="text" id="jaawaban" class="form-control" name="jawaban[]" > </td>' +
                    '</tr>'
                    );
            i++;
        });


        $('#pilih-jpu').click(function () {

            $('input:checkbox:checked').each(function (index) {
                //var keys = $('#gridKejaksaan').yiiGridView('getSelectedRows');
                // alert(keys);
                var value = $(this).val();
                var data = value.split('#');

                $('#gridJPU').append(
                        '<tr data-id="'+data[0]+'">' +
                        '<td><input type="text" class="form-control" name="txtnip[]" readonly="true" value="' + data[0] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtnama[]" readonly="true" value="' + data[1] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtpangkat[]" readonly="true" value="' + data[2] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtjabatan[]" readonly="true" value="' + data[3] + '"> </td>' +
                        '<td id="tdJPU"><input type="checkbox" name="jaksa[]"" class="hapusJaksa" id="hapusJaksa" value="'+data[0]+'"></td>' +
                        '</tr>'
                        );

            });
            $('#m_jpu').modal('hide');
        });
    };


//    function pilihJPU(nip, nama, jabatan, pangkat) {
//
//        var i = $('table#gridJPU tr:last').index() + 1;
//
//        $('#gridJPU').append(
//                "<tr id='trJPU" + i + "'>" +
//                "<td id='tdJPU" + i + "'><a class='btn btn-danger' id='btn_hapus'>(-)</a></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtnip[]' id='txtnip' value='" + nip + "' style='width:100px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtnama[]' id='txtnama' value='" + nama + "' style='width:250px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtpangkat[]' id='txtpangkat' value='" + pangkat + "' style='width:50px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "<td id='tdJPU" + i + "'><input type='text' name='txtjabatan[]' id='txtjabatan' value='" + jabatan + "' style='width:510px;' readonly='true' class='form-control' readonly='true'></td>" +
//                "</tr>"
//                );
//        i++;
//
//        $('#m_jpu').modal('hide');
//
//    }




</script>