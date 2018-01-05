<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsBa1Umum;

	$this->title 	= 'BA-1 Umum';
	$this->subtitle = 'Berita Acara Pemeriksaan Saksi';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_p8_umum = '".$_SESSION["pidsus_no_p8_umum"]."'";
	$linkBatal		= '/pidsus/pds-ba1-umum/index';
	$linkCetak		= '/pidsus/pds-ba1-umum/cetak?id1='.rawurlencode($model['no_ba1_umum']);
	if($isNewRecord){
		$sqlCek = "select no_p8_umum, tgl_p8_umum from pidsus.pds_p8_umum where ".$whereDefault;
		$model 	= PdsBa1Umum::findBySql($sqlCek)->asArray()->one();
	}

	$tgl_p8_umum 	= ($model['tgl_p8_umum'])?date('d-m-Y',strtotime($model['tgl_p8_umum'])):'';
	$tgl_ba1_umum 	= ($model['tgl_ba1_umum'])?date('d-m-Y',strtotime($model['tgl_ba1_umum'])):'';
	$tgl_lahir 		= ($model['tgl_lahir'])?date('d-m-Y',strtotime($model['tgl_lahir'])):'';
	$readonly 		= (!$model['pns'])?'readonly':'';
	$checked 		= ($model['no_ba1_umum'] && $model['pns'])?'checked':'';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-ba1-umum/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal BA-1 Umum</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_ba1_umum" id="tgl_ba1_umum" class="form-control datepicker" value="<?php echo $tgl_ba1_umum;?>" required data-error="Tanggal BA-1 Umum belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_ba1_umum"></div>
                            </div>
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
										$resOpt1 = PdsBa1Umum::findBySql($sqlOpt1)->asArray()->all();
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
        <h3 class="box-title">Saksi</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Status</label>        
                    <div class="col-md-8">
                        <input type="text" name="status" id="status" class="form-control" value="Saksi" readonly />
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Nama</label>        
                    <div class="col-md-8">
                        <div class="input-group input-group-sm">
                            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" required data-error="Nama Saksi belum dipilih" />
                            <span class="input-group-btn"><button class="btn" type="button" id="pilih_saksi"><i class="fa fa-search"></i></button></span>
                        </div>
                        <div class="help-block with-errors" id="error_custom_nama"></div>
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
                        <input type="radio" name="id_jkl" id="id_jkl[1]" value="1" <?php echo ($model["id_jkl"] == "1")?'checked':'';?> />
                        <label for="id_jkl[1]" class="control-label jarak-kanan">Laki-Laki</label>
                        
                        <input type="radio" name="id_jkl" id="id_jkl[2]" value="2" <?php echo ($model["id_jkl"] == "2")?'checked':'';?> />
                        <label for="id_jkl[2]" class="control-label">Perempuan</label>
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
                                         $agm = PdsBa1Umum::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
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
                                <div class="input-group">
                                	<input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" />
                                	<span class="input-group-addon no-border">
                                    	<label for="pns" class="control-label" style="padding:0px;"><input type="checkbox" name="pns" id="pns" value="1" <?php echo $checked;?> /> 
                                        <span class="jarak-kanan">PNS</span></label>
									</span>
                                </div>
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
                                        $pdd = PdsBa1Umum::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
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
            <div class="col-md-6">
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">       
                            <label class="control-label col-md-4">Pangkat</label>
                            <div class="col-md-8">
                                <input type="text" name="pangkat" id="pangkat" class="form-control is_pns" value="<?php echo $model['pangkat'];?>" <?php echo $readonly;?> />
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                	<div class="col-md-12">
                        <div class="form-group form-group-sm">       
                            <label class="control-label col-md-4">Jabatan</label>
                            <div class="col-md-8">
                                <input type="text" name="jabatan" id="jabatan" class="form-control is_pns" value="<?php echo $model['jabatan'];?>" <?php echo $readonly;?> />
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
        <h3 class="box-title">Pertanyaan dan Jawaban</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">
                <a class="btn btn-danger btn-sm hapusPertanyaan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                <a class="btn btn-success btn-sm" id="tambah-pertanyaan" title="Tambah Pertanyaan"><i class="fa fa-plus jarak-kanan"></i>Pertanyaan</a><br>
            </div>	
        </div><br/>	
        <div class="table-responsive">
            <table id="table_pertanyaan" class="table table-bordered">
                <tbody>
                <?php
                    if($model['no_ba1_umum'] == ''){
                        $resx = array(
							array("no_urut"=>1, "pertanyaan"=>"Apakah Saudara dalam keadaan sehat jasmani dan rohani serta bersediakah Saudara memberi keterangan pada pemeriksaan ini?", "jawaban"=>""), 
							array("no_urut"=>2, "pertanyaan"=>"Apakah Saudara telah menunjuk Penasehat Hukum yang akan mendampingi Saudara dalam pemeriksaan ini?", "jawaban"=>""), 
							array("no_urut"=>3, "pertanyaan"=>"Mengapa Saudara berkeberatan didampingi Penasehat Hukum?", "jawaban"=>""), 
						);
                    } else{
                        $sqlx = "select * from pidsus.pds_ba1_umum_pertanyaan where ".$whereDefault." and no_ba1_umum = '".$model['no_ba1_umum']."' order by no_urut";
                        $resx = PdsBa1Umum::findBySql($sqlx)->asArray()->all();
                    }
                    $nom = 0;
                    foreach($resx as $datx){
						$nom++;
                ?>
                <tr data-id="<?php echo $nom;?>">
                    <td class="text-center" width="5%">
                        <?php echo ($nom > 3)?'<input type="checkbox" name="chkdel_soal[]" id="chkdel_soal'.$nom.'" class="hRow" value="'.$nom.'" />':'';?>
                    </td>
                    <td>
                        <div class="form-group form-group-sm" style="margin:0 0 10px;">
                            <div class="input-group" style="width:100%">
                                <span class="input-group-addon frmnosaksi" style="width:35px;padding:6px;text-align:left;vertical-align:top;" data-row-count="<?php echo $nom;?>">
                                <?php echo $nom;?></span>
                                <textarea name="pertanyaan[]" id="<?php echo 'pertanyaan'.$nom;?>" class="form-control" style="height:50px;" placeholder="Pertanyaan"><?php echo $datx['pertanyaan'];?></textarea> 
                            </div>
                        </div>
                        <div class="form-group form-group-sm no-margin">
                            <textarea name="jawaban[]" id="<?php echo 'jawaban'.$nom;?>" class="form-control ckeditor" style="height:80px;" placeholder="Jawaban"><?php echo $datx['jawaban'];?></textarea> 
                        </div>
					</td>
                </tr>	
                <?php } ?>
                </tbody>
            </table>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <div class="col-md-12">
                        <input type="file" name="file_unggah_pertanyaan" id="file_unggah_pertanyaan" class="form-inputfile" />                    
                        <label for="file_unggah_pertanyaan" class="label-inputfile">
                            <?php 
                                $pathFile 	= Yii::$app->params['ba1_umum'].$model['file_unggah_pertanyaan'];
                                $labelFile 	= 'Unggah Daftar Pertanyaan';
                                if($model['file_unggah_pertanyaan'] && file_exists($pathFile)){
                                    $labelFile 	= 'Ubah Daftar Pertanyaan';
                                    $param1  	= chunk_split(base64_encode($pathFile));
                                    $param2  	= chunk_split(base64_encode($model['file_unggah_pertanyaan']));
                                    $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                    $extPt		= substr($model['file_unggah_pertanyaan'], strrpos($model['file_unggah_pertanyaan'],'.'));
                                    echo '<a href="'.$linkPt.'" title="'.$model['file_unggah_pertanyaan'].'" style="float:left; margin-right:10px;">
                                    <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                }
                            ?>
                            <div class="input-group">
                                <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                <input type="text" class="form-control" readonly />
                            </div>
                            <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
                            <div class="help-block with-errors" id="error_custom_file_unggah_pertanyaan"></div>
                        </label>
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
                        $pathFile 	= Yii::$app->params['ba1_umum'].$model['file_upload'];
                        $labelFile 	= 'Unggah BA-1 Umum';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah BA-1 Umum';
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
                    <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf, .jpg dengan ukuran maks. 5Mb]</h6>
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
    <input type="hidden" name="no_ba1_umum" id="no_ba1_umum" value="<?php echo $model['no_ba1_umum']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

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
                <h4 class="modal-title">List Saksi</h4>
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
		$("#list_saksi_modal").find(".modal-body").load("/pidsus/pds-ba1-umum/getsaksi?perihal="+$("#status").val());
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

	$('#pns').on("ifChecked",function(){
		$('.is_pns').removeAttr('readonly').val("");
	}).on("ifUnchecked",function(){
		$('.is_pns').attr('readonly','readonly').val("");
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

	/* START PERTANYAAN */
	$('#tambah-pertanyaan').click(function(){
		var tabel = $('#table_pertanyaan > tbody').find('tr:last');			
		var newId = (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_pertanyaan').append(
		'<tr data-id="'+newId+'">'+
			'<td class="text-center" width="5%"><input type="checkbox" name="chkdel_soal[]" id="chkdel_soal'+newId+'" class="hRow" value="'+newId+'" /></td>'+
			'<td>'+
				'<div class="form-group form-group-sm" style="margin:0 0 10px;">'+
					'<div class="input-group" style="width:100%">'+
						'<span class="input-group-addon frmnosaksi" style="width:35px;padding:6px;text-align:left;vertical-align:top;" data-row-count="'+newId+'"></span>'+
						'<textarea name="pertanyaan[]" id="pertanyaan'+newId+'" class="form-control" style="height:50px;" placeholder="Pertanyaan"></textarea>'+ 
					'</div>'+
				'</div>'+
				'<div class="form-group form-group-sm no-margin">'+
					'<textarea name="jawaban[]" id="jawaban'+newId+'" class="form-control" style="height:80px;" placeholder="Jawaban"></textarea>'+ 
				'</div>'+
			'</td>'+
		'</tr>');
		$("#chkdel_soal"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_pertanyaan').find(".frmnosaksi").each(function(i,v){$(v).text(i+1);});				
	});
								
	$(".hapusPertanyaan").click(function(){
		var tabel = $("#table_pertanyaan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find(".frmnosaksi").each(function(i,v){$(v).text(i+1);});					
	});
	/* END PERTANYAAN */
        
});
	
</script>