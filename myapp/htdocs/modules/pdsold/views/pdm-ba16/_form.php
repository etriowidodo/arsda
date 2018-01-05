<?php


use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\builder\Form;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */
/* @var $form yii\widgets\ActiveForm */
?>


<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

      <?php
    $form = ActiveForm::begin(
        [
            'id' => 'p44-form',
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
                <h3 class="box-title">

                </h3>
            </div>
            <div class="box-body">
				<div class="form-group">
					<label class="control-label col-sm-2">Wilayah Kerja</label>
					<div class="col-sm-4">
						<input type="text" name="wilayah_kerja" class="form-control" id="wilayah_kerja" value="<?= $wilayah ?>" readonly="readonly">
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-sm-2">Tanggal Pembuatan</label>
					<div class="col-sm-2">
						<?=
                $form->field($model, 'tgl_surat')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tanggal Pembuatan',
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
								<div class="box-header with-border" style="border-color: #c7c7c7;">
									<h3 class="box-title">
										<a class="btn btn-primary addJPU2" id="popUpJpu">Jaksa Penerima</a>
									</h3>
								</div>
							</div>
				<div class="form-group">
			<table id="table_jpu" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>No Urut</th>
                            <th>NIP</th>
                            <th>NAMA</th>
                            <th>JABATAN</th>
                            <th>PANGKAT</th>
                            <th><a class='btn btn-danger delete'></a></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu">
                         <?php if (!$model->isNewRecord): ?>
                            <?php foreach ($modelJpu as $key => $value): ?>
                                <tr data-id="<?= $value['id_jpp'] ?>">
                                    <td><input type="text" name="no_urut[]" class="form-control" value="<?= ($value['no_urut'] == null) ? $key+1:$value['no_urut'] ?>" style="width: 50px;"></td>
                                    <td><input type="text" name="nip_baru[]" class="form-control" readonly="true" value="<?= $value['peg_nip_baru'] ?>"><input type="hidden" name="nip_jpu[]" class="form-control" readonly="true" value="<?= $value['nip'] ?>"></td>
                                    <td><input type="text" name="nama_jpu[]" class="form-control" readonly="true" value="<?= $value->nama ?>"></td>
                                    <td><input type="text" name="jabatan_jpu[]" class="form-control" readonly="true" value="<?= $value->jabatan ?>"></td>
                                    <td><input type="text" name="gol_jpu[]" class="form-control" readonly="true" value="<?= $value->pangkat ?>"></td>
                                    <td><input type='checkbox' name='jaksa[]' class='checkHapus' id='hapusJaksa' value="<?= $value['id_jpp'] ?>"> </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
				</div>
				
				<div class="form-group">
					<div class="col-sm-12">
						 <?php
            echo Form::widget([ /* tersangka */
                'model' => $model,
                'form' => $form,
                'columns' => 1,
                'attributes' => [
                    'tersangka' => [
                        'label' => 'Terdakwa',
                        'labelSpan' => 2,
                        'columns' => 8,
                        'attributes' => [
                            'id_tersangka' => [
                                'type' => Form::INPUT_DROPDOWN_LIST,
                                'options' => ['prompt' => 'Pilih Terdakwa'],
                                'items' => ArrayHelper::map($listTersangka, 'id_tersangka', 'nama'),
                                'columnOptions' => ['colspan' => 4],
                            ],
                        ]
                    ],
                ]
            ]);
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
					SAKSI
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
				<div class="col-sm-2">
					Nama
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'nama1'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Umur
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'umur1'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Pekerjaan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'pekerjaan1'); ?>
				</div>
			</div>
			<br/><br/>
			 <div class="form-group">
				<div class="col-sm-2">
					Nama
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'nama2'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Umur
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'umur2'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Pekerjaan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'pekerjaan2'); ?>
				</div>
			</div>
			
           </div>
		</div>
	</div>
	
	<div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
					TINDAKAN
                </h3>
            </div>
            <div class="box-body">
                <div class="form-group">
				<div class="col-sm-2">
					Penggeledahan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'penggeledahan')->textarea(); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Nama
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'nama_geledah'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Alamat
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'alamat_geledah'); ?>
				</div>
			</div>
			
			 <div class="form-group">
				<div class="col-sm-2">
					Pekerjaan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'pekerjaan_geledah'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					List Barbuk
				</div>
				<div class="col-sm-6">
					<?php foreach($data_barbuk as $databarbuk): ?>
					<div class="col-sm-12">
					<input type="checkbox" value="<?=$databarbuk['nama']?>" class="chk"> <?=$databarbuk['nama']?>
					</div>
					<?php endforeach; ?>
					<div class="col-sm-2">
					<input type="button" class="btn btn-primary" id="btn_isibarbuk" value="Pilih Barbuk" />
					</div>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-2">
					Penyitaan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'penyitaan')->textarea(); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Nama
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'nama_sita'); ?>
				</div>
			</div>
			
			<div class="form-group">
				<div class="col-sm-2">
					Alamat
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'alamat_sita'); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Pekerjaan
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'pekerjaan_sita'); ?>
				</div>
			</div>
			
           </div>
		</div>
	</div>
		
	 <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-ba16/cetak?id=' . $model->id_ba16]) ?>">Cetak</a>
          <?php endif ?>  
        </div>
		
  <?php ActiveForm::end(); ?>

</div>
    </section>
	
		
<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pdsold/p16/jpu');
        $('#m_jpu').modal('show');
	});
	
	$("#btn_isibarbuk").click(function() {
		$('#pdmba16-penyitaan').val('');
	    var chkArray = [];
	
		$(".chk:checked").each(function() {
			chkArray.push($(this).val());
		});
		
		var no = 1;
		$.each(chkArray , function(i, val) { 
		  $('#pdmba16-penyitaan').val($('#pdmba16-penyitaan').val()+no+'. '+val+"\\n"); 
		  no++;
		});
	});

/*
      $( document ).on('click', '.hapusJaksa', function(e) {
        var input = $( this );
            $(".hapus").click(function(event){
                event.preventDefault();
                if(input.prop( "checked" ) == true){
                    bootbox.dialog({
                        message: "Apakah anda ingin menghapus data ini?",
                        buttons:{
                            ya : {
                                label: "Ya",
                                className: "btn-warning",
                                callback: function(){
                                    $("#trjpu"+e.target.value).remove();
                                }
                            },
                            tidak : {
                                label: "Tidak",
                                className: "btn-warning",
                                callback: function(result){
                                    console.log(result);
                                }
                            },
                        },
                    });

                }else if(input.prop( "checked" ) == false){
                    $(".hapus").off("click");
                }
            });


    });*/

JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
?>
