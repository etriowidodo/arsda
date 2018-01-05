<?php
use app\assets\AppAsset;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\modules\pdsold\models\PdmPenandatangan;
use app\components\GlobalConstMenuComponent;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use dosamigos\ckeditor\CKEditor;
use kartik\widgets\FileInput;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP18 */
/* @var $form yii\widgets\ActiveForm */
$this->registerJs(
  "$('#p18-form').on('afterValidate', function (event, messages) {
     
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
  });"
  );
?>

<div class="box box-primary">
    <div class="box-header"></div>

   <?php 
	
			$form = ActiveForm::begin(
			[
                'id' => 'p18-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ],
                'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
            ]);
			?>
			
			<div class="box-body">
            <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
            <div class="col-md-12">
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
            </div>
            <div class="col-md-12">
                <div class="form-group">
                <label class="control-label col-md-2">Instansi Penyidik</label>
                   <div class="col-md-3">
                      <input type="text" class="form-control" value="<?= $modelInsPenyidik->nama ?>  ( <?= $modelInsPenyidik->akronim ?> )" readonly="true">
                    </div>
                </div>
            </div>
            </div>
       
        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>
         <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
            <div class="col-md-12">
        <h4 style="">Tersangka</h4>
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
                                    <td><?php echo  $value2->tmpt_lahir.', '.date('d-m-Y',strtotime($value2->tgl_lahir)) ?></td>
                                    <td><?= $value2->umur ?></td>
                               
                                    
                                </tr>
                            <?php endforeach; ?>
            
                        <?php //endif; ?>
                    </tbody>
                </table> 
                </div>
            </div>
      <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
            <div class="col-md-12">
        <div class="col-md-12" id='file_upload'>
        <div class="form-group">
            
            <div class="col-sm-3"> 
                <?php
                echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                        'options' => ['accept'=>'application/pdf'],
                        'pluginOptions' => [
                            'showPreview' => true,
                            'showUpload' => false,
                            'showRemove' => false,
                            'showClose' => false,
                            'showCaption'=> false,
                            'allowedFileExtension' => ['pdf'],
                            'maxFileSize'=> 3027,
                            'browseLabel'=>'Unggah P-18...',
                        ]
                    ]);
                    if ($model->file_upload != null || $model->file_upload != '') { 
                        echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                    }
                ?>
            </div>
        </div>
        </div>
       
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P18, 'id_table' => $model->id_p18]) ?>
    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
        <?php if(!$model->isNewRecord){ ?>
            <a href="javascript:void(0)" class="btn btn-warning" id="printToSave">Cetak</a>
        <?php }else{ ?>
            <a href="javascript:void(0)" class="btn btn-warning" id="printToSave">Cetak</a>
        <?php }?>
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/pdm-p18/index'], ['class' => 'btn btn-danger']) ?>
        <input type="hidden" name="print"  id="print" value="0">
    </div>
        
 <?php ActiveForm::end(); ?>
</div>
</div>
</div>
<?php
$script = <<< JS
$('.field-pdmp18-file_upload').parent().find('a').insertAfter($('.field-pdmp18-file_upload div:eq(0) span'));
//$('#file_upload').insertAfter($('.col-md-12:eq(3)'));
  $('#pdmp18-tgl_dikeluarkan-disp').parent().attr('id','tgl_keluar');
  $(document).ready(function(){
    var tgl             = '$modelPengantar->tgl_pengantar';
        date            =  tgl;
        var someDate    = new Date(date);
        var endDate     = new Date();
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate());
        endDate.setDate(endDate.getDate());
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('#tgl_keluar').html();
        var datecontrol         = $('#pdmp18-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('#tgl_keluar').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp18-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
      $('#pdmp18-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmp18-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
  });
//script pembatasan tanggal per 1 minggu CreateBy Etrio-Widodo
  $('#pdmp18-tgl_dikeluarkan-disp').on('click hover',function(){
        var tgl         = '$modelPengantar->tgl_pengantar';
        date            =  tgl;
        var someDate    = new Date(date);
        var endDate     = new Date();
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate());
        endDate.setDate(endDate.getDate());
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('#tgl_keluar').html();
        var datecontrol         = $('#pdmp18-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('#tgl_keluar').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp18-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
      $('#pdmp18-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmp18-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
      //$('.field-pdmspdp-tgl_terima').removeClass('.has-error');
  });
  // var cetak   = '/pdsold/pdm-p18/cetak?id_p18=""&id_pengantar=""';
  //                                               //var update  =  'update?id='+data;
  //                                               window.open(cetak, '_blank');

$('#printToSave').click(function(){

    var print       = $('#pdmp18-no_surat').val();
    var tempat      = $('#pdmp18-dikeluarkan').val();
    var tgl         = $('#pdmp18-tgl_dikeluarkan-disp').val();        
    var tandaTangan = $('#pdmp18-id_penandatangan').val(); 

    var loc = window.location;
    var pathName = loc.search;
    var upd =  decodeURIComponent(pathName);
    var ex = pathName.split('=');
    var id_pengantar = decodeURIComponent(ex[2]);
    var idx = id_pengantar.split('|');
    var id_p18 = idx[0]+'|'+print;
    var updates   = 'update?id_p18='+id_p18+'&id_pengantar='+id_pengantar;
    //console.log(cetak);
    //return false;

        
        if(print!=''&&tempat!=''&&tgl!=''&&tandaTangan!=''){
             $.ajax({
                type        : 'POST',
                url         :'/pdsold/pdm-p18/cek-no-surat',
                data        : 'no_surat='+print,                                
                success     : function(data){
                                  if(data>0){
                                    if(id_p18=='0'){
                                        alert('No P-18 : Telah Tersedia Silahkan Input No Lain');
                                        return false;
                                    }else{
                                        $("#print").val('1');
                                             $.ajax({
                                                type: "POST",
                                                async:    false,
                                                url: '/pdsold/pdm-p18/update'+upd,
                                                data: $("form").serialize(),
                                                success:function(data){ 
                                                $('.box-footer').hide(); 
                                                    var cetak   = '/pdsold/pdm-p18/cetak?id_p18='+id_p18+'&id_pengantar='+id_pengantar;
                                                    var update  =  updates;
                                                    window.open(cetak, '_blank');
                                                    window.focus();
                                                    setTimeout(function(){ window.location = update; }, 3000);
                                                    
                                            
                                                },
                                            });
                                    }
                                    
                                  }else{
                                    $("#print").val('1');
                                         $.ajax({
                                            type: "POST",
                                            async:    false,
                                            url: '/pdsold/pdm-p18/update'+upd,
                                            data: $("form").serialize(),
                                            success:function(data){ 
                                            $('.box-footer').hide(); 
                                                var cetak   = '/pdsold/pdm-p18/cetak?id_p18='+id_p18+'&id_pengantar='+id_pengantar;
                                                var update  =  updates;
                                                window.open(cetak, '_blank');
                                                window.focus();
                                                setTimeout(function(){ window.location = update; }, 3000);
                                                
                                        
                                            },
                                        });
                                  }
                              }
                });

        }else{
            $('form').submit();
        }
});
JS;
$this->registerJs($script);
?>