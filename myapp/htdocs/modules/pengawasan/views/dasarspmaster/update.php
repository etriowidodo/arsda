<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\DasarSpWasMaster */

$this->title = 'Update Dasar Sp Was Master ';// . ' ' . $model->id_dasar_spwas;
$this->params['breadcrumbs'][] = ['label' => 'Dasar Sp Was Masters', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_dasar_spwas, 'url' => ['view', 'id' => $model->id_dasar_spwas]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dasar-sp-was-master-update">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
