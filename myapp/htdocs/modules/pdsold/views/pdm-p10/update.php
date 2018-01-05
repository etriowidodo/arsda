<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP10 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p10-update">

      <?= $this->render('_form', [
        'model' => $model,
		'modelTersangka' => $modelTersangka,
        'modelSpdp' => $modelSpdp,
    ]) ?>

</div>
