<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\GetKewarganegaraan;
?>

<?php ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchModalWgn', 'options'=>['name'=>'searchModalWgn', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="form-group">
            <div class="input-group">
                <input type="text" name="mwgn_q1" id="mwgn_q1" class="form-control" placeholder="Pencarian..." />
                <div class="input-group-btn">
                    <button type="submit" class="btn btn-warning" name="btnSearchMWgn" id="btnSearchMWgn">Cari</button>
                    <a class="btn btn-info btn-flat reset-cari-mwgn" style="margin-left:10px;">Reset Pencarian</a>
                </div>
            </div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="modal-wgn-index">

	<!--<p style="margin-bottom:-15px;" class="text-right"><a class="btn btn-warning btn-sm disabled" id="idPilihWgnModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a></p>-->
    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjaxModalWgn', 'timeout' => false, 'formSelector' => '#searchModalWgn', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'table-wgn-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['id']).'#'.rawurlencode($data['nama']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:80%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Warga Negara', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
//				'aksi'=>[
//					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
//					'contentOptions'=>['class'=>'text-center aksinya'],
//					'format'=>'raw',
//					'header'=>'Pilih', 
//					'value'=>function($data, $index){
//						$idnya = rawurlencode($data['id']).'#'.rawurlencode($data['nama']);
//						return '<input type="radio" name="pilih-wgn-modal[]" id="pilih-wgn-modal'.($index+1).'" value="'.$idnya.'" class="pilih-wgn-modal" />';
//					}, 
//				],
			],
		]);
		Pjax::end();
    ?>
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-ttd"></div>
</div>

<style>
	.modal-wgn-index.loading {overflow: hidden;}
	.modal-wgn-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalWgn").on('pjax:send', function(){
		$(".modal-wgn-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-wgn-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihWgnModal").addClass("disabled");
	});

	$(".modal-wgn-index").on("ifChecked", ".pilih-wgn-modal", function(){
		$("#idPilihWgnModal").removeClass("disabled");
	});
	
	$(".reset-cari-mwgn").on("click", function(){
		$("#mwgn_q1").val("");
		$("#searchModalWgn").trigger("submit");
	});

});
</script>