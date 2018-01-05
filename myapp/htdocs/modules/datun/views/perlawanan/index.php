<?php

use app\assets\AppAsset;
use app\modules\datun\models\MsInstPenyidik;
use app\modules\datun\models\MsInstPelakPenyidikan;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use app\modules\datun\models\MsJenisPidana;
use app\modules\datun\models\MsJenisPerkara;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */
/* @var $form yii\widgets\ActiveForm */
$this->title = 'Pelawanan Tergugat atas Sita Jaminan (S - 18)';
//jaka | 25 Mei 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#spdp-form').on('afterValidate', function (event, messages) {
     
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

//script pembatasan tanggal per 1 minggu CreateBy Etrio-Widodo
  $('#pdmspdp-tgl_surat-disp').on('change hover',function(){
    var date        = $(this).val().split('-');
    date            = date[2]+'-'+date[1]+'-'+date[0];
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
    var input               = $('#tgl_diterima').html();
    var datecontrol         = $('#pdmspdp-tgl_terima-disp').attr('data-krajee-datecontrol');
    $('#tgl_diterima').html(input);
    var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_001 = {'idSave':'pdmspdp-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
  $('#pdmspdp-tgl_terima-disp').kvDatepicker(kvDatepicker_001);
  $('#pdmspdp-tgl_terima-disp').datecontrol(datecontrol_001);
  $('.field-pdmspdp-tgl_terima').removeClass('.has-error');
  var result    = $(this).val().split('-');
  result0       = parseInt(result[0]);
  result1       = parseInt(result[1]);
  result2       = parseInt(result[2]);
  valDay(result1,result0,result2);
    $('.hour').removeAttr('disabled');
    $('.minute').removeAttr('disabled');
    $('.day').removeAttr('disabled');
    $('.month').removeAttr('disabled');
    $('.year').removeAttr('disabled');
  var resultFulldate = '00-00-'+('0'+result0).slice(-2)+'-'+('0'+result1).slice(-2)+'-'+result2;
      $('#pdmspdp-tgl_kejadian_perkara').val('');
      $('#pdmspdp-tgl_kejadian_perkara').val(resultFulldate); 

  });

// Validasi Waktu Kejadian Perkara CreateBy Etrio-Widodo
function valDay(bln,tgl,th)
{
   $('.day   option[value=\"'+tgl+'\"]').prop('selected','true');
   $('.month option[value=\"'+(bln-1)+'\"]').prop('selected','true');
   $('.year  option[value=\"'+th+'\"]').prop('selected','true');

   $('.month option').each(function(i){
    var value_bln = parseInt($(this).val())+1;
    if(value_bln>=0)
    {
      $(this).removeAttr('disabled');
      if(value_bln==bln)
        {
            $(this).prop('selected','true');
        } 
      if(value_bln>=(bln+1))
        {
            $(this).prop('disabled','true');
        }   
    }
        
    }) 
}

// Validasi Waktu Kejadian Perkara CreateBy Etrio-Widodo
    $('#pdmspdp-tgl_kejadian_perkara').on('change',function(){
      var today = new Date();
      var getYear   = today.getFullYear();
      var minute    = $('span.combodate .minute option:selected').text();    
      var hour      = $('span.combodate .hour option:selected').text();
      var day       = $('span.combodate .day option:selected').text();
      var month     = $('span.combodate .month option:selected').text();
      var year      = $('span.combodate .year option:selected').val();
     
      if(year=='')
      {
        year = '0000';
      }
      if(minute=='-')
      {
        minute = '';
      }
      if(hour=='-')
      {
        hour = '';
      }
      if(day=='-')
      {
        day = '00';
      }
      if(month=='-')
      {
        month = '00';
      }
      var full_date = hour+'-'+minute+'-'+day+'-'+month+'-'+year;
      $(this).val('');
      $(this).val(full_date);

    });
  "

  );
//END <-- CMS_PIDUM001 -->
?>
<style type="text/css">
    h3{
        font-weight: bold;
    }
