<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP11 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-p11-create">
    <?= $this->render('_form', [
        'model' => $model,
        // 'modelSpdp' => $modelSpdp,
        'modelTersangka' => $modelTersangka
    ]) ?>

</div>
