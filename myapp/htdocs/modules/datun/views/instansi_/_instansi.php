
<style>
#m_instansi
{
    margin-top: 70px !important;
} 
</style>




<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $searchModel app\modules\pidum\models\PidumPdmSpdpSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */



 $this->subtitle = 'INSTANSI';
$this->title = 'MASTER'; 

//$this->params['breadcrumbs'][] = $this->title;
?>
<?php /* if(Yii::$app->session->getFlash('message') != null): */ ?><!--
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>	<i class="icon fa fa-check"></i> <?/*= Yii::$app->session->getFlash('message'); */?></h4>
</div>
--><?php /* endif */ ?>

<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
		<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">			
			<?php// $form = ActiveForm::begin(['action'=>['index2'], 'method'=>'get', 'id'=>'searchForm2', 'options'=>['name'=>'searchForm2']]); ?>						
			<?php $form = ActiveForm::begin(['method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>									
				   <div class="row"><br>
						<div class="col-md-12">
							<div class="form-group">
								<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
								<div class="col-md-8"><input type="text" name="i1" id="i1" class="form-control" /></div>
								<div class="col-md-2" style=" margin-left: -20px;"><button class="btn btn-warning" type="submit" ><i class="fa fa-search" aria-hidden="true"></i> Cari</button></div>
							
					
							</div>
						</div>
						
						

					</div>  
			
			<?php ActiveForm::end(); ?>
		</div>


<div class="instansi-instansi">
<div class="inline" style=" padding: 0px;" ><a class="btn btn-success" id="idtambah_instansi" title="Tambah Jenis Instansi"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</a></div>  
	<div class="pull-right" style=" margin-top: 20px;">
		<a href="/datun/instansi/index" class="btn btn-danger" style="background-color:	#008B8B; border-style:inset ;border-color:#008B8B" title="Kembali ke Jenis Instansi"><i class="fa fa-reply jarak-kanan" aria-hidden="true"></i> Kembali</a>
		<a class="btn btn-warning" id="idpilih_instansi" title="Pilih Instansi"><i class="fa fa-check-square-o" aria-hidden="true"></i> Pilih</a>		
    	<a class="btn btn-info disabled" id="idUbah_instansi" title="Ubah Instansi"><i class="fa fa-stack-exchange" aria-hidden="true"></i> Ubah</a>
    	<a class="btn btn-danger disabled" id="idHapus_instansi" title="Hapus Instansi"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
	</div>

    <div id="#wrapper-table" style=" padding-top: 5px;">
	<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);
		
		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],			
			'dataProvider' => $dataProviderInstansi,			
			'rowOptions' => function($data){			
				return ['data-id' => $data['kode_jenis_instansi'],'data-id2' => $data['kode_instansi']];
			},
			
		 	'columns' => [

				'Nomor'=>[
					'headerOptions'=>['style'=>'width:1%', 'class'=>'text-center'],					
					'format'=>'raw',
					'header'=>'Kode Jenis', 
					'value'=>function($data){
						return $data['kode_jenis_instansi'];
					}, 
					],	

					
				'Nomor2'=>[
					'headerOptions'=>['style'=>'width:1%', 'class'=>'text-center'],					
					'format'=>'raw',
					'header'=>'Kode Instansi', 
					'value'=>function($data){
						return $data['kode_instansi'];
					}, 
					],					
					
				'Modul'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],					
					'format'=>'raw',
					'header'=>'Deskripsi', 
					'value'=>function($data){
						return $data['deskripsi_instansi'];
					}, 
					],
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:1%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$data['kode_jenis_instansi'].'/'.$data['kode_instansi'].'" class="checkHapusIndex selection_one" />';
					}, 
				],
				

				
			], 
		]);
		Pjax::end();
    ?>
	<small style=" color:#FF0000;font-size: 12px;font-weight: normal;"> &nbsp;*Doble Click atau pilih salah satu</small>
    </div>
		
</div>


<div class="modal-loading-new"></div>
<div class="hide" id="filter-link"></div>
<style type="text/css">
</style>

