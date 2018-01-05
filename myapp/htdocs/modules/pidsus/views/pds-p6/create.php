<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah P-6';
		$isNewRecord = 1;
		$model 	= array();
	} else{
		$this->title = 'Ubah P-6';
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
		var tgl_p6 	= new Date(tgl_auto($("#tgl_p6").val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$(".with-errors").html("");
		if($("#nama_jaksa").val() == "" || $("#nip_jaksa").val() == ""){
			$("body").removeClass("loading");
			$("#error_custom_nama_jaksa").html('<i style="color:#dd4b39; font-size:12px;">Nama jaksa belum dipilih</i>');
			setErrorFocus($("#nama_jaksa"), $("#role-form"), false);
			return false;
		} else if(tgl_p6 > hariIni){
			$("body").removeClass("loading");
			$("#error_custom_tgl_p6").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal P-6 adalah hari ini</i>');
			setErrorFocus($("#tgl_p6"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}

});
</script>
