<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;

require('..\modules\pidsus\controllers\viewFormFunction.php');
$viewFormFunction=new viewFormFunction();
$idSatker=$_SESSION['idSatkerUser'];
/* @var $this yii\web\View */
/* @var $model app\models\PdsDik */
/* @var $form yii\widgets\ActiveForm */
$sqlLokasi="Select distinct inst_lokinst from kepegawaian.kp_inst_satker";
$sqlPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlAtasanPenerimaSurat="select * from pidsus.get_penerima_laporan ('".$idSatker."') order by nama_penerima_lap";
$sqlJenisKasus="select id_detail, nama_detail from pidsus.parameter_detail where id_header=9";
//$sqlStatusSelesai = "select id_detail, nama_detail from pidsus.parameter_detail where id_header=47";
//echo $_SESSION['idPdsTut'];
//echo $_SESSION['idPdsDik'];
?>

<div class="pds-dik-form">


	<div class="box box-primary">
		<div class="box-header">

		</div>
		<?php $form = ActiveForm::begin(
			[
				'id' => 'surat-form',
				'type' => ActiveForm::TYPE_HORIZONTAL,
				'enableAjaxValidation' => false,
				'fieldConfig' => [
					'autoPlaceholder'=>false
				],
				'formConfig' => [
					'deviceSize' => ActiveForm::SIZE_LARGE,
					'labelSpan' => 1,
					'showLabels'=>false

				]
			]); ?>

		<div>
			<?= $viewFormFunction->returnSelect2($sqlJenisKasus,$form,$model,'jenis_kasus','Kasus','id_detail','nama_detail','','jenis_kasus','full')?>
			<div class="form-group">
				<label for="asal_surat" class="control-label col-md-3">Asal SPDP</label>
				<div class="col-md-6"><?= $form->field($model, 'asal_spdp')->textInput(['readonly' => false]) ?></div>
			</div>
			<div class="form-group">
				<label for="No_SPDP" class="control-label col-md-3">Nomor SPDP</label>
				<div class="col-md-6"><?= $form->field($model, 'no_spdp')->textInput(['readonly' => false]) ?></div>
			</div>

			<div class="form-group">
				<label for="tgl_surat" class="control-label col-md-3">Tanggal SPDP</label>
				<div class="col-md-6"><?=
					$form->field($model, 'tgl_spdp')->widget(DateControl::classname(), [
						'type'=>DateControl::FORMAT_DATE,
						'ajaxConversion'=>false,
						'options' => [
							'pluginOptions' => [
								'autoclose' => true, 'startDate' => $_SESSION['globalStartDate'], 'endDate' => $_SESSION['todayDate'],
								'mask' => 'Pilih Tanggal...',
							]
						],
						'readonly'=>false
					])?>
				</div>
			</div>
			<div class="form-group">
				<label for="tgl_diterima" class="control-label col-md-3">Tanggal Diterima</label>
				<div class="col-md-6"><?=
					$form->field($model, 'tgl_diterima')->widget(DateControl::classname(), [
						'type'=>DateControl::FORMAT_DATE,
						'ajaxConversion'=>false,
						'options' => [
							'pluginOptions' => [
								'autoclose' => true, 'startDate' => $_SESSION['globalStartDate'], 'endDate' => $_SESSION['todayDate'],
								'mask' => 'Pilih Tanggal...',
							]
						],
						'readonly'=>false
					])?>
				</div>
			</div>
			<div class="form-group">
				<label for="perihal" class="control-label col-md-3">Perihal</label>
				<div class="col-md-6"><?= $form->field($model, 'perihal_spdp')->textInput(['readonly' => false]) ?></div>
			</div>



			<div class="form-group">
				<label for="isi" class="control-label col-md-3">Pasal Dugaan</label>
				<div class="col-md-6"><?= $form->field($model, 'dugaan_pasal')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => false)) ?></div>
			</div>
			
			<div class="box box-primary" style="border-color: #f39c12">
												<div class="box-header with-border" style="border-color: #c7c7c7;">
													<div class="col-md-6" style="padding: 0px;">
														<h3 class="box-title"> <a class="btn btn-primary" id="tambah_calon_tersangka"><i
																	class="glyphicon glyphicon-plus"></i> Tambah Calon Tersangka</a></h3>
													</div>



												</div>
												<div class="box-header with-border">
													<table id="table_tersangka" class="table table-bordered">
														<thead>
														<tr>
															<th>Nama Tersangka</th>
															<th>Nomor Id</th>
															<th></th>
														</tr>
														</thead>
														<tbody id="tbody_tersangka">

														<?php
														//echo 'aaa';
														if ($modelTersangkaUpdate != null) {
															foreach ($modelTersangkaUpdate as $key => $value) {
																echo "<tr id='tr_id".$value['id_pds_tut_tersangka']."'>
                                <td>" . $value['nama_tersangka'] . "</td>
								<td>".$value['nomor_id']."</td>
                                <td><span class='glyphicon glyphicon-pencil' onclick='editTersangka(\"".$value['id_pds_tut_tersangka']."\")'></span><a class='btn btn-danger btn-sm glyphicon glyphicon-remove hapus' onclick='hapusTersangka(\"".$value['id_pds_tut_tersangka']."\")'></a></td>
                              </tr>";

															}
														}
														?>

														</tbody>
													</table>
												</div>
											</div>
											<div id="hiddenId"></div>
											
			<div class="form-group">
				<label for="isi" class="control-label col-md-3">Kasus Posisi</label>
				<div class="col-md-6"><?= $form->field($model, 'kasus_posisi')->textArea(array('maxlength' => 4000, 'rows' => 6, 'cols' => 50,'readonly' => false)) ?></div>
			</div>
			<?= $viewFormFunction->returnSelect2($sqlPenerimaSurat,$form,$model,'penerima_spdp','Penerima Laporan','id_penerima_lap','nama_penerima_lap','Penerima Laporan ...','penerima_spdp','full')?>
			<?= $viewFormFunction->returnSelect2($sqlAtasanPenerimaSurat,$form,$model,'atasan_penerima_spdp','Atasan Penerima Laporan','id_penerima_lap','nama_penerima_lap','Atasan Penerima Laporan ...','atasan_penerima_spdp','full')?>
		</div>
		<div class="box-footer">
			<div class="col-md-<?= $model->isNewRecord ? '7' : '6' ?>">
				<?php //$viewFormFunction->returnDropDownListStatus($form,$model,$model->id_status)?>
			</div>
			<div class="col-md-1">
				<?= Html::submitButton( 'Simpan', ['class' => 'btn btn-primary', 'name'=>'btnSubmit', 'value'=>'simpan','id' => 'btnSimpan']) ?>
			</div>
			<div class="col-md-1">
				<?=Html::a('Batal',$model->isNewRecord ? ['index?type=pratut'] : ['../pidsus/tut/index?type=pratut'], ['data-pjax'=>0, 'class' => 'btn btn-danger', 'title'=>'cancel','id' => 'btnCancel']) ?>
			</div>

		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>



<?php
Modal::begin([
	'id' => 'm_tersangka',
	'header' => '<h7>Tambah Tersangka</h7>'
]);
//echo $this->render('_popTersangka', ['modelTersangka' => $modelTersangka]);
Modal::end();
?>

<?php
$script = <<< JS
        $('#tambah_calon_tersangka').click(function(){
            $('#m_tersangka').html('');
            $('#m_tersangka').load('/pidsus/tut/show-tersangka');
            $('#m_tersangka').modal('show');
        });




JS;
$this->registerJs($script);
?>
<script>
	function hapusTersangka(id)
	{
		if(confirm("Hapus Data Tersangka?")){
			$.get("delete-tersangka?id="+id);
			$("#tr_id"+id).remove();
			
		}
	}
	function hapusTersangkaOld(id)
	{
		if(confirm("Hapus Data Tersangka?")){
			$.get("delete-tersangka?id="+id);
			$("#tr_id"+id).remove();
			
		}
	}
	function editTersangka(id)
	{
		 $('#m_tersangka').html('');
         $('#m_tersangka').load('/pidsus/tut/edit-tersangka?id='+id);
         $('#m_tersangka').modal('show');
	}	
</script>
