<?php
	use yii\helpers\Html;
	use app\modules\datun\models\MsWilayahSearch as MsWilayah;
	use app\modules\datun\models\MsWilayahkabSearch as MsWilayahkab;
	use yii\widgets\ActiveForm;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/pengadilan/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
	<?php if($isNewRecord){ ?>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Pengadilan</label>
                <div class="col-md-8">
                	<div id="labelTingkat">
                        <input type="radio" name="tingkat" id="tingkat1" value="1" required data-error="Tingkat belum dipilih" /> Tinggi
                        <span class="jarak-kanan">&nbsp;&nbsp;</span>
                        <input type="radio" name="tingkat" id="tingkat2" value="2" required data-error="Tingkat belum dipilih" /> Negeri
					</div>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Provinsi</label>
                <div class="col-md-8">
                    <select id="propinsi" name="propinsi" class="select2" style="width:100%;" required data-error="Propinsi belum dipilih">
                        <option></option>
                        <?php 
                            $sqlOpt = "select * from datun.m_propinsi order by id_prop";
							$resOpt = MsWilayah::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
                                echo '<option value="'.$dOpt['id_prop'].'">'.$dOpt['deskripsi'].'</option>';
                            }
                        ?>
                    </select>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>

    <div class="row kabupatennya hide">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Kabupaten</label>
                <div class="col-md-8">
                    <select id="kabupaten" name="kabupaten" class="select2" style="width:100%;" required data-error="Kabupaten belum dipilih">
                    </select>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>    
	<?php } else{ ?>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Deskripsi</label>
                <div class="col-md-8">
                    <input type="text" id="deskripsi" name="deskripsi" class="form-control" value="<?php echo $model['nama_pengadilan'];?>" required data-error="Deskripsi belum diisi" />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
	<input type="hidden" name="propinsi" id="propinsi" value="<?php echo $model['kode_pengadilan_tk1'];?>" />
	<input type="hidden" name="kabupaten" id="kabupaten" value="<?php echo $model['kode_pengadilan_tk2'];?>" />
	<?php } ?>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Alamat</label>
                <div class="col-md-8">
                    <textarea id="alamat" name="alamat" class="form-control"><?php echo $model['alamat'];?></textarea>
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
    <a href="/datun/pengadilan/index" class="btn btn-danger">Batal</a>
</div>
</form>

<div class="modal-loading-new"></div>
<script type="text/javascript">
	$(document).ready(function(){
		$("input[name='tingkat']").on("ifChecked", function(){
			var nilai = $(this).val();
			if(nilai == 1){
				$(".kabupatennya").addClass("hide");
				$("select#kabupaten").val("").trigger('change').select2('close');
				$('#role-form').validator('update')
			} else if(nilai == 2){
				$(".kabupatennya").removeClass("hide");
				$("select#propinsi").trigger('change');
				$('#role-form').validator('update')
			}
		});

		$("select#propinsi").change(function(){
			$("select#kabupaten").val("").trigger('change').select2('close');
			$("select#kabupaten option").remove();
			$.ajax({
				type	: "POST",
				url		: '<?php echo Yii::$app->request->baseUrl.'/datun/pengadilan/getkabupaten'; ?>',
				data	: { q1 : $("select#propinsi").val() },
				cache	: false,
				dataType: 'json',
				success : function(data){ 
					if(data.items != ""){
						$("select#kabupaten").select2({ 
							data 		: data.items, 
							placeholder : "Pilih salah satu", 
							allowClear 	: true, 
						});
						return false;
					}
				}
			});
		});
	});
</script>


