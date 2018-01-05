<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = 'Penandatangan';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('_search'); ?>

<div class="role-index">
    <div class="inline"><a class="btn btn-success" href="/datun/penandatangan/create" title="Tambah Role"><i class="fa fa-plus" aria-hidden="true"></i> Tambah Penandatangan</a></div>
    <div class="pull-right">
    	<a class="btn btn-warning disabled" id="idPilih"><i class="fa fa-check-square-o" aria-hidden="true"></i>Pilih</a>&nbsp;
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
				return ['data-id' => $data['kode']];
			},
			'columns' => [
				// '0'=>[
				// 	'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
				// 	'class'=>'yii\grid\SerialColumn',
				// 	'header'=>'No',
				// 	'contentOptions'=>['class'=>'text-center'],
				// ],
				'1'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kode',
					'contentOptions'=>['class'=>'text-center'],
					'value'=>function($data){
						return $data['kode'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:70%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jabatan Penandatangan', 
					'value'=>function($data){
						return $data['deskripsi'];
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$data['kode'].'" class="checkHapusIndex selection_one" />';
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
			var id 	= $(".selection_one:checked").val();
			var url = window.location.protocol + "//" + window.location.host + "/datun/penandatangan/update?id="+id;
			$(location).attr("href", url);
		});

		$("#idPilih").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var url = window.location.protocol + "//" + window.location.host + "/datun/penandatangan/viewpejabat?id="+id;
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/penandatangan/hapusdata'; ?>",
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
									$.notify({icon:"fa fa-info jarak-kanan", message:"Data berhasil dihapus"}, {type:"danger", showProgressbar: true});
								}
							}
						});
					}
				}
			});
		});

        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var url = window.location.protocol + "//" + window.location.host + "/datun/penandatangan/viewpejabat?id="+id;
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
	});
</script>
