<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus16Umum;
        require_once('./function/tgl_indo.php');
	$this->title = 'Pidsus-16 Umum';
	$this->subtitle = 'Nota Dinas Usul Tindakan Penggeledahan/Penyitaan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-16-umum/index';
	$linkCetak		= '/pidsus/pds-pidsus-16-umum/cetak?id1='.rawurlencode($model['no_pidsus16_umum']);
	if($isNewRecord){
		$sqlCek = "select a.no_p8_umum, a.tgl_p8_umum from pidsus.pds_p8_umum a where ".$whereDefault;
		$model 	= PdsPidsus16Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_pidsus16_umum = ($model['tgl_pidsus16_umum'])?date('d-m-Y',strtotime($model['tgl_pidsus16_umum'])):'';
	$ttdJabatan = $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-16-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pidsus 16 Umum</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_pidsus16_umum" id="tgl_pidsus16_umum" class="form-control datepicker" value="<?php echo $tgl_pidsus16_umum;?>"  required data-error="Tanggal Pidsus 16 Umum belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_pidsus16_umum"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>        
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran'];?>" required data-error="Lampiran belum diisi" maxlength="30" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-penggeledahan">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm disabled" id="btn_hapusgeledah"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="btn_popgeledah"><i class="fa fa-plus jarak-kanan"></i>Penggeledahan</a>
            </div>		
        </div><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableGldh">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckGldh" id="allCheckGldh" class="allCheckGldh" /></th>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="25%">Subyek/Obyek</th>
                        <th class="text-center" width="25%">Jaksa yang Melaksanakan & Waktu Pelaksanaan</th>
                        <th class="text-center" width="20%">Keperluan</th>
                        <th class="text-center" width="20%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlGeledah = "
                    with tbl_jaksa_geledah as(
                        select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penggeledahan, 
                        string_agg(concat(nip_jaksa, '|##|', nama_jaksa, '|##|', gol_jaksa, '|##|', pangkat_jaksa, '|##|', jabatan_jaksa), '|#|' order by no_urut) as jpu_geledah 
                        from pidsus.pds_pidsus16_umum_pengeledahan_jaksa 
                        group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penggeledahan 
                    )
                    select a.no_urut_penggeledahan, a.penggeledahan_terhadap, a.nama, a.jabatan, a.tempat_penggeledahan, a.alamat_penggeledahan, a.nama_pemilik, 
					a.pekerjaan_pemilik, a.alamat_pemilik, a.waktu_penggeledahan, a.keperluan, a.keterangan, b.jpu_geledah, a.jam_penggeledahan, a.tgl_penggeledahan 
                    from pidsus.pds_pidsus16_umum_pengeledahan a 
                    left join tbl_jaksa_geledah b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_p8_umum = b.no_p8_umum and a.no_pidsus16_umum = b.no_pidsus16_umum and a.no_urut_penggeledahan = b.no_urut_penggeledahan 
                    where ".$whereDefault." and a.no_pidsus16_umum = '".$model['no_pidsus16_umum']."' order by no_urut_penggeledahan";
                    $resGeledah = ($model['no_pidsus16_umum'])?PdsPidsus16Umum::findBySql($sqlGeledah)->asArray()->all():array();
                    if(count($resGeledah) == 0)
                        echo '<tr class="barisGeledahan"><td colspan="6">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resGeledah as $dtGeledah){
                            $arrJaksaGeledah = explode("|#|", $dtGeledah['jpu_geledah']);
                            $nomGeledah = $dtGeledah['no_urut_penggeledahan'];
                            $wktGeledah = explode("-", $dtGeledah['waktu_penggeledahan']);
                            $arrBln  = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                            $jam_geledah 		= $wktGeledah[0];
                            $menit_geledah 		= $wktGeledah[1];
                            $tanggal_geledah 	= $wktGeledah[2];
                            $bulan_geledah 		= $wktGeledah[3];
                            $tahun_geledah 		= $wktGeledah[4];
                            if($tahun_geledah) $tanggal = 'Tahun '.$tahun_geledah;
                            if($tahun_geledah && $bulan_geledah) $tanggal = 'Bulan '.$arrBln[intval($bulan_geledah)].' Tahun '.$tahun_geledah;
                            if($tahun_geledah && $bulan_geledah && $tanggal_geledah) $tanggal = 'Tanggal '.$tanggal_geledah.' '.$arrBln[intval($bulan_geledah)].' '.$tahun_geledah;
                            if($jam_geledah && $menit_geledah) $waktu = ' Jam '.$jam_geledah.':'.$menit_geledah;
                            $tgl_penggeledahan = ($dtGeledah['tgl_penggeledahan'])?date('d-m-Y',strtotime($dtGeledah['tgl_penggeledahan'])):'';
                            $tgl_penggeledahan_indo  = ($tgl_penggeledahan)?tgl_indo($tgl_penggeledahan):'';

                            $tableJaksaGeledah = '';
                            $inputJaksaGeledah = '';
                            if(count($arrJaksaGeledah) > 0){
                                $tableJaksaGeledah = '<table width="100%" cellspacing="0" border="0" cellpadding="0">';
                                foreach($arrJaksaGeledah as $idxJS=>$valJS){
                                    $nomx = $idxJS + 1;
                                    list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $valJS);
                                    $inputJaksaGeledah .= '<input type="hidden" name="jpngldhid['.$nomGeledah.'][]" class="geledahan" value="'.$valJS.'" />';											
                                    $tableJaksaGeledah .= '<tr><td width="25" valign="top">'.$nomx.'.</td><td>'.$nip_jaksa.'<br />'.$nama_jaksa.'</td></tr>';
                                }
                                $tableJaksaGeledah .= '</table>';
                            }
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
                                    '.$inputJaksaGeledah.'
                                    <input type="hidden" name="waktu_penggeledahan['.$nomGeledah.'][0]" class="geledahan" value="'.$wktGeledah[0].'" />
                                    <input type="hidden" name="waktu_penggeledahan['.$nomGeledah.'][1]" class="geledahan" value="'.$wktGeledah[1].'" />
                                    <input type="hidden" name="waktu_penggeledahan['.$nomGeledah.'][2]" class="geledahan" value="'.$wktGeledah[2].'" />
                                    <input type="hidden" name="waktu_penggeledahan['.$nomGeledah.'][3]" class="geledahan" value="'.$wktGeledah[3].'" />
                                    <input type="hidden" name="waktu_penggeledahan['.$nomGeledah.'][4]" class="geledahan" value="'.$wktGeledah[4].'" />
                                    <input type="hidden" name="gldh_keperluan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['keperluan'].'" />
                                    <input type="hidden" name="gldh_keterangan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['keterangan'].'" />
                                    <input type="hidden" name="jam_penggeledahan['.$nomGeledah.']" class="geledahan" value="'.$dtGeledah['jam_penggeledahan'].'" />
                                    <input type="hidden" name="tgl_penggeledahan['.$nomGeledah.']" class="geledahan" value="'.$tgl_penggeledahan.'" />
                                    <input type="checkbox" name="cekGldh[]" id="cekGldh'.$nomGeledah.'" class="hRowCekGldh" value="'.$nomGeledah.'" />
                                </td>
                                <td class="text-center"><span class="frmnogldh" data-row-count="'.$nomGeledah.'">'.$nomGeledah.'</span></td>
                                <td class="text-left">'.$ygDigeledah.'</td>
                                <td class="text-left">Tanggal '.$tgl_penggeledahan_indo.' Jam '.$dtGeledah['jam_penggeledahan'].'<br />'.$tableJaksaGeledah.'</td>
                                <td class="text-left">'.$dtGeledah['keperluan'].'</td>
                                <td class="text-left">'.$dtGeledah['keterangan'].'</td>
                            </tr>';
                        }
                    }
                 ?>	
                </tbody>
            </table>
        </div>
        <small><i>* Data tidak dapat dihapus jika masih ada data [jaksa yang melaksanakan]</i></small>
    </div>
