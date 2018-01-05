<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP16A */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p16a-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
         'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka,
        'modelPasal' => $modelPasal,
    	'modelJpu' => $modelJpu,
        'dataProviderTersangka' => $dataProviderTersangka,
        'tgl_max' => $tgl_max
    ]) ?>


    <?php
//    $this->render('_form', [
//        'model' => $model,
//        'modelTersangka' => $modelTersangka,
//        'modelTersangkaUpdate' => $modelTersangkaUpdate,
//        'searchJPU' => $searchJPU,
//        'dataJPU' => $dataJPU,
//        'jaksaDefault' => $jaksaDefault,
//        'modeljaksi' => $modeljaksi,
//    ])
    ?>

</div>
