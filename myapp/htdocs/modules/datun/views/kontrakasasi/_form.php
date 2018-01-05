<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\security\models\User;
	use mdm\admin\models\searchs\Menu as MenuSearch;

	$this->title 	= 'Kontra Kasasi';
	// $this->subtitle = 'Kontra Memori Banding';
	// $linkBatal		= '/datun/permohonan/update?id='.rawurlencode($_SESSION['no_register_perkara']).'&ns='.rawurlencode($_SESSION['no_surat']);
	// $linkCetak		= '/datun/sp1/cetak';
	// $tgl_permohonan = date('d-m-Y',strtotime($model['tanggal_permohonan']));
	// $tgl_diterima 	= date('d-m-Y',strtotime($model['tanggal_diterima']));
	// $tgl_pengadilan = date('d-m-Y',strtotime($model['tanggal_panggilan_pengadilan']));
	// $tgl_ttd 		= ($model['tanggal_ttd'])?date('d-m-Y',strtotime($model['tanggal_ttd'])):'';
	// $ttdJabatan 	= $model['penandatangan_status']." ".$model['penandatangan_ttdjabat'];
	// $isNewRecord 	= ($model['no_sp1'])?0:1;
?>

<?php if($_SESSION['no_surat'] && $_SESSION['no_register_perkara']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/sp1/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">   
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No. Perkara Perdata</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Asal Panggilan</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No. SKK</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="" id="" name="" placeholder="" readonly="true">
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
                            <input type="text" id="" name="" class="form-control" value="" readonly />
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
                        <input type="text" class="form-control" value="" id="" name="" placeholder="" readonly="true">
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
                            <input type="text" id="" name="" class="form-control" value="" readonly />
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
                        <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>       
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tergugat</label>        
                    <div class="col-md-8">
                        <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
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
                        <input type="text" class="form-control" value="" id="" placeholder="" readonly="true">
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
                            <input type="text" id="" name="" class="form-control" value="" readonly />
                        </div>                      
                    </div>
                </div>
            </div>   
        </div>
	</div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-body" style="padding:15px;">
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nomor Putusan</label>        
                            <div class="col-md-8">
                                <input type="text" name="" id="" class="form-control" value="" required data-error="" readonly/>
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No. Memori Kasasi</label>        
                            <div class="col-md-8">
                                <input type="text" name="" id="" class="form-control" value="" required data-error="" readonly/>
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Memori Kasasi</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="" name="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
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
                                <input type="text" name="" id="" class="form-control" value="" required data-error="" readonly/>
                                <div class="help-block with-errors" id="error_custom4"></div>
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
                                    <input type="text" id="" name="" class="form-control">
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Kepada Yth.</label>
                            <div class="col-md-8">
                                <textarea id="" name="" class="form-control" style="height:80px;" readonly></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Melalui</label>
                            <div class="col-md-8">
                                <textarea id="" name="" class="form-control" style="height:50px;"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Di -</label>        
                            <div class="col-md-8">
                                <input type="text" name="" id="" class="form-control" value="" required data-error=""/>
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>          
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="box box-primary form-buat-pemberi-kuasa" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color:#c7c7c7; margin:10px 10px 0px;">
                <h3 class="box-title">Jaksa Penuntut Negara (JPN)</h3>
            </div>
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-10"><a class="btn btn-success btn-sm" id="btn_tambahjpn"><i class="fa fa-user-plus jarak-kanan"></i>Tambah JPN</a></div> 
                    <div class="col-sm-2"><div class="text-right"><a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn">Hapus</a></div></div> 
                </div>      
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-jpn-modal">
                        <thead>
                            <tr>
                                <th class="text-center" width="5%">No</th>
                                <th class="text-center" width="40%">Nama</th>
                                <th class="text-center" width="5%"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr data-id="194709101983031002">
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="1">1</span>
                                    <input type="hidden" name="jpnid[]" value="194709101983031002#I WAYAN SUANDRA, S.H.#Jaksa Utama Madya (IV/d)#IV/d#Jaksa Utama Madya#Jaksa Fungsional PENELITIAN">
                                </td>
                                <td class="text-left">I WAYAN SUANDRA, S.H.</td>
                                <td class="text-center">
                                    <div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_1" class="hRowJpn" value="194709101983031002" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                </td>
                            </tr>
                            
                            <tr data-id="195012101977111001">
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="2">2</span>
                                    <input type="hidden" name="jpnid[]" value="195012101977111001#R HIMAWAN KASKAWA, S.H., M.H.#Jaksa Utama (IV/e)#IV/e#Jaksa Utama#Jaksa Fungsional TINDAK PIDANA UMUM">
                                </td>
                                <td class="text-left">R HIMAWAN KASKAWA, S.H., M.H.</td>
                                <td class="text-center">
                                    <div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_2" class="hRowJpn" value="195012101977111001" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="help-block with-errors" id="error_custom1"></div>
            </div>
        </div>          
    </div>
    <div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color:#c7c7c7; margin:10px 10px 0px;">
                <h3 class="box-title">Terbanding 1 / Tergugat 1</h3>
            </div>
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-10"><a class="btn btn-success btn-sm" id=""><i class="fa fa-user-plus jarak-kanan"></i>Tambah Data</a></div> 
                    <div class="col-sm-2"><div class="text-right"><a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn">Hapus</a></div></div> 
                </div>      
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table2">
                        <thead>
                            <tr>
                                <th class="text-center" width="45%">Nama</th>
                                <th class="text-center" width="30%">Jabatan</th>
                                <th class="text-center" width="5%"><div class="icheckbox_square-blue" style="position: relative;"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="help-block with-errors" id="error_custom10"></div>  
            </div>
        </div>
    </div>
</div>

<!-- <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">    
            <div class="col-md-12">
                <div class="panel with-nav-tabs panel-default">
                    <div class="panel-heading single-project-nav">
                        <ul class="nav nav-tabs"> 
                            <li class="active"><a href="#tab-alasan" data-toggle="tab">ALASAN</a></li>  
                            <li><a href="#tab-primair" data-toggle="tab">PRIMAIR </a></li>  
                            <li><a href="#tab-subsidair" data-toggle="tab">SUBSIDAIR</a></li>  
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-alasan">
                                <textarea class="ckeditor" id="tab_alasan" name="" ></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                            <div class="tab-pane fade in" id="tab-primair">
                                <textarea class="ckeditor" id="tab_primair" name="" ></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                            <div class="tab-pane fade in" id="tab-subsidair">
                                <textarea class="ckeditor" id="tab_subsidair" name="" ></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
		
<div class="row">
    <div class="col-md-12">
        <div class="form-group form-group-sm">
            <div class="col-md-12">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['s26'].$model['file_kontra_kasasi'];
                        $labelFile 	= 'Upload File Kontra Kasasi';
                        if($model['file_kontra_kasasi'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Kontra Kasasi';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_kontra_kasasi']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_kontra_kasasi'], strrpos($model['file_kontra_kasasi'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_kontra_kasasi'].'" style="float:left; margin-right:10px;">
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

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer" style="text-align: center;"> 
	<input type="hidden" name="tgl_pengadilan" id="tgl_pengadilan" value="<?php echo $tgl_pengadilan;?>" />
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Jaksa Pengacara Negara</h4>
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