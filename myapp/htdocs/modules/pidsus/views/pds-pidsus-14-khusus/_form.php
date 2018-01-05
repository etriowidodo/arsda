<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus14Khusus;

	$this->title 	= 'Pidsus-14 Khusus';
	$this->subtitle = 'Nota Usul Dinas Pemanggilan Saksi/ Ahli/ Tersangka';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-14-khusus/index';
	$linkCetak		= '/pidsus/pds-pidsus-14-khusus/cetak?id1='.$model['no_urut_pidsus14_khusus'];
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsPidsus14Khusus::findBySql($sqlCek)->asArray()->one();
	}

	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tgl_p8_khusus 	= ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_pidsus14_khusus 	= ($model['tgl_pidsus14_khusus'])?date('d-m-Y',strtotime($model['tgl_pidsus14_khusus'])):'';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-14-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor P-8 Khusus</label>        
                            <div class="col-md-8">
								<input type="text" name="no_p8_khusus" id="no_p8_khusus" class="form-control" value="<?php echo $model['no_p8_khusus'];?>" readonly />
                                <div class="help-block with-errors" id="error_custom_no_p8_khusus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal P-8 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_p8_khusus" id="tgl_p8_khusus" class="form-control" value="<?php echo $tgl_p8_khusus;?>" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>        
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran'];?>" maxlength="30" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pidsus-14 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_pidsus14_khusus" id="tgl_pidsus14_khusus" class="form-control datepicker" value="<?php echo $tgl_pidsus14_khusus;?>" required data-error="Tanggal belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_pidsus14_khusus"></div>
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
        <div class="box box-primary form-buat-nambah-saksi">
            <div class="box-header with-border">
                <h3 class="box-title">Saksi / Ahli / Tersangka</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm jarak-kanan disabled" id="btn_hapussaksi"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="btn_popusul"><i class="fa fa-user-plus jarak-kanan"></i>Saksi / Ahli / Tersangka</a>
                    </div>		
                </div><br />
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="table_saksi">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%"><input type="checkbox" name="allCheckSaksi" id="allCheckSaksi" class="allCheckSaksi" /></th>
                                <th class="text-center" width="5%">#</th>
                                <th class="text-center" width="25%">Nama</th>
                                <th class="text-center" width="15%">Waktu Pelaksanaan</th>
                                <th class="text-center" width="25%">Jaksa yang Melaksanakan</th>
                                <th class="text-center" width="25%">Keperluan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $nom14u = ($model['no_urut_pidsus14_khusus'])?$model['no_urut_pidsus14_khusus']:0;
                            $sqlnya = "select * from pidsus.pds_pidsus14_khusus_saksi_tersangka where ".$whereDefault." and no_urut_pidsus14_khusus = '".$nom14u."' order by no_urut_saksi_tsk";
                            $hasil 	= PdsPidsus14Khusus::findBySql($sqlnya)->asArray()->all();
                            if(count($hasil) == 0)
                                echo '<tr><td colspan="6">Data tidak ditemukan</td></tr>';
                            else{
                                $nom = 0;
                                foreach($hasil as $data){
                                    $nom++;
									$namasnya = $data['nama'].($data['jabatan']?'<br />'.$data['jabatan']:'');	
									$waktunya = date("d-m-Y", strtotime($data['waktu_pelaksanaan']));
									$jaksanya = $data['nip_jaksa']."#".$data['nama_jaksa']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];
									$ars['nama'] 	= $data['nama'];
									$ars['jabatan'] = $data['jabatan'];
									$ars['alamat'] 	= $data['nama'];
									$ars['jaksa'] 	= $jaksanya;
									$ars['tr_id'] 	= $nom;
									$ars['keperluan'] 	= $data['keperluan'];
									$ars['keterangan'] 	= $data['keterangan'];
									$ars['waktu_pelaksanaan'] = $waktunya;
									$ars['status_keperluan']  = $data['status_keperluan'];
									$saksinya = htmlspecialchars(json_encode($ars), ENT_QUOTES);
                          ?>
                              <tr data-id="<?php echo $nom;?>">
                                <td class="text-center">
                                	<input type="checkbox" name="chk_del_tembusan[]" id="<?php echo 'chk_del_tembusan'.$nom;?>" class="hRow" value="<?php echo $nom;?>" />
                                </td>
                                <td class="text-center"><span class="frmnosaksi" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span></td>
                                <td>
                                	<input type="hidden" name="saksi_ahli[]" value="<?php echo $saksinya;?>"/>
                                    <a class="ubahSaksiAhli" style="cursor:pointer" data-saksiahli="<?php echo $saksinya;?>"><?php echo $data['nama'];?></a>
                                </td>
                                <td class="text-center"><?php echo date("d-m-Y", strtotime($data['waktu_pelaksanaan']));?></td>
                                <td><?php echo $data['nama_jaksa'];?></td>
                                <td><?php echo $data['status_keperluan'].'<br />'.$data['keperluan'];?></td>
                             </tr>
                         <?php } } ?>
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
                        $pathFile 	= Yii::$app->params['pidsus_14khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-14 Khusus';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah Pidsus-14 Khusus';
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
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <input type="hidden" name="no_urut_pidsus14_khusus" id="no_urut_pidsus14_khusus" value="<?php echo $model['no_urut_pidsus14_khusus']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="tambah_usul_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Usul Saksi/Ahli/Tersangka</h4>
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
	$(".form-buat-nambah-saksi").on("click", "#btn_popusul", function(){
		$("#tambah_usul_modal").find(".modal-body").html("");
		$("#tambah_usul_modal").find(".modal-body").load("/pidsus/pds-pidsus-14-khusus/getusul", function(){
			$('#tambah_usul_modal').find("#simpan_form_saksi").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');
		});
		$("#tambah_usul_modal").modal({backdrop:"static"});
	}).on("click", "#btn_hapussaksi", function(){
		var tabel = $(".form-buat-nambah-saksi").find("#table_saksi");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-nambah-saksi").find("#table_saksi > tbody");
				nRow.append('<tr><td colspan="6">Data tidak ditemukan</td></tr>');
			}
		});
		tabel.find(".frmnosaksi").each(function(i,v){$(this).text(i+1);});				
		var n = tabel.find(".hRow:checked").length;
		(n > 0)?$("#btn_hapussaksi").removeClass("disabled"):$("#btn_hapussaksi").addClass("disabled");
	}).on("click", "#table_saksi .ubahSaksiAhli", function(){
		$("body").addClass("loading");
		var tr_id 		= $(this).closest("tr").data("id");
		var saksi_ahli 	= $(this).data("saksiahli");
		$.ajax({
			type	: "POST",
			url		: "/pidsus/pds-pidsus-14-khusus/getusul",
			data	: { saksi_ahli : saksi_ahli },
			cache	: false,
			success : function(data){ 
				$("#tambah_usul_modal").find(".modal-body").html("");
				$("#tambah_usul_modal").find(".modal-body").html(data);
				$('#tambah_usul_modal').find("#simpan_form_saksi").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
				$("#tambah_usul_modal").find("#tr_id").val(tr_id);
				$("#tambah_usul_modal").modal({backdrop:"static"});
			}
		});
	}).on("ifChecked", "#table_saksi input[name=allCheckSaksi]", function(){
		$(".hRow").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#table_saksi input[name=allCheckSaksi]", function(){
		$(".hRow").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#table_saksi .hRow", function(){
		var n = $(".hRow:checked").length;
		(n >= 1)?$("#btn_hapussaksi").removeClass("disabled"):$("#btn_hapussaksi").addClass("disabled");
	}).on("ifUnchecked", "#table_saksi .hRow", function(){
		var n = $(".hRow:checked").length;
		(n > 0)?$("#btn_hapussaksi").removeClass("disabled"):$("#btn_hapussaksi").addClass("disabled");
	});
	
	$("#tambah_usul_modal").on('show.bs.modal', function(e){
		$(".with-errors-modal-saksi").html("");
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("click",'#simpan_form_saksi',function(){
		$(".with-errors-modal-saksi").html("");
		var frmnya 	= $("#tambah_usul_modal").find("#frm-m1").serializeArray();
		var hasil 	= {};
		$.each(frmnya, function(k, v){ hasil[v.name] = v.value; });
		if(hasil.nama == "")
			$("#error_custom_saksi_nama").html('<p class="text-red">Nama Saksi/Ahli belum diisi</p>');
		else if(hasil.waktu_pelaksanaan == "")
			$("#error_custom_waktu_pelaksanaan").html('<p class="text-red">Waktu Pelaksanaan belum diisi</p>');
		else if(hasil.jaksa == "")
			$("#error_custom_jaksa").html('<p class="text-red">Jaksa belum dipilih</p>');
		else if(hasil.status_keperluan == "")
			$("#error_custom_status_keperluan").html('<p class="text-red">Kolom diatas belum dipilih</p>');
		else{
			var hasilObject = escapeHtml(JSON.stringify(hasil));
			var tabel = $(".form-buat-nambah-saksi").find("#table_saksi");
			var rwTbl = tabel.find('tbody > tr:last');
			var rwNom = parseInt(rwTbl.find("span.frmnosaksi").data('rowCount'));
			var newId = (isNaN(rwNom))?1:parseInt(rwNom + 1);
			var testj = hasil.jaksa.split("#");
			var testn = hasil.nama+(hasil.jabatan?'<br />'+hasil.jabatan:'');

			if(hasil.tr_id == ""){
				if(isNaN(rwNom)){
					rwTbl.remove();
					rwTbl = tabel.find('tbody');
					rwTbl.append(
					'<tr data-id="'+newId+'">'+
						'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
						'<td class="text-center"><span class="frmnosaksi" data-row-count="'+newId+'"></span></td>'+
						'<td>'+
							'<input type="hidden" name="saksi_ahli[]" value="'+hasilObject+'"/>'+
							'<a class="ubahSaksiAhli" style="cursor:pointer" data-saksiahli="'+hasilObject+'">'+hasil.nama+'</a>'+
						'</td>'+
						'<td class="text-center">'+hasil.waktu_pelaksanaan+'</td>'+
						'<td>'+testj[1]+'</td>'+
						'<td>'+hasil.status_keperluan+'<br />'+hasil.keperluan+'</td>'+
					'</tr>');
				} else{
					rwTbl.after(
					'<tr data-id="'+newId+'">'+
						'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
						'<td class="text-center"><span class="frmnosaksi" data-row-count="'+newId+'"></span></td>'+
						'<td>'+
							'<input type="hidden" name="saksi_ahli[]" value="'+hasilObject+'"/>'+
							'<a class="ubahSaksiAhli" style="cursor:pointer" data-saksiahli="'+hasilObject+'">'+hasil.nama+'</a>'+
						'</td>'+
						'<td class="text-center">'+hasil.waktu_pelaksanaan+'</td>'+
						'<td>'+testj[1]+'</td>'+
						'<td>'+hasil.status_keperluan+'<br />'+hasil.keperluan+'</td>'+
					'</tr>');
				}
			} else{
				$('#table_saksi').find("tr[data-id='"+hasil.tr_id+"']").html(
				'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
				'<td class="text-center"><span class="frmnosaksi" data-row-count="'+newId+'"></span></td>'+
				'<td>'+
					'<input type="hidden" name="saksi_ahli[]" value="'+hasilObject+'"/>'+
					'<a class="ubahSaksiAhli" style="cursor:pointer" data-saksiahli="'+hasilObject+'">'+hasil.nama+'</a>'+
				'</td>'+
				'<td class="text-center">'+hasil.waktu_pelaksanaan+'</td>'+
				'<td>'+testj[1]+'</td>'+
				'<td>'+hasil.status_keperluan+'<br />'+hasil.keperluan+'</td>');
			}
			tabel.find(".frmnosaksi").each(function(i,v){$(v).text(i+1);});
			$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
			$("#tambah_usul_modal").modal('hide');
		}
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