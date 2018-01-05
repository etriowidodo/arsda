<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\datun\models\TahapBantuanHukum;

	$this->title 	= 'SKKS';
	$this->subtitle = '<span style="font-weight:400; font-size:13px;">No Register Perkara : '.$_SESSION['no_register_perkara'].' | No Permohonan : '.$_SESSION['no_surat'];
	$this->subtitle .= ($_SESSION['no_register_skk'])?' | No SKK : '.$_SESSION['no_register_skk'].'</span>':'</span>';
	$sqlCek = "select penerima_kuasa from datun.skk where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' 
				and no_register_skk = '".$_SESSION['no_register_skk']."' and tanggal_skk = '".$_SESSION['tanggal_skk']."'";
	$resCek = TahapBantuanHukum::findBySql($sqlCek)->scalar();
	$attCek = ($resCek == "JPN")?'disabled':'';
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
<hr style="border-color:#fff; margin:10px;">

<div class="role-index">
    <div class="inline"><a class="<?php echo 'btn btn-success '.$attCek;?>" href="/datun/skks/create">Tambah SKKS</a></div>
    <div class="pull-right">
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
				$idnya = rawurlencode($data['no_register_skks']); 
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor/ Tanggal SKK', 
					'value'=>function($data){
						return ($data['kode_jenis_instansi'] != "01"?$data['no_register_skk'].'<br>':'').date("d/m/Y", strtotime($data['tanggal_skk']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor/ Tanggal SKKS', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px">'.$data['no_register_skks'].'</p>
								<p style="margin-bottom:0px">'.date("d/m/Y", strtotime($data['tanggal_ttd'])).'</p>';
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:45%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jaksa Pengacara Negara', 
					'value'=>function($data){
						$temp = explode('#', $data['nama_jpn']);
						$text = '';
						if(count($temp) > 0 && count($temp) == 1){
							$text .= '<p style="margin-bottom:0px;">'.$temp[0].'</p>';
						} else if(count($temp) > 0 && count($temp) != 1){
							foreach($temp as $idx=>$res){
								$nom = $idx+1;
								$text .= '<p style="margin-bottom:0px;">'.$nom.'. '.$res.'</p>';
							}
						}
						return $text;
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					//'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'header'=>'Pilih', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_register_skks']);
						return '<input type="radio" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
						//return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
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
		//$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-blue'});
		$("#idUbah, #idHapus").addClass("disabled");
	});

	$("#idUbah").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tahap_hukum = $("#tahap_hukum").val();
		var url = window.location.protocol + "//" + window.location.host + "/datun/skks/update?id="+id;
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
						url		: "<?php echo Yii::$app->request->baseUrl.'/datun/skks/hapusdata'; ?>",
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
		var tahap_hukum = $("#tahap_hukum").val();
		var url = window.location.protocol + "//" + window.location.host + "/datun/skks/update?id="+id;
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
			$("#idUbah, #idHapus").removeClass("disabled");
			//$("#idHapus").removeClass("disabled");
		} else if(n > 1){
			$("#idUbah, #idHapus").addClass("disabled");
			//$("#idHapus").removeClass("disabled");
		} else{
			$("#idUbah, #idHapus").addClass("disabled");
			//$("#idHapus").addClass("disabled");
		}
	}
});
</script>
