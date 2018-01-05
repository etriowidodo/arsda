<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\TahapBantuanHukum;
	
	$sqlCek = "
		select d.deskripsi_inst_wilayah as wil_instansi, d.alamat as alamat_ins, e.deskripsi as nm_propinsi 
		from datun.permohonan a 
		join datun.jenis_instansi b on a.kode_jenis_instansi = b.kode_jenis_instansi
		join datun.instansi c on a.kode_jenis_instansi = c.kode_jenis_instansi and a.kode_instansi = c.kode_instansi and a.kode_tk = c.kode_tk 
		join datun.instansi_wilayah d on a.kode_jenis_instansi = d.kode_jenis_instansi and a.kode_instansi = d.kode_instansi 
			and a.kode_provinsi = d.kode_provinsi and a.kode_kabupaten = d.kode_kabupaten and a.kode_tk = d.kode_tk and a.no_urut_wil = d.no_urut 
		join datun.m_propinsi e on d.kode_provinsi = e.id_prop 
		where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."'";
	$resCek = TahapBantuanHukum::findBySql($sqlCek)->asArray()->one();

	$sqlCek2 = "
		select no_register_skks from datun.skks where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' 
		and no_register_skk = '".$_SESSION['no_register_skk']."' and tanggal_skk = NULLIF ('".$_SESSION['tanggal_skk']."', '')::date";
	$resCek2 = TahapBantuanHukum::findBySql($sqlCek2)->asArray()->all();

	$linkBatal		= '/datun/undangan/index';
	$linkCetak		= '/datun/undangan/cetak?id='.rawurlencode($model['no_surat_undangan']).'&tp='.rawurlencode($model['tahap_undangan']);

	$tgl_permohonan = ($model['tanggal_permohonan'])?date("d-m-Y", strtotime($model['tanggal_permohonan'])):'';
	$tanggal_skk 	= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):'';
	$tanggal_skks 	= ($model['tgl_skks'])?date("d-m-Y", strtotime($model['tgl_skks'])):'';
	$tgl_diterima 	= ($model['tanggal_diterima'])?date("d-m-Y", strtotime($model['tanggal_diterima'])):'';
	$tgl_surat_und 	= ($model['tanggal_surat_undangan'])?date("d-m-Y", strtotime($model['tanggal_surat_undangan'])):'';
	$tgl_undangan 	= ($model['tanggal'])?date("d-m-Y", strtotime($model['tanggal'])):'';
	$jns_undangan 	= ($model['tahap_undangan'] == 1)?'Persiapan':'Persidangan';
	$kepadaYth 		= ($isNewRecord)?$resCek['wil_instansi'].PHP_EOL.$resCek['alamat_ins']:$model['kepada_yth'];
	$tempat 		= ($isNewRecord)?$resCek['nm_propinsi']:$model['di'];
	$ttdJabatan 	= $model['penandatangan_status']." ".$model['penandatangan_ttdjabat'];
	$arr_penggugat 	= explode("#", $model['penggugat']);
	$penggugat 		= "";
	if(count($arr_penggugat) > 0 && $arr_penggugat[0] != ""){
		$jumlah = 0;
		foreach($arr_penggugat as $data_penggugat){
			$jumlah++;
			$separator 	= ($jumlah == count($arr_penggugat) - 1)?' dan ':', ';
			$penggugat .= $data_penggugat.$separator;
		}
		$penggugat = substr($penggugat,0,-2);
	}

