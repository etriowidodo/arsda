<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<div class="modal-tsk-index">
	<p style="margin-bottom:-15px;" class="text-right"><a class="btn btn-warning btn-sm disabled" id="idPilihTskModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a></p>
    <div id="#wrapper-table">
	<?php
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'table-tsk-modal'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_urut']).'#'.rawurlencode($data['nama']).'#'.rawurlencode($data['tmpt_lahir']).'#'.
						 rawurlencode(($data['tgl_lahir']?date("d-m-Y", strtotime($data['tgl_lahir'])):'')).'#'.rawurlencode(($data['umur']?$data['umur']:'')).'#'.
						 rawurlencode($data['warganegara']).'#'.rawurlencode($data['kebangsaan']).'#'.rawurlencode($data['suku']).'#'.
						 rawurlencode($data['id_identitas']).'#'.rawurlencode($data['no_identitas']).'#'.rawurlencode($data['id_jkl']).'#'.
						 rawurlencode($data['id_agama']).'#'.rawurlencode($data['alamat']).'#'.rawurlencode($data['no_hp']).'#'.
						 rawurlencode(($data['id_pendidikan']>=0?$data['id_pendidikan']:"")).'#'.rawurlencode($data['pekerjaan']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:42%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:42%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tempat dan Tanggal Lahir', 
					'value'=>function($data){
						return ($data['tmpt_lahir']?$data['tmpt_lahir']:'').($data['tgl_lahir']?', '.date("d-m-Y", strtotime($data['tgl_lahir'])):'');
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Pilih', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_urut']).'#'.rawurlencode($data['nama']).'#'.rawurlencode($data['tmpt_lahir']).'#'.
								 rawurlencode(($data['tgl_lahir']?date("d-m-Y", strtotime($data['tgl_lahir'])):'')).'#'.rawurlencode(($data['umur']?$data['umur']:'')).'#'.
								 rawurlencode($data['warganegara']).'#'.rawurlencode($data['kebangsaan']).'#'.rawurlencode($data['suku']).'#'.
								 rawurlencode($data['id_identitas']).'#'.rawurlencode($data['no_identitas']).'#'.rawurlencode($data['id_jkl']).'#'.
								 rawurlencode($data['id_agama']).'#'.rawurlencode($data['alamat']).'#'.rawurlencode($data['no_hp']).'#'.
								 rawurlencode(($data['id_pendidikan']>=0?$data['id_pendidikan']:"")).'#'.rawurlencode($data['pekerjaan']);
						return '<input type="radio" name="pilih-tsk-modal[]" id="pilih-tsk-modal'.($index+1).'" value="'.$idnya.'" class="pilih-tsk-modal" />';
					}, 
				],
			],
		]);
    ?>
    </div>

    <div class="modal-loading-new"></div>
</div>

<style>
	.modal-tsk-index.loading {overflow: hidden;}
	.modal-tsk-index.loading .modal-loading-new {display: block;}
	ul.pagination {margin:0px;}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: inherit;
		font-size: inherit;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
	$(".modal-tsk-index").on("ifChecked", ".pilih-tsk-modal", function(){
		$("#idPilihTskModal").removeClass("disabled");
	});
});
</script>