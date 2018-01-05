<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT5 */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p17-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka,
		'dataProviderTersangka' => $dataProviderTersangka
    ]) ?>

</div>