?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/undangan/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<p id="error_custom0"></p>
<div class="row">
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Jenis Undangan</label>
            <div class="col-md-8">
                <?php if($isNewRecord){ ?>
                <select id="tahap_undangan" name="tahap_undangan" class="select2" style="width:100%;" required data-error="Jenis undangan belum dipilih">
                    <option></option>
                    <option value="1">Persiapan</option>
                    <?php echo (count($resCek2) > 0)?'<option value="2">Persidangan</option>':''; ?>
                </select>
                <?php } else{ ?>
                <input type="hidden" name="tahap_undangan" id="tahap_undangan" value="<?php echo $model['tahap_undangan'];?>" />
                <input type="text" name="txt_tahap" id="txt_tahap" class="form-control" value="<?php echo $jns_undangan;?>" readonly />
				<?php } ?>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Penggugat</label>        
        			<div class="col-md-8">
						<input type="text" id="penggugat" name="penggugat" class="form-control" value="<?php echo $penggugat;?>" readonly />
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tergugat</label>        
        			<div class="col-md-8">
						<input type="text" id="tergugat" name="tergugat" class="form-control" value="<?php echo $model['tergugat'];?>" readonly />
        			</div>
        		</div>
        	</div>
        </div>

        <div id="main-persiapan">
            <div class="row">            
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Register Perkara</label>
                        <div class="col-md-8">
                            <input type="text" id="no_perkara" name="no_perkara" class="form-control" value="<?php echo $model['no_register_perkara'];?>" readonly />
                        	<div class="help-block with-errors" id="error_custom1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Permohonan</label>
                        <div class="col-md-8">
                            <input type="hidden" id="no_surat" name="no_surat" value="<?php echo $model['no_surat'];?>" />
                            <input type="text" id="no_surat_txt" name="no_surat_txt" class="form-control" value="<?php echo ($model['kode_jenis_instansi'] == '01' || $model['kode_jenis_instansi'] == '06')?'':$model['no_surat'];?>" readonly />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-6 col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tanggal Permohonan</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" id="tgl_permohonan" name="tgl_permohonan" class="form-control" value="<?php echo $tgl_permohonan;?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="main-persidangan" class="<?php echo ($model['tahap_undangan'] != '2'?'hide':'');?>">
            <div class="row">            
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Register SKK</label>
                        <div class="col-md-8">
                            <input type="hidden" id="no_skk" name="no_skk" value="<?php echo $model['no_register_skk'];?>" />
                            <input type="text" id="no_skk_txt" name="no_skk_txt" class="form-control" value="<?php echo ($model['kode_jenis_instansi'] == '01')?'':$model['no_register_skk'];?>" readonly />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tanggal SKK</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" id="tanggal_skk" name="tanggal_skk" class="form-control" value="<?php echo $tanggal_skk;?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">            
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Register SKKS</label>
                        <div class="col-md-8">
                            <input type="text" id="no_skks" name="no_skks" class="form-control" value="<?php echo $model['no_register_skks'];?>" readonly />
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tanggal SKKS</label>
                        <div class="col-md-4">
                            <div class="input-group">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                <input type="text" id="tanggal_skks" name="tanggal_skks" class="form-control" value="<?php echo $tanggal_skks;?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">            
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Diterima di wilayah kerja</label>
        			<div class="col-md-8">
            			<input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo Yii::$app->inspektur->getNamaSatker();?>" readonly />
                    </div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Diterima</label>
        			<div class="col-md-4">
        				<div class="input-group">
        					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        					<input type="text" id="tgl_diterima" name="tgl_diterima" class="form-control" value="<?php echo $tgl_diterima;?>" readonly />
        				</div>
        			</div>
                	<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
				</div>
			</div>
		</div>

	</div>
</div>

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Undangan</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nomor</label>
        			<div class="col-md-8">
            			<input type="text" name="no_und" id="no_und" maxlength="40" class="form-control" value="<?php echo $model['no_surat_undangan']; ?>" required data-error="Nomor undangan belum diisi" <?php echo (!$isNewRecord)?'readonly':'';?> />
                        <div class="help-block with-errors" id="error_custom2"></div>
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Dikeluarkan</label>
        			<div class="col-md-8">
            			<input type="text" id="lok_keluar" name="lok_keluar" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly />
            		</div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Sifat</label>
        			<div class="col-md-8">
						<select name="sifat_und" id="sifat_und" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
							<option></option>
							<?php 
                                $resOpt = TahapBantuanHukum::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
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
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal</label>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tanggal_surat_und" name="tanggal_surat_und" class="form-control datepicker" value="<?php echo $tgl_surat_und;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal surat undangan belum diisi" />
                        </div>						
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom3"></div></div>
            	</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Lampiran</label>
        			<div class="col-md-2">
            			<input type="text" maxlength="2" name="lampiran_und" id="lampiran_und" value="<?php echo $model['lampiran']; ?>" class="form-control number-only-strip" />
            		</div>
            	</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perihal</label>        
                            <div class="col-md-8">
                                <input type="text" name="perihal" id="perihal" value="<?php echo $model['perihal']; ?>" class="form-control" required data-error="Perihal surat belum diisi" />
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
                        <textarea name="untuk" id="untuk" class="form-control" style="height:90px;" required data-error="Kolom [Kepada Yth] belum diisi" ><?php echo $kepadaYth; ?></textarea>						
                    	<div class="help-block with-errors"></div>
                    </div>
            	</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di</label>
                            <div class="col-md-8">
                                <input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo $tempat; ?>" required data-error="Kolom [Di] belum diisi" />
                            	<div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
        </div>
	</div>
