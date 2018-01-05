<?php

/**
 * Created by PhpStorm.
 
 

 */
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\datecontrol\DateControl;
use \kartik\datetime\DateTimePicker;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();

$form = ActiveForm::begin([
            'id' => 'permintaan_data-form',
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
$sqlJaksa='select peg_nik,peg_nama from pidsus.get_jaksa_p2(\''.$modelPermintaanData->id_pds_lid_surat.'\')';
?>
<div class="modal-content" style="width: 780px;margin: 30px auto;">
    <div class="modal-header">
        Usul Pemanggilan
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelPermintaanData, 'nama'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Jabatan</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelPermintaanData, 'jabatan'); ?>
                        </div>
                        
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Instansi</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelPermintaanData, 'nama_instansi'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">


                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Waktu Pelaksanaan</label>
                        <div class="col-md-10">
                            <?php //echo $form->field($modelPermintaanData, 'waktu_pelaksanaan'); ?>
                            <?php echo $form->field($modelPermintaanData, 'waktu_pelaksanaan')->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => 'Enter event time ...'],
                                'pluginOptions' => [
                                    'autoclose' => true,
                                    'format' => 'dd-mm-yyyy hh:ii'
                                ]
                            ]); ?>
                        </div>
                    </div>
                </div>

            </div>
			 <div class="row">
			

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Keperluan</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelPermintaanData, 'keperluan'); ?>
                        </div>
                    </div>
                </div>

            </div>
			
        <div class="row">
        	<div class="col-md-12">
        				<?= $viewFormFunction->returnSelect2($sqlJaksa,$form,$modelPermintaanData,'jaksa_pelaksanaan','Jaksa Penyelidik','peg_nik','peg_nama','Pilih Jaksa Penyelidik ...','jaksaPenyelidik','full','2','10')?>
        </div>
        </div>
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
        	<div class="col-md-2">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        <div class="col-md-1"><a class="btn btn-danger" id="tambah_permintaan_data" onclick="$('#m_permintaan_data').modal('hide');">Batal</a></div>
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
    $('#permintaan_data-form').submit(function(event) {

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
        event.stopImmediatePropagation();
        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
         var data=$("#permintaan_data-form").serialize();
        // process the form
        if($('#pdslidusulanpermintaandata-waktu_pelaksanaan').val() && $('#pdslidusulanpermintaandata-jaksa_pelaksanaan').val() && $('#pdslidusulanpermintaandata-nama').val() && $('#pdslidusulanpermintaandata-nama_instansi').val() && $('#pdslidusulanpermintaandata-jabatan').val() && $('#pdslidusulanpermintaandata-keperluan').val()){
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'pidsus4/editpermintaandata?id=<?php echo $modelPermintaanData->id_pds_lid_usulan_permintaan_data?>', // the url where we want to POST
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
                
                // here we will handle errors and validation messages
            });

        $("#tr_id<?php echo $modelPermintaanData->id_pds_lid_usulan_permintaan_data?>").remove();
        var jaksaSelect = document.getElementById("pdslidusulanpermintaandata-jaksa_pelaksanaan");
        var selectedText = jaksaSelect.options[jaksaSelect.selectedIndex].text; 
        
    	$('#tbody_pd').prepend(
                '<tr id="tr_id<?php echo $modelPermintaanData->id_pds_lid_usulan_permintaan_data?>" ondblclick="editPermintaanData(\'<?php echo $modelPermintaanData->id_pds_lid_usulan_permintaan_data?>\')">'+
                '<td>' +
                $('#pdslidusulanpermintaandata-nama').val()+
                '</td>' +
				'<td>'+
				$('#pdslidusulanpermintaandata-waktu_pelaksanaan').val()+
            '</td>'+   
            '<td>'+
            selectedText+ 
            '</td>'+
                    '<td><input type="checkbox" name="hapusPermintaanDataCheck" value="'+data['id_pds_lid_usulan_permintaan_data']+'" ></td>' +
                '</tr>'

            );
            $('#m_permintaan_data').modal('hide');
        }
    });

});
</script>