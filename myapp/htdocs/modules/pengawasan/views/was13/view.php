<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was13 */

$this->title = $model->id_was_13;
$this->params['breadcrumbs'][] = ['label' => 'Was13s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was13-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_13], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_13], [
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
            'id_was_13',
            'inst_satkerkd',
            'id_register',
            'hari',
            'tgl',
            //'sebagai',
            'id_peran',
            'menerima_nama',
            'ttd_peg_nik',
            'ttd_id_jabatan',
            'upload_file',
            //'is_deleted',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
