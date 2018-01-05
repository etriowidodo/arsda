<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsUUndang */

$this->title = $model->uu;
$this->params['breadcrumbs'][] = ['label' => 'Ms Uundangs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-uundang-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->uu], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->uu], [
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
            'deskripsi',
            'tentang',
            'tanggal',
        ],
    ]) ?>

</div>
