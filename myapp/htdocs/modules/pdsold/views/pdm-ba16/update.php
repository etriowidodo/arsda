<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBa16 */

$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-ba16-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelJpu' => $modelJpu,
        'listTersangka' => $listTersangka,
        'wilayah' => $wilayah,
        'data_barbuk' => $data_barbuk,
    ]) ?>

</div>
