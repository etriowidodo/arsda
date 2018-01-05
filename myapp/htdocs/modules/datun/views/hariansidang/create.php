<?php 
	use yii\helpers\Html;
	$this->title 	= 'Tambah Laporan Harian Sidang (S-11)';
	$this->subtitle = '<span style="font-weight:400; font-size:13px;">No Register Perkara : '.$_SESSION['no_register_perkara'].' | No Permohonan : '.$_SESSION['no_surat'];
	$this->subtitle .= ($_SESSION['no_register_skk'])?' | No SKK : '.$_SESSION['no_register_skk'].'</span>':'</span>';
	if($model->isNewRecord){
		$isNewRecord = 1;
		$head['tanggal_skk'] 		= ($head['tanggal_skk'])?date("d-m-Y", strtotime($head['tanggal_skk'])):"";
		$head['tanggal_skks'] 		= ($head['tgl_skks'])?date("d-m-Y", strtotime($head['tgl_skks'])):"";
		$head['tanggal_diterima'] 	= ($head['tanggal_diterima'])?date("d-m-Y", strtotime($head['tanggal_diterima'])):"";
		$head['tanggal_panggilan_pengadilan'] = ($head['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($head['tanggal_panggilan_pengadilan'])):"";
		$model 	= array();
	} else{
		$isNewRecord = 0;
		$head['tanggal_skk'] 		= ($head['tanggal_skk'])?date("d-m-Y", strtotime($head['tanggal_skk'])):"";
		$head['tanggal_skks'] 		= ($head['tgl_skks'])?date("d-m-Y", strtotime($head['tgl_skks'])):"";
		$head['tanggal_diterima'] 	= ($head['tanggal_diterima'])?date("d-m-Y", strtotime($head['tanggal_diterima'])):"";
		$head['tanggal_panggilan_pengadilan'] = ($head['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($head['tanggal_panggilan_pengadilan'])):"";
	
	}
?>
<div class="pidum-pdm-spdp-create">
	<?php echo $this->render('_form', ['model' => $model, 'head' => $head, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#harian-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}	
			if($('#tab_kasus').val() == '' || $('#tab_laporan').val() == '' || $('#tab_analisa').val() == '' || $('#tab_kesimpulan').val() == '' || $('#tab_resume').val() == '' ){
				bootbox.confirm({ 
					message: "Text Editor [Kasus Posisi, Isi Laporan, Analisa, Kesimpulan, Resume] masih ada yang kosong. Apakah anda masih ingin tetap menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							$(".bootbox-confirm").modal('hide');
							$(".bootbox-confirm").one('hidden.bs.modal', function(){
								$("body").addClass("modal-open");
							});
							cekUploadS11();
							return false;
						}
					}
				});
				return false;
			} else{
				cekUploadS11();
				return false;
			}
		}
	});

	function cekUploadS11(){
		var filenya = $("#file_s11")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file S-11 (Laporan Harian Sidang). Apakah anda yakin ingin tetap menyimpan data?",
				size: "small",
				closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function(result){
					if(result){
						$(".bootbox-confirm").modal('hide');
						validasi_upload();
						return false;
					}
				}
			});
			return false;
		} else{
			validasi_upload();
			return false;
		}
	}

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_s11")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tglPng 	= new Date(tgl_auto($('#tanggal_panggilan_sidang').val()));
		var tglS11 	= new Date(tgl_auto($('#waktu_tanggal').val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');
		var tglTtd 	= new Date(tgl_auto($('#tanggal_ditandatangani').val()));

		$(".with-errors").html('');
		if(typeof(filenya) != 'undefined'){	
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		} 

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom8").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom8"), $("#harian-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom8").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom8"), $("#harian-form"), false);
			return false;
		} else if(tglS11 < tglPng){
			$("body").removeClass("loading");
			$("#error_custom7").html('<span style="color:#dd4b39; font-size:12px;">Tanggal Harian Sidang lebih kecil dari tanggal persidangan</span>');
			setErrorFocus($("#error_custom7"), $("#harian-form"), false);
			return false;
		} else if(tglS11 > hariIni){
			$("body").removeClass("loading");
			$("#error_custom7").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal Harian Sidang adalah hari ini</span>');
			setErrorFocus($("#error_custom7"), $("#harian-form"), false);
			return false;
		} else if(tglTtd < tglS11){
			$("body").removeClass("loading");
			$("#error_custom9").html('<span style="color:#dd4b39; font-size:12px;">Tanggal tanda tangan lebih kecil dari tanggal S11</span>');
			setErrorFocus($("#error_custom9"), $("#harian-form"), false);
			return false;
		} else if(tglTtd > hariIni){
			$("body").removeClass("loading");
			$("#error_custom9").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal tanda tangan adalah hari ini</span>');
			setErrorFocus($("#error_custom9"), $("#harian-form"), false);
			return false;
		} else{
			$('#harian-form').validator('destroy').off("submit");
			$('#harian-form').submit();
			/*$.ajax({
				type	: "POST",
				url		: '/datun/hariansidang/ceks11',
				data	: $("#harian-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(!data.hasil){
						$("body").removeClass("loading");
						$("#"+data.element).html(data.error);
						setErrorFocus($("#"+data.element), $("#harian-form"), false);
					} else{
						$('#harian-form').validator('destroy').off("submit");
						$('#harian-form').submit();
					}
				}
			});
			return false;*/
		}
	}
});
</script>