</style>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <!--    <div class="box-header"></div>-->
        <?php
                        
        $form = ActiveForm::begin([
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
        ]);
        ?>

        <!-- 1 -->
        <div class="box box-primary" style="border-color: #eaba05;overflow: hidden;padding-bottom:15px;">
            <br>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Asal Panggilan</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">No. Surat Panggilan Sidang</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                        </div>
                    </div>
                </div>
            </div>      
            <br/><br/>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="#" placeholder="Kejaksaan Agung Republik Indonesia" disabled="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Tanggal Diterima</label>
                        <div class="col-md-7">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
            <br/><br/>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tergugat</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Penggugat</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-5">Kuasa Penggugat</label>
                        <div class="col-md-7">
                            <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                        </div>
                    </div>
                </div>
            </div>      
            <br/><br/>
            <div class="col-md-12" style="padding-top:5px;">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No. SKKS (S-2.A.1)</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="#" placeholder="PRINT-" disabled="true">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-5">Tanggal SKKS (S-2.A.1)</label>
                        <div class="col-md-7">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker" disabled="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>      
            <br/><br/>
        </div>
        <!-- 1 -->

        <!-- 2 -->
        <div class="col-md-6" style="padding-left:0px;">
          <div class="content-wrapper-1">
            <div class="panggilan">
              <div class="form-group">
                  <label class="control-label col-md-4">Nomor</label>
                  <div class="col-md-8">
                      <input type="text" class="form-control" id="#" placeholder="">
                  </div>
              </div>
              <div class="form-group">
                <label class="control-label col-md-4">Perihal</label>
                <div class="col-md-8">
                  <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                </div>
              </div>
            </div>
          </div>
          <br/>
          <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
            <div class="content-wrapper-1">
              <div class="box-header with-border" style="border-color: #c7c7c7;padding-top:0px">
                  <div class="col-md-6" style="padding-left:0px;">
                      <h3 class="box-title"> Penetapan Sita Jaminan</h3>
                  </div>
              </div>
              <br/> 
              <div class="panggilan">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="#" placeholder="">
                    </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-md-4">Tanggal</label>
                  <div class="col-md-8">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker" disabled="true">
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- 2 -->

        <!-- 2 -->
        <div class="col-md-6" style="padding-right:0px;padding-bottom:15px;">
          <div class="content-wrapper-1">
            <div class="panggilan">
            <div class="form-group">
                <label class="control-label col-md-4">Dikeluarkan</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-4">Tanggal</label>
              <div class="col-md-8">
                  <div class="input-group date">
                      <div class="input-group-addon">
                          <i class="fa fa-calendar"></i>
                      </div>
                      <input type="text" class="form-control pull-right" id="datepicker">
                  </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-4">Kepada Yth.</label>
              <div class="col-md-8">
                <textarea class="form-control" style="height:110px;"></textarea>
              </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-4">Di</label>
                <div class="col-md-8">
                    <input type="text" class="form-control" id="#" placeholder="">
                </div>
            </div>
            </div>
          </div> 
        </div>
        <div class="clearfix"></div>
        <!-- 2 -->

        <!-- Tambah JPN -->
        <div class="col-md-6 pull-left" style="padding-left:0px;padding-bottom:15px;">
            <div class="content-wrapper-1">
                <div class="tambah-jpn">
                    <div class="inline">
                        <button type="button" class="btn btn-dtn" data-toggle="modal" data-target="#tambahJPN">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Tambah JPN
                        </button>
                    </div>
                    <div class="pull-right">
                        <a class="btn btn-success btnUbahCheckboxIndex" id="idUbah" title="Edit" disabled="disabled"><i class="fa fa-stack-exchange" aria-hidden="true"></i> Ubah</a>&nbsp;
                        <a class="btn btn-danger hapusTembusan btnHapusCheckboxIndex" id="idHapus" title="Hapus" disabled="disabled"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a><br></div><br><br>
                        <div id="btnHapus"></div>
                        <div id="btnUpdate"></div>
                    </div>

                <div class="row">
                    <div class="col-md-12">
                        <table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                                <tr role="row">
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th style="text-align:center;width:40px;"><input type="checkbox" name="" value="1" id="checkpermohonan"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Bagus Priyonggo, SH</td>
                                    <td style="text-align:center;"><input type="checkbox" name="" value="1"></td>
                                 </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Annisa Kusuma, SH</td>
                                    <td style="text-align:center;"><input type="checkbox" name="" value="1"></td>
                                 </tr>
                            </tbody>
                        </table>
                        <p style="color:red;font-size:10px;">*JPN yang ditugaskan minimal 2 orang</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Tambah JPN -->

        <!-- texteditor -->
        <div class="col-md-12" style="padding:0px">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                        <li class="active">
                            <a href="#tab-alasan" data-toggle="tab">Alasan</a>
                        </li>
                        <li>
                            <a href="#tab-primair" data-toggle="tab">Primair</a>
                        </li>
                        <li>
                            <a href="#tab-subsidair" data-toggle="tab">Subsidair</a>
                        </li>          
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-alasan">
                            <form>
                                <textarea class="ckeditor" name='isi'></textarea>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tab-primair">
                            <form>
                                <textarea class="ckeditor" name='isi'></textarea>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="tab-subsidair">
                            <form>
                                <textarea class="ckeditor" name='isi'></textarea>
                            </form>
                        </div>         
                    </div>
                </div>
            </div>
        </div>
        <!-- ///// -->

        <div class="col-md-6" style="padding: 0px;margin-top:-10px;">
            <h3 class="box-title">
                <a href="#" class='btn btn-primary' onclick="document.getElementById('fileID').click(); return false;" /><i class="fa fa-cloud-upload" aria-hidden="true" ></i> Upload Lampiran S-18</a>
                <input type="file" id="fileID" style="visibility: hidden;" />
            </h3>
        </div>

        <div class="col-md-6" style="padding-right:0px;">
            <div class="kuasa-tergugat">
                <h4>Kuasa Tergugat</h4>
                <table class="table table-bordered" style="background:#eee;cursor:not-allowed;">
                    <tbody>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Nama</th>
                        </tr>
                        <tr>
                          <td>1.</td>
                          <td>Bagus Priyonggo, SH</td>
                        </tr>
                        <tr>
                          <td>2.</td>
                          <td>Annisa Kusuma, SH</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <br/>  
    <div class="box-footer" style="text-align: center;"> 
        <button type="submit" class="btn btn-dtn"><i class="fa fa-floppy-o" aria-hidden="true"></i> Simpan</button>
        <button type="submit" class="btn btn-dtn"><i class="fa fa-print" aria-hidden="true"></i> Cetak</button>
        <button type="submit" class="btn btn-danger">Batal</button>
    </div>
        <div id="hiddenId"></div>
    <?php ActiveForm::end(); ?>
