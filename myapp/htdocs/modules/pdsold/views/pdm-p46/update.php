<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP46 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p46-update">

    <?= $this->render('_form', [
        'model' => $model,
    	'modelSpdp' => $modelSpdp,
    	'modeljaksi' => $modeljaksi,
    	'searchJPU' => $searchJPU,
    	'dataJPU' => $dataJPU,
    	'terdakwa' => $terdakwa,
    ]) ?>

</div>
