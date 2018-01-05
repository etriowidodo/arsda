<?php


use kartik\datecontrol\DateControl;
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP44 */
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
					<label class="control-label col-sm-2">Tanggal Tuntutan</label>
					<div class="col-sm-2">
						<?=
                $form->field($model, 'tgl_tuntutan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tanggal Tuntutan',
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
					<label class="control-label col-sm-2">No. Putusan</label>
					
					<div class="col-sm-2">
						<?php echo $form->field($model,'no_putusan');  ?>
					</div>
					
					<div class="col-sm-2">
						<?=
                $form->field($model, 'tgl_putusan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tanggal Putusan',
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
			<table id="table_jpu" class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Pasal</th>
                            <th>Dakwaan</th>
                            <th>Pidana Badan</th>
                            <th>Denda</th>
                            <th>Barang Bukti</th>
                            <th>Biaya Perkara</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="tbody_jpu">
                         
                            <?php  foreach ($listTersangka as $key => $value): ?>
                                <tr>
                                    <td><input type="text" readonly name="nama[]" class="form-control" value="<?=$value['nama'] ?>" style="width: 100px;"></td>
                                    <td><label class="control-label"><?=$value['pasal']?></label></td>
                                    <td><input type="text" readonly name="dakwaan[]" class="form-control" id="putusan_dakwaan_<?=$value['tersangka_id']?>" style="width: 100px;"></td>
                                    <td><input type="text" readonly name="pidana_badan[]" class="form-control" id="putusan_pidanabadan_<?=$value['tersangka_id']?>" value="<?=$value['tahun_badan']." Tahun ".$value['bulan_badan']." Bulan ".$value['hari_badan']." Hari"?>" style="width: 100px;"></td>
                                    <td><input type="text" readonly name="denda[]" value="<?=$value['denda']?>" class="form-control" id="putusan_denda_<?=$value['tersangka_id']?>" style="width: 100px;"></td>
                                    <td><input type="text" readonly name="barbuk[]" class="form-control" id="putusan_barbuk_<?=$value['tersangka_id']?>" style="width: 100px;"></td>
									<td><input type="text" readonly name="biaya_perkara[]" value="<?=$value['biaya_perkara']?>" class="form-control" id="putusan_biayaperkara_<?=$value['tersangka_id']?>" style="width: 100px;"></td>
                                    <td><a class="btn btn-primary putusan " id-tersangka="<?= $value['tersangka_id'] ?>">+</a></td>
                                </tr>
                            <?php endforeach; ?>
                        
                    </tbody>
                </table>
				</div>
				
				<div class="form-group">
					<label class="control-label col-sm-2">Dikeluarkan</label>
					<div class="col-sm-4">
						<?php echo $form->field($model, 'dikeluarkan'); ?>
					</div>
					<div class="col-sm-2">
						<?=
                $form->field($model, 'tgl_dikeluarkan')->widget(DateControl::className(), [
                    'type' => DateControl::FORMAT_DATE,
                    'ajaxConversion' => false,
                    'options' => [
                        'options' => [
                            'placeholder' => 'Tanggal Dikeluarkan',
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
                <label class="control-label col-sm-2">Jaksa Penuntut Umum</label>
                <div class="col-sm-4">
                    <?php
                if (!$model->isNewRecord) {
                    ?>
					<div class="form-group field-pdmjaksapenerima-nama required">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" id="pdmjaksapenerima-nama" class="form-control" name="PdmJaksaPenerima[nama]" value="<?=$modeljaksapenerima['nama']?>">
                            <div class="input-group-btn">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu_penerima">Pilih</a>
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

                <div class="form-group field-pdmjaksapenerima-nama required">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" id="pdmjaksapenerima-nama" class="form-control" name="PdmJaksaPenerima[nama]"  value="<?=$modeljaksapenerima['nama']?>">
                            <div class="input-group-btn">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu_penerima">Pilih</a>
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
                <label class="control-label col-sm-2">Mengetahui</label>
                <div class="col-sm-4">
                    <?php
                if (!$model->isNewRecord) {
                   ?>
				    <div class="form-group field-pdmjaksasaksi-nama required">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]" value="<?=$modeljaksasaksi['nama']?>">
                            <div class="input-group-btn">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
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
                            <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]" value="<?=$modeljaksasaksi['nama']?>">
                            <div class="input-group-btn">
                                <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
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
			
			</div>
		</div>
	</div>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-p44/cetak?id=' . $model->id_perkara]) ?>">Cetak</a>
          <?php endif ?>  
        </div>
		
		<?php
          
                 echo Html::hiddenInput('PdmJaksaSaksi[nip]', $modeljaksasaksi['nip'], ['id' => 'pdmjaksasaksi-nip']);
                echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', $modeljaksasaksi['jabatan'], ['id' => 'pdmjaksasaksi-jabatan']);
                echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', $modeljaksasaksi['pangkat'], ['id' => 'pdmjaksasaksi-pangkat']);
				
				echo Html::hiddenInput('PdmJaksaPenerima[nip]', $modeljaksapenerima['nip'], ['id' => 'pdmjaksapenerima-nip']);
                echo Html::hiddenInput('PdmJaksaPenerima[jabatan]', $modeljaksapenerima['jabatan'], ['id' => 'pdmjaksapenerima-jabatan']);
                echo Html::hiddenInput('PdmJaksaPenerima[pangkat]', $modeljaksapenerima['pangkat'], ['id' => 'pdmjaksapenerima-pangkat']);
            
        ?>

    <?php ActiveForm::end(); ?>

</div>
    </section>

<?php
Modal::begin([
    'id' => 'm_putusantersangka',
    'header' => '<h7>Putusan Tersangka</h7>'
]);
Modal::end();
?>

<?php
$script = <<< JS
        $('.putusan').click(function(e){
          
			var id_tersangka = $('.putusan').attr('id-tersangka');
			
            $('#m_putusantersangka').html('');
            $('#m_putusantersangka').load('/pdsold/pdm-p44/show-putusantersangka?id_tersangka='+id_tersangka);
            $('#m_putusantersangka').modal('show');
        });


     
      
       
JS;
$this->registerJs($script);
?>
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
Modal::begin([
    'id' => 'm_jpu_penerima',
    'header' => 'Data Jaksa Penerima',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_m_jpu_penerima', [
    'model' => $model,
    'searchJPU' => $searchJPU,
    'dataJPU' => $dataJPU,
])
?>

<?php
Modal::end();
?>

	
