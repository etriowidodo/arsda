<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmB16 */

$this->title = $model->id_b16;
$this->params['breadcrumbs'][] = ['label' => 'Pdm B16s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-b16-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_b16], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_b16], [
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
            'id_b16',
            'id_perkara',
            'no_surat',
            'sifat',
            'lampiran',
            'kepada',
            'di_kepada',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'id_tersangka',
            'pelaksanaan_lelang',
            'tgl_lelang',
            'total',
            'bank',
            'ba_penitipan',
            'tgl_ba',
            'no_persetujuan',
            'tgl_persetujuan',
            'kantor_lelang',
            'no_risalan',
            'id_penandatangan',
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
