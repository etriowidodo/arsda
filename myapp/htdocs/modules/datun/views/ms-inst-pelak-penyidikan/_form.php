<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPelakPenyidikan */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0 20% 0 20%;">
<div class="content-wrapper-1">
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		<div class="col-md-12">
            <div class="col-md-10">
				<div class="ms-inst-pelak-penyidikan-form">

				    <?php $form = ActiveForm::begin(
			    									[
									                'id' => 'mst-inst-pelak-penyidik',
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
				     <label class="control-label col-md-3">Instansi Penyidik</label>
				     	<div class="col-md-8">
				     <?php
                       echo $form->field($model, 'kode_ip')->dropDownList( $kode,
                                                ['prompt' 	=> '---Pilih---','disabled'	=> $model->isNewRecord?false:true],
                                                ['label'	=>'']);
                      ?>
				    	</div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-3">Kode</label>
				     	<div class="col-md-3">
				    <?= 
				    	$form->field($model, 'kode_ipp')->input(
								    		'text',
								    		[	
								    		 'maxlength' => true,
								    		 'style'	 =>'width:90px',
								    		 'class'	 =>'dumy-input',
								    		 'data-inputmask'=>'\'mask\': \'99 / 99 / 99\'',
								    		 'data-mask'	=>true,
								    		  'disabled'	=> $model->isNewRecord?false:true
								    		]
				    						);

				     ?>
				    	</div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-3">Nama</label>
				     	<div class="col-md-8">
				    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
				    	</div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-3">Akronim</label>
				     	<div class="col-md-8">
				    <?= $form->field($model, 'akronim')->textInput(['maxlength' => true]) ?>
				    	</div>
				    </div>
				    <hr style="border-color: #c7c7c7;margin: 10px 0;">
				    <div class="box-footer" style="text-align: center;"> 
				        <?= Html::SubmitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
				        <!-- jaka | 25 mei 2016| CMS_PIDUM001_16 #tambah tombol batal -->
				        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/ms-inst-pelak-penyidikan/index'], ['class' => 'btn btn-danger']) ?>
				        <!-- END CMS_PIDUM001_16 -->
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
	$(document).ready(function(){
		$("#msinstpelakpenyidikan-kode_ipp").hover(function(){
			$('#msinstpelakpenyidikan-kode_ipp').inputmask();
		})
		
		$("#msinstpelakpenyidikan-kode_ipp").on('keydown',function(e) { 
		  	var keyCode = e.keyCode || e.which; 
			  if (keyCode == 9) 
			  { 
			    e.preventDefault(); 
			    $('#msinstpelakpenyidikan-kode_ipp').inputmask('remove');
			    $("#msinstpelakpenyidikan-nama").focus();
			  } 
			 
		});
		
		$('input,button').not('#msinstpelakpenyidikan-kode_ipp').mouseover(function(){
			$('#msinstpelakpenyidikan-kode_ipp').inputmask('remove');
		});
		$('input').not('#msinstpelakpenyidikan-kode_ipp').click(function(){
			$('#msinstpelakpenyidikan-kode_ipp').inputmask('remove');
		});
		$('#msinstpelakpenyidikan-kode_ipp').change(function(){
			$('#msinstpelakpenyidikan-kode_ipp').inputmask('remove');
		});
	})
		
if($('button:eq(0)').text()=='Simpan')
{
	$('button:eq(0)').attr('type','button');
	$('button:eq(0)').click(function(){
		var id  = $('input[type=text]:eq(0)').val();
		var id2 = $('#msinstpelakpenyidikan-kode_ip').val();
		if(id=='')
		{
			$('form').submit();
		}
		else
		{
			checkData(id,id2);
			if(typeof(localStorage.succsess)!='undefined')
			{
				$('form').submit();
				localStorage.clear();
			}
		}
		
	})
}
function checkData(id,id2)
{
	dataObject = {'kode_ipp':id,'kode_ip':id2}
	$.ajax({
            type        : 'POST',
            url         :'/pidum/ms-inst-pelak-penyidikan/cek-no-kode-ipp',
            data        : dataObject,                 
            success     : function(data)
                            {
                              if(data>0)
                              {
                              	 textInput.value = '';
                                 bootbox.dialog({
					                message: "Kode Instansi Pelaksana Penyidik : Telah Tersedia Silahkan Input No Lain",
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
        var textInput = document.getElementById('msinstpelakpenyidikan-kode_ipp');

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
            	if($('#msinstpelakpenyidikan-kode_ip').val()!='')
            	{	
            		checkData(textInput.value,$('#msinstpelakpenyidikan-kode_ip').val());
            	}
            	else
            	{
            		$('form').submit();
            	}
              
            }, 2000);
        };
JS;
$this->registerJs($js);
?>