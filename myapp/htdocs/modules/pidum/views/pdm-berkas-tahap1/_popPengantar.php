<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use kartik\typeahead\TypeaheadAsset;
use app\modules\pidum\models\PdmPengantarTahap1;
use app\models\MsWarganegara;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\View;
use kartik\builder\Form;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use kartik\grid\GridView;
use app\modules\pidum\models\MsJenisPidana;

AppAsset::register($this);
//AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengantarTahap1 */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Pengantar Berkas Tahap 1';
?>

<?php
$this->registerJs(" 

 // $('#pdmpengantartahap1-tgl_pengantar-disp').on('change hover',function(){
 //   	var date        = $(this).val().split('-');
 //    date            = date[2]+'-'+date[1]+'-'+date[0];
 //    var someDate    = new Date(date);
 //    var endDate     = new Date();	
 //    someDate.setDate(someDate.getDate());
 //    endDate.setDate(endDate.getDate());
 //    var dateFormated        = someDate.toISOString().substr(0,10);
 //    var enddateFormated     = endDate.toISOString().substr(0,10);
 //    var resultDate          = dateFormated.split('-');
 //    var endresultDate       = enddateFormated.split('-');
 //    finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
 //    date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
 //    var input               = $('#tgl_terima').html();
 //    var datecontrol         = $('#pdmpengantartahap1-tgl_terima-disp').attr('data-krajee-datecontrol');
 //    $('#tgl_terima').html(input);
 //    var kvDatepicker_00 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
 //    var datecontrol_00 = {'idSave':'pdmpengantartahap1-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
 //  $('#pdmpengantartahap1-tgl_terima-disp').kvDatepicker(kvDatepicker_00);
 //  $('#pdmpengantartahap1-tgl_terima-disp').datecontrol(datecontrol_00);
 //  $('.field-pdmpengantartahap1-tgl_terima').removeClass('.has-error');
 //  });

    $('#pdmspdp-tgl_kejadian_perkara').on('change',function(){
      var today = new Date();
      var getYear = today.getFullYear();
      var minute    = $('span.combodate .minute option:selected').text();     
      var hour      = $('span.combodate .hour option:selected').text();
      var day       = $('span.combodate .day option:selected').text();
      var month     = $('span.combodate .month option:selected').text();
      var year      = $('span.combodate .year option:selected').val();
      if(year=='')
      {
        year = '0000';
      }
      if(minute=='minute')
      {
        minute = '00';
      }
      if(hour=='hour')
      {
        hour = '00';
      }
      if(day=='day')
      {
        day = '00';
      }
      if(month=='month')
      {
        month = '00';
      }
      var full_date = hour+'-'+minute+'-'+day+'-'+month+'-'+year;
      $(this).val(full_date);
    });
   
  ");
?>
<?php $form = ActiveForm::begin([            
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [        
                'labelSpan' => 1,
                'showLabels' => false
            ],
  ]); ?>
<!--<div class="modal-loading-new"></div>-->
<div id="pengantar">
<div class="" style="width:95%;margin: 2% auto;">

    <div class="">
    <div class="box box-primary"  style="border-color: #f39c12;">
    <div class="box-header"></div>
	<div class="col-md-12" style="padding:0">
            <div class="col-md-6" style="width:50%;">
                <div class="form-group">
                    <label class="control-label col-md-4"  style="width:30%;">Instansi Penyidik</label>

                    <div class="col-md-8" style="width:60%;">
                        <input class="form-control" value="<?= $modelSpdp->idAsalsurat->nama ?>" readOnly="true">
                    </div>

                </div>
            </div>
            <div class="col-md-6" style="width:50%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:40%;">Instansi Pelaksana Penyidikan</label>

                    <div class="col-md-8" style="width:60%;">
                        <input class="form-control" value="<?= MsInstPelakPenyidikan::findOne(['kode_ip'=>$modelSpdp->id_asalsurat,'kode_ipp'=>$modelSpdp->id_penyidik])->nama ?>"" readOnly="true">
                    </div>

                </div>
            </div>			
        </div>
		 <div class="clearfix" style="margin-bottom:14px;"></div>
		<div class="col-md-12" style="padding:0">
					<div class="col-md-6" style="width:50%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:30%;">Nomor Berkas</label>

                    <div class="col-md-8" style="width:60%;">
                        <input class="form-control" id="no_berkas" value="<?=$modelBerkas->no_berkas?>" readOnly="true">
                    </div>

                </div>
            </div>
			<div class="col-md-6" style="width:50%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:40%;">Tanggal Berkas</label>

                    <div class="col-md-9"  style="width:25%;">
                             <input class="form-control" id="tgl_berkas_popup" value="<?= date('d-m-Y', strtotime($modelBerkas->tgl_berkas))?>" readOnly="true">
							 
                            </div>
                        </div>    
                    </div>	
			</div>
        <div class="clearfix" style="margin-bottom:14px;"></div>
	
	<div class="col-md-6" style="width:50%;">
                <div class="form-group">
                    <label class="control-label col-md-4" style="width:30%;">Nomor Pengantar</label>

                   <div class="col-md-8" style="width:60%;">
				   <?= $form->field($model,'no_pengantar')->input('text',['onkeyup'  =>'
                                        var number =  /^[A-Za-z0-9-/]+$/+.;
                                        if(this.value.length>50)
                                        {
                                          this.value = this.value.substr(0,50);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        var str   = "";
                                        var slice = "";
                                        var b   = 0;
                                        for(var a =1;a<=this.value.length;a++)
                                        {
                                            
                                            slice = this.value.substr(b,1);
                                            if(slice.match(number))
                                            {
                                                
                                                str+=slice;
                                                
                                            }
                                            
                                            b++
                                        }
                                        this.value=str;
                                        ']) ?>			
		
            </div>
				</div>
					</div>
	<div class="col-md-6" style="width:25%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:55%;">Tanggal Pengantar</label>

                    <div class="col-md-8"  style="width:45%;" id="tgl_pengantar">
                                 <?php                                   
                                  $trim         = explode('-',$modelSpdp->tgl_terima);
                                  $tgl_spdp = $trim[2].'-'.$trim[1].'-'.$trim[0];
                								  $trim_end     = explode('-',date('Y-m-d', strtotime("+1 days")));
                								  $tgl_spdp_end = $trim_end[2].'-'.$trim_end[1].'-'.$trim_end[0];
                                  ?>
                                <?=
                                    $form->field($model, 'tgl_pengantar')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'startDate'=>  $tgl_spdp,
                                                'endDate'  =>  date('d-m-Y'),
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
	<div class="col-md-6" style="width:25%;">
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:55%;">Tanggal Diterima</label>
                    <div class="col-md-9"  style="width:45%;" id="tgl_terima">
                                <?=
                                    $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'options'=>[
                                                'placeholder'=>'DD-MM-YYYY',
                                            ],
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'startDate'=>  $tgl_spdp,
                                                'endDate'  =>  date('d-m-Y'),
                                            ]
                                        ]
                                    ]);   
                                ?>
                            </div>
                        </div>    
                    </div>
	</div>			

	<div class="box box-primary"  style="border-color: #f39c12;">
            <div class="box-header">
		      <div class="col-md-12" style="padding:0">
          <div class="col-md-6" style="padding-left:0px; width:50%;">
                <div class="form-group">
                    <label class="control-label col-md-4" >Waktu Kejadian</label>
                    <?php
                       if(!($modelSpdp->isNewRecord)):
                       $date = explode('-', $modelSpdp->tgl_kejadian_perkara); 
                        $minute =   $date[1];
                        $hour   =   $date[0];
                        $day    =   $date[2];
                        $month  =   $date[3];
                        $year   =   $date[4];

                        if($minute=='')
                        {
                          $minute='00' ; 
                        }
                        if($hour=='')
                        {
                          $hour='00' ; 
                        }
                        if($day=='00'||$day=='')
                        {
                            $day = '01';
                        }

                        if($month=='00'||$month=='')
                        {
                            $month = '01';
                        }
                         if($year =='0000'||$year=='')
                        {
                            $year  = date('Y');
                        }
                       endif;?>
                    <div class="col-md-8" style="padding-left: 0;"><!--CMS_PIDUM004 | jaka | rubah lebar kolom-->
                      <input   type="text" id="pdmspdp-tgl_kejadian_perkara" data-format="HH-mm-DD-MM-YYYY" data-template="HH  :  mm   DD - MM - YYYY "name="PdmSpdp[tgl_kejadian_perkara]" 
                      value="<?php echo trim($hour.'-'.$minute.'-'.$day.'-'.$month.'-'.$year); ?>">
                    </div>
                </div>
            </div>
      
      <div class="col-md-6" >
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:26%;">Tempat Kejadian</label>

                    <div class="col-md-10"  style="width:74%;">
                             <input class="form-control" name="tempat_kejadian" id="tempat_kejadian" value="<?= $modelSpdp->tempat_kejadian ?> ">
                  
                            </div>
                        </div>    
                    </div>
      </div>
			</div>
        </div>
		
	<div class="box box-primary"  style="border-color: #f39c12;margin-top: 20px;">	
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary addJPU2" id="popUpTersangka" >Tersangka</a>
                </h3>
            </div>	
            <div class="box-header with-border">
                <table id="table_tersangka" class="table table-bordered">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="45px">#</th>
                            <th style="text-align:center;">Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                            <th>Umur</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_tersangka">
                    <?php if (!$model->isNewRecord):?>	
                    <?php foreach ($modelTersangka2 as $key2 => $value2): $wnx = MsWarganegara::findOne($value2->warganegara)->nama; ?>
                        <tr id="tr_id<?= $value2['id_tersangka'] ?>" data-id="<?= $value2['id_tersangka'] ?>">
                            
                            <td  id="tdTRS" width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="<?= $value2->id_tersangka ?>"></td>
                            <td> 
                            <a href="#<?php echo $value2['id_tersangka'] ;?>" class="edit_tersangka" ><?= $value2->no_urut ?>. <?= $value2->nama?></a>
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][nama][]" value="<?= $value2->nama?>" class="form-control tersangka<?= $value2->id_tersangka ?>">

                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_tersangka][]" value="<?= $value2->id_tersangka?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][tmpt_lahir][]" value="<?= $value2->tmpt_lahir ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][tgl_lahir][]" value="<?= $value2->tgl_lahir ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" style="border:none; background-color:transparent;" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][umur][]" value="<?= $value2->umur ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">    
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_jkl][]" value="<?= $value2->id_jkl ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][alamat][]" value="<?= $value2->alamat ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">  
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_identitas][]" value="<?= $value2->id_identitas ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][no_identitas][]" value="<?= $value2->no_identitas ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][no_hp][]" value="<?= $value2->no_hp ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_agama][]" value="<?= $value2->id_agama ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][warganegara][]" attr-id="<?= $wnx ?>" value="<?= $value2->warganegara ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][pekerjaan][]" value="<?= $value2->pekerjaan ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][suku][]" value="<?= $value2->suku ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_pendidikan][]" value="<?= $value2->id_pendidikan ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_tersangka][]" value="<?= $value2->id_tersangka ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][no_urut][]" value="<?= $value2->no_urut ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">

                            </td>
                            <td>
                                <input type="text" class="form-control" readonly="true" style="border:none; background-color:transparent;" value="<?php echo  $value2->tmpt_lahir.', '.date('d-m-Y',strtotime($value2->tgl_lahir)) ?>">
                            </td>
                            <td>
                                <input type="text" style="border:none; background-color:transparent;" value="<?= $value2->umur.' Tahun' ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">                  
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    <?php if ($model->isNewRecord):?>	
                    <?php foreach ($modelTersangka2 as $key2 => $value2): $wnx = MsWarganegara::findOne($value2->warganegara)->nama; ?>
                        <tr id="tr_id<?= $value2['id_tersangka'] ?>" data-id="<?= $value2['id_tersangka'] ?>">
                            
                            <td  id="tdTRS" width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="<?= $value2->id_tersangka ?>"></td>
                            <td> 
                            <a href="#<?php echo $value2['id_tersangka'] ;?>" class="edit_tersangka" ><?= $value2->no_urut ?>. <?= $value2->nama?></a>
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][nama][]" value="<?= $value2->nama?>" class="form-control tersangka<?= $value2->id_tersangka ?>">

                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_tersangka][]" value="<?= $value2->id_tersangka?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][tmpt_lahir][]" value="<?= $value2->tmpt_lahir ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][tgl_lahir][]" value="<?= $value2->tgl_lahir ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" style="border:none; background-color:transparent;" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][umur][]" value="<?= $value2->umur ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">    
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_jkl][]" value="<?= $value2->id_jkl ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][alamat][]" value="<?= $value2->alamat ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">  
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_identitas][]" value="<?= $value2->id_identitas ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][no_identitas][]" value="<?= $value2->no_identitas ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][no_hp][]" value="<?= $value2->no_hp ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_agama][]" value="<?= $value2->id_agama ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][warganegara][]" attr-id="<?= $wnx ?>" value="<?= $value2->warganegara ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][pekerjaan][]" value="<?= $value2->pekerjaan ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][suku][]" value="<?= $value2->suku ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_pendidikan][]" value="<?= $value2->id_pendidikan ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][id_tersangka][]" value="<?= $value2->id_tersangka ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">
                            <input type="hidden" name="MsTersangkaBaru[<?= $value2->id_tersangka ?>][no_urut][]" value="<?= $value2->no_urut ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">

                            </td>
                            <td>
                                <input type="text" class="form-control" readonly="true" style="border:none; background-color:transparent;" value="<?php echo  $value2->tmpt_lahir.', '.date('d-m-Y',strtotime($value2->tgl_lahir)) ?>">
                            </td>
                            <td>
                                <input type="text" style="border:none; background-color:transparent;" value="<?= $value2->umur.' Tahun' ?>" class="form-control tersangka<?= $value2->id_tersangka ?>">                  
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table> 
                <div id="hiddenId"></div>
            </div>
        </div>
		
        <?php if ($model->isNewRecord){?>
            <?php if ($modelUuTahap1[0][undang] == '') {?>
            <div class="box box-primary "  style="border-color: #f39c12;">
                <div class="box-header with-border">
                    <div class="col-md-6">
                        <h5 class="box-title"> Undang-Undang & Pasal </h5>&nbsp;
                    </div>
                </div>
                <div class="body-undang-undang">
                        <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
                            <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
                                <div class="form-group">
                                    <div class="col-md-12 " style="padding-right:0px">
                                         <div class="form-group field-mspedoman-uu">
                                             <div class="col-sm-8">
                                                 <div class="form-group">
                                                    <label class="control-label col-md-2" >Undang Undang</label>
                                                    <div class="input-group col-md-8" >
                                                        <input type="text" readOnly placeholder="Undang-Undang" class="form-control undang-undang" value="" name="MsUndang[undang][]">
                                                        <input type="hidden" readOnly class="form-control tentang-undang-undang" value="" name="MsUndang[tentang][]">
                                                        <div class="input-group-btn">
                                                            <a class="btn btn-warning pilih-undang" href="/pidum/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label col-md-2" >Pasal</label>
                                                     <div class="input-group col-md-8" >
                                                         <input type="text" readOnly placeholder="Pasal Undang-Undang" class="form-control pasal-undang-undang" value="" attr-id='' name="MsUndang[pasal][]">
                                                         <div class="input-group-btn">
                                                             <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label col-md-2" >Dakwaan</label>
                                                     <div class="input-group col-md-4">
                                                         <select name="MsUndang[dakwaan][]" class="form-control select-dakwaan" >
                                                             <option value="0">-- Pilih --</option>
                                                             <option <?php if($value['dakwaan']==1){echo "selected='selected'";} ?> value="1">-- Juncto --</option>
                                                             <option <?php if($value['dakwaan']==2){echo "selected='selected'";} ?>  value="2">-- Dan --</option>
                                                             <option <?php if($value['dakwaan']==3){echo "selected='selected'";} ?>  value="3">-- Atau --</option>
                                                             <option <?php if($value['dakwaan']==4){echo "selected='selected'";} ?>  value="4">-- Subsider --</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
                                             <?php if($key>0){ ?>
                                                 <div class="col-sm-2">
                                                     <div class="input-group col-md-2" >
                                                         <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                                             <i class="fa fa-trash-o"></i> Hapus
                                                         </a>      
                                                     </div>
                                                 </div>
                                             <?php } ?>
                                        </div>
                                    </div>
                                </div>                          
                            </div>                                      
                        </div>
                    </div>
            </div>
            <?php } else {?>
            <div class="box box-primary "  style="border-color: #f39c12;">
                <div class="box-header with-border">
                    <div class="col-md-6">
                        <h5 class="box-title"> Undang-Undang & Pasal </h5>&nbsp;
                    </div>
                </div>
                <div class="body-undang-undang">
                    <?php  foreach ($modelUuTahap1 as $key => $value) { ?>
                        <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
                            <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
                                <div class="form-group">
                                    <div class="col-md-12 " style="padding-right:0px">
                                         <div class="form-group field-mspedoman-uu">
                                             <div class="col-sm-8">
                                                 <div class="form-group">
                                                    <label class="control-label col-md-2" >Undang Undang</label>
                                                    <div class="input-group col-md-8" >
                                                        <input type="text" readOnly placeholder="Undang-Undang" class="form-control undang-undang" value="<?= $value['undang'] ?>" name="MsUndang[undang][]">
                                                        <input type="hidden" readOnly class="form-control tentang-undang-undang" value="<?= $value['tentang']?>" name="MsUndang[tentang][]">
                                                        <div class="input-group-btn">
                                                            <a class="btn btn-warning pilih-undang" href="/pidum/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                                        </div>
                                                    </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label col-md-2" >Pasal</label>
                                                     <div class="input-group col-md-8" >
                                                         <input type="text" readOnly placeholder="Pasal Undang-Undang" class="form-control pasal-undang-undang" value="<?= $value['pasal'] ?>" attr-id='' name="MsUndang[pasal][]">
                                                         <div class="input-group-btn">
                                                             <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                                         </div>
                                                     </div>
                                                 </div>
                                                 <div class="form-group">
                                                     <label class="control-label col-md-2" >Dakwaan</label>
                                                     <div class="input-group col-md-4">
                                                         <select name="MsUndang[dakwaan][]" class="form-control select-dakwaan" >
                                                             <option value="0">-- Pilih --</option>
                                                             <option <?php if($value['dakwaan']==1){echo "selected='selected'";} ?> value="1">-- Juncto --</option>
                                                             <option <?php if($value['dakwaan']==2){echo "selected='selected'";} ?>  value="2">-- Dan --</option>
                                                             <option <?php if($value['dakwaan']==3){echo "selected='selected'";} ?>  value="3">-- Atau --</option>
                                                             <option <?php if($value['dakwaan']==4){echo "selected='selected'";} ?>  value="4">-- Subsider --</option>
                                                         </select>
                                                     </div>
                                                 </div>
                                             </div>
                                             <?php if($key>0){ ?>
                                                 <div class="col-sm-2">
                                                     <div class="input-group col-md-2" >
                                                         <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                                             <i class="fa fa-trash-o"></i> Hapus
                                                         </a>      
                                                     </div>
                                                 </div>
                                             <?php } ?>
                                        </div>
                                    </div>
                                </div>                          
                            </div>                                      
                        </div>
                        <?php } ?>
                    </div>
            </div>
            <?php } ?>
        <?php } else {?>
        <div class="box box-primary "  style="border-color: #f39c12;">
            <div class="box-header with-border">
                <div class="col-md-6">
                    <h5 class="box-title"> Undang-Undang & Pasal </h5>&nbsp;
                </div>
            </div>
            <div class="body-undang-undang">
                <?php  foreach ($modelUuTahap1 as $key => $value) { ?>
                    <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
                        <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
                            <div class="form-group">
                                <div class="col-md-12 " style="padding-right:0px">
                                     <div class="form-group field-mspedoman-uu">
                                         <div class="col-sm-8">
                                             <div class="form-group">
                                                <label class="control-label col-md-2" >Undang Undang</label>
                                                <div class="input-group col-md-8" >
                                                    <input type="text" readOnly placeholder="Undang-Undang" class="form-control undang-undang" value="<?= $value['undang'] ?>" name="MsUndang[undang][]">
                                                    <input type="hidden" readOnly class="form-control tentang-undang-undang" value="<?= $value['tentang']?>" name="MsUndang[tentang][]">
                                                    <div class="input-group-btn">
                                                        <a class="btn btn-warning pilih-undang" href="/pidum/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                                    </div>
                                                </div>
                                             </div>
                                             <div class="form-group">
                                                 <label class="control-label col-md-2" >Pasal</label>
                                                 <div class="input-group col-md-8" >
                                                     <input type="text" readOnly placeholder="Pasal Undang-Undang" class="form-control pasal-undang-undang" value="<?= $value['pasal'] ?>" attr-id='' name="MsUndang[pasal][]">
                                                     <div class="input-group-btn">
                                                         <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                                     </div>
                                                 </div>
                                             </div>
                                             <div class="form-group">
                                                 <label class="control-label col-md-2" >Dakwaan</label>
                                                 <div class="input-group col-md-4">
                                                     <select name="MsUndang[dakwaan][]" class="form-control select-dakwaan" >
                                                         <option value="0">-- Pilih --</option>
                                                         <option <?php if($value['dakwaan']==1){echo "selected='selected'";} ?> value="1">-- Juncto --</option>
                                                         <option <?php if($value['dakwaan']==2){echo "selected='selected'";} ?>  value="2">-- Dan --</option>
                                                         <option <?php if($value['dakwaan']==3){echo "selected='selected'";} ?>  value="3">-- Atau --</option>
                                                         <option <?php if($value['dakwaan']==4){echo "selected='selected'";} ?>  value="4">-- Subsider --</option>
                                                     </select>
                                                 </div>
                                             </div>
                                         </div>
                                         <?php if($key>0){ ?>
                                             <div class="col-sm-2">
                                                 <div class="input-group col-md-2" >
                                                     <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                                         <i class="fa fa-trash-o"></i> Hapus
                                                     </a>      
                                                 </div>
                                             </div>
                                         <?php } ?>
                                    </div>
                                </div>
                            </div>                          
                        </div>                                      
                    </div>
                    <?php } ?>
                </div>
        </div>
        <?php } ?>
        
    </div>
    
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">
    
    <div class="box-footer" style="text-align: center;"> 
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
         <a class="btn btn-danger" id="batal-modal-pengantar">Batal</a>
       
    </div>



