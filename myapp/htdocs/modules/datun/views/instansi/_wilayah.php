
<style>
#m_wilayah 
{
    margin-top: 20px !important;
} 
</style>


<?php
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\widgets\ActiveForm;
use app\modules\datun\models\searchs\Menu as MenuSearch;

 $this->subtitle = 'INSTANSI/BUMN/BUMD';
$this->title = 'MASTER'; 

//$this->params['breadcrumbs'][] = $this->title;
?>
<?php /* if(Yii::$app->session->getFlash('message') != null): */ ?><!--
<div class="alert alert-success alert-dismissable">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    <h4>	<i class="icon fa fa-check"></i> <?/*= Yii::$app->session->getFlash('message'); */?></h4>
</div>
--><?php /* endif */ ?>

	
<!---A-->

<div class="instansi-wilayah">
	<div class=" inline" style="margin: 0px;">	
		<?php $form = ActiveForm::begin(['method'=>'get', 'id'=>'searchForm', 'options'=>['name'=>'searchForm']]); ?>
		<div class="col-md-12">
			<p class="control-label " id="nama_instansi"  style="font-size:18px; color:#00acd6" align="left" ></p>
				<div style="border-color: #f39c12;overflow: hidden; " class="box box-primary" >
				<!--	<p class="control-label " id="nama_instansi"  style="font-size:16px; color:#eaba05" align="center" ></p>	-->

					<div class="row">
					
							<div class="col-md-6" style=" padding-top: 70px;">
								<div class="form-group">
									<label class="control-label col-md-2" style="margin-top: 5px;">Pencarian</label>
									<div class="col-md-8"><input type="text" name="w1" id="w1" class="form-control" /></div> 
									<div class="col-md-2" style="margin-left: -25px;"><button class="btn btn-warning" type="submit" id="idcari"><i class="fa fa-search" aria-hidden="true"></i> Cari</button></div>									
								</div>
							</div>
					
						
						
					
							<div class="col-md-6" style="margin-top: 0px;">	
							
								<fieldset class="scheduler-border">
									<legend class="scheduler-border" style="font-size:14px;color:#FF0000"><b>Filter :</b></legend>
														
											<div class="col-md-12" style="margin-top: 0px;">	
																					
												<label class="control-label col-md-6" style="margin-top: 5px;">Wilayah ( Provinsi )</label>
												<div class="col-md-6" style="margin-left: -25px; width:240px">
													<select id="w3" name="w3" class="select2"  style="width:100%;">
														<option></option>
															<?php 
															$resOpt = MenuSearch::findBySql("select distinct id_prop,deskripsi from datun.m_propinsi where deskripsi is not null order by id_prop")->asArray()->all();
																foreach($resOpt as $dOpt){
																	echo '<option value="'.$dOpt['id_prop'].'">'.$dOpt['deskripsi'].'</option>';
																}
															?>
													</select>
												</div>                    
												 
											</div>

											<div class="col-md-12" style="margin-top: 5px;">														
												<div class="form-group">
													<label class="control-label col-md-6" style="margin-top: 5px;">Wilayah ( Kota Kabupaten )</label>
													<div class="col-md-6" style="margin-left: -25px; width:240px">
													
														<select id="w4" name="w4" class="select2" style="width:100%;" >
														</select>

													</div>                    
												</div>        				
											</div>	
								</fieldset>	
								
							</div>	
							


					</div>  
				
				

						
						
					
				</div>
		</div>

		<?php ActiveForm::end(); ?>		
	</div>
	
	
<hr style="border-color: #c7c7c7;margin: 10px 0;">



