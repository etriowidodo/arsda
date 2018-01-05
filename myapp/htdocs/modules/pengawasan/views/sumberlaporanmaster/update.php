<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Sumber Laporan';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Sumber Laporan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_sumber_laporan, 'url' => ['view', 'id' => $model->id_sumber_laporan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="sumber-laporan-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
