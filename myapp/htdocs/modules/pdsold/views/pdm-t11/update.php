<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT11 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t11-update">

    <?=
    $this->render('_form', [
        'model'                 => $model,
        'sysMenu'               => $sysMenu,
        'no_register_perkara'   => $no_register_perkara,
        'dataJPU'               => $dataJPU,
        'searchJPU'             => $searchJPU,
        'dasar1'                => $dasar1,
        'dasar2'                => $dasar2,
        'dasar3'                => $dasar3,
        'modelpeg'              => $modelpeg,
        'modeltsk'              => $modeltsk,
    ])
    ?>

</div>
