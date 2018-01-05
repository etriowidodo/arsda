
<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\Url;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use kartik\grid\GridView;
use kartik\widgets\FileInput;
use app\modules\pdsold\models\PdmPengantarTahap1;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
  "$('#p19-form').on('afterValidate', function (event, messages) {
     
    if(typeof $('.has-error').first().offset() !== 'undefined') {
      var scroll     = $('.has-error').first().closest(':visible').offset().top;
      var minscroll  = (86.6/100)*scroll;
        $('html, body').animate({
            scrollTop: ($('.has-error').first().closest(':visible').offset().top)-minscroll
        }, 1500);
        var lenghInput = $('.has-error div input[type=text]').length;
        var lenghSearch = $('.has-error div input[type=search]').length;
         $('.has-error div input').first().focus();  
        if(lenghInput==0)
        {
          var minscrollText = (39/100)*($(document).height()-$(window).height());
          $('html, body').animate({
            scrollTop: ($(document).height()-$(window).height())-minscrollText
        }, 1500);
           $('.has-error div textarea').first().focus();
        }
        
      }
  });

"
  );
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
    <?php
    
$tgl_pengantar = PdmPengantarTahap1::findOne(['id_pengantar' => $_GET['id_pengantar']])->tgl_pengantar;

    $form = ActiveForm::begin([
                'id' => 'p19-form',
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
        <div class="panel box box-warning">
        <div class="box-header with-border">
              
            </div><br>
            <div class="form-group">
                <label for="nomor" class="control-label col-md-2">Nomor Berkas</label>

                <div class="col-md-3">
                    <?= $form->field($modelBerkas, 'no_berkas')->textinput(['readonly' => true]) ?>
                </div>
               
                <label class="control-label col-md-1" style="padding-right:0px">Tanggal Berkas</label>
                <div class="col-md-2"><input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($modelBerkas->tgl_berkas)) ?>" readonly="true"></div>
                 <label class="control-label col-md-1" style="padding-right:0px">Tanggal Terima</label>
               <div class="col-md-2">
                  <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($modelPengantar->tgl_terima)) ?>" readonly="true">
                </div>
            </div>

            <div class="form-group">
               <label class="control-label col-md-2">Instansi Penyidik</label>
               <div class="col-md-3">
                  <input type="text" class="form-control" value="<?= $modelInsPenyidik->nama ?>  ( <?= $modelInsPenyidik->akronim ?> )" readonly="true">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="nomor" class="control-label col-md-2"><?php if($_GET['id_p19']=='null'){ echo 'Nomor P-18'; }else{ echo 'Nomor P-19'; } ?></label>

                <div class="col-md-3">
                <?php if($_GET['id_p19']=='null'){ ?>
                    <?= $form->field($modelP18, 'no_surat')->textinput(['readonly' => true]) ?>
                <?php }else{ ?>
                    <?= $form->field($model, 'no_surat')->textinput(['readonly' => true]) ?>
                <?php } ?>
                </div>
               
                <label class="control-label col-md-1" style="padding-right:0px"><?php if($_GET['id_p19']=='null'){ echo 'Tanggal P-18'; }else{ echo 'Tanggal P-19'; } ?></label>
                <div class="col-md-2">
                <?php if($_GET['id_p19']=='null'){ ?>
                <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($modelP18->tgl_dikeluarkan)) ?>" readonly="true">
                <?php }else{ ?>
                <input type="text" class="form-control" value="<?= date('d-m-Y', strtotime($model->tgl_dikeluarkan)) ?>" readonly="true">
                <?php } ?>
                </div>
            </div>
            <br>
		
        
		</div>
   
        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>
        <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
        <?php 
        if(!empty($model->tgl_dikeluarkan) == 1)
        {
            $tgl_dikeluarkan_new_record = $model->tgl_dikeluarkan;
        }
        else
        {
            $tgl_dikeluarkan_new_record = 0;
        }

         ?>
        <div class="col-md-12">
        <div class="box-header">Petujuk</div>               
            <div class="col-md-12" >

                                            <?php echo $form->field($model, 'petunjuk')->textarea() ?>
                                            <?php
                                            $this->registerCss("div[contenteditable] {
                                                    outline: 1px solid #d2d6de;
                                                    min-height: 100px;
                                                }");
                                            $this->registerJs("
                                                    CKEDITOR.inline( 'PdmP19[petunjuk]');
                                                    CKEDITOR.config.enterMode = CKEDITOR.ENTER_BR;
                                                    CKEDITOR.config.autoParagraph = false;

                                                ");
                                            ?>
                 
            </div>            
        </div>
        </div>
        <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
        
        <div class="col-md-12">               
            <div class="col-md-12" >
             <br>
                <p>Tersangka  </p>
        <table id="table_tersangka" class="table table-bordered">
            <thead>
                <tr>
                    
                    <th style="text-align:center;" width="45px">No</th>
                    <th style="text-align:center;">Nama</th>
                    <th>Tempat, Tanggal Lahir</th>
                    <th>Umur</th>
                    
                </tr>
            </thead>
            <tbody id="tbody_tersangka">
                <?php // if (!$model->isNewRecord):?>
            
                    <?php foreach ($modelTersangka as $key2 => $value2): ?>
                        <tr data-id="">
                            <td id="tdTRS" width="20px"><?= $key2+1; ?></td>                                    
                            <td>
                            <?= $value2->nama ?>
                            </td>
                            <td><?= $value2->tmpt_lahir ?> ,   <?php echo "&nbsp".date('d-m-Y',strtotime($value2->tgl_lahir)) ?></td>
                            <td><?= $value2->umur ?></td>
                       
                            
                        </tr>
                    <?php endforeach; ?>
    
                <?php //endif; ?>
            </tbody>
        </table> 
        </div>
            
        </div>
        </div>
        <div class="col-md-12" style='margin-top:-20px'>
            <div class="col-md-12 right-content" >
            <br>
                
                <div class="col-md-12" style="padding-bottom:0px;margin-bottom:-10px"> 
                <div class="col-md-3" style="margin-left:-50px"> 
                    <?php
                echo $form->field($model, 'file_upload_petunjuk_p19')->widget(FileInput::classname(), [
                        'options' => ['accept'=>'application/pdf'],
                        'pluginOptions' => [
                            'showPreview' => true,
                            'showUpload' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'showCaption'=> false,
                            'allowedFileExtension' => ['pdf'],
                            'maxFileSize'=> 3027,
                            'browseLabel'=>'Unggah Isi Petunjuk'
                        ]
                    ]);
                    if ($model->file_upload_petunjuk_p19 != null || $model->file_upload_petunjuk_p19 != '') { 
                        echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload_petunjuk_p19,['target'=>'_blank'])."&nbsp;";
                    }
                ?>
                </div>
                <div class="col-md-3" style="margin-left:-90px">
                    <?php
                echo $form->field($model, 'file_upload_p19')->widget(FileInput::classname(), [
                        'options' => ['accept'=>'application/pdf'],
                        'pluginOptions' => [
                            'showPreview' => true,
                            'showUpload' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'showCaption'=> false,
                            'allowedFileExtension' => ['pdf'],
                            'maxFileSize'=> 3027,
                            'browseLabel'=>'Unggah P-19'
                        ]
                    ]);
                    if ($model->file_upload_p19 != null || $model->file_upload_p19 != '') { 
                        echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload_p19,['target'=>'_blank'])."&nbsp;";
                    }
                ?>
                </div>
                <?php //if(count($countP19)==0): ?>
                <div class="col-md-3" style="margin-left:-10px;margin-top:0.6%">               
                   <label >Berkas di Pecah ( Splitzing ) </label>
                   <input style="margin-top:1%" type="checkbox" name="PdmP19[is_split]" <?= ($model->is_split==1)?'checked="checked"':'' ?>  value="1" id="1">
                </div>
                <?php //endif; ?>
                <div class="col-md-3" style="margin-left:-110px;">
                <div class="form-group">
                <label style="padding-right:0px" class="control-label col-md-6" >Tanggal Diterima P-19 Oleh Penyidik</label>
                <div class="col-md-6">

                    <?=
                $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
                           // 'startDate' => $MinTgl,
                           // 'endDate'   => $MaxTgl,
						    'endDate' => date('d-m-Y'),
                        ]
                    ]
                ]);
                ?>
                </div>
                    
                </div>
                </div>
                </div>
                
                
                <!-- <div class="col-md-12" >
                <div class="form-group"> 
                <label  class="control-label col-md-12" ><center>Penanda Tangan</center></label>
                </div>
                <br>
                </div>
                 <div class="col-md-12" style="padding-bottom:10px" >
                 <div id="box-penanda-tangan"></div>
                 </div>
                 <br>
                 <br>
                 <div class="col-md-12">
                 <div id="box-form-tembusan"></div>
                 </div> -->
            </div>
        </div>
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P19, 'id_table' => $model->id_p19]) ?>
    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
        <?php if(!$model->isNewRecord){ ?>
            <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p19/cetak?id='.$model->id_p19.'&id_pengantar='.$model->id_pengantar])?>">Cetak</a>
        <?php } ?>
                  
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/pdm-p19/index'], ['class' => 'btn btn-danger']) ?>
    </div>
    <?php ActiveForm::end(); ?>
    </div>
