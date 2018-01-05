<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use kartik\widgets\ActiveForm;
use app\modules\pdsold\models\PdmPenandatangan;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP21A */
/* @var $form yii\widgets\ActiveForm */

$this->registerJs(
  "$('#p21-a-form').on('afterValidate', function (event, messages) {     
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
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
	<?php 
		$form = ActiveForm::begin(		[
			'options' => ['enctype' => 'multipart/form-data'],
            'id' => 'p21-a-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder'=>false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 1,
                'showLabels'=>false
            ]
       ]);
	?>
	<?php
	$_SESSION['tgl_ba']='';
	$_SESSION['tgl_p23']='';	
	$_SESSION['tgl_p21']=$modelP21->tgl_dikeluarkan;
    $date_awal  = date('Y-m-d');

    $date_akhir = date_create((date('Y-m-d',strtotime($modelP21->tgl_dikeluarkan))));
    date_add($date_akhir, date_interval_create_from_date_string('30 days'));
    $date_akhir = $date_akhir->format('Y-m-d');

    // echo $date_awal.'-'.$date_akhir ;
    // echo ( $date_awal<$date_akhir)?"TRUE":"FALSE";
	 ?>
		 <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
         <div class="col-md-12" style="padding:0">
		 <div class="col-md-8" >
                <div class="form-group">
                    <label class="control-label col-md-3" style="width:23%;" >Nomor P-21</label>

                   <div class="col-md-8" style="width:40%;">
               <input type="text" class="form-control" value="<?= $modelP21->no_surat ?>" readonly="true">
            </div>
				</div>
					</div>
					
					 <div class="col-md-4">
                <div class="form-group">
                    <label class="control-label col-md-3"  style="width:47%;">Tanggal</label>

                   <div class="col-md-4" style="width:32%;">
               <input type="text" class="form-control" value="<?= date('d-m-Y',strtotime($modelP21->tgl_dikeluarkan)) ?>" readonly="true">
            </div>
				</div>
					</div>
					
		 </div>

	 </div>
		  <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
         
		
		 <p><h4>Tersangka</h4><p>
		  <?= GridView::widget([
	   'dataProvider' => $dataProvider,
       // 'filterModel' => $searchModel,
	   'rowOptions'   => function ($model, $key, $index, $grid) {
	
            return ['data-id' => $model['id_tersangka']];	
        },
        'columns' => [
          
		   [
                'attribute'=>'namaTersangka',
                'label' => 'Nama',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[namaTersangka]);

                },

            ],
		   [
                'attribute'=>'tgl_lahir',
                'label' => 'Tanggal Lahir',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return (date('d-m-Y',strtotime($model[tgl_lahir]))) ;
		

                },

            ],
			 [
                'attribute'=>'umur',
                'label' => 'Umur',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[umur]);

                },

            ],
			 [
                'attribute'=>'nama',
                'label' => 'Jenis Kelamin',
                'format' => 'raw',
                'value'=>function ($model, $key, $index, $widget) {
			
				return ($model[nama]);

                },

            ],
			
        ],
		     'export' => false,
        'pjax' => true,
        'responsive'=>true,
        'hover'=>true,
		
    ]); ?>

	 </div>
		<?= $this->render('//default/_formHeader3', ['form' => $form, 'model' => $model]) ?>
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
                                'browseLabel'=>'Unggah P21A ...',
                            ]
                        ]); 
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/pdf.png',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pdsold_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        } ?>
		</div>
		</div>
		
         <div class="box box-primary" style="border-color: #f39c12">
    <?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::P21A, 'id_table' => $model->id_p21a]) ?>
    </div>
     </div>


    <div class="box-footer" style="text-align: center;">
       <?php 
       
		$tgl_diterima = date_create($modelP21->tgl_dikeluarkan);
		$tgl_hari_ini = date_create(date('Y-m-d'));
		$diff=date_diff($tgl_diterima,$tgl_hari_ini);
		$cek_tanggal = $diff->format("%a");
		if($date_awal >= $date_akhir){
            ?>
		
		<?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>			
		<?php if(!$model->isNewRecord){ ?>
		<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p21-a/cetak?id_pengantar='.$_GET['id_pengantar'].'&idp21a='.$_GET['idp21a']])?>">Cetak</a>
			<button id='hapus' type="button" class="btn btn-danger" >Hapus</button>
		<?php } ?>
        <!-- jaka | 24 Juni 2016| CMS_PIDUM001_16 #tambah tombol batal -->
        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pdsold/pdm-p21-a/index'], ['class' => 'btn btn-danger']) ?>
        <!-- END CMS_PIDUM001_16 --> 
		 <?php }?>

    </div>
 <?php ActiveForm::end(); ?>
	</div>
	</section>
	<input id="tmp_id" type="hidden" value="<?php echo $model['id_pengantar']; ?>">
<?php
$script = <<< JS
       $('.summary').remove();
	   $(document).ready(function(){
		var date_awal = Date.parse('$date_awal');
        var date_akhir = Date.parse('$date_akhir');
        console.log((date_awal>date_akhir)?"TRUE":"FALSE");
        // console.log(date_akhir);
		if (date_awal < date_akhir)
		{
		 bootbox.dialog({
                message: "Anda Belum Dapat Melakukan Input P21A, Karena Tanggal Belum Melebihi 30 Hari Dari Tanggal P21",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}
	});
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
                                     url        :  '/pdsold/pdm-p21-a/hapus',
                                     data       : 'hapusIndex='+$('#tmp_id').val(),              
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
                        }
                    }
                }
            });
                
        });


        var date        = '$modelP21->tgl_dikeluarkan';
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
        var input               = $('#tgl_dikeluarkan_p21').html();
        var datecontrol         = $('#pdmp21a-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
        $('#tgl_dikeluarkan_p21').html(input);
        var kvDatepicker_001 = {'autoclose':true,'startDate':finaldate ,'format':'dd-mm-yyyy','language':'id'};
        var datecontrol_001 = {'idSave':'pdmp21a-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
          $('#pdmp21a-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
          $('#pdmp21a-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
          $('.field-pdmp21a-tgl_dikeluarkan').removeClass('.has-error');
          $('#pdmp21a-tgl_dikeluarkan-disp').removeAttr('disabled');
JS;
$this->registerJs($script);
?>
       