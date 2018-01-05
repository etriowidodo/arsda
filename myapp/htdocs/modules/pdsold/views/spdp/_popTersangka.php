<!-- <script src="js/jquery-1.3.2.js"></script>
<script src="js/jquery.iframe-post-form.js"></script>
<script src="js/jquery.simplemodal.js"></script> -->
<!-- <script src="js/mgupload.js"></script>
 -->
 <style>

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
            ],
            'options' => [
                            'enctype' => 'multipart/form-data',
                        ]
        ]);
?>
<div class="modal-loading-new"></div>
<div class="modal-content" style="width:75%;margin: 2% auto;">
    <div class="modal-header">
        <!--CMS_PIDIUM001_5-->
        Data Tersangka
    </div>

    <div class="modal-body">
   
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
			
            <div class="row">
            <!-- canvas untuk foto
            <canvas  style="display:none"  width="1200" height="1800" id="MyCanvas">This browser or document mode doesn't support canvas</canvas>
                 -->
				 <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">No Urut Tersangka <?php echo $modelTersangka['no_urut'] ;?></label>
                        <div class="col-md-1">
                            <?php echo $form->field($modelTersangka, 'no_urut'); ?>
                        </div>
						<label class="control-label col-md-1">Nama</label>
						<div class="col-md-7">
                            <?php echo $form->field($modelTersangka, 'nama'); ?>
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
                            <?php echo $form->field($modelTersangka, 'tmpt_lahir'); ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3">Tanggal Lahir</label><!-- jaka|03-06-2016|tambah label tanggal lahir -->
                        <div class="col-md-2" style="width:27%">
                            <?php
                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
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
                                            var tgl = $('#mstersangka-tgl_lahir-disp').val();
                                            var str = tgl.split('-');
                                            var firstdate=new Date(str[2],str[1],str[0]);
                                            var tglSpdp =$('#pdmspdp-tgl_surat-disp').val();
                                            
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
                        <label class="control-label col-md-1" style="width:15%;padding-left:30px;">Umur</label><!-- CMS_PIDUM003_28|jaka|03-06-2016|tambah label Umur -->
                         <div class="col-md-2 control-label-inline" style="width:22%">
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
                        <label class="control-label col-md-3">Suku</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'suku') ?>
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
                    <!-- jaka | tambahan label dan filter number-->
                    <label class="control-label col-md-3" style="">No Identitas</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'no_identitas')->input('text',
                                [
                                'maxlength'=> '24',
                                'oninput'  =>'
                                        var onchange = document.getElementById("mstersangka-id_identitas").value;
                                        var number =  /^[0-9]+$/;
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
							
								echo $form->field($modelTersangka, 'id_jkl')->radioList($JenisKelamin);
								
								//echo $form->field($modelTersangka, 'id_jkl')->inline()->radioList($JnsKelamin);
                                //echo $form->field($modelTersangka, 'id_jkl');
                              //echo $form->radioButtonList($modelTersangka,'id_jkl',(1=>'Laki-laki',2=>'Perempuan'),array('separator'=>'&nbsp;','labelOptions'=>array('style'=>'display:inline'),));
                                //echo $form->error($modelTersangka,'id_jkl');
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
                            echo $form->field($modelTersangka, 'id_agama')->dropDownList( $agama,
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
                            <?php echo $form->field($modelTersangka, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">No HP</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'no_hp')->input('text',
                                ['oninput'  =>'var number =  /^[0-9 +]+$/;
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
                            echo $form->field($modelTersangka, 'id_pendidikan')->dropDownList( $pendidikan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>'']
                            )
                            ?>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-3" style="">Pekerjaan</label>
                        <div class="col-md-9">
                            <?php echo $form->field($modelTersangka, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>

            </div>
            
            <?= $form->field($modelTersangka, 'id_tersangka')->hiddenInput() ?>
            <input type="hidden" class="form-control" name="MsTersangka[foto]" 
            value="<?php echo $modelTersangka['id_tersangka'].'.jpg'; ?>">
            <input type="hidden" id="new_foto" class="form-control" name="MsTersangka[new_foto]" value="">
             <!-- END CMS_PIDUM001_07 EtrioWidodo 08-06-2016--> 
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
            <?php if($modelTersangka->isNewRecord): ?>
                <a class="btn btn-warning" id="simpan-tersangka">Simpan</a> 
            <?php else: ?>
                <a class="btn btn-warning" id="ubah-tersangka">Ubah</a> 
            <?php endif; ?>
            <!-- jaka 25 mei 2016/CMS_PIDUM001_8 #tambah tombol batal -->
            <a class="btn btn-danger" id='batal-tersangka'>Batal</a>
            <!--END CMS_PIDUM001_8 -->
        </div>
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
$script = <<< JS
if(typeof(localStorage.no_urut)!='undefined'&&localStorage.no_urut!='-Infinity')
{
   $('#mstersangka-no_urut').val(localStorage.no_urut);
}   
$('#mstersangka-no_urut').on('blur',function(){
    var compare = parseInt($(this).val());
     $('input[name="MsTersangkaBaru[no_urut][]"]').each(function(i,x){
               if( compare ==parseInt(this.value))
               {
                alert('No Urut Sudah Tersedia');
                $('#mstersangka-no_urut').val(localStorage.no_urut);
               }
      });
       $('#tbody_tersangka a.tambah_calon_tersangka').each(function(i,x){
                if( compare ==parseInt(this.text))
               {
                alert('No Urut Sudah Tersedia');
                $('#mstersangka-no_urut').val(localStorage.no_urut);
               }
             });
})
$('#mstersangka-tgl_lahir-disp').kvDatepicker({
    beforeShow: function (textbox, instance) {
            instance.dpDiv.css({
                    marginTop: (-textbox.offsetHeight) + 'px',
                    marginLeft: textbox.offsetWidth + 'px'
            });
    }
});



$('#batal-tersangka').on('click',function(){
    $('body').css('overflow-y','scroll');
    $('#m_tersangka').modal('hide');
});

//Etrio Widodo
$("#mstersangka-id_identitas").change(function(){
    var change = $(this).val();
    $("#mstersangka-no_identitas").val("");
	if(change=='4'){
		$("#mstersangka-no_identitas").attr('readonly',true);
	}else{
		$("#mstersangka-no_identitas").attr('readonly',false);
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
                $('#show_image_tersangka').remove();
        }
    
    
});



$('.fileinput-remove-button,.fileinput-remove').click(function(){
    myImage = '';
    $('#new_foto').val("");
});
$('.radio').css('display','inline-block');
//BEGIN CMS_PIDUM_SPDP_001
 //<!-- BEGIN CMS_PIDUM001_13 ETRIO WIDODO -->  
    $('#mstersangka-warganegara').click(function(){
		$("#mstersangka-warganegara").parent().parent().removeClass('has-error');
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
    $('#mstersangka-umur').attr('placeholder','Umur');var mydate       = new Date();
    var unix         = mydate.getYear()+''+mydate.getUTCHours()+''+mydate.getUTCMinutes()+''+mydate.getUTCSeconds();
    var currentValue = unix;
    var isi_table = '';
    var wn = '';
	var jekel='';
    function edit_tersangka(id)
    {

        var id    = id;
        var eq_td = '';
        if(typeof($('#tr_id'+id+' td:eq(1) input:eq(0)').val()) != 'undefined')
        {
            eq_td =' td:eq(1) ';
        }
        else
        {
            eq_td =' td:eq(0) ';
        }

             
            localStorage.no_urut_tersangka    = $('#tr_id'+id+' '+eq_td+'input:eq(15)').val();
            localStorage.nama_tersangka       = $('#tr_id'+id+' '+eq_td+'input:eq(0)').val();
            localStorage.pk_tersangka         = $('#tr_id'+id+' '+eq_td+'input:eq(1)').val();
            localStorage.tmpt_lahir_tersangka = $('#tr_id'+id+' '+eq_td+'input:eq(2)').val();
            localStorage.tgl_lahir_tersangka  = $('#tr_id'+id+' '+eq_td+'input:eq(3)').val();
            localStorage.umur_tersangka       = $('#tr_id'+id+' '+eq_td+'input:eq(4)').val();
            localStorage.jk_tersangka         = $('#tr_id'+id+' '+eq_td+'input:eq(5)').val();
            localStorage.alamat_tersangka     = $('#tr_id'+id+' '+eq_td+'input:eq(6)').val();
            localStorage.id_tersangka         = $('#tr_id'+id+' '+eq_td+'input:eq(7)').val();
            localStorage.no_id_tersangka      = $('#tr_id'+id+' '+eq_td+'input:eq(8)').val();
            localStorage.no_hp_tersangka      = $('#tr_id'+id+' '+eq_td+'input:eq(9)').val();
            localStorage.agama_tersangka      = $('#tr_id'+id+' '+eq_td+'input:eq(10)').val();
            localStorage.id_wn_tersangka      = $('#tr_id'+id+' '+eq_td+'input:eq(11)').val();
            localStorage.nm_wn_tersangka      = $('#tr_id'+id+' '+eq_td+'input:eq(11)').attr('attr-id');
            localStorage.kerja_tersangka      = $('#tr_id'+id+' '+eq_td+'input:eq(12)').val();
            localStorage.suku_tersangka       = $('#tr_id'+id+' '+eq_td+'input:eq(13)').val();
            localStorage.pendidikan_tersangka = $('#tr_id'+id+' '+eq_td+'input:eq(14)').val();
            localStorage.tr_tersangka         = id;
            localStorage.foto_tersangka       = $('#tr_id'+id+' '+eq_td+'input:eq(15)').val(); 
        
                                $('#m_tersangka').html('');
                                $('#m_tersangka').load('/pdsold/spdp/show-tersangka');
                                $('#m_tersangka').modal('show');
    }
    
   
    if(typeof(localStorage.nama_tersangka) != 'undefined')
    {   
       
        if(localStorage.pk_tersangka=='')
        {
            $('#simpan-tersangka').text('Ubah');
           
        }
        else
        {
           $('#simpan-tersangka').text('Ubah');
           $('#simpan-tersangka').attr('id','ubah-tersangka'); 
        }
       
        $('#mstersangka-nama').val(localStorage.nama_tersangka);
        $('#mstersangka-tmpt_lahir').val(localStorage.tmpt_lahir_tersangka);
        if(localStorage.tgl_lahir_tersangka !='')
        {
          var tgl_t = localStorage.tgl_lahir_tersangka.split('-');

          $('#mstersangka-tgl_lahir-disp').val(tgl_t[2]+'-'+tgl_t[1]+'-'+tgl_t[0]);  
          $('#mstersangka-tgl_lahir').val(localStorage.tgl_lahir_tersangka);
        }
        $('#mstersangka-umur').val(localStorage.umur_tersangka);
        $('#mstersangka-warganegara').val(localStorage.nm_wn_tersangka);
        $('#mstersangka-warganegara').attr('data-id',localStorage.id_wn_tersangka);
        $('#mstersangka-id_identitas').val(localStorage.id_tersangka);
        $('#mstersangka-no_identitas').val(localStorage.no_id_tersangka);
        $('#mstersangka-id_agama').val(localStorage.agama_tersangka);
        $('#mstersangka-alamat').val(localStorage.alamat_tersangka);
        $('#mstersangka-no_hp').val(localStorage.no_hp_tersangka);
        $('#mstersangka-no_urut').val(localStorage.no_urut_tersangka);
        $('#mstersangka-id_pendidikan').val(localStorage.pendidikan_tersangka);
        if(typeof(localStorage.pk_tersangka)!= 'undefined')
        {
            $('#mstersangka-id_tersangka').val(localStorage.pk_tersangka);  
        }
        else
        {
            $('#mstersangka-id_tersangka').val("");
        }
        $('#mstersangka-pekerjaan').val(localStorage.kerja_tersangka);
        $('#mstersangka-suku').val(localStorage.suku_tersangka);
        $('#mstersangka-suku').val(localStorage.suku_tersangka);
        $.each($('input[type="radio"]'),function(x,y)
        {
            if(localStorage.jk_tersangka==$(this).val())
            {
               $(this).prop('checked',true);
            }
        });

      $('#simpan-tersangka').on('click',function(){
        var num = localStorage.tr_tersangka;
        removeAfterEdit(num);
        });
        function removeAfterEdit(id)
        {
            if(id!='')
            {
             $('#tr_id'+id).remove();
             localStorage.clear();
            }
        }
        
    }



  
    $('#simpan-tersangka').click(function(){        

        if(typeof($('#mstersangka-warganegara').attr('data-id')) === 'undefined')
        {
           wn = '';  
        }
        else
        {
          wn = $('#mstersangka-warganegara').attr('data-id');  
		
        }
        if (($('input[type="radio"]:checked').val()) ==1)
		{ 
		jekel=$('input[type="radio"]:checked').val();
		}
		else if (($('input[type="radio"]:checked').val()) ==2)
		{ 
		jekel=$('input[type="radio"]:checked').val();
		}
		else
		{
		jekel='';
		}
		
        var umur = 0;
        if($('#mstersangka-umur').val()!='')
        {
            umur = $('#mstersangka-umur').val();
        }
        var nama        = $('#mstersangka-nama').val().trim();  
        var no_urut     = parseInt($('#mstersangka-no_urut').val());  
        if(nama!=''&&no_urut>0)
        {
            isi_table = '<tr id="tr_id'+currentValue+'">'+                
                '<td width="20px"><input type="checkbox" name="tersangka[]" class="hapusTersangka" value="'+currentValue+'"></td>' +
                '<td>' +
                    '<a href="javascript:void(0);" onclick="edit_tersangka('+currentValue+')">'+no_urut+'. '+nama+'</a>'+
                    '<input type="hidden" name="MsTersangkaBaru[nama][]" value="'+nama+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_tersangka][]" value="" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tmpt_lahir][]" value="'+$('#mstersangka-tmpt_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[tgl_lahir][]" value="'+$('#mstersangka-tgl_lahir').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[umur][]" value="'+parseInt(umur)+'" class="form-control tersangka'+ currentValue +'">' +                  
					'<input type="hidden" name="MsTersangkaBaru[id_jkl][]" value="'+jekel+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[alamat][]" value="'+$('#mstersangka-alamat').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_identitas][]" value="'+$('#mstersangka-id_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_identitas][]" value="'+$('#mstersangka-no_identitas').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[no_hp][]" value="'+$('#mstersangka-no_hp').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_agama][]" value="'+$('#mstersangka-id_agama').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[warganegara][]" attr-id="'+$('#mstersangka-warganegara').val()+'" value="'+wn+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[pekerjaan][]" value="'+$('#mstersangka-pekerjaan').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[suku][]" value="'+$('#mstersangka-suku').val()+'" class="form-control tersangka'+ currentValue +'">' +
                    '<input type="hidden" name="MsTersangkaBaru[id_pendidikan][]" value="'+$('#mstersangka-id_pendidikan').val()+'" class="form-control tersangka'+ currentValue +'">' +              
                    '<input type="hidden" name="MsTersangkaBaru[no_urut][]" value="'+$('#mstersangka-no_urut').val()+'" class="form-control tersangka'+currentValue+'">' +                   
                '</td>' +
            '</tr>'

             $('#tbody_tersangka').append(
        // BEGIN CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
                    isi_table
            // END CMS_PIDUM002_ Etrio Widodo Permintaan Pa Amir
        ); 
        $('body').css('overflow-y','scroll');      
        $('#m_tersangka').modal('hide');

        // currentValue ++;
        }
        else
        {
            //CMS_PIDUM001_ Nama di popup tersangka tidak boleh kosong.
            alert('Nama atau No Urut Tidak Boleh Kosong');
            $('#mstersangka-nama').focus();
            $('#tersangka-form').submit();
            $('.field-mstersangka-id_tersangka').hide();
            
        }  
        
    });
    
    $('#ubah-tersangka').click(function(){
       if(typeof($('#mstersangka-warganegara').attr('data-id')) === 'undefined')
        {
           wn = '';  
        }
        else
        {
          wn = $('#mstersangka-warganegara').attr('data-id');  
        
        }
        if (($('input[type="radio"]:checked').val()) ==1)
        { 
        jekel=$('input[type="radio"]:checked').val();
        }
        else if (($('input[type="radio"]:checked').val()) ==2)
        { 
        jekel=$('input[type="radio"]:checked').val();
        }
        else
        {
        jekel='';
        }
        
        var umur = 0;
        if($('#mstersangka-umur').val()!='')
        {
            umur = $('#mstersangka-umur').val();
        }

        var nama        = $('#mstersangka-nama').val().trim();
        var tersangka   = $('#mstersangka-id_tersangka').val();
        var no_urut     = parseInt($('#mstersangka-no_urut').val());  
        allFoundCharacters = tersangka.match(/[|]/g);
        
        if(allFoundCharacters.length>0)
        {
            tersangka = tersangka.split('|');
            tersangka = tersangka[1];

        }
        if(nama!=''&&no_urut>0)
        {
            isi_table = '<a href="javascript:void(0);" onclick="edit_tersangka(\''+tersangka+'\')">'+no_urut+'. '+nama+'</a>'+
                        '<input type="hidden" name="MsTersangkaUpdate[nama][]" value="'+nama+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[id_tersangka][]" value="'+$('#mstersangka-id_tersangka').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[tmpt_lahir][]" value="'+$('#mstersangka-tmpt_lahir').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[tgl_lahir][]" value="'+$('#mstersangka-tgl_lahir').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[umur][]" value="'+parseInt(umur)+'" class="form-control tersangka">' +                  
                        '<input type="hidden" name="MsTersangkaUpdate[id_jkl][]" value="'+jekel+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[alamat][]" value="'+$('#mstersangka-alamat').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[id_identitas][]" value="'+$('#mstersangka-id_identitas').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[no_identitas][]" value="'+$('#mstersangka-no_identitas').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[no_hp][]" value="'+$('#mstersangka-no_hp').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[id_agama][]" value="'+$('#mstersangka-id_agama').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[warganegara][]" attr-id="'+$('#mstersangka-warganegara').val()+'" value="'+wn+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[pekerjaan][]" value="'+$('#mstersangka-pekerjaan').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[suku][]" value="'+$('#mstersangka-suku').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[id_pendidikan][]" value="'+$('#mstersangka-id_pendidikan').val()+'" class="form-control tersangka">' +
                        '<input type="hidden" name="MsTersangkaUpdate[no_urut][]" value="'+$('#mstersangka-no_urut').val()+'" class="form-control tersangka'+currentValue+'">';
            if($('#tr_id'+tersangka+' td input[type=checkbox]').length>0)
            {
              if($('#tr_id'+tersangka+' td:eq(1) input[type=hidden]').length>0)
                {
                    //$('#tr_id'+tersangka+' td:eq(1) input[type=hidden]').remove();
                    $('#tr_id'+tersangka+' td:eq(1)').html(isi_table);
                }
                else
                {
                    $('#tr_id'+tersangka+' td:eq(1)').html(isi_table);
                }  
            }
            else
            {
                if($('#tr_id'+tersangka+' td:eq(0) input[type=hidden]').length>0)
                {
                    //$('#tr_id'+tersangka+' td:eq(0) input[type=hidden]').remove();
                    $('#tr_id'+tersangka+' td:eq(0)').html(isi_table);
                }
                else
                {
                    $('#tr_id'+tersangka+' td:eq(0)').html(isi_table);
                }  
            }
        $('body').css('overflow-y','scroll');
        localStorage.clear();       
        $('#m_tersangka').modal('hide');

        }
        else
        {
            //CMS_PIDUM001_ Nama di popup tersangka tidak boleh kosong.
            alert('Nama Atau No Urut Tidak Boleh Kosong');
            $('#mstersangka-nama').focus();
            $('#tersangka-form').submit();
            $('.field-mstersangka-id_tersangka').hide();
            
        }  
    });
    
    var tgl = $('#mstersangka-tgl_lahir-disp').val();
    if(tgl != ''){
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglSpdp =$('#pdmspdp-tgl_surat-disp').val();
                                            
        var start = tglSpdp.split('-');
        var Endate=new Date(start[2],start[1],start[0]);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#mstersangka-umur').val(age);
    }
    
    //BEGIN DANAR CMS_PIDUM001_26 danar Wido 03-06-2016 

                        // $('#mstersangka-umur').change(function(){
                    
                        //     // var date_birth = $('#pdmspdp-tgl_surat-disp').val();    
                        //     // var numb = Number ($('#mstersangka-umur').val());
                        //     // var jumlah = numb * 365;
                        //     // if ($('#mstersangka-umur').val() !='') 
                        //     //     {            
                        //     //         var str_tgl_lahir = date_birth.split('-');
                        //     //         console.log(str_tgl_lahir);
                        //     //         var startDate = new Date (str_tgl_lahir[2],str_tgl_lahir[1]-1,str_tgl_lahir[0]);
                        //     //         console.log(startDate);
                        //     //         var the7DaysAfter = new Date(startDate).setDate(startDate.getDate() - jumlah);
                        //     //         console.log(the7DaysAfter);
                        //     //         var endDate = new Date(the7DaysAfter);
                        //     //         console.log(endDate);                                                               
                        //     //             function pad(number)
                        //     //             {
                        //     //                 return (number < 10) ? '0' + number : number;
                        //     //             }
                        //     //         var tgl_lahir_human_format = pad(endDate.getDate()) + '-' + pad(endDate.getMonth() + 1) + '-' + endDate.getFullYear();
                        //     //         $('#mstersangka-tgl_lahir-disp').val(tgl_lahir_human_format);                                   
                        //     //         var tgl_lahir_db_format = endDate.getFullYear() + '-' + pad(endDate.getMonth() + 1) + '-' + pad(endDate.getDate());
                        //     //         $('#mstersangka-tgl_lahir').val(tgl_lahir_db_format);         
                        //     //         $('#mstersangka-tgl_lahir-disp').val(tgl_lahir_human_format);


                        //     //     }
                        // });
                        
    //END DANAR CMS_PIDUM001_26 danar Wido 03-06-2016       
JS;
$this->registerJs($script);

ActiveForm::end();
?>
