<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\MasterPeraturan */

$this->title = $model->id_peraturan;
$this->params['breadcrumbs'][] = ['label' => 'Master Peraturans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="master-peraturan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_peraturan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_peraturan], [
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
            'id_peraturan',
            'isi_peraturan:ntext',
            'tgl_perja',
            'kode_surat',
            'pasal',
            'tgl_inactive',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
