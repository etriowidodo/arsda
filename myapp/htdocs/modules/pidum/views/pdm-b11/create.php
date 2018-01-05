<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\pdmB11 */
$this->title = $sysMenu->kd_berkas;
$this->subtitle = $sysMenu->keterangan;
?>
<div class="pdm-b11-create">

    

    <?= $this->render('_form', [
        'model' => $model,
		'tabelbarbuk' => $tabelbarbuk,
    ]) ?>

</div>
