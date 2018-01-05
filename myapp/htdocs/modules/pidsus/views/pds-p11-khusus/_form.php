<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsP11Khusus;

	$this->title 	= 'P-11 Khusus';
	$this->subtitle = 'Surat Bantuan Pemanggilan Saksi / Ahli';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-p11-khusus/index';
	$linkCetak		= '/pidsus/pds-p11-khusus/cetak?id1='. rawurlencode($model['no_p11_khusus']);
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsP11Khusus::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_khusus = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_p11_khusus = ($model['tgl_p11_khusus'])?date('d-m-Y',strtotime($model['tgl_p11_khusus'])):'';
	$ttdJabatan = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-p11-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor P-11 Khusus</label>
                    <div class="col-md-8">
                        <input type="text" name="no_p11_khusus" id="no_p11_khusus" class="form-control" value="<?php echo $model['no_p11_khusus']; ?>" maxlength="50" required data-error="Nomor P-11 Khusus belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_p11_khusus"></div>
                    </div>
            	</div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_p11_khusus" id="tgl_p11_khusus" class="form-control datepicker" value="<?php echo $tgl_p11_khusus;?>" required data-error="Tanggal P-11 Khusus belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_p11_khusus"></div>
                    </div>
                </div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Sifat</label>
                    <div class="col-md-8">
                        <select name="sifat" id="sifat" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                            <option></option>
                            <?php 
                                $resOpt = PdsP11Khusus::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
                                foreach($resOpt as $dOpt){
                                    $selected = ($model['sifat'] == $dOpt['id'])?'selected':'';
                                    echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>             		
                    </div>
                </div>
            	<div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran']; ?>" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perihal</label>        
                            <div class="col-md-8">
                                <select name="perihal" id="perihal" class="select2" style="width:100%" required data-error="Perihal belum dipilih">
                                    <option></option>
                                    <option <?php echo ($model['perihal'] == 'Bantuan Pemanggilan Saksi')?'selected':'';?>>Bantuan Pemanggilan Saksi</option>
                                    <option <?php echo ($model['perihal'] == 'Bantuan Pemanggilan Ahli')?'selected':'';?>>Bantuan Pemanggilan Ahli</option>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kepada Yth.</label>
                    <div class="col-md-8">
                        <textarea name="kepada_nama" id="kepada_nama" class="form-control" style="height:75px;" required data-error="Kolom [Kepada Yth] belum diisi"><?php echo $model['kepada_nama']; ?></textarea>						
                    	<div class="help-block with-errors"></div>
                    </div>
            	</div>
            	<div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>
                            <div class="col-md-8">
                                <input type="text" name="di_tempat" id="di_tempat" class="form-control" value="<?php echo $model['di_tempat']; ?>" required data-error="Kolom [Di] belum diisi" />
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
                <h3 class="box-title">Saksi/ Ahli</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm disabled" id="btn_hps_saksi"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="btn_add_saksi"><i class="fa fa-user-plus jarak-kanan"></i>Saksi/ Ahli</a>
                    </div>		
                </div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table-saksi">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%"><input type="checkbox" name="allCheckSaksi" id="allCheckSaksi" class="allCheckSaksi" /></th>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="30%">Nama Lengkap Saksi/ Ahli Yang Dipanggil</th>
                                <th class="text-center" width="35%">Alamat</th>
                                <th class="text-center" width="25%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $sqlnya = "select * from pidsus.pds_p11_khusus_saksi where ".$whereDefault." and no_p11_khusus = '".$model['no_p11_khusus']."' order by no_urut_saksi";
                            $hasil 	= PdsP11Khusus::findBySql($sqlnya)->asArray()->all();
                            if(count($hasil) == 0)
                                echo '<tr class="barisListSaksi"><td colspan="5">Data tidak ditemukan</td></tr>';
                            else{
                                $nom = 0;
                                foreach($hasil as $data){
                                    $nom++;	
									echo '
									<tr class="barisListSaksi" data-id="'.$nom.'">
										<td class="text-center">
											<input type="hidden" name="nama_saksi[1]" class="list-saksi" value="'.$data['nama'].'" />
											<input type="hidden" name="alamat_saksi[1]" class="list-saksi" value="'.$data['alamat'].'" />
											<input type="hidden" name="keterangan_saksi[1]" class="list-saksi" value="'.$data['keterangan'].'" />
											<input type="hidden" name="status_saksi[1]" class="list-saksi" value="'.$data['status'].'" />
											<input type="checkbox" value="'.$nom.'" class="hRowSaksi" id="chk_del_saksi'.$nom.'" name="chk_del_saksi['.$nom.']" />
										</td>
										<td class="text-center"><span data-row-count="'.$nom.'" class="frmnosaksi">'.$nom.'</span></td>
										<td class="text-left"><a class="ubahListSaksi" style="cursor:pointer">'.$data['nama'].'</a></td>
										<td class="text-left">'.$data['alamat'].'</td>
										<td class="text-left">'.$data['keterangan'].'</td>
									</tr>';
                         		} 
							} 
						?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="row">
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
                        $pathFile 	= Yii::$app->params['p11_khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah P-11 Khusus';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah P-11 Khusus';
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

<div class="modal fade" id="tambah_saksi_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="list_saksi_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"></h4>
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
	$("#perihal").on("change", function(){
		var tabel = $(".form-buat-pemberi-kuasa").find("#table-saksi > tbody");
		tabel.html('<tr class="barisListSaksi"><td colspan="5">Data tidak ditemukan</td></tr>');
		$("#btn_hps_saksi").addClass("disabled");
	});

	/* START AMBIL SAKSI */
	$(".form-buat-pemberi-kuasa").on("click", "#btn_add_saksi", function(){
		var perihal = $("#perihal").val();
		if(perihal){			
			$("#tambah_saksi_modal").find(".modal-body").html("");
			$("#tambah_saksi_modal").find(".modal-body").load("/pidsus/pds-p11-khusus/getsaksi?perihal="+encodeURIComponent(perihal), function(){
				if(perihal == 'Bantuan Pemanggilan Saksi'){ 
					$("#tambah_saksi_modal").find(".modal-title").html("Saksi");
					$("#modal_status_saksi").val("Saksi");
				} else if(perihal == 'Bantuan Pemanggilan Ahli'){ 
					$("#tambah_saksi_modal").find(".modal-title").html("Ahli");
					$("#modal_status_saksi").val("Ahli");
				} else{ 
					$("#tambah_saksi_modal").find(".modal-title").html("Tersangka");
					$("#modal_status_saksi").val("Tersangka");
				}
				$("#nurec_penggeledahan").val('1');
				$("#simpan_form_penggeledahan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
			});
			$("#tambah_saksi_modal").modal({backdrop:"static", keyboard:false});
		} else{
			bootbox.alert({message: "Silahkan pilih perihal terlebih dahulu", size: 'small'});
		}
	}).on("click", ".ubahListSaksi", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".list-saksi").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-p11-khusus/getsaksi", objk, function(data){
			if($("#perihal").val() == 'Bantuan Pemanggilan Saksi'){ 
				$("#tambah_saksi_modal").find(".modal-title").html("Saksi");
			} else if($("#perihal").val() == 'Bantuan Pemanggilan Ahli'){ 
				$("#tambah_saksi_modal").find(".modal-title").html("Ahli");
			} else{ 
				$("#tambah_saksi_modal").find(".modal-title").html("Tersangka");
			}
			$("#tambah_saksi_modal").find(".modal-body").html("");
			$("#tambah_saksi_modal").find(".modal-body").html(data);
			$("#tambah_saksi_modal").find("#tr_id_penggeledahan").val(trid);
			$("#tambah_saksi_modal").find("#nurec_penggeledahan").val('0');
			$("#tambah_saksi_modal").find("#simpan_form_penggeledahan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
			$("#tambah_saksi_modal").modal({backdrop:"static", keyboard:false});
		});
	}).on("click", "#btn_hps_saksi", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-pemberi-kuasa").find("#table-saksi");
		tabel.find(".hRowSaksi:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-pemberi-kuasa").find("#table-saksi > tbody");
				nRow.append('<tr class="barisListSaksi"><td colspan="5">Data tidak ditemukan</td></tr>');
			}
		});
		tabel.find(".frmnosaksi").each(function(i,v){$(this).text(i+1);});
		var n = tabel.find(".hRowSaksi:checked").length;
		(n > 0)?$("#btn_hps_saksi").removeClass("disabled"):$("#btn_hps_saksi").addClass("disabled");
	}).on("ifChecked", "#table-saksi input[name=allCheckSaksi]", function(){
		$(".hRowSaksi").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#table-saksi input[name=allCheckSaksi]", function(){
		$(".hRowSaksi").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#table-saksi .hRowSaksi", function(){
		var n = $(".hRowSaksi:checked").length;
		(n >= 1)?$("#btn_hps_saksi").removeClass("disabled"):$("#btn_hps_saksi").addClass("disabled");
	}).on("ifUnchecked", "#table-saksi .hRowSaksi", function(){
		var n = $(".hRowSaksi:checked").length;
		(n > 0)?$("#btn_hps_saksi").removeClass("disabled"):$("#btn_hps_saksi").addClass("disabled");
	});

	$("#tambah_saksi_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
		$("#form-modal-gldh").validator({disable:false});
		$("#form-modal-gldh").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#form-modal-gldh").find(".with-errors").html("");
				$("#evt_penggeledahan_sukses").trigger("validasi.oke.penggeledahan");
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		if($(e.target).attr("id") == "tambah_saksi_modal")
			$(this).find('form#form-modal-gldh').off('submit').validator('destroy');
	}).on("validasi.oke.penggeledahan", "#evt_penggeledahan_sukses", function(){
		var frmnya = $("#tambah_saksi_modal").find("#form-modal-gldh").serializeArray();
		var arrnya = {};
		$.each(frmnya, function(k, v){ arrnya[v.name] = v.value; });
		if(arrnya['nurec_penggeledahan'] == 1){
			var tabel 	= $("#table-saksi");
			var rwTbl	= tabel.find('tbody > tr.barisListSaksi:last');
			var rwNom	= parseInt(rwTbl.data('id'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-p11-khusus/setsaksi", frmnya, function(data){
				if(isNaN(rwNom)){
					rwTbl.remove();
					rwTbl = tabel.find('tbody');
					rwTbl.append(data.hasil);
				} else{
					rwTbl.after(data.hasil);
				}
				$("#chk_del_saksi"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				tabel.find(".frmnosaksi").each(function(i,v){$(this).text(i+1);});
				$("#tambah_saksi_modal").modal('hide');
			}, "json");
		} else{
			var tabel = $("#table-saksi").find("tr[data-id='"+arrnya['tr_id_penggeledahan']+"']");
			var newId = arrnya['tr_id_penggeledahan'];
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-p11-khusus/setsaksi", frmnya, function(data){
				tabel.html(data.hasil);
				$("#chk_del_saksi"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#table-saksi").find(".frmnosaksi").each(function(i,v){$(this).text(i+1);});
				$("#tambah_saksi_modal").modal('hide');
			}, "json");
		}
	}).on("click", "#pilih_saksi", function(){
		var perihal = $("#modal_status_saksi").val();
		if(perihal){
			$("#list_saksi_modal").find(".modal-body").html("");
			$("#list_saksi_modal").find(".modal-body").load("/pidsus/pds-p11-khusus/getlistsaksi?perihal="+encodeURIComponent(perihal), function(){
				if(perihal == 'Saksi'){ 
					$("#list_saksi_modal").find(".modal-title").html("List Saksi");
				} else if(perihal == 'Ahli'){ 
					$("#list_saksi_modal").find(".modal-title").html("List Ahli");
				} else{ 
					$("#list_saksi_modal").find(".modal-title").html("List Tersangka");
				}
			});
			$("#list_saksi_modal").modal({backdrop:"static", keyboard:false});
		}
	});

	$("#list_saksi_modal").on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("dblclick", "#table-pds14u-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
			$("#tambah_saksi_modal").find("#modal_nama_saksi").val(decodeURIComponent(param[0]));
			$("#tambah_saksi_modal").find("#modal_alamat_saksi").val(decodeURIComponent(param[1]));
			$("#tambah_saksi_modal").find("#modal_keterangan_saksi").val(decodeURIComponent(param[2]));
		$("#list_saksi_modal").modal("hide");
	}).on('click', ".pilih-pds14u", function(){
		var tabel = $("#table-pds14u-modal");
		tabel.find(".selection_one_saksi:checked").each(function(k, v){
			var index = $(v).val();
			var param = index.toString().split('#');
			$("#tambah_saksi_modal").find("#modal_nama_saksi").val(decodeURIComponent(param[0]));
			$("#tambah_saksi_modal").find("#modal_alamat_saksi").val(decodeURIComponent(param[1]));
			$("#tambah_saksi_modal").find("#modal_keterangan_saksi").val(decodeURIComponent(param[2]));
		});
		$("#list_saksi_modal").modal("hide");
	});
	/* END AMBIL SAKSI */

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