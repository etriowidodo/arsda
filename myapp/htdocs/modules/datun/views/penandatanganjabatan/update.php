<?php
	use yii\helpers\Html;
	
		$this->title = 'Ubah Penandatangan Pejabat';
		$this->params['breadcrumbs'][] = $this->title;
		
?>

<div class="role-update">
	<?php echo $this->render('_form', [
		'model' 	=> $model,
		'searchJPU' => $searchJPU,
        'dataJPU' 	=> $dataJPU,
		'kodeTK'    => $kodeTK,
		'kode'      => $kode,
		'nip'       => $nip,
		'sts'       => $sts,
		'nmtd'      => $nmtd,
		'jbtd'	    => $jbtd,
		'pktd'  	=> $pktd,
		]); ?>
</div>
<div class="modal-loading-new"></div>

<script type="text/javascript">
	$(document).ready(function(){
	
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