</section>
<br>

<?php 

    if(count($countP19)==0)
    {
        $tanggal_diterima_p19_min =  $modelP18->tgl_dikeluarkan;
    }
    else
    {
        $tanggal_diterima_p19_min =  $tgl_pengantar;
    }
?>
<?php
$script = <<< JS
$('.field-pdmp19-file_upload_petunjuk_p19').parent().find('a').insertAfter($('.field-pdmp19-file_upload_petunjuk_p19 div:eq(0) span'));
$('.field-pdmp19-file_upload_p19').parent().find('a').insertAfter($('.field-pdmp19-file_upload_p19 div:eq(0) span'));

        
        date            = '$tanggal_diterima_p19_min';
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate());
        endDate.setDate(endDate.getDate()+7);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp19-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmp19-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp19-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp19-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp19-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp19-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp19-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp19-tgl_dikeluarkan-disp').removeAttr('disabled');


$('#pdmp19-tgl_dikeluarkan-disp').on('change',function(){
        var date        = $(this).val().split('-');
        date            = date[2]+'-'+date[1]+'-'+date[0];
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate());
        //endDate.setDate(endDate.getDate()+40);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp19-tgl_terima').html();
        var datecontrol         = $('#pdmp19-tgl_terima-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp19-tgl_terima').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':0,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp19-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp19-tgl_terima-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp19-tgl_terima-disp').datecontrol(datecontrol_001);
          $('.field-pdmp19-tgl_terima').removeClass('.has-error');
          $('#pdmp19-tgl_terima-disp').removeAttr('disabled');
  });

