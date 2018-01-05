<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsBa10Penahanan;

	$this->title = 'BA-10 (Penahanan)';
	$this->subtitle = 'Berita Acara Pelaksanaan Perintah Penahanan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-ba10-penahanan/index';
	$linkCetak		= '/pidsus/pds-ba10-penahanan/cetak?id1='.rawurlencode($model['no_pidsus20a']);
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsBa10Penahanan::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_khusus          = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_ba10               = ($model['tgl_ba10'])?date('d-m-Y',strtotime($model['tgl_ba10'])):'';
	$tgl_mulai_penahanan    = ($model['tgl_mulai_penahanan'])?date('d-m-Y',strtotime($model['tgl_mulai_penahanan'])):'';
	$ttdJabatan             = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-ba10-penahanan/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">SP - Penyidikan</label>        
            <div class="col-md-8">
                <div class="input-group input-group-sm">
                    <input type="text" name="no_pidsus18" id="no_pidsus18" class="form-control" value="<?php echo $model['no_pidsus18'];?>" readonly/>
                    <span class="input-group-btn">
                        <button class="btn" type="button" id="pilih_no_p8_khusus">Pilih</button>
                    </span>
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Nomor</label>        
            <div class="col-md-8">
                <input type="text" name="no_p8_khusus" id="no_p8_khusus" class="form-control" value="<?php echo $model['no_p8_khusus']; ?>"readonly />
                <div class="help-block with-errors" id="error_custom_no_p8_khusus"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal</label>        
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="tgl_p8_khusus" id="tgl_p8_khusus" class="form-control" value="<?php echo $tgl_p8_khusus;?>" readonly/>
                </div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Jenis</label>        
                    <div class="col-md-8">
                        <select name="jenis" id="jenis" class="select2" style="width:100%" required data-error="Jenis belum diisi">
                            <option></option>

                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal BA-10</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_ba10" id="tgl_ba10" class="form-control datepicker" value="<?php echo $tgl_ba10;?>" required data-error="Tanggal BA-10 belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_ba10"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Penahanan</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_mulai_penahanan" id="tgl_mulai_penahanan" class="form-control datepicker" value="<?php echo $tgl_mulai_penahanan;?>" required data-error="Tanggal Penahanan belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_mulai_penahanan"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Pasal</label>        
                    <div class="col-md-8">
                        <input type="text" name="pasal" id="pasal" class="form-control" value="<?php echo $model['pasal'];?>"  /> 
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kepala Rutan</label>        
                    <div class="col-md-8">
                        <input type="text" name="kepala_rutan" id="kepala_rutan" class="form-control" value="<?php echo $model['kepala_rutan'];?>"  /> 
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa Penyidik</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama</label>        
                            <div class="col-md-8">
                                <select name="nama_jaksa_penyidik" id="nama_jaksa_penyidik" class="select2" style="width:100%" required data-error="Nama Jaksa belum dipilih">
                                    <option></option>
                                    <?php
                                    /**    $sqlOpt1 = "select nip_jaksa as idnya, nama_jaksa as namanya, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatnya 
                                                from pidsus.pds_p8_umum_jaksa where ".$whereDefault;
                                        $resOpt1 = PdsBa1Umum::findBySql($sqlOpt1)->asArray()->all();
                                        foreach($resOpt1 as $datOpt1){
                                            $selected = ($datOpt1['idnya'] == $model['nip_jaksa'])?'selected':'';
                                            echo '<option value="'.$datOpt1['idnya'].'" data-pangkat="'.$datOpt1['pangkatnya'].'" '.$selected.'>'.$datOpt1['namanya'].'</option>';
                                        } **/
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pangkat</label>        
                            <div class="col-md-8">
                                <input type="text" name="pangkat_jaksa" id="pangkat_jaksa" class="form-control" value="<?php echo $model['pangkat_jaksa'];?>" readonly  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">NIP</label>        
                            <div class="col-md-8">
                                <input type="hidden" name="nama_jaksa" id="nama_jaksa" value="<?php echo $model['nama_jaksa'];?>"  /> 
                                <input type="text" name="nip_jaksa" id="nip_jaksa" class="form-control" value="<?php echo $model['nip_jaksa'];?>" readonly  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tersangka</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama</label>        
                    <div class="col-md-8">
                        <div class="input-group input-group-sm">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" required data-error="Kolom [Nama] belum dipilih" />
                            <span class="input-group-btn"><button class="btn" type="button" id="pilih_tersangka"><i class="fa fa-search"></i></button></span>
                        </div>
                        <div class="help-block with-errors" id="error_custom_nama"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Tempat Lahir</label>
                    <div class="col-md-4">
                        <input type="text" name="tmpt_lahir" id="tmpt_lahir" class="form-control chars-only" value="<?php echo $model["tmpt_lahir"];?>" />
                    </div>
                    <label class="control-label col-md-2">Tanggal Lahir</label>
                    <div class="col-md-4">
                         <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker"  value="<?php echo $tgl_lahir;?>" required data-error="Tanggal Lahir belum diisi" />
							<div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>
							<input type="text" name="umur" id="umur" class="form-control" style="width:60px;" value="<?php echo ($model["umur"]?$model["umur"]:'')?>" />
						</div>
                        <div class="help-block with-errors"></div>                            	
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Jenis Kelamin</label>
                    <div class="col-md-8">
                        <input type="radio" name="id_jkl" id="id_jkl1" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> />
                        <label for="id_jkl1" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="id_jkl" id="id_jkl2" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> />
                        <label for="id_jkl2" class="control-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                        <input type="hidden" name="warganegara" id="warganegara" value="<?= $model["warganegara"]?>"/>
                        <input type="text" name="kebangsaan" id="kebangsaan" class="form-control" value="<?= $model["kebangsaan"]?>" placeholder="-Pilih Kewarganegaraan-"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Tinggal</label>
                    <div class="col-md-8">
                        <textarea name="alamat" id="alamat" class="form-control" style="height:75px"><?php echo $model["alamat"];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                	<div class="col-sm-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Agama</label>
                            <div class="col-md-8">
                                <select id="id_agama" name="id_agama" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                         $agm = PdsBa10Penahanan::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
                                        foreach($agm as $ag){
                                            $selected = ($ag['id_agama'] == $model['id_agama'])?'selected':'';
                                            echo '<option value="'.$ag['id_agama'].'" '.$selected.'>'.$ag['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                	<div class="col-sm-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pekerjaan</label>        
                            <div class="col-md-8">
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pendidikan</label>
                                <div class="col-md-8">
                                    <select id="pendidikan" name="pendidikan" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                        $pdd = PdsBa10Penahanan::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                        foreach($pdd as $pd){
                                            $selected = ($pd['id_pendidikan'] === $model['id_pendidikan'])?'selected':'';
                                            echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Register Tahanan</label>
                    <div class="col-md-8">
                        <input type="text" name="reg_tahanan" id="reg_tahanan" class="form-control" value="<?php echo $model['reg_tahanan'];?>" required data-error="Kolom [Register Tahanan] belum dipilih" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Register Perkara</label>
                    <div class="col-md-8">
                        <input type="text" name="reg_perkara" id="reg_perkara" class="form-control" value="<?php echo $model['reg_perkara'];?>" required data-error="Kolom [Register Perkara] belum dipilih" />
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
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['ba10-penahanan'].$model['file_upload'];
                        $labelFile 	= 'Unggah BA-10';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah BA-10';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload'], strrpos($model['file_upload'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p21'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>	
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="no_p8_khusus" id="no_p8_khusus" value="<?php echo $model['no_p8_khusus'];?>" />
    <input type="hidden" name="tgl_p8_khusus" id="tgl_p8_umum" value="<?php echo $tgl_p8_khusus;?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
    <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<div class="modal fade" id="penandatangan_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penandatangan</h4>
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
	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
        $("#jam_und").on('focus', function(){
		$(this).prev().trigger('click');
	});

	$("#tgl_und").on('change', function(){
		var nilai = $(this).val();
		var arrHr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
		var hari  = ""; 
		if(nilai != ""){
			var n = new Date(tgl_auto(nilai));
			hari = arrHr[n.getDay()];
		}
		$("#hari_und").val(hari);
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