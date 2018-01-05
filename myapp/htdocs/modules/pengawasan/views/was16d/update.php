<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16d */

$this->title = 'Was16d';
$this->params['breadcrumbs'][] = ['label' => 'Was16ds', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_16b, 'url' => ['view', 'id' => $model->id_was_16b]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was16d-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelTembusan' => $modelTembusan,
        'modelwas16d' => $modelwas16d,
    ]) ?>

</div>
