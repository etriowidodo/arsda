<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa6 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba6-create">

    <?= $this->render('_form', [
        'model' => $model,
        'modeljaksi' => $modeljaksi,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'modelSpdp' => $modelSpdp,
        'p16a' => $p16a,
        'penetapan' => $penetapan,
        'no_register_perkara'=>$no_register_perkara,
    ]) ?>

</div>
