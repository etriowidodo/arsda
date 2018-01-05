<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Pejabat (Tandatangan)';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Pejabat (Tandatangan)';
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
				url		: "/pidsus/ttd-pejabat/cekttdpejabat",
				data	: $("#role-form").serialize(),
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.hasil){
						$("body").removeClass("loading");
						$("#pejabatnya").html('<span style="color:#dd4b39;">Pejabat sudah ada</span>').parents(".form-group").addClass("has-error");
						setErrorFocus($("#pejabatnya"), $("#role-form"), false);
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
