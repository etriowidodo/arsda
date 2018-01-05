<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was18 */

$this->title = 'Update Was18';
$this->params['breadcrumbs'][] = ['label' => 'Was18s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_was18, 'url' => ['view', 'id' => $model->id_was18]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="was18-update">

    <h1><?//= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
		'modelTembusan' => $modelTembusan,
    ]) ?>

</div>
