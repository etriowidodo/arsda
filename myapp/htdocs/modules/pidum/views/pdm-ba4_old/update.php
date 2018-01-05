<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA4 */
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba4-update">
    <?=
    $this->render('_form', [
        'model' => $model,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'searchTerdakwa' => $searchTerdakwa,
        'dataTerdakwa' => $dataTerdakwa,
        'modeljaksi' => $modeljaksi,
        'modelJaksiChoosen' => $modelJaksiChoosen,
        'modeltanya' => $modeltanya,
        'sysMenu' => $sysMenu,
        'modelSpdp' => $modelSpdp,
		'modelTerdakwa'=>$modelTerdakwa,
        'id' => $id,
    ])
    ?>

</div>
