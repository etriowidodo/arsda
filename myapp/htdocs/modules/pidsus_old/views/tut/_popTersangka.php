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
        Pilih Calon Tersangka
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'nama_tersangka'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Tempat & Tgl Lahir</label>
                        <div class="col-md-4">
                            <?php echo $form->field($modelTersangka, 'tempat_lahir'); ?>
                        </div>
                        <div class="col-md-6">
                            <?php
                            echo $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::className(), [
                                'type' => DateControl::FORMAT_DATE,
                                'ajaxConversion' => false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
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
                        <label class="control-label col-md-4">Identitas & No</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'jenis_id','Jenis Identitas',67,'')?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php echo $form->field($modelTersangka, 'nomor_id') ?>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Jenis Kelamin</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'jenis_kelamin','Jenis Kelamin',5,'')?>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Agama</label>
                        <div class="col-md-8">
                            <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'agama','Agama',4,'')?>
                        </div>
                    </div>
                </div>

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Alamat</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelTersangka, 'alamat')->textarea() ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
               

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                           <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'pendidikan','Pendidikan',6,'')?>
                        </div>
                    </div>
                </div>
				
				<div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Pekerjaan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'pekerjaan') ?>
                        </div>
                    </div>
                </div>
                
            </div>

            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Kewarganegaraan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'kewarganegaraan') ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Suku</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelTersangka, 'suku') ?>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
            </div><div class="col-md-1">&nbsp;</div><div class="col-md-1"><a class="btn btn-danger" id="tambah_tersangka" onclick="$('#m_tersangka').modal('hide');">Batal</a></div>
								        </div>
        </div>
    </div>
</div>
<?php


ActiveForm::end();
?>
<script>
$(document).ready(function() {
	var currentValue = 1;
	  
    // process the form
    $('#tersangka-form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
         var data=$("#tersangka-form").serialize();
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'show-tersangka', // the url where we want to POST
            data        : data, // our data object
            success:function(data){
                //alert(data['id_pds_dik_tersangka']); 
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
                $('#tbody_tersangka').append(
                        '<tr id="tr_id'+data['id_pds_tut_tersangka']+'">'+
                            '<td>' +
                                $('#pdstuttersangka-nama_tersangka').val()+
                                '</td>' +
             				'<td>'+
             				$('#pdstuttersangka-nomor_id').val()+
                            '</td>'+    
                            '<td><span class="glyphicon glyphicon-pencil" onclick="editTersangka(\''+data['id_pds_tut_tersangka']+'\')"></span><a class="btn btn-danger btn-sm glyphicon glyphicon-remove hapus" onclick="hapusTersangka(\''+data['id_pds_tut_tersangka']+'\')"></a></td>' +
                        '</tr>'

                    );
                // here we will handle errors and validation messages
            });

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
        event.stopImmediatePropagation();
      
            currentValue ++;
            $('#m_tersangka').modal('hide');
    });

});
</script>