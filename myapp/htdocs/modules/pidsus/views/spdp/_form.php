<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
	use app\modules\datun\models\searchs\Instansi as pilih;
	$waktu = explode("-", $model['tgl_kejadian_perkara']);
?>

<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/spdp/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">SPDP</h3>
    </div>
    <div class="box-body">
        <div id="error_custom_head"></div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Instansi Penyidik</label>        
                    <div class="col-md-8">
                        <select id="instansi_pdk" name="instansi_pdk" class="select2" style="width:100%;" required data-error="Instansi Penyidik belum dipilih">
                            <option></option>
                            <?php 
                                $jns = pilih::findBySql("select * from pidsus.ms_inst_penyidik order by kode_ip")->asArray()->all();
                                foreach($jns as $ji){
                                    $selected = ($ji['kode_ip'] == $model['id_asalsurat'])?'selected':'';
                                    echo '<option value="'.$ji['kode_ip'].'" '.$selected.'>'.$ji['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Instansi Pelaksana Penyidikan</label>        
                        <div class="col-md-8">
                            <select id="instansi_plk_pydk" name="instansi_plk_pydk" class="select2" style="width:100%;" required data-error="Instansi Pelaksana Penyidik belum dipilih">
                            <option></option>
                            <?php 
                                if(!$isNewRecord){
                                    $jns = pilih::findBySql("select * from pidsus.ms_inst_pelak_penyidikan order by kode_ipp")->asArray()->all();
                                    foreach($jns as $ji){
                                            $selected = ($ji['kode_ipp'] == $model['id_penyidik'])?'selected':'';
                                            echo '<option value="'.$ji['kode_ipp'].'" '.$selected.'>'.$ji['nama'].'</option>';
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
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Sprindik</label>
                    <div class="col-md-8">
                        <input type="text" name="no_sprindik" id="no_sprindik" placeholder="Nomor Sprindik" class="form-control" value="<?php echo $model['no_sprindik'];?>" required data-error="No Sprindik belum diisi" maxlength="70" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Sprindik</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_sprindik" id="tgl_sprindik" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_sprindik'];?>" required data-error="Tanggal Sprindik belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_sprindik"></div></div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor SPDP</label>
                    <div class="col-md-8">
                        <input type="text" name="no_spdp" id="no_spdp" placeholder="Nomor SPDP" class="form-control" value="<?php echo $model['no_spdp'];?>" <?php echo ($model['statusnya']!='SPDP' && !$isNewRecord)?'readonly':'';?> required data-error="No SPDP belum diisi" maxlength="50" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal SPDP</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_spdp" id="tgl_spdp" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_spdp'];?>" <?php echo ($model['statusnya']!='SPDP' && !$isNewRecord)?'readonly':'';?> required data-error="Tanggal SPDP belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_spdp"></div></div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Diterima Wilayah Kerja</label>
                    <div class="col-md-8">
                        <input type="text" id="wil_kerja" name="wil_kerja" class="form-control" value="<?php echo Yii::$app->inspektur->getNamaSatker();?>" readonly />
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
                            <input type="text" name="tgl_terima" id="tgl_terima" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $model['tgl_terima'];?>" required data-error="Tanggal Diterima belum diisi" />
                        </div>
                    </div>
                    <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_terima"></div></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Waktu Kejadian Perkara</label>
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12">
                            	<div class="form-group form-group-sm" style="margin:0px 0px 15px;">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="border:none; padding-left:0px; font-size:12px; width:55px; text-align:left;">Jam</div>
                                        <select name="waktu_kejadian[0]" id="waktu_kejadian0" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
												for($i=0; $i<=23; $i++){
													$sel0 = ($waktu[0] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
													echo '<option '.$sel0.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
												}
												
											?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;">:</div>
                                        <select name="waktu_kejadian[1]" id="waktu_kejadian1" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
												for($i=0; $i<=59; $i++){
													$sel1 = ($waktu[1] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
													echo '<option '.$sel1.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
												}
												
											?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;"></div>
                                        <select name="waktu_kejadian[5]" id="waktu_kejadian5" class="form-control" style="height:30px; border:1px solid #f29db2; width:70px;">
                                            <option></option>
                                            <option value="WIB" <?= ($waktu[5]=='WIB')?'selected':'' ?> >WIB</option>
                                            <option value="WITA" <?= ($waktu[5]=='WITA')?'selected':'' ?> >WITA</option>
                                            <option value="WIT" <?= ($waktu[5]=='WIT')?'selected':'' ?> >WIT</option>
                                        </select>
                                    </div>
								</div>
							</div>
						</div>

                        <div class="row">
                            <div class="col-md-12">
                            	<div class="form-group form-group-sm" style="margin:0px 0px 15px;">
                                    <div class="input-group">
                                        <div class="input-group-addon" style="border:none; padding-left:0px; font-size:12px; width:55px; text-align:left;">Tanggal</div>
                                        <select name="waktu_kejadian[2]" id="waktu_kejadian2" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
												for($i=1; $i<=31; $i++){
													$sel2 = ($waktu[2] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
													echo '<option '.$sel2.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
												}
												
											?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;">:</div>
                                        <select name="waktu_kejadian[3]" id="waktu_kejadian3" class="form-control" style="height:30px; border:1px solid #f29db2; width:60px;">
                                            <option></option>
                                            <?php 
												for($i=1; $i<=12; $i++){
													$sel3 = ($waktu[3] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
													echo '<option '.$sel3.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
												}
												
											?>
                                        </select>
                                        <div class="input-group-addon" style="border:none; float:left;">:</div>
                                        <select name="waktu_kejadian[4]" id="waktu_kejadian4" class="form-control" style="height:30px; border:1px solid #f29db2; width:70px;">
                                            <option></option>
                                            <?php 
												for($i=date("Y")-2; $i<=date("Y"); $i++){
													$sel4 = ($waktu[4] == $i)?'selected':'';
													echo '<option '.$sel4.'>'.$i.'</option>';
												}
												
											?>
                                        </select>
                                    </div>
								</div>
							</div>
						</div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Kejadian</label>
                    <div class="col-md-8">
                        <input type="text" name="tmp_kejadian" id="tmp_kejadian" class="form-control" value="<?php echo $model['tempat_kejadian'];?>" />
                        <div class="help-block with-errors"></div>
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
                                <th class="text-center" width="8%"></th>
                                <th class="text-center" width="35%">Nama</th>
                                <th class="text-center" width="27%">Tempat &amp; Tanggal Lahir</th>
<!--                                <th class="text-center" width="15%">Jenis Kelamin</th>
                                <th class="text-center" width="15%">Umur</th>-->
                            </tr>
                        </thead>
                        <tbody>
                        <?php
							if($model['no_spdp']){
								$prmx = Yii::$app->inspektur->tgl_db($model['tgl_spdp']);
								$sqlx = "select a.*, b.nama as kebangsaan from pidsus.pds_spdp_tersangka a left join ms_warganegara b on a.warganegara = b.id 
										 where id_kejati = '".$model['id_kejati']."' and id_kejari = '".$model['id_kejari']."' and 
										 id_cabjari = '".$model['id_cabjari']."' and no_spdp = '".$model['no_spdp']."' and tgl_spdp = '".$prmx."' 
										 order by no_urut";
								$resx = Pilih::findBySql($sqlx)->asArray()->all();
								$noms = 0;
								$ajkl = array(1=>"Laki-laki", "Perempuan");
								if(count($resx) > 0){
									foreach($resx as $datx){
										$noms++;
										$tgl_lahir = ($datx['tgl_lahir'])?date('d-m-Y',strtotime($datx['tgl_lahir'])):'';
										$hasilObject = $datx['no_urut']."|#|".$datx['nama']."|#|".$datx['tmpt_lahir']."|#|".$tgl_lahir."|#|".$datx['umur']."|#|".
													$datx['warganegara']."|#|".$datx['kebangsaan']."|#|".$datx['suku']."|#|".$datx['id_identitas']."|#|".
													$datx['no_identitas']."|#|".$datx['id_jkl']."|#|".$datx['id_agama']."|#|".$datx['alamat']."|#|".$datx['no_hp']."|#|".
													$datx['id_pendidikan']."|#|".$datx['pekerjaan'];

										echo '
										<tr data-id="'.$noms.'">
											<td class="text-center">
												<input type="checkbox" name="chk_del_tembusan[]" id="chk_del_tembusan'.$noms.'" class="hRow" value="'.$noms.'" />
											</td>
											<td>
												<input type="hidden" name="tersangka[]" value="'.$hasilObject.'"/>
												<a class="ubahTersangka" style="cursor:pointer" data-tersangka="'.$hasilObject.'">'.$datx['no_urut'].'. '.$datx['nama'].'</a>
											</td>
											<td class="text-left">'.$datx['tmpt_lahir'].', '.$tgl_lahir.'</td>
											<!--<td class="text-left">'.$ajkl[$datx['id_jkl']].'</td>
											<td class="text-left">'.($datx['umur']?$datx['umur'].' Tahun':'').'</td>-->
										</tr>';
									}
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

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Uraian Singkat Perkara</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea id="uraian" name="uraian" class="form-control" style="height:90px;" required data-error="Uraian Singkat Perkara belum diisi"><?php echo $model['ket_kasus'];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Undang-undang &amp; Pasal</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <textarea id="uu" name="uu" class="form-control" style="height:90px;" required data-error="Undang-undang &amp; Pasal belum diisi"><?php echo $model['undang_pasal'];?></textarea>
                        <div class="help-block with-errors"></div>
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
                        $pathFile 	= Yii::$app->params['spdp'].$model['file_upload_spdp'];
                        $labelFile 	= 'Unggah File SPDP';
                        if($model['file_upload_spdp'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File SPDP';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_spdp']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_spdp'], strrpos($model['file_upload_spdp'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_spdp'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
					<h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 2Mb]</h6>
                    <div class="help-block with-errors" id="error_custom_file_permohonan"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-top: 4px double #ccc; margin:0px -15px 15px;">
<div class="box-footer text-center"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-pidsus jarak-kanan" type="submit" id="simpan1" name="simpan1">
    <i class="fa fa-floppy-o jarak-kanan"></i><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <a href="/pidsus/spdp/index" class="btn btn-danger"><i class="fa fa-reply jarak-kanan"></i>Batal</a>
</div>
</form>

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

<!--FORM KEWARGANEGARAAN
<div class="modal fade" id="tambah_form_warga" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kewarganegaraan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>-->

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
	/* START TERSANGKA */
		$("#tersangka").on('click', function(){
			if($("#tgl_spdp").val()==""){
				bootbox.alert({
					message: "Silahkan isi tanggal Spdp terlebih dahulu",
					size: 'small',
					callback: function(){
						$("#tgl_spdp").focus();
					}
				}); 
			}else{
				$("#tambah_tersangka").find(".modal-body").html("");
				$("#tambah_tersangka").find(".modal-body").load("/pidsus/spdp/poptersangka",function(){
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
			}
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
				var umur 	= (hasil[4].value)?hasil[4].value+' Tahun':'';
				var tgln = "";
				var ajkl = "";
				if(hasil[3].value) 
					tgln = (hasil[3].value)?', '+hasil[3].value:'';
				if(hasil[10].value) 
					ajkl = (hasil[10].value == 1)?'Laki-laki':'Perempuan';
				
				if(hasil[16].value==1){
					$('#table_tersangka').append(
						'<tr data-id="'+newId+'">' +
							'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
							'<td>'+
								'<input type="hidden" name="tersangka[]" value="'+hasilObject+'"/>'+
								'<a class="ubahTersangka" style="cursor:pointer" data-tersangka="'+hasilObject+'">'+hasil[0].value+". "+hasil[1].value+'</a>'+
							'</td>'+
							'<td class="text-left">'+hasil[2].value+tgln+'</td>'+
							'<!--<td class="text-left">'+ajkl+'</td>'+
							'<td class="text-left">'+umur+'</td>-->'+
						'</tr>'
					);
				} else{
					$('#table_tersangka').find("tr[data-id='"+hasil[17].value+"']").html(
						'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
						'<td>'+
							'<input type="hidden" name="tersangka[]" value="'+hasilObject+'"/>'+
							'<a class="ubahTersangka" style="cursor:pointer" data-tersangka="'+hasilObject+'">'+hasil[0].value+". "+hasil[1].value+'</a>'+
						'</td>'+
						'<td class="text-left">'+hasil[2].value+tgln+'</td>'+
						'<!--<td class="text-left">'+ajkl+'</td>'+
						'<td class="text-left">'+umur+'</td>-->'
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
	
	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});

	$("#jam_kejadian").on('focus', function(){
		$(this).prev().trigger('click');
	});
	
	/* START DROPDOWN INSTANSI PENYIDIK */
	$("#instansi_pdk").change(function(){
		$("#instansi_plk_pydk").val("").trigger('change').select2('close');
		$("#instansi_plk_pydk option").remove();
		$.ajax({
				type	: "POST",
				url		: "/pidsus/spdp/getinstansiplkpydk",
				dataType    : 'json',
				data	: { q1 : $("#instansi_pdk").val() },
				cache	: false,
				success     : function(data){ 
							if(data.items != ""){
								$("#instansi_plk_pydk").select2({ 
									data 		: data.items, 
									placeholder     : "Pilih salah satu", 
									allowClear 	: true, 
								});
								return false;
							}
				}
		});
	});
	/* END DROPDOWN INSTANSI PENYIDIK */
	
	/* START MODAL KEWARGANEGARAAN */
	$("#tambah_tersangka").on('show.bs.modal', function(e){
			$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
			$("body").removeClass("loading");
	}).on('click', "#warganegara", function(){
			$("#tambah_form_warga").find(".modal-body").load("/pidsus/spdp/getwarnegara");
			$("#tambah_form_warga").modal({backdrop:"static"});
	});
	/*$("#tambah_tersangka").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	});*/
	/* END MODAL KEWARGANEGARAAN */
	
	$("#tgl_spdp").on("change", function(){
		var tgl = $(this).val();
		var tmp = tgl.split("-");
		$("#waktu_kejadian2").val(tmp[0]);
		$("#waktu_kejadian3").val(tmp[1]);
		$("#waktu_kejadian4").val(tmp[2]);
	});

});
</script>