<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Kejati';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Kejati', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_kejati];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kejati-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
