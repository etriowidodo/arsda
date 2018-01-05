<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsPidsus12Khusus;

        $this->title = 'Pidsus-12 Khusus';
	$this->subtitle = 'Nota Dinas Pemberitahuan Dimulainya Penyidikan';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' and a.no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."'";
        if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus a where ".$whereDefault;
		$model 	= PdsPidsus12Khusus::findBySql($sqlCek)->asArray()->one();
	}
	$linkBatal 		= '/pidsus/pds-pidsus-12-khusus/index';
	$linkCetak 		= '/pidsus/pds-pidsus-12-khusus/cetak?id1='.$model['no_p8_khusus'];
        $linkHapus 		= '/pidsus/pds-pidsus-12-khusus/hapusdata?id1='.rawurlencode($model['no_pidsus18']).'&id2='.rawurlencode($model['no_p8_khusus']).'&id3='.rawurlencode($model['no_pidsus12_khusus']);
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
	$tgl_p8_khusus 	= ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_pidsus12_khusus 	= ($model['tgl_pidsus12_khusus'])?date('d-m-Y',strtotime($model['tgl_pidsus12_khusus'])):'';
?>


<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-pidsus-12-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor P-8 Khusus</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_p8_khusus" id="no_p8_khusus" class="form-control" value="<?php echo $model['no_p8_khusus'];?>" readonly />
                                <div class="help-block with-errors" id="error_custom_no_p8_khusus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal P-8 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_p8_khusus" id="tgl_p8_khusus" class="form-control" value="<?php echo $tgl_p8_khusus;?>" readonly />
                                </div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Pidsus-12 Khusus</label>        
                            <div class="col-md-8">
                                <input type="text" name="no_pidsus12_khusus" id="no_pidsus12_khusus" class="form-control" value="<?php echo $model['no_pidsus12_khusus'];?>" required data-error="Nomor Pidsus 12 Khusus belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_pidsus12_khusus"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Pidsus-12 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_pidsus12_khusus" id="tgl_pidsus12_khusus" class="form-control datepicker" value="<?php echo $tgl_pidsus12_khusus;?>" required data-error="Tanggal Pidsus-12 Khusus belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_pidsus12_khusus"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Lampiran</label>        
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $model['lampiran'];?>" maxlength="30" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary form-buat-tersangka">
    <div class="box-header with-border">
        <h3 class="box-title">Tersangka</h3>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table class="table table-bordered table-hover" id="tableTsk">
                <thead>
                    <tr>
                        <th class="text-center" width="5%">No</th>
                        <th class="text-center" width="45%">Nama</th>
                        <th class="text-center" width="45%">Tempat, Tanggal lahir</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                    $sqlTsk = "
                    select a.*, b.nama as kebangsaan from pidsus.pds_pidsus18_tersangka a
                    left join public.ms_warganegara b on a.warganegara = b.id
                    where ".$whereDefault." order by a.no_urut_tersangka";
                    $resTsk = ($_SESSION["pidsus_no_pidsus18"])? PdsPidsus12Khusus::findBySql($sqlTsk)->asArray()->all():array();
                    if(count($resTsk) == 0)
                        echo '<tr class="barisTsk"><td colspan="4">Data tidak ditemukan</td></tr>';
                    else{
                        foreach($resTsk as $dtTsk){
                            $nomTsk = $dtTsk['no_urut_tersangka'];
                            echo '
                            <tr data-id="'.$nomTsk.'" class="barisTsk">
                                <td class="text-center"><span class="frmnotsk" data-row-count="'.$nomTsk.'">'.$nomTsk.'</span></td>
                                <td class="text-left">'.$dtTsk['nama'].'</td>
                                <td class="text-left">'.$dtTsk['tmpt_lahir'].'/ '.date('d-m-Y',strtotime($dtTsk['tgl_lahir'])).'</td>
                            </tr>';
                        }
                    }
                 ?>	
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-tembusan" title="Tambah Tembusan"><i class="fa fa-plus jarak-kanan"></i>Tembusan</a><br>
                    </div>	
                </div>		
            </div>
            <div class="box-body">
                <div class="table-responsive">
                    <table id="table_tembusan" class="table table-bordered">
                        <thead>
							<tr>
                                <th width="10%"></th>
                                <th width="15%">No Urut</th>
                                <th width="75%">Tembusan</th>
							</tr>
                        </thead>
                        <tbody>
                        <?php
                        	if($model['no_pidsus12_khusus'] == ''){
                        		$sqlx = "select no_urut, tembusan from pidsus.ms_template_surat_tembusan where kode_template_surat = 'Pidsus-12-Khusus' order by no_urut";
                        		$resx = PdsPidsus12Khusus::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, tembusan from pidsus.pds_pidsus12_khusus_tembusan a
                                                where ".$whereDefault." and a.no_pidsus12_khusus = '".$model['no_pidsus12_khusus']."' order by no_urut";
                        		$resx = PdsPidsus12Khusus::findBySql($sqlx)->asArray()->all();
                        	}
                        	$no = 1;
							foreach($resx as $datx):
						?>
                        	<tr data-id="<?php echo $no;?>">
                        		<td class="text-center">
                                <input type="checkbox" name="chk_del_tembusan[]" id="<?php echo 'chk_del_tembusan'.$no;?>" class="hRow" value="<?php echo $no;?>" /></td>
                        		<td><input type="text" name="no_urut[]" class="form-control input-sm" value="<?php echo $datx['no_urut'];?>" /></td>
                        		<td><input type="text" name="nama_tembusan[]" class="form-control input-sm"  value="<?php echo $datx['tembusan'];?>" /></td>
                        	</tr>
                        <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>			
	</div>
	<div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Penandatangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $model['penandatangan_nip']; ?>" />
                                <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $model['penandatangan_jabatan_pejabat'];?>" />														
                                <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $model['penandatangan_gol'];?>" />														
                                <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $model['penandatangan_pangkat'];?>" />														
                                <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $model['penandatangan_status_ttd']; ?>" />
                                <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $model['penandatangan_jabatan_ttd'];?>" />														
                                <div class="input-group">
                                	<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penandatangan--" readonly />
                                	<div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
                                </div>
								<div class="help-block with-errors" id="error_custom_penandatangan"></div>
                            </div>				
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-offset-4 col-md-8">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                            	<input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
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
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['pidsus_12khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah Pidsus-12';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah Pidsus-12';
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
					<h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 2Mb]</h6>
                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                </label>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?>
    	<a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a>
        <a class="btn btn-danger jarak-kanan" href="<?php echo $linkHapus;?>">Hapus</a>
    <?php } ?>
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