var cek_tgl_update  = '$tgl_dikeluarkan_new_record';
if(cek_tgl_update!=0)
{
    date            = cek_tgl_update;
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate());
        //endDate.setDate(endDate.getDate()+40);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp19-tgl_terima').html();
        var datecontrol         = $('#pdmp19-tgl_terima-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp19-tgl_terima').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':0,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp19-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp19-tgl_terima-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp19-tgl_terima-disp').datecontrol(datecontrol_001);
          $('.field-pdmp19-tgl_terima').removeClass('.has-error');
          $('#pdmp19-tgl_terima-disp').removeAttr('disabled');
}



// $("#Editor1_div").on("onload", function() {
//    alert($('.ribbon_office2007_blue').length); 
// });

// $('.field-pdmp19-id_penandatangan').insertAfter($('#box-penanda-tangan'));
// $('.box-body:eq(0)').remove();

// $('.box-body .pull-left').addClass('col-md-12 Formtembusan');
// $('.Formtembusan').removeClass('pull-left'); 
// $('.Formtembusan').removeClass('col-md-8');
// $('.Formtembusan').insertAfter($('#box-form-tembusan'));
// $('.Formtembusan .form-group .col-md-8').addClass('col-md-10');
// $('.Formtembusan .form-group .col-md-8').removeClass('col-md-8');

// $( "body" ).delegate('#tambah-tembusan','click',function(){
//     $('.Formtembusan .form-group .col-md-8').addClass('col-md-10');
//     $('.Formtembusan .form-group .col-md-8').removeClass('col-md-8');
//});
JS;
$this->registerJs($script);
?>

<?php

 
    $js = <<< JS
        $('td').dblclick(function (e) {
        var idp19 = $(this).closest('tr').data('id');
        var idp24 = $(this).closest('tr').data('id_p24');
        var idberkas = $(this).closest('tr').data('id_berkas');        
        var url = window.location.protocol + "//" + window.location.host + "/pdsold/pdm-p19/update2?id_p19=" + idp19+"&id_p24=" +idp24+"&id_berkas=" +idberkas;
        $(location).attr('href',url);
    });

    $(".btnHapusCheckboxIndex").attr("disabled",true);
JS;

    $this->registerJs($js);
?>