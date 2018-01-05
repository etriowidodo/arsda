<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getb4'], 'method'=>'get', 'id'=>'searchModalGetB4', 'options'=>['name'=>'searchModalGetB4']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mb4_q1" id="mb4_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearchMb4" id="btnSearchMb4">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-mb4" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="modal-b4-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalB4', 'timeout' => false, 'formSelector' => '#searchModalGetB4', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tabel-b4-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_b4_umum']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:45%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor B-4 Umum', 
					'value'=>function($data){
						return $data['no_b4_umum'];
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal B-4 Umum', 
					'value'=>function($data){
						return date('d-m-Y',strtotime($data['tgl_dikeluarkan']));
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_b4_umum']);
						return '<input type="radio" name="pilih-b4-modal[]" id="pilih-b4-modal'.($index+1).'" value="'.$idnya.'" class="pilih-b4-modal" />';
					}, 
				],
            ],
        ]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihB4Modal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalB4Modal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-b4-modal"></div>
</div>

<style>
	.modal-b4-index.loading {overflow: hidden;}
	.modal-b4-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalB4").on('pjax:send', function(){
		$(".modal-b4-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-b4-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihB4Modal").addClass("disabled");
	});

	$(".modal-b4-index").on("ifChecked", ".pilih-b4-modal", function(){
		$("#idPilihB4Modal").removeClass("disabled");
	});

	$(".reset-cari-mb4").on("click", function(){
		$("#mb4_q1").val("");
		$("#searchModalGetB4").trigger("submit");
	});

	$("#idBatalB4Modal").on("click", function(){
		$("#b4_modal").modal("hide");
	});
});
</script>
