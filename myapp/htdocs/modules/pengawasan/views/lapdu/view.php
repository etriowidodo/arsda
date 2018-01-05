<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Lapdu */

$this->title = $model->no_register;
$this->params['breadcrumbs'][] = ['label' => 'Lapdus', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="lapdu-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->no_register], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->no_register], [
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
            'no_register',
            'tanggal_surat_diterima',
            'nomor_surat_lapdu',
            'perihal_lapdu:ntext',
            'tanggal_surat_lapdu',
            'ringkasan_lapdu:ntext',
            'file_lapdu',
            'id_media_pelaporan',
            'inst_satkerkd',
        ],
    ]) ?>

</div>
