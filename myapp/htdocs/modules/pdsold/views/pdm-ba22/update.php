<?php

use app\modules\pdsold\models\PdmBa22;
use yii\web\View;

/* @var $this View */
/* @var $model PdmBa22 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba22-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'modeljaksi' => $modeljaksi,
    ])
    ?>

</div>
