<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Was9 */

$this->title = $model->id_was9;
$this->params['breadcrumbs'][] = ['label' => 'Was9s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was9-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was9], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was9], [
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
            'id_was9',
            'tanggal_was9',
            'perihal_was9',
            'lampiran_was9',
            'id_saksi_was9',
            'no_register',
            'jenis_saksi',
            'nip',
            'hari_pemeriksaan_was9',
            'tanggal_pemeriksaan_was9',
            'jam_pemeriksaan_was9',
            'tempat_pemeriksaan_was9',
            'nip_penandatangan',
            'nama_penandatangan',
            'pangkat_penandatangan',
            'golongan_penandatangan',
            'jabatan_penandatangan',
            'was9_file',
            'id_sp_was',
            'sifat_was9',
        ],
    ]) ?>

</div>
