<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p30-create">

    <?= $this->render('_form', [
        'sysMenu'       => $sysMenu,
        'model'         => $model,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        'no_register'   => $no_register,
        'ba4tsk'        => $ba4tsk,
        'modeluu'       => $modeluu,
        'searchUU'      => $searchUU,
        'dataUU'        => $dataUU,
    ]) ?>

</div>
