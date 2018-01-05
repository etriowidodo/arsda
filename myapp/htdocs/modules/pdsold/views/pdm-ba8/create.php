<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA11 */


$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba11-create">

   

    <?=
    $this->render('_form', [
         'model' => $model,
                        'id' => $id,
                        'searchJPU' => $searchJPU,
                        'dataJPU' => $dataJPU,
                        'searchSatker' => $searchSatker,
                        'dataSatker' => $dataSatker,
                        'modeljaksi' => $modeljaksi,
                        'kepalajaksal' => $kepalajaksal,
                        'sysMenu' => $sysMenu,
                        'modelRp9'=>$modelRp9,
                        'modelRt3'=>$modelRt3,
    ])
    ?>

</div>
