<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	$this->title = 'Config';
	$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-config-index">
    <?php
		if($dataProvider->totalCount > 0){
			echo GridView::widget([
				'dataProvider' => $dataProvider,
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
						'contentOptions'=>['class'=>'text-center'],
						'value'=>function($data){
							return '<a title="Ubah" href="/pidum/pdm-config/update?id='.$data['kd_satker'].'"><span class="glyphicon glyphicon-pencil"></span></a>';
						}, 
					],
				],
				'summary' => '',
			]);
		} else echo '<a href="/pidum/pdm-config/create" class="btn btn-success">Set Satker</a>';
	?>
</div>
