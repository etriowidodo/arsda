<?php
	use yii\helpers\Html;
	use yii\widgets\ActiveForm;
	use mdm\admin\models\searchs\Menu as MenuSearch;
?>
<div class="pdm-config-form">
<form id="role-form" name="role-form" class="form-validasi form-horizontal" method="post" action="/pidum/pdm-config/simpan">
<input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
<div style="border-color: #f39c12;padding: 15px;overflow: hidden;" class="box box-primary">
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Satker</label>
                <div class="col-md-8">
                	<select name="kd_satker" id="kd_satker" class="select2" style="width:100%" required data-error="Satker Belum diisi">
                    	<option></option>
                        <?php 
                            $resOpt = MenuSearch::findBySql("select * from kepegawaian.kp_inst_satker")->asArray()->all();
                            foreach($resOpt as $dOpt){
								$selected = ($model['kd_satker'] == $dOpt['inst_satkerkd']?'selected':'');
                                echo '<option value="'.$dOpt['inst_satkerkd'].'" '.$selected.'>'.$dOpt['inst_nama'].'</option>';
                            }
                        ?>
                    </select>
                	<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <div class="form-group">
                <label class="control-label col-md-4">Time Format</label>
                <div class="col-md-4">
                	<select name="time_format" id="time_format" class="select2" style="width:100%" required data-error="Time Format Belum diisi">
                    	<option></option>
                        <option value="WIB" <?php echo ($model['time_format'] == 'WIB'?'selected':''); ?>>WIB</option>
                    	<option value="WITA" <?php echo ($model['time_format'] == 'WITA'?'selected':''); ?>>WITA</option>
                    	<option value="WIT" <?php echo ($model['time_format'] == 'WIT'?'selected':''); ?>>WIT</option>
                    </select>
					<div class="help-block with-errors"></div>
				</div>
            </div>
        </div>
    </div>
</div>
<hr style="border-color: #c7c7c7;margin: 10px 0;">
<div class="box-footer text-center"> 
    <input type="hidden" name="act" id="act" value="<?php echo $act; ?>" />
    <button class="btn btn-warning jarak-kanan" type="submit" id="simpan"><?php echo ($act)?'Simpan':'Ubah';?></button>
    <a href="/pidum/pdm-config/index" class="btn btn-danger">Batal</a>
</div>
</form>
</div>
