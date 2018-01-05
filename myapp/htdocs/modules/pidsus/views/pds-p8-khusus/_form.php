<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsP8Khusus;

	$this->title = 'P-8 Khusus';
	$this->subtitle = 'Surat Perintah Penyidikan (Khusus)';
        
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."'";
	$linkBatal	= '/pidsus/pds-p8-khusus/index';
	$linkCetak	= '/pidsus/pds-p8-khusus/cetak?id1='.$model['no_p8_khusus'];
	    
        $tgl_pidsus18 	= ($model['tgl_pidsus18'])?date('d-m-Y',strtotime($model['tgl_pidsus18'])):'';
        $tgl_p8_khusus 	= ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
        $tgl_p8_umum 	= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-p8-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />	
<div class="box box-primary" style="margin-bottom:30px;">
    <div class="box-header with-border">
        <h3 class="box-title">Pidsus-18 Surat Penetapan Tersangka / Para Tersangka</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Pidsus-18</label>        
                    <div class="col-md-8">
                        <?php if(!$model['no_pidsus18']){?>
                        <div class="input-group input-group-sm">
                            <input type="text" name="no_pidsus18" id="no_pidsus18" class="form-control" value="<?php echo $model['no_pidsus18'];?>" readonly />
                            <span class="input-group-btn"><button class="btn" type="button" id="pilih_pidsus18"><i class="fa fa-search"></i></button></span>
                        </div>
                        <?php } else{ ?>
                        <div class="input-group input-group-sm">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="no_pidsus18" id="no_pidsus18" class="form-control" value="<?php echo $model['no_pidsus18'];?>" readonly />
                        </div>
                        <?php }?>
                        <div class="help-block with-errors" id="error_custom_no_pidsus18"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Pidsus-18</label> 
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_pidsus18" id="tgl_pidsus18" class="form-control" value="<?php echo $tgl_pidsus18;?>" readonly />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_p8_khusus"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor P-8 Umum</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_p8_umum" id="no_p8_umum" class="form-control" value="<?php echo $model['no_p8_umum'];?>" readonly/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal P-8 Umum</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_p8_umum" id="tgl_p8_umum" class="form-control  datepicker" value="<?php echo $tgl_p8_umum;?>" readonly/>
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
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Nomor P-8 Khusus</label>        
            <div class="col-md-8">
                <input type="text" name="no_p8_khusus" id="no_p8_khusus" class="form-control" value="<?php echo $model['no_p8_khusus'];?>" required data-error="Nomor P-8 Umum belum diisi" maxlength="50" />
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
                    <input type="text" name="tgl_p8_khusus" id="tgl_p8_khusus" class="form-control  datepicker" value="<?php echo $tgl_p8_khusus;?>" required data-error="Tanggal P-8 Umum belum diisi" />
                </div>
                <div class="help-block with-errors" id="error_custom_tgl_p8_khusus"></div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Laporan telah terjadi tindak pidana</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-4 col-md-2">
                <div class="form-group form-group-sm">       
                    <div class="col-md-12">
                        <select name="tindak_pidana" id="tindak_pidana" class="select2">
                        <?php 
                            echo '<option value="Korupsi" '.($model['tindak_pidana'] == "Korupsi"?"selected":"").'>Korupsi</option>';
                            if($_SESSION["kode_kejati"] == "00")
                                echo '<option value="HAM" '.($model['tindak_pidana'] == "HAM"?"selected":"").'>Pelanggaran HAM</option>';
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
                    <div class="col-md-12">
                        <textarea class="form-control" id="laporan_pidana" name="laporan_pidana" style="height:100px" maxlength="255"><?php echo $model['laporan_pidana'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary form-buat-tersangka">
    <div class="box-header with-border">
        <h3 class="box-title">Tersangka</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableTsk">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="45%">Nama</th>
                        <th class="text-center" width="45%">Tempat, Tanggal lahir</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlTsk = "
                    select a.*, b.nama as kebangsaan from pidsus.pds_pidsus18_tersangka a
                    left join public.ms_warganegara b on a.warganegara = b.id
                    where ".$whereDefault." and a.no_pidsus18 = '".$model['no_pidsus18']."' order by a.no_urut_tersangka";
                    $resTsk = ($model['no_pidsus18'])? PdsP8Khusus::findBySql($sqlTsk)->asArray()->all():array();
                    if(count($resTsk) == 0)
                        echo '<tr class="barisTsk"><td colspan="4">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resTsk as $dtTsk){
                            $nomTsk = $dtTsk['no_urut_tersangka'];
                            echo '
                            <tr data-id="'.$nomTsk.'" class="barisTsk">
                                <td class="text-center"><span class="frmnotsk" data-row-count="'.$nomTsk.'">'.$nomTsk.'</span></td>
                                <td class="text-left">'.$dtTsk['nama'].'</td>
                                <td class="text-left">'.$dtTsk['tmpt_lahir'].'/ '.date('d-m-Y',strtotime($dtTsk['tgl_lahir'])).'</td>
                            </tr>';
                        }
                    }
                 ?>	
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-pemberi-kuasa">
    <div class="box-header with-border">
        <h3 class="box-title">Jaksa Penyidik</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="btn_popjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a>
            </div>		
        </div><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-jpn-modal">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="30%">NIP / Nama</th>
                        <th class="text-center" width="40%">Jabatan / Pangkat &amp; Golongan</th>
                        <th class="text-center" width="20%">Jaksa Penyidik</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlnya = "select * from pidsus.pds_p8_khusus_jaksa a where ".$whereDefault." and a.no_p8_khusus = '".$model['no_p8_khusus']."' order by no_urut";
                    $hasil 	= PdsP8Khusus::findBySql($sqlnya)->asArray()->all();
                    if(count($hasil) == 0)
                        echo '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
                    else{
                        $nom = 0;
                        $jabatanp8 = array(1=>'Koordinator', 'Ketua Tim', 'Wakil Ketua', 'Sekretaris', 'Anggota');
                        foreach($hasil as $data){
                            $nom++;	
                            $nipnya = $data['nip_jaksa'];
                            $idJpn 	= $data['nip_jaksa']."|#|".$data['gol_jaksa']."|#|".$data['pangkat_jaksa']."|#|".$data['jabatan_jaksa']."|#|".
                                      $data['nama_jaksa']."|#|".$data['jabatan_p8']."|#|";
                  ?>        
                      <tr data-id="<?php echo $nipnya;?>">
                        <td class="text-center">
                            <input type="checkbox" name="chk_del_jaksa[]" id="<?php echo 'chk_del_jaksa'.$nom;?>" class="hRowJpn" value="<?php echo $nipnya;?>" />
                        </td>
                        <td class="text-center"><span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span></td>
                        <td class="text-left"><?php echo $data['nip_jaksa'].'<br />'.$data['nama_jaksa'];?></td>
                        <td class="text-left"><?php echo $data['jabatan_jaksa'].'<br />'.$data['pangkat_jaksa'].' ('.$data['gol_jaksa'].')';?></td>
                        <td class="text-left"><?php echo $jabatanp8[$data['jabatan_p8']];?><input type="hidden" name="jaksa[]" value="<?php echo $idJpn;?>" /></td>
                     </tr>
                 <?php } } ?>
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
                        	if($model['no_p8_khusus'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-8-Khusus' order by no_urut";
                        		$resx = PdsP8Khusus::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_p8_khusus_tembusan a
						where ".$whereDefault." and a.no_p8_khusus = '".$model['no_p8_khusus']."' order by no_urut";
                        		$resx = PdsP8Khusus::findBySql($sqlx)->asArray()->all();
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
                        $pathFile 	= Yii::$app->params['p8khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah File P-8 Khusus';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File P-8 Khusus';
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
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>
<div class="modal fade" id="pidsus18_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Pidsus-18</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah_jaksa_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tambah Jaksa Penyidik</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="jpn_penyidik_modal" role="dialog" tabindex="-1" aria-hidden="true">
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
        localStorage.clear();
	var formValuesJPP = JSON.parse(localStorage.getItem('formValuesJPP')) || {};
        
        /* START AMBIL Pidsus-18 */
	$("#pilih_pidsus18").on('click', function(e){
		$("#pidsus18_modal").find(".modal-body").html("");
		$("#pidsus18_modal").find(".modal-body").load("/pidsus/pds-p8-khusus/getpidsus18");
		$("#pidsus18_modal").modal({backdrop:"static"});
	});
	$("#pidsus18_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-pidsus18-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		$("#no_pidsus18").val(decodeURIComponent(param[0]));
		$("#tgl_pidsus18").val(decodeURIComponent(param[1]));
		$("#no_p8_umum").val(decodeURIComponent(param[2]));
		$("#tgl_p8_umum").val(decodeURIComponent(param[3]));
                getTersangka(decodeURIComponent(param[0]));
                getJaksa(decodeURIComponent(param[2]));
		$("#pidsus18_modal").modal("hide");
	}).on('click', "#idPilihPidsus18Modal", function(){
		var modal = $("#pidsus18_modal").find("#tabel-pidsus18-modal");
		var index = modal.find(".pilih-pidsus18-modal:checked").val();
		var param = index.toString().split('|#|');
		$("#no_pidsus18").val(decodeURIComponent(param[0]));
		$("#tgl_pidsus18").val(decodeURIComponent(param[1]));
		$("#no_p8_umum").val(decodeURIComponent(param[2]));
		$("#tgl_p8_umum").val(decodeURIComponent(param[3]));
                getTersangka(decodeURIComponent(param[0]));
                getJaksa(decodeURIComponent(param[2]));
		$("#pidsus18_modal").modal("hide");
	}).on('click','#idBatalPidsus18Modal', function(){
		$("#pidsus18_modal").modal("hide");
	});
        function getTersangka(id){
            var tabel 	= $("#tableTsk");
            var rwTbl	= tabel.find('tbody > tr:last');
            $.post("/pidsus/pds-p8-khusus/gettsk", {no_pidsus18:id}, function(data){
                rwTbl.remove();
                rwTbl = tabel.find('tbody');
                rwTbl.append(data.hasil);
            }, "json");
        }
        function getJaksa(id){
            var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
            var rwTbl	= tabel.find('tbody > tr:last');
            $.post("/pidsus/pds-p8-khusus/getjaksa", {no_p8_umum:id}, function(data){
                rwTbl.remove();
                rwTbl = tabel.find('tbody');
                rwTbl.append(data.hasil);
                tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPP[idnya] = idnya;
                });
                localStorage.setItem("formValuesJPP", JSON.stringify(formValuesJPP));
                
                rwTbl.find("span.frmnojpn").each(function(k, v){
			var idnya = $(v).data("rowCount");
                        $("#chk_del_jaksa"+idnya).iCheck({checkboxClass: 'icheckbox_square-pink'});
                });
            }, "json");
        }
	/* END AMBIL Pidsus-18 */
        
	/* START AMBIL JAKSA */
	$(".form-buat-pemberi-kuasa").find(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValuesJPP[idnya] = idnya;
	});
	localStorage.setItem("formValuesJPP", JSON.stringify(formValuesJPP));
        
	$(".form-buat-pemberi-kuasa").on("click", "#btn_popjpn", function(){
		$("#tambah_jaksa_modal").find(".modal-body").html("");
		$("#tambah_jaksa_modal").find(".modal-body").load("/pidsus/pds-p8-khusus/getjp");
		$("#tambah_jaksa_modal").modal({backdrop:"static"});
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

		formValuesJPP = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPP[idnya] = idnya;
		});
		localStorage.setItem("formValuesJPP", JSON.stringify(formValuesJPP));
		var n = tabel.find(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});
        
	$("#tambah_jaksa_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("click", "#btn_tambah_mjp", function(){
		$("#jpn_penyidik_modal").find(".modal-body").html("");
		$("#jpn_penyidik_modal").find(".modal-body").load("/pidsus/get-jpu/penyidik");
		$("#jpn_penyidik_modal").modal({backdrop:"static"});
	}).on("click", "#modalBatalJaksaPenyidik", function(){
		$("#tambah_jaksa_modal").modal("hide");
	}).on("click", "#modalPilihJaksaPenyidik", function(){
		$("#error_custom_modal1").html("");
		var nilai1 = $("#mjp_nip_jaksa").val();
		var nilai2 = $("#mjp_jabatan_p8").val();
		if(nilai1 == "" || nilai2 == ""){
			$("#error_custom_modal1").html('<p class="text-red">* Harap lengkapi data anda</p>');
		} else{
			var hasil = $("#tambah_jaksa_modal").find("#form-modal-jaksa-penyidik").serializeArray();
			var hasilObject = "";
			$.each(hasil, function(i,v){
				hasilObject += v.value+"|#|";
			});
			insertToRole(hasil[0].value, hasilObject);
			$("#tambah_jaksa_modal").modal('hide');
		}
	});
        
	function insertToRole(myvar, hasilObject){
		var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.frmnojpn").data('rowCount'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var hasil	= hasilObject.toString().split('|#|');
		var jabatanp8 = ['', 'Koordinator', 'Ketua Tim', 'Wakil Ketua', 'Sekretaris', 'Anggota'];
		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append(
			'<tr data-id="'+myvar+'">' +
				'<td class="text-center"><input type="checkbox" name="chk_del_jaksa[]" class="hRowJpn" id="chk_del_jaksa'+newId+'" value="'+myvar+'"></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span></td>' +
				'<td>'+hasil[0]+'<br />'+hasil[4]+'</td>'+
				'<td>'+hasil[3]+'<br />'+hasil[2]+' ('+hasil[1]+')</td>'+
				'<td>'+jabatanp8[hasil[5]]+'<input type="hidden" name="jaksa[]" value="'+hasilObject+'"/>'+'</td>'+
			'</tr>');
		} else{
			rwTbl.after(
			'<tr data-id="'+myvar+'">' +
				'<td class="text-center"><input type="checkbox" name="chk_del_jaksa[]" class="hRowJpn" id="chk_del_jaksa'+newId+'" value="'+myvar+'"></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span></td>' +
				'<td>'+hasil[0]+'<br />'+hasil[4]+'</td>'+
				'<td>'+hasil[3]+'<br />'+hasil[2]+' ('+hasil[1]+')</td>'+
				'<td>'+jabatanp8[hasil[5]]+'<input type="hidden" name="jaksa[]" value="'+hasilObject+'"/>'+'</td>'+
			'</tr>');
		}
		$("#chk_del_jaksa"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		tabel.find(".frmnojpn").each(function(i,v){$(v).text(i+1);});
		formValuesJPP[myvar] = myvar;
		localStorage.setItem("formValuesJPP", JSON.stringify(formValuesJPP));
	}
        
	$("#jpn_penyidik_modal").on('show.bs.modal', function(e){
		$("#tambah_jaksa_modal").find("#wrapper-modal-jps").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#tambah_jaksa_modal").find("#wrapper-modal-jps").removeClass("loading");
	}).on("dblclick", "#jpn-jpn-penyidik-modal td:not(.aksinya)", function(){
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('#');
		var myvar 	= param[0];
		if(myvar in formValuesJPP === false){
			$('#mjp_nip_jaksa').val(param[0]);
			$('#mjp_nama_jaksa').val(param[1]);
			$('#mjp_gol_jaksa').val(param[3]);
			$('#mjp_pangkat_jaksa').val(param[4]);
			$('#mjp_jabatan_jaksa').val(param[5]);
			$("#jpn_penyidik_modal").modal("hide");
		}
	}).on('click', ".pilih-jpn-penyidik", function(){
		var index 	= $('.pilih-jpnp-modal:checked').val();
		var param	= index.toString().split('#');
		var myvar 	= param[0];
		if(myvar in formValuesJPP === false){
			$('#mjp_nip_jaksa').val(param[0]);
			$('#mjp_nama_jaksa').val(param[1]);
			$('#mjp_gol_jaksa').val(param[3]);
			$('#mjp_pangkat_jaksa').val(param[4]);
			$('#mjp_jabatan_jaksa').val(param[5]);
			$("#jpn_penyidik_modal").modal("hide");
		}
	});
        
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
	/* END AMBIL JAKSA */

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