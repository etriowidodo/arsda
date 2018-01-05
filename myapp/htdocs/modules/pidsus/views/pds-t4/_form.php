<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsT4;

	$this->title = 'T-4';
	$this->subtitle = 'Surat perpanjangan Penahanan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/pds-t4/index';
	$linkCetak		= '/pidsus/pds-t4/cetak?id1='.rawurlencode($model['no_minta_perpanjang']).'&id2='.rawurlencode($model['no_t4']);
	$tgl_ttd 		= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$tgl_mulai_thn 	= ($model['tgl_mulai_penahanan'])?date('d-m-Y',strtotime($model['tgl_mulai_penahanan'])):'';
	$tgl_habis_thn 	= ($model['tgl_selesai_penahanan'])?date('d-m-Y',strtotime($model['tgl_selesai_penahanan'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-t4/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Permintaan Perpanjangan</label>        
                            <div class="col-md-8">
                                <?php if($isNewRecord){ ?>
                                <select id="no_minta_perpanjang" name="no_minta_perpanjang" class="select2" style="width:100%;" required data-error="Nomor permintaan perpanjangan belum dipilih">
                                    <option></option>
                                <?php
                                        $sqlx = "
                                        select a.no_minta_perpanjang, a.nama, to_char(d.tgl_nota, 'DD-MM-YYYY')as tgl_nota
                                        from pidsus.pds_minta_perpanjang a 
                                        join pidsus.pds_nota_pendapat_t4 d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari 
                                                and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp and a.no_minta_perpanjang = d.no_minta_perpanjang
                                        left join pidsus.pds_t4 b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                                                and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_minta_perpanjang = b.no_minta_perpanjang
                                        left join pidsus.pds_t5 c on a.id_kejati = c.id_kejati and a.id_kejari = c.id_kejari and a.id_cabjari = c.id_cabjari 
                                                and a.no_spdp = c.no_spdp and a.tgl_spdp = c.tgl_spdp and a.no_minta_perpanjang = c.no_minta_perpanjang 
                                        where ".$whereDefault." and b.no_t4 is null and c.no_t5 is null ";
                                        $resx = PdsT4::findBySql($sqlx)->asArray()->all();
                                        foreach($resx as $datx){
                                            echo '<option value="'.$datx['no_minta_perpanjang'].'">'.$datx['no_minta_perpanjang'].'</option>';
                                        }
                                    ?>
                                                                </select>
                                <?php } else{ ?>
                                <input type="text" name="no_minta_perpanjang" id="no_minta_perpanjang"class="form-control" value="<?php echo $model['no_minta_perpanjang'];?>" readonly/>
                                <?php } ?>
                                <div class="help-block with-errors" id="error_custom_no_minta_perpanjang"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Nota Pendapat T-4</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_nota" id="tgl_nota" class="form-control" readonly="" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_nota'];?>"/>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Surat</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_t4" id="no_t4" class="form-control" value="<?php echo $model['no_t4'];?>" required data-error="No Surat belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_t4"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perpanjangan Penahanan<br />A.n. Tersangka</label>        
                            <div class="col-md-8">
                                <input type="text" name="namaTxt" id="namaTxt" class="form-control" value="<?php echo $model['nama'];?>" readonly />
                                <div class="help-block with-errors" id="error_custom_namaTxt"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-resonsive">
                	<table class="table table-bordered">
                    	<thead>
                        	<tr>
                            	<th class="text-center" width="200">&nbsp;</th>
                            	<th class="text-center" width="180">Jenis Penahanan</th>
                            	<th class="text-center" width="">Lokasi</th>
                            	<th class="text-center" width="26">Masa Penahanan</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                            	<td>Riwayat</td>
                            	<td>
                                    <div class="form-group form-group-sm" style="margin:0px;">
                                        <input type="text" id="jenis_thn" name="jenis_thn" class="form-control" value="<?php echo $model['jenis_thn'];?>" readonly />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </td>
                            	<td>
                                    <div class="form-group form-group-sm" style="margin:0px;">
                                        <input type="text" id="lokasi_thn" name="lokasi_thn" class="form-control" value="<?php echo $model['lokasi_thn'];?>" readonly />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </td>
                            	<td class="text-center">
                                	<div class="form-group form-group-sm" style="margin:0px;">
                                        <div class="input-group">
                                            <input type="text" name="tgl_mulai_thn" id="tgl_mulai_thn" class="form-control" style="width:100px;" value="<?php echo $model["tgl_mulai_thn"];?>" readonly />
                                            <div class="input-group-addon" style="border:none;">S/D</div>
                                            <input type="text" name="tgl_selesai_thn" id="tgl_selesai_thn" class="form-control" style="width:100px;" value="<?php echo $model["tgl_selesai_thn"]?>" readonly />
                                        </div>
                                    	<div class="help-block with-errors"></div>
                                    </div>
								</td>
                            </tr>
                        	<tr>
                            	<td>Perpanjangan</td>
                            	<td>
                                    <div class="form-group form-group-sm" style="margin:0px;">
                                        <select id="jenis_penahanan" name="jenis_penahanan" class="select2" style="width:100%;" required data-error="Jenis Penahanan belum dipilih">
                                            <option></option>
                                            <?php 
                                                $arrJnsThn = array(1=>"Rutan", "Rumah", "Kota");
                                                foreach($arrJnsThn as $idxJnsThn=>$valJnsThn){
                                                    $selected = ($idxJnsThn == $model['jenis_penahanan'])?'selected':'';
                                                    echo '<option value="'.$idxJnsThn.'" '.$selected.'>'.$valJnsThn.'</option>';	
                                                }
                                            ?>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </td>
                            	<td>
                                    <div class="form-group form-group-sm" style="margin:0px;">
                                		<input type="text" name="lokasi_penahanan" id="lokasi_penahanan" class="form-control" value="<?php echo $model["lokasi_penahanan"];?>" required data-error="Lokasi Penahanan belum diisi" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </td>
                            	<td class="text-center">
                                	<div class="form-group form-group-sm" style="margin:0px;">
                                        <div class="input-group">
                                            <input type="text" name="tgl_mulai_penahanan" id="tgl_mulai_penahanan" class="form-control datepicker" style="width:100px;" value="<?php echo $tgl_mulai_thn;?>" required data-error="Masa Penahanan belum diisi" />
                                            <div class="input-group-addon" style="border:none;">S/D</div>
                                            <input type="text" name="tgl_selesai_penahanan" id="tgl_selesai_penahanan" class="form-control datepicker" style="width:100px;" value="<?php echo $tgl_habis_thn;?>" required data-error="Masa Penahanan belum diisi" />
                                        </div>
                                    	<div class="help-block with-errors"></div>
                                    </div>
								</td>
                            </tr>
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
                        	if($model['no_t4'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'T-4' order by no_urut";
                        		$resx = PdsT4::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, deskripsi_tembusan as tembusan from pidsus.pds_t4_tembusan a
										where ".$whereDefault." and a.no_minta_perpanjang = '".$model['no_minta_perpanjang']."' and a.no_t4 = '".$model['no_t4']."' 
										order by a.no_urut";
                        		$resx = PdsT4::findBySql($sqlx)->asArray()->all();
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
                            <label class="control-label col-md-4">Dikeluarkan di</label>        
                            <div class="col-md-8">
                                <input type="text" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" id="lokel" name="lokel" readonly />	
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Ditandatangani</label>        
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" class="form-control datepicker" id="tgldittd" name="tgldittd" value="<?php echo $tgl_ttd;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal Belum diisi" />
                                </div>						
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgldittd"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Penandatangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $model['penandatangan_nip']; ?>" />
                                <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $model['penandatangan_jabatan_pejabat'];?>" />														
                                <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $model['penandatangan_gol'];?>" />														
                                <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $model['penandatangan_pangkat'];?>" />														
                                <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $model['penandatangan_status_ttd']; ?>" />
                                <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $model['penandatangan_jabatan_ttd'];?>" />														
                                <div class="input-group">
                                	<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penandatangan--" readonly />
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
                        $pathFile 	= Yii::$app->params['pdsT4'].$model['file_upload_t4'];
                        $labelFile 	= 'Unggah File T-4';
                        if($model['file_upload_t4'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File T-4';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_t4']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_t4'], strrpos($model['file_upload_t4'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_t4'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo date("d-m-Y", strtotime($_SESSION["tgl_spdp"]));?>" />
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

	$("select#no_minta_perpanjang").on("change", function(){
		var nilai = $(this).val();
		$("body").addClass("loading");
		$("#jenis_thn, #lokasi_thn, #tgl_mulai_thn, #tgl_selesai_thn, #tgl_nota, #namaTxt, #tgl_mulai_penahanan, #tgl_selesai_penahanan").val("");
		if(nilai){
			$.post("/pidsus/pds-t4/get-tersangka", {idnya:nilai}, function(data){
				$("#jenis_thn").val(data.jenis_thn);
				$("#lokasi_thn").val(data.lokasi_thn);
				$("#tgl_mulai_thn").val(data.tgl_mulai_thn);
				$("#tgl_selesai_thn").val(data.tgl_selesai_thn);
				$("#tgl_nota").val(data.tgl_nota);
				$("#namaTxt").val(data.nama);
				$("#tgl_mulai_penahanan").val(data.tgl_awal_permintaan_perpanjangan);
				$("#tgl_selesai_penahanan").val(data.tgl_akhir_permintaan_perpanjangan);
			}, "json");
		}
		$("body").removeClass("loading");
	});
	
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
	$("#btn_tambahttd, #penandatangan_nama, #ttdJabatan").on('click', function(e){
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
<?php } ?>