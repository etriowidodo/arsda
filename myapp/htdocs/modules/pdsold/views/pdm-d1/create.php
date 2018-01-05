<?php

use app\modules\pdsold\models\PdmD1;
use yii\web\View;

/* @var $this View */
/* @var $model PdmD1 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-d1-create">


    <?=
    $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'modeljakpen' => $modeljakpen,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'modelTerpanggil' => $modelTerpanggil
    ])
    ?>

</div>
