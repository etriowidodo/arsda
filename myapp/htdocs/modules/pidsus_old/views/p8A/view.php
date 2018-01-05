<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\PdsDikRendik */

$this->title = $model->id_pds_dik_rendik;
//$this->params['breadcrumbs'][] = ['label' => 'Pds Dik Rendiks', 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
$this->params['idtitle']=$_SESSION['noSpdpDik'];
?>
<div class="pds-dik-rendik-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pds_dik_rendik], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pds_dik_rendik], [
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
            'id_pds_dik_rendik',
            'id_pds_dik_surat',
            'no_urut',
            'kasus_posisi',
            'pasal_disangkakan',
            'alat_bukti',
            'tindakan_hukum',
            'waktu_tempat',
            'koor_dan_dal',
            'keterangan',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
        ],
    ]) ?>

</div>
