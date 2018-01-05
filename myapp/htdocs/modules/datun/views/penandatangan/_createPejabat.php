<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Pejabat';
		$isNewRecord = 1;
		$model = array();
		$model['kode'] 		= $arrTtd['kode'];
		$model['kode_tk'] 	= $arrTtd['kode_tk'];
	} else{
		$this->title = 'Ubah Pejabat';
		$isNewRecord = 0;
	}
?>
<h3 style="margin:0 0 10px; font-size:16px; font-family:arial;"><b><?php echo 'Penandatangan '.$arrTtd['deskripsi'];?></b></h3>
<div class="role-create">
	<?php echo $this->render('_formPejabat', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#role-form').validator({disable:false})
		.on('submit', function(e){
			if(!e.isDefaultPrevented()){
				$("body").addClass("loading");
				$.ajax({
					type	: "POST",
					url		: '<?php echo Yii::$app->request->baseUrl.'/datun/penandatangan/cekpejabat'; ?>',
					data	: $("#role-form").serialize(),
					cache	: false,
					dataType: 'json',
					success : function(data){ 
						if(data.hasil){
							$("body").removeClass("loading");
							$(".with-errors").eq(0).html("Pegawai sudah ada untuk penandatangan jabatan ini");
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
