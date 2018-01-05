<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;

	$paramId = Yii::$app->request->get();
	$this->title = 'Tembusan '.$paramId['id'];
?>

<div class="role-index">
    <div class="inline">
    	<a class="btn btn-success addTembusan"><i class="fa fa-plus jarak-kanan"></i>Tambah Tembusan</a>
    	<a class="btn btn-info hide" id="idReset"><i class="fa fa-retweet jarak-kanan"></i>Batal Ubah</a>&nbsp;
    	<a class="btn btn-info" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah Semua</a>&nbsp;
	</div>
    <div class="pull-right">
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p>&nbsp;</p>

    <form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/templatetembusan/simpan">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['id' => 'table-tembusan', 'class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				return ['data-id' => $data['kode_template_surat'].'#'.$data['no_urut']];
			},
			'summary' => '',
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center nomnya'],
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:72%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tembusan', 
					'value'=>function($data, $index){
						return '<span class="txtnya" data-count="'.($index+1).'">'.$data['tembusan'].'</span>
						<span class="formnya hide"><input type="text" id="tembusan'.($index+1).'" name="tembusan[]" value="'.$data['tembusan'].'" class="form-control" /></span>';
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						$idnya = $data['kode_template_surat'].'#'.$data['no_urut'];
						return '<span class="delDb">
						<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="checkHapusIndex selection_one" /></span>
						<span class="delFm hide">
						<a class="btn btn-danger hRow" style="padding: 2px 7px;" data-id="'.$idnya.'"><i class="fa fa-times"></i></a></span></span>';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
    <div class="text-center"> 
        <input type="hidden" name="hdnId" id="hdnId" value="<?php echo $paramId['id'];?>" />
        <button class="btn btn-warning jarak-kanan disabled" type="submit" id="simpan" name="simpan">Simpan</button>
        <a href="/datun/templatetembusan/index" class="btn btn-danger">Batal</a>
    </div>
    </form>

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
			$(".selection_one").trigger("ifChecked");
		});

		$(".addTembusan").on("click", function(){
			var tabel 	= $("#table-tembusan");
			var rwTbl	= tabel.find('tbody > tr:last');
			var rwNom	= parseInt(rwTbl.find("span.txtnya").data('count'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			var idnya	= $("#hdnId").val()+'#'+newId;

			var objTr 	= '<tr data-id="'+idnya+'">'+
				'<td class="text-center nomnya"></td>'+
				'<td><span data-count="'+newId+'" class="txtnya hide"></span><input type="text" name="tembusan[]" id="tembusan'+newId+'" class="form-control" /></td>'+
				'<td class="text-center aksinya">'+
					'<a class="btn btn-danger hRow" style="padding: 2px 7px;" data-id="'+idnya+'"><i class="fa fa-times"></i></a>'+
				'</td>'+
			'</tr>';
			if(isNaN(rwNom)){
				rwTbl.remove();
				rwTbl = tabel.find('tbody');
				rwTbl.append(objTr);
			} else{
				rwTbl.after(objTr);
			}
			tabel.find(".nomnya").each(function(i,v){$(this).text(i+1);});
			saveAble(tabel);
		});

		$("#idReset").on("click", function(){
			var tabel = $("#table-tembusan");
			$("#idUbah").removeClass("hide");
			$("#idReset").addClass("hide");
			tabel.find(".txtnya").removeClass("hide");
			tabel.find(".formnya").addClass("hide");
			tabel.find(".delDb").removeClass("hide");
			tabel.find(".delFm").addClass("hide");
			saveAble(tabel);
		});

		$("#idUbah").on("click", function(){
			var tabel = $("#table-tembusan");
			tabel.find(".txtnya").addClass("hide");
			tabel.find(".formnya").removeClass("hide");
			tabel.find(".delDb").addClass("hide");
			tabel.find(".delFm").removeClass("hide");
			if(tabel.find(".formnya").length > 0){
				$("#idUbah").addClass("hide");
				$("#idReset").removeClass("hide");
			}
			saveAble(tabel);
			$(".selection_one").iCheck("uncheck");
		});

		$("#table-tembusan").on("click", ".hRow", function(){
			var tabel 	= $("#table-tembusan");
			var idnya 	= $(this).data('id');
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $("#table-tembusan > tbody");
				nRow.append('<tr><td colspan="3"><div class="empty">Tidak ada data yang ditemukan.</div></td></tr>');
			} else{
				tabel.find(".nomnya").each(function(i,v){$(this).text(i+1);});
			}
			saveAble(tabel);
		});

		function saveAble(tabel){
			var hitung = tabel.find(".hRow:visible").length;
			if(hitung > 0){ 
				$("#simpan").removeClass("disabled");
				$(".selection_one").iCheck('disable');
			} else{
				$("#simpan").addClass("disabled");
				$(".selection_one").iCheck('enable');
			}
		}
		
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/templatetembusan/hapusdata'; ?>",
							data	: { 'id' : id },
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$("body").removeClass("loading");
									$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false});
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data berhasil dihapus"}, {type:"success", showProgressbar: true});
								} else{
									$("body").removeClass("loading");
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data gagal dihapus"}, {type:"danger", showProgressbar: true});
								}
							}
						});
					}
				}
			});
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
				$("#idHapus").removeClass("disabled");
			} else if(n > 1){
				$("#idHapus").removeClass("disabled");
			} else{
				$("#idHapus").addClass("disabled");
			}
		}
	});
</script>
