<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getisnta'], 'method'=>'get', 'id'=>'searchFormJnsIns', 'options'=>['name'=>'searchFormJnsIns']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="jnsins_q1" id="jnsins_q1" class="form-control" />
					<input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES);?>" />
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

<div class="get-insta-index">
    <div class="inline">
    	<a class="btn btn-success btn-sm" id="tmbh_instansi" data-id="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES);?>">
        <i class="fa fa-plus jarak-kanan"></i>Tambah</a>
	</div>
    <div class="pull-right">
    	<a class="btn btn-warning btn-sm disabled" id="idPilih"><i class="fa fa-table jarak-kanan"></i>Pilih</a>&nbsp;
    	<a class="btn btn-info btn-sm disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger btn-sm disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p style="margin-bottom:10px;"></p>

	<?php
        Pjax::begin(['id' => 'myPjaxModalIns', 'timeout' => false, 'formSelector' => '#searchFormJnsIns', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'jns-ins-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['kode_instansi'].'#'.$data['deskripsi_instansi'];
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
					'headerOptions'=>['style'=>'width:17%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kode Instansi', 
					'value'=>function($data){
						return $data['kode_instansi'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:65%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Instansi', 
					'value'=>function($data){
						return $data['deskripsi_instansi'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = $data['kode_instansi'].'#'.$data['deskripsi_instansi'].'#'.$data['kode_jenis_instansi'];
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/datun/permohonan/getisnta?id='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
</div>
<style>
	.get-insta-index.loading {overflow: hidden;}
	.get-insta-index.loading .modal-loading-new {display: block;}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});

		$("#myPjaxModalIns").on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$(".get-insta-index").addClass("loading");
		}).on('pjax:success', function(){
			$(".get-insta-index").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$("#idUbah, #idPilih, #idHapus").addClass("disabled");
		});

		$(".get-insta-index").on("ifChecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("uncheck");
		});
		$(".get-insta-index").on("ifChecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		}).on("ifUnchecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		});
		function endisButton(n){
			if(n == 1){
				$("#idUbah, #idPilih").removeClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah, #idPilih").addClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else{
				$("#idUbah, #idPilih").addClass("disabled");
				$("#idHapus").addClass("disabled");
			}
		}

		$("#tambah_form_intansi").on('click', '#simpan_form_instansi', function(e){
			var obj = $("#tambah_form_intansi").find("#wrapper-modal-ins");
			obj.addClass("loading");
			$.ajax({
				type	: "POST",
				url		: "<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/instansi'; ?>",
				data	: $("#frm-m1").serialize(),
				cache	: false,
				dataType: "json",
				success : function(data){ 
					if(data.hasil){
						obj.removeClass("loading");
						$("#errornya-modal-ins").html("");
						$("#tambah_form_intansi").modal("hide");
						$.pjax({url: $("#filter-link").text(), container: '#myPjaxModalIns', 'push':false, 'timeout':false})
					} else{
						$("#errornya-modal-ins").html(data.error);
						obj.removeClass("loading");
					}
				}
			});
			return false;
		}).on('click', '#form_keluar', function(e){
			$("#tambah_form_intansi").modal("hide");
		});
		
	});
</script>