<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;

	$this->title = 'Penandatangan '.$arrTtd['deskripsi'];
?>

<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <?php $form = ActiveForm::begin(['action'=>['viewpejabat'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                <div class="col-md-10">
                    <div class="input-group">
                    	<input type="text" name="q1" id="q1" class="form-control" />
                    	<input type="hidden" name="id" id="id" class="form-control" value="<?php echo $arrTtd['kode'];?>" />
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
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="<?php echo '/datun/penandatangan/createpejabat?id='.$arrTtd['kode'];?>">Tambah Pejabat</a></div>
    <div class="pull-right">
    	<a class="btn btn-primary" href="/datun/penandatangan/index"><i class="fa fa-reply jarak-kanan"></i>Kembali ke penandatangan</a>&nbsp;
    	<a class="btn btn-info disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p>&nbsp;</p>

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				return ['data-id' => $data['kode'].'.'.$data['nip']];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:31%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'NIP / Nama', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['nip'].'</p><p style="margin-bottom:0px;">'.$data['nama'].'</p>';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:46%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pangkat / Jabatan', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['pangkat'].'</p><p style="margin-bottom:0px;">'.$data['jabatan'].'</p>';
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'contentOptions'=>['class'=>'text-center'],
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
						$idKab = $data['kode'].'.'.$data['nip'];
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idKab.'" class="selection_one" />';
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
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myPjax').on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$("body").addClass("loading");
		}).on('pjax:complete', function(){
			$("body").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$(".selection_one").trigger("ifChecked");
		});

		$("#idUbah").on("click", function(){
			var tmp = $(".selection_one:checked").val().split(".");
			var url = window.location.protocol + "//" + window.location.host + "/datun/penandatangan/updatepejabat?id="+tmp[0]+"&kb="+tmp[1];
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/penandatangan/hapuspejabat'; ?>",
							data	: { 'id' : id },
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$("body").removeClass("loading");
									$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false});
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data berhasil dihapus"}, {type:"success"});
								} else{
									$("body").removeClass("loading");
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data gagal dihapus"}, {type:"danger"});
								}
							}
						});
					}
				}
			});
		});

        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var tmp = $(this).closest("tr").data("id").toString().split(".");
			var url = window.location.protocol + "//" + window.location.host + "/datun/penandatangan/updatepejabat?id="+tmp[0]+"&kb="+tmp[1];
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
