<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use app\modules\pidsus\models\GetJpu;
?>

<?php ActiveForm::begin(['action'=>['penyidik'], 'method'=>'get', 'id'=>'searchModalJpnPenyidik', 'options'=>['name'=>'searchModalJpnPenyidik', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
                	<input type="text" name="mjpnp_q1" id="mjpnp_q1" class="form-control" placeholder="Pencarian..." />
                    <div class="input-group-btn">
                        <button class="btn btn-warning" type="submit" name="btnCariM2" id="btnCariM2">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-jpu-penyidik" style="margin-left:10px;">Reset Pencarian</a>
                    </div>
                </div>
			</div>                    
		</div>
	</div>
	<div class="col-md-1"></div>
</div> 
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="jpn-penyidik-index" id="dom-target">
	<div id="#wrapper-table">
		<?php
			Pjax::begin(['id' => 'myPjaxModalJpnPenyidik', 'timeout' => false, 'formSelector' => '#searchModalJpnPenyidik', 'enablePushState' => false]);
                echo GridView::widget([
				'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'jpn-jpn-penyidik-modal'],
				'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
				'dataProvider' => $dataProvider,
				'rowOptions' => function($data){
					$idnya = $data['peg_nip_baru'].'#'.$data['nama'].'#'.$data['pangkatgol'].'#'.$data['gol_kd'].'#'.$data['gol_pangkatjaksa'].'#'.$data['jabatan'];
					return ['data-id' => $idnya];
				},
                'columns' => [
                    'nomor'=>[
                        'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
                        'class'=>'yii\grid\SerialColumn',
                        'header'=>'No',
                        'contentOptions'=>['class'=>'text-center'],
                    ],
                    '1'=>[
                        'headerOptions'=>['style'=>'width:38%', 'class'=>'text-center'],
                        'format'=>'raw',
                        'header'=>'NIP / Nama',
                        'value'=>function($data){
                            return '<p style="margin-bottom:0px;">'.$data['peg_nip_baru'].'</p><p style="margin-bottom:0px;">'.$data['nama'].'</p>';
                        }, 
                    ],
                    '2'=>[
                        'headerOptions'=>['style'=>'width:47%', 'class'=>'text-center'],
                        'format'=>'raw',
                        'header'=>'Jabatan / Pangkat',
                        'value'=>function($data){
                            return '<p style="margin-bottom:0px;">'.$data['jabatan'].'</p><p style="margin-bottom:0px;">'.$data['pangkatgol'].'</p>';
                        }, 
                    ],
                    'Aksi'=>[
                        'headerOptions'=>['style'=>'width:7%', 'class'=>'text-center'],
                        'contentOptions'=>['class'=>'text-center aksinya'],
                        'format'=>'raw',
                        'header'=>'Pilih', 
                        'value'=>function($data, $index){
                            $idnya = $data['peg_nip_baru'].'#'.$data['nama'].'#'.$data['pangkatgol'].'#'.$data['gol_kd'].'#'.$data['gol_pangkatjaksa'].'#'.$data['jabatan'];
							return '<input type="radio" name="pilih-jpnp-modal[]" id="pilih-jpnp-modal'.($index+1).'" value="'.$idnya.'" class="pilih-jpnp-modal" />';
                        }, 
                    ],
                ],
            ]);
			Pjax::end();
		?>			
	</div>
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih-jpn-penyidik" type="button" disabled>Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
	<div class="modal-loading-new"></div> 
</div>

<style>
	.jpn-penyidik-index.loading {overflow: hidden;}
	.jpn-penyidik-index.loading .modal-loading-new {display: block;}
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
	var formValuesJPP 		= JSON.parse(localStorage.getItem('formValuesJPP')) || {};	
	$(".jpn-penyidik-index").find(".pilih-jpnp-modal").each(function(i, v){
		var idnya = $(v).val().toString().split('#');
		(idnya[0] in formValuesJPP)?$(v).attr({'disabled':'disabled'}):$(v).removeAttr('disabled');
	});
	$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});

	$('#myPjaxModalJpnPenyidik').on('pjax:send', function(){
		$(".jpn-penyidik-index").addClass("loading");
	}).on('pjax:success', function(a, b, c){
		$(".jpn-penyidik-index").find(".pilih-jpnp-modal").each(function(i, v){
			var idnya = $(v).val().toString().split('#');
			(idnya[0] in formValuesJPP)?$(v).attr({'disabled':'disabled'}):$(v).removeAttr('disabled');
		});
		$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
		$(".jpn-penyidik-index").removeClass("loading");
	});	
	
	$(".jpn-penyidik-index").on("ifChecked", ".pilih-jpnp-modal", function(){
		$(".pilih-jpn-penyidik").removeAttr("disabled");
	});
        
	$(".reset-cari-jpu-penyidik").on("click", function(){
		$("#mjpnp_q1").val("");
		$("#searchModalJpnPenyidik").trigger("submit");
	});
});
</script>