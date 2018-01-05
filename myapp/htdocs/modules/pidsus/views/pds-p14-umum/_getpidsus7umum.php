<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getpidsus7umum'], 'method'=>'get', 'id'=>'searchModalGetpidsus7umum', 'options'=>['name'=>'searchModalGetpidsus7umum']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mpds7u_q1" id="mpds7u_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearchMba1u" id="btnSearchMba1u">Cari</button>
                                                <a class="btn btn-info btn-flat reset-cari-mba1u" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="modal-pds7u-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalpds7u', 'timeout' => false, 'formSelector' => '#searchModalGetpidsus7umum', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'tabel-pds7u-modal'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_pidsus7_umum'])."|#|".rawurlencode(date("d-m-Y", strtotime($data['tgl_pidsus7'])));
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'header'=>'No', 
					'class' => 'yii\grid\SerialColumn',
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal Pidsus-7 Umum', 
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['tgl_pidsus7']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal Expose', 
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['tgl_ekspose']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Penelaah', 
					'value'=>function($data){
						$text = '<p style="margin-bottom:0px;">'.$data['nip_jaksa'].'<br />'.$data['nama_jaksa'].'</p>';
						return $text;
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_pidsus7_umum'])."|#|".rawurlencode(date("d-m-Y", strtotime($data['tgl_pidsus7'])));
						return '<input type="radio" name="pilih_pds7u_modal[]" id="pilih_pds7u_modal'.($index+1).'" value="'.$idnya.'" class="pilih_pds7u_modal" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihpds7UModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalpds7UModal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-ba1u-modal"></div>
</div>

<style>
	.modal-pds7u-index.loading {overflow: hidden;}
	.modal-pds7u-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalpds7u").on('pjax:send', function(){
		$(".modal-pds7u-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-pds7u-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihpds7UModal").addClass("disabled");
	});

	$(".modal-pds7u-index").on("ifChecked", ".pilih_pds7u_modal", function(){
		$("#idPilihpds7UModal").removeClass("disabled");
	});

	$(".reset-cari-mba1u").on("click", function(){
		$("#mpds7u_q1").val("");
		$("#searchModalGetpidsus7umum").trigger("submit");
	});

	$("#idBatalpds7UModal").on("click", function(){
		$("#get_pidsus7_umum_modal").modal("hide");
	});
});
</script>