<?php ActiveForm::end(); ?>
<div  id='clone_div' class="hide">
    <div class="col-md-12" style="border-color: #f39c12; padding:5px;overflow: hidden;">
        <div class="col-md-12" style="background-color:whitesmoke; margin-right:10px">
            <div class="form-group">
                <div class="col-md-12 " style="padding-right:0px">
                    <div class="form-group field-mspedoman-uu">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label class="control-label col-md-2" >Undang Undang</label>
                                <div class="input-group col-md-8" >
                                    <input type="text" readOnly placeholder="Undang-Undang" class="form-control undang-undang" value="" name="MsUndang[undang][]">
                                    <div class="input-group-btn">
                                        <a class="btn btn-warning pilih-undang" href="/pidum/ms-pedoman/create" data-toggle="modal" data-target="#_undang">Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="control-label col-md-2" >Pasal</label>
                                <div class="input-group col-md-8" >
                                    <input type="text" readOnly placeholder="Pasal Undang-Undang" class="form-control pasal-undang-undang" value="" attr-id='' name="MsUndang[pasal][]">
                                    <div class="input-group-btn">
                                        <a class="btn btn-warning pilih-pasal" href="javascript:void(0)">Pilih</a>
                                    </div>
                                </div>
                            </div>
                            <label class="control-label col-md-2" >Dakwaan</label>
                            <div class="form-group">
                                <div class="input-group col-md-4">
                                    <select name="MsUndang[dakwaan][]" class="form-control select-dakwaan" >
                                        <option value="0">-- Pilih --</option>
                                        <option value="1">-- Juncto --</option>
                                        <option value="2">-- Dan --</option>
                                        <option value="3">-- Atau --</option>
                                        <option value="4">-- Subsider --</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="input-group col-md-2" >
                                <a class="btn btn-app btn-warning delete-undang-undang" style="background-color:orange;color:white">
                                    <i class="fa fa-trash-o"></i> Hapus
                                </a>                   
                                <div class="input-group col-md-2" >
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

