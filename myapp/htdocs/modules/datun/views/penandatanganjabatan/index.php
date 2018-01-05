<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\Menu */

$this->title = 'Penandatangan Jabatan';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php //echo $this->render('_search'); ?>

<div class="role-index">
    <div class="inline">
		<a class="btn btn-warning" href="<?php echo Yii::$app->request->baseUrl.'/datun/penandatanganjabatan/create?id='.$kode;?>" title="Tambah TTD Jabatan">
		Tambah Penandatangan Jabatan</a>
	</div>
    <div class="pull-right">
    	<a class="btn btn-success disabled" id="idUbah" title="Edit">Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus" title="Hapus">Hapus</a>
	</div>
    <p>&nbsp;</p>

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			//'filterModel' => $searchModel,
			'rowOptions' => function($data){
				return ['data-id' => $data['kode']];
			},
			'columns' => [
				/* 'Kode'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center', 'type'=>'hidden'],
					'visible' => '0',
					'format'=>'raw',
					'header'=>'kode', 
					'value'=>function($data){
						return $data['kode'];
					}, 
				], */
				'Nomor'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'NIP'=>[
					'headerOptions'=>['style'=>'width:15%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'NIP', 
					'value'=>function($data){
						return $data['nip'];
					}, 
				],
				'Nama'=>[
					'headerOptions'=>['style'=>'width:25%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
				'Jabatan'=>[
					'headerOptions'=>['style'=>'width:28%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jabatan', 
					'value'=>function($data){
						return $data['jabatan'];
					}, 
				],
				'Pangkat'=>[
					'headerOptions'=>['style'=>'width:28%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pangkat', 
					'value'=>function($data){
						return $data['pangkat'];
					}, 
				],
				'Status'=>[
					'headerOptions'=>['style'=>'width:28%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'value'=>function($data){
						return $data['stats'];
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$data['kode_tk'].'-'.$data['kode'].'-'.$data['nip'].'-'.$data['kode_st'].'-'.$data['nama'].'-'.$data['jabatan'].'-'.$data['pangkat'].'" class="checkHapusIndex selection_one" />';
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
			var url = window.location.protocol + "//" + window.location.host + "/datun/penandatanganjabatan/update?id="+id;
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
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-center jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-center'}
				},
				callback: function (result) {
					if(result){
						$("body").addClass("loading");
						//$.post(url, {'id' : id}, function(data){}, "json");
						$.ajax({
							type	: "POST",
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/penandatanganjabatan/hapusdata'; ?>",
							data	: { 'id' : id },
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$("body").removeClass("loading");
									$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false});
									$.notify('Data berhasil dihapus', {type: 'success', icon: 'fa fa-info', allow_dismiss: true, showProgressbar: true});
								} else{
									$("body").removeClass("loading");
								}
							}
						});
					}
				}
			});
		});

	//fungsi double click	
        // $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			// var id = $(this).closest("tr").data("id");
			// var url = window.location.protocol + "//" + window.location.host + "/datun/penandatanganjabatan/update?id="+id;
			// $(location).attr("href", url);
    	// });

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
