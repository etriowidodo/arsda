<?php

use yii\helpers\Html;
use kartik\widgets\ActiveForm;
use kartik\datecontrol\DateControl;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmPenandatangan;
use yii\bootstrap\Modal;
use yii\helpers\ArrayHelper;
use kartik\widgets\FileInput;
use yii\web\View;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa18 */
/* @var $form yii\widgets\ActiveForm */

//echo '<pre>';print_r($modelJaksa);exit;
?>
<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">

    <?php 
	$form = ActiveForm::begin([
		'options' => ['enctype' => 'multipart/form-data'],
		'id' => 'pdm-ba5-form',
		'type' => ActiveForm::TYPE_HORIZONTAL,
		'enableAjaxValidation' => false,
		'fieldConfig' => [
			'autoPlaceholder' => false
		],
		'formConfig' => [
			'deviceSize' => ActiveForm::SIZE_SMALL,
			'showLabels' => false

		],
	]); 
	?>

    <div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
		<div class="box-header"></div>
		<div class="col-md-12">
			<div class="form-group">
			<div class="col-md-6">
				<label class="hide">Wilayah Kejaksaan</label>
				<div class="hide">
					<!--<input type="text" readonly="true" class="form-control" value="<?php //echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">-->
					<?= $form->field($model, 'asal_satker')->textInput(['readonly' => true, 'maxlength' => true, 'value'=>Yii::$app->globalfunc->getSatker()->inst_nama]) ?>
				</div>
				<label class="control-label col-md-3">Tanggal Pembuatan</label>
				<div class="col-md-3">
					<?php echo DateControl::widget([
                                   'name'=>'PdmBa5[tgl_ba5]', 
                                   'value'=>$rp9->tgl_terima,
                                   'type'=> DateControl::FORMAT_DATE,
                                   'readonly'=>true,
                                   'ajaxConversion' => false,
                                   'options' => [
                                       'pluginOptions' => [
                                       'autoclose' => true,
                                       ]
                                   ]
                               ]); ?>
				</div>
			</div>
			
		
			<div class="col-md-6">
				<label class="control-label col-md-4">Tempat Penyimpanan</label>
				<div class="col-md-8">
					<?= $form->field($model, 'lokasi')->textInput(['maxlength' => true, 'placeholder' => 'Tempat / Lokasi']) ?>
				</div>
			</div>
		</div>
		</div>
	</div>
	
	<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
		<div style="border-color: #c7c7c7;" class="box-header with-border">
            <h3 class="box-title">
                <strong>JAKSA</strong>
            </h3>
        </div>

		<div class="col-md-10">
			<div class="form-group">
				
				<a class="btn btn-primary" id="popUpJpu">
					<i class="glyphicon glyphicon-plus"></i>Jaksa 
				</a>
			</div>
		</div>
		<table id="table_jaksa_penerima" class="table table-bordered">
            <thead>
                <tr>
                    <th>No Urut</th>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>PANGKAT / GOLONGAN</th>
                    <th>JABATAN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody id="tbody-penerima">
                <?php if (!$model->isNewRecord): ?>
                    <?php foreach ($modelJaksa as $key => $value): ?>
                        <tr data-id="jaksaPenerima-<?= $value['no_register_perkara'].$value['no_urut'] ?>">
                            <td><input type="text" name="penerima-no_urut_news[]" class="form-control" value="<?= ($value['no_urut'] == null) ? $key+1:$value['no_urut'] ?>" style="width: 50px;"></td>
                            <td><input type="text" name="penerima-peg_nip_news[]" class="form-control" readonly="true" value="<?= $value['nip'] ?>">
                            	</td>
                            <td><input type="text" name="penerima-peg_nama_news[]" class="form-control" readonly="true" value="<?= $value['nama'] ?>"></td>
                            <td><input type="text" name="penerima-pangkat_news[]" class="form-control" readonly="true" value="<?= $value['pangkat'] ?>"></td>
                            <td><input type="text" name="penerima-jabatan_news[]" class="form-control" readonly="true" value="<?= $value['jabatan'] ?>"></td>
                            <td id="tdJPU"><a class="btn btn-danger delete" data-id="<?= $value['nip'] ?>" id="btn_hapus"></a></td>
                            <input type="hidden" name="penerima-idjpp[]" class="form-control" readonly="true" value="<?= $value['no_urut'] ?>">
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
		<div id="deleted_jaksa_penerima"></div>
		
		<div class="col-md-10">
			<div class="form-group">
				<!-- <label class="control-label col-md-2"><strong>Para Saksi</strong></label> -->
				<div class="form-group">
				
				<a class="btn btn-primary" id="popUpSaksi">
					<i class="glyphicon glyphicon-plus"></i> Saksi
				</a>
                <a class="btn btn-primary" id="tambahSaksiLuar">
                    <i class="glyphicon glyphicon-plus"></i> Saksi Dari Luar Kejaksaan
                </a>
			</div>
				<a class="btn btn-primary hide" data-toggle="modal" data-target="#m_jaksa-saksi">
					<i class="glyphicon glyphicon-plus"></i>
				</a>
			</div>
		</div>
		<table id="table_saksi_penerima" class="table table-bordered">
            <thead>
                <tr>
                    <th>No Urut</th>
                    <th>NIP</th>
                    <th>NAMA</th>
                    <th>PANGKAT / GOLONGAN</th>
                    <th>JABATAN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody id="tbody-saksi">
            	<?php if (!$model->isNewRecord): ?>
                    <?php foreach ($modelSaksi as $value): ?>
                        <tr data-id="jaksaSaksi-<?= $value['no_register_perkara'].$value['no_urut'] ?>">
                            <td><input type="text" name="saksi-no_urut_news[]" class="form-control" readonly="true" value="<?= ($value['no_urut'] == null) ? $key+1:$value['no_urut'] ?>" style="width: 50px;"></td>
                            <td><input type="text" name="saksi-peg_nip_news[]" class="form-control" readonly="true" value="<?= $value['nip'] ?>"></td>
                            <td><input type="text" name="saksi-peg_nama_news[]" class="form-control" readonly="true" value="<?= $value['nama'] ?>"></td>
                            <td><input type="text" name="saksi-pangkat_news[]" class="form-control" readonly="true" value="<?= $value['pangkat'] ?>"></td>
                            <td><input type="text" name="saksi-jabatan_news[]" class="form-control" readonly="true" value="<?= $value['jabatan'] ?>"></td>
                            <td id="tdSaksi"><a class="btn btn-danger delete" data-id="<?= $value['nip'] ?>" id="btn_hapus_saksi"></a></td>
                        </tr>
                    <?php endforeach; ?>
            	<?php endif; ?>
            </tbody>
        </table>
	</div>

	<div class="box box-primary hide">
		<div class="box-header">
			<div class="col-md-12" style="border:1px solid #cecece;border-radius:4px;padding:10px 0px;background-image: linear-gradient(to bottom, rgba(255, 255, 255, 1) 0%, rgba(246, 246, 246, 1) 47%, rgba(237, 237, 237, 1) 100%);">
				<div class="form-group">
					<label class="control-label col-md-2" style="margin-top:5px;">ACUAN</label>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label class="control-label col-md-2">Kejaksaan</label>
				<div class="col-md-4">
					<input type="text" readonly="true" class="form-control" value="<?php echo \Yii::$app->globalfunc->getSatker()->inst_nama ?>">
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label class="control-label col-md-2">No.SP Kepala Kejaksaan</label>
				<div class="col-md-4">
					<?= $form->field($model, 'no_sp')->textInput(['maxlength' => true]) ?>
				</div>
			</div>
		</div>
		<div class="col-md-10">
			<div class="form-group">
				<label class="control-label col-md-2">Tanggal SP</label>
				<div class="col-md-4">
					<?php echo $form->field($model, 'tgl_sp')->widget(DateControl::className(),[
						'type'=>DateControl::FORMAT_DATE,
						'ajaxConversion'=>false,
						'options' => [
							'pluginOptions' => [
								'autoclose' => true
							]
						]
					]); ?>
				</div>
			</div>
		</div>
	</div>
	

	
	<div class="box box-primary" style="border-top-color:#ffb04d;overflow:hidden;">
		<div class="box-header with-border" style="border-color: #c7c7c7;">
		<div class="form-group">
				<label class="control-label col-md-2"><b>No Register Barang Bukti</b></label>
				<div class="col-md-3">
					<?= $form->field($model, 'no_reg_bukti')->textInput(['maxlength' => true, 'placeholder' => 'No Register Barang Bukti']) ?>
				</div>
			</div>

            <h3 class="box-title">
                <a class="btn btn-primary" id="tambahBarbuk" data-toggle="modal" data-target="#m_barbuk">
                	<i class="glyphicon glyphicon-plus"></i> Barang Bukti
                </a>
            </h3>
        </div>

		<!-- <div class="col-md-10 hide">
			<div class="form-group">
				<label class="control-label col-md-2">No.Reg.Bukti</label>
				<div class="col-md-4">
					<?php //$form->field($model, 'no_reg_bukti')->textInput(['maxlength' => true]) 
					?>
				</div>
			</div>
		</div> -->

		<table id="table_barbuk" class="table table-bordered">
            <thead>
            <tr>
                <th width="6%"
                    style="text-align: center;"><?= Html::buttonInput('Hapus', ['class' => 'btn btn-warning', 'id' => 'tmblhapusbaris']) ?></th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Nama</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Jumlah [decimal]</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Satuan</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Disita dari</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Tempat Penyimpanan</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Kondisi</th>
            </tr>
            </thead>
            <tbody id="tbody_barbuk">

            <?php
            if (!$model->isNewRecord) {
                //echo '<pre>';print_r($modelBarbuk);exit;
                foreach ($modelBarbuk as $barbuk):
            ?>
                <tr id="row">
                    <td style="text-align: center">
                    	<input type="checkbox" name="chkHapusBarbuk" class="chkHapusBarbuk">
                    </td>
                    <td>
                    	<input type="hidden" class="form-control idbarbuk" name="idBarbuk" readonly="true" value="<?= $barbuk['no_register_perkara'].$barbuk['no_urut_bb'] ?>">
                    	<input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="<?= $barbuk['nama'] ?>">
                    </td>
                    <td>
                    	<input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="<?= $barbuk['jumlah'] ?>">
                    </td>
                    <td>
                    	<input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="<?= $barbuk['id_satuan'] ?>">
                    	<input type="text" class="form-control" name="txtBarbukSatuan" readonly="true" value="<?= \app\modules\pidum\models\PdmMsSatuan::findOne($barbuk['id_satuan'])->nama ?>">
                    </td>
                    <td>
                    	<input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="<?= $barbuk['sita_dari'] ?>">
                    </td>
                    <td>
                    	<input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="<?= $barbuk['tindakan'] ?>">
                    </td>
                    <td>
                    	<input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="<?= $barbuk['id_stat_kondisi'] ?>">
                    	<input type="text" class="form-control" name="txtBarbukKondisi" readonly="true" value="<?= \app\modules\pidum\models\PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => \app\components\ConstDataComponent::KondisiBarang])->nama ?>">
                    </td>

                </tr>
            <?php
                endforeach;
            }
            ?>

            </tbody>
        </table>
        <div id="hapusBaris"></div>
	</div>
	

	<div class="box box-primary" style="border-color: #f39c12">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <div class="col-md-12">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label col-md-4">Upload File</label>
                        <div class="col-md-6">
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
                </div>
            </div>
        </div>
    </div>



	<div class="form-group hide">
            <label class="control-label col-md-2">Penanda Tangan</label>
            <div class="col-md-4">
                <?php 
                	echo $form->field($model, 'id_penandatangan')->dropDownList(
            			ArrayHelper::map(PdmPenandatangan::find()->all(), 'peg_nik', 'nama'), ['prompt' => 'Pilih Penandatangan']
            		)
				?>
               
            </div>
        </div>
	
    


    <?= $form->field($model, 'upload_file')->hiddenInput(['maxlength' => true]) ?>

    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
		<?php if(!$model->isNewRecord){ ?>
			<a class="btn btn-warning" id="cobax" href="#null" >Cetak</a>
		<?php } ?>
        <a type="button" id="draft" class='btn btn-warning'>Cetak Draft</a>
    </div>
        <div id="hiddenId"></div>

    <?php ActiveForm::end(); ?>

