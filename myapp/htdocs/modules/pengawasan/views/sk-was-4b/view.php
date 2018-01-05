<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas4b */

$this->title = $model->id_sk_was_4b;
$this->params['breadcrumbs'][] = ['label' => 'Sk Was4bs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sk-was4b-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_sk_was_4b], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_sk_was_4b], [
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
            'id_sk_was_4b',
            'no_sk_was_4b',
            'inst_satkerkd',
            'id_register',
            'tgl_sk_was_4b',
            'ttd_sk_was_4b',
            'perja',
            'tgl_1',
            'tgl_2',
            'anggaran',
            'thn_dipa',
            'ttd_peg_nik',
            'upload_file',
            'is_deleted',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
            'ttd_id_jabatan',
        ],
    ]) ?>

</div>
