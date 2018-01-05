<?php

use yii\helpers\Html;
use app\modules\pidum\models\PdmSysMenu;
use app\components\GlobalConstMenuComponent;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p33-create">

    <?= $this->render('_form', [
        'model'                 => $model,
        'sysMenu'               => $sysMenu,
        'no_register_perkara'   => $no_register_perkara,
        'dataJPU'               => $dataJPU,
        'searchJPU'             => $searchJPU,
        'modeltsk'              => $modeltsk,
    ]) ?>

</div>
