<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use kartik\widgets\FileInput;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRendak */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php 
		$form = ActiveForm::begin(
    [
        'id' => 'pdm-rendak-form',
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

        
        // echo $p21->tgl_dikeluarkan;

	?>

        <div class="box box-primary" style="border-color: #f39c12">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="col-md-12" style="padding:0">
                    <div class="col-md-6" style="width:41%;">
                        <div class="form-group">
                            <label class="control-label col-md-3" style="width:39%;" >Nomor Berkas</label>
                           <div class="col-md-8" style="width:61%;">
                               <input type="text" class="form-control" value="<?= $modelBerkas->no_berkas ?>" readonly="true">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="width:30%;">
                        <div class="form-group">
                            <label class="control-label col-md-3"  style="width:35%;">Tanggal Berkas</label>
                            <div class="col-md-4">
                                <input type="text" class="form-control" value="<?= date('d-m-Y',strtotime($modelBerkas->tgl_berkas)) ?>" readonly="true">
                            </div>
                        </div>
                    </div>
		 </div>
            </div>
        </div>
   <div class="box box-primary" style="border-color: #f39c12">
		<div class="box-header with-border" style="border-color: #c7c7c7;">
			<div class="col-md-6">
				<div class="form-group form-inline">
                <!--<label class="control-label col-md-4" style="width:22%">Upload File</label>-->
        		
				<div class="col-md-2 inline" >
				<?php
					echo $form->field($model, 'file_upload')->widget(FileInput::classname(), [
                            'options' => ['accept'=>'application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword'],
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showUpload' => false,
                                'showRemove' => false,
								'showClose' => false,
                                'showCaption'=> false,
                                'allowedFileExtension' => ['docx,doc'],
                                'browseLabel'=>'Unggah Rendak...',
                            ]
                        ]);
                        if ($model->file_upload != null || $model->file_upload != '') { 
                            echo Html::a(Html::img('/image/odt.jpg',['width'=>'30', 'style'=>'margin-left:0px;']), '/template/pidum_surat/'.$model->file_upload,['target'=>'_blank'])."&nbsp;";
                        }
				?>
				</div>
		</div>
			</div>
		</div>
		
		<div class="box-header with-border" style="border-color: #c7c7c7;">
			<div class="col-md-12">
				<?php echo $form->field($model, 'dakwaan')->textArea(['style'=>'height:200px']);  ?>
			</div>
		</div>
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
                        <label class="control-label col-md-4">Tanggal Surat</label>
                        <div class="col-md-4"  >
                            <?= $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(),[
                                                'type'=>DateControl::FORMAT_DATE,
                                                'ajaxConversion'=>false,
                                                'options' => [
                                                    'options' => ['placeholder' => 'Tanggal Dikeluarkan'],
                                                    'pluginOptions' => [
                                                        'autoclose' => true
                                                    ]
                                                ]
                                            ]); ?>
                        </div>
                    </div>
                </div>

               
            </div>
            
        </div>
		
		<?= $this->render('//default/_formFooter', ['form' => $form, 'model' => $model, 'GlobalConst' => GlobalConstMenuComponent::RencanaDakwaan, 'id_table' => $model->id_rendak]) ?>
		
	<div class="box-footer" style="text-align: center;">
       <?php if($p21->tgl_dikeluarkan!=''){?>
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
           <?php }?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-rendak/cetakblanko?id_berkas='.$model->id_berkas] ) ?>">Cetak</a>
		<?php } ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
</section>


<?php
$now = date('Y-m-d');
$script = <<< JS


$(document).ready(function(){
        var date_awal = Date.parse('$date_awal');
        var date_akhir = Date.parse('$date_akhir');
        if ('$p21->tgl_dikeluarkan'=='')
        {
         bootbox.dialog({
                message: "Anda Belum Dapat Melakukan Input Rencana Dakwaan, Karena Belum melakukan input P21",
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
            var date        = '$p21->tgl_dikeluarkan';
            // date            = date[2]+'-'+date[1]+'-'+date[0];
            console.log(date);
            var someDate    = new Date(date);
            var endDate     = new Date('$now');
            //someDate.setDate(someDate.getDate()+7);
            someDate.setDate(someDate.getDate()+1);
            endDate.setDate(endDate.getDate());
            var dateFormated        = someDate.toISOString().substr(0,10);
            var enddateFormated     = endDate.toISOString().substr(0,10);
            var resultDate          = dateFormated.split('-');
            var endresultDate       = enddateFormated.split('-');
            finaldate               = endresultDate[2]+'-'+endresultDate[1]+'-'+endresultDate[0];
            date                    = resultDate[2]+'-'+resultDate[1]+'-'+resultDate[0];
            var input               = $('#tgl_dikeluarkan').html();
            var datecontrol         = $('#pdmrendak-tgl_dikeluarkan-disp').attr('data-krajee-datecontrol');
            $('#tgl_dikeluarkan').html(input);
            var kvDatepicker_001 = {'autoclose':true,'startDate':date,'endDate':finaldate ,'format':'dd-mm-yyyy','language':'id'};
            var datecontrol_001 = {'idSave':'pdmrendak-tgl_dikeluarkan','url':'','type':'date','saveFormat':'Y-m-d','dispFormat':'d-m-Y','saveTimezone':null,'dispTimezone':null,'asyncRequest':true,'language':'id','dateSettings':{'days':['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'],'daysShort':['Mgu','Sen','Sel','Rab','Kam','Jum','Sab','Mgu'],'months':['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'],'monthsShort':['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Ags','Sep','Okt','Nov','Des'],'meridiem':['AM','PM']}}; 
              $('#pdmrendak-tgl_dikeluarkan-disp').kvDatepicker(kvDatepicker_001);
              $('#pdmrendak-tgl_dikeluarkan-disp').datecontrol(datecontrol_001);
              $('.field-pdmrendak-tgl_dikeluarkan').removeClass('.has-error');
              $('#pdmrendak-tgl_dikeluarkan-disp').removeAttr('disabled');
        }
        
    });

       
JS;
$this->registerJs($script);
?>