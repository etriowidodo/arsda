<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsNotaPendapatPratut;

	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/pds-nota-pendapat-pratut/index';
	$linkCetak		= '/pidsus/pds-nota-pendapat-pratut/cetak?id='.$model['no_minta_perpanjang'];
	$tgl_nota	= ($model['tgl_nota'])?date('d-m-Y',strtotime($model['tgl_nota'])):'';
	$tgl_awal_penahanan_oleh_penyidik = ($model['tgl_awal_penahanan_oleh_penyidik'])?date('d-m-Y',strtotime($model['tgl_awal_penahanan_oleh_penyidik'])):'';
	$tgl_akhir_penahanan_oleh_penyidik = ($model['tgl_akhir_penahanan_oleh_penyidik'])?date('d-m-Y',strtotime($model['tgl_akhir_penahanan_oleh_penyidik'])):'';
	$tgl_awal_permintaan_perpanjangan = ($model['tgl_awal_permintaan_perpanjangan'])?date('d-m-Y',strtotime($model['tgl_awal_permintaan_perpanjangan'])):'';
	$tgl_akhir_permintaan_perpanjangan = ($model['tgl_akhir_permintaan_perpanjangan'])?date('d-m-Y',strtotime($model['tgl_akhir_permintaan_perpanjangan'])):'';
	$tgl_minta_perpanjang = ($model['tgl_minta_perpanjang'])?date('d-m-Y',strtotime($model['tgl_minta_perpanjang'])):'';
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-nota-pendapat-pratut/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Permintaan Perpanjangan</label>        
                            <div class="col-md-8">
                                <?php if($model['no_minta_perpanjang']){ ?>
                                    <input type="text" name="no_minta_perpanjang" id="no_minta_perpanjang" maxlength="50" class="form-control" value="<?php echo $model['no_minta_perpanjang']; ?>" readonly />
                                <?php } else{ ?>
                                <select id="no_minta_perpanjang" name="no_minta_perpanjang" class="select2" style="width:100%;" required data-error="Nomor Permintaan Perpanjangan belum dipilih">
                                    <option></option>
                                    <?php 
                                        $sqlx="select a.no_minta_perpanjang from pidsus.pds_minta_perpanjang a "
                                                . " left join pidsus.pds_nota_pendapat_t4 d on a.id_kejati = d.id_kejati and a.id_kejari = d.id_kejari and a.id_cabjari = d.id_cabjari and a.no_spdp = d.no_spdp and a.tgl_spdp = d.tgl_spdp and a.no_minta_perpanjang = d.no_minta_perpanjang"
                                                . " where ".$whereDefault." and d.no_minta_perpanjang is null";
                                        $jns = PdsNotaPendapatPratut::findBySql($sqlx)->asArray()->all();
                                        foreach($jns as $ji){
                                            $selected = ($ji['no_minta_perpanjang'] == $model['no_minta_perpanjang'])?'selected':'';
                                            echo '<option value="'.$ji['no_minta_perpanjang'].'" '.$selected.'>'.$ji['no_minta_perpanjang'].'</option>';
                                        }
                                    ?>
                                </select>
                                <?php }?>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_no_perpanjangan"></div></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Permintaan Perpanjangan</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_minta_perpanjang" id="tgl_minta_perpanjang" class="form-control" readonly="" placeholder="DD-MM-YYYY" value="<?php echo $tgl_minta_perpanjang;?>"/>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
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
            <div class="box-body">
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Tanggal Nota Pendapat</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_nota" id="tgl_nota" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_nota;?>"/>
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom_tglnota"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Tanggal Penahanan Oleh Penyidik</label>  
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_awal_penahanan_oleh_penyidik" id="tgl_awal_penahanan_oleh_penyidik" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_awal_penahanan_oleh_penyidik;?>"/>
                                </div>
                            </div>
                            <label class="control-label col-md-1" style="text-align: center">sd</label> 
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_akhir_penahanan_oleh_penyidik" id="tgl_akhir_penahanan_oleh_penyidik" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_akhir_penahanan_oleh_penyidik;?>"/>
                                </div>
                            </div>
                            <div class="col-md-offset-8 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_akhir_penahanan_oleh_penyidik"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Tanggal Perpanjangan</label>  
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_awal_permintaan_perpanjangan" id="tgl_awal_permintaan_perpanjangan" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_awal_permintaan_perpanjangan;?>"/>
                                </div>
                            </div>
                            <label class="control-label col-md-1" style="text-align: center">sd</label> 
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_akhir_permintaan_perpanjangan" id="tgl_akhir_permintaan_perpanjangan" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_akhir_permintaan_perpanjangan;?>"/>
                                </div>
                            </div>
                            <div class="col-md-offset-8 col-md-8"><div class="help-block with-errors" id="error_custom_tgl_akhir_permintaan_perpanjangan"></div></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-3">Persetujuan</label>        
                            <div class="col-md-4">
                                <input type="text" readonly="" name="persetujuan" id="persetujuan" class="form-control" value="<?php echo $model['persetujuan'];?>" />
                            </div>
                            <label class="control-label col-md-1">Hari</label> 
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Kota Ditandatangani</label>        
                            <div class="col-md-8">
                                <input type="text" name="kota" id="kota" class="form-control" value="<?php echo $model['kota'];?>" maxlength="121" />
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="box box-primary form-buat-pemberi-kuasa">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="btn_popjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah Jaksa</a>
                    </div>		
                </div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-jpn-modal">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="30%">NIP / Nama</th>
                                <th class="text-center" width="60%">Jabatan / Pangkat &amp; Golongan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $sqlnya = "select id_jaksa,nip_jaksa_p16, nama_jaksa_p16, jabatan_jaksa_p16, pangkat_jaksa_p16    
                                        from pidsus.pds_nota_pendapat_t4_jaksa a where ".$whereDefault." and no_minta_perpanjang = '".$model['no_minta_perpanjang']."' order by id_jaksa";
                            $hasil = PdsNotaPendapatPratut::findBySql($sqlnya)->asArray()->all();
                            if(count($hasil) == 0)
                                echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
                            else{
                                $nom = 0;
                                foreach($hasil as $data){
                                    $nom++;	
                                    $idJpn = $data['nip_jaksa_p16']."#".$data['nama_jaksa_p16']."#".$data['jabatan_jaksa_p16']."#".$data['pangkat_jaksa_p16'];						
                          ?>        
                              <tr data-id="<?php echo $data['nip_jaksa_p16'];?>">
                                <td class="text-center">
                                    <input type="checkbox" name="chk_del_jaksa[]" class="hRowJpn" id="chk_del_jaksa<?php echo $data['no_urut'];?>" value="<?php echo $data['nip_jaksa_p16'];?>">
                                </td>
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="<?php echo $data['no_urut'];?>"><?php echo $data['id_jaksa'];?></span>
                                    <input type="hidden" name="no_urut_jaksa[]" value="<?php echo $data['id_jaksa'];?>"/>
                                </td>
                                <td class="text-left"><?php echo $data['nip_jaksa_p16'].' / '.$data['nama_jaksa_p16'];?></td>
                                <td class="text-left">
                                    <?php echo $data['jabatan_jaksa_p16'].' / '.$data['pangkat_jaksa_p16'];?>
                                    <input type="hidden" name="jaksa[]" value="<?php echo $idJpn;?>"/>
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
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo date("d-m-Y", strtotime($_SESSION["tgl_spdp"]));?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="jpn_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog form-horizontal">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar Jaksa P-16</h4>
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
$(document).ready(function(){
	/* START AMBIL JAKSA */
        localStorage.clear();
	var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
	$(".form-buat-pemberi-kuasa").find(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValues[idnya] = idnya;
	});
	localStorage.setItem("formValues", JSON.stringify(formValues));
        
	$(".form-buat-pemberi-kuasa").on("click", "#btn_popjpn", function(){
                $("#jpn_modal").find(".modal-body").html("");
		$("#jpn_modal").find(".modal-body").load("/pidsus/pds-nota-pendapat-pratut/getjp");
		$("#jpn_modal").modal({backdrop:"static",keyboard:false});
	}).on("click", "#btn_hapusjpn", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
		tabel.find(".hRowJpn:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-pemberi-kuasa").find(".table-jpn-modal > tbody");
				nRow.append('<tr><td colspan="4">Tidak ada dokumen</td></tr>');
			}
		});
		tabel.find(".frmnojpn").each(function(i,v){$(this).text(i+1);});				

		formValues = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValues[idnya] = idnya;
		});
		localStorage.setItem("formValues", JSON.stringify(formValues));
		var n = tabel.find(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});
        
        $("#jpn_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on('click', '.pilih-jpn', function(){
                var id 	= [];
                var n 	= JSON.parse(localStorage.getItem('modalnyaDataJPN')) || {};
                for(var x in n){ 
                        id.push(n[x]);
                }
                id.forEach(function(index,element) {
                        var param	= index.toString().split('#');
                        var myvar 	= param[0];
                        insertToRole(myvar, index);
                });
                localStorage.removeItem("modalnyaDataJPN");
                $("#jpn_modal").modal("hide");
        }).on("dblclick", "#jpn-jpn-modal td:not(.aksinya)", function(){
                var index 	= $(this).closest("tr").data("id");
                var param	= index.toString().split('#');
                var myvar 	= param[0];
                if(myvar in formValues){
                    $("#jpn_modal").modal("hide");
                } else{
                    insertToRole(myvar, index);
                    $("#jpn_modal").modal("hide");
                }
	});
        
        function insertToRole(myvar, index){
            var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
            var rwTbl	= tabel.find('tbody > tr:last');
            var rwNom	= parseInt(rwTbl.find("span.frmnojpn").data('rowCount'));
            var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
            var param	= index.toString().split('#');
                
            if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+myvar+'">'+
                                '<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jaksa[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[2]+'<br />'+param[3]+'</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
                                '<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jaksa[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br />'+param[1]+'</td>'+
				'<td>'+param[2]+'<br />'+param[3]+'</td>'+
			'</tr>');
		}

		$("#cekModalJpn_"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		tabel.find(".frmnojpn").each(function(i,v){$(this).text(i+1);});
		formValues[myvar] = myvar;
		localStorage.setItem("formValues", JSON.stringify(formValues));
	}
        
        $(".form-buat-pemberi-kuasa").on("ifChecked", ".table-jpn-modal input[name=allCheckJpn]", function(){
		$(".hRowJpn").not(':disabled').iCheck("check");
	}).on("ifUnchecked", ".table-jpn-modal input[name=allCheckJpn]", function(){
		$(".hRowJpn").not(':disabled').iCheck("uncheck");
	}).on("ifChecked", ".table-jpn-modal .hRowJpn", function(){
		var n = $(".hRowJpn:checked").length;
		(n >= 1)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	}).on("ifUnchecked", ".table-jpn-modal .hRowJpn", function(){
		var n = $(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});
	/* END AMBIL JAKSA */
        
        /* START AMBIL TANGGAL PERMINTAAN PERPANJANGAN */
        $("#no_minta_perpanjang").change(function(){
            $("#tgl_minta_perpanjang").val("");
            $.ajax({
                    type	: "POST",
                    url		: "/pidsus/pds-nota-pendapat-pratut/gettglmintaperpanjang",
                    dataType    : 'json',
                    data	: { q1 : $("#no_minta_perpanjang").val() },
                    cache	: false,
                    success     : function(data){ 
                                if(data != ""){
                                        $("#tgl_minta_perpanjang").val(data);
                                        return false;
                                }
                    }
            });
	});
        /* END AMBIL TANGGAL PERMINTAAN PERPANJANGAN */
        
        /* START HITUNG PERSETUJUAN */
        $("#tgl_akhir_permintaan_perpanjangan").on('change',function (){
            hariPersetujuan();
        });
        $("#tgl_awal_permintaan_perpanjangan").on('change',function (){
            hariPersetujuan();
        });
        function hariPersetujuan(){
            var tgl_awal    = $('#tgl_awal_permintaan_perpanjangan').val();
            var tgl_akhir   = $('#tgl_akhir_permintaan_perpanjangan').val();
            var miliday = 24 * 60 * 60 * 1000;
            
            var str = tgl_awal.split('-');
            var firstdate=new Date(str[2],str[1],str[0]);
            
            var start = tgl_akhir.split('-');
            var Endate=new Date(start[2],start[1],start[0]);
            
            var selisih = (Endate - firstdate) / miliday;
            var persetujuan = parseInt(selisih)+1;
            if(persetujuan<0 || isNaN(persetujuan)){persetujuan=0}
            $('#persetujuan').val(persetujuan);
        }
        /* END HITUNG PERSETUJUAN */
});
	
</script>
<?php } ?>