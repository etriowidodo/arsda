<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was3 */

$this->title = $model->id_was_3;
$this->params['breadcrumbs'][] = ['label' => 'Was3s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was3-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_3], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_3], [
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
            'id_was_3',
            'no_was_3',
            'inst_satkerkd',
            'id_register',
            'tgl_was_3',
            'kpd_was_3',
            'ttd_was_3',
            'id_terlapor',
            'ttd_peg_nik',
            'upload_file',
            'flag',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
            'ttd_id_jabatan',
            'jml_lampiran',
            'satuan_lampiran',
        ],
    ]) ?>

</div>
