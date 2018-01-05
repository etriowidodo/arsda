<?php use yii\helpers\Html; ?>
<div class="role-create"><?php echo $this->render('_form', ['model'=>$model, 'head'=>$head]); ?></div>
<div class="modal-loading-new"></div>
<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}
			var amar 		= $('#tab_amar').val();
			var filenya 	= $("#file_template")[0].files[0]; 
			var cek			= $("#cek_file").val();
			var msg="";
			var msg1="";
			
			if(amar == '' || (cek == 0 && typeof(filenya) == 'undefined')){
				if (amar=='') { 
					msg+="Text editor amar", msg1+=" dan ";
				} 
				if (cek == 0 && typeof(filenya) == 'undefined') {
					msg+=msg1+"File";
				}
				msg+=" putusan kontra PK masih kosong, Apakah anda tetap ingin menyimpan data?";
				bootbox.confirm({ 
					message: msg,
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							bootbox.hideAll();
							validasi_upload();
							return false;
						}
					}
				});	
			} else{
				validasi_upload();
				return false;
			}
			return false;
		}
	});

	function validasi_upload(){ 
		$("body").addClass("loading");
		var filenya 			= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 				= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tgl_putusan			= new Date(tgl_auto($("#tanggal_putusan").val()));
		var tgl_kontra_pk		= new Date(tgl_auto($("#tanggal_pts_kontrapk").val()));
		var hariIni 			= new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2, #error_custom3, #error_custom4, #error_custom5").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom3").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom3"), $("#role-form"), false);
			return false;
		} else if(tgl_kontra_pk < tgl_putusan){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">Tanggal putusan kontra PK harus lebih besar atau sama dengan tanggal putusan</i>');
			setErrorFocus($("#tanggal_pts_kontrapk"), $("#role-form"), false);
			return false;
		} else if(tgl_kontra_pk > hariIni){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal putusan kontra PK adalah hari ini</i>');
			setErrorFocus($("#tanggal_pts_kontrapk"), $("#role-form"), false);
			return false;
		} else {
				$.ajax({
						type	: "POST",
						url		: '<?php echo Yii::$app->request->baseUrl.'/datun/putusan-kontrapk/cek'; ?>',
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
