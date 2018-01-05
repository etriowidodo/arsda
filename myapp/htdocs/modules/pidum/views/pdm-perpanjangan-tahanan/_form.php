<?php
use kartik\widgets\ActiveForm;
use kartik\builder\Form;
use kartik\datecontrol\DateControl;
use kartik\widgets\DatePicker;
use yii\helpers\ArrayHelper;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\PdmTahananPenyidik;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\FileInput;
//use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPerpanjanganTahanan */
/* @var $form yii\widgets\ActiveForm */
$tgl_akhir = date('d'); 
$bln_akhir = date('m'); 
$thn_akhir = date('Y'); 
//jaka | 10 Juni 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#perpanjanganTananan').on('afterValidate', function (event, messages) {
     
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
  
  $('#pdmperpanjangantahanan-tgl_surat_penahanan-disp').on('change',function(){
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
    finaldate               = $tgl_akhir+'-'+$bln_akhir+'-'+$thn_akhir;
    date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
    var input               = $('#tgl_diterima').html();
    var datecontrol         = $('#pdmperpanjangantahanan-tgl_surat-disp').attr('data-krajee-datecontrol');
    $('#tgl_diterima').html(input);
    var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_001 = {'idSave':'pdmperpanjangantahanan-tgl_surat','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
      $('#pdmperpanjangantahanan-tgl_surat-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmperpanjangantahanan-tgl_surat-disp').datecontrol(datecontrol_001);
      $('.field-pdmperpanjangantahanan-tgl_surat').removeClass('.has-error');
      $('#pdmperpanjangantahanan-tgl_surat-disp').removeAttr('disabled');
  });
  
  $('body').on('change','#pdmperpanjangantahanan-tgl_surat-disp',function(){
    var checkInput = $('#pdmperpanjangantahanan-tgl_terima-disp').val();
    if(checkInput=='')
    {
		
		
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
        finaldate               = $tgl_akhir+'-'+$bln_akhir+'-'+$thn_akhir;
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('#tgl_diterima1').html();
        var datecontrol         = $('#pdmperpanjangantahanan-tgl_terima-disp').attr('data-krajee-datecontrol');
        $('#tgl_diterima1').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmperpanjangantahanan-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmperpanjangantahanan-tgl_terima-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmperpanjangantahanan-tgl_terima-disp').datecontrol(datecontrol_001);
          $('.field-pdmperpanjangantahanan-tgl_terima-disp').removeClass('.has-error');
          $('#pdmperpanjangantahanan-tgl_terima-disp').removeAttr('disabled');
    }
    else
    {
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
        finaldate               = $tgl_akhir+'-'+$bln_akhir+'-'+$thn_akhir;
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('#tgl_diterima1').html();
        var datecontrol         = $('#pdmperpanjangantahanan-tgl_terima-disp').attr('data-krajee-datecontrol');
        $('#tgl_diterima1').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmperpanjangantahanan-tgl_terima','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmperpanjangantahanan-tgl_terima-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmperpanjangantahanan-tgl_terima-disp').datecontrol(datecontrol_001);
          $('.field-pdmperpanjangantahanan-tgl_terima-disp').removeClass('.has-error');
          $('#pdmperpanjangantahanan-tgl_terima-disp').removeAttr('disabled');
          $('#pdmperpanjangantahanan-tgl_terima-disp').val(checkInput);
    }

  });
  "
  );
