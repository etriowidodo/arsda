<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa18 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba18-update">
    <?= $this->render('_form', [
        'model' => $model,
		'id_perkara' => $id_perkara,
		'modelSaksi' => $modelSaksi,
		'modelJaksa' => $modelJaksa,
		'searchJPU' => $searchJPU,
		'modelBarbuk' => $modelBarbuk,
		'dataJPU' => $dataJPU,
		'rp9'	=> $rp9,
    ]) ?>

</div>
