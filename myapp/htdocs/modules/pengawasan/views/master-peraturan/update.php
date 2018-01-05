<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MasterPeraturan */

$this->title = 'Update Master Peraturan: ' . ' ' . $model->id_peraturan;
$this->params['breadcrumbs'][] = ['label' => 'Master Peraturans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_peraturan, 'url' => ['view', 'id' => $model->id_peraturan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="master-peraturan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
