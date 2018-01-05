<?php
	use yii\helpers\Html;
	use yii\grid\GridView;
	use yii\widgets\Pjax;
	use yii\widgets\ActiveForm;
	use yii\helpers\ArrayHelper;
	use app\modules\datun\models\searchs\Menu as MenuSearch;
?>
<div id="wrapper-modalPengadilan">
    <form class="form-horizontal" id="frm-m3">
		<?php if($model['isNewRecord']){ ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Pengadilan</label>
                    <div class="col-md-8">
                        <div class="radio" style="padding:0px;">
                            <label class="radio-inline" style="padding-left:0px; font-size:12px;"><input type="radio" name="tingkat" id="tingkat1" value="1" />Tinggi</label>
                            <label class="radio-inline" style="font-size:12px;"><input type="radio" name="tingkat" id="tingkat2" value="2" />Negeri</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Provinsi</label>
                    <div class="col-md-8">
                        <select id="propinsi" name="propinsi" class="select2" style="width:100%;">
                            <option></option>
                            <?php 
                                $resOpt = MenuSearch::findBySql("select * from datun.m_propinsi order by id_prop")->asArray()->all();
                                foreach($resOpt as $dOpt){
                                    echo '<option value="'.$dOpt['id_prop'].'">'.$dOpt['deskripsi'].'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    
        <div class="row kabupatennya hide">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Kabupaten</label>
                    <div class="col-md-8">
                        <select id="kabupaten" name="kabupaten" class="select2" style="width:100%;">
                        </select>
                        <div class="help-block with-errors"></div>
                    </div>
                </div>
            </div>
        </div>    
        <?php } else{ ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Deskripsi</label>
                    <div class="col-md-8">
                        <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $model['nama_pengadilan'];?>" />
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" name="propinsi" id="propinsi" value="<?php echo $model['kode_pengadilan_tk1'];?>" />
        <input type="hidden" name="kabupaten" id="kabupaten" value="<?php echo $model['kode_pengadilan_tk2'];?>" />
        <input type="hidden" name="tingkat" id="tingkat" value="<?php echo ($model['kode_pengadilan_tk2'] == '00')?'1':'2';?>" />
        <?php } ?>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group form-group-sm">
                    <label class="control-label col-md-3">Alamat</label>
                    <div class="col-md-8">
                        <textarea id="alamat" name="alamat" class="form-control" style="height:90px;"><?php echo $model['alamat'];?></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="help-block text-red" style="font-style:italic" id="errornya-modal-pengadilan"></div>
        <hr style="border-color: #c7c7c7;margin: 10px 0;">
        <div class="box-footer text-center"> 
            <input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $model['isNewRecord'];?>" />
            <button type="button" id="simpan_form_pengadilan" class="btn btn-warning btn-sm jarak-kanan"><i class="fa fa-floppy-o jarak-kanan"></i>Simpan</button>
            <a class="btn btn-danger btn-sm" id="form_keluar3"><i class="fa fa-reply jarak-kanan"></i>Kembali</a>
        </div>
    </form>
    <div class="modal-loading-new"></div>
</div>
<style>
	#wrapper-modalPengadilan.loading {overflow: hidden;}
	#wrapper-modalPengadilan.loading .modal-loading-new {display: block;}

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
	$("input[type='radio']:not(.simple)").iCheck({radioClass: 'iradio_square-blue'});

	$("input[name='tingkat']").on("ifChecked", function(){
		var nilai = $(this).val();
		if(nilai == 1){
			$(".kabupatennya").addClass("hide");
			$("select#kabupaten").val("").trigger('change').select2('close');
		} else if(nilai == 2){
			$(".kabupatennya").removeClass("hide");
			$("select#propinsi").trigger('change');
		}
	});

	$("select#propinsi").change(function(){
		$("select#kabupaten").val("").trigger('change').select2('close');
		$("select#kabupaten option").remove();
		$.ajax({
			type	: "POST",
			url		: '<?php echo Yii::$app->request->baseUrl.'/datun/permohonan/getkabupaten'; ?>',
			data	: { q1 : $("select#propinsi").val() },
			cache	: false,
			dataType: 'json',
			success : function(data){ 
				if(data.items != ""){
					$("select#kabupaten").select2({placeholder:"Pilih salah satu", allowClear:true, data:data.items});
					return false;
				}
			}
		});
	});
});
</script>