<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use kartik\widgets\ActiveForm;
// use kartik\widgets\DatePicker;
use app\modules\pengawasan\models\SumberLaporan;
use kartik\datecontrol\DateControl;
use app\models\MsAgama;
use app\models\MsPendidikan;
use app\models\MsWarganegara;
use yii\bootstrap\Modal;
// use app\models\MsJkl;

use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */
/* @var $form yii\widgets\ActiveForm */
?>
<!--<style>
#pelapor-kewarganegaraan_pelapor {
 background-color: #FFF;
  cursor: text;
}
</style>-->
<div class="modalContent">
    <?php
    $form = ActiveForm::begin([
                'id' => 'modalterlapor',
                'type' => ActiveForm::TYPE_HORIZONTAL,
                'enableAjaxValidation' => false,
                'fieldConfig' => [
                    'autoPlaceholder' => false
                ],
                'formConfig' => [
                    'deviceSize' => ActiveForm::SIZE_SMALL,
                    'showLabels' => false
                ]
    ]);
    ?>


   <div class="col-md-12"  style="margin-top:10px;">
        
   </div>


    <hr style="border-color: #c7c7c7;margin: 10px 0;">
    <div class="box-footer" style="margin-top:10px;">
        <!-- <button class="btn btn-primary" type="button" id="btn-tambah-terlapor">Simpan</button>
        <button class="btn btn-primary"  data-dismiss="modal" type="button">Batal</button> -->
    </div>

    <?php ActiveForm::end(); ?>
</div>

