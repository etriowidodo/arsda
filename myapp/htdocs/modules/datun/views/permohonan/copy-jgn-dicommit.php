<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getpeng'], 'method'=>'get', 'id'=>'serachFormModalPeng', 'options'=>['name'=>'serachFormModalPeng']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="peng_q1" id="peng_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning btn-sm" name="btnSearch" id="btnSearch">Cari</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="get-peng-index">
    <div class="inline">
    	<a class="btn btn-success btn-sm" id="tmbh_pengadilan"><i class="fa fa-plus jarak-kanan"></i>Tambah</a>
	</div>
    <div class="pull-right">
    	<a class="btn btn-warning btn-sm disabled" id="idPilih3"><i class="fa fa-table jarak-kanan"></i>Pilih</a>&nbsp;
    	<a class="btn btn-info btn-sm disabled" id="idUbah3"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger btn-sm disabled" id="idHapus3"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p style="margin-bottom:10px;"></p>

	<?php
        Pjax::begin(['id' => 'myPjaxModalPeng', 'timeout' => false, 'formSelector' => '#serachFormModalPeng', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'pengadilan-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['kode_pengadilan_tk1'].'#'.$data['kode_pengadilan_tk2'].'#'.$data['nama_pengadilan'];
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
	 			'1'=>[
					'headerOptions'=>['style'=>'width:80%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Pengadilan', 
					'value'=>function($data){
						return $data['nama_pengadilan'];
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all3" id="selection_all3" />', 
					'value'=>function($data, $index){
						$idnya = $data['kode_pengadilan_tk1'].'#'.$data['kode_pengadilan_tk2'].'#'.$data['nama_pengadilan'];
						return '<input type="checkbox" name="selection3[]" id="selection3'.($index+1).'" value="'.$idnya.'" class="selection_one3" />';
					}, 
				], 
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link3"><?php echo '/datun/permohonan/getpeng';?></div>
</div>

<style>
	.get-peng-index.loading {overflow: hidden;}
	.get-peng-index.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
		$("#myPjaxModalPeng").on('pjax:beforeSend', function(a, b, c){
			$("#filter-link3").text(c.url);
		}).on('pjax:send', function(){
			$(".get-peng-index").addClass("loading");
		}).on('pjax:success', function(){
			$(".get-peng-index").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$("#idUbah3, #idPilih3, #idHapus3").addClass("disabled");
		});

		$(".get-peng-index").on("ifChecked", "input[name=selection_all3]", function(){
			$(".selection_one3").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=selection_all3]", function(){
			$(".selection_one3").not(':disabled').iCheck("uncheck");
		});
		$(".get-peng-index").on("ifChecked", ".selection_one3", function(){
			var n = $(".selection_one3:checked").length;
			endisButton(n);
		}).on("ifUnchecked", ".selection_one3", function(){
			var n = $(".selection_one3:checked").length;
			endisButton(n);
		});
		function endisButton(n){
			if(n == 1){
				$("#idUbah3, #idPilih3").removeClass("disabled");
				$("#idHapus3").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah3, #idPilih3").addClass("disabled");
				$("#idHapus3").removeClass("disabled");
			} else{
				$("#idUbah3, #idPilih3").addClass("disabled");
				$("#idHapus3").addClass("disabled");
			}
		}

		$("#tambah_form_pengadilan").on('click', '#simpan_form_pengadilan', function(e){
			var obj = $("#tambah_form_pengadilan").find("#wrapper-modalPengadilan");
			obj.addClass("loading");
			$.ajax({
				type	: "POST",
				url		: "<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/pengadilan'; ?>",
				data	: $("#frm-m3").serialize(),
				cache	: false,
				dataType: "json",
				success : function(data){ 
					if(data.hasil){
						obj.removeClass("loading");
						$("#errornya-modal-pengadilan").html("");
						$("#tambah_form_pengadilan").modal("hide");
						$.pjax({url: $("#filter-link3").text(), container: '#myPjaxModalPeng', 'push':false, 'timeout':false})
					} else{
						$("#errornya-modal-pengadilan").html(data.error);
						obj.removeClass("loading");
					}
				}
			});
			return false;
		}).on('click', '#form_keluar3', function(e){
			$("#tambah_form_pengadilan").modal("hide");
		});
		
		/*$("#tambah_pengadilan").on('click', '#idHapus3', function(e){
			var id 	= [];
			var n 	= $(".selection_one3:checked").length;
			for(var i = 0; i < n; i++){
				var test = $(".selection_one3:checked").eq(i);
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
				callback: function(result){
					if(result){
						$.ajax({
							type	: "POST",
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/hapuspengadilan'; ?>",
							data	: {'id':id},
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$.pjax({url: $("#filter-link3").text(), container: '#myPjaxModalPeng', 'push':false, 'timeout':false})
								} else{
									$.pjax({url: $("#filter-link3").text(), container: '#myPjaxModalPeng', 'push':false, 'timeout':false})
								}
							}
						});
					}
				}
			});
		});*/

	});
</script>
