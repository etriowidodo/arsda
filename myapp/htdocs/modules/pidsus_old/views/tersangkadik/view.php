<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidsus\models\PdsDikTersangka */

$this->title = $model->id_pds_dik_tersangka;
$this->params['breadcrumbs'][] = ['label' => 'Pds Dik Tersangkas', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pds-dik-tersangka-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_pds_dik_tersangka], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_pds_dik_tersangka], [
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
            'id_pds_dik_tersangka',
            'id_pds_dik',
            'nama_tersangka',
            'tempat_lahir',
            'tgl_lahir',
            'jenis_kelamin',
            'kewarganegaraan',
            'alamat',
            'agama',
            'pekerjaan',
            'pendidikan',
            'create_by',
            'create_date',
            'update_by',
            'update_date',
            'jenis_id',
            'nomor_id',
            'suku',
            'flag',
        ],
    ]) ?>

</div>
