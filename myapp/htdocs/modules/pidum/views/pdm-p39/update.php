<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP39 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p39-update">

    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'no_register'   => $no_register,
        'agenda'        => $agenda,
        'jaksap16a'     => $jaksap16a,
        'p16a'          => $p16a,
        'majelis1'      => $majelis1,
        'majelis2'      => $majelis2,
        'penasehat1'    => $penasehat1,
        'penasehat2'    => $penasehat2,
        'panitera1'     => $panitera1,
        'panitera2'     => $panitera2,
    ]) ?>

</div>
