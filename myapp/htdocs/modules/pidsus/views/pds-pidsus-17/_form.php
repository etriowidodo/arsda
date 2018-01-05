<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus17;

	$this->title = 'Pidsus-17';
	$this->subtitle = 'Pemberitahuan Tidak Dapat Dilakukan Penyitaan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/pds-p21/index';
	$linkCetak		= '/pidsus/pds-p21/cetak';
	$tgl_ttd 		= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$tgl_berkas 		= ($model['tgl_berkas'])?date('d-m-Y',strtotime($model['tgl_berkas'])):'';
	$tgl_terima 		= ($model['tgl_terima'])?date('d-m-Y',strtotime($model['tgl_terima'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/p16/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor</label>
                    <div class="col-md-8">
                        <input type="text" name="no_surat" id="no_surat" maxlength="50" class="form-control" value="<?php echo $model['no_surat']; ?>" required data-error="Nomor Surat belum diisi" <?php echo (!$isNewRecord)?'readonly':'';?> />
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
                                        $resOpt = PdsPidsus17::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
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

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Penetapan Ijin Penyitaan Ketua PN</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Penetapan</label>        
                            <div class="col-md-8">
                                <input type="text" name="nomor_penetapan" id="nomor_penetapan" class="form-control" value="<?php echo $model['nomor_penetapan'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Penetapan</label>        
                            <div class="col-md-8">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control datepicker" id="tgl_penetapan" name="tgl_penetapan" value="<?php echo $tgl_ttd;?>" placeholder="DD-MM-YYYY" />
                                </div>
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
                <h3 class="box-title">Barang yang Tidak Dilakukan Penyitaan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusSita jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-sita" title="Tambah Sita"><i class="fa fa-plus jarak-kanan"></i>Barang Sitaan</a><br>
                    </div>	
                </div><hr/>
                <div class="table-responsive">
                    <table id="table_sita" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="15%">No</th>
                                <th width="75%">Nama Barang</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        	if($model['no_berkas'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-21' order by no_urut";
                        		$resx = PdsPidsus17::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_p21_tembusan 
										where ".$whereDefault." and no_berkas = '".$model['no_berkas']."' order by no_urut";
                        		$resx = PdsPidsus17::findBySql($sqlx)->asArray()->all();
                        	}
                        	$no = 1;
							foreach($resx as $datx):
						?>
                        	<tr data-id="<?php echo $no;?>">
                        		<td class="text-center">
                                <input type="checkbox" name="chk_del_sita[]" id="<?php echo 'chk_del_sita'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                        		<td><input type="text" name="no_urut_sita[]" class="form-control input-sm" value="<?php echo $datx['no_urut'];?>" /></td>
                        		<td><input type="text" name="nama_sita[]" class="form-control input-sm"  value="<?php echo $datx['tembusan'];?>" /></td>
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
            <div class="box-header with-border">
                <h3 class="box-title">Alasan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusAlasan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-alasan" title="Tambah Alasan"><i class="fa fa-plus jarak-kanan"></i>Alasan</a><br>
                    </div>	
                </div><hr/>
                <div class="table-responsive">
                    <table id="table_alasan" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="15%">No</th>
                                <th width="75%">Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        	if($model['no_berkas'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-21' order by no_urut";
                        		$resx = PdsPidsus17::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_p21_tembusan 
										where ".$whereDefault." and no_berkas = '".$model['no_berkas']."' order by no_urut";
                        		$resx = PdsPidsus17::findBySql($sqlx)->asArray()->all();
                        	}
                        	$no = 1;
							foreach($resx as $datx):
						?>
                        	<tr data-id="<?php echo $no;?>">
                        		<td class="text-center">
                                <input type="checkbox" name="chk_del_alasan[]" id="<?php echo 'chk_del_alasan'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                        		<td><input type="text" name="no_urut_alasan[]" class="form-control input-sm" value="<?php echo $datx['no_urut'];?>" /></td>
                        		<td><input type="text" name="nama_alasan[]" class="form-control input-sm"  value="<?php echo $datx['tembusan'];?>" /></td>
                        	</tr>
                        <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
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
                        	if($model['no_berkas'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-21' order by no_urut";
                        		$resx = PdsPidsus17::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_p21_tembusan 
										where ".$whereDefault." and no_berkas = '".$model['no_berkas']."' order by no_urut";
                        		$resx = PdsPidsus17::findBySql($sqlx)->asArray()->all();
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
                            <label class="control-label col-md-4">Penanda Tangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $model['penandatangan_nip']; ?>" />
                                <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $model['penandatangan_jabatan_pejabat'];?>" />														
                                <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $model['penandatangan_gol'];?>" />														
                                <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $model['penandatangan_pangkat'];?>" />														
                                <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $model['penandatangan_status_ttd']; ?>" />
                                <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $model['penandatangan_jabatan_ttd'];?>" />														
                                <div class="input-group">
                                	<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
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
                        $pathFile 	= Yii::$app->params['p21'].$model['file_upload_p21'];
                        $labelFile 	= 'Unggah File Pidsus-17';
                        if($model['file_upload_spdp_kembali'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah Pidsus 17';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_spdp_kembali']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_p21'], strrpos($model['file_upload_p21'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p21'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php// if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php// } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<div class="modal fade" id="penandatangan_modal" role="dialog" tabindex="-1" aria-hidden="true">
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

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa</h4>
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
        
        /* START SITA */
	$('#tambah-sita').click(function(){
		var tabel	= $('#table_sita > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_sita').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_sita[]" class="hRow" id="chk_del_sita'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut_sita[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_sita[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_sita"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_sita').find("input[name='no_urut_sita[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusSita").click(function(){
		var tabel 	= $("#table_sita");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut_sita[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END SITA */
        
        /* START ALASAN */
	$('#tambah-alasan').click(function(){
		var tabel	= $('#table_alasan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_alasan').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_alasan[]" class="hRow" id="chk_del_alasan'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut_alasan[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_alasan[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_alasan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_alasan').find("input[name='no_urut_alasan[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusAlasan").click(function(){
		var tabel 	= $("#table_alasan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut_alasan[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END ALASAN */

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