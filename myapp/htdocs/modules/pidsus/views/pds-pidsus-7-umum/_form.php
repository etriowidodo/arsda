<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus7Umum;

	$this->title 	= 'Pidsus-7 Umum';
	$this->subtitle = 'Nota Dinas Laporan Hasil Ekspose';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-pidsus-7-umum/index';
	$linkCetak		= '/pidsus/pds-pidsus-7-umum/cetak?id1='.rawurlencode($model['no_pidsus7_umum']);
	if($isNewRecord){
		$sqlCek = "select a.no_p8_umum, a.tgl_p8_umum from pidsus.pds_p8_umum a where ".$whereDefault;
		$model 	= PdsPidsus7Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum = ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_pidsus7 = ($model['tgl_pidsus7'])?date('d-m-Y',strtotime($model['tgl_pidsus7'])):'';
	$tgl_ekspose = ($model['tgl_ekspose'])?date('d-m-Y',strtotime($model['tgl_ekspose'])):'';
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-7-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Ekspose</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Nota Dinas</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_pidsus7" id="tgl_pidsus7" class="form-control datepicker" value="<?php echo $tgl_pidsus7;?>" required data-error="Tanggal Nota Dinas belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_pidsus7"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pelaksanaan Ekspose</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_ekspose" id="tgl_ekspose" class="form-control datepicker" value="<?php echo $tgl_ekspose;?>" required data-error="Tanggal Ekspose belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_ekspose"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tempat Pelaksanaan Ekspose</label>        
                            <div class="col-md-8">
                                <input type="text" name="di_tempat" id="di_tempat" class="form-control" value="<?php echo $model['di_tempat'];?>" required data-error="Tempat Pelaksanaan Ekspose belum diisi" maxlength="150" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa Penelaah</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Pidsus-6 Umum</label>        
                            <div class="col-md-8">
                                <select name="no_pidsus6_umum" id="no_pidsus6_umum" class="select2" style="width:100%" required data-error="No Pidsus-6 Umum belum dipilih">
                                    <option></option>
                                    <?php
                                        $sqlOpt1 = "select a.no_pidsus6_umum from pidsus.pds_pidsus6_umum a where ".$whereDefault;
                                        $resOpt1 = PdsPidsus7Umum::findBySql($sqlOpt1)->asArray()->all();
                                        foreach($resOpt1 as $datOpt1){
                                            $selected = ($datOpt1['no_pidsus6_umum'] == $model['no_pidsus6_umum'])?'selected':'';
                                            echo '<option value="'.$datOpt1['no_pidsus6_umum'].'" '.$selected.'>'.$datOpt1['no_pidsus6_umum'].'</option>';
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
                            <label class="control-label col-md-4">Nama</label>        
                            <div class="col-md-8">
                                <select name="nama_jaksa_penelaah" id="nama_jaksa_penelaah" class="select2" style="width:100%" required data-error="Nama Jaksa belum dipilih">
                                    <option></option>
                                    <?php
                                        if(!$isNewRecord){
											$sqlOpt2 = "select a.nip_jaksa as idnya, a.nama_jaksa as namanya, a.gol_jaksa||'#'||a.pangkat_jaksa||'#'||a.jabatan_jaksa as pangkatnya 
														from pidsus.pds_pidsus6_umum_penelaah a where ".$whereDefault." and a.no_pidsus6_umum = '".$model['no_pidsus6_umum']."'";
											$resOpt2 = PdsPidsus7Umum::findBySql($sqlOpt2)->asArray()->all();
											foreach($resOpt2 as $datOpt2){
												$dataIdny = $datOpt2['idnya'];
												$selected = ($dataIdny == $model['nip_jaksa'])?'selected':'';
												echo '<option value="'.$dataIdny.'" data-pangkat="'.$datOpt2['pangkatnya'].'" '.$selected.'>'.$datOpt2['namanya'].'</option>';
											}
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
                            <label class="control-label col-md-4">NIP</label>        
                            <div class="col-md-8">
                                <input type="text" name="nip_jaksa" id="nip_jaksa" class="form-control" value="<?php echo $model['nip_jaksa'];?>" readonly  /> 
                                <input type="hidden" name="nama_jaksa" id="nama_jaksa" value="<?php echo $model['nama_jaksa'];?>"  /> 
                                <input type="hidden" name="gol_jaksa" id="gol_jaksa" value="<?php echo $model['gol_jaksa'];?>"  /> 
                                <input type="hidden" name="pangkat_jaksa" id="pangkat_jaksa" value="<?php echo $model['pangkat_jaksa'];?>"  /> 
                                <input type="hidden" name="jabatan_jaksa" id="jabatan_jaksa" value="<?php echo $model['jabatan_jaksa'];?>"  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pangkat</label>        
                            <div class="col-md-8">
                                <input type="text" name="pangkat_jaksa_penelaah" id="pangkat_jaksa_penelaah" class="form-control" value="<?php echo (!$isNewRecord)?$model['pangkat_jaksa']." (".$model['gol_jaksa'].")":"";?>" readonly  /> 
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
            <div class="box-header with-border">
                <h3 class="box-title">Posisi Kasus</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="posisi_kasus" id="posisi_kasus" class="form-control ckeditor" style="height:70px;"><?php echo $model['posisi_kasus'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="box-footer with-border" style="padding:0px 15px 10px; margin-top:-15px;">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <input type="file" name="file_upload_posisi_kasus" id="file_upload_posisi_kasus" class="form-inputfile" />                    
                        <label for="file_upload_posisi_kasus" class="label-inputfile">
                            <?php 
                                $pathFile 	= Yii::$app->params['pidsus_7umum'].$model['file_upload_posisi_kasus'];
                                $labelFile 	= 'Unggah';
                                if($model['file_upload_posisi_kasus'] && file_exists($pathFile)){
                                    $param1  	= chunk_split(base64_encode($pathFile));
                                    $param2  	= chunk_split(base64_encode($model['file_upload_posisi_kasus']));
                                    $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                    $extPt		= substr($model['file_upload_posisi_kasus'], strrpos($model['file_upload_posisi_kasus'],'.'));
                                    echo '<a href="'.$linkPt.'" title="'.$model['file_upload_posisi_kasus'].'" style="float:left; margin-right:10px;">
                                    <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                }
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                <input type="text" class="form-control" readonly />
                            </div>
                            <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
                            <div class="help-block with-errors" id="error_custom_file_upload_posisi_kasus"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>	
	</div>
</div>		

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pendapat Pemapar</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <label class="radio">
                            <input type="radio" name="pemapar_dilanjutkan" id="pemapar_dilanjutkan1" value="1" <?php echo ($model['pemapar_dilanjutkan'] == 1)?'checked':'';?> required data-error="Pilih Pendapat Pemapar"/> Dilanjutkan
                        </label>
                        <div class="dilanjutkan_pemapar"<?php echo($model['pemapar_dilanjutkan'] != 1)?' style="display:none;"':'';?> required>
                            <label class="checkbox" style="padding:0 0 5px;">
                                <input type="checkbox" name="sita_geledah_pemapar" id="sita_geledah_pemapar" value="1" <?php echo($model['sita_geledah_pemapar'] == 1)?'checked':'';?> required data-error="Pilih Pendapat Pemapar"/><span>Melakukan Penyitaan/Penggeledahan</span>
                            </label>
                            <label class="checkbox" style="padding:0 0 5px;">
                                <input type="checkbox" name="penetapan_tsk_pemapar" id="penetapan_tsk_pemapar" value="1" <?php echo($model['penetapan_tsk_pemapar'] == 1)?'checked':'';?> required data-error="Pilih Pendapat Pemapar belum diisi"/><span>Penetapan Tersangka</span>
                            </label>
                        </div>
                        <label class="radio">
                            <input type="radio" name="pemapar_dilanjutkan" id="pemapar_dilanjutkan2" value="0" <?php echo ($model['pemapar_dilanjutkan'] == 0 && $model['pemapar_dilanjutkan'] !='')?'checked':'';?> required data-error="Pilih Pendapat Pemapar belum diisi"/> Dihentikan
                        </label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="pendapat_pemapar" id="pendapat_pemapar" class="form-control ckeditor" style="height:70px;"><?php echo $model['pendapat_pemapar'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="box-footer with-border" style="padding:0px 15px 10px; margin-top:-15px;">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <input type="file" name="file_upload_pendapat_pemapar" id="file_upload_pendapat_pemapar" class="form-inputfile" />                    
                        <label for="file_upload_pendapat_pemapar" class="label-inputfile">
                            <?php 
                                $pathFile 	= Yii::$app->params['pidsus_7umum'].$model['file_upload_pendapat_pemapar'];
                                $labelFile 	= 'Unggah';
                                if($model['file_upload_pendapat_pemapar'] && file_exists($pathFile)){
                                    $param1  	= chunk_split(base64_encode($pathFile));
                                    $param2  	= chunk_split(base64_encode($model['file_upload_pendapat_pemapar']));
                                    $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                    $extPt		= substr($model['file_upload_pendapat_pemapar'], strrpos($model['file_upload_pendapat_pemapar'],'.'));
                                    echo '<a href="'.$linkPt.'" title="'.$model['file_upload_pendapat_pemapar'].'" style="float:left; margin-right:10px;">
                                    <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                }
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                <input type="text" class="form-control" readonly />
                            </div>
                            <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
                            <div class="help-block with-errors" id="error_custom_file_upload_pendapat_pemapar"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>	
	</div>
</div>		

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Pendapat Pimpinan/ Peserta ekspose</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <label class="radio">
                            <input type="radio" name="pimpinan_dilanjutkan" id="pimpinan_dilanjutkan1" value="1" <?php echo ($model['pimpinan_dilanjutkan'] == 1)?'checked':'';?> required data-error="Pilih Pendapat Pimpinan"/> Dilanjutkan
                        </label>
                        <div class="dilanjutkan_pimpinan"<?php echo($model['pimpinan_dilanjutkan'] != 1)?' style="display:none;"':'';?> required>
                            <label class="checkbox" style="padding:0 0 5px;">
                                <input type="checkbox" name="sita_geledah_pimpinan" id="sita_geledah_pimpinan" value="1" <?php echo($model['sita_geledah_pimpinan'] == 1)?'checked':'';?> required data-error="Pilih Pendapat Pimpinan"/><span>Melakukan Penyitaan/Penggeledahan</span>
                            </label>
                            <label class="checkbox" style="padding:0 0 5px;">
                                <input type="checkbox" name="penetapan_tsk_pimpinan" id="penetapan_tsk_pimpinan" value="1" <?php echo($model['penetapan_tsk_pimpinan'] == 1)?'checked':'';?> required data-error="Pilih Pendapat Pimpinan"/><span>Penetapan Tersangka</span>
                            </label>
                        </div>
                        <label class="radio">
                            <input type="radio" name="pimpinan_dilanjutkan" id="pimpinan_dilanjutkan2" value="0" <?php echo ($model['pimpinan_dilanjutkan'] == 0 && $model['pimpinan_dilanjutkan'] !='')?'checked':'';?> required data-error="Pilih Pendapat Pimpinan"/> Dihentikan
                        </label>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
                
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="pendapat_pimpinan" id="pendapat_pimpinan" class="form-control ckeditor" style="height:70px;"><?php echo $model['pendapat_pimpinan'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="box-footer with-border" style="padding:0px 15px 10px; margin-top:-15px;">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <input type="file" name="file_upload_pendapat_pimpinan" id="file_upload_pendapat_pimpinan" class="form-inputfile" />                    
                        <label for="file_upload_pendapat_pimpinan" class="label-inputfile">
                            <?php 
                                $pathFile 	= Yii::$app->params['pidsus_7umum'].$model['file_upload_pendapat_pimpinan'];
                                $labelFile 	= 'Unggah';
                                if($model['file_upload_pendapat_pimpinan'] && file_exists($pathFile)){
                                    $param1  	= chunk_split(base64_encode($pathFile));
                                    $param2  	= chunk_split(base64_encode($model['file_upload_pendapat_pimpinan']));
                                    $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                    $extPt		= substr($model['file_upload_pendapat_pimpinan'], strrpos($model['file_upload_pendapat_pimpinan'],'.'));
                                    echo '<a href="'.$linkPt.'" title="'.$model['file_upload_pendapat_pimpinan'].'" style="float:left; margin-right:10px;">
                                    <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                }
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                <input type="text" class="form-control" readonly />
                            </div>
                            <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
                            <div class="help-block with-errors" id="error_custom_file_upload_pendapat_pimpinan"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>	
	</div>
</div>		

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Kesimpulan</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="kesimpulan" id="kesimpulan" class="form-control ckeditor" style="height:70px;"><?php echo $model['kesimpulan'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="box-footer with-border" style="padding:0px 15px 10px; margin-top:-15px;">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <input type="file" name="file_kesimpulan" id="file_kesimpulan" class="form-inputfile" />                    
                        <label for="file_kesimpulan" class="label-inputfile">
                            <?php 
                                $pathFile 	= Yii::$app->params['pidsus_7umum'].$model['file_upload_kesimpulan'];
                                $labelFile 	= 'Unggah';
                                if($model['file_upload_kesimpulan'] && file_exists($pathFile)){
                                    $param1  	= chunk_split(base64_encode($pathFile));
                                    $param2  	= chunk_split(base64_encode($model['file_upload_kesimpulan']));
                                    $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                    $extPt		= substr($model['file_upload_kesimpulan'], strrpos($model['file_upload_kesimpulan'],'.'));
                                    echo '<a href="'.$linkPt.'" title="'.$model['file_upload_kesimpulan'].'" style="float:left; margin-right:10px;">
                                    <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                }
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                <input type="text" class="form-control" readonly />
                            </div>
                            <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
                            <div class="help-block with-errors" id="error_custom_file_kesimpulan"></div>
                        </label>
                    </div>
                </div>
            </div>
        </div>	
	</div>
</div>		

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Saran/ Pendapat Penelaah</h3>
            </div>
            <div class="box-body">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea name="saran" id="saran" class="form-control ckeditor" style="height:70px;"><?php echo $model['saran'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="box-footer with-border" style="padding:0px 15px 10px; margin-top:-15px;">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <input type="file" name="file_saran" id="file_saran" class="form-inputfile" />                    
                        <label for="file_saran" class="label-inputfile">
                            <?php 
                                $pathFile 	= Yii::$app->params['pidsus_7umum'].$model['file_saran'];
                                $labelFile 	= 'Unggah';
                                if($model['file_saran'] && file_exists($pathFile)){
                                    $param1  	= chunk_split(base64_encode($pathFile));
                                    $param2  	= chunk_split(base64_encode($model['file_saran']));
                                    $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                    $extPt		= substr($model['file_saran'], strrpos($model['file_saran'],'.'));
                                    echo '<a href="'.$linkPt.'" title="'.$model['file_saran'].'" style="float:left; margin-right:10px;">
                                    <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                }
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                <input type="text" class="form-control" readonly />
                            </div>
                            <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
                            <div class="help-block with-errors" id="error_custom_file_saran"></div>
                        </label>
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
                        $pathFile 	= Yii::$app->params['pidsus_7umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-7 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah Pidsus-7 Umum';
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
					<h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
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
    <input type="hidden" name="no_pidsus7_umum" id="no_pidsus7_umum" value="<?php echo $model['no_pidsus7_umum']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
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

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa Penelaah</h4>
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
        .iradio-pidsus{
		position: absolute !important;
		left: 0px;
		top: 3px;
	}
	.form-horizontal label.radio,
	.form-horizontal label.checkbox{
		cursor: pointer;
	}
	.form-horizontal label.radio{
		padding:0 0 5px 25px;
	}
	.dilanjutkan_pemapar, .dilanjutkan_pimpinan{
		padding-left: 25px;
	}
	.dilanjutkan_pemapar span, .dilanjutkan_pimpinan span{
		margin-left: 7px;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink iradio-pidsus'});
    
    $("input[name='pemapar_dilanjutkan']").on('ifChecked',function(){
        var nilai = $(this).val();
        if(nilai == '1'){
            $(".dilanjutkan_pemapar").slideDown();
        }else{
            $(".dilanjutkan_pemapar").slideUp();
            $("input[name='sita_geledah_pemapar'], input[name='penetapan_tsk_pemapar']").iCheck("uncheck");
        }
    });
    
    $("input[name='pimpinan_dilanjutkan']").on('ifChecked',function(){
        var nilai = $(this).val();
        if(nilai == '1'){
            $(".dilanjutkan_pimpinan").slideDown();
        }else{
            $(".dilanjutkan_pimpinan").slideUp();
            $("input[name='sita_geledah_pimpinan'], input[name='penetapan_tsk_pimpinan']").iCheck("uncheck");
        }
    });
    
	$("select#no_pidsus6_umum").change(function(){
		$kdprov = $("select#no_pidsus6_umum").val();
		$("#nama_jaksa_penelaah, #pangkat_jaksa_penelaah, nip_jaksa, nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa").val("");
		$("select#nama_jaksa_penelaah option").remove();
		$.ajax({
			type	: "POST",
			url		: '<?php echo Yii::$app->request->baseUrl.'/pidsus/pds-pidsus-7-umum/getjaksapenelaah'; ?>',
			data	: { q1 : $kdprov },
			cache	: false,
			dataType: 'json',
			success : function(data){ 
				if(data.items != ""){
					$("select#nama_jaksa_penelaah").append(data.items).trigger('change');
					return false;
				}
			}
		});
	});
	$("select#nama_jaksa_penelaah").on("change", function(){
		var nilai 	= $(this).val();
			console.log(nilai);
		if(nilai != ""){
			var pangkat = $("#nama_jaksa_penelaah option:selected").data("pangkat");
			var param 	= pangkat.toString().split("#");
			var nama 	= $(this).select2('data');
			$("#nip_jaksa").val(nilai);
			$("#nama_jaksa").val(nama[0].text);
			$("#gol_jaksa").val(param[0]);
			$("#pangkat_jaksa").val(param[1]);
			$("#jabatan_jaksa").val(param[2]);
			$("#pangkat_jaksa_penelaah").val(param[0]+' ('+param[1]+')');
		} else{
			$("#nip_jaksa, #nama_jaksa, gol_jaksa, pangkat_jaksa, jabatan_jaksa, #pangkat_jaksa_penelaah").val("");
		}
	});

        
});
</script>