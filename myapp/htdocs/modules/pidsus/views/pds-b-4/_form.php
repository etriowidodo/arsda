<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsB4;

	$this->title = 'B-4';
	$this->subtitle = 'Surat Perintah Penggeledahan/Penyegelan/Penyitaan/Penitipan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/p16/index';
	$linkCetak		= '/pidsus/p16/cetak';
	$tgl_ttd 		= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/p16/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor B-4</label>        
                            <div class="col-md-8">
                                <input type="text" name="nomor" id="nomor" class="form-control" value="<?php echo $model['nomor'];?>" <?php echo ($model['no_p16'])?'readonly':'';?> required data-error="Nomor belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
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
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusTersangka jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tersangka" title="Tambah Tersangka"><i class="fa fa-plus jarak-kanan"></i>Tersangka</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="table-responsive">
                    <table id="table_tersangka" class="table table-bordered">
                        <thead>
                            <tr>
                                <th width="5%" class="text-center"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                                <th width="5%" class="text-center">#</th>
                                <th width="45%">Nama</th>
                                <th width="45%">Tempat, Tanggal lahir</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
//                                if($model['no_spdp']){
//                                        $prmx = Yii::$app->inspektur->tgl_db($model['tgl_spdp']);
//                                        $sqlx = "select a.*, b.nama as kebangsaan from pidsus.pds_spdp_tersangka a left join ms_warganegara b on a.warganegara = b.id 
//                                                         where id_kejati = '".$model['id_kejati']."' and id_kejari = '".$model['id_kejari']."' and 
//                                                         id_cabjari = '".$model['id_cabjari']."' and no_spdp = '".$model['no_spdp']."' and tgl_spdp = '".$prmx."' 
//                                                         order by no_urut";
//                                        $resx = Pilih::findBySql($sqlx)->asArray()->all();
//                                        $noms = 0;
//                                        if(count($resx) > 0){
//                                                foreach($resx as $datx){
//                                                        $noms++;
//                                                        $hasilObject = $datx['no_urut']."|#|".$datx['nama']."|#|".$datx['tmpt_lahir']."|#|".$datx['tgl_lahir']."|#|".$datx['umur']."|#|".
//                                                                                $datx['warganegara']."|#|".$datx['kebangsaan']."|#|".$datx['suku']."|#|".$datx['id_identitas']."|#|".
//                                                                                $datx['no_identitas']."|#|".$datx['id_jkl']."|#|".$datx['id_agama']."|#|".$datx['alamat']."|#|".$datx['no_hp']."|#|".
//                                                                                $datx['id_pendidikan']."|#|".$datx['pekerjaan'];
//
//                                                        echo '
//                                                        <tr data-id="'.$noms.'">
//                                                                <td class="text-center">
//                                                                        <input type="checkbox" name="chk_del_tembusan[]" id="chk_del_tembusan'.$noms.'" class="hRow" value="'.$noms.'" />
//                                                                </td>
//                                                                <td>
//                                                                        <input type="hidden" name="tersangka[]" value="'.$hasilObject.'"/>
//                                                                        <a class="ubahTersangka" style="cursor:pointer" data-tersangka="'.$hasilObject.'">'.$datx['no_urut'].'. '.$datx['nama'].'</a>
//                                                                </td>
//                                                        </tr>';
//                                                }
//                                        }
//                                }								
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
//                            $sqlnya = "select nip, nama, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
//                                        from pidsus.pds_p16_jaksa where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
//                            $hasil = PdsB4::findBySql($sqlnya)->asArray()->all();
//                            if(count($hasil) == 0)
//                                echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
//                            else{
//                                $nom = 0;
//                                foreach($hasil as $data){
//                                    $nom++;	
//									$idJpn = $data['nip']."#".$data['nama']."#".$data['pangkatgol']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];						
                         ?>	
<!--                              <tr data-id="<?php echo $data['nip'];?>">
                                <td class="text-center">
                                    <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                                </td>
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                                    <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                                </td>
                                <td class="text-left"><?php echo $data['nama'];?></td>
                                <td class="text-left"><?php echo $data['pangkatgol'];?></td>
                             </tr>-->
                         <?php // } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-penggeledahan">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm disabled" id="btn_hapusgeledah"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="btn_popgeledah"><i class="fa fa-plus jarak-kanan"></i>Penggeledahan</a>
                    </div>		
                </div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-geledah-modal">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%"><input type="checkbox" name="allCheckGeledah" id="allCheckGeledah" class="allCheckGeledah" /></th>
                                <th class="text-center" width="10%">No</th>
                                <th class="text-center" width="80%">Subyek/Obyek yang digeledah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="6">Data tidak ditemukan</td></tr>
                        <?php 
