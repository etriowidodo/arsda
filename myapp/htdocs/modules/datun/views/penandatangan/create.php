<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Penandatangan';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Penandatangan';
		$isNewRecord = 0;
	}
?>
<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#role-form').validator({disable:false})
		.on('submit', function(e){
			if(!e.isDefaultPrevented()){
				$("body").addClass("loading");
				$.ajax({
					type	: "POST",
					url		: '<?php echo Yii::$app->request->baseUrl.'/datun/penandatangan/cekrole'; ?>',
					data	: { q1 : $("#kd_ttd").val(), isNewRecord:$("#isNewRecord").val() },
					cache	: false,
					dataType: 'json',
					success : function(data){
						if(data.hasil){
							$("body").removeClass("loading");
							$(".with-errors").eq(0).html("Kode sudah ada").parents(".form-group").addClass("has-error");
						} else{
							$(".with-errors").eq(0).html("").parents(".form-group").removeClass("has-error");
							$('#role-form').validator('destroy').off("submit");
							$('#role-form').submit();
						}
					}
				});
				return false;
			}
		});
		$('#myPjaxForm').on('pjax:send', function(e){
			$("body").addClass("loading");
		}).on('pjax:success', function(e){
			$("body").removeClass("loading");
		});
	});
</script>
