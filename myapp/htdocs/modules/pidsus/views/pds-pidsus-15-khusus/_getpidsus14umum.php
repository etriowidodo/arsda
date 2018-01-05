<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getpidsus14umum'], 'method'=>'get', 'id'=>'searchModalGetpidsus14umum', 'options'=>['name'=>'searchModalGetpidsus14umum']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mpds14u_q1" id="mpds14u_q1" class="form-control" />
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
        Pjax::begin(['id' => 'myPjaxModalPds14U', 'timeout' => false, 'formSelector' => '#searchModalGetpidsus14umum', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tabel-pidsus14-umum-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_urut_pidsus14_umum']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_pidsus14_umum'])));
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal Pidsus-14 Umum', 
					'value'=>function($data){
						return date('d-m-Y',strtotime($data['tgl_pidsus14_umum']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:75%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Saksi/Ahli', 
					'value'=>function($data){
						$temp = explode('|#|', $data['saksinya']);
						$text = '';
						if(count($temp) > 0 && count($temp) == 1){
							$isian = explode("#", $temp[0]);
							$tgnya = date("d-m-Y", strtotime($isian[2]));
							if($isian[0]) $text .= '<p style="margin-bottom:0px;">'.$isian[0].' tanggal pelaksanaan '.$tgnya.'</p>';
						} else if(count($temp) > 0 && count($temp) != 1){
							foreach($temp as $idx=>$res){
								$nom = $idx+1;
								$isian = explode("#", $res);
								$tgnya = date("d-m-Y", strtotime($isian[2]));
								$text .= '
								<div style="margin-bottom: 5px; width: 100%; display: table;">
									<div style="display: table-cell; width: 23px;">'.$nom.'.</div>
									<div style="display: table-cell;">'.$isian[0].' tanggal pelaksanaan '.$tgnya.'</div>
								</div>';
							}
						}
						return $text;
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_urut_pidsus14_umum']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_pidsus14_umum'])));
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
		$("#mpds14u_q1").val("");
		$("#searchModalGetpidsus14umum").trigger("submit");
	});

	$("#idBatalPIDSUS14UModal").on("click", function(){
		$("#pidsus14_umum_modal").modal("hide");
	});
});
</script>