</div>			

<div class="box box-primary form-buat-penyitaan">
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm disabled" id="btn_hapussita"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="btn_popsita"><i class="fa fa-plus jarak-kanan"></i>Penyitaan</a>
            </div>		
        </div><br/>
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableSita">
                <thead>
                    <tr>
                        <th class="text-center" width="5%"><input type="checkbox" name="allCheckSita" id="allCheckSita" class="allCheckSita" /></th>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="15%">Item</th>
                        <th class="text-center" width="25%">Disita Dari dan Tempat Penyitaan</th>
                        <th class="text-center" width="25%">Jaksa yang Melaksanakan & Waktu Pelaksanaan</th>
                        <th class="text-center" width="15%">Keperluan</th>
                        <th class="text-center" width="10%">Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlSita = "
                    with tbl_jaksa_sita as(
                        select id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penyitaan, 
                        string_agg(concat(nip_jaksa, '|##|', nama_jaksa, '|##|', gol_jaksa, '|##|', pangkat_jaksa, '|##|', jabatan_jaksa), '|#|' order by no_urut) as jpu_sita 
                        from pidsus.pds_pidsus16_umum_penyitaan_jaksa 
                        group by id_kejati, id_kejari, id_cabjari, no_p8_umum, no_pidsus16_umum, no_urut_penyitaan 
                    )
                    select a.no_urut_penyitaan, a.nama_barang_disita, a.jenis_barang_disita, a.jumlah_barang_disita, a.disita_dari, a.tempat_penyitaan, a.nama_pemilik, 
                    a.pekerjaan_pemilik, a.alamat_pemilik, a.waktu_penyitaan, a.keperluan, a.keterangan, b.jpu_sita, a.jam_penyitaan, a.tgl_penyitaan 
                    from pidsus.pds_pidsus16_umum_penyitaan a 
                    left join tbl_jaksa_sita b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                        and a.no_p8_umum = b.no_p8_umum and a.no_pidsus16_umum = b.no_pidsus16_umum and a.no_urut_penyitaan = b.no_urut_penyitaan 
                    where ".$whereDefault." and a.no_pidsus16_umum = '".$model['no_pidsus16_umum']."' order by no_urut_penyitaan"; 
                    $resSita = ($model['no_pidsus16_umum'])?PdsPidsus16Umum::findBySql($sqlSita)->asArray()->all():array();
                    if(count($resSita) == 0)
                        echo '<tr class="barisSitaan"><td colspan="7">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resSita as $dtSita){
                            $arrJaksaSita = explode("|#|", $dtSita['jpu_sita']);
                            $nomSita = $dtSita['no_urut_penyitaan'];
                            $wktSita = explode("-", $dtSita['waktu_penyitaan']);
                            $arrBln  = array(1=>"Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
                            $jam_sita 		= $wktSita[0];
                            $menit_sita 	= $wktSita[1];
                            $tanggal_sita 	= $wktSita[2];
                            $bulan_sita 	= $wktSita[3];
                            $tahun_sita 	= $wktSita[4];
                            if($tahun_sita) $tanggal = 'Tahun '.$tahun_sita;
                            if($tahun_sita && $bulan_sita) $tanggal = 'Bulan '.$arrBln[intval($bulan_sita)].' Tahun '.$tahun_sita;
                            if($tahun_sita && $bulan_sita && $tanggal_sita) $tanggal = 'Tanggal '.$tanggal_sita.' '.$arrBln[intval($bulan_sita)].' '.$tahun_sita;
                            if($jam_sita && $menit_sita) $waktu = ' Jam '.$jam_sita.':'.$menit_sita;
                            $tgl_penyitaan  = ($dtSita['tgl_penyitaan'])?(date('d-m-Y',strtotime($dtSita['tgl_penyitaan']))):'';
                            $tgl_penyitaan_indo  = ($tgl_penyitaan)?tgl_indo($tgl_penyitaan):'';
                            
                            $tableJaksaSita = '';
                            $inputJaksaSita = '';
                            if(count($arrJaksaSita) > 0){
                                $tableJaksaSita = '<table width="100%" cellspacing="0" border="0" cellpadding="0">';
                                foreach($arrJaksaSita as $idxJS=>$valJS){
                                    $nomx = $idxJS + 1;
                                    list($nip_jaksa, $nama_jaksa, $gol_jaksa, $pangkat_jaksa, $jabatan_jaksa) = explode("|##|", $valJS);
                                    $inputJaksaSita .= '<input type="hidden" name="jpnsitaid['.$nomSita.'][]" class="sitaan" value="'.$valJS.'" />';											
                                    $tableJaksaSita .= '<tr><td width="25" valign="top">'.$nomx.'.</td><td>'.$nip_jaksa.'<br />'.$nama_jaksa.'</td></tr>';
                                }
                                $tableJaksaSita .= '</table>';
                            }
                            
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
                                    '.$inputJaksaSita.'
                                    <input type="hidden" name="waktu_pelaksanaan['.$nomSita.'][0]" class="sitaan" value="'.$wktSita[0].'" />
                                    <input type="hidden" name="waktu_pelaksanaan['.$nomSita.'][1]" class="sitaan" value="'.$wktSita[1].'" />
                                    <input type="hidden" name="waktu_pelaksanaan['.$nomSita.'][2]" class="sitaan" value="'.$wktSita[2].'" />
                                    <input type="hidden" name="waktu_pelaksanaan['.$nomSita.'][3]" class="sitaan" value="'.$wktSita[3].'" />
                                    <input type="hidden" name="waktu_pelaksanaan['.$nomSita.'][4]" class="sitaan" value="'.$wktSita[4].'" />
                                    <input type="hidden" name="sita_keperluan['.$nomSita.']" class="sitaan" value="'.$dtSita['keperluan'].'" />
                                    <input type="hidden" name="sita_keterangan['.$nomSita.']" class="sitaan" value="'.$dtSita['keterangan'].'" />
                                    <input type="hidden" name="jam_penyitaan['.$nomSita.']" class="sitaan" value="'.$dtSita['jam_penyitaan'].'" />
                                    <input type="hidden" name="tgl_penyitaan['.$nomSita.']" class="sitaan" value="'.$tgl_penyitaan.'" />
                                    <input type="checkbox" name="cekSita[]" id="cekSita'.$nomSita.'" class="hRowCekSita" value="'.$nomSita.'" />
                                </td>
                                <td class="text-center"><span class="frmnosita" data-row-count="'.$nomSita.'">'.$nomSita.'</span></td>
                                <td class="text-left">
                                    <a style="cursor:pointer" class="ubahPenyitaan">'.$dtSita['nama_barang_disita'].'</a><br />
                                    Jenis : '.$dtSita['jenis_barang_disita'].'<br />Jumlah : '.$dtSita['jumlah_barang_disita'].'
                                </td>
                                <td class="text-left">Dari : '.$dtSita['disita_dari'].'<br />Tempat : '.$dtSita['tempat_penyitaan'].'</td>
                                <td class="text-left">Tanggal '.$tgl_penyitaan_indo.' Jam '.$dtSita['jam_penyitaan'].'<br />'.$tableJaksaSita.'</td>
                                <td class="text-left">'.$dtSita['keperluan'].'</td>
                                <td class="text-left">'.$dtSita['keterangan'].'</td>
                            </tr>';
                        }
                    }
                 ?>	
                </tbody>
            </table>
        </div>
        <small><i>* Data tidak dapat dihapus jika masih ada data [jaksa yang melaksanakan]</i></small>
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
                        	if($model['no_pidsus16_umum'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pidsus-16-Umum' order by no_urut";
                        		$resx = PdsPidsus16Umum::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select a.no_urut, a.tembusan from pidsus.pds_pidsus16_umum_tembusan a where ".$whereDefault." 
										 and no_pidsus16_umum = '".$model['no_pidsus16_umum']."' order by no_urut";
                        		$resx = PdsPidsus16Umum::findBySql($sqlx)->asArray()->all();
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
                            <label class="control-label col-md-4">Penanda Tangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="nama_jaksa" name="nama_jaksa" value="<?php echo $model['nama_jaksa']; ?>" />
                                <input type="hidden" id="gol_jaksa" name="gol_jaksa" value="<?php echo $model['gol_jaksa'];?>" />														
                                <input type="hidden" id="pangkat_jaksa" name="pangkat_jaksa" value="<?php echo $model['pangkat_jaksa'];?>" />														
                                <input type="hidden" id="jabatan_jaksa" name="jabatan_jaksa" value="<?php echo $model['jabatan_jaksa'];?>" />														
                                <input type="hidden" id="jabatan_p8" name="jabatan_p8" value="<?php echo $model['jabatan_p8']; ?>" />
                                <select name="nip_jaksa" id="nip_jaksa" class="select2" style="width:100%" required data-error="Penandatangan belum diisi">
                                    <option></option>
                                    <?php 
                                        $sqlOpt1 = "select * from pidsus.pds_p8_umum_jaksa a where ".$whereDefault." order by no_urut";
										$resOpt1 = PdsPidsus16Umum::findBySql($sqlOpt1)->asArray()->all();
										$arrJbtnSdk = array(1=>'Koordinator', 'Ketua Tim', 'Wakil Ketua', 'Sekretaris', 'Anggota');
                                        foreach($resOpt1 as $dOpt1){
                                            $selected = ($model['nip_jaksa'] == $dOpt1['nip_jaksa'])?'selected':'';
											$prmnya = $dOpt1['nama_jaksa']."#".$dOpt1['gol_jaksa']."#".$dOpt1['pangkat_jaksa']."#".$dOpt1['jabatan_jaksa']."#".$dOpt1['jabatan_p8'];
											$jbtnJsdk = $arrJbtnSdk[$dOpt1['jabatan_p8']];
                                            echo '<option value="'.$dOpt1['nip_jaksa'].'" data-param="'.$prmnya.'" '.$selected.'>'.$dOpt1['nama_jaksa'].'</option>';
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
                        $pathFile 	= Yii::$app->params['pidsus_16umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-16 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah Pidsus-16 Umum';
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
    <input type="hidden" name="no_pidsus16_umum" id="no_pidsus16_umum" value="<?php echo $model['no_pidsus16_umum']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

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

<div class="modal fade" id="jpn_modal_gldh" role="dialog" tabindex="-1" aria-hidden="true">
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

<div class="modal fade" id="jpn_modal_sita" role="dialog" tabindex="-1" aria-hidden="true">
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
    $("#nip_jaksa").on("change", function(){
		var nilai = $(this).find("option:selected").data("param");
		var hasil = nilai.split("#");
		$("#nama_jaksa").val(hasil[0]);
		$("#gol_jaksa").val(hasil[1]);
		$("#pangkat_jaksa").val(hasil[2]);
		$("#jabatan_jaksa").val(hasil[3]);
		$("#jabatan_p8").val(hasil[4]);
	});

	/* START PENGGELEDAHAN */
	$(".form-buat-penggeledahan").on("click", "#btn_popgeledah", function(){
		$("#tambah_gldh_modal").find(".modal-body").html("");
		$("#tambah_gldh_modal").find(".modal-body").load("/pidsus/pds-pidsus-16-umum/getgldh",function(e){
			$("#nurec_penggeledahan").val('1');
			$("#simpan_form_penggeledahan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
		});
		$("#tambah_gldh_modal").modal({backdrop:"static"});
	}).on("click", ".ubahPenggeledahan", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".geledahan").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-pidsus-16-umum/getgldh", objk, function(data){
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
			$.post("/pidsus/pds-pidsus-16-umum/setgldh", frmnya, function(data){
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
			$.post("/pidsus/pds-pidsus-16-umum/setgldh", frmnya, function(data){
				tabel.html(data.hasil);
				$("#cekGldh"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#tableGldh").find(".frmnogldh").each(function(i,v){$(this).text(i+1);});
				$("#tambah_gldh_modal").modal('hide');
			}, "json");
		}
		formValuesJPPGldh = {};
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
	});
	/* END PENGGELEDAHAN */
        
	/* START AMBIL JPN GLDH */
	localStorage.clear();
	var formValuesJPPGldh = JSON.parse(localStorage.getItem('formValuesJPPGldh')) || {};
	$("#tambah_gldh_modal").find(".table-jpn-gldh-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValuesJPPGldh[idnya] = idnya;
	});
	localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));

	$("#tambah_gldh_modal").on("click", "#btn_tambahjpn_gldh", function(){
		$("#jpn_modal_gldh").find(".modal-body").html("");
		$("#jpn_modal_gldh").find(".modal-body").load("/pidsus/pds-pidsus-16-umum/getlistjaksagldh");
		$("#jpn_modal_gldh").modal({backdrop:"static"});
	}).on("click", "#btn_hapusjpn_gldh", function(){
		var id 		= [];
		var tabel 	= $("#tambah_gldh_modal").find(".table-jpn-gldh-modal");
		tabel.find(".hRowJpnGldh:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $("#tambah_gldh_modal").find(".table-jpn-gldh-modal > tbody");
				nRow.append('<tr><td colspan="4">Data tidak ditemukan</td></tr>');
			}
		});
		tabel.find(".frmnojpngldh").each(function(i,v){$(this).text(i+1);});				

		formValuesJPPGldh = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPPGldh[idnya] = idnya;
		});
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
		var n = tabel.find(".hRowJpnGldh:checked").length;
		(n > 0)?$("#btn_hapusjpn_gldh").removeClass("disabled"):$("#btn_hapusjpn_gldh").addClass("disabled");
	});
        
	$("#jpn_modal_gldh").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("dblclick", "#tabel_list_jpngldh td:not(.aksinya)", function(){
		var trid 	= $(this).closest("tr");
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('|##|');
		var myvar 	= param[0];
		if(myvar in formValuesJPPGldh){
			$("#jpn_modal_gldh").modal("hide");
		} else{
			insertToGldh(myvar, index);
			$("#jpn_modal_gldh").modal("hide");
		}
	}).on('click', ".pilih_jpngldh_modal", function(){
		var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataJPNGldh')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('|##|');
			var myvar 	= param[0];
			insertToGldh(myvar, index);
		});
		localStorage.removeItem("modalnyaDataJPNGldh");
		$("#jpn_modal_gldh").modal("hide");
	});
	function insertToGldh(myvar, index){
		var tabel 	= $("#tambah_gldh_modal").find(".table-jpn-gldh-modal");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.frmnojpngldh").data('rowCount'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('|##|');

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekJpnGldhModal[]" id="cekJpnGldhModal_'+newId+'" class="hRowJpnGldh" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpngldh" data-row-count="'+newId+'"></span><input type="hidden" name="modal_jpngldhid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[4]+'<br />'+param[3]+' ('+param[2]+')</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekJpnGldhModal[]" id="cekJpnGldhModal_'+newId+'" class="hRowJpnGldh" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpngldh" data-row-count="'+newId+'"></span><input type="hidden" name="modal_jpngldhid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[4]+'<br />'+param[3]+' ('+param[2]+')</td>'+
			'</tr>');
		}

		$("#cekJpnGldhModal_"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		tabel.find(".frmnojpngldh").each(function(i,v){$(this).text(i+1);});
		formValuesJPPGldh[myvar] = myvar;
		localStorage.setItem("formValuesJPPGldh", JSON.stringify(formValuesJPPGldh));
	}
		
	$("#tambah_gldh_modal").on("ifChecked", ".table-jpn-gldh-modal input[name=allCheckJpnGldh]", function(){
		$(".hRowJpnGldh").not(':disabled').iCheck("check");
	}).on("ifUnchecked", ".table-jpn-gldh-modal input[name=allCheckJpnGldh]", function(){
		$(".hRowJpnGldh").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", ".table-jpn-gldh-modal .hRowJpnGldh", function(){
		var n = $(".hRowJpnGldh:checked").length;
		(n >= 1)?$("#btn_hapusjpn_gldh").removeClass("disabled"):$("#btn_hapusjpn_gldh").addClass("disabled");
	}).on("ifUnchecked", ".table-jpn-gldh-modal .hRowJpnGldh", function(){
		var n = $(".hRowJpnGldh:checked").length;
		(n > 0)?$("#btn_hapusjpn_gldh").removeClass("disabled"):$("#btn_hapusjpn_gldh").addClass("disabled");
	});
	/* END AMBIL JPN GLDH */
        

	/* START PENYITAAN */
	$(".form-buat-penyitaan").on("click", "#btn_popsita", function(){
		$("#tambah_sita_modal").find(".modal-body").html("");
		$("#tambah_sita_modal").find(".modal-body").load("/pidsus/pds-pidsus-16-umum/getsita",function(e){
			$("#nurec_penyitaan").val('1');
			$("#simpan_form_penyitaan").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');				
		});
		$("#tambah_sita_modal").modal({backdrop:"static"});
	}).on("click", ".ubahPenyitaan", function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".sitaan").serializeArray();
		objk.push({name: 'arr_id', value: trid});
		$.post("/pidsus/pds-pidsus-16-umum/getsita", objk, function(data){
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
			$.post("/pidsus/pds-pidsus-16-umum/setsita", frmnya, function(data){
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
			$.post("/pidsus/pds-pidsus-16-umum/setsita", frmnya, function(data){
				tabel.html(data.hasil);
				$("#cekSita"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
				$("#tableSita").find(".frmnosita").each(function(i,v){$(this).text(i+1);});
				$("#tambah_sita_modal").modal('hide');
			}, "json");
		}
		formValuesJPPSita = {};
		localStorage.setItem("formValuesJPPSita", JSON.stringify(formValuesJPPSita));
	});
	/* END PENYITAAN */
        
	/* START AMBIL JPN SITA*/
	localStorage.clear();
	var formValuesJPPSita = JSON.parse(localStorage.getItem('formValuesJPPSita')) || {};
	$("#tambah_sita_modal").find(".table-jpn-sita-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValuesJPPSita[idnya] = idnya;
	});
	localStorage.setItem("formValuesJPPSita", JSON.stringify(formValuesJPPSita));

	$("#tambah_sita_modal").on("click", "#btn_tambahjpn_sita", function(){
		$("#jpn_modal_sita").find(".modal-body").html("");
		$("#jpn_modal_sita").find(".modal-body").load("/pidsus/pds-pidsus-16-umum/getlistjaksasita");
		$("#jpn_modal_sita").modal({backdrop:"static"});
	}).on("click", "#btn_hapusjpn_sita", function(){
		var id 		= [];
		var tabel 	= $("#tambah_sita_modal").find(".table-jpn-sita-modal");
		tabel.find(".hRowJpnSita:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $("#tambah_sita_modal").find(".table-jpn-sita-modal > tbody");
				nRow.append('<tr><td colspan="4">Data tidak ditemukan</td></tr>');
			}
		});
		tabel.find(".frmnojpnsita").each(function(i,v){$(this).text(i+1);});				

		formValuesJPPSita = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesJPPSita[idnya] = idnya;
		});
		localStorage.setItem("formValuesJPPSita", JSON.stringify(formValuesJPPSita));
		var n = tabel.find(".hRowJpnSita:checked").length;
		(n > 0)?$("#btn_hapusjpn_sita").removeClass("disabled"):$("#btn_hapusjpn_sita").addClass("disabled");
	});
        
	$("#jpn_modal_sita").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("dblclick", "#tabel_list_jpnsita td:not(.aksinya)", function(){
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('|##|');
		var myvar 	= param[0];
		if(myvar in formValuesJPPSita){
			$("#jpn_modal_sita").modal("hide");
		} else{
			insertToRole(myvar, index);
			$("#jpn_modal_sita").modal("hide");
		}
	}).on('click', ".pilih_jpnsita_modal", function(){
		var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataJPNSita')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('|##|');
			var myvar 	= param[0];
			insertToRole(myvar, index);
		});
		localStorage.removeItem("modalnyaDataJPNSita");
		$("#jpn_modal_sita").modal("hide");
	});
	function insertToRole(myvar, index){
		var tabel 	= $("#tambah_sita_modal").find(".table-jpn-sita-modal");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.frmnojpnsita").data('rowCount'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('|##|');

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekJpnSitaModal[]" id="cekJpnSitaModal_'+newId+'" class="hRowJpnSita" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpnsita" data-row-count="'+newId+'"></span><input type="hidden" name="modal_jpnsitaid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[4]+'<br />'+param[3]+' ('+param[2]+')</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekJpnSitaModal[]" id="cekJpnSitaModal_'+newId+'" class="hRowJpnSita" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpnsita" data-row-count="'+newId+'"></span><input type="hidden" name="modal_jpnsitaid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[4]+'<br />'+param[3]+' ('+param[2]+')</td>'+
			'</tr>');
		}

		$("#cekJpnSitaModal_"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		tabel.find(".frmnojpnsita").each(function(i,v){$(this).text(i+1);});
		formValuesJPPSita[myvar] = myvar;
		localStorage.setItem("formValuesJPPSita", JSON.stringify(formValuesJPPSita));
	}
		
	$("#tambah_sita_modal").on("ifChecked", ".table-jpn-sita-modal input[name=allCheckJpnSita]", function(){
		$(".hRowJpnSita").not(':disabled').iCheck("check");
	}).on("ifUnchecked", ".table-jpn-sita-modal input[name=allCheckJpnSita]", function(){
		$(".hRowJpnSita").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", ".table-jpn-sita-modal .hRowJpnSita", function(){
		var n = $(".hRowJpnSita:checked").length;
		(n >= 1)?$("#btn_hapusjpn_sita").removeClass("disabled"):$("#btn_hapusjpn_sita").addClass("disabled");
	}).on("ifUnchecked", ".table-jpn-sita-modal .hRowJpnSita", function(){
		var n = $(".hRowJpnSita:checked").length;
		(n > 0)?$("#btn_hapusjpn_sita").removeClass("disabled"):$("#btn_hapusjpn_sita").addClass("disabled");
	});
	/* END AMBIL JPN SITA */
        
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

});
</script>