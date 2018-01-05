<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>

<div class="get-pegawai-index">
    <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
        <?php $form = ActiveForm::begin(['action'=>['getpegawai'], 'method'=>'get', 'id'=>'serachFormModalPegawai', 'options'=>['name'=>'serachFormModalPegawai']]); ?>
        <div class="row">
            <div class="col-md-offset-1 col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                    <div class="col-md-10">
                    	<div class="input-group">
                    		<input type="text" id="q1Modal" name="q1Modal" class="form-control" />
                    		<div class="input-group-btn"><button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button></div>
						</div>
					</div>
                </div>
            </div>
        </div>     
        <?php ActiveForm::end(); ?>
    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
	<?php
        Pjax::begin(['id' => 'myPjaxModal', 'timeout' => false, 'formSelector' => '#serachFormModalPegawai', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer'],
            'dataProvider' => $dataProvider,
			'columns' => [
				'Nomor'=>[
					'headerOptions'=>['style'=>'width:12%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'NIP'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'NIP', 
					'value'=>function($data){
						return $data['peg_nip_baru'];
					}, 
				],
				'NAMA'=>[
					'headerOptions'=>['style'=>'width:60%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Pegawai', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['nama'].'</p><p style="margin-bottom:0px;">'.$data['jabatan'].'</p>';
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Aksi', 
					'value'=>function($data, $index){
						return '<a data-pilih="'.$data['peg_nip_baru'].'#'.$data['nama'].'#'.$data['inst_satkerkd'].'#'.$data['unitkerja_kd'].'#'.$data['unitkerja_idk'].'" class="btn btn-success btn-sm pilihan">Pilih</a>';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
</div>

<style>
	.get-pegawai-index.loading {overflow: hidden;}
	.get-pegawai-index.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myPjaxModal').on('pjax:send', function(e){
			$(".get-pegawai-index").addClass("loading");
		}).on('pjax:success', function(e){
			$(".get-pegawai-index").removeClass("loading");
		});
	});
</script>
