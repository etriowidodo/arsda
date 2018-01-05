<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was19a */

$this->title = 'Update Was19a: ' . ' ' . $model->id_was_19a;
$this->params['breadcrumbs'][] = ['label' => 'Was19as', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_19a, 'url' => ['view', 'id' => $model->id_was_19a]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was19a-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
