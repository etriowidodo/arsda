<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\modules\datun\models\MsWilayahkab;

/* @var $this yii\web\View */
/* @var $model app\modules\datun\models\wilayah */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0 20% 0 20%;">
<div class="content-wrapper-1">
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		<div class="col-md-12">
            <div class="col-md-10">
				<div class="ms-wilayah-kabupaten-form">
				 <?php $form = ActiveForm::begin(
				    								[
										                'id' => 'wilayahkab',
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
				     <label class="control-label col-md-2">Provinsi</label>
						<input type="hidden" value="<?php echo $kode; ?>" id="kdp" name="kdp" style="width:300px;">
						<div class="col-md-6">
						<input disabled="true" class="form-control" value="<?php echo substr($kode,0,2); ?>">
                        </div>
						
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-2">Kode Kabupaten</label>
				     	<div class="col-md-3">
						<input  disabled="true" type="text" class="form-control" value="<?php echo $kode; ?>" id="kdk" name="kdk" style="width:100px;"/>
				    	</div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-2">Deskripsi</label>
				     	<div class="col-md-3">
						<input type="text" class="form-control" value="<?php echo $deskrip; ?>" id="desk" name="desk" style="width:300px;height400px;"/>
				    	</div>
				    </div>
				    <hr style="border-color: #c7c7c7;margin: 10px 0;">
				    <div class="box-footer" style="text-align: center;"> 
						<a class="btn btn-warning" onclick="javascript:ubah();">Ubah</a> 
				        <?= Html::a('Batal', $model->isNewRecord ? ['index?id='.substr($kode,0,2)] : ['../datun/wilayahkab/index?id='.substr($kode,0,2)], ['class' => 'btn btn-danger']) ?>
				        <!-- END CMS_PIDUM001_16 -->               
				    </div>
				    <?php ActiveForm::end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>
</section>

<script type="text/javascript">
function ubah(){
	var kd_prop = document.getElementById('kdp').value;
	var kd_kab  = document.getElementById('kdk').value;
	var desk    = document.getElementById('desk').value;
			$.ajax({
				type: "POST",
				url :'/datun/wilayahkab/ubahwil',
				//data: ({kd1:kd_prop,kd2:kd_kab,desk:desk}),,
				data: 'kd1=' + kd_prop + '&kd2=' + kd_kab +'&desk='+desk,
				dataType:"json",
				success:function(data){       
                    
					localStorage.succsess = 'ok';
				}
				});

}


</script>

<?php 
$js = <<< JS
	$('button:eq(0)').click(function(){
	var b = document.getElementById('kdp').value;
	alert(b);
		//$('form').submit();
		
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
	
function test(){
	var b = document.getElementById('kdp');
	alert(b);
}	
function checkData(id)
{
	$.ajax({
            type        : 'POST',
            url         :'/datun/wilayahkab/cek-no-kode-ip',
            data        : 'id_kabupaten_kota='+id,                 
            success     : function(data)
                            {
                              if(data>0)
                              {
                              	 textInput.value = '';
                                 bootbox.dialog({
					                message: "Kode Wilayah Kabupaten : Telah Tersedia Silahkan Input Kode Lain",
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
        var textInput = document.getElementById('wilayahkab-id_kabupaten_kota');

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