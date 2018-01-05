<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Inspektur';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Inspektur Models', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_inspektur, 'url' => ['view', 'id' => $model->id_inspektur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="inspektur-model-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
