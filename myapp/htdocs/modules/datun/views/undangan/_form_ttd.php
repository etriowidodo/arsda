<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\TahapBantuanHukum;
	$isNewRecord 	= ($model['nama'] == '')?1:0;
	$this->title 	= ($isNewRecord)?'Tambah Tanda Terima':'Ubah Tanda Terima';
	$tgl_undangan 	= ($model['tanggal_surat_undangan'])?date("d-m-Y", strtotime($model['tanggal_surat_undangan'])):"";
	$tgl_ttd 		= ($model['tanggal_tanda_terima'])?date("d-m-Y", strtotime($model['tanggal_tanda_terima'])):"";
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/undangan/simpanttd" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Surat Undangan</label>        
        			<div class="col-md-8">
						<input type="text" id="no_surat_undangan" name="no_surat_undangan" class="form-control" value="<?php echo $model['no_surat_undangan'];?>" readonly />
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-3">Tanggal Surat</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tgl_undangan" name="tgl_undangan" class="form-control" value="<?php echo $tgl_undangan;?>" readonly />
                        </div>
                    </div>
        		</div>
        	</div>
        </div>
	</div>
</div>

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Penerima</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama</label>
        			<div class="col-md-8">
            			<input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama']; ?>" required data-error="Nama belum diisi" />
                        <div class="help-block with-errors"></div>
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control datepicker" id="tanggal_tanda_terima" name="tanggal_tanda_terima" value="<?php echo $tgl_ttd;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal Belum diisi" />
                        </div>						
                    </div>
                    <div class="col-md-offset-3 col-md-8"><div class="help-block with-errors" id="error_custom1"></div></div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Pekerjaan</label>
        			<div class="col-md-8">
						<input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan']; ?>" required data-error="Pekerjaan belum diisi" />             		
                        <div class="help-block with-errors"></div>
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-3">Hari</label>
        			<div class="col-md-4">
            			<input type="text" id="hari" name="hari" class="form-control" value="<?php echo $model['hari'];?>" readonly />
            		</div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Hubungan dgn yg diundang</label>
        			<div class="col-md-8">
            			<input type="text" name="hubungan" id="hubungan" value="<?php echo $model['hubungan_dengan_su']; ?>" class="form-control" required data-error="Hubungan dengan yang diundang belum diisi" />
                        <div class="help-block with-errors"></div>
            		</div>
            	</div>
			</div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Jam</label>        
                    <div class="col-md-3">
                        <div class="input-group bootstrap-timepicker">
                            <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                            <input type="text" name="jam" id="jam" value="<?php echo $model['jam']; ?>" class="form-control timepicker" required data-error="Jam Belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-3 col-md-8"><div class="help-block with-errors"></div></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Alamat</label>
                    <div class="col-md-8">
                        <textarea style="height:90px;" name="alamat" id="alamat" class="form-control" required data-error="Alamat belum diisi"><?php echo $model['alamat']; ?></textarea>						
                        <div class="help-block with-errors"></div>
            		</div>
            	</div>
            </div>
        </div>
	</div>
</div>
        
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_ttd" id="file_ttd" class="form-inputfile" />                    
                <label for="file_ttd" class="label-inputfile">
                    <?php 
                        $tmpPathnya = ($model['jns_undangan'] == 1)?Yii::$app->params['s4_siap']:Yii::$app->params['s4_sidang'];
						$pathFile 	= $tmpPathnya.$model['file_ttd'];
                        $labelFile 	= 'Upload File Tanda Terima';
                        if($model['file_ttd'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Tanda Terima';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_ttd']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_ttd'], strrpos($model['file_ttd'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_ttd'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom2"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="jns_undangan" id="jns_undangan" value="<?php echo $model['jns_undangan']; ?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
	<a href="/datun/undangan/index" class="btn btn-danger">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>

<style>
	h3.box-title{
		font-weight: bold;
	}
	.form-horizontal .form-group-sm .control-label{
		font-size: 12px;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
		font-size: 12px;
	}
	.select2-search--dropdown .select2-search__field{
		font-family: arial;
		font-size: 11px;
		padding: 4px 3px;
	}
	.form-group-sm .select2-container > .selection,
	.select2-results__option{
		font-family: arial;
		font-size: 11px;
	}
	fieldset.scheduler-border{
		border: 1px solid #ddd;
		margin:0;
		padding:10px;
	}
	legend.scheduler-border{
		border-bottom: none;
		width: inherit;
		margin:0;
		padding:0px 5px;
		font-size: 14px;
		font-weight: bold;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});

	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});

	$("#jam").on('focus', function(){
		$(this).prev().trigger('click');
	});

	$("#tanggal_tanda_terima").on('change', function(){
		var nilai = $(this).val();
		var arrHr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
		var hari  = ""; 
		if(nilai != ""){
			var n = new Date(tgl_auto(nilai));
			hari = arrHr[n.getDay()];
		}
		$("#hari").val(hari);
	});

	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			validasi_upload();
			return false;
		}
	});

	function validasi_upload(){
		$("body").addClass("loading");
		var filenya = $("#file_ttd")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var tglUnd 	= new Date(tgl_auto($("#tgl_undangan").val()));
		var tglTtd 	= new Date(tgl_auto($("#tanggal_tanda_terima").val()));
		var hariIni = new Date('<?php echo date('Y-m-d');?>');

		$("#error_custom1, #error_custom2").html('');
		if(typeof(filenya) != 'undefined'){
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		}

		if(tglTtd < tglUnd){
			$("body").removeClass("loading");
			$("#error_custom1").html('<span style="color:#dd4b39; font-size:12px;">Tanggal tanda terima lebih kecil daripada tanggal surat undangan</span>');
			setErrorFocus($("#error_custom1"), $("#role-form"), false);
			return false;
		} else if(tglTtd > hariIni){
			$("body").removeClass("loading");
			$("#error_custom1").html('<span style="color:#dd4b39; font-size:12px;">Maximal tanggal tanda terima adalah hari ini</span>');
			setErrorFocus($("#error_custom1"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}
});

</script>
