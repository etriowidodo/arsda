<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'Penyelesaian Pra Penuntutan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();

?>
<div class="role-index">
    <div class="row ">
        <div class="col-md-12">
            <div class="pull-right">
                <a class="btn btn-primary disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
                <a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
            </div>
        </div>
    </div>
    

    <div id="#wrapper-table" style="margin-top:10px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_berkas']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor dan Tanggal Berkas', 
					'value'=>function($data){
						return '<p style="margin-bottom:5px;">'.$data['no_berkas'].'</p>'.date("d-m-Y", strtotime($data['tgl_berkas']));
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tersangka', 
					'value'=>function($data){
						return $data['nama_tersangka'];
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:27%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'value'=>function($data){
						return $data['status'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_berkas']);
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
			$("#idUbah, #idHapus").addClass("disabled");
		});
	
		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var tm 	= id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-penyelesaian-pratut/create";
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-penyelesaian-pratut/hapusdata'; ?>",
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
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/pds-penyelesaian-pratut/create";
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