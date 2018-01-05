<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use mdm\admin\models\searchs\Menu as MenuSearch;
	$this->title = 'Kejaksaan';
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
<hr style="border-color: #fff;margin: 10px 0;">

<div class="role-index">
    <div id="#wrapper-table">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],
			'dataProvider' => $dataProvider,
			'columns' => [
				'0'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Kode Satker',
					'value'=>function($data){
						return $data['inst_satkerkd'];
					}, 
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Kejaksaan',
					'value'=>function($data){
						return $data['inst_nama'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Lokasi', 
					'value'=>function($data){
						return $data['inst_lokinst'];
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Alamat', 
					'value'=>function($data){
						return $data['inst_alamat'];
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
	});
});
</script>
