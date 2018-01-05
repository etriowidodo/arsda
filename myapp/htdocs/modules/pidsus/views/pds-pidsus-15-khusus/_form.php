<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus15Khusus;

	$this->title 	= 'Pidsus-15 Khusus';
	$this->subtitle = 'Surat Permintaan Persetujuan Tertulis Tindakan Penyidikan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
                            and a.no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and a.no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-15-khusus/index';
	$linkCetak		= '/pidsus/pds-pidsus-15-khusus/cetak?id1='.$model['no_pidsus15_khusus'];
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	if($isNewRecord){
		$sqlCek = "select a.no_p8_khusus, a.tgl_p8_khusus from pidsus.pds_p8_khusus a where ".$whereDefault;
		$model 	= PdsPidsus15Khusus::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_khusus = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_pidsus15_khusus 	= ($model['tgl_pidsus15_khusus'])?date('d-m-Y',strtotime($model['tgl_pidsus15_khusus'])):'';
	$model['perihal'] 	= ($model['perihal'])?$model['perihal']:'';
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-15-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Keperluan</label>        
            <div class="col-md-8">
                <select name="keperluan" id="keperluan" class="form-control select2">
                    <option <?php echo ($model['keperluan'] == 'Pemeriksaan Saksi')?'selected':'';?>>Pemeriksaan Saksi</option>
                    <option <?php echo ($model['keperluan'] == 'Pemeriksaan Tersangka')?'selected':'';?>>Pemeriksaan Tersangka</option>
                    <option <?php echo ($model['keperluan'] == 'Penahanan Tersangka')?'selected':'';?>>Penahanan Tersangka</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Atas Nama</label>        
            <div class="col-md-8">
                <div class="input-group input-group-sm">
                    <input type="text" name="nama_saksi" id="nama_saksi" class="form-control" value="<?php echo $model['nama_saksi'];?>" readonly />
                    <span class="input-group-btn"><button class="btn" type="button" id="pilih_saksi"><i class="fa fa-search"></i></button></span>
                </div>
				<div class="help-block with-errors" id="error_custom_nama_saksi"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Jabatan</label>        
            <div class="col-md-8">
				<input type="text" name="jabatan_saksi" id="jabatan_saksi" class="form-control" value="<?php echo $model['jabatan_saksi'];?>" readonly />
				<div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Pidsus-15 Khusus</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_pidsus15_khusus" id="no_pidsus15_khusus" class="form-control" value="<?php echo $model['no_pidsus15_khusus'];?>" required data-error="Nomor Pidsus-15 Khusus belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_pidsus15_khusus"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Pidsus-15 Khusus</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_pidsus15_khusus" id="tgl_pidsus15_khusus" class="form-control datepicker" value="<?php echo $tgl_pidsus15_khusus;?>" required data-error="Tanggal Pidsus-15 Khusus belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_pidsus15_khusus"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Sifat</label>
                            <div class="col-md-8">
                                <select name="sifat" id="sifat" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                                    <option></option>
                                    <?php 
                                        $resOpt = PdsPidsus15Khusus::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
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
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perihal</label>
                            <div class="col-md-8">
                                <textarea name="perihal" id="perihal" class="form-control" style="height:70px;" required data-error="Kolom [Perihal] belum diisi" ><?php echo $model['perihal']; ?></textarea>
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
                        <textarea name="kepada" id="kepada" class="form-control" style="height:70px;" required data-error="Kolom [Kepada Yth] belum diisi" ><?php echo $model['kepada']; ?></textarea>						
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
    <div class="box-header with-border" style="border-color: #c7c7c7;">
        <h3 class="box-title">Posisi Kasus</h3>		
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="posisi_kasus" id="posisi_kasus" style="height: 100px" class="form-control"><?php echo $model['posisi_kasus']; ?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>			

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Berdasarkan Undang-undang</label>        
                    <div class="col-md-9">
                        <input type="text" name="berdasarkan_uu" id="berdasarkan_uu" class="form-control" value="<?php echo $model['berdasarkan_uu'];?>" required data-error="Kolom [Berdasarkan Undang-undang] belum diisi" maxlength="255" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Perizinan dari</label>        
                    <div class="col-md-9">
                        <input type="text" name="ijin" id="ijin" class="form-control" value="<?php echo $model['ijin'];?>" maxlength="100" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Alasan Pemeriksaan/Penahanan</label>        
                    <div class="col-md-9">
                        <textarea name="alasan" id="alasan" style="height:100px;" class="form-control"><?php echo $model['alasan']; ?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
        <h3 class="box-title">Uraian Singkat Penanganan Perkara</h3>		
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="uraian_penanganan_perkara" id="uraian_penanganan_perkara" style="height:100px" class="form-control"><?php echo $model['uraian_penanganan_perkara']; ?></textarea>
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
                        	if($model['no_pidsus15_khusus'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pidsus-15-Khusus' order by no_urut";
                        		$resx = PdsPidsus15Khusus::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_pidsus15_khusus_tembusan a 
										where ".$whereDefault." and a.no_pidsus15_khusus = '".$model['no_pidsus15_khusus']."' order by a.no_urut";
                        		$resx = PdsPidsus15Khusus::findBySql($sqlx)->asArray()->all();
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
                        $pathFile 	= Yii::$app->params['pidsus_15khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-15 Khusus';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah Pidsus-15 Khusus';
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
	<input type="hidden" name="no_p8_khusus" id="no_p8_khusus" value="<?php echo $model['no_p8_khusus'];?>" />
    <input type="hidden" name="tgl_p8_khusus" id="tgl_p8_khusus" value="<?php echo $tgl_p8_khusus;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="saksi_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="pidsus14_khusus_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Pidsus-14 Khusus</h4>
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

<!--UNDANG-UNDANG-->
<div class="modal fade" id="pilih_undang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM1UU" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Undang Undang</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--PASAL-->
<div class="modal fade" id="form_pasal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM1Psl" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pasal</h4>
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
	$("#keperluan").on("change", function(){
		$("#nama_saksi, #jabatan_saksi, #perihal").val("");
	});

	/* START AMBIL SAKSI {keperluan:keperluan}, */
	$("#pilih_saksi").on('click', function(e){
		var keperluan = $("#keperluan").val();
		if(keperluan){			
			$("#saksi_modal").find(".modal-body").html("");
			$("#saksi_modal").find(".modal-body").load("/pidsus/pds-pidsus-15-khusus/getsaksi?keperluan="+encodeURIComponent(keperluan), function(){
				if(keperluan == 'Pemeriksaan Saksi') $("#saksi_modal").find(".modal-title").html("Daftar Saksi");
				else $("#saksi_modal").find(".modal-title").html("Daftar Tersangka");
			});
			$("#saksi_modal").modal({backdrop:"static", keyboard:false});
		} else{
			bootbox.alert({message: "Silahkan pilih keperluan terlebih dahulu", size: 'small'});
		}
	});
	$("#saksi_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-pidsus14-khusus-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		insertSaksi(param);
		$("#saksi_modal").modal("hide");
	}).on('click', "#idPilihPIDSUS14UModal", function(){
		var modal = $("#saksi_modal").find("#tabel-pidsus14-khusus-modal");
		var index = modal.find(".pilih-pidsus14-khusus-modal:checked").val();
		var param = index.toString().split('|#|');
		insertSaksi(param);
		$("#saksi_modal").modal("hide");
	}).on('click','#idBatalPIDSUS14UModal', function(){
		$("#saksi_modal").modal("hide");
	});
	function insertSaksi(param){
		var keperluan = $("#keperluan").val();
		$("#nama_saksi").val(decodeURIComponent(param[0]));
		$("#jabatan_saksi").val(decodeURIComponent(param[1]));
		if(keperluan == "Pemeriksaan Saksi")
			$("#perihal").val('Permintaan persetujuan tertulis pemeriksaan saksi atas nama '+decodeURIComponent(param[0]));
		else if(keperluan == "Pemeriksaan Tersangka")
			$("#perihal").val('Permintaan persetujuan tertulis pemeriksaan tersangka atas nama '+decodeURIComponent(param[0]));
		else if(keperluan == "Penahanan Tersangka")
			$("#perihal").val('Permintaan persetujuan tertulis penahanan tersangka atas nama '+decodeURIComponent(param[0]));
	}
	/* END AMBIL SAKSI */

	/* START GET PIDSUS-14 UMUM */
	$("#pilih_pidsus14_khusus").on('click', function(e){
		$("#pidsus14_khusus_modal").find(".modal-body").html("");
		$("#pidsus14_khusus_modal").find(".modal-body").load("/pidsus/pds-pidsus-15-khusus/getpidsus14khusus");
		$("#pidsus14_khusus_modal").modal({backdrop:"static"});
	});
	$("#pidsus14_khusus_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-pidsus14-khusus-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		$("#no_urut_pidsus14_khusus").val(decodeURIComponent(param[0]));
		$("#tgl_pidsus14_khusus").val(decodeURIComponent(param[1]));
		$("#pidsus14_khusus_modal").modal("hide");
	}).on('click', "#idPilihPIDSUS14UModal", function(){
		var modal = $("#pidsus14_khusus_modal").find("#tabel-pidsus14-khusus-modal");
		var index = modal.find(".pilih-pidsus14-khusus-modal:checked").val();
		var param = index.toString().split('|#|');
		$("#no_urut_pidsus14_khusus").val(decodeURIComponent(param[0]));
		$("#tgl_pidsus14_khusus").val(decodeURIComponent(param[1]));
		$("#pidsus14_khusus_modal").modal("hide");
	}).on('click','#idBatalPIDSUS14UModal', function(){
		$("#pidsus14_khusus_modal").modal("hide");
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
        
	/* START UNDANG-UNDANG PASAL */
	var id;   
	function setId(id1){ id =id1; }
	 
	$('#table_uu').on('click',".undang", function(e){
		setId($(this).data("id"));
		$("#pilih_undang").find(".modal-body").html("");
		$("#pilih_undang").find(".modal-body").load("/pidsus/pds-terima-berkas/getformundang");
		$("#pilih_undang").modal({backdrop:"static", keyboard:false});
	}).on('click', '.pasal',function(e){
		setId($(this).data("id"));
		var ida = $('#undang_id'+id).val();
		if(ida == ""){
			bootbox.alert({message: "Silahkan pilih Undang-undang terlebih dahulu", size:'small', 
				callback: function(){
					$("#pilih_pasal").focus();
				}
			});
		}else{
			$("#form_pasal").find(".modal-body").html("");
			$("#form_pasal").find(".modal-body").load("/pidsus/pds-terima-berkas/getformpasal?jnsins_id="+ida);
			$("#form_pasal").modal({backdrop:"static"});
		}
	}).on('change','.dakwaan', function(e){
		var dak 	= $(this).data("id");
		var tabel	= $('#table_uu').find('.tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		var cek 	= newId - parseInt(dak);
		if($(this).val() != "" && cek == 1){
			$('#table_uu').append(
			'<div style="padding:10px; margin-bottom:15px; border:1px solid #f29db2;" class="tr" data-id="'+newId+'">'+
				'<button class="btn btn-danger btn-sm hapus-dakwaan pull-right" data-id="'+newId+'">Hapus</button>'+
				'<div class="row">'+        
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Undang-undang</label>'+
							'<div class="col-md-8">'+
								'<div class="input-group input-group-sm">'+
									'<input type="hidden" name="undang_id['+newId+']" id="undang_id'+newId+'" value="" />'+
									'<input type="text" name="undang_uu['+newId+']" id="undang_uu'+newId+'" class="form-control txtUndangPasal" value="" readonly />'+
									'<span class="input-group-btn"><button type="button" class="btn undang" data-id="'+newId+'">Pilih</button></span>'+
								'</div>'+
								'<div class="help-block with-errors" id="error_custom_undang_uu'+newId+'"></div>'+
							'</div>'+
						'</div>'+
					'</div>' +
				'</div>'+
				'<div class="row">'+        
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Pasal</label>'+
							'<div class="col-md-8">'+
								'<div class="input-group input-group-sm">'+
									'<input type="hidden" name="id_pasal['+newId+']" id="id_pasal'+newId+'" value="" />'+
									'<input type="text" name="pasal['+newId+']" id="pasal'+newId+'" class="form-control txtUndangPasal" value="" readonly />'+
									'<span class="input-group-btn"><button type="button" class="btn pasal" data-id="'+newId+'">Pilih</button></span>'+
								'</div>'+
								'<div class="help-block with-errors" id="error_custom_pasal'+newId+'"></div>'+
							'</div>'+
						'</div>'+
					'</div> '+
				'</div>'+
				'<div class="row">'+       
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Dakwaan</label>'+
							'<div class="col-md-4">'+
								'<select name="dakwaan['+newId+']" id="dakwaan'+newId+'" class="select2 dakwaan" data-id="'+newId+'" style="width:100%;">'+
									'<option value=""></option>'+
									'<option value="1">-- Juncto --</option>'+
									'<option value="2">-- Dan --</option>'+
									'<option value="3">-- Atau --</option>'+
									'<option value="4">-- Subsider --</option>'+
								'</select>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>');
			$("#dakwaan"+newId).select2({placeholder:"Pilih salah satu", allowClear:true});
		}
	}).on('click','.hapus-dakwaan',function(e){
		var id = $(this).data('id');
		$('#table_uu').find(".tr[data-id='"+id+"']").remove();
	});
	
	$("#pilih_undang").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("click", ".closeM1UU", function(){
		$("#pilih_undang").modal("hide");
	}).on("dblclick", "#tblModalUu td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split("|#|");
		insertToUu(param);
		$("#pilih_undang").modal('hide');
	}).on('click','.pilihModalUU',function(e){
		var index = $(this).data('id');
		var param = index.toString().split("|#|");
		insertToUu(param);
		$("#pilih_undang").modal('hide');
	});
	function insertToUu(param){
		var $target = $("#table_uu").find(".tr[data-id='"+id+"']");
		$("#undang_id"+id).val(decodeURIComponent(param[0]));
		$("#undang_uu"+id).val(decodeURIComponent(param[1]));
		$("#id_pasal"+id+", #pasal"+id).val("");
		$("#table_uu").animate({scrollTop: $target.offset().top-60 + "px"});
	}
	
	$("#form_pasal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("click", ".closeM1Psl", function(){
		$("#form_pasal").modal("hide");
	}).on("dblclick", "#tblModalPasal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split("|#|");
		insertToPasal(param);
		$("#form_pasal").modal('hide');
	}).on('click','.pilihModalPasal',function(e){
		var index = $(this).data('id');
		var param = index.toString().split("|#|");
		insertToPasal(param);
		$("#form_pasal").modal('hide');
	});
	function insertToPasal(param){
		var $target = $("#table_uu").find(".tr[data-id='"+id+"']");
		$("#id_pasal"+id).val(decodeURIComponent(param[0]));
		$("#pasal"+id).val(decodeURIComponent(param[1]));
		$("#table_uu").animate({scrollTop: $target.offset().top-60 + "px"});
	}
	/* END UNDANG-UNDANG PASAL */
});
	
</script>