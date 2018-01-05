<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\Skk;
	$tgl_skk = ($model['tanggal_skk'])?date("d-m-Y", strtotime($model['tanggal_skk'])):'';
	$tgl_tmp = ($model['tanggal_tmp'])?date("d-m-Y", strtotime($model['tanggal_tmp'])):'';
	$tgl_ttd = ($model['tanggal_ttd'])?date("d-m-Y", strtotime($model['tanggal_ttd'])):'';
	$tgl_png = ($model['tanggal_panggilan_pengadilan'])?date("d-m-Y", strtotime($model['tanggal_panggilan_pengadilan'])):'';
	$linkBatal	= '/datun/skks/index';
	$linkCetak	= '/datun/skks/cetak?id='.rawurlencode($model['no_register_skks']);
	$linkCetak_permasalahan	= '/datun/skks/cetak_permasalahan?id='.rawurlencode($model['no_register_skks']);
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/skks/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Pemohon</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Jenis Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="jenis_ins" name="jenis_ins" class="form-control" value="<?php echo $model['jns_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama Instansi/BUMN/BUMD</label>
        			<div class="col-md-8">
            			<input type="text" id="nama_ins" name="nama_ins" class="form-control" value="<?php echo $model['nama_instansi'];?>" readonly />
            		</div>
            	</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Alamat Instansi</label>
        			<div class="col-md-8">
            			<textarea id="alamat_ins" name="alamat_ins" class="form-control" style="height:115px;" readonly><?php echo $model['alamat_instansi'];?></textarea>
					</div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Wilayah</label>
        			<div class="col-md-8">
            			<input type="text" id="wil_ins" name="wil_ins" class="form-control" value="<?php echo $model['wil_instansi'];?>" readonly />
                    </div>
				</div>
			</div>
			<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama</label>
        			<div class="col-md-8">
            			<input type="text" id="pimpinan_ins" name="pimpinan_ins" class="form-control" value="<?php echo $model['pimpinan_pemohon'];?>" readonly />
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
                <h3 class="box-title">Lawan Pemohon</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table3">
                    	<thead>
                        	<tr>
                                <th class="text-center" width="15%">No</th>
                                <th class="text-center" width="85%">Nama</th>
                    		</tr>
						</thead>
                        <tbody>
                        <?php
							$sql2 = "select * from datun.lawan_pemohon where no_register_perkara = '".$model['no_register_perkara']."' and no_surat = '".$model['no_surat']."'
									 order by no_urut";
							$arr2 = Skk::findBySql($sql2)->asArray()->all();
							if(count($arr2) == 0)
								echo '<tr><td colspan="2">Data tidak ditemukan</td></tr>';
							else{
								$nom2 = 0;
								foreach($arr2 as $data2){
									$nom2++;
									echo '<tr><td class="text-center">'.$data2['no_urut'].'</td><td>'.$data2['nama_instansi'].'</td></tr>';
								}
							}
						?>
                        </tbody>
                    </table>
				</div>	
			</div>
		</div>
    </div>

	<div class="col-md-6">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">Panggilan Pengadilan</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Asal Panggilan</label>
                            <div class="col-md-8">
            					<input type="text" id="asal_pengadilan" name="asal_pengadilan" class="form-control" value="<?php echo $model['nama_pengadilan'];?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No Register Perkara</label>
                            <div class="col-md-8">
            					<input type="text" id="no_perkara" name="no_perkara" class="form-control" value="<?php echo $model['no_register_perkara'];?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>        
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Panggilan</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tanggal_panggilan" name="tanggal_panggilan" class="form-control" value="<?php echo $tgl_png;?>" readonly />
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

