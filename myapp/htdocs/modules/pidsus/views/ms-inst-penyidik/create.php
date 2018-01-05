<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Instansi Penyidik';
		$isNewRecord = 1;
		$model 	= array();
	} else{
		$this->title = 'Ubah Instansi Penyidik';
		$isNewRecord = 0;
	}
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
			$("body").addClass("loading");
			$.ajax({
				type	: "POST",
				url	: '<?php echo Yii::$app->request->baseUrl.'/pidsus/ms-inst-penyidik/cekttdjabatan'; ?>',
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.hasil){
						$("body").removeClass("loading");
						$("#kodenya").html('<span style="color:#dd4b39;">Kode sudah ada</span>').parents(".form-group").addClass("has-error");
						setErrorFocus($("#kode_ip"), $("#role-form"), true);
					} else{
						$('#role-form').validator('destroy').off("submit");
						$('#role-form').submit();
					}
				}
			});
			return false;
		}
	});
    });
</script>
