<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidSurat */

$this->title = $model->id_pds_dik_surat;
//$this->params['breadcrumbs'][] = ['label' => 'Pds Lid Surats', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapDik'];
?>
<div class="pds-lid-surat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pds_lid_surat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pds_lid_surat], [
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
            'id_pds_lid_surat',
            'id_pds_lid',
            'id_jenis_surat',
            'no_surat',
            'tgl_surat',
            'lokasi_surat',
            'sifat_surat',
            'lampiran_surat',
            'perihal_lap',
            'kepada',
            'kepada_lokasi',
            'id_ttd',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'id_pds_lid_surat_parent',
            'id_status',
            'jam_surat',
        ],
    ]) ?>

</div>
