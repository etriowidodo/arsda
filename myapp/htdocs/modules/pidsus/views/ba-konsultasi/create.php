<?php
	use yii\helpers\Html;
	if($model['isNewRecord']){
		$this->title = 'Tambah Berita Acara Konsultasi';
		$isNewRecord = 1;
                $model['id_ba_konsultasi'];
	} else{
		$this->title = 'Ubah Berita Acara Konsultasi';
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
		var tgl_pelaksanaan 	= new Date(tgl_auto($("#tgl_pelaksanaan").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		$(".with-errors").html("");

		if(tgl_pelaksanaan > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tglpelaksanaan").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal pelaksanaan adalah hari ini</i>');
			setErrorFocus($("#tgl_pelaksanaan"), $("#role-form"), false);
			return false;
		}else{
			$.ajax({
				type	: "POST",
				url	: '<?php echo Yii::$app->request->baseUrl.'/pidsus/ba-konsultasi/cekba'; ?>',
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
