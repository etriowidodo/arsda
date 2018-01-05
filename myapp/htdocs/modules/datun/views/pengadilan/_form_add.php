<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use app\modules\datun\models\MsWilayah;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\datun\models\pengadilan */
/* @var $form yii\widgets\ActiveForm */


?>
<script type="text/javascript">
var sts="";
    function opt(val){  
		var sts	= val;
		$('#sts').attr("value",sts);
		if(val=='tk2'){
            $("#div_kota").show();
			$("#div_prop1").hide();
			$("#div_prop2").show();
		}else{
            $("#div_kota").hide();
			$("#div_prop2").hide();
			$("#div_prop1").show();
		}
		}
		
     $(function(){
        $("#div_kota").hide();
        $("#div_prop2").hide();
		$('#kd_pt').combogrid({  
            panelWidth:600, 
            width:160, 
			url:'',
            idField:'bidang',  
            textField:'bidang',              
            mode:'remote',            
            loadMsg:"Tunggu Sebentar....!!",                                                 
            columns:[[  
               {field:'bidang',title:'Kode Barang',width:100},  
               {field:'nm_bidang',title:'Nama Barang',width:500}    
            ]],  
             onSelect:function(rowIndex,rowData){
				cbidang=rowData.bidang;
        }  
		});
	}); 
	
  function simpan(){
	var kdpn  	= document.getElementById('kd_pn').value;
	var desk    = document.getElementById('deskripsi').value;
	var td		= document.getElementById('sts').value;
	  if(td=='tk2'){
		  alert("masuk");
	var kdpt 	= kdpn.substr(0,2);
	  }else{
	var kdpt 	= document.getElementById('kd_pt').value;
	  }
	  alert(kdpt);
	if(td==''){
		alert("Mohon dipilh radio button dahulu.!");
		return;
	}
			$.ajax({
				type: "POST",
				url :'/datun/pengadilan/simpan',
				data: 'kdpt=' + kdpt + '&kdpn=' + kdpn +'&desk='+desk +'&sts='+td,
				dataType:"json",
				success:function(data){       
					localStorage.succsess = 'ok';
				}
				});

	}
	
</script>

<section class="content" style="padding: 0 20% 0 20%;">
<div class="content-wrapper-1">
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		<div class="col-md-12">
            <div class="col-md-10">
				<div class="ms-pengadilan-form">
				    <?php $form = ActiveForm::begin(
				    								[
										                'id' => 'pengadilan',
										                'type' => ActiveForm::TYPE_HORIZONTAL,
										                'enableAjaxValidation' => false,
										                'fieldConfig' => [
										                    'autoPlaceholder' => false,
										                ],
										                'formConfig' => [
										                    'deviceSize' => ActiveForm::SIZE_SMALL,
										                    'showLabels' => false
										                ],
														'options' => [
										                            'enctype' => 'multipart/form-data',
										                        ]
												    ]
				    ); ?>
					
					<div class="form-group">
				     <label class="control-label col-md-2">Pengadilan</label>
				     	<div class="col-md-3">
						<table>
						<tr>
							<td><input type="radio" name="gender" value="tk1" onclick="opt(this.value)"> Tinggi</td>
							<td><input hidden="true" readonly="true" id="sts" name="sts"></td>
							<td><input type="radio" name="gender" value="tk2" onclick="opt(this.value)"> Negeri</td>
						</tr>
						</table>
						</div>
				    </div>
					
				     <div class="form-group">
				     <label class="control-label col-md-2">Provinsi</label>
				     	<div class="col-md-6" id="div_prop1">
						<input  class="form-control" id="kd_pt" name="kd_pt" value="" maxlength="2"> 
						<?php
                    /*     if($model->isNewRecord){
                         echo $form->field($model, 'kd_pt')->Input(['maxlength' => true]);
						}else{
						 echo $form->field($model, 'kd_pt')->dropDownList(
                                ArrayHelper::map(MsWilayah::find()->orderBy('id_prop ASC')->all(), 'id_prop', 'deskripsi'), ['prompt' => ''],['width'=>'40%']
                        );
						} */
                        ?>
				    	</div>
						<div class="col-md-6" id="div_prop2">
						<?php
						 echo $form->field($model, 'kd_pt')->dropDownList(
                                ArrayHelper::map(MsWilayah::find()->orderBy('id_prop ASC')->all(), 'id_prop', 'deskripsi'), ['prompt' => ''],['width'=>'40%']
                        );
                        ?>
				    	</div>
				    </div>
					<div class="form-group" id="div_kota">
				     <label class="control-label col-md-2">Kota</label>
				     	<div class="col-md-3">
						<input  class="form-control" id="kd_pn" name="kd_pn" value="" maxlength="4">
				    	</div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-2">Deskripsi</label>
				     	<div class="col-md-8">
						<textarea class="form-control" id="deskripsi" name="deskripsi" value=""></textarea>
						</div>
				    </div>
				    <hr style="border-color: #c7c7c7;margin: 10px 0;">
				    <div class="box-footer" style="text-align: center;"> 
						<a class="btn btn-warning" onclick="javascript:simpan();">Simpan</a> 
				        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../datun/pengadilan/index'], ['class' => 'btn btn-danger']) ?>
				    </div>
				    <?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</section>

<?php 
$js = <<< JS
	$('button:eq(0)').click(function(){
		$('form').submit();
		
		/*var id = $('input[type=text]:eq(0)').val();
		console.log($('input[type=text]:eq(0)'));
		return false;
		if(id == '')
		{
			$('form').submit();
		}
		else
		{
			if(typeof(localStorage.succsess)!='undefined')
			{
				$('form').submit();
				localStorage.clear();
			}
		}*/
	});

function simpan(id)
{
	$.ajax({
            type        : 'POST',
            url         :'/datun/pengadilan/cek-no-kode-ip',
            data        : 'kode='+id,                 
            success     : function(data)
                            {
                              if(data>0)
                              {
                              	 textInput.value = '';
                                 bootbox.dialog({
					                message: "Kode Pengadilan : Telah Tersedia Silahkan Input Kode Lain",
					                buttons:{
					                            Ok : {
					                                label: "OK",
					                                className: "btn-success",
					                                callback: function(){

					                                }
					                            }
					                        }
					                    });
                              }else
                              {
                              	localStorage.succsess = 'ok';
                              }
                              
                          }
    });
}	
	
	
function checkData(id)
{
	$.ajax({
            type        : 'POST',
            url         :'/datun/pengadilan/cek-no-kode-ip',
            data        : 'kode='+id,                 
            success     : function(data)
                            {
                              if(data>0)
                              {
                              	 textInput.value = '';
                                 bootbox.dialog({
					                message: "Kode Pengadilan : Telah Tersedia Silahkan Input Kode Lain",
					                buttons:{
					                            Ok : {
					                                label: "OK",
					                                className: "btn-success",
					                                callback: function(){

					                                }
					                            }
					                        }
					                    });
                              }else
                              {
                              	localStorage.succsess = 'ok';
                              }
                              
                          }
    });
}
// Get the input box
        var textInput = document.getElementById('pengadilan-kode');

        // Init a timeout variable to be used below
        var timeout = null;

        // Listen for keystroke events
        textInput.onkeyup = function (e) {

            // Clear the timeout if it has already been set.
            // This will prevent the previous task from executing
            // if it has been less than <MILLISECONDS>
            clearTimeout(timeout);

            // Make a new timeout set to go off in 800ms
            timeout = setTimeout(function () {
              checkData(textInput.value);
            }, 2000);
        };
JS;
$this->registerJs($js);
?>