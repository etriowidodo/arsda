<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus6Umum;

	$this->title 	= 'Pidsus-6 Umum';
	$this->subtitle = 'Surat Perintah Penunjukan Penelaah';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-6-umum/index';
	$linkCetak		= '/pidsus/pds-pidsus-6-umum/cetak?id1='.rawurlencode($model['no_pidsus6_umum']);
	if($isNewRecord){
		$sqlCek = "select no_p8_umum, tgl_p8_umum from pidsus.pds_p8_umum where ".$whereDefault;
		$model 	= PdsPidsus6Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_dikeluarkan = ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tempat_dikeluarkan = ($model['tempat_dikeluarkan'])?$model['tempat_dikeluarkan']:Yii::$app->inspektur->getLokasiSatker()->lokasi;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-6-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Pidsus-6 Umum</label>
                    <div class="col-md-8">
                        <input type="text" name="no_pidsus6_umum" id="no_pidsus6_umum" class="form-control" value="<?php echo $model['no_pidsus6_umum']; ?>" maxlength="50" required data-error="Nomor Pidsus-6 Umum belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_pidsus6_umum"></div>
                    </div>
            	</div>
            </div>
		</div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Dikeluarkan di</label>        
                    <div class="col-md-8">
                        <input type="text" name="tempat_dikeluarkan" id="tempat_dikeluarkan" class="form-control" value="<?php echo $tempat_dikeluarkan;?>" required data-error="Kolom [Dikeluarkan di] belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Dikeluarkan</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_dikeluarkan" id="tgl_dikeluarkan" class="form-control datepicker" value="<?php echo $tgl_dikeluarkan;?>" required data-error="Tanggal Dikeluarkan belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_dikeluarkan"></div>
                    </div>
                </div>
            </div>
		</div>
    </div>
</div>

<div class="box box-primary form-buat-pemberi-kuasa">
    <div class="box-header with-border">
    	<h3 class="box-title">Jaksa Penelaah</h3>
	</div>
    <div class="box-body">
        <div style="margin-bottom:15px;">
            <a class="btn btn-danger btn-sm disabled jarak-kanan" id="btn_hapusjpn"><i class="fa fa-trash" style="font-size:14px;"></i></a>	
            <a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a>	
        </div>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-jpn-modal">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="30%">NIP / Nama</th>
                        <th class="text-center" width="60%">Jabatan / Pangkat &amp; Golongan</th>
                    </tr>
                </thead>
                <tbody>
				<?php 
					$sqlJaksa = "select a.nip_jaksa, a.nama_jaksa, a.gol_jaksa, a.pangkat_jaksa, a.jabatan_jaksa 
								 from pidsus.pds_pidsus6_umum_penelaah a where ".$whereDefault." and a.no_pidsus6_umum = '".$model['no_pidsus6_umum']."' order by a.no_urut";
					$resJaksa = PdsPidsus6Umum::findBySql($sqlJaksa)->asArray()->all();
                    if(count($resJaksa) == 0){
                       echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
                    } else{
                        $nom = 0;
                        foreach($resJaksa as $data){
                            $nom++;	
                            $idJpn = $data['nip_jaksa']."#".$data['nama_jaksa']."#".$data['test']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];					
                            echo '
							<tr data-id="'.$data['nip_jaksa'].'">
								<td class="text-center">
									<input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'.$nom.'" class="hRowJpn" value="'.$data['nip_jaksa'].'" />
								</td>
								<td class="text-center">
									<span class="frmnojpn" data-row-count="'.$nom.'">'.$nom.'</span><input type="hidden" name="jpnid[]" value="'.$idJpn.'" />
								</td>
								<td class="text-left">'.$data['nip_jaksa'].'<br />'.$data['nama_jaksa'].'</td>
								<td class="text-left">'.$data['jabatan_jaksa'].'<br />'.$data['pangkat_jaksa'].' ('.$data['gol_jaksa'].')</td>
							</tr>';
                        }
                    }
                 ?>	
                </tbody>
            </table>
        </div>
    </div>
</div>			

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-tembusan" title="Tambah Tembusan"><i class="fa fa-plus jarak-kanan"></i>Tembusan</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table_tembusan" class="table table-bordered">
                        <thead>
							<tr>
                                <th width="10%"></th>
                                <th width="15%">No Urut</th>
                                <th width="75%">Tembusan</th>
							</tr>
                        </thead>
                        <tbody>
                        <?php
                        	if($model['no_pidsus6_umum'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pidsus-6-Umum' order by no_urut";
                        		$resx = PdsPidsus6Umum::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select a.no_urut, a.tembusan from pidsus.pds_pidsus6_umum_tembusan a where ".$whereDefault." 
										 and a.no_pidsus6_umum = '".$model['no_pidsus6_umum']."' order by a.no_urut";
                        		$resx = PdsPidsus6Umum::findBySql($sqlx)->asArray()->all();
                        	}
                        	$no = 1;
							foreach($resx as $datx):
						?>
                        	<tr data-id="<?php echo $no;?>">
                        		<td class="text-center">
                                <input type="checkbox" name="chk_del_tembusan[]" id="<?php echo 'chk_del_tembusan'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                        		<td><input type="text" name="no_urut[]" class="form-control input-sm" value="<?php echo $datx['no_urut'];?>" /></td>
                        		<td><input type="text" name="nama_tembusan[]" class="form-control input-sm"  value="<?php echo $datx['tembusan'];?>" /></td>
                        	</tr>
                        <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
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
                        $pathFile 	= Yii::$app->params['pidsus_6umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-6 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah Pidsus-6 Umum';
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
	<input type="hidden" name="no_p8_umum" id="no_p8_umum" value="<?php echo $model['no_p8_umum'];?>" />
    <input type="hidden" name="tgl_p8_umum" id="tgl_p8_umum" value="<?php echo $tgl_p8_umum;?>" /> 
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

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa Penelaah</h4>
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

	/* START AMBIL JPN */
	$(".form-buat-pemberi-kuasa").on("click", "#btn_tambahjpn", function(){
		$("#jpn_modal").find(".modal-body").html("");
		$("#jpn_modal").find(".modal-body").load("/pidsus/get-jpu/index");
		$("#jpn_modal").modal({backdrop:"static"});
	}).on("click", "#btn_hapusjpn", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
		tabel.find(".hRowJpn:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-pemberi-kuasa").find(".table-jpn-modal > tbody");
				nRow.append('<tr><td colspan="4">Data tidak ditemukan</td></tr>');
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
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[5]+'<br />'+param[2]+'</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[5]+'<br />'+param[2]+'</td>'+
			'</tr>');
		}

		$("#cekModalJpn_"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
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

	/* START TEMBUSAN */
	$('#tambah-tembusan').click(function(){
		var tabel	= $('#table_tembusan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_tembusan').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_tembusan[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_tembusan').find("input[name='no_urut[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusTembusan").click(function(){
		var tabel 	= $("#table_tembusan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END TEMBUSAN */
	
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