</div>
<?php
Modal::begin([
    'id' => 'm_jpu',
    'header' => '<h7>Tambah Jaksa Penerima</h7>'
]);
Modal::end();

Modal::begin([
    'id' => 'm_saksi',
    'header' => '<h7>Tambah Saksi</h7>'
]);
Modal::end();

Modal::begin([
    'id' => 'm_barbuk',
    'header' => 'Barang Bukti',
    'options' => [
        'data-url' => '',
    ],
]);
?>

<?=
$this->render('_popBarbuk')
?>

<?php
Modal::end();
?> 
<?php
$this->registerJs($script,View::POS_BEGIN);


$this->registerJs( "

    $('#draft').on('click', function(){
            var url    = '/pdsold/pdm-ba5/cetak-draft';
            window.open(url, '_blank');
            window.focus();
    });

    $(document).on('click', 'a#btn_hapus', function (e) {
    	var nip = $(this).attr('data-id');
        $(this).parent().parent().remove();
        return false;
    });

    $('a#cetakba').click(function(){
    	var kd = $(this).attr('data-kdbarbuk');
    	/*$.ajax({
                    type        : 'POST',
                    url         :'/pdsold/pdm-ba5/cetak',
                    data        : 'no_urut='+kd,                                
                    success     : function(data){
                                if(data>0){
                                    alert('Silahkan Simpan terlebih dahulu..');
                                }else{
                                	window.location.href = '/pdsold/pdm-ba5/cetak?no_urut='+kd;
                                }
                            }
                });*/
            var url    = '/pdsold/pdm-ba5/cetak?no_urut='+kd;  
			window.open(url, '_blank');
			window.focus();
    });

    $(document).on('click', 'a#btn_hapus_saksi', function (e) {
    	var nip = $(this).attr('data-id');
        $(this).parent().parent().remove();
        return false;
    });

	$('#popUpJpu').click(function(){
		$('#m_jpu').html('');
        $('#m_jpu').load('/pdsold/pdm-ba5/jpu');
        $('#m_jpu').modal('show');
	});

    $('#cobax').on('click', function(){
        var url    = '/pdsold/pdm-ba5/cetak';
        console.log('lolo');
        window.open(url, '_blank');
        //lampiran();
    });

    /*function lampiran(){
        console.log('lel');
        var url    = '/pdsold/pdm-ba5/cetak';
        window.open(url, '_blank');
    }*/


	$('#popUpSaksi').click(function(){
		$('#m_saksi').html('');
        $('#m_saksi').load('/pdsold/pdm-ba5/get-saksi');
        $('#m_saksi').modal('show');
	});

	$('#tmblhapusbaris').click(function(){

        $('#table_barbuk :checkbox:checked').each(function() {
            var idBarbuk = $(this).closest('tr').find('.idbarbuk').val();
            console.log(idBarbuk);
            $('#hapusBaris').append(
               '<input type=\"hidden\" id=\"hapus\" name=\"hapusIndex[]\" value=\"+idBarbuk+\">'
            );
        });

        jQuery('input:checkbox:checked').parents('tr').remove();
    });

	function hapusJpuPenerima(e){
		$('#jaksaPenerima-' + e).remove();
	}

	function hapusJpuSaksi(e){
		$('#jaksaSaksi-' + e).remove();
	}

	function hapusBarang(e){
		$('#' + e).remove();
	}

	function removeRow(e){
		$('#jaksa-' + e).remove();
	}

	function removeRowBarang(){
		$('#barbuk').remove();
	}


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
                    document.getElementById('pdmba5-file_upload').value = mime+btoa(binaryString);
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


    $('#tambahSaksiLuar').click(function () {
        var trCount = $('#table_saksi_penerima tr').length;
        $('#table_saksi_penerima').append(
                '<tr id=\"trsaksi-'+trCount+'\">' +
                '<td><input type=\"text\" name=\"saksi-no_urut_news[]\" style=\"width: 50px;\" class=\"form-control\" value='+trCount+'></td>' +
                '<td><input type=\"text\" class=\"form-control\" name=\"saksi-peg_nip_news[]\"  value=\"\"> </td>' +
                '<td><input type=\"text\" class=\"form-control\" name=\"saksi-peg_nama_news[]\" value=\"\"> </td>' +
                '<td><input type=\"text\" class=\"form-control\" name=\"saksi-pangkat_news[]\"  value=\"\"> </td>' +
                '<td><input type=\"text\" class=\"form-control\" name=\"saksi-jabatan_news[]\"  value=\"\"> </td>' +
                '<td id=\"tdJPU\"><a class=\"btn btn-danger delete\" data-id=\"trsaksi'+trCount+'\" id=\"btn_hapus_saksi\"></a></td>' +
                '<input type=\"hidden\" name=\"saksi-peg_nip_news[]\" value=\"trsaksi-'+trCount+'\" >'+
                '</tr>'
        );
    });

    $(document).ready(function(){
  
	

}); ", \yii\web\View::POS_END);
?>

<!-- $('#tambahBarbuk').click(function(){
         
          $('#tbody-barbuk').append(
			'<tr id=\"barbuk\">'+
				'<td><a id=\"hapus-jpu\" class=\"btn btn-danger\" onclick=\"removeRowBarang()\">Hapus</a></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"berupa[]\"></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"tindakan[]\"></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"jumlah[]\"></td>'+
				'<td><input type=\"text\" class=\"form-control\" name=\"id_satuan[]\"></td>'+
			'</tr>');
           

      }); -->