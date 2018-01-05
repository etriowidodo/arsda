<?php

/**
 * Created by PhpStorm.
 * User: rio
 * Date: 25/06/15
 * Time: 16:03
 */
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
//jaka | 25 Mei 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(

  "$('#tersangka-form').on('afterValidate', function (event, messages) {
     
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
//END <-- CMS_PIDUM001 -->
$form = ActiveForm::begin([
            'id' => 'tersangka-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'showLabels' => false
            ]
        ]);
?>
<div class="modal-content" style="width: 990px;margin: 30px auto;">
    <div class="modal-header">
  DATA TERSANGKA
      
    </div>

   <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'nama'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                    <!-- CMS_PIDUM003_28|jaka|03-06-2016|ganti label TTL menjadi tempat lahir -->
                        <label class="control-label col-md-2">Tempat Lahir</label>
                        <div class="col-md-4">
                            <?php echo $form->field($modelTersangka, 'tmpt_lahir'); ?>
                        </div>
                        <label class="control-label col-md-1" style="width:120px;">Tanggal Lahir</label><!-- jaka|03-06-2016|tambah label tanggal lahir -->
                        <div class="col-md-2" style="width:130px;">
                            <?php
                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
									'options' => [
										'placeholder' => 'Tgl Lahir',
									],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'startDate' => '-101y',
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) {
                                            var tgl = $('#mstersangka-tgl_lahir-disp').val();
                                            var str = tgl.split('-');
                                            var firstdate=new Date(str[2],str[1],str[0]);
											var tglSpdp =$('#spdp-tgl_surat').val();
											
											var start = tglSpdp.split('-');
                                            var Endate=new Date(start[2],start[1],start[0]);
                                            var today = new Date(Endate);
                                            var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
                                            var age = parseInt(dayDiff);
                                            $('#mstersangka-umur').val(age);
											
                                        }",
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <label class="control-label col-md-1" style="width:50px;">Umur</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label Umur -->
						 <div class="col-md-1 contol-label-inline" style="width:110px;">
                         <!-- BEGIN CMS_PIDUM001_03 ETRIO WIDODO -->
                             <?php echo $form->field($modelTersangka, 'umur')->Input('number',
                        ['max'      =>99,
                         'min'      =>0,
                         'maxlength'=>2,
                         'oninput'  =>'
                                        var number =  /^[0-9]+$/;
                                        if(this.value.length>2)
                                        {
                                          this.value = this.value.substr(0,2);
                                        }
                                        if(this.value<0)
                                        {
                                           this.value =null
                                        }
                                        if(!this.value.match(number))
                                        {
                                            this.value =null
                                        }
                                        ']); ?>
                       <!-- END CMS_PIDUM001_03 ETRIO WIDODO -->
                    </div>

                    <label class="col-md-1" style="width:20px;padding-top:6px;padding-left:0px;">Tahun</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label tahun untuk usia-->
                </div>
            </div>
 </div>
            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Identitas & No</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_identitas')->dropDownList(
                                    $identitas,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            )
                            ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php echo $form->field($modelTersangka, 'no_identitas') ?>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                        <!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->
                            <?php
                                 $JnsKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');

                                echo  $form->field($modelTersangka, 'id_jkl')->radiolist($JnsKelamin);
                                //echo  $form->radioButtonList($model,'radio',array('m'=>'male','f'=>'female'),array('separator'=>'', 'labelOptions'=>array('style'=>'display:inline')));
                                                    // ->dropDownList($JnsKelamin,
                                                    // ['prompt' => '---Pilih---'],
                                                    // ['label'=>'']) ?>
                        <!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_agama')->dropDownList( $agama,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">No HP</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'no_hp') ?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelTersangka, 'id_pendidikan')->dropDownList( $pendidikan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            )
                            ?>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">

                            <?php 

                            //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->
                             
                                function search_wn($strorage,$id=null)
                                {
                                    foreach($strorage AS $index=>$value )
                                    {
                                        if($id!=null)
                                        {
                                            if($id==$index)
                                            {
                                                return $value;
                                            }
                                        }                                       
                                        
                                    }
                                }
                                
                                $i_wn = $modelTersangka->warganegara;
                                echo $form->field($modelTersangka, 'warganegara')->textInput(['type'=>'text','value'=>search_wn($warganegara,$i_wn) ,'readonly'=>'readonly','placeholder'=>'--Pilih Kewarganegaraan--','data-id'=>$i_wn]);                             
                             
                            //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->    
                                                    
                            // echo $form->field($modelTersangka, 'warganegara')->dropDownList( $warganegara,
                            //                         ['prompt' => '---Pilih---'],
                            //                         ['label'=>'']
                            //)

                             ?>   
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pekerjaan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>

				<!-- CMS_PIDUM001_07 Danar Wido 26-05-2015-->
				
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Upload Foto</label>
                        <div class="col-md-10">
						
					<?php
                      echo $form->field($modelTersangka, 'foto')->widget(FileInput::classname(), [
                            'options' => [
                                'multiple' => false,
								'id'=> 'foto',
                            ],
                            'pluginOptions' => [
                                'showPreview' => false,
                                'showUpload' => false,
								'allowedFileExtension' => ['jpg','jpeg'],
								'maxFileSize'=> 3072,
                            ]
                        ]);
                        ?>
					
                        </div>
                    </div>
                </div>
				<div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2" style="width:5000px;margin:auto;color:red";>* File size foto maksimal 3 MB, Extensi file : JPG,JPEG</label>
                        <div class="col-md-10">
						     </div>
                    </div>
                </div>
						
				
			<!-- END CMS_PIDUM001_07 Danar Wido 26-05-2015-->

				
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Suku</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'suku') ?>
                        </div>
                    </div>
                </div>


            </div>
            <?= $form->field($modelTersangka, 'id_tersangka')->hiddenInput() ?>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
            <?php if($modelTersangka->isNewRecord): ?>
                <a class="btn btn-warning" id="simpan-tersangka">Simpan</a> 
            <?php else: ?>
                <a class="btn btn-warning" id="ubah-tersangka">Ubah</a> 
            <?php endif; ?>
            <!-- jaka 25 mei 2016/CMS_PIDUM001_8 #tambah tombol batal -->
            <a class="btn btn-danger" data-dismiss="modal">Batal</a>
            <!--END CMS_PIDUM001_8 -->
        </div>
    </div>
