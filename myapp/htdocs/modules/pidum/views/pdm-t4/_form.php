<?php
use app\assets\AppAsset;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\MsLoktahanan;
use app\modules\pidum\models\PdmTahananPenyidik;
use dosamigos\ckeditor\CKEditor;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\Modal;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT4 */
/* @var $form yii\widgets\ActiveForm */

//jaka | 27 Mei 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#t4-form').on('afterValidate', function (event, messages) {
     
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
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm::begin(
                        [
                            'id' => 't4-form',
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
                <div class="col-md-6 hide">
                    <label class="control-label col-md-4">Wilayah Kerja</label>
                    <div class="col-md-8">
                        <input class="form-control" readonly="true" value="<?php echo \Yii::$app->globalfunc->getNamaSatker($modelSpdp->wilayah_kerja)->inst_nama ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <label class="control-label col-md-4">Nomor Surat</label><!-- Jaka|02-06-2016|menambahkan label pada nomor menjadi nomor surat -->
                    <div class="col-md-8">
                        <?= $form->field($model, 'no_surat')->input('text',
                                ['oninput'  =>'
                                        var number =  /^[A-Za-z0-9-/:.]+$/;
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
        </div>

        <div class="box box-primary hide" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">
                <div class="box-header with-border">
                    <h5 class="box-title">Pertimbangan</h5>
                </div><br>
                <div class="col-md-12">
                    <label class="control-label col-md-2">Perkara</label>
                    <div class="col-md-10">
                        <?= $form->field($modelSpdp, 'ket_kasus')->textArea(['maxlength' => true, 'rows' => 4, 'readonly' => true]) ?>
                    </div>
                </div>
                 
            </div>
        </div>


       
		
		
		<?php 
		$display = $model->isNewRecord ? 'display:none' :'';
		?>
		
		<div class="box box-primary" id="div_riwayat_tahanan_div" style="border-color: #f39c12;" >
           
           
            <div class="box-header with-border">
			
			<div class="col-md-12">
                <div class="col-md-10">
                    <div class="form-group">
                        <label class="control-label col-md-4">Perpanjangan Penahanan A.n. Tersangka</label><!-- CMS_PIDUM003_6 | JAKA | merubah jadi satu baris-->
                        <div class="col-md-4">
                            <?php
                            $nama = (new \yii\db\Query())
                                    ->select("b.id_perpanjangan,a.nama")
                                    ->from('pidum.ms_tersangka_pt a')
                                    ->join('left join','pidum.pdm_perpanjangan_tahanan b', 'a.id_perpanjangan = b.id_perpanjangan and a.no_surat_penahanan=b.no_surat_penahanan')
                                    ->join('left join','pidum.pdm_t4 c', 'b.id_perpanjangan = c.id_perpanjangan and a.no_surat_penahanan=c.no_surat_penahanan')
                                    ->join('left join','pidum.pdm_t5 d', 'b.id_perpanjangan = d.id_perpanjangan and a.no_surat_penahanan=d.no_surat_penahanan')
                                    ->where("b.id_perkara='" . $id ."' AND (c.id_perpanjangan IS NULL AND d.id_perpanjangan IS NULL)")
                                    ->all();
							$filterNama = (new \yii\db\Query()) // menampilkan tersangka yg sudah di proses di T-4
                                    ->select("b.id_perpanjangan,a.nama")
                                    ->from('pidum.ms_tersangka_pt a')
                                    ->join('inner join','pidum.pdm_perpanjangan_tahanan b', 'a.id_perpanjangan = b.id_perpanjangan')
                                    ->join('inner join','pidum.pdm_t4 c', 'b.id_perpanjangan = c.id_perpanjangan and a.no_surat_penahanan=c.no_surat_penahanan')
                                    ->where("c.id_t4='" . $id ."'") 
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
                
				<div class="col-md-12" style="padding:0px;">
				
				 <div class="well well-sm col-md-12 " style="background-color:#fcbd3e">
                    <div class="form-inline col-md-12" style="padding:0;">
						<div class="col-md-2" style="font-size:16px;padding-left:0;">
                            
                        </div>
                        <div class="col-md-3" style="font-size:16px;padding-left:0;">
                            Jenis Penahanan
                        </div>
						<div class="col-md-3" >
                            Lokasi  
                        </div>
                        <div class="col-md-4" >
                            Masa Penahanan   
                        </div>
                        
                    </div>
                </div>
              
                <div class="well well-sm col-md-12 ">
                    <div class="form-inline col-md-12" style="padding:0;">
						<div class="col-md-2" style="font-size:16px;padding-left:0;">
                            Riwayat
                        </div>
                        <div class="col-md-3" style="font-size:16px;padding-left:0;" >
                           <input type="text" class="form-control" readOnly id="txt_jenis_penahanan" value="<?=$riwayat_tahanan['jenis_penahanan']?>" />
                        </div>
						
						<div class="col-md-3" style="font-size:16px; ">
                            <input type="text" maxlength="256" style="width:100%;" class="form-control" value="<?=$riwayat_tahanan['lokasi']?>"  readOnly id="txt_lokasi_penahanan"  />
                        </div>
						
						
						<div class="col-md-4">
						<div class="form-group">
							<div class="col-md-5" style="font-size:16px;">
								<input type="text" class="form-control" readOnly id="txt_tgl_awal" style="width:120px" value="<?=$riwayat_tahanan['tgl_awal']?>" />
							</div>
							<label class="control-label col-md-1"> s/d</label>
							 <div class="col-md-3" style="font-size:16px;">
							   <input type="text" class="form-control" style="width:120px" readOnly id="txt_tgl_akhir" value="<?=$riwayat_tahanan['tgl_akhir']?>" />
                               <input type="hidden" class="form-control" style="width:120px" readOnly id="txt_tgl_surat" value="<?=$riwayat_tahanan['tgl_surat']?>" />
							</div>
						</div>
						</div>
						
                        
                    </div>
                </div>   
				
                <div class="well well-sm col-md-12 ">
                    <div class="form-inline col-md-12" style="padding:0;">
                        <div class="col-md-2" style="font-size:16px;padding-left:0;">
                            Perpanjangan
                        </div>		
                        <div class="col-md-2" style="font-size:16px;padding-left:0;" >
                            <?php
                             //echo Yii::$app->globalfunc->returnDropDownList($form, $model, MsLoktahanan::find()->where('id_loktahanan<>4')->all(), 'id_loktahanan', 'nama', 'id_loktahanan') ;
                             ?>
                            <input type="text" class="form-control" readOnly id="pdmt4-id_loktahanan1" value="<?=$jenis_penahanan?>" />
                            <input type="hidden" class="form-control" readOnly id="pdmt4-id_loktahanan" name="PdmT4[id_loktahanan]" value="<?//$riwayat_tahanan['jenis_penahanan']?>" />
                        </div>
                        <div class="col-md-3" style="font-size:16px; ">
                            <?= $form->field($model, 'lokasi')->textInput(['maxlength' => true,'style'=>"width:100%", 'readonly' => "readonly"]) ?> 
                        </div>			
                        <div class="col-md-1">
                            <input id='count_hari' value="<?php 
                            if(!$model->isNewRecord)
                            {
                               $start_date = new DateTime($model['tgl_mulai']);
                                $end_date = new DateTime($model['tgl_selesai']);
                                $interval = $start_date->diff($end_date);
                                echo $interval->days + 1; // hasil : 217 hari 
                            }?>" 
                            type='text' class='col-md-12' style="margin-right: 5px;padding-right: 0px;padding-left: 1px;" disabled="disabled">
                        </div>
                        <div class="col-md-4">
                            <div class="col-md-2">
                                <label >  Hari </label>
                            </div>
                            <div class="col-md-5">
                                <?php //$form->field($model, 'tgl_mulai')->textInput(['maxlength' => true,'style'=>"width:100%", 'disabled' => "disabled"]) 
                                    echo $form->field($model, 'tgl_mulai')->widget(DateControl::classname(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'endDate'=>date('d-m-Y'),
                                            ],
                                            'options'=>[
                                            'placeholder'=>'DD-MM-YYYY',
                                             'disabled' => "disabled",
                                            'style'=>'width:120px'
                                            ]
                                        ]
                                    ]);
                                ?> 
                            </div>
                            <div class="col-md-5">
                                <?php //$form->field($model, 'tgl_selesai')->textInput(['maxlength' => true,'style'=>"width:100%", 'disabled' => "disabled"]) 
                                    echo $form->field($model, 'tgl_selesai')->widget(DateControl::classname(), [
                                        'type' => DateControl::FORMAT_DATE,
                                        'ajaxConversion' => false,
                                        'options' => [
                                            'pluginOptions' => [
                                                'autoclose' => true,
                                                'endDate'=>date('d-m-Y'),
                                            ],
                                            'options'=>[
                                            'placeholder'=>'DD-MM-YYYY',
                                             'disabled' => "disabled",
                                            'style'=>'width:120px'
                                            ]
                                        ]
                                    ]);
                                ?> 
                            </div>
                        </div>
                            
                            <!--<div class="form-group">-->
                                <!--<div class="col-md-4" id="tgl_diterima_tersangka_xx" style="font-size:16px;">-->
                                
                                <?php
//                                if(!$model->isNewRecord){
//                                        $cek = false;
//                                }else{
//                                        $cek = true;
//                                }
//                            echo $form->field($model, 'tgl_mulai')->widget(DateControl::classname(), [
//                                'type' => DateControl::FORMAT_DATE,
//                                'ajaxConversion' => false,
//                                'options' => [
//                                    'pluginOptions' => [
//                                        'autoclose' => true,
//                                        'endDate'=>date('d-m-Y'),
//                                    ],
//                                    'options'=>[
//                                    'placeholder'=>'DD-MM-YYYY',
//                                     'disabled'   => true,
//                                    'style'=>'width:120px'
//                                    ]
//                                ]
//                            ]);
							
                                ?>
                                <!--</div>--> 	
<!--                                <div class="col-md-4" id="tgl_diterima_tersangka_xx" style="font-size:16px;">
                                    <? //$form->field($model, 'tgl_selesai')->textInput(['maxlength' => true,'style'=>"width:100%"]) ?> 
                                </div>-->
                            <!--</div>-->
                        
                    </div>
                </div> 
				
            </div>
             
            </div>
        </div>
         <div class="col-md-3" style="font-size:16px;">
                               <?php
                           // echo $form->field($model, 'tgl_selesai')->widget(DateControl::classname(), [
//                                'type' => DateControl::FORMAT_DATE,
//                                'ajaxConversion' => false,
//                                'options' => [
//                                    'pluginOptions' => [
//                                        'autoclose' => true,
//                                        'startDate' => date('d-m-Y'),
//                                        'endDate' => '+40d'
//                                    ],
//                                    'options'=>[
//                                    'placeholder'=>'DD-MM-YYYY',
//                                    'disabled'   =>FALSE,
//                                    'style'=>'width:120px',
//                                    'class' => 'hide'
//                                    ]
//                                ]
//                            ]);
                            ?>
                            </div>
        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            <div class="col-md-12">

                <div class="col-md-6">

                    <div class="form-group">
                        <label class="control-label col-md-4">Dikeluarkan</label>
                        <div class="col-md-8">
                             <?php 
                                if ($model->isNewRecord){
                                    echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]) ;
                                }else{
                                    echo $form->field($model, 'dikeluarkan'); 
                                } 
                                ?>
                            
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Tanggal Ditanda tangani</label>
                        <div class="col-md-4"  id="tgl_dikeluarkan">
                            <?=
                            $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true,
										//'startDate' => date('d-m-Y', strtotime($model->tgl_mulai)),
                                        'endDate' => date('d-m-Y')
                                    ],
                                    'options'=>[
                                    'style'=>'width:75%',
                                    'placeholder'=>'DD-MM-YYYY'// jaka | tambah placeholder
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
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
                                'browseLabel'=>'Unggah T-4...',
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

        <div class="box box-primary" style="border-color: #f39c12">
            <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::T4, 'id_table' => $model->id_t4]) ?>
        </div>
         <?= Html::textInput('perkara', $id, ['id' => 'perkara', 'type' => 'hidden']) ?>
        <?= Html::textInput('id_t4', $model->id_t4, ['id' => 'id_t4', 'type' => 'hidden']) ?>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer">
            <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
            
            <?php
            if (!$model->isNewRecord) {
                ?>
				
				<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-t4/cetak?id_t4='.$model->id_t4])?>">Cetak</a>
				<?php
            }
            ?>
             <!-- jaka | 27 mei 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/pdm-t4/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
        </div>
    </div>

