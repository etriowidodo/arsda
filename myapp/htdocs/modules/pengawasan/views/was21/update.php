<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21 */

$this->title = 'Update Was21: ' . ' ' . $model->id_was_21;
$this->params['breadcrumbs'][] = ['label' => 'Was21s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was_21, 'url' => ['view', 'id' => $model->id_was_21]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was21-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
