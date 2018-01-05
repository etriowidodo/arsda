<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\security\models\User;
	use mdm\admin\models\searchs\Menu as MenuSearch;

	$this->title 		= 'Nota Dinas';
	$linkBatal			= '/datun/putusan/index';
	$linkCetak			= '/datun/nota-dinas-laporan-principal/cetak';
	$tanggal_putusan 	= date('d-m-Y',strtotime($head['tanggal_putusan']));
	$tanggal_prinsipal 	= ($head['tanggal_prinsipal'])?date('d-m-Y',strtotime($head['tanggal_prinsipal'])):''; 
	$tanggal_nodis 		= ($head['tanggal_nodis'])?date('d-m-Y',strtotime($head['tanggal_nodis'])):'';
	$ttdJabatan 		= $head['penandatangan_status']." ".$head['penandatangan_ttdjabat'];	
    $isNewRecord 		= ($head['nomor_nodis'])?0:1;
?>

<?php if($_SESSION['no_surat'] && $_SESSION['no_register_perkara'] && $_SESSION['no_skks']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/nota-dinas-laporan-principal/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">      
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kepada Yth.</label>        
                    <div class="col-md-8">
                        <textarea id="kepada_yth" name="kepada_yth" class="form-control" style="height:120px;" maxlength="200" placeholder="Kepada"><?php echo $head['kepada_yth']; ?></textarea>
                        <div class="help-block with-errors" id="error_custom4"></div>
                    </div>
                </div>
            </div>      
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Dari</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $head['dari']; ?>" id="dari" name="dari" placeholder="Dari" maxlength="150">
                    </div>
        		</div>
        	</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nomor Prinsipal</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $head['nomor_prinsipal']; ?>" id="nomor_prinsipal" name="nomor_prinsipal" readonly>
                    </div>
        		</div>
        	</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
					<label class="control-label col-md-4">Tanggal Prinsipal</label>
					<div class="col-md-4">
						<div class="input-group">
							<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								 <input type="text" class="form-control pull-right" id="tanggal_prinsipal" name="tanggal_prinsipal" value="<?php echo $tanggal_prinsipal;?>" readonly="true" placeholder="DD-MM-YYYY">
						</div>
					</div>
				  <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors"></div></div>
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
                            <label class="control-label col-md-4">No. Nota Dinas</label>        
                            <div class="col-md-8">
                                <input type="text" name="nomor_nodis" id="nomor_nodis" class="form-control" value="<?php echo $head['nomor_nodis']; ?>" <?php echo ($isNewRecord)?'':'readonly';?> required data-error="Nomor nota dinas belum diisi" maxlength="30" placeholder="Nomor nota dinas">
                                <div class="help-block with-errors" id="error_custom6"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                       <div class="form-group form-group-sm">
							<label class="control-label col-md-4">Tanggal Nodis</label>        
							<div class="col-md-4">
							   <div class="input-group date">
									<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
									<input type="text" class="form-control datepicker" id="tanggal_nodis" name="tanggal_nodis" value="<?php echo $tanggal_nodis;?>" placeholder="DD-MM-YYYY" required data-error="Tanggal nota dinas belum diisi">
								</div>                      
							</div>
							<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom5"></div></div>
						</div>
                    </div>
                </div>
				<div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Sifat</label>        
                            <div class="col-md-8">
                                <select class="form-control select2" id="sifat" name="sifat">
                                    <option></option>
                                    <option value="BIASA" <?php echo ($head['sifat']=='BIASA')?'selected':''; ?> >Biasa</option>
                                    <option value="RAHASIA" <?php echo ($head['sifat']=='RAHASIA')?'selected':''; ?> >Rahasia</option>
                                    <option value="SEGERA" <?php echo ($head['sifat']=='SEGERA')?'selected':''; ?> >Segera</option>
                                    <option value="SANGAT SEGERA" <?php echo ($head['sifat']=='SANGAT SEGERA')?'selected':''; ?> >Sangat Segera</option>
                                </select>
                                <div class="help-block with-errors" id="error_custom4"></div>
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
                            <label class="control-label col-md-4">Lampiran</label>        
                            <div class="col-md-8">
                                <input type="text" name="lampiran" id="lampiran" class="form-control" value="<?php echo $head['lampiran']; ?>" maxlength="10" placeholder="Lampiran">
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Perihal</label>        
                            <div class="col-md-8">
                                <textarea id="perihal" name="perihal" class="form-control" style="height:77px;" maxlength="100" placeholder="Perihal"><?php echo $head['perihal']; ?></textarea>
                                <div class="help-block with-errors" id="error_custom4"></div>
                            </div>
                        </div>
                    </div>    
                </div>
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
                            <li class="active"><a href="#tab-kasus" data-toggle="tab">Kasus Posisi</a></li>  
                            <li><a href="#tab-putusan" data-toggle="tab">Putusan Terhadap Perkara</a></li>  
                            <li><a href="#tab-kesimpulan" data-toggle="tab">Kesimpulan</a></li>   
                        </ul>
                    </div>
                    <div class="panel-body">
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="tab-kasus">
                                <textarea class="ckeditor" id="tab_kasus" name="tab_kasus" ><?php echo $head['kasus_posisi']; ?></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                            <div class="tab-pane fade in" id="tab-putusan">
                                <textarea class="ckeditor" id="tab_putusan" name="tab_putusan" ><?php echo $head['putusan_aquo']; ?></textarea>
                                <div class="help-block with-errors" id="error_custom2"></div>
                            </div>
                            <div class="tab-pane fade in" id="tab-kesimpulan">
                                <textarea class="ckeditor" id="tab_kesimpulan" name="tab_kesimpulan" ><?php echo $head['kesimpulan']; ?></textarea>
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
    <div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusTembusan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-tembusan" title="Tambah Tembusan"><i class="fa fa-plus jarak-kanan"></i>Tembusan</a><br>
                    </div>  
                </div>      
            </div>
            <div class="box-body" style="padding:15px;">
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
                            if($isNewRecord){
                                $sqlx = "select no_urut, tembusan from datun.template_tembusan where kode_template_surat = 'Nodis' order by no_urut";
                                $resx = User::findBySql($sqlx)->asArray()->all();
                            } else{
                                $sqlx = "select no_tembusan as no_urut, deskripsi_tembusan as tembusan from datun.nodis_tembusan 
                                        where nomor_prinsipal = '".$head['nomor_prinsipal']."' and no_putusan = '".$head['no_putusan']."'
                                        and no_register_skks = '".$head['no_register_skks']."' and tanggal_putusan = '".$head['tanggal_putusan']."'
										and nomor_nodis = '".$head['nomor_nodis']."' order by no_tembusan";
                                $resx = User::findBySql($sqlx)->asArray()->all();
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
       <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <div class="row">
                    <div class="col-sm-12">
                        <h3 class="box-title">Penandatangan</h3>
                    </div>  
                </div>      
            </div>
            <div class="box-body" style="padding:15px;">
               <!--  <label class="radio-inline">
                    <input type="radio" name="optradio">Asli
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio">Plt
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio">Plh
                </label>
                <label class="radio-inline">
                    <input type="radio" name="optradio">A.n
                </label>
                <div class="col-md-8" style="padding-top: 10px;">
                    <div class="input-group">
                        <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $head['penandatangan_nip']; ?>" />
						<input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $head['penandatangan_status']; ?>" />
						<input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $head['penandatangan_jabatan'];?>" />														
						<input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $head['penandatangan_gol'];?>" />														
						<input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $head['penandatangan_pangkat'];?>" />														
						<input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $head['penandatangan_ttdjabat'];?>" />
                        <input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $model['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
                        <div class="input-group-btn">
                            <button type="button" class="btn btn-success btn-md" id="btn_tambahttd">Pilih</button>
                        </div>
                    </div>
                    <div class="help-block with-errors" id="error_custom1"></div>
                </div>
				     
                <div class="form-group form-group-sm">
                            <div class="col-md-12">
                            	<input type="text" class="form-control" id="ttdJabatan" name="ttdJabatan" value="<?php echo $ttdJabatan;?>" readonly />
                            </div>				
                 </div>-->
                  
                 <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Penandatangan</label>
                            <div class="col-md-8">
                                <input type="hidden" id="penandatangan_nip" name="penandatangan_nip" value="<?php echo $head['penandatangan_nip']; ?>" />
                                <input type="hidden" id="penandatangan_status" name="penandatangan_status" value="<?php echo $head['penandatangan_status']; ?>" />
                                <input type="hidden" id="penandatangan_jabatan" name="penandatangan_jabatan" value="<?php echo $head['penandatangan_jabatan'];?>" />														
                                <input type="hidden" id="penandatangan_gol" name="penandatangan_gol" value="<?php echo $head['penandatangan_gol'];?>" />														
                                <input type="hidden" id="penandatangan_pangkat" name="penandatangan_pangkat" value="<?php echo $head['penandatangan_pangkat'];?>" />														
                                <input type="hidden" id="penandatangan_ttdjabat" name="penandatangan_ttdjabat" value="<?php echo $head['penandatangan_ttdjabat'];?>" />														
                                <div class="input-group">
                                	<input type="text" class="form-control" id="penandatangan_nama" name="penandatangan_nama" value="<?php echo $head['penandatangan_nama'];?>" placeholder="--Pilih Penanda Tangan--" readonly />
                                	<div class="input-group-btn"><button type="button" class="btn btn-success btn-sm" id="btn_tambahttd" title="Cari">...</button></div>
                                </div>
								<div class="help-block with-errors" id="error_custom7"></div>
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
				<?php
					$pathFile 	= Yii::$app->params['nodis'].$head['file_nodis'];
					$cek=($head['file_nodis'] && file_exists($pathFile))?1:0;
				?>
				<input type="hidden" name="cek_file" id="cek_file" value="<?php echo $cek; ?>">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                <label for="file_template" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['nodis'].$head['file_nodis'];
                        $labelFile 	= 'Upload File Nota Dinas';
                        if($head['file_nodis'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Nota Dinas';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($head['file_nodis']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($head['file_nodis'], strrpos($head['file_nodis'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$head['file_nodis'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="no_putusan" id="no_putusan" value="<?php echo $head['no_putusan'];?>" />
	<input type="hidden" name="tanggal_putusan" id="tanggal_putusan" value="<?php echo $tanggal_putusan;?>" />
	<input type="hidden" name="no_register_perkara" id="no_register_perkara" value="<?php echo $head['no_register_perkara'];?>" />
	<input type="hidden" name="no_register_skks" id="no_register_skks" value="<?php echo $head['no_register_skks'];?>" />
	<input type="hidden" name="no_surat" id="no_surat" value="<?php echo $head['no_surat'];?>" />
	<input type="hidden" name="kode_jenis_instansi" id="kode_jenis_instansi" value="<?php echo $head['kode_jenis_instansi'];?>" >
    <input type="hidden" name="kode_instansi" id="kode_instansi" value="<?php echo $head['kode_instansi'];?>" >
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a>
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