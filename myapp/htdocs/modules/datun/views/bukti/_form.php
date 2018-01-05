<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\searchs\Menu as User;
	
	$xtanggal_s19a 		= ($model['tanggal_s19a'])?date("d-m-Y", strtotime($model['tanggal_s19a'])):"";
	$xtgl_pengadilan	= ($model['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($model['tanggal_panggilan_pengadilan'])):"";
	$xtgl_skk 			= ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):"";
	$xtgl_skks 			= ($model['tanggal_skks'])?date("d-m-Y", strtotime($model['tanggal_skks'])):"";
	$model['subsidair'] = ($model['subsidair'])?$model['subsidair']:'Apabila pengadilan berpendapat lain, mohon putusan yang seadil-adilnya (ex aequo et bono).';

	$helpernya 	= Yii::$app->inspektur;
	$tmp_pggt 	= explode("#", $model['penggugat']);
	$penggugat 	= (count($tmp_pggt) > 1)?$tmp_pggt[0].', Dkk':$tmp_pggt[0];
	$nreg 		= $model['no_register_perkara'];
	$nsur 		= $model['no_surat'];
	$lokel 		= Yii::$app->inspektur->getLokasiSatker()->lokasi;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/bukti/simpan" enctype="multipart/form-data">
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
            	<div class="box-body" style="padding:15px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group form-group-sm">
                                <label class="control-label col-md-4">Dikeluarkan</label>
                                <div class="col-md-8">
                                    <input type="text" name="dikeluarkan" id="dikeluarkan" class="form-control" value="<?php echo $lokel;?>" readonly />
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
                                        <input type="text" name="tgl_s19a" id="tgl_s19a" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo ($isNewRecord)?date('d-m-Y'):$xtanggal_s19a;?>" />
                                    </div>
                                </div>
                                <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_s19a"></div></div>
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
                                    <textarea name="isi" id="isi" class="form-control" style="height:90px;"><?php echo $kepadaY;?></textarea>
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
			<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
				<div class="box-header with-border" style="border-color: #c7c7c7;">
					<div class="col-md-12">
						<h3 class="box-title"> Bukti Tertulis</h3>
					</div>
				</div>
				<div class="box-header with-border" style="border-color: #c7c7c7;">
					<div class="row">
						<div class="col-sm-12">
							<a class="btn btn-danger btn-sm hapusTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
							<a class="btn btn-success btn-sm" id="tambah-tembusan" title="Tambah Tembusan"><i class="fa fa-plus jarak-kanan"></i>Tambah</a><br>
						</div>	
					</div>		
				</div>
				<div class="box-body" style="padding:15px;">
					<div class="table-responsive">
						<table id="table_tembusan" class="table table-bordered">
							<thead>
								<tr>
									<th width="5%" style="text-align: center;">&nbsp;</th>
									<th width="5%" style="text-align: center;">No</th>
									<th width="10%" style="text-align: center;">Kode Bukti</th>
									<th width="65%" style="text-align: center;">Jenis Bukti</th>
									<th width="15%" style="text-align: center;">Ketrangan</th>
								</tr>
							</thead>
							<tbody>
							<?php
								$noreg_skk 	= $model['no_register_skk'];
								$tgl_skk 	= $model['tanggal_skk'];
								if($nsur && $nreg && $noreg_skk && $tgl_skk){
								$sqlx  = "
								select b.* from datun.s19a a 
								join datun.bukti_tertulis b on a.no_surat=b.no_surat and a.no_register_perkara=b.no_register_perkara 
								where a.no_surat = '".$nsur."' and a.no_register_perkara = '".$nreg."'";
								$hasil = ($nsur && $nreg && $noreg_skk && $tgl_skk)?User::findBySql($sqlx)->asArray()->all():array();
								$nom = 1;
								foreach($hasil as $value):
							?>
								<tr data-id="<?= $nom;  ?>" data-cek="1">
									<td class="text-center">
										<input type='checkbox' name='chk_del_bukti[]' class='hRow' id='<?php echo 'chk_del_bukti'.$nom;?>' value="<?= $nom ?>">
                                   	</td>								
									<td class="text-center">
										<span data-row-count="<?php echo $nom;?>" class="frmid"><?php echo $nom;?></span>
									</td>
									<td><input type="text" name="no_tergugat[]" class="form-control input-sm" value="<?= $value['kode_bukti']; ?>" <?php echo ($isNewRecord)?'':'readonly="true"';?>></td>
									<td><input type="text" name="jenis_bukti[]" class="form-control input-sm" value="<?= $value['jenis_bukti']; ?>"></td>
									<td><input type="text" name="keterangan[]" class="form-control input-sm" value="<?= $value['keterangan']; ?>"></td>
								</tr>
								<tr data-id="<?= $nom;  ?>">
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td class="text-center" colspan="3">
										<div class="panel with-nav-tabs panel-default">
											<div class="panel-heading single-project-nav">
													<ul class="nav nav-tabs"> 
														<li class="active"><a href="#tab-penjelasan" data-toggle="tab">Penjelasan</a></li>   
													</ul>
											</div>
											<div class="panel-body">
												<div class="tab-content">
													<div class="tab-pane active" id="tab-penjelasan">
														<textarea name="penjelasan[]" id="penjelasan" class="ckeditor"><?php echo $value['penjelasan'];?></textarea>
													</div>							
												</div>
											</div>
										</div>
									</td>	
								</tr>
								
							<?php $nom++; endforeach; }?>
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
                    <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                    <label for="file_template" class="label-inputfile">
						<?php 
                            $pathFile 	= Yii::$app->params['s19a'].$model['file_s19a'];
                            $labelFile 	= 'Upload File S-19.A';
                            if($model['file_s19a'] && file_exists($pathFile)){
                                $labelFile 	= 'Ubah File';
                                $param1  	= chunk_split(base64_encode($pathFile));
                                $param2  	= chunk_split(base64_encode($model['file_s19a']));
                                $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                                $extPt		= substr($model['file_s19a'], strrpos($model['file_s19a'],'.'));
                                echo '<a href="'.$linkPt.'" title="'.$model['file_s19a'].'" style="float:left; margin-right:10px;">
                                <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                            }
                        ?>
                        <div class="input-group">
                            <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                            <input type="text" class="form-control" readonly />
                        </div>
                        <div class="help-block with-errors" id="error_custom_file_template"></div>
                    </label>
                </div>
            </div>
        </div>
    </div>

    <hr style="border-color:#c7c7c7;margin:10px 0;">
    <div class="box-footer text-center"> 
		<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
        <button class="btn btn-warning jarak-kanan" type="submit" id="simpan" name="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
        <a class="btn btn-warning jarak-kanan" href="<?php echo '/datun/bukti/cetak';?>" target="_blank">Cetak</a>
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

	/* START BUKTI TERTULIS */
	$('#tambah-tembusan').click(function(){
		var tabel	= $('#table_tembusan > tbody').find('tr[data-cek="1"]:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_tembusan').append(
		'<tr data-id="'+newId+'" data-cek="1" >'+
			'<td class="text-center"><input type="checkbox" name="chk_del_bukti[]" class="hRow" id="chk_del_bukti'+newId+'" value="'+newId+'"></td>'+
			'<td class="text-center"><span data-row-count="'+newId+'" class="frmid"></span></td>'+
			'<td><input type="text" name="no_tergugat[]" class="form-control input-sm" placeholder="Kode Bukti"/></td>'+
			'<td><input type="text" name="jenis_bukti[]" class="form-control input-sm" placeholder="Jenis Bukti"/></td>'+
			'<td><input type="text" name="keterangan[]" class="form-control input-sm" placeholder="Keterangan"/></td>'+
		'</tr>'+
		'<tr data-id="'+newId+'">'+
			'<td>&nbsp;</td>'+
			'<td>&nbsp;</td>'+
			'<td class="text-center" colspan="3">'+
				'<div class="panel with-nav-tabs panel-default">'+
					'<div class="panel-heading single-project-nav">'+
							'<ul class="nav nav-tabs">'+
								'<li class="active"><a href="#tab-penjelasan" data-toggle="tab">Penjelasan</a></li>' + 
							'</ul>'+
					'</div>'+
					'<div class="panel-body">'+
						'<div class="tab-content">'+
							'<div class="tab-pane active" id="tab-penjelasan">'+
								'<textarea name="penjelasan[]" id="penjelasan'+newId+'" class="ckeditor"></textarea>'+
							'</div>'+					
						'</div>'+
					'</div>'+
				'</div>'+
			'</td>'+
		'</tr>');
			
		$("#penjelasan"+newId).ckeditor();	
		$("#chk_del_bukti"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
		$('#table_tembusan').find(".frmid").each(function(i,v){$(v).html(i+1);});				
	});
	$(".hapusTembusan").click(function(){
		var tabel 	= $("#table_tembusan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		$('#table_tembusan').find(".frmid").each(function(i,v){$(this).html(i+1);});				
	});
	/* END BUKTI TERTULIS */
});		

</script>
