<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA14 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba14-update">

       <?= $this->render('_form', [
        'model' => $model,
		'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka,
		'modelPasal' => $modelPasal,
		'modeljaksi' => $modeljaksi,
		'modeljaksiChoosen' => $modeljaksiChoosen,
		'modelRp9'=>$modelRp9,
	    'id'=> $id,
    ]) ?>

</div>
