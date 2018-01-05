<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP42 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p42-create">

    
    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'no_register'   => $no_register,
        'modeltsk'      => $modeltsk,
        'modelhkm'      => $modelhkm,
        'modelbb'       => $modelbb,
        'jaksap16a'     => $jaksap16a,
    ]) ?>

</div>