<div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
    <div class="box-header with-border" style="border-color: #c7c7c7;">
		<h3 class="box-title">Identitas Pemberi Kuasa Substitusi</h3>
	</div>
    <div class="box-body" style="padding:15px;">
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">No SKK/(S)</label>        
        			<div class="col-md-8">
                        <input type="hidden" id="penerima_kuasa_tmp" name="penerima_kuasa_tmp" value="<?php echo $model['penerima_kuasa_tmp'];?>" />
                        <?php if($model['kode_jenis_instansi'] == '01' && $model['penerima_kuasa_tmp'] == 'JA'){ ?>
                        <input type="hidden" id="nomor_tmp" name="nomor_tmp" value="<?php echo $model['no_register_tmp'];?>" />
                        <input type="text" class="form-control" readonly />
                        <?php } else { ?>
                        <input type="text" id="nomor_tmp" name="nomor_tmp" class="form-control" value="<?php echo $model['no_register_tmp'];?>" readonly />
                        <?php } ?>
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Tanggal SKK/(S)</label>        
        			<div class="col-md-4">
        				<div class="input-group">
        					<div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" id="tanggal_tmp" name="tanggal_tmp" class="form-control" value="<?php echo $tgl_tmp;?>" readonly />
        				</div>
        			</div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Nama</label>        
        			<div class="col-md-8">
						<input type="text" id="nama_pemberi" name="nama_pemberi" class="form-control" value="<?php echo $model['nama_pemberi'];?>" readonly />
        			</div>
        		</div>
        	</div>        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Jabatan</label>        
        			<div class="col-md-8">
						<input type="text" id="jabatan_pemberi" name="jabatan_pemberi" class="form-control" value="<?php echo $model['jabatan_pemberi'];?>" readonly />
        			</div>
        		</div>
        	</div>
        </div>
        <div class="row">        
        	<div class="col-md-6">
        		<div class="form-group form-group-sm">
        			<label class="control-label col-md-4">Alamat</label>        
        			<div class="col-md-8">
            			<textarea id="alamat_pemberi" name="alamat_pemberi" class="form-control" style="height:90px;" readonly><?php echo $model['alamat_pemberi'];?></textarea>
        			</div>
        		</div>
        	</div>        
        </div>
	</div>
</div>

<?php /*
<div class="row">        
    <div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">No SKKS</label>        
            <div class="col-md-8">
                <input type="text" id="nomor_skks" name="nomor_skks" class="form-control" value="<?php echo $model['no_register_skks'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="Nomor SKKS belum diisi" maxlength="40"  />
                <div class="help-block with-errors" id="error_custom1"></div>
            </div>
        </div>
    </div> 
	<div class="col-md-6">
        <div class="form-group form-group-sm">
            <label class="control-label col-md-4">Permasalahan/Perkara</label>        
            <div class="col-md-8">
                <textarea id="permasalahan" name="permasalahan" class="form-control" style="height:80px;" readonly><?php echo $model['permasalahan_pemohon'];?></textarea>
                <div class="help-block with-errors" id="error_custom1"></div>
            </div>
        </div>
    </div> 	
</div>
*/ ?>

<div class="row">
	<div class="col-md-5">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-body" style="padding:15px;">
                <div class="row">        
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">No SKKS</label>        
                            <div class="col-md-8">
                                <input type="text" id="nomor_skks" name="nomor_skks" class="form-control" value="<?php echo $model['no_register_skks'];?>" <?php echo (!$isNewRecord)?'readonly':'';?> required data-error="Nomor SKKS belum diisi" maxlength="40"  />
                                <div class="help-block with-errors" id="error_custom1"></div>
                            </div>
                        </div>
                    </div> 
				</div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Dikeluarkan di</label>
                            <div class="col-md-8">
                                <input type="text" id="diklr" name="diklr" class="form-control" value="<?php echo Yii::$app->inspektur->getLokasiSatker()->lokasi;?>" readonly />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Ditandatangani</label>
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" id="tanggal_ttd" name="tanggal_ttd" class="form-control datepicker" placeholder="DD-MM-YYYY" value="<?php echo $tgl_ttd;?>" required data-error="Tanggal tanda tangan belum diisi" />
                                </div>
                            </div>
                            <div class="col-md-offset-4 col-md-8"><div class="help-block with-errors" id="error_custom2"></div></div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
    </div>
	<div class="col-md-7">
        <div class="box box-primary" style="border-color:#f39c12; overflow:hidden;">
            <div class="box-header with-border" style="border-color: #c7c7c7;">
                <h3 class="box-title">Identitas Penerima Kuasa Substitusi</h3>
            </div>
            <div class="box-body" style="padding:15px;">
                <div class="form-buat-pemberi-kuasa">
                	<?php echo $this->render('_formPenerimaKuasa', ['model' => $model, 'isNewRecord'=>$isNewRecord]); ?>
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
					$pathFile 	= Yii::$app->params['skks'].$model['file_skks'];
					$cek=($model['file_skks'] && file_exists($pathFile))?1:0;
				?>
				<input type="hidden" name="cek_file" id="cek_file" value="<?php echo $cek; ?>">
                <input type="file" name="file_skks" id="file_skks" class="form-inputfile" />                    
                <label for="file_skks" class="label-inputfile">
                    <?php 
                        $pathFile 	= Yii::$app->params['skks'].$model['file_skks'];
                        $labelFile 	= 'Upload File SKKS';
                        if($model['file_skks'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File SKKS';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_skks']));
                            $linkPt 	= "/datun/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_skks'], strrpos($model['file_skks'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_skks'].'" style="float:left; margin-right:10px;">
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
<div class="box-footer text-center"> 
    <input type="hidden" id="nomor_skk" name="nomor_skk" value="<?php echo $model['no_register_skk'];?>" />
    <input type="hidden" id="tanggal_skk" name="tanggal_skk" value="<?php echo $tgl_skk;?>" />
    <input type="hidden" id="nomor_surat" name="nomor_surat" value="<?php echo $model['no_surat'];?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan1" name="simpan1"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <?php if(!$isNewRecord && ($model['penerima_kuasa'] != 'JPN' || $model['is_active'])){ ?>
    	<a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a>
    	<a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak_permasalahan;?>"><div class="print" >Cetak Permasalahan</div></a>
	<?php } ?>
    <a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a> 
