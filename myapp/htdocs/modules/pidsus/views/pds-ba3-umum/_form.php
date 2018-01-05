<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsBa3Umum;

	$this->title 	= 'BA-3 Umum';
	$this->subtitle = 'Berita Acara Pengambilan Sumpah/ Janji Orang Ahli';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-ba3-umum/index';
	$linkCetak		= '/pidsus/pds-ba3-umum/cetak?id1='.rawurlencode($model['no_ba3_umum']);
	if($isNewRecord){
		$sqlCek = "select no_p8_umum, tgl_p8_umum from pidsus.pds_p8_umum where ".$whereDefault;
		$model 	= PdsBa3Umum::findBySql($sqlCek)->asArray()->one();
	}
	$tgl_p8_umum 	= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_ba3_umum 	= ($model['tgl_ba3_umum'])?date('d-m-Y',strtotime($model['tgl_ba3_umum'])):'';
	$tgl_lahir 		= ($model['tgl_lahir'])?date('d-m-Y',strtotime($model['tgl_lahir'])):'';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-ba3-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal/Jam BA-3 Umum</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_ba3_umum" id="tgl_ba3_umum" class="form-control datepicker" value="<?php echo $tgl_ba3_umum;?>" required data-error="Tanggal/Jam BA-3 Umum belum diisi" />
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                                    <input type="text" name="jam_ba3_umum" id="jam_ba3_umum" class="form-control timepicker" value="<?php echo $model['jam_ba3_umum']; ?>" required data-error="Tanggal/Jam BA-3 Umum belum diisi" />
                                </div>
                            </div>
							<div class="help-block with-errors col-md-8 col-md-offset-4" id="error_custom_tgl_ba3_umum"></div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tempat</label>        
                            <div class="col-md-8">
                                <input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo $model['tempat'];?>" required data-error="Tempat belum diisi" maxlength="200" />
                                <div class="help-block with-errors"></div>
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
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Jaksa Penyidik</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama</label>        
                            <div class="col-md-8">
                                <select name="nama_jaksa_penyidik" id="nama_jaksa_penyidik" class="select2" style="width:100%" required data-error="Nama Jaksa belum dipilih">
                                    <option></option>
                                    <?php
										$sqlOpt1 = "select nip_jaksa as idnya, nama_jaksa as namanya, pangkat_jaksa||' ('||gol_jaksa||')' as pangkatnya 
											from pidsus.pds_p8_umum_jaksa where ".$whereDefault;
										$resOpt1 = PdsBa3Umum::findBySql($sqlOpt1)->asArray()->all();
                                        foreach($resOpt1 as $datOpt1){
                                            $selected = ($datOpt1['idnya'] == $model['nip_jaksa'])?'selected':'';
                                            echo '<option value="'.$datOpt1['idnya'].'" data-pangkat="'.$datOpt1['pangkatnya'].'" '.$selected.'>'.$datOpt1['namanya'].'</option>';
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
                            <label class="control-label col-md-4">Pangkat</label>        
                            <div class="col-md-8">
                                <input type="text" name="pangkat_jaksa" id="pangkat_jaksa" class="form-control" value="<?php echo $model['pangkat_jaksa'];?>" readonly  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">NIP</label>        
                            <div class="col-md-8">
                                <input type="hidden" name="nama_jaksa" id="nama_jaksa" value="<?php echo $model['nama_jaksa'];?>"  /> 
                                <input type="text" name="nip_jaksa" id="nip_jaksa" class="form-control" value="<?php echo $model['nip_jaksa'];?>" readonly  /> 
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Ahli</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama</label>        
                    <div class="col-md-8">
                        <div class="input-group input-group-sm">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" required data-error="Kolom [Nama] belum dipilih" />
                            <span class="input-group-btn"><button class="btn" type="button" id="pilih_saksi"><i class="fa fa-search"></i></button></span>
                        </div>
                        <div class="help-block with-errors" id="error_custom_nama"></div>
                        <?php /*
                        <select name="nama" id="nama" class="select2" style="width:100%" required data-error="Nama Saksi belum dipilih">
                            <option></option>
                            <?php 
                                $sqlOpt2 = "select nama from pidsus.pds_pidsus14_umum_saksi where ".$whereDefault;
								$resOpt2 = PdsBa3Umum::findBySql($sqlOpt2)->asArray()->all();
								foreach($resOpt2 as $datOpt2){
									$selected = ($datOpt2['nama'] == $model['nama'])?'selected':'';
									echo '<option value="'.$datOpt2['nama'].'" '.$selected.'>'.$datOpt2['nama'].'</option>';
								}
                            ?>
                        </select> */ ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-2">Tempat Lahir</label>
                    <div class="col-md-4">
                        <input type="text" name="tmpt_lahir" id="tmpt_lahir" class="form-control chars-only" value="<?php echo $model["tmpt_lahir"];?>" />
                    </div>
                    <label class="control-label col-md-2">Tanggal Lahir</label>
                    <div class="col-md-4">
                         <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker"  value="<?php echo $tgl_lahir;?>" required data-error="Tanggal Lahir belum diisi" />
							<div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>
							<input type="text" name="umur" id="umur" class="form-control" style="width:60px;" value="<?php echo ($model["umur"]?$model["umur"]:'')?>" />
						</div>
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
                        <input type="radio" name="id_jkl" id="id_jkl1" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> />
                        <label for="id_jkl1" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="id_jkl" id="id_jkl2" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> />
                        <label for="id_jkl2" class="control-label">Perempuan</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                        <input type="hidden" name="warganegara" id="warganegara" value="<?= $model["warganegara"]?>"/>
                        <input type="text" name="kebangsaan" id="kebangsaan" class="form-control" value="<?= $model["kebangsaan"]?>" placeholder="-Pilih Kewarganegaraan-"/>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Tinggal</label>
                    <div class="col-md-8">
                        <textarea name="alamat" id="alamat" class="form-control" style="height:75px"><?php echo $model["alamat"];?></textarea>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                	<div class="col-sm-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Agama</label>
                            <div class="col-md-8">
                                <select id="id_agama" name="id_agama" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                         $agm = PdsBa3Umum::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
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
                	<div class="col-sm-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pekerjaan</label>        
                            <div class="col-md-8">
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pendidikan</label>
                                <div class="col-md-8">
                                    <select id="pendidikan" name="pendidikan" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                        $pdd = PdsBa3Umum::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                        foreach($pdd as $pd){
                                            $selected = ($pd['id_pendidikan'] === $model['id_pendidikan'])?'selected':'';
                                            echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                        }
                                    ?>
                                </select>
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
        <div class="box box-primary form-yang-menyaksikan">
            <div class="box-header with-border">
                <h3 class="box-title">Yang Menyaksikan</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm disabled" id="btn_hapusjpn"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="btn_popusul"><i class="fa fa-user-plus jarak-kanan"></i>Yang Menyaksikan</a>
                    </div>		
                </div><br/>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-jpn-modal">
                        <thead>
                            <tr>
                                <th class="text-center" width="8%"><input type="checkbox" name="allCheckJpn" id="allCheckJpn" class="allCheckJpn" /></th>
                                <th class="text-center" width="8%">#</th>
                                <th class="text-center" width="42%">Nama / NIP</th>
                                <th class="text-center" width="42%">Pangkat / Jabatan</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
							$sqlnya = "select * from pidsus.pds_ba3_umum_saksi where ".$whereDefault." and no_ba3_umum = '".$model['no_ba3_umum']."' order by no_urut_saksi";
                            $hasil 	= ($model['no_ba3_umum'])?PdsBa3Umum::findBySql($sqlnya)->asArray()->all():array();
                            if(count($hasil) == 0)
                                echo '<tr><td colspan="4">Data tidak ditemukan</td></tr>';
                            else{
                                $nom = 0;
                                foreach($hasil as $data){
                                    $nom++;	
                                    $idJpn = $data['nip']."#".$data['nama']."#".$data['pangkat']."#".$data['jabatan'];
                         ?>	
                              <tr data-id="<?php echo $data['nip'];?>">
                                <td class="text-center">
                                    <input type="checkbox" name="cekModalJpn[]" id="<?php echo 'cekModalJpn_'.$nom;?>" class="hRowJpn" value="<?php echo $data['nip'];?>" />
                                </td>
                                <td class="text-center">
                                    <span class="frmnojpn" data-row-count="<?php echo $nom;?>"><?php echo $nom;?></span>
                                    <input type="hidden" name="jpnid[]" value="<?php echo $idJpn;?>" />
                                </td>
                                <td class="text-left"><?php echo $data['nip'].'<br />'.$data['nama'];?></td>
                                <td class="text-left"><?php echo $data['pangkat'].'<br />'.$data['jabatan'];?></td>
                             </tr>
                         <?php } } ?>
                        </tbody>
                    </table>
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
                        $pathFile 	= Yii::$app->params['ba3_umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah BA-3 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah BA-3 Umum';
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
	<input type="hidden" name="no_p8_umum" id="no_p8_umum" value="<?php echo $model['no_p8_umum'];?>" />
    <input type="hidden" name="tgl_p8_umum" id="tgl_p8_umum" value="<?php echo $tgl_p8_umum;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <input type="hidden" name="no_ba3_umum" id="no_ba3_umum" value="<?php echo $model['no_ba3_umum']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

<!--<div class="row">
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama Tersangka</label>        
                            <div class="col-md-8">
                                <select name="nama_tsk" id="nama_tsk" class="select2" style="width:100%">
                                    <option></option>
                                    
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Jaksa Penyidik</label>        
                            <div class="col-md-8">
                                <select name="jp" id="jp" class="select2" style="width:100%">
                                    <option></option>
                                    
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>			
    </div>
</div>-->

<div class="modal fade" id="tambah_usul_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Yang Menyaksikan Sumpah</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
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

<div class="modal fade" id="list_saksi_modal" role="dialog" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">List Ahli</h4>
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
	$("#pilih_saksi").on("click", function(){
		$("#list_saksi_modal").find(".modal-body").html("");
		$("#list_saksi_modal").find(".modal-body").load("/pidsus/pds-ba3-umum/getlistsaksi?perihal=Ahli");
		$("#list_saksi_modal").modal({backdrop:"static", keyboard:false});
	});
        
	$("#list_saksi_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#table-pds14u-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('#');
		$("#nama").val(decodeURIComponent(param[0]));
		$("#list_saksi_modal").modal("hide");
	}).on('click', ".pilih-pds14u", function(){
		var tabel = $("#table-pds14u-modal");
		tabel.find(".selection_one_saksi:checked").each(function(k, v){
			var index = $(v).val();
			var param = index.toString().split('#');
			$("#nama").val(decodeURIComponent(param[0]));
		});
		$("#list_saksi_modal").modal("hide");
	});

	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
	$("#jam_ba3_umum").on('focus', function(){
		$(this).prev().trigger('click');
	});

	$("#nama_jaksa_penyidik").on("change", function(){
		var nilai 	= $(this).val();
		var pangkat = $("#nama_jaksa_penyidik option:selected").data("pangkat");
		var nama 	= $(this).select2('data');
		if(nilai != ""){
			$("#nip_jaksa").val(nilai);
			$("#nama_jaksa").val(nama[0].text);
			$("#pangkat_jaksa").val(pangkat);
		} else{
			$("#nip_jaksa, #nama_jaksa, #pangkat_jaksa").val("");
		}
	});

    $("#tgl_lahir").on('change',function (){
        var tgl = $('#tgl_lahir').val();
        var str = tgl.split('-');
        var firstdate=new Date(str[2],str[1],str[0]);
        var tglSkr ='<?php echo date("d-m-Y");?>';

        var start = tglSkr.split('-');
        var Endate=new Date(start[2],start[1],start[0]);
        var today = new Date(Endate);
        var dayDiff = Math.ceil(today.getTime() - firstdate.getTime()) / (1000 * 60 * 60 * 24 * 365);
        var age = parseInt(dayDiff);
        $('#umur').val(age);
    });

	/* START WARGANEGARA */
	$("#kebangsaan").on("focus", function(){
		$("#kewarganegaraan_modal").find(".modal-body").load("/pidsus/get-kewarganegaraan/index");
		$("#kewarganegaraan_modal").modal({backdrop:"static", keyboard:false});
	});
	$("#kewarganegaraan_modal").on('show.bs.modal', function(e){
		$("#wrapper-modal-tsk").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("#wrapper-modal-tsk").removeClass("loading");
	}).on("click", ".closeMWgn", function(){
		$("#kewarganegaraan_modal").modal("hide");
	}).on("click", "#table-wgn-modal td:not(.aksinya)", function(){
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
		$("#warganegara").val(param[0]);
		$("#kebangsaan").val(param[1]);
	}
	/* END WARGANEGARA */

	localStorage.clear();
	var formValuesBa3Umum = JSON.parse(localStorage.getItem('formValuesBa3Umum')) || {};
	$(".form-yang-menyaksikan").find(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValuesBa3Umum[idnya] = idnya;
	});
	localStorage.setItem("formValuesBa3Umum", JSON.stringify(formValuesBa3Umum));

	/* START AMBIL JPN */
	$(".form-yang-menyaksikan").on("click", "#btn_popusul", function(){
		$("#tambah_usul_modal").find(".modal-body").load("/pidsus/pds-ba3-umum/getsaksi");
		$("#tambah_usul_modal").modal({backdrop:"static",keyboard:false});
	}).on("click", "#btn_hapusjpn", function(){
		var id 		= [];
		var tabel 	= $(".form-yang-menyaksikan").find(".table-jpn-modal");
		tabel.find(".hRowJpn:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
			if(tabel.find("tr").length == 1){
				var nRow = $(".form-yang-menyaksikan").find(".table-jpn-modal > tbody");
				nRow.append('<tr><td colspan="4">Tidak ada dokumen</td></tr>');
			}
		});
		tabel.find(".frmnojpn").each(function(i,v){$(this).text(i+1);});				

		formValuesBa3Umum = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesBa3Umum[idnya] = idnya;
		});
		localStorage.setItem("formValuesBa3Umum", JSON.stringify(formValuesBa3Umum));
		var n = tabel.find(".hRowJpn:checked").length;
		(n > 0)?$("#btn_hapusjpn").removeClass("disabled"):$("#btn_hapusjpn").addClass("disabled");
	});
        
	$("#tambah_usul_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#jpn-jpn-modal td:not(.aksinya)", function(){
		var index 	= $(this).closest("tr").data("id");
		var param	= index.toString().split('#');
		var myvar 	= param[0];
		if(myvar in formValuesBa3Umum){
			$("#tambah_usul_modal").modal("hide");
		} else{
			insertToRole(myvar, index);
			$("#tambah_usul_modal").modal("hide");
		}
	}).on('click', ".pilih-jpn", function(){
		var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataBa3Umum')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('#');
			var myvar 	= param[0];
			insertToRole(myvar, index);
		});
		localStorage.removeItem("modalnyaDataBa3Umum");
		$("#tambah_usul_modal").modal("hide");
	});
	function insertToRole(myvar, index){
		var tabel 	= $(".form-yang-menyaksikan").find(".table-jpn-modal");
		var rwTbl	= tabel.find('tbody > tr:last');
		var rwNom	= parseInt(rwTbl.find("span.frmnojpn").data('rowCount'));
		var newId 	= (isNaN(rwNom))?1:parseInt(rwNom + 1);
		var param	= index.toString().split('#');

		if(isNaN(rwNom)){
			rwTbl.remove();
			rwTbl = tabel.find('tbody');
			rwTbl.append('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td class="text-left">'+param[0]+'<br />'+param[1]+'</td>'+
				'<td class="text-left">'+param[2]+'<br />'+param[3]+'</td>'+
			'</tr>');
		} else{
			rwTbl.after('<tr data-id="'+myvar+'">'+
				'<td class="text-center"><input type="checkbox" name="cekModalJpn[]" id="cekModalJpn_'+newId+'" class="hRowJpn" value="'+myvar+'" /></td>'+
				'<td class="text-center"><span class="frmnojpn" data-row-count="'+newId+'"></span><input type="hidden" name="jpnid[]" value="'+index+'" /></td>'+
				'<td class="text-left">'+param[0]+'<br />'+param[1]+'</td>'+
				'<td class="text-left">'+param[2]+'<br />'+param[3]+'</td>'+
			'</tr>');
		}

		$("#cekModalJpn_"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		tabel.find(".frmnojpn").each(function(i,v){$(this).text(i+1);});
		formValuesBa3Umum[myvar] = myvar;
		localStorage.setItem("formValuesBa3Umum", JSON.stringify(formValuesBa3Umum));
	}
	$(".form-yang-menyaksikan").on("ifChecked", ".table-jpn-modal input[name=allCheckJpn]", function(){
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