<script type="text/javascript">
	$(document).ready(function(){
		//alert($id);
		$('#myPjax').on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$("body").addClass("loading");
		}).on('pjax:complete', function(){
			$("body").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$(".selection_one").trigger("ifChecked");
		});

		$("#idUbah_instansi").on("click", function(){
	
	
			var id 	= $(".selection_one:checked").val();
		
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/updateinstansi?id="+id;
			$(location).attr("href", url);
						
		});
		
		$("#idHapus_instansi").on("click", function(){
		
			var id 	= [];
			var n 	= $(".selection_one:checked").length;
			for(var i = 0; i < n; i++){
				var test = $(".selection_one:checked").eq(i);
				id.push(test.val());
			}
	
			bootbox.confirm({
				message: "Apakah anda ingin menghapus data ini?",
				size: "small",
				closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function (result) {
					if(result){
						$("body").addClass("loading");
						//$.post(url, {'id' : id}, function(data){}, "json");
						$.ajax({
							type	: "POST",
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/instansi/hapusdatainstansi'; ?>",
							data	: { 'id' : id },
							cache	: false,
							dataType: "json",
							success : function(data){ 
								if(data.hasil){
									$("body").removeClass("loading");
									$.pjax({url: $("#filter-link").text(), container: '#myPjax', 'push':false, 'timeout':false});
								//	$.notify('Data berhasil dihapus', {type: 'success', icon: 'fa fa-info', allow_dismiss: true});
								} else{
									$("body").removeClass("loading");
								}
							}
							
						});
						
						
					}
				}
				
					
			});
		});


		$("#idtambah_instansi").click(function () {
            $("#m_instansi").modal('show');

        });
		
		
		$("#idpilih_instansi").on("click", function(){
			
			var id 	= [];
			var n 	= $(".selection_one:checked").length;
			for(var i = 0; i < n; i++){
				var test = $(".selection_one:checked").eq(i);
				id.push(test.val());
			}


			
			if( i >= 2){
			
				alert('Pilihan Tidak boleh lebih dari Satu')
				return				
			}
			if( i == 0){
				
			alert('Pilih Instansi Terlebih dahulu')
				return
			}
					
						
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/pilih_instansi?id="+id;
			$(location).attr("href", url);
		
		
		});		
		
	


	
        $(".instansi-instansi").on("dblclick", "td:not(.aksinya)", function(){	

		
			var id = $(this).closest("tr").data("id");
			var id2 = $(this).closest("tr").data("id2");


			
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/pilih_instansi?id="+id+"/"+id2;
			$(location).attr("href", url);






		
/* 			//var id = $(this).closest("tr").data("id");
			var id 	= [];
			var n 	= $(".selection_one:checked").length;
			for(var i = 0; i < n; i++){
				var test = $(".selection_one:checked").eq(i);
				id.push(test.val());
			}		

			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/pilih_instansi?id="+id;
			$(location).attr("href", url);	 */		
			
    	});

		$(".instansi-instansi").on("ifChecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("uncheck");
		});
		$(".instansi-instansi").on("ifChecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		}).on("ifUnchecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		});
		
		function endisButton(n){
			
			if(n == 1){
				$("#idUbah_instansi").removeClass("disabled");
				$("#idHapus_instansi").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah_instansi").addClass("disabled");
				$("#idHapus_instansi").removeClass("disabled");
			} else{
				$("#idUbah_instansi").addClass("disabled");
				$("#idHapus_instansi").addClass("disabled");
			}
		}
	});
	
</script>


<!-- =======================================================MODAL INSTANSI ========================================================-->


<?php
Modal::begin([
    'id' => 'm_instansi',
    'header' => 'INSTANSI',
    'options' => [
        'data-url' => '',
    ],
]);
?> 


<?=
$this->render('_tambah_instansi', [
    'model' 	=> $model,
	'kode1'	   	=> $kode1,	
	'nmjns'	   	=> $nmjns,
	'kode2'		=> $urut,

])


?>

<?php
Modal::end();
?>



<!-- =======================================================MODAL JENIS INSTANSI/N ========================================================-->

