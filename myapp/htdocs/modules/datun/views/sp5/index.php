<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	$this->title = 'Formulir Telaahan Bantuan Hukum (S5)';
	$linkBatal		= '/datun/permohonan/update?id='.rawurlencode($_SESSION['no_register_perkara']).'&ns='.rawurlencode($_SESSION['no_surat']);
	$linkCetak		= '/datun/sp5/cetak';
	$tgl_permohonan = ($model['tanggal_permohonan'])?date("d-m-Y", strtotime($model['tanggal_permohonan'])):"";
	$tgl_diterima 	= ($model['tanggal_diterima'])?date("d-m-Y", strtotime($model['tanggal_diterima'])):"";
	$tgl_pengadilan = date('d-m-Y',strtotime($model['tanggal_panggilan_pengadilan']));
	$tgl_sp1 		= ($model['tanggal_sp1'])?date("d-m-Y", strtotime($model['tanggal_sp1'])):"";
	$tanggal_ttd 	= ($model['tanggal_ttd'])?date("d-m-Y", strtotime($model['tanggal_ttd'])):"";
	$isNewRecord 	= ($tanggal_ttd == '')?1:0;
	$petunjuk 		= ($isNewRecord)?'2':$model['petunjuk'];
?>

<?php if($model['no_sp1'] && $model['no_register_perkara'] && $model['no_surat']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/sp5/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Permohonan</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Jenis Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="jenis_ins" name="jenis_ins" class="form-control" value="<?php echo $model['jenis_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="nama_ins" name="nama_ins" class="form-control" value="<?php echo $model['nama_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Register</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $model['no_register_perkara']; ?>" id="no_reg_perkara" name="no_reg_perkara" readonly />
                        <div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Wilayah</label>        
        			<div class="col-md-8">
                        <input type="text" id="instans" name="instans" class="form-control" value="<?php echo $model['wil_instansi'];?>" readonly />
                    </div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Surat Permohonan</label>        
        			<div class="col-md-8">
                        <?php if($model['kode_jenis_instansi'] == '01' || $model['kode_jenis_instansi'] == '06'){ ?>
                        <input type="hidden" id="no_permohonan" name="no_permohonan" value="<?php echo $model['no_surat']; ?>" />
                        <input type="text" id="npemohonTxt" name="npemohonTxt" class="form-control" value="" readonly />
                        <?php } else{ ?>
                        <input type="hidden" id="no_permohonan" name="no_permohonan" value="<?php echo $model['no_surat']; ?>" />
                        <input type="text" id="npemohonTxt" name="npemohonTxt" class="form-control" value="<?php echo $model['no_surat']; ?>" readonly />
                        <?php } ?>
                        <div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Permohonan</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?php echo $tgl_permohonan; ?>" readonly />
						</div>						
					</div>
        		</div>
        	</div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Diterima Wilayah Kerja</label>
        			<div class="col-md-8">
            			<input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo Yii::$app->inspektur->getNamaSatker();?>" readonly />
            		</div>
            	</div>
            </div>
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Diterima</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control" id="tgl_diterima" name="tgl_diterima" value="<?php echo $tgl_diterima;?>" readonly />
                        </div>						
                    </div>
        		</div>
        	</div>
        </div>
	</div>
</div>

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Dasar</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No. Surat Perintah (SP-1)</label>
        			<div class="col-md-8">
            			<input type="text" id="no_sp1" name="no_sp1" class="form-control" value="<?php echo $model['no_sp1'];?>" readonly />
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal (SP-1)</label>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control" id="tgl_sp1" name="tgl_sp1" value="<?php echo $tgl_sp1;?>" readonly />
                        </div>						
                    </div>
            	</div>
            </div>
        </div>
	</div>
</div>

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Posisi Kasus</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active"><a href="#tab-data" data-toggle="tab">Data</a></li>
                            <li><a href="#tab-fakta" data-toggle="tab">Fakta</a></li>
                            <!-- <a class="accordion-toggle pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapsefakta">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i></a> -->
                        </ul>
                    </div>
                    <div id="collapsefakta" class="panel-collapse">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-data">
                                    <textarea name="posisi_data" id="posisi_data" class="ckeditor"><?php echo $model['posisi_kasus_dt'];?></textarea>
                                </div>
                                <div class="tab-pane fade" id="tab-fakta">
                                    <textarea name="posisi_fakta" id="posisi_fakta" class="ckeditor"><?php echo $model['posisi_kasus_ft'];?></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active"><a href="#tab-permasalahan" data-toggle="tab">Permasalahan</a></li>
                            <li><a href="#tab-analisa" data-toggle="tab">Analisa </a></li>
                            <li><a href="#tab-kesimpulan" data-toggle="tab">Kesimpulan</a></li>
                            <li><a href="#tab-saran" data-toggle="tab">Saran</a></li>	
                            <!-- <a class="accordion-toggle pull-right" data-toggle="collapse" data-parent="#accordion" href="#collapsemasalah">
                            <i class="fa fa-chevron-down" aria-hidden="true"></i></a> -->
                        </ul>
                    </div>
                    <div id="collapsemasalah" class="panel-collapse">
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-permasalahan">
                                    <textarea name="permasalahan" id="permasalahan" class="ckeditor"><?php echo $model['permasalahan'];?></textarea>
                                </div>
                                <div class="tab-pane fade" id="tab-analisa">
                                    <textarea name="analisa" id="analisa" class="ckeditor"><?php echo $model['analisa'];?></textarea>
                                </div>
                                <div class="tab-pane fade" id="tab-kesimpulan">
                                    <textarea name="kesimpulan" id="kesimpulan" class="ckeditor"><?php echo $model['kesimpulan'];?></textarea>
                                </div>
                                <div class="tab-pane fade" id="tab-saran">
                                    <textarea name="saran" id="saran" class="ckeditor"><?php echo $model['saran'];?></textarea>
                                </div>				  
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
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Petunjuk JPN</label>
            <div class="col-md-8">
                <select name="petunjuk_jpn" id="petunjuk_jpn" class="select2" style="width:100%" required data-error="Petunjuk JPN belum dipilih">
					<option></option>
                    <option value="1" <?php echo ($petunjuk === true)?'selected':'';?>>Dapat diterbitkan SKK</option>
                    <option value="0" <?php echo ($petunjuk === false)?'selected':'';?>>Permohonan tidak dapat ditindaklanjuti</option>
                </select>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Dikeluarkan di</label>
            <div class="col-md-8">
                <input type="text" id="lok_keluar" name="lok_keluar" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly />	
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-offset-6 col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal Ditandatangani</label>
            <div class="col-md-4">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control datepicker" id="tanggal_ttd" name="tanggal_ttd" value="<?php echo $tanggal_ttd;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal Belum diisi" />
                </div>						
            </div>
            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom1"></div></div>
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
                        $pathFile 	= Yii::$app->params['s5'].$model['file_s5'];
                        $labelFile 	= 'Upload File S5';
                        if($model['file_s5'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File S5';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_s5']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_s5'], strrpos($model['file_s5'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_s5'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom2"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <input type="hidden" name="cek_aja" id="cek_aja" />
    <input type="hidden" name="tgl_pengadilan" id="tgl_pengadilan" value="<?php echo $tgl_pengadilan;?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan" name="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
	<?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>
<?php } ?>
<div class="modal-loading-new"></div>
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
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			var posisi_data = $('#posisi_data').val(), posisi_fakta = $('#posisi_fakta').val(), permasalahan = $('#permasalahan').val(); 
			var analisa 	= $('#analisa').val(), kesimpulan = $('#kesimpulan').val(), saran = $('#saran').val(); 
			if(posisi_data == '' || posisi_fakta == '' || permasalahan == '' || analisa == '' || kesimpulan == '' || saran == ''){
				bootbox.confirm({ 
					message: "Text editor masih ada yang kosong. Apakah anda tetap ingin menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							bootbox.hideAll();
							validasi_upload();
							return false;
						}
					}
				});	
			} else{
				validasi_upload();
				return false;
			}
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tglTtd 	= new Date(tgl_auto($("#tanggal_ttd").val()));
		var tglSp1 	= new Date(tgl_auto($("#tgl_sp1").val()));
		var tglPn 	= new Date(tgl_auto($("#tgl_pengadilan").val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(tglTtd < tglSp1){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">Tanggal tanda tangan harus lebih besar atau sama dengan tanggal SP1</i>');
			setErrorFocus($("#tanggal_ttd"), $("#role-form"), false);
			return false;
		} else if(tglTtd > hariIni){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal tanda tangan adalah hari ini</i>');
			setErrorFocus($("#tanggal_ttd"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt, .doc, .docx, .pdf</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '/datun/sp5/ceksp5',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(!data.hasil){
						$("body").removeClass("loading");
						bootbox.confirm({ 
							message: "Anda telah merubah kolom petunjuk. Apakah anda yakin ingin menyimpan data?",
							size: "small",
							closeButton: false,
							buttons: {
								confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
								cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
							},
							callback: function(result){
								if(result){
									$("#cek_aja").val('1');
									$('#role-form').validator('destroy').off("submit");
									$('#role-form').submit();
								}
							}
						});	
					} else{
						$("#cek_aja").val('');
						$('#role-form').validator('destroy').off("submit");
						$('#role-form').submit();
					}
				}
			});
		}
	}
});
</script>

