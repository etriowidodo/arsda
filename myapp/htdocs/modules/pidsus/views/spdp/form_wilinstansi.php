<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
?>
<div id="wrapper-modalWil">
    <form class="form-horizontal" id="frm-m2">
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Jenis Instansi</label>
                    <div class="col-md-2">
                        <input type="text" name="m2_jenis" id="m2_jenis" class="form-control" value="<?php echo $model['kode_jenis_instansi']; ?>" maxlength="2" readonly />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Instansi</label>
                    <div class="col-md-2">
                        <input type="text" name="m2_instansi" id="m2_instansi" class="form-control" value="<?php echo $model['kode_instansi']; ?>" maxlength="3" readonly />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Wilayah (Propinsi)</label>
                    <div class="col-md-8">
                        <?php if($model['isNewRecord']){ ?>
                        <select id="m2_prop" name="m2_prop" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                $resOpt = MenuSearch::findBySql("select distinct id_prop, deskripsi from datun.m_propinsi order by deskripsi")->asArray()->all();
                                foreach($resOpt as $dOpt){
                                    $selected = ($model['kode_provinsi'] == $dOpt['id_prop'])?'selected':'';
                                    echo '<option value="'.$dOpt['id_prop'].'" '.$selected2.'>'.$dOpt['deskripsi'].'</option>';														
                                }
                            ?> 
                        </select>
                        <?php } else{ ?>
                        	<input type="hidden" name="m2_prop" id="m2_prop" value="<?php echo $model['kode_provinsi'];?>" />
                        	<input type="text" name="m2_prop_txt" id="m2_prop_txt" class="form-control" value="<?php echo $model['propinsi'];?>" readonly />
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Wilayah (Kabupaten/Kota)</label>
                    <div class="col-md-8">
                        <?php if($model['isNewRecord']){ ?>
                        <select id="m2_kab" name="m2_kab" class="select2" style="width:100%;">
                        </select>
                        <?php } else{ ?>
                        	<input type="hidden" name="m2_kab" id="m2_kab" value="<?php echo $model['kode_kabupaten'];?>" />
                        	<input type="text" name="m2_kab_txt" id="m2_kab_txt" class="form-control" value="<?php echo $model['kabupaten'];?>" readonly />
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Nama Instansi/BUMN/BUMD</label>
                    <div class="col-md-8">
                        <input type="text" name="m2_inst_wilayah" id="m2_inst_wilayah" class="form-control" value="<?php echo $model['deskripsi_inst_wilayah']; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Pimpinan</label>
                    <div class="col-md-8">
                        <input type="text" name="m2_pimpinan" id="m2_pimpinan" class="form-control" value="<?php echo $model['nama']; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">No.Telp</label>
                    <div class="col-md-8">
                        <input type="text" name="m2_telp" id="m2_telp" class="form-control number-only" maxlength="15" value="<?php echo $model['no_tlp']; ?>" />
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-8">
                        <textarea style="height:90px;" name="m2_alamat" id="m2_alamat" class="form-control"><?php echo $model['alamat']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row">
            <div class="col-md-12">
                <div class="help-block with-errors text-red" style="font-style:italic" id="errornya-modal-wil"></div>
            </div>
        </div>
    
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="no_urut" id="no_urut" value="<?php echo $model['no_urut'];?>" />
            <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $model['isNewRecord'];?>" />
            <button type="button" id="simpan_form_wilinstansi" class="btn btn-warning btn-sm jarak-kanan"><i class="fa fa-floppy-o jarak-kanan"></i>Simpan</button>
            <a class="btn btn-danger btn-sm" id="form_keluar2"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
        </div>
    </form>
    <div class="modal-loading-new"></div>
</div>
<style>
	#wrapper-modalWil.loading {overflow: hidden;}
	#wrapper-modalWil.loading .modal-loading-new {display: block;}

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
</style>
<script type="text/javascript">
$(function(){
	$(".select2").select2({placeholder:"Pilih salah satu", allowClear:true});		
	$("select#m2_prop").change(function(){
		$kdprov = $("select#m2_prop").val();
		$("select#m2_kab option").remove();
		$.ajax({
			type	: "POST",
			url		: '<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/getkabupaten'; ?>',
			data	: { q1 : $kdprov },
			cache	: false,
			dataType: 'json',
			success : function(data){ 
				if(data.items != ""){						
					$("select#m2_kab").select2({placeholder:"Pilih salah satu", allowClear:true, data:data.items});
					return false;
				}
			}
		});
	});
});
</script>