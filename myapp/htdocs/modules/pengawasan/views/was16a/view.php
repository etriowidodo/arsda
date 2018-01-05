<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was16a */

$this->title = $model->id_was_16a;
$this->params['breadcrumbs'][] = ['label' => 'Was16as', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was16a-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_16a], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_16a], [
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
            'id_was_16a',
            'no_was_16a',
            'id_register',
            'inst_satkerkd',
            'kpd_was_16a',
            'id_terlapor',
            'tgl_was_16a',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'perihal',
            'ttd_was_16a',
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
