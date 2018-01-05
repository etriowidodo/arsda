<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmPenandatangan;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use kartik\widgets\FileInput;

//jaka | 15 Juni 2016/CMS_PIDUM001_10 #setfocus
$this->registerJs(
  "$('#p17-form').on('afterValidate', function (event, messages) {
     
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
<div class="box box-primary">
    <div class="box-header"></div>
	
<?php
$form = ActiveForm::begin(
    [
        'id' => 'p17-form',
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
	//Danar Wido Create session tgl terima Spdp :15/06/2016
	$_SESSION['tgl_terima'] = date('d-m-Y', strtotime($modelSpdp->tgl_terima)) ;
	//End Danar
?>
    <div class="box-body">
        <?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model, 'id_p17'=>'1']) ?>
        
        <div class="box box-primary" style="border-color: #f39c12;">
			<div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
					Undang-Undang dan Pasal
                </h3>
            </div>
		<div class="box-header with-border">
            
			<textarea id="pdmspdp-undang_pasal" class="form-control" readonly><?=$modelSpdp->undang_pasal?></textarea>
        </div>
        </div>
		
        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">
                   Tersangka

                </h3>
            </div>
            <div class="box-header with-border">
                  <table id="table_grid_tersangka" class="table table-bordered table-striped">
                    <thead>
                            <th style="text-align:center;width:60px;">#</th>
                            <th>NAMA</th>
                            <th>Tanggal Lahir</th>
							<th>Umur</th>
                            <th>Jenis Kelamin</th>
                            
                        </tr>
                    </thead>
                    <tbody id="tbody_grid_tersangka">
                         <?php $i=1; foreach ($dataProviderTersangka as $key => $value): ?>
                                <tr>
									<td><?=$i?></td>
									<td><?=$value['nama']?></td>
									<td><?=$value['tgl_lahir']?></td>
									<td><?=$value['umur']." Tahun"?></td>
									<td><?=$value['jns_kelamin']?></td>
                                </tr>
                            <?php $i++;endforeach; ?>
                        <?php //endif; ?>
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
                                'browseLabel'=>'Unggah P-17...',
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


        <div class="box box-primary" style="border-color: #f39c12"><!-- tambah div class box primary untuk tampilan-->
        <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P17, 'id_table' => $model->id_p17]) ?>
        </div>
        
		<hr>
		<div class="box-footer" style="text-align: center;">
			<?php 
			$tgl_diterima_spdp = date_create($modelSpdp->tgl_terima);
			$tgl_hari_ini = date_create(date('Y-m-d'));
			$diff=date_diff($tgl_diterima_spdp,$tgl_hari_ini);
			$cek_tanggal = $diff->format("%a");
			?>
			<?php if($cek_tanggal >= 3){ ?>
				<?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
			<?php } ?>
			<?php if(!$model->isNewRecord): ?>
				<a class="btn btn-warning" href="<?= Url::to(['pdm-p17/cetak?id=' . $model->id_p17]) ?>">Cetak</a>
                <?= Html::a('Hapus', Url::to(['pdm-p17/delete-it', 'id' => $model->id_p17]), ['class'=>'btn btn-danger','data-method' => 'POST']) ?>
			<?php endif ?>
			
			<?= Html::a('Batal', $model->isNewRecord ? ['../pidum/spdp/index'] : ['../pidum/spdp/index'], ['class' => 'btn btn-danger']) ?>
			
		</div>
    </div>
	 
    <div></div>
        <?php ActiveForm::end(); ?>
	</div>
<input id="tmp_id" type="hidden" value="<?php echo $model['id_perkara']; ?>">

<?php
$id_p17 = $model['id_perkara'];
//echo $id_p17;
$script = <<< JS

	$(document).ready(function(){
		

		if ($cek_tanggal <= 3 )
		{
		 bootbox.dialog({
                message: "Belum Bisa Input P-17 Karena Tgl. P17 > Tgl. Diterima SPDP + 30Hari Sesuai Perja 036-Bab V Bagian Pasal 4 Pasal 12(1) ",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
	});
        var n=1;
            $('.tambah-tembusan').click(function(){
                $('.tembusan').append(
               '<input type="text" class="form-control" style="margin-left:180px" id="field_'+n+'" name="mytext[]"><br />'
                )
                n=n+$('.tembusan').length;

            });
        //BEGIN ETRIO WIDODO
        $('#hapus').click(function(){
             bootbox.dialog({
                message: "Apakah anda ingin menghapus data ini?",
                buttons:{
                    ya : {
                        label: "Ya",
                        className: "btn-warning",
                        callback: function(){
                           $.ajax({
                                     type       : 'POST',
                                     url        :  '/pidum/pdm-p17/delete-it',
                                     data       : 'delete='+$('#tmp_id').val(),             
                                     success    : function(data)
                                                {
                                                    location.reload();
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
                
        });
        //END ETRIO WIDODO

        var date        = '$modelSpdp->tgl_terima';
        // date            = date[2]+'-'+date[1]+'-'+date[0];
        console.log(date);
        var someDate    = new Date(date);
        var endDate     = new Date(date);
        //someDate.setDate(someDate.getDate()+7);
        someDate.setDate(someDate.getDate()+1);
        endDate.setDate(endDate.getDate()+30);
        var dateFormated        = someDate.toISOString().substr(0,10);
        var enddateFormated     = endDate.toISOString().substr(0,10);
        var resultDate          = dateFormated.split('-');
        var endresultDate       = enddateFormated.split('-');
        finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
        date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
        var input               = $('.field-pdmp17-tgl_dikeluarkan').html();
        var datecontrol         = $('#pdmp17-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('.field-pdmp17-tgl_dikeluarkan').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':finaldate ,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp17-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp17-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp17-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp17-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp17-tgl_dikeluarkan-disp').removeAttr('disabled');
            
JS;
$this->registerJs($script);
?>
<br>
