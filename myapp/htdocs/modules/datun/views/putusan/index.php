<?php use yii\helpers\Html; ?>
<div class="role-create"><?php echo $this->render('_form', ['model'=>$model,'head'=>$head]); ?></div>
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
			var filenya 	= $("#file_template")[0].files[0]; 
			var cek		= $("#cek_file").val();
			var msg="";
			var msg1="";
			
		//	if(amar_putusan == '' || (cek == 0 && typeof(filenya) == 'undefined') ){
			if(cek == 0 && typeof(filenya) == 'undefined'){
				/* if (amar_putusan=='') {
					msg+="Text editor amar", msg1+=" dan ";
				} 
				if (cek == 0 && typeof(filenya) == 'undefined') {
					msg+=msg1+"File";
				} */
			
				msg+="File putusan masih kosong, Apakah anda tetap ingin menyimpan data?";
				
				
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
		var filenya 	= $("#file_template")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 		= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tgl_skks	= ($("#tanggal_skks").val())? new Date(tgl_auto($("#tanggal_skks").val())): new Date(tgl_auto($("#tanggal_skk").val()));
		var war			= ($("#tanggal_skks").val())?'SKKS':'SKK';
		var tgl_putusan	= new Date(tgl_auto($("#tanggal_putusan").val()));
		var tgl_terima_jpn	= new Date(tgl_auto($("#tanggal_terima_jpn").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		
		$("#error_custom1, #error_custom2,#error_custom3,#error_custom4").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}
		
		if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(tgl_putusan < tgl_skks){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">Tanggal putusan harus lebih besar atau sama dengan tanggal '+war+'</i>');
			setErrorFocus($("#tanggal_putusan"), $("#role-form"), false);
			return false;
		} else if(tgl_putusan > hariIni){
			$("body").removeClass("loading");
			$("#error_custom1").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal putusan adalah hari ini</i>');
			setErrorFocus($("#tanggal_putusan"), $("#role-form"), false);
			return false;
		} 
		else if(tgl_terima_jpn < tgl_putusan){
			$("body").removeClass("loading");
			$("#error_custom4").html('<i style="color:#dd4b39; font-size:12px;">Tanggal terima JPN harus lebih besar atau sama dengan tanggal putusan</i>');
			setErrorFocus($("#tanggal_terima_jpn"), $("#role-form"), false);
			return false;
		} else if(tgl_terima_jpn > hariIni){
			$("body").removeClass("loading");
			$("#error_custom4").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal terima JPN adalah hari ini</i>');
			setErrorFocus($("#tanggal_terima_jpn"), $("#role-form"), false);
			return false;
		}
		else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/putusan/cekputusan'; ?>',
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
