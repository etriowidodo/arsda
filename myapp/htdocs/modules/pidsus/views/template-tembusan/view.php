<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;

	$paramId = Yii::$app->request->get();
	$this->title = 'Tembusan '.$paramId['id'];
?>

<div class="role-index">
    <div class="inline"><a class="btn btn-success addTembusan"><i class="fa fa-plus jarak-kanan"></i>Tambah Tembusan</a></div>
    <div class="pull-right">
    	<a class="btn btn-info disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus"><i class="fa fa-trash jarak-kanan"></i>Hapus</a>
	</div>
    <p>&nbsp;</p>

    <form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/template-tembusan/simpan">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['id' => 'table-tembusan', 'class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['kode_template_surat']).'#'.rawurlencode($data['no_urut']);
				return ['data-id' => $idnya];
			},
			'summary' => '',
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center nomnya'],
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:74%', 'class'=>'text-center'],
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
						$idnya = rawurlencode($data['kode_template_surat']).'#'.rawurlencode($data['no_urut']);
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
    <div class="text-center"> 
        <input type="hidden" name="hdnId" id="hdnId" value="<?php echo rawurlencode($paramId['id']);?>" />
        <button class="btn btn-warning jarak-kanan disabled" type="submit" id="simpan" name="simpan">Simpan</button>
        <a href="/pidsus/template-tembusan/index" class="btn btn-danger">Batal</a>
    </div>
    </form>

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

	$(".addTembusan").on("click", function(){
		$("#idUbah, #idHapus").addClass("disabled");
		$(".selection_one, #selection_all").iCheck('uncheck');
		var tabel 	= $(".role-index").find("#table-tembusan");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.txtnya").data('count'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var idnya	= $("#hdnId").val()+'#'+newId;

		var objTr 	= '<tr data-id="'+idnya+'">'+
			'<td class="text-center nomnya"></td>'+
			'<td><span data-count="'+newId+'" class="txtnya hide"></span><span class="formnya">'+
			'<input type="text" name="tembusan[]" id="tembusan'+newId+'" class="form-control" /></span></td>'+
			'<td class="text-center aksinya"><input type="checkbox" name="selection[]" id="selection'+newId+'" value="'+idnya+'" class="hRow" /></td>'+
		'</tr>';
		tabel.find(".formnya").val(tabel.find(".txtnya").text());
		tabel.find(".txtnya").removeClass("hide");
		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append(objTr);
		} else{
			rwTbl.after(objTr);
		}
		tabel.find(".nomnya").each(function(i,v){$(this).text(i+1);});
		$("#selection"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		saveAble(tabel);
	});

	$("#idUbah").on("click", function(){
		var tbl = $("#role-form").find("#table-tembusan");
		var idm = tbl.find(".selection_one:checked").val();
		var row = $("tr[data-id='"+idm+"']");
		row.find(".txtnya").addClass("hide");
		row.find(".formnya").removeClass("hide");
		saveAble(tbl);
	});

	$(".role-index").on("dblclick", "td:not(.aksinya)", function(){
		var tbl = $("#role-form").find("#table-tembusan");
		var row = $(this).closest("tr");
		row.find(".txtnya").addClass("hide");
		row.find(".formnya").removeClass("hide");
		saveAble(tbl);
	});

	function saveAble(tabel){
		var hitung = tabel.find(".formnya:visible").length;
		console.log(hitung);
		if(hitung > 0){
			$("#simpan").removeClass("disabled");
			$("#role-form").find(".selection_one").iCheck('disable');
		} else{
			$("#simpan").addClass("disabled");
			$("#role-form").find(".selection_one").iCheck('enable');
		}
		$("#idUbah, #idHapus").addClass("disabled");
	}
	
	$("#idHapus").on("click", function(){
		var tbl = $("#role-form").find("#table-tembusan");
		var n 	= $(".selection_one:checked").length;
		var m 	= tbl.find(".hRow:checked").length;
		if(m > 0){
			tbl.find(".hRow:checked").each(function(k, v){
				var idnya = $(v).val();
				tbl.find("tr[data-id='"+idnya+"']").remove();
				if($("#table_tembusan > tbody").find("tr").length == 1){
					var nRow = $("#table-tembusan > tbody");
					nRow.append('<tr><td colspan="3"><div class="empty">Tidak ada data yang ditemukan.</div></td></tr>');
				} else{
					tbl.find(".nomnya").each(function(i,v){$(this).text(i+1);});
				}
			});
			saveAble(tbl);
		}

		if(n > 0){
			var id 	= [];
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/pidsus/template-tembusan/hapusdata'; ?>",
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
		}
	});

	$(".role-index").on("ifChecked", "input[name=selection_all]", function(){
		$(".selection_one, .hRow").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selection_all]", function(){
		$(".selection_one, .hRow").not(':disabled').iCheck("uncheck");
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
	
	$(".role-index").on("ifChecked", ".hRow", function(){
		var n = $(".hRow:checked").length;
		rowisButton(n);
	}).on("ifUnchecked", ".hRow", function(){
		var n = $(".hRow:checked").length;
		rowisButton(n);
	});
	function rowisButton(n){
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