//                            $sqlnya = "select nip, nama, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
//                                        from pidsus.pds_p16_jaksa where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
//                            $hasil = PdsPidsus16::findBySql($sqlnya)->asArray()->all();
//                            if(count($hasil) == 0)
//                                echo '<tr><td colspan="6">Data tidak ditemukan</td></tr>';
//                            else{
//                                $nom = 0;
//                                foreach($hasil as $data){
//                                    $nom++;	
//                                    $idJpn = $data['nip']."#".$data['nama']."#".$data['pangkatgol']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];						
                         ?>	
<!--                              <tr data-id="<?php echo $data['nip'];?>">
                                <td class="text-center">
                                    <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                                </td>
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                                    <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                                </td>
                                <td class="text-left"><?php echo $data['nama'];?></td>
                                <td class="text-left"><?php echo $data['pangkatgol'];?></td>
                             </tr>-->
                         <?php// } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-penyitaan">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm disabled" id="btn_hapussita"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="btn_popsita"><i class="fa fa-plus jarak-kanan"></i>Penyitaan</a>
                    </div>		
                </div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-geledah-modal">
                        <thead>
                            <tr>
                                <th class="text-center" width="10%"><input type="checkbox" name="allCheckSita" id="allCheckSita" class="allCheckSita" /></th>
                                <th class="text-center" width="10%">No</th>
                                <th class="text-center" width="80%">Nama Barang Disita</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td colspan="7">Data tidak ditemukan</td></tr>
                        <?php 
//                            $sqlnya = "select nip, nama, gol_jaksa, pangkat_jaksa, jabatan_jaksa, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatgol   
//                                        from pidsus.pds_p16_jaksa where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
//                            $hasil = PdsPidsus16::findBySql($sqlnya)->asArray()->all();
//                            if(count($hasil) == 0)
//                                echo '<tr><td colspan="6">Data tidak ditemukan</td></tr>';
//                            else{
//                                $nom = 0;
//                                foreach($hasil as $data){
//                                    $nom++;	
//                                    $idJpn = $data['nip']."#".$data['nama']."#".$data['pangkatgol']."#".$data['gol_jaksa']."#".$data['pangkat_jaksa']."#".$data['jabatan_jaksa'];						
                         ?>	
