<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\Was2 */

$this->title = $model->id_was_2;
$this->params['breadcrumbs'][] = ['label' => 'Was2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was2-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_was_2], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_was_2], [
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
            'id_was_2',
            'no_was_2',
            'inst_satkerkd',
            'id_register',
            'tgl_was_2',
            'kpd_was_2',
            'ttd_was_2',
            'jml_lampiran',
            'satuan_lampiran',
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
        ],
    ]) ?>

</div>
