<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pengawasan\models\SpWas1 */

$this->title = $model->id_sp_was1;
$this->params['breadcrumbs'][] = ['label' => 'Sp Was1s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sp-was1-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_sp_was1], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_sp_was1], [
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
            'id_sp_was1',
            'nomor_sp_was1',
            'tanggal_sp_was1',
            'tanggal_mulai_sp_was1',
            'tanggal_akhir_sp_was1',
            'nip_penandatangan_sp_was1',
            'nama_penandatangan_sp_was1',
            'pangkat_penandatangan_sp_was1',
            'golongan_penandatangan_sp_was1',
            'jabatan_penandatangan_sp_was1',
            'file_sp_was1',
            'created_by',
            'created_ip',
            'created_time',
            'updated_by',
            'updated_ip',
            'updated_time',
        ],
    ]) ?>

</div>
