<?php
	use yii\helpers\Html;
	use app\modules\security\models\User;
	use yii\widgets\ActiveForm;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/autentikasi/user/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Username</label>
                <div class="col-md-8">
                	<input type="text" name="username" id="username" class="form-control" required data-error="Username belum diisi" value="<?php echo $model['username'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <?php if($isNewRecord){ ?>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Password</label>
                <div class="col-md-8">
                	<input type="password" name="passhash" id="passhash" class="form-control" required data-error="Password belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">NIP Pegawai</label>
                <div class="col-md-8">
                	<div class="input-group">
                        <input type="text" name="peg_nip" id="peg_nip" class="form-control" required data-error="NIP Pegawai belum diisi" value="<?php echo $model['peg_nip'];?>" readonly />
	                	<span class="input-group-btn"><button type="button" name="btnCariNip" id="btnCariNip" class="btn btn-success"><i class="fa fa-search"></i></button></span>
                    </div>
                    <div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Nama Pegawai</label>
                <div class="col-md-8">
                	<input type="text" name="namanya" id="namanya" class="form-control" value="<?php echo $model['nama_pegawai'];?>" readonly />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">&nbsp;</label>
                <div class="col-md-8">
                	<label><input type="checkbox" name="is_admin" id="is_admin" value="1" <?php echo ($model['is_admin']?'checked':'');?> /> Is Admin</label>
				</div>
            </div>
        </div>
    </div>
</div>

<div style="border-color:#f39c12; overflow:hidden;" class="box box-primary">
    <div class="box-header" style="padding:15px; border-bottom: 1px solid #ccc;">
    	<h3 class="box-title"><b>Role User</b></h3>
    </div>
    <div class="box-body" style="padding:15px;">
        <div class="form-group row">
        	<div class="col-md-10">
            	<button type="button" name="btnTambah" id="btnTambah" class="btn btn-success btn-sm">Tambah</button>&nbsp;
            	<button type="button" name="btnHapus" id="btnHapus" class="btn btn-danger btn-sm pull-right disabled">Hapus</button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-10">
            	<div class="table-responsive">
                	<table class="table table-bordered table-hover table-role">
                    	<thead>
                        	<tr>
                                <th class="text-center" width="8%">No</th>
                                <th class="text-center" width="34%">Modul</th>
                                <th class="text-center" width="50%">Nama Role</th>
                                <th class="text-center" width="8%"><input type="checkbox" name="allCheck" id="allCheck" class="allCheck" /></th>
							</tr>
                        </thead>
                    	<tbody>
						<?php 
							$idnya	= ($model['id'])?$model['id']:-1;
							$sqlnya = "select a.username, b.id_role, c.nama_role, c.module 
								from mdm_user a 
								join mdm_user_role b on a.id = b.id_user join mdm_role c on b.id_role = c.id_role
								where a.id = '".$idnya."'";
							$hasil = User::findBySql($sqlnya)->asArray()->all();
							if(count($hasil) == 0)
								echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
							else{
								$nom = 0;
								foreach($hasil as $data){
									$nom++;							
                        ?>	
                            <tr data-id="<?php echo $data['id_role'];?>">
                            	<td class="text-center">
                                    <span data-row-count="<?php echo $nom;?>" class="frmid"><?php echo $nom;?></span>
                                    <input type="hidden" value="<?php echo $data['id_role'];?>" name="roleid[]">
								</td>
                                <td class="text-left"><?php echo $data['module'];?></td>
                                <td class="text-left"><?php echo $data['nama_role'];?></td>
                                <td class="text-center">
                                	<input type="checkbox" value="<?php echo $data['id_role'];?>" class="hRow" id="<?php echo 'cekrole_'.$nom;?>" name="cekrole[]" />
								</td>
                            </tr>
						<?php } } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
	</div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
    <input type="hidden" name="idr" id="idr" value="<?php echo $model['id']; ?>" />
    <input type="hidden" name="act" id="act" value="<?php echo $isNewRecord; ?>" />
    <input type="hidden" name="kode_tk" id="kode_tk" value="<?php echo $model['kode_tk']; ?>" />
    <input type="hidden" name="kode_kejati" id="kode_kejati" value="<?php echo $model['kode_kejati']; ?>" />
    <input type="hidden" name="kode_kejari" id="kode_kejari" value="<?php echo $model['kode_kejari']; ?>" />
    <input type="hidden" name="kode_cabjari" id="kode_cabjari" value="<?php echo $model['kode_cabjari']; ?>" />
    <input type="hidden" name="unitkerja_kd" id="unitkerja_kd" value="<?php echo $model['unitkerja_kd']; ?>" />
    <input type="hidden" name="unitkerja_idk" id="unitkerja_idk" value="<?php echo $model['unitkerja_idk']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <a href="/autentikasi/user/index" class="btn btn-danger">Batal</a>
