<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use app\modules\datun\models\InstansiJenis;

	$jnsTxt	= $model['kode'].' | '.$model['jabatan_ttd'];
	$reqSts = 'required data-error="Penandatangan belum dipilih"';
?>
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/datun/ttd-pejabat/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Kode Jabatan</label>
                <div class="col-md-8">
					<?php if($isNewRecord){ ?>
                    <select id="kode_ttd" name="kode_ttd" class="select2" style="width:100%;" required data-error="Kode jabatan belum dipilh">
                        <option></option>
                        <?php 
                            $sqlOpt = "select * from datun.m_penandatangan where kode_tk = '".$_SESSION['kode_tk']."' order by kode";
                            $resOpt = InstansiJenis::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
                                echo '<option value="'.$dOpt['kode'].'">'.$dOpt['deskripsi'].'</option>';
                            }
                        ?>
                    </select>
					<?php } else{ ?>
                	<input type="hidden" name="kode_ttd" id="kode_ttd" value="<?php echo $model['kode'];?>" />
                    <input type="text" name="kode_txt" id="kode_txt" class="form-control" value="<?php echo $jnsTxt;?>" readonly />
					<?php } ?>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Nama</label>
                <div class="col-md-8">
                	<?php if($isNewRecord){ ?>
					<select name="peg_nip" id="peg_nip" class="form-control" required data-error="Nama belum dipilih">
                    	<option></option>
                        <?php 
                            $sqlOpt = "select peg_nip_baru, peg_nip_baru||'#'||nama||'#'||jabatan||'#'||case when pns_jnsjbtfungsi = 0 then gol_kd||' '||gol_pangkatjaksa 
									else gol_kd||' '||gol_pangkat2 end as nama 
									from kepegawaian.kp_pegawai where eselon is not null and inst_satkerkd = '".$_SESSION['inst_satkerkd']."' 
									order by ref_jabatan_kd";
							$resOpt = InstansiJenis::findBySql($sqlOpt)->asArray()->all();
                            foreach($resOpt as $dOpt){
								$selected = ($model['nip'] == $dOpt['peg_nip_baru']?'selected':'');
                                echo '<option value="'.$dOpt['peg_nip_baru'].'" '.$selected.'>'.$dOpt['nama'].'</option>';
                            }
                        ?>
                    </select>
                	<?php } else{ ?>
                	<input type="hidden" name="peg_nip" id="peg_nip" value="<?php echo $model['nip']; ?>" />
                	<input type="text" name="pegnama" id="pegnama" class="form-control" value="<?php echo $model['nip'].' | '.$model['nama']; ?>" readonly />
                	<?php } ?>
                    <div class="help-block with-errors" id="pejabatnya"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Pangkat</label>
                <div class="col-md-8">
                	<input type="text" name="pangkat" id="pangkat" class="form-control" value="<?php echo $model['pangkat']; ?>" readonly />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Jabatan</label>
                <div class="col-md-8">
                	<input type="text" name="jabatan" id="jabatan" class="form-control" value="<?php echo $model['jabatan']; ?>" readonly />
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-3">Penandatangan</label>
                <div class="col-md-8">
                    <div class="radio" style="padding:0px;">
                        <label class="radio-inline" style="padding-left:0px;">
                        	<input type="radio" name="status" id="status1" value="Asli" <?php echo ($model['status']=='Asli')?'checked':'';?> <?php echo $reqSts;?> />Asli
						</label>
                        <label class="radio-inline">
                        	<input type="radio" name="status" id="status2" value="Plt" <?php echo ($model['status']=='Plt')?'checked':'';?> <?php echo $reqSts;?> />Plt
                        </label>
                        <label class="radio-inline">
                        	<input type="radio" name="status" id="status3" value="Plh" <?php echo ($model['status']=='Plh')?'checked':'';?> <?php echo $reqSts;?> />Plh
                        </label>
                        <label class="radio-inline">
                        	<input type="radio" name="status" id="status4" value="A.N" <?php echo ($model['status']=='A.N')?'checked':'';?> <?php echo $reqSts;?> />A.N
                        </label>
                    </div>
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
    <a href="/datun/ttd-pejabat/index" class="btn btn-danger">Batal</a>
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
