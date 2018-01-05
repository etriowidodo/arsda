<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\TtdPejabat;

	$this->title = 'Pejabat (Tandatangan)';
?>

<?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="control-label col-md-3" style="margin-top: 5px;">Jabatan</label>
			<div class="col-md-9">
                <select id="q2" name="q2" class="select2" style="width:100%;">
                    <option></option>
                    <?php 
                        $id_kejati  = $_SESSION['kode_kejati'];
                        $id_kejari  = $_SESSION['kode_kejari'];
                        $id_cabjari = $_SESSION['kode_cabjari'];
                        
                        $sqlOpt = "select * from pidsus.ms_penandatangan where id_kejati = '".$id_kejati."' and id_kejari = '".$id_kejari."' and id_cabjari = '".$id_cabjari."' order by kode";
                        $resOpt = TtdPejabat::findBySql($sqlOpt)->asArray()->all();
                        foreach($resOpt as $dOpt){
                            echo '<option value="'.$dOpt['kode'].'">'.$dOpt['deskripsi'].'</option>';
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
    <div class="inline"><a class="btn btn-success" href="/pidsus/ttd-pejabat/create"><i class="fa fa-plus jarak-kanan"></i>Tambah</a></div>
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
				$idnya = rawurlencode($data['kode'])."#".rawurlencode($data['nip']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:29%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'NIP / Nama (Pejabat)', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['nip'].'</p><p style="margin-bottom:0px;">'.$data['nama'].'</p>';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:40%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pangkat / Jabatan (Pejabat)', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['pangkat'].'</p><p style="margin-bottom:0px;">'.$data['jabatan'].'</p>';
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status / Jabatan (Tandatangan)', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['status'].'</p><p style="margin-bottom:0px;">'.$data['jabatan_ttd'].'</p>';
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:6%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['kode'])."#".rawurlencode($data['nip']);
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
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$("#idUbah, #idHapus").addClass("disabled");
		});

		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var tmp = id.toString().split("#");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/ttd-pejabat/update?id="+tmp[0]+"&id2="+tmp[1];
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/ttd-pejabat/hapusdata'; ?>",
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
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/ttd-pejabat/update?id="+tmp[0]+"&id2="+tmp[1];
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
