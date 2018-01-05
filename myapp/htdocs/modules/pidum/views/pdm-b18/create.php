<?php

use app\modules\pidum\models\PdmB18;
use yii\web\View;

/* @var $this View */
/* @var $model PdmB18 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b18-create">


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
