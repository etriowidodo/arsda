<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP40 */

$this->title = $model->id_p40;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P40s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p40-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p40], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p40], [
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
            'id_p40',
            'id_berkas',
            'no_surat',
            'sifat',
            'lampiran',
            'dikeluarkan',
            'tgl_dikeluarkan',
            'kepada',
            'di',
            'id_jpu',
            'isi:ntext',
            'menimbang:ntext',
            'no_penetapan',
            'tgl_penetapan',
            'id_penandatangan',
            'id_perkara',
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
