<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
//	use app\modules\pidsus\models\GetTtd;
?>

<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="modal-spdp-index">

    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjaxModalSpdp', 'timeout' => false, 'formSelector' => '#searchModalSpdp', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'table-spdp-modal'],
			'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				
				return ['data-id' => $model['no_urut_tersangka']];
			},
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'header'=>'No', 
					'class' => 'yii\grid\SerialColumn',
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:40%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor Surat', 
					'value'=>function($data){
						return $data['no_surat_t7'];
					}, 
				],
                                '2'=>[
					'headerOptions'=>['style'=>'width:40%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal', 
					'value'=>function($data){
						return $data['tgl_ba7'];
					}, 
				],   
                                '3'=>[
					'headerOptions'=>['style'=>'width:40%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jenis', 
					'value'=>function($data){
						return $data['jenis'];
					}, 
				],
                                '4'=>[
					'headerOptions'=>['style'=>'width:40%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Lokasi Tahanan', 
					'value'=>function($data){
						return $data['lokasi_tahanan'];
					}, 
				],
                                '5'=>[
					'headerOptions'=>['style'=>'width:40%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'value'=>function($data){
						return $data['status'];
					}, 
				],
			],
		]);
		Pjax::end();
    ?>
		<!--<p style="margin-bottom:5px;" class="text-center"><a class="btn btn-warning btn-sm disabled" id="idPilihSpdpModal"><i class="fa fa-table jarak-kanan"></i>Pilih</a></p>-->
    </div>

    <div class="modal-loading-new"></div>
    <!--<div class="hide" id="filter-link-spdp"></div>-->
</div>

<style>
	.modal-spdp-index.loading {overflow: hidden;}
	.modal-spdp-index.loading .modal-loading-new {display: block;}
	ul.pagination {margin:0px;}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: inherit;
		font-size: inherit;
	}
</style>