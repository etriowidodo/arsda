<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	require_once('./function/tgl_indo.php');
	
	$this->title 	= 'P-9 Umum';
	$this->subtitle = 'Surat Panggilan Saksi';
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
                        <a href="/pidsus/pds-p9-umum/index" class="btn btn-info btn-flat reset-cari" style="margin-left:10px;">Reset Pencarian</a>
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
    <div class="inline"><a class="btn btn-pidsus" href="/pidsus/pds-p9-umum/create"><i class="fa fa-plus jarak-kanan"></i>Tambah</a></div>
    <div class="pull-right">
    	<a class="btn btn-warning disabled" id="idCetak"><i class="fa fa-print jarak-kanan"></i>Cetak</a>&nbsp;
    	<a class="btn btn-primary disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>

    <div id="#wrapper-table" style="margin-top:10px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-laporan'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_p9_umum']);
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
					'header'=>'Nomor/Tanggal P-9 Umum', 
					'value'=>function($data){
						return $data['no_p9_umum'].'<br />'.date("d-m-Y", strtotime($data['tgl_p9_umum']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kepada', 
					'value'=>function($data){
						return $data['kepada_nama'].($data['kepada_jabatan']?'<br />'.$data['kepada_jabatan']:'');
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:45%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-left'],
					'format'=>'raw',
					'header'=>'Detil Pemanggilan', 
					'value'=>function($data){
                        return '
						<table class="table no-border table-pemanggilan" style="margin-bottom:0px;">
							<tr>
								<td width="85" class="aksinya">Hari</td>
								<td width="10" class="aksinya">:</td>
								<td width="" class="aksinya">'.$data['hari_pemanggilan'].'</td>
							</tr>
							<tr>
								<td class="aksinya">Tanggal</td>
								<td class="aksinya">:</td>
								<td class="aksinya">'.tgl_indo($data['tgl_pemanggilan'], 'long', 'db').'</td>
							</tr>
							<tr>
								<td class="aksinya">Jam</td>
								<td class="aksinya">:</td>
								<td class="aksinya">'.$data['jam_pemanggilan'].'</td>
							</tr>
							<tr>
								<td class="aksinya">Tempat</td>
								<td class="aksinya">:</td>
								<td class="aksinya">'.$data['tempat_pemanggilan'].'</td>
							</tr>
							<tr>
								<td class="aksinya">Menghadap</td>
								<td class="aksinya">:</td>
								<td class="aksinya">'.$data['menghadap_kepada'].'</td>
							</tr>
						</table>';
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_p9_umum']);
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
<div class="modal fade" id="upload_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<style>
	.table-pemanggilan > tbody > tr > td{
		padding: 0px 5px;
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
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$("#idUbah, #idHapus, #idCetak").addClass("disabled");
	});

	$("#idUbah").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p9-umum/update?id1="+tm[0];
		$(location).attr("href", url);
	});
        
        $("#idCetak").on("click", function(){
		var id 	= $(".selection_one:checked").val();
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p9-umum/cetak?id1="+tm[0];
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
						url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-p9-umum/hapusdata'; ?>",
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

	$(".role-index").on("dblclick", ".table-laporan td:not(.aksinya)", function(){
		var id = $(this).closest("tr").data("id");
		var tm 	= id.toString().split("#");
		var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-p9-umum/update?id1="+tm[0];
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