<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was27Inspek */

$this->title = $model->id_was_27_inspek;
$this->params['breadcrumbs'][] = ['label' => 'Was27 Inspeks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was27-inspek-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_27_inspek], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_27_inspek], [
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
            'id_was_27_inspek',
            'id_register',
            'inst_satkerkd',
            'no_was_27_inspek',
            'tgl',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'data_data',
            'upload_file_data',
            'analisa',
            'kesimpulan',
            'rncn_henti_riksa_1_was_27_ins',
            'rncn_henti_riksa_2_was_27_ins',
            'pendapat_1_was_27_ins',
            'pendapat',
            'persetujuan',
            'ttd_was_27_inspek',
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
