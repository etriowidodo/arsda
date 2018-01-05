<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\P16;

	$this->title = 'P-24';
	$this->subtitle = 'Berita Acara Pendapat';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal	= '/pidsus/pds-p24/index';
	$linkCetak	= '/pidsus/pds-p24/cetak?id1='.$model['no_berkas'].'&id2='.$model['no_pengantar']."&id3=0";
	$tgl_ba 	= ($model['tgl_ba'])?date('d-m-Y',strtotime($model['tgl_ba'])):'';
	$tgl_berkas = ($model['tgl_berkas'])?date('d-m-Y',strtotime($model['tgl_berkas'])):'';

	if($_SESSION['kode_kejati'] == '00' && $_SESSION['kode_kejari'] == '00' && $_SESSION['kode_cabjari'] == '00'){
		$labelSaran = 'Saran Direktur';
		$labelPendapat = 'Petunjuk JAM Pidum';
	} else if($_SESSION['kode_kejati'] != '00' && $_SESSION['kode_kejari'] == '00' && $_SESSION['kode_cabjari'] == '00'){
		$labelSaran = 'Saran Aspidum';
		$labelPendapat = 'Petunjuk Kajati';
	} else if($_SESSION['kode_kejati'] != '00' && $_SESSION['kode_kejari'] != '00' && $_SESSION['kode_cabjari'] == '00'){
		$labelSaran = 'Saran Kasi Pidum';
		$labelPendapat = 'Petunjuk Kajari';
	}
        
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-p24/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal Berkas</label>        
            <div class="col-md-4">
                <div class="input-group">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" name="tgl_berkas" id="tgl_berkas" class="form-control" value="<?php echo $tgl_berkas;?>" readonly />
				</div>
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">        
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal Berita Acara</label>        
            <div class="col-md-4">
                <div class="input-group">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="tgl_ba" id="tgl_ba" class="form-control datepicker" placeholder="DD-MM-YYYY" required="" value="<?php echo $tgl_ba;?>" data-error="Tanggal Berita Acara harus diisi"/>
                    </div>
                <div class="help-block with-errors" id="error_custom_tgl_ba"></div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary ">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa P-16</h3>
                <p style="margin:0;"><small>Nomor : <?php echo $model['no_p16'];?>  Tanggal : <?php echo date("d-m-Y", strtotime($model['tgl_p16']));?></small></p>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                	<table class="table table-bordered table-hover">
                    	<thead>
                        	<th class="text-center" width="5%">No</th>
                        	<th class="text-center" width="40%">NIP &amp; Nama</th>
                        	<th class="text-center" width="55%">Pangkat &amp; Jabatan</th>
                        </thead>
                        <tbody>
                        	<?php 
								$sqlJaksa = "select a.nip, a.no_urut, a.nama, a.gol_jaksa, a.pangkat_jaksa, a.jabatan_jaksa from pidsus.pds_p16_jaksa a where ".$whereDefault." 
											 and a.no_p16 = '".$model['no_p16']."' order by a.no_urut";
								$resJaksa = P16::findBySql($sqlJaksa)->asArray()->all();
								if(count($resJaksa) > 0){
									foreach($resJaksa as $idx1=>$res1){
										echo '<tr>
											<td class="text-center">'.$res1['no_urut'].'</td>
											<td>'.$res1['nip'].'<br />'.$res1['nama'].'</td>
											<td>'.$res1['gol_jaksa'].' '.$res1['pangkat_jaksa'].'<br />'.$res1['jabatan_jaksa'].'</td>
										</tr>';
									}
								} else{
									echo '<tr><td colspan="3">Data Tidak Ditemukan</td></tr>';
								}
							?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="box box-primary ">
    <div class="box-header with-border">
        <h3 class="box-title">Hasil Penelitian</h3>
    </div>
    <div class="box-body">
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Keterangan Saksi</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="ket_saksi" name="ket_saksi" style="height:80px"><?php echo $model['ket_saksi'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Keterangan Ahli</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="ket_ahli" name="ket_ahli" style="height:80px"><?php echo $model['ket_ahli'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Alat Bukti Surat</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="alat_bukti" name="alat_bukti" style="height:80px"><?php echo $model['alat_bukti'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Petunjuk/Benda Sitaan</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="benda_sitaan" name="benda_sitaan" style="height:80px"><?php echo $model['benda_sitaan'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Keterangan Tersangka</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="ket_tersangka" name="ket_tersangka" style="height:80px"><?php echo $model['ket_tersangka'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Fakta Hukum</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="fakta_hukum" name="fakta_hukum" style="height:80px"><?php echo $model['fakta_hukum'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Pembahasan Yuridis</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="yuridis" name="yuridis" style="height:80px"><?php echo $model['yuridis'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Kesimpulan</label>        
                    <div class="col-md-8">
                        <textarea class="form-control" id="kesimpulan" name="kesimpulan" style="height:80px"><?php echo $model['kesimpulan'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
        <div class="row">        
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Pendapat</label>        
                    <div class="col-md-10">
                        <label for="pendapat[1]" class="radio control-label">
                            <input type="radio" name="pendapat" id="pendapat[1]" value="1" <?php echo ($model["id_pendapat"] == "1")?'checked':'';?> required data-error="Pendapat belum dipilih" /> 
                            Berkas perkara telah memenuhi persyaratan untuk dilimpahkan ke Pengadilan
                        </label>
                        <label for="pendapat[2]" class="radio control-label">
                            <input type="radio" name="pendapat" id="pendapat[2]" value="2" <?php echo ($model["id_pendapat"] == "2")?'checked':'';?> /> 
                            Masih perlu melengkapi berkas perkara dengan melakukan pemeriksaan tambahan
                        </label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>  
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary ">
            <div class="box-header with-border">
                <h3 class="box-title">Tersangka</h3>
            </div>
            <div class="box-body">
                <div class="table-responsive">
                	<table class="table table-bordered table-hover">
                    	<thead>
                        	<th class="text-center" width="5%">No</th>
                        	<th class="text-center" width="35%">Nama</th>
                        	<th class="text-center" width="34%">Tempat dan Tanggal Lahir</th>
                        	<th class="text-center" width="13%">Jenis Kelamin</th>
                        	<th class="text-center" width="13%">Umur</th>
                        </thead>
                        <tbody>
                        	<?php 
								$sqlTsk = "select distinct a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_berkas, a.no_urut, a.nama, a.tmpt_lahir, 
											 to_char(a.tgl_lahir, 'DD-MM-YYYY') as tgl_lahir, a.umur, a.id_jkl from pidsus.pds_terima_berkas_tersangka a where ".$whereDefault." 
											 and a.no_berkas = '".$model['no_berkas']."' order by a.no_urut";
								$resTsk = P16::findBySql($sqlTsk)->asArray()->all();
								$arrKel = array(1=>"Laki-laki", "Perempuan");
								if(count($resTsk) > 0){
									foreach($resTsk as $idx2=>$res2){
										echo '<tr>
											<td class="text-center">'.$res2['no_urut'].'</td>
											<td>'.$res2['nama'].'</td>
											<td>'.$res2['tmpt_lahir'].', '.$res2['tgl_lahir'].'</td>
											<td>'.$arrKel[$res2['id_jkl']].'</td>
											<td>'.($res2['umur']?$res2['umur'].' Tahun':'').'</td>
										</tr>';
									}
								} else{
									echo '<tr><td colspan="5">Data Tidak Ditemukan</td></tr>';
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
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <div class="box box-primary ">
                    <div class="box-body">
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2"></label>        
                                    <div class="col-md-5">
                                        <input type="radio" name="saran_disetujui" id="saran_disetujui[1]" value="1" <?php echo ($model["saran_disetujui"] == "1")?'checked':'';?> required data-error="Saran belum dipilih" />
                                        <label for="saran_disetujui[1]" class="control-label jarak-kanan">Setuju Pendapat</label>

                                        <input type="radio" name="saran_disetujui" id="saran_disetujui[2]" value="0" <?php echo ($model["saran_disetujui"] == "2")?'checked':'';?> required data-error="Saran belum dipilih" />
                                        <label for="saran_disetujui[2]" class="control-label">Tidak Setuju Pendapat</label>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $labelSaran;?></label>        
                                    <div class="col-md-5">
                                        <textarea class="form-control" id="saran" name="saran" style="height:80px"><?php echo $model['saran'];?></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2"></label>        
                                    <div class="col-md-5">
                                        <input type="radio" name="petunjuk_disetujui" id="petunjuk_disetujui[1]" value="1" <?php echo ($model["petunjuk_disetujui"] == "1")?'checked':'';?> required data-error="Petunjuk belum dipilih" />
                                        <label for="petunjuk_disetujui[1]" class="control-label jarak-kanan">Setuju Pendapat</label>

                                        <input type="radio" name="petunjuk_disetujui" id="petunjuk_disetujui[2]" value="0" <?php echo ($model["petunjuk_disetujui"] == "2")?'checked':'';?> required data-error="Petunjuk belum dipilih" />
                                        <label for="petunjuk_disetujui[2]" class="control-label">Tidak Setuju Pendapat</label>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2"><?php echo $labelPendapat;?></label>        
                                    <div class="col-md-5">
                                        <textarea class="form-control" id="petunjuk" name="petunjuk" style="height:80px"><?php echo $model['petunjuk'];?></textarea>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                        <div class="row">        
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="control-label col-md-2">Penandatangan</label>        
                                    <div class="col-md-5">
                                        <select id="penandatangan" name="penandatangan" class="select2" style="width:100%;">
                                        <option></option>
                                        <?php
											if(count($resJaksa) > 0){
												foreach($resJaksa as $idx3=>$res3){
													$selected = ($res3['nip'] == $model['nip_ttd'])?'selected':'';
													$nilainya = $res3['nip'].'|#|'.$res3['nama'].'|#|'.$res3['gol_jaksa'].'|#|'.$res3['pangkat_jaksa'].'|#|'.$res3['jabatan_jaksa'];
													echo '<option value="'.$nilainya.'" '.$selected.'>'.$res3['nama'].'</option>';
												}
											}
                                        ?>
                                        </select>
                                        <input type="hidden" name="nip_ttd" id="nip_ttd" value="<?php echo $model['nip_ttd'];?>" />
                                        <input type="hidden" name="nama_ttd" id="nama_ttd" value="<?php echo $model['nama_ttd'];?>" />
                                        <input type="hidden" name="gol_ttd" id="gol_ttd" value="<?php echo $model['gol_ttd'];?>" />
                                        <input type="hidden" name="pangkat_ttd" id="pangkat_ttd" value="<?php echo $model['pangkat_ttd'];?>" />
                                        <input type="hidden" name="jabatan_ttd" id="jabatan_ttd" value="<?php echo $model['jabatan_ttd'];?>" />
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </div>
        </div>		
    </div>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
	<input type="hidden" name="no_berkas" id="no_berkas" value="<?php echo $model['no_berkas'];?>" />
	<input type="hidden" name="no_pengantar" id="no_pengantar" value="<?php echo $model['no_pengantar'];?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

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
    $("#penandatangan").on('change', function(e){
        var id = $(this).val();
        var tm = id.toString().split('|#|');
        $("#nip_ttd").val(tm[0]);
        $("#nama_ttd").val(tm[1]);
        $("#gol_ttd").val(tm[2]);
        $("#pangkat_ttd").val(tm[3]);
        $("#jabatan_ttd").val(tm[4]);
    });
});
	
</script>
<?php } ?>