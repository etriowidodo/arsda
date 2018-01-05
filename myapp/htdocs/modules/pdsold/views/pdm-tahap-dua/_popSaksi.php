<!-- <script src="js/jquery-1.3.2.js"></script>
<script src="js/jquery.iframe-post-form.js"></script>
<script src="js/jquery.simplemodal.js"></script> -->
<!-- <script src="js/mgupload.js"></script>
 -->
 <style>
#pdmmssaksi-warganegara {
 background-color: #FFF;
  cursor: text;
}


    /* Start by setting display:none to make this hidden.
       Then we position it in relation to the viewport window
       with position:fixed. Width, height, top and left speak
       for themselves. Background we set to 80% white with
       our animation centered, and no-repeating */
    .modal-loading-new {
        display:    none;
        position:   fixed;
        z-index:    1000;
        top:        0;
        left:       0;
        height:     100%;
        width:      100%;
        background: rgba( 255, 255, 255, .8 ) 
                    url(<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/image/loading.gif'; ?>) 
                    50% 50% 
                    no-repeat;
    }

    /* When the body has the loading class, we turn
       the scrollbar off with overflow:hidden */
    body.loading {
        overflow: hidden;   
    }

    /* Anytime the body has the loading class, our
       modal element will be visible */
    body.loading .modal-loading-new {
        display: block;
    }

</style>
<?php

/**
 * Created by PhpStorm.
 * User: rio
 * Date: 25/06/15
 * Time: 16:03
 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
use yii\helpers\Url;
//jaka | 25 Mei 2016/CMS_PIDUM001_10 #setfocus

$this->registerJs(

  "$('#saksi-form').on('afterValidate', function (event, messages) {
     
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
            'id' => 'saksi-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
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
<div class="modal-loading-new"></div>
<div class="modal-content" style="width:75%;margin: 2% auto;">
    <div class="modal-header" id="headx">Data Saksi</div>

    <div class="modal-body">
   
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
             <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">No Urut saksi</label>
                        <div class="col-md-1">
                            <?php echo $form->field($modelsaksi, 'no_urut'); ?>
                        </div>
						<label class="control-label col-md-1">Nama</label>
						<div class="col-md-7">
                            <?php echo $form->field($modelsaksi, 'nama'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <!-- CMS_PIDUM003_28|jaka|03-06-2016|ganti label TTL menjadi tempat lahir -->
                        <label class="control-label col-md-4">Tempat Lahir</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelsaksi, 'tmpt_lahir'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Lahir</label><!-- jaka|03-06-2016|tambah label tanggal lahir -->
                        <div class="col-md-2" style="width:27%">
                            <?php
                            echo $form->field($modelsaksi, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'options' => [
                                        'placeholder' => 'DD-MM-YYYY',//jaka | rubah jadi format tanggal
                                    ],
                                    'pluginOptions' => [
                                        'autoclose' => true,
                                        'startDate' => '-101y',
                                    ],
                                    'pluginEvents' => [
                                        "changeDate" => "function(e) {
                                           
                                            
                                        }",
                                    ],
                                ],
                            ]);
                            ?>
                        </div>
                        <label class="control-label col-md-1" style="width:15%;padding-left:30px;">Umur</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label Umur -->
                         <div class="col-md-2 control-label-inline" style="width:22%">
                         <!-- BEGIN CMS_PIDUM001_03 ETRIO WIDODO -->
                             <?php echo $form->field($modelsaksi, 'umur')->Input('number',
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
                                        ',
                        'onchange'=>'maxpendidikan()'
                                        ]); ?>
                       <!-- END CMS_PIDUM001_03 ETRIO WIDODO -->
                    </div>

                    <label class="control-label label-inline col-md-1" style="padding-left:0px;">Tahun</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label tahun untuk usia-->
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
                                
                                $i_wn = $modelsaksi->warganegara;
                                
                                echo $form->field($modelsaksi, 'warganegara')->textInput(['type'=>'text','value'=>search_wn($warganegara,$i_wn) ,'readonly'=>'readonly','placeholder'=>'--Pilih Kewarganegaraan--','data-id'=>$i_wn]);                             

                            //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->    
                                                    
                            // echo $form->field($modelsaksi, 'warganegara')->dropDownList( $warganegara,
                            //                         ['prompt' => '---Pilih---'],
                            //                         ['label'=>'']
                            //)

                             ?>  
                 
                        </div>
                    </div>
                </div>

                 <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Suku</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelsaksi, 'suku') ?>
                        </div>
                    </div>
                </div> 

            </div>
            <div class="row">


                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Identitas</label>
                        <div class="col-md-8">
                            <?php
                            echo $form->field($modelsaksi, 'id_identitas')->dropDownList(
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
                    <!-- jaka | tambahan label dan filter number-->
                    <label class="control-label col-md-3" style="">No Identitas</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelsaksi, 'no_identitas')->input('text',
                                [
                                'maxlength'=> '24',
                                'oninput'  =>'
                                        var onchange = document.getElementById("pdmmssaksi-id_identitas").value;
                                        var number =  /^[0-9-]+$/;
                                        if(onchange != 3)
                                        {
                                           if(this.value.length>24)
                                            {
                                              this.value = this.value.substr(0,24);
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
                                        }
                                       
                                        
                                        ']) ?>
                        <!-- END -->
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
									<label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                        <!--
                        <div class="btn-group" data-toggle="button-radio">
                            <button type="button" class="btn btn-primary">Laki</button>
                            <button type="button" class="btn btn-primary">Perempuan</button>
                        </div>
                        <!-- BEGIN CMS_PIDUM001_12 ETRIO WIDODO -->
         
                                
                           
								<?php
							
								echo $form->field($modelsaksi, 'id_jkl')->radioList($JenisKelamin);
								
								//echo $form->field($modelsaksi, 'id_jkl')->inline()->radioList($JnsKelamin);
                                //echo $form->field($modelsaksi, 'id_jkl');
                              //echo $form->radioButtonList($modelsaksi,'id_jkl',(1=>'Laki-laki',2=>'Perempuan'),array('separator'=>'&nbsp;','labelOptions'=>array('style'=>'display:inline'),));
                                //echo $form->error($modelsaksi,'id_jkl');
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
                        <label class="control-label col-md-3" style="">Agama</label>
                        <div class="col-md-9">
                            <?php
                            echo $form->field($modelsaksi, 'id_agama')->dropDownList( $agama,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
                            ?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Alamat</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelsaksi, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">No HP</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelsaksi, 'no_hp')->input('text',
                                ['oninput'  =>'var number =  /^[0-9]+$/;
                                        if(this.value.length>24)
                                        {
                                          this.value = this.value.substr(0,24);
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
            </div>

            <div class="row">
                

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                            <?php
                            
                            echo $form->field($modelsaksi, 'id_pendidikan')->dropDownList( $pendidikan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''],
                                                    ['data-id'=>'a']
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">Pekerjaan</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelsaksi, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>

            </div>
           
           
            <?= $form->field($modelsaksi, 'id_saksi')->hiddenInput() ?>
            
            
             <!-- END CMS_PIDUM001_07 EtrioWidodo 08-06-2016--> 
        </div>
		    
			
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
            <?php if($modelsaksi->isNewRecord): ?>
                <a class="btn btn-warning" id="simpan-saksi">Simpan</a> 
            <?php else: ?>
                <a class="btn btn-warning" id="ubah-saksi">Ubahh</a> 
            <?php endif; ?>
            <!-- jaka 25 mei 2016/CMS_PIDUM001_8 #tambah tombol batal -->
            <a class="btn btn-danger" id='batal-saksi'>Batal</a>
            <!--END CMS_PIDUM001_8 -->
        </div>


	</div>


<script language='javascript'>
function validAngka(a)
{
    if(!/^[0-9.]+$/.test(a.value))
    {
    a.value = a.value.substring(0,a.value.length-1000);
    }
}
</script>

<?php
$usia = date('Y,m,d');
$uuid = uniqid();
$maxpendidikan = json_encode($maxPendidikan);
$script = <<< JS
//console.log(localStorage);

console.log(localStorage.jenis)
if(localStorage.jenis == 'saksi'){
  $('#headx').text('Data Saksi');
}else{
  $('#headx').text('Data Ahli');
}

if(typeof(localStorage.no_urut_saksi)!='undefined'&&localStorage.no_urut_saksi!='-Infinity')
{
   $('#pdmmssaksi-no_urut').val(localStorage.no_urut_saksi);
}   
/*$('#pdmmssaksi-no_urut').on('blur',function(){
    var compare = parseInt($(this).val());
       $('#table_saksi #tbody_saksi a').each(function(i,x){
                var split = this.text.split('.');
                if( compare == parseInt(split[0]))
               {
                alert('No Urut Sudah Tersedia');
                $('#pdmmssaksi-no_urut').val(localStorage.no_urut_saksi);
               }
             });
});*/

   
      $('#m_saksi').on('hidden.bs.modal', function () {   
            $("body").css('overflow','hidden');
            $("body").css('overflow-y','scroll');
        });
    
    $('#m_saksi').on('show.bs.modal', function () {
       $("#m_saksi").css('overflow','scroll');
            $("body").css('overflow-y','hidden');            
        });
 $('#pdmmssaksi-tgl_lahir-disp').on('change',function(){
    var tgl = $('#pdmmssaksi-tgl_lahir-disp').val();
    console.log(tgl);
    if(tgl != ''){
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglKejadian ='01-01-1800';
                                            
        var start = tglKejadian.split('-');
        var Endate=new Date($usia);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#pdmmssaksi-umur').val(age);
        maxpendidikan();
    }
 });    
  function maxpendidikan()
  {
    var compare     = $('#pdmmssaksi-umur').val(); 
    var jsonMaxUsia = $maxpendidikan;
    $('#pdmmssaksi-id_pendidikan option:eq(0)').prop('disabled','true'); 
    $.each(jsonMaxUsia,function(x,y){
        if(compare<y)
        {
          $('#pdmmssaksi-id_pendidikan option:eq('+(x)+')').prop('disabled','true');  
          $('#pdmmssaksi-id_pendidikan option:eq('+(x)+')').css('color','red');
        }
        else
        {
          $('#pdmmssaksi-id_pendidikan option:eq('+(x)+')').removeAttr('disabled');
          $('#pdmmssaksi-id_pendidikan option:eq('+(x)+')').css('color','black');
        }
        
    });
  }

//Etrio Widodo
$("#pdmmssaksi-id_identitas").change(function(){
   var change = $(this).val();
    $("#pdmmssaksi-no_identitas").val("");
	if(change=='4'){
		$("#pdmmssaksi-no_identitas").val("-");
		$("#pdmmssaksi-no_identitas").attr('readonly',true);
		
	}else{
		$("#pdmmssaksi-no_identitas").attr('readonly',false);
		$("#pdmmssaksi-no_identitas").val('');
	}
});
var tmppath = '';
var myImage = '';
$('#foto').on('change',function(e){

       if(this.files[0].size>=3072000)
       {
            alert('Besar File tidak boleh melebihi : 3 Mb');
            $('.file-preview').hide(); 
            $('.fileinput-remove-button,.fileinput-remove').trigger('click'); 
            $('.fileinput-remove-button').hide(); 
       }
        var fileExtension = ['jpeg', 'jpg'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) 
        {
             if($(this).val()=='')
             {     
                myImage = '';
                $('#new_foto').val("");           
             }
             else
             {
                alert("Format yang di izinkan hanya : "+fileExtension.join(', '));
                $('.file-preview').hide(); 
                $('.fileinput-remove-button,.fileinput-remove').trigger('click'); 
                $('.fileinput-remove-button').hide(); 
             }
        }else
        {
             $('.file-preview').show();               
             $('.fileinput-remove-button').show();
             tmppath = URL.createObjectURL(e.target.files[0]);    
             var url = tmppath;  
             var canvas = document.getElementById("MyCanvas");
           
                if (canvas.getContext) 
                {
                    var ctx = canvas.getContext("2d");
                    var img = new Image();
                    img.src = url;
                        img.onload = function () 
                        {
                        var hRatio = canvas.width / img.width    ;
                        var vRatio = canvas.height / img.height  ;
                        var ratio  = Math.min ( hRatio, vRatio );
                        ctx.drawImage(img, 0,0, img.width, img.height, 0,0,img.width*ratio, img.height*ratio);
                        myImage = canvas.toDataURL("image/jpeg");
                        $('#new_foto').val(myImage);                        
                        }
                }
                $('#show_image_saksi').remove();
        }
    
    
});



$('.fileinput-remove-button,.fileinput-remove').click(function(){
    myImage = '';
    $('#new_foto').val("");
});
$('.radio').css('display','inline-block');
//BEGIN CMS_PIDUM_SPDP_001
 //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->  
    $('#pdmmssaksi-warganegara').click(function(){
        $('#m_kewarganegaraan').html('');
        $('#m_kewarganegaraan').load('/pdsold/pdm-tahap-dua/wn');
        $('#m_kewarganegaraan').modal('show');
    });
 //<!-- END CMS_PIDUM001_13 ETRIO WIDODO -->
     $('#m_kewarganegaraan div div div button.close').hide();
    //<!-- CMS_PIDIUM001_4 bowo 25 mei 2016 -->
    $('#pdmmssaksi-nama').attr('placeholder','Nama');
    $('#pdmmssaksi-no_identitas').attr('placeholder','No. Identitas');
    $('#pdmmssaksi-tmpt_lahir').attr('placeholder','Tempat Lahir');
    $('#pdmmssaksi-umur').attr('placeholder','Umur');
    
    var mydate       = new Date();
    var unix         = mydate.getDay()+''+mydate.getMonth()+''+mydate.getYear()+''+mydate.getUTCHours()+''+mydate.getUTCMinutes()+''+mydate.getUTCSeconds();
    var currentValue = unix;
    var isi_table = '';
    var wn = '';
	var jekel='';
    function edit_saksi(id,jenis)
    {

        var id = id;
        
        localStorage.unix_saksi       =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(0)").val();
       localStorage.nama_saksi       =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(2)").val();
         
       localStorage.tmpt_lahir_saksi =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(3)").val();
       localStorage.tgl_lahir_saksi  =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(4)").val();
       localStorage.umur_saksi       =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(5)").val();
       localStorage.jk_saksi         =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(6)").val();
       localStorage.alamat_saksi     =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(7)").val();
       localStorage.id_saksi         =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(8)").val();
       localStorage.no_id_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(9)").val();
       localStorage.no_hp_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(10)").val();
       localStorage.agama_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(11)").val();
       localStorage.id_wn_saksi      =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(12)").val();
       localStorage.nm_wn_saksi      =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(12)").attr('attr-id');
       localStorage.kerja_saksi      =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(13)").val();
       localStorage.suku_saksi       =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(14)").val();
       localStorage.pendidikan_saksi =  $("tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(15)").val();
       localStorage.tr_saksi         = id;
       localStorage.no_urut              =  $("#table_"+jenis+" tbody#tbody_"+jenis+"  tr[id='tr_id"+id+"']  input:eq(17)").val();
		var href = $(this).attr('href');
		if(href != null){
			var id_saksi = href.substring(1, href.length);
		}else{
			var id_saksi = '';
		}

        console.log(localStorage);
		$('#m_saksi').html('');
		$('#m_saksi').load('/pdsold/pdm-tahap-dua/show-saksi?id_saksi='+id_saksi);
        $('#m_saksi').modal('show');
    }
    
    
    if(typeof(localStorage.nama_saksi) != 'undefined'&&localStorage.nama_saksi!='')
    {   
        
        $('#simpan-saksi').text('Ubah');
        $('#pdmmssaksi-nama').val(localStorage.nama_saksi);
        $('#pdmmssaksi-tmpt_lahir').val(localStorage.tmpt_lahir_saksi);
        if(localStorage.tgl_lahir_saksi !='')
        {
          var Slice = localStorage.tgl_lahir_saksi.split('-');
          var Ymd   = Slice[2]+'-'+Slice[1]+'-'+Slice[0];
          $('#pdmmssaksi-tgl_lahir-disp').val(localStorage.tgl_lahir_saksi);
          $('#pdmmssaksi-tgl_lahir').val(Ymd);   
        }
        if(localStorage.id_wn_saksi!=1&&localStorage.id_wn_saksi!='')
        {
           //$('#pdmmssaksi-suku').prop('disabled','true'); 
           $('#pdmmssaksi-suku').val('-'); 
            $('#pdmmssaksi-id_identitas option:eq(1)').hide();
            $('#pdmmssaksi-id_identitas option:eq(2)').hide();
        }
        else
        {
            $('#pdmmssaksi-suku').prop('disabled',false);
            $('#pdmmssaksi-id_identitas option:eq(1)').show();
            $('#pdmmssaksi-id_identitas option:eq(2)').show();
        }

        $('#pdmmssaksi-umur').val(localStorage.umur_saksi);
        $('#pdmmssaksi-warganegara').val(localStorage.nm_wn_saksi);
        $('#pdmmssaksi-warganegara').attr('data-id',localStorage.id_wn_saksi);
        $('#pdmmssaksi-id_identitas').val(localStorage.id_saksi);
        $('#pdmmssaksi-no_identitas').val(localStorage.no_id_saksi);
        $('#pdmmssaksi-id_agama').val(localStorage.agama_saksi);
        $('#pdmmssaksi-alamat').val(localStorage.alamat_saksi);
        $('#pdmmssaksi-no_hp').val(localStorage.no_hp_saksi);
        $('#pdmmssaksi-id_pendidikan').val(localStorage.pendidikan_saksi);
        $('#pdmmssaksi-pekerjaan').val(localStorage.kerja_saksi);
        $('#pdmmssaksi-suku').val(localStorage.suku_saksi);
        $('#pdmmssaksi-no_urut').val(localStorage.no_urut);
		maxpendidikan();
		
        $.each($('input[type="radio"]'),function(x,y)
        {
            if(localStorage.jk_saksi==$(this).val())
            {
               $(this).prop('checked',true);
            }
        });

      $('#simpan-saksi').on('click',function(){
        var num = localStorage.tr_saksi;
        removeAfterEdit(num);
        });
        function removeAfterEdit(id)
        {
            if(id!='')
            {
             $("tbody#tbody_saksi tr[id='tr_id"+id+"']").remove();
			 
            }
        }
        
    }
  
    $('#simpan-saksi').click(function(){
        prosesSimpansaksi('0',localStorage.jenis);
    });

    $('#ubah-saksi').click(function(){
		
		prosesSimpansaksi('1',localStorage.jenis);
		
    });
	
	function prosesSimpansaksi(flag,jenis){
		        
		
        if(typeof($('#pdmmssaksi-warganegara').attr('data-id')) === 'undefined')
        {
           wn = '';  
        }
        else
        {
          wn = $('#pdmmssaksi-warganegara').attr('data-id');  
		
        }
        if (($('input[type="radio"]:checked').val()) ==1){ 
		  jekel=$('input[type="radio"]:checked').val();
		}else if (($('input[type="radio"]:checked').val()) ==2){ 
		  jekel=$('input[type="radio"]:checked').val();
		}else{
		  jekel='';
		}
		
        var umur = 0;
        if($('#pdmmssaksi-umur').val()!='')
        {
            umur = $('#pdmmssaksi-umur').val();
        }

        var nama = $('#pdmmssaksi-nama').val().trim();
        var countEmptyValue =0;
		
       if($("#pdmmssaksi-nama").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-no_urut").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-tmpt_lahir").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-tgl_lahir-disp").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-umur").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-warganegara").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($.trim($("#pdmmssaksi-id_identitas").val())!='' || localStorage.id_saksi!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-suku").val()!=''){
				
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-no_identitas").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($.trim($("#pdmmssaksi-id_agama").val())!='' || localStorage.agama_saksi!=''){
                countEmptyValue +=1;                
			}
			
			if($("#saksi-form input[type='radio']:checked").val()!='' && typeof($("#saksi-form input[type='radio']:checked").val())!='undefined'){
                countEmptyValue +=1;                
			}
			
	
			
			if($("#pdmmssaksi-alamat").val()!=''){
                countEmptyValue +=1;                
			}
			
			if($.trim($("#pdmmssaksi-id_pendidikan").val())!='' || localStorage.pendidikan_saksi!=''){
                countEmptyValue +=1;                
			}
			
			if($("#pdmmssaksi-pekerjaan").val()!=''){
                countEmptyValue +=1;                
			}
			
        if(countEmptyValue >=4 )    
        {
                //console.log(localStorage);
            //console.log(localStorage.jenis);
                    var unix_saksi = "";
                    var uuid = "";
                    no_urut        = $('#pdmmssaksi-no_urut').val();
                    if(typeof(localStorage.unix_saksi )!='undefined')
                    {
                       currentValue   = localStorage.unix_saksi;
                       uuid           = currentValue; 
                    
                    }
                    isi_table = '<tr id="tr_id'+currentValue+'">'+                
                    '<td width="20px"><input type="checkbox" name="saksi[]" class="hapussaksi" value="'+currentValue+'"></td>' +
                    '<td>' +
                    '<a href="javascript:void(0);" onclick="edit_saksi(\''+currentValue+'\',\''+jenis+'\')">'+no_urut+'. '+nama+'</a>'+
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][id_saksi][]" value="'+currentValue+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][nama][]" value="'+$('#pdmmssaksi-nama').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][tmpt_lahir][]" value="'+$('#pdmmssaksi-tmpt_lahir').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][tgl_lahir][]" value="'+$('#pdmmssaksi-tgl_lahir-disp').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][umur][]" value="'+parseInt(umur)+'" class="form-control saksi'+ currentValue +'">' +                  
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][id_jkl][]" value="'+jekel+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][alamat][]" value="'+$('#pdmmssaksi-alamat').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][id_identitas][]" value="'+$('#pdmmssaksi-id_identitas').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][no_identitas][]" value="'+$('#pdmmssaksi-no_identitas').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][no_hp][]" value="'+$('#pdmmssaksi-no_hp').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][id_agama][]" value="'+$('#pdmmssaksi-id_agama').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][warganegara][]" attr-id="'+$('#pdmmssaksi-warganegara').val()+'" value="'+wn+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][pekerjaan][]" value="'+$('#pdmmssaksi-pekerjaan').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][suku][]" value="'+$('#pdmmssaksi-suku').val()+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][id_pendidikan][]" value="'+$('#pdmmssaksi-id_pendidikan').val()+'" class="form-control saksi'+ currentValue +'">'+
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][unix][]" value="'+currentValue+'" class="form-control saksi'+ currentValue +'">' +
                    '<input type="hidden" name="MssaksiBaru['+jenis+']['+currentValue+'][no_urut][]" value="'+$('#pdmmssaksi-no_urut').val()+'" class="form-control saksi'+ currentValue +'">' +unix_saksi+
                     '</td>' +
                      '</tr>';
               
              
              
           
			isi_tableHide= '<tr id="tr_id'+currentValue+'">'+                
                '<td>' +
                     '<input type="hidden" style="border:none; background-color:transparent;" name="MssaksiBaru['+jenis+'][nama][]" value="'+nama+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][id_saksi][]" value="$id_saksi" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][id_saksi][]" value="" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][tmpt_lahir][]" value="'+$('#pdmmssaksi-tmpt_lahir').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][tgl_lahir][]" value="'+$('#pdmmssaksi-tgl_lahir-disp').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][umur][]" value="'+parseInt(umur)+'" class="form-control saksi'+ currentValue +'">' +                  
                          '<input type="hidden" name="MssaksiBaru['+jenis+'][id_jkl][]" value="'+jekel+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][alamat][]" value="'+$('#pdmmssaksi-alamat').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][id_identitas][]" value="'+$('#pdmmssaksi-id_identitas').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][no_identitas][]" value="'+$('#pdmmssaksi-no_identitas').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][no_hp][]" value="'+$('#pdmmssaksi-no_hp').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][id_agama][]" value="'+$('#pdmmssaksi-id_agama').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][warganegara][]" attr-id="'+$('#pdmmssaksi-warganegara').val()+'" value="'+wn+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][pekerjaan][]" value="'+$('#pdmmssaksi-pekerjaan').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][suku][]" value="'+$('#pdmmssaksi-suku').val()+'" class="form-control saksi'+ currentValue +'">' +
                     '<input type="hidden" name="MssaksiBaru['+jenis+'][id_pendidikan][]" value="'+$('#pdmmssaksi-id_pendidikan').val()+'" class="form-control saksi'+ currentValue +'">' +
                          '<input type="hidden" name="MssaksiBaru['+jenis+'][no_urut][]" value="'+$('#pdmmssaksi-no_urut').val()+'" class="form-control saksi'+ currentValue +'">' +
                '</td>' +
            '</tr>'
			if(flag=='0'){
                $('#tbody_'+localStorage.jenis).append(isi_table);  
			}else{
				$('#tbody_'+localStorage.jenis).html(isi_table);    
			}
        $('#m_saksi').modal('hide');
        }
        else
        {
            
            //CMS_PIDUM001_ Nama di popup saksi tidak boleh kosong.
            $('#pdmmssaksi-nama').focus();
             if($('#pdmmssaksi-warganegara').attr('data-id')!=1)
                {
                    $('#pdmmssaksi-suku').parent().parent().attr('class','form-group ');
                    $('.field-pdmmssaksi-suku').find('.help-block').remove();
                }
            $('#saksi-form').submit();
            $('.field-mssaksi-id_saksi').hide();
            
        }
        console.log(localStorage);  
	}

    $('#batal-saksi').on('click',function(){
      $('#m_saksi').modal('hide')
    }); 

    
            
    

JS;
$this->registerJs($script);

ActiveForm::end();



Modal::begin([
    'id' => 'm_saksi2',
    'header' => '<h7>Data saksi</h7>'
]);
Modal::end();


Modal::begin([
    'id' => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Warganegara</h7>'
]);
Modal::end();


?>
