<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Tembusan';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Tembusan', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_tembusan, 'url' => ['view', 'id' => $model->id_tembusan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="tembusan-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>