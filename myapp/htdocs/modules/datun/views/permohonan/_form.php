<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	use app\modules\datun\models\searchs\Instansi as pilih;
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/permohonan/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Register Bantuan Hukum</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div id="error_custom0"></div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Jenis Instansi</label>        
        			<div class="col-md-8">
                        <?php if($isNewRecord){ ?>
                        <select id="jns_instansi" name="jns_instansi" class="select2" style="width:100%;" required data-error="Jenis Instansi belum dipilih">
                            <option></option>
                            <?php 
                                $jns = pilih::findBySql("select * from datun.jenis_instansi order by kode_jenis_instansi")->asArray()->all();
                                foreach($jns as $ji){
                                    $selected = ($ji['kode_jenis_instansi'] == $model['kode_jenis_instansi'])?'selected':'';
                                    echo '<option value="'.$ji['kode_jenis_instansi'].'" '.$selected.'>'.$ji['deskripsi_jnsinstansi'].'</option>';
                                }
                            ?>
                        </select>
                        <?php } else{ ?>
                        <input type="hidden" name="jns_instansi" id="jns_instansi" value="<?php echo $model['kode_jenis_instansi'];?>" />
                        <input type="text" name="jns_txt" id="jns_txt" class="form-control" value="<?php echo $model['deskripsi_jnsinstansi'];?>" readonly />
                        <?php } ?>
                        <div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama Instansi</label>        
        			<div class="col-md-8">
                        <div class="input-group">
                            <input type="hidden" name="kode_instansi" id="kode_instansi" value="<?php echo $model['kode_instansi'];?>" />
                            <input type="text" name="nama_instansi" id="nama_instansi" class="form-control" value="<?php echo $model['deskripsi_instansi'];?>" readonly>
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success btn-sm" id="btn_instansi"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="help-block with-errors" id="error_custom1"></div>
                    </div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Surat</label>
                    <div class="col-md-8">
                        <?php if($isNewRecord){ ?>
                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="<?php echo $model['no_surat'];?>" maxlength="40" />
                        <?php } else if(!$isNewRecord && in_array($model['kode_jenis_instansi'], array("01","06"))){ ?>
                        <input type="hidden" name="no_surat" id="no_surat" value="<?php echo $model['no_surat'];?>" />
                        <input type="text" class="form-control" readonly />
                        <?php } else if(!$isNewRecord && !in_array($model['kode_jenis_instansi'], array("01","06"))){ ?>
                        <input type="text" name="no_surat" id="no_surat" class="form-control" value="<?php echo $model['no_surat'];?>" maxlength="40" readonly />
                        <?php } ?>
                        <div class="help-block with-errors" id="error_custom_no_surat"></div>
                    </div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Wilayah</label>
                    <div class="col-md-8">
                        <div class="input-group">
                            <input type="hidden" name="no_urut_wil" id="no_urut_wil" value="<?php echo $model['no_urut_wil'];?>" />
                            <input type="hidden" name="kode_prop" id="kode_prop" value="<?php echo $model['kode_provinsi'];?>" />
                            <input type="hidden" name="kode_wilayah" id="kode_wilayah" value="<?php echo $model['kode_kabupaten'];?>" />
                            <input type="text" name="wilayah" id="wilayah" class="form-control" value="<?php echo $model['deskripsi_inst_wilayah'];?>" readonly />
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-success btn-sm" id="btn_wilayah"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                        <div class="help-block with-errors" id="error_custom2"></div>
                    </div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama Pimpinan</label>
                    <div class="col-md-8">
                        <input type="text" name="nm_pemimpin" id="nm_pemimpin" class="form-control" value="<?php echo $model['pimpinan_pemohon'];?>" required data-error="Nama Pimpinan belum diisi" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Permohonan</label>        
        			<div class="col-md-4">
        				<div class="input-group">
        					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        					<input type="text" name="tgl_permohonan" id="tgl_permohonan" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_pemohon'];?>" required data-error="Tanggal permohonan belum diisi" />
        				</div>
        			</div>
                	<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom7"></div></div>
        		</div>
        	</div>
        </div>
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Alamat Instansi</label>
        			<div class="col-md-8">
            			<textarea id="alamat_instansi" name="alamat_instansi" class="form-control" style="height:90px;" required data-error="Alamat Instansi belum diisi" readonly ><?php echo $model['alamat_instansi'];?></textarea>
                        <div class="help-block with-errors"></div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No Telepon</label>
        			<div class="col-md-8">
                    	<input type="text" name="no_telepon" id="no_telepon" class="form-control number-only" value="<?php echo $model['telp_instansi'];?>" required data-error="No Telepon belum diisi" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal Diterima</label>
        			<div class="col-md-4">
        				<div class="input-group">
        					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
        					<input type="text" name="tgl_diterima" id="tgl_diterima" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_diterima'];?>" required data-error="Tanggal diterima belum diisi" />
        				</div>
        			</div>
                	<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom8"></div></div>
        		</div>
			</div>
		</div>
        <div class="row">
            <div class="col-md-6">
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                            <div class="col-md-8">
                                <input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo Yii::$app->inspektur->getNamaSatker();?>" readonly />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
					</div>
				</div>
            	<div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Status Pemohon</label>
                            <div class="col-md-4">
                                <select id="status_pemohon" name="status_pemohon" class="select2" style="width:100%">
                                    <option></option>
                                    <option value="TERGUGAT" <?php echo ($model['status_pemohon'] == 'TERGUGAT')?'selected':'';?>>Tergugat</option>
                                    <option value="TURUT TERGUGAT" <?php echo ($model['status_pemohon'] == 'TURUT TERGUGAT')?'selected':'';?>>Turut Tergugat</option>
                                </select>      
                            </div>
                            <div class="col-md-3">
                            	<div class="input-group">
                                	<div class="input-group-addon" style="border:none; font-size:12px; padding-right:5px;">Ke -</div>
                                    <input type="text" name="num_status" id="num_status" maxlength="2" class="form-control number-only" value="<?php echo $model['no_status_pemohon'];?>" />
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom3"></div></div>
                        </div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
            	<fieldset class="scheduler-border">
                	<legend class="scheduler-border">PIC(Person-In-Charge)</legend>
                    <div class="row">
                    	<div class="col-sm-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Nama</label>
                                <div class="col-md-8">
                                    <input type="text" name="nm_pic" id="nm_pic" class="form-control" value="<?php echo $model['nama_pic'];?>" required data-error="Nama PIC belum diisi" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
						</div>
					</div>
                    <div class="row">
                    	<div class="col-sm-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Jabatan</label>
                                <div class="col-md-8">
                                    <input type="text" name="jabatan_pic" id="jabatan_pic" class="form-control" value="<?php echo $model['jabatan_pic'];?>" required data-error="Jabatan PIC belum diisi" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
						</div>
					</div>
                    <div class="row">
                    	<div class="col-sm-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">No Handphone</label>
                                <div class="col-md-8">
                                    <input type="text" name="no_telepon_pic" id="no_telepon_pic" maxlength="15" class="form-control number-only" value="<?php echo $model['no_handphone_pic'];?>" required data-error="No handphone PIC belum diisi" />
                                    <div class="help-block with-errors"></div>
                                </div>
                            </div>
						</div>
					</div>
                </fieldset>
			</div>
		</div>

    </div>
