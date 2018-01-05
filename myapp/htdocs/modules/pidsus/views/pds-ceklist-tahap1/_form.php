<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\P16;

	$this->title = "Pendapat";
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutan();
	$whereDefault 	= "a.id_kejati = '".$_SESSION["kode_kejati"]."' and a.id_kejari = '".$_SESSION["kode_kejari"]."' and a.id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and a.no_spdp = '".$_SESSION["no_spdp"]."' and a.tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/pds-ceklist-tahap1/index';
	$linkCetak		= '/pidsus/pds-ceklist-tahap1/cetak';
	$tgl_berkas 	= ($model['tgl_berkas'])?date('d-m-Y',strtotime($model['tgl_berkas'])):'';
	$tgl_pengantar 	= ($model['tgl_pengantar'])?date('d-m-Y',strtotime($model['tgl_pengantar'])):'';
	$tgl_mulai 		= ($model['tgl_mulai'])?date('d-m-Y',strtotime($model['tgl_mulai'])):'';
	$tgl_selesai 	= ($model['tgl_selesai'])?date('d-m-Y',strtotime($model['tgl_selesai'])):'';
	$pendapat1 		= $model['pendapat_jaksa'];
	$pendapat2 		= $model['pendapat_jaksa_tdk_lngkp'];
	$pendapat3 		= explode(",", $model['pendapat_jaksa_tdk_lngkp_alsn']);
?>

