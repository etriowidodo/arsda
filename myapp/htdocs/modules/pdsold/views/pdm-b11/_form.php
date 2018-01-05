<?php

use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmB11;
use app\modules\pdsold\models\VwPenandatangan;
use app\modules\pdsold\models\PdmMsJnsbrng;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\View;
use yii\widgets\ActiveForm as ActiveForm2;

/* @var $this yii\web\View */
/* @var $model app\models\pdmB11 */
/* @var $form yii\widgets\ActiveForm */
?>

<section class="content" style="padding: 0px;">
    <div class="content-wrapper-1">
        <?php
    $form = ActiveForm::begin(
        [
            'id' => 'b11-form',
            'type' => ActiveForm::TYPE_HORIZONTAL,
            'enableAjaxValidation' => false,
            'fieldConfig' => [
                'autoPlaceholder' => false
            ],
            'formConfig' => [
                'deviceSize' => ActiveForm::SIZE_SMALL,
                'labelSpan' => 2,
                'showLabels' => false

            ]
        ]);
    ?>
	<div class="box box-primary" style="border-color: #f39c12;">
		<div class="box-header with-border" style="border-bottom:none;">
            <fieldset>
				<div class="kv-nested-attribute-block form-sub-attributes form-group">
					<div class="col-sm-12">
						<?= $this->render('//default/_formHeader', ['form' => $form, 'model' => $model]) ?>
					</div>
				 </div>
            </fieldset>
		</div>
	</div>
	
	<div class="box box-primary" style="border-color: #f39c12;">
		<div class="box-header with-border" style="border-bottom:none;">
            <fieldset>
    <div class="col-sm-12">
	
          
            <div class="box-body">
			<!--
			<div class="form-group">
				<label class="control-label col-md-2">Berlokasi Di</label>
				<div class="col-sm-6">
					<?php //echo $form->field($model, 'lokasi')->textarea() ?>
				</div>
			</div>
			-->
			 <div class="box-header with-border" style="border-color: #c7c7c7;">
        <h3 class="box-title" style="margin-top: 5px;">
            <strong>BARANG BUKTI</strong>
        </h3>
    </div>
			<div class="" style="border-bottom:none;">
        <table id="table_barbuk" class="table table-bordered">
            <thead>
            <tr>
                <th width="6%"
                    style="text-align: center;"><?php // Html::buttonInput('Hapus', ['class' => 'btn btn-warning', 'id' => 'tmblhapusbaris']) ?></th> 
                <th width="14%" style="text-align: center;vertical-align: middle;">Nama</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Jumlah [decimal]</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Satuan</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Disita dari</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Tempat Simpan</th>
                <th width="14%" style="text-align: center;vertical-align: middle;">Kondisi</th>
            </tr>
            </thead>
            <tbody id="tbody_barbuk">

            <?php
          // if (!$model->isNewRecord) {
                foreach ($tabelbarbuk as $barbuk):
                    echo '<tr id="row">';
                    echo '<td style="text-align: center"><input type="checkbox" name="chkHapusBarbuk" value="' . $barbuk['nama'] . '" class="chk"></td>';
                    echo '<td><input type="hidden" class="form-control idbarbuk" name="idBarbuk" readonly="true" value="' . $barbuk['id'] . '">';
                    echo '<input type="text" class="form-control" name="pdmBarbukNama[]" readonly="true" value="' . $barbuk['nama'] . '"></td>';
                    echo '<td><input type="text" class="form-control" name="pdmBarbukJumlah[]" readonly="true" value="' . $barbuk['jumlah'] . '"></td>';
                    echo '<td><input type="hidden" class="form-control" name="pdmBarbukSatuan[]" readonly="true" value="' . $barbuk['id_satuan'] . '">';
                    echo '<input type="text" class="form-control" name="txtBarbukSatuan" readonly="true" value="' . \app\modules\pidum\models\PdmMsSatuan::findOne($barbuk['id_satuan'])->nama . '"></td>';
                    echo '<td><input type="text" class="form-control" name="pdmBarbukSitaDari[]" readonly="true" value="' . $barbuk['sita_dari'] . '"></td>';
                    echo '<td><input type="text" class="form-control" name="pdmBarbukTindakan[]" readonly="true" value="' . $barbuk['tindakan'] . '"></td>';
                    echo '<td><input type="hidden" class="form-control" name="pdmBarbukKondisi[]" readonly="true" value="' . $barbuk['id_stat_kondisi'] . '">';
                    echo '<input type="text" class="form-control" name="txtBarbukKondisi" readonly="true" value="' . \app\modules\pidum\models\PdmMsStatusData::findOne(['id' => $barbuk['id_stat_kondisi'], 'is_group' => \app\components\ConstDataComponent::KondisiBarang])->nama . '"></td>';
                    echo '</tr>';
                endforeach;
           // }
            ?>


            </tbody>
        </table>
        
    </div>
			<div class="form-group">
				<label class="control-label col-md-2">
				<input type="button" class="btn btn-primary" id="btn_isibarbuk" value="Pilih Barbuk" />
				</label>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Deskripsi</label>
				<div class="col-sm-6">
					<?php  echo $form->field($model, 'isi_barbuk')->textarea();
						
					?>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-md-2">Jenis</label>
				<div class="col-sm-6">
					<?php  echo Yii::$app->globalfunc->returnRadioList($form,$model, PdmMsJnsbrng::find()->all(),'id','nama','id_msjnsbrng'); 
						//echo Html::radioList('abc', null, [1 => 'Hello', 2 => 'World']);
						//echo $form->field($model, "id_msjnsbrng")->radioList([1 => 'Hello', 2 => 'World']);
					?>
				</div>
			</div>
		</div>
		
    </div>
	 </fieldset>
		</div>
	</div>
	
	
	<div class="box box-primary" style="border-color: #f39c12;">
		<div class="box-header with-border" style="border-bottom:none;">
            <fieldset>
    <div class="col-sm-12">
        
         
            <div class="box-body">
                <div class="form-group">
                    <label class="control-label col-md-2">Penanda Tangan</label>

                    <div class="col-md-3">
                        <?php  echo Yii::$app->globalfunc->returnDropDownList($form,$model, VwPenandatangan::find()->all(),'peg_nik','nama','id_penandatangan')  ?>
                    </div>
                </div>
                <?php echo Yii::$app->globalfunc->getTembusan($form,GlobalConstMenuComponent::B11,$this,$model->id_b11, $model->id_perkara) ?>
            </div>
        
    </div>
	 </fieldset>
		</div>
	</div>

     <hr style="border-color: #c7c7c7;margin: 10px 0;">
      <div class="box-footer" style="text-align: center;">
            <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Ubah', ['class' => $model->isNewRecord ? 'btn btn-warning' : 'btn btn-warning']) ?>
          <?php if(!$model->isNewRecord): ?>  
            <a class="btn btn-warning" href="<?= Url::to(['pdm-b11/cetak?id=' . $model->id_perkara]) ?>">Cetak</a>
          <?php endif ?>  
        </div>

        

    <?php ActiveForm::end(); ?>

</div>
    </section>
	
<?php
$script1 = <<< JS
	
	$("#btn_isibarbuk").click(function() {
		$('#pdmba11-isi_barbuk').val('');
	    var chkArray = [];
	
		$(".chk:checked").each(function() {
			chkArray.push($(this).val());
		});
		
		var no = 1;
		$.each(chkArray , function(i, val) { 
		  $('#pdmb11-isi_barbuk').val($('#pdmb11-isi_barbuk').val()+no+'. '+val+"\\n"); 
		  no++;
		});
	});


JS;
$this->registerJs($script1);
?>