<?php
$tgl_spdp = date('d-m-Y',strtotime($modelSpdp->tgl_surat));
//echo $tgl_spdp;
$script = <<< JS
//  var tglBerkas = $('#pdmberkastahap1-tgl_berkas-disp').val();
//  var noBerkas  = $('#pdmberkastahap1-no_berkas').val();
//  $('#tgl_berkas_popup').val(tglBerkas);
//  $('#no_berkas_popup').val(noBerkas);

$(document).ready(function(){
	
	
 






	
	
	
    var today = new Date();
    var year = today.getFullYear();
    $('#pdmspdp-tgl_kejadian_perkara').combodate({
            firstItem: 'name',
            minYear: year-15,
            maxYear: year,
            minuteStep: 1,
            smartDays:true
    });
  var tgl_kejadian_perkara_db         = '$modelSpdp->tgl_kejadian_perkara';
  var split_tgl_kejadian_perkara_db   =  tgl_kejadian_perkara_db.split('-');
  var hour      = split_tgl_kejadian_perkara_db[0];     
  var minute    = split_tgl_kejadian_perkara_db[1];
  var day       = split_tgl_kejadian_perkara_db[2];
  var month     = split_tgl_kejadian_perkara_db[3];
  var year      = split_tgl_kejadian_perkara_db[4];
   if(minute =='00')
  {
    $('.minute option:eq(0)').prop('selected',true);
  }
  if(hour =='00')
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


$('.combodate .hour').before('<span>Jam </span>');
$('.combodate .day').before('<span>Tanggal </span>');
});

