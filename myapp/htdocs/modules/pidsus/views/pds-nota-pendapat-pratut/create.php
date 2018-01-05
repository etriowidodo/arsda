<?php
	use yii\helpers\Html;
	if($model->isNewRecord){
		$this->title = 'Tambah Nota Pendapat T-4';
		$isNewRecord = 1;
	} else{
		$this->title = 'Ubah Nota Pendapat T-4';
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
			if($("input[name='jaksa[]']").length == 0){
				bootbox.confirm({ 
					message: "Tabel Jaksa masih kosong. Apakah anda ingin tetap menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							$(".bootbox-confirm").modal('hide');
							validasi_upload();
							return false;
						}
					}
				});
				return false;
			}else{
				validasi_upload();
				return false;
			}
		}
	});
        
        function validasi_upload(){
		$("body").addClass("loading");
		$(".with-errors").html("");
                var tgl_minta_perpanjang= new Date(tgl_auto($("#tgl_minta_perpanjang").val()));
                var tgl_nota 	= new Date(tgl_auto($("#tgl_nota").val()));
		var hariIni 	= new Date('<?php echo date('Y-m-d');?>');
		var tgl_awal_penahanan_oleh_penyidik 	= new Date(tgl_auto($("#tgl_awal_penahanan_oleh_penyidik").val()));
		var tgl_akhir_penahanan_oleh_penyidik 	= new Date(tgl_auto($("#tgl_akhir_penahanan_oleh_penyidik").val()));
		var tgl_awal_permintaan_perpanjangan 	= new Date(tgl_auto($("#tgl_awal_permintaan_perpanjangan").val()));
		var tgl_akhir_permintaan_perpanjangan 	= new Date(tgl_auto($("#tgl_akhir_permintaan_perpanjangan").val()));
                
                if(tgl_nota > hariIni){
                    $("body").removeClass("loading");
                    $("#error_custom_tglnota").html('<i style="color:#dd4b39; font-size:12px;">Maximal tanggal nota adalah hari ini</i>');
                    setErrorFocus($("#tgl_nota"), $("#role-form"), false);
                    return false;
		}else if(tgl_minta_perpanjang > tgl_nota){
                    $("body").removeClass("loading");
                    $("#error_custom_tglnota").html('<i style="color:#dd4b39; font-size:12px;">Tanggal nota lebih kecil dari tanggal permintaan perpanjangan</i>');
                    setErrorFocus($("#tgl_nota"), $("#role-form"), false);
                    return false;
		}else if(tgl_awal_penahanan_oleh_penyidik > tgl_akhir_penahanan_oleh_penyidik){
                    $("body").removeClass("loading");
                    $("#error_custom_tgl_akhir_penahanan_oleh_penyidik").html('<i style="color:#dd4b39; font-size:12px;">Tanggal akhir penahanan lebih kecil dari tanggal awal penahanan</i>');
                    setErrorFocus($("#tgl_akhir_penahanan_oleh_penyidik"), $("#role-form"), false);
                    return false;
		}else if(tgl_awal_permintaan_perpanjangan > tgl_akhir_permintaan_perpanjangan){
                    $("body").removeClass("loading");
                    $("#error_custom_tgl_akhir_permintaan_perpanjangan").html('<i style="color:#dd4b39; font-size:12px;">Tanggal akhir permintaan perpanjangan lebih kecil dari tanggal awal permintaan</i>');
                    setErrorFocus($("#tgl_akhir_permintaan_perpanjangan"), $("#role-form"), false);
                    return false;
		}else{
                    $.ajax({
                            type	: "POST",
                            url	: '<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-nota-pendapat-pratut/cekmintaperpanjangan'; ?>',
                            data	: $("#role-form").serialize(),
                            cache	: false,
                            dataType: 'json',
                            success : function(data){ 
                                    if(!data.hasil){
                                            $("body").removeClass("loading");
                                            $("#"+data.element).html(data.error);
                                            setErrorFocus($("#"+data.element), $("#role-form"), false);
                                    } else{
                                            $('#role-form').validator('destroy').off("submit");
                                            $('#role-form').submit();
                                    }
                            }
                    });
                    return false;
                }
	}

});
</script>
