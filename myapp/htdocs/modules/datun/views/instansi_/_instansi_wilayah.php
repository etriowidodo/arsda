
<?php
	use yii\helpers\Html;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	
/* 	use app\modules\datun\models\MsWilayahSearch as MsWilayah;
	use app\modules\datun\models\MsWilayahkabSearch as MsWilayahkab;	
	 */
	use yii\widgets\ActiveForm;
	
	
 	if($model->isNewRecord){
		$this->title = 'MASTER';
		$this->subtitle = 'UBAH INSTANSI/BUMN/BUMD';
		$this->params['breadcrumbs'][] = $this->title;
	} else{
		$this->title = 'MASTER';
		$this->subtitle = ' INSTANSI/BUMN/BUMD';
		$this->params['breadcrumbs'][] = $this->title;
	} 	
	
	
/* 	 $this->subtitle = 'TAMBAH JENIS INSTANSI';
	 $this->title = 'MASTER';  */
	
?>	
	

<form id="instansi-wilayah" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/instansi/simpanwilayah">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

	<div class="instansi-input">
				<div style="border-color: #f39c12;padding: 20px;overflow: hidden;"  class="box box-primary">

							<!--	<h3 class="box-title"> <b>Tambah Instansi/BUMN/BUMD</b></h3> 
								<hr style="border-color: #c7c7c7;margin: 10px 0;"> -->
									
									 <div class="row">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Instansi/BUMN/BUMD</label>
												<div class="col-md-6">
													<select id="kode_instansi" name="kode_instansi" class="select2"  style="width:100%;" placeholder="Pilih Instansi">
													<option></option>
													<?php 
													$resOpt = MenuSearch::findBySql("select distinct kode_instansi,deskripsi_instansi from datun.instansi where kode_jenis_instansi='$kode1' and kode_instansi='$kode2' and deskripsi_instansi is not null order by deskripsi_instansi")->asArray()->all();
														
														foreach($resOpt as $dOpt){
														$selected1=($kode2==$dOpt['kode_instansi'])?'selected':'';
														echo '<option value="'.$dOpt['kode_instansi'].'" '.$selected1.'>'.$dOpt['deskripsi_instansi'].'</option>';														
															}
																	
													?>
													</select>
													
													
												</div>                    
											</div>  
																						
										</div>
									</div>									
								
									 <div class="row insertprov">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Wilayah (Provinsi)</label>
												<div class="col-md-6">
													<select id="id_prop" name="id_prop" class="select2"  style="width:100%;" placeholder="Pilih Provinsi" >
													<option></option>
													<?php 
													$resOpt = MenuSearch::findBySql("select distinct id_prop,deskripsi from datun.m_propinsi where deskripsi is not null order by deskripsi")->asArray()->all();
														
														foreach($resOpt as $dOpt){
														$selected2=($kode3==$dOpt['id_prop'])?'selected':'';
														echo '<option value="'.$dOpt['id_prop'].'" '.$selected2.'>'.$dOpt['deskripsi'].'</option>';														
															}
																	
													?> 
													</select>
													
													
												</div>                    
											</div>        				
										</div>
									</div>
								
									<div class="row updateprov hide">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Wilayah (Provinsi)</label>
												<div class="col-md-6">
													<select id="uid_prop" name="uid_prop" class="select2" style="width:100%;" placeholder="Pilih Wilayah (Kabupaten)">
													<option></option>
													<?php 
													
													$resOpt = MenuSearch::findBySql("select distinct id_prop,deskripsi from datun.m_propinsi where id_prop='$kode3' and deskripsi is not null order by id_prop")->asArray()->all();
														foreach($resOpt as $dOpt){ 
														$selected=($kode3==$dOpt['id_prop'])?'selected':'';
														
														echo '<option value="'.$dOpt['id_prop'].'" '.$selected.'>'.$dOpt['deskripsi'].'</option>';
															}
																												
													?>
													</select>
												</div>  
												
											</div>        				
										</div>
									</div>									
									 <div class="row insertkab hide">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Wilayah (Kabupaten)</label>
												<div class="col-md-6">
												
												<select id="id_kabupaten_kota" name="id_kabupaten_kota"  class="select2" style="width:100%;"  >
												</select>
												</div>                    
											</div>        				
										</div>
									</div>				

									 <div class="row updatekab hide">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Wilayah (Kabupaten)</label>
												<div class="col-md-6">
													<select id="uid_kabupaten_kota" name="uid_kabupaten_kota" class="select2" style="width:100%;" placeholder="Pilih Wilayah (Kabupaten)">
													<option></option>
													<?php 
													
													$resOpt = MenuSearch::findBySql("select distinct id_kabupaten_kota,deskripsi_kabupaten_kota from datun.m_kabupaten where id_prop='$kode3' and id_kabupaten_kota='$kode4' and deskripsi_kabupaten_kota is not null order by id_kabupaten_kota")->asArray()->all();
														foreach($resOpt as $dOpt){ 
														$selected=($kode4==$dOpt['id_kabupaten_kota'])?'selected':'';
														
														echo '<option value="'.$dOpt['id_kabupaten_kota'].'" '.$selected.'>'.$dOpt['deskripsi_kabupaten_kota'].'</option>';
															}
																												
													?>
													</select>
												</div>  
												
											</div>        				
										</div>
									</div>	

									<div class="row inserturt hide" >
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;" >No Urut</label>
												<div class="col-md-3">
													<input type="text" style="width:60px" name="no_urut"  id="no_urut" maxlength="4" value="<?php echo $kode6; ?>" class="form-control" />
																																		
														<div class="help-block with-errors"></div>
												</div>                    
											</div>        				
										</div>
									</div>										

									
									 <div class="row">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Nama Instansi/BUMN/BUMD</label>
												<div class="col-md-6">
													<input type="text" name="deskripsi_inst_wilayah"  id="deskripsi_inst_wilayah" value="<?php echo $c4; ?>" class="form-control"/>
														<div class="help-block with-errors"></div>
												</div>                    
											</div>        				
										</div>
									</div>						
						
									 <div class="row">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Pimpinan</label>
												<div class="col-md-6">
													<input type="text" name="nama" id="nama" class="form-control"  value="<?php echo $c1; ?>"/>
														<div class="help-block with-errors"></div>
												</div>                    
											</div>        				
										</div>
									</div>						

									 <div class="row">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">No.Telp</label>
												<div class="col-md-3">
													<input type="text" name="no_tlp" id="no_tlp" class="form-control"  value="<?php echo $c3; ?>"/>
														<div class="help-block with-errors"></div>
												</div>                    
											</div>        				
										</div>
									</div>						
									
									 <div class="row">
										<div class="col-md-12">														
											<div class="form-group" style="margin: 2px;">
												<label class="control-label col-md-4" style="margin-top: 5px;">Alamat</label>
												<div class="col-md-6">
													<textarea style="height:90px;"  name="alamat" id="alamat"  class="form-control"><?php echo htmlspecialchars($c2); ?></textarea>
														<div class="help-block with-errors"></div>
														<input type="hidden" name="status_wil" id="status_wil"/>
														<input type="hidden" name="kode_jenis_instansi" id="kode_jenis_instansi"  value="<?php echo $kode1; ?>"/>
														</div>  
												
											</div>        				
										</div>
									</div>															
									
				<div id="preview-menu"></div>

				</div>

		</div>
			

