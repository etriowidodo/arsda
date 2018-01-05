<?php

use app\models\MsPendidikan;
use app\modules\pidum\models\PdmMsStatusData;
use app\modules\pidum\models\VwPenandatangan;
use app\components\GlobalConstMenuComponent;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use kartik\widgets\TimePicker;
use kartik\widgets\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP37 */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="pdm-p37-form">

    <?php 
        $form = ActiveForm::begin(
           [
                'id' => 'p37-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 2,
                    'showLabels' => false

           ]
        ]);
    ?>
    
    <div class="col-sm-12">
    	<div class="box box-warning">
            <div class="box-header">
                
            </div>
            <div class="box-body">
                <div class="form-group hide">
		            <label class="control-label col-sm-2">Wilayah Kerja</label>
		            <div class="col-sm-5">
		                <input class="form-control" readonly='true' value="<?php echo Yii::$app->globalfunc->getSatker()->inst_nama ?>">
		                <?= $form->field($model, 'wilayah_kerja')->hiddenInput(['value' => \Yii::$app->globalfunc->getSatker()->inst_satkerkd])->label(false) ?>
		            </div>
		        </div>
                
                
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Nomor</label>
                                <div class="col-sm-6">
                                    <?= $form->field($model, 'no_surat_p37') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
		<div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Keperluan</label>
                                <div class="col-sm-6" >
                                    <?php 
                                        echo $form->field($model, 'id_ms_sts_data')->dropDownList(
                                           ArrayHelper::map(PdmMsStatusData::findAll(['is_group' => 'P-38', 'flag'=>1]), 'id', 'nama'), // Flat array ('id'=>'label')
                                           ['prompt' => 'Pilih Keperluan']    // options
                                        );
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
		        	<label class="control-label col-sm-4">Panggilan Sebagai</label>
		        	<div class="col-sm-6">
		        		<?php 
                                            $items = ArrayHelper::map(PdmMsStatusData::findAll(['is_group' => 'P-37', 'flag'=>1]), 'id', 'nama');
                                            echo $form->field($model, 'id_msstatusdata')->radioList($items, ['inline'=>true]); 
		        		?>
		        	</div>
                            </div>
                        </div>
                    </div>
                </div>
		<div class="row" id="terdakwa" style="display:none">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Nama Terdakwa</label>
                               <div class="col-sm-6">
                                   <?php
                                   echo $form->field($model, 'no_reg_tahanan')->dropDownList(
                                       ArrayHelper::map($modelTersangka, 'no_reg_tahanan', 'nama'), // Flat array ('id'=>'label')
                                       ['prompt' => 'Pilih Terdakwa', 'class' => 'cmb_terdakwa']    // options
                                   );
                                   ?>
                               </div>
                            </div>
                        </div>        
                    </div>        
                </div>   
                <div class="row" id="saksi" style="display:none">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Nama Saksi</label>
                               <div class="col-sm-6">
                                   <?php
                                   echo $form->field($model, 'no_reg_tahanan')->dropDownList(
                                       ArrayHelper::map($vw_saksi, 'no_urut', 'nama'), // Flat array ('id'=>'label')
                                       ['prompt' => 'Pilih Saksi', 'class' => 'cmb_saksi']    // options
                                   );
                                   ?>
                               </div>
                            </div>
                        </div>        
                    </div>        
                </div>  
                <div class="row" id="ahli" style="display:none">
                    <div class="col-md-12">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label col-sm-4">Nama Ahli</label>
                               <div class="col-sm-6">
                                   <?php
                                   echo $form->field($model, 'no_reg_tahanan')->dropDownList(
                                       ArrayHelper::map($vw_ahli, 'no_urut', 'nama'), // Flat array ('id'=>'label')
                                       ['prompt' => 'Pilih Ahli', 'class' => 'cmb_saksi']    // options
                                   );
                                   ?>
                               </div>
                            </div>
                        </div>        
                    </div>        
                </div>  
            </div>
        </div>
    </div>
    
    <div id="jenis">
        <div class="col-sm-12">
        	<div class="box box-warning">
                <div class="box-header">
                    
                </div>
                <div class="box-body">
                    <div class="form-group">
    		            <label class="control-label col-sm-2">Nama</label>
    		            <div class="col-sm-4">
    		                <?= $form->field($model, 'nama') ?>
    		            </div>
    		        </div>
    		        <div class="form-group">
    		            <label class="control-label col-sm-2">Tempat Lahir</label>
    		            <div class="col-sm-4">
    		                <?= $form->field($model, 'tmpt_lahir') ?>
    		            </div>
    		        </div>
    		        <div class="form-group">
    		        	<label class="control-label col-sm-2">Tanggal Lahir</label>
    		        	<div class="col-sm-2">
    		        		<?php 
    		        			echo $form->field($model, 'tgl_lahir')->widget(DateControl::className(), [
    			                    'type' => DateControl::FORMAT_DATE,
    			                    'ajaxConversion' => false,
    			                    'options' => [
    			                        'options' => [
    			                            'placeholder' => 'Tanggal Lahir',
    			                        ],
    			                        'pluginOptions' => [
    			                            'autoclose' => true,
                                            'startDate' => '-100y'
    			                        ]
    			                    ]
    			                ]); 
    		        		?>
    		        	</div>
    		        </div>
                    <div class="form-group">
                    <label class="control-label col-sm-2">Umur</label>
                        <div class="col-sm-2">
                            <?php 
                                echo $form->field($model, 'umur')->textInput(['readonly'=>true, 'value'=> $model->isNewRecord ? 0 : $model->umur]); 
                            ?>
                        </div>
                    </div>
    		        <div class="form-group">
    		            <label class="control-label col-sm-2">Jenis Kelamin</label>
    		            <div class="col-sm-4">
    		               <?php
                                     $JnsKelamin = ArrayHelper::map(\app\models\MsJkl::find()->all(), 'id_jkl', 'nama');
                                    echo  $form->field($model, 'id_jkl')->dropDownList($JnsKelamin,
                                                        ['prompt' => '---Pilih---'],
                                                        ['label'=>'']) ?>
    		            </div>
    		        </div>
    		        <div class="form-group">
                       <label class="control-label col-md-2">Kewarganegaraan</label>
                       <div class="col-sm-4">
                          <?php
                          	$warganegara = ArrayHelper::map(\app\models\MsWarganegara::find()->all(), 'id', 'nama');
                          	echo $form->field($model, 'warganegara')->dropDownList( $warganegara,
                                      ['prompt' => '---Pilih---'],
                                      ['label'=>'']
                          ) ?>
                      </div>
                    </div>
                    <div class="form-group">
                    	<label class="control-label col-sm-2">Alamat</label>
                    	<div class="col-sm-4">
                    		<?php 
                    			echo $form->field($model, 'alamat')->textarea();
                    		?>
                    	</div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-2">Agama</label>
                        <div class="col-md-4">
                            <?php
                              $agama = ArrayHelper::map(\app\models\MsAgama::find()->all(), 'id_agama', 'nama');
                              echo $form->field($model, 'id_agama')->dropDownList( $agama,
                                                        ['prompt' => '---Pilih---'],
                                                        ['label'=>''])
                           ?>
                        </div>
                    </div>
                    <div class="form-group">
                    	<label class="control-label col-sm-2">Pendidikan</label>
                    	<div class="col-sm-4">
                    		<?php 
                    			$pendidikan = ArrayHelper::map(MsPendidikan::find()->all(), 'id_pendidikan', 'nama');
                    			echo $form->field($model, 'id_pendidikan')->dropDownList($pendidikan,
                    				['prompt' => '---Pilih---'],
                    				['label'=>'']
                    			);
                    		?>
                    	</div>
                    </div>
                    <div class="form-group">
                    	<label class="control-label col-sm-2">Pekerjaan</label>
                    	<div class="col-sm-4">
                    		<?php echo $form->field($model, 'pekerjaan') ?>
                    	</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12">
    	<div class="box box-warning">
            <div class="box-header with-border" style="padding-left:0px;">
                <div class="col-md-6" style="padding-left:6px">
                    <h3 class="box-title">Menghadap</h3>
                </div>
            </div>
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-md-2">Nama</label>
                    <div class="col-md-4">
                       <?=
                          $form->field($model, 'nama_hadap', [
                              'addon' => [
                                 'append' => [
                                    'content' => Html::a('Pilih', '', ['class' => 'btn btn-warning', 'data-toggle' => 'modal', 'data-target' => '#m_jpu']),
                                      'asButton' => true
                                 ]
                             ]
                         ]);
                       ?>
                    </div>
                </div>
                <div class="form-group">
                	<label class="control-label col-sm-2">Alamat</label>
                	<div class="col-sm-4">
                		<?php echo $form->field($model, 'alamat_hadap')->textarea()?>
                	</div>
                </div>
                <div class="form-group">
		        	<label class="control-label col-sm-2">Tanggal</label>
		        	<div class="col-sm-2">
		        		<?php 
		        			echo $form->field($model, 'tgl_hadap')->widget(DateControl::className(), [
			                    'type' => DateControl::FORMAT_DATE,
			                    'ajaxConversion' => false,
			                    'options' => [
			                        'options' => [
			                            'placeholder' => 'Tanggal Hadap',
			                        ],
			                        'pluginOptions' => [
			                            'autoclose' => true,
                                        'endDate' => '+1y'
			                        ]
			                    ]
			                ]); 
		        		?>
		        	</div>
		        	<label class="control-label col-sm-1">Jam</label>
		        	<div class="col-sm-2">
		        		<?php 
		        			echo $form->field($model, 'jam')->widget(TimePicker::className(),[
		        					'pluginOptions' => [
		        							'showSeconds' => false,
		        							'showMeridian' => false,
		        							'minuteStep' => 1,
		        							'secondStep' => 5,
		        					]
		        			]);
		        		?>
		        	</div>
		        </div>
		        <div class="form-group">
		        	<label class="control-label col-sm-2">Untuk Keperluan</label>
		        	<div class="col-sm-4">
		        		<?php 
		        			echo $form->field($model, 'keperluan')->textarea();
		        		?>
		        	</div>
		        </div>
            </div>
        </div>
    </div>

    <div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
                    
                </h3>
            </div>
            <div class="box-body">
            	<div class="form-group">
		        	<label class="control-label col-sm-2">Dikeluarkan</label>
		            <div class="col-sm-4">
		                <?php
		                    if($model->isNewRecord){
		                       echo $form->field($model, 'dikeluarkan')->input('text', ['value' => Yii::$app->globalfunc->getSatker()->inst_lokinst]);
		                    }else{
		                       echo $form->field($model, 'dikeluarkan');
		                    } 
		                ?>
		            </div>
		            <div class="col-sm-2">
		                <?=
		                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
		                    'type' => DateControl::FORMAT_DATE,
		                    'ajaxConversion' => false,
		                    'options' => [
		                        'options' => [
		                            'placeholder' => 'Tanggal dikeluarkan',
		                        ],
		                        'pluginOptions' => [
		                            'autoclose' => true
		                        ]
		                    ]
		                ]);
		                ?>
		            </div>
		        </div>

                <div class="form-group">
                    <label class="control-label col-md-2">Upload File</label>
                    <div class="col-md-3">
                        <?php
                        $preview = "";
                        if($model->file_upload!=""){
                            $preview = ["<a href='".$model->file_upload."' target='_blank'><div class='file-preview-text'><h2><i class='glyphicon glyphicon-file'></i></h2></div></a>"
                                         ];
                        }
                        echo FileInput::widget([
                            'name' => 'attachment_3',
                            'id'   =>  'filePicker',
                            'pluginOptions' => [
                                'showPreview' => true,
                                'showCaption' => true,
                                'showRemove' => true,
                                'showUpload' => false,
                                'initialPreview' =>  $preview
                            ],
                        ]);
                        ?>
                        
                        
                        <?= $form->field($model, 'file_upload')->hiddenInput()?>
                    </div>
                </div>




                
                

            	<div class="form-group" style="text-align: center;">
                	<?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
					<?php if(!$model->isNewRecord): ?>
						<a class="btn btn-warning" href="<?= \yii\helpers\Url::to(['pdm-p37/cetak?id='.$model->id_p37])?>">Cetak</a>
					<?php endif; ?>

                </div>
            </div>
        </div>
    </div>
    <div class="form-group" style="text-align: center;">
       
    </div>
	<?= $form->field($model, 'nip')->hiddenInput() ?>
	<?= $form->field($model, 'jabatan')->hiddenInput() ?>
	<?= $form->field($model, 'pangkat')->hiddenInput() ?>

    <?= $form->field($model, 'nama_ttd')->hiddenInput() ?>
    <?= $form->field($model, 'jabatan_ttd')->hiddenInput() ?>
    <?= $form->field($model, 'pangkat_ttd')->hiddenInput() ?>
    <?php 

    if(!$model->isNewRecord ){
        echo $form->field($model, 'id_p37')->hiddenInput();
    }else{
        echo $form->field($model, 'id_p37')->hiddenInput(['value'=>trim(uniqid())]);
    }

    ActiveForm::end(); ?>




