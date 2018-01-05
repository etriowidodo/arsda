<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16b */

$this->title = $model->id_was_16b;
$this->params['breadcrumbs'][] = ['label' => 'Was16bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was16b-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_16b], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_16b], [
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
            'id_was_16b',
            'no_was_16b',
            'id_register',
            'inst_satkerkd',
            'kpd_was_16b',
            'id_terlapor',
            'tgl_was_16b',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'perihal',
            'perja',
            'ttd_was_16b',
            'ttd_peg_nik',
            'ttd_id_jabatan',
            'upload_file',
            'flag',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
