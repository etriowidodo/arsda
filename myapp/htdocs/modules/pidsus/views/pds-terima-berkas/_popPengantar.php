<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\PdsTerimaBerkas as pilih;
	$modelUun = (count($modelUun) == 0)?array(1=>array("")):$modelUun;
	$sqlCek1 = "select count(*) from pidsus.pds_terima_berkas_pengantar 
				where id_kejati = '".$_SESSION['kode_kejati']."' and id_kejari = '".$_SESSION['kode_kejari']."' and id_cabjari = '".$_SESSION['kode_cabjari']."' 
				and no_spdp = '".$_SESSION['no_spdp']."' and tgl_spdp = '".$_SESSION['tgl_spdp']."' and no_berkas = '".$modelPnt['no_berkas_pengantar']."' 
				and no_pengantar = '".$modelPnt['no_pengantar']."'";
	$count1 = pilih::findBySql($sqlCek1)->asArray()->scalar();
	$readonly = ($count1 > 0)?'readonly':'';
?>
<div id="wrapper-modal-pengantar">
    <form class="form-horizontal" id="frm-pengantar">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Instansi Penyidik</label>        
                            <div class="col-md-8">
                                <input type="text" name="inst_penyidik_pengantar" id="inst_penyidik_pengantar" class="form-control" value="<?php echo $modelPnt['inst_penyidik_pengantar'];?>" readonly />    
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Instansi Pelaksana Penyidikan</label>        
                                <div class="col-md-8">
                                    <input type="text" name="inst_pelaksana_pengantar" id="inst_pelaksana_pengantar" class="form-control" value="<?php echo $modelPnt['inst_pelaksana_pengantar'];?>" readonly />    
                                    <div class="help-block with-errors"></div>
                                </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No Berkas</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_berkas_pengantar" id="no_berkas_pengantar" value="<?php echo $modelPnt['no_berkas_pengantar'];?>" readonly class="form-control" />    
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Berkas</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_berkas_pengantar" id="tgl_berkas_pengantar" value="<?php echo $modelPnt['tgl_berkas_pengantar'];?>" readonly class="form-control" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No Pengantar</label>        
                            <div class="col-md-8">
                                <input type="text" name="modal1_no_pengantar" id="modal1_no_pengantar" class="form-control" value="<?php echo $modelPnt['no_pengantar'];?>" required data-error="No Pengantar belum diisi" <?php echo $readonly;?> />    
                                <div class="help-block with-errors" id="error_custom_no_pengantar"></div>
                            </div>
                        </div>
                    </div>        
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pengantar</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="modal1_tgl_pengantar" id="modal1_tgl_pengantar" class="form-control datepicker" value="<?php echo $modelPnt['tgl_pengantar'];?>" required data-error="Tanggal Pengantar belum diisi" placeholder="DD-MM-YYYY" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_modal1_tgl_pengantar"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-6 col-md-offset-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Diterima</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="modal1_tgl_terima" id="modal1_tgl_terima" class="form-control datepicker" value="<?php echo $modelPnt['tgl_terima'];?>" required data-error="Tanggal terima belum diisi" placeholder="DD-MM-YYYY" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_modal1_tgl_terima"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box box-primary">
            <div class="box-body">
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
                                                <select name="modal1_waktu_kejadian[0]" id="modal1_waktu_kejadian0" class="form-control selectSimple" style="width:60px;">
                                                    <option></option>
                                                    <?php 
														for($i=0; $i<=23; $i++){
																$sel0 = ($modelPnt['waktu_kejadian'][0] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
																echo '<option '.$sel0.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
														}
													?>
                                                </select>
                                                <div class="input-group-addon" style="border:none; float:left;">:</div>
                                                <select name="modal1_waktu_kejadian[1]" id="modal1_waktu_kejadian1" class="form-control selectSimple" style="width:60px;">
                                                    <option></option>
                                                    <?php 
														for($i=0; $i<=59; $i++){
																$sel1 = ($modelPnt['waktu_kejadian'][1] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
																echo '<option '.$sel1.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
														}
													?>
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
                                                <select name="modal1_waktu_kejadian[2]" id="modal1_waktu_kejadian2" class="form-control selectSimple" style="width:60px;">
                                                    <option></option>
                                                    <?php 
														for($i=1; $i<=31; $i++){
																$sel2 = ($modelPnt['waktu_kejadian'][2] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
																echo '<option '.$sel2.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
														}
													?>
                                                </select>
                                                <div class="input-group-addon" style="border:none; float:left;">:</div>
                                                <select name="modal1_waktu_kejadian[3]" id="modal1_waktu_kejadian3" class="form-control selectSimple" style="width:60px;">
                                                    <option></option>
													<?php 
														for($i=1; $i<=12; $i++){
															$sel3 = ($modelPnt['waktu_kejadian'][3] == str_pad($i,2,'0',STR_PAD_LEFT))?'selected':'';
															echo '<option '.$sel3.'>'.str_pad($i,2,'0',STR_PAD_LEFT).'</option>';
														}
                                                    ?>
                                                </select>
                                                <div class="input-group-addon" style="border:none; float:left;">:</div>
                                                <select name="modal1_waktu_kejadian[4]" id="modal1_waktu_kejadian4" class="form-control selectSimple" style="width:70px;">
                                                    <option></option>
													<?php 
														for($i=date("Y")-2; $i<=date("Y"); $i++){
															$sel4 = ($modelPnt['waktu_kejadian'][4] == $i)?'selected':'';
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
                                <input type="text" name="modal1_tmp_kejadian" id="modal1_tmp_kejadian" class="form-control" value="<?php echo $modelPnt['tmp_kejadian'];?>" required data-error="Tempat Kejadian belum diisi" />
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
                    <div class="box-header with-border" style="border-color: #c7c7c7;">
                        <div class="row">
                            <div class="col-sm-12">
                                <a class="btn btn-danger btn-sm hapusTersangka jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                                <a class="btn btn-success btn-sm" id="tersangka" title="Tambah Tersangka"><i class="fa fa-plus jarak-kanan"></i>Tersangka</a><br>
                            </div>	
                        </div>		
                    </div>
                    <div class="box-body" style="padding:15px;">
                        <div style="margin-bottom:5px;" class="help-block with-errors" id="error_custom_tersangka"></div>
                        <div class="table-responsive">
                            <table id="table_tersangka" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%" class="text-center"></th>
                                        <th width="50%">Nama</th>
                                        <th width="35%">Tempat dan Tanggal Lahir</th>
                                        <th width="10%">Umur</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if(count($modelTsk) > 0){
										foreach($modelTsk as $idx1=>$rowTsk){
											$hd1 = 'type="hidden" class="tskBrks nomnya"';
											$hd2 = 'type="hidden" class="tskBrks"';
											echo '
											<tr data-id="'.$idx1.'">
												<td class="text-center">
													<input type="checkbox" name="modal1_chk_del_tsk['.$idx1.']" id="modal1_chk_del_tsk'.$idx1.'" class="hRow" value="'.$idx1.'" />
												</td>
												<td>
													<input '.$hd1.' name="modal1_no_urut['.$idx1.']" id="modal1_no_urut'.$idx1.'" value="'.$rowTsk['no_urut'].'" />
													<input '.$hd2.' name="modal1_nama['.$idx1.']" id="modal1_nama'.$idx1.'" value="'.$rowTsk['nama'].'" />
													<input '.$hd2.' name="modal1_tmpt_lahir['.$idx1.']" id="modal1_tmpt_lahir'.$idx1.'" value="'.$rowTsk['tmpt_lahir'].'" />
													<input '.$hd2.' name="modal1_tgl_lahir['.$idx1.']" id="modal1_tgl_lahir'.$idx1.'" value="'.$rowTsk['tgl_lahir'].'" />
													<input '.$hd2.' name="modal1_umur['.$idx1.']" id="modal1_umur'.$idx1.'" value="'.$rowTsk['umur'].'" />
													<input '.$hd2.' name="modal1_warganegara['.$idx1.']" id="modal1_warganegara'.$idx1.'" value="'.$rowTsk['warganegara'].'" />
													<input '.$hd2.' name="modal1_kebangsaan['.$idx1.']" id="modal1_kebangsaan'.$idx1.'" value="'.$rowTsk['kebangsaan'].'" />
													<input '.$hd2.' name="modal1_suku['.$idx1.']" id="modal1_suku'.$idx1.'" value="'.$rowTsk['suku'].'" />
													<input '.$hd2.' name="modal1_id_identitas['.$idx1.']" id="modal1_id_identitas'.$idx1.'" value="'.$rowTsk['id_identitas'].'" />
													<input '.$hd2.' name="modal1_no_identitas['.$idx1.']" id="modal1_no_identitas'.$idx1.'" value="'.$rowTsk['no_identitas'].'" />
													<input '.$hd2.' name="modal1_id_jkl['.$idx1.']" id="modal1_id_jkl'.$idx1.'" value="'.$rowTsk['id_jkl'].'" />
													<input '.$hd2.' name="modal1_id_agama['.$idx1.']" id="modal1_id_agama'.$idx1.'" value="'.$rowTsk['id_agama'].'" />
													<input '.$hd2.' name="modal1_alamat['.$idx1.']" id="modal1_alamat'.$idx1.'" value="'.$rowTsk['alamat'].'" />
													<input '.$hd2.' name="modal1_no_hp['.$idx1.']" id="modal1_no_hp'.$idx1.'" value="'.$rowTsk['no_hp'].'" />
													<input '.$hd2.'name="modal1_id_pendidikan['.$idx1.']" id="modal1_id_pendidikan'.$idx1.'" value="'.$rowTsk['id_pendidikan'].'" />
													<input '.$hd2.' name="modal1_pekerjaan['.$idx1.']" id="modal1_pekerjaan'.$idx1.'" value="'.$rowTsk['pekerjaan'].'" />
													<a class="ubahTersangka" style="cursor:pointer">'.$rowTsk['no_urut'].'. '.$rowTsk['nama'].'</a>
												</td>
												<td>'.$rowTsk['tmpt_lahir'].', '.$rowTsk['tgl_lahir'].'</td>
												<td>'.$rowTsk['umur'].' Tahun</td>
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
        
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Undang-undang &amp; Pasal</h3>
            </div>
            <div class="box-body">
            	<div id="table_uu">
				<?php 
				foreach($modelUun as $idx1=>$rowUun){
					$cls1 		= 'class="form-control txtUndangPasal"';
					$undang_uu 	= $rowUun['undang_uu'];
					echo '
					<div style="padding:10px; margin-bottom:15px; border:1px solid #f29db2;" class="tr" data-id="'.$idx1.'">
						'.($idx1 > 1?'<button class="btn btn-danger btn-sm hapus-dakwaan pull-right" data-id="'.$idx1.'">Hapus</button>':'').'
						<div class="row">        
							<div class="col-md-10">
								<div class="form-group form-group-sm">
									<label class="control-label col-md-2">Undang-undang</label>
									<div class="col-md-8">
										<div class="input-group input-group-sm">
											<input type="hidden" name="modal1_undang_id['.$idx1.']" id="modal1_undang_id'.$idx1.'" value="'.$rowUun['undang_id'].'" />
											<input type="text" name="modal1_undang_uu['.$idx1.']" id="modal1_undang_uu'.$idx1.'" '.$cls1.' value="'.$undang_uu.'" readonly />
											<span class="input-group-btn"><button type="button" class="btn undang" data-id="'.$idx1.'">Pilih</button></span>
										</div>
										<div class="help-block with-errors" id="error_custom_modal1_undang_uu'.$idx1.'"></div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">        
							<div class="col-md-10">
								<div class="form-group form-group-sm">
									<label class="control-label col-md-2">Pasal</label>
									<div class="col-md-8">
										<div class="input-group input-group-sm">
											<input type="hidden" name="modal1_id_pasal['.$idx1.']" id="modal1_id_pasal'.$idx1.'" value="'.$rowUun['id_pasal'].'"/>
											<input type="text" name="modal1_pasal['.$idx1.']" id="modal1_pasal'.$idx1.'" '.$cls1.' value="'.$rowUun['pasal'].'" readonly />
											<span class="input-group-btn"><button type="button" class="btn pasal" data-id="'.$idx1.'">Pilih</button></span>
										</div>
										<div class="help-block with-errors" id="error_custom_modal1_pasal'.$idx1.'"></div>
									</div>
								</div>
							</div> 
						</div>
						<div class="row">        
							<div class="col-md-10">
								<div class="form-group form-group-sm">
									<label class="control-label col-md-2">Dakwaan</label>
									<div class="col-md-4">
										<select name="modal1_dakwaan['.$idx1.']" id="modal1_dakwaan'.$idx1.'" class="select2 dakwaan" data-id="'.$idx1.'" style="width:100%;">
											<option value=""></option>
											<option value="1"'.($rowUun['dakwaan'] == 1?' selected':'').'>-- Juncto --</option>
											<option value="2"'.($rowUun['dakwaan'] == 2?' selected':'').'>-- Dan --</option>
											<option value="3"'.($rowUun['dakwaan'] == 3?' selected':'').'>-- Atau --</option>
											<option value="4"'.($rowUun['dakwaan'] == 4?' selected':'').'>-- Subsider --</option>
										</select>
									</div>
								</div>
							</div> 
						</div>
					</div>';
				} ?>
                </div>
            </div>
        </div>
        
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="evt_pengantar_sukses" id="evt_pengantar_sukses"  />
            <input type="hidden" name="nurec_pengantar" id="nurec_pengantar" value="" />
            <input type="hidden" name="tr_id_pengantar" id="tr_id_pengantar" value="" />
            <button type="submit" id="simpan_form_pengantar" class="btn btn-warning btn-sm jarak-kanan"></button>
            <a data-dismiss="modal" class="btn btn-danger btn-sm"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
        </div>
    </form>
    <div class="modal-loading-new"></div>
</div>

<!--TERSANGKA-->
<div class="modal fade" id="tambah_tersangka" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close clsM2Tsk" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Tersangka</h4>
                
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--UNDANG-UNDANG-->
<div class="modal fade" id="pilih_undang" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM1UU" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Undang Undang</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<!--PASAL-->
<div class="modal fade" id="form_pasal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeM1Psl" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pasal</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<style>
	#wrapper-modal-pengantar.loading {overflow: hidden;}
	#wrapper-modal-pengantar.loading .modal-loading-new {display: block;}

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
	.selectSimple{
		height: 30px;
		border: 1px solid #f29db2;	
	}
</style>

<script type="text/javascript">
$(function(){
    var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';
    $(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
    $("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'});
	$("input[type='checkbox']:not(.simple)").iCheck({checkboxClass: 'icheckbox_square-pink'}); 
    $(".datepicker").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    });
    
	/* START TERSANGKA */
	$("#tersangka").on("click", function(){
		var tabel	= $('#table_tersangka > tbody').find('tr:last');
		var defNo 	= (tabel.length > 0)?parseInt(tabel.find("input.nomnya").val())+1:1;
		$("#tambah_tersangka").find(".modal-body").html("");
		$("#tambah_tersangka").find(".modal-body").load("/pidsus/pds-terima-berkas/poptersangka", function(){
			$("#modal2_no_urut").val(defNo);
			$("#newrec_form_tersangka").val('1');
			$("#simpan_form_tersangka").html('<i class="fa fa-floppy-o jarak-kanan"></i>Simpan');
		});
		$("#tambah_tersangka").modal({backdrop:"static", keyboard:false});
	});
	$("#tambah_tersangka").on('show.bs.modal', function(e){
		$("#wrapper-modal-pengantar").addClass("loading");
	}).on('shown.bs.modal', function(e){
		var $target = $(this).find(".modal-body").first();
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
		$("#wrapper-modal-pengantar").removeClass("loading");
		$("#frm-m1").validator({disable:false});
		$("#frm-m1").on("submit", function(e){
			if(!e.isDefaultPrevented()){
				$("#evt_sukses").trigger("validasi.oke");
				return false;
			}
		});
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
		if($(e.target).attr("id") == "tambah_tersangka")
			$(this).find('form#frm-m1').off('submit').validator('destroy');
	}).on("click", ".clsM2Tsk", function(){
		$("#tambah_tersangka").modal("hide");
	}).on("validasi.oke", "#evt_sukses", function(){
		var frmnya = $("#tambah_tersangka").find("#frm-m1").serializeArray();
		var arrnya = [];
		$.each(frmnya, function(i,v){arrnya[v.name] = v.value;});
		if(arrnya['newrec_form_tersangka'] == 1){
			var tabel = $('#table_tersangka > tbody').find('tr:last');
			var newId = (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
			$('#table_tersangka').append(
			'<tr data-id="'+newId+'">'+
				'<td class="text-center"><input type="checkbox" name="modal1_chk_del_tsk['+newId+']" id="modal1_chk_del_tsk'+newId+'" class="hRow" value="'+newId+'"></td>'+
				'<td>'+
					'<input type="hidden" class="tskBrks nomnya" name="modal1_no_urut['+newId+']" id="modal1_no_urut'+newId+'" value="'+arrnya['modal2_no_urut']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_nama['+newId+']" id="modal1_nama'+newId+'" value="'+arrnya['modal2_nama']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_tmpt_lahir['+newId+']" id="modal1_tmpt_lahir'+newId+'" value="'+arrnya['modal2_tmpt_lahir']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_tgl_lahir['+newId+']" id="modal1_tgl_lahir'+newId+'" value="'+arrnya['modal2_tgl_lahir']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_umur['+newId+']" id="modal1_umur'+newId+'" value="'+arrnya['modal2_umur']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_warganegara['+newId+']" id="modal1_warganegara'+newId+'" value="'+arrnya['modal2_warganegara']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_kebangsaan['+newId+']" id="modal1_kebangsaan'+newId+'" value="'+arrnya['modal2_kebangsaan']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_suku['+newId+']" id="modal1_suku'+newId+'" value="'+arrnya['modal2_suku']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_id_identitas['+newId+']" id="modal1_id_identitas'+newId+'" value="'+arrnya['modal2_id_identitas']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_no_identitas['+newId+']" id="modal1_no_identitas'+newId+'" value="'+arrnya['modal2_no_identitas']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_id_jkl['+newId+']" id="modal1_id_jkl'+newId+'" value="'+arrnya['modal2_id_jkl']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_id_agama['+newId+']" id="modal1_id_agama'+newId+'" value="'+arrnya['modal2_id_agama']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_alamat['+newId+']" id="modal1_alamat'+newId+'" value="'+arrnya['modal2_alamat']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_no_hp['+newId+']" id="modal1_no_hp'+newId+'" value="'+arrnya['modal2_no_hp']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_id_pendidikan['+newId+']" id="modal1_id_pendidikan'+newId+'" value="'+arrnya['modal2_id_pendidikan']+'" />'+
					'<input type="hidden" class="tskBrks" name="modal1_pekerjaan['+newId+']" id="modal1_pekerjaan'+newId+'" value="'+arrnya['modal2_pekerjaan']+'" />'+
					'<a class="ubahTersangka" style="cursor:pointer">'+arrnya['modal2_no_urut']+'. '+arrnya['modal2_nama']+'</a>'+
				'</td>'+
				'<td>'+arrnya['modal2_tmpt_lahir']+', '+arrnya['modal2_tgl_lahir']+'</td>'+
				'<td>'+arrnya['modal2_umur']+' Tahun</td>'+
			'</tr>');
		} else{
			var tabel = $('#table_tersangka').find("tr[data-id='"+arrnya['trid_form_tersangka']+"']");
			var newId = arrnya['trid_form_tersangka'];
			tabel.html(
			'<td class="text-center"><input type="checkbox" name="modal1_chk_del_tsk['+newId+']" id="modal1_chk_del_tsk'+newId+'" class="hRow" value="'+newId+'"></td>'+
			'<td>'+
				'<input type="hidden" class="tskBrks nomnya" name="modal1_no_urut['+newId+']" id="modal1_no_urut'+newId+'" value="'+arrnya['modal2_no_urut']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_nama['+newId+']" id="modal1_nama'+newId+'" value="'+arrnya['modal2_nama']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_tmpt_lahir['+newId+']" id="modal1_tmpt_lahir'+newId+'" value="'+arrnya['modal2_tmpt_lahir']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_tgl_lahir['+newId+']" id="modal1_tgl_lahir'+newId+'" value="'+arrnya['modal2_tgl_lahir']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_umur['+newId+']" id="modal1_umur'+newId+'" value="'+arrnya['modal2_umur']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_warganegara['+newId+']" id="modal1_warganegara'+newId+'" value="'+arrnya['modal2_warganegara']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_kebangsaan['+newId+']" id="modal1_kebangsaan'+newId+'" value="'+arrnya['modal2_kebangsaan']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_suku['+newId+']" id="modal1_suku'+newId+'" value="'+arrnya['modal2_suku']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_id_identitas['+newId+']" id="modal1_id_identitas'+newId+'" value="'+arrnya['modal2_id_identitas']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_no_identitas['+newId+']" id="modal1_no_identitas'+newId+'" value="'+arrnya['modal2_no_identitas']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_id_jkl['+newId+']" id="modal1_id_jkl'+newId+'" value="'+arrnya['modal2_id_jkl']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_id_agama['+newId+']" id="modal1_id_agama'+newId+'" value="'+arrnya['modal2_id_agama']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_alamat['+newId+']" id="modal1_alamat'+newId+'" value="'+arrnya['modal2_alamat']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_no_hp['+newId+']" id="modal1_no_hp'+newId+'" value="'+arrnya['modal2_no_hp']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_id_pendidikan['+newId+']" id="modal1_id_pendidikan'+newId+'" value="'+arrnya['modal2_id_pendidikan']+'" />'+
				'<input type="hidden" class="tskBrks" name="modal1_pekerjaan['+newId+']" id="modal1_pekerjaan'+newId+'" value="'+arrnya['modal2_pekerjaan']+'" />'+
				'<a class="ubahTersangka" style="cursor:pointer">'+arrnya['modal2_no_urut']+'. '+arrnya['modal2_nama']+'</a>'+
			'</td>'+
			'<td>'+arrnya['modal2_tmpt_lahir']+', '+arrnya['modal2_tgl_lahir']+'</td>'+
			'<td>'+arrnya['modal2_umur']+' Tahun</td>');
		}
		$("#modal1_chk_del_tsk"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$("#tambah_tersangka").modal('hide');
	});
	$(".hapusTersangka").click(function(){
		var tabel = $("#table_tersangka");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
	});
	$("#table_tersangka").on("click",'.ubahTersangka',function(){
		var temp = $(this).closest("tr");
		var trid = temp.data("id");
		var objk = temp.find(".tskBrks").serializeArray();
		objk.push({name: 'tr_id', value: trid});
		$.ajax({
			type	: "POST",
			url		: "/pidsus/pds-terima-berkas/poptersangka",
			data	: objk,
			cache	: false,
			success : function(data){ 
				$("#tambah_tersangka").find(".modal-body").html("");
				$("#tambah_tersangka").find(".modal-body").html(data);
				$("#tambah_tersangka").find("#trid_form_tersangka").val(trid);
				$("#tambah_tersangka").find("#newrec_form_tersangka").val('0');
				$("#tambah_tersangka").find("#simpan_form_tersangka").html('<i class="fa fa-floppy-o jarak-kanan"></i>Ubah');
				$("#tambah_tersangka").modal({backdrop:"static", keyboard:false});
			}
		});
	});
	/* END TERSANGKA */
        
	/* START UNDANG-UNDANG PASAL */
	$('#table_uu').on('click',".undang", function(e){
		setId($(this).data("id"));
		$("#pilih_undang").find(".modal-body").html("");
		$("#pilih_undang").find(".modal-body").load("/pidsus/pds-terima-berkas/getformundang");
		$("#pilih_undang").modal({backdrop:"static", keyboard:false});
	}).on('click', '.pasal',function(e){
		setId($(this).data("id"));
		var ida = $('#modal1_undang_id'+id).val();
		if(ida == ""){
			bootbox.alert({message: "Silahkan pilih Undang-undang terlebih dahulu", size:'small', 
				callback: function(){
					$("#pilih_pasal").focus();
				}
			});
		}else{
			$("#form_pasal").find(".modal-body").html("");
			$("#form_pasal").find(".modal-body").load("/pidsus/pds-terima-berkas/getformpasal?jnsins_id="+ida);
			$("#form_pasal").modal({backdrop:"static"});
		}
	}).on('change','.dakwaan', function(e){
		var dak 	= $(this).data("id");
		var tabel	= $('#table_uu').find('.tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		var cek 	= newId - parseInt(dak);
		if(cek == 1){
			$('#table_uu').append(
			'<div style="padding:10px; margin-bottom:15px; border:1px solid #f29db2;" class="tr" data-id="'+newId+'">'+
				'<button class="btn btn-danger btn-sm hapus-dakwaan pull-right" data-id="'+newId+'">Hapus</button>'+
				'<div class="row">'+        
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Undang-undang</label>'+
							'<div class="col-md-8">'+
								'<div class="input-group input-group-sm">'+
									'<input type="hidden" name="modal1_undang_id['+newId+']" id="modal1_undang_id'+newId+'" value="" />'+
									'<input type="text" name="modal1_undang_uu['+newId+']" id="modal1_undang_uu'+newId+'" class="form-control txtUndangPasal" value="" readonly />'+
									'<span class="input-group-btn"><button type="button" class="btn undang" data-id="'+newId+'">Pilih</button></span>'+
								'</div>'+
								'<div class="help-block with-errors" id="error_custom_modal1_undang_uu'+newId+'"></div>'+
							'</div>'+
						'</div>'+
					'</div>' +
				'</div>'+
				'<div class="row">'+        
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Pasal</label>'+
							'<div class="col-md-8">'+
								'<div class="input-group input-group-sm">'+
									'<input type="hidden" name="modal1_id_pasal['+newId+']" id="modal1_id_pasal'+newId+'" value="" />'+
									'<input type="text" name="modal1_pasal['+newId+']" id="modal1_pasal'+newId+'" class="form-control txtUndangPasal" value="" readonly />'+
									'<span class="input-group-btn"><button type="button" class="btn pasal" data-id="'+newId+'">Pilih</button></span>'+
								'</div>'+
								'<div class="help-block with-errors" id="error_custom_modal1_pasal'+newId+'"></div>'+
							'</div>'+
						'</div>'+
					'</div> '+
				'</div>'+
				'<div class="row">'+       
					'<div class="col-md-10">'+
						'<div class="form-group form-group-sm">'+
							'<label class="control-label col-md-2">Dakwaan</label>'+
							'<div class="col-md-4">'+
								'<select name="modal1_dakwaan['+newId+']" id="modal1_dakwaan'+newId+'" class="select2 dakwaan" data-id="'+newId+'" style="width:100%;">'+
									'<option value=""></option>'+
									'<option value="1">-- Juncto --</option>'+
									'<option value="2">-- Dan --</option>'+
									'<option value="3">-- Atau --</option>'+
									'<option value="4">-- Subsider --</option>'+
								'</select>'+
							'</div>'+
						'</div>'+
					'</div>'+
				'</div>'+
			'</div>');
			$("#modal1_dakwaan"+newId).select2({placeholder:"Pilih salah satu", allowClear:true});
		}
	}).on('click','.hapus-dakwaan',function(e){
		var id = $(this).data('id');
		$('#table_uu').find(".tr[data-id='"+id+"']").remove();
	});
	
	var id;   
	function setId(id1){
		id =id1;
	}
	 
	$("#pilih_undang").on('show.bs.modal', function(e){
		$("#wrapper-modal-pengantar").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-pengantar").removeClass("loading");
		var $target = $(this).find(".modal-body").first();
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("click", ".closeM1UU", function(){
		$("#pilih_undang").modal("hide");
	}).on("dblclick", "#tblModalUu td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split("|#|");
		insertToUu(param);
		$("#pilih_undang").modal('hide');
	}).on('click','.pilihModalUU',function(e){
		var index = $(this).data('id');
		var param = index.toString().split("|#|");
		insertToUu(param);
		$("#pilih_undang").modal('hide');
	});
	function insertToUu(param){
		var $target = $("#jpn_modal").find(".tr[data-id='"+id+"']");
		$("#modal1_undang_id"+id).val(decodeURIComponent(param[0]));
		$("#modal1_undang_uu"+id).val(decodeURIComponent(param[1]));
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
	}
	
	$("#form_pasal").on('show.bs.modal', function(e){
		$("#wrapper-modal-pengantar").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-pengantar").removeClass("loading");
		var $target = $(this).find(".modal-body").first();
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("click", ".closeM1Psl", function(){
		$("#form_pasal").modal("hide");
	}).on("dblclick", "#tblModalPasal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split("|#|");
		insertToPasal(param);
		$("#form_pasal").modal('hide');
	}).on('click','.pilihModalPasal',function(e){
		var index = $(this).data('id');
		var param = index.toString().split("|#|");
		insertToPasal(param);
		$("#form_pasal").modal('hide');
	});
	function insertToPasal(param){
		var $target = $("#jpn_modal").find(".tr[data-id='"+id+"']");
		$("#modal1_id_pasal"+id).val(decodeURIComponent(param[0]));
		$("#modal1_pasal"+id).val(decodeURIComponent(param[1]));
		$("#jpn_modal").animate({scrollTop: $target.offset().top-60 + "px"});
	}
	/* END UNDANG-UNDANG PASAL */
});
</script>
