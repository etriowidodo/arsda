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
$this->title = 'Jawaban Tergugat ( S-13 )';
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

        <!-- //////// -->
        <div class="col-md-6" style="padding-left:0px;">
          <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
            <br>
            <div class="col-md-12" style="padding-left:30px;padding-bottom:15px;">
              <div class="dikeluarkan" style="padding-bottom:10px;">
                <div class="form-group">
                    <label class="control-label col-md-5">Dikeluarkan</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="#" placeholder="" disabled="true">
                  </div>
                </div>
              </div>
              <div class="tanggal-keluar" style="padding-bottom:10px;">
                <div class="form-group">
                    <label class="control-label col-md-5">Tanggal</label>
                    <div class="col-md-7">
                      <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control pull-right" id="datepicker">
                    </div>
                  </div>
                </div>
              </div>
              <div class="kepada" style="padding-bottom:10px;">
                <div class="form-group">
                    <label class="control-label col-md-5">Kepada Yth.</label>
                    <div class="col-md-7">
                      <textarea class="form-control" style="height:80px;"></textarea>
                    </div>
                </div>
              </div>
              <div class="dikeluarkan" style="padding-bottom:10px;">
                <div class="form-group">
                    <label class="control-label col-md-5">Di</label>
                    <div class="col-md-7">
                      <input type="text" class="form-control" id="#" placeholder="">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /////////////// -->

        <!-- tambah JPN -->
        <div class="col-md-6" style="padding-right:0px;">
            <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-6">
                    <h3 class="box-title"> Tambah JPN</h3>
                </div>
            </div>
            <br>
            <div class="col-md-12" style="padding-bottom:15px;">
                <div class="">
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
            </div>
        </div>
        <!-- ////////////////////// -->

        <!-- jawaban -->
        <div class="col-md-12" style="padding-left:0px;padding-right:0px;">
          <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-6">
                    <h3 class="box-title"> Jawaban</h3>
                </div>
            </div>
            <br>
            <div class="col-md-12" style="padding-bottom:20px;">
              <form>
                <textarea class="ckeditor" name='jawaban'></textarea>
              </form>
            </div>
          </div>
        </div>
        <!--////-->

        <div class="col-md-12" style="padding: 0px;margin-top:-10px;">
          <div class="col-md-6" style="padding-left:0px;">
            <h3 class="box-title">
                <a href="#" class='btn btn-primary' onclick="document.getElementById('fileID').click(); return false;" /><i class="fa fa-cloud-upload" aria-hidden="true" ></i> Upload S-13</a>
                <input type="file" id="fileID" style="visibility: hidden;" />
            </h3>
          </div>
          <div class="col-md-6" style="padding-right:0px;">
            <div class="penerima-kuasa">
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