<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBA10 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba10-update">

      <?= $this->render('_form', [
        'model' => $model,
        'id' => $id,
        'modelT7' => $modelT7,
        'modelTerdakwa' => $modelTerdakwa
    ]) ?>

</div>
