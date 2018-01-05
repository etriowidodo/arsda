<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa6 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba6-update">

    <?= $this->render('_form', [
        'model' => $model,
        'no_register_perkara'=>$no_register_perkara,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'dataJPU' => $dataJPU,
        'sysMenu' => $sysMenu,
        'penetapan' => $penetapan,
        'id' => $id
    ]) ?>

</div>
