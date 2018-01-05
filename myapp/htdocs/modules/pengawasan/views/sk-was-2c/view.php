<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SkWas2c */

$this->title = $model->id_sk_was_2c;
$this->params['breadcrumbs'][] = ['label' => 'Sk Was2cs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sk-was2c-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_sk_was_2c], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_sk_was_2c], [
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
            'id_sk_was_2c',
            'no_sk_was_2c',
            'inst_satkerkd',
            'id_register',
            'tgl_sk_was_2c',
            'ttd_sk_was_2c',
            'id_terlapor',
            'tingkat_kd',
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
