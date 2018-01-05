<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB1 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b1-update">

    <?= $this->render('_form', [
        'model' => $model,
        'modelSpdp' => $modelSpdp
    ]) ?>

</div>
