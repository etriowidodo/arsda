<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmPenetapanBarbuk */

$this->title = $model->id_penetapan_barbuk;
$this->params['breadcrumbs'][] = ['label' => 'Pdm Penetapan Barbuks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-penetapan-barbuk-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_penetapan_barbuk], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_penetapan_barbuk], [
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
            'id_penetapan_barbuk',
            'no_penetapan',
            'tersangka',
            'id_inst_penyidik',
            'id_inst_penyidik_pelaksana',
            'tgl_surat',
            'dikeluarkan',
            'k_pembuktian_perkara',
            'k_pengembangan_iptek',
            'k_pendidikan_pelatihan',
            'dimusnahkan',
            'id_penandatangan',
            'nama',
            'pangkat',
            'jabatan',
            'file_upload',
            'created_by',
            'created_ip',
            'created_time',
            'updated_ip',
            'updated_by',
            'updated_time',
        ],
    ]) ?>

</div>
