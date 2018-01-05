<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use mdm\admin\models\searchs\Menu as MenuSearch;
?>

<div class="get-role-index">
    <div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
        <?php $form = ActiveForm::begin(['action'=>['getrole'], 'method'=>'get', 'id'=>'serachFormModalRole', 'options'=>['name'=>'serachFormModalRole']]); ?>
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="form-group">
                    <label class="control-label col-md-2" style="margin-top: 5px;">Modul</label>
                    <div class="col-md-6">
                        <select id="q1Modal" name="q1Modal" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                $resOpt = MenuSearch::findBySql("select distinct module from public.menu where module is not null")->asArray()->all();
                                foreach($resOpt as $dOpt){
                                    echo '<option value="'.$dOpt['module'].'">'.$dOpt['module'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                    <div class="col-md-4"><button type="submit" class="btn btn-warning btn-sm" name="btnSearch" id="btnSearch">Cari</button></div>
                </div>
            </div>
            <div class="col-md-1"></div>
        </div>     
        <?php ActiveForm::end(); ?>
    </div>
    <hr style="border-color: #c7c7c7;margin: 10px 0;">
	<?php
        Pjax::begin(['id' => 'myPjaxModal', 'timeout' => false, 'formSelector' => '#serachFormModalRole', 'enablePushState' => false]);
        echo GridView::widget([
            'tableOptions' => ['class' => 'table table-bordered table-hover explorer'],
            'dataProvider' => $dataProvider,
			'columns' => [
				'Nomor'=>[
					'headerOptions'=>['style'=>'width:10%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'Modul'=>[
					'headerOptions'=>['style'=>'width:41%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Modul', 
					'value'=>function($data){
						return $data['module'];
					}, 
				],
				'NamaRole'=>[
					'headerOptions'=>['style'=>'width:41%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Nama Role', 
					'value'=>function($data){
						return '<a style="cursor:pointer;" data-id="'.$data['id_role'].'#'.$data['module'].'#'.$data['nama_role'].'" class="menunya">'.$data['nama_role'].'</a>';
					}, 
				],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'Aksi', 
					'value'=>function($data, $index){
						return '<a data-id="'.$data['id_role'].'" data-pilih="'.$data['id_role'].'#'.$data['module'].'#'.$data['nama_role'].'" class="btn btn-success btn-sm pilihan" title="Pilih Role">Pilih</a>';
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
		var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
		$(".select2").select2({placeholder: "Pilih salah satu", allowClear: true});
		$('#myPjaxModal').on('pjax:send', function(e){
			$(".get-role-index").addClass("loading");
		}).on('pjax:success', function(e){
			$(".get-role-index").find(".pilihan").each(function(i, v){
				var idnya = $(v).data("id");
				(idnya in formValues)?$(v).addClass("disabled"):$(v).removeClass("disabled");
			});
			$(".get-role-index").removeClass("loading");
		});
	});
</script>
