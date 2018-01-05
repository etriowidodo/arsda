<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP50 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p50-update">

    <?= $this->render('_form', [
        'model'     => $model,
        'modelSpdp' => $modelSpdp,
        'terdakwa'  => $terdakwa,
        'alasan'    => $alasan,
//        'sysMenu'   => $this->sysMenu
    ]) ?>

</div>
