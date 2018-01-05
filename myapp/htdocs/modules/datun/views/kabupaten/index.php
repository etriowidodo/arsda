<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\datun\models\Provinsi;

	$this->title = 'Kabupaten/Kota';
?>

<?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-3" style="margin-top: 5px;">Provinsi</label>
			<div class="col-md-9">
                <select id="q2" name="q2" class="select2" style="width:100%;">
                    <option></option>
					<?php 
                        $resOpt = Provinsi::findBySql("select * from datun.m_propinsi order by id_prop")->asArray()->all();
                        foreach($resOpt as $dOpt){
                            echo '<option value="'.$dOpt['id_prop'].'">'.$dOpt['deskripsi'].'</option>';
                        }
                    ?>
                </select>
            </div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-3" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-9">
				<div class="input-group">
                	<input type="text" name="q1" id="q1" class="form-control" />
                    <div class="input-group-btn"><button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button></div>
                </div>
            </div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #fff;margin: 10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="/datun/kabupaten/create"><i class="fa fa-plus jarak-kanan"></i>Tambah Kabupaten/Kota</a></div>
    <div class="pull-right">
    	<a class="btn btn-info disabled" id="idUbah" title="Edit"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus" title="Hapus"><i class="fa fa-trash-o jarak-kanan"></i>Hapus</a>
	</div>

    <div id="#wrapper-table" style="margin-top:10px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['id_prop'])."#".rawurlencode($data['id_kabupaten_kota']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Provinsi', 
					'value'=>function($data){
						return $data['deskripsi'];
					}, 
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kode', 
					'contentOptions'=>['class'=>'text-center'],
					'value'=>function($data){
						return $data['id_kabupaten_kota'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:60%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kabupaten/Kota', 
					'value'=>function($data){
						return $data['deskripsi_kabupaten_kota'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:7%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['id_prop'])."#".rawurlencode($data['id_kabupaten_kota']);
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
			var tmp = id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/datun/kabupaten/update?id="+tmp[0]+"&id2="+tmp[1];
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/kabupaten/hapusdata'; ?>",
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
			var tmp = id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/datun/kabupaten/update?id="+tmp[0]+"&id2="+tmp[1];
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