</section>


<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Tambah Tersangka</h7>'
]);
//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
?>
<?php
Modal::begin([
    'id'     => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Kewarganegaraan<button type="button" id="contoh">klik</button></h7>'

]);
Modal::end();



?>
<?php
$script = <<< JS
// CreateBy Etrio Widodo
$(document).ajaxStart(function(){
    $('button').hide();    
}).ajaxStop(function(){
    $('button,a').show();    
});
$('#m_tersangka').on('hidden.bs.modal', function () {
localStorage.clear();
});
$('#m_tersangka').on('show.bs.modal', function () {   
            $("body").css('overflow-y','hidden');
        });
$(document).ready(function(){
    var kode_ip = $('#InstansiPenyidik').val();
    $.ajax({
        type: "POST",
        url: '/pidum/spdp/penyidik',
        data: 'kode_ip='+kode_ip,
        success:function(data){
            console.log(data);
            $('#InstansiPelaksanaPenyidik').html(data);
        }
    });
    
    var id_cb = $('#cb_pdm_mst_perkara').val();
    $.ajax({
        type: "POST",
        url: '/pidum/spdp/showmstperkara',
        data: 'id_pdmmstperkara='+id_cb,
        success:function(data){
            console.log(data);
            $('#pdmspdp-id_pk_ting_ref').html(data);
        }
    });
            
    var today = new Date();
    var year = today.getFullYear();
    $('#pdmspdp-tgl_kejadian_perkara').combodate({
            firstItem: 'name',
            minYear: year-15,
            maxYear: year,
            minuteStep: 1,
            smartDays:true
    });
  var tgl_kejadian_perkara_db         = '$model->tgl_kejadian_perkara';
  var split_tgl_kejadian_perkara_db   =  tgl_kejadian_perkara_db.split('-');
  var hour      = split_tgl_kejadian_perkara_db[0];     
  var minute    = split_tgl_kejadian_perkara_db[1];
  var day       = split_tgl_kejadian_perkara_db[2];
  var month     = split_tgl_kejadian_perkara_db[3];
  var year      = split_tgl_kejadian_perkara_db[4];
   if(minute =='')
  {
    $('.minute option:eq(0)').prop('selected',true);
  }
  if(hour =='')
  {
    $('.hour option:eq(0)').prop('selected',true);
  }
  if(day =='00')
  {
    $('.day option:eq(0)').prop('selected',true);
  }
   if(month =='00')
  {
    $('.month option:eq(0)').prop('selected',true);
  }
  if(year =='0000')
  {
    $('.year option:eq(0)').prop('selected',true);
  }

if($('#pdmspdp-tgl_surat-disp').val()=='')
{
    $('.hour').prop('disabled','true');
    $('.minute').prop('disabled','true');
    $('.day').prop('disabled','true');
    $('.month').prop('disabled','true');
    $('.year').prop('disabled','true');
     
}
    $('.combodate .hour').before('<span>Jam  </span>');
    $('.combodate .day').before('<span>Tanggal  </span>'); 

     $('.day,.month,.year').on('change',function(){

        var endDate       = $('.year option:selected').text()+'-'+$('.month option:selected').text()+'-'+$('.day option:selected').text(); 
        var IntDate       = $('#pdmspdp-tgl_surat-disp').val().split('-');
        var ResultDate    = IntDate[2]+'-'+IntDate[1]+'-'+IntDate[0];
        var ResultEndDate = endDate;
        var someDate = new Date(ResultDate);
        someDate.setDate(someDate.getDate() )
        var dateFormated        = someDate.toISOString().substr(0,10);
        var compareStartDate    = new Date(dateFormated);
        var compareEndDate      = new Date(ResultEndDate);
        if($('.month option:selected').text()=='-'){
          $('.day option:eq(0)').prop('selected','true');
        }
        if($('.year option:selected').text()=='-'){
          $('.day option:eq(0)').prop('selected','true');
          $('.month option:eq(0)').prop('selected','true');
        }
        if(compareEndDate>compareStartDate)
        {
           if (IntDate[0].charAt(0) === '0'){ IntDate[0] = IntDate[0].replace("0", "")};
           if (IntDate[1].charAt(0) === '0'){ IntDate[1] = IntDate[1].replace("0", "")};
            //$('.day   option[value=\"'+IntDate[0]+'\"]').prop('selected','true');
            //$('.month option[value=\"'+(IntDate[1]-1)+'\"]').prop('selected','true');
            bootbox.dialog({
                message: "<center>Tanggal Kejadian Perkara Harus Lebih Kecil dari Tanggal Spdp </center>",
                buttons:{
                            Ok : {
                                label: "Ya",
                                className: "btn-danger",
                                callback: function(){
                                  $('.day   option[value=\"'+IntDate[0]+'\"]').prop('selected','true');
                                  $('.month option[value=\"'+(IntDate[1]-1)+'\"]').prop('selected','true');
                                }
                            }
                        }
                    });
            
        }
     });
});





   if($('.btn-warning').text()=='Simpan')
    {
     $('.btn-warning').attr('type','button');
     $('.btn-warning').attr('id','simpan');
    } 
    // Get the input box
        var textInput = document.getElementById('pdmspdp-no_surat');

        // Init a timeout variable to be used below
        var timeout = null;

        // Listen for keystroke events
        textInput.onkeyup = function (e) {

            // Clear the timeout if it has already been set.
            // This will prevent the previous task from executing
            // if it has been less than <MILLISECONDS>
            clearTimeout(timeout);

            // Make a new timeout set to go off in 800ms
            timeout = setTimeout(function () {
                    $.ajax({
                                type        : 'POST',
                                url         :'/pidum/spdp/cek-no-surat-spdp',
                                data        : 'no_surat='+textInput.value, 
                                beforeSend  : function()
                                                {
                                                   // $('#loading').modal('show');
                                                },                  
                                success     : function(data)
                                                {
                                                  // $('#loading').modal('hide');
                                                  if(data>0)
                                                  {
                                                    alert('No Spdp : Telah Tersedia Silahkan Input No Lain');
                                                  }
                                              }
                        });
            }, 2000);
        };

