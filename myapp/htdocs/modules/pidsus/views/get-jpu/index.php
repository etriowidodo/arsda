<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use app\modules\pidsus\models\GetJpu;
?>

<?php ActiveForm::begin(['action'=>['index'], 'method'=>'get', 'id'=>'searchModalJpn', 'options'=>['name'=>'searchModalJpn', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
                	<input type="text" name="mjpn_q1" id="mjpn_q1" class="form-control" placeholder="Pencarian..." />
                    <div class="input-group-btn">
                        <button class="btn btn-warning" type="submit" name="btnCariM1" id="btnCariM1">Cari</button>
                        <a class="btn btn-info btn-flat reset-cari-jpu" style="margin-left:10px;">Reset Pencarian</a>
                    </div>
                </div>
			</div>                    
		</div>
	</div>
	<div class="col-md-1"></div>
</div> 
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="jpn-index" id="dom-target">
	<div id="#wrapper-table">
		<?php
			Pjax::begin(['id' => 'myPjaxModalJpn', 'timeout' => false, 'formSelector' => '#searchModalJpn', 'enablePushState' => false]);
                echo GridView::widget([
				'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'jpn-jpn-modal'],
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
                        'header'=>'<input type="checkbox" name="selection_all_jpn" id="selection_all_jpn" />', 
                        'value'=>function($data, $index){
                            $idnya = $data['peg_nip_baru'].'#'.$data['nama'].'#'.$data['pangkatgol'].'#'.$data['gol_kd'].'#'.$data['gol_pangkatjaksa'].'#'.$data['jabatan'];
							return '<input type="checkbox" name="selection_one_jpn[]" id="selection_one_jpn'.($index+1).'" value="'.$idnya.'" class="selection_one_jpn"  />';
                        }, 
                    ],
                ],
            ]);
			Pjax::end();
		?>			
	</div>
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih-jpn" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
	<div class="modal-loading-new"></div> 
</div>

<style>
	.jpn-index.loading {overflow: hidden;}
	.jpn-index.loading .modal-loading-new {display: block;}
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
	localStorage.removeItem("modalnyaDataJPN");
	var modalnyaDataJPN = {};
	var formValues 		= JSON.parse(localStorage.getItem('formValues')) || {};	
	$(".jpn-index").find(".selection_one_jpn").each(function(i, v){
		var idnya = $(v).val().toString().split('#');
		(idnya[0] in formValues)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
	});
	
	$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});

	$('#myPjaxModalJpn').on('pjax:send', function(){
		$(".jpn-index").addClass("loading");
	}).on('pjax:success', function(a, b, c){
		$(".jpn-index").find(".selection_one_jpn").each(function(i, v){
			var idnya = $(v).val().toString().split('#');
			(idnya[0] in formValues)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
			(idnya[0] in modalnyaDataJPN)?$(v).prop({'checked':'checked'}):$(v);
		});
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$(".jpn-index").removeClass("loading");
	});	
	
	$(".jpn-index").on("ifChecked", "input[name=selection_all_jpn]", function(){
		$(".selection_one_jpn").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selection_all_jpn]", function(){
		$(".selection_one_jpn").not(':disabled').iCheck("uncheck");
	});

	$("#searchModalJpn").on("submit", function(){localStorage.removeItem("modalnyaDataJPN");});
	$(".jpn-index").on("ifChecked", ".selection_one_jpn", function(){
		var nilai = $(this).val();
		var pecah = nilai.toString().split("#");
		modalnyaDataJPN[pecah[0]] = nilai;
		localStorage.setItem("modalnyaDataJPN", JSON.stringify(modalnyaDataJPN));
	}).on("ifUnchecked", ".selection_one_jpn", function(){
		var nilai = $(this).val();
		var pecah = nilai.toString().split("#");
		delete modalnyaDataJPN[pecah[0]];
		localStorage.setItem("modalnyaDataJPN", JSON.stringify(modalnyaDataJPN));
	});
        
        $(".reset-cari-jpu").on("click", function(){
		$("#mjpn_q1").val("");
		$("#searchModalJpn").trigger("submit");
	});
});
</script>