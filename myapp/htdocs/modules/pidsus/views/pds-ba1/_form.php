<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use yii\bootstrap\Modal;
	use yii\widgets\Pjax;
	use yii\grid\GridView;
	use app\modules\pidsus\models\PdsBa1;

	$this->title = 'BA-1';
	$this->subtitle = 'Berita Acara Pemeriksaan Saksi / Tersangka';
	$this->params['idtitle'] = Yii::$app->inspektur->getHeaderPraPenuntutanInternal();
	$whereDefault 	= "id_kejati = '".$_SESSION["kode_kejati"]."' and id_kejari = '".$_SESSION["kode_kejari"]."' and id_cabjari = '".$_SESSION["kode_cabjari"]."' 
						and no_spdp = '".$_SESSION["no_spdp"]."' and tgl_spdp = '".$_SESSION["tgl_spdp"]."'";
	$linkBatal		= '/pidsus/p16/index';
	$linkCetak		= '/pidsus/p16/cetak';
	$tgl_ttd 		= ($model['tgl_dikeluarkan'])?date('d-m-Y',strtotime($model['tgl_dikeluarkan'])):'';
	$ttdJabatan 	= $model['penandatangan_status_ttd']." ".$model['penandatangan_jabatan_ttd'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidsus/p16/simpan" enctype="multipart/form-data">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
	
<div class="row">        
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tanggal" id="tanggal" class="form-control datepicker" value="<?php echo $model['tanggal'];?>" <?php echo ($model['tanggal'])?'readonly':'';?> required data-error="Tanggal belum diisi" maxlength="50" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tempat</label>        
                            <div class="col-md-8">
                                <input type="text" name="tempat" id="tempat" class="form-control" value="<?php echo $model['tempat'];?>" <?php echo ($model['tempat'])?'readonly':'';?> required data-error="Tempat belum diisi" maxlength="50" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
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
                                <select name="nama_jp" id="nama_jp" class="select2" style="width:100%" required data-error="Sifat surat belum diisi">
                                    <option></option>
                                    
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pangkat</label>        
                            <div class="col-md-8">
                                
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">NIP</label>        
                            <div class="col-md-8">
                                
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
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
                <h3 class="box-title">Saksi / Tersangka</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Nama</label>        
                            <div class="col-md-8">
                                <select name="nama_saksi" id="nama_saksi" class="select2" style="width:100%">
                                    <option></option>
                                    
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tempat Tinggal</label>        
                            <div class="col-md-8">
                                <textarea name="tmp_tinggal" id="tmp_tinggal" class="form-control" style="height: 50px"></textarea>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Status</label>        
                            <div class="col-md-8">
                                <input type="radio" name="status" id="status[1]" value="1" <?php echo ($model["status"] == "1")?'checked':'';?> />
                                <label for="id_jkl[1]" class="control-label jarak-kanan">Saksi</label>

                                <input type="radio" name="status" id="status[2]" value="2" <?php echo ($model["status"] == "2")?'checked':'';?> />
                                <label for="status[2]" class="control-label">Tersangka</label>
                                <div class="help-block with-errors"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Agama</label>        
                            <div class="col-md-8">
                                <select id="id_agama" name="id_agama" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                         $agm = PdsBa1::findBySql("select * from public.ms_agama order by id_agama")->asArray()->all();
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
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tempat Lahir</label>        
                            <div class="col-md-8">
                                <input type="text" name="tmp_lahir" id="tmp_lahir" class="form-control" value="<?php echo $model['tmp_lahir'];?>" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pekerjaan</label>        
                            <div class="col-md-6">
                                <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $model['pekerjaan'];?>" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                            <input type="checkbox" name="is_pns" id="is_pns" class="col-md-2" />
                            <label for="is_pns" class="control-label jarak-kanan">PNS</label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Tanggal Lahir</label>        
                            <div class="col-md-8">
                                <div class="input-group">
                                    <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                                    <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control datepicker" value="<?php echo $model['tgl_lahir'];?>" />
                                </div>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">       
                            <div class="col-md-8 col-md-offset-4">
                                <input type="text" name="pangkat" id="pangkat" class="form-control is_pns" value="<?php echo $model['pangkat'];?>" placeholder="Pangkat" readonly="" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Jenis Kelamin</label>        
                            <div class="col-md-8">
                                <select name="jk" id="jk" class="select2" style="width:100%">
                                    <option></option>
                                    <option value="1">Laki-laki</option>
                                    <option value="2">Perempuan</option>
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">       
                            <div class="col-md-8 col-md-offset-4">
                                <input type="text" name="jabatan" id="jabatan" class="form-control is_pns" value="<?php echo $model['jabatan'];?>" placeholder="Jabatan" readonly="" />
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Kewarganegaraan</label>        
                            <div class="col-md-8">
                                <select name="id_warganegara" id="id_warganegara" class="select2" style="width:100%">
                                    <option></option>
                                    <?php 
                                        $idkwn = PdsBa1::findBySql("select * from public.ms_warganegara order by id")->asArray()->all();
                                        foreach($idkwn as $id){
                                            $selected = ($id['id'] == $model['id_kwn'])?'selected':'';
                                            echo '<option value="'.$id['id'].'" '.$selected.'>'.$id['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group form-group-sm">
                            <label class="control-label col-md-4">Pendidikan</label>        
                            <div class="col-md-8">
                                <select id="pendidikan" name="pendidikan" class="select2" style="width:100%;">
                                    <option></option>
                                    <?php 
                                        $pdd = PdsBa1::findBySql("select * from public.ms_pendidikan order by id_pendidikan")->asArray()->all();
                                        foreach($pdd as $pd){
                                            $selected = ($pd['id_pendidikan'] === $model['id_pendidikan'])?'selected':'';
                                                echo '<option value="'.$pd['id_pendidikan'].'" '.$selected.'>'.$pd['nama'].'</option>';
                                        }
                                    ?>
                                </select>
                                <div class="help-block with-errors" id="error_custom_no_p16"></div>
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
                <h3 class="box-title">Pertanyaan dan Jawaban</h3>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12">
                        <a class="btn btn-danger btn-sm hapusPertanyaan jarak-kanan" title="Hapus"><i class="fa fa-trash" style="font-size:14px;"></i></a>
                        <a class="btn btn-success btn-sm" id="tambah-pertanyaan" title="Tambah Pertanyaan"><i class="fa fa-plus jarak-kanan"></i>Pertanyaan</a><br>
                    </div>	
                </div><br/>	
                <div class="">
                    <table id="table_pertanyaan" class="table table-bordered">
                        <tbody>
                        <?php
                        	if($model['id_pertanyaan'] == ''){
                        		$sqlx = "select id, pertanyaan from pidsus.ms_pertanyaan_ba1 order by id";
                        		$resx = PdsBa1::findBySql($sqlx)->asArray()->all();
                        	} else{
                        		$sqlx = "select no_urut as no_urut, deskripsi_tembusan as tembusan from pidsus.pds_p16_tembusan 
										where ".$whereDefault." and no_p16 = '".$model['no_p16']."' order by no_urut";
                        		$resx = PdsP8Umum::findBySql($sqlx)->asArray()->all();
                        	}
                        	$no = 1;
							foreach($resx as $datx):
						?>
                                <tr data-id="<?php echo $no;?>">
                                    <td class="text-center" width="5%">
                                        <!--<input type="checkbox" name="chk_del_pertanyaan[]" id="<?php echo 'chk_del_pertanyaan'.$no;?>" class="hRow" value="<?php echo $no;?>" />-->
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="form-group form-group-sm col-md-12">
                                                <div class="col-md-1">
                                                    <input type="text" name="no_urut[]" readonly="" class="form-control input-sm" value="<?php echo $no;?>"/>
                                                </div>
                                                <div class="col-md-6">
                                                    <input type="text" name="pertanyaan[]" class="form-control" placeholder="Pertanyaan" value="<?php echo $datx['pertanyaan'];?>" readonly=""/> 
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group form-group-sm">
                                                    <div class="col-md-7">
                                                        <textarea style="height: 80px" class="form-control" name="jawaban_pertanyaan[]"></textarea>
                                                        <div class="help-block with-errors"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                        	</tr>	
                        <?php $no++; endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group form-group-sm">
                            <div class="col-md-12">
                                <input type="file" name="file_template" id="file_template" class="form-inputfile" />                    
                                <label for="file_template" class="label-inputfile">
                                    <?php 
                                        $pathFile 	= Yii::$app->params['p16'].$model['file_upload_p16'];
                                        $labelFile 	= 'Unggah Daftar Pertanyaan';
                                        if($model['file_upload_p16'] && file_exists($pathFile)){
                                            $labelFile 	= 'Unggah Daftar Pertanyaan';
                                            $param1  	= chunk_split(base64_encode($pathFile));
                                            $param2  	= chunk_split(base64_encode($model['file_upload_p16']));
                                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                                            $extPt		= substr($model['file_upload_p16'], strrpos($model['file_upload_p16'],'.'));
                                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p16'].'" style="float:left; margin-right:10px;">
                                            <img src="'.Yii::$app->inspektur->getIconFile($extPt).'" /></a>';
                                        }
                                    ?>
                                    <div class="input-group">
                                        <div class="input-group-addon btn-blue"><i class="fa fa-upload jarak-kanan"></i><?php echo $labelFile;?></div>
                                        <input type="text" class="form-control" readonly />
                                    </div>
                                    <h6 style="margin:5px 0px;">[ Tipe file .doc, .docx, .pdf dengan ukuran maks. 2Mb]</h6>
                                    <div class="help-block with-errors" id="error_custom_file_template"></div>
                                </label>
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
                        $pathFile 	= Yii::$app->params['p16'].$model['file_upload_p16'];
                        $labelFile 	= 'Unggah BA-1';
                        if($model['file_upload_p16'] && file_exists($pathFile)){
                            $labelFile 	= 'Unggah BA-1';
                            $param1  	= chunk_split(base64_encode($pathFile));
                            $param2  	= chunk_split(base64_encode($model['file_upload_p16']));
                            $linkPt 	= "/pidsus/download-file/index?id=".$param1."&fn=".$param2;
                            $extPt		= substr($model['file_upload_p16'], strrpos($model['file_upload_p16'],'.'));
                            echo '<a href="'.$linkPt.'" title="'.$model['file_upload_p16'].'" style="float:left; margin-right:10px;">
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
	<input type="hidden" name="tgl_spdp" id="tgl_spdp" value="<?php echo date("d-m-Y", strtotime($_SESSION["tgl_spdp"]));?>" />
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" name="simpan" id="simpan" value="simpan"><?php echo ($isNewRecord)?'Simpan':'Ubah';?></button>
    <?php // if(!$isNewRecord){ ?><a class="btn btn-warning jarak-kanan" target="_blank" href="<?php echo $linkCetak;?>">Cetak</a><?php // } ?>
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
        $('#is_pns').on("ifChecked",function(){
            $('.is_pns').removeAttr('readonly');
        }).on("ifUnchecked",function(){
            $('.is_pns').val('');
            $('.is_pns').attr('readonly','readonly');
        });
        
        /* START PERTANYAAN */
	$('#tambah-pertanyaan').click(function(){
		var tabel	= $('#table_pertanyaan > tbody').find('tr:last');			
		var newId	= (tabel.length > 0)?parseInt(tabel.data('id'))+1:1;
		$('#table_pertanyaan').append(
			'<tr data-id="'+newId+'">'+
                        '<td class="text-center" width="5%">'+
                            '<input type="checkbox" name="chk_del_pertanyaan[]" id="chk_del_pertanyaan'+newId+'" class="hRow" value="'+newId+'" />'+
                        '</td>'+
                        '<td>'+
                            '<div class="row">'+
                                '<div class="form-group form-group-sm col-md-12">'+
                                    '<div class="col-md-1">'+
                                        '<input type="text" name="no_urut[]" class="form-control input-sm" />'+
                                    '</div>'+
                                    '<div class="col-md-6">'+
                                        '<input type="text" name="pertanyaan[]" class="form-control" placeholder="Pertanyaan"/>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                            '<div class="row">'+
                                '<div class="col-md-12">'+
                                    '<div class="form-group form-group-sm">'+
                                        '<div class="col-md-7">'+
                                            '<textarea style="height: 80px" class="form-control" name="jawaban_pertanyaan[]"></textarea>'+
                                            '<div class="help-block with-errors"></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</td>'+
                    '</tr>'
		);
		$("#chk_del_pertanyaan"+newId).iCheck({checkboxClass: 'icheckbox_square-pink'});
		$('#table_pertanyaan').find("input[name='no_urut[]']").each(function(i,v){$(v).val(i+1);});				
	});
								
	$(".hapusPertanyaan").click(function(){
		var tabel 	= $("#table_pertanyaan");
		tabel.find(".hRow:checked").each(function(k, v){
			var idnya = $(v).val();
			tabel.find("tr[data-id='"+idnya+"']").remove();
		});
		tabel.find("input[name='no_urut[]']").each(function(i,v){$(this).val(i+1);});				
	});
	/* END PERTANYAAN */
        
});
	
</script>