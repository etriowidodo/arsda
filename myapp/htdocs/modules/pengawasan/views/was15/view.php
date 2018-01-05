<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was15 */

$this->title = $model->id_was_15;
$this->params['breadcrumbs'][] = ['label' => 'Was15s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was15-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_15], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_15], [
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
            'id_was_15',
            'no_was_15',
            'id_register',
            'inst_satkerkd',
            'tgl_was_15',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'rncn_jatuh_hukdis_1_was_15',
            'rncn_jatuh_hukdis_2_was_15',
            'rncn_jatuh_hukdis_3_was_15',
            'pendapat',
            'persetujuan',
            'ttd_was_15',
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
