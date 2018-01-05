<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\builder\Form;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use app\modules\pdsold\models\PdmJaksaPenerima;
use app\modules\pdsold\models\MsTersangka;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm ::begin(
                        [
                            'id' => 'p34-form',
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

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
              <div class="col-md-6">
                   <div class="form-group">
                        <label class="control-label col-md-4">Wilayah Kerja</label>
                        <div class="col-md-8">
                        <input class="form-control" readonly="true" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                    </div>
                    </div> 

                    <div class="form-group">
                        <label class="control-label col-md-4">Lokasi Pengadilan Negeri</label>
                        <div class="col-md-8">
                            <?php $conf = Yii::$app->globalfunc->GetConfSatker();
                            echo $form->field($model, 'lokasi_pengadilan')->textInput(['value'=> $model->isNewRecord ? $conf->p_negeri : $model->lokasi_pengadilan]); ?>
                    </div>
                    </div> 
                
                 <div class="form-group" style="margin-top:10px">
                        <label class="control-label col-md-4">Tanggal</label>
                        <div class="col-md-8">
                            <?=
                            $form->field($model, 'tgl_surat_p34')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
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
                </div>
            <div class="col-md-6" style="margin-left:15px">
			 <?php
                echo Form::widget([ /* waktu kunjungan */
                    'model' => $model,
                    'form' => $form,
                    'columns' => 2,
                    'attributes' => [
                        'jam_kunjungan' => [
                            'label' => 'Jam',
                            'labelSpan' => 4,
                            'columns' => 12,
                            'attributes' => [
                                'jam' => [
                                    'type' => Form::INPUT_WIDGET,
                                    'widgetClass' => '\kartik\widgets\TimePicker',
                                    'options' => [
                                        'pluginOptions'=>[
                                            //'template'=>false,
                                            'defaultTime'=>false,
                                            'showSeconds'=>false,
                                            'showMeridian'=>false,
                                            'minuteStep'=>1,
                                        ],
                                        'options' => [
                                            'placeholder'=>' '
                                        ]
                                    ],
                                    'columnOptions' => ['colspan' => 6 ],
									 
                                ],
                            ]
                        ],
                    ]
                ]);
                ?>
        </div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Yang Menyerahkan</label>
                        <div class="col-md-8" style="margin-left:172px;margin-top:-27px">
                            <?php
                            echo $form->field($modeljapen, 'nama', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#_m_jpu2']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                     <div class="form-group">
                        <label class="control-label col-md-5">Yang Menerima</label>
                        <div class="col-md-8" style="margin-left:172px;margin-top:-27px">
                            <?= $form->field($model, 'penerima') ?>
                        </div>
                    </div>
                </div>
                </div>
              <!-- <div class="form-group" style="border-style;border-width:1px;margin-left:41px;width:400px;text-align:left; margin-top:-10px;">
            <label for="tersangka" class="control-label col-md-4" style="margin-left:-27px">Terdakwa</label>
            <div class="col-md-8" style="margin-left:146px;margin-top:-28px">
			 <?php
            /*echo $form->field($model, 'id_tersangka')->dropDownList(
                    ArrayHelper::map($modelTersangka, 'no_urut_tersangka', 'nama'), // Flat array ('id'=>'label')
                    ['prompt' => '']  );   // options*/
           
            ?>
            </div>
              </div> -->
			  
			    <!--<div class="form-group"> 
            <label class="control-label col-md-2">Terdakwa</label>
            <div class="col-md-3">
                <?php  //echo Yii::$app->globalfunc->returnDropDownList($form,$model, MsTersangka::find()->all(),'id_perkara','id_tersangka','id_perkara')  ?>
               
            </div>
        </div>-->
            
              <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Dikeluarkan</label>
                        <div class="col-md-8" style="margin-left:172px;margin-top:-27px">
                        <?= $form->field($model, 'dikeluarkan') ?>
                    </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Tanggal</label>
                        <div class="col-md-7" style="margin-left:-130px">
                            <?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
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
                                    
                                    
                                    <?= $form->field($model, 'file_upload')->hiddenInput()?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
	  
    <div class="box-footer" style="text-align: center;">
        <?php
        echo $form->field($modeljapen, 'nip')->hiddenInput();
        echo $form->field($modeljapen, 'jabatan')->hiddenInput();
        echo $form->field($modeljapen, 'pangkat')->hiddenInput();
         
        ?>
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php
        if (!$model->isNewRecord) {
            echo Html::a('Cetak', ['cetak', 'no_surat' => $model->no_register_perkara], ['class' => 'btn btn-warning']);
        }
            echo Html::a('Cetak Draf', ['cetak', 'no_surat' => $no_register_perkara], ['class' => 'btn btn-warning']);
        ?>

        <?php ActiveForm::end(); ?>

    </div>


    </div>
</section>

<?php
Modal::begin([
    'id' => '_m_jpu2',
    'header' => 'Data Jaksa Penerima',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu2', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>  

<?php
$this->registerJs( "
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
                    document.getElementById('pdmp34-file_upload').value = mime+btoa(binaryString);
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


    $(document).ready(function(){
  
    

}); ", \yii\web\View::POS_END);
?>




<script type="text/javascript">

    /*window.onload = function () {



        $(document).on('click', 'a#btn_hapus', function () {
            $(this).parent().parent().remove();
            return false;
        });

        $('#pilih-jpu').click(function () {

            $('input:checkbox:checked').each(function (index) {
                //var keys = $('#gridKejaksaan').yiiGridView('getSelectedRows');
                // alert(keys);
                var value = $(this).val();
                var data = value.split('#');

                $('#gridJPU').append(
                        '<tr id="trjpu">' +
                        '<td><input type="text" class="form-control" name="txtnip[]" readonly="true" style="width:100px;" value="' + data[0] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtnama[]" readonly="true" style="width:250px;" value="' + data[1] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtpangkat[]" readonly="true" style="width:50px;" value="' + data[2] + '"> </td>' +
                        '<td><input type="text" class="form-control" name="txtjabatan[]" readonly="true" style="width:480px;" value="' + data[3] + '"> </td>' +
                        '<td id="tdJPU"><a class="btn btn-danger delete" id="btn_hapus"></a></td>' +
                        '</tr>'
                        );

            });
            $('#_m_jpu2').modal('hide');
        });
    };
*/
    function pilihJPU(nip, nama, jabatan, pangkat) {
        $("#pdmba5jaksa-nama").val(nama);
        $("#pdmba5jaksa-nip").val(nip);
        $("#pdmba5jaksa-jabatan").val(jabatan);
        $("#pdmba5jaksa-pangkat").val(pangkat);
        $('#_m_jpu2').modal('hide');
    }
</script>

