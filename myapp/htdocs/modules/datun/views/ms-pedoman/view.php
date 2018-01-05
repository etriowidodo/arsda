<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPedoman */

$this->title = $model->uu;
$this->params['breadcrumbs'][] = ['label' => 'Ms Pedomen', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-pedoman-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'uu' => $model->uu, 'pasal' => $model->pasal, 'kategori' => $model->kategori], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'uu' => $model->uu, 'pasal' => $model->pasal, 'kategori' => $model->kategori], [
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
            'uu',
            'pasal',
            'kategori',
            'ancaman_hari',
            'ancaman_bulan',
            'ancaman_tahun',
            'denda',
        ],
    ]) ?>

</div>