</div>
        
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Tanggal dan Waktu</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row"> 
            <div class="col-md-7">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Tanggal</label>
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tgl_und" name="tgl_und" class="form-control datepicker" value="<?php echo $tgl_undangan;?>" placeholder="DD-MM-YYYY" />
                        </div>						
                    </div>
                    <label class="control-label col-md-1">Hari</label>
                    <div class="col-md-4">
                        <input type="text" name="hari_und" id="hari_und" value="<?php echo $model['hari']; ?>" class="form-control" readonly />						
                    </div>
                    <div class="col-md-offset-3 col-md-9"><div class="help-block with-errors" id="error_custom4"></div></div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Jam</label>
                    <div class="col-md-4">
                        <div class="input-group bootstrap-timepicker">
                            <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                            <input type="text" name="jam_und" id="jam_und" value="<?php echo $model['waktu']; ?>" class="form-control timepicker" />
                        </div>
                    </div>
                    <div class="col-md-offset-2 col-md-10"><div class="help-block with-errors" id="error_custom5"></div></div>
                </div>
            </div>
        </div>
        <div class="row"> 
            <div class="col-md-7">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Tempat</label>
                    <div class="col-md-9">
                    	<input type="text" id="tempat_und" name="tempat_und" class="form-control" value="<?php echo $model['tempat']; ?>" required data-error="Kolom [Tempat] belum diisi" />
                    	<div class="help-block with-errors"></div>
                    </div>
                </div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Bertemu dengan</label>        
                            <div class="col-md-9">
                                <input type="text" class="form-control" id="bertemu" name="bertemu" value="<?php echo $model['bertemu'];?>" required data-error="Kolom [Bertemu dengan] belum diisi" />
                    			<div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            </div>
            <div class="col-md-5">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Acara</label>
                    <div class="col-md-10">
                    	<textarea id="acara_und" name="acara_und" class="form-control" style="height:90px;" required data-error="Acara belum diisi"><?php echo $model['acara']; ?></textarea>
                    	<div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        
	</div>
</div>

