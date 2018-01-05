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
            'id' => 'penyitaan-form',
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
$sqlJaksa='select peg_nik,peg_nama from pidsus.get_jaksa_satker(\''.$_SESSION['idSatkerUser'].'\')';
$sqlNamaJabatan="select nama_jabatan|| ', ' ||tempat_lokasi as nama_jabatan from pidsus.pds_dik_surat_target_pemanggilan where id_pds_dik_surat='".$_SESSION['idPdsDikSurat']."' and flag!='3'";
?>
<div class="modal-content" style="width: 900px;margin: 30px auto;">
    <div class="modal-header">
        Item yang Disita
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">No Urut</label>
                        <div class="col-md-1">
                            <?php echo $form->field($modelPenyitaan, 'no_urut'); ?>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="row">
	        	<div class="col-md-12">
	        				<?= $viewFormFunction->returnSelect2($sqlNamaJabatan,$form,$modelPenyitaan,'nama_jabatan','Item','nama_jabatan','nama_jabatan','','namajabatan','full','4','8')?>
		        </div>
	        </div>

            
            
			<div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Disita dari dan tempat penyitaan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelPenyitaan, 'dari_dan_tempat'); ?>

                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="row">
        	<div class="col-md-12">
        				<?= $viewFormFunction->returnSelect2($sqlJaksa,$form,$modelPenyitaan,'id_jaksa_pelaksana','Jaksa Pelaksana','peg_nik','peg_nama','Pilih Jaksa Penyelidik ...','jaksaPenyelidik','full','4','8')?>
        </div>
        </div>
            <div class="row">


                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Waktu Pelaksanaan</label>
                        <div class="col-md-8">
                            <?php //echo $form->field($modelPenyitaan, 'waktu_pelaksanaan'); ?>
                            <?php echo $form->field($modelPenyitaan, 'waktu_pelaksanaan')->widget(DateTimePicker::classname(), [
                                'options' => ['placeholder' => '...'],
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
                        <label class="control-label col-md-4">Keperluan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelPenyitaan, 'keperluan')->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50)); ?>
                        </div>
                    </div>
                </div>

            </div>
			 <div class="row">
			

                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-4">Keterangan</label>
                        <div class="col-md-8">
                            <?php echo $form->field($modelPenyitaan, 'keterangan')->textArea(array('maxlength' => 4000, 'rows' => 3, 'cols' => 50)); ?>
                        </div>
                    </div>
                </div>

            </div>
			
        
        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
        	<div class="col-md-2">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        <div class="col-md-1"><a class="btn btn-danger" id="batal" onclick="$('#m_penyitaan').modal('hide');">Batal</a></div>
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
    $('#penyitaan-form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
         var data=$("#penyitaan-form").serialize();
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'editpenyitaan?id=<?php echo $modelPenyitaan->id_pds_dik_surat_penyitaan?>', // the url where we want to POST
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

        // stop the form from submitting the normal way and refreshing the page
        event.preventDefault();
        event.stopImmediatePropagation();
        $("#tr_id_sita<?php echo $modelPenyitaan->id_pds_dik_surat_penyitaan?>").remove();
        var jaksaSelect = document.getElementById("pdsdiksuratpenyitaan-id_jaksa_pelaksana");
        var selectedText = jaksaSelect.options[jaksaSelect.selectedIndex].text; 
        
    	$('#tbody_sita').prepend(
    			 '<tr id="tr_id_sita<?php echo $modelPenyitaan->id_pds_dik_surat_penyitaan ?>" ondblclick="editPenyitaan(\'<?php echo $modelPenyitaan->id_pds_dik_surat_penyitaan ?>\')">'+
                 '<td>' +
                 	$('#pdsdiksuratpenyitaan-no_urut').val()+
                 '</td>' +
                 '<td>' +
                     $('#pdsdiksuratpenyitaan-nama_jabatan').val()+" "+$('#pdsdiksuratpenyitaan-tempat_lokasi').val()+
                     '</td>' +
                 '<td>' +
                     $('#pdsdiksuratpenyitaan-dari_dan_tempat').val()+
                     '</td>' +
                     
  				'<td>'+
  				selectedText+" "+$('#pdsdiksuratpenyitaan-waktu_pelaksanaan').val()+
                 '</td>'+
                 '<td>' +
                     $('#pdsdiksuratpenyitaan-keperluan').val()+
                     '</td>' +
                 '<td>' +
                     $('#pdsdiksuratpenyitaan-keterangan').val()+
                     '</td>' +
                 '<td><input type="checkbox" name="hapusPenyitaanCheck" value="<?php echo $modelPenyitaan->id_pds_dik_surat_penyitaan?>" ></td>' +
             '</tr>'

         );
            $('#m_penyitaan').modal('hide');
    });

});
</script>