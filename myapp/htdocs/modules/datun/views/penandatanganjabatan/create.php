<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Penandatangan Jabatan';
		$this->params['breadcrumbs'][] = $this->title;
	} else{
		$this->title = 'Ubah Penandatangan Jabatan';
		$this->params['breadcrumbs'][] = $this->title;
	}
?>

<div class="role-create">
	<?php echo $this->render('_form', [
		'model' 	=> $model,
		'searchJPU' => $searchJPU,
        'dataJPU' 	=> $dataJPU,
		'kode'      => $kode,
		]); ?>
</div>

<div class="modal-loading-new"></div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#role-form').validator({disable:false})
		.on('submit', function(e){
			if(!e.isDefaultPrevented()){
				$("body").addClass("loading");
				$.ajax({
					type	: "POST",
					url		: '<?php echo Yii::$app->request->baseUrl.'/datun/penandatanganjabatan/cekrole'; ?>',
					data	: { q1 : $("#nip_jbt").val(), q2 : $("#kode1").val(), q3 : $("#stat").val() },
					cache	: false,
					dataType: 'json',
					success : function(data){
						if(data.hasil){
							$("body").removeClass("loading");
							$("#nip_jbt").next().html("nip sudah ada").css('color', 'red');;
						} else{
							$('#role-form').validator('destroy').off("submit");
							$('#role-form').submit();
						}
					}
				});
				return false;
			}
		});
		
		/* $("select#modul").change(function(){
			$("body").addClass("loading");
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/penandatangan/getmenu'; ?>',
				data	: { q1 : $("select#modul").val() },
				cache	: false,
				success : function(data){ 
					$("#preview-menu").html(data);
					$("body").removeClass("loading");
					return false;
				}
			});
		}); */
		
		$("#preview-menu").on("ifChecked", "input[name=allCheck]", function(){
			$(".chkp").iCheck("check");
		}).on("ifUnchecked", "input[name=allCheck]", function(){
			$(".chkp").iCheck("uncheck");
		});
		$("#preview-menu").on("ifChecked", "input[name=allCheckT]", function(){
			$(".chkpT").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=allCheckT]", function(){
			$(".chkpT").not(':disabled').iCheck("uncheck");
		});
		$("#preview-menu").on("ifChecked", "input[name=allCheckU]", function(){
			$(".chkpU").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=allCheckU]", function(){
			$(".chkpU").not(':disabled').iCheck("uncheck");
		});
		$("#preview-menu").on("ifChecked", "input[name=allCheckH]", function(){
			$(".chkpH").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=allCheckH]", function(){
			$(".chkpH").not(':disabled').iCheck("uncheck");
		});
		$("#preview-menu").on("ifChecked", "input[name=allCheckC]", function(){
			$(".chkpC").not(':disabled').iCheck("check");
		}).on("ifUnchecked", "input[name=allCheckC]", function(){
			$(".chkpC").not(':disabled').iCheck("uncheck");
		});
		$("#preview-menu").on("ifChecked", ".chkp", function(){
			var elem = $(this).attr("id").split("cek")[1];
			$("#cekT"+elem+", #cekU"+elem+", #cekH"+elem+", #cekC"+elem+"").iCheck('enable');
			var a = String($(this).data("tree"));
			var b = a.substring(0,3);
			var c = "";
			while(b > 0){
				c = a.substring(0, b);
				$('.chkp[data-tree="'+c+'"]').iCheck("check");
				b = c.lastIndexOf(".");
			}
		}).on("ifUnchecked", ".chkp", function(){
			var elem = $(this).attr("id").split("cek")[1];
			$("#cekT"+elem+", #cekU"+elem+", #cekH"+elem+", #cekC"+elem+"").iCheck('disable');
			var a = String($(this).data("tree"));
			$('.chkp[data-tree^="'+a+'."]').iCheck("uncheck");
		});
		$('#myPjaxForm').on('pjax:send', function(e){
			$("body").addClass("loading");
		}).on('pjax:success', function(e){
			$("body").removeClass("loading");
		});
	});
</script>
