<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\searchs\Menu as User;
	
	$this->title 		= 'Perlawanan Tergugat (S-18)'; 
	$isNewRecord 		= ($model['tanggal_s18'] == ''?1:0);
	$xtanggal_s18 		= ($model['tanggal_s18'])?date("d-m-Y", strtotime($model['tanggal_s18'])):"";
	$xtgl_pengadilan	= ($model['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($model['tanggal_panggilan_pengadilan'])):"";
	$xtgl_skk 			= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):"";
	$xtgl_skks 			= ($model['tanggal_skks'])?date("d-m-Y", strtotime($model['tanggal_skks'])):"";
	$xtanggal_sita 		= ($model['tanggal_sita_jaminan'])?date("d-m-Y", strtotime($model['tanggal_sita_jaminan'])):"";
	$model['subsidair'] = ($model['subsidair'])?$model['subsidair']:'Apabila pengadilan berpendapat lain, mohon putusan yang seadil-adilnya (ex aequo et bono).';

	$helpernya 	= Yii::$app->inspektur;
	$tmp_pggt 	= explode("#", $model['penggugat']);
	$penggugat 	= (count($tmp_pggt) > 1)?$tmp_pggt[0].', Dkk':$tmp_pggt[0];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/s18/simpan" enctype="multipart/form-data">
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
						    <input type="hidden" id="tgl_pengadilan" name="tgl_pengadilan" value="<?php echo $xtgl_pengadilan;?>" />
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
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo $xtgl_skk;?>" readonly /> 
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
                            <input type="text" class="form-control" id="wilayah_terima" name="wilayah_terima" value="<?php echo $helpernya->getNamaSatker();?>" readonly/>
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
                    <h3 class="box-title"><b>Penetapan Sita Jaminan</b></h3>
                </div>
                <div class="box-body" style="padding:15px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Nomor</label>
                                <div class="col-md-8">
                                    <input type="text" name="nomor_sita_jaminan" id="nomor_sita_jaminan" value="<?php echo $model['nomor_sita_jaminan']; ?>" class="form-control" />
                                    <div class="help-block with-errors"></div>
                                </div> 								
                            </div>
                        </div>										
                    </div>
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Tanggal</label>
                                <div class="col-md-4">
                                    <div class="input-group date">
                                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>	
                                        <input type="text" name="tanggal_sita_jaminan" id="tanggal_sita_jaminan" class="form-control datepicker" value="<?php echo ($isNewRecord)?date('d-m-Y'):$xtanggal_sita;?>" placeholder="DD-MM-YYYY" />
                                    </div>
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
                                <label class="control-label col-md-4">Dikeluarkan</label>
                                <div class="col-md-8">
                                    <input type="text" name="dikeluarkan" id="dikeluarkan" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly />
                                </div> 
                            </div>
                        </div>
                    </div>										
                    
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Tanggal</label>
                                <div class="col-md-4">
                        			<div class="input-group date">
                        				<div class="input-group-addon"><i class="fa fa-calendar"></i></div>	
                        				<input type="text" id="tanggal_s18" name="tanggal_s18" class="form-control datepicker" value="<?php echo ($isNewRecord)?date('d-m-Y'):$xtanggal_s18;?>" placeholder="DD-MM-YYYY" />
                        				</div>	
                        			</div>
                                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="err_tgls18"></div></div>
                        		</div>
                    		</div>								
                		</div>										

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Kepada Yth.</label>
                                <div class="col-md-8">
                                    <?php 
										$tmp1 	 = 'Majelis Hakim Dalam Perkara Perdata <br />'.'No. '.$model['no_register_perkara'].'<br />';
										$tmp1 	.= $model['nama_pengadilan'].'<br />'.$model['alamat_pengadilan'];
										$convert = str_replace("<br />", "\n", $tmp1);
										$kepadaY = ($isNewRecord)?$convert:$model['kepada_yth'];
									?>
                                    <textarea name="untuk" id="untuk" class="form-control" style="height:90px;"><?php echo $kepadaY;?></textarea>
									<div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
					</div>										

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Di</label>
                                <div class="col-md-8">
                                    <input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo $model['tempat']; ?>" />
                                    <div class="help-block with-errors"></div>
								</div>
							</div>
						</div>
					</div>										
				
                </div>
			</div>
        </div>
	</div>										
	
				
	<div class="box box-primary" style="border-color: #f39c12;overflow: hidden;">
    	<div class="box-body" style="padding:15px;">
			<div class="panel with-nav-tabs panel-default">
				<div class="panel-heading single-project-nav">
                    <ul class="nav nav-tabs"> 
                        <li class="active"><a href="#tab-alasan" data-toggle="tab">ALASAN</a></li>
                        <li><a href="#tab-primair" data-toggle="tab">PRIMAIR</a></li>
                        <li><a href="#tab-subsidair" data-toggle="tab">SUBSIDAIR</a></li>												
                    </ul>
				</div>
                <div class="panel-body">
					<div class="tab-content">
                        <div class="tab-pane fade in active" id="tab-alasan">
                        	<textarea class="ckeditor" id='alasan' name='alasan' ><?php echo $model['alasan']; ?> </textarea>
                        </div>
						<div class="tab-pane fade" id="tab-primair">
                        	<textarea class="ckeditor" id='primair' name='primair' ><?php echo $model['primair']; ?></textarea>
						</div>  
						<div class="tab-pane fade" id="tab-subsidair">
                        	<textarea class="ckeditor" id='subsidair' name='subsidair' ><?php echo $model['subsidair']; ?></textarea>
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
                    <input type="file" name="file_s18" id="file_s18" class="form-inputfile" />                    
                    <label for="file_s18" class="label-inputfile">
                        <?php 
                            $pathFile 	= Yii::$app->params['s18'].$model['file_s18'];
                            $labelFile 	= 'Upload File S-18';
                            if($model['file_s18'] && file_exists($pathFile)){
                                $labelFile 	= 'Ubah File S-18';
                                $param1  	= chunk_split(base64_encode($pathFile));
                                $param2  	= chunk_split(base64_encode($model['file_s18']));
                                $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                $extPt		= substr($model['file_s18'], strrpos($model['file_s18'],'.'));
                                echo '<a href="'.$linkPt.'" title="'.$model['file_s18'].'" style="float:left; margin-right:10px;">
                                <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                            }
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                            <input type="text" class="form-control" readonly />
                        </div>
                        <div class="help-block with-errors" id="error_custom2"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>
																														
    <hr style="border-color:#c7c7c7;margin:10px 0;">
    <div class="box-footer text-center"> 
		<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
        <button class="btn btn-warning jarak-kanan" type="submit" id="csimpan" name="csimpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
        <a class="btn btn-warning jarak-kanan" href="<?php echo '/datun/s18/cetak';?>" target="_blank">Cetak</a>
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

	$("body").addClass('fixed sidebar-collapse');
	$(".sidebar-toggle").click(function(){
		 $("html, body").animate({scrollTop: 0}, 500);
	});	

	function tgl_auto($tgl){
		var a = $tgl.toString().split('-');
		return a[2]+'-'+a[1]+'-'+a[0];
	}


	$('#role-form').validator({disable:false}).on('submit', function(e){
		if(!e.isDefaultPrevented()){
			for(var instanceName in CKEDITOR.instances){
				CKEDITOR.instances[instanceName].updateElement();
			}	
			if($('#alasan').val() == '' || $('#primair').val() == '' || $('#subsidair').val() == '' ){
				bootbox.confirm({ 
					message: "Text Editor [ALASAN, PRIMAIR, SUBSIDAIR] masih ada yang kosong. Apakah anda masih ingin tetap menyimpan data?",
					size: "small",
					closeButton: false,
					buttons: {
						confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
						cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
					},
					callback: function(result){
						if(result){
							$(".bootbox-confirm").modal('hide');
							$(".bootbox-confirm").one('hidden.bs.modal', function(){
								$("body").addClass("modal-open");
							});
							cekUploadReplik();
							return false;
						}
					}
				});
				return false;
			} else{
				cekUploadReplik();
				return false;
			}
		}
	});

	function cekUploadReplik(){
		var filenya = $("#file_s18")[0].files[0];
		if(typeof(filenya) == 'undefined'){
			bootbox.confirm({ 
				message: "Anda belum mengunggah file S-18 (Perlawanan Tergugat). Apakah anda yakin ingin tetap menyimpan data?",
				size: "small",
				closeButton: false,
				buttons: {
					confirm: {label:'<div style="min-width:30px">Ya</div>', className:'btn-primary pull-right jarak-kanan'},
					cancel: {label:'<div style="min-width:30px">Tidak</div>', className:'btn-default pull-right'}
				},
				callback: function(result){
					if(result){
						$(".bootbox-confirm").modal('hide');
						validasi_upload();
						return false;
					}
				}
			});
			return false;
		} else{
			validasi_upload();
			return false;
		}
	}
			
	function validasi_upload(){
		var filenya = $("#file_s18")[0].files[0], fname = '', fsize = 0, extnya = '';
		var arrExt 	= [".doc", ".odt", ".docx", ".rtf", ".pdf" ];
		var hariIni = new Date('<?php echo date('Y-m-d') ?>');
		var tgl_s18 = ($('#tanggal_s18').val())?new Date(tgl_auto($('#tanggal_s18').val())):"";
		var tgl_png = new Date(tgl_auto($('#tgl_pengadilan').val()));		
		
		$(".with-errors").html('');
		if(typeof(filenya) != 'undefined'){	
			fsize 	= filenya.size, 
			fname 	= filenya.name, 
			extnya 	= fname.substr(fname.lastIndexOf(".")).toLowerCase();
		} 
		
		if(tgl_s18 && tgl_s18 < tgl_png){
			$("body").removeClass("loading");
			$("#err_tgls18").html('<i style="color:#dd4b39; font-size:12px;">* Tanggal S-18 lebih kecil tanggal panggilan pengadilan</i>');
			setErrorFocus($("#err_tgls18"), $("#role-form"), false);
			return false;
		} else if(tgl_s18 && tgl_s18 > hariIni){
			$("body").removeClass("loading");
			$("#err_tgls18").html('<i style="color:#dd4b39; font-size:12px;">* Maximal Tanggal S-18 adalah hari ini</i>');
			setErrorFocus($("#err_tgls18"), $("#role-form"), false);
			return false;
		} else if(fname && $.inArray(extnya, arrExt) == -1){
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* Tipe file hanya .odt,.doc,.docx,.pdf</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else if(fname && fsize > (2 * 1024 * 1024)){		
			$("body").removeClass("loading");
			$("#error_custom2").html('<i style="color:#dd4b39; font-size:12px;">* File Max 2MB</i>');
			setErrorFocus($("#error_custom2"), $("#role-form"), false);
			return false;
		} else{
			$('#role-form').validator('destroy').off("submit");
			$('#role-form').submit();
		}
	}	
});
</script>
