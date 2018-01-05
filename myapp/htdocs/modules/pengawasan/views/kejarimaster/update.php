<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\InspekturModel */

$this->title = 'Ubah Kejari';// . ' ' . $model->id_inspektur;
$this->params['breadcrumbs'][] = ['label' => 'Kejari', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_kejari];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kejari-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
