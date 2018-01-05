<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP39 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p39-create">

    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'no_register'   => $no_register,
        'agenda'        => $agenda,
        'jaksap16a'     => $jaksap16a,
        'p16a'          => $p16a,
    ]) ?>

</div>
