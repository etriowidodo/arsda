<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\PdmBa4Tersangka */

$this->title = 'Create Pdm Ba4 Tersangka';
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba4 Tersangkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba4-tersangka-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
