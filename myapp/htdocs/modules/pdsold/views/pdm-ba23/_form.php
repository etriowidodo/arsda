<?php

use app\modules\pdsold\models\PdmBa23;
use dosamigos\ckeditor\CKEditorAsset;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;
use app\modules\pdsold\models\VwTerdakwaT2;

CKEditorAsset::register($this);
/* @var $this View */
/* @var $model PdmBa23 */
/* @var $form ActiveForm2 */
?>

<div class="pdm-ba23-form">

    <?php
    $form = ActiveForm::begin([
                'id' => 'ba23-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false,
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 2,
                    'showLabels' => false
                ]
    ]);
    ?>

    <div class="box box-warning">
        <div class="box-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Tanggal</label>
                            <div class="col-md-8">
                                <?=
                                $form->field($model, 'tgl_ba23')->widget(DateControl::className(), [
                                    'type' => DateControl::FORMAT_DATE,
                                    'ajaxConversion' => false,
                                    'options' => [
    //                                    'options' => [
    //                                        'placeholder' => 'Tanggal Putusan Penjara',
    //                                    ],
                                        'pluginOptions' => [
                                            'autoclose' => true,
                                        //'endDate' => '+1y'
                                        ]
                                    ]
                                ]);
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
                            <label class="control-label col-md-4">Tempat / Lokasi</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'dikeluarkan')->textInput() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box box-warning">
        <div class="box-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Terpidana</label>
                            <div class="col-md-8">
                                <?php $nama_terpidana = VwTerdakwaT2::findOne(['no_reg_tahanan'=>$no_reg_tahanan])->nama;
                                if(!$model->isNewRecord){ ?>
                                <?= $form->field($model, 'terpidana')->textInput(['readonly'=>true]);?>
                                <?php }else{ ?>
                                <?= $form->field($model, 'terpidana')->textInput(['readonly'=>true, 'value'=>$nama_terpidana]);?>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label col-md-4">Nama Jaksa</label>
                            <div class="col-md-6">
                                <?php
                                    if ($model->isNewRecord) {?>
                                        <div class="form-group field-pdmjaksasaksi-nama required">
                                            <div class="col-sm-12">
                                                <div class="input-group">
                                                    <input type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
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
                                    } else {
                                ?>
                                    <div class="form-group field-pdmjaksasaksi-nama required">
                                        <div class="col-sm-12">
                                            <div class="input-group">
                                                <input value ="<?= $modeljaksi['nama']?>" type="text" id="pdmjaksasaksi-nama" class="form-control" name="PdmJaksaSaksi[nama]">
                                                <div class="input-group-btn">
                                                    <a class="btn btn-warning" data-toggle="modal" data-target="#m_jpu">Pilih</a>
                                                </div>
                                            </div>
                                            <?php
                                            echo $form->field($modeljaksi, 'no_surat_p16a')->hiddenInput();
                                            echo $form->field($modeljaksi, 'no_urut')->hiddenInput();
                                            ?>
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
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-10">
			<div class="form-group">
                            <a class="btn btn-primary" id="tambah-saksi" style="margin-left: 15px">
                                <i class="glyphicon glyphicon-plus">Saksi</i>
                            </a>
			</div>
                        <br/>
                        <table id="table_saksi" class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No Urut</th>
                                    <th>NIP</th>
                                    <th>NAMA</th>
                                    <th>PANGKAT</th>
                                    <th>JABATAN</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody id="tbody-saksi">
                                <?php  $modelSaksi = json_decode($model->saksi);
                                    for ($i=0; $i < count($modelSaksi->no_urut); $i++) {  ?>
                                    <tr data-id="saksi-<?=$modelSaksi->no_urut[$i]?>">
                                        <td><input type="text" name="saksi[no_urut][]" class="form-control" readonly="true" value="<?= $modelSaksi->no_urut[$i]?>" style="width: 50px;"></td>
                                        <td><input type="text" class="form-control" value="<?= $modelSaksi->nip[$i]?>" name="saksi[nip][]"></td>
                                        <td><input type="text" class="form-control" value="<?= $modelSaksi->nama[$i]?>" name="saksi[nama][]"></td>
                                        <td><input type="text" class="form-control" value="<?= $modelSaksi->pangkat[$i]?>" name="saksi[pangkat][]"></td>
                                        <td><input type="text" class="form-control" value="<?= $modelSaksi->jabatan[$i]?>" name="saksi[jabatan][]"></td>
                                        <td id="saksi-<?=$modelSaksi->no_urut[$i]?>"><a class="btn btn-danger delete"></a></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="box box-warning">
        <div class="box-header">
            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label col-md-2">Pemusnahan Barang</label>
                            <div class="col-md-8">
                                <?= $form->field($model, 'pemusnahan')->textarea() ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
        <?php if (!$model->isNewRecord) : ?>
            <a class="btn btn-warning" href="<?= Url::to(['pdm-ba23/cetak?id=' . $model->no_eksekusi]) ?>">Cetak</a>
        <?php endif ?>	
        <?php
            echo Html::hiddenInput('PdmJaksaSaksi[no_register_perkara]', $model->no_register_perkara, ['id' => 'pdmjaksasaksi-no_register_perkara']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_surat_p16a]', null, ['id' => 'pdmjaksasaksi-no_surat_p16a']);
            echo Html::hiddenInput('PdmJaksaSaksi[no_urut]', null, ['id' => 'pdmjaksasaksi-no_urut']);
            echo Html::hiddenInput('PdmJaksaSaksi[nip]', $model->id_penandatangan, ['id' => 'pdmjaksasaksi-nip']);
            echo Html::hiddenInput('PdmJaksaSaksi[jabatan]', $model->jabatan, ['id' => 'pdmjaksasaksi-jabatan']);
            echo Html::hiddenInput('PdmJaksaSaksi[pangkat]', $model->pangkat, ['id' => 'pdmjaksasaksi-pangkat']);
        ?>
    </div>
    <?php ActiveForm::end(); ?>

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
$this->registerJs($script,View::POS_BEGIN);

$this->registerJs( "

	$('body').on('click','.delete', function(){
		$(this).closest('tr').remove();
	});

	$('#tambah-saksi').on('click',function(){
		var len = $('#tbody-saksi tr').length+1;
		          $('#tbody-saksi').append(
					'<tr data-id=\"saksi-'+len+'\">'+
						'<td><input type=\"text\" name=\"saksi[no_urut][]\" class=\"form-control\" readonly=\"true\" value='+len+' style=\"width: 50px;\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[nip][]\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[nama][]\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[pangkat][]\"></td>'+
						'<td><input type=\"text\" class=\"form-control\" name=\"saksi[jabatan][]\"></td>'+
						'<td id=\"saksi-'+len+'\"><a class=\"btn btn-danger delete\"></a></td>'+
					'</tr>');
	});

	function hapusJpuPenerima(e){
		$('#jaksaPenerima-' + e).remove();
	}


    $(document).ready(function(){
  
	

}); ", \yii\web\View::POS_END);
?>