// $('.day,.month,.year').on('change',function(){

//         var endDate       = $('.year option:selected').text()+'-'+$('.month option:selected').text()+'-'+$('.day option:selected').text(); 
//         var IntDate       = '$tgl_spdp';
//         var ResultDate    = IntDate[2]+'-'+IntDate[1]+'-'+IntDate[0];
//         var ResultEndDate = endDate;
//         var someDate = new Date(ResultDate);
//         someDate.setDate(someDate.getDate() );
//         var dateFormated        = someDate.toISOString().substr(0,10);
//         var compareStartDate    = new Date(dateFormated );
//         var compareEndDate      = new Date(ResultEndDate);
//         if($('.month option:selected').text()=='-'){
//           $('.day option:eq(0)').prop('selected','true');
//         }
//         if($('.year option:selected').text()=='-'){
//           $('.day option:eq(0)').prop('selected','true');
//           $('.month option:eq(0)').prop('selected','true');
//         }
//         alert(compareEndDate+' > '+compareStartDate);
//         if(compareEndDate>compareStartDate)
//         {
//            if (IntDate[0].charAt(0) === '0'){ IntDate[0] = IntDate[0].replace("0", "")};
//            if (IntDate[1].charAt(0) === '0'){ IntDate[1] = IntDate[1].replace("0", "")};
//             //$('.day   option[value=\"'+IntDate[0]+'\"]').prop('selected','true');
//             //$('.month option[value=\"'+(IntDate[1]-1)+'\"]').prop('selected','true');
//             bootbox.dialog({
//                 message: "<center>Tanggal Kejadian Perkara Harus Lebih Kecil dari Tanggal Spdp </center>",
//                 buttons:{
//                             Ok : {
//                                 label: "Ya",
//                                 className: "btn-danger",
//                                 callback: function(){
//                                   $('.day   option[value=\"'+IntDate[0]+'\"]').prop('selected','true');
//                                   $('.month option[value=\"'+(IntDate[1]-1)+'\"]').prop('selected','true');
//                                 }
//                             }
//                         }
//                     });
            
//         }
//      });

    function show_tersangka()
    {

        if($('#table_tersangka #tbody_tersangka tr').length==0)
            {
              localStorage.no_urut_tersangka = 1;
            }
            else
            {
              var count_tersangka =  [];
  
              $('#table_tersangka #tbody_tersangka a').each(function(i,x){
                var split = this.text.split('.');
               count_tersangka.push(parseInt(split[0]));
             });
             console.log(count_tersangka);
             var a = Math.max.apply(null,count_tersangka);
             console.log($(this).parent().prop("tagName"));
             localStorage.no_urut_tersangka = a+1;
            
            }
        var href = $(this).attr('href');
                if(href != null){
                    var id_tersangka = href.substring(1, href.length);
                }else{
                    var id_tersangka = '';
                }
            localStorage.nama_tersangka       = '';
            localStorage.tgl_lahir_tersangka  = '';
            localStorage.tmpt_lahir_tersangka = '';
            localStorage.umur_tersangka       = '';
            localStorage.jk_tersangka         = '';
            localStorage.alamat_tersangka     = '';
            localStorage.id_tersangka         = '';
            localStorage.no_id_tersangka      = '';
            localStorage.no_hp_tersangka      = '';
            localStorage.agama_tersangka      = '';
            localStorage.id_wn_tersangka      = '';
            localStorage.nm_wn_tersangka      = '';
            localStorage.kerja_tersangka      = '';
            localStorage.suku_tersangka       = '';
            localStorage.pendidikan_tersangka = '';
            localStorage.tr_tersangka         = '';
            localStorage.foto_tersangka       = '';
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidum/pdm-berkas-tahap1/show-tersangka?id_tersangka='+id_tersangka);
            $('#m_tersangka').modal('show');
    }
