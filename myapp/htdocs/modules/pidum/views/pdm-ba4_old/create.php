<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA4 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba4-create">

    <?= $this->render('_form', [
        'model' => $model,
		'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
		'modelSpdp' =>$modelSpdp,
		'modelTerdakwa'=>$modelTerdakwa,
		'searchTerdakwa' => $searchTerdakwa,
        'dataTerdakwa' => $dataTerdakwa,
		'modeljaksi' =>$modeljaksi,
        'sysMenu' => $sysMenu,
		'modeltanya' =>$modeltanya,
    ]) ?>

</div>
