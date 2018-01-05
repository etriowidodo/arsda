<?php


use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use yii\widgets\MaskedInput;

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
            ]
        ]);
?>
<div class="modal-content" style="width: 780px;margin: 30px auto;">
    <div class="modal-header">
        Putusan Pengadilan Terhadap Tersangka
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
			 <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Rencana Tuntutan</label>
						<label class="control-label col-md-1"></label>
                        <div class="col-md-3">
						<?php
						echo $form->field($modelPutusan, 'id_ms_rentut')->dropDownList( $rentut,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
						?>
                        </div>
                    </div>
                </div>
            </div>
			
			<div id="div_kurungan_denda" style="display:none">
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kurungan</label>
						<label class="control-label col-md-1"></label>
                        <div class="col-md-5">
                           <?php echo $form->field($modelPutusan, 'bulan_kurung') ?>
                        </div>
						<label class="control-label col-md-2">Bulan</label>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-5">
                            <?php echo $form->field($modelPutusan, 'hari_kurung') ?>
                        </div>
						<label class="control-label col-md-2">Hari</label>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Denda</label>
						<div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">Rp</div>
                                    <?= MaskedInput::widget([
                                            'name' => 'modelPutusan[denda]',
                                            'value' => $modelPutusan->denda,
                                            'mask' => '9',
                                            'clientOptions' => [
                                                'repeat' => 10, 
                                                'greedy' => false
                                            ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-12"></div>
                                <div class="col-sm-12">
                                    <div class="help-block"></div>
                                </div>
                            </div>
						
                    </div>
                </div>
            </div>
			
			
			</div>
			
			<div id="div_penjara" style="display:none">
			<div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-12">Masa Percobaan</label>
                    </div>
                </div>
				
				<div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                           <?php echo $form->field($modelPutusan, 'tahun_coba') ?>
                        </div>
						<label class="control-label col-md-1">Tahun</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                            <?php echo $form->field($modelPutusan, 'bulan_coba') ?>
                        </div>
						<label class="control-label col-md-1">Bulan</label>
                    </div>
                </div>
				
				 <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                            <?php echo $form->field($modelPutusan, 'hari_coba') ?>
                        </div>
						<label class="control-label col-md-1">Hari</label>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-12">Pidana Badan</label>
                    </div>
                </div>
				
				<div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                           <?php echo $form->field($modelPutusan, 'tahun_badan') ?>
                        </div>
						<label class="control-label col-md-1">Tahun</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                            <?php echo $form->field($modelPutusan, 'bulan_badan') ?>
                        </div>
						<label class="control-label col-md-1">Bulan</label>
                    </div>
                </div>
				
				 <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                            <?php echo $form->field($modelPutusan, 'hari_badan') ?>
                        </div>
						<label class="control-label col-md-1">Hari</label>
                    </div>
                </div>
            </div>
			
			
			
			<div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label col-md-12">Subsidair</label>
                    </div>
                </div>
				
				<div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                           <?php echo $form->field($modelPutusan, 'tahun_sidair') ?>
                        </div>
						<label class="control-label col-md-1">Tahun</label>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                            <?php echo $form->field($modelPutusan, 'bulan_sidair') ?>
                        </div>
						<label class="control-label col-md-1">Bulan</label>
                    </div>
                </div>
				
				 <div class="col-md-3">
                    <div class="form-group">
                        <div class="col-md-6">
                            <?php echo $form->field($modelPutusan, 'hari_sidair') ?>
                        </div>
						<label class="control-label col-md-1">Hari</label>
                    </div>
                </div>
            </div>
			
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-6">Biaya Perkara</label>
						
						<div class="col-md-5">
                                <div class="input-group">
                                    <div class="input-group-addon">Rp</div>
                                    <?= MaskedInput::widget([
                                            'name' => 'modelPutusan[biaya_perkara]',
                                            'value' => $modelPutusan->biaya_perkara,
                                            'mask' => '9',
                                            'clientOptions' => [
                                                'repeat' => 10, 
                                                'greedy' => false
                                            ]
                                    ]);
                                    ?>
                                </div>
                                <div class="col-sm-12"></div>
                                <div class="col-sm-12">
                                    <div class="help-block"></div>
                                </div>
                            </div>
						
                    </div>
                </div>
            </div>
			
			
			
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-6">Pidana Pengawasan</label>
						
                        <div class="col-md-6">
                           <?php
						echo $form->field($modelPutusan, 'id_ms_pidanapengawasan')->dropDownList( $pengawasan,
                                                    ['prompt' => '---Pilih---'],
                                                    ['label'=>''])
						?>
                        </div>
						
                    </div>
                </div>
            </div>
			
			
			</div>
			
			<div id="div_kurungan" style="display:none">
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pidana Tambahan</label>
						<label class="control-label col-md-1"></label>
                        <div class="col-md-6">
                           <?php echo $form->field($modelPutusan, 'pidana_tambahan')->textarea(); ?>
                        </div>
						
                    </div>
                </div>
            </div>
			
			</div>
			
			<div class="row">
				 <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Sikap Jaksa</label>
						<label class="control-label col-md-1"></label>
                        <div class="col-md-6">
                           <?php  echo Yii::$app->globalfunc->returnRadioList($form,$modelPutusan, $sikap_jaksa,'id','nama','is_sikap_jaksa')   ?>
                        </div>
						
                    </div>
                </div>
			</div>
			
			<div class="row">
				 <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Sikap Tersangka</label>
						<label class="control-label col-md-1"></label>
                        <div class="col-md-6">
                           <?php  echo Yii::$app->globalfunc->returnRadioList($form,$modelPutusan, $sikap_tersangka,'id','nama','is_sikap_tersangka')   ?>
                        </div>
						
                    </div>
                </div>
			</div>
			
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $modelPutusan->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        </div>
    </div>
</div>
<?php
$script = <<< JS

$(document).ready(function(){
	var jns_hukuman = $('#pdmputusanhakim44-id_ms_rentut').val();
	if(jns_hukuman =='3'){
		$('#div_penjara').show();
	}else if(jns_hukuman =='4'){
		$('#div_kurungan_denda').show();
	}else{
	
	}
});//end documenready

$("#ubah-tersangka").click(function()
{

	$('#putusan_pasal_$id_tersangka').val('text');
	$('#m_putusantersangka').modal('hide');
});

$('#pdmputusanhakim44-id_ms_rentut').change(function () {
	if(this.value=='3'){
		$('#div_penjara').show();
		$('#div_kurungan_denda').hide();
	}else if(this.value=='4'){
		$('#div_kurungan_denda').show();
		$('#div_penjara').hide();
	}else{
		$('#div_kurungan_denda').hide();
		$('#div_penjara').hide();
	}
})
JS;
$this->registerJs($script);

ActiveForm::end();
?>
