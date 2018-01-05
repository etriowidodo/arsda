<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba17-create">

 

    <?= $this->render('_form', [
        'model'         => $model,
        'sysMenu'       => $sysMenu,
        'modeltsk'      => $modeltsk,
        'wilayah'       => $wilayah,
        'modelJpu'      => $modelJpu,
        'modeljaksi'    => $modeljaksi,
        'searchJPU'     => $searchJPU,
        'dataJPU'       => $dataJPU,
        
    ]) ?>

</div>
