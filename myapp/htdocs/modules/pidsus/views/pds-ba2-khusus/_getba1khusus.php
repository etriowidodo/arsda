<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getba1khusus'], 'method'=>'get', 'id'=>'searchModalGetba1khusus', 'options'=>['name'=>'searchModalGetba1khusus']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mba1u_q1" id="mba1u_q1" class="form-control" />
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

<div class="modal-ba1u-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalba1u', 'timeout' => false, 'formSelector' => '#searchModalGetba1khusus', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'tabel-ba1u-modal'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_ba1_khusus'])."|#|".rawurlencode(date("d-m-Y",strtotime($data['tgl_ba1_khusus'])))."|#|".
						 rawurlencode($data['nip_jaksa'])."|#|".rawurlencode($data['nama_jaksa'])."|#|".rawurlencode($data['pangkat_jaksa'])."|#|".
						 rawurlencode($data['nama'])."|#|".rawurlencode($data['tmpt_lahir'])."|#|".rawurlencode(date("d-m-Y",strtotime($data['tgl_lahir'])))."|#|".
						 rawurlencode($data['id_jkl'])."|#|".rawurlencode($data['warganegara'])."|#|".rawurlencode($data['kebangsaan'])."|#|".
						 rawurlencode($data['alamat'])."|#|".rawurlencode($data['id_agama'])."|#|".rawurlencode($data['agama'])."|#|".rawurlencode($data['pekerjaan'])."|#|".
						 rawurlencode($data['id_pendidikan'])."|#|".rawurlencode($data['pendidikan'])."|#|".rawurlencode($data['umur']);
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
					'header'=>'Tanggal BA-1 Khusus', 
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['tgl_ba1_khusus']))."<br />".$data['tempat'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Penyidik', 
					'value'=>function($data){
						return $data['nip_jaksa']."<br />".$data['nama_jaksa']."<br />".$data['pangkat_jaksa'];
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Saksi', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_ba1_khusus'])."|#|".rawurlencode(date("d-m-Y",strtotime($data['tgl_ba1_khusus'])))."|#|".
								 rawurlencode($data['nip_jaksa'])."|#|".rawurlencode($data['nama_jaksa'])."|#|".rawurlencode($data['pangkat_jaksa'])."|#|".
								 rawurlencode($data['nama'])."|#|".rawurlencode($data['tmpt_lahir'])."|#|".rawurlencode(date("d-m-Y",strtotime($data['tgl_lahir'])))."|#|".
								 rawurlencode($data['id_jkl'])."|#|".rawurlencode($data['warganegara'])."|#|".rawurlencode($data['kebangsaan'])."|#|".
								 rawurlencode($data['alamat'])."|#|".rawurlencode($data['id_agama'])."|#|".rawurlencode($data['pekerjaan'])."|#|".
								 rawurlencode($data['id_pendidikan'])."|#|".rawurlencode($data['umur']);
						return '<input type="radio" name="pilih_ba1u_modal[]" id="pilih_ba1u_modal'.($index+1).'" value="'.$idnya.'" class="pilih_ba1u_modal" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihba1UModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalba1UModal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-ba1u-modal"></div>
</div>

<style>
	.modal-ba1u-index.loading {overflow: hidden;}
	.modal-ba1u-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalba1u").on('pjax:send', function(){
		$(".modal-ba1u-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-ba1u-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihba1UModal").addClass("disabled");
	});

	$(".modal-ba1u-index").on("ifChecked", ".pilih_ba1u_modal", function(){
		$("#idPilihba1UModal").removeClass("disabled");
	});

	$(".reset-cari-mba1u").on("click", function(){
		$("#mba1u_q1").val("");
		$("#searchModalGetba1khusus").trigger("submit");
	});

	$("#idBatalba1UModal").on("click", function(){
		$("#get_ba1_khusus_modal").modal("hide");
	});
});
</script>
