<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenandatangan */

$this->title = $model->id_ttd;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penandatangans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penandatangan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_ttd], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_ttd], [
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
            'peg_nik',
            'nama',
            'pangkat',
            'jabatan',
            'keterangan',
            'is_active',
            'flag',
            'id_ttd',
			//bowo 30 mei 2016 #menambahkan field peg_nip_baru
			'peg_nip_baru',
        ],
    ]) ?>

</div>
