<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP20 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p20-update">

    <?= $this->render('_form', [
        'model' => $model,
		//'modelPasalBerkas' => $modelPasalBerkas,
		'modelTersangka' => $modelTersangka,
    	//'modelP19' => $modelP19,
    	//'modelSpdp' => $modelSpdp,
    	'data_berkas' => $data_berkas,
    ]) ?>

</div>
