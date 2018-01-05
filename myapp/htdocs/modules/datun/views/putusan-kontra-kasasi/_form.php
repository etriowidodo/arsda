<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\security\models\User;
	use mdm\admin\models\searchs\Menu as MenuSearch;

	$this->title 	= 'Putusan Kontra Kasasi';
	$linkBatal		= '/datun/putusan/index';
	$tanggal_pts_kontrakasasi = ($head['tanggal_pts_kontrakasasi'])?date('d-m-Y',strtotime($head['tanggal_pts_kontrakasasi'])):'';
	$tanggal_skk 	= date('d-m-Y',strtotime($head['tanggal_skk']));
    $tanggal_skks	= date('d-m-Y',strtotime($head['tanggal_skks'])); 
    $tanggal_diterima= date('d-m-Y',strtotime($head['tanggal_diterima']));
	$tanggal_putusan	= date('d-m-Y',strtotime($head['tanggal_putusan']));
    $isNewRecord 	= ($head['no_pts_kontrakasasi'])?0:1; 
?>

<?php if($_SESSION['no_surat'] && $_SESSION['no_register_perkara'] && $_SESSION['no_skks']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/putusan-kontra-kasasi/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">   
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No. Perkara Perdata</label>        
        			<div class="col-md-8">
                         <input type="text" class="form-control" value="<?php echo $head['no_register_perkara'];?>" id="no_register_perkara" name="no_register_perkara" placeholder="" readonly="true">
                         <input type="text" class="form-control hide" value="<?php echo $head['no_putusan'];?>" id="no_putusan" name="no_putusan" placeholder="" readonly="true">
						 <input type="text" class="form-control hide" id="no_surat" name="no_surat" value="<?php echo $head['no_surat'];?>" placeholder="" hidden="true">
                         <input type="text" class="form-control hide" id="kode_jenis_instansi" name="kode_jenis_instansi" value="<?php echo $head['kode_jenis_instansi'];?>" placeholder="" hidden="true">
                         <input type="text" class="form-control hide" id="kode_instansi" name="kode_instansi" value="<?php echo $head['kode_instansi'];?>" placeholder="" hidden="true">
						<div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Asal Panggilan</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control hide" id="kode_kabupaten" name="kode_kabupaten" value="<?php echo $head['kode_kabupaten'];?>" placeholder="" hidden="true">
                        <input type="text" class="form-control" id="asal_panggilan" name="asal_panggilan" value="<?php echo $head['nama_pengadilan'];?>" placeholder="" readonly="true">
					</div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No. SKK</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control" id="no_register_skk" name="no_register_skk"  value="<?php echo $head['no_register_skk'];?>" placeholder="" readonly="true">
                        <div class="help-block with-errors"></div>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal  SKK</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right" id="tanggal_skk" name="tanggal_skk" value="<?php echo $tanggal_skk;?>" readonly="true" placeholder="DD-MM-YYYY">
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No. SKKS</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="no_register_skks" name="no_register_skks" value="<?php echo $head['no_register_skks'];?>" placeholder="" readonly="true"/>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal  SKKS</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<input type="text" class="form-control pull-right" id="tanggal_skks" name="tanggal_skks" value="<?php echo $tanggal_skks;?>" readonly="true" placeholder="DD-MM-YYYY"/>
                        </div>                      
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Penggugat</label>        
                    <div class="col-md-8">
                       	<input type="text" class="form-control" id="penggugat" name="penggugat" value="<?php echo $head['penggugat'];?>" placeholder="" readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>       
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tergugat</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="tergugat" name="tergugat" value="<?php echo $head['tergugat'];?>" placeholder="" readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>    
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Diterima Wilayah Kerja</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" id="wilayah_terima" name="wilayah_terima"  value="<?php echo Yii::$app->inspektur->getNamaSatker();?>"  readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>       
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Diterima</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" class="form-control pull-right" id="tanggal_diterima" name="tanggal_diterima" value="<?php echo $tanggal_diterima;?>" readonly="true" placeholder="DD-MM-YYYY">
                        </div>                      
                    </div>
                </div>
            </div>   
        </div>
	</div>
</div>

<div class="row">        
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Nomor Putusan</label>        
            <div class="col-md-8">
                <input type="text" name="no_putusan" id="no_putusan" class="form-control" value="<?php echo $head['no_putusan']; ?>" required data-error="" readonly />
                <div class="help-block with-errors" id="error_custom4"></div>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Dikeluarkan</label>        
            <div class="col-md-8">
                <input type="text" name="diklr" id="diklr" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" required data-error="" readonly />
                <div class="help-block with-errors"></div>
            </div>
        </div>
    </div> 
</div>
<div class="row">  
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal Putusan</label>        
            <div class="col-md-4">
               <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
					<input type="text" class="form-control pull-right" id="tanggal_putusan" name="tanggal_putusan" value="<?php echo $tanggal_putusan;?>" readonly="true" placeholder="DD-MM-YYYY">
					</div>                      
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal Pts Kontra Kasasi</label>        
            <div class="col-md-4">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control <?php echo ($isNewRecord)?'datepicker':''; ?>" id="tanggal_pts_kontrakasasi"  name="tanggal_pts_kontrakasasi" value="<?php echo $tanggal_pts_kontrakasasi;?>" <?php echo ($isNewRecord)?'':'readonly'; ?> placeholder="DD-MM-YYYY" required data-error="Tanggal putusan kontra kasasi belum diisi"/>
                </div>                      
            </div>
			<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom1"></div></div>
        </div>
    </div>  
</div>

<div class="row">  
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Nomor Pts Kontra Kasasi</label>        
            <div class="col-md-8">
                <input type="text" name="no_pts_kontrakasasi" id="no_pts_kontrakasasi" <?php echo ($isNewRecord)?'':'readonly'; ?> class="form-control" value="<?php echo $head['no_pts_kontrakasasi']; ?>" required data-error="Nomor putusan kontra kasasi belum diisi" maxlength="30"  />
                <div class="help-block with-errors" id="error_custom5"></div>
            </div>
        </div>
    </div>
   
</div>

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">    
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active"><a href="#tab-amar" data-toggle="tab">AMAR PUTUSAN KONTRA KASASI</a></li>  
                        </ul>
                    </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-amar">
                                    <textarea class="ckeditor" id="tab_amar" name="tab_amar"><?php echo $head['amar_pts_kontrakasasi']; ?></textarea>
                                    <div class="help-block with-errors" id="error_custom2"></div>
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
				 <?php
					$pathFile 	= Yii::$app->params['pts_kontra_kasasi'].$head['file_pts_kontrakasasi'];
					$cek=($head['file_pts_kontrakasasi'] && file_exists($pathFile))?1:0;
				?>
				<input type="hidden" name="cek_file" id="cek_file" value="<?php echo $cek; ?>">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['pts_kontra_kasasi'].$head['file_pts_kontrakasasi'];
                        $labelFile 	= 'Upload File Putusan Kontra Kasasi';
                        if($head['file_pts_kontrakasasi'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Putusan Kontra Kasasi';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($head['file_pts_kontrakasasi']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($head['file_pts_kontrakasasi'], strrpos($head['file_pts_kontrakasasi'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$head['file_pts_kontrakasasi'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
                    <div class="help-block with-errors" id="error_custom3"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
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
	localStorage.clear();
	var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
	$(".form-buat-pemberi-kuasa").find(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValues[idnya] = idnya;
	});
	localStorage.setItem("formValues", JSON.stringify(formValues));

	/* START AMBIL JPN */
	$(".form-buat-pemberi-kuasa").on("click", "#btn_tambahjpn", function(){
		$("#jpn_modal").find(".modal-body").html("");
		$("#jpn_modal").find(".modal-body").load("/datun/getjpn/index");
		$("#jpn_modal").modal({backdrop:"static"});
	}).on("click", "#btn_hapusjpn", function(){
		var id 		= [];
		var tabel 	= $(".form-buat-pemberi-kuasa").find(".table-jpn-modal");
		tabel.find(".hRowJpn:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-buat-pemberi-kuasa").find(".table-jpn-modal > tbody");
				nRow.append('<tr><td colspan="5">Tidak ada dokumen</td></tr>');
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
	}).on('click', ".pilih-jpn", function(){
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
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'</td>'+
				'<td>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'</td>'+
				'<td>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		}

		$("#cekModalJpn_"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
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
	/* END AMBIL JPN */

	/* START TEMBUSAN */
	$('#tambah-tembusan').click(function(){
		var tabel	= $('#table_tembusan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_tembusan').append(
			'<tr data-id="'+newId+'">' +
			'<td class="text-center"><input type="checkbox" name="chk_del_tembusan[]" class="hRow" id="chk_del_tembusan'+newId+'" value="'+newId+'"></td>'+
			'<td><input type="text" name="no_urut[]" class="form-control input-sm" /></td>' +
			'<td><input type="text" name="nama_tembusan[]" class="form-control input-sm" /> </td>' +
			'</tr>'
		);
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-blue'});
		$('#table_tembusan').find("input[name='no_urut[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusTembusan").click(function(){
		var tabel 	= $("#table_tembusan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END TEMBUSAN */

	/* START AMBIL TTD */
	$("#btn_tambahttd").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/datun/get-ttd/index");
		$("#penandatangan_modal").modal({backdrop:"static"});
	});
	
	$("#penandatangan_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#table-ttd-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	}).on('click', "#idPilihTtdModal", function(){
		var modal = $("#penandatangan_modal").find("#table-ttd-modal");
		var index = modal.find(".pilih-ttd-modal:checked").val();
		var param = index.toString().split('#');
		insertToTtd(param);
		$("#penandatangan_modal").modal("hide");
	});
	function insertToTtd(param){
		$("#penandatangan_status").val(param[0]);
		$("#penandatangan_nip").val(param[1]);
		$("#penandatangan_nama").val(param[2]);
		$("#penandatangan_jabatan").val(param[3]);
		$("#penandatangan_gol").val(param[4]);
		$("#penandatangan_pangkat").val(param[5]);
		$("#penandatangan_ttdjabat").val(param[6]);
		$("#ttdJabatan").val(param[0]+' '+param[6]);
	}
	/* END AMBIL TTD */
});
	
</script>
<?php } ?>