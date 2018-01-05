<?php

use app\modules\pidum\models\PdmB21;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB21 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b21-update">


    <?=
    $this->render('_form', [
        'model' => $model,
        'modelJaksa' => $modelJaksa,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
    ])
    ?>

</div>
