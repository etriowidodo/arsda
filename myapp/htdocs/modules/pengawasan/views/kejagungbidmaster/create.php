<?php

use yii\helpers\Html;


$this->title = 'Tambah Kejagung Bidang';
$this->params['breadcrumbs'][] = ['label' => 'Kejagung Bidang', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kejagung-bidang-create">

    <!--<h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
