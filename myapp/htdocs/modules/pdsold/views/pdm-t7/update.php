<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\pdmt7 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdmt7-update">


    <?= $this->render('_form', [
		'model' => $model,
        'modelJpu' => $modelJpu,
        'modelTindakanStatus' => $modelTindakanStatus,
        'modelTersangka'    => $modelTersangka,
        'modelnotaPendapat' => $modelnotaPendapat,
        'modelSpdp' => $modelSpdp,
        'searchJPU' => $searchJPU,
        'dataProviderJPU' => $dataProviderJPU,
        'sysMenu' => $sysMenu
    ]) ?>

</div>
