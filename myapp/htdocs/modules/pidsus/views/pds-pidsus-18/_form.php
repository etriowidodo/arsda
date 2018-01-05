<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus18;

	$this->title = 'Pidsus-18';
	$this->subtitle = 'Surat Penetapan Tersangka / Para Tersangka';
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-18/index';
	$linkCetak		= '/pidsus/pds-pidsus-18/cetak?id1='.rawurlencode($model['no_pidsus18']).'&id2='.rawurlencode($model['no_p8_umum']);
	if($isNewRecord){
		$sqlCek = "select a.no_p8_umum, a.tgl_p8_umum from pidsus.pds_p8_umum a where ".$whereDefault." and a.no_p8_umum = '".$model['no_p8_umum']."'";
		$model 	= PdsPidsus18::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum 		= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_dikeluarkan 	= ($model['tgl_pidsus18'])?date('d-m-Y',strtotime($model['tgl_pidsus18'])):'';
	$ttdJabatan 		= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tempat_dikeluarkan     = ($model['tempat_dikeluarkan'])?$model['tempat_dikeluarkan']:Yii::$app->inspektur->getLokasiSatker()->lokasi;
        
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-18/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor P-8 Umum</label>        
                            <div class="col-md-8">
                                <?php if(!$model['no_p8_umum']){?>
                                <div class="input-group input-group-sm">
                                    <input type="text" name="no_p8_umum" id="no_p8_umum" class="form-control" value="<?php echo $model['no_p8_umum'];?>" readonly />
                                    <span class="input-group-btn"><button class="btn" type="button" id="pilih_p8"><i class="fa fa-search"></i></button></span>
                                </div>
                                <?php } else{ ?>
                                <div class="input-group input-group-sm">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="no_p8_umum" id="no_p8_umum" class="form-control" value="<?php echo $model['no_p8_umum'];?>" readonly/>
                                </div>
                                <?php }?>
                                <div class="help-block with-errors" id="error_custom_no_p8_umum"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Pidsus-18</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_pidsus18" id="no_pidsus18" class="form-control" value="<?php echo $model['no_pidsus18'];?>"  required data-error="Nomor Pidsus-18 belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_pidsus18"></div>
                            </div>
                        </div>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-tersangka">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm disabled" id="btn_hapustsk"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="btn_poptsk"><i class="fa fa-plus jarak-kanan"></i>Tersangka</a>
            </div>		
        </div><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableTsk">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckTsk" id="allCheckTsk" class="allCheckTsk" /></th>
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
                    $resTsk = ($model['no_pidsus18'])?PdsPidsus18::findBySql($sqlTsk)->asArray()->all():array();
                    if(count($resTsk) == 0)
                        echo '<tr class="barisTsk"><td colspan="4">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resTsk as $dtTsk){
                            $nomTsk = $dtTsk['no_urut_tersangka'];
                            echo '
                            <tr data-id="'.$nomTsk.'" class="barisTsk">
                                <td class="text-center">
                                    <input name="nama['.$nomTsk.']" class="tersangka" value="'.$dtTsk['nama'].'" type="hidden">
                                    <input name="tmpt_lahir['.$nomTsk.']" class="tersangka" value="'.$dtTsk['tmpt_lahir'].'" type="hidden">
                                    <input name="tgl_lahir['.$nomTsk.']" class="tersangka" value="'.date('d-m-Y',strtotime($dtTsk['tgl_lahir'])).'" type="hidden">
                                    <input name="umur['.$nomTsk.']" class="tersangka" value="'.$dtTsk['umur'].'" type="hidden">
                                    <input name="warganegara['.$nomTsk.']" class="tersangka" value="'.$dtTsk['warganegara'].'" type="hidden">
                                    <input name="kebangsaan['.$nomTsk.']" class="tersangka" value="'.$dtTsk['kebangsaan'].'" type="hidden">
                                    <input name="suku['.$nomTsk.']" class="tersangka" value="'.$dtTsk['suku'].'" type="hidden">
                                    <input name="id_identitas['.$nomTsk.']" class="tersangka" value="'.$dtTsk['id_identitas'].'" type="hidden">
                                    <input name="no_identitas['.$nomTsk.']" class="tersangka" value="'.$dtTsk['penggeledahan_terhadap'].'" type="hidden">
                                    <input name="id_agama['.$nomTsk.']" class="tersangka" value="'.$dtTsk['no_identitas'].'" type="hidden">
                                    <input name="alamat['.$nomTsk.']" class="tersangka" value="'.$dtTsk['alamat'].'" type="hidden">
                                    <input name="no_hp['.$nomTsk.']" class="tersangka" value="'.$dtTsk['no_hp'].'" type="hidden">
                                    <input name="id_pendidikan['.$nomTsk.']" class="tersangka" value="'.$dtTsk['id_pendidikan'].'" type="hidden">
                                    <input name="pekerjaan['.$nomTsk.']" class="tersangka" value="'.$dtTsk['pekerjaan'].'" type="hidden">
                                    <input type="checkbox" name="cekTsk['.$nomTsk.']" id="cekTsk'.$nomTsk.'" class="hRowCekTsk" value="'.$nomTsk.'" />
                                </td>
                                <td class="text-center"><span class="frmnotsk" data-row-count="'.$nomTsk.'">'.$nomTsk.'</span></td>
                                <td class="text-left"><a style="cursor:pointer" class="ubahTersangka">'.$dtTsk['nama'].'</a></td>
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
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Undang-undang &amp; Pasal</h3>
    </div>
    <div class="box-body">
        <div id="table_uu">
                        <?php 
                        $sqlUU = "
                            select a.* from pidsus.pds_pidsus18_uu_pasal a
                            where ".$whereDefault." and a.no_pidsus18 = '".$model['no_pidsus18']."' order by a.id_uu_pasal";
                            $resUU = ($model['no_pidsus18'])?PdsPidsus18::findBySql($sqlUU)->asArray()->all():array();
                            
                            $modelUun = (count($resUU) == 0)?array(1=>array("")):$resUU;
                            
                                foreach($modelUun as $rowUun){
                                        $cls1 		= 'class="form-control txtUndangPasal"';
                                        $undang_uu 	= $rowUun['undang'];
                                        $idx1           = $rowUun['id_uu_pasal'];
                                        echo '
                                        <div style="padding:10px; margin-bottom:15px; border:1px solid #f29db2;" class="tr" data-id="'.$idx1.'">
                                                '.($idx1 > 1?'<button class="btn btn-danger btn-sm hapus-dakwaan pull-right" data-id="'.$idx1.'">Hapus</button>':'').'
                                                <div class="row">        
                                                        <div class="col-md-10">
                                                                <div class="form-group form-group-sm">
                                                                        <label class="control-label col-md-2">Undang-undang</label>
                                                                        <div class="col-md-8">
                                                                                <div class="input-group input-group-sm">
                                                                                        <input type="hidden" name="modal1_undang_id['.$idx1.']" id="modal1_undang_id'.$idx1.'" value="'.$rowUun['undang_id'].'" />
                                                                                        <input type="text" name="undang_uu['.$idx1.']" id="undang_uu'.$idx1.'" '.$cls1.' value="'.$undang_uu.'" readonly />
                                                                                        <span class="input-group-btn"><button type="button" class="btn undang" data-id="'.$idx1.'">Pilih</button></span>
                                                                                </div>
                                                                                <div class="help-block with-errors" id="error_custom_modal1_undang_uu'.$idx1.'"></div>
                                                                        </div>
                                                                </div>
                                                        </div>
                                                </div>
                                                <div class="row">        
                                                        <div class="col-md-10">
                                                                <div class="form-group form-group-sm">
                                                                        <label class="control-label col-md-2">Pasal</label>
                                                                        <div class="col-md-8">
                                                                                <div class="input-group input-group-sm">
                                                                                        <input type="hidden" name="modal1_id_pasal['.$idx1.']" id="modal1_id_pasal'.$idx1.'" value="'.$rowUun['id_pasal'].'"/>
                                                                                        <input type="text" name="pasal['.$idx1.']" id="pasal'.$idx1.'" '.$cls1.' value="'.$rowUun['pasal'].'" readonly />
                                                                                        <span class="input-group-btn"><button type="button" class="btn pasal" data-id="'.$idx1.'">Pilih</button></span>
                                                                                </div>
                                                                                <div class="help-block with-errors" id="error_custom_modal1_pasal'.$idx1.'"></div>
                                                                        </div>
                                                                </div>
                                                        </div> 
                                                </div>
                                                <div class="row">        
                                                        <div class="col-md-10">
                                                                <div class="form-group form-group-sm">
                                                                        <label class="control-label col-md-2">Dakwaan</label>
                                                                        <div class="col-md-4">
                                                                                <select name="dakwaan['.$idx1.']" id="dakwaan'.$idx1.'" class="select2 dakwaan" data-id="'.$idx1.'" style="width:100%;">
                                                                                        <option value=""></option>
                                                                                        <option value="1"'.($rowUun['dakwaan'] == 1?' selected':'').'>-- Juncto --</option>
                                                                                        <option value="2"'.($rowUun['dakwaan'] == 2?' selected':'').'>-- Dan --</option>
                                                                                        <option value="3"'.($rowUun['dakwaan'] == 3?' selected':'').'>-- Atau --</option>
                                                                                        <option value="4"'.($rowUun['dakwaan'] == 4?' selected':'').'>-- Subsider --</option>
                                                                                </select>
                                                                        </div>
                                                                </div>
                                                        </div> 
                                                </div>
                                        </div>';
                                }
                            
                         ?>
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
                        	if($model['no_pidsus18'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pidsus-18' order by no_urut";
                        		$resx = PdsPidsus18::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select a.no_urut, a.tembusan from pidsus.pds_pidsus18_tembusan a 
						where ".$whereDefault." and a.no_pidsus18 = '".$model['no_pidsus18']."' order by a.no_urut";
                        		$resx = PdsPidsus18::findBySql($sqlx)->asArray()->all();
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
                                <input type="text" name="tempat_dikeluarkan" id="tempat_dikeluarkan" class="form-control" value="<?php echo $tempat_dikeluarkan;?>" required data-error="Kolom [Dikeluarkan di] belum diisi" />
                                <div class="help-block with-errors"></div>
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
                                    <input type="text" class="form-control datepicker" id="tgl_dikeluarkan" name="tgl_dikeluarkan" value="<?php echo $tgl_dikeluarkan;?>" required data-error="Tanggal Dikeluarkan Belum diisi" />
                                </div>						
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_dikeluarkan"></div></div>
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
                        $pathFile 	= Yii::$app->params['pidsus_18'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-18';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah Pidsus-18';
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
    <input type="hidden" name="tgl_p8_umum" id="tgl_p8_umum" value="<?php echo $tgl_p8_umum;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
    <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="p8_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar P-8 Umum Dilanjutkan</h4>
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

<!--UNDANG-UNDANG-->
<div class="modal fade" id="pilih_undang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM1UU" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Undang Undang</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--PASAL-->
<div class="modal fade" id="form_pasal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM1Psl" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pasal</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah_tsk_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Tersangka</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="kewarganegaraan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeMWgn"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kewarganegaraan</h4>
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
        /* START AMBIL P-8 */
	$("#pilih_p8").on('click', function(e){
		$("#p8_modal").find(".modal-body").html("");
		$("#p8_modal").find(".modal-body").load("/pidsus/pds-pidsus-18/getp8");
		$("#p8_modal").modal({backdrop:"static"});
	});
	$("#p8_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-p8-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		$("#no_p8_umum").val(decodeURIComponent(param[0]));
		$("#tgl_p8_umum").val(decodeURIComponent(param[1]));
		$("#p8_modal").modal("hide");
	}).on('click', "#idPilihP8Modal", function(){
		var modal = $("#p8_modal").find("#tabel-p8-modal");
		var index = modal.find(".pilih-p8-modal:checked").val();
		var param = index.toString().split('|#|');
		$("#no_p8_umum").val(decodeURIComponent(param[0]));
                $("#tgl_p8_umum").val(decodeURIComponent(param[1]));
		$("#p8_modal").modal("hide");
	}).on('click','#idBatalP8Modal', function(){
		$("#p8_modal").modal("hide");
	});
	/* END AMBIL P-6 */
        /* START TERSANGKA */
	$(".form-buat-tersangka").on("click", "#btn_poptsk", function(){
		$("#tambah_tsk_modal").find(".modal-body").html("");
		$("#tambah_tsk_modal").find(".modal-body").load("/pidsus/pds-pidsus-18/gettsk",function(e){
			$("#nurec_tersangka").val('1');
			$("#simpan_form_tersangka").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
		});
		$("#tambah_tsk_modal").modal({backdrop:"static"});
	}).on("click", ".ubahTersangka", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".tersangka").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-pidsus-18/gettsk", objk, function(data){
			$("#tambah_tsk_modal").find(".modal-body").html("");
			$("#tambah_tsk_modal").find(".modal-body").html(data);
			$("#tambah_tsk_modal").find("#tr_id_tersangka").val(trid);
			$("#tambah_tsk_modal").find("#nurec_tersangka").val('0');
			$("#tambah_tsk_modal").find("#simpan_form_tersangka").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
			$("#tambah_tsk_modal").modal({backdrop:"static", keyboard:false});
		});
	}).on("click", "#btn_hapustsk", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-tersangka").find("#tableTsk");
		tabel.find(".hRowCekTsk:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-tersangka").find("#tableTsk > tbody");
				nRow.append('<tr class="barisTsk"><td colspan="6">Data tidak ditemukan</td></tr>');
				$("#btn_hapustsk").addClass("disabled");
			}
		});
		tabel.find(".frmnotsk").each(function(i,v){$(this).text(i+1);});
	}).on("ifChecked", "#tableTsk input[name=allCheckTsk]", function(){
		$(".hRowCekTsk").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#tableTsk input[name=allCheckTsk]", function(){
		$(".hRowCekTsk").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#tableTsk .hRowCekTsk", function(e){
		var elem = $(this);
		var temp = $(this).parents("tr").first();
		var trid = temp.data("id");
		var objk = temp.find("input[name^='jpngldhid["+trid+"]']").length;
		if(objk > 0){
			setTimeout(function(){ elem.iCheck('uncheck');}, 0);
		} else{
			var n = $(".hRowCekTsk:checked").length;
			(n >= 1)?$("#btn_hapustsk").removeClass("disabled"):$("#btn_hapustsk").addClass("disabled");
		}
	}).on("ifUnchecked", "#tableTsk .hRowCekTsk", function(){
		var n = $(".hRowCekTsk:checked").length;
		(n > 0)?$("#btn_hapustsk").removeClass("disabled"):$("#btn_hapustsk").addClass("disabled");
	});

	$("#tambah_tsk_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
		formValuesJPPGldh = JSON.parse(localStorage.getItem('formValuesJPPGldh')) || {};
		$("#tambah_tsk_modal").find(".table-jpn-gldh-modal tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPPGldh[idnya] = idnya;
		});
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
		$("#form-modal-tsk").validator({disable:false});
		$("#form-modal-tsk").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#form-modal-tsk").find(".with-errors").html("");
				$("#evt_tersangka_sukses").trigger("validasi.oke.tersangka");
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		if($(e.target).attr("id") == "tambah_tsk_modal")
			$(this).find('form#form-modal-tsk').off('submit').validator('destroy');
	}).on("validasi.oke.tersangka", "#evt_tersangka_sukses", function(){
		var frmnya = $("#tambah_tsk_modal").find("#form-modal-tsk").serializeArray();
		var arrnya = {};
		$.each(frmnya, function(k, v){ arrnya[v.name] = v.value; });
		if(arrnya['nurec_tersangka'] == 1){
			var tabel 	= $("#tableTsk");
			var rwTbl	= tabel.find('tbody > tr.barisTsk:last');
			var rwNom	= parseInt(rwTbl.data('id'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-pidsus-18/settsk", frmnya, function(data){
				if(isNaN(rwNom)){
					rwTbl.remove();
					rwTbl = tabel.find('tbody');
					rwTbl.append(data.hasil);
				} else{
					rwTbl.after(data.hasil);
				}
				$("#cekTsk"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				tabel.find(".frmnotsk").each(function(i,v){$(this).text(i+1);});
				$("#tambah_tsk_modal").modal('hide');
			}, "json");
		} else{
			var tabel = $("#tableTsk").find("tr[data-id='"+arrnya['tr_id_tersangka']+"']");
			var newId = arrnya['tr_id_tersangka'];
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-pidsus-18/settsk", frmnya, function(data){
				tabel.html(data.hasil);
				$("#cekTsk"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#tableTsk").find(".frmnotsk").each(function(i,v){$(this).text(i+1);});
				$("#tambah_tsk_modal").modal('hide');
			}, "json");
		}
		formValuesJPPGldh = {};
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
	}).on("focus", "#modal_kebangsaan",function(){
		$("#kewarganegaraan_modal").find(".modal-body").load("/pidsus/get-kewarganegaraan/index");
		$("#kewarganegaraan_modal").modal({backdrop:"static", keyboard:false});
	});
	$("#kewarganegaraan_modal").on('show.bs.modal', function(e){
		$("#wrapper-modal-tsk").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-tsk").removeClass("loading");
	}).on("click", ".closeMWgn", function(){
		$("#kewarganegaraan_modal").modal("hide");
	}).on("click", "#table-wgn-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToWgn(param);
		$("#kewarganegaraan_modal").modal("hide");
	}).on('click', "#idPilihWgnModal", function(){
		var modal = $("#kewarganegaraan_modal").find("#table-wgn-modal");
		var index = modal.find(".pilih-wgn-modal:checked").val();
		var param = index.toString().split('#');
		insertToWgn(param);
		$("#kewarganegaraan_modal").modal("hide");
	});
	function insertToWgn(param){
		$("#modal_warganegara").val(param[0]);
		$("#modal_kebangsaan").val(param[1]);
	}
	/* END WARGANEGARA */
	/* END TERSANGKA */
        
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
        
        /* START UNDANG-UNDANG PASAL */
	$('#table_uu').on('click',".undang", function(e){
		setId($(this).data("id"));
		$("#pilih_undang").find(".modal-body").html("");
		$("#pilih_undang").find(".modal-body").load("/pidsus/pds-pidsus-18/getformundang");
		$("#pilih_undang").modal({backdrop:"static", keyboard:false});
	}).on('click', '.pasal',function(e){
		setId($(this).data("id"));
		var ida = $('#modal1_undang_id'+id).val();
		if(ida == ""){
			bootbox.alert({message: "Silahkan pilih Undang-undang terlebih dahulu", size:'small', 
				callback: function(){
					$("#pilih_pasal").focus();
				}
			});
		}else{
			$("#form_pasal").find(".modal-body").html("");
			$("#form_pasal").find(".modal-body").load("/pidsus/pds-pidsus-18/getformpasal?jnsins_id="+ida);
			$("#form_pasal").modal({backdrop:"static"});
		}
	}).on('change','.dakwaan', function(e){
		var dak 	= $(this).data("id");
		var tabel	= $('#table_uu').find('.tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		var cek 	= newId - parseInt(dak);
		if(cek == 1){
			$('#table_uu').append(
			'<div style="padding:10px; margin-bottom:15px; border:1px solid #f29db2;" class="tr" data-id="'+newId+'">'+
				'<button class="btn btn-danger btn-sm hapus-dakwaan pull-right" data-id="'+newId+'">Hapus</button>'+
				'<div class="row">'+        
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Undang-undang</label>'+
							'<div class="col-md-8">'+
								'<div class="input-group input-group-sm">'+
									'<input type="hidden" name="modal1_undang_id['+newId+']" id="modal1_undang_id'+newId+'" value="" />'+
									'<input type="text" name="undang_uu['+newId+']" id="modal1_undang_uu'+newId+'" class="form-control txtUndangPasal" value="" readonly />'+
									'<span class="input-group-btn"><button type="button" class="btn undang" data-id="'+newId+'">Pilih</button></span>'+
								'</div>'+
								'<div class="help-block with-errors" id="error_custom_modal1_undang_uu'+newId+'"></div>'+
							'</div>'+
						'</div>'+
					'</div>' +
				'</div>'+
				'<div class="row">'+        
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Pasal</label>'+
							'<div class="col-md-8">'+
								'<div class="input-group input-group-sm">'+
									'<input type="hidden" name="modal1_id_pasal['+newId+']" id="modal1_id_pasal'+newId+'" value="" />'+
									'<input type="text" name="pasal['+newId+']" id="modal1_pasal'+newId+'" class="form-control txtUndangPasal" value="" readonly />'+
									'<span class="input-group-btn"><button type="button" class="btn pasal" data-id="'+newId+'">Pilih</button></span>'+
								'</div>'+
								'<div class="help-block with-errors" id="error_custom_modal1_pasal'+newId+'"></div>'+
							'</div>'+
						'</div>'+
					'</div> '+
				'</div>'+
				'<div class="row">'+       
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Dakwaan</label>'+
							'<div class="col-md-4">'+
								'<select name="dakwaan['+newId+']" id="modal1_dakwaan'+newId+'" class="select2 dakwaan" data-id="'+newId+'" style="width:100%;">'+
									'<option value=""></option>'+
									'<option value="1">-- Juncto --</option>'+
									'<option value="2">-- Dan --</option>'+
									'<option value="3">-- Atau --</option>'+
									'<option value="4">-- Subsider --</option>'+
								'</select>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>');
			$("#modal1_dakwaan"+newId).select2({placeholder:"Pilih salah satu", allowClear:true});
		}
	}).on('click','.hapus-dakwaan',function(e){
		var id = $(this).data('id');
		$('#table_uu').find(".tr[data-id='"+id+"']").remove();
	});
	
	var id;   
	function setId(id1){
		id =id1;
	}
	 
	$("#pilih_undang").on('show.bs.modal', function(e){
		$("#wrapper-modal-pengantar").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-pengantar").removeClass("loading");
		var $target = $(this).find(".modal-body").first();
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
	}).on("click", ".closeM1UU", function(){
		$("#pilih_undang").modal("hide");
	}).on("dblclick", "#tblModalUu td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split("|#|");
		insertToUu(param);
		$("#pilih_undang").modal('hide');
	}).on('click','.pilihModalUU',function(e){
		var index = $(this).data('id');
		var param = index.toString().split("|#|");
		insertToUu(param);
		$("#pilih_undang").modal('hide');
	});
	function insertToUu(param){;
		$("#modal1_undang_id"+id).val(decodeURIComponent(param[0]));
		$("#undang_uu"+id).val(decodeURIComponent(param[1]));
	}
	
	$("#form_pasal").on('show.bs.modal', function(e){
		$("#wrapper-modal-pengantar").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-pengantar").removeClass("loading");
		var $target = $(this).find(".modal-body").first();
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
	}).on("click", ".closeM1Psl", function(){
		$("#form_pasal").modal("hide");
	}).on("dblclick", "#tblModalPasal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split("|#|");
		insertToPasal(param);
		$("#form_pasal").modal('hide');
	}).on('click','.pilihModalPasal',function(e){
		var index = $(this).data('id');
		var param = index.toString().split("|#|");
		insertToPasal(param);
		$("#form_pasal").modal('hide');
	});
	function insertToPasal(param){
		$("#modal1_id_pasal"+id).val(decodeURIComponent(param[0]));
		$("#pasal"+id).val(decodeURIComponent(param[1]));
	}
	/* END UNDANG-UNDANG PASAL */
});
	
</script>