<!---A-->

	
 <div class="inline" style=" padding: 0px;" ><a class="btn btn-success" id="idtambah_wilayah" title="Tambah Instansi Wilayah"><i class="fa fa-plus" aria-hidden="true"></i> Tambah</a></div> 
    <div class="pull-right" style=" margin-top: 20px;">
		<a href="<?php echo Yii::$app->request->baseUrl.'/datun/instansi/pilih_jenis?id='.$kode1;?>" class="btn btn-danger" style="background-color:#008B8B; border-style:inset ;border-color:#008B8B" title="Kembali ke Instansi" type="button" data-dismiss="modal"><i class="fa fa-reply jarak-kanan" aria-hidden="true"></i>Kembali</a>
    	<a class="btn btn-info disabled" id="idUbah" title="Ubah Instansi Wilayah"><i class="fa fa-stack-exchange" aria-hidden="true"></i> Ubah</a>&nbsp;
    	<a class="btn btn-danger disabled" id="idHapus" title="Hapus Instansi Wilayah"><i class="fa fa-trash" aria-hidden="true"></i> Hapus</a>
	</div>


    <div id="#wrapper-table" style=" padding-top: 5px;">
		<?php
		Pjax::begin(['id' => 'myPjax', 'timeout' => false, 'formSelector' => '#searchForm', 'enablePushState' => false]);

		echo GridView::widget([
			'tableOptions' => ['class' => 'table table-bordered table-hover'],			
			'dataProvider' => $dataProviderWilayah,

			'rowOptions' => function($data){
				return ['data-id' => $data['kode_jenis_instansi'],
						'data-id2' => $data['kode_instansi'],
						'data-id3' => $data['kode_provinsi'],
						'data-id4' => $data['kode_kabupaten'],
						'data-id5' => $data['kode_tk'],
						'data-id6' => $data['no_urut']];
			},
			
			 'columns' => [
				 
				'Nomor'=>[
					'headerOptions'=>['style'=>'width:1%', 'class'=>'text-center'],
					'class'=>'yii\grid\SerialColumn',					
					'header'=>'#',
					'contentOptions'=>['class'=>'text-center'],
				],
	
				'Nama'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],					
					'format'=>'raw',
					'visible'=>'true',
					'header'=>'Nama', 
					'value'=>function($data){
						return $data['deskripsi_inst_wilayah'];
					}, 
					],
			'Pimpinan'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],					
					'format'=>'raw',
					'header'=>'Pimpinan', 
					'value'=>function($data){
						return $data['nama'];
					}, 
					],				
			'Alamat'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],					
					'format'=>'raw',
					'header'=>'Alamat', 
					'value'=>function($data){
						return $data['alamat'];
					}, 
					],		
		'No_telp'=>[
					'headerOptions'=>['style'=>'width:20%', 'class'=>'text-center'],					
					'format'=>'raw',
					'header'=>'No.Telp', 
					'value'=>function($data){
						return $data['no_tlp'];
					}, 
					],				
				'Aksi'=>[
					'headerOptions'=>['style'=>'width:1%', 'class'=>'text-center'],
					'contentOptions'=>['class'=>'text-center aksinya'],
					'format'=>'raw',
					'header'=>'<input type="checkbox" name="selection_all" id="selection_all" />', 
					'value'=>function($data, $index){
						return '<input type="checkbox" name="selection[]" id="selection'.($index+1).'" value="'.$data['kode_jenis_instansi'].'/'
						.$data['kode_instansi'].'/'.$data['kode_provinsi'].'/'.$data['kode_kabupaten'].'/'.$data['kode_tk']
						.'/'.$data['no_urut'].'" class="checkHapusIndex selection_one" />';
					}, 
					
					
				],
				
			], 
		]);
		Pjax::end();
		?>
		<small style=" color:#FF0000;font-size: 12px;font-weight: normal;"> &nbsp;*Doble Click atau pilih salah satu</small>
    </div>
			

		<div  style="text-align: center;" class="box-footer">
			<input type="hidden" name="hkode1" id="hkode1" value="<?php echo $kode1; ?>"/>	
			<input type="hidden" name="hkode2" id="hkode2" value="<?php echo $kode2; ?>"/>		
		</div>	

		<div class="modal-loading-new"></div>
		<div class="hide" id="filter-link"></div>
</div>
<style type="text/css">

	fieldset.scheduler-border {
    border: 1px groove #ddd !important;
    padding: 0 1.4em 1.4em 1.4em !important;
    margin: 0 0 1.5em 0 !important;
    -webkit-box-shadow:  0px 0px 0px 0px #000;
            box-shadow:  0px 0px 0px 0px #000;
}

