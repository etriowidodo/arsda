<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	
	$this->title = 'Tembusan';
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
    <p class="text-right"><a class="btn btn-warning disabled" id="idPilih"><i class="fa fa-table jarak-kanan"></i>Pilih</a></p>

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
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:12%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kode',
					'value'=>function($data){
						return $data['kode_template_surat'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:70%', 'class'=>'text-center'],
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
						return '<input type="radio" name="selection[]" id="selection'.($index+1).'" value="'.$idnya.'" class="checkHapusIndex selection_one" />';
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
			$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-blue'});
			$("#idPilih").addClass("disabled");
		});

		$("#idPilih").on("click", function(){
			var id 	= $(".selection_one:checked").val();
			var url = window.location.protocol + "//" + window.location.host + "/datun/templatetembusan/view?id="+id;
			$(location).attr("href", url);
		});

        $(".role-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var url = window.location.protocol + "//" + window.location.host + "/datun/templatetembusan/view?id="+id;
			$(location).attr("href", url);
    	});

		$(".role-index").on("ifChecked", ".selection_one", function(){
			$("#idPilih").removeClass("disabled");
		}).on("ifUnchecked", ".selection_one", function(){
			$("#idPilih").addClass("disabled");
		});
		function endisButton(n){
			if(n == 1){
				$("#idPilih").removeClass("disabled");
			} else if(n > 1){
				$("#idPilih").addClass("disabled");
			} else{
				$("#idPilih").addClass("disabled");
			}
		}
	});
</script>
