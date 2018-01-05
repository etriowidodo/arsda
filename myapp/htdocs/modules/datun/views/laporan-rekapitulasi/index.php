<?php
	use yii\helpers\Html;
		$this->title 	= 'LAPORAN REKAPITULASI';
		$this->params['breadcrumbs'][] = $this->title;

?>

<div class="rekap-create">
	<form id="rekap-form" name="rekap-form" class="form-validasi form-horizontal" method="post" action="/datun/laporan-rekapitulasi/cetak" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
		<div class="box box-primary" style="border-color: #eaba05;overflow: hidden;padding-bottom:15px;">
		<div class="col-md-12" style=" padding: 0px;margin-top:4px; padding-left: 0px;">
		<div class="col-md-6" style="padding-right: 0px; margin-top: 10px;" readonly="true">
			<div class="form-group form-group-sm">
				<label class="control-label col-md-4">Tahun</label>        
				<div class="col-md-4">
				<select id="thn" name="thn" class="select2" style="width:100%;" required data-error="Tahun belum dipilih">
                        <option></option>
							<?php
			
								$now=date('Y');
								for ($a=$now;$a>=$now-20;$a--)
								{
									 echo "<option class='form-control pull-right' name='a' value='$a'>$a</option>";
								}
							
							?>
				</select>

				</div>
				<div class="col-md-offset-4 col-md-8">
					<div class="help-block with-errors" id="err_tgls14"></div>
				</div>
			</div>
		</div>
		</div>
		
		<div class="col-md-12" style=" padding: 0px;margin-top:4px; margin-top:-10px; padding-left: 0px;">
		<div class="col-md-6" style="padding-right: 0px;" readonly="true">
			<div class="form-group form-group-sm">
				<label class="control-label col-md-4">Bulan</label>        
				<div class="col-md-4">
                <select id="bln" name="bln" class="select2" style="width:100%;" required data-error="Bulan belum dipilih">
                        <option></option>
					<?php
					$bulan=array("Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
					$jlh_bln=count($bulan);
					for($c=0; $c<$jlh_bln; $c+=1){
						echo"<option class='form-control pull-right' value=$c> $bulan[$c] </option>";
					}
					?>
				</select>
				</div>
				<div class="col-md-offset-4 col-md-8">
					<div class="help-block with-errors" id="err_tgls14"></div>
				</div>
			</div>
		</div>
		</div>
		
			<div class="col-md-12" style=" padding: 0px;margin-top:-10px; padding-left: 0px; ">	
				  <div class="col-md-6">
						<fieldset class="scheduler-border">
							<legend class="scheduler-border">Penandatangan :</legend>
							<div class="row">        
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<div class="col-md-12">
											<input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $seq['penandatangan_nip']; ?>" />
											<input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $seq['penandatangan_status']; ?>" />
											<input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $seq['penandatangan_jabatan'];?>" />														
											<input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $seq['penandatangan_gol'];?>" />														
											<input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $seq['penandatangan_pangkat'];?>" />														
											<input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $seq['penandatangan_ttdjabat'];?>" />														
											<div class="input-group">
												<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $seq['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
												<div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
											</div>
											<div class="help-block with-errors" id="error_custom3"></div>
										</div>				
									</div>
								</div>
							</div>
							<div class="row">        
								<div class="col-md-12">
									<div class="form-group form-group-sm">
										<div class="col-md-12">
											<input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
										</div>				
									</div>
								</div>
							</div>
						</fieldset>
					</div>
			</div>	
		
		
		
		</div>
		<div class="box-footer text-center"> 
			<button class="btn btn-warning jarak-kanan" type="submit" id="cetak" >Cetak</button>
		</div>
	</form>
</div>
<div class="modal fade" id="penandatangan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">PENANDATANGAN</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal-loading-new"></div>


<script type="text/javascript">

$(document).ready(function(){

	$("#btn_tambahttd, #penandatangan_nama").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");		
		$("#penandatangan_modal").find(".modal-body").load("/datun/laporan-rekapitulasi/get_ttd");
		$("#penandatangan_modal").modal({backdrop:"static"});
	});
	
	$("#penandatangan_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#table-ttd-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	}).on('click', "#idPilihTtdModal", function(){
		var modal = $("#penandatangan_modal").find("#table-ttd-modal");
		var index = modal.find(".pilih-ttd-modal:checked").val();
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	});
	function insertToTtd(param){
		$("#penandatangan_status").val(param[0]);
		$("#penandatangan_nip").val(param[1]);
		$("#penandatangan_nama").val(param[2]);
		$("#penandatangan_jabatan").val(param[3]);
		$("#penandatangan_gol").val(param[4]);
		$("#penandatangan_pangkat").val(param[5]);
		$("#penandatangan_ttdjabat").val(param[6]);
		$("#ttdJabatan").val(param[0]+' '+param[6]);
	
	}	

});

</script>


<style>
	h3.box-title{
		font-weight: bold;
	}
	.form-horizontal .form-group-sm .control-label{
		font-size: 12px;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
		font-size: 12px;
	}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: arial;
		font-size: 11px;
	}
	fieldset.scheduler-border{
		border: 1px solid #ddd;
		margin:0;
		padding:10px;
	}
	legend.scheduler-border{
		border-bottom: none;
		width: inherit;
		margin:0;
		padding:0px 5px;
		font-size: 14px;
		font-weight: bold;
	}
</style>