<!--                              <tr data-id="<?php echo $data['nip'];?>">
                                <td class="text-center">
                                    <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                                </td>
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                                    <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                                </td>
                                <td class="text-left"><?php echo $data['nama'];?></td>
                                <td class="text-left"><?php echo $data['pangkatgol'];?></td>
                             </tr>-->
                         <?php// } } ?>
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
                        	if($model['no_p16'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'P-16' order by no_urut";
                        		$resx = PdsB4::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, deskripsi_tembusan as tembusan from pidsus.pds_p16_tembusan 
										where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
                        		$resx = PdsB4::findBySql($sqlx)->asArray()->all();
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
                                <input type="text" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" id="lokel" name="lokel" readonly />	
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
                                    <input type="text" class="form-control datepicker" id="tgldittd" name="tgldittd" value="<?php echo $tgl_ttd;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal Belum diisi" />
                                </div>						
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgldittd"></div></div>
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
                        $pathFile 	= Yii::$app->params['p16'].$model['file_upload_p16'];
                        $labelFile 	= 'Unggah Pidsus B-4';
                        if($model['file_upload_p16'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah Pidsus B-4';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_p16']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_p16'], strrpos($model['file_upload_p16'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p16'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo date("d-m-Y", strtotime($_SESSION["tgl_spdp"]));?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php // if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php // } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

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

<!--TERSANGKA-->
<div class="modal fade" id="tambah_tersangka" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Tersangka</h4>
            </div>
            <div class="modal-body">
                
            </div>
        </div>
    </div>
</div>

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

<div class="modal fade tambah_sita_modal" id="tambah_sita_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Barang Yang Disita</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade tambah_geledah_modal" id="tambah_geledah_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penggeledahan</h4>
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
        /* START TERSANGKA */
            $("#tersangka").on('click', function(){
                    $("#tambah_tersangka").find(".modal-body").load("/pidsus/pds-b-4/poptersangka",function(){
                        var i=$('#table_tersangka').find("input[name='tersangka[]']").length;
                        if(i==0){
                            $('#tambah_tersangka').find("#no_urut").val(1);
                        }else{
                            $('#tambah_tersangka').find("#no_urut").val(i+1);
                        }
                    });
                    $("#tambah_tersangka").modal({
                        backdrop:"static",
                        keyboard:false
                    });
            });

            $("#tambah_tersangka").on("click",'#simpan_form_tersangka',function(){
                var hasil=$("#tambah_tersangka").find("#frm-m1").serializeArray();
                if(hasil[0].value!="" && hasil[1].value!=""){
                    var hasilObject="";
                    $.each(hasil, function(i,v){
                        hasilObject+=v.value+"|#|";
                    });

                    var tabel	= $('#table_tersangka > tbody').find('tr:last');			
                    var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
					if(hasil[16].value==1){
                        $('#table_tersangka').append(
                            '<tr data-id="'+newId+'">' +
                            	'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
                                    '<td>'+
                                            '<input type="hidden" name="tersangka[]" value="'+hasilObject+'"/>'+
                                            '<a class="ubahTersangka" style="cursor:pointer" data-tersangka="'+hasilObject+'">'+hasil[0].value+'</a>'+
                                    '</td>'+
                                    '<td>'
                                        +hasil[1].value+
                                    '</td>'+
                                    '<td>'
                                        +hasil[2].value+', '+hasil[3].value+
                                    '</td>'+
                            '</tr>'
                        );
                    } else{
                        $('#table_tersangka').find("tr[data-id='"+hasil[17].value+"']").html(
                            '<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
                            '<td>'+
                                    '<input type="hidden" name="tersangka[]" value="'+hasilObject+'"/>'+
                                    '<a class="ubahTersangka" style="cursor:pointer" data-tersangka="'+hasilObject+'">'+hasil[0].value+'</a>'+
                            '</td>'+
                            '<td>'
                                +hasil[1].value+
                            '</td>'+
                            '<td>'
                                +hasil[2].value+', '+hasil[3].value+
                            '</td>'                         
                        );
                    }
                    $("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
                    $("#tambah_tersangka").modal('hide');
                } else{
                    bootbox.alert({message: "No Urut dan Nama Harus diisi!", size: 'small'});
                }
            });
								
	$(".hapusTersangka").click(function(){
		var tabel 	= $("#table_tersangka");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
        
        $("#table_tersangka").on("click",'.ubahTersangka',function(){
            var tersangka=$(this).data("tersangka");
            var tr_id=$(this).closest("tr").data("id");
            $.ajax({
                    type	: "POST",
                    url		: "/pidsus/spdp/poptersangka",
                    data	: { tersangka : tersangka },
                    cache	: false,
                    success     : function(data){ 
                                    $("#tambah_tersangka").find(".modal-body").html(data);
                                    $("#tambah_tersangka").find("#tr_id").val(tr_id);
                                    }
                    });
                    $("#tambah_tersangka").modal({
                        backdrop:"static",
                        keyboard:false
                    });
        });
        
	/* END TERSANGKA */
        
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
				nRow.append('<tr><td colspan="4">Tidak ada dokumen</td></tr>');
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
        
        /* START PENYITAAN */
        $(".form-buat-penyitaan").on("click", "#btn_popsita", function(){
                $("#tambah_sita_modal").find(".modal-body").html("");
		$("#tambah_sita_modal").find(".modal-body").load("/pidsus/pds-b-4/getsita");
		$("#tambah_sita_modal").modal({backdrop:"static"});
	});
        
        $("#tambah_sita_modal").on('show.bs.modal', function(e){
                $("body").addClass("loading");
        }).on('shown.bs.modal', function(e){
                $("body").removeClass("loading");
        });
        /* END PENYITAAN */
        
        /* START PENGGELEDAHAN */
        $(".form-buat-penggeledahan").on("click", "#btn_popgeledah", function(){
                $("#tambah_geledah_modal").find(".modal-body").html("");
		$("#tambah_geledah_modal").find(".modal-body").load("/pidsus/pds-b-4/getgeledah");
		$("#tambah_geledah_modal").modal({backdrop:"static"});
	});
        
        $("#tambah_geledah_modal").on('show.bs.modal', function(e){
                $("body").addClass("loading");
        }).on('shown.bs.modal', function(e){
                $("body").removeClass("loading");
        });
        /* END PENGGELEDAHAN */
});
	
</script>