$('#simpan').click(function(){
    var no_surat        = $('#pdmspdp-no_surat').val();
    var jumlahTersangka = $('#tbody_tersangka tr').length;
    if(no_surat!='')
    {
        //Etrio WIdodo
        if(jumlahTersangka<1)
        {
           bootbox.dialog({
                message: "Apakah Data Tersangka Benar Kosong ?",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-warning",
                        callback: function(){
                          $.ajax({
                                    type    : 'POST',
                                    url     :'/pidum/spdp/cek-no-surat-spdp',
                                    data    : 'no_surat='+no_surat,                      
                                    success : function(data)
                                                {
                                                  if(data>0)
                                                  {
                                                    alert('No Spdp : Telah Tersedia Silahkan Input No Lain');
                                                    $('#pdmspdp-no_surat').val("");
                                                    $('#spdp-form').submit();
                                                  }
                                                  else
                                                  {
                                                    $('button').hide();
                                                    $('#spdp-form').submit();
                                                  }
                                                }
                                    }); 
                        }
                    },
                    tidak : {
                        label: "Tidak",
                        className: "btn-warning",
                        callback: function(result){
                            //$(".btnHapusCheckbox").off("click");
                        }
                    }
                }
            });
        }
        else
        {
             $.ajax({
                    type    : 'POST',
                    url     :'/pidum/spdp/cek-no-surat-spdp',
                    data    : 'no_surat='+no_surat,                      
                    success : function(data)
                                {
                                  if(data>0)
                                  {
                                    alert('No Spdp : Telah Tersedia Silahkan Input No Lain');
                                    $('#pdmspdp-no_surat').val("");
                                    $('#spdp-form').submit();
                                  }
                                  else
                                  {
                                    $('button').hide();
                                    $('#spdp-form').submit();
                                  }
                                }
                    }); 
        }
    }else
    {
        $('#spdp-form').submit();
    }
    
   

});

        
        //<!-- CMS_PIDIUM001_4 bowo 25 mei 2016 -->
        $('#pdmspdp-no_surat').attr('placeholder','Nomor SPDP');
        $('#InstansiPenyidik').change(function(){
            var kode_ip = $(this).val();
            $.ajax({
                type: "POST",
                url: '/pidum/spdp/penyidik',
                data: 'kode_ip='+kode_ip,
                success:function(data){
                    console.log(data);
                    $('#InstansiPelaksanaPenyidik').html(data);
                }
            });
        });
        
        $('#cb_pdm_mst_perkara').change(function(){
            var id_cb = $(this).val();
            $.ajax({
                type: "POST",
                url: '/pidum/spdp/showmstperkara',
                data: 'id_pdmmstperkara='+id_cb,
                success:function(data){
                    console.log(data);
                    $('#pdmspdp-id_pk_ting_ref').html(data);
                }
            });
        });
        
        $('.tambah_calon_tersangka').click(function(e){

            var href = $(this).attr('href');
            if(href != null){
                var id_tersangka = href.substring(1, href.length);
            }else{
                var id_tersangka = '';
            }
            
            if($('#tr_id'+id_tersangka+' td input[type=hidden]').length!=0)
            {
                edit_tersangka(id_tersangka);

            }else
            {
                    if ($('#pdmspdp-tgl_surat-disp').val() != '')
                    {
                            if($('#pdmspdp-tgl_kejadian_perkara').val() !='')
                            {  
                                $('#m_tersangka').html('');
                                $('#m_tersangka').load('/pidum/spdp/show-tersangka?id_tersangka='+id_tersangka);
                                $('#m_tersangka').modal('show');
                            }
                            else
                            {
                               if($('#tbody_tersangka tr').length<1){
                                    bootbox.dialog({
                                    message: "Tanggal Kejadian Perkara Belum Terisi Anda Yakin Akan Menambah Tersangka ?",
                                    buttons:{
                                                ya : {
                                                    label: "Ya",
                                                    className: "btn-warning",
                                                    callback: function(){
                                                        $('#m_tersangka').html('');
                                                        $('#m_tersangka').load('/pidum/spdp/show-tersangka?id_tersangka='+id_tersangka);
                                                        $('#m_tersangka').modal('show');
                                                    }
                                                },
                                                tidak : {
                                                    label: "Tidak",
                                                    className: "btn-warning",
                                                    callback: function(result){
                                                        $('#pdmspdp-tgl_kejadian_perkara-disp').focus();
                                                    }
                                                }
                                            }
                                        });
                               }
                               else
                               {
                                $('#m_tersangka').html('');
                                $('#m_tersangka').load('/pidum/spdp/show-tersangka?id_tersangka='+id_tersangka);
                                $('#m_tersangka').modal('show');
                               }
                            }
                    }
                    else
                    {
                     bootbox.dialog({
                                    message: "Silahkan isi tanggal Spdp terlebih dahulu",
                                    buttons:{
                                        ya : {
                                            label: "OK",
                                            className: "btn-warning",
                                            callback: function(){
                                              $('#pdmspdp-tgl_surat-disp').focus();
                                            }
                                        }
                                    }
                                });

                    }
            }
        });

        $('#tambah-pasal').click(function(){
                if($('#jenis-pasal').val() == 'tunggal'){
                    $('#tunggal').show();
                }

                if($('#jenis-pasal').val() == 'berlapis'){
                    $('#tunggal').hide();
                    $('#berlapis').show();
                }

            });

            $('#tambah-undang-pasal').click(function(){
                $('#undang-pasal-body').append(
                    '<tr>' +
                        '<td><input type="text" name="undang[]" class="form-control" placeholder="undang - undang"></td>' +
                    '</tr>' +
                    '<tr>' +
                        '<td><input type="text" name="pasal[]" class="form-control" placeholder="pasal - pasal"></td>' +
                    '</tr>'
                );
            });

    
    $(".hapus").click(function()
        {
             $.each($('input[type="checkbox"]'),function(x)
                {
                    var input = $(this);
                    if(input.prop('checked')==true)
                    {   var id = input.parent().parent();
                        id.remove();
                        $('#hiddenId').append(
                            '<input type="hidden" name="MsTersangka[nama_update][]" value='+input.val()+'>'
                            );
                    }
                }
             )
        }
    );
    
     
     



     
