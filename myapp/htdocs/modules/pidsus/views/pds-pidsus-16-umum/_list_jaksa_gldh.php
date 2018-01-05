<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use app\modules\pidsus\models\GetJpu;
?>

<?php ActiveForm::begin(['action'=>['getlistjaksagldh'], 'method'=>'get', 'id'=>'searchJpnGldhModal', 'options'=>['name'=>'searchJpnGldhModal', 'class'=>'form-horizontal']]); ?>
<div class="row">
	<div class="col-md-1"></div>
	<div class="col-md-10">
		<div class="form-group">
			<div class="col-md-12">
				<div class="input-group">
                	<input type="text" name="mjpngldh_q1" id="mjpngldh_q1" class="form-control" placeholder="Pencarian..." />
                    <div class="input-group-btn">
                        <button class="btn btn-warning" type="submit" name="btnCariJpnGldhModal" id="btnCariJpnGldhModal">Cari</button>
                        <a class="btn btn-info btn-flat resetCariJpnGldhModal" style="margin-left:10px;">Reset Pencarian</a>
                    </div>
                </div>
			</div>                    
		</div>
	</div>
	<div class="col-md-1"></div>
</div> 
<?php ActiveForm::end(); ?>
<hr style="border-color:#fff; margin:10px 10px 0px;">

<div class="jpnGldhWrapperModal" id="dom-target">
	<?php
        Pjax::begin(['id' => 'myPjaxJpnGldhModal', 'timeout' => false, 'formSelector' => '#searchJpnGldhModal', 'enablePushState' => false]);
            echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover', 'id'=>'tabel_list_jpngldh'],
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
                    'header'=>'<input type="checkbox" name="selectAllJpnGldhModal" id="selectAllJpnGldhModal" />', 
                    'value'=>function($data, $index){
                		$idnya = $data['peg_nip_baru'].'##'.$data['nama'].'##'.$data['gol_kd'].'##'.$data['gol_pangkatjaksa'].'##'.$data['jabatan'];
                        return '<input type="checkbox" name="selectOneJpnGldhModal[]" id="selectOneJpnGldhModal'.($index+1).'" value="'.$idnya.'" class="selectOneJpnGldhModal" />';
                    }, 
                ],
            ],
        ]);
        Pjax::end();
    ?>			
    <div class="box-footer" style="text-align:center;">
        <button class="btn btn-warning jarak-kanan pilih_jpngldh_modal" type="button">Pilih</button>
        <button class="btn btn-danger" data-dismiss="modal" type="button">Batal</button>
    </div>
    <div class="modal-loading-new"></div> 
</div>

<style>
	.jpnGldhWrapperModal.loading {overflow: hidden;}
	.jpnGldhWrapperModal.loading .modal-loading-new {display: block;}
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
	localStorage.removeItem("modalnyaDataJPNGldh");
	var modalnyaDataJPNGldh = {};
	var formValuesJPPGldh = JSON.parse(localStorage.getItem('formValuesJPPGldh')) || {};	
	$(".jpnGldhWrapperModal").find(".selectOneJpnGldhModal").each(function(i, v){
		var idnya = $(v).val().toString().split('##');
		(idnya[0] in formValuesJPPGldh)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
	});
	
	$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});

	$('#myPjaxJpnGldhModal').on('pjax:send', function(){
		$(".jpnGldhWrapperModal").addClass("loading");
	}).on('pjax:success', function(a, b, c){
		$(".jpnGldhWrapperModal").find(".selectOneJpnGldhModal").each(function(i, v){
			var idnya = $(v).val().toString().split('##');
			(idnya[0] in formValuesJPPGldh)?$(v).prop({'checked':'checked', 'disabled':'disabled'}):$(v).removeProp('checked disabled');
			(idnya[0] in modalnyaDataJPNGldh)?$(v).prop({'checked':'checked'}):$(v);
		});
		$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$(".jpnGldhWrapperModal").removeClass("loading");
	});	
	
	$(".jpnGldhWrapperModal").on("ifChecked", "input[name=selectAllJpnGldhModal]", function(){
		$(".selectOneJpnGldhModal").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "input[name=selectAllJpnGldhModal]", function(){
		$(".selectOneJpnGldhModal").not(':disabled').iCheck("uncheck");
	});

	$("#searchJpnGldhModal").on("submit", function(){localStorage.removeItem("modalnyaDataJPNGldh");});
	$(".jpnGldhWrapperModal").on("ifChecked", ".selectOneJpnGldhModal", function(){
		var nilai = $(this).val();
		var pecah = nilai.toString().split("##");
		modalnyaDataJPNGldh[pecah[0]] = nilai;
		localStorage.setItem("modalnyaDataJPNGldh", JSON.stringify(modalnyaDataJPNGldh));
	}).on("ifUnchecked", ".selectOneJpnGldhModal", function(){
		var nilai = $(this).val();
		var pecah = nilai.toString().split("##");
		delete modalnyaDataJPNGldh[pecah[0]];
		localStorage.setItem("modalnyaDataJPNGldh", JSON.stringify(modalnyaDataJPNGldh));
	});
        
	$(".resetCariJpnGldhModal").on("click", function(){
		$("#mjpngldh_q1").val("");
		$("#searchJpnGldhModal").trigger("submit");
	});
});
</script>