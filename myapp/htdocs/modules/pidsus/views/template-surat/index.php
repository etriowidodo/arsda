<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	$this->title = 'Template Surat';
?>

<?php $form = ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="q1" id="q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 0;">

<div class="role-index">
    <p class="text-right"><a class="btn btn-info disabled" id="idUbah"><i class="fa fa-pencil jarak-kanan"></i>Ubah</a></p>

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['kode_template_surat']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:12%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kode',
					'value'=>function($data){
						return $data['kode_template_surat'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:80%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Deskripsi', 
					'value'=>function($data){
						return $data['deskripsi_template_surat'];
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Pilih', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['kode_template_surat']);
						return '<input type="radio" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="selection_one" />';
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
			$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
			$("#idUbah").addClass("disabled");
		});

		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/template-surat/update?id="+id;
			$(location).attr("href", url);
		});

        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var url = window.location.protocol + "//" + window.location.host + "/pidsus/template-surat/update?id="+id;
			$(location).attr("href", url);
    	});

		$(".role-index").on("ifChecked", ".selection_one", function(){
			$("#idUbah").removeClass("disabled");
		}).on("ifUnchecked", ".selection_one", function(){
			$("#idUbah").addClass("disabled");
		});
		function endisButton(n){
			if(n == 1){
				$("#idUbah").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah").addClass("disabled");
			} else{
				$("#idUbah").addClass("disabled");
			}
		}
	});
</script>
