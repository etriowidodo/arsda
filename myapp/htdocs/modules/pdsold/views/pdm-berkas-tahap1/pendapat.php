<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\typeahead\TypeaheadAsset;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;
use kartik\widgets\FileInput;
use app\components\GlobalConstMenuComponent;
use app\components\GlobalFuncComponent;
use kartik\grid\GridView;
use app\modules\pdsold\models\PdmBerkasTahap1;
use app\modules\pdsold\models\PdmPengantarTahap1;
use app\modules\pdsold\models\PdmBerkasTahap1Search;
use app\modules\pdsold\models\PdmP16;
use app\modules\pdsold\models\PdmP24;
//use app\modules\pdsold\models\PdmJaksaSaksi;

  $dat1=explode(',', $modelCeklis['id_pendapat_jaksa']);

// print_r($dat1) ;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBerkasTahap1 */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Pendapat';



?>

<script src="http://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function(){



});
</script>
<section class="content" style="padding: 0px;">
<div class="content-wrapper-1">
    <?php $form = ActiveForm::begin([
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'labelSpan' => 1,
                'showLabels' => false
            ],
            'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
  ]); ?>
        <div class="box box-primary"  style="border-color: #f39c12;padding:15px;overflow: hidden;">
            <div class="col-md-12" >

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="padding-top:6px;">Nomor Berkas</label>
                        <div class="col-md-8">
                            <?php $model= new PdmBerkasTahap1();
                            $modelPengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $id_ceklist]);
                            $modelBerkas = PdmBerkasTahap1::findOne(['id_berkas' => $_GET['id_berkas']]);
                                             ?>
                            <input class="form-control" readonly="true" value="<?= $modelBerkas->no_berkas ?>" >

                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="padding-top:6px;">Tanggal Terima</label>
                        <div class="col-md-8" style="width:23%;">
                        <?php $tglBerkas   = date('d-m-Y',strtotime($modelBerkas->tgl_berkas));?>
                            <input class="form-control" readonly="true" value="<?php echo $tglBerkas; ?>" >
                        </div>

                    </div>
                </div>
            </div>
            <div class="clearfix" style="margin-bottom:14px;"></div>
            <div class="col-md-12" >
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="padding-top:6px;">Nomor Surat Pengantar</label>
                        <div class="col-md-8">
                            <input class="form-control" value="<?= $modelPengantar->no_pengantar ?>" name="no_pengantar" readOnly="true">
                        </div>
				    </div>
				</div>
			    <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="padding-top:6px;">Tanggal Surat Pengantar</label>
                        <div class="col-md-8"  style="width:23%;">
                        <?php $tglPengantar   = date('d-m-Y',strtotime($modelPengantar->tgl_pengantar));
                            $tglSelesaiPengantar   = date('d-m-Y',strtotime($modelPengantar->tgl_terima))?>
                            <input class="form-control" readonly="true" value="<?php echo $tglPengantar; ?>" >
                        </div>
                    </div>
                </div>
			</div>
            <div class="clearfix" style="margin-bottom:14px;"></div>
            <div class="col-md-12" >
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="padding-top:6px;">Jaksa Peneliti</label>
                        <div class="col-md-8">

                            <?php
                        echo $form->field($modelCeklis, 'nik_ttd')->dropDownList($modelP16);?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4" style="padding-top:6px;">Waktu Penelitian</label>
                        <div class="col-md-3"  style="width:23%;">

                            <?=$form->field($modelCeklis, 'tgl_mulai')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options'=>[
                                            'placeholder'=>'DD-MM-YYYY',//jaka | tambah placeholder format tanggal
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                            'startDate' => $tglSelesaiPengantar,
                                            'endDate' => date('d-m-Y'),
                                        ]
                                    ]
                                ]);
                            ?>
                        </div><label class="control-label col-md-1" style="padding-left:0px;padding-top:6px;width:2%;">s/d.</label>
                        <div class="col-md-3"  style="width:23%;padding-left:-50px;" id="tgl_terima">
                            <?php
                            $tgl_mulai = date('d-m-Y',strtotime($modelCeklis->tgl_mulai)) ;
                                  $tgl_mulai = $modelCeklis->isNewRecord ? :$tgl_mulai; ?>
                            <?=$form->field($modelCeklis, 'tgl_selesai')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
                                        'options'=>[
                                            'placeholder'=>'DD-MM-YYYY',//jaka | tambah placeholder format tanggal
                                        ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
											'startDate' => $tglSelesaiPengantar,
                                            'endDate' => date('d-m-Y'),
                                        ]
                                    ]
                                ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary"  style="border-color: #f39c12;overflow: hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-6" style="padding-left: 30px;">
                    <h3 class="box-title">Pendapat Jaksa Peneliti</h3>
                </div>

            </div>
            <div class="box-header with-border">
                <div style="padding-left:30px;">
                </div>
                <div style="clear: both;"></div>

                <label class="radio" style="padding-left:50px;padding-right:30px">
                    <input type="radio" name="rdPendapat[]" id="rd1" value="1"<?php if(in_array('1', $dat1)){echo 'checked="checked"';} ?>>
                    Hasil penyidikan sudah lengkap perlu dilanjutkan penyerahan tanggung jawab atas Tersangka dan Barang Bukti, untuk segera menentukan apakah perkara itu sudah memenuhi persyaratan untuk dapat atau tidak dilimpahkan ke Pengadilan.
                </label>
                <label class="radio" style="padding-left:50px;padding-right:30px">

                    <input type="radio" name="rdPendapat[]" id="rd2" value="2"<?php if(in_array('2', $dat1)){echo 'checked="checked"';} ?>>
                    Hasil penyidikan belum lengkap :
                    <?php  ?>

                </label>
                <div id="div1" hidden>
                    <label class="checkbox" id="ck1" style="padding-left:70px;padding-right:30px">
                      <input type="checkbox" name="rdPendapat[]" value="3"<?php if(in_array('3',$dat1)){echo 'checked="checked"';}?>>
                      Perkara Perlu di Split
                    </label>
                    <label class="checkbox" id="ck2" style="padding-left:70px;padding-right:30px">
                      <input type="checkbox" name="rdPendapat[]" value="4" <?php if(in_array('4',$dat1)){echo 'checked="checked"';} ?>>
                      Perlu Saksi Ahli
                    </label>
                    <label class="checkbox" id="ck3" style="padding-left:70px;padding-right:30px">
                      <input type="checkbox" name="rdPendapat[]" value="5" <?php if(in_array('5',$dat1)){echo 'checked="checked"';} ?>>
                      Perlu Saksi A. Charge
                    </label>
                    <label class="checkbox" id="ck4" style="padding-left:70px;padding-right:30px">
                      <input type="checkbox" name="rdPendapat[]" value="6" <?php if(in_array('6',$dat1)){echo 'checked="checked"';} ?>>
                      Perlu Alat Bukti Lain
                    </label>
                    <label class="radio" style="padding-left:70px;padding-right:30px">
                    <input type="radio" name="rdPendapat[]" id="rd3" value="7" <?php if(in_array('7',$dat1)){echo 'checked="checked"';} ?>>
                    Hasil penyidikan sudah optimal tetapi secara material belum terpenuhi, diberikan petunjuk barang bukti dan tersangka agar diserahkan untuk diadakan pemeriksaan tambahan, berdasar pasal 27 ayat 1 (d) UU Nomor 16 tahun 2004.
                    </label>
                    <label class="radio" style="padding-left:70px;padding-right:30px">
                        <input type="radio" name="rdPendapat[]" id="rd4" value="8" <?php if(in_array('8',$dat1)){echo 'checked="checked"';} ?>>
                        Perkara Koneksitas
                    </label>
                     <label class="radio" style="padding-left:70px;padding-right:30px">
                        <input type="radio" name="rdPendapat[]" id="rd5" value="9" <?php if(in_array('9',$dat1)){echo 'checked="checked"';} ?>>
                        Termasuk Wewenang PN Lain
                    </label>
                </div>
                

            </div>
        </div>

        <div class="box box-primary"  style="border-color: #f39c12;padding: 13px;overflow: hidden;">
            <div class="row">
                <div class="col-md-12" style="margin-top: 15px">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Upload File</label>
                            <div class="col-md-4">  
                            <?php
                                $preview = "";
                                if($modelCeklis->file_upload!=""){
                                    /*$preview = ["<a href='".$modelCeklis->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                                 ];*/
                                    echo '<object width="160px" id="print" height="160px" data="'.$modelCeklis->file_upload.'"></object>';
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


                            <?= $form->field($modelCeklis, 'file_upload')->hiddenInput()?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

	<hr style="border-color: #c7c7c7;margin: 10px 0;">

    <div class="box-footer" style="text-align: center;">
        <?= Html::SubmitButton($modelCeklis->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $modelCeklis->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if ($modelCeklis->isNewRecord) {?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-berkas-tahap1/cetak-draf']) ?>">Cetak Draf</a>
        <?php  } else {?>
            <!-- <a class="btn btn-warning" href="<?= $modelCeklis->file_upload?>" target="_blank">Cetak</a>      -->
            <!--<a class="btn btn-warning" href="<? //Url::to(['pdm-berkas-tahap1/cetak?id='.$id_ceklist]) ?>">Cetak</a>-->     
        <?php  }?>

    </div>
        <div id="hiddenId"></div>
<?php ActiveForm::end(); ?>
</div>
</section>




<?php
    $js = <<< JS
            
            
            
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
                    document.getElementById("pdmceklisttahap1-file_upload").value = mime+btoa(binaryString);
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
        
            
            
        $('td').dblclick(function (e) {
        var id = $(this).closest('tr').data('id');
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-berkas-tahap1/update?id="+id;
        $(location).attr('href',url);
    });

    $('#rd1').click(function () {
       $('#div1').hide('fast');

       if($('#rd1').prop('checked',true)){
        $('#ck1').attr('checked',false);
       }
		$('input:checkbox').removeAttr('checked');
    });

    // Kondisi saat Form di-load
    if($("#rd2:checked").val()){
        $('#div1').toggle('fast');
    } else {
        $('#div1').attr('disabled','disabled');
    }
    // Kondisi saat Radio diklik
    $('#rd2').click(function() {
        if (!$(this).is(':checked')) {
            $('#div1').attr('disabled','disabled');
            $('#div1').val('');
        } else {
            $('#div1').toggle('fast');
            $('#div1').focus();
        }
    });

    // $('#rd3').click(function () {
    //    $('#div1').hide('fast');
	   // $('input:checkbox').removeAttr('checked');
    // });
    // $('#rd4').click(function () {
    //    $('#div1').hide('fast');
	   // $('input:checkbox').removeAttr('checked');
    // });
    // $('#rd5').click(function () {
    //    $('#div1').hide('fast');
	   // $('input:checkbox').removeAttr('checked');
    // });

   $('#pdmceklisttahap1-tgl_mulai-disp').on('change hover',function(){
    var date        = $(this).val().split('-');
    date            = date[2]+'-'+date[1]+'-'+date[0];
    var someDate    = new Date(date);
    var endDate     = new Date();
    someDate.setDate(someDate.getDate());
    endDate.setDate(endDate.getDate());
    var dateFormated        = someDate.toISOString().substr(0,10);
    var enddateFormated     = endDate.toISOString().substr(0,10);
    var resultDate          = dateFormated.split('-');
    var endresultDate       = enddateFormated.split('-');
    finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
    date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
    var input               = $('#tgl_terima').html();
    var datecontrol         = $('#pdmceklisttahap1-tgl_selesai-disp').attr('data-krajee-datecontrol');
    $('#tgl_terima').html(input);
    var kvDatepicker_00 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_00 = {'idSave':'pdmceklisttahap1-tgl_selesai','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}};
  $('#pdmceklisttahap1-tgl_selesai-disp').kvDatepicker(kvDatepicker_00);
  $('#pdmceklisttahap1-tgl_selesai-disp').datecontrol(datecontrol_00);
  $('.field-pdmceklisttahap1-tgl_selesai').removeClass('.has-error');
  });

JS;

        $this->registerJs($js);
        ?>
