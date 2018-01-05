<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\security\models\User;
	use mdm\admin\models\searchs\Menu as MenuSearch;

	$this->title 	    = 'Putusan';
	$this->subtitle     = 'No Register Perkara : '.$head['no_register_perkara'].' | No Register Bantuan Hukum : '.$head['no_surat'].'';
	$linkBatal		    = '/datun/skk/index';
	$tanggal_skk 	    = ($head['tanggal_skk'])?date('d-m-Y',strtotime($head['tanggal_skk'])):'';
	$tanggal_skks	    = ($head['tanggal_skks'])?date('d-m-Y',strtotime($head['tanggal_skks'])):''; 
	$tanggal_diterima   = ($head['tanggal_diterima'])?date('d-m-Y',strtotime($head['tanggal_diterima'])):'';
	$tanggal_putusan    = ($head['tanggal_putusan'])?date('d-m-Y',strtotime($head['tanggal_putusan'])):'';
	$tanggal_terima_jpn = ($head['tanggal_terima_jpn'])?date('d-m-Y',strtotime($head['tanggal_terima_jpn'])):'';
	$isNewRecord 	    = ($head['no_putusan'])?0:1;
?>

<?php if($_SESSION['no_surat'] && $_SESSION['no_register_perkara']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/putusan/simpan" enctype="multipart/form-data">
	<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-body" style="padding:15px;">
        <div class="row">   
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No. Perkara Perdata</label>        
        			<div class="col-md-8">
                        <input type="text" class="form-control" value="<?php echo $head['no_register_perkara'];?>" id="no_register_perkara" name="no_register_perkara" placeholder="" readonly="true">
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
                        <?php if($isNewRecord){ ?>
                            <select name="no_skk" id="no_skk" style="width:100%;" required data-error="No SKK belum dipilih">
								<?php 
									$sqlOpt1 = "select a.no_register_skk, a.tanggal_skk from datun.skk a 
												where no_register_perkara = '".$_SESSION['no_register_perkara']."' and no_surat = '".$_SESSION['no_surat']."' 
												order by tanggal_skk desc";
									$resOpt1 = User::findBySql($sqlOpt1)->asArray()->all();
									foreach($resOpt1 as $dOpt1){
										$selected = ($dOpt1['no_register_skk'] == $head['no_register_skk']?'selected':'');
										echo '<option '.$selected.' data-tgl="'.date("d-m-Y", strtotime($dOpt1['tanggal_skk'])).'">'.$dOpt1['no_register_skk'].'</option>';
									}
                                  ?>
							</select>
							<?php } else { ?>
							<input type="text" name="no_skk" id="no_skk" class="form-control" value="<?php echo $head['no_register_skk'];?>" readonly /> 
							<?php } ?>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal  SKK</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                             <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
								<?php if($isNewRecord){ ?>
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo ($resOpt1[0]['tanggal_skk'])?date("d-m-Y", strtotime($resOpt1[0]['tanggal_skk'])):'';?>" readonly />
                                <?php } else { ?>
                                <input type="text" name="tanggal_skk" id="tanggal_skk" class="form-control" value="<?php echo $tanggal_skk;?>" readonly /> 
                                <?php } ?>
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
							<input type="text" name="no_skks" id="no_skks" class="form-control" value="<?php echo $head['no_register_skks'];?>" readonly /> 
							<?php } ?>
                    </div>
                </div>
            </div>        
        	<div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal  SKKS</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                             <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
							<?php if($isNewRecord){ ?>
							<input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo ($resOpt2[0]['tanggal_skks'])?date("d-m-Y", strtotime($resOpt2[0]['tanggal_skks'])):'';?>" readonly placeholder="DD-MM-YYYY"  />
							<?php } else { ?>
							<input type="text" name="tanggal_skks" id="tanggal_skks" class="form-control" value="<?php echo $tanggal_skks;?>" readonly placeholder="DD-MM-YYYY" /> 
							<?php } ?>
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
                       	<?php 
								$reg	= $head['no_register_perkara'];
								$cns	= $head['no_surat'];
								$sqlnya = "SELECT b.nama_instansi from datun.permohonan a inner join datun.lawan_pemohon b on a.no_surat=b.no_surat and
											a.no_register_perkara=b.no_register_perkara where a.no_register_perkara='$reg' and a.no_surat='$cns'
											order by no_urut";
								$hasil = User::findBySql($sqlnya)->asArray()->All();
								if(count($hasil) > 1) {
									$datains = $hasil[0]['nama_instansi'].', dkk';
								} else{
									$datains = $hasil[0]['nama_instansi'];
								} 
						?>
								<input type="text" class="form-control" value="<?php echo $datains;?>" id="penggugat" name="penggugat" placeholder="" readonly="true">
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
                    <label class="control-label col-md-4">Dikeluarkan</label>        
                    <div class="col-md-4">
                        <div class="input-group date">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                           <!-- <input type="text" class="form-control pull-right" id="tanggal_diterima" name="tanggal_diterima" value="<?php //echo $tanggal_diterima;?>" readonly="true" placeholder="DD-MM-YYYY"> -->
						    <input type="text" class="form-control" name="diklr" id="diklr" placeholder=""  value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly="true">
							<div class="help-block with-errors"></div>
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
            <label class="control-label col-md-4">Tanggal Putusan TK I</label>        
            <div class="col-md-4">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control datepicker" id="tanggal_putusan"  name="tanggal_putusan" value="<?php echo $tanggal_putusan;?>" placeholder="DD-MM-YYYY"  required data-error="Tanggal Putusan belum diisi"/>
                </div>                      
            </div>
			<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom1"></div></div>
        </div>
    </div>  
	 <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Tanggal Terima JPN</label>        
            <div class="col-md-4">
                <div class="input-group date">
                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                    <input type="text" class="form-control datepicker" id="tanggal_terima_jpn"  name="tanggal_terima_jpn" value="<?php echo $tanggal_terima_jpn;?>" placeholder="DD-MM-YYYY"  required data-error="Tanggal Terima JPN belum diisi"/>
                </div>                      
            </div>
			<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom4"></div></div>
        </div>
    </div>      
