<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPermintaanPerpanjangan;

	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/pds-permintaan-perpanjangan/index';
	$tgl_minta_pnj 	= ($model['tgl_minta_perpanjang'])?date('d-m-Y',strtotime($model['tgl_minta_perpanjang'])):'';
	$tgl_minta_pnh 	= ($model['tgl_surat_penahanan'])?date('d-m-Y',strtotime($model['tgl_surat_penahanan'])):'';
	$tgl_terima 	= ($model['tgl_terima'])?date('d-m-Y',strtotime($model['tgl_terima'])):'';
	$tgl_lahir 		= ($model['tgl_lahir'])?date('d-m-Y',strtotime($model['tgl_lahir'])):'';
	$tgl_mulai_thn 	= ($model['tgl_mulai_penahanan'])?date('d-m-Y',strtotime($model['tgl_mulai_penahanan'])):'';
	$tgl_habis_thn 	= ($model['tgl_selesai_penahanan'])?date('d-m-Y',strtotime($model['tgl_selesai_penahanan'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-permintaan-perpanjangan/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="box box-primary">
    <div class="box-body">
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Instansi Penyidik</label>        
                    <div class="col-md-8">
                        <input type="text" id="instansi_pdk" name="instansi_pdk" class="form-control" value="<?php echo $model['nama_instansi_penyidik'];?>" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Instansi Pelaksana Penyidikan</label>        
                    <div class="col-md-8">
                        <input type="text" id="instansi_plk_pydk" name="instansi_plk_pydk" class="form-control" value="<?php echo $model['nama_instansi_pelaksana'];?>" readonly />
                        <div class="help-block with-errors"></div>
					</div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Surat Permintaan</label>
                    <div class="col-md-8">
                        <input type="text" name="no_minta_perpanjang" id="no_minta_perpanjang" class="form-control" value="<?php echo $model['no_minta_perpanjang'];?>" required data-error="Nomor Surat Permintaan belum diisi" maxlength="50" />
                        <div class="help-block with-errors" id="error_custom_no_minta_perpanjang"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Permintaan</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_minta_perpanjang" id="tgl_minta_perpanjang" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_minta_pnj;?>" required data-error="Tanggal Surat Permintaan belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_minta_perpanjang"></div></div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Surat Perintah Penahanan</label>
                    <div class="col-md-8">
                        <input type="text" name="no_surat_penahanan" id="no_surat_penahanan" class="form-control" value="<?php echo $model['no_surat_penahanan'];?>" required data-error="Nomor Surat Perintah Penahanan belum diisi" maxlength="50" />
                        <div class="help-block with-errors" id="error_custom_no_surat_penahanan"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Surat Perintah Penahanan</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_surat_penahanan" id="tgl_surat_penahanan" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_minta_pnh;?>" required data-error="Tanggal Surat Perintah Penahanan belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_surat_penahanan"></div></div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                    <div class="col-md-8">
                        <input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo Yii::$app->inspektur->getNamaSatker();?>" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Diterima</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_terima" id="tgl_terima" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_terima;?>" required data-error="Tanggal Diterima belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_terima"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusTersangka jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm<?php echo ($model['no_minta_perpanjang']?' disabled':'');?>" id="tersangka" title="Tambah Tersangka">
                        	<i class="fa fa-plus jarak-kanan"></i>Tersangka
						</a>
                    </div>	
                </div>		
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="table-responsive">
                    <table id="table_tersangka" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center"></th>
                                <th width="60%" class="text-center">Nama</th>
                                <th width="35%" class="text-center">Tempat dan Tanggal Lahir</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							if($model['no_minta_perpanjang']){
								echo '
								<tr data-id="1">
									<td class="text-center">
										<input type="checkbox" name="chk_del_tembusan" id="chk_del_tembusan1" class="hRow" value="1" />
									</td>
									<td>
										<input type="hidden" class="tersangkanyaPT" name="nama" id="nama" value="'.$model['nama'].'" />
										<input type="hidden" class="tersangkanyaPT" name="tmpt_lahir" id="tmpt_lahir" value="'.$model['tmpt_lahir'].'" />
										<input type="hidden" class="tersangkanyaPT" name="tgl_lahir" id="tgl_lahir" value="'.$tgl_lahir.'" />
										<input type="hidden" class="tersangkanyaPT" name="umur" id="umur" value="'.$model['umur'].'" />
										<input type="hidden" class="tersangkanyaPT" name="warganegara" id="warganegara" value="'.$model['warganegara'].'" />
										<input type="hidden" class="tersangkanyaPT" name="kebangsaan" id="kebangsaan" value="'.$model['kebangsaan'].'" />
										<input type="hidden" class="tersangkanyaPT" name="suku" id="suku" value="'.$model['suku'].'" />
										<input type="hidden" class="tersangkanyaPT" name="id_identitas" id="id_identitas" value="'.$model['id_identitas'].'" />
										<input type="hidden" class="tersangkanyaPT" name="no_identitas" id="no_identitas" value="'.$model['no_identitas'].'" />
										<input type="hidden" class="tersangkanyaPT" name="id_jkl" id="id_jkl" value="'.$model['id_jkl'].'" />
										<input type="hidden" class="tersangkanyaPT" name="id_agama" id="id_agama" value="'.$model['id_agama'].'" />
										<input type="hidden" class="tersangkanyaPT" name="alamat" id="alamat" value="'.$model['alamat'].'" />
										<input type="hidden" class="tersangkanyaPT" name="no_hp" id="no_hp" value="'.$model['no_hp'].'" />
										<input type="hidden" class="tersangkanyaPT" name="id_pendidikan" id="id_pendidikan" value="'.$model['id_pendidikan'].'" />
										<input type="hidden" class="tersangkanyaPT" name="pekerjaan" id="pekerjaan" value="'.$model['pekerjaan'].'" />
										<input type="hidden" class="tersangkanyaPT" name="jenis_penahanan" id="jenis_penahanan" value="'.$model['jenis_penahanan'].'" />
										<input type="hidden" class="tersangkanyaPT" name="tgl_mulai_penahanan" id="tgl_mulai_penahanan" value="'.$tgl_mulai_thn.'" />
										<input type="hidden" class="tersangkanyaPT" name="tgl_selesai_penahanan" id="tgl_selesai_penahanan" value="'.$tgl_habis_thn.'" />
										<input type="hidden" class="tersangkanyaPT" name="lokasi_penahanan" id="lokasi_penahanan" value="'.$model['lokasi_penahanan'].'" />
										<a class="ubahTersangka" style="cursor:pointer">'.$model['nama'].'</a>
									</td>
									<td>'.$model['tmpt_lahir'].', '.date("d-m-Y", strtotime($model['tgl_lahir'])).'</td>
								</tr>';
							}								
						?>
                        </tbody>
                    </table>
                </div>
                <p style="margin:0px;" class="help-block with-errors" id="error_custom_tersangka"></p>
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
                        $pathFile 	= Yii::$app->params['minta_perpanjang'].$model['file_upload_minta_perpanjang'];
                        $labelFile 	= 'Unggah File Permintaan...';
                        if($model['file_upload_minta_perpanjang'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Permintaan...';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_minta_perpanjang']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_minta_perpanjang'], strrpos($model['file_upload_minta_perpanjang'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_minta_perpanjang'].'" style="float:left; margin-right:10px;">
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
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<!--TERSANGKA-->
<div class="modal fade" id="tambah_tersangka" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Tersangka</h4>
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
	/* START TERSANGKA */
	$("#tersangka").on("click", function(){
		var tabel = $('#table_tersangka > tbody').find('tr:last');
		if(tabel.length == 0){		
			$("#tambah_tersangka").find(".modal-body").html("");
			$("#tambah_tersangka").find(".modal-body").load("/pidsus/pds-permintaan-perpanjangan/poptersangka", function(){
				$("#simpan_form_tersangka").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');
			});
			$("#tambah_tersangka").modal({backdrop:"static", keyboard:false});
		} else{
			bootbox.alert({message: "Hanya untuk satu tersangka", size: 'small'});
		}
	});
	$("#tambah_tersangka").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
		$("#frm-m1").validator({disable:false});
		$("#frm-m1").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#evt_sukses").trigger("validasi.oke");
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		//$(this).find('form').off('submit').validator('destroy');
	}).on("validasi.oke", "#evt_sukses", function(){
		var frmnya = $("#tambah_tersangka").find("#frm-m1").serializeArray();
		var arrnya = [];
		$.each(frmnya, function(i,v){arrnya[v.name] = v.value;});
		var tabel = $('#table_tersangka > tbody').find('tr:last');
		if(tabel.length == 0){
			$('#table_tersangka').append(
			'<tr data-id="1">'+
				'<td class="text-center"><input type="checkbox" name="chk_del_tembusan" id="chk_del_tembusan1" class="hRow" value="1"></td>'+
				'<td>'+
					'<input type="hidden" class="tersangkanyaPT" name="nama" id="nama" value="'+arrnya['modal_nama']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="tmpt_lahir" id="tmpt_lahir" value="'+arrnya['modal_tmpt_lahir']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="tgl_lahir" id="tgl_lahir" value="'+arrnya['modal_tgl_lahir']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="umur" id="umur" value="'+arrnya['modal_umur']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="warganegara" id="warganegara" value="'+arrnya['modal_warganegara']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="kebangsaan" id="kebangsaan" value="'+arrnya['modal_kebangsaan']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="suku" id="suku" value="'+arrnya['modal_suku']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="id_identitas" id="id_identitas" value="'+arrnya['modal_id_identitas']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="no_identitas" id="no_identitas" value="'+arrnya['modal_no_identitas']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="id_jkl" id="id_jkl" value="'+arrnya['modal_id_jkl']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="id_agama" id="id_agama" value="'+arrnya['modal_id_agama']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="alamat" id="alamat" value="'+arrnya['modal_alamat']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="no_hp" id="no_hp" value="'+arrnya['modal_no_hp']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="id_pendidikan" id="id_pendidikan" value="'+arrnya['modal_pendidikan']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="pekerjaan" id="pekerjaan" value="'+arrnya['modal_pekerjaan']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="jenis_penahanan" id="jenis_penahanan" value="'+arrnya['modal_jenis_penahanan']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="tgl_mulai_penahanan" id="tgl_mulai_penahanan" value="'+arrnya['modal_tgl_mulai_penahanan']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="tgl_selesai_penahanan" id="tgl_selesai_penahanan" value="'+arrnya['modal_tgl_selesai_penahanan']+'" />'+
					'<input type="hidden" class="tersangkanyaPT" name="lokasi_penahanan" id="lokasi_penahanan" value="'+arrnya['modal_lokasi_penahanan']+'" />'+
					'<a class="ubahTersangka" style="cursor:pointer">'+arrnya['modal_nama']+'</a>'+
				'</td>'+
				'<td>'+arrnya['modal_tmpt_lahir']+', '+arrnya['modal_tgl_lahir']+'</td>'+
			'</tr>');
		} else{
			tabel.html(
			'<td class="text-center"><input type="checkbox" name="chk_del_tembusan" id="chk_del_tembusan1" class="hRow" value="1"></td>'+
			'<td>'+
				'<input type="hidden" class="tersangkanyaPT" name="nama" id="nama" value="'+arrnya['modal_nama']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="tmpt_lahir" id="tmpt_lahir" value="'+arrnya['modal_tmpt_lahir']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="tgl_lahir" id="tgl_lahir" value="'+arrnya['modal_tgl_lahir']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="umur" id="umur" value="'+arrnya['modal_umur']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="warganegara" id="warganegara" value="'+arrnya['modal_warganegara']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="kebangsaan" id="kebangsaan" value="'+arrnya['modal_kebangsaan']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="suku" id="suku" value="'+arrnya['modal_suku']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="id_identitas" id="id_identitas" value="'+arrnya['modal_id_identitas']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="no_identitas" id="no_identitas" value="'+arrnya['modal_no_identitas']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="id_jkl" id="id_jkl" value="'+arrnya['modal_id_jkl']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="id_agama" id="id_agama" value="'+arrnya['modal_id_agama']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="alamat" id="alamat" value="'+arrnya['modal_alamat']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="no_hp" id="no_hp" value="'+arrnya['modal_no_hp']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="id_pendidikan" id="id_pendidikan" value="'+arrnya['modal_pendidikan']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="pekerjaan" id="pekerjaan" value="'+arrnya['modal_pekerjaan']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="jenis_penahanan" id="jenis_penahanan" value="'+arrnya['modal_jenis_penahanan']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="tgl_mulai_penahanan" id="tgl_mulai_penahanan" value="'+arrnya['modal_tgl_mulai_penahanan']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="tgl_selesai_penahanan" id="tgl_selesai_penahanan" value="'+arrnya['modal_tgl_selesai_penahanan']+'" />'+
				'<input type="hidden" class="tersangkanyaPT" name="lokasi_penahanan" id="lokasi_penahanan" value="'+arrnya['modal_lokasi_penahanan']+'" />'+
				'<a class="ubahTersangka" style="cursor:pointer">'+arrnya['modal_nama']+'</a>'+
			'</td>'+
			'<td>'+arrnya['modal_tmpt_lahir']+', '+arrnya['modal_tgl_lahir']+'</td>');
		}
		$("#tersangka").addClass("disabled");
		$("#chk_del_tembusan1").iCheck({checkboxClass: 'icheckbox_square-pink'});
		$("#tambah_tersangka").modal('hide');
	});
	$(".hapusTersangka").click(function(){
		var tabel = $("#table_tersangka");
		tabel.find(".hRow:checked").each(function(k, v){
			tabel.find("tr[data-id='1']").remove();
			$("#tersangka").removeClass("disabled");
		});
	});

	$("#table_tersangka").on("click",'.ubahTersangka',function(){
		$.ajax({
			type	: "POST",
			url		: "/pidsus/pds-permintaan-perpanjangan/poptersangka",
			data	: $(".tersangkanyaPT").serializeArray(),
			cache	: false,
			success : function(data){ 
				$("#tambah_tersangka").find(".modal-body").html("");
				$("#tambah_tersangka").find(".modal-body").html(data);
				$("#tambah_tersangka").find("#simpan_form_tersangka").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
				$("#tambah_tersangka").modal({backdrop:"static", keyboard:false});
			}
		});
	});
	/* END TERSANGKA */
});

</script>
<?php } ?>