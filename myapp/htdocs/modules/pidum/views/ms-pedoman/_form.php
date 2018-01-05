<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm  as ActiveForm2;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPedoman */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php  $form = ActiveForm::begin([
                    'id' => 'ms-pasal-form',
                    'type' => ActiveForm::TYPE_HORIZONTAL,
                    'enableAjaxValidation' => false,
                    'fieldConfig' => [
                        'autoPlaceholder' => false
                    ],
                    'formConfig' => [
                        'deviceSize' => ActiveForm::SIZE_SMALL,
                        'showLabels' => false
                    ]
        ]); ?>
	
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Undang-Undang</label>
					<div class="col-md-8 pull-right">
						 <?php
                            echo $form->field($model, 'id', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#_undang']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
						
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Pasal</label>
					<div class="col-md-8">
						<?php
                            echo $form->field($model, 'id_pasal', [
                                'addon' => [
                                    'append' => [
                                        'content' => Html::button('Pilih', [ 'class' => 'btn btn-warning btn-popup-pasal']),
                                        'asButton' => true
                                    ]
                                ]
                            ]);
                            ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Kategori</label>
					<div class="col-md-8">
						<?php echo $form->field($model, 'kategori')->dropDownList(['1' => 'I (Tidak ada hal yang meringankan)', '2' => 'II (Hal yang memberatkan lebih dominan tetapi ada hal yang meringankan)', '3' => 'III (Antara hal yang memberatkan dan meringankan sebanding)', '4' => 'IV (Lebih dominan hal yang meringankan tetapi ada hal yang memberatkan)', '5' => 'V (Tidak ada hal yang memberatkan)']); ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Tuntutan Pidana</label>
					<div class="col-md-8" >
						<?= $form->field($model, 'tuntutan_pidana')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Ancaman</label>
					<div class="col-md-8" >
						<?= $form->field($model, 'ancaman')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		
		<div class="col-md-12">
			<div class="col-md-6">
				<div class="form-group">
					<label class="control-label col-md-4">Denda</label>
					<div class="col-md-8">
						<?= $form->field($model, 'denda')->textInput(['maxlength' => true]) ?>
					</div>
				</div>
			</div>
		</div>
		
    </div>

    

    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/ms-pedoman/index'], ['class' => 'btn btn-danger']) ?>
    </div>

    <?php ActiveForm::end(); ?>

	</div>
</section>


<?php
Modal::begin([
    'id' => '_undang',
    'header' => 'Data Undang-Undang',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('//ms-pasal/_undang', [
    'model' => $model,
    'searchUU' => $searchUU,
    'dataUU' => $dataUU,
])
?>

<?php
Modal::end();
?>  

<?php
Modal::begin([
    'id' => 'm_pasal',
    'header' => '<h7>Daftar Pasal</h7>',
	'options' => [
        'width' => '50%',
    ],
]);
Modal::end();
?>

<?php
$js = <<< JS
	$('.btn-popup-pasal').click(function(e){
		var undang = $("#mspedoman-id").val();
		if(undang==''){
			 bootbox.dialog({
                message: "Silahkan Pilih Undang-Undang Dahulu",
                buttons:{
                    ya : {
                        label: "OK",
                        className: "btn-warning",

                    }
                }
            });
		}else{
			$('#m_pasal').html('');
			$('#m_pasal').load('/pidum/ms-pedoman/show-pasal?uu='+encodeURI(undang));
			$('#m_pasal').modal('show');
		}
	});
	
	$(document).ready(function(){
		$("#mspedoman-uu").prop("readonly",true);
		$("#mspedoman-pasal").prop("readonly",true);
	});
JS;
$this->registerJs($js);
?>