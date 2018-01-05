<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\modules\pidum\models\PdmPenandatangan;
use app\modules\pidum\models\VwTerdakwaT2;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa18 */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php 
	$form = ActiveForm::begin([
		'options' => ['enctype' => 'multipart/form-data'],
		'id' => 'pdm-t6-form',
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'enableAjaxValidation' => false,
		'fieldConfig' => [
			'autoPlaceholder' => false
		],
		'formConfig' => [
			'deviceSize' => ActiveForm::SIZE_SMALL,
			'showLabels' => false

		],
	]); 
	?>

    <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
		<div class="box-header"></div>
		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-md-2 hide">Wilayah Kejaksaan</label>
				<div class="col-md-3 hide">
					<!--<input type="text" readonly="true" class="form-control" value="<?php //echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">-->
					<?= $form->field($model, 'asal_satker')->textInput(['readonly' => true, 'maxlength' => true, 'value'=>Yii::$app->globalfunc->getSatker()->inst_nama]) ?>
				</div>
				<label class="control-label col-md-2">Tanggal Pembuatan</label>
				<div class="col-md-3">
					<?php echo $form->field($model, 'tgl_pembuatan')->widget(DateControl::className(),[
						'type'=>DateControl::FORMAT_DATE,
						'ajaxConversion'=>false,
						'options' => [
							'pluginOptions' => [
								'autoclose' => true
							],
							'options' => [
								'placeholder' => 'Tanggal Pembuatan'
							]
						]
					]); ?>

				</div>
			</div>
		</div>

		<div class="col-md-12">
			<div class="form-group">
				<label class="control-label col-md-2">Tempat / Lokasi</label>
				<div class="col-md-3">
					<?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'placeholder' => 'Tempat / Lokasi']) ?>
				</div>
			</div>
		</div>
	</div>
	
	<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
		<div class="box-header"></div>
		<div class="col-md-10">
			<div class="form-group">
			    <label class="control-label col-md-2">Nama Terpidana</label>
			    <div class="col-md-4">
			       <?php $nama_terpidana = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan])->nama;
			       if(!$model->isNewRecord){ ?>
			       	<?= $form->field($model, 'terpidana')->textInput(['readonly'=>true]);?>
			       <?php }else{ ?>
			       	<?= $form->field($model, 'terpidana')->textInput(['readonly'=>true, 'value'=>$nama_terpidana]);?>
			       <?php } ?>
			    </div>
			</div>
		</div>

		<div class="col-md-10">
			<div class="form-group">
			    <label class="control-label col-md-2">Nama Jaksa</label>
			    <div class="col-md-4">
			       <?=
			          $form->field($model, 'nama_ttd', [
			              'addon' => [
			                 'append' => [
			                    'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
			                      'asButton' => true
			                 ]
			             ]
			         ]);
			       ?>
			    </div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<a class="btn btn-primary" id="tambah-saksi">
					<i class="glyphicon glyphicon-plus">Saksi</i>
				</a>
			</div>
		<table id="table_saksi" class="table table-bordered">
            <thead>
                <tr>
                    <th>No Urut</th>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>PANGKAT</th>
                    <th>JABATAN</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbody-saksi">
                    <?php  $modelSaksi = json_decode($model->saksi);
                    	for ($i=0; $i < count($modelSaksi->no_urut); $i++) {  ?>
                        <tr data-id="saksi-<?=$modelSaksi->no_urut[$i]?>">
                        	<td><input type="text" name="saksi[no_urut][]" class="form-control" readonly="true" value="<?= $modelSaksi->no_urut[$i]?>" style="width: 50px;"></td>
                        	<td><input type="text" class="form-control" value="<?= $modelSaksi->nip[$i]?>" name="saksi[nip][]"></td>
                        	<td><input type="text" class="form-control" value="<?= $modelSaksi->nama[$i]?>" name="saksi[nama][]"></td>
                        	<td><input type="text" class="form-control" value="<?= $modelSaksi->pangkat[$i]?>" name="saksi[pangkat][]"></td>
                        	<td><input type="text" class="form-control" value="<?= $modelSaksi->jabatan[$i]?>" name="saksi[jabatan][]"></td>
                        	<td id="saksi-<?=$modelSaksi->no_urut[$i]?>"><a class="btn btn-danger delete"></a></td>
                        </tr>
                    <?php } ?>
            </tbody>
        </table>
		</div>
	</div>

	<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
	<div class="box-header"></div>
		<div class="col-md-10">
			<div class="form-group">
				<label class="control-label col-md-2">Kejaksaan</label>
				<div class="col-md-4">
					<input type="text" readonly="true" class="form-control" value="<?php echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label class="control-label col-md-2">No.SP Kepala Kejaksaan</label>
				<div class="col-md-4">
					<?= $form->field($model, 'no_sp')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label class="control-label col-md-2">Tanggal SP</label>
				<div class="col-md-3">
					<?php echo $form->field($model, 'tgl_sp')->widget(DateControl::className(),[
						'type'=>DateControl::FORMAT_DATE,
						'ajaxConversion'=>false,
						'options' => [
							'pluginOptions' => [
								'autoclose' => true
							]
						]
					]); ?>
				</div>
			</div>
		</div>
		<div class="clear-fix"></div>
	</div>
	
	<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
	<div class="box-header"></div>
	    <div class="col-md-10">
	    	<div class="form-group">
	    		<label class="control-label col-md-2">No.Visum</label>
	    		<div class="col-md-4">
	    			<?= $form->field($model, 'no_visum')->textInput(['maxlength' => true]) ?>
	    		</div>
	    	</div>
	    </div>
	    <div class="col-md-10">
	    	<div class="form-group">
	    		<label class="control-label col-md-2">Tanggal Visum</label>
	    		<div class="col-md-3">
	    			<?php echo $form->field($model, 'tgl_visum')->widget(DateControl::className(),[
	    				'type'=>DateControl::FORMAT_DATE,
	    				'ajaxConversion'=>false,
	    				'options' => [
	    					'pluginOptions' => [
	    						'autoclose' => true
	    					]
	    				]
	    			]); ?>
	    		</div>
	    	</div>
	    </div>
	</div>

	<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
	<div class="box-header"></div>
	    <div class="col-md-10">
	    	<div class="form-group">
	    		<label class="control-label col-md-2">No Ijin Menteri Kehakiman</label>
	    		<div class="col-md-4">
	    			<?= $form->field($model, 'no_menteri')->textInput(['maxlength' => true]) ?>
	    		</div>
	    	</div>
	    </div>
	    <div class="col-md-10">
	    	<div class="form-group">
	    		<label class="control-label col-md-2">Tanggal Ijin</label>
	    		<div class="col-md-3">
	    			<?php echo $form->field($model, 'tgl_menteri')->widget(DateControl::className(),[
	    				'type'=>DateControl::FORMAT_DATE,
	    				'ajaxConversion'=>false,
	    				'options' => [
	    					'pluginOptions' => [
	    						'autoclose' => true
	    					]
	    				]
	    			]); ?>
	    		</div>
	    	</div>
	    </div>
	</div>



    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-ba18/cetak?no_eksekusi='.$model->no_eksekusi] ) ?>">Cetak</a>
		<?php } ?>
    </div>
        <div id="hiddenId"></div>
        <?= $form->field($model, 'id_penandatangan')->hiddenInput()?>
		<?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>
		<?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>
    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Pilih Jaksa</h7>'
]);

