<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP18*/

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p18-update">

    <?= $this->render('_form', [
      	'model' => $model,
	    'modelSpdp' => $modelSpdp,
	    'modelPengantar' => $modelPengantar,
	    'modelBerkas' => $modelBerkas,
	    'modelTersangka' => $modelTersangka,
	    'modelInsPenyidik' => $modelInsPenyidik,
	    'sysMenu' => $sysMenu
    ]) ?>

</div>
