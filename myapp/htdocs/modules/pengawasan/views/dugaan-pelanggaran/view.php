<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\DugaanPelanggaran */

$this->title = $model->id_register;
$this->params['breadcrumbs'][] = ['label' => 'Dugaan Pelanggarans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="dugaan-pelanggaran-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_register], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_register], [
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
            'id_register',
            'no_register',
            'inst_satkerkd',
            'wilayah',
            'inspektur',
            'tgl_dugaan',
            'sumber_dugaan',
            'perihal',
            'ringkasan:ntext',
            'sumber_pelapor',
            'status',
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
