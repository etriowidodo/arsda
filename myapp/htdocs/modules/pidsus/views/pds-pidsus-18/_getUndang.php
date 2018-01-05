<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getformundang'], 'method'=>'get', 'id'=>'searchFormUU', 'options'=>['name'=>'searchFormUU']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="undang_q1" id="undang_q1" class="form-control" />
					<div class="input-group-btn">
						<button type="submit" class="btn btn-warning btn-sm" name="btnSearchModalUu" id="btnSearchModalUu">Cari</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #fff;margin: 10px 0;">

<div class="get-uu-index">
    <p style="margin-bottom:10px;"></p>

	<?php
        Pjax::begin(['id' => 'myPjaxModalUnd', 'timeout' => false, 'formSelector' => '#searchFormUU', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tblModalUu'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['id']).'|#|'.rawurlencode($data['uu']);
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Undang Undang', 
					'value'=>function($data){
						return $data['uu'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Deskripsi', 
					'value'=>function($data){
						return $data['deskripsi'];
					}, 
				],
                                '3'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tentang', 
					'value'=>function($data){
						return $data['tentang'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['id']).'|#|'.rawurlencode($data['uu']);
						return '<button type="button" data-id="'.$idnya.'" class="pilihModalUU btn btn-pidsus btn-sm">Pilih</button>';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"></div>
</div>
<style>
	.get-uu-index.loading {overflow: hidden;}
	.get-uu-index.loading .modal-loading-new {display: block;}
</style>
<script>
    $("#myPjaxModalUnd").on('pjax:beforeSend', function(a, b, c){
		$("#filter-link").text(c.url);
    }).on('pjax:send', function(){
		$(".get-uu-index").addClass("loading");
    }).on('pjax:success', function(){
		$(".get-uu-index").removeClass("loading");
    });
</script>
