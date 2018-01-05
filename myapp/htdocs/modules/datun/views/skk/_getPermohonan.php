<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use mdm\admin\models\searchs\Menu as MenuSearch;
?>

<div class="get-role-index">
	<?php $form = ActiveForm::begin(['action'=>['getpermohonan'], 'method'=>'get', 'id'=>'serachFormModalRole', 'options'=>['name'=>'serachFormModalRole']]); ?>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                <div class="col-md-10">
                    <div class="input-group">
                        <input type="text" id="m1q1" name="m1q1" class="form-control input-sm" />
                        <span class="input-group-btn"><button type="submit" class="btn btn-warning btn-sm" name="btnSearch" id="btnSearch">Cari</button></span>
                    </div>
                </div>
            </div>
        </div>
    </div>     
	<?php ActiveForm::end(); ?>
    <hr style="border-color:#fff; margin:10px 10px 0px;">
	<?php
        Pjax::begin(['id' => 'myPjaxModal', 'timeout' => false, 'formSelector' => '#serachFormModalRole', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'modal-tabel-permohonan'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['deskripsi_jnsinstansi'].'#'.$data['deskripsi_instansi'].'#'.$data['deskripsi_inst_wilayah'].'#'.$data['alamat_instansi'].'#'.
						 $data['pimpinan_pemohon'].'#'.$data['diterima_satker'].'#'.$data['no_register_perkara'].'#'.$data['no_surat'].'#'.$data['nama_pengadilan'].'#'.
						 date("d-m-Y", strtotime($data['tanggal_panggilan_pengadilan'])).'#'.$data['nip_penerima_kuasa'].'#'.$data['nama_penerima_kuasa'].'#'.
						 $data['jabatan_penerima_kuasa'].'#'.$data['alamat_penerima_kuasa'].'#'.$data['kode_jenis_instansi'].'#'.$data['kode_tk'].'#'.$data['inst_lokinst'].'#'.
						 $data['tanggal_permohonan'];
				return ['data-id' => $idnya];
			},
			'columns' => [
				'1'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'No Register Perkara', 
					'value'=>function($data){
						return $data['no_register_perkara'];
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nomor / Tangal Surat', 
					'value'=>function($data){
						return (!in_array($data['kode_jenis_instansi'],array("01","06"))?$data['no_surat'].'<br>':'').date("d/m/Y", strtotime($data['tanggal_permohonan']));
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:24%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pemohon', 
					'value'=>function($data){
						$pemohon = $data['deskripsi_inst_wilayah'];
						return $pemohon;
					}, 
				],
				'4'=>[
					'headerOptions'=>['style'=>'width:24%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Lawan Pemohon', 
					'value'=>function($data){
						$temp = explode('#', $data['lawan_pemohon']);
						$text = '';
						if(count($temp) > 0 && count($temp) == 1){
							$text .= '<p style="margin-bottom:0px;">'.$temp[0].'</p>';
						} else if(count($temp) > 0 && count($temp) != 1){
							foreach($temp as $idx=>$res){
								$nom = $idx+1;
								$text .= '<div style="margin-bottom: 5px; width: 100%; display: table;">';
								$text .= '<div style="display: table-cell; width: 23px;">'.$nom.'.</div><div style="display: table-cell;">'.$res.'</div>';
								$text .= '</div>';
							}
						}
						return $text;
					}, 
				],
				'5'=>[
					'headerOptions'=>['style'=>'width:6%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'value'=>function($data){
						return $data['status_telaah'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:6%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Aksi', 
					'value'=>function($data, $index){
						$idnya = $data['deskripsi_jnsinstansi'].'#'.$data['deskripsi_instansi'].'#'.$data['deskripsi_inst_wilayah'].'#'.$data['alamat_instansi'].'#'.
								 $data['pimpinan_pemohon'].'#'.$data['diterima_satker'].'#'.$data['no_register_perkara'].'#'.$data['no_surat'].'#'.$data['nama_pengadilan'].'#'.
								 date("d-m-Y", strtotime($data['tanggal_panggilan_pengadilan'])).'#'.$data['nip_penerima_kuasa'].'#'.$data['nama_penerima_kuasa'].'#'.
								 $data['jabatan_penerima_kuasa'].'#'.$data['alamat_penerima_kuasa'].'#'.$data['kode_jenis_instansi'].'#'.$data['kode_tk'].'#'.
								 $data['inst_lokinst'].'#'.$data['tanggal_permohonan'];
						return '<a data-id="'.$idnya.'" class="btn btn-success btn-sm pilihan" title="Pilih Role">Pilih</a>';
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
</div>

<style>
	.get-role-index.loading {overflow: hidden;}
	.get-role-index.loading .modal-loading-new {display: block;}
</style>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myPjaxModal').on('pjax:send', function(e){
			$(".get-role-index").addClass("loading");
		}).on('pjax:success', function(e){
			$(".get-role-index").removeClass("loading");
		});
	});
</script>
