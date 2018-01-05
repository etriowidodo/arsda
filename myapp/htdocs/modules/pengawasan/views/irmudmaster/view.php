<?php

use yii\helpers\Html;
use yii\widgets\DetailView;


$this->title = $model->id_irmud;
$this->params['breadcrumbs'][] = ['label' => 'Irmud', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="irmud-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_irmud], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_irmud], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_irmud',
            'nama_irmud',
            'akronim',
        ],
    ]) ?>

</div>
