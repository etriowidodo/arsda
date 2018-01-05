<?php

use app\assets\AppAsset;
use app\modules\pidum\models\MsInstPenyidik;
use app\modules\pidum\models\MsInstPelakPenyidikan;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use app\modules\pidum\models\MsJenisPidana;
use app\modules\pidum\models\MsJenisPerkara;

AppAsset::register($this);
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PidumPdmSpdp */
/* @var $form yii\widgets\ActiveForm */

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

var create_1 = $(location).attr('href').split('/').pop();
if(create_1=='create')
{
    valDay(result1,result0,result2);
    $('.hour').removeAttr('disabled');
    $('.minute').removeAttr('disabled');
    $('.day').removeAttr('disabled');
    $('.month').removeAttr('disabled');
    $('.year').removeAttr('disabled');
}
  


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

    <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Instansi Penyidik</label>
                    <div class="col-md-8">
                        <?php
                        echo $form->field($model, 'id_asalsurat')->dropDownList(
                                ArrayHelper::map(MsInstPenyidik::find()->all(), 'kode_ip', 'nama'), // Flat array ('id'=>'label')
                                ['id' => 'InstansiPenyidik']    // options
                        );?>
                    </div> 
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Instansi Pelaksana Penyidikan</label>

                    <div class="col-md-6">
                        <?php
                        if($model->isNewRecord){
                            echo $form->field($model, 'id_penyidik')->dropDownList(
                                ['' => 'Pilih Instansi Penyidik Dahulu'], ['id' => 'InstansiPelaksanaPenyidik']
                            );
                        }else{
                            echo $form->field($model, 'id_penyidik')->dropDownList(
                                ArrayHelper::map(MsInstPelakPenyidikan::findAll(['kode_ipp'=>$model->id_penyidik]), 'kode_ipp', 'nama'), // Flat array ('id'=>'label')
                                ['id' => 'InstansiPelaksanaPenyidik']
                            );
                        }
                        ?>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor Sprindik</label>

                    <div class="col-md-8">
                        <?= $form->field($model, 'no_sprindik')->input('text',
                                ['oninput'  =>'
                    var number =  /^[A-Za-z0-9-/.:]+$/;
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
                                        '])  ?>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Tanggal Sprindik</label><!-- jaka | rubah spdp jadi huruf kapital -->
                    <div class="col-md-2" style="width:26%" >
                    <?php $tgl_sprindik = date('d-m-Y',strtotime($model->tgl_sprindik)) ;                           
                          $now       = $model->isNewRecord ? date('d-m-Y'):date('d-m-Y',strtotime($model->tgl_terima));
                          $tgl_surat = $model->isNewRecord ? date('d-m-Y',strtotime($now.'-1 month')):$tgl_surat;
                      ?>
                        <?=
                        $form->field($model, 'tgl_sprindik')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'DD-MM-YYYY',//JAKA : Rubah placeholder jadi format tanggal
                                    
                                ],
                                'pluginOptions' => [
                                    //'startDate' => $tgl_surat,
                                    //'endDate' => $now ,
                                    'autoclose' => true
                                ],
                            ]
                        ]);
                        ?>
                
                    </div>
                </div>
      
            </div>
        </div>  

        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Nomor SPDP</label>

                    <div class="col-md-8">
                        <?= $form->field($model, 'no_surat')->input('text',
                                ['oninput'  =>'
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
                                        '])  ?>
                    </div>

                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-5">Tanggal SPDP</label><!-- jaka | rubah spdp jadi huruf kapital -->
                    <div class="col-md-2" style="width:26%" >
                    <?php $tgl_surat = date('d-m-Y',strtotime($model->tgl_surat)) ;                           
                          $now       = $model->isNewRecord ? date('d-m-Y'):date('d-m-Y',strtotime($model->tgl_terima));
                          $tgl_surat = $model->isNewRecord ? date('d-m-Y',strtotime($now.'-1 month')):$tgl_surat;
                      ?>
                        <?=
                        $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'DD-MM-YYYY',//JAKA : Rubah placeholder jadi format tanggal
                                    
                                ],
                                'pluginOptions' => [
                                    'startDate' => $tgl_surat,
                                    'endDate' => $now ,
                                    'autoclose' => true
                                ],
                            ]
                        ]);
                        ?>
                
                    </div>
                </div>
			
            </div>
        </div>		
		
        <div class="col-md-12">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4" >Diterima Wilayah Kerja</label>

                    <div class="col-md-8">
						<!--CMS_PIDIUM001_2 bowo 25 mei 2016 #disableds-->
                        <input disabled="true" class="form-control" value="<?php echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                        <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
                    </div>

                </div>
            </div>
  
            <div class="col-md-6">
                <div class="form-group">
        			<label class="control-label col-md-5">Tanggal Diterima</label>
                    <div class="col-md-2" style="width:26%;" id="tgl_diterima">

                      <?php $tgl_terima   = date('d-m-Y',strtotime($model->tgl_terima)) ;
                            $tgl_terima   = $model->isNewRecord ? '-1m':$tgl_terima;
                      ?>
        			<?= 
                        $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
        					'id'=>'limit',
                            'ajaxConversion' => false,
                            'options' => [
                                'options' => [
                                    'placeholder' => 'DD-MM-YYYY',//JAKA : Rubah placeholder jadi format tanggal

                                ],
                                'pluginOptions'   => [
                                    'startDate'   => $tgl_surat,
        							              'endDate'     => $tgl_terima,
                                    'autoclose'   => true,
        							
                                ],
        						
        					]
        		
                        ]);
                        ?></div>
                </div>
            </div>

        </div>
        <!— jaka —>
        <div class="col-md-12">   
          <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4" style="padding-right:0px">Waktu Kejadian Perkara</label>
                    <?php
                       if(!$model->isNewRecord):
                        $date = explode('-', $model->tgl_kejadian_perkara); 
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
                    <div class="col-md-8"  style="margin-top:4px;padding-left: 9px;padding-right: 0;"><!--CMS_PIDUM004 | jaka | rubah lebar kolom-->
                      <input   type="text" id="pdmspdp-tgl_kejadian_perkara" data-format="HH-mm-DD-MM-YYYY" data-template="HH : mm DD - MM - YYYY "name="PdmSpdp[tgl_kejadian_perkara]" 
                      value="<?php echo trim($hour.'-'.$minute.'-'.$day.'-'.$month.'-'.$year); ?>">
                    </div>
                </div>
            </div>
             
  </div><!— END —>
    
    </div>
    <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6">
                <h3 class="box-title"> Tempat Kejadian Perkara</h3>
            </div>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'tempat_kejadian')->textarea() ?>
        </div>
    </div>
    <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6" style="padding: 0px;">
                <h3 class="box-title">
				<?php if($status_perkara =='SPDP' || $status_perkara ==''){ ?>
				<a class='btn btn-danger delete hapus'></a>
				&nbsp;
				<a class="btn btn-primary tambah_calon_tersangka tambah-tersangka">Tersangka</a>
				<?php }else{ ?>
				Tersangka
				<?php } ?>
				</h3>
            </div>

        </div>
        <div class="box-header with-border">
        <table id="table_tersangka" class="table table-bordered">

           <!-- CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
            <thead>
                <tr>
                    <th>Nama</th>
                    <th></th>
                </tr>
            </thead>

             -->

            <tbody id="tbody_tersangka">
                <div id="divHapus">

                </div>
                <?php
                // BEGIN CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
                if ($modelTersangkaUpdate != null) {
                    $i =0;
					if($status_perkara =='SPDP'){
						foreach ($modelTersangkaUpdate as $key => $value) {
              $id_tersangka = explode('|',  $value['id_tersangka']);
              $id_tersangka = $id_tersangka[1];
							echo "<tr id='tr_id".$id_tersangka."'>
                                 <td width='20px'><input type='checkbox' name='tersangka[]' class='hapusTersangka' id='hapusTersangka' value='".$value['id_tersangka']."'></td>
                                <td><a class='tambah_calon_tersangka' href='#".$id_tersangka."'>" .$value['no_urut'].". ". $value['nama'] . "</a></td>                               
                              </tr>";
						}
					}else{
						foreach ($modelTersangkaUpdate as $key => $value) {
              $id_tersangka = explode('|',$value['id_tersangka']);
              $id_tersangka = $id_tersangka[1];
							echo "<tr id='tr_id".$id_tersangka."'>
                                <td><a class='tambah_calon_tersangka' href='#".$id_tersangka."'>" .$value['no_urut'].". ". $value['nama'] . "</a></td>
                               
                              </tr>";
						}
						
					}
                    
                }
                // END CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
                ?>

            </tbody>
        </table>
        </div>
    </div>

    <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6">
                <h3 class="box-title"> Uraian Singkat Perkara</h3>
            </div>

        </div>
			<div class="box-body">
				<?= $form->field($model, 'ket_kasus')->textarea() ?>
			</div>
    </div>
    <!--<div class="form-group">
        <label class="control-label col-md-2">Diterima Wilayah Kerja</label>
        <div class="col-md-3">
            <?=
            $form->field($model, 'tgl_kejadian_perkara')->widget(DateControl::className(), [
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
    </div>-->
    <div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-6">
                <h3 class="box-title"> Undang-undang & Pasal</h3>
            </div>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'undang_pasal')->textarea() ?>
        </div>
    </div> 
<!--CMS_PIDUM_SPDP_79 #bowo #14072016 // label jenis perkara dan menambah checkbox PK-Ting-->
<div class="box box-primary" style="border-color: #f39c12;padding: 13px;overflow: hidden;">
    <div class="col-md-12">
        <div class="col-md-6" style="width:33%;"> 
            <div class="form-group">
                <label class="control-label col-md-4">Jenis Pidana</label>
        		<div class="col-md-8" style="width:63%;">
                    <?php
                    /*echo Html::dropDownList('cb_pdm_mst_perkara',$mst_perkara,
                            ArrayHelper::map(MsJenisPidana::find()->all(), 'kode_pidana', 'akronim'), // Flat array ('id'=>'label')
                            ['class'=>'form-control','id'=>'cb_pdm_mst_perkara']    // options
                    );*/
					echo $form->field($model, 'kode_pidana')->dropDownList(
                            ArrayHelper::map(MsJenisPidana::find()->all(), 'kode_pidana', 'akronim'),['id'=>'cb_pdm_mst_perkara']);
                    ?>
                </div>
            </div>
        </div>
        <div class="col-md-6" style="width:65%">
            <div class="form-group">
                <label class="control-label col-md-4" style="width:20%">Jenis Perkara</label>  
                <div class="col-md-8" style="width:60%;">
                    <?php
                        echo $form->field($model, 'id_pk_ting_ref')->dropDownList(
                            ArrayHelper::map(MsJenisPerkara::find()->all(), 'jenis_perkara', 'nama'));
                    ?>
                </div>
					<div class="col-md-8" style="width:20%;">
						<?php
							echo $form->field($model, 'pkting')->checkBox(['label' => 'PK-Ting', 'uncheck' => null, 'selected' => true]);
						?> 
					</div>
            </div>
        </div>
    </div>
	<div class="col-md-12" >
        <div class="col-md-6" >
            <div class="form-group form-inline">
                <!--<label class="control-label col-md-4" style="width:22%">Upload File</label>-->
        		
				<div class="col-md-2 inline" >
                <?php
                     
                       /* 
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
                                'browseLabel'=>'Perbaharui Berkas ...',
                            ]
                        ]);
                        
                     
                     } else{
                     */
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
                                'browseLabel'=>'Unggah SPDP...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pidum_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					 /*}else{
						$pathfile = Url::to('/template/pidum_surat/spdp/'. $model->file_upload);
						echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/pdf','id'=>'upload_file_spdp'],
                            'pluginOptions' => [
								'initialPreviewShowDelete' => true,
                                'showPreview' => true,
                                'showUpload' => false,
								'showClose' => false,
                                'showRemove' => false,
                                'allowedFileExtension' => ['pdf'],
                                'maxFileSize'=> 3027,
								'initialPreview' => [
                                        "<a href='" . $pathfile . "' target='_blank'><div class='file-preview-text' title='Download'><h2><i class='glyphicon glyphicon-file'></i></h2>File SPDP</div></a>"
                                ],
							
								'initialCaption' => 'File Upload SPDP',
								'overwriteInitial' => true
                            ]
                        ]);
					 }*/
                        ?>  
						
                </div>
                
            </div>
        </div>
    </div>
