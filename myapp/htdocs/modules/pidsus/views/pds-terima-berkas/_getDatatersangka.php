<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getdatatersangka'], 'method'=>'get', 'id'=>'searchDataTsk', 'options'=>['name'=>'searchDataTsk']]); ?>
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" name="mDataTskq1" id="mDataTskq1" class="form-control" />
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-warning btn-sm" name="btnSearchDataTsk" id="btnSearchDataTsk">Cari</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>     
<?php ActiveForm::end(); ?>
<hr style="border-color: #fff;margin: 10px 0;">

<div class="get-data-tersangka-index">
	<?php
        Pjax::begin(['id' => 'myPjaxModalDataTsk', 'timeout' => false, 'formSelector' => '#searchDataTsk', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'tblDataTskModal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = rawurlencode($data['no_urut']).'#'.rawurlencode($data['nama']).'#'.rawurlencode($data['tmpt_lahir']).'#'.
						 rawurlencode(($data['tgl_lahir']?date("d-m-Y", strtotime($data['tgl_lahir'])):'')).'#'.rawurlencode(($data['umur']?$data['umur']:'')).'#'.
						 rawurlencode($data['warganegara']).'#'.rawurlencode($data['kebangsaan']).'#'.rawurlencode($data['suku']).'#'.
						 rawurlencode($data['id_identitas']).'#'.rawurlencode($data['no_identitas']).'#'.rawurlencode($data['id_jkl']).'#'.
						 rawurlencode($data['id_agama']).'#'.rawurlencode($data['alamat']).'#'.rawurlencode($data['no_hp']).'#'.
						 rawurlencode(($data['id_pendidikan']>=0?$data['id_pendidikan']:"")).'#'.rawurlencode($data['pekerjaan']);
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
					'headerOptions'=>['style'=>'width:45%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama', 
					'value'=>function($data){
						return $data['nama'].'<br /><small><i>('.$data['tsk_dari'].')</i></small>';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:35%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Tempat dan Tanggal Lahir', 
					'value'=>function($data){
						return ($data['tmpt_lahir']?$data['tmpt_lahir']:'').($data['tgl_lahir']?', '.date("d-m-Y", strtotime($data['tgl_lahir'])):'');
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idnya = rawurlencode($data['no_urut']).'#'.rawurlencode($data['nama']).'#'.rawurlencode($data['tmpt_lahir']).'#'.
								 rawurlencode(($data['tgl_lahir']?date("d-m-Y", strtotime($data['tgl_lahir'])):'')).'#'.rawurlencode(($data['umur']?$data['umur']:'')).'#'.
								 rawurlencode($data['warganegara']).'#'.rawurlencode($data['kebangsaan']).'#'.rawurlencode($data['suku']).'#'.
								 rawurlencode($data['id_identitas']).'#'.rawurlencode($data['no_identitas']).'#'.rawurlencode($data['id_jkl']).'#'.
								 rawurlencode($data['id_agama']).'#'.rawurlencode($data['alamat']).'#'.rawurlencode($data['no_hp']).'#'.
								 rawurlencode(($data['id_pendidikan']>=0?$data['id_pendidikan']:"")).'#'.rawurlencode($data['pekerjaan']);
						return '<button type="button" data-id="'.$idnya.'" class="btn btn-sm btn-warning pilihDataTskModal">Pilih</button>';
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
	.get-data-tersangka-index.loading {overflow: hidden;}
	.get-data-tersangka-index.loading .modal-loading-new {display: block;}
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
<script type="text/javascript">
$(document).ready(function(){
	$('#myPjaxModalDataTsk').on('pjax:beforeSend', function(a, b, c){
		$("#filter-link").text(c.url);
	}).on('pjax:send', function(){
		$(".get-data-tersangka-index").addClass("loading");
	}).on('pjax:complete', function(){
		$(".get-data-tersangka-index").removeClass("loading");
	});
});
</script>