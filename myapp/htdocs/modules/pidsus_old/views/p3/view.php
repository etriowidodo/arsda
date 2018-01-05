<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PdsLidRenlid */

$this->title = $model->id_pds_lid_renlid;
//$this->params['breadcrumbs'][] = ['label' => 'Pds Lid Renlids', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noLapLid'];
?>
<div class="pds-lid-renlid-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pds_lid_renlid], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pds_lid_renlid], [
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
            'id_pds_lid_renlid',
            'id_pds_lid_surat',
            'no_urut',
            'laporan',
            'kasus_posisi',
            'dugaan_pasal',
            'alat_bukti',
            'sumber',
            'pelaksana',
            'tindakan_hukum',
            'tempat',
            'koor_dan_dal',
            'keterangan',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'waktu',
        ],
    ]) ?>

</div>
