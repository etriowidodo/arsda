<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB14 */
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b14-update">

    

    <?= $this->render('_form', [
        'model' => $model,
        'model2' => $model2,
        'modelJpu' => $modelJpu,
    ]) ?>

</div>