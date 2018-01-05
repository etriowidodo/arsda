<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	$id 	= htmlspecialchars($_GET['id'], ENT_QUOTES);
	$idins 	= htmlspecialchars($_GET['idins'], ENT_QUOTES);
?>
<?php $form = ActiveForm::begin(['action'=>['getwil'], 'method'=>'get', 'id'=>'searchFormWilIns', 'options'=>['name'=>'searchFormWilIns']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="wilins_q1" id="wilins_q1" class="form-control" />
					<input type="hidden" name="id" id="id" value="<?php echo $id;?>" />
					<input type="hidden" name="idins" id="idins" value="<?php echo $idins;?>" />
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

<div class="get-wilinsta-index">
    <div class="inline">
    	<a class="btn btn-success btn-sm" id="tmbh_wilinstansi" data-id="<?php echo $id;?>" data-idins="<?php echo $idins;?>">
        <i class="fa fa-plus jarak-kanan"></i>Tambah</a>
	</div>
    <div class="pull-right">
    	<a class="btn btn-warning btn-sm disabled" id="idPilih2"><i class="fa fa-table jarak-kanan"></i>Pilih</a>&nbsp;
    	<a class="btn btn-info btn-sm disabled" id="idUbah2"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger btn-sm disabled" id="idHapus2"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p style="margin-bottom:10px;"></p>

	<?php
        Pjax::begin(['id' => 'myPjaxModalWil', 'timeout' => false, 'formSelector' => '#searchFormWilIns', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'wil-ins-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['kode_provinsi'].'#'.$data['kode_kabupaten'].'#'.$data['no_urut'].'#'.$data['nama'].'#'.
						 $data['alamat'].'#'.$data['no_tlp'].'#'.$data['deskripsi_inst_wilayah'];
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
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Instansi', 
					'value'=>function($data){
						return $data['deskripsi_inst_wilayah'];
					}, 
				],
	 			'2'=>[
					'headerOptions'=>['style'=>'width:12%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Pimpinan', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
	 			'3'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Alamat Instansi', 
					'value'=>function($data){
						return $data['alamat'].' '.$data['no_telp'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all2" id="selection_all2" />', 
					'value'=>function($data, $index){
						$idnya = $data['kode_provinsi'].'#'.$data['kode_kabupaten'].'#'.$data['no_urut'].'#'.$data['nama'].'#'.
								 $data['alamat'].'#'.$data['no_tlp'].'#'.$data['deskripsi_inst_wilayah'].'#'.$data['kode_jenis_instansi'].'#'.$data['kode_instansi'];
						return '<input type="checkbox" name="selection2[]" id="selection2'.($index+1).'" value="'.$idnya.'" class="selection_one2" />';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link2"><?php echo '/datun/permohonan/getwil?id='.$id.'&idins='.$idins;?></div>
</div>


<style>
	.get-wilinsta-index.loading {overflow: hidden;}
	.get-wilinsta-index.loading .modal-loading-new {display: block;}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});

		$("#myPjaxModalWil").on('pjax:beforeSend', function(a, b, c){
			$("#filter-link2").text(c.url);
		}).on('pjax:send', function(){
			$(".get-wilinsta-index").addClass("loading");
		}).on('pjax:success', function(){
			$(".get-wilinsta-index").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$("#idUbah2, #idPilih2, #idHapus2").addClass("disabled");
		});
		
		$(".get-wilinsta-index").on("ifChecked", "input[name=selection_all2]", function(){
			$(".selection_one2").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=selection_all2]", function(){
			$(".selection_one2").not(':disabled').iCheck("uncheck");
		});
		$(".get-wilinsta-index").on("ifChecked", ".selection_one2", function(){
			var n = $(".selection_one2:checked").length;
			endisButton(n);
		}).on("ifUnchecked", ".selection_one2", function(){
			var n = $(".selection_one2:checked").length;
			endisButton(n);
		});
		function endisButton(n){
			if(n == 1){
				$("#idUbah2, #idPilih2").removeClass("disabled");
				$("#idHapus2").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah2, #idPilih2").addClass("disabled");
				$("#idHapus2").removeClass("disabled");
			} else{
				$("#idUbah2, #idPilih2").addClass("disabled");
				$("#idHapus2").addClass("disabled");
			}
		}

		$("#tambah_form_wilintansi").on('click', '#simpan_form_wilinstansi', function(e){
			var obj = $("#tambah_form_wilintansi").find("#wrapper-modalWil");
			obj.addClass("loading");
			$.ajax({
				type	: "POST",
				url		: "<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/wilinstansi'; ?>",
				data	: $("#frm-m2").serialize(),
				cache	: false,
				dataType: "json",
				success : function(data){ 
					if(data.hasil){
						obj.removeClass("loading");
						$("#errornya-modal-wil").html("");
						$("#tambah_form_wilintansi").modal("hide");
						$.pjax({url: $("#filter-link2").text(), container: '#myPjaxModalWil', 'push':false, 'timeout':false})
					} else{
						$("#errornya-modal-wil").html(data.error);
						obj.removeClass("loading");
					}
				}
			});
			return false;
		}).on('click', '#form_keluar2', function(e){
			$("#tambah_form_wilintansi").modal("hide");
		});
		
	});
</script>
