<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsP14Umum;

	$this->title 	= 'P-14 Umum';
	$this->subtitle = 'Surat Perintah Penghentian Penyidikan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-p14-umum/index';
	$linkCetak		= '/pidsus/pds-p14-umum/cetak?id1='.rawurlencode($model['no_ba2_umum']);
	if($isNewRecord){
		$sqlCek = "select no_p8_umum, tgl_p8_umum from pidsus.pds_p8_umum where ".$whereDefault;
		$model 	= PdsP14Umum::findBySql($sqlCek)->asArray()->one();
	}
	$tgl_p8_umum 	= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_surat_persetujuan 	= ($model['tgl_surat_persetujuan'])?date('d-m-Y',strtotime($model['tgl_surat_persetujuan'])):'';
        $tgl_dikeluarkan 	= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
        $tgl_pidsus7_umum 	= ($model['tgl_pidsus7'])?date('d-m-Y',strtotime($model['tgl_pidsus7'])):'';
        $ttdJabatan 		= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tempat_dikeluarkan     = ($model['dikeluarkan'])?$model['dikeluarkan']:Yii::$app->inspektur->getLokasiSatker()->lokasi;
        $alasan 		= explode(",", $model['alasan']);
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-p14-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pidsus-7 Umum</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tgl_pidsus7_umum" id="tgl_pidsus7_umum" class="form-control" value="<?php echo $tgl_pidsus7_umum;?>" readonly />
                                    <input type="hidden" name="no_pidsus7_umum" id="no_pidsus7_umum" value="<?php echo $model['no_pidsus7_umum'];?>" />
                                    <div class="input-group-btn"><a class="btn btn-pidsus btn-sm" id="btn-cari-pidsus7-umum"><i class="fa fa-search"></i></a></div>
                                </div>
                                <div class="help-block with-errors" id="error_custom_no_pidsus7_umum"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor P-14 Umum</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_p14_umum" id="no_p14_umum" class="form-control" value="<?php echo $model['no_p14_umum'];?>" required data-error="Nomor P-14 Umum belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_p14_umum"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Surat Persetujuan</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_surat_persetujuan" id="no_surat_persetujuan" class="form-control" value="<?php echo $model['no_surat_persetujuan'];?>" maxlength="50" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Surat Persetujuan</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_surat_persetujuan" id="tgl_surat_persetujuan" class="form-control datepicker" value="<?php echo $tgl_surat_persetujuan;?>" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Alasan</label>        
                            <div class="col-md-9">
                                <div class="alsn">
                                    <label class="checkbox" style="padding:0 0 5px;">
                                        <input type="checkbox" name="alasan[]" id="alasan1" value="1" <?php echo (in_array("1", $alasan))?'checked':'';?>/><span>Tidak terdapat cukup bukti</span>
                                    </label>
                                    <label class="checkbox" style="padding:0 0 5px;">
                                        <input type="checkbox" name="alasan[]" id="alasan2" value="2" <?php echo (in_array("2", $alasan))?'checked':'';?>/><span>Peristiwa yang dilakukan bukan merupakan tindak pidana</span>
                                    </label>
                                    <label class="checkbox" style="padding:0 0 5px;">
                                        <input type="checkbox" name="alasan[]" id="alasan3" value="3" <?php echo (in_array("3", $alasan))?'checked':'';?>/><span>Penyidikan harus ditutup demi hukum</span>
                                    </label>
                                </div>
                                <div class="help-block with-errors" id="error_custom_alasan"></div>
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa Penyidik</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama</label>        
                            <div class="col-md-8">
                                <select name="nama_jaksa_penyidik" id="nama_jaksa_penyidik" class="select2" style="width:100%" required data-error="Nama Jaksa belum dipilih">
                                    <option></option>
                                    <?php
                                        $sqlOpt1 = "select jabatan_jaksa, nip_jaksa as idnya, nama_jaksa as namanya, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatnya 
                                                from pidsus.pds_p8_umum_jaksa where ".$whereDefault;
                                        $resOpt1 = PdsP14Umum::findBySql($sqlOpt1)->asArray()->all();
                                        foreach($resOpt1 as $datOpt1){
                                            $selected = ($datOpt1['idnya'] == $model['nip_jaksa'])?'selected':'';
                                            echo '<option value="'.$datOpt1['idnya'].'" data-pangkat="'.$datOpt1['pangkatnya'].'" data-jabatan="'.$datOpt1['jabatan_jaksa'].'" '.$selected.'>'.$datOpt1['namanya'].'</option>';
                                        }
									?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pangkat</label>        
                            <div class="col-md-8">
                                <input type="text" name="pangkat_jaksa" id="pangkat_jaksa" class="form-control" value="<?php echo $model['pangkat_jaksa'];?>" readonly  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">NIP</label>        
                            <div class="col-md-8">
                                <input type="hidden" name="nama_jaksa" id="nama_jaksa" value="<?php echo $model['nama_jaksa'];?>"  /> 
                                <input type="hidden" name="jabatan_jaksa" id="jabatan_jaksa" value="<?php echo $model['jabatan_jaksa'];?>"  /> 
                                <input type="text" name="nip_jaksa" id="nip_jaksa" class="form-control" value="<?php echo $model['nip_jaksa'];?>" readonly  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
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
                        	if($model['no_p14_umum'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-14-Umum' order by no_urut";
                        		$resx = PdsP14Umum::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select a.no_urut, a.tembusan from pidsus.pds_p14_umum_tembusan a 
                                                 where ".$whereDefault." and a.no_p14_umum = '".$model['no_p14_umum']."' order by a.no_urut";
                        		$resx = PdsP14Umum::findBySql($sqlx)->asArray()->all();
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
                                <input type="text" name="tempat_dikeluarkan" id="tempat_dikeluarkan" class="form-control" value="<?php echo $tempat_dikeluarkan;?>" required data-error="Kolom [Dikeluarkan di] belum diisi" />
                                <div class="help-block with-errors"></div>
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
                                    <input type="text" class="form-control datepicker" id="tgl_dikeluarkan" name="tgl_dikeluarkan" value="<?php echo $tgl_dikeluarkan;?>" required data-error="Tanggal Dikeluarkan Belum diisi" />
                                </div>						
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_dikeluarkan"></div></div>
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
                        $pathFile 	= Yii::$app->params['p14_umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah P-14 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah P-14 Umum';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload'], strrpos($model['file_upload'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 2Mb]</h6>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="no_p8_umum" id="no_p8_umum" value="<?php echo $model['no_p8_umum'];?>" />
    <input type="hidden" name="tgl_p8_umum" id="tgl_p8_umum" value="<?php echo $tgl_p8_umum;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="get_pidsus7_umum_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pidsus-7 Umum</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
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
        .alsn span{
		margin-left: 7px;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("#nama_jaksa_penyidik").on("change", function(){
		var nilai 	= $(this).val();
		var pangkat = $("#nama_jaksa_penyidik option:selected").data("pangkat");
		var jabatan = $("#nama_jaksa_penyidik option:selected").data("jabatan");
		var nama 	= $(this).select2('data');
		if(nilai != ""){
			$("#nip_jaksa").val(nilai);
			$("#nama_jaksa").val(nama[0].text);
			$("#pangkat_jaksa").val(pangkat);
			$("#jabatan_jaksa").val(jabatan);
		} else{
			$("#nip_jaksa, #nama_jaksa, #pangkat_jaksa, #jabatan_jaksa").val("");
		}
	});


	/* START GET Pidsus-7 UMUM */
	$("#btn-cari-pidsus7-umum").on('click', function(e){
		$("#get_pidsus7_umum_modal").find(".modal-body").html("");
		$("#get_pidsus7_umum_modal").find(".modal-body").load("/pidsus/pds-p14-umum/getpidsus7umum");
		$("#get_pidsus7_umum_modal").modal({backdrop:"static"});
	});
	$("#get_pidsus7_umum_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-pds7u-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
                $("#no_pidsus7_umum").val(param[0]);
                $("#tgl_pidsus7_umum").val(param[1]);
		$("#get_pidsus7_umum_modal").modal("hide");
	}).on('click', "#idPilihpds7UModal", function(){
		var modal = $("#get_pidsus7_umum_modal").find("#tabel-pds7u-modal");
		var index = modal.find(".pilih_pds7u_modal:checked").val();
		var param = index.toString().split('|#|');
		$("#no_pidsus7_umum").val(param[0]);
                $("#tgl_pidsus7_umum").val(param[1]);
		$("#get_pidsus7_umum_modal").modal("hide");
	}).on('click','#idBatalba1UModal', function(){
		$("#get_pidsus7_umum_modal").modal("hide");
	});
	/* END GET PIDSUS-14 UMUM */

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
	$("#btn_tambahttd").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/pidsus/get-ttd/index");
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
	/* END AMBIL TTD */
        
});
	
</script>