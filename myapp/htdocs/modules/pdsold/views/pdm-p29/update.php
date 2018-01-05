<?php

use yii\helpers\Html;
use app\components\GlobalConstMenuComponent;
use app\modules\pdsold\models\PdmSysMenu;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT8 */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;

?>
<div class="pdm-p29-update">

    <?= $this->render('_form', [
        'sysMenu'       => $sysMenu,
        'model'         => $model,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        'ba4tsk'        => $ba4tsk,
        'riwayat'       => $riwayat,
        'modeluu'       => $modeluu,
        'searchUU'      => $searchUU,
        'dataUU'        => $dataUU,
    ]) ?>

</div>
