<?php
	use yii\helpers\Html;
	if($model['isNewRecord']){
		$this->title = 'Tambah Penerimaan Berkas';
		$isNewRecord = 1;
	} else{
		$this->title = 'Ubah Penerimaan Berkas';
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
			var tabel = $("#table_pengantar > tbody");
			var cekin = tabel.find(".waktu_kejadian0").length;
			if(cekin == 0){
				bootbox.confirm({ 
					message: "Tabel Pengantar masih kosong. Apakah anda ingin tetap menyimpan data?",
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
		var tgl_terima 	= new Date(tgl_auto($("#tgl_terima").val()));
		var tgl_berkas 	= new Date(tgl_auto($("#tgl_berkas").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		$(".with-errors").html("");

		if(tgl_berkas < tgl_terima){
			$("body").removeClass("loading");
			$("#error_custom_tgl_berkas").html('<i style="color:#dd4b39; font-size:12px;">Tanggal berkas tidak boleh lebih kecil daripada tanggal terima SPDP</i>');
			setErrorFocus($("#tgl_berkas"), $("#role-form"), false);
			return false;
		} else{
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-terima-berkas/cekberkas'; ?>',
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
