


<?php

	use yii\helpers\Html;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	use yii\widgets\ActiveForm;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use yii\helpers\ArrayHelper;
	
 	if($model->isNewRecord){
		$this->title = 'MASTER';
		$this->subtitle = 'UBAH JENIS INSTANSI';
		$this->params['breadcrumbs'][] = $this->title;
	} else{
		$this->title = 'MASTER';
		$this->subtitle = 'JENIS INSTANSI';
		$this->params['breadcrumbs'][] = $this->title;
	} 	
	
	
/* 	 $this->subtitle = 'TAMBAH JENIS INSTANSI';
	 $this->title = 'MASTER';  */
	 
?>



<div style="border-color: #f39c12; padding: 15px; overflow: hidden;"  class="box box-primary col-md-5">
<?php $form = ActiveForm::begin(['action'=>['get_ttd'],'method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
    <div class="row">
        <div class="col-md-offset-1 col-md-10">
            <div class="form-group">
                <label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
                <div class="col-md-10">
                    <div class="input-group">
                    	<input type="text" name="q1" id="q1" class="form-control" />
						<input type="hidden" name="id" id="id" class="form-control" value="<?php echo $id; ?>" />
                        <div class="input-group-btn">
                        	<button type="submit" class="btn btn-warning" name="btnSearch" id="btnSearch">Cari</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
	<?php ActiveForm::end(); ?>	
        </div>
 



<form id="role-form" name="role-form" style=" padding: 1px;" class="form-validasi form-horizontal" method="post" action="/datun/instansi/simpanjenis">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
	<div class="ttd-index" id="#wrapper-table">
						<?php
							Pjax::begin(['id' => 'myPjax2', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
							echo GridView::widget([
							//	'showHeader' => false,
								'tableOptions' => ['id' => 'table-tandatangan', 'class' => 'table table-bordered table-hover'],
								'dataProvider' => $dataProviderx,
								'rowOptions' => function($data){
									return ['data-id' => $data['nip']];
								},
								'summary' => '',
								'columns' => [

				'0'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',
					'header'=>'No',
					'contentOptions'=>['class'=>'text-center'],
				],
				'1'=>[
					'headerOptions'=>['style'=>'width:31%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'NIP / Nama', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['nip'].'</p><p style="margin-bottom:0px;">'.$data['nama'].'</p>';
					}, 
				],
				'2'=>[
					'headerOptions'=>['style'=>'width:46%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Pangkat / Jabatan', 
					'value'=>function($data){
						return '<p style="margin-bottom:0px;">'.$data['pangkat'].'</p><p style="margin-bottom:0px;">'.$data['jabatan'].'</p>';
					}, 
				],
				'3'=>[
					'headerOptions'=>['style'=>'width:8%', 'class'=>'text-center'],
					'format'=>'raw',
					'header'=>'Status', 
					'contentOptions'=>['class'=>'text-center'],
					'value'=>function($data){
						return $data['status'];
					}, 
				],				
				
				'aksi'=>[
					'headerOptions'=>['style'=>'width:5%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'', 
					'value'=>function($data, $index){
						$idKab = $data['kode'].'.'.$data['nip'];
						return '<a data-id="'.$data['kode_tk'].'.'.$data['nip'].'" data-pilih="'.$data['nama'].'#'.$data['nip'].'#'.$data['jabatan'].'#'.$data['pangkat'].'" class="btn btn-info btn-sm pilihan" title="Pilih TTD">Pilih</a>';
					}, 
				],								

								],
							]);
							Pjax::end();
							?>
						
	</div>
</div>						

<div id="preview-menu"></div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 

	<a href="/datun/instansi/index"  class="btn btn-danger" data-dismiss="modal" ><i class="fa fa-ban" aria-hidden="true"></i> Batal</a>
	<!--<button type="button" data-dismiss="modal" class="btn btn-danger" style="display: inline-block;">Batal</button> -->
</div>
</form>
<div class="modal-loading-new"></div>

<script type="text/javascript">

$(document).ready(function(){
/* $('#role-form').validator('update')
var ckode = document.getElementById('deskripsi_jnsinstansi').value;

		if(ckode==''){
			$("#status").attr("value",'0');								
					document.getElementById('kode_jenis_instansi').readOnly  = false;	
					
		}else{
			$("#status").attr("value",'1');
			document.getElementById('kode_jenis_instansi').readOnly =true;
		
			
		} */
		
		var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
		$('#myPjax2Modal').on('pjax:send', function(e){
			$(".ttd-index").addClass("loading");
		}).on('pjax:success', function(e){
			$(".ttd-index").find(".pilihan").each(function(i, v){
				var idnya = $(v).data("id");
				(idnya in formValues)?$(v).addClass("disabled"):$(v).removeClass("disabled");
			});
			$(".ttd-index").removeClass("loading");
		});		
		
		
		
		
});


</script>

	