<div class="row">
	<div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm delTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm addTembusan"><i class="fa fa-plus jarak-kanan"></i>Tembusan</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body" style="padding:15px;">
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
                        	if($model['no_surat_undangan'] == ''){
                        		$sqlx = "select no_urut, tembusan from datun.template_tembusan where kode_template_surat = 'S-3' order by no_urut";
                        		$resx = TahapBantuanHukum::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		if($model['tahap_undangan'] == 1)
									$sqlx = "select no_tembusan as no_urut, deskripsi_tembusan as tembusan from datun.surat_undangan_telaah_tembusan 
											where no_surat = '".$model['no_surat']."' and no_register_perkara = '".$model['no_register_perkara']."' 
											and no_surat_undangan = '".$model['no_surat_undangan']."' order by no_tembusan";
                        		else if($model['tahap_undangan'] == 2)
									$sqlx = "select no_tembusan as no_urut, deskripsi_tembusan as tembusan from datun.surat_undangan_sidang_tembusan 
											where no_surat = '".$model['no_surat']."' and no_register_perkara = '".$model['no_register_perkara']."' 
											and no_surat_undangan = '".$model['no_surat_undangan']."' and no_register_skk = '".$model['no_register_skk']."' 
											and tanggal_skk = '".$model['tanggal_skk']."' order by no_tembusan";
                        		$resx = TahapBantuanHukum::findBySql($sqlx)->asArray()->all();
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
        <fieldset class="scheduler-border">
            <legend class="scheduler-border">Penandatangan :</legend>
            <div class="row">        
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $model['penandatangan_nip']; ?>" />
                            <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $model['penandatangan_status']; ?>" />
                            <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $model['penandatangan_jabatan'];?>" />														
                            <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $model['penandatangan_gol'];?>" />														
                            <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $model['penandatangan_pangkat'];?>" />														
                            <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $model['penandatangan_ttdjabat'];?>" />														
                            <div class="input-group">
                                <input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
                                <div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
                            </div>
                            <div class="help-block with-errors" id="error_custom6"></div>
                        </div>				
                    </div>
                </div>
            </div>
            <div class="row">        
                <div class="col-md-12">
                    <div class="form-group form-group-sm">
                        <div class="col-md-12">
                            <input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
                        </div>				
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_undangan" id="file_undangan" class="form-inputfile" />                    
                <label for="file_undangan" class="label-inputfile">
                    <?php 
                        $tmpPathnya = ($model['tahap_undangan'] == 1)?Yii::$app->params['s3_siap']:Yii::$app->params['s3_sidang'];
						$pathFile 	= $tmpPathnya.$model['file_undangan'];
                        $labelFile 	= 'Upload File Undangan';
                        if($model['file_undangan'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Undangan';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_undangan']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_undangan'], strrpos($model['file_undangan'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_undangan'].'" style="float:left; margin-right:10px;">
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
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="tgl_sp1" id="tgl_sp1" value="<?php echo $model['tanggal_sp1']; ?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
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
	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});

	$("select#tahap_undangan").change(function(){
		$("body").addClass("loading");
		var nilai = $(this).val();
		if(nilai == 1 || nilai == 2){
			$.ajax({
				type	: "POST",
				url		: "/datun/undangan/getundangan",
				data	: { q1 : nilai },
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					$("#main-persidangan").addClass("hide").find("input").val("");
					var arr_penggugat = (data.hasil.penggugat)?data.hasil.penggugat.toString().split("#"):{};
					var penggugat = "", separator = "", jumlah = "";
					if(arr_penggugat.length > 0 && arr_penggugat[0] != ""){
						jumlah = 0;
						for(var i =0; i<arr_penggugat.length; i++){
							jumlah++;
							separator = (jumlah == arr_penggugat.length - 1)?' dan ':', ';
							penggugat += arr_penggugat[i]+separator;
						}
						penggugat = penggugat.substring(0,penggugat.lastIndexOf(", "));
					}

					$("#penggugat").val(penggugat);
					$("#tergugat").val(data.hasil.wil_instansi);
					$("#no_perkara").val(data.hasil.no_register_perkara);
					if(data.hasil.kode_jenis_instansi == '01' || data.hasil.kode_jenis_instansi == '06'){
						$("#no_surat").val(data.hasil.no_surat);
						$("#no_surat_txt").val("");
					} else{
						$("#no_surat").val(data.hasil.no_surat);
						$("#no_surat_txt").val(data.hasil.no_surat);
					}
					$("#tgl_permohonan").val(data.hasil.tgl_permohonan);
					$("#tgl_diterima").val(data.hasil.tgl_diterima);
					$("#bertemu").val(data.hasil.bertemu);
					$("#tgl_sp1").val(data.hasil.tanggal_sp1);
					if(nilai == 2){
						if(data.hasil.kode_jenis_instansi == '01'){
							$("#no_skk").val(data.hasil.no_register_skk);
							$("#no_skk_txt").val("");
						} else{
							$("#no_skk").val(data.hasil.no_register_skk);
							$("#no_skk_txt").val(data.hasil.no_register_skk);
						}
						$("#tanggal_skk").val(data.hasil.tgl_skk);
						$("#no_skks").val(data.hasil.no_register_skks);
						$("#tanggal_skks").val(data.hasil.tgl_skks);
						$("#ketemuan").val(data.hasil.ketemuan);
						$("#main-persidangan").removeClass("hide");
					}
					$("body").removeClass("loading");
				}
			});
		} else{
			$("#main-persiapan").find("input").val("");
			$("#main-persidangan").addClass("hide").find("input").val("");
			$("body").removeClass("loading");
		}
	});

	$("#jam_und").on('focus', function(){
		$(this).prev().trigger('click');
	});

	$("#tgl_und").on('change', function(){
		var nilai = $(this).val();
		var arrHr = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum\'at', 'Sabtu'];
		var hari  = ""; 
		if(nilai != ""){
			var n = new Date(tgl_auto(nilai));
			hari = arrHr[n.getDay()];
		}
		$("#hari_und").val(hari);
	});

	/* START TEMBUSAN */
	$('.addTembusan').click(function(){
		var tabel	= $('#table_tembusan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_tembusan').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_tembusan[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
		$('#table_tembusan').find("input[name='no_urut[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".delTembusan").click(function(){
		var tabel 	= $("#table_tembusan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END TEMBUSAN */

	/* START AMBIL TTD */
	$("#btn_tambahttd, #penandatangan_nama").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/datun/get-ttd/index");
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


