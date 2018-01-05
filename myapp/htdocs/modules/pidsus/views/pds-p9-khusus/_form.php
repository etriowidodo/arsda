<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsP9Khusus;

	$this->title 	= 'P-9 Khusus';
	$this->subtitle = 'Surat Panggilan Saksi';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-p9-khusus/index';
	$linkCetak		= '/pidsus/pds-p9-khusus/cetak?id1='.rawurlencode($model['no_p9_khusus']);
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsP9Khusus::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_khusus = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_p9_khusus = ($model['tgl_p9_khusus'])?date('d-m-Y',strtotime($model['tgl_p9_khusus'])):'';
	$tgl_pemanggilan = ($model['tgl_pemanggilan'])?date('d-m-Y',strtotime($model['tgl_pemanggilan'])):'';
	$ttdJabatan = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-p9-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor P-9 Khusus</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_p9_khusus" id="no_p9_khusus" class="form-control" value="<?php echo $model['no_p9_khusus'];?>" required data-error="Nomor P-9 Khusus belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_p9_khusus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal P-9 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_p9_khusus" id="tgl_p9_khusus" class="form-control datepicker" value="<?php echo $tgl_p9_khusus;?>" required data-error="Tanggal P-9 Khusus belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_p9_khusus"></div>
                            </div>
                        </div>
                    </div>
				</div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Panggilan Sebagai</label>        
                            <div class="col-md-8">
                                <select name="panggilan" id="panggilan" class="select2">
                                    <option <?php echo ($model['panggilan'] == 'Saksi')?'selected':'';?>>Saksi</option>
                                    <option <?php echo ($model['panggilan'] == 'Tersangka')?'selected':'';?>>Tersangka</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Kepada Yth</label>        
                            <div class="col-md-8">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="kepada_nama" id="kepada_nama" class="form-control" value="<?php echo $model['kepada_nama'];?>" required data-error="Kepada belum diisi" />
                                    <span class="input-group-btn"><button class="btn" type="button" id="pilih_saksi"><i class="fa fa-search"></i></button></span>
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>        
                            <div class="col-md-8">
                                <input type="text" name="di_tempat" id="di_tempat" class="form-control" value="<?php echo $model['di_tempat'];?>" required data-error="Kolom [Di] belum diisi" />
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
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">Pemanggilan</h3>		
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal/Jam</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_pemanggilan" id="tgl_pemanggilan" class="form-control datepicker" value="<?php echo $tgl_pemanggilan;?>" required data-error="Tanggal/ Jam pemanggilan belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_pemanggilan"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                                    <input type="text" name="jam_pemanggilan" id="jam_pemanggilan" class="form-control timepicker" value="<?php echo $model['jam_pemanggilan']; ?>" required data-error="Tanggal/ Jam pemanggilan belum diisi" />
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Hari</label>        
                            <div class="col-md-4">
                                <input type="text" name="hari_pemanggilan" id="hari_pemanggilan" class="form-control" value="<?php echo $model['hari_pemanggilan'];?>" readonly />
                                <div class="help-block with-errors" id="error_custom_hari_pemanggilan"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tempat</label>        
                            <div class="col-md-8">
                                <textarea name="tempat_pemanggilan" id="tempat_pemanggilan" class="form-control" style="height:90px" required data-error="Tempat belum diisi"><?php echo $model['tempat_pemanggilan'];?></textarea>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Menghadap</label>        
                            <div class="col-md-8">
                                <input type="text" name="menghadap_kepada" id="menghadap_kepada" class="form-control" value="<?php echo $model['menghadap_kepada'];?>" required data-error="Menghadap belum diisi"  />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Diperiksa sebagai</label>        
                            <div class="col-md-8">
                                <input type="text" name="diperiksa_sebagai" id="diperiksa_sebagai" class="form-control" value="<?php echo $model['diperiksa_sebagai'];?>" required data-error="Kolom [Diperiksa sebagai] belum diisi" maxlength="255" />
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
            <div class="box-body">
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Penanda Tangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $model['penandatangan_nip']; ?>" />
                                <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $model['penandatangan_jabatan_pejabat'];?>" />														
                                <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $model['penandatangan_gol'];?>" />														
                                <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $model['penandatangan_pangkat'];?>" />														
                                <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $model['penandatangan_status_ttd']; ?>" />
                                <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $model['penandatangan_jabatan_ttd'];?>" />														
                                <div class="input-group">
                                	<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
                                	<div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
                                </div>
								<div class="help-block with-errors" id="error_custom_penandatangan"></div>
                            </div>				
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-offset-4 col-md-8">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                            	<input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
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
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['p9_khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah P-9 Khusus';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah P-9 Khusus';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload'], strrpos($model['file_upload'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
					<h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 2Mb]</h6>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="no_p8_khusus" id="no_p8_khusus" value="<?php echo $model['no_p8_khusus'];?>" />
    <input type="hidden" name="tgl_p8_khusus" id="tgl_p8_khusus" value="<?php echo $tgl_p8_khusus;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="saksi_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="penandatangan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">PENANDATANGAN</h4>
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
	$("#panggilan").on("change", function(){
		$("#kepada_nama, #diperiksa_sebagai").val("");
	});

	/* START AMBIL SAKSI {keperluan:keperluan}, */
	$("#pilih_saksi").on('click', function(e){
		var keperluan = $("#panggilan").val();
		if(keperluan){			
			$("#saksi_modal").find(".modal-body").html("");
			$("#saksi_modal").find(".modal-body").load("/pidsus/pds-p9-khusus/getsaksi?keperluan="+encodeURIComponent(keperluan), function(){
				if(keperluan == 'Saksi') $("#saksi_modal").find(".modal-title").html("Daftar Saksi");
				else $("#saksi_modal").find(".modal-title").html("Daftar Tersangka");
			});
			$("#saksi_modal").modal({backdrop:"static", keyboard:false});
		} else{
			bootbox.alert({message: "Silahkan pilih kolom [panggilan sebagai] terlebih dahulu", size: 'small'});
		}
	});
	$("#saksi_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-pidsus14-khusus-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		insertSaksi(param);
		$("#saksi_modal").modal("hide");
	}).on('click', "#idPilihPIDSUS14UModal", function(){
		var modal = $("#saksi_modal").find("#tabel-pidsus14-khusus-modal");
		var index = modal.find(".pilih-pidsus14-khusus-modal:checked").val();
		var param = index.toString().split('|#|');
		insertSaksi(param);
		$("#saksi_modal").modal("hide");
	}).on('click','#idBatalPIDSUS14UModal', function(){
		$("#saksi_modal").modal("hide");
	});
	function insertSaksi(param){
		var keperluan = $("#panggilan").val();
		$("#kepada_nama").val(decodeURIComponent(param[0]));
		$("#diperiksa_sebagai").val(keperluan);
	}
	/* END AMBIL SAKSI */

	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
	$("#jam_pemanggilan").on('focus', function(){
		$(this).prev().trigger('click');
	});

	$("#tgl_pemanggilan").on('change', function(){
		var nilai = $(this).val();
		var arrHr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
		var hari  = ""; 
		if(nilai != ""){
			var n = new Date(tgl_auto(nilai));
			hari = arrHr[n.getDay()];
		}
		$("#hari_pemanggilan").val(hari);
	});
	
	/* START AMBIL TTD */
	$("#btn_tambahttd").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/pidsus/get-ttd/index");
		$("#penandatangan_modal").modal({backdrop:"static"});
	});
	
	$("#penandatangan_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#table-ttd-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	}).on('click', "#idPilihTtdModal", function(){
		var modal = $("#penandatangan_modal").find("#table-ttd-modal");
		var index = modal.find(".pilih-ttd-modal:checked").val();
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	});
	function insertToTtd(param){
		$("#penandatangan_status").val(param[0]);
		$("#penandatangan_nip").val(param[1]);
		$("#penandatangan_nama").val(param[2]);
		$("#penandatangan_jabatan").val(param[3]);
		$("#penandatangan_gol").val(param[4]);
		$("#penandatangan_pangkat").val(param[5]);
		$("#penandatangan_ttdjabat").val(param[6]);
		$("#ttdJabatan").val(param[0]+' '+param[6]);
	}
	/* END AMBIL TTD */
        
        
});
	
</script>