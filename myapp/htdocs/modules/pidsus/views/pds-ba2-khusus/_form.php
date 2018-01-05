<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsBa2Khusus;

	$this->title 	= 'BA-2 Khusus';
	$this->subtitle = 'Berita Acara Pengambilan Sumpah/ Janji Saksi';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternalKhusus();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_pidsus18 = '".$_SESSION["pidsus_no_pidsus18"]."' and no_p8_khusus = '".$_SESSION["pidsus_no_p8_khusus"]."'";
	$linkBatal		= '/pidsus/pds-ba2-khusus/index';
	$linkCetak		= '/pidsus/pds-ba2-khusus/cetak?id1='.rawurlencode($model['no_ba2_khusus']);
	if($isNewRecord){
		$sqlCek = "select no_p8_khusus, tgl_p8_khusus from pidsus.pds_p8_khusus where ".$whereDefault;
		$model 	= PdsBa2Khusus::findBySql($sqlCek)->asArray()->one();
	}
	$tgl_p8_khusus 	= ($model['tgl_p8_khusus'])?date('d-m-Y',strtotime($model['tgl_p8_khusus'])):'';
	$tgl_ba1_khusus 	= ($model['tgl_keterangan'])?date('d-m-Y',strtotime($model['tgl_keterangan'])):'';
	$tgl_ba2_khusus 	= ($model['tgl_ba2_khusus'])?date('d-m-Y',strtotime($model['tgl_ba2_khusus'])):'';
	$tgl_lahir 		= ($model['tgl_lahir'])?date('d-m-Y',strtotime($model['tgl_lahir'])):'';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/pds-ba2-khusus/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal BA-1 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <input type="text" name="tgl_ba1_khusus" id="tgl_ba1_khusus" class="form-control" value="<?php echo $tgl_ba1_khusus;?>" readonly />
                                    <div class="input-group-btn"><a class="btn btn-pidsus btn-sm" id="btn-cari-ba1-khusus"><i class="fa fa-search"></i></a></div>
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_ba1_khusus"></div>
                            </div>
                        </div>
                    </div>
				</div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal/Jam BA-2 Khusus</label>        
                            <div class="col-md-4">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_ba2_khusus" id="tgl_ba2_khusus" class="form-control datepicker" value="<?php echo $tgl_ba2_khusus;?>" required data-error="Tanggal BA-2 Khusus belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_tgl_ba2_khusus"></div>
                            </div>
                            <div class="col-md-4">
                                <div class="input-group bootstrap-timepicker">
                                    <div class="input-group-addon picker" style="border-right:0px;"><i class="fa fa-clock-o"></i></div>
                                    <input type="text" name="jam_ba2_khusus" id="jam_ba2_khusus" class="form-control timepicker" value="<?php echo $model['jam_ba2_khusus']; ?>" required data-error="Jam BA-2 Khusus belum diisi" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_jam_ba2_khusus"></div>
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
                                                from pidsus.pds_p8_khusus_jaksa where ".$whereDefault;
                                        $resOpt1 = PdsBa2Khusus::findBySql($sqlOpt1)->asArray()->all();
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
                    <label class="control-label col-md-4">Nama</label>        
                    <div class="col-md-8">
                        <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" readonly />
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
                        <input type="text" name="tmpt_lahir" id="tmpt_lahir" class="form-control chars-only" value="<?php echo $model["tmpt_lahir"];?>" readonly />
                    </div>
                    <label class="control-label col-md-2">Tanggal Lahir</label>
                    <div class="col-md-4">
                         <div class="input-group">
                            <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                            <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker"  value="<?php echo $tgl_lahir;?>" required data-error="Tanggal Lahir belum diisi" readonly />
                                <div class="input-group-addon" style="border:none; font-size:12px;">Umur</div>
                                <input type="text" name="umur" id="umur" class="form-control" style="width:60px;" value="<?php echo ($model["umur"]?$model["umur"]:'')?>" readonly />
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
                        <input type="hidden" name="id_jkl" id="id_jkl" value="<?php echo $model['id_jkl'];?>" />
                        <?php 
                            if($model["id_jkl"] && $model["id_jkl"] == "1") $jklTxt = "Laki-Laki";
                            else if($model["id_jkl"] && $model["id_jkl"] == "2") $jklTxt = "Perempuan";
                            else $jklTxt = "";
                        ?>
                        <input type="text" name="jklTxt" id="jklTxt" class="form-control" value="<?php echo $jklTxt;?>" readonly />
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Kewarganegaraan</label>
                    <div class="col-md-8">
                        <input type="hidden" name="warganegara" id="warganegara" value="<?php echo $model["warganegara"]?>"/>
                        <input type="text" name="kebangsaan" id="kebangsaan" class="form-control" value="<?php echo $model["kebangsaan"]?>" readonly />
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-4">Tempat Tinggal</label>
                    <div class="col-md-8">
                        <textarea name="alamat" id="alamat" class="form-control" style="height:75px" readonly><?php echo $model["alamat"];?></textarea>
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
                                <input type="hidden" name="id_agama" id="id_agama" value="<?php echo $model['id_agama'];?>" />
                                <input type="text" name="agamaTxt" id="agamaTxt" class="form-control" value="<?php echo $model['agama'];?>" readonly />
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
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" readonly />
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
                                <input type="hidden" name="pendidikan" id="pendidikan" value="<?php echo $model['id_pendidikan'];?>" />
                                <input type="text" name="pendidikanTxt" id="pendidikanTxt" class="form-control" value="<?php echo $model['pendidikan'];?>" readonly />
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
                            $sqlnya = "select * from pidsus.pds_ba2_khusus_saksi where ".$whereDefault." and no_ba2_khusus = '".$model['no_ba2_khusus']."' order by no_urut_saksi";
                            $hasil 	= ($model['no_ba2_khusus'])?PdsBa2Khusus::findBySql($sqlnya)->asArray()->all():array();
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
                        $pathFile 	= Yii::$app->params['ba2_khusus'].$model['file_upload'];
                        $labelFile 	= 'Unggah BA-2 Khusus';
                        if($model['file_upload'] && file_exists($pathFile)){
                            $labelFile 	= 'Ubah BA-2 Khusus';
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
	<input type="hidden" name="no_p8_khusus" id="no_p8_khusus" value="<?php echo $model['no_p8_khusus'];?>" />
    <input type="hidden" name="tgl_p8_khusus" id="tgl_p8_khusus" value="<?php echo $tgl_p8_khusus;?>" /> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <input type="hidden" name="no_ba2_khusus" id="no_ba2_khusus" value="<?php echo $model['no_ba2_khusus']; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php  } ?>
	<a class="btn btn-danger" href="<?php echo $linkBatal;?>">Batal</a>
</div>
</form>

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

<div class="modal fade" id="get_ba1_khusus_modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" style="width:1000px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">BA-1 Khusus</h4>
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
	$(".timepicker").timepicker({"defaultTime":false, "showMeridian":false, "minuteStep":1, "dropdown":true, "scrollbar":true});
	$("#jam_ba2_khusus").on('focus', function(){
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

	/* START GET BA-1 UMUM */
	$("#btn-cari-ba1-khusus").on('click', function(e){
		$("#get_ba1_khusus_modal").find(".modal-body").html("");
		$("#get_ba1_khusus_modal").find(".modal-body").load("/pidsus/pds-ba2-khusus/getba1khusus");
		$("#get_ba1_khusus_modal").modal({backdrop:"static"});
	});
	$("#get_ba1_khusus_modal").on('show.bs.modal', function(e){
		$("body").addClass("loading");
	}).on('shown.bs.modal', function(e){
		$("body").removeClass("loading");
	}).on("dblclick", "#tabel-ba1u-modal td:not(.aksinya)", function(){
		var index = $(this).closest("tr").data("id");
		var param = index.toString().split('|#|');
		insertToBa1u(param);
		$("#get_ba1_khusus_modal").modal("hide");
	}).on('click', "#idPilihba1UModal", function(){
		var modal = $("#get_ba1_khusus_modal").find("#tabel-ba1u-modal");
		var index = modal.find(".pilih_ba1u_modal:checked").val();
		var param = index.toString().split('|#|');
		insertToBa1u(param);
		$("#get_ba1_khusus_modal").modal("hide");
	}).on('click','#idBatalba1UModal', function(){
		$("#get_ba1_khusus_modal").modal("hide");
	});
	function insertToBa1u(param){
		$("#no_ba1_khusus").val(decodeURIComponent(param[0]));
		$("#tgl_ba1_khusus").val(decodeURIComponent(param[1]));
		$("#nama_jaksa_penyidik").val(decodeURIComponent(param[2])).trigger("change");
		$("#nip_jaksa").val(decodeURIComponent(param[2]));
		$("#nama_jaksa").val(decodeURIComponent(param[3]));
		$("#pangkat_jaksa").val(decodeURIComponent(param[4]));
		$("#nama").val(decodeURIComponent(param[5])).trigger("change");
		$("#tmpt_lahir").val(decodeURIComponent(param[6]));
		$("#tgl_lahir").val(decodeURIComponent(param[7]));
		$("#id_jkl").val(decodeURIComponent(param[8]));
		if(decodeURIComponent(param[8]) == 1){
			$("#jklTxt").val("Laki-Laki");
		} else if(decodeURIComponent(param[8]) == 2){
			$("#jklTxt").val("Perempuan");
		} else{
			$("#jklTxt").val("");
		}
		$("#warganegara").val(decodeURIComponent(param[9]));
		$("#kebangsaan").val(decodeURIComponent(param[10]));
		$("#alamat").val(decodeURIComponent(param[11]));
		$("#id_agama").val(decodeURIComponent(param[12]));
		$("#agamaTxt").val(decodeURIComponent(param[13]));
		$("#pekerjaan").val(decodeURIComponent(param[14]));
		$("#pendidikan").val(decodeURIComponent(param[15]));
		$("#pendidikanTxt").val(decodeURIComponent(param[16]));
		$("#umur").val(decodeURIComponent(param[17]));
	}
	/* END GET PIDSUS-14 UMUM */

	/* START WARGANEGARA */
	/*$("#kebangsaan").on("focus", function(){
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
	}*/
	/* END WARGANEGARA */

	localStorage.clear();
	var formValuesBa2Khusus = JSON.parse(localStorage.getItem('formValuesBa2Khusus')) || {};
	$(".form-yang-menyaksikan").find(".table-jpn-modal tr[data-id]").each(function(k, v){
		var idnya = $(v).data("id");
		formValuesBa2Khusus[idnya] = idnya;
	});
	localStorage.setItem("formValuesBa2Khusus", JSON.stringify(formValuesBa2Khusus));

	/* START AMBIL JPN */
	$(".form-yang-menyaksikan").on("click", "#btn_popusul", function(){
		$("#tambah_usul_modal").find(".modal-body").load("/pidsus/pds-ba2-khusus/getsaksi");
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

		formValuesBa2Khusus = {};
		tabel.find("tr[data-id]").each(function(k, v){
			var idnya = $(v).data("id");
			formValuesBa2Khusus[idnya] = idnya;
		});
		localStorage.setItem("formValuesBa2Khusus", JSON.stringify(formValuesBa2Khusus));
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
		if(myvar in formValuesBa2Khusus){
			$("#tambah_usul_modal").modal("hide");
		} else{
			insertToRole(myvar, index);
			$("#tambah_usul_modal").modal("hide");
		}
	}).on('click', ".pilih-jpn", function(){
		var id 	= [];
		var n 	= JSON.parse(localStorage.getItem('modalnyaDataBa2Khusus')) || {};
		for(var x in n){ 
			id.push(n[x]);
		}
		id.forEach(function(index,element) {
			var param	= index.toString().split('#');
			var myvar 	= param[0];
			insertToRole(myvar, index);
		});
		localStorage.removeItem("modalnyaDataBa2Khusus");
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
		formValuesBa2Khusus[myvar] = myvar;
		localStorage.setItem("formValuesBa2Khusus", JSON.stringify(formValuesBa2Khusus));
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