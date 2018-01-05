<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getp6'], 'method'=>'get', 'id'=>'searchModalGetP6', 'options'=>['name'=>'searchModalGetP6']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mp6_q1" id="mp6_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearchMp6" id="btnSearchMp6">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-mp6" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="modal-p6-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalP6', 'timeout' => false, 'formSelector' => '#searchModalGetP6', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tabel-p6-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_urut_p6']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_p6']))).'|#|'.
						 rawurlencode($data['nip_jaksa']).'|#|'.rawurlencode($data['nama_jaksa']).'|#|'.rawurlencode($data['pangkat_jaksa']).'|#|'.
						 rawurlencode($data['jabatan_jaksa']).'|#|'.rawurlencode($data['tindak_pidana']).'|#|'.rawurlencode($data['dilakukan_oleh']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal P6', 
					'value'=>function($data){
						return date('d-m-Y',strtotime($data['tgl_p6']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Pembuat Laporan', 
					'value'=>function($data){
						return $data['nip_jaksa'].'<br/>'.$data['nama_jaksa'].'<br/>'.$data['pangkat_jaksa'];
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tindak Pidana', 
					'value'=>function($data){
						return $data['tindak_pidana'];
					}, 
				],
				'5'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Diduga dilakukan oleh', 
					'value'=>function($data){
						return $data['dilakukan_oleh'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_urut_p6']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_p6']))).'|#|'.
								 rawurlencode($data['nip_jaksa']).'|#|'.rawurlencode($data['nama_jaksa']).'|#|'.rawurlencode($data['pangkat_jaksa']).'|#|'.
								 rawurlencode($data['jabatan_jaksa']).'|#|'.rawurlencode($data['tindak_pidana']).'|#|'.rawurlencode($data['dilakukan_oleh']);
						return '<input type="radio" name="pilih-p6-modal[]" id="pilih-p6-modal'.($index+1).'" value="'.$idnya.'" class="pilih-p6-modal" />';
					}, 
				],
            ],
        ]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihP6Modal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalP6Modal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-p6-modal"></div>
</div>

<style>
	.modal-p6-index.loading {overflow: hidden;}
	.modal-p6-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalP6").on('pjax:send', function(){
		$(".modal-p6-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-p6-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihP6Modal").addClass("disabled");
	});

	$(".modal-p6-index").on("ifChecked", ".pilih-p6-modal", function(){
		$("#idPilihP6Modal").removeClass("disabled");
	});

	$(".reset-cari-mp6").on("click", function(){
		$("#mp6_q1").val("");
		$("#searchModalGetP6").trigger("submit");
	});

	$("#idBatalP6Modal").on("click", function(){
		$("#p6_modal").modal("hide");
	});
});
</script>
