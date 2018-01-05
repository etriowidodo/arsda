<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was11 */

$this->title = $model->id_was_11;
$this->params['breadcrumbs'][] = ['label' => 'Was11s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was11-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_11], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_11], [
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
            'id_was_11',
            'no_was_11',
            'inst_satkerkd',
            'id_register',
            'tgl_was_11',
            'ttd_was_11',
            'sifat_surat',
            'jml_lampiran',
            'satuan_lampiran',
            'perihal',
            'id_saksi_internal',
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
