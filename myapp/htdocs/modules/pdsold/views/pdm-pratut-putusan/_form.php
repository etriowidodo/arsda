<?php

use yii\helpers\Html;
use kartik\builder\Form;
use kartik\widgets\ActiveForm;
use kartik\select2\Select2Asset;
use kartik\datecontrol\DateControl;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPratutPutusan */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
        $form = ActiveForm ::begin(
                        [
                            'id' => 'pdm-pratut-putusan-form',
                            'type' => ActiveForm::TYPE_HORIZONTAL,
                            'enableAjaxValidation' => false,
                            'fieldConfig' => [
                                'autoPlaceholder' => false
                            ],
                            'formConfig' => [
                                'deviceSize' => ActiveForm::SIZE_SMALL,
                                'labelSpan' => 1,
                                'showLabels' => false
                            ]
        ]);
        ?>

        <div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
            
            <div class="form-group">
                <label class="control-label col-md-2">Status</label>
                <div class="col-md-4">
				<?php if(!$model->isNewRecord) {?>
                    <?php
                        echo $form->field($model, 'is_proses')->dropDownList(
                            ArrayHelper::map($pengadilan, 'id', 'keterangan'), 
                            ['prompt' => '--Pilih status--', 'id' => 'status_penyelesaian'], 
                            ['label' => '']
                        );       

                    ?>
                </div>
            </div>

            <div class="form-group hide" id="pelimpahan_kpd">
                <label class="control-label col-md-2">Wilayah Pelimpahan</label>
                <div class="col-md-4">
			
                    <input type="text" id="satker_pelimpahan" name="PdmSpdp[id_satker_tujuan]" value="<?php echo $modelSpdp->id_satker_tujuan; ?>">
		
                </div>
					   <input type="hidden" id="satker_pelimpahan" name="idberkas" value="<?php echo $_GET['id_berkas']; ?>">

					   <input type="hidden"  id="satker" name="idberkas2" value="<?php echo $satker ?>">
				</div>
					 <input type="hidden" id="satker_pelimpahan2" name="PdmSpdp[id_satker_tujuan]" value="<?php echo $modelSpdp->id_satker_tujuan; ?>">
				   <input type="hidden"  id="satker" name="satker" value="<?php echo $satker ?>">
		
            <div class="form-group hide" id="no_tgl">
		
                <label class="control-label col-md-2">Nomor</label>
                <div class="col-md-4">
                    <?= $form->field($model, 'no_surat')->textInput(['id' => 'no_penyelesaian']) ?>
                </div>
                 <label class="control-label col-md-1">Tanggal</label>
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'id' => 'tgl_penyelesaian',
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
				<?php } else {?>
				
				<?php
                        echo '<select id="status_penyelesaian" class="form-control" name="PdmPratutPutusan[is_proses]">
<option value="">--Pilih status--</option>
<option value="1">Dilanjutkan Pentututan Ke</option>
<option value="3">Dihentikan Penyidik (SP3)</option>
<option value="2">Penyidikan Optimal</option>
</select>';
                             

                    ?>
                </div>
            </div>
			
	        <div class="form-group hide" id="pelimpahan_kpd">
                <label class="control-label col-md-2">Wilayah Pelimpahan</label>
                <div class="col-md-4">
                    <input type="hidden" id="satker_pelimpahan" name="PdmSpdp[id_satker_tujuan]" value="<?php echo $modelSpdp->id_satker_tujuan; ?>">
                </div>
				<input type="hidden"  name="idberkas2" value="<?php echo $_GET['id_berkas'] ?>">
	   <input type="hidden"  id="satker" name="satker" value="<?php echo $satker ?>">
				</div>
				 <input type="hidden" id="satker_pelimpahan2" name="PdmSpdp[id_satker_tujuan]" value="<?php echo $modelSpdp->id_satker_tujuan; ?>">
				   <input type="hidden"  id="satker" name="satker" value="<?php echo $satker ?>">
		
				 <div class="form-group hide" id="no_tgl">
			
                <label class="control-label col-md-2">Nomor</label>
                <div class="col-md-4">
                    <?= $form->field($model, 'no_surat')->textInput(['id' => 'no_penyelesaian']) ?>
                </div>
                 <label class="control-label col-md-1">Tanggal</label>
                <div class="col-md-4">
                    <?=
                    $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                        'type' => DateControl::FORMAT_DATE,
                        'ajaxConversion' => false,
                        'options' => [
                            'id' => 'tgl_penyelesaian',
                            'pluginOptions' => [
                                'autoclose' => true
                            ]
                        ]
                    ]);
                    ?>
                </div>
            </div>
				<?php }?>
        </div>
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
      </div> 
    </div>    
