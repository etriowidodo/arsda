<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Undangan';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Undangan';
		$isNewRecord = 0;
	}
	$this->subtitle = 'No Register Perkara : '.$_SESSION['no_register_perkara'].' | No Permohonan : '.$_SESSION['no_surat'];
?>
<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			validasi_upload();
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_undangan")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tmpSkk 	= $("#tanggal_skks").val();
		var tmpSp1 	= $("#tgl_sp1").val();
		var tglSrt 	= new Date(tgl_auto($("#tanggal_surat_und").val()));
		var tglUnd 	= new Date(tgl_auto($("#tgl_und").val()));
		var tglSkk 	= (tmpSkk)?new Date(tgl_auto(tmpSkk)):'';
		var tglSp1 	= (tmpSp1)?new Date(tmpSp1):'';
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom0, #error_custom1, #error_custom2, #error_custom3, #error_custom4, #error_custom5, #error_custom6, #error_custom7").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		/* if($("#tahap_undangan").val() == 1){
			$("body").removeClass("loading");
			$("#error_custom0").html('<i style="color:#dd4b39; font-size:12px;">Tanggal SP1 tidak ada, anda tidak dapat membuat surat undangan ini</i>');
			setErrorFocus($("#error_custom0"), $("#role-form"), false);
			return false;
		} else  */
		if($("#tahap_undangan").val() == 2 && !tglSkk){
			$("body").removeClass("loading");
			$("#error_custom0").html('<i style="color:#dd4b39; font-size:12px;">Tanggal SKKS tidak ada, anda tidak dapat membuat surat undangan ini</i>');
			setErrorFocus($("#error_custom0"), $("#role-form"), false);
			return false;
		} else if($("#no_perkara").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom1").html('<span style="color:#dd4b39; font-size:12px;">No Register Perkara belum diisi</span>');
			setErrorFocus($("#no_perkara"), $("#role-form"), false);
			return false;
		} else if($("#tahap_undangan").val() == 1 && tglSp1!='' && tglSrt < tglSp1){
			$("body").removeClass("loading");
			$("#error_custom3").html('<span style="color:#dd4b39; font-size:12px;">Tanggal surat undangan harus lebih besar atau sama dengan tanggal SP1</span>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if($("#tahap_undangan").val() == 2 && tglSrt < tglSkk){
			$("body").removeClass("loading");
			$("#error_custom3").html('<span style="color:#dd4b39; font-size:12px;">Tanggal surat undangan harus lebih besar atau sama dengan tanggal SKKS</span>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(tglSrt > hariIni){
			$("body").removeClass("loading");
			$("#error_custom3").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal surat undangan adalah hari ini</span>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if($("#tgl_und").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom4").html('<span style="color:#dd4b39; font-size:12px;">Tanggal acara belum diisi</span>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if(tglUnd < tglSrt){
			$("body").removeClass("loading");
			$("#error_custom4").html('<span style="color:#dd4b39; font-size:12px;">Tanggal acara harus lebih besar atau sama dengan tanggal surat undangan</span>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if($("#jam_und").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom5").html('<span style="color:#dd4b39; font-size:12px;">Jam acara belum diisi</span>');
			setErrorFocus($("#error_custom5"), $("#role-form"), false);
			return false;
		} else if($("#penandatangan_nip").val() == '' || $("#penandatangan_nama").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom6").html('<span style="color:#dd4b39; font-size:12px;">Penandatangan belum dipilih</span>');
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
				url		: '/datun/undangan/cekundangan',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.hasil){
						$("body").removeClass("loading");
						var pesan = "Undangan dengan nomor "+$("#no_surat_undangan").val()+" sudah ada";
						$("#error_custom2").html(pesan).parents(".form-group").addClass("has-error");
						setErrorFocus($("#no_surat_undangan"), $("#role-form"), false);
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
