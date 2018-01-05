<?php
	require_once('./function/tgl_indo.php');
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title 	= 'Undangan';
	$this->subtitle = '<span style="font-weight:400; font-size:13px;">No Register Perkara : '.$_SESSION['no_register_perkara'].' | No Permohonan : '.$_SESSION['no_surat'];
	$this->subtitle .= ($_SESSION['no_register_skk'])?' | No SKK : '.$_SESSION['no_register_skk'].'</span>':'</span>';
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
<hr style="border-color: #fff;margin: 10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="/datun/undangan/create">Tambah Undangan</a></div>
    <div class="pull-right">
    	<a class="btn btn-warning disabled" id="idTtd" title="Tanda Terima">Tanda Terima</a>&nbsp;
    	<a class="btn btn-info disabled" id="idUbah" title="Ubah">Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus" title="Hapus">Hapus</a>
	</div>
    <p style="margin-bottom:10px;"></p>

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_surat_undangan'])."#".rawurlencode($data['tahap_undangan']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor / Tanggal Surat Undangan', 
					'value'=>function($data){
						return $data['no_surat_undangan'].'<br />'.tgl_indo($data['tanggal_surat_undangan'], 'long', 'db');
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:44%', 'class'=>'text-center'],
					'format'=>'raw',
					'contentOptions'=>['class'=>'text-left'],
					'header'=>'Tanggal / Waktu Acara', 
					'value'=>function($data){
						$tmp1 = substr($data['waktu'],0,strrpos($data['waktu'], ':')).' '.Yii::$app->inspektur->getTimeFormat();
						$row1 = $data['hari'].', '.tgl_indo($data['tanggal'], 'long', 'db').($tmp1 == '00:00'.' '.Yii::$app->inspektur->getTimeFormat()?'':', pukul '.$tmp1);
						$row2 = 'Bertempat di '.$data['tempat'];
						$row3 = 'Acara '.$data['acara'];
						return '<p style="margin-bottom:0px;">'.$row1.'</p><p style="margin-bottom:0px;">'.$row2.'</p><p style="margin-bottom:0px;">'.$row3.'</p>';
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Bertemu Dengan', 
					'value'=>function($data){
						return $data['bertemu'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:6%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_surat_undangan'])."#".rawurlencode($data['tahap_undangan']);
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
<style type="text/css">
	.table > thead > tr > th, 
	.table > tbody > tr > th, 
	.table > tfoot > tr > th, 
	.table > thead > tr > td, 
	.table > tbody > tr > td, 
	.table > tfoot > tr > td{
		vertical-align: top;
	}
</style>
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
			$("#idUbah, #idHapus, #idTtd").addClass("disabled");
		});

		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var nm = id.toString().split('#');
			var url = window.location.protocol + "//" + window.location.host + "/datun/undangan/update?id="+nm[0]+"&tp="+nm[1];
			$(location).attr("href", url);
		});

		$("#idTtd").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var nm = id.toString().split('#');
			var url = window.location.protocol + "//" + window.location.host + "/datun/undangan/ttd?id="+nm[0]+"&tp="+nm[1];
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/undangan/hapusdata'; ?>",
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
			var nm = id.toString().split('#');
			var url = window.location.protocol + "//" + window.location.host + "/datun/undangan/update?id="+nm[0]+"&tp="+nm[1];
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
				$("#idUbah, #idTtd").removeClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah, #idTtd").addClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else{
				$("#idUbah, #idTtd").addClass("disabled");
				$("#idHapus").addClass("disabled");
			}
		}
	});
</script>