</div>

<div class="row">
	<div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color:#c7c7c7; margin:10px 10px 0px;">
                <h3 class="box-title">Tergugat/Turut Tergugat</h3>
            </div>
            <div class="box-body" style="padding:15px;">
				<p><a class="btn btn-success btn-sm" id="addrow2"><i class="fa fa-plus jarak-kanan"></i>Tambah Data</a></p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table2">
                    	<thead>
                        	<tr>
                                <th class="text-center" width="45%">Nama Instansi</th>
                                <th class="text-center" width="30%">Status</th>
                                <th class="text-center" width="15%">Urut</th>
                                <th class="text-center" width="10%">Aksi</th>
                    		</tr>
						</thead>
                        <tbody>
                        <?php
							$sql1 = "select * from datun.turut_tergugat where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'
									 order by no_urut";
							$arr1 = pilih::findBySql($sql1)->asArray()->all();
							if(count($arr1) > 0){
								$nom1 = 0;
								foreach($arr1 as $data1){
									$nom1++;
									$urutgt = $data1['no_status_tergugat'];
									echo '<tr data-id="'.$nom1.'">
										<td><input type="text" name="nm_ins[]" id="nm_ins'.$nom1.'" class="form-control input-sm" value="'.$data1['nama_instansi'].'" /></td>
										<td class="form-group-sm"><select name="sts[]" id="sts'.$nom1.'" class="select2" style="width:100%">
											<option></option>
											<option value="TERGUGAT" '.($data1['status_tergugat'] == 'TERGUGAT'?'selected':'').'>Tergugat</option>
											<option value="TURUT TERGUGAT" '.($data1['status_tergugat'] == 'TURUT TERGUGAT'?'selected':'').'>Turut Tergugat</option>
										</select></td>
										<td><input type="text" name="urut[]" id="urut'.$nom1.'" class="form-control input-sm number-only" value="'.$urutgt.'" /></td>
										<td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>
									</tr>';
								}
							}
						?>
                        </tbody>
                    </table>
				</div>
                <div class="help-block with-errors" id="error_custom10"></div>	
			</div>
            <div class="box-header with-border" style="border-color: #c7c7c7;margin: 10px;">
                <h3 class="box-title">Panggilan Pengadilan</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Asal Panggilan</label>
                            <div class="col-md-8">
                                <div class="input-group">
                                    <input type="hidden" name="kode_pengadilan_tk1" id="kode_pengadilan_tk1" value="<?php echo $model['kode_pengadilan_tk1'];?>" />
                                    <input type="hidden" name="kode_pengadilan_tk2" id="kode_pengadilan_tk2" value="<?php echo $model['kode_pengadilan_tk2'];?>" />
                                    <input type="text" name="nama_pengadilan" id="nama_pengadilan" class="form-control" value="<?php echo $model['nama_pengadilan'];?>" readonly />
                                    <div class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-sm" id="btn_pengadilan"><i class="fa fa-university"></i></button>
                                    </div>
                                </div>
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No Register Perkara</label>
                            <div class="col-md-8">
                                <input type="text" id="no_reg_perkara" name="no_reg_perkara" class="form-control" value="<?php echo $model['no_register_perkara'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="Nomor perkara belum diisi" maxlength="40" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Panggilan Sidang</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_panggilan" id="tgl_panggilan" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_panggilan'];?>" required data-error="Tanggal panggilan belum diisi" />
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom9"></div></div>
                        </div>
                    </div>
                </div> 
            </div>
		</div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color:#c7c7c7; margin:10px 10px 0px;">
                <h3 class="box-title">Lawan Pemohon</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <p><a class="btn btn-success btn-sm" id="addrow3"><i class="fa fa-plus jarak-kanan"></i>Tambah Data</a></p>
                <div class="table-responsive">
                    <table class="table table-bordered" id="table3">
                        <thead>
                            <tr>
                                <th class="text-center" width="15%">No</th>
                                <th class="text-center" width="75%">Nama</th>
                                <th class="text-center" width="10%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                            $sql2 = "select * from datun.lawan_pemohon where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'
                                     order by no_urut";
                            $arr2 = pilih::findBySql($sql2)->asArray()->all();
                            if(count($arr2) > 0){
                                $nom2 = 0;
                                foreach($arr2 as $data2){
                                    $nom2++;
                                    echo '<tr data-id="'.$nom2.'">
                                        <td class="text-center"><span class="nomnya">'.$data2['no_urut'].'</span></td>
                                        <td><input type="text" name="nm_lawan[]" id="nm_lawan'.$nom2.'" class="form-control input-sm" value="'.$data2['nama_instansi'].'" /></td>
                                        <td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>
                                    </tr>';
                                }
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
                <div class="help-block with-errors" id="error_custom5"></div>
            </div>
            <div class="box-header with-border" style="border-color: #c7c7c7;margin: 10px;">
                <h3 class="box-title">Permasalahan</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <textarea id="permasalahan" name="permasalahan" class="form-control" style="height:90px;"><?php echo $model['permasalahan_pemohon'];?></textarea>
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
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_permohonan" id="file_permohonan" class="form-inputfile" />                    
                <label for="file_permohonan" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['permohonan'].$model['file_pemohon'];
                        $labelFile 	= 'Upload File Register';
                        if($model['file_pemohon'] && file_exists($pathFile)){
                            //$labelFile 	= 'Ubah File Register';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_pemohon']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_pemohon'], strrpos($model['file_pemohon'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_pemohon'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom6"></div>
                </label>
                <h6 style="margin-top: 0px;"><i>*File Max 2MB</i></h6>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan1" name="simpan1"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <a href="/datun/permohonan/index" class="btn btn-danger">Batal</a>
</div>
</form>

<!--INSTANSI-->
<div class="modal fade" id="tambah_intansi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Instansi</h4>
            </div>
			<div class="modal-body"></div>
        </div>
    </div>
</div>

<!--WILAYAH-->
<div class="modal fade" id="tambah_wilayah" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Wilayah Instansi</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--PENGADILAN-->
<div class="modal fade" id="tambah_pengadilan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pengadilan</h4>
            </div>			
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--FORM INSTANSI-->
<div class="modal fade" id="tambah_form_intansi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Instansi</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--FORM WILAYAH INSTANSI-->
<div class="modal fade" id="tambah_form_wilintansi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Wilayah Instansi</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--FORM PENGADILAN-->
<div class="modal fade" id="tambah_form_pengadilan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Form Pengadilan</h4>
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
	$(function() {
		$("#jns_instansi").on("change", function(){
			$("#kode_instansi, #nama_instansi, #kode_prop, #kode_wilayah, #no_urut_wil, #nm_pemimpin, #alamat_instansi, #no_telepon, #wilayah").val("");
			var nilai = $(this).val();
			if(nilai == '01' || nilai == '06'){
				$("#no_surat").val("").attr("readonly", "readonly");
			} else{
				$("#no_surat").val("").removeAttr("readonly");
			}
		});
		$("#btn_instansi").on('click', function(e){
			var kd = $("#jns_instansi").val(); 
			if(kd == ""){
				bootbox.alert({message:"Jenis instansi belum dipilih!", size:'small', closeButton: false});
			}else{
				//$("#kode_instansi, #nama_instansi, #kode_prop, #kode_wilayah, #no_urut_wil, #nm_pemimpin, #alamat_instansi, #no_telepon, #wilayah").val("");
				$("#tambah_intansi").find(".modal-body").load("/datun/permohonan/getisnta?id="+kd);
				$("#tambah_intansi").modal({backdrop:"static"});
			}
		});
		$("#tambah_intansi").on('show.bs.modal', function(e){
			$("#tambah_intansi").find(".modal-body").html("");
			$("body").addClass("loading");
		}).on('shown.bs.modal', function(e){
			$("body").removeClass("loading");
		}).on('click', "#tmbh_instansi", function(){
			var id = $(this).data("id");
			$("#tambah_form_intansi").find(".modal-body").load("/datun/permohonan/getformins?id="+id);
			$("#tambah_form_intansi").modal({backdrop:"static"});
		}).on('click', "#idPilih", function(){
			var id = $(".selection_one:checked").val();
			getInsModal(id);
		}).on("dblclick", "#jns-ins-modal td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			getInsModal(id);
		}).on("click", "#idUbah", function(){
			var id = $(".selection_one:checked").val();
			var tm = id.toString().split("#");
			$("#tambah_form_intansi").find(".modal-body").load("/datun/permohonan/getformins?id="+tm[2]+"&idins="+tm[0]);
			$("#tambah_form_intansi").modal({backdrop:"static"});
		}).on("click", "#idHapus", function(){
			hapusFormModal($(".selection_one:checked"), '/datun/permohonan/hapusinstansi', $("#filter-link"), '#myPjaxModalIns');
    	}); 
		function getInsModal(id){
			$("#kode_instansi, #nama_instansi, #kode_prop, #kode_wilayah, #no_urut_wil, #nm_pemimpin, #alamat_instansi, #no_telepon, #wilayah").val("");
			var tm = id.toString().split('#');
			$("#kode_instansi").val(tm[0]);
			$("#nama_instansi").val(tm[1]);
			$("#tambah_intansi").modal("hide");
		}
	
		$("#btn_wilayah").on('click', function(e){
			var kd    	 = $("#jns_instansi").val(); 
			var kdins    = $("#kode_instansi").val(); 
			if(kd == "" || kdins == ""){
				bootbox.alert({message:"Jenis atau nama instansi belum dipilih!", size:'small', closeButton: false});
			}else{
				//$("#kode_prop, #kode_wilayah, #no_urut_wil, #nm_pemimpin, #alamat_instansi, #no_telepon, #wilayah").val("");
				$("#tambah_wilayah").find(".modal-body").load("/datun/permohonan/getwil?id="+kd+"&idins="+kdins);
				$("#tambah_wilayah").modal({backdrop:"static"});
			}
		});
		$("#tambah_wilayah").on('show.bs.modal', function(e){
			$("#tambah_wilayah").find(".modal-body").html("");
			$("body").addClass("loading");
		}).on('shown.bs.modal', function(e){
			$("body").removeClass("loading");
		}).on('click', "#tmbh_wilinstansi", function(){
			var id = $(this).data("id");
			var idins = $(this).data("idins");
			$("#tambah_form_wilintansi").find(".modal-body").load("/datun/permohonan/getformwilins?id="+id+"&idins="+idins);
			$("#tambah_form_wilintansi").modal({backdrop:"static"});
		}).on('click', "#idPilih2", function(){
			var id = $(".selection_one2:checked").val();
			getWilInsModal(id);
		}).on("dblclick", "#wil-ins-modal td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			getWilInsModal(id);
		}).on("click", "#idUbah2", function(){
			var id = $(".selection_one2:checked").val();
			var tm = id.toString().split("#");
			$("#tambah_form_wilintansi").find(".modal-body").load("/datun/permohonan/getformwilins?id="+tm[7]+"&idins="+tm[8]+"&tq3="+tm[0]+"&tq4="+tm[1]+"&tq5="+tm[2]);
			$("#tambah_form_wilintansi").modal({backdrop:"static"});
		}).on("click", "#idHapus2", function(){
			hapusFormModal($(".selection_one2:checked"), '/datun/permohonan/hapuswilinstansi', $("#filter-link2"), '#myPjaxModalWil');
    	});
		function getWilInsModal(id){
			$("#kode_prop, #kode_wilayah, #no_urut_wil, #nm_pemimpin, #alamat_instansi, #no_telepon, #wilayah").val("");
			var tm = id.toString().split('#');
			$("#kode_prop").val(tm[0]);
			$("#kode_wilayah").val(tm[1]);
			$("#no_urut_wil").val(tm[2]);
			$("#nm_pemimpin").val(tm[3]);
			$("#alamat_instansi").val(tm[4]);
			$("#no_telepon").val(tm[5]);
			$("#wilayah").val(tm[6]);
			$("#tambah_wilayah").modal("hide");
		}

		$("#btn_pengadilan").on('click', function(e){
			$("#tambah_pengadilan").find(".modal-body").html("");
			$("#tambah_pengadilan").find(".modal-body").load("/datun/permohonan/getpeng");
			$("#tambah_pengadilan").modal({backdrop:"static"});
		});
		$("#tambah_pengadilan").on('show.bs.modal', function(e){
			$("body").addClass("loading");
		}).on('shown.bs.modal', function(e){
			$("body").removeClass("loading");
		}).on('click', "#tmbh_pengadilan", function(){
			$("#tambah_form_pengadilan").find(".modal-body").load("/datun/permohonan/getformpengadilan");
			$("#tambah_form_pengadilan").modal({backdrop:"static"});
		}).on('click', "#idPilih3", function(){
			var id = $(".selection_one3:checked").val();
			getPengadilanModal(id);
		}).on("dblclick", "#pengadilan-modal td:not(.aksinya)", function(){
			var id = $(this).closest("tr").data("id");
			getPengadilanModal(id);
		}).on("click", "#idUbah3", function(){
			var id = $(".selection_one3:checked").val();
			var tm = id.toString().split("#");
			$("#tambah_form_pengadilan").find(".modal-body").load("/datun/permohonan/getformpengadilan?id="+tm[0]+"."+tm[1]);
			$("#tambah_form_pengadilan").modal({backdrop:"static"});
		}).on("click", "#idHapus3", function(){
			hapusFormModal($(".selection_one3:checked"), '/datun/permohonan/hapuspengadilan', $("#filter-link3"), '#myPjaxModalPeng');
    	});
		function getPengadilanModal(id){
			var tm = id.toString().split('#');
			$("#kode_pengadilan_tk1").val(tm[0]);
			$("#kode_pengadilan_tk2").val(tm[1]);
			$("#nama_pengadilan").val(tm[2]);
			$("#tambah_pengadilan").modal("hide");
		}

		$(document).on('hidden.bs.modal', ".bootbox-confirm", function(e){
			if($(document).find(".modal-backdrop").length > 0) $("body").addClass("modal-open");
    	}).on("hidden.bs.modal", "#tambah_form_intansi", function(){
			if($(document).find(".modal-backdrop").length > 0) $("body").addClass("modal-open");
    	}).on("hidden.bs.modal", "#tambah_form_wilintansi", function(){
			if($(document).find(".modal-backdrop").length > 0) $("body").addClass("modal-open");
    	}).on("hidden.bs.modal", "#tambah_form_pengadilan", function(){
			if($(document).find(".modal-backdrop").length > 0) $("body").addClass("modal-open");
    	});
		function hapusFormModal(element, urlnya, pjaxUrl, pjaxContent){
			var id = [], n = element.length;
			for(var i = 0; i < n; i++){
				var test = element.eq(i);
				id.push(test.val());
			}
			bootbox.confirm({
				message: "Apakah anda ingin menghapus data ini?", size: "small", closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'}, 
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function(result){
					if(result){
						$.ajax({type:"POST", url:urlnya, data:{'id':id}, cache:false, dataType:"json",
						success : function(data){ 
							$.pjax({url: pjaxUrl.text(), container: pjaxContent, 'push':false, 'timeout':false});
						}});
					}
				}
			});
		}

		$("#addrow2").on("click", function(){
			var tabel	= $('#table2 > tbody').find('tr:last');			
			var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
			$('#table2 > tbody').append('<tr data-id="'+newId+'">'+
				'<td><input type="text" name="nm_ins[]" id="nm_ins'+newId+'" class="form-control input-sm" /></td>'+
				'<td class="form-group-sm"><select name="sts[]" id="sts'+newId+'" class="select2" style="width:100%">'+
					'<option></option>'+
					'<option value="TERGUGAT">Tergugat</option>'+
					'<option value="TURUT TERGUGAT">Turut Tergugat</option>'+
				'</select></td>'+
				'<td><input type="text" name="urut[]" id="urut'+newId+'" class="form-control input-sm number-only" /></td>'+
				'<td class="text-center"><a class="btn btn-danger btn-sm hRow" style="padding: 2px 7px;"><i class="fa fa-times"></i></a></td>'+
			'</tr>');
			$("#sts"+newId).select2({allowClear:true, placeholder:'Pilih salah satu'});
		});
		$("#table2").on("click", ".hRow", function(){
			var tabel = $(this).parents("tr");
			tabel.remove();
		});
	
		$("#addrow3").on("click", function(){
			var tabel	= $('#table3 > tbody').find('tr:last');			
			var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
			$('#table3 > tbody').append('<tr data-id="'+newId+'">'+
				'<td class="text-center"><span class="nomnya"></span></td>'+
				'<td><input type="text" name="nm_lawan[]" id="nm_lawan'+newId+'" class="form-control input-sm" /></td>'+
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