<div class="modal fade" id="p8_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Daftar P-8 Khusus</h4>
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
    /* START AMBIL P-8 */
	$("#pilih_p8").on('click', function(e){
		$("#p8_modal").find(".modal-body").html("");
		$("#p8_modal").find(".modal-body").load("/pidsus/get-p8-khusus");
		$("#p8_modal").modal({backdrop:"static"});
	});
	$("#p8_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-p8-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		$("#no_p8_khusus").val(decodeURIComponent(param[0]));
		$("#tgl_p8_khusus").val(decodeURIComponent(param[1]));
		$("#p8_modal").modal("hide");
	}).on('click', "#idPilihP8Modal", function(){
		var modal = $("#p8_modal").find("#tabel-p8-modal");
		var index = modal.find(".pilih-p8-modal:checked").val();
		var param = index.toString().split('|#|');
		$("#no_p8_khusus").val(decodeURIComponent(param[0]));
                $("#tgl_p8_khusus").val(decodeURIComponent(param[1]));
		$("#p8_modal").modal("hide");
	}).on('click','#idBatalP8Modal', function(){
		$("#p8_modal").modal("hide");
	});
	/* END AMBIL P-6 */
        
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
		$("#chk_del_tembusan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
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
	$("#btn_tambahttd, #penandatangan_nama, #ttdJabatan").on('click', function(e){
		$("#penandatangan_modal").find(".modal-body").html("");
		$("#penandatangan_modal").find(".modal-body").load("/pidsus/get-ttd/index");
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