//END <-- CMS_PIDUM001 -->
$this->title = 'Tambah Permintaan Perpanjangan Penahanan';
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

        <?php
        $form = ActiveForm::begin(
            [
                'id' => 'perpanjanganTananan',
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
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">

            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Instansi Penyidik</label>

                        <div class="col-md-8">
                            <input class="form-control" value="<?= $modelAsalSurat ?>" readOnly="true">
                        </div>

                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Instansi Pelaksana Penyidikan</label>

                        <div class="col-md-8">
                            <input class="form-control" value="<?= $modelPenyidik ?>" readOnly="true">
                        </div>

                    </div>
                </div>
            </div>
            <div class="clearfix" style="margin-bottom:14px;"></div>
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat Perintah Penahanan</label>

                        <div class="col-md-8">
                            <?= $form->field($model, 'no_surat_penahanan')->input('text',
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
                <div class="col-md-6" >
                <div class="form-group">
                <label class="control-label col-md-4">Tanggal Surat Perintah Penahanan</label>

                    <div class="col-md-3" >
                    <?php 
                          //$endDate          = "+".((ceil(date('n') / 12) * 12)-date('n'))."m"; 
                          $startDate        = "-1y -".(date('n')-1)."m";
                    ?>
                        <?= $form->field($model, 'tgl_surat_penahanan')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'startDate' => $startDate,
                                    'endDate'   => date('d-m-Y')
                                ],
                                'options' => [
                                    'placeholder' => 'DD-MM-YYYY'
                                ]
                            ],
                        ]);
                        ?>
                    </div>
                    <div class="col-md-1" style="padding-left:2px;">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Nomor Surat Permintaan</label>
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
            <div class="col-md-6" >
                <div class="form-group">
                <label class="control-label col-md-4">Tanggal Permintaan</label>
                    <div class="col-md-3"  id='tgl_diterima'><!--CMS_PIDUM003_19|JAKA|02-06-2016| SETIAP TANGGAL LEBAR KOLOMNYA SAMA -->
                        <?= $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'endDate' => date('d-m-Y'),

                                ],
                                'options' => [
                                    'placeholder' => 'DD-MM-YYYY',
                                    'disabled' => true
                                ]
                            ],
                        ]);
                        ?>
                    </div>
                    </div>
                    <div class="col-md-1" style="padding-left:2px;">
                    </div>
                </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                    <div class="col-md-8">
                        <input class="form-control" value="<?php echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">
                        <?= $form->field($model, 'terima_dari')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6" >
            <div class="form-group">
                <label class="control-label col-md-4">Tanggal Diterima</label>
                    <div id="tgl_diterima1" class="col-md-3 " ><!--CMS_PIDUM003_19|JAKA|02-06-2016| SETIAP TANGGAL LEBAR KOLOMNYA SAMA -->
                        <?= $form->field($model, 'tgl_terima')->widget(DateControl::className(), [
                            'type' => DateControl::FORMAT_DATE,
                            'ajaxConversion' => false,
                            'options' => [
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'endDate' => date('d-m-Y'),
                                ],
                                'options' => [
                                    'placeholder' => 'DD-MM-YYYY',
                                    'disabled' => true
                                ]
                            ],
                        ]);
                        ?>
                    </div>
                    </div>
                    <div class="col-md-1" style="padding-left:2px;">
                    </div>
                </div>
        </div>
    

	<div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                    <a class="btn btn-danger delete hapus"></a>&nbsp;<a class="btn btn-primary tombol_tambah_calon_tersangka tambah-tersangka" id="popUpJpu">Tersangka</a>
                </h3>
            </div>
            <div class="box-header with-border">
                <table id="table_tersangka" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="text-align:center;" width="45px">#</th>
                            <th style="text-align:center;">Nama</th>
                            <th>Tempat, Tanggal Lahir</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_tersangka">
                        <?php if(!$model->isNewRecord && count($modelListTersangka) > 1){ ?>
                        <tr>
                                <td><input type='checkbox' name='tersangka[]' class='hapusTersangka' id='hapusTersangka' value='<?=$modelListTersangka['id_tersangka']?>'></td>
                                <td><a href="#<?=$modelListTersangka['id_tersangka']?>" class="tambah_calon_tersangka" ><?=$modelListTersangka['nama']?></a></td>
                                <td><?=$modelListTersangka['tmpt_lahir'].", ".$modelListTersangka['tgl_lahir']?></td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
		
		<div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
        <div class="col-md-12" >
        <div class="col-md-6" >
            <div class="form-group form-inline">
               
        		
				<div class="col-md-2 inline" >
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
                                'browseLabel'=>'Unggah Surat Permintaan...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pidum_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					
                        ?>  
						
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>


    <div class="box-footer">
		<?php if($model->isNewRecord){ ?>
		<button id="simpan" class="btn btn-warning" type="button">Simpan</button>
		<?php }else{ ?>
		<button id="simpan" class="btn btn-warning" type="button">Ubah</button>
		<?php } ?>
        
        <!-- jaka | 1 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['../pidum/pdm-perpanjangan-tahanan/index'] : ['../pidum/pdm-perpanjangan-tahanan/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
    </div>
<div id="hiddenId"></div>
<?php ActiveForm::end(); ?>
</div>
</section>



	<?php
Modal::begin([
    'id' => 'm_tersangka',
    'header' => '<h7>Data Tersangka</h7>'
]);
Modal::end();

Modal::begin([
    'id'     => 'm_kewarganegaraan',
    'header' => '<h7>Pilih Kewarganegaraan<button type="button" id="contoh">klik</button></h7>',
'clientOptions' => ['backdrop' => 'static', 'keyboard' => false] 
]);
Modal::end();

?>
 
 
<?php
$script = <<< JS
    if($('.btn-warning').text()=='Simpan')
    {
        $('.btn-warning').attr('type','button');
        $('.btn-warning').attr('id','simpan');
    }

    $('#simpan').on('click',function(){
        if($('#tbody_tersangka tr').length<1)
        {
         bootbox.dialog({
                            message: "Tersangka Harus Terisi",
                            buttons:{
                                ya : {
                                    label: "OK",
                                    className: "btn-warning"
                                }
                            }
                        });
        }
        else
        {
            $('#perpanjanganTananan').submit();
        }
    });    
    //Begin CMS_PIDUM_SPDP_48 Etrio Widodo
        // $('#m_tersangka').on('hidden.bs.modal', function () {
        //     $("#m_tersangka").css('overflow','hidden');
        //     $("body").css('overflow-y','scroll');
        //     localStorage.clear();
        // });
        // $('#m_tersangka').on('show.bs.modal', function () {
        //     $("#m_tersangka").css('overflow','scroll');
        //     $("body").css('overflow-y','hidden');            
        // });


//End  CMS_PIDUM_SPDP_48 Etrio Widodo
	
	$('.tambah_calon_tersangka').click(function(e){
		
		localStorage.clear();
		var href = $(this).attr('href');
		if(href != null){
			var id_tersangka = href.substring(1, href.length);
		}else{
			var id_tersangka = '';
		}
		
			$('#m_tersangka').html('');
			$('#m_tersangka').load('/pidum/pdm-perpanjangan-tahanan/show-tersangka?id_tersangka='+id_tersangka);
			$('#m_tersangka').modal('show');
        
    });

	$('.tombol_tambah_calon_tersangka').click(function(e){
		
		localStorage.clear();
		var href = $(this).attr('href');
		if(href != null){
			var id_tersangka = href.substring(1, href.length);
		}else{
			var id_tersangka = '';
		}
		var rowCount = $('#table_tersangka tr').length;
		if(rowCount >1){
			 bootbox.dialog({
                                    message: "Hanya Bisa 1 Tersangka",
                                    buttons:{
                                        ya : {
                                            label: "OK",
                                            className: "btn-warning"
                                        }
                                    }
                                });
		}else{
			$('#m_tersangka').html('');
			$('#m_tersangka').load('/pidum/pdm-perpanjangan-tahanan/show-tersangka?id_tersangka='+id_tersangka);
			$('#m_tersangka').modal('show');
        }
    });

    $('#tersangkaFromSpdp').click(function(){
            $('#m_tersangka').html('');
                $('#m_tersangka2').load('/pidum/pdm-perpanjangan-tahanan/tersangka');
                $('#m_tersangka2').modal('show');
          });
		  
	$(".hapus").click(function(){
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
    });

JS;
$this->registerJs($script);
?>


<script type="text/javascript">
    

</script>