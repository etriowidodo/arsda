<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Inspektur Muda';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Inspektur Muda', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_irmud, 'url' => ['view', 'id' => $model->id_irmud]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="irmud-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
