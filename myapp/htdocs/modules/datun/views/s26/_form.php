<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\security\models\User;
	use mdm\admin\models\searchs\Menu as MenuSearch;

	$this->title 	= 'Memori Kasasi (S-26)';
	$this->subtitle = 'No Register Perkara : '.$head['no_register_perkara'].' | No Register Bantuan Hukum : '.$head['no_surat'].'';
	$linkBatal		= '/datun/skk/index';
	$linkCetak		= '/datun/s26/cetak';
	$tanggal_s26 	= ($head['tanggal_s26'])?date('d-m-Y',strtotime($head['tanggal_s26'])):'';
	$tgl_permohonan_kasasi 	= ($head['tgl_permohonan_kasasi'])?date('d-m-Y',strtotime($head['tgl_permohonan_kasasi'])):'';
	$tanggal_putusan= ($head['tanggal_putusan'])?date('d-m-Y',strtotime($head['tanggal_putusan'])):'';
    $tanggal_skk 	= ($head['tanggal_skk'])?date('d-m-Y',strtotime($head['tanggal_skk'])):'';
    $tanggal_skks	= ($head['tanggal_skks'])?date('d-m-Y',strtotime($head['tanggal_skks'])):'';
    $tanggal_diterima= date('d-m-Y',strtotime($head['tanggal_diterima']));
    $isNewRecord 	= ($head['is_cek'])?0:1;
	$subsidair		= ($isNewRecord)?'Apabila pengadilan berpendapat lain, mohon putusan yang seadil-adilnya <i>(ex aequo et bono).</i>':$head['isi_petitum_subsider'];
	$melalui		= ($isNewRecord)?"Kepaniteraan ".ucwords($head['nama_pengadilan']):$head['melalui'];
?>

