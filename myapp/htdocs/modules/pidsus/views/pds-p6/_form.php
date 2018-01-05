<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsP6;

	$this->subtitle = 'Laporan Terjadinya Tindak Pidana';
	$linkBatal	= '/pidsus/pds-p6/index';
	$linkCetak	= '/pidsus/pds-p6/cetak?no_urut_p6='.$model['no_urut_p6'].'&tgl_p6='.$model['tgl_p6'];
	$tgl_p6 	= ($model['tgl_p6'])?date('d-m-Y',strtotime($model['tgl_p6'])):'';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-p6/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />	
<div class="row">                
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal P-6</label>        
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="tgl_p6" id="tgl_p6" class="form-control datepicker" value="<?php echo $tgl_p6;?>" required data-error="Tanggal belum diisi" />
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa Pembuat Laporan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama</label>        
                            <div class="col-md-8">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="nama_jaksa" id="nama_jaksa" class="form-control" value="<?php echo $model['nama_jaksa'];?>" readonly=""/>
                                    <span class="input-group-btn"><button class="btn" type="button" id="pilih_jaksa">Pilih</button></span>
                                </div>
                                <div class="help-block with-errors" id="error_custom_nama_jaksa"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pangkat</label>        
                            <div class="col-md-8">
                                <input type="text" name="pangkat_jaksa" id="pangkat_jaksa" class="form-control" value="<?php echo $model['pangkat_jaksa'];?>" readonly />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">NIP</label>        
                            <div class="col-md-8">
                                <input type="text" name="nip_jaksa" id="nip_jaksa" class="form-control" value="<?php echo $model['nip_jaksa'];?>" readonly />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Jabatan</label>        
                            <div class="col-md-8">
                                <input type="text" name="jabatan_jaksa" id="jabatan_jaksa" class="form-control" value="<?php echo $model['jabatan_jaksa'];?>" readonly />
                                <input type="hidden" name="gol_jaksa" id="gol_jaksa" value="<?php echo $model['gol_jaksa'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pelaporan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Melaporkan Kepada</label>        
                            <div class="col-md-8">
                                <input type="text" name="melaporkan_kepada" id="melaporkan_kepada" class="form-control" value="<?php echo $model['melaporkan_kepada'];?>" maxlength="150"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Diterima dari</label>        
                            <div class="col-md-8">
                                <input type="text" name="melaporkan_dari" id="melaporkan_dari" class="form-control" value="<?php echo $model['melaporkan_dari'];?>" maxlength="150"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-pemberi-kuasa">
            <div class="box-header with-border">
                <h3 class="box-title">Tentang Tindak Pidana</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea id="tindak_pidana" name="tindak_pidana" class="form-control" style="height:90px;" maxlength="255"><?php echo $model['tindak_pidana'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-pemberi-kuasa">
            <div class="box-header with-border">
                <h3 class="box-title">Diduga dilakukan oleh</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea id="dilakukan_oleh" name="dilakukan_oleh" class="form-control" style="height:90px;" maxlength="150"><?php echo $model['dilakukan_oleh'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-pemberi-kuasa">
            <div class="box-header with-border">
                <h3 class="box-title">Kasus Posisi</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea id="kasus_posisi" name="kasus_posisi" class="form-control" style="height:90px;" maxlength="255"><?php echo $model['kasus_posisi'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>			
    </div>
</div>
		
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Jaksa</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

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
	/* START AMBIL JAKSA */
        localStorage.clear();
        $("#pilih_jaksa").on("click", function(){
		$("#jpn_modal").find(".modal-body").html("");
		$("#jpn_modal").find(".modal-body").load("/pidsus/get-jpu/index",function(){
                    $('#selection_all_jpn').remove();
                    $(".selection_one_jpn").prop("type", "radio");
                });
		$("#jpn_modal").modal({backdrop:"static"});
	});

	$("#jpn_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#jpn-jpn-modal td:not(.aksinya)", function(){
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('#');
                $('#nip_jaksa').val(param[0]);
                $('#nama_jaksa').val(param[1]);
                $('#pangkat_jaksa').val(param[2]);
                $('#gol_jaksa').val(param[3]);
                $('#jabatan_jaksa').val(param[5]);
                $("#jpn_modal").modal("hide");
		
	}).on('click', ".pilih-jpn", function(){
		var index 	= $('.selection_one_jpn:checked').val();
		var param	= index.toString().split('#');
                $('#nip_jaksa').val(param[0]);
                $('#nama_jaksa').val(param[1]);
                $('#pangkat_jaksa').val(param[2]);
                $('#gol_jaksa').val(param[3]);
                $('#jabatan_jaksa').val(param[5]);
                $("#jpn_modal").modal("hide");
	}).on('pjax:beforeSend', function(){
                $(".selection_one_jpn").iCheck("uncheck");
        }).on('pjax:complete','#myPjaxModalJpn', function(){
                $('#selection_all_jpn').remove();
                $(".selection_one_jpn").prop("type", "radio");
        });
	/* END AMBIL JAKSA */
});
	
</script>