<?php

/**
 * Created by PhpStorm.
 
 

 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();

$form = ActiveForm::begin([
            'id' => 'saksi-form',
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
        Data Ahli
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelSaksi, 'nama_saksi')->textInput(['readonly' => true]); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Tempat & Tgl Lahir</label>
                        <div class="col-md-4">
                            <?php echo $form->field($modelSaksi, 'tempat_lahir'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->field($modelSaksi, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true, 'startDate' =>  $_SESSION['startBirth'], 'endDate' => $_SESSION['endBirth']
                                    ]
                                ]
                            ]);
                            ?>
                        </div>
                    </div>
                </div>
            </div>

          
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelSaksi,'jenis_kelamin','Jenis Kelamin',5,'')?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelSaksi,'agama','Agama',4,'')?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelSaksi, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
               

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                           <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelSaksi,'pendidikan','Pendidikan',6,'')?>
                        </div>
                    </div>
                </div>
				
				<div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pekerjaan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelSaksi, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelSaksi, 'kewarganegaraan') ?>
                        </div>
                    </div>
                </div>
                
                

            </div>

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div><div class="col-md-1">&nbsp;</div>
										<div class="col-md-1"><a class="btn btn-danger" id="tambah_tersangka" onclick="$('#m_saksi').modal('hide');">Batal</a></div>
        </div>
    </div>
</div>
<?php


ActiveForm::end();
?>
<script>
$(document).ready(function() {
	// process the form
    $('#saksi-form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
         var data=$("#saksi-form").serialize();
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'editsaksi?id=<?php echo $modelSaksi->id_pds_dik_saksi?>', // the url where we want to POST
            data        : data, // our data object
            success:function(data){
                //alert(data); 
              },
		   error: function(data) { // if error occured
		         //alert("Error occured.please try again");
		         //alert(data);
		    },
		 
		  dataType:'json'
        })
            // using the done promise callback
            .done(function(data) {
            	
                // log data to the console so we can see
                //console.log(data); 
				
                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
        event.stopImmediatePropagation();
      
            $('#m_saksi').modal('hide');
    });

});
</script>