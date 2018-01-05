<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\pidsus\models\PdsPengembalianSpdp;
	
	$linkBatal		= '/pidsus/pds-pengembalian-spdp/index';
	$linkCetak		= '/pidsus/pds-pengembalian-spdp/cetak?no_spdp='.rawurlencode($model['no_spdp']).'&tgl_spdp='.rawurlencode($model['tgl_spdp']);
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$model["no_spdp"]."' and tgl_spdp = '".$model["tgl_spdp"]."'";

	$tgl_spdp 	= ($model['tgl_spdp'])?date("d-m-Y", strtotime($model['tgl_spdp'])):'';
	$tgl_terima = ($model['tgl_terima'])?date("d-m-Y", strtotime($model['tgl_terima'])):'';
	$tgl_ttd 	= ($model['tgl_dikeluarkan'])?date("d-m-Y", strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pengembalian-spdp/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-header with-border"><h3 class="box-title">SPDP</h3></div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nomor SPDP</label>
        			<div class="col-md-8">
						<?php if($model['no_spdp']){ ?>
                            <input type="text" name="no_spdp" id="no_spdp" maxlength="50" class="form-control" value="<?php echo $model['no_spdp']; ?>" readonly />
                        <?php } else{ ?>
            			<div class="input-group">
                            <input type="text" name="no_spdp" id="no_spdp" maxlength="50" class="form-control" value="<?php echo $model['no_spdp']; ?>" readonly />
                        	<div class="input-group-btn">
                            	<button type="button" class="btn btn-success btn-sm" id="btn_tambahspdp" title="Cari"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="help-block with-errors" id="error_custom_no_spdp"></div>
            		</div>
            	</div>
            </div>
            <div class="col-md-3">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal SPDP</label>
        			<div class="col-md-8">
                        <input type="text" name="tgl_spdp" id="tgl_spdp" class="form-control" value="<?php echo $tgl_spdp; ?>" readonly />
                        <div class="help-block with-errors" id="error_custom_tgl_spdp"></div>
            		</div>
            	</div>
            </div>
            <div class="col-md-3">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Terima</label>
        			<div class="col-md-8">
                        <input type="text" name="tgl_terima" id="tgl_terima" class="form-control" value="<?php echo $tgl_terima; ?>" readonly />
                        <div class="help-block with-errors" id="error_custom_tgl_terima"></div>
            		</div>
            	</div>
            </div>
        </div>
	</div>
</div>

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nomor</label>
        			<div class="col-md-8">
            			<input type="text" name="no_spdp_kembali" id="no_spdp_kembali" maxlength="50" class="form-control" value="<?php echo $model['no_spdp_kembali']; ?>" required data-error="Nomor pengembalian SPDP belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_spdp_kembali"></div>
            		</div>
            	</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Sifat</label>
                            <div class="col-md-8">
                                <select name="sifat" id="sifat" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                                    <option></option>
                                    <?php 
                                        $resOpt = PdsPengembalianSpdp::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
                                        foreach($resOpt as $dOpt){
                                            $selected = ($model['sifat'] == $dOpt['id'])?'selected':'';
                                            echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>             		
                            </div>
                        </div>
					</div>
				</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>
                            <div class="col-md-2">
                                <input type="text" maxlength="2" name="lampiran" id="lampiran" value="<?php echo $model['lampiran']; ?>" class="form-control number-only-strip" />
                            </div>
                        </div>
					</div>
				</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perihal</label>
                            <div class="col-md-8">
                                <textarea name="perihal" id="perihal" class="form-control" style="height:90px;" required data-error="Kolom [Perihal] belum diisi" ><?php echo $model['perihal']; ?></textarea>
                            	<div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Kepada Yth.</label>
                    <div class="col-md-8">
                        <textarea name="kepada" id="kepada" class="form-control" style="height:90px;" required data-error="Kolom [Kepada Yth] belum diisi" ><?php echo $model['kepada']; ?></textarea>						
                    	<div class="help-block with-errors"></div>
                    </div>
            	</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>
                            <div class="col-md-8">
                                <input type="text" name="di_kepada" id="di_kepada" class="form-control" value="<?php echo $model['di_kepada']; ?>" required data-error="Kolom [Di] belum diisi" />
                            	<div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
        </div>
	</div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Alasan</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="alasan" id="alasan" class="ckeditor"><?php echo $model['alasan']; ?></textarea>						
                    	<div class="help-block with-errors"></div>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-tembusan" title="Tambah Tembusan"><i class="fa fa-plus jarak-kanan"></i>Tembusan</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table_tembusan" class="table table-bordered">
                        <thead>
							<tr>
                                <th width="10%"></th>
                                <th width="15%">No Urut</th>
                                <th width="75%">Tembusan</th>
							</tr>
                        </thead>
                        <tbody>
                        <?php
                        	if($model['no_spdp_kembali'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pengembalian-SPDP' order by no_urut";
                        		$resx = PdsPengembalianSpdp::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, deskripsi_tembusan as tembusan from pidsus.pds_spdp_kembali_tembusan 
										where ".$whereDefault." and no_spdp_kembali = '".$model['no_spdp_kembali']."' order by no_urut";
                        		$resx = PdsPengembalianSpdp::findBySql($sqlx)->asArray()->all();
                        	}
                        	$no = 1;
							foreach($resx as $datx):
						?>
                        	<tr data-id="<?php echo $no;?>">
                        		<td class="text-center">
                                <input type="checkbox" name="chk_del_tembusan[]" id="<?php echo 'chk_del_tembusan'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                        		<td><input type="text" name="no_urut[]" class="form-control input-sm" value="<?php echo $datx['no_urut'];?>" /></td>
                        		<td><input type="text" name="nama_tembusan[]" class="form-control input-sm"  value="<?php echo $datx['tembusan'];?>" /></td>
                        	</tr>
                        <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
	</div>
	<div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Dikeluarkan di</label>        
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" id="lokel" name="lokel" readonly />	
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Ditandatangani</label>        
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control datepicker" id="tgldittd" name="tgldittd" value="<?php echo $tgl_ttd;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal Belum diisi" />
                                </div>						
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgldittd"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Penandatangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $model['penandatangan_nip']; ?>" />
                                <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $model['penandatangan_jabatan_pejabat'];?>" />														
                                <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $model['penandatangan_gol'];?>" />														
                                <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $model['penandatangan_pangkat'];?>" />														
                                <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $model['penandatangan_status_ttd']; ?>" />
                                <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $model['penandatangan_jabatan_ttd'];?>" />														
                                <div class="input-group">
                                	<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penandatangan--" readonly />
                                	<div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
                                </div>
								<div class="help-block with-errors" id="error_custom_penandatangan"></div>
                            </div>				
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-offset-4 col-md-8">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                            	<input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
                            </div>				
                        </div>
                    </div>
                </div>

            </div>
        </div>			
	</div>
</div>
		
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['spdp_kembali'].$model['file_upload_spdp_kembali'];
                        $labelFile 	= 'Unggah File Pengembalian SPDP';
                        if($model['file_upload_spdp_kembali'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Pengembalian SPDP';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_spdp_kembali']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_spdp_kembali'], strrpos($model['file_upload_spdp_kembali'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_spdp_kembali'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
    <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<div class="modal fade" id="penandatangan_modal" role="dialog" tabindex="-1" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penandatangan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="spdp_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Berkas Perkara</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

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
<script type="text/javascript">
$(document).ready(function(){

	/* START TEMBUSAN */
	$('#tambah-tembusan').click(function(){
		var tabel	= $('#table_tembusan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_tembusan').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_tembusan[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_tembusan').find("input[name='no_urut[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusTembusan").click(function(){
		var tabel 	= $("#table_tembusan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END TEMBUSAN */

	/* START AMBIL TTD */
	$("#btn_tambahttd, #penandatangan_nama, #ttdJabatan").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/pidsus/get-ttd/index");
		$("#penandatangan_modal").modal({backdrop:"static",keyboard:false});
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
	/* END AMBIL TTD */

	/* START AMBIL SPDP */
	$("#btn_tambahspdp").on('click', function(e){
		$("#spdp_modal").find(".modal-body").load("/pidsus/pds-pengembalian-spdp/getspdp");
		$("#spdp_modal").modal({backdrop:"static"});
	});
	
	$("#spdp_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("click", "#table-spdp-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToSpdp(param);
		$("#spdp_modal").modal("hide");
	}).on('click', "#idPilihSpdpModal", function(){
		var modal = $("#spdp_modal").find("#table-spdp-modal");
		var index = modal.find(".pilih-spdp-modal:checked").val();
		var param = index.toString().split('#');
		insertToSpdp(param);
		$("#spdp_modal").modal("hide");
	}).on('click','#idBatalSpdpKembaliModal', function(){
                var modal = $("#spdp_modal").find(".modal-spdp-index");
		var index = modal.find("#batal").val();
                var param = index.toString().split('#');
                insertToSpdp(param);
                $("#spdp_modal").modal("hide");
        });
	function insertToSpdp(param){
		$("#no_spdp").val(param[0]);
		$("#tgl_spdp").val(param[1]);
		$("#tgl_terima").val(param[2]);
		$("#perihal").val(param[3]);
	}
	/* END AMBIL SPDP */

});
</script>


