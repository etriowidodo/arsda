<?php
	use yii\helpers\Html;	
	$this->title = 'Daftar Bukti Tertulis dari Tergugat (S-19.A)';
	$isNewRecord = ($model['tanggal_s19a'] == ''?1:0);
?>

<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord' => $isNewRecord]); ?>
</div>

<div class="modal-loading-new"></div>
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
			if($("input[name='no_tergugat[]']").length == 0){
				bootbox.confirm({ 
					message: "Tabel Bukti masih kosong. Apakah anda ingin tetap menyimpan data?",
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
							cekUpload();
							return false;
						}
					}
				});
				return false;
			}else{
				cekUpload();
				return false;
			}
		}
	});
	
	function cekUpload(){
		var filenya = $("#file_template")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file S-19A. Apakah anda yakin ingin tetap menyimpan data?",
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
		var filenya 	= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		= [".doc", ".odt", ".docx", ".rtf", ".pdf"];
		var tgl_s19a 	= ($("#tgl_s19a").val())?new Date(tgl_auto($("#tgl_s19a").val())):"";
		var tgl_pngdln 	= new Date($('#tanggal_panggilan_pengadilan').val());
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');

		$(".with-errors").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file Hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom_file_template"),$('#role-form'),false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom_file_template"),$('#role-form'),false);						
			return false;
		} else if(tgl_s19a && (tgl_s19a < tgl_pngdln)){
			$("body").removeClass("loading");
			$("#error_custom_tgl_s19a").html('<i style="color:#dd4b39; font-size:12px;">Tanggal S-19A lebih kecil dari tanggal panggilan pengadilan</i>');
			setErrorFocus($("#error_custom_tgl_s19a"), $("#role-form"), false);
			return false;
		} else if(tgl_s19a && (tgl_s19a > hariIni)){
			$("body").removeClass("loading");
			$("#error_custom_tgl_s19a").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal S-19A adalah hari ini</i>');
			setErrorFocus($("#error_custom_tgl_s19a"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
			
		}
	}	
	
});
</script>

