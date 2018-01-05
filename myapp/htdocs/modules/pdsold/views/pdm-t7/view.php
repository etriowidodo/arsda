<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\pdmt7 */

$this->title = $model->id_t7;
$this->params['breadcrumbs'][] = ['label' => 'Pdmt7s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdmt7-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t7], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t7], [
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
            'id_t7',
            'id_berkas',
            'uraian_singkat:ntext',
            'id_penuntutumum',
            'lama',
            'tgl_mulai',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_penandatangan',
            'status',
        ],
    ]) ?>

</div>
