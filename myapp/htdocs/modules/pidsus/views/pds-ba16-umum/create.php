<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$isNewRecord = 1;
		$model 	= array();
	} else{
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
                if($("input[name='nama_saksi[]']").length == 0){
                    bootbox.confirm({ 
                        message: "Tabel Saksi masih kosong. Apakah anda ingin tetap menyimpan data?",
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
		var filenya         = $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt          = [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		var tgl_b4_umum     = new Date(tgl_auto($("#tgl_b4_umum").val()));
		var tgl_ba16_umum   = new Date(tgl_auto($("#tgl_ba16_umum").val()));
		var hariIni         = new Date('<?php echo date('Y-m-d');?>');
		var no_b4_umum      = $("#no_b4_umum").val();
		$(".with-errors").html("");

		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file yang diperbolehkan hanya .doc, .docx, .pdf, dan .jpg</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_template").html('<i style="color:#dd4b39; font-size:12px;">* Ukuran file yang diperbolehkan maksimal 2MB</i>');
			setErrorFocus($("#error_custom_file_template"), $("#role-form"), false);
			return false;
		} else if(no_b4_umum == ""){
			$("body").removeClass("loading");
			$("#error_custom_no_b4_umum").html('<i style="color:#dd4b39; font-size:12px;">Pilih Nomor B-4 Umum</i>');
			setErrorFocus($("#error_custom_no_b4_umum"), $("#role-form"), false);
			return false;
		} else if(tgl_b4_umum > tgl_ba16_umum){
			$("body").removeClass("loading");
			$("#error_custom_tgl_ba16_umum").html('<i style="color:#dd4b39; font-size:12px;">Tanggal BA-16 Umum lebih kecil dari tanggal B-4 Umum</i>');
			setErrorFocus($("#error_custom_tgl_ba16_umum"), $("#role-form"), false);
			return false;
		} else if(tgl_ba16_umum > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_ba16_umum").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal BA-16 Umum adalah hari ini</i>');
			setErrorFocus($("#error_custom_tgl_ba16_umum"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}
});
</script>
