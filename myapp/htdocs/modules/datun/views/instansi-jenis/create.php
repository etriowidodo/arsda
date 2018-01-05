<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Pengadilan';
		$isNewRecord = 1;
		$model = array();
	} else{
		$this->title = 'Ubah Pengadilan';
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
					url		: '<?php echo Yii::$app->request->baseUrl.'/datun/pengadilan/cekwilayah'; ?>',
					data	: { q1 : $("input[name='tingkat']:checked").val(), q2 : $("#propinsi").val(), q3 : $("#kabupaten").val(), isNewRecord: $("#isNewRecord").val()},
					cache	: false,
					dataType: 'json',
					success : function(data){ 
						if(data.hasil){
							$("body").removeClass("loading");
							$("#labelTingkat").next().html("Pengadilan sudah ada");
						} else{
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
