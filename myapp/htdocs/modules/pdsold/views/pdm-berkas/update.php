<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBerkas */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-berkas-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
		'modelTahananPenyidik' => $modelTahananPenyidik,
		'modelRp9' => $modelRp9,
        'modelTersangka' => $modelTersangka,
		
        'modelPasal' => $modelPasal,
        'dataProviderTersangka' => $dataProviderTersangka
    ]) ?>

</div>
