<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLid */

$this->title = $model->id_pds_lid;
//$this->params['breadcrumbs'][] = ['label' => 'Pds Lids', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pds_lid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pds_lid], [
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
            'id_pds_lid',
            'id_satker',
            'no_lap',
            'tgl_diterima',
            'penerima_lap',
            'lokasi_lap',
            'pelapor',
            'perihal_lap',
            'asal_surat_lap',
            'no_surat_lap',
            'tgl_lap',
            'isi_surat_lap',
            'uraian_surat_lap',
            'penandatangan_lap',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'id_status',
        ],
    ]) ?>

</div>