JS;

$this->registerJs($script);

?>

<script>
    function hapusTersangka(id)
    {
        //$("#tr_id"+id).remove();
        var arr = [id];
        jQuery.each(arr, function( i, val ) {
                    console.log(val);
                });
        //console.log(id);
    }
    function hapusTersangkaOld(id, value)
    {
        $("#tr_id_old"+id).remove();
        $('#hiddenId').append(
            '<input type="hidden" name="id_tersangka_remove[]" value='+value+'>'
        )
    }
</script>


<!-- Modal -->
<div class="modal fade" id="tambahJPN" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color:#000;"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Tambah JPN</h4>
            </div>
            <div class="modal-body">
            <table id="#" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                <thead>
                    <tr role="row">
                        <th>#</th>
                        <th>Nama</th>
                        <th style="text-align:center;width:40px;"><input type="checkbox" name="" value="1" id="checkpermohonan"></th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Bagus Priyonggo, SH</td>
                        <td style="text-align:center;"><input type="checkbox" name="" value="1"></td>
                     </tr>
                    <tr>
                        <td>2</td>
                        <td>Annisa Kusuma, SH</td>
                        <td style="text-align:center;"><input type="checkbox" name="" value="1"></td>
                     </tr>
                </tbody>
            </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary">Tambah</button>
            </div>
            <br/><br/>
        </div>
    </div>
</div>