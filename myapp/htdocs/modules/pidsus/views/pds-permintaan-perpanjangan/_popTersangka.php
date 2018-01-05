<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\pidsus\models\PdsPermintaanPerpanjangan as pilih;
?>
<div id="wrapper-modal-tsk">
    <form class="form-horizontal" id="frm-m1">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Nama Tersangka</label>
                    <div class="col-md-10">
                        <div class="input-group">
                        	<input type="text" name="modal_nama" id="modal_nama" class="form-control" value="<?php echo $model["nama"]; ?>" required data-error="Nama tersangka belum diisi" />
                            <div class="input-group-btn">
                            	<button type="button" class="btnGetTskSpdp btn btn-sm btn-pidsus"><i class="fa fa-search jarak-kanan"></i>Tersangka SPDP</button>
                            </div>
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Lahir</label>
                    <div class="col-md-8">
                        <input type="text" name="modal_tmpt_lahir" id="modal_tmpt_lahir" class="form-control" value="<?php echo $model["tmpt_lahir"]; ?>" required data-error="Tempat lahir belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
            <div class="col-md-4">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-6">Tanggal Lahir</label>
                    <div class="col-md-6">
                         <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="modal_tgl_lahir" id="modal_tgl_lahir" class="form-control" value="<?php echo $model["tgl_lahir"]; ?>" style="width:90px;" placeholder="DD-MM-YYYY" required data-error="Tanggal lahir belum diisi" />
						</div>
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
            <div class="col-md-2">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                         <div class="input-group">
                            <div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>
                            <input type="text" name="modal_umur" id="modal_umur" class="form-control" value="<?php echo ($model["umur"]?$model["umur"]:'');?>" required data-error="Umur belum diisi" />
                        </div>
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                        <input type="hidden" name="modal_warganegara" id="modal_warganegara" value="<?= $model["warganegara"]?>" />
                        <input type="text" name="modal_kebangsaan" id="modal_kebangsaan" class="form-control" value="<?= $model["kebangsaan"]?>" placeholder="-Pilih Kewarganegaraan-" required data-error="Kewarganegaraan belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Suku</label>
                    <div class="col-md-8">
                        <input type="text" name="modal_suku" id="modal_suku" class="form-control" value="<?= $model["suku"]?>" required data-error="Suku belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Identitas</label>
                    <div class="col-md-8">
                        <select name="modal_id_identitas" id="modal_id_identitas" class="select2" style="width:100%;" required data-error="Identitas belum dipilih">
                            <option></option>
                            <?php 
                                $idn = pilih::findBySql("select * from public.ms_identitas order by id_identitas")->asArray()->all();
                                foreach($idn as $id){
                                    $selected = ($id['id_identitas'] == $model['id_identitas'])?'selected':'';
                                    echo '<option value="'.$id['id_identitas'].'" '.$selected.'>'.$id['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No Identitas</label>
                    <div class="col-md-8">
                        <input type="text" name="modal_no_identitas" id="modal_no_identitas" class="form-control" value="<?= $model["no_identitas"]?>" placeholder="No Identitas" required data-error="No Identitas belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Jenis Kelamin</label>
                    <div class="col-md-8">
                        <input type="radio" name="modal_id_jkl" id="id_jkl[1]" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> required data-error="Jenis Kelamin belum dipilih" />
                        <label for="id_jkl[1]" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="modal_id_jkl" id="id_jkl[2]" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> required data-error="Jenis Kelamin belum dipilih" />
                        <label for="id_jkl[2]" class="control-label">Perempuan</label>
                        <div class="help-block with-errors"></div>
                    </div>
				</div>
			</div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Agama</label>
                    <div class="col-md-8">
                        <select id="modal_id_agama" name="modal_id_agama" class="select2" style="width:100%;" required data-error="Agama belum dipilih">
                            <option></option>
                            <?php 
                                $agm = pilih::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
                                foreach($agm as $ag){
                                    $selected = ($ag['id_agama'] == $model['id_agama'])?'selected':'';
                                    echo '<option value="'.$ag['id_agama'].'" '.$selected.'>'.$ag['nama'].'</option>';
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
                    <label class="control-label col-md-4">Alamat</label>
                    <div class="col-md-8">
                        <textarea name="modal_alamat" id="modal_alamat" class="form-control" style="height:100px;" required data-error="Alamat belum diisi"><?php echo $model["alamat"];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No HP</label>
                    <div class="col-md-8">
                        <input type="text" name="modal_no_hp" id="modal_no_hp" class="form-control" value="<?= $model["no_hp"]?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Pendidikan</label>
                        <div class="col-md-8">
                            <select id="modal_pendidikan" name="modal_pendidikan" class="select2" style="width:100%;" required data-error="Pendidikan belum dipilih">
                            <option></option>
                            <?php 
                                $pdd = pilih::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                foreach($pdd as $pd){
                                    $selected = ($pd['id_pendidikan'] == $model['id_pendidikan'])?'selected':'';
                                	echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Pekerjaan</label>
                    <div class="col-md-8">
                        <input type="text" name="modal_pekerjaan" id="modal_pekerjaan" class="form-control" value="<?= $model["pekerjaan"]?>" required data-error="Pekerjaan belum diisi" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Riwayat Penahanan</h3>
            </div>
            <div class="box-body">
                <div class="table-resonsive">
                	<table class="table table-bordered">
                    	<thead>
                        	<tr>
                            	<th class="text-center" width="180">Jenis Penahanan</th>
                            	<th class="text-center" width="265">Masa Penahanan</th>
                            	<th class="text-center" width="">Lokasi</th>
                            </tr>
                        </thead>
                        <tbody>
                        	<tr>
                            	<td>
                                    <div class="form-group form-group-sm" style="margin:0px;">
                                        <select id="modal_jenis_penahanan" name="modal_jenis_penahanan" class="select2" style="width:100%;" required data-error="Jenis Penahanan belum dipilih">
                                            <option></option>
                                            <?php 
                                                $arrJnsThn = array(1=>"Rutan", "Rumah", "Kota");
                                                foreach($arrJnsThn as $idxJnsThn=>$valJnsThn){
                                                    $selected = ($idxJnsThn == $model['jenis_penahanan'])?'selected':'';
                                                    echo '<option value="'.$idxJnsThn.'" '.$selected.'>'.$valJnsThn.'</option>';	
                                                }
                                            ?>
                                        </select>
                                        <div class="help-block with-errors"></div>
                                    </div>
                                </td>
                            	<td>
                                	<div class="form-group form-group-sm" style="margin:0px;">
                                        <div class="input-group">
                                            <input type="text" name="modal_tgl_mulai_penahanan" id="modal_tgl_mulai_penahanan" class="form-control input-sm" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $model["tgl_mulai_penahanan"]?>" required data-error="Masa Penahanan belum diisi" />
                                            <div class="input-group-addon" style="border:none;">S/D</div>
                                            <input type="text" name="modal_tgl_selesai_penahanan" id="modal_tgl_selesai_penahanan" class="form-control input-sm" style="width:100px;" placeholder="DD-MM-YYYY" value="<?= $model["tgl_selesai_penahanan"]?>" required data-error="Masa Penahanan belum diisi" />
                                        </div>
                                    	<div class="help-block with-errors"></div>
                                    </div>
                                </td>
                            	<td>
                                	<div class="form-group form-group-sm" style="margin:0px;">
                                		<input type="text" name="modal_lokasi_penahanan" id="modal_lokasi_penahanan" class="form-control input-sm" value="<?= $model["lokasi_penahanan"]; ?>" required data-error="Lokasi Penahanan belum diisi" />
                                    	<div class="help-block with-errors"></div>
                                    </div>
								</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="evt_sukses" id="evt_sukses"  />
            <button type="submit" id="simpan_form_tersangka" class="btn btn-warning btn-sm jarak-kanan"></button>
            <a data-dismiss="modal" class="btn btn-danger btn-sm" id="form_keluar"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
        </div>
    </form>
    <div class="modal-loading-new"></div>

</div>

<div class="modal fade" id="kewarganegaraan_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeMWgn"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Kewarganegaraan</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="tskSpdp_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close closeMTsk"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Data Tersangka</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<style>
	#wrapper-modal-tsk.loading {overflow: hidden;}
	#wrapper-modal-tsk.loading .modal-loading-new {display: block;}

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
</style>

<script type="text/javascript">
$(function(){
    var tglASDF123 = '<?php echo date("Y").",".date("m").",".date("d");?>';

	$(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
    
    $("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink'}); 
    
    $("#modal_tgl_lahir, #modal_tgl_mulai_penahanan, #modal_tgl_selesai_penahanan").datepicker({								  
		defaultDate: new Date(tglASDF123),
		dateFormat: 'dd-mm-yy',
		changeMonth: true,
		changeYear: true,
		yearRange: "c-80:c+10",
		dayNamesMin: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
		monthNamesShort: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
    });
    
    $("#modal_tgl_lahir").on('change',function (){
        var tgl = $('#modal_tgl_lahir').val();
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglSkr ='<?php echo date("d-m-Y");?>';

        var start = tglSkr.split('-');
        var Endate=new Date(start[2],start[1],start[0]);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#modal_umur').val(age);
    });

	$("#modal_kebangsaan").on("focus", function(){
		$("#kewarganegaraan_modal").find(".modal-body").load("/pidsus/get-kewarganegaraan/index");
		$("#kewarganegaraan_modal").modal({backdrop:"static", keyboard:false});
	});
	$("#kewarganegaraan_modal").on('show.bs.modal', function(e){
		$("#wrapper-modal-tsk").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-tsk").removeClass("loading");
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("click", ".closeMWgn", function(){
		$("#kewarganegaraan_modal").modal("hide");
	}).on("dblclick", "#table-wgn-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToWgn(param);
		$("#kewarganegaraan_modal").modal("hide");
	}).on('click', "#idPilihWgnModal", function(){
		var modal = $("#kewarganegaraan_modal").find("#table-wgn-modal");
		var index = modal.find(".pilih-wgn-modal:checked").val();
		var param = index.toString().split('#');
		insertToWgn(param);
		$("#kewarganegaraan_modal").modal("hide");
	});
	function insertToWgn(param){
		$("#modal_warganegara").val(param[0]);
		$("#modal_kebangsaan").val(param[1]);
	}
	
	$(".btnGetTskSpdp").on("click", function(){
		$("#tskSpdp_modal").find(".modal-body").load("/pidsus/pds-permintaan-perpanjangan/get-tersangka-spdp");
		$("#tskSpdp_modal").modal({backdrop:"static"});
	});
	$("#tskSpdp_modal").on('show.bs.modal', function(e){
		$("#wrapper-modal-tsk").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-tsk").removeClass("loading");
	}).on('hidden.bs.modal', function(e){
		$("body").addClass("modal-open");
	}).on("click", ".closeMTsk", function(){
		$("#tskSpdp_modal").modal("hide");
	}).on("dblclick", "#table-tsk-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToTsk(param);
		$("#tskSpdp_modal").modal("hide");
	}).on('click', "#idPilihTskModal", function(){
		var modal = $("#tskSpdp_modal").find("#table-tsk-modal");
		var index = modal.find(".pilih-tsk-modal:checked").val();
		var param = index.toString().split('#');
		insertToTsk(param);
		$("#tskSpdp_modal").modal("hide");
	});
	function insertToTsk(param){
		$("#modal_nama").val(decodeURIComponent(param[1]));
		$("#modal_tmpt_lahir").val(decodeURIComponent(param[2]));
		$("#modal_tgl_lahir").val(decodeURIComponent(param[3]));
		$("#modal_umur").val(decodeURIComponent(param[4]));
		$("#modal_warganegara").val(decodeURIComponent(param[5]));
		$("#modal_kebangsaan").val(decodeURIComponent(param[6]));
		$("#modal_suku").val(decodeURIComponent(param[7]));
		$("#modal_id_identitas").val(decodeURIComponent(param[8])).trigger("change");
		$("#modal_no_identitas").val(decodeURIComponent(param[9]));
		$("input[name='modal_id_jkl']").iCheck('uncheck');
		if(decodeURIComponent(param[10]) == 1) $("#modal_id_jkl[1]").iCheck('check');
		else if(decodeURIComponent(param[10]) == 2) $("#modal_id_jkl[2]").iCheck('check');
		$("#modal_id_agama").val(decodeURIComponent(param[11])).trigger("change");
		$("#modal_alamat").val(decodeURIComponent(param[12]));
		$("#modal_no_hp").val(decodeURIComponent(param[13]));
		$("#modal_pendidikan").val(decodeURIComponent(param[14])).trigger("change");
		$("#modal_pekerjaan").val(decodeURIComponent(param[15]));
	}

	/*$("#frm-m1").validator({disable:false}).on("submit", function(e){
		if(!e.isDefaultPrevented()){
			alert("oke");
			//$("#evt_sukses").trigger("validasi.oke");
			return false;
		}
	});*/
});
</script>
