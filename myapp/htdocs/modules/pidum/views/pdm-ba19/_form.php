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
				<div class="col-sm-2">
					Lokasi
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'lokasi'); ?>
				</div>
			</div>
			<div class="form-group">
                <label class="control-label col-sm-2">Jaksa Penuntut Umum</label>
                <div class="col-sm-4">
                    <?php
                if (!$model->isNewRecord) {
				
               ?>
				<div class="form-group field-pdmjaksasaksi-nama required">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]" value="<?=$modeljaksi['nama']?>">
                            <div class="input-group-btn">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu_single">Pilih</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
			   <?php
                }else{
                ?>

                <div class="form-group field-pdmjaksasaksi-nama required">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                            <div class="input-group-btn">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu_single">Pilih</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12"></div>
                    <div class="col-sm-12">
                        <div class="help-block"></div>
                    </div>
                </div>
                <?php
                }


                ?>
                </div>
            </div>
				<div class="form-group">
								<div class="box-header with-border" style="border-color: #c7c7c7;">
									<h3 class="box-title">
										<a class="btn btn-primary addJPU2" id="popUpJpu">Jaksa Saksi</a>
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
				
				
				
				
			</div>
		</div>
	</div>
	
	<div class="col-sm-12">
        <div class="box box-warning">
            <div class="box-header">
                <h3 class="box-title">
					BARANG
                </h3>
            </div>
            <div class="box-body">
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
					Berupa
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'berupa')->textarea(); ?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-sm-2">
					Diserahkan Kepada
				</div>
				<div class="col-sm-6">
					<?php echo $form->field($model, 'diserahkan_kpd'); ?>
				</div>
			</div>
			
			
			
           </div>
		</div>
	</div>
	
	
		
	 <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-ba19/cetak?id=' . $model->id_ba19]) ?>">Cetak</a>
          <?php endif ?>  
        </div>
		
		<?php
            if(!$model->isNewRecord ){
                 echo Html::hiddenInput('PdmJaksaSaksi[nip]', $modeljaksi['nip'], ['id' => 'pdmjaksasaksi-nipp']);
                echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', $modeljaksi['jabatan'], ['id' => 'pdmjaksasaksi-jabatan']);
                echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', $modeljaksi['pangkat'], ['id' => 'pdmjaksasaksi-pangkat']);
            }else{
                echo Html::hiddenInput('PdmJaksaSaksi[nip]', null, ['id' => 'pdmjaksasaksi-nip']);
                echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', null, ['id' => 'pdmjaksasaksi-jabatan']);
                echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', null, ['id' => 'pdmjaksasaksi-pangkat']);
            }
        ?>
		
  <?php ActiveForm::end(); ?>

</div>
    </section>
	
		
<?php
$script1 = <<< JS
	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pidum/p16/jpu');
        $('#m_jpu').modal('show');
	});
	
	$("#btn_isibarbuk").click(function() {
		$('#pdmba19-berupa').val('');
	    var chkArray = [];
	
		$(".chk:checked").each(function() {
			chkArray.push($(this).val());
		});
		
		var no = 1;
		$.each(chkArray , function(i, val) { 
		  $('#pdmba19-berupa').val($('#pdmba19-berupa').val()+no+'. '+val+"\\n"); 
		  no++;
		});
	});


JS;
$this->registerJs($script1);
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah JPU</h7>'
]);
Modal::end();
?>


<?php
Modal::begin([
    'id' => 'm_jpu_single',
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