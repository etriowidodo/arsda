<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use mdm\admin\models\searchs\Menu as MenuSearch;
?>

<div class="get-modal-pegawai">
	<?php $form = ActiveForm::begin(['action'=>['getpegawai'], 'method'=>'get', 'id'=>'searchModalPeg', 'options'=>['name'=>'searchModalPeg']]); ?>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" id="mpegq1" name="mpegq1" class="form-control input-sm" />
                        <input type="hidden" id="tipe" name="tipe" value="<?php echo htmlspecialchars($_GET['tipe'], ENT_QUOTES);?>" />
                        <span class="input-group-btn"><button type="submit" class="btn btn-warning btn-sm" name="btnSearch" id="btnSearch">Cari</button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>     
    <?php ActiveForm::end(); ?>
    <hr style="border-color:#fff; margin:10px 10px 0px;">
	<?php
        Pjax::begin(['id' => 'myPjaxModalPeg', 'timeout' => false, 'formSelector' => '#searchModalPeg', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'modal-tabel-pegawai'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['nip'].'#'.$data['nama'].'#'.$data['jabatan_pegawai'].'#'.$data['alamat'];
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
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nip', 
					'value'=>function($data){
						return $data['nip'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:30%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:34%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Jabatan', 
					'value'=>function($data){
						return $data['jabatan_pegawai'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:6%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Aksi', 
					'value'=>function($data, $index){
						$idnya = $data['nip'].'#'.$data['nama'].'#'.$data['jabatan_pegawai'].'#'.$data['alamat'];
						return '<a data-id="'.$idnya.'" class="btn btn-success btn-sm pilihPeg" title="Pilih Role">Pilih</a>';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
</div>

<style>
	.get-modal-pegawai.loading {overflow: hidden;}
	.get-modal-pegawai.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myPjaxModalPeg').on('pjax:send', function(e){
			$(".get-modal-pegawai").addClass("loading");
		}).on('pjax:success', function(e){
			$(".get-modal-pegawai").removeClass("loading");
		});
	});
</script>
