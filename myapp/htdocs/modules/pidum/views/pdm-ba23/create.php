<?php

use app\modules\pidum\models\PdmBa23;
use yii\web\View;

/* @var $this View */
/* @var $model PdmBa23 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba23-create">


    <?=
    $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'modeljaksi' => $modeljaksi,
        'modeljakpen' => $modeljakpen,
    ])
    ?>

</div>
