<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'Pidsus-17 Umum';
	$this->subtitle = 'Pemberitahuan Tidak Dapat Dilakukan Penyitaan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
?>
<?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="q1" id="q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn" name="btnSearch" id="btnSearch"><i class="fa fa-search jarak-kanan"></i>Cari</button>
                        <a href="/pidsus/pds-pidsus-17-umum/index" class="btn btn-info btn-flat reset-cari" style="margin-left:10px;">Reset Pencarian</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-1"></div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-pidsus" href="/pidsus/pds-pidsus-17-umum/create"><i class="fa fa-plus jarak-kanan"></i>Tambah</a></div>
    <div class="pull-right">
    	<a class="btn btn-warning disabled" id="idCetak"><i class="fa fa-print jarak-kanan"></i>Cetak</a>&nbsp;
    	<a class="btn btn-primary disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>

    <div id="#wrapper-table" style="margin-top:10px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_pidsus17_umum']);
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
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor dan Tanggal Pidsus-17 Umum', 
					'value'=>function($data){
						return $data['no_pidsus17_umum'].'<br />'.date("d-m-Y", strtotime($data['tgl_dikeluarkan']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor dan Tanggal Penetapan', 
					'value'=>function($data){
						return $data['no_penetapan'].'<br />'.date("d-m-Y", strtotime($data['tgl_penetapan']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Barang Yang Tidak Disita', 
					'value'=>function($data){
						$temp = explode('#', $data['sitaan']);
						$text = '';
						if(count($temp) > 0 && count($temp) == 1){
							$isian = explode("--", $temp[0]);
							$text .= '<p style="margin-bottom:0px;">'.$isian[0].'</p>';
						} else if(count($temp) > 0 && count($temp) != 1){
							foreach($temp as $idx=>$res){
								$nom = $idx+1;
								$isian = explode("--", $res);
								$text .= '
								<div style="margin-bottom: 5px; width: 100%; display: table;">
									<div style="display: table-cell; width: 23px;">'.$nom.'.</div>
									<div style="display: table-cell;">'.$isian[0].'</div>
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
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_pidsus17_umum']);
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
    </div>

</div>
<div class="modal-loading-new"></div>
<div class="hide" id="filter-link"></div>

<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$('#myPjax').on('pjax:beforeSend', function(a, b, c){
		$("#filter-link").text(c.url);
	}).on('pjax:send', function(){
		$("body").addClass("loading");
	}).on('pjax:complete', function(){
		$("body").removeClass("loading");
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$("#idUbah, #idHapus, #idCetak").addClass("disabled");
	});

	$("#idUbah").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-pidsus-17-umum/update?id1="+tm[0];
		$(location).attr("href", url);
	});
			
	$("#idCetak").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-pidsus-17-umum/cetak?id1="+tm[0];
		$(location).attr("href", url);
	});

	$("#idHapus").on("click", function(){
		var id 	= [];
		var n 	= $(".selection_one:checked").length;
		for(var i = 0; i < n; i++){
			var test = $(".selection_one:checked").eq(i);
			id.push(test.val());
		}
		bootbox.confirm({
			message: "Apakah anda ingin menghapus data ini?",
			size: "small",
			closeButton: false,
			buttons: {
				confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
				cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
			},
			callback: function (result) {
				if(result){
					$("body").addClass("loading");
					$.ajax({
						type	: "POST",
						url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-pidsus-17-umum/hapusdata'; ?>",
						data	: { 'id' : id },
						cache	: false,
						dataType: "json",
						success : function(data){ 
							if(data.hasil){
								$("body").removeClass("loading");
								$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false})
								notify_hapus("success", "Data berhasil dihapus");
							} else{
								$("body").removeClass("loading");
								notify_hapus("danger", "Data gagal dihapus");
							}
						}
					});
				}
			}
		});
	});

	$(".role-index").on("dblclick", "td:not(.aksinya)", function(){
		var id = $(this).closest("tr").data("id");
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-pidsus-17-umum/update?id1="+tm[0];
		$(location).attr("href", url);
	});
	$(".role-index").on("ifChecked", "input[name=selection_all]", function(){
		$(".selection_one").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selection_all]", function(){
		$(".selection_one").not(':disabled').iCheck("uncheck");
	});
	$(".role-index").on("ifChecked", ".selection_one", function(){
		var n = $(".selection_one:checked").length;
		endisButton(n);
	}).on("ifUnchecked", ".selection_one", function(){
		var n = $(".selection_one:checked").length;
		endisButton(n);
	});
	function endisButton(n){
		if(n == 1){
			$("#idUbah, #idCetak").removeClass("disabled");
			$("#idHapus").removeClass("disabled");
		} else if(n > 1){
			$("#idUbah, #idCetak").addClass("disabled");
			$("#idHapus").removeClass("disabled");
		} else{
			$("#idUbah, #idCetak").addClass("disabled");
			$("#idHapus").addClass("disabled");
		}
	}

});
</script>