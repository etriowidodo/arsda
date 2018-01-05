<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus15;

	$this->title = 'Pidsus-15';
	$this->subtitle = 'Surat Permintaan Persetujuan Tertulis Tindakan Penyidikan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/p16/index';
	$linkCetak		= '/pidsus/p16/cetak';
	$tgl_ttd 		= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/p16/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor</label>        
                            <div class="col-md-8">
                                <input type="text" name="nomor" id="nomor" class="form-control" value="<?php echo $model['nomor'];?>" <?php echo ($model['no_p16'])?'readonly':'';?> required data-error="Nomor belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Sifat</label>        
                            <div class="col-md-8">
                                <select name="sifat" id="sifat" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                                    <option></option>
                                    <?php 
                                        $resOpt = PdsPidsus15::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
                                        foreach($resOpt as $dOpt){
                                            $selected = ($model['sifat'] == $dOpt['id'])?'selected':'';
                                            echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tanggal" id="tanggal" class="form-control datepicker" value="<?php echo $model['tanggal'];?>" <?php echo ($model['tanggal'])?'readonly':'';?> required data-error="Tanggal belum diisi" maxlength="50" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>        
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran'];?>" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Keperluan</label>        
                            <div class="col-md-8">
                                <select name="keperluan" id="keperluan" class="select2" style="width:100%" required data-error="Keperluan belum diisi">
                                    <option></option>
                                    <option value="1">Pemeriksaan Saksi</option>
                                    <option value="2">Pemeriksaan Pemeriksaan Tersangka</option>
                                    <option value="3">Penahanan Tersangka</option>
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Saksi / Tersangka</label>        
                            <div class="col-md-8">
                                <select name="saksi" id="saksi" class="select2" style="width:100%" required data-error="Saksi / Tersangak belum diisi">
                                    <option></option>
                                    <?php 
//                                        $resOpt = PdsPidsus15::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
//                                        foreach($resOpt as $dOpt){
//                                            $selected = ($model['sifat'] == $dOpt['id'])?'selected':'';
//                                            echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
//                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
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
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">Posisi Kasus</h3>		
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <textarea name="posisi_kasus" id="posisi_kasus" style="height: 100px" class="form-control"></textarea>
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
        <h3 class="box-title">Undang-undang & Pasal</h3>
    </div>
    <div class="box-body">
        <table id="table_uu" class="table table-bordered">
            <thead>
                <tr>

                </tr>
            </thead>
            <tbody>
                <tr data-id='1'>
                    <td>
                        <div class="row">        
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-4">Undang-undang</label>
                                    <div class="col-md-8">
                                        <div class="input-group">
                                            <input type="hidden" name="id" id="id1" value="<?php echo $model['id'];?>"/>
                                            <input type="text" name="uu" id="uu1" class="form-control" value="<?php echo $model['uu'];?>" readonly required data-error="Undang-undang belum diisi"/>
                                            <span class="input-group-btn">
                                                <button class="btn btn-sm undang" data-id="1" type="button" <?php if($model['id']!=""){echo 'disabled';}?>>Pilih</button>
                                            </span>
                                        </div>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">        
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-4">Pasal</label>
                                    <div class="col-md-8">
                                        <div class="input-group input-group-sm">
                                            <input type="hidden" name="id_pasal" id="id_pasal1" value="<?php echo $model['id_pasal'];?>"/>
                                            <input type="text" name="pasal" id="pasal1" readonly class="form-control" value="<?php echo $model['pasal'];?>" required data-error="Pasal belum diisi"/>
                                            <div class="help-block with-errors"></div>
                                            <span class="input-group-btn">
                                                <button class="btn pasal" type="button" data-id="1"<?php if($model['id_pasal']!=""){echo 'disabled';}?>>Pilih</button>
                                            </span>
                                        </div>

                                    </div>
                                </div>
                            </div> 
                        </div>
                        <div class="row">        
                            <div class="col-md-6">
                                <div class="form-group form-group-sm">
                                    <label class="control-label col-md-4">Dakwaan</label>
                                    <div class="col-md-8">
                                        <select id="dakwaan1" name="dakwaan" class="select2 dakwaan" data-id='1'style="width:100%;">
                                            <option value=""></option>
                                            <option value="1">-Juncto-</option>
                                            <option value="2">-Dan-</option>
                                            <option value="3">-Atau-</option>
                                            <option value="4">-Subsider-</option>
                                        </select>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Ijin</label>        
                    <div class="col-md-8">
                        <input type="text" name="ijin" id="ijin" class="form-control" value="<?php echo $model['ijin'];?>" />
                        <div class="help-block with-errors" id="error_custom_no_p16"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Alasan</label>        
                    <div class="col-md-8">
                        <textarea name="alasan" id="alasan" style="height: 100px" class="form-control"></textarea>
                        <div class="help-block with-errors" id="error_custom_no_p16"></div>
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
                        	if($model['no_p16'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-16' order by no_urut";
                        		$resx = PdsPidsus15::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, deskripsi_tembusan as tembusan from pidsus.pds_p16_tembusan 
										where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
                        		$resx = PdsPidsus15::findBySql($sqlx)->asArray()->all();
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
                        $pathFile 	= Yii::$app->params['p16'].$model['file_upload_p16'];
                        $labelFile 	= 'Unggah Pidsus P-15';
                        if($model['file_upload_p16'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah Pidsus P-15';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_p16']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_p16'], strrpos($model['file_upload_p16'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p16'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo date("d-m-Y", strtotime($_SESSION["tgl_spdp"]));?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php // if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php // } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

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

<!--Undang Undang-->
<div class="modal fade" id="pilih_undang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Undang Undang</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<!--Pasal-->
<div class="modal fade" id="form_pasal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pasal</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

<!--TERSANGKA-->
<div class="modal fade" id="tambah_tersangka" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Tersangka</h4>
            </div>
            <div class="modal-body">
                
            </div>
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
         
        $("#pilih_undang").on('show.bs.modal', function(e){
            $("body").addClass("loading");
        }).on('shown.bs.modal', function(e){
            $("body").removeClass("loading");
        }).on('click','.selection_one',function(e){
            var ida = $(this).data('id');
            var tm = ida.toString().split("|#|");
            $("#id"+id).val(tm[0]);
            $("#uu"+id).val(tm[1]);
            $("#pilih_undang").modal('hide');
        });
        
        
        $("#form_pasal").on('show.bs.modal', function(e){
            $("body").addClass("loading");
        }).on('shown.bs.modal', function(e){
            $("body").removeClass("loading");
        }).on('click','.selection_one',function(e){
            var ida = $(this).data('id');
            var tm = ida.toString().split("|#|");
            $("#id_pasal"+id).val(tm[0]);
            $("#pasal"+id).val(tm[1]);
            $("#form_pasal").modal('hide');
        });
        
        $('#table_uu').on('click',".undang", function(e){
            setId($(this).data("id"));
            $("#pilih_undang").find(".modal-body").load("/pidsus/get-undang/getformundang");
            $("#pilih_undang").modal({backdrop:"static"});
        }).on('click', '.pasal',function(e){
            var ida=$('#id'+id).val();
            if(ida==""){
                bootbox.alert({
                    message: "Silahkan pilih Undang-undang terlebih dahulu",
                    size: 'small',
                    callback: function(){
                        $("#pilih_pasal").focus();
                    }
                }); 
            }else{
                $("#form_pasal").find(".modal-body").load("/pidsus/get-pasal/getformpasal?id="+ida);
                $("#form_pasal").modal({backdrop:"static"});
            }
        }).on('change','.dakwaan', function(e){
            var dak = $(this).data("id");
            var tabel	= $('#table_uu > tbody').find('tr:last');			
            var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
            var cek = newId-parseInt(dak);
            if(cek==1){
                $('#table_uu').append(
                    '<tr data-id="'+newId+'">' +
                        '<td>'+
                                '<div class="row">'+        
                                        '<div class="col-md-6">'+
                                            '<div class="form-group form-group-sm">'+
                                                '<label class="control-label col-md-4">Undang-undang</label>'+
                                                '<div class="col-md-8">'+
                                                    '<div class="input-group">'+
                                                        '<input type="hidden" name="id" id="id'+newId+'" value=""/>'+
                                                        '<input type="text" name="uu" id="uu'+newId+'" class="form-control" value="" readonly required data-error="Undang-undang belum diisi"/>'+
                                                        '<span class="input-group-btn">'+
                                                            '<button class="btn btn-sm undang" type="button" data-id="'+newId+'">Pilih</button>'+
                                                        '</span>'+
                                                    '</div>'+
                                                    '<div class="help-block with-errors"></div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>' +
                                    '</div>'+
                                    '<div class="row">'+        
                                        '<div class="col-md-6">'+
                                            '<div class="form-group form-group-sm">'+
                                                '<label class="control-label col-md-4">Pasal</label>'+
                                                '<div class="col-md-8">'+
                                                    '<div class="input-group input-group-sm">'+
                                                        '<input type="hidden" name="id_pasal" id="id_pasal'+newId+'" value=""/>'+
                                                        '<input type="text" name="pasal" id="pasal'+newId+'" readonly class="form-control" value="" required data-error="Pasal belum diisi"/>'+
                                                        '<div class="help-block with-errors"></div>'+
                                                        '<span class="input-group-btn">'+
                                                            '<button class="btn pasal" type="button" data-id="'+newId+'" >Pilih</button>'+
                                                        '</span>'+
                                                    '</div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div> '+
                                    '</div>'+
                                    '<div class="row"> '+       
                                        '<div class="col-md-6">'+
                                            '<div class="form-group form-group-sm">'+
                                                '<label class="control-label col-md-4">Dakwaan</label>'+
                                                '<div class="col-md-8">'+
                                                    '<select data-id="'+newId+'" id="dakwaan'+newId+'" name="dakwaan" class="select2 dakwaan" style="width:100%;">'+
                                                        '<option value=""></option>'+
                                                        '<option value="1">-Juncto-</option>'+
                                                        '<option value="2">-Dan-</option>'+
                                                        '<option value="3">-Atau-</option>'+
                                                        '<option value="4">-Subsider-</option>'+
                                                    '</select>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div><button class="btn btn-warning hapus-dakwaan" data-id="'+newId+'">Hapus</button>'+
                                    '</div>'+
                        '</td>'+
                    '</tr>'
                );
            $("#dakwaan"+newId).select2({placeholder:"Pilih salah satu", allowClear:true});
            }
            }).on('click','.hapus-dakwaan',function(e){
                var id=$(this).data('id');
                $('#table_uu').find("tr[data-id='"+id+"']").remove();
            });
         var id;   
         function setId(id1){
             id =id1;
         }
        /* END UNDANG-UNDANG PASAL */
});
	
</script>