$('#popUpTersangka').click(function(){
        show_tersangka();
	});
	
	$('.edit_tersangka').click(function(){


        var ids = $(this).attr('href').split('#');
        var id  = ids[1];
        localStorage.nama_tersangka       =  $("#table_tersangka tbody#tbody_tersangka  tr[id='tr_id"+id+"']  td:eq(1) input:eq(0)").val();
        localStorage.unix_tersangka       =  $("#table_tersangka tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(2)").val();
        
         localStorage.tmpt_lahir_tersangka =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(3)").val();
         localStorage.tgl_lahir_tersangka  =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(4)").val();
        localStorage.umur_tersangka       =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(5)").val();
        localStorage.jk_tersangka         =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(6)").val();
        localStorage.alamat_tersangka     =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(7)").val();
        localStorage.id_tersangka         =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(8)").val();
        localStorage.no_id_tersangka      =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(9)").val();
        localStorage.no_hp_tersangka      =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(10)").val();
        localStorage.agama_tersangka      =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(11)").val();
        localStorage.id_wn_tersangka      =  $("#table_tersangka tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(12)").val();
        localStorage.nm_wn_tersangka      =  $("#table_tersangka tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(12)").attr('attr-id');
        localStorage.kerja_tersangka      =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(13)").val();
        localStorage.suku_tersangka       =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(14)").val();
        localStorage.pendidikan_tersangka =  $("tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(15)").val();
        // localStorage.tr_tersangka         = id;
         localStorage.no_urut              =  $("#table_tersangka tbody#tbody_tersangka  tr[id='tr_id"+id+"']  input:eq(17)").val();
    

        var href = $(this).attr('href');
                if(href != null){
                    var id_tersangka = href.substring(1, href.length);
                }else{
                    var id_tersangka = '';
                }
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidum/pdm-berkas-tahap1/show-tersangka?id_tersangka='+id_tersangka);
            $('#m_tersangka').modal('show');
	});
	
	 $(".hapus").click(function()
        {
             $.each($('.hapusTersangka'),function(x)
                {

                    var input = $(this);
                    if(input.prop('checked')==true)
                    {   
                      var id  = input.parent().parent();
                      var lcl = 'hapusTersangka'+localStorage.data_db;
                      id.remove();
                       $('#trHpsTersangka').append(
                        '<input type="hidden" class="'+lcl+'" name="hapusTersangka[]" value='+input.val()+'>'
                        );
                    }
                }
             )
        });
	var mydate       = new Date();
    var unix         = mydate.getYear()+''+mydate.getUTCHours()+''+mydate.getUTCMinutes()+''+mydate.getUTCSeconds();
    var currentValue = unix;
    localStorage.generate_id_pengantar = currentValue; 

    
        $('#tambah-pasal').click(function(){
            if($('#jenis-pasal').val() == 'tunggal'){
                $('#tunggal').show();
            }

            if($('#jenis-pasal').val() == 'berlapis'){
                $('#tunggal').hide();
                $('#berlapis').show();
            }

        });

		var i =1;
        $('#tambah-undang-pasal').click(function(){
			
                $('.undang-pasal-append').append(
					'<div class="hapus_pasal_awal'+i+'">'+
                    	'<div class="form-group">'+
                        	'<div class="col-sm-3">'+
                            	'<label>Undang-undang</label>'+
                        	'</div>'+
                        	'<div class="col-sm-8">'+
								'<div class="col-sm-8">'+
        	                    	'<input type="text" name="undang[]" class="form-control typeahead" placeholder="undang - undang">'+
								'</div>'+
								'<div class="col-sm-3">'+
									'<a class="btn btn-danger delete" onclick=hapusPasalAwal("'+i+'")></a>'+
								'</div>'+
                        	'</div>'+
                    	'</div>'+
                    	'<div class="form-group">'+
                        	'<div class="col-sm-3">'+
                            	'<label>Pasal</label>'+
                        	'</div>'+
							'<div class="col-sm-8">'+
								'<div class="col-sm-8">'+
        	                    	'<input type="text" name="pasal[]" class="form-control" placeholder="pasal - pasal">'+
								'</div>'+	
							'</div>'+
                        '</div>'+    
                    '</div>'
                    
					
                );
                $('.typeahead').typeahead('destroy');
                $('.typeahead').typeahead(null, {
                    name: 'undang',
                    displayKey: 'value',
                    source: undangPasal,
                });
				i++;
            });
	
	function edit_pengantar(id)
    {
        localStorage.clear();
        var id = id;
        var data_db                       = $("tbody#tbody_pengantar tr[id='tr_id"+id+"']").attr('data-db');
        var tglpengantar_db                       = $("tbody#tbody_pengantar tr[id='tr_id"+id+"']").attr('data-tglpengantar');
        console.log(data_db);
        console.log(tglpengantar_db);
		
        
        $("tbody#tbody_pengantar tr[id='tr_id"+id+"'] td:eq(1) input:eq(0)")

        localStorage.no_pengantar         = $("tbody#tbody_pengantar tr[id='tr_id"+id+"'] td:eq(1) input:eq(0)").val();
		    localStorage.tgl_pengantar 		    = $("tbody#tbody_pengantar tr[id='tr_id"+id+"'] td:eq(1) input:eq(1)").val();
        localStorage.tgl_terima		        = $("tbody#tbody_pengantar tr[id='tr_id"+id+"'] td:eq(2) input:eq(0)").val();
        localStorage.tr_pengantar         = id;
        if(typeof(data_db)!='undefined')
        {
          localStorage.data_db              = data_db;
        }
        isi_table    = null;

       // $('body').append(localStorage.content_undang);
        $("tbody#tbody_pengantar tr[id='tr_id"+id+"'] td:eq(3)").find('li').each(function(x){
          
           currentValue =  $(this).attr('id');

           nama         =  $(this).find('input:eq(17)').val()+'. '+$(this).find('input:eq(0)').val();
           html         =  $(this).find('div.hide').html();

   
            isi_table += '<tr id="tr_id'+currentValue+'">'+                
                '<td width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
                '<td>' +
                    '<a href="javascript:void(0);" onclick="edit_tersangka('+"'"+currentValue+"'"+')">'+nama+'</a>'+
                    html+
                    '</td>'+
                '<td>' +
                   $(this).find('input:eq(3)').val()  +', '+ $(this).find('input:eq(4)').val() +
                '</td>' +
                '<td>' +
                   $(this).find('input:eq(5)').val() +' Tahun'+
                '</td>' +
            '</tr>';
        });
        localStorage.table_tersangka = isi_table.replace('null','');
        //localStorage.content_undang = undang_html ;
		var href = $(this).attr('href');
		if(href != null){
			var id_pengantar = id.replace('_','|').replace('___','-');
		}else{
			var id_pengantar = '';
		}
  
 
		$('#pengantar').html('');
		$('#pengantar').load('/pidum/pdm-berkas-tahap1/show-pengantar?id_pengantar='+id_pengantar);
		$('#pengantar').modal('show');
		
		
    }
	
	if(typeof(localStorage.no_pengantar) != 'undefined')
    {  
        $('#simpan-pengantar').text('Ubah');
        $('#pdmpengantartahap1-no_pengantar').val(localStorage.no_pengantar);
        $('#pdmpengantartahap1-tgl_pengantar').val('2016-11-18');
		$('#pdmpengantartahap1-tgl_terima').val('2016-11-18');
        $('#tbody_tersangka').html(localStorage.table_tersangka);
        var result_undang = $("tbody#tbody_pengantar tr[id='tr_id"+localStorage.tr_pengantar+"'] td:eq(3)").find('.body-undang-undang').clone();
          $('.box-primary .body-undang-undang').remove();
        $('#pengantar').find('.box-primary:eq(3)').append(result_undang);
        if(localStorage.tgl_pengantar !='')
        {
          $('#pdmpengantartahap1-tgl_pengantar-disp').val(localStorage.tgl_pengantar);  
        }
		if(localStorage.tgl_terima !='')
        {
          $('#pdmpengantartahap1-tgl_terima-disp').val(localStorage.tgl_terima);  
        }	
        
    }
	
	
	$('#pdmpengantartahap1-tgl_pengantar-disp').blur(function(){
		$('#pdmpengantartahap1-tgl_pengantar').val(localStorage.tgl_pengantar.substring(6,10)+'-'+localStorage.tgl_pengantar.substring(3,5)+'-'+localStorage.tgl_pengantar.substring(0,2));
		$('#pdmpengantartahap1-tgl_pengantar-disp').val(localStorage.tgl_pengantar);
	});
	
	$('#pdmpengantartahap1-tgl_terima-disp').blur(function(){
		$('#pdmpengantartahap1-tgl_terima').val(localStorage.tgl_terima.substring(6,10)+'-'+localStorage.tgl_terima.substring(3,5)+'-'+localStorage.tgl_terima.substring(0,2));
		$('#pdmpengantartahap1-tgl_terima-disp').val(localStorage.tgl_terima);
	});
	
	$('#simpan-pengantar').click(function(){
        prosesSimpanPengantar('0');
    });

    $('#ubah-pengantar').click(function(){
		prosesSimpanPengantar('1');
    });
			
	function prosesSimpanPengantar(flag){
            // if(typeof(localStorage.data_flag_new_save)!='undefined')
            // {
            //   flag = localStorage.data_flag_new_save;
            // }                
            var noPengantar = $('#pdmpengantartahap1-no_pengantar').val().trim();
            var liUndang = null;
                var count_uu =0;
                $('.box-primary  input.undang-undang').each(function(x){
                   liUndang += '<li>'+$(this).val()+'</li>';
                   if($(this).val()=='')
                   {
                    count_uu +=1;
                   }
                });
                 var count_psl =0;
                $('.box-primary  input.pasal-undang-undang').each(function(x){                   
                   if($(this).val()=='')
                   {
                    count_psl +=1;
                   }
                });
            if(noPengantar !=''&&$('tbody#tbody_tersangka tr').length!=0&&count_uu==0&&count_psl==0)    
            {
              if(typeof(localStorage.data_db)!='undefined')
                 {
                     $('#pengantar tbody#tbody_tersangka').find('input').each(function(x){
                            var name = $(this).attr('name');
                            name = name.replace('MsTersangkaDb','MsTersangkaBaru['+localStorage.data_db+']');
                            $(this).attr('name',name);
                         });
                      $('#pengantar .body-undang-undang').find('input').each(function(x){
                            var name1 = $(this).attr('name');
                            name1 = name1.replace('MsUndangDb','MsUndang['+localStorage.data_db+']');
                            $(this).attr('name',name1);
                         });
                      $('#pengantar .body-undang-undang').find('select').each(function(x){
                            var name2 = $(this).attr('name');
                            name2 = name2.replace('MsUndangDb','MsUndang['+localStorage.data_db+']');
                            $(this).attr('name',name2);
                         });
                        // console.log(name+'----->'+name1+'----->'+name2);
                        var li = null;
                        $('tbody#tbody_tersangka tr').each(function(x){
                            $(this).find('a').remove();
                            li += '<li id="'+$(this).attr('id').replace('tr_id','')+'">'+$(this).find('td:eq(1) input:eq(0)').val()+'<div class="hide">'+$(this).find('td:eq(1)').html()+'</div></li>';
                        });  
                        var olUndang =  '<ol>'+liUndang.replace('null','')+'</ol>';
                        var ol      =  '<ol>'+li.replace('null','')+'</ol>';
                        isiTabel =  '<tr data-db="'+localStorage.data_db+'"ondblclick="edit_pengantar(\''+localStorage.data_db+'\')" id="tr_id'+localStorage.data_db+'">' +
                        '<td><a href="javascript:void(0);" onclick="edit_pengantar(\''+localStorage.data_db+'\')">'+noPengantar+'</a> </td>'+
                                    '<td><input type="hidden" name="PengantarUpdate[no_pengantar][]" value="'+$('#pdmpengantartahap1-no_pengantar').val()+'" class="form-control pengantar'+localStorage.data_db+'"><input type="text" style="border:none; background-color:transparent;" name="PengantarUpdate[tgl_pengantar][]" readonly="true" value="'+$('#pdmpengantartahap1-tgl_pengantar-disp').val()+'" class="form-control pengantar'+localStorage.data_db+'"></td>'+
                                    '<td><input type="text" style="border:none; background-color:transparent;" name="PengantarUpdate[tgl_terima][]" readonly="true" value="'+$('#pdmpengantartahap1-tgl_terima-disp').val()+'" class="form-control pengantar'+ localStorage.data_db +'"> </td>'+
                                    '<td>'+ol+'<div id="saveUndang'+localStorage.data_db+'" class="hide"></div></td>'+
                        '<td>'+olUndang+'</td>'+
                                    '<td style="text-align:center;" id="tdPengantar"><input type="checkbox" name="noPengantar[]" class="hapusPengantar" id="hapusPengantar"  value="'+localStorage.data_db+'"></td>'+                                               
                                    '<td hidden><input type="hidden" style="border:none; background-color:transparent;" name="PengantarUpdate[tmpt_kejadian]" value="'+$('#tempat_kejadian').val()+'" class="form-control pengantar'+ localStorage.data_db +'"><input type="hidden" style="border:none; background-color:transparent;" name="PengantarUpdate[waktu_kejadian]" value="'+$('#pdmspdp-tgl_kejadian_perkara').val()+'" class="form-control pengantar'+ localStorage.data_db +'"></td>'+
                                    '<input type="hidden" style="border:none; background-color:transparent;" name="PengantarUpdate[generate_id][]" value="'+localStorage.data_db+'" class="form-control pengantar'+ localStorage.data_db +'">'+
                      '</tr>'
                  }
                  else
                  {
                     $('#pengantar tbody#tbody_tersangka').find('input').each(function(x){   
                            var name2 = $(this).attr('name');
                            count =  name2.split("[").length-1;
                            if(count==2)
                            {
                              name2 = name2.replace('MsTersangkaBaru','MsTersangkaBaru['+localStorage.generate_id_pengantar+']');
                              $(this).attr('name',name2);
                            }
                            else
                            {
                              name2 = name2.split("]");
                              var name3 = name2[1]+']'+name2[2]+']';
                              name2 = name2[0]+']';
                              
                              name2 = name2.replace(name2,'MsTersangkaBaru['+localStorage.generate_id_pengantar+']'+name3);
                              $(this).attr('name',name2);
                            }
                         });

                         $('#pengantar .body-undang-undang').find('input').each(function(x){   
                            var name2 = $(this).attr('name');
                            count =  name2.split("[").length-1;
                            if(count==2)
                            {
                              name2 = name2.replace('MsUndang','MsUndang['+localStorage.generate_id_pengantar+']');
                              $(this).attr('name',name2);
                            }
                            else
                            {
                              name2 = name2.split("]");
                              var name3 = name2[1]+']'+name2[2]+']';
                              name2 = name2[0]+']';
                              
                              name2 = name2.replace(name2,'MsUndang['+localStorage.generate_id_pengantar+']'+name3);
                              $(this).attr('name',name2);
                            }
                         });
                          $('#pengantar .body-undang-undang').find('select').each(function(x){
                                var name2 = $(this).attr('name');
                                count =  name2.split("[").length-1;
                                if(count==2)
                                {
                                  name2 = name2.replace('MsUndang','MsUndang['+localStorage.generate_id_pengantar+']');
                                  $(this).attr('name',name2);
                                }
                                else
                                {
                                  name2 = name2.split("]");
                                  var name3 = name2[1]+']'+name2[2]+']';
                                  name2 = name2[0]+']';
                                  
                                  name2 = name2.replace(name2,'MsUndang['+localStorage.generate_id_pengantar+']'+name3);
                                  $(this).attr('name',name2); 
                                }  
                             });

                         var li = null;
                          $('tbody#tbody_tersangka tr').each(function(x){
                              $(this).find('a').remove();
                              li += '<li id="'+$(this).attr('id').replace('tr_id','')+'">'+$(this).find('td:eq(1) input:eq(0)').val()+'<div class="hide">'+$(this).find('td:eq(1)').html()+'</div></li>';
                          });  
                          var olUndang =  '<ol>'+liUndang.replace('null','')+'</ol>';
                          var ol      =  '<ol>'+li.replace('null','')+'</ol>';
                          isiTabel =  '<tr ondblclick="edit_pengantar('+localStorage.generate_id_pengantar+')" id="tr_id'+localStorage.generate_id_pengantar+'">' +
                          '<td><a href="javascript:void(0);" onclick="edit_pengantar('+localStorage.generate_id_pengantar+')">'+noPengantar+'</a> </td>'+
                                      '<td><input type="hidden" name="PengantarBaru[no_pengantar][]" value="'+$('#pdmpengantartahap1-no_pengantar').val()+'" class="form-control pengantar'+localStorage.generate_id_pengantar+'"><input type="text" style="border:none; background-color:transparent;" name="PengantarBaru[tgl_pengantar][]" readonly="true" value="'+$('#pdmpengantartahap1-tgl_pengantar-disp').val()+'" class="form-control pengantar'+localStorage.generate_id_pengantar+'"></td>'+
                                      '<td><input type="text" style="border:none; background-color:transparent;" name="PengantarBaru[tgl_terima][]" readonly="true" value="'+$('#pdmpengantartahap1-tgl_terima-disp').val()+'" class="form-control pengantar'+ localStorage.generate_id_pengantar +'"> </td>'+
                                      '<td>'+ol+'<div id="saveUndang'+localStorage.generate_id_pengantar+'" class="hide"></div></td>'+
                          '<td>'+olUndang+'</td>'+
                                      '<td style="text-align:center;" id="tdPengantar"><input type="checkbox" name="noPengantar[]" class="hapusPengantar" id="hapusPengantar"  value="'+localStorage.generate_id_pengantar+'"></td>'+                                               
                                      '<td hidden><input type="hidden" style="border:none; background-color:transparent;" name="PengantarBaru[tmpt_kejadian]" value="'+$('#tempat_kejadian').val()+'" class="form-control pengantar'+ localStorage.generate_id_pengantar +'"><input type="hidden" style="border:none; background-color:transparent;" name="PengantarBaru[waktu_kejadian]" value="'+$('#pdmspdp-tgl_kejadian_perkara').val()+'" class="form-control pengantar'+ localStorage.generate_id_pengantar +'"></td>'+
                                      '<input type="hidden" style="border:none; background-color:transparent;" name="PengantarBaru[generate_id][]" value="'+localStorage.generate_id_pengantar+'" class="form-control pengantar'+ localStorage.generate_id_pengantar +'">'+
                        '</tr>'
                  }

                     
        			if(flag=='0'){
                      //$('#simpan-pengantar').on('click',function(){
                          var num = localStorage.tr_pengantar;
                          removeAfterEdit(num);
                        //  });
                          if(typeof(localStorage.data_db)!='undefined')
                          {
                            var name = 'removePengantar[id_pengantar][]';
                            var length = $('#table_pengantar input[type=hidden][name="removePengantar[id_pengantar][]"][value="'+localStorage.data_db+'"]').length;
                              if(length==0)
                                {
                                      var update_pengantar_db = '<input type="hidden" name="removePengantar[id_pengantar][]" value="'+localStorage.data_db.replace('_','|').replace('___','-')+'">';  

                                        $('#table_pengantar').append(update_pengantar_db);
                                }
                            
                          }
                          function removeAfterEdit(id)
                          {
                              if(id!='')
                              {

                               $("tbody#tbody_pengantar tr[id='tr_id"+id+"']").remove();
                               //localStorage.clear();
                              }
                          }

                     $('#tbody_pengantar').append(isiTabel);
                     if(typeof(localStorage.data_db)!='undefined')
                      {
                        
                        $('#pengantar .body-undang-undang').find('input').each(function(x){   
                            var name2 = $(this).attr('name');
                            count =  name2.split("[").length-1;
                            if(count==2)
                            {
                              name2 = name2.replace('MsUndang','MsUndang['+localStorage.data_db+']');
                              $(this).attr('name',name2);
                            }
                            else
                            {
                              name2 = name2.split("]");
                              var name3 = name2[1]+']'+name2[2]+']';
                              name2 = name2[0]+']';
                              
                              name2 = name2.replace(name2,'MsUndang['+localStorage.data_db+']'+name3);
                              $(this).attr('name',name2);
                            }
                         });
                          $('#pengantar .body-undang-undang').find('select').each(function(x){
                                var name2 = $(this).attr('name');
                                count =  name2.split("[").length-1;
                                if(count==2)
                                {
                                  name2 = name2.replace('MsUndang','MsUndang['+localStorage.data_db+']');
                                  $(this).attr('name',name2);
                                }
                                else
                                {
                                  name2 = name2.split("]");
                                  var name3 = name2[1]+']'+name2[2]+']';
                                  name2 = name2[0]+']';
                                  
                                  name2 = name2.replace(name2,'MsUndang['+localStorage.data_db+']'+name3);
                                  $(this).attr('name',name2); 
                                }  
                             });

                        
                        $('.box-primary  .body-undang-undang').clone().appendTo("#tbody_pengantar div[id='saveUndang"+localStorage.data_db+"']"); 
                      }
                      else
                      {
                         $('.box-primary  .body-undang-undang').clone().appendTo("#tbody_pengantar div[id='saveUndang"+localStorage.generate_id_pengantar+"']"); 
                      }
        			}else{
        			 $('#tbody_pengantar').append(isiTabel);
                     $('.box-primary .body-undang-undang').clone().appendTo("#tbody_pengantar  div#saveUndang"+localStorage.generate_id_pengantar);   
        			}
        		$("body").css('overflow-y','scroll');
                localStorage.clear();
                $('#pengantar').modal('hide');
    		}
    		else
            {
                
               if(noPengantar!='')
               {
                    bootbox.dialog({
                    message: "Data yang anda masukan belum lengkap",
                    buttons:{
                        ya : {
                            label: "OK",
                            className: "btn-warning",
                            callback: function(){
                                if($('tbody#tbody_tersangka tr').length==0)
                                {
                                   show_tersangka();
                                   $('#m_tersangka').css('overflow-y','scroll');
                                }
                            }
                        }
                        }
                    });
               }
               else
               {
                 bootbox.dialog({
                    message: "Data yang anda masukan belum lengkap",
                    buttons:{
                        ya : {
                            label: "OK",
                            className: "btn-warning",
                            callback: function(){
                                if($('tbody#tbody_tersangka tr').length==0)
                                {
                                    $('#pdmpengantartahap1-no_pengantar').focus();
                                    // $('.field-pdmpengantartahap1-no_pengantar').addClass('has-error');
                                    //$('.field-pdmpengantartahap1-no_pengantar').find('.help-block').text('Nomor Pengantar Harus Terisi');
                                     $("#pengantar").css('overflow-y','scroll');
                                }
                            }
                        }
                        }
                    });
               }
            }  
			
		}
    $('#batal-modal-pengantar').on('click',function(){
        $("body").css('overflow-y','scroll');
        $("a [class='hapusTersangka"+localStorage.data_db+"']").remove();
        localStorage.clear();
        $('#pengantar').modal('hide');
    });







