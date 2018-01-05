<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was18 */

$this->title = $model->id_was_18;
$this->params['breadcrumbs'][] = ['label' => 'Was18s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was18-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_18], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_18], [
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
            'id_was_18',
            'no_was_18',
            'id_register',
            'inst_satkerkd',
            'tgl_was_18',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'kpd_was_18',
            'id_terlapor',
            'ttd_was_18',
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
            'perihal',
        ],
    ]) ?>

</div>
