<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'SKK';
	$this->subtitle = 'Surat Kuasa Khusus';
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
						<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-1"></div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px">

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="/datun/skk/create"><i class="fa fa-plus" aria-hidden="true"></i> Tambah SKK</a></div>
    <div class="pull-right">
    	<a class="btn btn-info disabled" id="idUbah" title="Ubah"><i class="fa fa-pencil jarak-kanan"></i> Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus" title="Hapus"><i class="fa fa-trash jarak-kanan"></i> Hapus</a>
	</div>
    <p style="margin-bottom:10px;"></p>

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_register_perkara']).'#'.rawurlencode($data['no_surat']).'#'.rawurlencode($data['no_register_skk']).'#'.
						 rawurlencode($data['tanggal_skk']).'#'.rawurlencode($data['kode_tahap_bankum']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:21%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor Register Perkara', 
					'value'=>function($data){
						return $data['no_register_perkara'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:21%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor/ Tanggal Permohonan', 
					'value'=>function($data){
						return (!in_array($data['kode_jenis_instansi'],array("01","06"))?$data['no_surat'].'<br>':'').date("d/m/Y", strtotime($data['tanggal_permohonan']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:21%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor/ Tanggal SKK', 
					'value'=>function($data){
						return (!in_array($data['kode_jenis_instansi'],array("01"))?$data['no_register_skk'].'<br>':'').date("d/m/Y", strtotime($data['tanggal_skk']));
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:21%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tahap Bantuan Hukum', 
					'value'=>function($data){
						return $data['bantuan_hukum'];
					}, 
				],
				'5'=>[
					'headerOptions'=>['style'=>'width:11%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'contentOptions'=>['class'=>'text-center'],
					'value'=>function($data){
						return $data['status_data'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_register_perkara']).'#'.rawurlencode($data['no_surat']).'#'.rawurlencode($data['no_register_skk']).'#'.
								 rawurlencode($data['tanggal_skk']).'#'.rawurlencode($data['kode_tahap_bankum']);
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
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
		$("#idUbah, #idHapus").addClass("disabled");
	});

	$("#idUbah").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tmp = id.toString().split('#');
		var url = window.location.protocol + "//" + window.location.host + "/datun/skk/update?id="+tmp[0]+"&np="+tmp[1]+"&nk="+tmp[2]+"&tk="+tmp[3]+"&th="+tmp[4];
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
						url		: "<?php echo Yii::$app->request->baseUrl.'/datun/skk/hapusdata'; ?>",
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
								notify_hapus("success", "Data gagal dihapus");
							}
						}
					});
				}
			}
		});
	});

	$(".role-index").on("dblclick", "td:not(.aksinya)", function(){
		var id = $(this).closest("tr").data("id");
		var tmp = id.toString().split('#');
		var url = window.location.protocol + "//" + window.location.host + "/datun/skk/update?id="+tmp[0]+"&np="+tmp[1]+"&nk="+tmp[2]+"&tk="+tmp[3]+"&th="+tmp[4];
		$(location).attr("href", url);
	});

	$(".role-index").on("ifChecked", "input[name=selection_all]", function(){
		$(".selection_one").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selection_all]", function(){
		$(".selection_one").not(':disabled').iCheck("uncheck");
	});
	$(".role-index").on("ifChecked", ".selection_one", function(){
		console.log('asas');
		var n = $(".selection_one:checked").length;
		endisButton(n);
	}).on("ifUnchecked", ".selection_one", function(){
		var n = $(".selection_one:checked").length;
		endisButton(n);
	});
	function endisButton(n){
		if(n == 1){
			$("#idUbah").removeClass("disabled");
			$("#idHapus").removeClass("disabled");
		} else if(n > 1){
			$("#idUbah").addClass("disabled");
			$("#idHapus").removeClass("disabled");
		} else{
			$("#idUbah").addClass("disabled");
			$("#idHapus").addClass("disabled");
		}
	}
});
</script>
