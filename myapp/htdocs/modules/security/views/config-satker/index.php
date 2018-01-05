<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	$this->title = 'Config';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="config-satker-index">
    <?php
		if($dataProvider->totalCount > 0){
			echo GridView::widget([
				'tableOptions' => ['class' => 'table table-bordered table-hover'],
				'dataProvider' => $dataProvider,
				'rowOptions' => function($data){
					return ['data-id' => $data['kd_satker']];
				},
				'columns' => [
					'kdsatker'=>[
						'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
						'header'=>'Kode Satker',
						'contentOptions'=>['class'=>'text-center'],
						'value'=>function($data){
							return $data['kd_satker'];
						}, 
					],
					'satker'=>[
						'headerOptions'=>['style'=>'width:70%', 'class'=>'text-center'],
						'format'=>'raw',
						'header'=>'Nama Satker', 
						'value'=>function($data){
							return $data['inst_nama'];
						}, 
					],
					'time'=>[
						'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
						'format'=>'raw',
						'header'=>'Time Format',
						'contentOptions'=>['class'=>'text-center'],
						'value'=>function($data){
							return $data['time_format'];
						}, 
					],
					'aksi'=>[
						'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
						'format'=>'raw',
						'header'=>'Aksi',
						'contentOptions'=>['class'=>'text-center aksinya'],
						'value'=>function($data){
							return '<a title="Ubah" href="/autentikasi/config-satker/update?id='.$data['kd_satker'].'"><span class="glyphicon glyphicon-pencil"></span></a>';
						}, 
					],
				],
				'summary' => '',
			]);
		} else echo '<a href="/autentikasi/config-satker/create" class="btn btn-success">Set Satker</a>';
	?>
</div>
<div class="modal-loading-new"></div>
<div class="hide" id="filter-link"></div>
<style type="text/css">
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myPjax').on('pjax:send', function(){
			$("body").addClass("loading");
		}).on('pjax:complete', function(){
			$("body").removeClass("loading");
		});

        $(".config-satker-index").on("dblclick", "td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			var url = window.location.protocol + "//" + window.location.host + "/autentikasi/config-satker/update?id="+id;
			$(location).attr("href", url);
    	});
	});
</script>
