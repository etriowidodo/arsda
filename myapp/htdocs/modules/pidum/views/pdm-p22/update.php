<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP22 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p22-update">

    <?= $this->render('_form', [
        'model' => $model,
    	'modelSpdp' => $modelSpdp,
		'modelBerkas' => $modelBerkas,
		'modelTersangka' => $modelTersangka,
    	'p19' => $p19,
    	'data_berkas' => $data_berkas
    ]) ?>

</div>
