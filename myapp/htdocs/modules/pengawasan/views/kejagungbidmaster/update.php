<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Kejagung Bidang';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Kejagung Bidang', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_inspektur, 'url' => ['view', 'id' => $model->id_inspektur]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kejagung-bidang-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
