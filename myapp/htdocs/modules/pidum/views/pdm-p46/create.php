<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP46 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p46-create">

    <?= $this->render('_form', [
        'model' => $model,
    	'modelSpdp' => $modelSpdp,
    	'dataJPU' => $dataJPU,
        'searchJPU' => $searchJPU,
        'modelP41Terdakwa' => $modelP41Terdakwa,
        'terdakwa' => $terdakwa,
    ]) ?>

</div>
