<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmT12 */

$this->title = $model->id_t12;
$this->params['breadcrumbs'][] = ['label' => 'Pdm T12s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-t12-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_t12], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_t12], [
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
            'id_t12',
            'id_t8',
            'no_surat',
            'sifat',
            'lampiran',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'dilaksanakan',
            'id_penandatangan',
        ],
    ]) ?>

</div>
