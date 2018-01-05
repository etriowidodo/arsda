<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was21 */

$this->title = $model->id_was_21;
$this->params['breadcrumbs'][] = ['label' => 'Was21s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was21-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_21], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_21], [
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
            'id_was_21',
            'no_was_21',
            'id_register',
            'inst_satkerkd',
            'tgl_was_21',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'perihal',
            'kpd_was_21',
            'ttd_was_21',
            'id_terlapor',
            'pendapat',
            'id_peraturan',
            'tingkat_kd',
            'kputusan_ja',
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
