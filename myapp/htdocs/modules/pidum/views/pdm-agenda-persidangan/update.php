<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP36 */

$this->title = "Agenda Persidangan";
//$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p36-update">

    <?= $this->render('_form', [
        'model'         => $model,
        'modelsdg'      => $modelsdg,
        'majelis1'      => $majelis1,
        'majelis2'      => $majelis2,
        'penasehat1'    => $penasehat1,
        'penasehat2'    => $penasehat2,
        'panitera1'     => $panitera1,
        'panitera2'     => $panitera2,
    ]) ?>

</div>
