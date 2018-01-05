<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP25 */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p25-update">

    

    <?= $this->render('_form', [
		'model' => $model,
		'pT7' => $pT7,
		'dasar' => $dasar,
		'searchJPU' => $searchJPU,
		'dataJPU' => $dataJPU,
		'pertimbangan' => $pertimbangan,
		'modelSpdp' => $modelSpdp,
		'modelJaksaSaksi' => $modelJaksaSaksi,
    ]) ?>

</div>
