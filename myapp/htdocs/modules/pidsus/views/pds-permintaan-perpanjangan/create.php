<?php
	use yii\helpers\Html;
	if(!$model['no_minta_perpanjang']){
		$this->title = 'Tambah Permintaan Perpanjangan Penahanan';
		$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
		$isNewRecord = 1;
	} else{
		$this->title = 'Ubah Permintaan Perpanjangan Penahanan';
		$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
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
                    var tabel = $('#table_tersangka > tbody').find('tr:last');
                    if(tabel.length == 0){
                        bootbox.alert({
                                message: "Silahkan isi tersangka terlebih dahulu",
                                size: 'small',
                                callback: function(){
                                        $("#tersangka").focus();
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
		var filenya 	= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		= [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		//var tgl_spdp 	= new Date(tgl_auto($("#tgl_spdp").val()));
		//var tgldittd 	= new Date(tgl_auto($("#tgldittd").val()));
		var tgl_minta_perpanjang = new Date(tgl_auto($("#tgl_minta_perpanjang").val()));
		var tgl_surat_penahanan = new Date(tgl_auto($("#tgl_surat_penahanan").val()));
		var tgl_terima = new Date(tgl_auto($("#tgl_terima").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
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
		} else if($("#nama").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom_tersangka").html('<i style="color:#dd4b39; font-size:12px;">Tersangka belum dipilih</i>');
			setErrorFocus($("#nama"), $("#role-form"), false);
			return false;
                } else if(tgl_minta_perpanjang > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_minta_perpanjang").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal permintaan adalah hari ini</i>');
			setErrorFocus($("#tgl_minta_perpanjang"), $("#role-form"), false);
			return false;
		} else if(tgl_surat_penahanan > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_surat_penahanan").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal surat perintah penahanan adalah hari ini</i>');
			setErrorFocus($("#tgl_surat_penahanan"), $("#role-form"), false);
			return false;
                } else if(tgl_minta_perpanjang > tgl_surat_penahanan){
			$("body").removeClass("loading");
			$("#error_custom_tgl_surat_penahanan").html('<i style="color:#dd4b39; font-size:12px;">Tanggal surat perintah penahanan lebih kecil dari tanggal permintaan</i>');
			setErrorFocus($("#tgl_surat_penahanan"), $("#role-form"), false);
			return false;
                } else if(tgl_terima > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_terima").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal terima adalah hari ini</i>');
			setErrorFocus($("#tgl_terima"), $("#role-form"), false);
			return false;
                } else if(tgl_surat_penahanan > tgl_terima){
			$("body").removeClass("loading");
			$("#error_custom_tgl_terima").html('<i style="color:#dd4b39; font-size:12px;">Tanggal terima lebih kecil dari tanggal surat perintah penahanan</i>');
			setErrorFocus($("#tgl_terima"), $("#role-form"), false);
			return false;
		/*} else if(tgl_spdp > tgldittd){
			$("body").removeClass("loading");
			$("#error_custom_tgldittd").html('<i style="color:#dd4b39; font-size:12px;">Tanggal dikeluarkan lebih kecil dari tanggal SPDP</i>');
			setErrorFocus($("#tgldittd"), $("#role-form"), false);
			return false;
		} else if(tgldittd > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgldittd").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal dikeluarkan adalah hari ini</i>');
			setErrorFocus($("#tgldittd"), $("#role-form"), false);
			return false;*/
		} else{
			$.ajax({
				type	: "POST",
				url	: '<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-permintaan-perpanjangan/cekmintapanjang'; ?>',
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
