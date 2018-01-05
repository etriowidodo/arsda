<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenyelesaianPratutLimpah */

$this->title = $model->id_pratut_limpah;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penyelesaian Pratut Limpahs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penyelesaian-pratut-limpah-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pratut_limpah], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pratut_limpah], [
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
            'id_pratut_limpah',
            'id_pratut',
            'no_surat',
            'sifat',
            'lampiran',
            'tgl_dikeluarkan',
            'dikeluarkan',
            'kepada',
            'di_kepada',
            'perihal',
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