<?php if($_SESSION['no_spdp'] && $_SESSION['tgl_spdp']){ ?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-ceklist-tahap1/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="box box-primary">
    <div class="box-body">
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nomor Berkas</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_berkas" id="no_berkas" class="form-control" value="<?php echo $model['no_berkas'];?>" readonly />    
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
                            <input type="text" name="tgl_berkas" id="tgl_berkas" class="form-control" value="<?php echo $tgl_berkas;?>" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">No Surat Pengantar</label>        
                    <div class="col-md-8">
                        <input type="text" name="no_pengantar" id="no_pengantar" class="form-control" readonly=""value="<?php echo $model['no_pengantar'];?>" />    
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tanggal Surat Pengantar</label>        
                    <div class="col-md-4">
                        <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_pengantar" id="tgl_pengantar" class="form-control" value="<?php echo $tgl_pengantar;?>" readonly />
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Jaksa Peneliti</label>        
                    <div class="col-md-8">
                        <select id="pilih_jaksa" name="pilih_jaksa" class="select2" style="width:100%;" required data-error="Jaksa Peneliti belum dipilih">
                            <option></option>
                            <?php 
                                $sql = "
                                    select a.id_kejati, a.id_kejari, a.id_cabjari, a.no_spdp, a.tgl_spdp, a.no_p16, b.nip, b.no_urut, b.nama, b.gol_jaksa, 
                                    b.pangkat_jaksa, b.jabatan_jaksa 
                                    from pidsus.pds_terima_berkas a 
                                    join pidsus.pds_p16_jaksa b on a.id_kejati = b.id_kejati and a.id_kejari = b.id_kejari and a.id_cabjari = b.id_cabjari 
                                        and a.no_spdp = b.no_spdp and a.tgl_spdp = b.tgl_spdp and a.no_p16 = b.no_p16
                                    where ".$whereDefault." and a.no_berkas = '".$model['no_berkas']."' order by b.no_urut";
                                $jns = P16::findBySql($sql)->asArray()->all();
                                foreach($jns as $ji){
                                    $selected = ($ji['nip'] == $model['nip_ttd'])?'selected':'';
                                    $nilainya = $ji['nip'].'|#|'.$ji['nama'].'|#|'.$ji['gol_jaksa'].'|#|'.$ji['pangkat_jaksa'].'|#|'.$ji['jabatan_jaksa'];
                                    echo '<option value="'.$nilainya.'" '.$selected.'>'.$ji['nama'].'</option>';
                                }
                            ?>
                        </select>
                        <input type="hidden" name="nip_ttd" id="nip_ttd" value="<?php echo $model['nip_ttd'];?>" />
                        <input type="hidden" name="nama_ttd" id="nama_ttd" value="<?php echo $model['nama_ttd'];?>" />
                        <input type="hidden" name="gol_ttd" id="gol_ttd" value="<?php echo $model['gol_ttd'];?>" />
                        <input type="hidden" name="pangkat_ttd" id="pangkat_ttd" value="<?php echo $model['pangkat_ttd'];?>" />
                        <input type="hidden" name="jabatan_ttd" id="jabatan_ttd" value="<?php echo $model['jabatan_ttd'];?>" />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>        
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Waktu Penelitian</label>        
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-5" style="padding-right:0px;">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_mulai" id="tgl_mulai" class="form-control datepicker" value="<?php echo $tgl_mulai;?>" placeholder="DD-MM-YYYY" />
                                </div>
                            </div>
                            <div class="col-md-2" style="padding:0px;">
                                <div class="input-group"><div class="input-group-addon" style="font-size:12px; border:none; padding:">s/d</div></div>
                            </div>
                            <div class="col-md-5" style="padding-left:0px;">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_selesai" id="tgl_selesai" class="form-control datepicker" value="<?php echo $tgl_selesai;?>" placeholder="DD-MM-YYYY" />
                                </div>
                            </div>
                        </div>
                        <div class="help-block with-errors" id="error_custom_waktu_penelitian"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>			

<div class="box box-primary form-buat-pengantar">
    <div class="box-header with-border">
        <h3 class="box-title">Pendapat Jaksa Peneliti</h3>
    </div>
    <div class="box-body">
        <label class="radio" for="pendapat_jaksa1">
        	<input type="radio" name="pendapat_jaksa" id="pendapat_jaksa1" value="1" <?php echo ($pendapat1 == 1)?'checked':'';?> />Hasil penyidikan sudah lengkap perlu dilanjutkan penyerahan tanggung jawab atas Tersangka dan Barang Bukti, untuk segera menentukan apakah perkara itu sudah memenuhi persyaratan untuk dapat atau tidak dilimpahkan ke Pengadilan.
		</label>
        <label class="radio" for="pendapat_jaksa2">
        	<input type="radio" name="pendapat_jaksa" id="pendapat_jaksa2" value="2" <?php echo ($pendapat1 == 2)?'checked':'';?> />Hasil penyidikan belum lengkap 
		</label>
        <div class="tdklkp"<?php echo(!$pendapat1 || $pendapat1 == 1)?' style="display:none;"':'';?>>
            <label class="radio" for="pendapat_jaksa_tdk_lngkp1">
                <input type="radio" name="pendapat_jaksa_tdk_lngkp" id="pendapat_jaksa_tdk_lngkp1" value="1" <?php echo ($pendapat2 == 1)?'checked':'';?> />Kebutuhan Perkara
            </label>
            <div class="tdklkpalsn"<?php echo($pendapat2 != 1)?' style="display:none;"':'';?>>
                <label class="checkbox" style="padding:0 0 5px;">
                    <input type="checkbox" name="pendapat_jaksa_tdk_lngkp_alsn[]" id="pendapat_jaksa_tdk_lngkp_alsn1" value="1" <?php echo (in_array("1", $pendapat3))?'checked':'';?> /><span>Perkara Perlu di Split</span>
                </label>
                <label class="checkbox" style="padding:0 0 5px;">
                    <input type="checkbox" name="pendapat_jaksa_tdk_lngkp_alsn[]" id="pendapat_jaksa_tdk_lngkp_alsn2" value="2" <?php echo (in_array("2", $pendapat3))?'checked':'';?> /><span>Perlu Saksi Ahli</span>
                </label>
                <label class="checkbox" style="padding:0 0 5px;">
                    <input type="checkbox" name="pendapat_jaksa_tdk_lngkp_alsn[]" id="pendapat_jaksa_tdk_lngkp_alsn3" value="3" <?php echo (in_array("3", $pendapat3))?'checked':'';?> /><span>Perlu Saksi A. Charge</span>
                </label>        	
                <label class="checkbox" style="padding:0 0 5px;">
                    <input type="checkbox" name="pendapat_jaksa_tdk_lngkp_alsn[]" id="pendapat_jaksa_tdk_lngkp_alsn4" value="4" <?php echo (in_array("4", $pendapat3))?'checked':'';?> /><span>Perlu Alat Bukti Lain</span>
                </label>
            </div>
            <label class="radio" for="pendapat_jaksa_tdk_lngkp2">
                <input type="radio" name="pendapat_jaksa_tdk_lngkp" id="pendapat_jaksa_tdk_lngkp2" value="2" <?php echo ($pendapat2 == 2)?'checked':'';?> />Perkara Koneksitas
            </label>
            <label class="radio" for="pendapat_jaksa_tdk_lngkp3">
                <input type="radio" name="pendapat_jaksa_tdk_lngkp" id="pendapat_jaksa_tdk_lngkp3" value="3" <?php echo ($pendapat2 == 3)?'checked':'';?> />
                Termasuk Wewenang PN Lain 
            </label>        	
            <label class="radio" for="pendapat_jaksa_tdk_lngkp4">
                <input type="radio" name="pendapat_jaksa_tdk_lngkp" id="pendapat_jaksa_tdk_lngkp4" value="4" <?php echo ($pendapat2 == 4)?'checked':'';?> />Hasil penyidikan sudah optimal tetapi secara material belum terpenuhi, diberikan petunjuk barang bukti dan tersangka agar diserahkan untuk diadakan pemeriksaan tambahan, berdasar pasal 27 ayat 1 (d) UU Nomor 16 tahun 2004.
            </label>
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
                        $pathFile 	= Yii::$app->params['ceklist'].$model['file_upload_ceklist'];
                        $labelFile 	= 'Unggah File Ceklist';
                        if($model['file_upload_ceklist'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah File Ceklist';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_ceklist']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_ceklist'], strrpos($model['file_upload_ceklist'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_ceklist'].'" style="float:left; margin-right:10px;">
                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                        }
                    ?>
                    <div class="input-group">
                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                        <input type="text" class="form-control" readonly />
                    </div>
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
	.iradio-pidsus{
		position: absolute !important;
		left: 0px;
		top: 3px;
	}
	.form-horizontal label.radio,
	.form-horizontal label.checkbox{
		cursor: pointer;
	}
	.form-horizontal label.radio{
		padding:0 0 5px 25px;
	}
	.tdklkp, .tdklkpalsn{
		padding-left: 25px;
	}
	.tdklkpalsn span{
		margin-left: 7px;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
    $("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-pink iradio-pidsus'});
	
	$("input[name='pendapat_jaksa']").on('ifChecked',function(){
        var nilai = $(this).val();
        if(nilai == '2'){
			console.log($(".tdklkp"));
            $(".tdklkp").slideDown();
        }else{
            $(".tdklkp").slideUp();
            $("input[name='pendapat_jaksa_tdk_lngkp'], input[name='pendapat_jaksa_tdk_lngkp_alsn[]']").iCheck("uncheck");
        }
    });
    
	$("input[name='pendapat_jaksa_tdk_lngkp']").on('ifChecked',function(){
        var nilai = $(this).val();
        if(nilai == '1'){
            $(".tdklkpalsn").slideDown();
        }else{
            $(".tdklkpalsn").slideUp();
            $("input[name='pendapat_jaksa_tdk_lngkp_alsn[]']").iCheck("uncheck");
        }
    });
    
    $("#pilih_jaksa").on("change", function(e){
        var id = $(this).val();
		var tm = id.toString().split('|#|');
        $("#nip_ttd").val(tm[0]);
        $("#nama_ttd").val(tm[1]);
        $("#gol_ttd").val(tm[2]);
        $("#pangkat_ttd").val(tm[3]);
        $("#jabatan_ttd").val(tm[4]);
    });
});	
</script>
<?php } ?>