</section>
<?php ActiveForm::end(); ?>

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
            

//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
?>
<?php
$script = <<< JS

		
// Etrio Widodo
 $('#pdmt4-id_perpanjangan').change(function(e){
  if ($('#pdmt4-id_perpanjangan').val() !='')
  {
 var id_perpanjangan = $(this).val();
            $.ajax({    
                type: "POST",
				dataType: "json",
                url: '/pidum/pdm-t4/riwayattahanan',
                data: 'id_perpanjangan='+id_perpanjangan,
                success:function(data){
					$("#pdmt4-tgl_mulai-disp").kvDatepicker("setStartDate", data.tgl_akhir);	   console.log(data);                    
                    $('#pdmt4-tgl_mulai-disp').removeAttr('disabled');
					$('.field-pdmt4-tgl_mulai').removeClass('.has-error');
                    $('#txt_jenis_penahanan').val(data.jenis_penahanan);
                    $('#txt_lokasi_penahanan').val(data.lokasi);
                    $('#count_hari').val(data.persetujuan);
                    $('#count_hari').val(data.persetujuan);
                    $('#count_hari').val(data.persetujuan);
                    $('#txt_tgl_awal').val(data.tgl_awal);
                    $('#txt_tgl_akhir').val(data.tgl_akhir);
                    $('#pdmt4-tgl_mulai-disp').val(data.tgl_mulai_permintaan_disp);
                    $('#pdmt4-tgl_mulai').val(data.tgl_mulai_permintaan);
                    $('#pdmt4-tgl_selesai-disp').val(data.tgl_selesai_permintaan_disp);
                    $('#pdmt4-tgl_selesai').val(data.tgl_selesai_permintaan);
                    $('#pdmt4-id_loktahanan1').val(data.jenis_penahanan);
                    $('#pdmt4-id_loktahanan').val(data.id_riwayat_tahanan);
//                    $('#pdmt4-id_loktahanan option[value="'+data.id_riwayat_tahanan+'"]').attr('selected','selected');
                    //$('#pdmt4-id_loktahanan').attr('readonly','readonly');
                    $('#pdmt4-lokasi').val(data.lokasi);
                    $('#pdmt4-lokasi').attr('readonly','readonly');
                }
            });	
			
  }
  

 
 });


 $('#pdmt4-tgl_mulai-disp').on('change',function(){
    var date        = $(this).val().split('-');
    date            = date[2]+'-'+date[1]+'-'+date[0];
    console.log(date);
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
    var input               = $('#tgl_dikeluarkan').html();
    var datecontrol         = $('#pdmt4-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
    $('#tgl_dikeluarkan').html(input);
    var kvDatepicker_001 = {'autoclose':true,'endDate':date,'format':'dd-mm-yyyy','language':'id'};
    var datecontrol_001 = {'idSave':'pdmt4-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
      $('#pdmt4-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
      $('#pdmt4-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
      $('.field-pdmt4-tgl_dikeluarkan').removeClass('.has-error');
      $('#pdmt4-tgl_dikeluarkan-disp').removeAttr('disabled');
  });


      //BEGIN CMS_PIDUM004_55 ETRIOWIDODO
      $('#pdmperpanjangantahanan-no_surat').parent().parent().parent().parent().hide();
      //END CMS_PIDUM004_55 ETRIOWIDODO

      //BEGIN CMS_PIDUMT4_08 ETRIOWIDODO
      $('input[type="radio"]').click(function(){
        var value       = $(this).val();
        var tgl_selesai = $('#pdmt4-tgl_mulai-disp').val();
        var radio       = $(this);  
        if(value==0)
        {
            $('#pdmt4-tgl_selesai-disp').removeAttr('disabled');
        }else
        {
            if(tgl_selesai=='')
            {
                alert('Tidak bisa tercentang : --Isi terlebih dahulu Tanggal Mulai--');
                $('#pdmt4-tgl_mulai-disp').focus();
                $(this).prop('checked',false);
                $('#cektanggal0').prop('checked',true);
            }
            else
            {
                if(value==1)
                {
                   $('#pdmt4-tgl_selesai-disp').attr('disabled','disabled');
                   
                }
                if(value==2)
                {
                   $('#pdmt4-tgl_selesai-disp').attr('disabled','disabled');
                   
                }
                if(value==3)
                {
                   $('#pdmt4-tgl_selesai-disp').attr('disabled','disabled');
                   
                }
                
            }
        }        
      });
      function count_date(range)
      {
         var range = parseInt(range);
         var start_date = $('#pdmt4-tgl_mulai-disp').val().split('-');
                var start_date = start_date[2]+"-"+start_date[1]+"-"+start_date[0];
                function pad(number){
                        return (number < 10) ? '0' + number : number;
                    }
                var targetDate = new Date(start_date);
                targetDate.setDate(targetDate.getDate()+range);
                var dd      = pad(targetDate.getDate());
                var mm      = pad(targetDate.getMonth()+1);
                var yyyy    = targetDate.getFullYear();
                $('#pdmt4-tgl_selesai-disp').val(dd+'-'+mm+'-'+yyyy);
                $('#pdmt4-tgl_selesai').val(yyyy+'-'+mm+'-'+dd);
      }
      //END CMS_PIDUMT4_08 ETRIOWIDODO
      $(".hapus").prop("disabled",true);
      $( document ).on('click', '.hapusTersangka', function(e) {
        
        console.log(e.target.value);
        var input = $( this );
        if(input.prop( "checked" ) == true){
            $(".hapus").prop("disabled",false);
        
            $(".hapus").click(function(){
                $("#tr_id"+e.target.value).remove();
                $('#hiddenId').append(
                    '<input type="hidden" name="MsTersangka[nama_update][]" value='+e.target.value+'>'
                )
            });  


        }

       
    });
      
  

  $('body').on('change','#pdmt4-tgl_mulai-disp',function(){
    var range = $('#count_hari').val()
    if(range>0)
    {
        count_date(range);
    }else{
        alert('hari belum terisi');
	 
	
          $('#pdmt4-tgl_selesai-disp').removeAttr('disabled');
          // $('#pdmt4-tgl_selesai-disp').attr('readonly',true);
    }


     
  });  
JS;
$this->registerJs($script);
?>