</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => 'Data Jaksa Pelaksana',
    'options' => [
        'data-url' => '',
    ],
]);
?> 

<?=
$this->render('_m_jpu', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>  
 <?php
$usia = date('Y,m,d');
$script = <<< JS
    $('#pdmp37-id_msstatusdata').on('change', function() {
       var checked = $("#pdmp37-id_msstatusdata input[type='radio']:checked").val(); 
       if(checked=='3' || checked=='4'){
            $("#terdakwa").show('slow');
            $("#saksi").hide('slow');
            $("#ahli").hide('slow');
       }else if (checked=='1'){
            $("#saksi").show('slow');
            $("#ahli").hide('slow');
            $("#terdakwa").hide('slow');
        }else if (checked=='2'){
            $("#saksi").hide('slow');
            $("#ahli").show('slow');
            $("#terdakwa").hide('slow');
        }else{
        $("#terdakwa").hide('slow');
        $("#jenis :input").val('');
        $("#jenis input").removeAttr("readonly");
        $("#jenis select").removeAttr("readonly");
        $("#jenis textarea").removeAttr("readonly");
       }
    });
    
    $('#pdmp37-tgl_lahir-disp').on('change',function(){
        //alert('lol');return false;
                var tgl = $('#pdmp37-tgl_lahir-disp').val();
                if(tgl != ''){
                    var str = tgl.split('-');
                    var firstdate=new Date(str[2],str[1],str[0]);
                    var tglKejadian =$('#pdmp37-tgl_lahir-disp').val();
                    var start = tglKejadian.split('-');
                    var Endate=new Date('<?php echo $usia ?>');
                    var today = new Date(Endate);
                    var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
                    var age = parseInt(dayDiff);
                    $('#pdmp37-umur').val(age);
                }
             });

    $('.cmb_terdakwa').change(function(){
                //var kodex = $('input[name="PdmP37[id_msstatusdata]"]:checked').val();
                //console.log(wewe);
                var no_reg_tahanan = $(this).val();
                if(no_reg_tahanan!==''){
                    $.ajax({
                        type: "POST",
                        url: '/pidum/pdm-p37/terdakwa',
                        data: 'no_reg_tahanan='+no_reg_tahanan,
                        success:function(data){
                           console.log(data);
                            $("#pdmp37-no_urut").val(data.no_urut);
                            $("#pdmp37-nama").val(data.nama);
                            $("#pdmp37-tmpt_lahir").val(data.tmpt_lahir);
                            $("#pdmp37-umur").val(data.umur);
                            $("#pdmp37-alamat").val(data.alamat);                            
                            $("#pdmp37-tgl_lahir").val(data.tgl_lahir_hide);
                            $("#pdmp37-tgl_lahir-disp").val(data.tgl_lahir);
                            $("#pdmp37-id_jkl").val(data.jns_kelamin);
                            $("#pdmp37-id_agama").val(data.agama);
                            $("#pdmp37-id_pendidikan").val(data.pendidikan);
                            $("#pdmp37-warganegara").val(data.warganegara);
                            $("#pdmp37-pekerjaan").val(data.pekerjaan);
    //                        $("#pdmp37-alamat").val(data.alamat);
    //                        $("#pdmp37-tgl_lahir-disp" ).trigger( "change" );
                        }   
                    });
                    $('#jenis input').attr('readonly', 'readonly');
                    $('#jenis select').attr('readonly', 'readonly');
                    $('#jenis textarea').attr('readonly', 'readonly');
                }
            });
        
        
        $('.cmb_saksi').change(function(){
                var jenis = $('input[name="PdmP37[id_msstatusdata]"]:checked').val();
                var no_reg_tahanan = $(this).val();
                if(no_reg_tahanan!==''){
                    $.ajax({
                        type: "POST",
                        url: '/pidum/pdm-p37/saksi',
                        data: {no_reg_tahanan:no_reg_tahanan, jenis:jenis},
                        success:function(data){
                            console.log(data);
                            $("#pdmp37-no_urut").val(data.no_urut);
                            $("#pdmp37-nama").val(data.nama);
                            $("#pdmp37-tmpt_lahir").val(data.tmpt_lahir);
                            $("#pdmp37-tgl_lahir").val(data.tgl_lahir_hide);
                            $("#pdmp37-umur").val(data.umur);
                            $("#pdmp37-alamat").val(data.alamat);
                            $("#pdmp37-tgl_lahir-disp").val(data.tgl_lahir);
                            $("#pdmp37-id_jkl").val(data.jns_kelamin);
                            $("#pdmp37-id_agama").val(data.agama);
                            $("#pdmp37-id_pendidikan").val(data.pendidikan);
                            $("#pdmp37-warganegara").val(data.warganegara);
                            $("#pdmp37-pekerjaan").val(data.pekerjaan);
    //                        $("#pdmp37-alamat").val(data.alamat);
    //                        $("#pdmp37-tgl_lahir-disp" ).trigger( "change" );
                        }   
                    });
    //                $('#jenis input').attr('readonly', 'readonly');
                    $('#jenis select').attr('readonly', 'readonly');
                    $('#jenis textarea').attr('readonly', 'readonly');
                }
            });

    var handleFileSelect = function(evt) {
         var files = evt.target.files;
         var file = files[0];

         if (files && file) {
             var reader = new FileReader();
             // console.log(file);
             reader.onload = function(readerEvt) {
                 var binaryString = readerEvt.target.result;
                 var mime = 'data:'+file.type+';base64,';
                 console.log(mime);
                 document.getElementById('pdmp37-file_upload').value = mime+btoa(binaryString);
                 // window.open(mime+btoa(binaryString));
             };
             reader.readAsBinaryString(file);
         }
     };

     if (window.File && window.FileReader && window.FileList && window.Blob) {
         document.getElementById('filePicker').addEventListener('change', handleFileSelect, false);
     } else {
         alert('The File APIs are not fully supported in this browser.');
     }


JS;
    $this->registerJs($script);
    ?>      