legend.scheduler-border {
    width:inherit; /* Or auto */
    padding:0 10px; /* To give a bit of padding on the left and right */
    border-bottom:none;
}



</style>


<!-- =======================================================MODAL JENIS INSTANSI ========================================================-->

<?php
Modal::begin([
    'id' => 'm_wilayah',
    'header' => 'TAMBAH INSTANSI/BUMN/BUMD',
    'options' => [
        'data-url' => '',
    ],
]);
?> 


<?=
$this->render('_instansi_wilayah', [
    'model' => $model,
	'kode1'	=> $kode1,
	'kode2' => $kode2,
	'desc' => $desc,
		
])

?>

<?php
Modal::end();
?>

<!-- =======================================================MODAL JENIS INSTANSI/N ========================================================-->



<script type="text/javascript">
	$(document).ready(function(){
		
		document.getElementById("nama_instansi").innerHTML="<B><?php echo $desc; ?></b>";
		
		$('#myPjax').on('pjax:beforeSend', function(a, b, c){
			$("#filter-link").text(c.url);
		}).on('pjax:send', function(){
			$("body").addClass("loading");
		}).on('pjax:complete', function(){
			$("body").removeClass("loading");
			$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-blue'});
			$(".selection_one").trigger("ifChecked");
		});

		$("#idUbah").on("click", function(){
			var id 	= $(".selection_one:checked").val();
						
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/updatewilayah?id="+id;
			$(location).attr("href", url);
		});
		

	
		$("select#w3").change(function(){
		$kdprov = $("select#w3").val();
		$("select#w4").val("").trigger('change').select2('close');
		$("select#w4 option").remove();
	

	
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/instansi/getkabupaten'; ?>',
				data	: { q1 : $kdprov },
				cache	: false,
				dataType: 'json',
				success : function(data){ 
				
					if(data.items != ""){
						$("select#w4").select2({ 
							data 		: data.items, 
							placeholder : "Pilih salah satu", 
							allowClear 	: true, 
						});
						return false;
					}
				}
			});
		});		
		
		
		
		
		
		
		$("#idHapus").on("click", function(){
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
							url		: "<?php echo Yii::$app->request->baseUrl.'/datun/instansi/hapusdatawilayah'; ?>",
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

	

		 $("#idtambah_wilayah").click(function () {
            $("#m_wilayah").modal('show');

        });
	
			$("#idpilih_wilayah").on("click", function(){
				
			var id 	= $(".selection_one:checked").val();
						
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/updatewilayah?id="+id;
			$(location).attr("href", url);				
				
				

		});			
		
		
        $(".instansi-wilayah").on("dblclick", "td:not(.aksinya)", function(){
		
			var id = $(this).closest("tr").data("id");
			var id2 = $(this).closest("tr").data("id2");
			var id3 = $(this).closest("tr").data("id3");
			var id4 = $(this).closest("tr").data("id4");
			var id5 = $(this).closest("tr").data("id5");
			var id6 = $(this).closest("tr").data("id6");
			
			
			var url = window.location.protocol + "//" + window.location.host + "/datun/instansi/updatewilayah?id="+id+"/"+id2+"/"+id3+"/"+id4+"/"+id5+"/"+id6;

			$(location).attr("href", url);		
		
    	});

		$(".instansi-wilayah").on("ifChecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=selection_all]", function(){
			$(".selection_one").not(':disabled').iCheck("uncheck");
		});
		$(".instansi-wilayah").on("ifChecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		}).on("ifUnchecked", ".selection_one", function(){
			var n = $(".selection_one:checked").length;
			endisButton(n);
		});
		function endisButton(n){
			
			if(n == 1){
				$("#idUbah").removeClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else if(n > 1){
				$("#idUbah").addClass("disabled");
				$("#idHapus").removeClass("disabled");
			} else{
				$("#idUbah").addClass("disabled");
				$("#idHapus").addClass("disabled");
			}
		}
		

		$("select#w3").change(function(){
			$("#idcari").click();

		});		
		
		$("select#w4").change(function(){
			$("#idcari").click();

		});				
		
		
	});
</script>


