<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah User';
		$this->params['breadcrumbs'][] = $this->title;
		$model 	= array();
		$act 	= 1;
	} else{
		$this->title = 'Ubah User';
		$this->params['breadcrumbs'][] = $this->title;
		$act = 0;
	}
?>
<div class="role-create">
	<?php echo $this->render('_form', ['model' => $model, 'isNewRecord'=>$act]); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#role-form').validator({disable:false})
		.on('submit', function(e){
			if(!e.isDefaultPrevented()){
				$("body").addClass("loading");
				$.ajax({
					type	: "POST",
					url		: '<?php echo Yii::$app->request->baseUrl.'/autentikasi/user/cekusername'; ?>',
					data	: { q1 : $("#username").val(), q2 : $("#kode_tk").val(), q3 : $("#kode_kejati").val(), 
								q4 : $("#kode_kejari").val(), q5 : $("#kode_cabjari").val(), isNewRecord : $("#act").val() },
					cache	: false,
					dataType: 'json',
					success : function(data){ 
						if(data.hasil){
							$("body").removeClass("loading");
							$("#username").next().html("Username sudah ada");
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