</section>
<?php 
if($modelSpdp->id_satker_tujuan == null){
$satkerPelimpahan = $this->context->getSatker();}else{
$satkerPelimpahan2 = $this->context->getSatker();
$satkerPelimpahan = $satkerPelimpahan2;
//print_r ($satkerPelimpahan);exit;
}

?>
<script type="text/javascript">
    var satkerPelimpahan = JSON.parse('<?php echo json_encode($satkerPelimpahan); ?>');
    console.log(satkerPelimpahan);

</script>
<?php if (!$model->isNewRecord): ?>
    <script type="text/javascript">
        var valueSatker = <?php $modelSpdp->id_satker_tujuan;?>
    </script>
<?php endif;

/*	
			$('#satker_pelimpahan').change(function(){
        $(document).ready(function(){
            var status = $('#status_penyelesaian').val();
			var satker1 =  $('#satker_pelimpahan').val();
			var satker2 = $('#satker').val();
		
	
var satker1 =  $('#satker_pelimpahan').val();
			var satker2 = $('#satker').val();
		 $('#satker_pelimpahan2').val(satker1);
	 var satker3 = $('#satker_pelimpahan2').val();

 
  alert(satker3);
            if(status == 1 && satker3 != satker2){
                $('#pelimpahan_kpd').removeClass('hide');
				$('#no_tgl').removeClass('hide');
				
			}else if(status == 1 && satker3 == satker2){
				           $('#pelimpahan_kpd').removeClass('hide');
						    $('#no_tgl').addClass('hide');
			}
			else if(status == 2 || status == 3){
                $('#no_tgl').removeClass('hide');
                $('#pelimpahan_kpd').addClass('hide');
            }else{
                $('#pelimpahan_kpd').addClass('hide');
                $('#no_tgl').addClass('hide');
            }
        });
  });
	 */ ?>
<?php
$script = <<< JS
  
        $('#status_penyelesaian, #satker_pelimpahan').change(function(){
            var val =  $('#status_penyelesaian').val();
			var satker1 =  $('#satker_pelimpahan').val();
			var satker2 = $('#satker').val();

		 $('#satker_pelimpahan2').val(satker1);
    var satker3 = $('#satker_pelimpahan2').val();

	
            if(val == 1 && satker3 != satker2){
                $('#pelimpahan_kpd').removeClass('hide');
                $('#no_tgl').removeClass('hide');
                $('#no_penyelesaian').val(''); // reset inputan no_penyelesaian
                $('#tgl_penyelesaian').val(''); // reset inputan tanggal_penyelesaian
                $('#tgl_penyelesaian-disp').val(''); // reset inputan tanggal_penyelesaian
				
            }else if(val == 1 && satker3 == satker2){
			 $('#pelimpahan_kpd').removeClass('hide');
			      $('#no_tgl').addClass('hide');
			  $('#no_penyelesaian').val(''); // reset inputan no_penyelesaian
                $('#tgl_penyelesaian').val(''); // reset inputan tanggal_penyelesaian
                $('#tgl_penyelesaian-disp').val(''); // reset inputan tanggal_penyelesaian
		
			}
			else if(val == 2 || val == 3){
                  $('#no_tgl').removeClass('hide');
                $('#pelimpahan_kpd').addClass('hide');
                $('#satker_pelimpahan').val(''); //reset inputan wilayah pelimpahan
                $('.select2-chosen').html('Pilih Wilayah Pelimpahan'); //reset inputan wilayah pelimpahan
	
            }else {
				  $('#pelimpahan_kpd').addClass('hide');
                $('#no_tgl').addClass('hide');
		
			}
        });

        $("#satker_pelimpahan").select2({
            minimumInputLength: 2,
            placeholder: 'Pilih Wilayah Pelimpahan',
            data: satkerPelimpahan,
            width: '400',
        });
JS;
$this->registerJs($script);
?>           