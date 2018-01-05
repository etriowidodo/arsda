<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\TahapBantuanHukum;
	$tgl_skk 	= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):'';
	$tgl_trm 	= ($model['tanggal_diterima'])?date("d-m-Y", strtotime($model['tanggal_diterima'])):'';
	$tgl_ttd 	= ($model['tanggal_ttd'])?date("d-m-Y", strtotime($model['tanggal_ttd'])):'';
	$tgl_png 	= ($model['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($model['tanggal_panggilan_pengadilan'])):'';
	$linkBatal	= '/datun/skk/index';
	$linkCetak	= '/datun/skk/cetak';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/skk/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<p><a class="btn btn-success btn-sm <?php echo (!$isNewRecord)?'disabled':'';?>" id="pilihPermohonan"><i class="fa fa-file-text-o jarak-kanan"></i>Pilih Permohonan</a></p>
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Identitas Pemberi Kuasa</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No SKK</label>        
        			<div class="col-md-8">
                        <?php if($isNewRecord){ ?>
                        <input type="text" name="nomor_skk" id="nomor_skk" class="form-control" value="<?php echo $model['no_register_skk'];?>" maxlength="40" />
                        <?php } else if(!$isNewRecord && $model['kode_jenis_instansi'] == "01"){ ?>
                        <input type="hidden" name="nomor_skk" id="nomor_skk" value="<?php echo $model['no_register_skk'];?>" />
                        <input type="text" class="form-control" readonly />
                        <?php } else if(!$isNewRecord && $model['kode_jenis_instansi'] != "01"){ ?>
                        <input type="text" name="nomor_skk" id="nomor_skk" class="form-control" value="<?php echo $model['no_register_skk'];?>" maxlength="40" readonly />
                        <?php } ?>
                        <small><i>* Boleh kosong jika tergugat adalah Presiden</i></small>
                        <div class="help-block with-errors" id="error_custom1"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal SKK</label>        
        			<div class="col-md-4">
        				<div class="input-group">
        					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        					<?php if($isNewRecord){ ?>
                            <input type="text" id="tanggal_skk" name="tanggal_skk" class="form-control datepicker" placeholder="DD-MM-YYYY" required data-error="Tanggal SKK belum diisi" />
                            <?php } else{ ?>
                            <input type="text" id="tanggal_skk" name="tanggal_skk" class="form-control" value="<?php echo $tgl_skk;?>" readonly />
                            <?php } ?>
        				</div>
        			</div>
                	<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom2"></div></div>
        		</div>
        	</div>
        </div>

        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Jenis Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="jenis_ins" name="jenis_ins" class="form-control" value="<?php echo $model['jns_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="nama_ins" name="nama_ins" class="form-control" value="<?php echo $model['deskripsi_instansi'];?>" readonly />
                        <div class="help-block with-errors" id="error_custom3"></div>
            		</div>
            	</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Alamat Instansi</label>
        			<div class="col-md-8">
            			<textarea id="alamat_ins" name="alamat_ins" class="form-control" style="height:115px;" readonly><?php echo $model['alamat_instansi'];?></textarea>
					</div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Wilayah</label>
        			<div class="col-md-8">
            			<input type="text" id="wil_ins" name="wil_ins" class="form-control" value="<?php echo $model['wil_instansi'];?>" readonly />
                    </div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama</label>
        			<div class="col-md-8">
            			<input type="text" id="pimpinan_ins" name="pimpinan_ins" class="form-control" value="<?php echo $model['pimpinan_pemohon'];?>" readonly />
                    </div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Diterima di wilayah kerja</label>
        			<div class="col-md-8">
            			<input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo $model['diterima_satker'];?>" readonly />
                    </div>
				</div>
			</div>
		</div>

        <div class="row">
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Diterima</label>
        			<div class="col-md-4">
        				<div class="input-group">
        					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        					<input type="text" id="tanggal_diterima" name="tanggal_diterima" class="form-control datepicker" value="<?php echo $tgl_trm;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal diterima belum diisi" />
        				</div>
        			</div>
                	<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom4"></div></div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-md-7">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">Identitas Penerima Kuasa</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="form-buat-pemberi-kuasa">
                	<?php echo $this->render('_formPenerimaKuasa', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
				</div>
			</div>
		</div>
    </div>

	<div class="col-md-5">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">Panggilan Pengadilan</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Asal Panggilan</label>
                            <div class="col-md-8">
            					<input type="text" id="asal_pengadilan" name="asal_pengadilan" class="form-control" value="<?php echo $model['nama_pengadilan'];?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No Register Perkara</label>
                            <div class="col-md-8">
            					<input type="text" id="no_perkara" name="no_perkara" class="form-control" value="<?php echo $model['no_register_perkara'];?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Panggilan</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tanggal_panggilan" name="tanggal_panggilan" class="form-control" value="<?php echo $tgl_png;?>" readonly />
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div> 
			</div>
		</div>
        <div class="col-md-12" style="padding: 0px;">
            <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
                <div class="box-header with-border" style="border-color: #c7c7c7;">
                    <h3 class="box-title">Pemberian Bantuan Hukum</h3>
                </div>
                <div class="box-body" style="padding:15px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-6">Tahap Pemberian Bantuan Hukum</label>
                                <div class="col-md-6">
                                    <select id="tahap_bankum" name="tahap_bankum" class="select2" style="width:100%;" required data-error="Bantuan hukum belum dipilih">
                                        <option></option>
                                        <?php 
                                            $sqlOpt = "select kode_tahap_bankum, deskripsi_tahap_bankum from datun.tr_tahap_bankum order by 1";
                                            $resOpt = TahapBantuanHukum::findBySql($sqlOpt)->asArray()->all();
                                            foreach($resOpt as $dOpt){
                                                $selected = ($model['kode_tahap_bankum'] == $dOpt['kode_tahap_bankum']?'selected':'');
                                                echo '<option value="'.$dOpt['kode_tahap_bankum'].'" '.$selected.'>'.$dOpt['deskripsi_tahap_bankum'].'</option>';
                                            } 
                                        ?>
                                    </select>
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<div class="form-buat-ttdnya <?php echo ($model['kode_jenis_instansi'] != '06')?'hide':'';?>">
    <div class="row"><div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-body" style="padding:15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Dikeluarkan di</label>
                            <div class="col-md-8">
                                <input type="text" id="dikeluarkan" name="dikeluarkan" class="form-control" value="<?php echo $model['inst_lokinst'];?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Ditandatangani</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tanggal_ttd" name="tanggal_ttd" class="form-control datepicker" value="<?php echo $tgl_ttd;?>" placeholder="DD-MM-YYYY"/>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom6"></div></div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
	</div></div>
</div>


<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_skk" id="file_skk" class="form-inputfile" />                    
                <label for="file_skk" class="label-inputfile">
                    <?php 
                        $pathFile   = Yii::$app->params['skk'].$model['file_skk'];
                        $labelFile  = 'Upload File SKK';
                        if($model['file_skk'] && file_exists($pathFile)){
                            $labelFile  = 'Ubah File SKK';
                            $param1     = chunk_split(base64_encode($pathFile));
                            $param2     = chunk_split(base64_encode($model['file_skk']));
                            $linkPt     = "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt      = substr($model['file_skk'], strrpos($model['file_skk'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_skk'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom7"></div>
                </label>
            </div>
        </div>
	</div>
</div>


<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <input type="hidden" name="kdtp" id="kdtp" value="<?php echo $model['kode_jenis_instansi'];?>" />
    <input type="hidden" name="kdtk" id="kdtk" value="<?php echo $model['kode_tk'];?>" />
    <input type="hidden" name="no_surat" id="no_surat" value="<?php echo $model['no_surat'];?>" />
    <input type="hidden" name="tgl_permohonan" id="tgl_permohonan" value="<?php echo $model['tanggal_permohonan'];?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan1" name="simpan1"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <?php if(!$isNewRecord && $model['kode_jenis_instansi'] == '06'){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
    <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>

<div class="modal fade" id="permohonan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Permohonan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="penerima_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penerima Kuasa</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa Pengacara Negara</h4>
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
	localStorage.clear();
	var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
	$(".form-buat-pemberi-kuasa").find(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValues[idnya] = idnya;
	});
	localStorage.setItem("formValues", JSON.stringify(formValues));
	<?php echo ($isNewRecord)?'var aHarusUnik1 = "";':'var aHarusUnik1 = $(".form-buat-pemberi-kuasa").find("#penerima_kuasa").val();'; ?>

	/* START MODAL PERMOHONAN */
	$("#pilihPermohonan").on('click', function(e){
		$("#permohonan_modal").find(".modal-body").html("");
		$("#permohonan_modal").find(".modal-body").load("/datun/skk/getpermohonan");
		$("#permohonan_modal").modal({backdrop:"static"});
	});
	$("#permohonan_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on('click', ".pilihan", function(e){
		var pilih = $(this).data("id").split("#");
		savePermohonan(pilih);
	}).on("dblclick", "#modal-tabel-permohonan td:not(.aksinya)", function(e){
		var pilih = $(this).closest("tr").data("id").toString().split("#");
		savePermohonan(pilih);
	});
	function savePermohonan(pilih){
		$("body").addClass("loading");
		var objParam = {'q1':pilih[10], 'q2':pilih[11], 'q3':pilih[12], 'q4':pilih[13], 'q5':pilih[6], 'q6':pilih[7], 'tp':pilih[14], 'tk':pilih[15]};
		if(pilih[14] == '06'){
			$(".form-buat-ttdnya").removeClass("hide");
		} else{
			$(".form-buat-ttdnya").addClass("hide");
		}
		$(".form-buat-pemberi-kuasa").find("input, textarea, hidden").val("");
		$(".form-buat-pemberi-kuasa").load("/datun/skk/getpenerimakuasa", objParam, function(){
			$('#role-form').validator('update');
		});
		$("#jenis_ins").val(pilih[0]);
		$("#nama_ins").val(pilih[1]);
		$("#wil_ins").val(pilih[2]);
		$("#alamat_ins").val(pilih[3]);
		$("#pimpinan_ins").val(pilih[4]);
		$("#wil_kerja").val(pilih[5]);
		$("#no_perkara").val(pilih[6]);
		$("#no_surat").val(pilih[7]);
		$("#asal_pengadilan").val(pilih[8]);
		$("#tanggal_panggilan").val(pilih[9]);
		$("#kdtp").val(pilih[14]);
		$("#kdtk").val(pilih[15]);
		$("#dikeluarkan").val(pilih[16]);
		$("#pemberi_kuasa").val(pilih[2]);
		$("#tgl_permohonan").val(pilih[17]);
		$("#permohonan_modal").modal("hide");
		$("body").removeClass("loading");
	}
	/* END MODAL PERMOHONAN */
	
	/* START AMBIL PEGAWAI */
	$(".form-buat-pemberi-kuasa").on("change", "#penerima_kuasa", function(){
		$("body").addClass("loading");
		$(".form-buat-pemberi-kuasa").find(".form-control, hidden").val("");
		var q1 = $(this).val();
		var q2 = $("#kdtp").val();
		var q3 = $("#kdtk").val();
		if(q2 != '06' && q3 != '0'){
			$.ajax({
				type	: "POST",
				url		: "<?php echo Yii::$app->request->baseUrl.'/datun/skk/getpenerimapusat'; ?>",
				data	: {'q1':q1},
				cache	: false,
				dataType: "json",
				success : function(data){ 
					if(data.hasil){
						$(".form-buat-pemberi-kuasa").find("#nip_penerima").val(data.hasil.nip);
						$(".form-buat-pemberi-kuasa").find("#nama_penerima").val(data.hasil.nama);
						$(".form-buat-pemberi-kuasa").find("#jabatan_penerima").val(data.hasil.jabatan);
						$(".form-buat-pemberi-kuasa").find("#alamat_penerima").val(data.hasil.alamat);
					} else{
						$(".form-buat-pemberi-kuasa").find(".form-control, hidden").val("");
					}
				}
			});
		} else if(q2 == '06'){
			var frm_ja 	= $(".form-buat-pemberi-kuasa").find("#frm_modal_penerima_ja");
			var frm_jpn	= $(".form-buat-pemberi-kuasa").find("#frm_modal_penerima_jpn");
			if(q1 == "JPN"){
				frm_ja.addClass('hide').find(".form-control, hidden").val("");
				frm_jpn.removeClass('hide');
				if(aHarusUnik1 && aHarusUnik1 != "JPN"){
					var table = $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
					frm_jpn.find(".table-jpn-modal > tbody").find("tr").remove();
					frm_jpn.find(".table-jpn-modal > tbody").load("/datun/skk/getjpnsp1");
				}
			} else{
				frm_jpn.addClass('hide');
				frm_ja.removeClass('hide').find(".form-control, hidden").val("");
				if(q1 == "JAMDATUN"){
					$.ajax({
						type	: "POST",
						url		: "<?php echo Yii::$app->request->baseUrl.'/datun/skk/getpenerimapusat'; ?>",
						data	: {'q1':q1},
						cache	: false,
						dataType: "json",
						success : function(data){ 
							if(data.hasil){
								$(".form-buat-pemberi-kuasa").find("#nip_penerima").val(data.hasil.nip);
								$(".form-buat-pemberi-kuasa").find("#nama_penerima").val(data.hasil.nama);
								$(".form-buat-pemberi-kuasa").find("#jabatan_penerima").val(data.hasil.jabatan);
								$(".form-buat-pemberi-kuasa").find("#alamat_penerima").val(data.hasil.alamat);
							} else{
								$(".form-buat-pemberi-kuasa").find(".form-control, hidden").val("");
							}
						}
					});
				}
			}
		}
		$("body").removeClass("loading");
	}).on("click", "#btn-cari-peg", function(){
		var nilai = $(".form-buat-pemberi-kuasa").find("#penerima_kuasa").val();
		if(nilai){
			$("#penerima_modal").find(".modal-body").html("");
			$("#penerima_modal").find(".modal-body").load("/datun/skk/getpegawai?tipe="+nilai);
			$("#penerima_modal").modal({backdrop:"static"});
		}
	});

	$("#penerima_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on('click', ".pilihPeg", function(){
		var id = $(this).data('id');
		getPegawaiModal(id);
	}).on("dblclick", "#modal-tabel-pegawai td:not(.aksinya)", function(){
		var id = $(this).closest("tr").data("id");
		getPegawaiModal(id);
	});
	function getPegawaiModal(id){
		var tm = id.toString().split('#');
		$(".form-buat-pemberi-kuasa").find("#nip_penerima").val(tm[0]);
		$(".form-buat-pemberi-kuasa").find("#nama_penerima").val(tm[1]);
		$(".form-buat-pemberi-kuasa").find("#jabatan_penerima").val(tm[2]);
		$(".form-buat-pemberi-kuasa").find("#alamat_penerima").val(tm[3]);
		$("#penerima_modal").modal("hide");
	}
	/* END AMBIL PEGAWAI */

	/* START AMBIL JPN */
	$(".form-buat-pemberi-kuasa").on("click", "#btn_tambahjpn", function(){
		$("#jpn_modal").find(".modal-body").html("");
		$("#jpn_modal").find(".modal-body").load("/datun/getjpn/index");
		$("#jpn_modal").modal({backdrop:"static"});
	}).on("click", "#btn_hapusjpn", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
		tabel.find(".hRowJpn:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-pemberi-kuasa").find(".table-jpn-modal > tbody");
				nRow.append('<tr><td colspan="5">Tidak ada dokumen</td></tr>');
			}
		});
		tabel.find(".frmnojpn").each(function(i,v){$(this).text(i+1);});				

		formValues = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValues[idnya] = idnya;
		});
		localStorage.setItem("formValues", JSON.stringify(formValues));
		var n = tabel.find(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});

	$("#jpn_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#jpn-jpn-modal td:not(.aksinya)", function(){
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('#');
		var myvar 	= param[0];
		if(myvar in formValues){
			$("#jpn_modal").modal("hide");
		} else{
			insertToRole(myvar, index);
			$("#jpn_modal").modal("hide");
		}
	}).on('click', ".pilih-jpn", function(){
		var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataJPN')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('#');
			var myvar 	= param[0];
			insertToRole(myvar, index);
		});
		localStorage.removeItem("modalnyaDataJPN");
		$("#jpn_modal").modal("hide");
	});
	function insertToRole(myvar, index){
		var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.frmnojpn").data('rowCount'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('#');

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		}

		$("#cekModalJpn_"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
		tabel.find(".frmnojpn").each(function(i,v){$(this).text(i+1);});
		formValues[myvar] = myvar;
		localStorage.setItem("formValues", JSON.stringify(formValues));
	}
		
	$(".form-buat-pemberi-kuasa").on("ifChecked", ".table-jpn-modal input[name=allCheckJpn]", function(){
		$(".hRowJpn").not(':disabled').iCheck("check");
	}).on("ifUnchecked", ".table-jpn-modal input[name=allCheckJpn]", function(){
		$(".hRowJpn").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", ".table-jpn-modal .hRowJpn", function(){
		var n = $(".hRowJpn:checked").length;
		(n >= 1)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	}).on("ifUnchecked", ".table-jpn-modal .hRowJpn", function(){
		var n = $(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});
	/* END AMBIL JPN */

});
</script>


