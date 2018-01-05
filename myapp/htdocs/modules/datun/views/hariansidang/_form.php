<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\HarianSidang as pilih;
	$helpernya	= Yii::$app->inspektur;
	$tanggalS11 = ($head['tanggal_s11'])?date ('d-m-Y',strtotime($head['tanggal_s11'])):'';
	$tmp_pggt 	= explode("#", $head['penggugat']);
	$penggugat 	= (count($tmp_pggt) > 1)?$tmp_pggt[0].', Dkk':$tmp_pggt[0];
	
?>
<form id="harian-form" name="harian-form" class="form-validasi form-horizontal" method="post" action="/datun/hariansidang/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
        <div class="box-body" style="padding:15px;">
            <div class="row">
				<div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Perkara Perdata</label>
                        <div class="col-md-8">
                            <input type="hidden" id="no_surat" name="no_surat" value="<?php echo $head['no_surat'];?>" />
                            <input type="hidden" id="kode_jenis_instansi" name="kode_jenis_instansi" value="<?php echo $head['kode_jenis_instansi'];?>" />
                            <input type="hidden" id="kode_instansi" name="kode_instansi" value="<?php echo $head['kode_instansi'];?>" />
						    <input type="text" class="form-control" id="no_perkara_perdata" name="no_perkara_perdata" value="<?php echo $head['no_register_perkara'];?>" readonly />
					   </div>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Asal Panggilan</label>
                        <div class="col-md-8">
						    <input type="hidden" id="kode_kabupaten" name="kode_kabupaten" value="<?php echo $head['kode_kabupaten'];?>" />
						    <input type="hidden" id="tanggal_panggilan_sidang" name="tanggal_panggilan_sidang" value="<?php echo $head['tanggal_panggilan_pengadilan'];?>" />
                            <input type="text" class="form-control" id="asal_panggilan" name="asal_panggilan" value="<?php echo $head['nama_pengadilan'];?>" readonly />
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
									$resOpt1 = pilih::findBySql($sqlOpt1)->asArray()->all();
									foreach($resOpt1 as $dOpt1){
										$selected = ($dOpt1['no_register_skk'] == $head['no_register_skk']?'selected':'');
										$frmtTgls = date("d-m-Y", strtotime($dOpt1['tanggal_skk']));
										$tampilan = ($head['kode_jenis_instansi'] == '01')?$dOpt1['no_register_skk'].' ('.$frmtTgls.')':$dOpt1['no_register_skk'];
										echo '<option value="'.$dOpt1['no_register_skk'].'" '.$selected.' data-tgl="'.$frmtTgls.'">'.$tampilan.'</option>';
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
                        <label class="control-label col-md-4">Tanggal SKK</label>
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<?php if($isNewRecord){ ?>
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo ($resOpt1[0]['tanggal_skk'])?date("d-m-Y", strtotime($resOpt1[0]['tanggal_skk'])):'';?>" readonly />
                                <?php } else { ?>
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo $head['tanggal_skk'];?>" readonly /> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
        	
			<div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. SKKS </label>
                        <div class="col-md-8">
							<?php if($isNewRecord){ ?>
                            <select name="no_skks" id="no_skks" style="width:100%;">
								<?php 
									$sqlOpt2 = "select a.no_register_skks, a.tanggal_ttd as tanggal_skks from datun.skks a 
												where a.no_register_perkara = '".$_SESSION['no_register_perkara']."' and a.no_surat = '".$_SESSION['no_surat']."' 
													and a.no_register_skk = '".$resOpt1[0]['no_register_skk']."' and a.tanggal_skk = '".$resOpt1[0]['tanggal_skk']."' 
													and a.penerima_kuasa = 'JPN' 
												order by a.is_active desc";
									$resOpt2 = pilih::findBySql($sqlOpt2)->asArray()->all();
									foreach($resOpt2 as $dOpt2){
										$selected = ($dOpt2['no_register_skks'] == $head['no_register_skks']?'selected':'');
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
                        <label class="control-label col-md-4">Tanggal SKKS</label>
                        <div class="col-md-4">
                            <div class="input-group date">
                                <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<?php if($isNewRecord){ ?>
                                <input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo ($resOpt2[0]['tanggal_skks'])?date("d-m-Y", strtotime($resOpt2[0]['tanggal_skks'])):'';?>" readonly />
                                <?php } else { ?>
                                <input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo $head['tanggal_skks'];?>" readonly /> 
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
			</div>		

            <div class="row">
				<div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Tergugat</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="tergugat" name="tergugat" value="<?php echo $head['tergugat'];?>" readonly />
                        </div>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Penggugat</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="penggugat" name="penggugat" value="<?php echo $penggugat;?>" readonly />
                        </div>
                    </div>
                </div>				
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="wilayah_terima" name="wilayah_terima" value="<?php echo $helpernya->getNamaSatker();?>" readonly/>
                        </div>
                    </div>
                </div>
			</div>

        </div>
	</div>

    <div class="box box-primary" style="border-color:#f39c12; overflow:visible;">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
            <h3 class="box-title">Waktu</h3>
        </div>
        <div class="box-body" style="padding:15px;">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Tanggal</label>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control <?php echo ($isNewRecord)?'datepicker':'' ?> " id="waktu_tanggal"  name="waktu_tanggal" value="<?php echo $tanggalS11;?>" placeholder="DD-MM-YYYY" <?php echo ($isNewRecord)?'':'readonly' ?>  required data-error="Tanggal Harian Sidang belum diisi"/>
                            </div>
                            <div class="help-block with-errors" id="error_custom7"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Hari</label>
                        <div class="col-md-6">
                        <input type="text" readonly="true" class="form-control" id="waktu_hari"  name="waktu_hari" value="<?php echo $head['hari'];?>"/>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-2">Jam</label>
                        <div class="col-md-6">
                            <div class="input-group bootstrap-timepicker">
                                <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                                <input type="text" name="waktu_sidang" id="waktu_sidang" value="<?php echo ($isNewRecord)? '00:00':$head['waktu_sidang']; ?>" class="form-control timepicker" />
                            </div>
                        </div>
                        <div class="col-md-offset-2 col-md-10"><div class="help-block with-errors" id="error_custom10"></div></div>
                    </div>
                </div>
            </div>
		</div>
	</div>
	
    <div class="row">
		<div class="col-md-6">
        	<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
                <div class="box-header with-border" style="border-color: #c7c7c7;">
                    <h3 class="box-title">Majelis Hakim</h3>
                </div>
                <div class="box-body" style="padding:15px;">
					<p><a class="btn btn-success btn-sm" id="addrow2"><i class="fa fa-plus jarak-kanan"></i>Tambah Data</a></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table2">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10%">No</th>
                                    <th class="text-center" width="45%">Nama</th>
                                    <th class="text-center" width="30%">Status</th>
                                    <th class="text-center" width="15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                            
                            /* */
                            
                            if($isNewRecord!=1){
                                $sql1 = "SELECT * from datun.s11_majelis_hakim 
                                        where no_register_perkara = '".$head['no_register_perkara']."' 
                                        and no_surat = '".$head['no_surat']."'
                                        and tanggal_s11 = '".$head['tanggal_s11']."'
                                        order by no_urut_majelis  ";
                            }else{
                                /* $sql1 = "SELECT * from datun.s11_majelis_hakim 
                                        where no_register_skk = '".$head['no_register_skk']."'  
                                        and no_register_perkara = '".$head['no_register_perkara']."' 
                                        and no_surat = '".$head['no_surat']."'
                                        and tanggal_skk = '".$helpernya->tgl_db($head['tanggal_skk'])."'
                                        and tanggal_s11=(SELECT max(tanggal_s11) from datun.s11_majelis_hakim  
                                        where no_register_perkara='".$head['no_register_perkara']."' and no_surat='".$head['no_surat']."'
                                        and no_register_skk='".$head['no_register_skk']."'  and tanggal_skk='".$helpernya->tgl_db($head['tanggal_skk'])."' ) 
                                        order by no_urut_majelis "; */
                                    $sql1 = "SELECT * from datun.s11_majelis_hakim 
                                        where no_register_perkara = '".$head['no_register_perkara']."' 
                                        and no_surat = '".$head['no_surat']."'
                                        and tanggal_s11=(SELECT max(tanggal_s11) from datun.s11_majelis_hakim  
                                        where no_register_perkara='".$head['no_register_perkara']."' and no_surat='".$head['no_surat']."') 
                                        order by no_urut_majelis ";
                            }
                                $arr1 = pilih::findBySql($sql1)->asArray()->all();
                                if(count($arr1) > 0){
                                    $nom1 = 0;
                                    foreach($arr1 as $data1){
                                        $nom1++;
                                        if($nom1==1){
                                            $aksi_nya	= '<td></td>';
                                        }else{
                                            $aksi_nya	= '<td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>';
                                        }								
                                        echo '<tr data-id="'.$nom1.'">
                                                <td class="text-center"><span class="nomnya">'.$data1['no_urut_majelis'].'</span></td>
                                                <td><input type="text" name="majelis_hakim[]" id="majelis_hakim'.$nom1.'" class="form-control input-sm" value="'.$data1['majelis_hakim'].'" /></td>
                                                <td><input type="text" name="status_majelis[]" id="status_majelis'.$nom1.'" class="form-control input-sm" value="'.$data1['status_majelis'].'" readonly="true" /></td>
                                                '.$aksi_nya.'
                                            </tr>';
                                    }
                                }else{
                                    $nom1 = 1;
                                    echo '<tr data-id="'.$nom1.'">
                                                <td class="text-center"><span class="nomnya">'.$nom1.'</span></td>
                                                <td><input type="text" name="majelis_hakim[]" id="majelis_hakim'.$nom1.'" class="form-control input-sm" value="" /></td>
                                                <td><input type="text" name="status_majelis[]" id="status_majelis'.$nom1.'" class="form-control input-sm" value="Ketua Majelis" readonly="true" /></td>
                                                <td></td>
                                            </tr>';
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>	
					<div class="help-block with-errors" id="error_custom1"></div>
				</div>
			</div>
		</div>

		<div class="col-md-6">
            <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
                <div class="box-header with-border" style="border-color: #c7c7c7;">
                    <h3 class="box-title">Kuasa Penggugat</h3>
                </div>
                <div class="box-body" style="padding:15px;">
					<p><a class="btn btn-success btn-sm" id="addrow3"><i class="fa fa-plus jarak-kanan"></i>Tambah Data</a></p>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="table3">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10%">No</th>
                                    <th class="text-center" width="80%">Nama</th>
                                    <th class="text-center" width="10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                
                            if(!$isNewRecord){
                                $sql2 = "SELECT no_urut_kuasa_penggugat, kuasa_penggugat from datun.s11_kuasa_penggugat
                                         where no_register_perkara = '".$head['no_register_perkara']."' 
                                            and no_surat = '".$head['no_surat']."' and tanggal_s11 = '".$head['tanggal_s11']."' order by no_urut_kuasa_penggugat ";
                            }else{
                                /* $sql2 = "SELECT no_urut_kuasa_penggugat, kuasa_penggugat from datun.s11_kuasa_penggugat 
                                        where no_register_skk = '".$head['no_register_skk']."'  
                                        and no_register_perkara = '".$head['no_register_perkara']."' 
                                        and no_surat = '".$head['no_surat']."'
                                        and tanggal_skk = '".$helpernya->tgl_db($head['tanggal_skk'])."'
                                        and tanggal_s11=(SELECT max(tanggal_s11) from datun.s11_kuasa_penggugat  
                                        where no_register_perkara='".$head['no_register_perkara']."' and no_surat='".$head['no_surat']."'
                                        and no_register_skk='".$head['no_register_skk']."'  and tanggal_skk='".$helpernya->tgl_db($head['tanggal_skk'])."' ) 
                                        order by no_urut_kuasa_penggugat "; */
                                    $sql2 = "SELECT no_urut_kuasa_penggugat, kuasa_penggugat from datun.s11_kuasa_penggugat 
                                        where no_register_perkara = '".$head['no_register_perkara']."' 
                                        and no_surat = '".$head['no_surat']."'
                                        and tanggal_s11=(SELECT max(tanggal_s11) from datun.s11_kuasa_penggugat  
                                        where no_register_perkara='".$head['no_register_perkara']."' and no_surat='".$head['no_surat']."') 
                                        order by no_urut_kuasa_penggugat ";
                            }	
                                $arr2 = pilih::findBySql($sql2)->asArray()->all();
                                if(count($arr2) > 0){
                                    $nom2 = 0;
                                    foreach($arr2 as $data2){
                                        $nom2++;
                                    echo '<tr data-id="'.$nom2.'">
                                            <td class="text-center"><span class="nomnya">'.$data2['no_urut_kuasa_penggugat'].'</span></td>
                                            <td><input type="text" name="kuasa_penggugat[]" id="kuasa_penggugat'.$nom2.'" class="form-control input-sm" value="'.$data2['kuasa_penggugat'].'" /></td>
                                            <td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>
                                        </tr>';
                                    }
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
        <div class="col-md-6">
            <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
                <div class="box-body" style="padding:15px;">
                    <div class="row">
                        <div class="col-md-12">
                             <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Panitera Pengganti</label>
                                <div class="col-md-8">
                                    <?php
                                        if(!$isNewRecord){
                                            $sql3 = "SELECT a.panitera from datun.s11 a
                                                     left join datun.skk b on b.no_register_skk=a.no_register_skk and b.tanggal_skk=a.tanggal_skk and b.no_register_perkara=a.no_register_perkara and b.no_surat=a.no_surat	
                                                     left join datun.skks d on a.no_register_skk=d.no_register_skk and a.tanggal_skk=d.tanggal_skk and a.no_register_perkara=d.no_register_perkara and a.no_surat=d.no_surat and a.no_register_skks=d.no_register_skks
                                                     where a.no_register_perkara = '".$head['no_register_perkara']."' 
                                                     and a.no_surat = '".$head['no_surat']."' 
                                                     and a.tanggal_s11 = '".$head['tanggal_s11']."'";
                                        }else{
                                            /* $sql3 = "SELECT panitera from datun.s11 
                                                     where no_register_skk = '".$head['no_register_skk']."' and no_register_perkara = '".$head['no_register_perkara']."' 
                                                        and no_surat = '".$head['no_surat']."' and tanggal_skk = '".$helpernya->tgl_db($head['tanggal_skk'])."'
                                                     order by tanggal_s11 desc limit 1"; */
                                                $sql3 = "SELECT panitera from datun.s11 
                                                     where no_register_skk = '".$head['no_register_skk']."' and no_register_perkara = '".$head['no_register_perkara']."' 
                                                        and no_surat = '".$head['no_surat']."' order by tanggal_s11 desc limit 1";
                                        }
                                        $arr3 = pilih::findBySql($sql3)->asArray()->scalar();
                                        echo '<input type="text" class="form-control" name="panitera_pengganti" id="panitera_pengganti" value="'.$arr3.'" />';
                                    ?>		
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
                        </div>
					</div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Agenda Sidang</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control pull-right" id="agenda_sidang" name="agenda_sidang" value="<?php echo $head['agenda_sidang'];?>" />
                                    <div class="help-block with-errors"></div>
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
                                <label class="control-label col-md-4">Dikeluarkan di</label>
                                <div class="col-md-8">
                                    <input type="text" name="dikeluarkan_di" id="dikeluarkan_di" class="form-control" value="<?php echo $helpernya->getLokasiSatker()->lokasi;?>" readonly="true" />
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
                                        <input type="text" class="form-control datepicker" id="tanggal_ditandatangani" name="tanggal_ditandatangani" value="<?php echo ($isNewRecord)?date('d-m-Y'):date('d-m-Y',strtotime($head['tanggal_ttd']));?>" placeholder="DD-MM-YYYY" />
                                    </div>
                                    <div class="help-block with-errors" id="error_custom9"></div>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
    </div>

    <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
        <div class="box-body" style="padding:15px;">
            <div class="row">
                <div class="col-md-12">
                    
                    <div class="panel with-nav-tabs panel-default">
                        <div class="panel-heading single-project-nav">
                            <ul class="nav nav-tabs"> 
                                <li class="active"><a href="#tab-kasus-panel" data-toggle="tab">Kasus Posisi</a></li>
                                <li><a href="#tab-laporan-panel" data-toggle="tab">Isi Laporan</a></li>
                                <li><a href="#tab-analisa-panel" data-toggle="tab">Analisa</a></li>
                                <li><a href="#tab-kesimpulan-panel" data-toggle="tab">Kesimpulan</a></li>	
                                <li><a href="#tab-resume-panel" data-toggle="tab">Resume</a></li>	   
                            </ul>
                        </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-kasus-panel">
                                    <textarea class="ckeditor" id="tab_kasus" name="tab_kasus" ><?php echo $head['kasus_posisi'];?></textarea>
                                    <div class="help-block with-errors" id="error_custom2"></div>
                                </div>
                        
                                <div class="tab-pane fade" id="tab-laporan-panel">
                                    <textarea class="ckeditor" id="tab_laporan" name="tab_laporan"><?php echo $head['isi_laporan'];?></textarea>
                                    <div class="help-block with-errors" id="error_custom3"></div>
                                </div>
                                  
                                <div class="tab-pane fade" id="tab-analisa-panel">
                                    <textarea class="ckeditor" id="tab_analisa" name="tab_analisa"><?php echo $head['analisa_laporan'];?></textarea>
                                    <div class="help-block with-errors" id="error_custom4"></div>
                                </div>
                                  
                                <div class="tab-pane fade" id="tab-kesimpulan-panel">
                                    <textarea class="ckeditor" id="tab_kesimpulan" name="tab_kesimpulan"><?php echo $head['kesimpulan'];?></textarea>
                                    <div class="help-block with-errors" id="error_custom5"></div>
                                </div>
                                  
                                <div class="tab-pane fade" id="tab-resume-panel">
                                    <textarea class="ckeditor" id="tab_resume" name="tab_resume"><?php echo $head['resume'];?></textarea>
                                    <div class="help-block with-errors" id="error_custom6"></div>
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
                    <input type="file" name="file_s11" id="file_s11" class="form-inputfile" />                    
                    <label for="file_s11" class="label-inputfile">
                        <?php 
                            $pathFile 	= Yii::$app->params['s11'].$model['file_s11'];
                            $labelFile 	= 'Pilih File S11';
                            $cek		= ($head['file_s11'] && file_exists($pathFile))?1:0;
                            if($head['file_s11'] && file_exists($pathFile)){
                                $labelFile 	= 'Ubah File S11';
                                $param1  	= chunk_split(base64_encode($pathFile));
                                $param2  	= chunk_split(base64_encode($head['file_s11']));
                                $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                $extPt		= substr($head['file_s11'], strrpos($head['file_s11'],'.'));
                                echo '<a href="'.$linkPt.'" title="'.$head['file_s11'].'" style="float:left; margin-right:10px;">
                                <img src="'.$helpernya->getIconFile($extPt).'" /></a>';
                            }
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                            <input type="text" class="form-control" readonly />
                        </div>
                        <div class="help-block with-errors" id="error_custom8"></div>
                        <input type="hidden" name="cek_file" id="cek_file" value="<?php echo $cek;?>" />
                    </label>
                </div>
            </div>
        </div>
    </div>
		    
    <hr style="border-color:#c7c7c7;margin:10px 0;">
    <div class="box-footer text-center"> 
        <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
        <input type="hidden" name="no_sidang" id="no_sidang" value="<?php echo $head['no_sidang']; ?>" />
        <button class="btn btn-warning jarak-kanan" type="submit" id="simpan1" name="simpan1"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
        <a class="btn btn-warning jarak-kanan" href="<?php echo '/datun/hariansidang/cetak?noperkara='.$head['no_register_perkara'].'&nosrt='.$head['no_surat'].'&tgls11='.$head['tanggal_s11']; ?>">Cetak</a>
        <a href="/datun/hariansidang/index" class="btn btn-danger">Batal</a>
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

	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
	$("#waktu_sidang").on('focus', function(){$(this).prev().trigger('click');});
	$("#waktu_tanggal").on("change", function(){
		var arr = ['Minggu','Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'];
		var nil = $(this).val();
		var tgl	= new Date(tgl_auto(nil));
		$('#waktu_hari').val(arr[tgl.getDay()]);
	});

	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});
	
	$("#addrow2").on("click", function(){
		var tabel	= $('#table2 > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table2 > tbody').append('<tr data-id="'+newId+'">'+
			'<td class="text-center"><span class="nomnya"></span></td>'+
			'<td><input type="text" name="majelis_hakim[]" id="majelis_hakim'+newId+'" class="form-control input-sm" /></td>'+
			'<td><input type="text" name="status_majelis[]" id="status_majelis'+newId+'" class="form-control input-sm" value="Hakim Anggota" readonly="true"/></td>'+
			'<td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>'+
		'</tr>');
		$('#table2').find(".nomnya").each(function(i,v){$(v).html(i+1);});
	});
	
	$("#table2").on("click", ".hRow", function(){
		var tabel = $(this).parents("tr");
		tabel.remove();
		$('#table2').find(".nomnya").each(function(i,v){$(v).html(i+1);});
	});
		
		
	$("#addrow3").on("click", function(){
		var tabel	= $('#table3 > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table3 > tbody').append('<tr data-id="'+newId+'">'+
			'<td class="text-center"><span class="nomnya"></span></td>'+
			'<td><input type="text" name="kuasa_penggugat[]" id="kuasa_penggugat'+newId+'" class="form-control input-sm" /></td>'+
			'<td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>'+
		'</tr>');
		$('#table3').find(".nomnya").each(function(i,v){$(v).html(i+1);});
	});
	$("#table3").on("click", ".hRow", function(){
		var tabel = $(this).parents("tr");
		tabel.remove();
		$('#table3').find(".nomnya").each(function(i,v){$(v).html(i+1);});
	});	
});	
</script>
