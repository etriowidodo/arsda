<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\GetTtd;
?>

<?php ActiveForm::begin(['action'=>['getspdp'], 'method'=>'get', 'id'=>'searchModalSpdp', 'options'=>['name'=>'searchModalSpdp', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-10 col-md-offset-1">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
					<input type="text" name="mspdp_q1" id="mspdp_q1" class="form-control" placeholder="Pencarian..." />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="modal-spdp-index">

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjaxModalSpdp', 'timeout' => false, 'formSelector' => '#searchModalSpdp', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'table-spdp-modal'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['no_spdp'].'#'.date("d-m-Y", strtotime($data['tgl_spdp'])).'#'.date("d-m-Y", strtotime($data['tgl_terima'])).'#'.$data['nama_inst_penyidik'].'#'.
						 $data['nama_inst_pelaksana'].'#'.$data['tgl_kejadian_perkara'].'#'.$data['tempat_kejadian'];
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'header'=>'No', 
					'class' => 'yii\grid\SerialColumn',
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:84%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor dan Tanggal SPDP', 
					'value'=>function($data){
						return $data['no_spdp'].', Tanggal '.date("d-m-Y", strtotime($data['tgl_spdp']));
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Pilih', 
					'value'=>function($data, $index){
						$idnya = $data['no_spdp'].'#'.date("d-m-Y", strtotime($data['tgl_spdp'])).'#'.date("d-m-Y", strtotime($data['tgl_terima'])).'#'.
								 $data['nama_inst_penyidik'].'#'.$data['nama_inst_pelaksana'].'#'.$data['tgl_kejadian_perkara'].'#'.$data['tempat_kejadian'];
						return '<input type="radio" name="pilih-spdp-modal[]" id="pilih-spdp-modal'.($index+1).'" value="'.$idnya.'" class="pilih-spdp-modal" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center"><a class="btn btn-warning btn-sm disabled" id="idPilihSpdpModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a></p>
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-spdp"></div>
</div>

<style>
	.modal-spdp-index.loading {overflow: hidden;}
	.modal-spdp-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalSpdp").on('pjax:send', function(){
		$(".modal-spdp-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-spdp-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihSpdpModal").addClass("disabled");
	});

	$(".modal-spdp-index").on("ifChecked", ".pilih-spdp-modal", function(){
		$("#idPilihSpdpModal").removeClass("disabled");
	});
});
</script>