</div>
</form>
<div class="modal fade" id="tambah_role_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Role</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal fade" id="lihat_menurole_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:650px">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Menu Role</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="cari_nip_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Pegawai</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<div class="modal-loading-new"></div>
<script type="text/javascript">
	$(document).ready(function(){
		localStorage.clear();
		var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
		$(".table-role").find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValues[idnya] = idnya;
		});
		localStorage.setItem("formValues", JSON.stringify(formValues));

		$("#btnCariNip").on('click', function(e){
			$("#cari_nip_modal").find(".modal-body").load("/autentikasi/user/getpegawai");
			$("#cari_nip_modal").modal({backdrop:"static"});
		});

		$("#cari_nip_modal").on('show.bs.modal', function(e){
			$("body").addClass("loading");
		}).on('shown.bs.modal', function(e){
			$("body").removeClass("loading");
		}).on('hidden.bs.modal', function(e){
			$("#cari_nip_modal").find(".modal-body").html("");
		}).on('click', ".pilihan", function(e){
			var pilih 	= $(this).data("pilih").split("#");
			var satker 	= pilih[2].split(".");
			var kodeTk 	= (satker[0] == '00'?0:satker.length);
			var kodeKj 	= (typeof(satker[1]) != 'undefined'?satker[1]:'00');
			var kodeCj 	= (typeof(satker[2]) != 'undefined'?satker[2]:'00');
			$("#peg_nip").val(pilih[0]);
			$("#namanya").val(pilih[1]);
			$("#unitkerja_kd").val(pilih[3]);
			$("#unitkerja_idk").val(pilih[4]);
			$("#kode_tk").val(kodeTk);
			$("#kode_kejati").val(satker[0]);
			$("#kode_kejari").val(kodeKj);
			$("#kode_cabjari").val(kodeCj);
			$("#cari_nip_modal").modal("hide");
		});

		$("#btnTambah").on('click', function(e){
			$("#tambah_role_modal").find(".modal-body").load("/autentikasi/user/getrole");
			$("#tambah_role_modal").modal({backdrop:"static"});
		});
		$("#btnHapus").on("click", function(){
			var id 		= [];
			var tabel 	= $(".table-role");
			tabel.find(".hRow:checked").each(function(k, v){
				var idnya = $(v).val();
				tabel.find("tr[data-id='"+idnya+"']").remove();
				if(tabel.find("tr").length == 1){
					var nRow = $(".table-role > tbody");
					nRow.append('<tr><td colspan="4">Tidak ada dokumen</td></tr>');
				} else{
					tabel.find(".frmid").each(function(i,v){$(this).text(i+1);});				
				}
			});
			formValues = {};
			tabel.find("tr[data-id]").each(function(k, v){
				var idnya = $(v).data("id");
				formValues[idnya] = idnya;
			});
			localStorage.setItem("formValues", JSON.stringify(formValues));
			$("input[name=allCheck]").iCheck("uncheck");
			var n = tabel.find(".hRow:checked").length;
			(n > 0)?$("#btnHapus").removeClass("disabled"):$("#btnHapus").addClass("disabled");
		});

		$("#tambah_role_modal").on('show.bs.modal', function(e){
			$("body").addClass("loading");
		}).on('shown.bs.modal', function(e){
			$("body").removeClass("loading");
		}).on('hidden.bs.modal', function(e){
			$("#tambah_role_modal").find(".modal-body").html("");
		}).on('click', ".menunya", function(e){
			var idnya = $(this).data("id");
			$.post("/autentikasi/user/getrolemenu", {'id' : idnya}, 
			function(data){
				$("#lihat_menurole_modal").find(".modal-body").html(data);
			});
			$("#lihat_menurole_modal").modal({backdrop:"static"});
		}).on('click', ".pilihan", function(e){
			var idnya = $(this).data("id");
			var pilih = $(this).data("pilih");
			insertToRole(idnya, pilih);
			$("#tambah_role_modal").modal("hide");
		});

		$("#lihat_menurole_modal").on('hidden.bs.modal', function(e){
			$("body").addClass("modal-open");
			$("#lihat_menurole_modal").find(".modal-body").html("");
		}).on('click', "button.close", function(e){
			$("#lihat_menurole_modal").modal("hide");
		});

		$('#myPjaxForm').on('pjax:send', function(e){
			$("body").addClass("loading");
		}).on('pjax:success', function(e){
			$("body").removeClass("loading");
		});

		$(".table-role").on("ifChecked", "input[name=allCheck]", function(){
			$(".hRow").iCheck("check");
		}).on("ifUnchecked", "input[name=allCheck]", function(){
			$(".hRow").iCheck("uncheck");
		});
		$(".table-role").on("ifChecked", ".hRow", function(){
			var n = $(".hRow:checked").length;
			(n > 0)?$("#btnHapus").removeClass("disabled"):$("#btnHapus").addClass("disabled");
		}).on("ifUnchecked", ".hRow", function(){
			var n = $(".hRow:checked").length;
			(n > 0)?$("#btnHapus").removeClass("disabled"):$("#btnHapus").addClass("disabled");
		});

		function insertToRole(idnya, pilih){
			var tabel 	= $(".table-role");
			var rwTbl	= tabel.find('tbody > tr:last');
			var rwNom	= parseInt(rwTbl.find("span.frmid").data('rowCount'));
			var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
			var param	= pilih.split("#");

			var objTr 	= $("<tr>").attr("data-id", idnya);
			var objTd1 	= $("<td>", {class:"text-center"}).appendTo(objTr);
			var objTd2 	= $("<td>", {class:"text-left"}).appendTo(objTr);
			var objTd3 	= $("<td>", {class:"text-left"}).appendTo(objTr);
			var objTd4 	= $("<td>", {class:"text-center"}).appendTo(objTr);
			objTd1.html('<span class="frmid" data-row-count="'+newId+'"></span><input type="hidden" name="roleid[]" value="'+idnya+'" />');
			objTd2.html(param[1]);
			objTd3.html(param[2]);
			objTd4.html('<input type="checkbox" name="cekrole[]" id="cekrole_'+newId+'" class="hRow" value="'+idnya+'" />');
			if(isNaN(rwNom)){
				rwTbl.remove();
				rwTbl = tabel.find('tbody');
				rwTbl.append(objTr);
			} else{
				rwTbl.after(objTr);
			}
			$("#cekrole_"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
			tabel.find(".frmid").each(function(i,v){$(this).text(i+1);});
			formValues[idnya] = idnya;
			localStorage.setItem("formValues", JSON.stringify(formValues));
		}
	});
</script>


