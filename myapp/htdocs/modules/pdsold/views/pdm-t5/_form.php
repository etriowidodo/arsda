<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */
/* @var $form yii\widgets\ActiveForm */

//jaka | 25 Mei 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#t5-form').on('afterValidate', function (event, messages) {
     
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
//END <-- CMS_PIDUM001 -->
?>


<section class="content" style="padding: 0px;">
<div class ="content-wrapper-1">


 <?php
        $form = ActiveForm::begin([
                'id' => 't5-form',
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

 
     <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>

      <div class="box box-primary" style="border-color: #f39c12">
	  <br/>
         <div class="col-md-12">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="control-label col-md-4">Penolakan Penahanan A.n. Tersangka</label>
                        <div class="col-md-4">
                            <?php
                            $nama = (new \yii\db\Query())
                                    ->select("b.id_perpanjangan,a.nama")
                                    ->from('pidum.ms_tersangka_pt a')
									->join('left join','pidum.pdm_perpanjangan_tahanan b', 'a.id_perpanjangan = b.id_perpanjangan')
									->join('left join','pidum.pdm_t4 c', 'b.id_perpanjangan = c.id_perpanjangan')
									->join('left join','pidum.pdm_t5 d', 'b.id_perpanjangan = d.id_perpanjangan')
                                    ->where("b.id_perkara='" . $id_perkara ."' AND (c.id_perpanjangan IS NULL AND d.id_perpanjangan IS NULL)")
                                    ->all();
							$filterNama = (new \yii\db\Query()) 
                                    ->select("b.id_perpanjangan,a.nama")
                                    ->from('pidum.ms_tersangka_pt a')
									->join('inner join','pidum.pdm_perpanjangan_tahanan b', 'a.id_perpanjangan = b.id_perpanjangan')
									->join('inner join','pidum.pdm_t5 c', 'b.id_perpanjangan = c.id_perpanjangan')
									->where("c.id_t5='" . $id ."'") 
                                    ->all();
						
						if($model->isNewRecord){   //jika data baru
                           $listnama = ArrayHelper::map($nama, 'id_perpanjangan','nama');							
                           echo $form->field($model, 'id_perpanjangan')->dropDownList($listnama,
						   ['prompt' => '---Pilih Tersangka---'], ['label' => '']);
						}else{	//jika data update
						   $listnama = ArrayHelper::map($filterNama, 'id_perpanjangan','nama');			
						   echo $form->field($model, 'id_perpanjangan')->dropDownList($listnama, // Flat array ('id'=>'label')
                                ['','class' => 'form-control', 'disabled' => "disabled"]);	 
                            echo '<input type="hidden" value="'.$_SESSION['tgl_selesai'].'" id="tgl_akhirPenahanan" class="form-control">';
								}								
							?>



			
                         
							
                        </div>
                  
                    </div>
                </div>
				
			</div>
			
      
        
     </div>


	<div id="hiddenId"></div>

<div class="box box-primary" style="border-color: #f39c12">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
        <div class="col-md-6" style="width:67%;">
            <h3 class="box-title" style="">ALASAN PENOLAKAN</h3>
        </div>
		 <!-- Danar Wido CMS_PIDUM043 14 July 2016 -->
	    <label class="control-label col-sm-2" style="width: 12%;">Tanggal Resume</label>
		<div class="col-sm-2" style="width:12.5%;" id="tgl_resume">               
			   <?=
                $form->field($model, 'tgl_resume')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'DD-MM-YYYY'
							
                        ],
                        'pluginOptions' => [
                            'autoclose' => true,
							'endDate' => '+30d'
                        ]
                    ]
                ]);
                ?>
		</div>
		<!-- End Danar Wido CMS_PIDUM043 14 July 2016 -->
    </div>
    
    
        <div class="box-body"> 
        <?= $form->field($model, 'alasan')->textarea(['rows' => 3]) ?>
		
		
        <?php
        // panggil Tgl SPDP						
        echo Html::textInput('tgl_spdp', date('d-m-Y', strtotime($modelSpdp->tgl_surat)), ['id' => 'spdp-tgl_surat','class' => 'form-control','type' =>'hidden']);
     
	   ?>
	  
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
                                'browseLabel'=>'Unggah T-5...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
					
                        ?>  
						
                </div>
                
            </div>
        </div>
    </div>
</div>
</div>


<div class="box box-primary" style="border-color: #f39c12">
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T5, 'id_table' => $model->id_t5]) ?>
    
</div>		
    <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
		<?php if (!$model->isNewRecord) : ?>
		 <a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-t5/cetak?id_t5='.$model->id_t5])?>">Cetak</a>
		 <?php endif ?>
        <!-- jaka | 1 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['../pdsold/pdm-t5/index'] : ['../pdsold/pdm-t5/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
		
    </div>
		
</div>		


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
            
$date_tgl_surat = date('Y-m-d');
//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
?>
<?php
$script = <<< JS
        var date        = '$modelPerpanjangan->tgl_surat';
        var someDate    = new Date(date);
        var endDate     = new Date('$date_tgl_surat');
        //someDate.setDate(someDate.getDate());
        someDate.setDate(someDate.getDate()+1);
        endDate.setDate(endDate.getDate());
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmt5-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmt5-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmt5-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmt5-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmt5-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmt5-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmt5-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmt5-tgl_dikeluarkan-disp').removeAttr('disabled');


        var date        = '$modelPerpanjangan->tgl_surat_penahanan';
        var someDate    = new Date(date);
        var endDate     = new Date('$modelPerpanjangan->tgl_surat');
        //someDate.setDate(someDate.getDate());
        someDate.setDate(someDate.getDate());
        endDate.setDate(endDate.getDate());
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmt5-tgl_resume').html();
        var datecontrol         = $('#pdmt5-tgl_resume-disp').attr('data-krajee-datecontrol');
        $('.field-pdmt5-tgl_resume').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmt5-tgl_resume','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmt5-tgl_resume-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmt5-tgl_resume-disp').datecontrol(datecontrol_001);
          $('.field-pdmt5-tgl_resume').removeClass('.has-error');
          $('#pdmt5-tgl_resume-disp').removeAttr('disabled');

	$('#popUpTersangka').click(function(){
		$('#m_tersangka').html('');
        $('#m_tersangka').load('/pdsold/pdm-t5/tersangka');
        $('#m_tersangka').modal('show');
	});
 
        $('#input_asal_surat').change(function(){
            var id_asalsurat = $(this).val();
            $.ajax({
                type: "POST",
                url: '/pdsold/spdp/penyidik',
                data: 'id_asalsurat='+id_asalsurat,
                success:function(data){
                    console.log(data);
                    $('#input_penyidik').html(data);
                }
            });
        });
		
		  $('.tambah_calon_tersangka').click(function(e){
            var href = $(this).attr('href');
			var id_tersangka =   $('#tr_id').val(); 
            if(href != null){
                var id_tersangka = href.substring(1, href.length);
            }else{
                var id_tersangka = '';
            }

            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pdsold/spdp/show-tersangka?id_tersangka='+id_tersangka);
            $('#m_tersangka').modal('show');
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
                        '<td><input type="text" name="pasal[]" class="form-control" placeholder="pasal - pasal"</td>' +
                    '</tr>'
                );
            });


   
    //BEGIN CMS_PIDUM001_   CREATED BY ETRIO WIDODO
    $(".hapus").click(function()
        {
             $.each($('input[type="checkbox"][name="tersangka[]"]'),function(x)
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
    //END CMS_PIDUM001_   CREATED BY ETRIO WIDODO 
      
       
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
