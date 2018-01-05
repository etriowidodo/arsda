<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16d */

$this->title = $model->id_was_16d;
$this->params['breadcrumbs'][] = ['label' => 'Was16ds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was16d-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_16d], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_16d], [
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
            'id_was_16d',
            'no_was_16d',
            'id_register',
            'inst_satkerkd',
            'kpd_was_16d',
            'id_terlapor',
            'tgl_was_16d',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'perihal',
            'batas_waktu',
            'ttd_was_16d',
            'ttd_peg_nik',
            'ttd_id_jabatan',
            'upload_file',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
