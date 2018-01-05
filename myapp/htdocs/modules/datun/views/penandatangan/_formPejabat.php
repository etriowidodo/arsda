<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\Penandatangan;
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/penandatangan/simpanpejabat">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Nama</label>
                <div class="col-md-6">
                	<?php if($isNewRecord){ ?>
					<select name="peg_nip" id="peg_nip" class="form-control" required data-error="Nama belum dipilih">
                    	<option></option>
                        <?php 
                            $sqlOpt = "select peg_nip_baru, peg_nip_baru||'#'||nama||'#'||jabatan||'#'||case when pns_jnsjbtfungsi = 0 then gol_kd||' '||gol_pangkatjaksa 
									else gol_kd||' '||gol_pangkat2 end as nama 
									from kepegawaian.kp_pegawai where eselon is not null and inst_satkerkd = '".$_SESSION['inst_satkerkd']."' 
									order by ref_jabatan_kd";
							$resOpt = Penandatangan::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
								$selected = ($model['nip'] == $dOpt['peg_nip_baru']?'selected':'');
                                echo '<option value="'.$dOpt['peg_nip_baru'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                            }
                        ?>
                    </select>
                	<?php } else{ ?>
                	<input type="hidden" name="peg_nip" id="peg_nip" value="<?php echo $model['nip']; ?>" />
                	<input type="text" name="pegnipNama" id="pegnipNama" class="form-control" value="<?php echo $model['nip'].' | '.$model['nama']; ?>" readonly />
                	<?php } ?>
                    <div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Pangkat</label>
                <div class="col-md-6">
                	<input type="text" name="pangkat" id="pangkat" class="form-control" value="<?php echo $model['pangkat']; ?>" readonly />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Jabatan</label>
                <div class="col-md-6">
                	<input type="text" name="jabatan" id="jabatan" class="form-control" value="<?php echo $model['jabatan']; ?>" readonly />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label class="control-label col-md-2">Penandatangan</label>
                <div class="col-md-10">
                	<div class="radio">
                        <label><input type="radio" name="status" id="status1" value="Asli" <?php echo ($model['status'] == 'Asli')?'checked':''; ?> required data-error="Penandatangan belum dipilih" /> Asli</label>
                        <label><input type="radio" name="status" id="status2" value="Plt" <?php echo ($model['status'] == 'Plt')?'checked':''; ?> required data-error="Penandatangan belum dipilih" /> Plt</label>
                        <label><input type="radio" name="status" id="status3" value="Plh" <?php echo ($model['status'] == 'Plh')?'checked':''; ?> required data-error="Penandatangan belum dipilih" /> Plh</label>
                        <label><input type="radio" name="status" id="status4" value="A.N" <?php echo ($model['status'] == 'A.N')?'checked':''; ?> required data-error="Penandatangan belum dipilih" /> A.N</label>
					</div>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">

<div class="box-footer text-center"> 
	<input type="hidden" name="isNewRecord" id="isNewRecord" value="<?php echo $isNewRecord;?>" />
	<input type="hidden" name="kode" id="kode" value="<?php echo $model['kode'];?>" />
	<input type="hidden" name="kode_tk" id="kode_tk" value="<?php echo $model['kode_tk'];?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan" name="simpan"><?php echo ($isNewRecord)?'Simpan':'Simpan';?></button>
    <a href="<?php echo '/datun/penandatangan/viewpejabat?id='.$model['kode'];?>" class="btn btn-danger">Batal</a>
</div>
</form>
<div class="modal-loading-new"></div>
<script>
	$(document).ready(function(){
		$("select#peg_nip").select2({
			placeholder	: "Pilih salah satu",
			allowClear	: true,
			templateResult : function(repo){ 
				if(repo.loading) return repo.text;
				var text1 = repo.text.split("#");
				var $returnString = $('<span>'+text1[0]+' | '+text1[1]+'</span>');
				return $returnString;
			},
			templateSelection : function(repo){ 
				if(!repo.id) return repo.text;
				var text1 = repo.text.split("#");
				var $returnString = $('<span>'+text1[0]+' | '+text1[1]+'</span>');
				return $returnString;
			},
		}).on('select2:select', function(evt){
			var text = evt.params.data.text.toString();
			var temp = text.split('#');
			$("#jabatan").val(temp[2]);
			$("#pangkat").val(temp[3]);
		}).on('select2:unselect', function(evt){
			$("#jabatan").val("");
			$("#pangkat").val("");
		});
	});
</script>
