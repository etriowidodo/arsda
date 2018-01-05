<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	//use mdm\admin\models\searchs\Menu as MenuSearch;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
?>

<?php ActiveForm::begin(['action'=>['get_ttd'], 'method'=>'get', 'id'=>'searchModalTtd', 'options'=>['name'=>'searchModalTtd', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-2">
		<div class="form-group">
			<div class="col-md-12">
				<select id="mttd_q2" name="mttd_q2" style="width:100%;">
					<option></option>
                    <option value="Asli">Asli</option>
                    <option value="Plt">Plt</option>
                    <option value="Plh">Plh</option>
                    <option value="A.N">A.N</option>
				</select>
			</div>                    
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<div class="col-md-12">
				<select id="mttd_q3" name="mttd_q3" style="width:100%;">
					<option></option>
					<?php 
						$sqlnya = "select kode, deskripsi from datun.m_penandatangan where kode_tk = '".$_SESSION['kode_tk']."' order by kode";
						$resOpt = MenuSearch::findBySql($sqlnya)->asArray()->all();
						foreach($resOpt as $dOpt){
							echo '<option value="'.$dOpt['kode'].'">'.$dOpt['deskripsi'].'</option>';
						}
					?>
				</select>
			</div>                    
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
					<input type="text" name="mttd_q1" id="mttd_q1" class="form-control" placeholder="Pencarian..." />
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

<div class="modal-ttd-index">

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjaxModalTtd', 'timeout' => false, 'formSelector' => '#searchModalTtd', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'table-ttd-modal'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['status'].'#'.$data['nip'].'#'.$data['nama'].'#'.$data['jabatan'].'#'.$data['gol_kd'].'#'.$data['pangkat'].'#'.$data['ttd_jabat'];
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:28%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'NIP / Nama', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['nip'].'</p><p style="margin-bottom:0px;">'.$data['nama'].'</p>';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pangkat / Jabatan (Pejabat)', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['gol_kd'].' '.$data['pangkat'].'</p><p style="margin-bottom:0px;">'.$data['jabatan'].'</p>';
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status / Jabatan (Tandatangan)', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['status'].'</p><p style="margin-bottom:0px;">'.$data['ttd_jabat'].'</p>';
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:7%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Pilih', 
					'value'=>function($data, $index){
						$idnya = $data['status'].'#'.$data['nip'].'#'.$data['nama'].'#'.$data['jabatan'].'#'.$data['gol_kd'].'#'.$data['pangkat'].'#'.$data['ttd_jabat'];
						return '<input type="radio" name="pilih-ttd-modal[]" id="pilih-ttd-modal'.($index+1).'" value="'.$idnya.'" class="pilih-ttd-modal" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center"><a class="btn btn-warning btn-md disabled" id="idPilihTtdModal">Pilih</a></p>
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-ttd"></div>
</div>

<style>
	.modal-ttd-index.loading {overflow: hidden;}
	.modal-ttd-index.loading .modal-loading-new {display: block;}
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
	$("#mttd_q2").select2({placeholder: "Pilih Status TTD", allowClear: true});
	$("#mttd_q3").select2({placeholder: "Pilih Jabatan TTD", allowClear: true});
	$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-blue'});
	
	$("#myPjaxModalTtd").on('pjax:send', function(){
		$(".modal-ttd-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-ttd-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-blue'});
		$("#idPilihTtdModal").addClass("disabled");
	});

	$(".modal-ttd-index").on("ifChecked", ".pilih-ttd-modal", function(){
		$("#idPilihTtdModal").removeClass("disabled");
	});
});
</script>