$('body').on('click','.pilih-pasal',function(e){
   var index = $(this).index('.pilih-pasal');
   localStorage.indexPasal = index;
   var value = $('.undang-undang:eq('+index+')').attr('attr-id');
   console.log(value);
   if(value=='')
   {
         bootbox.dialog({
                message: "Silahkan Pilih Undang-Undang Dahulu",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
   }
   else
   {
    console.log(value);
        $('#m_pasal').html('');
        $('#m_pasal').load('/pidum/pdm-tahap-dua/show-pasal?uu='+encodeURI(value));
        $('#m_pasal').modal('show');
   }
});

$('body').on('click','a.pilih-undang',function(){
   var index = $(this).index('.pilih-undang');

   localStorage.indexUndang = index;
});

$('#_undang div div div button.close').hide();


function pilihPasal(pasal)
{
    $('input.pasal-undang-undang:eq('+localStorage.indexPasal+')').val(pasal);
    $('#m_pasal').modal('hide');
}


$('body').off('change').on('change','#pengantar .body-undang-undang .select-dakwaan',function(e){
  var add_clone  =  $('#pengantar .body-undang-undang .select-dakwaan option[value=0]:selected').length;
  var add_clone2 =   $('#clone_div .select-dakwaan option[value=0]:selected').length;
  var index     =  $(this).index('.select-dakwaan');
  var value     =  $(this).val();

  var valueUU   =  $('#pengantar  .body-undang-undang input.undang-undang:eq('+index+')').val();
  var valuePsl  =  $('#pengantar  .body-undang-undang input.pasal-undang-undang:eq('+index+')').val();
   //alert(index);

                var count_uu2 =0;
                $('#pengantar .box-primary  input.undang-undang').each(function(x){
                   if($(this).val()=='')
                   {
                    count_uu2 +=1;
                   }
                });

                 var count_uu3 =0;
                $('#pengantar .box-primary  input.pasal-undang-undang').each(function(x){
                 if($(this).val()=='')
                 {
                  count_uu3 +=1;
                 }
              });

  if( (add_clone+add_clone2) == 1)
  {

    console.log(valueUU);
    console.log(valuePsl);
    if(valueUU==''||valuePsl=='')
    {
        bootbox.dialog({
                message: "<center>Silahkan Isi Undang-Undang dan Pasal Dahulu</center>",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",
                        callback: function(){
                        $('.body-undang-undang .select-dakwaan:eq('+index+') option[value='+0+']').prop("selected","true"); 
                        $("#pengantar").css('overflow-y','scroll');
                        }

                    }
                }
            });
    }
    else
    {
         if(count_uu2==0&&count_uu3==0)
           {
             $('.select-dakwaan:eq('+index+') option[value='+value+']').attr("selected","selected");
                var a =  $('#clone_div').clone().html();
                $('#pengantar .body-undang-undang').append(a);
           }
           else
           {
             bootbox.dialog({
                    message: "<center>Silahkan Isi Undang-Undang dan Pasal Dahulu</center>",
                    buttons:{
                        ya : {
                            label: "OK",
                            className: "btn-warning",
                            callback: function(){
                            $('.body-undang-undang .select-dakwaan:eq('+index+') option[value='+0+']').prop("selected","true"); 
                            $("#pengantar").css('overflow-y','scroll');
                            }

                        }
                    }
                });
           } 
    }
   
  }
   

  if(index !=0)
  {
    if($(this).val()==0)
    {
        $(this).parent().parent().parent().parent().parent().parent().next().remove();
    }
  }

  $('.select-dakwaan:eq('+index+') option').removeAttr("selected");
  $('.select-dakwaan:eq('+index+') option[value='+value+']').attr("selected","selected");
  $('.select-dakwaan:eq('+index+') option[value='+value+']').prop("selected","true");
});



