<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Register Bantuan Hukum';
		$isNewRecord = 1;
		$model 	= array();
	} else{
		$this->title = 'Register Bantuan Hukum';
		$isNewRecord = 0;
		$model['tgl_pemohon'] 	= ($model['tanggal_permohonan'])?date("d-m-Y", strtotime($model['tanggal_permohonan'])):"";
		$model['tgl_diterima'] 	= ($model['tanggal_diterima'])?date("d-m-Y", strtotime($model['tanggal_diterima'])):"";
		$model['tgl_panggilan'] = ($model['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($model['tanggal_panggilan_pengadilan'])):"";
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
			if($("input[name='nm_ins[]']").length == 0){
				bootbox.confirm({ 
					message: "Tabel Tergugat/Turut Tergugat masih kosong, apakah anda ingin tetap menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							$(".bootbox-confirm").modal('hide');
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
		var filenya = $("#file_permohonan")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file permohonan. Apakah anda yakin ingin tetap menyimpan data?",
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
		var filenya = $("#file_permohonan")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tgl_pm 	= new Date(tgl_auto($("#tgl_permohonan").val()));
		var tgl_dt 	= new Date(tgl_auto($("#tgl_diterima").val()));
		var tgl_pn 	= new Date(tgl_auto($("#tgl_panggilan").val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2, #error_custom3, #error_custom4, #error_custom5").html('');
		$("#error_custom6, #error_custom7, #error_custom8, #error_custom9, #error_custom10").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if($("#jns_instansi").val() != '01' && $("#jns_instansi").val() != '06' && $("#no_surat").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom_no_surat").html('<span style="color:#dd4b39; font-size:12px;">No Surat Permohonan belum diisi</span>');
			setErrorFocus($("#error_custom_no_surat"), $("#role-form"), false);
			return false;
		} else if($("#nama_instansi").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom1").html('<span style="color:#dd4b39; font-size:12px;">Nama Instansi belum diisi</span>');
			setErrorFocus($("#error_custom1"), $("#role-form"), false);
			return false;
		} else if($("#wilayah").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom2").html('<span style="color:#dd4b39; font-size:12px;">Wilayah Instansi belum diisi</span>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if($("#status_pemohon").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom3").html('<span style="color:#dd4b39; font-size:12px;">Status pemohon belum dipilih</span>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if($("#nama_pengadilan").val() == ''){
			$("body").removeClass("loading");
			$("#error_custom4").html('<span style="color:#dd4b39; font-size:12px;">Asal panggilan belum diisi</span>');
			setErrorFocus($("#error_custom4"), $("#role-form"), false);
			return false;
		} else if($("input[name='nm_lawan[]']").length == 0){
			$("body").removeClass("loading");
			$("#error_custom5").html('<i style="color:#dd4b39; font-size:12px;">* Lawan pemohon masih kosong</i>');
			setErrorFocus($("#error_custom5"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom6").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom6").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom6"), $("#role-form"), false);
			return false;
		} else if(tgl_pm > tgl_dt){
			$("body").removeClass("loading");
			$("#error_custom7").html('<i style="color:#dd4b39; font-size:12px;">Tanggal permohonan tidak boleh lebih dari tanggal diterima</i>');
			setErrorFocus($("#tgl_permohonan"), $("#role-form"), false);
			return false;
		} else if(tgl_dt > hariIni){
			$("body").removeClass("loading");
			$("#error_custom8").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal diterima adalah hari ini</i>');
			setErrorFocus($("#tgl_diterima"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/cekpermohonan'; ?>',
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
/*}  else if(tgl_dt !='' && tgl_dt < tgl_pn){
	$("body").removeClass("loading");
	$("#error_custom8").html('<i style="color:#dd4b39; font-size:12px;">Tanggal diterima tidak boleh lebih kecil dari tanggal panggilan</i>');
	setErrorFocus($("#tgl_diterima"), $("#role-form"), false);
	return false;
} */ 

</script>
