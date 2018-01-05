<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\MsPasal */

$this->title = $model->uu;
$this->params['breadcrumbs'][] = ['label' => 'Ms Pasals', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ms-pasal-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'uu' => $model->uu, 'pasal' => $model->pasal], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'uu' => $model->uu, 'pasal' => $model->pasal], [
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
            'bunyi',
        ],
    ]) ?>

</div>
