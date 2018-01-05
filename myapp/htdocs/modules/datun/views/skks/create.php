<?php
	use yii\helpers\Html;
	if(!$model['no_register_skks']){
		$this->title = 'Tambah SKKS';
		$isNewRecord = 1;
	} else{
		$this->title = 'Ubah SKKS';
		$isNewRecord = 0;
	}
?>
<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	<?php if($isNewRecord){ ?>
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});
	<?php } ?>

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			var filenya 	= $("#file_skks")[0].files[0] , cek	 = $("#cek_file").val(); 			
			if(cek == 0 && typeof(filenya) == 'undefined'){
				bootbox.confirm({ 
					message: "Upload file SKKS masih kosong. Tetap simpan data tanpa melampirkan file SKKS?",
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
			}else{
				validasi_upload();
				return false;
			}
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_skks")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tglTmp 	= new Date(tgl_auto($("#tanggal_tmp").val()));
		var tglTtd 	= new Date(tgl_auto($("#tanggal_ttd").val()));
		var tglPng 	= new Date(tgl_auto($("#tanggal_panggilan").val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');
		var arrTkPn = {"JA":"1", "JAMDATUN":"2", "KAJATI":"3", "KAJARI":"4", "KACABJARI":"5", "JPN":"6"};
		var pnk1 	= $("#penerima_kuasa_tmp").val();
		var pnk2 	= $("#penerima_kuasa").val();

		$(".err_pknya, #error_custom1, #error_custom2, #error_custom3, #error_custom4").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(parseInt(arrTkPn[pnk1]) > parseInt(arrTkPn[pnk2])){
			$("body").removeClass("loading");
			$("#error_custom4").html('<span style="color:#dd4b39; font-size:12px;">Perhatikan hirarki antara pemberi kuasa dengan penerima kuasa</span>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if($("#penerima_kuasa").val() != 'JPN' && ($("#nama_penerima").val() == "" || $("#jabatan_penerima").val() == "" || $("#alamat_penerima").val() == "")){
			$("body").removeClass("loading");
			$(".err_pknya").html('<i style="color:#dd4b39; font-size:12px;">* Nama, jabatan, dan alamat penerima kuasa harus diisi</i>');
			setErrorFocus($(".err_pknya"), $("#role-form"), false);
			return false;
		} else if($("#penerima_kuasa").val() == 'JPN' && $("input[name='jpnid[]']").length < 2){
			$("body").removeClass("loading");
			$(".err_pknya").html('<i style="color:#dd4b39; font-size:12px;">* Minimal JPN 2 orang</i>');
			setErrorFocus($(".err_pknya"), $("#role-form"), false);
			return false;
		} else if(tglTtd < tglTmp){
			$("body").removeClass("loading");
			$("#error_custom2").html('<span style="color:#dd4b39; font-size:12px;">Tanggal tanda tangan harus lebih besar atau sama dengan tanggal skk(s)</span>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(tglTtd > hariIni){
			$("body").removeClass("loading");
			$("#error_custom2").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal tanda tangan adalah hari ini</span>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '/datun/skks/cekskks',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(!data.hasil){
						$("body").removeClass("loading");
						var pesan = "Skks dengan nomor "+$("#nomor_skks").val()+" sudah ada";
						$("#error_custom1").html(pesan).parents(".form-group").addClass("has-error");
						setErrorFocus($("#nomor_skks"), $("#role-form"), false);
					} else{
						$('#role-form').validator('destroy').off("submit");
						$('#role-form').submit();
					}
				}
			});
			return false;
		}
	}
});
</script>
