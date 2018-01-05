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
$sqlTerpanggil="select * from pidsus.get_list_terdakwa_saksi_tut_ddl('".$_SESSION["idPdsTutSurat"]."')";

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
        Pilih Calon SuratPanggilan
        <a class="close" data-dismiss="modal" style="color: white;">&times;</a>
    </div>

    <div class="modal-body">
        <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">

            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Nama Target Pemanggilan</label>
                        <div class="col-md-10">
                             <?= $viewFormFunction->returnSelect2($sqlTerpanggil,$form,$modelSuratPanggilan,'id_terpanggil','TargetPanggilan','id_pds_tut_tersangka','nama_tersangka','Pilih Target Pemanggilan...','targetPanggilan')?>
                        </div>
                    </div>
                </div>
            </div>

           
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label class="control-label col-md-2">Keterangan</label>
                        <div class="col-md-10">
                            <?php echo $form->field($modelSuratPanggilan, 'keterangan')->textarea() ?>
                        </div>
                    </div>
                </div>
            </div>

          

            

        </div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="form-group" style="margin-left: 0px;">
        	<div class="col-md-1">
							        		
								          	<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
								        </div>
								        <div class="col-md-1"><a id="btnCloseModal" class="btn btn-danger">Batal</a></div>
        </div>
    </div>
</div>
<?php


ActiveForm::end();
?>
<script>
$(document).ready(function() {
	// process the form
    $('#tersangka-form').submit(function(event) {

        // get the form data
        // there are many ways to get this data using jQuery (you can use the class or id also)
         var data=$("#tersangka-form").serialize();
        // process the form
        $.ajax({
            type        : 'POST', // define the type of HTTP verb we want to use (POST for our form)
            url         : 'p38/edit-terpanggil?id=<?php echo $modelSuratPanggilan->id_pds_tut_surat_panggilan?>', // the url where we want to POST
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
        $("#tr_id<?php echo $modelSuratPanggilan->id_pds_tut_surat_panggilan?>").remove();
    	$('#tbody_tersangka').prepend(
                '<tr id="tr_id<?php echo $modelSuratPanggilan->id_pds_tut_surat_panggilan?>">'+
                    '<td>' +
                        $('#pdstutsuratpanggilan-id_terpanggil').val()+
                        '</td>' +
     				'<td>'+
     				$('#pdstutsuratpanggilan-keterangan').val()+
                    '</td>'+    
                    '<td><span class="glyphicon glyphicon-pencil" onclick="editTersangka(\'<?php echo $modelSuratPanggilan->id_pds_tut_surat_panggilan?>\')"></span><a class="btn btn-danger btn-sm glyphicon glyphicon-remove hapus" onclick="hapusTersangka(\'<?php echo $modelSuratPanggilan->id_pds_tut_surat_panggilan?>\')"></a></td>' +
                '</tr>'

            );
            $('#m_terpanggil').modal('hide');
    });
    $('#btnCloseModal').click(function(){
        
        $('#m_terpanggil').modal('hide');
    });
});
</script>