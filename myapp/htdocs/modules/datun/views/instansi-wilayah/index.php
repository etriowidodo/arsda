<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\datun\models\InstansiJenis;

	$this->title = 'Wilayah Instansi';
?>

<?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
<div class="row">
	<div class="col-md-3">
		<div class="form-group">
			<div class="col-md-12">
                <select id="q2" name="q2" style="width:100%;">
                    <option></option>
                    <?php 
                        $sqlOpt = "select * from datun.jenis_instansi order by kode_jenis_instansi";
                        $resOpt = InstansiJenis::findBySql($sqlOpt)->asArray()->all();
                        foreach($resOpt as $dOpt){
                            echo '<option value="'.$dOpt['kode_jenis_instansi'].'">'.$dOpt['deskripsi_jnsinstansi'].'</option>';
                        }
                    ?>
                </select>
            </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="form-group">
			<div class="col-md-12">
                <select id="q3" name="q3" style="width:100%;">
                </select>
            </div>
		</div>
	</div>
	<div class="col-md-5">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
                	<input type="text" name="q1" id="q1" class="form-control" placeholder="Pencarian..." />
                    <div class="input-group-btn"><button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button></div>
                </div>
            </div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #fff;margin: 10px 0;">

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="/datun/instansi-wilayah/create"><i class="fa fa-plus jarak-kanan"></i>Tambah Wilayah Instansi</a></div>
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
				$idnya = rawurlencode($data['kode_jenis_instansi'])."#".rawurlencode($data['kode_instansi'])."#".rawurlencode($data['kode_provinsi'])."#".
						 rawurlencode($data['kode_kabupaten'])."#".rawurlencode($data['kode_tk'])."#".rawurlencode($data['no_urut']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'header'=>'Jenis Instansi',
					'contentOptions'=>['class'=>'text-left'],
					'value'=>function($data){
						return $data['deskripsi_jnsinstansi'];
					}, 
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'header'=>'Instansi',
					'contentOptions'=>['class'=>'text-left'],
					'value'=>function($data){
						return $data['deskripsi_instansi'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:43%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Wilayah Instansi', 
					'value'=>function($data){
						return $data['deskripsi_inst_wilayah'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:7%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['kode_jenis_instansi'])."#".rawurlencode($data['kode_instansi'])."#".rawurlencode($data['kode_provinsi'])."#".
								 rawurlencode($data['kode_kabupaten'])."#".rawurlencode($data['kode_tk'])."#".rawurlencode($data['no_urut']);
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
		$("#q2").select2({placeholder:"Pilih Jenis Instansi", allowClear:true});
		$("#q3").select2({placeholder:"Pilih Instansi", allowClear:true});

		$("select#q2").change(function(){
			$("select#q3").val("").trigger('change').select2('close');
			$("select#q3 option").remove();
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/instansi-wilayah/getinstansi'; ?>',
				data	: { q1 : $("select#q2").val() },
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.items != ""){
						$("select#q3").select2({data:data.items, placeholder:"Pilih Instansi", allowClear:true});
						return false;
					}
				}
			});
		});

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
			var prm = "id="+tmp[0]+"&id2="+tmp[1]+"&id3="+tmp[2]+"&id4="+tmp[3]+"&id5="+tmp[4]+"&id6="+tmp[5];
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi-wilayah/update?"+prm;
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/instansi-wilayah/hapusdata'; ?>",
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
			var tmp = id.toString().split("#");
			var prm = "id="+tmp[0]+"&id2="+tmp[1]+"&id3="+tmp[2]+"&id4="+tmp[3]+"&id5="+tmp[4]+"&id6="+tmp[5];
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi-wilayah/update?"+prm;
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
