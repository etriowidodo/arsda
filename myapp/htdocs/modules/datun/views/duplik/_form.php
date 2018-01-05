<?php

	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\security\models\User;
	use mdm\admin\models\searchs\Menu as MenuSearch;

	$xtgl_skk 			= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):"";
	$xtgl_skks 			= ($model['tanggal_skks'])?date("d-m-Y", strtotime($model['tanggal_skks'])):"";
	$tanggal_s17 		= ($model['tanggal_s17'])?date("d-m-Y", strtotime($model['tanggal_s17'])):"";
	$tanggal_replik 	= ($model['tanggal_replik'])?date("d-m-Y", strtotime($model['tanggal_replik'])):"";
	$tgl_pengadilan 	= ($model['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($model['tanggal_panggilan_pengadilan'])):"";
	$model['subsidair'] = ($model['subsidair'])?$model['subsidair']:'Apabila pengadilan berpendapat lain, mohon putusan yang seadil-adilnya (ex aequo et bono).';

	$helpernya 	= Yii::$app->inspektur;
	$tmp_pggt 	= explode("#", $model['penggugat']);
	$penggugat 	= (count($tmp_pggt) > 1)?$tmp_pggt[0].', Dkk':$tmp_pggt[0];
?>
<form id="duplik-form" name="duplik-form" class="form-validasi form-horizontal" method="post" action="/datun/duplik/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
    <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
        <div class="box-body" style="padding:15px;">
            <div class="row">
				<div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">No. Perkara Perdata</label>
                        <div class="col-md-8">
                            <input type="hidden" id="no_surat" name="no_surat" value="<?php echo $model['no_surat'];?>" />
                            <input type="hidden" id="kode_jenis_instansi" name="kode_jenis_instansi" value="<?php echo $model['kode_jenis_instansi'];?>" />
                            <input type="hidden" id="kode_instansi" name="kode_instansi" value="<?php echo $model['kode_instansi'];?>" />
						    <input type="text" id="no_reg" name="no_reg" class="form-control" value="<?php echo $model['no_register_perkara'];?>" readonly />
					   </div>
                    </div>
                </div>
				<div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Asal Panggilan</label>
                        <div class="col-md-8">
						    <input type="hidden" id="kode_kabupaten" name="kode_kabupaten" value="<?php echo $model['kode_kabupaten'];?>" />
						    <input type="hidden" id="tgl_pengadilan" name="tgl_pengadilan" value="<?php echo $tgl_pengadilan;?>" />
                            <input type="text" id="nm_pengadilan" name="nm_pengadilan" class="form-control" value="<?php echo $model['nama_pengadilan'];?>" readonly />
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
										$selected = ($dOpt1['no_register_skk'] == $model['no_register_skk']?'selected':'');
										$frmtTgls = date("d-m-Y", strtotime($dOpt1['tanggal_skk']));
										$tampilan = ($model['kode_jenis_instansi'] == '01')?$dOpt1['no_register_skk'].' ('.$frmtTgls.')':$dOpt1['no_register_skk'];
										echo '<option value="'.$dOpt1['no_register_skk'].'" '.$selected.' data-tgl="'.$frmtTgls.'">'.$tampilan.'</option>';
									}
                                  ?>
							</select>
							<?php } else { ?>
							<input type="text" name="no_skk" id="no_skk" class="form-control" value="<?php echo $model['no_register_skk'];?>" readonly /> 
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
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo $xtgl_skk?>" readonly /> 
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
									$resOpt2 = User::findBySql($sqlOpt2)->asArray()->all();
									foreach($resOpt2 as $dOpt2){
										$selected = ($dOpt2['no_register_skks'] == $model['no_register_skks']?'selected':'');
										echo '<option '.$selected.' data-tgl="'.date("d-m-Y", strtotime($dOpt2['tanggal_skks'])).'">'.$dOpt2['no_register_skks'].'</option>';
									}
                                  ?>
							</select>
							<?php } else { ?>
							<input type="text" name="no_skks" id="no_skks" class="form-control" value="<?php echo $model['no_register_skks'];?>" readonly /> 
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
                                <input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo $xtgl_skks;?>" readonly /> 
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
                            <input type="text" class="form-control" id="tergugat" name="tergugat" value="<?php echo $model['deskripsi_inst_wilayah'];?>" readonly />
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
				<div class="col-md-offset-6 col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Kuasa Penggugat</label>
                        <div class="col-md-8">
						<?php 
							$sqlKpg = "
							select * from datun.s11_kuasa_penggugat 
							where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."' and tanggal_s11 = (
								select max(tanggal_s11) from datun.s11_kuasa_penggugat 
								where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'
							) order by no_urut_kuasa_penggugat";
							$resKpg = User::findBySql($sqlKpg)->asArray()->all();
							$isiKpg = (count($resKpg) > 1)?$resKpg[0]['kuasa_penggugat'].', Dkk':$resKpg[0]['kuasa_penggugat'];
							echo '<input type="text" name="kuasa_penggugat" id="kuasa_penggugat" class="form-control" value="'.$isiKpg.'" readonly />';
                        ?>	
                        </div>
                    </div>
                </div>				
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group form-group-sm">
                        <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" id="wilkerja" name="wilkerja" value="<?php echo $helpernya->getNamaSatker();?>" readonly/>
                        </div>
                    </div>
                </div>
			</div>

        </div>
	</div>

	<div class="row">
		<div class="col-md-6">
			<div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
				<div class="box-header with-border" style="border-color: #c7c7c7;">
					<h3 class="box-title">Replik Penggugat</h3>
				</div>	
				<div class="box-body" style="padding:15px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Tanggal</label>
                                <div class="col-md-4">
                                    <div class="input-group date">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" value="<?php echo ($isNewRecord)?date('d-m-Y'):$tanggal_replik;?>" id="tanggal_replik" name="tanggal_replik" class="form-control datepicker" placeholder="DD-MM-YYYY" />
                                    </div>
                                    <div class="help-block with-errors" id="error_custom2"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <div class="col-md-12">
                                    <input type="file" name="file_replik" id="file_replik" class="form-inputfile" />                    
                                    <label for="file_replik" class="label-inputfile">
                                        <?php 
                                            $pathFile 	= Yii::$app->params['s17'].$model['file_replik'];
                                            $labelFile 	= 'Upload File Replik';
                                            if($model['file_replik'] && file_exists($pathFile)){
                                                $labelFile 	= 'Upload File Replik';
                                                $param1  	= chunk_split(base64_encode($pathFile));
                                                $param2  	= chunk_split(base64_encode($model['file_replik']));
                                                $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                                $extPt		= substr($model['file_replik'], strrpos($model['file_replik'],'.'));
                                                echo '<a href="'.$linkPt.'" title="'.$model['file_replik'].'" style="float:left; margin-right:10px;">
                                                <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                            }
                                        ?>
                                        <div class="input-group">
                                            <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                            <input type="text" class="form-control" readonly />
                                        </div>
                                        <div class="help-block with-errors" id="error_custom4"></div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
		<div class="col-md-6">
			<div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
				<div class="box-header with-border" style="border-color: #c7c7c7;">
					<h3 class="box-title">Dupik Tergugat</h3>
				</div>	
				<div class="box-body" style="padding:15px;">
					<div class="row">
						<div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-3">Dikeluarkan di</label>
                                <div class="col-md-9">
                                    <input type="text" id="wil_ins" name="wil_ins" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly />
                                </div>
                            </div>
						</div>
					</div>
					
					<div class="row">
						<div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-3">Tanggal</label>
                                <div class="col-md-4" >					  					
                                    <div class="input-group date">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                        <input type="text" class="form-control datepicker"  id="tanggal_keluar" name="tanggal_keluar" value="<?php echo ($isNewRecord)?date('d-m-Y'):$tanggal_s17;?>" placeholder="DD-MM-YYYY" >
                                    </div>  								
                                    <div class="help-block with-errors" id="error_custom3"></div>
                                </div>	
                            </div>
						</div>
					</div>
					
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-3">Kepada Yth.</label>
                                <div class="col-md-9">
                                    <?php 
										$tmp1 	 = 'Majelis Hakim Dalam Perkara Perdata <br />'.'No. '.$model['no_register_perkara'].'<br />';
										$tmp1 	.= $model['nama_pengadilan'].'<br />'.$model['alamat_pengadilan'];
										$convert = str_replace("<br />", "\n", $tmp1);
										$kepadaY = ($isNewRecord)?$convert:$model['kepada_yth'];
									?>
                                    <textarea name="isi" id="isi" class="form-control" style="height:90px;"><?php echo $kepadaY;?></textarea>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
					</div>										

					<div class="row">
						<div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-3">Di</label>
                                <div class="col-md-9">
                                    <input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo $model['tempat'];?>" />
                                </div>
                            </div>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
	
    <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
			<h3 class="box-title">JAWABAN</h3>
		</div>
        <div class="box-body" style="padding:15px;">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                        <li class="active"><a href="#tab-eksepsi" data-toggle="tab">Dalam Eksepsi</a></li>
                        <li><a href="#tab-provisi" data-toggle="tab">Dalam Provisi</a></li>
                        <li><a href="#tab-pokokperkara" data-toggle="tab">Dalam Pokok Perkara</a></li>
                        <li><a href="#tab-rekonvensi" data-toggle="tab">Dalam Rekonvensi</a></li>			   
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-eksepsi">
                            <textarea name="jawaban_eksepsi" id="jawaban_eksepsi" class="ckeditor"><?php echo $model['eksepsi'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-provisi">
                            <textarea name="jawaban_provisi" id="jawaban_provisi" class="ckeditor"><?php echo $model['provisi'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-pokokperkara">
                            <textarea name="jawaban_pokokperkara" id="jawaban_pokokperkara" class="ckeditor"><?php echo $model['pokokperkara'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-rekonvensi">
                            <textarea name="jawaban_rekonvensi" id="jawaban_rekonvensi" class="ckeditor"><?php echo $model['rekonvensi'];?></textarea>
                        </div>   
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
			<h3 class="box-title">PRIMAIR</h3>
		</div>
        <div class="box-body" style="padding:15px;">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                        <li class="active"><a href="#tab-primeksepsi" data-toggle="tab">Dalam Eksepsi</a></li>
                        <li><a href="#tab-primprovisi" data-toggle="tab">Dalam Provisi</a></li>
                        <li><a href="#tab-primpokokperkara" data-toggle="tab">Dalam Pokok Perkara</a></li>
                        <li><a href="#tab-primrekonvensi" data-toggle="tab">Dalam Rekonvensi</a></li>
                        <li><a href="#tab-primkonvensi" data-toggle="tab">Dalam Konvensi dan Rekonvensi</a></li>					   
                    </ul>
                </div>
            
                <div class="panel-body">
                    <div class="tab-content"> 
                        <div class="tab-pane fade in active" id="tab-primeksepsi">
                            <textarea name="primair_primeksepsi" id="primair_primeksepsi" class="ckeditor"><?php echo $model['prim_eksepsi'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-primprovisi">
                            <textarea name="primair_primprovisi" id="primair_primprovisi" class="ckeditor"><?php echo $model['prim_provisi'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-primpokokperkara">
                            <textarea name="primair_primpokokperkara" id="primair_primpokokperkara" class="ckeditor"><?php echo $model['prim_pokokperkara'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-primrekonvensi">
                            <textarea name="primair_primrekonvensi" id="primair_primrekonvensi" class="ckeditor"><?php echo $model['prim_rekonvensi'];?></textarea>
                        </div>
                        <div class="tab-pane fade" id="tab-primkonvensi">
                            <textarea name="primair_primkonvensi" id="primair_primkonvensi" class="ckeditor"><?php echo $model['prim_konvensi_rekonvensi'];?></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
	
    <div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
        <div class="box-header with-border" style="border-color: #c7c7c7;">
			<h3 class="box-title">SUBSIDAIR</h3>
		</div>
        <div class="box-body" style="padding:15px;">
            <div class="panel with-nav-tabs panel-default">
                <div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                        <li class="active"><a href="#tab-subsidair" data-toggle="tab">Subsidair</a></li>				   
                    </ul>
                </div>
                <div class="panel-body">
                    <div class="tab-content">						 
                        <div class="tab-pane fade in active" id="tab-subsidair">
                            <textarea name="subsidair" id="subsidair" class="ckeditor"><?php echo $model['subsidair'];?></textarea>
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
                    <input type="file" name="file_s17" id="file_s17" class="form-inputfile" />                    
                    <label for="file_s17" class="label-inputfile">
                        <?php 
                            $pathFile 	= Yii::$app->params['s17'].$model['file_s17'];
                            $labelFile 	= 'Upload File S-17';
                            if($model['file_s17'] && file_exists($pathFile)){
                                $labelFile 	= 'Ubah File S-17';
                                $param1  	= chunk_split(base64_encode($pathFile));
                                $param2  	= chunk_split(base64_encode($model['file_s17']));
                                $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                $extPt		= substr($model['file_s17'], strrpos($model['file_s17'],'.'));
                                echo '<a href="'.$linkPt.'" title="'.$model['file_s17'].'" style="float:left; margin-right:10px;">
                                <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                            }
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                            <input type="text" class="form-control" readonly />
                        </div>
                        <div class="help-block with-errors" id="error_custom5"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <hr style="border-color:#c7c7c7;margin:10px 0;">
    <div class="box-footer text-center"> 
        <input type="hidden" id="isNewRecord" name="isNewRecord" value="<?php echo $isNewRecord;?>"/>
        <button class="btn btn-warning jarak-kanan" type="submit" id="csimpan" name="csimpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
        <a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo '/datun/duplik/cetak';?>">Cetak</a>
        <a href=<?php echo "/datun/skk/index";?> class="btn btn-danger">Batal</a>
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
	.label-inputfile .btn-infos{
		background-color: #3c8dbc;
		border-color: #3c8dbc;
		opacity: .60;
		cursor: no-drop;
	}
	.btn-warning[disabled]{
		cursor: no-drop;
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
});
</script>
