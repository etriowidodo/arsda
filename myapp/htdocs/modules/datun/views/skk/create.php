<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah SKK';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah SKK';
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
			validasi_upload();
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_skk")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tmpTtd 	= $("#tanggal_ttd").val();
		var tglSkk 	= new Date(tgl_auto($("#tanggal_skk").val()));
		var tglDtr 	= new Date(tgl_auto($("#tanggal_diterima").val()));
		var tglPrm 	= new Date(tgl_auto($("#tgl_permohonan").val()));
		var tglPng 	= new Date(tgl_auto($("#tanggal_panggilan").val()));
		var tglTtd 	= (tmpTtd)?new Date(tgl_auto(tmpTtd)):'';
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2, #error_custom3, #error_custom4, #error_custom5, #error_custom6, #error_custom7").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if($("#nama_ins").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom3").html('<span style="color:#dd4b39; font-size:12px;">Nama Instansi belum diisi</span>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if($("#kdtp").val() != '01' && $("#nomor_skk").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom1").html('<span style="color:#dd4b39; font-size:12px;">No. SKK belum diisi</span>');
			setErrorFocus($("#error_custom1"), $("#role-form"), false);
			return false;
		} else if($("#kdtp").val() == '06' && $("#tanggal_ttd").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom6").html('<span style="color:#dd4b39; font-size:12px;">Tanggal tanda tangan belum diisi</span>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else if(tglSkk < tglPrm){
			$("body").removeClass("loading");
			$("#error_custom2").html('<span style="color:#dd4b39; font-size:12px;">Tanggal SKK harus lebih besar atau sama dengan tanggal permohonan</span>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(tglSkk > hariIni){
			$("body").removeClass("loading");
			$("#error_custom2").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal SKK adalah hari ini</span>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(tglDtr < tglSkk){
			$("body").removeClass("loading");
			$("#error_custom4").html('<span style="color:#dd4b39; font-size:12px;">Tanggal diterima harus lebih besar atau sama dengan tanggal SKK</span>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if(tglDtr > hariIni){
			$("body").removeClass("loading");
			$("#error_custom4").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal diterima adalah hari ini</span>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if((tglTtd != '') && (tglTtd < tglDtr)){
			$("body").removeClass("loading");
			$("#error_custom6").html('<span style="color:#dd4b39; font-size:12px;">Tanggal tanda tangan harus lebih besar atau sama dengan tanggal diterima</span>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else if((tglTtd != '') && (tglTtd > hariIni)){
			$("body").removeClass("loading");
			$("#error_custom6").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal tanda tangan adalah hari ini</span>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom7").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom7"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom7").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom7"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '/datun/skk/cekskk',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(!data.hasil){
						$("body").removeClass("loading");
						$("#"+data.element).html(data.error);
						setErrorFocus($("#"+data.element), $("#role-form"), false);
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
