<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use app\modules\pidsus\models\GetJpu;
?>

<?php ActiveForm::begin(['action'=>['getlistjaksasita'], 'method'=>'get', 'id'=>'searchJpnSitaModal', 'options'=>['name'=>'searchJpnSitaModal', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
                	<input type="text" name="mjpnsita_q1" id="mjpnsita_q1" class="form-control" placeholder="Pencarian..." />
                    <div class="input-group-btn">
                        <button class="btn btn-warning" type="submit" name="btnCariJpnSitaModal" id="btnCariJpnSitaModal">Cari</button>
                        <a class="btn btn-info btn-flat resetCariJpnSitaModal" style="margin-left:10px;">Reset Pencarian</a>
                    </div>
                </div>
			</div>                    
		</div>
	</div>
	<div class="col-md-1"></div>
</div> 
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="jpnSitaWrapperModal" id="dom-target">
	<?php
        Pjax::begin(['id' => 'myPjaxJpnSitaModal', 'timeout' => false, 'formSelector' => '#searchJpnSitaModal', 'enablePushState' => false]);
            echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'tabel_list_jpnsita'],
            'layout' => "{summary}\n{items}\n<div class='text-center'>{pager}</div>",
            'dataProvider' => $dataProvider,
            'rowOptions' => function($data){
                $idnya = $data['peg_nip_baru'].'##'.$data['nama'].'##'.$data['gol_kd'].'##'.$data['gol_pangkatjaksa'].'##'.$data['jabatan'];
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
                    'header'=>'<input type="checkbox" name="selectAllJpnSitaModal" id="selectAllJpnSitaModal" />', 
                    'value'=>function($data, $index){
                		$idnya = $data['peg_nip_baru'].'##'.$data['nama'].'##'.$data['gol_kd'].'##'.$data['gol_pangkatjaksa'].'##'.$data['jabatan'];
                        return '<input type="checkbox" name="selectOneJpnSitaModal[]" id="selectOneJpnSitaModal'.($index+1).'" value="'.$idnya.'" class="selectOneJpnSitaModal" />';
                    }, 
                ],
            ],
        ]);
        Pjax::end();
    ?>			
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih_jpnsita_modal" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
    <div class="modal-loading-new"></div> 
</div>

<style>
	.jpnSitaWrapperModal.loading {overflow: hidden;}
	.jpnSitaWrapperModal.loading .modal-loading-new {display: block;}
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
	localStorage.removeItem("modalnyaDataJPNSita");
	var modalnyaDataJPNSita = {};
	var formValuesJPPSita = JSON.parse(localStorage.getItem('formValuesJPPSita')) || {};	
	$(".jpnSitaWrapperModal").find(".selectOneJpnSitaModal").each(function(i, v){
		var idnya = $(v).val().toString().split('##');
		(idnya[0] in formValuesJPPSita)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
	});
	
	$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});

	$('#myPjaxJpnSitaModal').on('pjax:send', function(){
		$(".jpnSitaWrapperModal").addClass("loading");
	}).on('pjax:success', function(a, b, c){
		$(".jpnSitaWrapperModal").find(".selectOneJpnSitaModal").each(function(i, v){
			var idnya = $(v).val().toString().split('##');
			(idnya[0] in formValuesJPPSita)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
			(idnya[0] in modalnyaDataJPNSita)?$(v).prop({'checked':'checked'}):$(v);
		});
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$(".jpnSitaWrapperModal").removeClass("loading");
	});	
	
	$(".jpnSitaWrapperModal").on("ifChecked", "input[name=selectAllJpnSitaModal]", function(){
		$(".selectOneJpnSitaModal").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selectAllJpnSitaModal]", function(){
		$(".selectOneJpnSitaModal").not(':disabled').iCheck("uncheck");
	});

	$("#searchJpnSitaModal").on("submit", function(){localStorage.removeItem("modalnyaDataJPNSita");});
	$(".jpnSitaWrapperModal").on("ifChecked", ".selectOneJpnSitaModal", function(){
		var nilai = $(this).val();
		var pecah = nilai.toString().split("##");
		modalnyaDataJPNSita[pecah[0]] = nilai;
		localStorage.setItem("modalnyaDataJPNSita", JSON.stringify(modalnyaDataJPNSita));
	}).on("ifUnchecked", ".selectOneJpnSitaModal", function(){
		var nilai = $(this).val();
		var pecah = nilai.toString().split("##");
		delete modalnyaDataJPNSita[pecah[0]];
		localStorage.setItem("modalnyaDataJPNSita", JSON.stringify(modalnyaDataJPNSita));
	});
        
	$(".resetCariJpnSitaModal").on("click", function(){
		$("#mjpnsita_q1").val("");
		$("#searchJpnSitaModal").trigger("submit");
	});
});
</script>