<?php
use app\assets\AppAsset;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsInstPenyidik */
/* @var $form yii\widgets\ActiveForm */
?>
<section class="content" style="padding: 0 20% 0 20%;">
<div class="content-wrapper-1">
	<div class="box box-primary" style="border-color: #f39c12;padding: 15px;overflow: hidden;">
		<div class="col-md-12">
            <div class="col-md-10">
				<div class="ms-inst-penyidik-form">
				    <?php $form = ActiveForm::begin(
				    								[
										                'id' => 'mst-inst-penyidik',
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
				     <label class="control-label col-md-2">Kode</label>
				     	<div class="col-md-2">
				    	<?= $form->field($model, 'kode_ip')->input('text',
										    	['oninput'  =>'var number =  /^[0-9]+$/;
						                                        if(this.value.length>2)
						                                        {
						                                          this.value = this.value.substr(0,2);
						                                        }
						                                        if(this.value<0)
						                                        {
						                                           this.value =null
						                                        }
						                                        var str   = "";
						                                        var slice = "";
						                                        var b   = 0;
						                                        for(var a =1;a<=this.value.length;a++)
						                                        {
						                                            slice = this.value.substr(b,1);
						                                            if(slice.match(number))
						                                            {
						                                                str+=slice;
						                                            }
						                                            
						                                            b++
						                                        }
						                                        this.value=str;
						                                        ',
						                          'disabled'	=> $model->isNewRecord?false:true
						                                        ]) ?> 
				    	</div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-2">Nama</label>
				     	<div class="col-md-8">
				    <?= $form->field($model, 'nama')->textInput(['maxlength' => true]) ?>
				    </div>
				    </div>
				    <div class="form-group">
				     <label class="control-label col-md-2">Akronim</label>
				     	<div class="col-md-8">
				    <?= $form->field($model, 'akronim')->textInput(['maxlength' => true]) ?>
				    </div>
				    </div>
				    <hr style="border-color: #c7c7c7;margin: 10px 0;">
				    <div class="box-footer" style="text-align: center;"> 
				        <?= Html::SubmitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
				        <!-- jaka | 25 mei 2016| CMS_PIDUM001_16 #tambah tombol batal -->
				        <?= Html::a('Batal', $model->isNewRecord ? ['index'] : ['../pidum/ms-inst-penyidik/index'], ['class' => 'btn btn-danger']) ?>
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
if($('button:eq(0)').text()=='Simpan')
{
	$('button:eq(0)').attr('type','button');
	$('button:eq(0)').click(function(){
		var id = $('input[type=text]:eq(0)').val();
		if(id=='')
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
		}
		
	})
}
function checkData(id)
{
	$.ajax({
            type        : 'POST',
            url         :'/pidum/ms-inst-penyidik/cek-no-kode-ip',
            data        : 'kode_ip='+id,                 
            success     : function(data)
                            {
                              if(data>0)
                              {
                              	 textInput.value = '';
                                 bootbox.dialog({
					                message: "Kode Instansi Penyidik : Telah Tersedia Silahkan Input No Lain",
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
        var textInput = document.getElementById('msinstpenyidik-kode_ip');

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