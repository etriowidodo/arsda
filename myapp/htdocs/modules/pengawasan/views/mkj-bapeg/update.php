<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MkjBapeg */

$this->title = 'Update Mkj Bapeg: ' . ' ' . $model->id_mkj_bapeg;
$this->params['breadcrumbs'][] = ['label' => 'Mkj Bapegs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_mkj_bapeg, 'url' => ['view', 'id' => $model->id_mkj_bapeg]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mkj-bapeg-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
