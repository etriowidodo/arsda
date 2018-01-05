<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getp8'], 'method'=>'get', 'id'=>'searchFormJnsIns', 'options'=>['name'=>'searchFormJnsIns']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="q1" id="q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning btn-sm" name="btnSearch" id="btnSearch">Cari</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="get-insta-index">
    <p style="margin-bottom:10px;"></p>

	<?php
        Pjax::begin(['id' => 'myPjaxModalIns', 'timeout' => false, 'formSelector' => '#searchFormJnsIns', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'p8-tabel-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['no_p8_umum'].'#'.date('d-m-Y',strtotime($data['tgl_p8_umum']));
				return ['data-id' => $idnya];
			},
			'columns' => [
                                '0'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center'],
					'header'=>'No', 
					'class' => 'yii\grid\SerialColumn',
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:22%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor P-8 Umum', 
					'value'=>function($data){
						return $data['no_p8_umum'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tanggal', 
					'value'=>function($data){
						return ($data['tgl_p8_umum'])?date('d-m-Y',strtotime($data['tgl_p8_umum'])):'';
					}, 
				],
                                '3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Laporan Pidana', 
					'value'=>function($data){
						return $data['laporan_pidana'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = $data['no_p8_umum'].'#'.date('d-m-Y',strtotime($data['tgl_p8_umum']));
						return '<button type="button" name="selection[]" id="selection'.($index+1).'" data-id="'.$idnya.'" class="selection_one btn btn-primary btn-sm">Pilih</button>';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/pidsus/pds-p8-umum/getp6?q1='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
</div>
<style>
	.get-insta-index.loading {overflow: hidden;}
	.get-insta-index.loading .modal-loading-new {display: block;}
</style>

<script type="text/javascript">
	$(document).ready(function(){
		$("#myPjaxModalIns").on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$(".get-insta-index").addClass("loading");
		}).on('pjax:success', function(){
			$(".get-insta-index").removeClass("loading");
		});
	});
</script>