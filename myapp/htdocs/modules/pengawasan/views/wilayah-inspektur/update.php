<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Wilayah Inspektur';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Wilayah Inspektur', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_inspektur, 'url' => ['view', 'id_inspektur' => $model->id_inspektur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dipa-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
