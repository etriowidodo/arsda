<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmRendak */

$this->title = $model->id_rendak;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Rendaks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-rendak-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_rendak], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_rendak], [
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
            'id_rendak',
            'id_perkara',
            'id_berkas',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_penandatangan',
            'nama',
            'pangkat',
            'jabatan',
        ],
    ]) ?>

</div>
