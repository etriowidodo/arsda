<?php

use yii\helpers\Html;


$this->title = 'Tambah Sumber Laporan';
$this->params['breadcrumbs'][] = ['label' => 'Sumber Laporan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="Sumber-laporan-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
