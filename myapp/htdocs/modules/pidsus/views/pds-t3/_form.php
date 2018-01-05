<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsT3;

	$this->title = 'T-3';
	$this->subtitle = 'Permintaan Perpanjangan Penahanan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-t3/index';
	$linkCetak		= '/pidsus/pds-t3/cetak?id1='.rawurlencode($model['no_pidsus20a']);
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsT3::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_khusus          = ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_t3                 = ($model['tgl_t3'])?date('d-m-Y',strtotime($model['tgl_t3'])):'';
	$tgl_mulai_penahanan    = ($model['tgl_mulai_penahanan'])?date('d-m-Y',strtotime($model['tgl_mulai_penahanan'])):'';
	$tgl_selesai_penahanan  = ($model['tgl_selesai_penahanan'])?date('d-m-Y',strtotime($model['tgl_selesai_penahanan'])):'';
	$tgl_pertimbangan       = ($model['tgl_pertimbangan'])?date('d-m-Y',strtotime($model['tgl_pertimbangan'])):'';
	$ttdJabatan             = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-t3/simpan" enctype="multipart/form-data">
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
                    <label class="control-label col-md-4">Nomor T-3</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_t3" id="no_t3" class="form-control" value="<?php echo $model['no_t3'];?>" required data-error="Nomor T-3 belum diisi" />
                        <div class="help-block with-errors" id="error_custom_no_t3"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal T-3</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_t3" id="tgl_t3" class="form-control datepicker" value="<?php echo $tgl_t3;?>" required data-error="Tanggal T-3 belum diisi" />
                        </div>
                        <div class="help-block with-errors" id="error_custom_tgl_t3"></div>
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
                                        $resOpt = PdsT3::findBySql("select distinct id, nama from ms_sifat_surat order by id")->asArray()->all();
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

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Tersangka</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama</label>        
                    <div class="col-md-8">
                        <div class="input-group input-group-sm">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" required data-error="Kolom [Nama] belum dipilih" />
                            <span class="input-group-btn"><button class="btn" type="button" id="pilih_tersangka"><i class="fa fa-search"></i></button></span>
                        </div>
                        <div class="help-block with-errors" id="error_custom_nama"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Tempat Lahir</label>
                    <div class="col-md-4">
                        <input type="text" name="tmpt_lahir" id="tmpt_lahir" class="form-control chars-only" value="<?php echo $model["tmpt_lahir"];?>" />
                    </div>
                    <label class="control-label col-md-2">Tanggal Lahir</label>
                    <div class="col-md-4">
                         <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker"  value="<?php echo $tgl_lahir;?>" required data-error="Tanggal Lahir belum diisi" />
							<div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>
							<input type="text" name="umur" id="umur" class="form-control" style="width:60px;" value="<?php echo ($model["umur"]?$model["umur"]:'')?>" />
						</div>
                        <div class="help-block with-errors"></div>                            	
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Jenis Kelamin</label>
                    <div class="col-md-8">
                        <input type="radio" name="id_jkl" id="id_jkl1" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> />
                        <label for="id_jkl1" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="id_jkl" id="id_jkl2" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> />
                        <label for="id_jkl2" class="control-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                        <input type="hidden" name="warganegara" id="warganegara" value="<?= $model["warganegara"]?>"/>
                        <input type="text" name="kebangsaan" id="kebangsaan" class="form-control" value="<?= $model["kebangsaan"]?>" placeholder="-Pilih Kewarganegaraan-"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Tinggal</label>
                    <div class="col-md-8">
                        <textarea name="alamat" id="alamat" class="form-control" style="height:75px"><?php echo $model["alamat"];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                	<div class="col-sm-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Agama</label>
                            <div class="col-md-8">
                                <select id="id_agama" name="id_agama" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                         $agm = PdsT3::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
                                        foreach($agm as $ag){
                                            $selected = ($ag['id_agama'] == $model['id_agama'])?'selected':'';
                                            echo '<option value="'.$ag['id_agama'].'" '.$selected.'>'.$ag['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                	<div class="col-sm-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pekerjaan</label>        
                            <div class="col-md-8">
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pendidikan</label>
                                <div class="col-md-8">
                                    <select id="pendidikan" name="pendidikan" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                        $pdd = PdsT3::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                        foreach($pdd as $pd){
                                            $selected = ($pd['id_pendidikan'] === $model['id_pendidikan'])?'selected':'';
                                            echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                        }
                                    ?>
                                </select>
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
                            <label class="control-label col-md-4">Surat Perintah Penangkapan</label>
                            <div class="col-md-8">
                                <input type="text" name="sp_penangkapan" id="sp_penangkapan" value="<?php echo $model['sp_penangkapan']; ?>" class="form-control" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor SP Penangkapan</label>
                            <div class="col-md-8">
                                <input type="text" name="nomor_sp_penangkapan" id="nomor_sp_penangkapan" value="<?php echo $model['nomor_sp_penangkapan']; ?>" maxlength="50" class="form-control" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Surat Perintah Penahanan</label>
                            <div class="col-md-8">
                                <input type="text" name="sp_penahanan" id="sp_penahanan" value="<?php echo $model['sp_penahanan']; ?>" class="form-control" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor SP Penahanan</label>
                            <div class="col-md-8">
                                <input type="text" name="nomor_sp_penahanan" id="nomor_sp_penahanan" value="<?php echo $model['nomor_sp_penahanan']; ?>" maxlength="50" class="form-control" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tindak Pidana</label>
                            <div class="col-md-8">
                                <input type="text" name="tindak_pidana" id="tindak_pidana" class="form-control" value="<?php echo $model['tindak_pidana'];?>"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pasal</label>
                            <div class="col-md-8">
                                <input type="text" name="pasal" id="pasal" value="<?php echo $model['pasal']; ?>" class="form-control" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">UU Nomor </label>
                            <div class="col-md-8">
                                <input type="text" name="uu_nomor" id="uu_nomor" class="form-control" value="<?php echo $model['uu_nomor'];?>"/>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tentang</label>
                            <div class="col-md-8">
                                <input type="text" name="tentang" id="tentang" value="<?php echo $model['tentang']; ?>" class="form-control" />
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
        <h3 class="box-title">Penahanan</h3>
    </div>
    <div class="box-body">
        <div class="table-resonsive">
                <table class="table table-bordered">
                <thead>
                        <tr>
                        <th class="text-center" width="180">Jenis Penahanan</th>
                        <th class="text-center" width="265">Masa Penahanan</th>
                        <th class="text-center" width="180">Tanggal Pertimbangan</th>
                        <th class="text-center" width="">Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>
                        <td>
                            <div class="form-group form-group-sm" style="margin:0px;">
                                <select id="modal_jenis_penahanan" name="jenis_penahanan" class="select2" style="width:100%;" required data-error="Jenis Penahanan belum dipilih">
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
                                <div class="input-group">
                                    <input type="text" name="tgl_mulai_penahanan" id="tgl_mulai_penahanan" class="form-control input-sm datepicker" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $tgl_mulai_penahanan?>" required data-error="Masa Penahanan belum diisi" />
                                    <div class="input-group-addon" style="border:none;">S/D</div>
                                    <input type="text" name="tgl_selesai_penahanan" id="tgl_selesai_penahanan" class="form-control input-sm datepicker" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $tgl_selesai_penahanan?>" required data-error="Masa Penahanan belum diisi" />
                                </div>
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-group-sm" style="margin:0px;">
                                <input type="text" name="tgl_pertimbangan" id="tgl_pertimbangan" class="form-control input-sm datepicker" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $tgl_pertimbangan?>" required data-error="Tanggal Pertimbangan belum diisi" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </td>
                        <td>
                            <div class="form-group form-group-sm" style="margin:0px;">
                                <input type="text" name="lokasi_penahanan" id="lokasi_penahanan" class="form-control input-sm" value="<?= $model["lokasi_penahanan"]; ?>" required data-error="Lokasi Penahanan belum diisi" />
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
                        	if($model['no_t3'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'T-3' order by no_urut";
                        		$resx = PdsT3::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_t3_tembusan 
						where ".$whereDefault." and no_t3 = '".$model['no_t3']."' order by no_urut";
                        		$resx = PdsT3::findBySql($sqlx)->asArray()->all();
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
                        $pathFile 	= Yii::$app->params['t3'].$model['file_upload'];
                        $labelFile 	= 'Unggah T-3';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah T-3';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload'], strrpos($model['file_upload'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p21'].'" style="float:left; margin-right:10px;">
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
	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
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