</div>

<div class="row">        
   <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Inkracht</label>        
            <div class="col-md-4">
                <div class="input-group date">
                  <input type="checkbox" name="inkrah" id="inkrah" <?php echo ($head['is_inkrah']?'checked':'' ); ?> value="1"/>
                </div>                      
            </div>
			<div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom1"></div></div>
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
                            <li class="active"><a href="#tabtr" data-toggle="tab">ISI PUTUSAN</a></li>  
                        </ul>
                    </div>
                        <div class="panel-body">
                            <div class="tab-content">
                                <div class="tab-pane fade in active" id="tab-amar">
                                    <textarea class="ckeditor" id="tab_amar" name="tab_amar"  > <?php // echo $head['amar_putusan']; ?></textarea>
                                    <div class="help-block with-errors" id="error_custom3"></div>
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
				<?php
					$pathFile 	= Yii::$app->params['putusan'].$head['file_putusan'];
					$cek=($head['file_putusan'] && file_exists($pathFile))?1:0;
				?>
				<input type="hidden" name="cek_file" id="cek_file" value="<?php echo $cek; ?>">
                <input type="file" name="file_template" id="file_template" class="form-inputfile" />   
				<label for="file_template" class="label-inputfile">
                    <?php 
						$pathFile 	= Yii::$app->params['putusan'].$head['file_putusan'];
                        $labelFile 	= 'Upload File Putusan';
                        if($head['file_putusan'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Putusan';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($head['file_putusan']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($head['file_putusan'], strrpos($head['file_putusan'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$head['file_putusan'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" /> 
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan'; //($model->isNewRecord)?'Simpan':'Ubah'; ?></button>
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
	
	//awal tambahan combo skk n skks====================================
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
	/* $(function(){
		$(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});
		$("select#no_skk").change(function(){
			no_skk = $("select#no_skk").val();
			$("#tanggal_skk, #tanggal_skks").val('');
			$("select#no_skks option").remove();
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/hariansidang/getskks'; ?>',
				data	: { q1 : no_skk },
				cache	: false,
				dataType: 'json',
				success : function(data){ 					
					if(data.hasil.items != ""){
						$("select#no_skks").select2({placeholder:"Pilih salah satu", allowClear:true, data:data.hasil.items});
						var tgl_skk	= data.tanggal ;
						if (tgl_skk !=""){
							var tgl		= tgl_skk.toString().split("-");						
							$("#tanggal_skk").val(tgl[2]+'-'+tgl[1]+'-'+tgl[0]);
						}
						return false;
					}
				}
			});
		});
	});
	
	$(function(){
		$("select#no_skks").change(function(){
			var nilai = $(this).val();
			if (nilai==''){
				$("#tanggal_skks").val('');
			} else {
				$.ajax({
					type	: "POST",
					url		: "/datun/hariansidang/gettglskks",
					data	: { q1 : nilai },
					cache	: false,
					dataType: 'json',
					success : function(data){ 
							var tgl_skks	= data.hasil.tanggal_skks ;
							var tgl		= tgl_skks.toString().split("-");
							$("#tanggal_skks").val(tgl[2]+'-'+tgl[1]+'-'+tgl[0]);
					}
				});	
			}
		
		});
	}); */
	//akhir tambahan combo skk n skks====================================
});
	
</script>
<?php } ?>