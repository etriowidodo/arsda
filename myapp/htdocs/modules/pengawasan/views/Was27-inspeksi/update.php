<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Was 27 Inspeksi';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Was 27 Inspeksi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_27_inspeksi, 'url' => ['view', 'id' => $model->id_was_27_inspeksi]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was27-inspeksi-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model, 
        'modelTembusan' => $modelTembusan,
        'modelTerlapor' => $modelTerlapor,
        'modelPelapor' => $modelPelapor,
		'modelWas27Detail' => $modelWas27Detail,
		'modelLapdu' => $modelLapdu,
    ]) ?>

</div>
