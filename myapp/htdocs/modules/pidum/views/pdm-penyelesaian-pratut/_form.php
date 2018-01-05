<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use kartik\widgets\FileInput;
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php $form = ActiveForm::begin(
    [
        'id' => 'pdm-penyelesaian-pratut-form',
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

    <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;padding:20px 0px;">
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-sm-2">Status</label>
				<div class="col-sm-3" >
					<?php echo $form->field($model, 'status')->dropDownList(['2' => 'Diversi', '3' => 'SP-3'],['prompt'=>'Pilih Status']); ?>
				</div>
				<div id="div_sikapjaksa">
					<label class="control-label col-sm-2">Sikap Jaksa</label>
					<div class="col-sm-3" >
						<?= $form->field($model, 'sikap_jpu')->radioList(['1' => 'Tepat', '2' => 'Tidak Tepat'],['inline'=>true])->label(false) ?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12" id="div_nomor_tanggal">
			<div class="form-group">
				<label class="control-label col-sm-2">Nomor</label>
				<div class="col-sm-3" >
					<?= $form->field($model, 'nomor')->input('text',
                                ['oninput'  =>'
										var number =  /^[A-Za-z0-9-/]+$/;
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
				<div>
					<label class="control-label col-sm-2">Tanggal</label>
					<div class="col-sm-2" style="width:12%" >
						 <?=
							$form->field($model, 'tgl_surat')->widget(DateControl::className(), [
								'type' => DateControl::FORMAT_DATE,
								'ajaxConversion' => false,
								'options' => [
									'options' => [
										'placeholder' => 'DD-MM-YYYY',//dikeluarkan jadi surat
									],
									'pluginOptions' => [
										'autoclose' => true,
                                        'startDate' => $_SESSION['tgl_perkara'],
                                        'endDate'   => date('d-m-Y') ,
									]
								]
							]);
						?>
					</div>
				</div>
			</div>
		</div>
		
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
                                'browseLabel'=>'Unggah...',
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
	
	 <div class="box-footer" style="text-align: center;">
        <?= $this->render('//default/_formFooterButton', ['model' => $model]) ?>
    </div>


    <?php ActiveForm::end(); ?>
	</div>
</section>
<?php
$script = <<< JS



$('#div_sikapjaksa').hide();
$('#div_nomor_tanggal').hide();

$('#pdmpenyelesaianpratut-status').on('change', function(){
	if(this.value=='3'){
		$('#div_sikapjaksa').show();
	}else{
		$('#div_sikapjaksa').hide();
	}
});	

JS;

$this->registerJs($script);

?>
