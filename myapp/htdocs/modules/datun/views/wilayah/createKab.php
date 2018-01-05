<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Kabupaten';
		$isNewRecord = 1;
		$model = array();
		$model['id_prop'] = $arrProp['id_prop'];
		$model['proptxt'] = $arrProp['id_prop']." | ".$arrProp['deskripsi'];
	} else{
		$this->title = 'Ubah Kabupaten';
		$isNewRecord = 0;
	}
?>
<div class="role-create">
	<?php echo $this->render('_formKab', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#role-form').validator({disable:false})
		.on('submit', function(e){
			if(!e.isDefaultPrevented()){
				$("body").addClass("loading");
				$.ajax({
					type	: "POST",
					url		: '<?php echo Yii::$app->request->baseUrl.'/datun/wilayah/cekkabupaten'; ?>',
					data	: { isNewRecord: $("#isNewRecord").val(), q1 : $("#kode").val(), q2 : $("#kode_kab").val()},
					cache	: false,
					dataType: 'json',
					success : function(data){ 
						if(data.hasil){
							$("body").removeClass("loading");
							$(".with-errors").eq(1).html("Kode Kabupaten sudah ada");
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
