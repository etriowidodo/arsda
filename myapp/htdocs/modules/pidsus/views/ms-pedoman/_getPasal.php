<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getformpasal'], 'method'=>'get', 'id'=>'searchFormJnsIns', 'options'=>['name'=>'searchFormJnsIns']]); ?>
<div class="row">
	<div class="col-md-offset-1 col-md-10">
		<div class="form-group form-group-sm">
			<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
			<div class="col-md-10">
				<div class="input-group">
					<input type="text" name="jnsins_q1" id="jnsins_q1" class="form-control" />
					<input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($_GET['id'], ENT_QUOTES);?>" />
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
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'jns-ins-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['id_pasal'];
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pasal', 
					'value'=>function($data){
						return $data['pasal'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Bunyi', 
					'value'=>function($data){
						return $data['bunyi'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = $data['id_pasal']."|#|".$data['pasal'];
						return '<button type="button" name="selection[]" id="selection'.($index+1).'" data-id="'.$idnya.'" class="selection_one btn btn-primary btn-sm">Pilih</button>';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/pidsus/ms-pedoman/getformpasal?id='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
</div>
<style>
	.get-insta-index.loading {overflow: hidden;}
	.get-insta-index.loading .modal-loading-new {display: block;}
</style>

<script type="text/javascript">
	$("#myPjaxModalIns").on('pjax:beforeSend', function(a, b, c){
                $("#filter-link").text(c.url);
        }).on('pjax:send', function(){
                $(".get-insta-index").addClass("loading");
        }).on('pjax:success', function(){
                $(".get-insta-index").removeClass("loading");
                $("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
                $("#idUbah, #idPilih, #idHapus").addClass("disabled");
        });
</script>