$('select[name=kode_pidana]').on('change',function(){
        var kode_pidana=$('select[name=kode_pidana]').val();
        $.ajax({
            type: "POST",
            url: '/pidum/pdm-tahap-dua/refer-undang',
            data: 'kode_pidana='+kode_pidana,
            success:function(data){
                console.log(data);
                $('#_undang .modal-body').html(data).show();
            }
        });
    });

$('body').on('click','a.pilih-undang',function(){
   var index = $(this).index('.pilih-undang');
   localStorage.indexUndang = index;
   console.log(index);
});
$('body').on('click','.pilih-pasal',function(e){
   var index = $(this).index('.pilih-pasal');
   localStorage.indexPasal = index;
   var value = $('.undang-undang:eq('+index+')').attr('attr-id');
   console.log(value);
   if(value=='')
   {
         bootbox.dialog({
                message: "Silahkan Pilih Undang-Undang Dahulu",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
   }
   else
   {
    console.log(value);
        $('#m_pasal').html('');
        $('#m_pasal').load('/pidum/pdm-berkas-tahap1/show-pasal?uu='+encodeURI(value));
        $('#m_pasal').modal('show');
   }
});


$('#pengantar').off('click').on('click','.delete-undang-undang',function(e){
    var index  = $(this).index('.delete-undang-undang');
    var parent = $(this).prev().html();
    var value  = $(parent).find('input[type=hidden]').val();

   if(typeof(localStorage.data_db)!='undefined')
   {
   
         if(typeof(value)!='undefined')
         {
          var lcl = 'hapusTersangka'+localStorage.data_db;
            $('#trHpsTersangka').append(
              '<input class="'+lcl+'" type="hidden" name="hapusUndang[]" value='+value+'>'
              );
         }
        $(this).parent().parent().parent().parent().remove();
   }
   else
  {
     if(index !=0)
    {
         if(typeof(value)!='undefined')
       {
        var lcl = 'hapusTersangka'+localStorage.data_db;
          $('#trHpsTersangka').append(
            '<input class="'+lcl+'" type="hidden" name="hapusUndang[]" value='+value+'>'
            );
       }
        $(this).parent().parent().parent().parent().remove();
    }else{
        $(this).parent().parent().parent().parent().remove();
    }
  }
    
});  





JS;

$this->registerJs($script);
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Tambah Tersangka</h7>'
]);
Modal::end();

