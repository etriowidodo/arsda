<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>

<?php ActiveForm::begin(['action'=>['getlistsaksi'], 'method'=>'get', 'id'=>'searchPds14UModal', 'options'=>['name'=>'searchPds14UModal', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
                	<input type="text" name="mpds14u_q1" id="mpds14u_q1" class="form-control" placeholder="Pencarian..." />
                    <input type="hidden" name="perihal" id="perihal" value="<?php echo $perihal;?>" />
                    <div class="input-group-btn">
                        <button class="btn btn-warning" type="submit" name="btnCariM1" id="btnCariM1">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-pds14u" style="margin-left:10px;">Reset Pencarian</a>
                    </div>
                </div>
			</div>                    
		</div>
	</div>
	<div class="col-md-1"></div>
</div> 
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="modal-pds14u-index">
	<div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjaxModalPds14u', 'timeout' => false, 'formSelector' => '#searchPds14UModal', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'table-pds14u-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurldecode($data['nama'])."#".rawurldecode($data['alamat'])."#".rawurldecode($data['keterangan']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tgl Pidsus-14 Umum',
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['tgl_pidsus14_umum']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Saksi/ Ahli',
					'value'=>function($data){
						return $data['nama'].($data['jabatan']?'<br />'.$data['jabatan']:'');
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa yang Melaksanakan ',
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['nip_jaksa'].'</p><p style="margin-bottom:0px;">'.$data['nama_jaksa'].'</p>';
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Waktu Pelaksanaan/ Keperluan',
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['waktu_pelaksanaan'])).'<br />'.$data['keperluan'];
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Aksi', 
					'value'=>function($data, $index){
						$idnya = rawurldecode($data['nama'])."#".rawurldecode($data['alamat'])."#".rawurldecode($data['keterangan']);
						return '<input type="radio" name="selection_one_saksi[]" id="selection_one_saksi'.($index+1).'" value="'.$idnya.'" class="selection_one_saksi"  />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
    </div>
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih-pds14u" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
	<div class="modal-loading-new"></div> 
    <div class="hide" id="filter-link-pds14u"></div>
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
	
	$("#myPjaxModalPds14u").on('pjax:send', function(){
		$(".modal-pds14u-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-pds14u-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihTtdModal").addClass("disabled");
	});

	$(".modal-pds14u-index").on("ifChecked", "input[name=selection_all_saksi]", function(){
		$(".selection_one_saksi").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selection_all_saksi]", function(){
		$(".selection_one_saksi").not(':disabled').iCheck("uncheck");
	});
        
	$(".reset-cari-pds14u").on("click", function(){
		$("#mpds14u_q1").val("");
		$("#searchPds14UModal").trigger("submit");
	});
});
</script>