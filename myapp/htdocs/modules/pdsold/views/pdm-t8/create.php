<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT8 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-t8-create">

    <?= $this->render('_form', [
        'model'                 => $model,
        'modelRp9'              => $modelRp9,
        'modelSpdp'             => $modelSpdp,
        'searchJPU'             => $searchJPU,
        'dataJPU'               => $dataJPU,
        'sysMenu'               => $sysMenu,
        'no_surat_t7'           => $no_surat_t7,
        'no_register_perkara'   => $no_register_perkara,
        'modeljaksi'            => $modeljaksi,
    ]) ?>
    
    


</div>
