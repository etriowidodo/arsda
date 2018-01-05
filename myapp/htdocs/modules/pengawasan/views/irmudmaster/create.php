<?php

use yii\helpers\Html;


$this->title = 'Tambah Inspektur Muda';
$this->params['breadcrumbs'][] = ['label' => 'Irmud', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="irmud-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
