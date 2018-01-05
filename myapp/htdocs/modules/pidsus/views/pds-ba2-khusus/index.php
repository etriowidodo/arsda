<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	require_once('./function/tgl_indo.php');

	$this->title 	= 'BA-2 Khusus';
	$this->subtitle = 'Berita Acara Pengambilan Sumpah/ Janji Saksi';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
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
                                                <a href="/pidsus/pds-ba2-khusus/index" class="btn btn-info btn-flat reset-cari" style="margin-left:10px;">Reset Pencarian</a>
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
    <div class="inline"><a class="btn btn-pidsus" href="/pidsus/pds-ba2-khusus/create"><i class="fa fa-plus jarak-kanan"></i>Tambah</a></div>
    <div class="pull-right">
        <a class="btn btn-warning" id="idCetakDraft"><i class="fa fa-print jarak-kanan"></i>Cetak Draft</a>&nbsp;
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
				$idnya = rawurlencode($data['no_ba2_khusus']);
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
					'header'=>'Tanggal BA-2 Khusus', 
					'value'=>function($data){
						return date("d-m-Y", strtotime($data['tgl_ba2_khusus']))." Jam ".$data['jam_ba2_khusus']."<br />".$data['tempat'];
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
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_ba2_khusus']);
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
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-ba2-khusus/update?id1="+tm[0];
		$(location).attr("href", url);
	});
			
	$("#idCetakDraft").on("click", function(){
		var id 	= $(".selection_one:checked").val();
                var url;
                if(id){
                    var tm = id.toString().split("#");
                    url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-ba2-khusus/cetak?id1="+tm[0]+"&&id2=1";
                }else{
                    url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-ba2-khusus/cetak?id1=null&&id2=1";
                }
		$(location).attr("href", url);
	});
        
	$("#idCetak").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-ba2-khusus/cetak?id1="+tm[0]+"&&id2=0";
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
						url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-ba2-khusus/hapusdata'; ?>",
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
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-ba2-khusus/update?id1="+tm[0];
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
			$("#idUbah, #idCetak, #idCetakDraft").addClass("disabled");
			$("#idHapus").removeClass("disabled");
		} else{
			$("#idUbah, #idCetak").addClass("disabled");
			$("#idHapus").addClass("disabled");
		}
	}

});
</script>