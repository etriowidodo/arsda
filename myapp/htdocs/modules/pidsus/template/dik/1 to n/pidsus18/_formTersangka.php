<div class="modal-content">
    <div class="modal-header">
        JPU
        <a class="close" data-dismiss="modal">&times;</a>
    </div>

    <div class="modal-body">
        <?php $form = ActiveForm::begin(
	 [
                'id' => 'p2-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]); ?>
            <div class="box-body">
            	 <div class="box box-solid">
							                    <div class="box-header with-border">
							                        
							                        <h3 class="box-title">Tersangka :</h3>
							                    </div><!-- /.box-header -->
							                    <div class="box-body">   		 
											<div>
												<div class="form-group">
					                                    <label for="Nama" class="control-label col-md-3">Nama</label>
					                                    <div class="col-md-6"><?= $form->field($modelTersangka, 'nama_tersangka')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
												<div class="form-group">
					                                    <label for="ttl" class="control-label col-md-3">Tempat/Tanggal Lahir</label>
					                                    <div class="col-md-3"><?= $form->field($modelTersangka, 'tempat_lahir')->textInput(['readonly' => $readOnly]) ?></div>
					                                	<div class="col-md-3"><?=
					                                             $form->field($modelTersangka, 'tgl_lahir')->widget(DateControl::classname(), [
					                                                'type'=>DateControl::FORMAT_DATE,
					                                                'ajaxConversion'=>false,
					                                                'options' => [
					                                                    'pluginOptions' => [
					                                                        'autoclose' => true
					                                                    ]
					                                                ],
					                                             	'readonly'=>$readOnly,
					                                            ])?>
					                                    </div>
					                                </div> 
												<?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'jenis_kelamin','Jenis Kelamin',5)?>
												<div class="form-group">
					                                    <label for="kewarganegaraan" class="control-label col-md-3">Kewarganegaraan</label>
					                                    <div class="col-md-6"><?= $form->field($modelTersangka, 'kewarganegaraan')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div> 
												<div class="form-group">
					                                    <label for="alamat" class="control-label col-md-3">Tempat Tinggal</label>
					                                   <div class="col-md-6"><?= $form->field($modelTersangka, 'alamat')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => $readOnly)) ?></div>
													 </div> 
												<?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'agama','Agama',4)?>
												<div class="form-group">
					                                    <label for="pekerjaan" class="control-label col-md-3">Pekerjaan</label>
					                                    <div class="col-md-6"><?= $form->field($modelTersangka, 'kewarganegaraan')->textInput(['readonly' => $readOnly]) ?></div>
					                                </div>
					                                <?= $viewFormFunction->returnSelect2ParameterDetail($form,$modelTersangka,'pendidikan','Pendidikan',6)?>
												
					                        </div>           		
					                        </div></div>
					                        
            </div>
          <?php ActiveForm::end(); ?>
    </div>

<script>
    $(document).ready(function(){
        $('#pilih-jpu').click(function(){
            $('input:checkbox:checked').each(function(index) {
                var value = $(this).val();
                var data = value.split('#');

                $('#tbody_jpu').append(
                    '<tr id="trjpu'+data[0]+'">' +
                        '<td><input type="text" class="form-control" name="nip_jpu[]" readonly="true" value="'+data[0]+'"> </td>' +
                        '<td><input type="text" class="form-control" name="nama_jpu[]" readonly="true" value="'+data[1]+'"> </td>' +
                        '<td><a class="btn btn-danger" onclick="hapusJpuPop(\''+data[0]+'\')">Hapus</a> </td>' +
                    '</tr>'
                );

            });
            $('#m_jpu').modal('hide');
        });

    });
</script>