</div>
</form>
<div class="modal-loading-new"></div>
<div class="modal fade" id="penerima_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Penerima Kuasa</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>
<div class="modal fade" id="jpn_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1100px;">
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
	.print{
		/*font-size: 8px;*/
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	localStorage.clear();
	var formValues = JSON.parse(localStorage.getItem('formValues')) || {};
	$(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValues[idnya] = idnya;
	});
	localStorage.setItem("formValues", JSON.stringify(formValues));
	
	/* START AMBIL PEGAWAI */
	if($("#isNewRecord").val() == "1"){
		$("#frm_modal_penerima_ja").find(".form-control, hidden").val("");
	}
	$("#penerima_kuasa").on("change", function(){
		$("body").addClass("loading");
		var nilai 	= $(this).val();
		var frm_ja 	= $("#frm_modal_penerima_ja");
		var frm_jpn	= $("#frm_modal_penerima_jpn");
		if(nilai == "JPN"){
			frm_ja.addClass('hide').find(".form-control, hidden").val("");
			frm_jpn.removeClass('hide');
		} else{
			frm_jpn.addClass('hide');
			frm_ja.removeClass('hide').find(".form-control, hidden").val("");
			if(nilai == "JAMDATUN"){
				$.ajax({type:"POST", url:"/datun/skks/getpenerimapusat", data:{'q1':nilai}, cache:false, dataType:"json", success:function(data){ 
					if(data.hasil){
						$("#nip_penerima").val(data.hasil.nip);
						$("#nama_penerima").val(data.hasil.nama);
						$("#jabatan_penerima").val(data.hasil.jabatan);
						$("#alamat_penerima").val(data.hasil.alamat);
					}
				}});
			}
		}
		$("body").removeClass("loading");
	});
	$("#btn-cari-peg").on("click", function(){
		var nilai = $("#penerima_kuasa").val();
		console.log(nilai);
		if(nilai){
			$("#penerima_modal").find(".modal-body").load("/datun/skks/getpegawai?tipe="+nilai);
			$("#penerima_modal").modal({backdrop:"static"});
		}
	});
	$("#penerima_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on('hidden.bs.modal', function(e){
		$("#penerima_modal").find(".modal-body").html("");
	}).on('click', ".pilihPeg", function(){
		var id = $(this).data('id');
		getPegawaiModal(id);
	}).on("dblclick", "#modal-tabel-pegawai td:not(.aksinya)", function(){
		var id = $(this).closest("tr").data("id");
		getPegawaiModal(id);
	});
	function getPegawaiModal(id){
		var tm = id.toString().split('#');
		$("#nip_penerima").val(tm[0]);
		$("#nama_penerima").val(tm[1]);
		$("#jabatan_penerima").val(tm[2]);
		$("#alamat_penerima").val(tm[3]);
		$("#penerima_modal").modal("hide");
	}
	/* END AMBIL PEGAWAI */

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
				'<td>'+param[0]+'<br>'+param[1]+'</td>'+
				'<td>'+param[2]+'</td>'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td>'+param[0]+'<br>'+param[1]+'</td>'+
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

});
</script>


