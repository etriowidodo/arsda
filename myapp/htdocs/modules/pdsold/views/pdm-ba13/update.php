<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA13 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;


?>
<div class="pdm-ba13-update">


    <?= $this->render('_form', [
        'model' => $model,
        'searchJPU' => $searchJPU,
        'dataJPU' => $dataJPU,
        'modeljaksi' => $modeljaksi,
        'modeljaksiChoosen' => $modeljaksiChoosen,
        'id' => $id,
        'modelRp9' => $modelRp9,
        'modelSpdp' => $modelSpdp,
        'modelLokTahanan' => $modelLokTahanan,
    ]) ?>

</div>
