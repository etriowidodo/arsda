<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsT6;

	$this->title = 'T-6';
	$this->subtitle = 'Permintaan Perpanjangan Penahanan Terhadap Tersangka';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
			   and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-t6/index';
	$linkCetak		= '/pidsus/pds-t6/cetak?id1='.rawurlencode($model['no_pidsus20a']);
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsT6::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_khusus                      = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_dikeluarkan                    = ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$tgl_minta_perpanjang               = ($model['tgl_minta_perpanjang'])?date('d-m-Y',strtotime($model['tgl_minta_perpanjang'])):'';
	$tgl_penahanan                      = ($model['tgl_penahanan'])?date('d-m-Y',strtotime($model['tgl_penahanan'])):'';
	$tgl_penetapan_pn                   = ($model['tgl_penetapan_pn'])?date('d-m-Y',strtotime($model['tgl_penetapan_pn'])):'';
	$tgl_t7                             = ($model['tgl_t7'])?date('d-m-Y',strtotime($model['tgl_t7'])):'';
        $tgl_mulai_perpanjangan_penahanan   = ($model['tgl_mulai_perpanjangan_penahanan'])?date('d-m-Y',strtotime($model['tgl_mulai_perpanjangan_penahanan'])):'';
	$tgl_selesai_perpanjangan_penahanan = ($model['tgl_selesai_perpanjangan_penahanan'])?date('d-m-Y',strtotime($model['tgl_selesai_perpanjangan_penahanan'])):'';
	$ttdJabatan = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-t6/simpan" enctype="multipart/form-data">
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
                    <label class="control-label col-md-4">Nomor T-6</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_t6" id="no_t6" class="form-control" value="<?php echo $model['no_t6'];?>" required data-error="Nomor T-6 belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_t6"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal T-6</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_dikeluarkan" id="tgl_dikeluarkan" class="form-control datepicker" value="<?php echo $tgl_dikeluarkan;?>" required data-error="Tanggal T-6 belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_dikeluarkan"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Sifat</label>
                            <div class="col-md-8">
                                <select name="sifat" id="sifat" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                                    <option></option>
                                    <?php 
                                        $resOpt = PdsT6::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
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
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran'];?>" />
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
                        <textarea name="kepada" id="kepada" class="form-control" style="height:70px;" required data-error="Kolom [Kepada Yth] belum diisi" ><?php echo $model['kepada']; ?></textarea>						
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>
                            <div class="col-md-8">
                                <input type="text" name="di_kepada" id="di_kepada" class="form-control" value="<?php echo $model['di_kepada']; ?>" required data-error="Kolom [Di] belum diisi" />
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
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Surat Perpanjangan Penahanan</label>        
                            <div class="col-md-8">
                                <input type="text" name="minta_perpanjang" id="minta_perpanjang" class="form-control" value="<?php echo $model['minta_perpanjang'];?>" maxlength="100"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Surat Perpanjangan Penahanan</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_minta_perpanjang" id="no_minta_perpanjang" class="form-control" value="<?php echo $model['no_minta_perpanjang'];?>" maxlength="50"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Surat Perpanjangan Penahanan</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_minta_perpanjang" id="tgl_minta_perpanjang" class="form-control datepicker" value="<?php echo $tgl_minta_perpanjang;?>" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_minta_perpanjang"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama Tersangaka</label>
                            <div class="col-md-8">
                                <div class="input-group input-group-sm">
                                    <input type="text" name="nama_tersangka" id="nama_tersangka" class="form-control" value="<?php echo $model['nama_tersangka'];?>" readonly/>
                                    <span class="input-group-btn">
                                        <button class="btn" type="button" id="pilih_tersangka">Pilih</button>
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
                            <label class="control-label col-md-4">Tempat berakhirnya penahanan</label>        
                            <div class="col-md-8">
                                <input type="text" name="tempat_penahanan" id="tempat_penahanan" class="form-control" value="<?php echo $model['tempat_penahanan'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal berakhirnya penahanan</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_penahanan" id="tgl_penahanan" class="form-control datepicker" value="<?php echo $tgl_penahanan;?>" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Penetapan PN</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_penetapan_pn" id="no_penetapan_pn" class="form-control" value="<?php echo $model['no_penetapan_pn'];?>" maxlength="50"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Penetapan PN</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_penetapan_pn" id="tgl_penetapan_pn" class="form-control datepicker" value="<?php echo $tgl_penetapan_pn;?>" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor T-7</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_t7" id="no_t7" class="form-control" value="<?php echo $model['no_t7'];?>" maxlength="50"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal T-7</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_t7" id="tgl_t7" class="form-control datepicker" value="<?php echo $tgl_t7;?>" />
                                </div>
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
    <div class="box-body">
        <div class="table-resonsive">
                <table class="table table-bordered">
                <thead>
                        <tr>
                        <th class="text-center" width="150"></th>
                        <th class="text-center" width="265">Masa Penahanan</th>
                        <th class="text-center" width="">Pasal</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                        <td>
                            <div class="form-group" style="margin:0px;">
                                <label class="control-label">Perpanjangan</label>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-group-sm" style="margin:0px;">
                                <div class="input-group">
                                    <input type="text" name="tgl_mulai_perpanjangan_penahanan" id="tgl_mulai_perpanjangan_penahanan" class="form-control input-sm datepicker" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $tgl_mulai_perpanjangan_penahanan?>" required data-error="Masa Penahanan belum diisi" />
                                    <div class="input-group-addon" style="border:none;">S/D</div>
                                    <input type="text" name="tgl_selesai_perpanjangan_penahanan" id="tgl_selesai_perpanjangan_penahanan" class="form-control input-sm datepicker" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $tgl_selesai_perpanjangan_penahanan?>" required data-error="Masa Penahanan belum diisi" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-group-sm" style="margin:0px;">
                                <input type="text" name="pasal_perpanjangan_penahanan" id="pasal_perpanjangan_penahanan" class="form-control input-sm" value="<?= $model["pasal_perpanjangan_penahanan"]; ?>" required data-error="Pasal Penahanan belum diisi" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                    </tr>
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
                        <a class="btn btn-danger btn-sm hapusAlasan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-alasan" title="Tambah Alasan"><i class="fa fa-plus jarak-kanan"></i>Alasan</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table_alasan" class="table table-bordered">
                        <thead>
							<tr>
                                <th width="10%"></th>
                                <th width="15%">No Urut</th>
                                <th width="75%">Alasan</th>
							</tr>
                        </thead>
                        <tbody>
                        <?php
                            $sqly = "select no_urut as no_urut, alasan from pidsus.pds_t6_alasan 
                                            where ".$whereDefault." and no_t6 = '".$model['no_t6']."' order by no_urut";
                            $resy = PdsT6::findBySql($sqly)->asArray()->all();
                            if(count($resy) != 0){
                        	$no = 1;
                                foreach($resy as $daty):
                        ?>
                        	<tr data-id="<?php echo $no;?>">
                        		<td class="text-center">
                                <input type="checkbox" name="chk_del_alasan[]" id="<?php echo 'chk_del_alasan'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                        		<td><input type="text" name="no_urut_alasan[]" class="form-control input-sm" value="<?php echo $daty['no_urut'];?>" /></td>
                        		<td><input type="text" name="alasan[]" class="form-control input-sm"  value="<?php echo $daty['alasan'];?>" /></td>
                        	</tr>
                            <?php $no++; endforeach; }?>
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
                        	if($model['no_t6'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'T-6' order by no_urut";
                        		$resx = PdsT6::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_t6_tembusan 
                                                where ".$whereDefault." and no_t6 = '".$model['no_t6']."' order by no_urut";
                        		$resx = PdsT6::findBySql($sqlx)->asArray()->all();
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
                        $pathFile 	= Yii::$app->params['t6'].$model['file_upload'];
                        $labelFile 	= 'Unggah T-6';
                        if($model['file_upload_spdp_kembali'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah T-6';
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
        
        /* START ALASAN */
	$('#tambah-alasan').click(function(){
		var tabel	= $('#table_alasan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_alasan').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_alasan[]" class="hRow" id="chk_del_alasan'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut_alasan[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="alasan[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_alasan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_alasan').find("input[name='no_urut_alasan[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusAlasan").click(function(){
		var tabel 	= $("#table_alasan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut_alasan[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END AlASAN */
        
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