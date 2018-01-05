<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\WasDisposisiInspektur */

$this->title = $model->no_urut;
$this->params['breadcrumbs'][] = ['label' => 'Was Disposisi Inspekturs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="was-disposisi-inspektur-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'no_urut' => $model->no_urut, 'id_tingkat' => $model->id_tingkat, 'id_kejati' => $model->id_kejati, 'id_kejari' => $model->id_kejari, 'id_cabjari' => $model->id_cabjari, 'no_register' => $model->no_register, 'urut_terlapor' => $model->urut_terlapor], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'no_urut' => $model->no_urut, 'id_tingkat' => $model->id_tingkat, 'id_kejati' => $model->id_kejati, 'id_kejari' => $model->id_kejari, 'id_cabjari' => $model->id_cabjari, 'no_register' => $model->no_register, 'urut_terlapor' => $model->urut_terlapor], [
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
            'no_urut',
            'id_tingkat',
            'id_kejati',
            'id_kejari',
            'id_cabjari',
            'id_wilayah',
            'id_level1',
            'id_level2',
            'id_level3',
            'id_level4',
            'no_register',
            'id_inspektur',
            'tanggal_disposisi',
            'isi_disposisi:ntext',
            'file_inspektur',
            'id_irmud',
            'status',
            'urut_terlapor',
            'created_by',
            'created_ip',
            'created_time',
        ],
    ]) ?>

</div>
