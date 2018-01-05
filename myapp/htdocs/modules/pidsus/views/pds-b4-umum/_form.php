<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsB4Umum;

	$this->title = 'B-4 Umum';
	$this->subtitle = 'Surat Perintah Penggeledahan/Penyegelan/Penyitaan/Penitipan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-b4-umum/index';
	$linkCetak		= '/pidsus/pds-b4-umum/cetak?id1='.rawurlencode($model['no_b4_umum']);
	if($isNewRecord){
		$sqlCek = "select a.no_p8_umum, a.tgl_p8_umum from pidsus.pds_p8_umum a where ".$whereDefault;
		$model 	= PdsB4Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum 		= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_dikeluarkan 	= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan 		= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tempat_dikeluarkan = ($model['tempat_dikeluarkan'])?$model['tempat_dikeluarkan']:Yii::$app->inspektur->getLokasiSatker()->lokasi;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-b4-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor B-4 Umum</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_b4_umum" id="no_b4_umum" class="form-control" value="<?php echo $model['no_b4_umum'];?>" required data-error="Nomor B-4 Umum belum diisi" maxlength="50" />
                        <div class="help-block with-errors" id="error_custom_no_b4_umum"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-pemberi-kuasa">
    <div class="box-header with-border">
        <div class="row col-sm-12">
            <a class="btn btn-danger btn-sm disabled jarak-kanan" id="btn_hapusjpn"><i class="fa fa-trash" style="font-size:14px;"></i></a>	
            <a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a>	
        </div>
    </div>
    <div class="box-body">
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
								 from pidsus.pds_b4_umum_jaksa a where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by no_urut";
					$resJaksa = PdsB4Umum::findBySql($sqlJaksa)->asArray()->all();
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

<div class="box box-primary form-buat-penggeledahan">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm disabled" id="btn_hapusgeledah"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="btn_popgeledah"><i class="fa fa-plus jarak-kanan"></i>Penggeledahan Baru</a>
                <a class="btn btn-success btn-sm" id="btn_popgeledahambil"><i class="fa fa-plus jarak-kanan"></i>Penggeledahan Pidsus-16 Umum</a>
            </div>		
        </div><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableGldh">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckGldh" id="allCheckGldh" class="allCheckGldh" /></th>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="90%">Subyek/Obyek</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlGeledah = "
                    select a.* from pidsus.pds_b4_umum_pengeledahan a 
                    where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by a.no_urut_penggeledahan";
                    $resGeledah = ($model['no_b4_umum'])?PdsB4Umum::findBySql($sqlGeledah)->asArray()->all():array();
                    if(count($resGeledah) == 0)
                        echo '<tr class="barisGeledahan"><td colspan="3">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resGeledah as $dtGeledah){
                            $nomGeledah = $dtGeledah['no_urut_penggeledahan'];
							if($dtGeledah['penggeledahan_terhadap'] == 'Subyek'){
								$ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'.$dtGeledah['nama'].'</a><br />'.$dtGeledah['jabatan'];
							} else if($dtGeledah['penggeledahan_terhadap'] == 'Obyek'){
								$ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'.$dtGeledah['tempat_penggeledahan'].'</a>
								<br />'.$dtGeledah['alamat_penggeledahan'];
							}
							
                            echo '
                            <tr data-id="'.$nomGeledah.'" class="barisGeledahan">
                                <td class="text-center">
                                    <input type="hidden" name="penggeledahan_terhadap['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['penggeledahan_terhadap'].'" />
                                    <input type="hidden" name="gldh_nama['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['nama'].'" />
                                    <input type="hidden" name="gldh_jabatan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['jabatan'].'" />
                                    <input type="hidden" name="tempat_penggeledahan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['tempat_penggeledahan'].'" />
                                    <input type="hidden" name="alamat_penggeledahan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['alamat_penggeledahan'].'" />
                                    <input type="hidden" name="gldh_nama_pemilik['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['nama_pemilik'].'" />
                                    <input type="hidden" name="gldh_pekerjaan_pemilik['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['pekerjaan_pemilik'].'" />
                                    <input type="hidden" name="gldh_alamat_pemilik['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['alamat_pemilik'].'" />
                                    <input type="hidden" name="gldh_keperluan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['keperluan'].'" />
                                    <input type="hidden" name="gldh_keterangan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['keterangan'].'" />
                                    <input type="checkbox" name="cekGldh[]" id="cekGldh'.$nomGeledah.'" class="hRowCekGldh" value="'.$nomGeledah.'" />
                                </td>
                                <td class="text-center"><span class="frmnogldh" data-row-count="'.$nomGeledah.'">'.$nomGeledah.'</span></td>
                                <td class="text-left">'.$ygDigeledah.'</td>
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
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm disabled" id="btn_hapussita"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="btn_popsita"><i class="fa fa-plus jarak-kanan"></i>Penyitaan Baru</a>
                <a class="btn btn-success btn-sm" id="btn_popsitaambil"><i class="fa fa-plus jarak-kanan"></i>Penyitaan Pidsus-16 Umum</a>
            </div>		
        </div><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableSita">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckSita" id="allCheckSita" class="allCheckSita" /></th>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="35%">Barang yang disita</th>
                        <th class="text-center" width="35%">Jenis</th>
                        <th class="text-center" width="20%">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlSita = "
                    select a.* from pidsus.pds_b4_umum_penyitaan a 
                    where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by a.no_urut_penyitaan"; 
                    $resSita = ($model['no_b4_umum'])?PdsB4Umum::findBySql($sqlSita)->asArray()->all():array();
                    if(count($resSita) == 0)
                        echo '<tr class="barisSitaan"><td colspan="7">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resSita as $dtSita){
                            $nomSita = $dtSita['no_urut_penyitaan'];
                            echo '
                            <tr data-id="'.$nomSita.'" class="barisSitaan">
                                <td class="text-center">
                                    <input type="hidden" name="nama_barang_disita['.$nomSita.']" class="sitaan" value="'.$dtSita['nama_barang_disita'].'" />
                                    <input type="hidden" name="disita_dari['.$nomSita.']" class="sitaan" value="'.$dtSita['disita_dari'].'" />
                                    <input type="hidden" name="jenis_barang_disita['.$nomSita.']" class="sitaan" value="'.$dtSita['jenis_barang_disita'].'" />
                                    <input type="hidden" name="tempat_penyitaan['.$nomSita.']" class="sitaan" value="'.$dtSita['tempat_penyitaan'].'" />
                                    <input type="hidden" name="jumlah_barang_disita['.$nomSita.']" class="sitaan" value="'.$dtSita['jumlah_barang_disita'].'" />
                                    <input type="hidden" name="nama_pemilik['.$nomSita.']" class="sitaan" value="'.$dtSita['nama_pemilik'].'" />
                                    <input type="hidden" name="pekerjaan_pemilik['.$nomSita.']" class="sitaan" value="'.$dtSita['pekerjaan_pemilik'].'" />
                                    <input type="hidden" name="alamat_pemilik['.$nomSita.']" class="sitaan" value="'.$dtSita['alamat_pemilik'].'" />
                                    <input type="hidden" name="sita_keperluan['.$nomSita.']" class="sitaan" value="'.$dtSita['keperluan'].'" />
                                    <input type="hidden" name="sita_keterangan['.$nomSita.']" class="sitaan" value="'.$dtSita['keterangan'].'" />
                                    <input type="checkbox" name="cekSita[]" id="cekSita'.$nomSita.'" class="hRowCekSita" value="'.$nomSita.'" />
                                </td>
                                <td class="text-center"><span class="frmnosita" data-row-count="'.$nomSita.'">'.$nomSita.'</span></td>
                                <td class="text-left"><a style="cursor:pointer" class="ubahPenyitaan">'.$dtSita['nama_barang_disita'].'</a></td>
                                <td class="text-left">'.$dtSita['jenis_barang_disita'].'</td>
                                <td class="text-left">'.$dtSita['jumlah_barang_disita'].'</td>
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
                        	if($model['no_b4_umum'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'B-4-Umum' order by no_urut";
                        		$resx = PdsB4Umum::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select a.no_urut, a.tembusan from pidsus.pds_b4_umum_tembusan a 
										 where ".$whereDefault." and a.no_b4_umum = '".$model['no_b4_umum']."' order by a.no_urut";
                        		$resx = PdsB4Umum::findBySql($sqlx)->asArray()->all();
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
                        $pathFile 	= Yii::$app->params['b4_umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah B-4 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah B-4 Umum';
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

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa Penuntut Umum</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah_gldh_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penggeledahan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="tambah_sita_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penyitaan</h4>
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
             
	/* START PENGGELEDAHAN */
	$(".form-buat-penggeledahan").on("click", "#btn_popgeledah", function(){
		$("#tambah_gldh_modal").find(".modal-body").html("");
		$("#tambah_gldh_modal").find(".modal-body").load("/pidsus/pds-b4-umum/getgldh",function(e){
			$("#nurec_penggeledahan").val('1');
			$("#simpan_form_penggeledahan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
		});
		$("#tambah_gldh_modal").modal({backdrop:"static"});
	}).on("click", ".ubahPenggeledahan", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".geledahan").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-b4-umum/getgldh", objk, function(data){
			$("#tambah_gldh_modal").find(".modal-body").html("");
			$("#tambah_gldh_modal").find(".modal-body").html(data);
			$("#tambah_gldh_modal").find("#tr_id_penggeledahan").val(trid);
			$("#tambah_gldh_modal").find("#nurec_penggeledahan").val('0');
			$("#tambah_gldh_modal").find("#simpan_form_penggeledahan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
			$("#tambah_gldh_modal").modal({backdrop:"static", keyboard:false});
		});
	}).on("click", "#btn_hapusgeledah", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-penggeledahan").find("#tableGldh");
		tabel.find(".hRowCekGldh:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-penggeledahan").find("#tableGldh > tbody");
				nRow.append('<tr class="barisGeledahan"><td colspan="6">Data tidak ditemukan</td></tr>');
				$("#btn_hapusgeledah").addClass("disabled");
			}
		});
		tabel.find(".frmnogldh").each(function(i,v){$(this).text(i+1);});
	}).on("ifChecked", "#tableGldh input[name=allCheckGldh]", function(){
		$(".hRowCekGldh").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#tableGldh input[name=allCheckGldh]", function(){
		$(".hRowCekGldh").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#tableGldh .hRowCekGldh", function(e){
		var elem = $(this);
		var temp = $(this).parents("tr").first();
		var trid = temp.data("id");
		var objk = temp.find("input[name^='jpngldhid["+trid+"]']").length;
		if(objk > 0){
			setTimeout(function(){ elem.iCheck('uncheck');}, 0);
		} else{
			var n = $(".hRowCekGldh:checked").length;
			(n >= 1)?$("#btn_hapusgeledah").removeClass("disabled"):$("#btn_hapusgeledah").addClass("disabled");
		}
	}).on("ifUnchecked", "#tableGldh .hRowCekGldh", function(){
		var n = $(".hRowCekGldh:checked").length;
		(n > 0)?$("#btn_hapusgeledah").removeClass("disabled"):$("#btn_hapusgeledah").addClass("disabled");
	}).on("click", "#btn_popgeledahambil", function(){
		$("#tambah_gldh_modal").find(".modal-body").html("");
		$("#tambah_gldh_modal").find(".modal-body").load("/pidsus/pds-b4-umum/listgldh");
		$("#tambah_gldh_modal").modal({backdrop:"static"});
	});

	$("#tambah_gldh_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
		formValuesJPPGldh = JSON.parse(localStorage.getItem('formValuesJPPGldh')) || {};
		$("#tambah_gldh_modal").find(".table-jpn-gldh-modal tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPPGldh[idnya] = idnya;
		});
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
		$("#form-modal-gldh").validator({disable:false});
		$("#form-modal-gldh").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#form-modal-gldh").find(".with-errors").html("");
				$("#evt_penggeledahan_sukses").trigger("validasi.oke.penggeledahan");
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		if($(e.target).attr("id") == "tambah_gldh_modal")
			$(this).find('form#form-modal-gldh').off('submit').validator('destroy');
	}).on("validasi.oke.penggeledahan", "#evt_penggeledahan_sukses", function(){
		var frmnya = $("#tambah_gldh_modal").find("#form-modal-gldh").serializeArray();
		var arrnya = {};
		$.each(frmnya, function(k, v){ arrnya[v.name] = v.value; });
		if(arrnya['nurec_penggeledahan'] == 1){
			var tabel 	= $("#tableGldh");
			var rwTbl	= tabel.find('tbody > tr.barisGeledahan:last');
			var rwNom	= parseInt(rwTbl.data('id'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-b4-umum/setgldh", frmnya, function(data){
				if(isNaN(rwNom)){
					rwTbl.remove();
					rwTbl = tabel.find('tbody');
					rwTbl.append(data.hasil);
				} else{
					rwTbl.after(data.hasil);
				}
				$("#cekGldh"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				tabel.find(".frmnogldh").each(function(i,v){$(this).text(i+1);});
				$("#tambah_gldh_modal").modal('hide');
			}, "json");
		} else{
			var tabel = $("#tableGldh").find("tr[data-id='"+arrnya['tr_id_penggeledahan']+"']");
			var newId = arrnya['tr_id_penggeledahan'];
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-b4-umum/setgldh", frmnya, function(data){
				tabel.html(data.hasil);
				$("#cekGldh"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#tableGldh").find(".frmnogldh").each(function(i,v){$(this).text(i+1);});
				$("#tambah_gldh_modal").modal('hide');
			}, "json");
		}
		formValuesJPPGldh = {};
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
	}).on('click', ".pilih-gldh", function(){
                var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataGLDH')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('|#|');
			var myvar 	= param[10];
			insertToGldh(myvar, index);
		});
		$("#tambah_gldh_modal").modal("hide");
	});
        function insertToGldh(myvar, index){
		var tabel 	= $("#tableGldh");
		var rwTbl	= tabel.find('tbody > tr.barisGeledahan:last');
		var rwNom	= parseInt(rwTbl.data('id'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('|#|');
		var ygDigeledah;
                if(param[0] == 'Subyek'){
                    ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'+param[1]+'</a><br />'+param[2];
                } else if(param[0] == 'Obyek'){
                    ygDigeledah = '<a style="cursor:pointer" class="ubahPenggeledahan">'+param[3]+'</a><br />'+param[4];
                }

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+newId+'" class="barisGeledahan">'+
                        '<td class="text-center">'+
                            '<input type="hidden" name="penggeledahan_terhadap['+newId+']" class="geledahan" value="'+param[0]+'" />'+
                            '<input type="hidden" name="gldh_nama['+newId+']" class="geledahan" value="'+param[1]+'" />'+
                            '<input type="hidden" name="gldh_jabatan['+newId+']" class="geledahan" value="'+param[2]+'" />'+
                            '<input type="hidden" name="tempat_penggeledahan['+newId+']" class="geledahan" value="'+param[3]+'" />'+
                            '<input type="hidden" name="alamat_penggeledahan['+newId+']" class="geledahan" value="'+param[4]+'" />'+
                            '<input type="hidden" name="gldh_nama_pemilik['+newId+']" class="geledahan" value="'+param[5]+'" />'+
                            '<input type="hidden" name="gldh_pekerjaan_pemilik['+newId+']" class="geledahan" value="'+param[6]+'" />'+
                            '<input type="hidden" name="gldh_alamat_pemilik['+newId+']" class="geledahan" value="'+param[7]+'" />'+
                            '<input type="hidden" name="gldh_keperluan['+newId+']" class="geledahan" value="'+param[8]+'" />'+
                            '<input type="hidden" name="gldh_keterangan['+newId+']" class="geledahan" value="'+param[9]+'" />'+
                            '<input type="checkbox" name="cekGldh[]" id="cekGldh'+newId+'" class="hRowCekGldh" value="'+newId+'" />'+
                            '</td>'+
                            '<td class="text-center"><span class="frmnogldh" data-row-count="'+newId+'">'+newId+'</span></td>'+
                            '<td class="text-left">'+ygDigeledah+'</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+newId+'" class="barisGeledahan">'+
                        '<td class="text-center">'+
                            '<input type="hidden" name="penggeledahan_terhadap['+newId+']" class="geledahan" value="'+param[0]+'" />'+
                            '<input type="hidden" name="gldh_nama['+newId+']" class="geledahan" value="'+param[1]+'" />'+
                            '<input type="hidden" name="gldh_jabatan['+newId+']" class="geledahan" value="'+param[2]+'" />'+
                            '<input type="hidden" name="tempat_penggeledahan['+newId+']" class="geledahan" value="'+param[3]+'" />'+
                            '<input type="hidden" name="alamat_penggeledahan['+newId+']" class="geledahan" value="'+param[4]+'" />'+
                            '<input type="hidden" name="gldh_nama_pemilik['+newId+']" class="geledahan" value="'+param[5]+'" />'+
                            '<input type="hidden" name="gldh_pekerjaan_pemilik['+newId+']" class="geledahan" value="'+param[6]+'" />'+
                            '<input type="hidden" name="gldh_alamat_pemilik['+newId+']" class="geledahan" value="'+param[7]+'" />'+
                            '<input type="hidden" name="gldh_keperluan['+newId+']" class="geledahan" value="'+param[8]+'" />'+
                            '<input type="hidden" name="gldh_keterangan['+newId+']" class="geledahan" value="'+param[9]+'" />'+
                            '<input type="checkbox" name="cekGldh[]" id="cekGldh'+newId+'" class="hRowCekGldh" value="'+newId+'" />'+
                            '</td>'+
                            '<td class="text-center"><span class="frmnogldh" data-row-count="'+newId+'">'+newId+'</span></td>'+
                            '<td class="text-left">'+ygDigeledah+'</td>'+
			'</tr>');
		}
		$("#cekGldh"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
                tabel.find(".frmnogldh").each(function(i,v){$(this).text(i+1);});
	}
	/* END PENGGELEDAHAN */
        
	/* START PENYITAAN */
	$(".form-buat-penyitaan").on("click", "#btn_popsita", function(){
		$("#tambah_sita_modal").find(".modal-body").html("");
		$("#tambah_sita_modal").find(".modal-body").load("/pidsus/pds-b4-umum/getsita",function(e){
			$("#nurec_penyitaan").val('1');
			$("#simpan_form_penyitaan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
		});
		$("#tambah_sita_modal").modal({backdrop:"static"});
	}).on("click", ".ubahPenyitaan", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".sitaan").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-b4-umum/getsita", objk, function(data){
			$("#tambah_sita_modal").find(".modal-body").html("");
			$("#tambah_sita_modal").find(".modal-body").html(data);
			$("#tambah_sita_modal").find("#tr_id_penyitaan").val(trid);
			$("#tambah_sita_modal").find("#nurec_penyitaan").val('0');
			$("#tambah_sita_modal").find("#simpan_form_penyitaan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
			$("#tambah_sita_modal").modal({backdrop:"static", keyboard:false});
		});
	}).on("click", "#btn_hapussita", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-penyitaan").find("#tableSita");
		tabel.find(".hRowCekSita:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-penyitaan").find("#tableSita > tbody");
				nRow.append('<tr class="barisSitaan"><td colspan="7">Data tidak ditemukan</td></tr>');
				$("#btn_hapussita").addClass("disabled");
			}
		});
		tabel.find(".frmnosita").each(function(i,v){$(this).text(i+1);});
	}).on("ifChecked", "#tableSita input[name=allCheckSita]", function(){
		$(".hRowCekSita").not(':disabled').iCheck("check");
	}).on("ifUnchecked", "#tableSita input[name=allCheckSita]", function(){
		$(".hRowCekSita").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", "#tableSita .hRowCekSita", function(e){
		var elem = $(this);
		var temp = $(this).parents("tr").first();
		var trid = temp.data("id");
		var objk = temp.find("input[name^='jpnsitaid["+trid+"]']").length;
		if(objk > 0){
			setTimeout(function(){ elem.iCheck('uncheck');}, 0);
		} else{
			var n = $(".hRowCekSita:checked").length;
			(n >= 1)?$("#btn_hapussita").removeClass("disabled"):$("#btn_hapussita").addClass("disabled");
		}
	}).on("ifUnchecked", "#tableSita .hRowCekSita", function(){
		var n = $(".hRowCekSita:checked").length;
		(n > 0)?$("#btn_hapussita").removeClass("disabled"):$("#btn_hapussita").addClass("disabled");
	}).on("click", "#btn_popsitaambil", function(){
		$("#tambah_sita_modal").find(".modal-body").html("");
		$("#tambah_sita_modal").find(".modal-body").load("/pidsus/pds-b4-umum/listsita");
		$("#tambah_sita_modal").modal({backdrop:"static"});
	});

	$("#tambah_sita_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
		formValuesJPPSita = JSON.parse(localStorage.getItem('formValuesJPPSita')) || {};
		$("#tambah_sita_modal").find(".table-jpn-sita-modal tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPPSita[idnya] = idnya;
		});
		localStorage.setItem("formValuesJPPSita", JSON.stringify(formValuesJPPSita));
		$("#form-modal-sita").validator({disable:false});
		$("#form-modal-sita").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#form-modal-sita").find(".with-errors").html("");
				$("#evt_penyitaan_sukses").trigger("validasi.oke.penyitaan");
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		if($(e.target).attr("id") == "tambah_sita_modal")
			$(this).find('form#form-modal-sita').off('submit').validator('destroy');
	}).on("validasi.oke.penyitaan", "#evt_penyitaan_sukses", function(){
		var frmnya = $("#tambah_sita_modal").find("#form-modal-sita").serializeArray();
		var arrnya = {};
		$.each(frmnya, function(k, v){ arrnya[v.name] = v.value; });
		if(arrnya['nurec_penyitaan'] == 1){
			var tabel 	= $("#tableSita");
			var rwTbl	= tabel.find('tbody > tr.barisSitaan:last');
			var rwNom	= parseInt(rwTbl.data('id'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-b4-umum/setsita", frmnya, function(data){
				if(isNaN(rwNom)){
					rwTbl.remove();
					rwTbl = tabel.find('tbody');
					rwTbl.append(data.hasil);
				} else{
					rwTbl.after(data.hasil);
				}
				$("#cekSita"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				tabel.find(".frmnosita").each(function(i,v){$(this).text(i+1);});
				$("#tambah_sita_modal").modal('hide');
			}, "json");
		} else{
			var tabel = $("#tableSita").find("tr[data-id='"+arrnya['tr_id_penyitaan']+"']");
			var newId = arrnya['tr_id_penyitaan'];
			frmnya.push({name:"arr_id", value:newId});
			$.post("/pidsus/pds-b4-umum/setsita", frmnya, function(data){
				tabel.html(data.hasil);
				$("#cekSita"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#tableSita").find(".frmnosita").each(function(i,v){$(this).text(i+1);});
				$("#tambah_sita_modal").modal('hide');
			}, "json");
		}
		formValuesJPPSita = {};
		localStorage.setItem("formValuesJPPSita", JSON.stringify(formValuesJPPSita));
	}).on('click', ".pilih-sita", function(){
                var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataSITA')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('|#|');
			var myvar 	= param[10];
			insertToSita(myvar, index);
		});
		$("#tambah_sita_modal").modal("hide");
	});
        
        function insertToSita(myvar, index){
		var tabel 	= $("#tableSita");
		var rwTbl	= tabel.find('tbody > tr.barisSitaan:last');
		var rwNom	= parseInt(rwTbl.data('id'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('|#|');

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+newId+'" class="barisSitaan">'+
                        '<td class="text-center">'+
                            '<input type="hidden" name="nama_barang_disita['+newId+']" class="sitaan" value="'+param[0]+'" />'+
                            '<input type="hidden" name="disita_dari['+newId+']" class="sitaan" value="'+param[1]+'" />'+
                            '<input type="hidden" name="jenis_barang_disita['+newId+']" class="sitaan" value="'+param[2]+'" />'+
                            '<input type="hidden" name="tempat_penyitaan['+newId+']" class="sitaan" value="'+param[3]+'" />'+
                            '<input type="hidden" name="jumlah_barang_disita['+newId+']" class="sitaan" value="'+param[4]+'" />'+
                            '<input type="hidden" name="nama_pemilik['+newId+']" class="sitaan" value="'+param[5]+'" />'+
                            '<input type="hidden" name="pekerjaan_pemilik['+newId+']" class="sitaan" value="'+param[6]+'" />'+
                            '<input type="hidden" name="alamat_pemilik['+newId+']" class="sitaan" value="'+param[7]+'" />'+
                            '<input type="hidden" name="sita_keperluan['+newId+']" class="sitaan" value="'+param[8]+'" />'+
                            '<input type="hidden" name="sita_keterangan['+newId+']" class="sitaan" value="'+param[9]+'" />'+
                            '<input type="checkbox" name="cekSita[]" id="cekSita'+newId+'" class="hRowCekSita" value="'+newId+'" />'+
                            '</td>'+
                            '<td class="text-center"><span class="frmnosita" data-row-count="'+newId+'">'+newId+'</span></td>'+
                            '<td class="text-left"><a style="cursor:pointer" class="ubahPenyitaan">'+param[0]+'</a></td>'+
                            '<td class="text-left">'+param[2]+'</td>'+
                            '<td class="text-left">'+param[4]+'</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+newId+'" class="barisSitaan">'+
                        '<td class="text-center">'+
                            '<input type="hidden" name="nama_barang_disita['+newId+']" class="sitaan" value="'+param[0]+'" />'+
                            '<input type="hidden" name="disita_dari['+newId+']" class="sitaan" value="'+param[1]+'" />'+
                            '<input type="hidden" name="jenis_barang_disita['+newId+']" class="sitaan" value="'+param[2]+'" />'+
                            '<input type="hidden" name="tempat_penyitaan['+newId+']" class="sitaan" value="'+param[3]+'" />'+
                            '<input type="hidden" name="jumlah_barang_disita['+newId+']" class="sitaan" value="'+param[4]+'" />'+
                            '<input type="hidden" name="nama_pemilik['+newId+']" class="sitaan" value="'+param[5]+'" />'+
                            '<input type="hidden" name="pekerjaan_pemilik['+newId+']" class="sitaan" value="'+param[6]+'" />'+
                            '<input type="hidden" name="alamat_pemilik['+newId+']" class="sitaan" value="'+param[7]+'" />'+
                            '<input type="hidden" name="sita_keperluan['+newId+']" class="sitaan" value="'+param[8]+'" />'+
                            '<input type="hidden" name="sita_keterangan['+newId+']" class="sitaan" value="'+param[9]+'" />'+
                            '<input type="checkbox" name="cekSita[]" id="cekSita'+newId+'" class="hRowCekSita" value="'+newId+'" />'+
                            '</td>'+
                            '<td class="text-center"><span class="frmnosita" data-row-count="'+newId+'">'+newId+'</span></td>'+
                            '<td class="text-left"><a style="cursor:pointer" class="ubahPenyitaan">'+param[0]+'</a></td>'+
                            '<td class="text-left">'+param[2]+'</td>'+
                            '<td class="text-left">'+param[4]+'</td>'+
			'</tr>');
		}
		$("#cekSita"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
                tabel.find(".frmnosita").each(function(i,v){$(this).text(i+1);});
	}
	/* END PENYITAAN */
        
});
	
</script>