?>
<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>
<?php
Modal::end();
?> 

<?php
$this->registerJs($script,View::POS_BEGIN);

$this->registerJs( "

	$('body').on('click','.delete', function(){
		$(this).closest('tr').remove();
	});

	$('#tambah-saksi').on('click',function(){
		var len = $('#tbody-saksi tr').length+1;
		          $('#tbody-saksi').append(
					'<tr data-id=\"saksi-'+len+'\">'+
						'<td><input type=\"text\" name=\"saksi[no_urut][]\" class=\"form-control\" readonly=\"true\" value='+len+' style=\"width: 50px;\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[nip][]\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[nama][]\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[pangkat][]\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[jabatan][]\"></td>'+
						'<td id=\"saksi-'+len+'\"><a class=\"btn btn-danger delete\"></a></td>'+
					'</tr>');
	});

	function hapusJpuPenerima(e){
		$('#jaksaPenerima-' + e).remove();
	}


    $(document).ready(function(){
  
	

}); ", \yii\web\View::POS_END);
?>
<script>

</script>
<!-- $('#tambahBarbuk').click(function(){
         
          $('#tbody-barbuk').append(
			'<tr id=\"barbuk\">'+
				'<td><a id=\"hapus-jpu\" class=\"btn btn-danger\" onclick=\"removeRowBarang()\">Hapus</a></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"berupa[]\"></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"tindakan[]\"></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"jumlah[]\"></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"id_satuan[]\"></td>'+
			'</tr>');
           

      }); -->