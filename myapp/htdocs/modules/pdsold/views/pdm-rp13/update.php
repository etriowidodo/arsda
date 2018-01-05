<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP48 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p48-update">
    <?= $this->render('_form', [
        'model' => $model,
        'searchRegister' => $searchRegister,
        'dataRegister' => $dataRegister,
    ]) ?>

</div>