<?php if($_SESSION['no_register_skk'] && $_SESSION['no_register_perkara']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/s26/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">   
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No. Perkara Perdata</label>        
        			<div class="col-md-8">
                         <input type="text" class="form-control" value="<?php echo $head['no_register_perkara'];?>" id="no_register_perkara" name="no_register_perkara" placeholder="" readonly="true">
                         <input type="text" class="form-control hide" value="<?php echo $head['no_putusan'];?>" id="no_putusan" name="no_putusan" placeholder="" readonly="true">
						 <input type="text" class="form-control hide" id="no_surat" name="no_surat" value="<?php echo $head['no_surat'];?>" placeholder="" hidden="true">
                         <input type="text" class="form-control hide" id="kode_jenis_instansi" name="kode_jenis_instansi" value="<?php echo $head['kode_jenis_instansi'];?>" placeholder="" hidden="true">
                         <input type="text" class="form-control hide" id="kode_instansi" name="kode_instansi" value="<?php echo $head['kode_instansi'];?>" placeholder="" hidden="true">
						<div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Asal Panggilan</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control hide" id="kode_kabupaten" name="kode_kabupaten" value="<?php echo $head['kode_kabupaten'];?>" placeholder="" hidden="true">
                        <input type="text" class="form-control" id="asal_panggilan" name="asal_panggilan" value="<?php echo $head['nama_pengadilan'];?>" placeholder="" readonly="true">
					</div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No. SKK</label>        
        			<div class="col-md-8">
                       <?php if($isNewRecord){ ?>
                            <select name="no_skk" id="no_skk" style="width:100%;" required data-error="No SKK belum dipilih">
								<?php 
									$sqlOpt1 = "select a.no_register_skk, a.tanggal_skk from datun.skk a 
												where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' 
												order by tanggal_skk desc";
									$resOpt1 = User::findBySql($sqlOpt1)->asArray()->all();
									foreach($resOpt1 as $dOpt1){
										$selected = ($dOpt1['no_register_skk'] == $head['no_register_skk']?'selected':'');
										echo '<option '.$selected.' data-tgl="'.date("d-m-Y", strtotime($dOpt1['tanggal_skk'])).'">'.$dOpt1['no_register_skk'].'</option>';
									}
                                  ?>
							</select>
							<?php } else { ?>
							<input type="text" name="no_skk" id="no_skk" class="form-control" value="<?php echo $head['no_register_skk'];?>" readonly /> 
							<?php } ?>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal  SKK</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <?php if($isNewRecord){ ?>
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo ($resOpt1[0]['tanggal_skk'])?date("d-m-Y", strtotime($resOpt1[0]['tanggal_skk'])):'';?>" readonly />
                                <?php } else { ?>
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo $tanggal_skk;?>" readonly /> 
                                <?php } ?>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No. SKKS</label>        
                    <div class="col-md-8">
                        <?php if($isNewRecord){ ?>
                            <select name="no_skks" id="no_skks" style="width:100%;">
								<?php 
									$sqlOpt2 = "select a.no_register_skks, a.tanggal_ttd as tanggal_skks from datun.skks a 
												where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' 
													and a.no_register_skk = '".$resOpt1[0]['no_register_skk']."' and a.tanggal_skk = '".$resOpt1[0]['tanggal_skk']."' 
													and a.penerima_kuasa = 'JPN' 
												order by a.is_active desc";
									$resOpt2 = User::findBySql($sqlOpt2)->asArray()->all();
									foreach($resOpt2 as $dOpt2){
										$selected = ($dOpt2['no_register_skks'] == $model['no_register_skks']?'selected':'');
										echo '<option '.$selected.' data-tgl="'.date("d-m-Y", strtotime($dOpt2['tanggal_skks'])).'">'.$dOpt2['no_register_skks'].'</option>';
									}
                                  ?>
							</select>
							<?php } else { ?>
							<input type="text" name="no_skks" id="no_skks" class="form-control" value="<?php echo $head['no_register_skks'];?>" readonly /> 
							<?php } ?>
                    </div>
                </div>
            </div>        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal  SKKS</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<?php if($isNewRecord){ ?>
							<input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo ($resOpt2[0]['tanggal_skks'])?date("d-m-Y", strtotime($resOpt2[0]['tanggal_skks'])):'';?>" readonly placeholder="DD-MM-YYYY"  />
							<?php } else { ?>
							<input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo $tanggal_skks;?>" readonly placeholder="DD-MM-YYYY" /> 
							<?php } ?>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Penggugat</label>        
                    <div class="col-md-8">
                       	<?php 
								$reg	= $head['no_register_perkara'];
								$cns	= $head['no_surat'];
								$sqlnya = "SELECT b.nama_instansi from datun.permohonan a inner join datun.lawan_pemohon b on a.no_surat=b.no_surat and
											a.no_register_perkara=b.no_register_perkara where a.no_register_perkara='$reg' and a.no_surat='$cns'
											order by no_urut";
								$hasil = User::findBySql($sqlnya)->asArray()->All();
								if(count($hasil) > 1) {
									$datains = $hasil[0]['nama_instansi'].', dkk';
								} else{
									$datains = $hasil[0]['nama_instansi'];
								} 
						?>
						<input type="text" class="form-control" value="<?php echo $datains;?>" id="penggugat" name="penggugat" placeholder="" readonly="true">
                    </div>
                </div>
            </div>       
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tergugat</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="tergugat" name="tergugat" value="<?php echo $head['tergugat'];?>" placeholder="" readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Diterima Wilayah Kerja</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="wilayah_terima" name="wilayah_terima"  value="<?php echo Yii::$app->inspektur->getNamaSatker();?>"  readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>       
        	<!-- <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Diterima</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right" id="tanggal_diterima" name="tanggal_diterima" value="<?php// echo $tanggal_diterima;?>" readonly="true" placeholder="DD-MM-YYYY">
                        </div>                      
                    </div>
                </div>
            </div>   --> 
        </div>
	</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-body" style="padding:15px;">
                <!-- <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Putusan</label>        
                            <div class="col-md-8">
                               <input type="text" name="no_putusan" id="no_putusan" class="form-control" value="<?php echo $head['no_putusan']; ?>" required data-error="" readonly />
                            </div>
                        </div>
                    </div>
                </div> -->
                 <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Putusan TK I</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                         <input type="text" class="form-control pull-right" id="tanggal_putusan" name="tanggal_putusan" value="<?php echo $tanggal_putusan;?>" readonly="true" placeholder="DD-MM-YYYY">
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No. Akta Pernyataan Kasasi</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_permohonan_kasasi" id="no_permohonan_kasasi" class="form-control" value="<?php echo $head['no_permohonan_kasasi']; ?>" maxlength="30" required data-error="No Akta Pernyataan Kasasi belum diisi"/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Akta Pernyataan Kasasi</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                         <input type="text" class="form-control datepicker" id="tgl_permohonan_kasasi"  name="tgl_permohonan_kasasi" value="<?php echo $tgl_permohonan_kasasi;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal Akta Pernyataan Kasasi belum diisi"/>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom8"></div> </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
							<?php
								$pathFile3 	= Yii::$app->params['relas_s26'].$head['file_relas'];
								$cek3=($head['file_relas'] && file_exists($pathFile3))?1:0;
							?>
							<input type="hidden" name="cek_file3" id="cek_file3" value="<?php echo $cek3; ?>">
                                <input type="file" name="file_template3" id="file_template3" class="form-inputfile" value="<?php echo $head['file_relas']; ?>" />                    
                                <label for="file_template3" class="label-inputfile">
                                    <?php 
                                        $pathFile   = Yii::$app->params['relas_s26'].$head['file_relas'];
                                        $labelFile  = 'Upload File Akta Penyerahan Kasasi';
                                        if($head['file_relas'] && file_exists($pathFile)){
                                            $labelFile  = 'Ubah File Akta Penyerahan Kasasi';
                                            $param1     = chunk_split(base64_encode($pathFile));
                                            $param2     = chunk_split(base64_encode($head['file_relas']));
                                            $linkPt     = "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                            $extPt      = substr($head['file_relas'], strrpos($head['file_relas'],'.'));
                                            echo '<a href="'.$linkPt.'" title="'.$head['file_relas'].'" style="float:left; margin-right:10px;">
                                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                        }
                                    ?>
                                    <div class="input-group">
                                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                        <input type="text" class="form-control" readonly />
                                    </div>
                                    <div class="help-block with-errors" id="error_custom10"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
							<?php
								$pathFile2 	= Yii::$app->params['permohonan_kasasi'].$head['file_permohonan_kasasi'];
								$cek2=($head['file_permohonan_kasasi'] && file_exists($pathFile2))?1:0;
							?>
							<input type="hidden" name="cek_file2" id="cek_file2" value="<?php echo $cek2; ?>">
                                <input type="file" name="file_template2" id="file_template2" class="form-inputfile" value="<?php echo $head['file_permohonan_kasasi']; ?>" />                    
                                <label for="file_template2" class="label-inputfile">
                                    <?php 
                                        $pathFile   = Yii::$app->params['permohonan_kasasi'].$head['file_permohonan_kasasi'];
                                        $labelFile  = 'Upload File Akta Pernyataan Kasasi';
                                        if($head['file_permohonan_kasasi'] && file_exists($pathFile)){
                                            $labelFile  = 'Ubah File Akta Pernyataan Kasasi';
                                            $param1     = chunk_split(base64_encode($pathFile));
                                            $param2     = chunk_split(base64_encode($head['file_permohonan_kasasi']));
                                            $linkPt     = "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                            $extPt      = substr($head['file_permohonan_kasasi'], strrpos($head['file_permohonan_kasasi'],'.'));
                                            echo '<a href="'.$linkPt.'" title="'.$head['file_permohonan_kasasi'].'" style="float:left; margin-right:10px;">
                                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                        }
                                    ?>
                                    <div class="input-group">
                                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                        <input type="text" class="form-control" readonly />
                                    </div>
                                    <div class="help-block with-errors" id="error_custom9"></div>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
				
            </div>
        </div>          
    </div>
	<div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-body" style="padding:15px;">
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Dikeluarkan</label>        
                            <div class="col-md-8">
                                <input type="text" name="diklr" id="diklr" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" required data-error="" readonly/>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control datepicker ?> " id="tanggal_s26"  name="tanggal_s26" value="<?php echo $tanggal_s26;?>" placeholder="DD-MM-YYYY" />
                                </div>
                            </div> 
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom5"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Kepada Yth.</label>
                            <div class="col-md-8">
                                <textarea id="kepada_yth_s26" name="kepada_yth_s26" class="form-control" style="height:80px;" maxlength="200"><?php echo $head['kepada_yth_s26']; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Melalui</label>
                            <div class="col-md-8">
                                <textarea id="melalui" name="melalui" class="form-control" style="height:50px;" maxlength="200" ><?php echo $melalui; ?></textarea>
								<div class="help-block with-errors" id="error_custom7"></div>
							</div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di -</label>        
                            <div class="col-md-8">
                                <input type="text" name="di_s26" id="di_s26" class="form-control" value="<?php echo $head['di_s26']; ?>" maxlength="30"/>
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>			
	</div>
</div>

<!--
<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-pemberi-kuasa" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-10"><a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah JPN</a></div> 
                    <div class="col-sm-2"><div class="text-right"><a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn">Hapus</a></div></div> 
                </div>      
            </div>
			
			<div class="box-body" style="padding:15px;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-jpn-modal">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="20%">NIP</th>
                                <th class="text-center" width="40%">Nama</th>
                                <th class="text-center" width="30%">Pangkat & Golongan</th>
                                <th class="text-center" width="5%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            /* if($isNewRecord){
								$sqlnya = "select nip_pegawai as nip, nama_pegawai as nama, jabatan_pegawai as jabatan_jpn, pangkat_pegawai as pangkat_jpn, gol_pegawai as gol_jpn, pangkat_pegawai||' ('||gol_pegawai||')' as pangkatgol  
                                        from datun.skks_anak where no_register_perkara = '".$head['no_register_perkara']."' and no_surat = '".$head['no_surat']."' and no_register_skks = '".$head['no_register_skks']."'
										and tanggal_skk = '".$head['tanggal_skk']."' and no_register_skk = '".$head['no_register_skk']."' order by nip_pegawai";
                            } else {
								$sqlnya = "select nip, nama, jabatan as jabatan_jpn,pangkat as pangkat_jpn  , golongan as gol_jpn, pangkat||' ('||golongan||')' as pangkatgol   
                                        from datun.s26_anak where no_register_skks = '".$head['no_register_skks']."' and tanggal_s26 = '".$head['tanggal_s26']."' 
										and no_putusan = '".$head['no_putusan']."' order by nip";
                           	}
							$hasil = User::findBySql($sqlnya)->asArray()->all();
                            if(count($hasil) == 0)
                                echo '<tr><td colspan="5">Data tidak ditemukan</td></tr>';
                            else{
                                $nom = 0;
                                foreach($hasil as $data){
                                    $nom++;	
									$idJpn = $data['nip']."#".$data['nama']."#".$data['pangkatgol']."#".$data['gol_jpn']."#".$data['pangkat_jpn']."#".$data['jabatan_jpn'];		 */				
                         ?>	
                              <tr data-id="<?php echo $data['nip'];?>">
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                                    <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                                </td>
                                <td class="text-left"><?php echo $data['nip'];?></td>
                                <td class="text-left"><?php echo $data['nama'];?></td>
                                <td class="text-left"><?php echo $data['pangkatgol'];?></td>
                                <td class="text-center">
                                    <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                                </td>
                             </tr>
                         <?php // } } ?>
                        </tbody>
                    </table>
                </div>
                <div class="help-block with-errors" id="error_custom1"></div>
            </div>
          
        </div>          
    </div>
</div> -->

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">    
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active"><a href="#tab-alasan" data-toggle="tab">ALASAN</a></li>  
                            <li><a href="#tab-primair" data-toggle="tab">PRIMAIR </a></li>  
                            <li><a href="#tab-subsidair" data-toggle="tab">SUBSIDAIR</a></li>  
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-alasan">
                                <textarea class="ckeditor" id="tab_alasan" name="tab_alasan" ><?php echo $head['alasan_kasasi']; ?></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                            <div class="tab-pane fade in" id="tab-primair">
                                <textarea class="ckeditor" id="tab_primair" name="tab_primair" ><?php echo $head['isi_petitum_primer']; ?></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                            <div class="tab-pane fade in" id="tab-subsidair">
                                <textarea class="ckeditor" id="tab_subsidair" name="tab_subsidair" ><?php echo $subsidair; ?></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">        
   <div class="col-md-4">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4"><b>I N K R A C H T<b></label>        
            <div class="col-md-4">
              <input type="checkbox" name="inkrah" id="inkrah" <?php echo ($head['is_inkrah']?'checked':'' ); ?> value="1"/>
             </div>
			<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom1"></div></div>
        </div>
    </div>       
</div>	
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <?php
					$pathFile 	= Yii::$app->params['s26'].$head['file_s26'];
					$cek=($head['file_s26'] && file_exists($pathFile))?1:0;
				?>
				<input type="hidden" name="cek_file" id="cek_file" value="<?php echo $cek; ?>">
				<input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['s26'].$head['file_s26'];
                        $labelFile 	= 'Upload File S-26';
                        if($head['file_s26'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File S-26';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($head['file_s26']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($head['file_s26'], strrpos($head['file_s26'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$head['file_s26'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom3"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <?php // if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php //} ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa Pengacara Negara</h4>
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
		$("#jpn_modal").find(".modal-body").load("/datun/getjpn/index");
		$("#jpn_modal").modal({backdrop:"static"});
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
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'</td>'+
				'<td>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'</td>'+
				'<td>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		}

		$("#cekModalJpn_"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
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
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
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
	
	$("select#no_skk, select#no_skks").select2({placeholder:"Pilih salah satu", allowClear:false});
	$("select#no_skk").on("change", function(){
		var nom_skk = $(this).val();
		var tgl_skk = $("select#no_skk option:selected").data("tgl");
		$("#tanggal_skk").val(tgl_skk);
		$("select#no_skks").val("").trigger("change");
		$("select#no_skks option").remove();
		$("#tanggal_skks").val("");
		if(nom_skk != ''){
			$("body").addClass("loading");
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/getskks/index'; ?>',
				data	: { q1 : nom_skk, q2 : tgl_skk },
				cache	: false,
				dataType: 'json',
				success : function(data){
					$("body").removeClass("loading");
					if(data.hasil){
						$("select#no_skks").append(data.hasil).trigger("change");
					}
				}
			});
		}
	});

	$("select#no_skks").on("change", function(){
		var nilai = $(this).val();
		$("#tanggal_skks").val('');
		if(nilai != ''){
			var tgl_skks = $("select#no_skks option:selected").data("tgl");
			$("#tanggal_skks").val(tgl_skks);
		}
	});
});
	
</script>
<?php } ?>