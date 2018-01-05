<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getp8'], 'method'=>'get', 'id'=>'searchModalGetP8', 'options'=>['name'=>'searchModalGetP8']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="mp8_q1" id="mp8_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearchMp8" id="btnSearchMp8">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-mp8" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="modal-p8-index">
	<div id="#wrapper-table">
	<?php
        Pjax::begin(['id' => 'myPjaxModalP8', 'timeout' => false, 'formSelector' => '#searchModalGetP8', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tabel-p8-modal'],
			'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_p8_khusus']).'|#|'.rawurlencode(date('d-m-Y',strtotime($data['tgl_p8_khusus'])));
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'No dan Tanggal P-8 Khusus', 
					'value'=>function($data){
						return $data['no_p8_khusus'].'<br/>'.date('d-m-Y',strtotime($data['tgl_p8_khusus']));
					}, 
				],                
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Penyidik', 
					'value'=>function($data){
						$temp = explode('#', $data['jpunya']);
						$text = '';
						if(count($temp) > 0 && count($temp) == 1){
							$text .= '<p style="margin-bottom:0px;">'.$temp[0].'</p>';
						} else if(count($temp) > 0 && count($temp) != 1){
							foreach($temp as $idx=>$res){
								$nom = $idx+1;
								$text .= '<div style="margin-bottom: 5px; width: 100%; display: table;">';
								$text .= '<div style="display: table-cell; width: 23px;">'.$nom.'.</div><div style="display: table-cell;">'.$res.'</div>';
								$text .= '</div>';
							}
						}
						return $text;
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tindak Pidana', 
					'value'=>function($data){
						return $data['laporan_pidana'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_p8_khusus']).'|#|'.rawurlencode($data['tgl_p8_khusus']);
						return '<input type="radio" name="pilih-p8-modal[]" id="pilih-p8-modal'.($index+1).'" value="'.$idnya.'" class="pilih-p8-modal" />';
					}, 
				],
            ],
        ]);
		Pjax::end();
    ?>
		<p style="margin-bottom:5px;" class="text-center">
        	<a class="btn btn-warning btn-sm disabled jarak-kanan" id="idPilihP8Modal"><i class="fa fa-table jarak-kanan"></i>Pilih</a>
            <a class="btn btn-danger btn-sm" id="idBatalP8Modal"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
		</p> 
    </div>

    <div class="modal-loading-new"></div>
    <div class="hide" id="filter-link-p8-modal"></div>
</div>

<style>
	.modal-p8-index.loading {overflow: hidden;}
	.modal-p8-index.loading .modal-loading-new {display: block;}
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
	
	$("#myPjaxModalP8").on('pjax:send', function(){
		$(".modal-p8-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".modal-p8-index").removeClass("loading");
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$("#idPilihP8Modal").addClass("disabled");
	});

	$(".modal-p8-index").on("ifChecked", ".pilih-p8-modal", function(){
		$("#idPilihP8Modal").removeClass("disabled");
	});

	$(".reset-cari-mp8").on("click", function(){
		$("#mp8_q1").val("");
		$("#searchModalGetP8").trigger("submit");
	});

	$("#idBatalP8Modal").on("click", function(){
		$("#p8_modal").modal("hide");
	});
});
</script>
