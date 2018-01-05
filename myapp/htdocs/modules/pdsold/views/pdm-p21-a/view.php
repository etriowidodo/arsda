<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP21A */

$this->title = $model->id_p21a;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P21 As', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p21-a-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p21a], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p21a], [
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
            'id_p21a',
            'id_p21',
            'no_surat',
            'sifat',
            'lampiran',
            'tgl_surat',
            'dikeluarkan',
            'kepada',
            'di',
            'id_penandatangan',
            'status_berkas:boolean',
        ],
    ]) ?>

</div>
