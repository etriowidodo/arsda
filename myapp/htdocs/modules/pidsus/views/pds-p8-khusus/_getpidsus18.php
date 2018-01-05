<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getpidsus18'], 'method'=>'get', 'id'=>'searchModalGetPidsus18', 'options'=>['name'=>'searchModalGetPidsus18']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mpidsus18_q1" id="mpidsus18_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearchMpidsus18" id="btnSearchMpidsus18">Cari</button>
                                                <a class="btn btn-info btn-flat reset-cari-mpidsus18" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="modal-pidsus18-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalPidsus18', 'timeout' => false, 'formSelector' => '#searchModalGetPidsus18', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tabel-pidsus18-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_pidsus18']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_pidsus18']))).'|#|'.
                                         rawurlencode($data['no_p8_umum']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_p8_umum'])));
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor dan Tanggal P-8 Umum', 
					'value'=>function($data){
						return $data['no_p8_umum'].'<br />'.date('d-m-Y',strtotime($data['tgl_p8_umum']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor dan Tanggal Pidsus-18', 
					'value'=>function($data){
						return $data['no_pidsus18'].'<br/>'.date('d-m-Y',strtotime($data['tgl_pidsus18']));
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tersangka', 
					'value'=>function($data){
						$temp = explode('#', $data['tsk']);
						$text = '';
						if(count($temp) > 0 && count($temp) == 1){
							$isian = explode("--", $temp[0]);
							$text .= '<p style="margin-bottom:0px;">Nama : '.$isian[0].'<br />Tanggal lahir : '.date("d-m-Y", strtotime($isian[1])).'</p>';
						} else if(count($temp) > 0 && count($temp) != 1){
							foreach($temp as $idx=>$res){
								$nom = $idx+1;
								$isian = explode("--", $res);
								$text .= '<div style="margin-bottom: 5px; width: 100%; display: table;">';
								$text .= '<div style="display: table-cell; width: 23px;">'.$nom.'.</div><div style="display: table-cell;">Nama : '.$isian[0].'<br />Tanggal lahir : '.date("d-m-Y", strtotime($isian[1])).'</div>';
								$text .= '</div>';
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
						$idnya = rawurlencode($data['no_pidsus18']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_pidsus18']))).'|#|'.
                                                         rawurlencode($data['no_p8_umum']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_p8_umum'])));
						return '<input type="radio" name="pilih-pidsus18-modal[]" id="pilih-pidsus18-modal'.($index+1).'" value="'.$idnya.'" class="pilih-pidsus18-modal" />';
					}, 
				],
            ],
        ]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihPidsus18Modal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalPidsus18Modal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-pidsus18-modal"></div>
</div>

<style>
	.modal-pidsus18-index.loading {overflow: hidden;}
	.modal-pidsus18-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalPidsus18").on('pjax:send', function(){
		$(".modal-pidsus18-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-pidsus18-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihPidsus18Modal").addClass("disabled");
	});

	$(".modal-pidsus18-index").on("ifChecked", ".pilih-pidsus18-modal", function(){
		$("#idPilihPidsus18Modal").removeClass("disabled");
	});

	$(".reset-cari-mpidsus18").on("click", function(){
		$("#mpidsus18_q1").val("");
		$("#searchModalGetPidsus18").trigger("submit");
	});

	$("#idBatalPidsus18Modal").on("click", function(){
		$("#pidsus18_modal").modal("hide");
	});
});
</script>
