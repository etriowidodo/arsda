<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\VLaporanP6 */

$this->title = $model->w;
$this->params['breadcrumbs'][] = ['label' => 'Vlaporan P4s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vlaporan-p4-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->w], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->w], [
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
            'tgl_terima',
            'wilayah_kerja',
            'nama_lengkap',
            'kasus_posisi:ntext',
            'asal_perkara',
            'tgl_dihentikan',
            'tgl_dikesampingkan',
            'tgl_dikirim_ke',
            'no_denda_ganti',
            'tgl_denda_ganti',
            'tgl_dilimpahkan',
            'keterangan',
        ],
    ]) ?>

</div>
