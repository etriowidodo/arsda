<?php
	use yii\helpers\Html;
	$this->title 	= 'Eksepsi Tergugat (S-14)';
	$isNewRecord 	= ($model['tanggal_diterima_s14'] == ''?1:0);
	$tanggal_skk 	= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):"";
	$tgl_diterima 	= ($model['tanggal_diterima'])?date("d-m-Y", strtotime($model['tanggal_diterima'])):"";
	$tgl_skks 		= ($model['tgl_skks'])?date("d-m-Y", strtotime($model['tgl_skks'])):"";
	$tgl_s14 		= ($model['tanggal_diterima_s14'])?date("d-m-Y", strtotime($model['tanggal_diterima_s14'])):"";
	$model['subsidair'] = ($model['subsidair'])?$model['subsidair']:'Apabila pengadilan berpendapat lain, mohon putusan yang seadil-adilnya (ex aequo et bono).';
?>

<div class="role-create">
	<?php echo $this->render('_form', [
		'model' 		=> $model,
		'tanggal_skk' 	=> $tanggal_skk,
		'tgl_diterima' 	=> $tgl_diterima,
		'tgl_skks' 		=> $tgl_skks,
		'tgl_s14' 		=> $tgl_s14,
		'isNewRecord' 	=> $isNewRecord,
	]); ?>
</div>

<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});
	
	function tgl_auto($tgl){
		var a = $tgl.toString().split('-');
		return a[2]+'-'+a[1]+'-'+a[0];
	}
	
	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}	
			if($('#alasan').val() == '' || $('#primair').val() == '' || $('#subsidair').val() == '' ){			
				bootbox.confirm({ 
					message: "Text Editor dalam panel [Alasan, Primair, Subsidair] masih ada yang kosong. Apakah anda masih ingin tetap menyimpan data?",
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
							cekUploadS14();
							return false;
						}
					}
				});
				return false;
			} else{
				cekUploadS14();
				return false;
			}
		}
	});

	function cekUploadS14(){
		var filenya = $("#file_template")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file S-14. Apakah anda yakin ingin tetap menyimpan data?",
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
		var filenya = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tgl_s14 = new Date(tgl_auto($('#tgl_eksepsi').val()));
		var hariIni = new Date('<?php echo date('Y-m-d') ?>');
		var tgl_pgdln = new Date(tgl_auto($('#tanggal_panggilan_pengadilan').val()));

		$("#err_tgls14, #cek_error").html("");
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(tgl_s14 < tgl_pgdln){
			$("body").removeClass("loading");
			$("#err_tgls14").html('<i style="color:#dd4b39; font-size:12px;">* Tanggal S-14 lebih kecil daripada tanggal persidangan</i>');
			setErrorFocus($("#err_tgls14"), $("#role-form"), false);
			return false;
		} else if(tgl_s14 > hariIni){
			$("body").removeClass("loading");
			$("#err_tgls14").html('<i style="color:#dd4b39; font-size:12px;">* Maximal tanggal S-14 adalah hari ini</i>');
			setErrorFocus($("#err_tgls14"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#cek_error").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#cek_error"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#cek_error").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#cek_error"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
					
		}
	}
});	
</script>
