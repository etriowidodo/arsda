<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmBaKonsultasi */

$this->title = $model->id_perkara;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Ba Konsultasis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-ba-konsultasi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_perkara' => $model->id_perkara, 'id_ba_konsultasi' => $model->id_ba_konsultasi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_perkara' => $model->id_perkara, 'id_ba_konsultasi' => $model->id_ba_konsultasi], [
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
            'id_perkara',
            'id_ba_konsultasi',
            'tgl_pelaksanaan',
            'nip_jaksa',
            'nama_jaksa',
            'jabatan_jaksa',
            'nip_penyidik',
            'nama_penyidik',
            'jabatan_penyidik',
            'konsultasi_formil:ntext',
            'konsultasi_materil:ntext',
            'kesimpulan:ntext',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
