<?php

use app\modules\pdsold\models\PdmD4;
use yii\web\View;

/* @var $this View */
/* @var $model PdmD4 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-d4-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'sysMenu' => $sysMenu,
        'modeljakpen' => $modeljakpen,
        'modelSpdp' => $modelSpdp,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'putusan' => $putusan,
        'putusanTerdakwa' => $putusanTerdakwa,
    ])
    ?>

</div>