</div>
<?php
$script = <<< JS
    var currentValue = 1;
     //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->  
    $('#mstersangka-warganegara').click(function(){
        $('#m_kewarganegaraan').html('');
        $('#m_kewarganegaraan').load('/pdsold/spdp/wn');
        $('#m_kewarganegaraan').modal('show');        
    });
 //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->
    
    $('#m_kewarganegaraan div div div button.close').hide();
	//<!-- CMS_PIDIUM001_4 bowo 25 mei 2016 -->
	$('#mstersangka-nama').attr('placeholder','Nama');
	$('#mstersangka-no_identitas').attr('placeholder','No. Identitas');
	$('#mstersangka-tmpt_lahir').attr('placeholder','Tempat Lahir');
	$('#mstersangka-umur').attr('placeholder','Umur');
    var currentValue = $('tr').length;
	
    $('#simpan-tersangka').click(function(){
        $('#mstersangka-warganegara').attr('data-id','');
        var wn = '';
        if($('#mstersangka-warganegara').attr('data-id')!='')
        {
           wn = $('#mstersangka-warganegara').attr('data-id');    
        }
        var umur = 0;
        if($('#mstersangka-umur').val()!='')
        {
            umur = $('#mstersangka-umur').val();
        }
        var nama = $('#mstersangka-nama').val();
        if(nama!='')
        {


             $('#tbody_tersangka').append(
        // BEGIN CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
            '<tr id="tr_id'+currentValue+'">'+                
                '<td width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
                '<td>' +
                    '<input type="text" name="MsTersangkaBaru[nama][]" value="'+$('#mstersangka-nama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tersangka][]" value="" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tmpt_lahir][]" value="'+$('#mstersangka-tmpt_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tgl_lahir][]" value="'+$('#mstersangka-tgl_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[umur][]" value="'+parseInt(umur)+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_jkl][]" value="'+$('#mstersangka-id_jkl').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[alamat][]" value="'+$('#mstersangka-alamat').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_identitas][]" value="'+$('#mstersangka-id_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_identitas][]" value="'+$('#mstersangka-no_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_hp][]" value="'+$('#mstersangka-no_hp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_agama][]" value="'+$('#mstersangka-id_agama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[warganegara][]" value="'+wn+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[pekerjaan][]" value="'+$('#mstersangka-pekerjaan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[suku][]" value="'+$('#mstersangka-suku').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_pendidikan][]" value="'+$('#mstersangka-id_pendidikan').val()+'" class="form-control tersangka'+ currentValue +'">' +					
					
					'<input type="hidden" name="MsTersangkaBaru[foto][]" value="'+ $('#mstersangka-foto').val() +'" class="form-control tersangka'+ currentValue +'">' +
                '</td>' +
            '</tr>'
            // END CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
        );
        $('#m_tersangka').modal('hide');
        // currentValue ++;
        }else
        {
            //CMS_PIDUM001_ Nama di popup tersangka tidak boleh kosong.
            $('#mstersangka-nama').focus();
            $('#tersangka-form').submit();
            $('.field-mstersangka-id_tersangka').hide();
        }       
        
		
		
    });

    $('#ubah-tersangka').click(function(){
       $("#mstersangka-warganegara").val($("#mstersangka-warganegara").attr('data-id')); 
       $('#m_tersangka').modal('hide');      
        console.log($("form").serialize());
        $.ajax({
            type: "POST",
            url: '/pdsold/spdp/update-tersangka?id='+$('#mstersangka-id_tersangka').val(),
            data: $("form").serialize(),
            success:function(data){                
                $('#m_tersangka').modal('hide');
            },

        });
    });
	
    var tgl = $('#mstersangka-tgl_lahir-disp').val();
    if(tgl != ''){
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
		var tglSpdp =$('#spdp-tgl_surat').val();
											
		var start = tglSpdp.split('-');
        var Endate=new Date(start[2],start[1],start[0]);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
		var age = parseInt(dayDiff);
        $('#mstersangka-umur').val(age);
    }
	
	//BEGIN DANAR CMS_PIDUM001_26 danar Wido 03-06-2016	

                        $('#mstersangka-umur').change(function(){
					
                            var date_birth = $('#spdp-tgl_surat').val();	
							var numb = Number ($('#mstersangka-umur').val());
							var jumlah = numb * 365;
                            if ($('#mstersangka-umur').val() !='') {            
							      var str_tgl_lahir = date_birth.split('-');
                                    console.log(str_tgl_lahir);
                                    var startDate = new Date (str_tgl_lahir[2],str_tgl_lahir[1]-1,str_tgl_lahir[0]);
                                    console.log(startDate);
                                    var the7DaysAfter = new Date(startDate).setDate(startDate.getDate() - jumlah);
                                    console.log(the7DaysAfter);
                                    var endDate = new Date(the7DaysAfter);
                                    console.log(endDate);						                                    	
										function pad(number){
                                        return (number < 10) ? '0' + number : number;
                                    }
                                    var tgl_lahir_human_format = pad(endDate.getDate()) + '-' + pad(endDate.getMonth() + 1) + '-' + endDate.getFullYear();
                                    $('#mstersangka-tgl_lahir-disp').val(tgl_lahir_human_format);									
									var tgl_lahir_db_format = endDate.getFullYear() + '-' + pad(endDate.getMonth() + 1) + '-' + pad(endDate.getDate());
                                    $('#mstersangka-tgl_lahir').val(tgl_lahir_db_format);         
                                    $('#mstersangka-tgl_lahir-disp').val(tgl_lahir_human_format);


							    }
						});
						
	//END DANAR CMS_PIDUM001_26 danar Wido 03-06-2016		
JS;
$this->registerJs($script);

ActiveForm::end();
?>
