<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\InstansiJenis;

	$jnsTxt	= $model['kode_jenis_instansi'].' | '.$model['deskripsi_jnsinstansi'];
	$insTxt	= $model['kode_instansi'].' | '.$model['deskripsi_instansi'];
	$provTxt= $model['kode_provinsi'].' | '.$model['nm_provinsi'];
	$kabTxt	= $model['kode_kabupaten'].' | '.$model['nm_kabupaten'];
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/instansi-wilayah/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Kode Jenis Instansi</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="kode_jns" name="kode_jns" class="select2" style="width:100%;" required data-error="Kode jenis instansi belum dipilh">
                        <option></option>
                        <?php 
                            $sqlOpt = "select * from datun.jenis_instansi order by kode_jenis_instansi";
                            $resOpt = InstansiJenis::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
                                echo '<option value="'.$dOpt['kode_jenis_instansi'].'">'.$dOpt['deskripsi_jnsinstansi'].'</option>';
                            }
                        ?>
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="kode_jns" id="kode_jns" value="<?php echo $model['kode_jenis_instansi'];?>" />
                    <input type="text" name="jns_txt" id="jns_txt" class="form-control" value="<?php echo $jnsTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Kode Instansi</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="kode_ins" name="kode_ins" class="select2" style="width:100%;" required data-error="Kode instansi belum dipilh">
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="kode_ins" id="kode_ins" value="<?php echo $model['kode_instansi'];?>" />
                    <input type="text" name="ins_txt" id="ins_txt" class="form-control" value="<?php echo $insTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Provinsi</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="propinsi" name="propinsi" class="select2" style="width:100%;" required data-error="Provinsi belum dipilh">
                        <option></option>
                        <?php 
                            $sqlOpt = "select * from datun.m_propinsi order by id_prop";
							$resOpt = InstansiJenis::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
                                echo '<option value="'.$dOpt['id_prop'].'">'.$dOpt['deskripsi'].'</option>';
                            }
                        ?>
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="no_urut" id="no_urut" value="<?php echo $model['no_urut'];?>" />
                	<input type="hidden" name="propinsi" id="propinsi" value="<?php echo $model['kode_provinsi'];?>" />
                    <input type="text" name="prov_txt" id="prov_txt" class="form-control" value="<?php echo $provTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Kabupaten</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="kabupaten" name="kabupaten" class="select2" style="width:100%;" required data-error="Kabupaten belum dipilh">
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="kabupaten" id="kabupaten" value="<?php echo $model['kode_kabupaten'];?>" />
                    <input type="text" name="kab_txt" id="kab_txt" class="form-control" value="<?php echo $kabTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Deskripsi</label>
                <div class="col-md-8">
                	<input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?php echo $model['deskripsi_inst_wilayah'];?>" required data-error="Deksripsi belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Nama Pimpinan</label>
                <div class="col-md-8">
                	<input type="text" name="nama" id="nama" class="form-control" value="<?php echo $model['nama'];?>" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Alamat</label>
                <div class="col-md-8">
                	<textarea name="alamat" id="alamat" class="form-control" style="height:90px;"><?php echo $model['alamat'];?></textarea>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">No Telp</label>
                <div class="col-md-8">
                	<input type="text" name="no_tlp" id="no_tlp" class="form-control number-only" value="<?php echo $model['no_tlp'];?>" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
</div>

<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <a href="/datun/instansi-wilayah/index" class="btn btn-danger">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<style>
	h3.box-title{
		font-weight: bold;
	}
	.help-block{
		margin-bottom: 0px;
		margin-top: 0px;
	}
</style>
<script type="text/javascript">
$(document).ready(function(){
	$("select#kode_jns").change(function(){
		$("select#kode_ins").val("").trigger('change').select2('close');
		$("select#kode_ins option").remove();
		$.ajax({
			type	: "POST",
			url		: '<?php echo Yii::$app->request->baseUrl.'/datun/instansi-wilayah/getinstansi'; ?>',
			data	: { q1 : $("select#kode_jns").val() },
			cache	: false,
			dataType: 'json',
			success : function(data){ 
				if(data.items != ""){
					$("select#kode_ins").select2({data:data.items, placeholder:"Pilih salah satu", allowClear:true});
					return false;
				}
			}
		});
	});

	$("select#propinsi").change(function(){
		$("select#kabupaten").val("").trigger('change').select2('close');
		$("select#kabupaten option").remove();
		$.ajax({
			type	: "POST",
			url		: '<?php echo Yii::$app->request->baseUrl.'/datun/instansi-wilayah/getkabupaten'; ?>',
			data	: { q1 : $("select#propinsi").val() },
			cache	: false,
			dataType: 'json',
			success : function(data){ 
				if(data.items != ""){
					$("select#kabupaten").select2({data:data.items, placeholder:"Pilih salah satu", allowClear:true});
					return false;
				}
			}
		});
	});
});
</script>