<div class="box-footer text-center"> 
	<a href="<?php echo Yii::$app->request->baseUrl.'/datun/instansi/pilih_instansi?id='.$kode1.'/'.$kode2;?>" class="btn btn-danger"  style="background-color:	#008B8B; border-style:inset ;border-color:#008B8B"  title="Kembali ke Instansi" type="button" data-dismiss="modal"><i class="fa fa-reply jarak-kanan" aria-hidden="true"></i> Kembali</a>
    <button class="btn btn-warning" type="submit" style="display: inline-block;"><i class="fa fa-floppy-o" aria-hidden="true"></i> <?php echo ($model->isNewRecord)?'Simpan':'Simpan';?></button>

</div>
		
</form>

<div class="modal-loading-new"></div>

<script type="text/javascript">


$(document).ready(function(){
	
	/* 		$("select#id_prop").trigger('change'); */
			$('#instansi-wilayah').validator('update') 

		document.getElementById('no_urut').readOnly =true;
	   // document.getElementById("nama_jenis_instansi").innerHTML="<?php echo $nmjns; ?>";

	var cstatus = document.getElementById('deskripsi_inst_wilayah').value;

		if(cstatus==''){
			$(".updatekab").addClass("hide");
			$(".insertkab").removeClass("hide");
			$(".inserturt").addClass("hide");
			
			$(".updateprov").addClass("hide");
			$(".insertprov").removeClass("hide");
	 		$("#status_wil").attr("value",'0'); 

		}else{
			$(".updateprov").removeClass("hide");	
			$(".insertprov").addClass("hide");
			$(".updatekab").removeClass("hide");	
			$(".insertkab").addClass("hide");	
		//	$(".inserturt").removeClass("hide");			
			$(".inserturt").addClass("hide");		
			$("#status_wil").attr("value",'1');
		
			document.getElementById('uid_prop').readOnly  = true; 
			document.getElementById('uid_kabupaten_kota').readOnly  = true;
			document.getElementById('ukode_tk').readOnly  = true;	
			
		}
		
		
		$("select#id_prop").change(function(){
	
		$kdprov = $("select#id_prop").val();
		$("select#id_kabupaten_kota").val("").trigger('change').select2('close');
		$("select#id_kabupaten_kota option").remove();
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/instansi/getkabupaten'; ?>',
				data	: { q1 : $kdprov },
				cache	: false,
				dataType: 'json',
				success : function(data){ 
				
					if(data.items != ""){						
							$("select#id_kabupaten_kota").select2({						
							data 		: data.items, 
							placeholder : "Pilih salah satu", 
							allowClear 	: true, 
						});
						return false;
					}
				}
			});
		});		
			
		
});

$(".select2").select2({		
		allowClear: true
	});

</script>	