<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
?>
<?php $form = ActiveForm::begin(['action'=>['getwarnegara'], 'method'=>'get', 'id'=>'searchFormWarganegara', 'options'=>['name'=>'searchFormWarganegara']]); ?>
<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
            <div class="col-md-10">
                <div class="input-group">
                    <input type="text" name="nama" id="nama" class="form-control" />
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

<div class="get-warga-index">
    <p style="margin-bottom:10px;"></p>
	<?php
        Pjax::begin(['id' => 'myPjaxModalWrg', 'timeout' => false, 'formSelector' => '#searchFormWarganegara', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer', 'id'=>'wrg-modal'],
            'dataProvider' => $dataProvider,
			'rowOptions' => function($data){
				$idnya = $data['id'].'#'.$data['nama'];
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
					'headerOptions'=>['style'=>'width:80%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Warga Negara', 
					'value'=>function($data){
						return $data['nama'];
					}, 
				],
				'aksi'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'#', 
					'value'=>function($data){
						//return $data['nama'];
					}, 
				],
            ],
        ]);
        Pjax::end();
    ?>
    <div class="modal-loading-new"></div>
	<div class="hide" id="filter-link"><?php echo '/pidsus/spdp/getwarnegara?id='.htmlspecialchars($_GET['id'], ENT_QUOTES);?></div>
    </div>
<style>
	.get-warga-index.loading {overflow: hidden;}
	.get-warga-index.loading .modal-loading-new {display: block;}
</style>
<script>
    $("#wrg-modal td").on("dblclick", function(){
        var id = $(this).closest("tr").data("id");
        var tm = id.toString().split('#');
        $("#id_warganegara").val(tm[0]);
        $("#warganegara").val(tm[1]);
        $("#tambah_form_warga").modal("hide");
        if(tm[1]=="Indonesia"){
            $("#suku").removeAttr('readonly');
        }else{
            $("#suku").attr('readonly','readonly');
        }
    });
    $(document).on('ready pjax:end', function() {
        $("#wrg-modal td").on("dblclick", function(){
            var id = $(this).closest("tr").data("id");
            var tm = id.toString().split('#');
            $("#id_warganegara").val(tm[0]);
            $("#warganegara").val(tm[1]);
            $("#tambah_form_warga").modal("hide");
            if(tm[1]=="Indonesia"){
            $("#suku").removeAttr('readonly');
            }else{
                $("#suku").attr('readonly','readonly');
            }
        });
    });
    
</script>