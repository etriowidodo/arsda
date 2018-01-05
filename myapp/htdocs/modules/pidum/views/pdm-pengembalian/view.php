<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPengembalian */

$this->title = $model->id_pengembalian;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Pengembalians', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-pengembalian-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pengembalian], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pengembalian], [
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
            'id_pengembalian',
            'id_perkara',
            'id_berkas',
            'no_surat',
            'sifat',
            'lampiran',
            'tgl_dikeluarkan',
            'dikeluarkan',
            'kepada',
            'di_kepada',
            'perihal',
            'file_upload',
            'id_penandatangan',
            'nama',
            'pangkat',
            'jabatan',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
