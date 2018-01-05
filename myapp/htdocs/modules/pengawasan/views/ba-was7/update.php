<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16b */

$this->title = 'BaWas7';
$this->params['breadcrumbs'][] = ['label' => 'BaWas7', 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id_was_16b, 'url' => ['view', 'id' => $model->id_was_16b]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was16b-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'modelwas16b' => $modelwas16b,
    ]) ?>

</div>
