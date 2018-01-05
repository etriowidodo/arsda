<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus17Umum;

	$this->title = 'Pidsus-17 Umum';
	$this->subtitle = 'Pemberitahuan Tidak Dapat Dilakukan Penyitaan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-17-umum/index';
	$linkCetak		= '/pidsus/pds-pidsus-17-umum/cetak?id1='.rawurlencode($model['no_pidsus17_umum']);
	if($isNewRecord){
		$sqlCek = "select a.no_p8_umum, a.tgl_p8_umum from pidsus.pds_p8_umum a where ".$whereDefault;
		$model 	= PdsPidsus17Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum 		= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_penetapan 		= ($model['tgl_penetapan'])?date('d-m-Y',strtotime($model['tgl_penetapan'])):'';
	$tgl_dikeluarkan 	= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan 		= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$dikeluarkan 		= ($model['dikeluarkan'])?$model['dikeluarkan']:Yii::$app->inspektur->getLokasiSatker()->lokasi;
        $kepada                 = ($model['kepada'])?$model['kepada']:'Ketua '.Yii::$app->inspektur->getTtdPengadilan()->p_negeri;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-17-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Pidsus-17 Umum</label>
                    <div class="col-md-8">
                        <input type="text" name="no_pidsus17_umum" id="no_pidsus17_umum" maxlength="50" class="form-control" value="<?php echo $model['no_pidsus17_umum'];?>" required data-error="Nomor Pidsus-17 Umum belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_pidsus17_umum"></div>
                    </div>
            	</div>
            	<div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Sifat</label>
                            <div class="col-md-8">
                                <select name="sifat" id="sifat" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                                    <option></option>
                                    <?php 
                                        $resOpt = PdsPidsus17Umum::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
                                        foreach($resOpt as $dOpt){
                                            $selected = ($model['sifat'] == $dOpt['id'])?'selected':'';
                                            echo '<option value="'.$dOpt['id'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>             		
                            </div>
                        </div>
                    </div>
                </div>
            	<div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>
                            <div class="col-md-2">
                                <input type="text" maxlength="2" name="lampiran" id="lampiran" value="<?php echo $model['lampiran']; ?>" class="form-control number-only-strip" />
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
                        <textarea name="kepada" id="kepada" class="form-control" style="height:90px;" required data-error="Kolom [Kepada Yth] belum diisi" ><?php echo $kepada; ?></textarea>						
                    	<div class="help-block with-errors"></div>
                    </div>
            	</div>
            	<div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>
                            <div class="col-md-8">
                                <input type="text" name="di_tempat" id="di_tempat" class="form-control" value="<?php echo $model['di_tempat']; ?>" required data-error="Kolom [Di] belum diisi" maxlength="128" />
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
        <h3 class="box-title">Penetapan Ijin Penyitaan Ketua PN</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Penetapan</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_penetapan" id="no_penetapan" class="form-control" value="<?php echo $model['no_penetapan'];?>" required data-error="Nomor Penetapan belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Penetapan</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tgl_penetapan" name="tgl_penetapan" class="form-control datepicker" value="<?php echo $tgl_penetapan;?>" required data-error="Tanggal Penetapan belum diisi" />
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary form-buat-sita">
            <div class="box-header with-border">
                <h3 class="box-title">Barang yang Tidak Dilakukan Penyitaan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusSita jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-sita" title="Tambah Barang Sitaan"><i class="fa fa-plus jarak-kanan"></i>Barang Yang Tidak Disita</a>
                    </div>	
                </div><br />
                <div class="table-responsive">
                    <table id="table_sita" class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%"><input type="checkbox" name="allCheckSita" id="allCheckSita" class="allCheckSita" /></th>
                                <th width="10%">No</th>
                                <th width="80%">Nama Barang</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
                            $sqlSita = "select a.* from pidsus.pds_pidsus17_umum_disita a where ".$whereDefault." and a.no_pidsus17_umum = '".$model['no_pidsus17_umum']."' 
                                        order by a.no_urut_disita";
                            $resSita = PdsPidsus17Umum::findBySql($sqlSita)->asArray()->all();
                            $nomSita = 0;
                            if(count($resSita) > 0){
                                foreach($resSita as $datSita){
                                    $nomSita++;
                                    echo '
                                    <tr data-id="'.$nomSita.'">'.
                                        '<td class="text-center"><input type="checkbox" name="cekModalSita[]" id="cekModalSita_'.$nomSita.'" class="hRowSita" value="'.$nomSita.'" /></td>'.
                                        '<td class="text-center"><span class="frmnosita" data-row-count="'.$nomSita.'">'.$nomSita.'</span><input type="hidden" name="nama_barang_disita[]" value="'.$datSita['nama_barang_disita'].'" /></td>'.
                                        '<td>'.$datSita['nama_barang_disita'].'</td>'.
                                    '</tr>';
                                }
                            }else{
                                echo '<tr><td colspan="3">Tidak ada dokumen</td></tr>';
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
    </div>
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Alasan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusAlasan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-alasan" title="Tambah Alasan"><i class="fa fa-plus jarak-kanan"></i>Alasan</a><br>
                    </div>	
                </div><br />
                <div class="table-responsive">
                    <table id="table_alasan" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="10%"></th>
                                <th width="10%">No</th>
                                <th width="80%">Alasan</th>
                            </tr>
                        </thead>
                        <tbody>
						<?php
                            $sqlAlsn = "select a.* from pidsus.pds_pidsus17_umum_alasan a where ".$whereDefault." and a.no_pidsus17_umum = '".$model['no_pidsus17_umum']."' 
										order by a.no_urut";
                            $resAlsn = PdsPidsus17Umum::findBySql($sqlAlsn)->asArray()->all();
                            $nomAlsn = 0;
                            if(count($resAlsn) > 0){
                                foreach($resAlsn as $datAlsn){
                                    $nomAlsn++;
                                    echo '
									<tr data-id="'.$nomAlsn.'">
										<td class="text-center">
										<input type="checkbox" name="chk_del_alasan[]" id="chk_del_alasan'.$nomAlsn.'" class="hRow" value="'.$nomAlsn.'" /></td>
										<td><input type="text" name="no_urut_alasan[]" class="form-control input-sm" value="'.$nomAlsn.'" /></td>
										<td><textarea name="isi_alasan[]" class="form-control input-sm">'.$datAlsn['isi_alasan'].'</textarea></td>
									</tr>';
                                }
                            }else {
                               echo '<tr><td colspan="3">Tidak ada dokumen</td></tr>';;
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
                        	if($model['no_pidsus17_umum'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pidsus-17-Umum' order by no_urut";
                        		$resx = PdsPidsus17Umum::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select a.no_urut, a.tembusan from pidsus.pds_pidsus17_umum_tembusan a 
										where ".$whereDefault." and a.no_pidsus17_umum = '".$model['no_pidsus17_umum']."' order by a.no_urut";
                        		$resx = PdsPidsus17Umum::findBySql($sqlx)->asArray()->all();
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
                                <input type="text" name="dikeluarkan" id="dikeluarkan" class="form-control" value="<?php echo $dikeluarkan;?>" />	
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Dikeluarkan</label>        
                            <div class="col-md-4">
                                <div class="input-group date">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_dikeluarkan" id="tgl_dikeluarkan" class="form-control datepicker" value="<?php echo $tgl_dikeluarkan;?>" required data-error="Tanggal Belum diisi" />
                                </div>						
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_dikeluarkan"></div></div>
                        </div>
                    </div>
                </div>
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
                        $pathFile 	= Yii::$app->params['pidsus_17umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-17 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah Pidsus-17 Umum';
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
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>
<div class="modal fade" id="sita_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Penyitaan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
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

<div class="modal fade" id="sita_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa</h4>
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
	/* START SITA */
        localStorage.clear();
	var formValuesSita = JSON.parse(localStorage.getItem('formValuesSita')) || {};
	$(".form-buat-sita").find("#table_sita input[name='nama_barang_disita[]']").each(function(k, v){
//		var idnya = $(v).data("id");
                var idnya = $(v).val();
		formValuesSita[idnya] = idnya;
	});
	localStorage.setItem("formValuesSita", JSON.stringify(formValuesSita));
        $(".form-buat-sita").on("click", "#tambah-sita", function(){
		$("#sita_modal").find(".modal-body").html("");
		$("#sita_modal").find(".modal-body").load("/pidsus/pds-pidsus-17-umum/listsita");
		$("#sita_modal").modal({backdrop:"static",keyboard:false});
	}).on("click", ".hapusSita", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-sita").find("#table_sita");
		tabel.find(".hRowSita:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-sita").find("#table_sita > tbody");
				nRow.append('<tr><td colspan="3">Tidak ada dokumen</td></tr>');
			}
		});
		tabel.find(".frmnosita").each(function(i,v){$(this).text(i+1);});				

		formValuesSita = {};
		tabel.find("input[name='nama_barang_disita[]']").each(function(k, v){
//			var idnya = $(v).data("id");
                        var idnya = $(v).val();
			formValuesSita[idnya] = idnya;
		});
		localStorage.setItem("formValuesSita", JSON.stringify(formValuesSita));
		var n = tabel.find(".hRowSita:checked").length;
		(n > 0)?$(".hapusSita").removeClass("disabled"):$(".hapusSita").addClass("disabled");
	});

	$("#sita_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#sita-tabel-modal td:not(.aksinya)", function(){
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('|#|');
		var myvar 	= param[0];
		if(myvar in formValuesSita){
			$("#sita_modal").modal("hide");
		} else{
			insertToRole(myvar, index);
			$("#sita_modal").modal("hide");
		}
	}).on('click', ".pilih-sita", function(){
		var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataSITA')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('|#|');
			var myvar 	= param[1];
			insertToRole(myvar, index);
		});
		localStorage.removeItem("modalnyaDataSITA");
		$("#sita_modal").modal("hide");
	});
	function insertToRole(myvar, index){
		var tabel 	= $(".form-buat-sita").find("#table_sita");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.frmnosita").data('rowCount'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('|#|');

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+newId+'">'+
                                        '<td class="text-center"><input type="checkbox" name="cekModalSita[]" id="cekModalSita_'+newId+'" class="hRowSita" value="'+newId+'" /></td>'+
                                        '<td class="text-center"><span class="frmnosita" data-row-count="'+newId+'"></span><input type="hidden" name="nama_barang_disita[]" value="'+param[1]+'" /></td>'+
                                        '<td>'+param[1]+'</td>'+
                                    '</tr>');
		} else{
			rwTbl.after('<tr data-id="'+newId+'">'+
                                        '<td class="text-center"><input type="checkbox" name="cekModalSita[]" id="cekModalSita_'+newId+'" class="hRowSita" value="'+newId+'" /></td>'+
                                        '<td class="text-center"><span class="frmnosita" data-row-count="'+newId+'"></span><input type="hidden" name="nama_barang_disita[]" value="'+param[1]+'" /></td>'+
                                        '<td>'+param[1]+'</td>'+
                                    '</tr>');
		}

		$("#cekModalSita_"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		tabel.find(".frmnosita").each(function(i,v){$(this).text(i+1);});
		formValuesSita[myvar] = myvar;
		localStorage.setItem("formValuesSita", JSON.stringify(formValuesSita));
	}
		
	$(".form-buat-sita").on("ifChecked", "#table_sita input[name=allCheckSita]", function(){
		$(".hRowSita").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#table_sita input[name=allCheckSita]", function(){
		$(".hRowSita").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#table_sita .hRowSita", function(){
		var n = $(".hRowSita:checked").length;
		(n >= 1)?$(".hapusSita").removeClass("disabled"):$(".hapusSita").addClass("disabled");
	}).on("ifUnchecked", "#table_sita .hRowSita", function(){
		var n = $(".hRowSita:checked").length;
		(n > 0)?$(".hapusSita").removeClass("disabled"):$(".hapusSita").addClass("disabled");
	});
	/* END SITA */
        
	/* START ALASAN */
	$('#tambah-alasan').click(function(){
		var tabel	= $('#table_alasan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_alasan').append(
		'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_alasan[]" id="chk_del_alasan'+newId+'" class="hRow" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut_alasan[]" class="form-control input-sm" /></td>'+
			'<td><textarea name="isi_alasan[]" class="form-control input-sm"></textarea></td>'+
		'</tr>');
		$("#chk_del_alasan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_alasan').find("input[name='no_urut_alasan[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusAlasan").click(function(){
		var tabel 	= $("#table_alasan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
                        if(tabel.find("tr").length == 1){
				var nRow = $("#table_alasan > tbody");
				nRow.append('<tr><td colspan="3">Tidak ada dokumen</td></tr>');
			}
		});
		tabel.find("input[name='no_urut_alasan[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END ALASAN */

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