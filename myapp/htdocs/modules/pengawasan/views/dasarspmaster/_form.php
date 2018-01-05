<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dasar-sp-was-master-form">

    <?php $form = ActiveForm::begin(
    ); ?>
<!--
    <?= $form->field($model, 'id_dasar_spwas')->textInput(['maxlength' => true]) ?>-->
    <div class="content-wrapper-1">
	<div class="box box-primary" style="padding: 15px;overflow: hidden;">
		<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-2">Isi Dasar SP Was</label>
					<div class="col-md-10">

						<?= $form->field($model, 'isi_dasar_spwas')->textarea(['rows' => 6]) ?>
					</div>
				</div>
		</div>
		<div class="col-md-12">
				<div class="form-group">
					<label class="col-md-2">Tahun Dasar SP Was</label>
					<div class="col-md-2" style="width: 108px;">
                        <?php
                            $now=date('Y');
                            $beginYear=date('Y')-10;
                            for($i=$beginYear;$i<=$now;$i++){
                                $year[$i]=$i;
                            };
                        ?>
						<?//= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'tahun')->dropDownList($year)?>
					</div>
				</div>
		</div>

    <!--<?= $form->field($model, 'tahun')->textInput(['maxlength' => true]) ?>-->

</div>
	<div class="form-group" style="text-align: center;">
        <?= Html::submitButton($model->isNewRecord ? 'Tambah' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-primary' : 'btn btn-primary']) ?>
        <input action="action" type="button" value="Kembali" class="btn btn-primary" onclick="history.go(-1);" />
    </div>
</div>
    <?php ActiveForm::end(); ?>

</div>

<script type="text/javascript">
$(document).ready(function(){
	$(".control-label").hide();
});
</script>
