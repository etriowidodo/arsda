<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getsaksi'], 'method'=>'get', 'id'=>'searchModalGetSaksi', 'options'=>['name'=>'searchModalGetSaksi']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="hidden" name="keperluan" id="keperluan" value="<?php echo $keperluan;?>" />
					<input type="text" name="mb4_q1" id="mb4_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearchMpds14u" id="btnSearchMpds14u">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-mpds14u" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="modal-pds14u-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalPds14U', 'timeout' => false, 'formSelector' => '#searchModalGetSaksi', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tabel-pidsus14-umum-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['nama']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama / Jabatan', 
					'value'=>function($data){
						return $data['nama'].($data['jabatan']?'<br />'.$data['jabatan']:'');
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Waktu Pelaksanaan', 
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['waktu_pelaksanaan']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Yang Melaksanakan', 
					'value'=>function($data){
						return $data['nip_jaksa'].'<br />'.$data['nama_jaksa'];
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Keperluan', 
					'value'=>function($data){
						return $data['keperluan'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['nama']);
						return '<input type="radio" name="pilih-pidsus14-umum-modal[]" id="pilih-pidsus14-umum-modal'.($index+1).'" value="'.$idnya.'" class="pilih-pidsus14-umum-modal" />';
					}, 
				],
            ],
        ]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihPIDSUS14UModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalPIDSUS14UModal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-Pds14U-modal"></div>
</div>

<style>
	.modal-pds14u-index.loading {overflow: hidden;}
	.modal-pds14u-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalPds14U").on('pjax:send', function(){
		$(".modal-pds14u-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-pds14u-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihPIDSUS14UModal").addClass("disabled");
	});

	$(".modal-pds14u-index").on("ifChecked", ".pilih-pidsus14-umum-modal", function(){
		$("#idPilihPIDSUS14UModal").removeClass("disabled");
	});

	$(".reset-cari-mpds14u").on("click", function(){
		$("#mb4_q1").val("");
		$("#searchModalGetSaksi").trigger("submit");
	});
});
</script>
