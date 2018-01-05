<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsBa16Umum;

	$this->title = 'BA-13 Umum';
	$this->subtitle = 'Berita Acara Penggeledahan/Penyitaan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-ba16-umum/index';
	$linkCetak		= '/pidsus/pds-ba16-umum/cetak?id1='.rawurlencode($model['no_ba16_umum']).'&id2='.rawurlencode($model['tgl_ba16_umum']);
	if($isNewRecord){
		$sqlCek = "select a.no_p8_umum, a.tgl_p8_umum from pidsus.pds_p8_umum a where ".$whereDefault;
		$model 	= PdsBa16Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum 		= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_ba16_umum 		= ($model['tgl_ba16_umum'])?date('d-m-Y',strtotime($model['tgl_ba16_umum'])):'';
	$tgl_b4_umum 		= ($model['tgl_b4_umum'])?date('d-m-Y',strtotime($model['tgl_b4_umum'])):'';
	$tgl_surat_pn 		= ($model['tgl_surat_pn'])?date('d-m-Y',strtotime($model['tgl_surat_pn'])):'';
	$tgl_dikeluarkan 	= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan 		= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tempat_dikeluarkan     = ($model['dikeluarkan'])?$model['dikeluarkan']:Yii::$app->inspektur->getLokasiSatker()->lokasi;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-ba16-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tangga BA-16 Umum</label>
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_ba16_umum" id="tgl_ba16_umum" class="form-control datepicker" value="<?php echo $tgl_ba16_umum;?>" />
                            <div class="help-block with-errors" id="error_custom_tgl_ba16_umum"></div>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor B-4 Umum</label>        
                    <div class="col-md-8">
                        <?php if(!$model['no_b4_umum']){?>
                        <div class="input-group input-group-sm">
                            <input type="text" name="no_b4_umum" id="no_b4_umum" class="form-control" value="<?php echo $model['no_b4_umum'];?>" readonly />
                            <span class="input-group-btn"><button class="btn" type="button" id="pilih_b4"><i class="fa fa-search"></i></button></span>
                        </div>
                        <?php } else{ ?>
                            <input type="text" name="no_b4_umum" id="no_b4_umum" class="form-control" value="<?php echo $model['no_b4_umum'];?>" readonly />
                        <?php }?>
                        <div class="help-block with-errors" id="error_custom_no_b4_umum"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal B-4 Umum</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_b4_umum" id="tgl_b4_umum" class="form-control" value="<?php echo $tgl_b4_umum;?>" readonly/>
                            <div class="help-block with-errors" id="error_custom_tgl_b4_umum"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Surat Penetapan Ketua PN</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_surat_pn" id="no_surat_pn" class="form-control" value="<?php echo $model['no_surat_pn'];?>" maxlength="50"  required data-error="Nomor Surat PN belum diisi"/>
                    <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Surat Penetapan Ketua PN</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_surat_pn" id="tgl_surat_pn" class="form-control datepicker" value="<?php echo $tgl_surat_pn;?>"/>
                            <div class="help-block with-errors"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-pemberi-kuasa">
    <div class="box-header with-border">
        <h3 class="box-title">Jaksa Pelaksana</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-jpn-modal" id="tabel_jaksa">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="30%">NIP / Nama</th>
                        <th class="text-center" width="60%">Jabatan / Pangkat &amp; Golongan</th>
                    </tr>
                </thead>
                <tbody class="tbody_tabel_jaksa">
            <?php 
                    $sqlJaksa = "select a.nip_jaksa, a.nama_jaksa, a.gol_jaksa, a.pangkat_jaksa, a.jabatan_jaksa 
                                 from pidsus.pds_b4_umum_jaksa a where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by no_urut";
                    $resJaksa = PdsBa16Umum::findBySql($sqlJaksa)->asArray()->all();
                    if(count($resJaksa) == 0){
                       echo '<tr><td colspan="4" class="barisJaksa">Data tidak ditemukan</td></tr>';
                    } else{
                        $nom = 0;
                        foreach($resJaksa as $data){
                            $nom++;	
                            $idJpn = $data['nip_jaksa']."#".$data['nama_jaksa']."#".$data['test']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];					
                            echo '
                            <tr data-id="'.$data['nip_jaksa'].'">
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
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusSaksi jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-saksi" title="Tambah Saksi"><i class="fa fa-plus jarak-kanan"></i>Saksi</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table_saksi" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%"></th>
                                <th width="10%">No Urut</th>
                                <th width="30%">Nama</th>
                                <th width="25%">Umur</th>
                                <th width="30%">Pekerjaan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        	if($model['tgl_ba16_umum'] != ''){
                                    $sqly = "select * from pidsus.pds_ba16_umum_saksi a 
                                            where ".$whereDefault." and a.no_ba16_umum = '".$model['no_ba16_umum']."' and a.tgl_ba16_umum = '".$model['tgl_ba16_umum']."' order by a.no_urut_saksi";
                                    $resy = PdsBa16Umum::findBySql($sqly)->asArray()->all();
                                    if(count($resy) == 0){
//                                        echo '<tr><td colspan="5" class="barisJaksa">Data tidak ditemukan</td></tr>';
                                    } else{
                                        $no = 1;
                                        foreach($resy as $daty){
                                    ?>
                                        <tr data-id="<?php echo $no;?>">
                                                <td class="text-center">
                                        <input type="checkbox" name="chk_del_saksi[]" id="<?php echo 'chk_del_saksi'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                                                <td><input type="text" name="no_urut_saksi[]" class="form-control input-sm" value="<?php echo $daty['no_urut_saksi'];?>" /></td>
                                                <td><input type="text" name="nama_saksi[]" class="form-control input-sm"  value="<?php echo $daty['nama'];?>" /></td>
                                                <td><input type="text" name="umur_saksi[]" class="form-control input-sm number-only"  value="<?php echo $daty['umur'];?>" /></td>
                                                <td><input type="text" name="pekerjaan_saksi[]" class="form-control input-sm"  value="<?php echo $daty['pekerjaan'];?>" /></td>
                                        </tr>
                                    <?php 
                                            $no++; 
                                        } 
                                    }
                                }?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="box box-primary form-buat-penggeledahan">
    <div class="box-header with-border">
        <h3 class="box-title">Penggeledahan</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableGldh">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="20%">Subyek/Obyek</th>
                        <th class="text-center" width="20%">Milik</th>
                        <th class="text-center" width="35%">Alamat</th>
                        <th class="text-center" width="20%">Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlGeledah = "
                    select a.* from pidsus.pds_b4_umum_pengeledahan a 
                    where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by a.no_urut_penggeledahan";
                    $resGeledah = ($model['no_b4_umum'])?PdsBa16Umum::findBySql($sqlGeledah)->asArray()->all():array();
                    if(count($resGeledah) == 0)
                        echo '<tr class="barisGeledahan"><td colspan="5">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resGeledah as $dtGeledah){
                            $nomGeledah = $dtGeledah['no_urut_penggeledahan'];
                            if($dtGeledah['penggeledahan_terhadap'] == 'Subyek'){
                                    $ygDigeledah = $dtGeledah['nama'].'<br />'.$dtGeledah['jabatan'];
                            } else if($dtGeledah['penggeledahan_terhadap'] == 'Obyek'){
                                    $ygDigeledah = $dtGeledah['tempat_penggeledahan'].'<br />'.$dtGeledah['alamat_penggeledahan'];
                            }
							
                            echo '
                            <tr data-id="'.$nomGeledah.'" class="barisGeledahan">
                                <td class="text-center"><span class="frmnogldh" data-row-count="'.$nomGeledah.'">'.$nomGeledah.'</span></td>
                                <td class="text-left">'.$ygDigeledah.'</td>
                                <td class="text-left">'.$dtGeledah['nama_pemilik'].'</td>
                                <td class="text-left">'.$dtGeledah['alamat_pemilik'].'</td>
                                <td class="text-left">'.$dtGeledah['pekerjaan_pemilik'].'</td>
                            </tr>';
                        }
                    }
                 ?>	
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-penyitaan">
    <div class="box-header with-border">
        <h3 class="box-title">Penyitaan</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableSita">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="20%">Nama Barang</th>
                        <th class="text-center" width="20%">Milik</th>
                        <th class="text-center" width="35%">Alamat</th>
                        <th class="text-center" width="20%">Pekerjaan</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlSita = "
                    select a.* from pidsus.pds_b4_umum_penyitaan a 
                    where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by a.no_urut_penyitaan"; 
                    $resSita = ($model['no_b4_umum'])?PdsBa16Umum::findBySql($sqlSita)->asArray()->all():array();
                    if(count($resSita) == 0)
                        echo '<tr class="barisSitaan"><td colspan="5">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resSita as $dtSita){
                            $nomSita = $dtSita['no_urut_penyitaan'];
                            echo '
                            <tr data-id="'.$nomSita.'" class="barisSitaan">
                                <td class="text-center"><span class="frmnosita" data-row-count="'.$nomSita.'">'.$nomSita.'</span></td>
                                <td class="text-left">'.$dtSita['nama_barang_disita'].'</td>
                                <td class="text-left">'.$dtSita['nama_pemilik'].'</td>
                                <td class="text-left">'.$dtSita['alamat_pemilik'].'</td>
                                <td class="text-left">'.$dtSita['pekerjaan_pemilik'].'</td>
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
                                <input type="hidden" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" />
                                <select name="nip_jaksa" id="nip_jaksa" class="select2" style="width:100%" required data-error="Penandatangan belum diisi">
                                    <option></option>
                                    <?php 
                                        $sqlOpt1 = "select * from pidsus.pds_b4_umum_jaksa a where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by a.no_urut";
                                        $resOpt1 = PdsBa16Umum::findBySql($sqlOpt1)->asArray()->all();
                                        foreach($resOpt1 as $dOpt1){
                                            $selected = ($model['penandatangan_nip'] == $dOpt1['nip_jaksa'])?'selected':'';
                                            $prmnya = $dOpt1['nama_jaksa']."#".$dOpt1['nip_jaksa']."#".$dOpt1['jabatan_jaksa']."#".$dOpt1['gol_jaksa']."#".$dOpt1['pangkat_jaksa'];
                                            echo '<option value="'.$prmnya.'" '.$selected.'>'.$dOpt1['nama_jaksa'].'</option>';
                                        }
                                    ?>
                                </select>
				<div class="help-block with-errors" id="error_custom_penandatangan"></div>
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
                        $pathFile 	= Yii::$app->params['ba16_umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah BA-16 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah BA-16 Umum';
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
    <input type="hidden" name="no_ba16_umum" id="no_ba16_umum" value="<?php echo $model['no_ba16_umum']; ?>" />
    <input type="hidden" name="no_p8_umum" id="no_p8_umum" value="<?php echo $model['no_p8_umum'];?>" />
    <input type="hidden" name="tgl_p8_umum" id="tgl_p8_umum" value="<?php echo $tgl_p8_umum;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<div class="modal fade" id="b4_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar B-4 Umum</h4>
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
        /* START AMBIL B-4 */
	$("#pilih_b4").on('click', function(e){
		$("#b4_modal").find(".modal-body").html("");
		$("#b4_modal").find(".modal-body").load("/pidsus/pds-ba16-umum/getb4");
		$("#b4_modal").modal({backdrop:"static"});
	});
	$("#b4_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-b4-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		$("#no_b4_umum").val(decodeURIComponent(param[0]));
		$("#tgl_b4_umum").val(decodeURIComponent(param[1]));
                getJaksaB4(decodeURIComponent(param[0]));
                getPenggeledahanB4(decodeURIComponent(param[0]));
                getSitaB4(decodeURIComponent(param[0]));
                listJaksaB4(decodeURIComponent(param[0]));
		$("#b4_modal").modal("hide");
	}).on('click', "#idPilihB4Modal", function(){
		var modal = $("#b4_modal").find("#tabel-b4-modal");
		var index = modal.find(".pilih-b4-modal:checked").val();
		var param = index.toString().split('|#|');
		$("#no_b4_umum").val(decodeURIComponent(param[0]));
                $("#tgl_b4_umum").val(decodeURIComponent(param[1]));
                getJaksaB4(decodeURIComponent(param[0]));
                getPenggeledahanB4(decodeURIComponent(param[0]));
                getSitaB4(decodeURIComponent(param[0]));
                listJaksaB4(decodeURIComponent(param[0]));
		$("#b4_modal").modal("hide");
	}).on('click','#idBatalB4Modal', function(){
		$("#b4_modal").modal("hide");
	});
        function getJaksaB4(param){
            var tabel 	= $("#tabel_jaksa");
            var rwTbl	= tabel.find('tbody > tr');
            $.post("/pidsus/pds-ba16-umum/getjaksab4", {id:param}, function(data){
                rwTbl.remove();
                rwTbl = tabel.find('tbody');
                rwTbl.append(data.hasil);
            }, "json");
        }
        function getPenggeledahanB4(param){
            var tabel 	= $("#tableGldh");
            var rwTbl	= tabel.find('tbody > tr');
            $.post("/pidsus/pds-ba16-umum/getgeledahb4", {id:param}, function(data){
                rwTbl.remove();
                rwTbl = tabel.find('tbody');
                rwTbl.append(data.hasil);
            }, "json");
        }
        function getSitaB4(param){
            var tabel 	= $("#tableSita");
            var rwTbl	= tabel.find('tbody > tr');
            $.post("/pidsus/pds-ba16-umum/getsitab4", {id:param}, function(data){
                rwTbl.remove();
                rwTbl = tabel.find('tbody');
                rwTbl.append(data.hasil);
            }, "json");
        }
        function listJaksaB4(param){
            $("#nip_jaksa option").remove();
            $.post("/pidsus/pds-ba16-umum/listjaksab4", {id:param}, function(data){
                $("#nip_jaksa").select2({ 
                        data 		: data.items, 
                        placeholder     : "Pilih salah satu", 
                        allowClear 	: true, 
                });
            }, "json");
        }
	/* END AMBIL B-4 */
        
        /* START PENANDATANGAN */
        $("#nip_jaksa").change(function(){
            var index = $(this).val();
            var param = index.toString().split('#');
            $('#penandatangan_nama').val(param[0]);
            $('#penandatangan_nip').val(param[1]);
            $('#penandatangan_jabatan').val(param[2]);
            $('#penandatangan_gol').val(param[3]);
            $('#penandatangan_pangkat').val(param[4]);
        });
        /* END PENANDATANGAN */
        
        /* START SAKSI */
	$('#tambah-saksi').click(function(){
		var tabel	= $('#table_saksi > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_saksi').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_saksi[]" class="hRow" id="chk_del_saksi'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut_saksi[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_saksi[]" class="form-control input-sm" /> </td>' +
			'<td><input type="text" name="umur_saksi[]" class="form-control input-sm number-only" /> </td>' +
			'<td><input type="text" name="pekerjaan_saksi[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_saksi"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_saksi').find("input[name='no_urut_saksi[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusSaksi").click(function(){
		var tabel 	= $("#table_saksi");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut_saksi[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END SAKSI */
});
	
</script>