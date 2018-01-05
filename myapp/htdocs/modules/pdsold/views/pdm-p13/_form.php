<?php

use yii\helpers\Html;
use kartik\datecontrol\DateControl;
use kartik\widgets\ActiveForm;
use app\modules\pdsold\models\PdmP13;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP11 */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="box box-primary">
    <div class="box-header"></div>
<?php
        $form = ActiveForm ::begin(
            [
                'id' => 'p13-form',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder'=>false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'labelSpan' => 1,
                    'showLabels'=>false

                ]
            ]);
		 
        ?>

    <div class="row">
        <div class="col-md-12" >
            <div class="box-header with-border">
                <br>
                <div class="form-group" style="margin-left:-300px; margin-top:-20px">
                    <label for="no_surat_p13" class="control-label col-md-4">Nomor Surat P13</label>
                    <div class="col-md-2"><?= $form->field($model, 'no_surat_p13') ?></div>
                </div>
                <div class="form-group" style="margin-left:-300px">
                    <label for="sifat" class="control-label col-md-4">Sifat</label>
                    <div class="col-md-2"><?= $form->field($model, 'sifat') ?></div>
                </div>
                <div class="form-group" style="margin-left:-300px">
                    <label for="lampiran" class="control-label col-md-4">Lampiran</label>
                    <div class="col-md-2"><?= $form->field($model, 'lampiran') ?></div>
                </div>
                <div class="form-group" style="margin-left:-274px">
                    <label for="dikeluarkan" class="control-label col-md-4" style="margin-left:-18px">Tgl Dikeluarkan</label>
                    <div class="col-md-2" style="margin-left:1px">
                        <?php
                            echo $form->field($model, 'dikeluarkan')->widget(DateControl::classname(), [
                                'type'=>DateControl::FORMAT_DATE,
                                'ajaxConversion'=>false,
                                'options' => [
                                    'pluginOptions' => [
                                        'autoclose' => true
                                    ]
                                ]
                            ]);

                        ?>
                    </div>
                </div>
                <div class="panel box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">KEPADA</h3>
                    </div>
                    <br>
                    <div class="form-group" style="margin-left:-300px">
                        <label for="kepada" class="control-label col-md-4">Kepada</label>
                        <div class="col-md-2"><?= $form->field($model, 'kepada') ?></div>
                    </div>
                    <div class="form-group" style="margin-left:-300px">
                        <label for="kepada" class="control-label col-md-4">Di</label>
                        <div class="col-md-2"><?= $form->field($model, 'kepada') ?></div>
			<div class="form-group" style="margin-left:-380px;">
                            <label for="kepada" class="control-label col-md-4" style="margin-left:255px; margin-top:5px;">Kejaksaan</label>
                            <div class="col-md-1" style="margin-left:-6px; margin-top:5px"><?= $form->field($model, 'kepada') ?></div>
                            <button class="btn btn-primary" type="submit" style="margin-left:-65px; margin-top:50px">Cari</button>
			</div>
                    </div>
                </div>
                <div class="panel box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">LOKASI</h3>
                    </div>
                    <br>
                    <div class="form-group" style="margin-left:-300px;">
                        <label for="kepada" class="control-label col-md-4">Lokasi</label>
                        <div class="col-md-2"><?= $form->field($model, 'kepada') ?></div>
                    </div>
                    <div class="form-group" style="margin-left:-300px">
                        <label for="kepada" class="control-label col-md-4" style="margin-left:5px">No Surat Perintah</label>
                        <div class="col-md-2" style="margin-left:-5px"><?= $form->field($model, 'kepada') ?></div>
                    </div>
                    <div class="form-group" style="margin-left:-275px">
                        <label for="dikeluarkan" class="control-label col-md-4" style="margin-left:-13px">Tgl Surat Perintah</label>
                        <div class="col-md-2" style="margin-left:-4px">
                            <?php
                                echo $form->field($model, 'dikeluarkan')->widget(DateControl::classname(), [
                                    'type'=>DateControl::FORMAT_DATE,
                                    'ajaxConversion'=>false,
                                    'options' => [
                                        'pluginOptions' => [
                                            'autoclose' => true
                                        ]
                                    ]
                                ]);

                            ?>
                        </div>
                    </div>
                    <div class="form-group" style="margin-left:-285px;">
                        <label for="kepada" class="control-label col-md-4" style="margin-left:-5px; margin-top:5px;">Tersangka</label>
                        <div class="col-md-2" style="margin-left:-6px; margin-top:5px"><?= $form->field($model, 'kepada') ?></div>
                        <button class="btn btn-primary" type="submit" style="margin-left:-1px; margin-top:5px">Cari</button>
                    </div>
                </div>
                <div class="panel box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">KETERANGAN</h3>
                    </div>
                    <br>
                    <div class="form-group" style="margin-left:-300px" >
                        <label for="ket_saksi" class="control-label col-md-4">Keterangan Saksi</label>
                        <div class="col-md-2"><?= $form->field($model, 'ket_saksi')->textarea() ?></div>
                    </div>
                    <div class="form-group" style="margin-left:-300px">
                        <label for="ket_ahli" class="control-label col-md-4">Keterangan Ahli</label>
                        <div class="col-md-2"><?= $form->field($model, 'ket_ahli')->textarea() ?></div>
                    </div>
                    <div class="form-group" style="margin-left:-300px" >
                        <label for="ket_surat" class="control-label col-md-4">Surat-Surat</label>
                        <div class="col-md-2"><?= $form->field($model, 'ket_surat')->textarea() ?></div>
                    </div>
                    <div class="form-group"  style="margin-left:-300px">
                        <label for="petunjuk" class="control-label col-md-4">Petunjuk</label>
                        <div class="col-md-2"><?= $form->field($model, 'petunjuk')->textarea() ?></div>
                    </div>
                    <div class="form-group" style="margin-left:-300px" >
                        <label for="ket_tersangka" class="control-label col-md-4">Keterangan Tersangka</label>
                        <div class="col-md-2" ><?= $form->field($model, 'ket_tersangka')->textarea() ?></div>
                    </div>
                </div>
                <div class="col-md-12" style="border-style:''; border-width:1px; margin-left:410px; margin-top:-337pt;width:400px;text-align:left; " >
                    <div class="form-group" >
                        <label for="hukum" class="control-label col-md-6">Fakta Hukum</label>
                        <div class="col-md-6"><?= $form->field($model, 'hukum')->textarea() ?></div>
                    </div>
                    <div class="form-group" >
                        <label for="yuridis" class="control-label col-md-6">Yuridis</label>
                        <div class="col-md-6"><?= $form->field($model, 'yuridis')->textarea() ?></div>
                    </div>
                    <div class="form-group" >
                        <label for="kesimpulan" class="control-label col-md-6">Kesimpulan</label>
                        <div class="col-md-6"><?= $form->field($model, 'kesimpulan')->textarea() ?></div>
                    </div>
                    <div class="form-group" >
                        <label for="saran" class="control-label col-md-6">Saran</label>
                        <div class="col-md-6"><?= $form->field($model, 'saran')->textarea() ?></div>
                    </div>
                </div>
                <div class="panel box box-warning">
                    <div class="box-header with-border">
                        <h3 class="box-title">PENANDA TANGAN</h3>
                    </div>
                    <br>
                    <?php
                    if($modelTersangka != null){
                        foreach($modelTersangka as $key => $value){
                            // echo "<tr><td>".$value['nama']."</td></tr>";
                            ?>
                            <div class="form-group">
                                <label for="id_p17" class="control-label col-md-2">Nama Tersangka</label>
                                <div class="col-md-3">
                                    <input type="text" class="form-control" value="<?= $value['nama'] ?>" readonly="true">
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                    <div class="form-group" style="margin-left:-30px">
                        <label class="control-label col-md-2">Penanda Tangan</label>
                        <div class="col-md-2">
                            <?php
                            $listpenandatangan = ['1' => 'Kajari'];
                            echo $form->field($model, 'id_ba5')->dropDownList($listpenandatangan);
                            ?>
                        </div>
                        <button class="btn btn-primary" type="submit" style="margin-left:-7px; margin-top:-1px">Cari</button>
                    </div>
		</div>
            </div>
        </div>
        <div class="form-group" style="margin-left:20px">
            <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
