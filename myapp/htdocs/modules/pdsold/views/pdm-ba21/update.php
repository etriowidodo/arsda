<?php

use app\modules\pdsold\models\PdmBa21;
use yii\web\View;

/* @var $this View */
/* @var $model PdmBa21 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba21-update">


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
