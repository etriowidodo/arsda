<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\modules\pidum\models\PdmP30 */

$this->title = $model->id_p30;
$this->params['breadcrumbs'][] = ['label' => 'Pdm P30s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pdm-p30-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id_p30], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id_p30], [
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
            'id_p30',
            'no_perkara',
            'id_tersangka',
            'tgl_awal_rutan',
            'tgl_akhir_rutan',
            'tgl_awal_rumah',
            'tgl_akhir_rumah',
            'tgl_awal_kota',
            'tgl_akhir_kota',
            'perpanjangan',
            'tgl_perpanjangan',
            'pengalihan',
            'tgl_pengalihan',
            'pencabutan',
            'tgl_pencabutan',
            'catatan:ntext',
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
