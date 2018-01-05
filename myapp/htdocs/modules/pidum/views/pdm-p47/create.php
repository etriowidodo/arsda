<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP47 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p47-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'modelSpdp' => $modelSpdp,
    	'terdakwa' => $terdakwa,
    	'dataJPU' => $dataJPU,
    	'searchJPU' => $searchJPU,
    ]) ?>

</div>
