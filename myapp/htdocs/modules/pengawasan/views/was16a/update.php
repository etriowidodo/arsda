<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16a */

$this->title = 'Update Was16a: ' . ' ' . $model->id_was_16a;
$this->params['breadcrumbs'][] = ['label' => 'Was16as', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_16a, 'url' => ['view', 'id' => $model->id_was_16a]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was16a-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
        'modelPopUpJaksa' => $modelPopUpJaksa,
    ]) ?>

</div>