</div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    
    <div class="box-footer" style="text-align: center;"> 
	<?php if($status_perkara =='SPDP' && (!$model->isNewRecord)  ){ ?>
        <?= Html::SubmitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    <?php } ?>
	<?php if($model->isNewRecord){ ?>
        <?= Html::SubmitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
    <?php } ?>
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/spdp/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 -->
    </div>
        <div id="hiddenId"></div>
    <?php ActiveForm::end(); ?>
    </div>
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
			if('$model->id_penyidik' !=''){
				$('#InstansiPelaksanaPenyidik').val('$model->id_penyidik');
			}
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
			$('#pdmspdp-id_pk_ting_ref').val($model->id_pk_ting_ref);
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
            if($('#tbody_tersangka tr').length==0)
            {
              localStorage.no_urut = 1;
            }else
            {
              var count_tersangka =  [];
             $('input[name="MsTersangkaBaru[no_urut][]"]').each(function(i,x){
               count_tersangka.push(parseInt(this.value));
             });
              $('#tbody_tersangka a.tambah_calon_tersangka').each(function(i,x){
               count_tersangka.push(parseInt(this.text));
             });

             var a = Math.max.apply(null,count_tersangka);

             if($(this).parent().prop("tagName")=='H3')
             {
               localStorage.no_urut = a+1;
             }
            
            }
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
                              if(id_tersangka =='')
                              {
                                $('#m_tersangka').html('');
                                $('#m_tersangka').load('/pidum/spdp/show-tersangka');
                                $('#m_tersangka').modal('show');
                              }
                              else
                              {
                                $('#m_tersangka').html('');
                                $('#m_tersangka').load('/pidum/spdp/show-tersangka?id_tersangka='+'$model->id_perkara|'+id_tersangka);
                                $('#m_tersangka').modal('show');
                              }
                                
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
                        //alert(input.val());
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
