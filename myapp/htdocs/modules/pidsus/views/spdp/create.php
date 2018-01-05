<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah SPDP';
		$isNewRecord = 1;
		$model 	= array();
	} else{
		$this->title = 'Ubah SPDP';
		$isNewRecord = 0;
		$model['tgl_sprindik'] = ($model['tgl_sprindik'])?date("d-m-Y", strtotime($model['tgl_sprindik'])):"";
		$model['tgl_spdp'] 	 = ($model['tgl_spdp'])?date("d-m-Y", strtotime($model['tgl_spdp'])):"";
		$model['tgl_terima'] = ($model['tgl_terima'])?date("d-m-Y", strtotime($model['tgl_terima'])):"";
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
			if($("input[name='tersangka[]']").length == 0){
				bootbox.confirm({ 
					message: "Tabel Tersangka masih kosong, apakah anda ingin tetap menyimpan data?",
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
		var filenya 	= $("#file_permohonan")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		= [".doc", ".docx", ".pdf", ".jpg", ".jpeg"];
		var tgl_sprin 	= new Date(tgl_auto($("#tgl_sprindik").val()));
		var tgl_spdp 	= new Date(tgl_auto($("#tgl_spdp").val()));
		var tgl_terima 	= new Date(tgl_auto($("#tgl_terima").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		
		var millisecondsPerDay = 86400 * 1000;
		tgl_sprin.setHours(0,0,0,1);
		tgl_terima.setHours(23,59,59,999);
		var diff = tgl_terima - tgl_sprin;
		var days = Math.ceil(diff / millisecondsPerDay);

		$(".with-errors").html("");
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom_file_permohonan").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file yang diperbolehkan hanya .doc, .docx, .pdf, dan .jpg</i>');
			setErrorFocus($("#error_custom_file_permohonan"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom_file_permohonan").html('<i style="color:#dd4b39; font-size:12px;">* Ukuran file yang diperbolehkan maksimal 2MB</i>');
			setErrorFocus($("#error_custom_file_permohonan"), $("#role-form"), false);
			return false;
		} else if(tgl_spdp > tgl_terima){
			$("body").removeClass("loading");
			$("#error_custom_tgl_spdp").html('<i style="color:#dd4b39; font-size:12px;">Tanggal SPDP tidak boleh lebih dari tanggal diterima</i>');
			setErrorFocus($("#tgl_spdp"), $("#role-form"), false);
			return false;
		} else if(tgl_sprin > tgl_terima){
			$("body").removeClass("loading");
			$("#error_custom_tgl_sprindik").html('<i style="color:#dd4b39; font-size:12px;">Tanggal Sprindik tidak boleh lebih dari tanggal diterima</i>');
			setErrorFocus($("#tgl_sprindik"), $("#role-form"), false);
			return false;
		} else if(days > 8){
			$("body").removeClass("loading");
			$("#error_custom_tgl_terima").html('<i style="color:#dd4b39; font-size:12px;">Maks. Tanggal Terima 8 hari dari tanggal sprindik</i>');
			setErrorFocus($("#tgl_terima"), $("#role-form"), false);
			return false;
		} else if(tgl_terima > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_terima").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal diterima adalah hari ini</i>');
			setErrorFocus($("#tgl_terima"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/pidsus/spdp/cekspdp'; ?>',
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
		}
	}
});
</script>