Modal::begin([
    'id'     => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Kewarganegaraan<button type="button" id="contoh">klik</button></h7>'

]);
Modal::end();
?>

<?php
Modal::begin([
    'id'            => '_undang',
    'header'        => 'Data Undang-Undang
                        <div class="navbar-right" style="width: 180px; color: Black; ">
                        <h5>'.
                        Html::dropDownList('kode_pidana', null,
                        ArrayHelper::map(MsJenisPidana::find()->all(), 'kode_pidana', 'akronim'),
                        ['prompt'=>' -- Pilih Jenis Pidana --']        
                                ).'
                        </h5>
                        </div>',
    'options'       => [
        'data-url'  => '',
    ],
	'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
?> 

<?=
$this->render('//ms-pasal/_undang', [
    'model' => $model,
    'searchUU' => $searchUU,
    'dataUU' => $dataUU,
])
?>

<?php
Modal::end();
?>

<?php
Modal::begin([
    'id' => 'm_pasal',
    'header' => '<h7>Daftar Pasal</h7>',
    'options' => [
        'width' => '50%',
    ],
	'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();
?>  
<script>
	function hapusPasalAwal(key)
	{
		$('.hapus_pasal_awal'+key).remove();
	}
	
	function hapusPasal(key, id_pasal)
	{
		$('.hapus'+key).remove();
		$('.hapus_undang_pasal').append(
			'<input type="hidden" name="hapus_undang_pasal[]" value="'+id_pasal+'">'
		);
	}
</script>

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

<script>
    // $('select[name=kode_pidana]').on('change',function(){
    //     var kode_pidana=$('select[name=kode_pidana]').val();
    //     $.ajax({
    // 		type: "POST",
    // 		url: '/pidum/pdm-berkas-tahap1/refer-undang',
    // 		data: 'kode_pidana='+kode_pidana,
    // 		success:function(data){
    // 			console.log(data);
    //             $('#_undang .modal-body').html(data).show();
    // 		}
    // 	});
    // });
</script>